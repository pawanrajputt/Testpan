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
            $this->db->where('center_id', $center_id);
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
        $this->db->where('sbr.admin_status', 1);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);  // NEW
        }


        /*
        |--------------------------------------------------------------------------
        | Show only fully allocated cities
        |--------------------------------------------------------------------------
        */
        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats'
        ]);

        $this->db->having('SUM(sbr.center_seat) >= pd.number_of_seats', null, false);

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }
    public function get_bookings_by_date($date)
    {
        if (!$date) {
            return [];
        }

        // ==========================================
        // Self Bookings
        // ==========================================

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

        $self_bookings = $this->db->get()->result_array();


        // ==========================================
        // Assigned Bookings (Only Fully Allocated)
        // ==========================================

        $this->db->select("
        pd.project_id AS id,
        pd.exam_name,
        SUM(sbr.center_seat) AS seats_booked,
        cl.company_name AS client_name,
        pd.start_date,
        pd.end_date,
        c.center_name,
        pd.number_of_seats
    ");

        $this->db->select("'assigned_booking' AS type", false);

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
         AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->join(
            'tt_center c',
            'c.center_id = sbr.center_id'
        );

        $this->db->join(
            'tt_client cl',
            'cl.ac_id = sbr.client_id'
        );

        $this->db->where('pd.start_date <=', $date);
        $this->db->where('pd.end_date >=', $date);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.exam_name',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats',
            'cl.company_name',
            'c.center_name'
        ]);

        // Only fully allocated cities
        $this->db->having(
            'SUM(sbr.center_seat) >= pd.number_of_seats',
            null,
            false
        );

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge(
            $self_bookings,
            $assigned_bookings
        );
    }

    public function get_calendar_summary($month, $year, $center_id = null)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day  = date('Y-m-t', strtotime("$year-$month-01"));

        // =========================
        // SELF BOOKING COUNT
        // =========================

        $this->db->from('tt_self_bookings');
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);

        if (!empty($center_id)) {
            $this->db->where('center_id', $center_id);
        }

        $self_count = $this->db->count_all_results();


        // =========================
        // ASSIGNED BOOKING COUNT
        // =========================

        $this->db->select('
            sbr.project_id,
            sbr.city_id,
            pd.number_of_seats,
            SUM(sbr.center_seat) AS allocated_seats
        ');

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
            AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);
        }

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.number_of_seats'
        ]);

        $this->db->having('SUM(sbr.center_seat) >= pd.number_of_seats', null, false);

        $assigned_count = count($this->db->get()->result_array());


        return [
            'self_booking'      => $self_count,
            'assigned_booking'  => $assigned_count,
            'total_booking'     => $self_count + $assigned_count
        ];
    }

    public function get_calendar_day_counts($month, $year, $center_id = null)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day  = date('Y-m-t', strtotime("$year-$month-01"));

        $calendar = [];

        //=========================
        // SELF BOOKINGS
        //=========================

        $this->db->select('start_date,end_date');
        $this->db->from('tt_self_bookings');
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);

        if (!empty($center_id)) {
            $this->db->where('center_id', $center_id);
        }

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $start = strtotime(max($row['start_date'], $first_day));
            $end   = strtotime(min($row['end_date'], $last_day));

            while ($start <= $end) {

                $date = date('Y-m-d', $start);

                if (!isset($calendar[$date])) {
                    $calendar[$date] = [
                        'self' => 0,
                        'assigned' => 0
                    ];
                }

                $calendar[$date]['self']++;

                $start = strtotime('+1 day', $start);
            }
        }


        //=========================
        // ASSIGNED BOOKINGS
        //=========================

        $this->db->select('
    pd.start_date,
    pd.end_date,
    pd.number_of_seats,
    SUM(sbr.center_seat) AS allocated_seats
');
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id=sbr.project_id
     AND pd.exam_city_id=sbr.city_id'
        );

        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);
        }


        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats'
        ]);

        $this->db->having('SUM(sbr.center_seat) >= pd.number_of_seats', null, false);

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $start = strtotime(max($row['start_date'], $first_day));
            $end   = strtotime(min($row['end_date'], $last_day));

            while ($start <= $end) {

                $date = date('Y-m-d', $start);

                if (!isset($calendar[$date])) {

                    $calendar[$date] = [
                        'self' => 0,
                        'assigned' => 0
                    ];
                }

                $calendar[$date]['assigned']++;

                $start = strtotime('+1 day', $start);
            }
        }

        return $calendar;
    }

    public function get_calendar_tooltips($month, $year, $center_id = null)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day  = date('Y-m-t', strtotime("$year-$month-01"));

        $result = [];

        // =========================
        // SELF BOOKINGS
        // =========================

        $this->db->select('client_name, exam_name, start_date, end_date');
        $this->db->from('tt_self_bookings');
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);

        if (!empty($center_id)) {
            $this->db->where('center_id', $center_id);
        }

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $start = strtotime(max($row['start_date'], $first_day));
            $end   = strtotime(min($row['end_date'], $last_day));

            while ($start <= $end) {

                $date = date('Y-m-d', $start);

                if (!isset($result[$date])) {
                    $result[$date] = [
                        'self' => [],
                        'assigned' => []
                    ];
                }

                $result[$date]['self'][] =
                    $row['client_name'] . " - " . $row['exam_name'];

                $start = strtotime('+1 day', $start);
            }
        }

        // =========================
        // ASSIGNED BOOKINGS
        // =========================

        $this->db->select('
    cl.company_name,
    pd.exam_name,
    pd.start_date,
    pd.end_date,
    pd.number_of_seats,
    SUM(sbr.center_seat) AS allocated_seats
');
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id=sbr.project_id
     AND pd.exam_city_id=sbr.city_id'
        );
        $this->db->join('tt_client cl', 'cl.ac_id=sbr.client_id');

        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);
        }

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'cl.company_name',
            'pd.exam_name',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats'
        ]);

        $this->db->having('SUM(sbr.center_seat) >= pd.number_of_seats', null, false);

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $start = strtotime(max($row['start_date'], $first_day));
            $end   = strtotime(min($row['end_date'], $last_day));

            while ($start <= $end) {

                $date = date('Y-m-d', $start);

                if (!isset($result[$date])) {
                    $result[$date] = [
                        'self' => [],
                        'assigned' => []
                    ];
                }

                $result[$date]['assigned'][] =
                    $row['company_name'] . " - " . $row['exam_name'];

                $start = strtotime('+1 day', $start);
            }
        }

        return $result;
    }

    public function get_calendar_popovers($month, $year, $center_id = null)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day  = date('Y-m-t', strtotime("$year-$month-01"));

        $result = [];

        // ================= SELF =================

        $this->db->select('c.center_name,sb.client_name,sb.exam_name,sb.seats_booked,sb.start_date,sb.end_date');
        $this->db->from('tt_self_bookings sb');
        $this->db->join('tt_center c', 'c.center_id=sb.center_id');
        $this->db->where('sb.start_date <=', $last_day);
        $this->db->where('sb.end_date >=', $first_day);

        if (!empty($center_id)) {
            $this->db->where('sb.center_id', $center_id);
        }

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $start = strtotime(max($row['start_date'], $first_day));
            $end   = strtotime(min($row['end_date'], $last_day));

            while ($start <= $end) {

                $date = date('Y-m-d', $start);

                $result[$date]['self'][] = $row;

                $start = strtotime('+1 day', $start);
            }
        }

        // ================= ASSIGNED =================

        $this->db->select('c.center_name,cl.company_name,pd.exam_name,pd.number_of_seats as seats_booked,pd.start_date,pd.end_date');
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join('tt_project_detail pd', 'pd.project_id=sbr.project_id');
        $this->db->join('tt_client cl', 'cl.ac_id=sbr.client_id');
        $this->db->join('tt_center c', 'c.center_id=sbr.center_id');

        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);
        }

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $start = strtotime(max($row['start_date'], $first_day));
            $end   = strtotime(min($row['end_date'], $last_day));

            while ($start <= $end) {

                $date = date('Y-m-d', $start);

                $result[$date]['assigned'][] = $row;

                $start = strtotime('+1 day', $start);
            }
        }

        return $result;
    }

    public function get_assigned_booking_month_counts($year, $center_id = null)
    {
        $result = [];

        // Initialize all months
        for ($m = 1; $m <= 12; $m++) {
            $result[$m] = 0;
        }

        $this->db->select('
    pd.start_date,
    pd.end_date,
    pd.number_of_seats,
    SUM(sbr.center_seat) AS allocated_seats
');
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id=sbr.project_id
     AND pd.exam_city_id=sbr.city_id'
        );

        $this->db->where('YEAR(pd.start_date)', $year);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);
        }

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats'
        ]);

        $this->db->having('SUM(sbr.center_seat) >= pd.number_of_seats', null, false);

        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {

            $month = (int)date('n', strtotime($row['start_date']));

            $result[$month]++;
        }

        return $result;
    }


    // =============== View Center Calendar ===============
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

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats'
        ]);

        $this->db->having(
            'SUM(sbr.center_seat) >= pd.number_of_seats',
            null,
            false
        );

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }


    public function get_center_booking_summary($month, $year, $center_id)
    {
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day  = date('Y-m-t', strtotime("$year-$month-01"));

        // =====================================================
        // MONTHLY SELF COUNT
        // =====================================================
        $this->db->from('tt_self_bookings');
        $this->db->where('center_id', $center_id);
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);
        $monthly_self = $this->db->count_all_results();


        // =====================================================
        // MONTHLY ASSIGNED COUNT (Only Fully Allocated)
        // =====================================================
        $this->db->select('sbr.project_id');

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
         AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->where('sbr.center_id', $center_id);

        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.number_of_seats'
        ]);

        $this->db->having(
            'SUM(sbr.center_seat) >= pd.number_of_seats',
            null,
            false
        );

        $monthly_assigned = count($this->db->get()->result_array());


        // =====================================================
        // LIFE TIME SELF COUNT
        // =====================================================
        $this->db->from('tt_self_bookings');
        $this->db->where('center_id', $center_id);
        $life_time_self = $this->db->count_all_results();


        // =====================================================
        // LIFE TIME ASSIGNED COUNT (Only Fully Allocated)
        // =====================================================
        $this->db->select('sbr.project_id');

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
         AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->where('sbr.center_id', $center_id);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.number_of_seats'
        ]);

        $this->db->having(
            'SUM(sbr.center_seat) >= pd.number_of_seats',
            null,
            false
        );

        $life_time_assigned = count($this->db->get()->result_array());


        // =====================================================
        // YEARLY SELF COUNT
        // =====================================================
        $this->db->from('tt_self_bookings');
        $this->db->where('center_id', $center_id);
        $this->db->where('YEAR(start_date)', $year);
        $overall_self = $this->db->count_all_results();


        // =====================================================
        // YEARLY ASSIGNED COUNT (Only Fully Allocated)
        // =====================================================
        $this->db->select('sbr.project_id');

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
         AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->where('sbr.center_id', $center_id);
        $this->db->where('YEAR(pd.start_date)', $year);

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.number_of_seats'
        ]);

        $this->db->having(
            'SUM(sbr.center_seat) >= pd.number_of_seats',
            null,
            false
        );

        $overall_assigned = count($this->db->get()->result_array());


        return [
            'monthly_self'       => $monthly_self,
            'monthly_assigned'   => $monthly_assigned,
            'overall_self'       => $overall_self,
            'overall_assigned'   => $overall_assigned,
            'life_time_self'     => $life_time_self,
            'life_time_assigned' => $life_time_assigned,
        ];
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
            SUM(sbr.center_seat) AS seats_booked,
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
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by([
            'sbr.project_id',
            'sbr.city_id',
            'pd.exam_name',
            'pd.start_date',
            'pd.end_date',
            'pd.number_of_seats',
            'cl.company_name',
            'c.center_name'
        ]);

        // Show only fully allocated projects
        $this->db->having(
            'SUM(sbr.center_seat) >= pd.number_of_seats',
            null,
            false
        );

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }
}