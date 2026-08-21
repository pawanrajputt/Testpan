<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CenterAvailability_model extends CI_Model
{

    public function fetchCentersWithAvailability($filters, $start, $length)
    {
        $dateFrom = $filters['date_from'];
        $dateTo   = $filters['date_to'];

        $this->db->from('tt_center c');

        /* ================================
           Base Select (Always)
        ================================= */

        $this->db->select("
            c.id,
            c.center_name,
            c.capacity,
            c.total_no_lab,
            c.total_no_system,
            c.approved,
            c.audit_status,
            co.name AS country,
            s.title AS state,
            ct.city_name AS city,
            au.username AS owner_name
        ");

        /* ================================
           Location & Owner Joins
        ================================= */

        $this->db->join('tt_countries co', 'co.id = c.country_id', 'left');
        $this->db->join('tt_states s', 's.id = c.state_id', 'left');
        $this->db->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');

        /* ================================
           Availability Logic
        ================================= */

        if (!empty($dateFrom) && !empty($dateTo)) {

            $this->db->join(
                'tt_send_booking_request sbr',

                "sbr.center_id = c.id
                AND sbr.client_status = 1
                AND sbr.admin_status = 1
                AND sbr.exam_center_status = 1",

                'left'
            );

            $this->db->join(

                'tt_project_detail pd',

                "pd.project_id = sbr.project_id
                AND pd.client_id = sbr.client_id
                AND pd.start_date <= " . $this->db->escape($dateTo) . "
                AND pd.end_date >= " . $this->db->escape($dateFrom),

                'left'
            );

            $this->db->join(

                'tt_self_bookings sb',

                "sb.center_id = c.id
                AND sb.start_date <= " . $this->db->escape($dateTo) . "
                AND sb.end_date >= " . $this->db->escape($dateFrom),

                'left'
            );

            // FULL CENTER LOCK
            // $this->db->where("
            //     (
            //         pd.project_id IS NULL
            //         AND
            //         sb.id IS NULL
            //     )
            // ", NULL, FALSE);

            $this->db->select("
                COUNT(DISTINCT pd.project_id) AS project_bookings,
                COUNT(DISTINCT sb.id) AS self_bookings,

                CASE
                    WHEN COUNT(DISTINCT pd.project_id) > 0
                         OR COUNT(DISTINCT sb.id) > 0
                    THEN 0
                    ELSE 1
                END AS is_available
            ", FALSE);
        } else {

            $this->db->select("
                0 AS project_bookings,
                0 AS self_bookings,
                1 AS is_available
            ", FALSE);
        }

        /* ================================
           Filters
        ================================= */

        $this->db->where('c.deleted', 0);

        if (!empty($filters['state_id'])) {
            $this->db->where('c.state_id', $filters['state_id']);
        }

        if (!empty($filters['country_id'])) {
            $this->db->where('c.country_id', $filters['country_id']);
        }

        if (!empty($filters['city_id'])) {
            $this->db->where('c.city_id', $filters['city_id']);
        }

        if (!empty($filters['center_owner'])) {
            $this->db->where('c.owner_user_id', $filters['center_owner']);
        }

        if (!empty($filters['capacity'])) {
            $this->db->where('c.capacity >=', $filters['capacity']);
        }

        if (!empty($filters['search'])) {
            $this->db->group_start()
                ->like('c.center_name', $filters['search'])
                ->group_end();
        }

        $this->db->group_by('c.id');
        $this->db->order_by('c.capacity', 'DESC');

        /* ================================
           Count
        ================================= */

        $countQuery = clone $this->db;
        $total = $countQuery->get()->num_rows();

        /* ================================
           Pagination
        ================================= */

        $this->db->limit($length, $start);
        $query = $this->db->get();

        return [
            'total'  => $total,
            'result' => $query->result()
        ];
    }


    public function getAvailabilityOverview($filters)
    {
        $dateFrom = !empty($filters['date_from'])
            ? $filters['date_from']
            : '';

        $dateTo = !empty($filters['date_to'])
            ? $filters['date_to']
            : '';

        /*
    |--------------------------------------------------------------------------
    | Base Overview
    |--------------------------------------------------------------------------
    */

        $this->db->from('tt_center c');

        $this->db->join(
            'tt_countries co',
            'co.id = c.country_id',
            'left'
        );

        $this->db->join(
            'tt_states s',
            's.id = c.state_id',
            'left'
        );

        $this->db->join(
            'tt_city_master ct',
            'ct.city_id = c.city_id',
            'left'
        );

        $this->db->where('c.deleted', 0);

        // Filters
        if (!empty($filters['state_id'])) {
            $this->db->where('c.state_id', $filters['state_id']);
        }

        if (!empty($filters['country_id'])) {
            $this->db->where('c.country_id', $filters['country_id']);
        }

        if (!empty($filters['city_id'])) {
            $this->db->where('c.city_id', $filters['city_id']);
        }

        if (!empty($filters['center_owner'])) {
            $this->db->where('c.owner_user_id', $filters['center_owner']);
        }

        if (!empty($filters['capacity'])) {
            $this->db->where('c.capacity >=', $filters['capacity']);
        }

        if (!empty($filters['search'])) {
            $this->db->group_start()
                ->like('c.center_name', $filters['search'])
                ->group_end();
        }

        $this->db->select("
        COUNT(DISTINCT c.id) AS total_centers,
        COUNT(DISTINCT c.country_id) AS countries,
        COUNT(DISTINCT c.state_id) AS states,
        COUNT(DISTINCT c.city_id) AS cities,
        COALESCE(SUM(c.capacity), 0) AS total_capacity,
        COALESCE(SUM(c.total_no_system), 0) AS total_no_system,
        COUNT(DISTINCT CASE WHEN c.approved = 1 THEN c.id END) AS approved_centers,
        COUNT(DISTINCT c.owner_user_id) AS center_owners
    ", false);

        $overviewQuery = $this->db->get();
        $overview = $overviewQuery->row_array();


        /*
    |--------------------------------------------------------------------------
    | Available Centers
    |--------------------------------------------------------------------------
    */

        $availableCenters = 0;

        if (!empty($dateFrom) && !empty($dateTo)) {

            $this->db->from('tt_center c');

            $this->db->join(
                'tt_send_booking_request sbr',
                "sbr.center_id = c.id
            AND sbr.client_status = 1
            AND sbr.admin_status = 1
            AND sbr.exam_center_status = 1",
                'left'
            );

            $this->db->join(
                'tt_project_detail pd',
                "pd.project_id = sbr.project_id
            AND pd.client_id = sbr.client_id
            AND pd.start_date <= " . $this->db->escape($dateTo) . "
            AND pd.end_date >= " . $this->db->escape($dateFrom),
                'left'
            );

            $this->db->join(
                'tt_self_bookings sb',
                "sb.center_id = c.id
            AND sb.start_date <= " . $this->db->escape($dateTo) . "
            AND sb.end_date >= " . $this->db->escape($dateFrom),
                'left'
            );

            $this->db->where('c.deleted', 0);

            // Same filters
            if (!empty($filters['state_id'])) {
                $this->db->where('c.state_id', $filters['state_id']);
            }

            if (!empty($filters['country_id'])) {
                $this->db->where('c.country_id', $filters['country_id']);
            }

            if (!empty($filters['city_id'])) {
                $this->db->where('c.city_id', $filters['city_id']);
            }

            if (!empty($filters['center_owner'])) {
                $this->db->where('c.owner_user_id', $filters['center_owner']);
            }

            if (!empty($filters['capacity'])) {
                $this->db->where('c.capacity >=', $filters['capacity']);
            }

            if (!empty($filters['search'])) {
                $this->db->group_start()
                    ->like('c.center_name', $filters['search'])
                    ->group_end();
            }

            $this->db->select("
            COUNT(DISTINCT CASE
                WHEN pd.project_id IS NULL
                AND sb.id IS NULL
                THEN c.id
            END) AS available_centers
        ", false);

            $availableQuery = $this->db->get();
            $availableRow = $availableQuery->row_array();

            $availableCenters = (int) $availableRow['available_centers'];
        } else {

            // Without date filter, all centers are considered available
            $availableCenters = (int) $overview['total_centers'];
        }


        return [
            'total_centers'     => (int) $overview['total_centers'],
            'countries'         => (int) $overview['countries'],
            'states'            => (int) $overview['states'],
            'cities'            => (int) $overview['cities'],
            'total_capacity'    => (int) $overview['total_capacity'],
            'total_no_system'   => (int) $overview['total_no_system'],
            'available_centers' => $availableCenters,
            'approved_centers'  => (int) $overview['approved_centers'],
            'center_owners'     => (int) $overview['center_owners']
        ];
    }
}
