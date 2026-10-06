<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
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


  public function authenticateAdmin($email, $password)
  {
    $this->db->select('u.id, u.email, u.username, u.role_id, u.password, u.approved, r.name as role_name');
    $this->db->from('tt_admin_users u');
    $this->db->join('roles r', 'r.id = u.role_id', 'left');
    $this->db->where([
      'u.email'      => $email,
      'u.log_status' => 1
    ]);

    $query = $this->db->get();

    if ($query->num_rows() !== 1) {
      return 'invalid';
    }

    $user = $query->row();

    // Check approved status
    if ($user->approved != 1) {
      return 'blocked';
    }

    // 🔐 Verify Password (IMPORTANT)
    if (!password_verify($password, $user->password)) {
      return 'invalid';
    }

    // Login log
    $this->db->insert('tt_admin_users_login_logs', [
      'user_id'         => $user->id,
      'ip_address'      => $this->input->ip_address(),
      'last_login_date' => date('Y-m-d H:i:s'),
      'log_date'        => date('Y-m-d'),
      'log_time'        => date('H:i:s'),
      'log_status'      => 1
    ]);

    return [
      'id'        => $user->id,
      'username'  => ucwords($user->username),
      'email'     => $user->email,
      'role_id'   => $user->role_id,
      'role_name' => $user->role_name ?? 'Admin'
    ];
  }


  public function get_bookings_with_center($center_id)
  {
    $this->db->select('sb.*, c.center_name, c.center_id');
    $this->db->from('tt_self_bookings sb');
    $this->db->join('tt_center c', 'c.center_id = sb.center_id', 'left');
    $this->db->where('sb.center_id', $center_id);
    $this->db->order_by('sb.exam_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_center_info($center_id)
  {
    $this->db->where('center_id', $center_id);
    return $this->db->get('tt_center')->row_array();
  }

  public function get_self_booking_detail($id)
  {
    $this->db->select('sb.*, c.center_name');
    $this->db->from('tt_self_bookings sb');
    $this->db->join('tt_center c', 'c.center_id = sb.center_id', 'left');
    $this->db->where('sb.id', $id);
    $this->db->where('sb.deleted', 0);

    return $this->db->get()->row();
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

  public function getProjectBatchStatistics($projectId, $cityId = null)
  {
    $this->db->select("
      pb.city_id,
      cm.city_name,
      pb.batch_no,
      pb.batch_start,
      pb.batch_end,
      pb.seat AS required_seat,

      COALESCE(SUM(sbrb.center_seat), 0) AS requested_seat,

      COALESCE(SUM(
          CASE
              WHEN sbr.admin_status = 1
              AND sbr.exam_center_status = 1
              THEN sbrb.center_seat
              ELSE 0
          END
      ), 0) AS approved_seat
    ");

    $this->db->from("tt_project_batch_detail pb");

    $this->db->join(
      "tt_city_master cm",
      "cm.city_id = pb.city_id",
      "left"
    );

    $this->db->join(
      "tt_send_booking_request_batch sbrb",
      "sbrb.project_id = pb.project_id
        AND sbrb.city_id = pb.city_id
        AND sbrb.batch_no = pb.batch_no",
      "left"
    );

    $this->db->join(
      "tt_send_booking_request sbr",
      "sbr.id = sbrb.request_id",
      "left"
    );

    $this->db->where("pb.project_id", $projectId);

    if (!empty($cityId)) {
      $this->db->where("pb.city_id", $cityId);
    }

    $this->db->group_by([
      "pb.city_id",
      "pb.batch_no"
    ]);

    $this->db->order_by("cm.city_name");
    $this->db->order_by("pb.batch_no");

    $rows = $this->db->get()->result_array();

    $result = [];

    foreach ($rows as $row) {

      $city = $row['city_id'];

      if (!isset($result[$city])) {

        $stats = $this->db
          ->select("
                    COUNT(*) total_requests,

                    SUM(exam_center_status=0) pending,

                    SUM(exam_center_status=1) approved_centers,

                    SUM(exam_center_status=2) rejected,

                    SUM(exam_center_status=3) negotiation,

                    SUM(admin_status=3) hold
                ", false)
          ->where("project_id", $projectId)
          ->where("city_id", $city)
          ->get("tt_send_booking_request")
          ->row_array();

        $result[$city] = [

          'city_name' => $row['city_name'],

          'summary' => [

            'required' => 0,

            'requested' => 0,

            'approved' => 0,

            'remaining' => 0,

            'total_requests' => $stats['total_requests'] ?? 0,

            'pending' => $stats['pending'] ?? 0,

            'approved_centers' => $stats['approved_centers'] ?? 0,

            'rejected' => $stats['rejected'] ?? 0,

            'hold' => $stats['hold'] ?? 0,

            'negotiation' => $stats['negotiation'] ?? 0

          ],

          'batches' => []

        ];
      }

      $row['remaining_seat'] =
        max(
          0,
          $row['required_seat'] - $row['requested_seat']
        );

      $result[$city]['summary']['required'] += $row['required_seat'];
      $result[$city]['summary']['requested'] += $row['requested_seat'];
      $result[$city]['summary']['approved'] += $row['approved_seat'];
      $result[$city]['summary']['remaining'] += $row['remaining_seat'];

      $result[$city]['batches'][] = $row;
    }

    return $result;
  }
}
