<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function select_project_without_groupby($projectId)
    {
        $this->db->select('tt_project_detail.*, tt_city_master.city_name,tc.company_name,
            tc.company_type');
        $this->db->from('tt_project_detail');
        $this->db->join('tt_city_master', 'tt_city_master.city_id = tt_project_detail.exam_city_id', 'left');
        $this->db->join('tt_client tc', 'tc.ac_id = tt_project_detail.client_id', 'left');
        $this->db->where('tt_project_detail.project_id', $projectId);
        $this->db->where('tt_project_detail.deleted', 0);
        return $this->db->get()->result_array();
    }


    public function search_all_exam_center(
        $projectId = NULL,
        $cityId = NULL,
        $city = NULL,
        $capacity = NULL,
        $center_name = NULL,
        $owner = NULL,
        $subscription_status = NULL,
        $monitor_type = NULL,
        $ram = NULL,
        $switch_category = NULL,
        $hdd = NULL,
        $operating_system = NULL,
        $ethernet_company = NULL,
        $no_of_each_ethernet_ports = NULL
    ) {
        /**
         * ======================================
         * 1. Get project date range
         * ======================================
         */
        $project_dates = [];
        if ($projectId && $cityId) {
            $project_dates = $this->db
                ->select('start_date, end_date')
                ->from('tt_project_detail')
                ->where([
                    'project_id' => $projectId,
                    'exam_city_id' => $cityId,
                    'deleted' => 0
                ])
                ->get()
                ->row_array();
        }

        /**
         * ======================================
         * 2. Base center + lab query
         * ======================================
         */
        $this->db
            ->select("
                c.center_id, c.center_name, c.capacity, c.city_id,c.total_no_system,c.total_no_lab,c.owner_user_id,
                l.lab_name, l.floor_name, l.no_of_computer,
                l.monitor_type   AS lab_monitor_type,
                l.operating_system AS lab_os,
                l.ram            AS lab_ram,
                l.switch_category,
                l.hard_disk      AS lab_hdd,
                l.ehternet_swtch_company AS lab_ethernet_company,
                l.no_of_ethernet_switch AS lab_ethernet_ports,
                au.username AS owner_name,
                au.email AS owner_email,
                au.mobile_phone AS owner_phone,
                sp.name AS package_name,
                sp.package_color,
                sp.max_centers,
                sp.max_bookings,
                sp.verified_badge,
                sp.is_recommended,
                sp.price AS package_price,
                us.expiry_date
            ")
            ->from('tt_center c')
            ->join('tt_lab l', 'l.center_id = c.center_id AND l.deleted = 0', 'left')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->join(
                'user_subscriptions us',
                'us.center_owner_id = c.owner_user_id
                 AND us.is_active = 1',
                'left'
            )

            ->join(
                'subscription_packages sp',
                'sp.id = us.package_id',
                'left'
            )
            ->where('c.approved', 1)
            ->where('c.deleted', 0);

        /**
         * ======================================
         * 3. Filters
         * ======================================
         */
        if ($city) {
            $this->db->where('c.city_id', $city);
        }

        if ($capacity) {
            $this->db->where('c.capacity >=', $capacity);
        }

        if ($center_name) {
            $this->db->like('c.center_name', $center_name);
        }

        if (!empty($owner)) {

            $this->db->group_start();

            $this->db->like('au.username', $owner);
            $this->db->or_like('au.email', $owner);
            $this->db->or_like('au.mobile_phone', $owner);

            $this->db->group_end();
        }

        if ($subscription_status !== NULL && $subscription_status !== '') {

            if ($subscription_status == '1') {

                $this->db->where('us.id IS NOT NULL', NULL, FALSE);
            } elseif ($subscription_status == '0') {

                $this->db->where('us.id IS NULL', NULL, FALSE);
            }
        }

        if ($monitor_type) {
            $this->db->where('l.monitor_type', $monitor_type);
        }

        if ($ram) {
            $this->db->where('l.ram', $ram);
        }

        if ($switch_category) {
            $this->db->where('l.switch_category', $switch_category);
        }

        if ($hdd) {
            $this->db->where('l.hard_disk', $hdd);
        }

        if ($operating_system) {
            $this->db->where('l.operating_system', $operating_system);
        }

        if ($ethernet_company) {
            $this->db->where('l.ehternet_swtch_company', $ethernet_company);
        }

        if ($no_of_each_ethernet_ports) {
            $this->db->where('l.no_of_ethernet_switch', $no_of_each_ethernet_ports);
        }

        /**
         * ======================================
         * 4. City restriction from project (fallback)
         * ======================================
         */
        if (!$city && $projectId && $cityId) {
            $this->db->where('c.city_id', $cityId);
        }


        /**
         * ======================================
         * 5. Availability / overlapping booking logic
         * ======================================
         */
        if (!empty($project_dates)) {

            $start = $project_dates['start_date'];
            $end = $project_dates['end_date'];

            // Count overlapping bookings (project + self)
            $this->db->select("
              (
                  SELECT COUNT(*)
                  FROM tt_send_booking_request sbr
                  JOIN tt_project_detail pd 
                    ON pd.project_id = sbr.project_id
                  WHERE sbr.center_id = c.center_id
                    AND sbr.exam_center_status = 1
                    AND sbr.client_status = 1
                    AND sbr.admin_status = 1
                    AND pd.exam_city_id = {$cityId}
                    AND pd.start_date <= '{$end}'
                    AND pd.end_date   >= '{$start}'
              )
              +
              (
                  SELECT COUNT(*)
                  FROM tt_self_bookings sb
                  WHERE sb.center_id = c.center_id
                    AND sb.start_date <= '{$end}'
                    AND sb.end_date   >= '{$start}'
              )
              AS overlapping_bookings
          ", FALSE);

            // Human readable availability
            $this->db->select("
              CASE
                  WHEN EXISTS (
                      SELECT 1
                      FROM tt_self_bookings sb
                      WHERE sb.center_id = c.center_id
                        AND sb.start_date <= '{$end}'
                        AND sb.end_date   >= '{$start}'
                  ) THEN 'Not Available'

                  WHEN EXISTS (
                      SELECT 1
                      FROM tt_send_booking_request sbr
                      JOIN tt_project_detail pd 
                        ON pd.project_id = sbr.project_id
                      WHERE sbr.center_id = c.center_id
                        AND sbr.exam_center_status = 1
                        AND sbr.client_status = 1
                        AND sbr.admin_status = 1
                        AND pd.exam_city_id = {$cityId}
                        AND pd.start_date <= '{$end}'
                        AND pd.end_date   >= '{$start}'
                  ) THEN 'Not Available'

                  ELSE 'Available'
              END AS booking_status
          ", FALSE);
        } else {
            $this->db->select("0 AS overlapping_bookings, 'Available' AS booking_status", FALSE);
        }

        $this->db->select("
        (
              SELECT sbr.status
              FROM tt_send_booking_request sbr
              WHERE sbr.project_id = " . $this->db->escape($projectId) . "
                AND sbr.city_id    = " . (int) $cityId . "
                AND sbr.center_id  = c.center_id
                AND sbr.status     = 1
                ORDER BY sbr.id DESC
              LIMIT 1
        ) AS request_status
        ", FALSE);

        $this->db->select("
        (
            SELECT sbr.client_status
            FROM tt_send_booking_request sbr
            WHERE sbr.project_id = " . $this->db->escape($projectId) . "
              AND sbr.city_id    = " . (int)$cityId . "
              AND sbr.center_id  = c.center_id
            ORDER BY sbr.id DESC
            LIMIT 1
        ) AS client_status
        ", FALSE);

        $this->db->select("
        (
            SELECT sbr.exam_center_status
            FROM tt_send_booking_request sbr
            WHERE sbr.project_id = " . $this->db->escape($projectId) . "
              AND sbr.city_id    = " . (int)$cityId . "
              AND sbr.center_id  = c.center_id
            ORDER BY sbr.id DESC
            LIMIT 1
        ) AS exam_center_status
        ", FALSE);

        $this->db->select("
        (
            SELECT sbr.admin_status
            FROM tt_send_booking_request sbr
            WHERE sbr.project_id = " . $this->db->escape($projectId) . "
              AND sbr.city_id    = " . (int)$cityId . "
              AND sbr.center_id  = c.center_id
            ORDER BY sbr.id DESC
            LIMIT 1
        ) AS admin_status
        ", FALSE);

        $this->db->select("
        (
            SELECT sbr.comment
            FROM tt_send_booking_request sbr
            WHERE sbr.project_id = " . $this->db->escape($projectId) . "
              AND sbr.city_id    = " . (int)$cityId . "
              AND sbr.center_id  = c.center_id
            ORDER BY sbr.id DESC
            LIMIT 1
        ) AS reject_comment
        ", FALSE);



        /**
         * ======================================
         * 6. Group & order
         * ======================================
         */
        $this->db->group_by('c.center_id');
        $this->db->order_by('us.is_active', 'DESC');
        $this->db->order_by('sp.is_recommended', 'DESC');
        $this->db->order_by('sp.verified_badge', 'DESC');
        $this->db->order_by('c.capacity', 'DESC');

        return $this->db->get()->result_array();
    }



    public function getBookingRequestStatusList(
        $projectId = NULL,
        $cityId = NULL,
        $type = NULL
    ) {

        $this->db->select('

            br.id,

            br.project_id,

            br.city_id,

            br.center_id,

            br.center_seat,

            br.status,

            br.reason,

            br.comment,

            br.negotiate,

            br.admin_center_final_price,

            br.client_status,

            br.exam_center_status,

            br.center_booking_accept_date,

            br.admin_status,

            br.admin_remark,

            br.admin_action_by,

            br.admin_action_date,

            br.final_booking_flag,

            br.created_at,

            br.updated_at,

            c.center_name,

            c.capacity,

            c.total_no_lab,

            c.total_no_system,

            pd.exam_name,

            pd.client_name,

            pd.start_date,

            pd.end_date,

            pd.number_of_seats,

            pd.price_per_seat,

            pd.admin_price_per_seat,

            cm.city_name,

            sp.name AS package_name,
            sp.verified_badge,
            sp.price AS package_price

        ');

        $this->db->from(
            'tt_send_booking_request br'
        );

        $this->db->join(
            'tt_center c',
            'br.center_id = c.center_id',
            'left'
        );

        $this->db->join(
            'user_subscriptions us',
            'us.center_owner_id = c.owner_user_id
             AND us.is_active = 1',
            'left'
        );

        $this->db->join(
            'subscription_packages sp',
            'sp.id = us.package_id',
            'left'
        );

        $this->db->join(
            'tt_project_detail pd',

            'br.project_id = pd.project_id
        AND br.city_id = pd.exam_city_id',

            'left'
        );

        $this->db->join(

            'tt_city_master cm',

            'cm.city_id = br.city_id',

            'left'

        );

        if (!empty($projectId)) {

            $this->db->where(
                'br.project_id',
                $projectId
            );
        }

        if (!empty($cityId) && $cityId != '') {

            $this->db->where(
                'br.city_id',
                $cityId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Current List
        |--------------------------------------------------------------------------
        */

        if ($type == 'current') {

            $this->db->where('br.id IN (

                SELECT MAX(id)
                FROM tt_send_booking_request
                GROUP BY project_id, city_id, center_id

            )', NULL, FALSE);

            $this->db->where('br.admin_status !=', 2);

            $this->db->where('br.client_status !=', 2);

            $this->db->where('br.exam_center_status !=', 2);
        }

        /*
        |--------------------------------------------------------------------------
        | Rejected List
        |--------------------------------------------------------------------------
        */

        if ($type == 'rejected') {

            $this->db->group_start();

            $this->db->where('br.exam_center_status', 2);

            $this->db->or_where('br.client_status', 2);

            $this->db->or_where('br.admin_status', 2);

            $this->db->group_end();
        }

        $this->db->order_by(
            'br.id',
            'DESC'
        );

        return $this->db
            ->get()
            ->result_array();
    }
}
