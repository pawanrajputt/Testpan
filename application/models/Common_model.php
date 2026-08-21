<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSingleData($table, $where)
    {

        $this->db->select('*');

        if (!empty($where)) {

            $this->db->where($where);
        }

        $query = $this->db->get($table)->row();

        return $query;
    }

    public function getActiveNews()
    {
        return $this->db
            ->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('custom_news')
            ->result();
    }


    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        if (!empty($id > 0)) {
            return $id;
        } else {
            return false;
        }
    }


    public function UpdateRecord($TableName, $Data, $WhereData = NULL)
    {
        if ($WhereData != NULL) {
            $this->db->where($WhereData);
        }
        $Result = $this->db->update($TableName, $Data);
        return $Result;
    }


    public function Deletedata($table, $where)
    {
        $this->db->delete($table, $where);
        return TRUE;
    }


    public function getdata($table, $where)
    {

        $this->db->select('*');

        if (!empty($where)) {

            $this->db->where($where);
        }

        $query = $this->db->get($table)->row();

        return $query;
    }


    public function getdata_array($table, $where)
    {

        $this->db->select('*');

        if (!empty($where)) {

            $this->db->where($where);
        }

        $query = $this->db->get($table)->result_array();

        return $query;
    }


    public function get_total_booked_seat($table, $centerId)
    {
        if (empty($centerId)) {
            return 0;
        }

        $result = $this->db
            ->select('SUM(center_seat) AS booked_seats')
            ->from($table)
            ->where('center_id', $centerId)
            ->where('client_status', 1)
            ->where('exam_center_status', 1)
            ->where('admin_status', 1)
            ->get()
            ->row();

        return (int)($result->booked_seats ?? 0);
    }


    public function get_total_booking_request(
        $center_id,
        $reqStatus = NULL,
        $clientStatus = NULL,
        $search = NULL,
        $cityId = NULL
    ) {

        if (empty($center_id)) {
            return [];
        }

        $this->db->select('
          proj.*,

          req.id,
          req.status AS request_status,
          req.center_seat,

          req.client_status,
          req.exam_center_status,
          req.admin_status,

          req.admin_center_final_price,
          req.admin_remark,
          req.comment,

          req.center_booking_accept_date,
          req.admin_action_date,
          req.created_at
      ');

        $this->db->from('tt_project_detail AS proj');

        /*
      |--------------------------------------------------------------------------
      | Latest Request Only
      |--------------------------------------------------------------------------
      */
        $this->db->join(
            'tt_send_booking_request AS req',
            'req.id = (
                SELECT MAX(sbr.id)
                FROM tt_send_booking_request sbr
                WHERE sbr.project_id = proj.project_id
                AND sbr.city_id = proj.exam_city_id
                AND sbr.center_id = ' . (int)$center_id . '
            )',
            'INNER',
            FALSE
        );

        $this->db->where('req.center_id', $center_id);

        if (!empty($cityId)) {
            $this->db->where('proj.exam_city_id', $cityId);
        }

        /*
      |--------------------------------------------------------------------------
      | My Status Filter
      |--------------------------------------------------------------------------
      */
        if ($reqStatus !== NULL && !empty($reqStatus)) {
            $this->db->where('req.exam_center_status', $reqStatus);
        }

        /*
      |--------------------------------------------------------------------------
      | Client Status Filter
      |--------------------------------------------------------------------------
      */
        if ($clientStatus !== NULL && !empty($clientStatus)) {
            $this->db->where('req.client_status', $clientStatus);
        }

        /*
      |--------------------------------------------------------------------------
      | Search
      |--------------------------------------------------------------------------
      */
        if (!empty($search)) {

            $this->db->group_start();

            $this->db->like(
                'proj.exam_name',
                $search
            );

            $this->db->or_like(
                'proj.client_name',
                $search
            );

            $this->db->group_end();
        }

        /*
      |--------------------------------------------------------------------------
      | Exclude Rejected Records
      |--------------------------------------------------------------------------
      */

        // $this->db->group_start();

        //     $this->db->where('req.exam_center_status !=', 2);

        //     $this->db->where('req.client_status !=', 2);

        //     $this->db->where('req.admin_status !=', 2);

        // $this->db->group_end();

        $this->db->where(
            'proj.deleted',
            0
        );

        $this->db->order_by(
            'req.id',
            'DESC'
        );

        return $this->db
            ->get()
            ->result_array();

        // $result = $this->db->get()->result_array();

        // if ($includeReleased) {

        //     $released = $this->get_postponed_booking_request($center_id, $cityId);

        //     $result = array_merge($result, $released);

        //     usort($result, function ($a, $b) {

        //         $dateA = isset($a['released_at']) && !empty($a['released_at'])
        //             ? strtotime($a['released_at'])
        //             : strtotime($a['created_at']);

        //         $dateB = isset($b['released_at']) && !empty($b['released_at'])
        //             ? strtotime($b['released_at'])
        //             : strtotime($b['created_at']);

        //         return $dateB <=> $dateA;

        //     });
        // }

        // return $result;
    }

    public function get_inreview_booking_request(
        $center_id,
        $cityId = NULL
    ) {
        $this->db->select('
          proj.*,

          req.id,
          req.status AS request_status,
          req.center_seat,

          req.client_status,
          req.exam_center_status,
          req.admin_status,

          req.admin_center_final_price,
          req.admin_remark,
          req.comment,

          req.center_booking_accept_date,
          req.admin_action_date,
          req.created_at
      ');

        $this->db->from('tt_send_booking_request AS req');

        $this->db->join(
            'tt_project_detail AS proj',
            'proj.project_id = req.project_id
          AND proj.exam_city_id = req.city_id',
            'left'
        );

        $this->db->where([
            'req.center_id'          => $center_id,
            'req.exam_center_status' => 1,
            'req.client_status'      => 0,
            'req.admin_status'       => 1,
            'proj.deleted'           => 0
        ]);

        if (!empty($cityId)) {
            $this->db->where('req.city_id', $cityId);
        }

        $this->db->order_by('req.id', 'DESC');

        return $this->db->get()->result_array();
    }


    public function get_confirmed_booking_request(
        $center_id,
        $cityId = NULL
    ) {
        $this->db->select('
          proj.*,

          req.id,
          req.status AS request_status,
          req.center_seat,

          req.client_status,
          req.exam_center_status,
          req.admin_status,

          req.admin_center_final_price,
          req.admin_remark,
          req.comment,

          req.center_booking_accept_date,
          req.admin_action_date,
          req.created_at
      ');

        $this->db->from('tt_send_booking_request AS req');

        $this->db->join(
            'tt_project_detail AS proj',
            'proj.project_id = req.project_id
          AND proj.exam_city_id = req.city_id',
            'left'
        );

        $this->db->where([
            'req.center_id'          => $center_id,
            'req.exam_center_status' => 1,
            'req.client_status'      => 1,
            'req.admin_status'       => 1,
            'proj.deleted'           => 0
        ]);

        if (!empty($cityId)) {
            $this->db->where('req.city_id', $cityId);
        }

        $this->db->order_by('req.id', 'DESC');

        return $this->db->get()->result_array();
    }


    public function get_rejected_booking_request(
        $center_id,
        $cityId = NULL
    ) {
        $this->db->select('
          proj.*,

          req.id,
          req.status AS request_status,
          req.center_seat,

          req.client_status,
          req.exam_center_status,
          req.admin_status,

          req.admin_center_final_price,
          req.admin_remark,
          req.comment,

          req.center_booking_accept_date,
          req.admin_action_date,
          req.created_at
      ');

        $this->db->from('tt_send_booking_request AS req');

        $this->db->join(
            'tt_project_detail AS proj',
            'proj.project_id = req.project_id
          AND proj.exam_city_id = req.city_id',
            'left'
        );

        $this->db->where('req.center_id', $center_id);

        if (!empty($cityId)) {
            $this->db->where('req.city_id', $cityId);
        }

        $this->db->group_start();

        $this->db->where('req.exam_center_status', 2);

        $this->db->or_where('req.client_status', 2);

        $this->db->or_where('req.admin_status', 2);

        $this->db->group_end();

        $this->db->where('proj.deleted', 0);

        $this->db->order_by('req.id', 'DESC');

        return $this->db->get()->result_array();
    }


    public function get_postponed_booking_request($center_id, $cityId = NULL)
    {
        $this->db->select('
          proj.*,

          req.id,
          req.status AS request_status,
          req.center_seat,

          req.client_status,
          req.exam_center_status,
          req.admin_status,

          req.admin_center_final_price,
          req.admin_remark,
          req.comment,

          req.center_booking_accept_date,
          req.admin_action_date,
          req.created_at,

          req.release_type,
          req.release_reason,
          req.project_remark,
          req.released_at
      ');

        $this->db->from('tt_booking_release_log AS req');

        $this->db->join(
            'tt_project_detail AS proj',
            'proj.project_id = req.project_id
          AND proj.exam_city_id = req.city_id',
            'left'
        );

        $this->db->where('req.center_id', $center_id);

        if (!empty($cityId)) {
            $this->db->where('req.city_id', $cityId);
        }

        $this->db->where('req.release_reason', 'Project Postponed');

        $this->db->where('proj.deleted', 0);

        $this->db->order_by('req.released_at', 'DESC');

        return $this->db->get()->result_array();
    }



    public function get_total_inreview_booking_request(
        $center_id,
        $search = NULL,
        $cityId = NULL
    ) {
        if (empty($center_id)) {
            return [];
        }

        $this->db->select('
        proj.*,

        req.id,
        req.status AS request_status,
        req.center_seat,

        req.client_status,
        req.exam_center_status,
        req.admin_status,

        req.admin_center_final_price,
        req.admin_remark,
        req.comment,

        req.center_booking_accept_date,
        req.admin_action_date,
        req.created_at
    ');

        $this->db->from('tt_project_detail AS proj');

        /*
    |--------------------------------------------------------------------------
    | Latest Request Only
    |--------------------------------------------------------------------------
    */
        $this->db->join(
            'tt_send_booking_request AS req',
            'req.id = (
            SELECT MAX(sbr.id)
            FROM tt_send_booking_request sbr
            WHERE sbr.project_id = proj.project_id
            AND sbr.city_id = proj.exam_city_id
            AND sbr.center_id = ' . (int)$center_id . '
        )',
            'INNER'
        );

        $this->db->where('req.center_id', $center_id);

        /*
    |--------------------------------------------------------------------------
    | In Review Status
    |--------------------------------------------------------------------------
    */
        $this->db->where('req.exam_center_status', 1);
        $this->db->where('req.client_status', 0);

        if (!empty($cityId)) {
            $this->db->where('proj.exam_city_id', $cityId);
        }

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
        if (!empty($search)) {

            $this->db->group_start();

            $this->db->like(
                'proj.exam_name',
                $search
            );

            $this->db->or_like(
                'proj.client_name',
                $search
            );

            $this->db->group_end();
        }

        $this->db->where(
            'proj.deleted',
            0
        );

        $this->db->order_by(
            'req.id',
            'DESC'
        );

        return $this->db
            ->get()
            ->result_array();
    }


    public function get_single_booking_request($center_id, $project_id, $cityId, $booking_id = NULL)
    {
        $this->db->select('
          proj.*, 
          req.status AS request_status,
          req.center_seat, 
          req.client_status, 
          req.exam_center_status,
          req.created_at AS booking_received,
          req.center_booking_accept_date,
          req.client_accept_booking_date,
          req.center_id AS center_id,
          req.admin_center_final_price,
          city.city_name
      ');
        $this->db->from('tt_project_detail AS proj');
        $this->db->join('tt_send_booking_request AS req', 'proj.project_id = req.project_id AND proj.client_id = req.client_id');
        $this->db->join('tt_city_master AS city', 'proj.exam_city_id = city.city_id', 'left');
        $this->db->where('req.id', $booking_id);
        $this->db->where('req.center_id', $center_id);
        $this->db->where('req.project_id', $project_id);
        $this->db->where('proj.exam_city_id', $cityId);
        $this->db->where('proj.deleted', 0);

        return $this->db->get()->row();
    }



    public function get_exam_dates($month, $year, $center_id)
    {
        $first_day = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
        $last_day = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

        // Get self bookings
        $this->db->select('start_date, end_date, exam_name, "self_booking" as type');
        $this->db->from('tt_self_bookings');
        $this->db->where('start_date <=', $last_day);
        $this->db->where('end_date >=', $first_day);
        $this->db->where('center_id', $center_id);
        $self_bookings = $this->db->get()->result_array();

        // Get assigned bookings (from send_booking_request joined with project_detail)
        $this->db->select('pd.start_date, pd.end_date, pd.exam_name as exam_name, "assigned_booking" as type');
        $this->db->from('tt_send_booking_request sbr');
        $this->db->join('tt_project_detail pd', 'pd.project_id = sbr.project_id');
        $this->db->where('pd.start_date <=', $last_day);
        $this->db->where('pd.end_date >=', $first_day);
        $this->db->where('sbr.center_id', $center_id);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $assigned_bookings = $this->db->get()->result_array();

        // Merge both results
        return array_merge($self_bookings, $assigned_bookings);
    }

    public function get_bookings_by_date($date, $center_id)
    {
        // -------------------------
        // Self Bookings
        // -------------------------
        $this->db->select('
        sb.id,
        sb.exam_name,
        sb.seats_booked,
        sb.client_name,
        sb.start_date,
        sb.end_date,
        "self_booking" as type', false);

        $this->db->from('tt_self_bookings sb');
        $this->db->where('sb.start_date <=', $date);
        $this->db->where('sb.end_date >=', $date);

        if (!empty($center_id)) {
            $this->db->where('sb.center_id', $center_id);
        }

        $self_bookings = $this->db->get()->result_array();


        // -------------------------
        // Assigned Bookings
        // -------------------------
        $this->db->select('
        pd.project_id as id,
        pd.exam_name,
        sbr.center_seat as seats_booked,
        pd.client_name,
        pd.start_date,
        pd.end_date,
        "assigned_booking" as type', false);

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
        AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->where('pd.start_date <=', $date);
        $this->db->where('pd.end_date >=', $date);

        if (!empty($center_id)) {
            $this->db->where('sbr.center_id', $center_id);
        }

        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }

    public function get_bookings_by_date_api($date, $center_id)
    {
        // -------------------------
        // Self Bookings
        // -------------------------
        $this->db->select('
        sb.id,
        sb.exam_name,
        sb.seats_booked,
        sb.client_name,
        sb.start_date,
        sb.end_date,
        sb.total_batch,
        sb.batch1_start, sb.batch1_end,
        sb.batch2_start, sb.batch2_end,
        sb.batch3_start, sb.batch3_end,
        sb.batch4_start, sb.batch4_end,
        sb.batch5_start, sb.batch5_end,
        "self_booking" as type', false);

        $this->db->from('tt_self_bookings sb');
        $this->db->where('sb.start_date <=', $date);
        $this->db->where('sb.end_date >=', $date);
        $this->db->where('sb.center_id', $center_id);

        $self_bookings = $this->db->get()->result_array();


        // -------------------------
        // Assigned Bookings
        // -------------------------
        $this->db->select('
        pd.project_id as id,
        pd.exam_name,
        sbr.center_seat as seats_booked,
        pd.client_name,
        pd.start_date,
        pd.end_date,
        pd.total_batch,
        pd.batch1_start, pd.batch1_end,
        pd.batch2_start, pd.batch2_end,
        pd.batch3_start, pd.batch3_end,
        pd.batch4_start, pd.batch4_end,
        pd.batch5_start, pd.batch5_end,
        "assigned_booking" as type', false);

        $this->db->from('tt_send_booking_request sbr');

        $this->db->join(
            'tt_project_detail pd',
            'pd.project_id = sbr.project_id
        AND pd.exam_city_id = sbr.city_id'
        );

        $this->db->where('pd.start_date <=', $date);
        $this->db->where('pd.end_date >=', $date);

        $this->db->where('sbr.center_id', $center_id);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $this->db->where('sbr.admin_status', 1);

        $this->db->group_by('sbr.id');

        $assigned_bookings = $this->db->get()->result_array();

        return array_merge($self_bookings, $assigned_bookings);
    }

    public function get_client_self_booking($center_id, $search = '')
    {
        $this->db->select('sb.*, c.center_name, c.center_id');
        $this->db->from('tt_self_bookings sb');
        $this->db->join('tt_center c', 'c.center_id = sb.center_id', 'left');
        $this->db->where('sb.center_id', $center_id);

        // Multi-column search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('sb.client_name', $search);
            $this->db->or_like('sb.client_email', $search);
            $this->db->or_like('sb.client_phone', $search);
            $this->db->or_like('sb.exam_name', $search);
            $this->db->group_end();
        }

        $this->db->order_by('sb.exam_date', 'DESC');

        return $this->db->get()->result_array();
    }



    public function get_self_booking_data_by_id($id)
    {
        $this->db->select('sb.*, c.center_name, c.center_id, lab.*');
        $this->db->from('tt_self_bookings sb');
        $this->db->join('tt_center c', 'c.center_id = sb.center_id', 'left');
        $this->db->join('tt_lab lab', 'lab.id = sb.labs_assigned', 'left');
        $this->db->where('sb.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_assigned_booking_data_by_id($project_id)
    {
        $this->db->select('pd.*, sbr.*, sbr.center_seat AS number_of_seats, c.center_name, c.center_id, lab.*, 
                        cl.co_ordinator_name as client_name, cl.coordinator_email as client_email,
                        cl.coordinator_mobile_number as client_phone, cl.company_name as company_name');
        $this->db->from('tt_project_detail pd');
        $this->db->join(
            'tt_send_booking_request sbr',
            'sbr.project_id = pd.project_id
            AND sbr.city_id = pd.exam_city_id'
        );
        $this->db->join('tt_center c', 'c.center_id = sbr.center_id', 'left');
        $this->db->join('tt_lab lab', 'lab.center_id = sbr.center_id', 'left');
        $this->db->join('tt_client cl', 'cl.ac_id = sbr.client_id', 'left');
        $this->db->where('pd.project_id', $project_id);
        $this->db->where('sbr.exam_center_status', 1);
        $this->db->where('sbr.client_status', 1);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_date_conflict_self_booking($center_id, $start_date, $end_date, $exclude_id = null)
    {
        $this->db->where('center_id', $center_id);

        // Exclude current booking during update
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }

        $this->db->where("(
          (start_date <= '$end_date' AND end_date >= '$start_date') OR
          (start_date BETWEEN '$start_date' AND '$end_date') OR
          (end_date BETWEEN '$start_date' AND '$end_date')
      )");
        return $this->db->get('tt_self_bookings')->num_rows() > 0;
    }


    public function check_date_conflict_project($center_id, $start_date, $end_date)
    {
        $this->db->select('pd.start_date, pd.end_date');
        $this->db->from('tt_project_detail pd');
        $this->db->join('tt_send_booking_request sbr', 'pd.project_id = sbr.project_id');
        $this->db->where('sbr.center_id', $center_id);
        $this->db->where("(
          (pd.start_date <= '$end_date' AND pd.end_date >= '$start_date') OR
          (pd.start_date BETWEEN '$start_date' AND '$end_date') OR
          (pd.end_date BETWEEN '$start_date' AND '$end_date')
      )");
        return $this->db->get()->num_rows() > 0;
    }


    public function check_phone_exists($phone)
    {
        $this->db->where('mobile_phone', $phone);
        $query = $this->db->get('tt_admin_users');
        return $query->num_rows() > 0;
    }

    public function has_any_booking($center_id)
    {
        // Self bookings
        $selfExists = $this->db
            ->where('center_id', $center_id)
            ->limit(1)
            ->count_all_results('tt_self_bookings') > 0;

        if ($selfExists) {
            return true;
        }

        // Assigned bookings
        $assignedExists = $this->db
            ->where('center_id', $center_id)
            ->limit(1)
            ->count_all_results('tt_send_booking_request') > 0;

        return $assignedExists;
    }
}
