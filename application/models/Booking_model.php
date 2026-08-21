<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{

    public function get_booked_dates($month, $year, $center_id = null)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day = date('Y-m-t', strtotime("$year-$month-01"));

        // ------------------------
        // SELF BOOKINGS (With Center Filter)
        // ------------------------
        $this->db->select('start_date, end_date, "self_booking" as type', false);
        $this->db->from('tt_self_bookings');
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);

        if (!empty($center_id)) {
            $this->db->where_in('center_id', $center_id);
        }

        $self_bookings = $this->db->get()->result_array();

        // ------------------------
        // ASSIGNED BOOKINGS (With Center Filter)
        // ------------------------
        $this->db->select('pd.start_date, pd.end_date, "assigned_booking" as type', false);
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join('tt_project_detail pd', 'pd.project_id = sbr.project_id');
        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);

        if (!empty($center_id)) {
            $this->db->where_in('sbr.center_id', $center_id);  // NEW
        }

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }


    public function get_bookings_by_date($date)
    {
        if (!$date) {
            return []; // Return empty array if no date provided
        }

        // Get self bookings for the date
        $this->db->select('sb.id, sb.exam_name, sb.seats_booked, sb.client_name, sb.start_date, sb.end_date, c.center_name');
        $this->db->select("'self_booking' as type", false);
        $this->db->from('tt_self_bookings sb');
        $this->db->join('tt_center c', 'c.center_id = sb.center_id');
        $this->db->where('sb.start_date <=', $date);
        $this->db->where('sb.end_date >=', $date);
        $self_bookings = $this->db->get()->result_array();

        // Get assigned bookings for the date (grouped by project_id)
        $this->db->select('
            pd.project_id as id,
            pd.exam_name,
            sbr.center_seat as seats_booked,
            cl.company_name as client_name,
            pd.start_date,
            pd.end_date,
            c.center_name
        ');
        $this->db->select("'assigned_booking' as type", false);
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id AND pd.exam_city_id = sbr.city_id'
        );
        $this->db->join('tt_center c', 'c.center_id = sbr.center_id');
        $this->db->join('tt_client cl', 'cl.ac_id = sbr.client_id');
        $this->db->where('pd.start_date <=', $date);
        $this->db->where('pd.end_date >=', $date);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->group_by('pd.project_id'); // Group by project_id to avoid duplicates
        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }


    public function get_center_booked_dates($month, $year, $center_id)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day = date('Y-m-t', strtotime("$year-$month-01"));

        // Get self bookings
        $this->db->select('center_id, start_date, end_date, "self_booking" as type', false); // Note the false parameter
        $this->db->from('tt_self_bookings');
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);
        $this->db->where('center_id', $center_id);
        $self_bookings = $this->db->get()->result_array();

        // Get assigned bookings
        $this->db->select('pd.start_date, pd.end_date, "assigned_booking" as type', false);
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
            AND pd.exam_city_id = sbr.city_id'
        );
        $this->db->where('sbr.center_id', $center_id);
        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);
        $this->db->where('sbr.center_id', $center_id);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }

    public function get_center_bookings_by_date($date, $center_id)
    {
        if (!$date) {
            return []; // Return empty array if no date provided
        }

        // Get self bookings for the date
        $this->db->select('sb.id, sb.exam_name, sb.seats_booked, sb.client_name, sb.start_date, sb.end_date, c.center_name, sb.center_id');
        $this->db->select("'self_booking' as type", false);
        $this->db->from('tt_self_bookings sb');
        $this->db->join('tt_center c', 'c.center_id = sb.center_id');
        $this->db->where('sb.center_id', $center_id);
        $this->db->where('sb.start_date <=', $date);
        $this->db->where('sb.end_date >=', $date);
        $self_bookings = $this->db->get()->result_array();

        // Get assigned bookings for the date (grouped by project_id)
        $this->db->select('
            pd.project_id as id,
            pd.exam_name,
            sbr.center_seat as seats_booked,
            cl.company_name as client_name,
            pd.start_date,
            pd.end_date,
            c.center_name
        ');
        $this->db->select("'assigned_booking' as type", false);
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
            AND pd.exam_city_id = sbr.city_id'
        );
        $this->db->join('tt_center c', 'c.center_id = sbr.center_id');
        $this->db->join('tt_client cl', 'cl.ac_id = sbr.client_id');
        $this->db->where('pd.start_date <=', $date);
        $this->db->where('pd.end_date >=', $date);
        $this->db->where('sbr.center_id', $center_id);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->group_by('pd.project_id'); // Group by project_id to avoid duplicates
        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }


    public function get_center_booking_summary($month, $year, $center_ids = [])
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day  = date('Y-m-t', strtotime("$year-$month-01"));

        // -------------------
        // MONTHLY SELF COUNT
        // -------------------
        $this->db->from('tt_self_bookings');

        if (!empty($center_ids)) {
            $this->db->where_in('center_id', $center_ids);
        }

        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);
        $monthly_self = $this->db->count_all_results();

        // -------------------
        // MONTHLY ASSIGNED COUNT
        // -------------------
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join('tt_project_detail pd', 'pd.project_id = sbr.project_id');

        if (!empty($center_ids)) {
            $this->db->where_in('sbr.center_id', $center_ids);
        }

        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $monthly_assigned = $this->db->count_all_results();

        // -------------------
        // OVERALL SELF COUNT
        // -------------------
        $this->db->from('tt_self_bookings');

        if (!empty($center_ids)) {
            $this->db->where_in('center_id', $center_ids);
        }

        $overall_self = $this->db->count_all_results();

        // -------------------
        // OVERALL ASSIGNED COUNT
        // -------------------
        $this->db->from('tt_send_booking_request');

        if (!empty($center_ids)) {
            $this->db->where_in('center_id', $center_ids);
        }

        $this->db->where('exam_center_status', 1);
        $this->db->where('client_status', 1);
        $overall_assigned = $this->db->count_all_results();

        return [
            'monthly_self'      => $monthly_self,
            'monthly_assigned'  => $monthly_assigned,
            'overall_self'      => $overall_self,
            'overall_assigned'  => $overall_assigned,
        ];
    }


    public function get_bookings_by_date_api($date, $center_ids = [])
    {
        if (!$date) {
            return [];
        }

        // Self Bookings
        $this->db->select('
            sb.id,
            sb.exam_name,
            sb.seats_booked,
            sb.client_name,
            sb.start_date,
            sb.end_date,
            c.center_name
        ');
        $this->db->select("'self_booking' as type", false);
        $this->db->from('tt_self_bookings sb');
        $this->db->join('tt_center c', 'c.center_id = sb.center_id');

        $this->db->where('sb.start_date <=', $date);
        $this->db->where('sb.end_date >=', $date);

        if (!empty($center_ids)) {
            $this->db->where_in('sb.center_id', $center_ids);
        }

        $self_bookings = $this->db->get()->result_array();

        // Assigned Bookings
        $this->db->select('
            pd.project_id as id,
            pd.exam_name,
            sbr.center_seat as seats_booked
            cl.company_name as client_name,
            pd.start_date,
            pd.end_date,
            c.center_name
        ');
        $this->db->select("'assigned_booking' as type", false);

        $this->db->from('tt_send_booking_request sbr');
        $this->db->join('tt_project_detail pd', 'pd.project_id = sbr.project_id AND pd.exam_city_id = sbr.city_id');
        $this->db->join('tt_center c', 'c.center_id = sbr.center_id');
        $this->db->join('tt_client cl', 'cl.ac_id = sbr.client_id');

        $this->db->where('pd.start_date <=', $date);
        $this->db->where('pd.end_date >=', $date);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);

        if (!empty($center_ids)) {
            $this->db->where_in('sbr.center_id', $center_ids);
        }

        $this->db->group_by('pd.project_id');

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }
}
