<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeletedCenterController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }
    }

    /* ===============================
       PAGE LOAD
    =============================== */
    public function index()
    {
        $data['page_title'] = 'Deleted Centers';

        // Deleted Centers
        $data['deleted_centers'] = $this->db
            ->where('deleted', 1)
            ->count_all_results('tt_center');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/deleted_centers');
        $this->load->view('layouts/footer');
    }

    /* ===============================
       AJAX LIST (deleted = 1)
    =============================== */
    public function ajaxList()
    {
        ini_set('display_errors', 0);
        error_reporting(0);

        while (ob_get_level()) ob_end_clean();

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = trim($this->input->post('search')['value']);

        /* -------- Total -------- */
        $recordsTotal = $this->db
            ->where('deleted', 1)
            ->count_all_results('tt_center');

        /* -------- Main Query -------- */
        $this->db
            ->select('
                c.id,
                c.center_name,
                c.owner_user_id,
                c.approved,
                c.capacity,
                c.total_no_system,
                c.audit_status,
                c.audit_file,
                c.last_audited,
                c.reason_of_delete,
                c.last_modified_on,
                au.username,
                au.email,
                au.mobile_phone,
                co.name AS country,
                s.title AS state,
                ct.city_name AS city
            ')
            ->from('tt_center c')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->join('tt_countries co', 'co.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left')
            ->where('c.deleted', 1);

        /* 🔍 Global Search */
        if ($search !== '') {
            $this->db->group_start()
                ->like('c.center_name', $search)
                ->or_like('au.username', $search)
                ->or_like('au.email', $search)
                ->or_like('au.mobile_phone', $search)
                ->or_like('co.name', $search)
                ->or_like('s.title', $search)
                ->or_like('ct.city_name', $search)
            ->group_end();
        }

        $recordsFiltered = $this->db->count_all_results('', false);

        $this->db->order_by('c.id', 'DESC');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        $data = [];
        $sr = $start + 1;

        foreach ($query->result() as $row) {

            $approval = ($row->approved == 1)
                ? '<span class="badge bg-success mb-2">Approved</span>'
                : '<span class="badge bg-danger mb-2">Not Approved</span>';

            $audit = ($row->audit_status == 1)
                ? '<span class="badge bg-success">Completed</span>'
                : '<span class="badge bg-warning">Pending</span>';
                
            $resonOfDelete = '<p class="mt-2"><strong>Delete Reason :</strong> ' . $row->reason_of_delete ?? '--' .'</p>';
            $dateOfDelete = '<p class="mt-2"><strong>Delete Date :</strong> ' . date('Y-m-d', strtotime($row->last_modified_on)) ?? '--' .'</p>';

            $data[] = [
                'sr' => $sr++,

                'center_owner' => "
                    $approval <br>
                    <strong>{$row->center_name}</strong><br>
                    <small>Owner: {$row->username}</small><br>
                    <small>Email: {$row->email}</small><br>
                    <small>Mobile: {$row->mobile_phone}</small>
                ",

                'location' => "
                    {$row->country}<br>
                    {$row->state}<br>
                    {$row->city}
                ",

                'audit' => "
                    $audit<br>
                    <small>".($row->audit_file ? 'File Uploaded' : 'Not Uploaded')."</small>
                ",

                'action' => '
                    <button 
                        class="btn btn-sm btn-success retrieveCenter"
                        data-id="'.$row->id.'">
                        Retrieve
                    </button>
                '.$resonOfDelete.' <br> '.$dateOfDelete
            ];
        }

        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
        exit;
    }

    /* ===============================
       RETRIEVE CENTER (deleted = 0)
    =============================== */
    public function retrieveCenter()
    {
        $this->output->set_content_type('application/json');

        $id = (int) $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID']);
            exit;
        }

        $this->db->where('id', $id)
                 ->update('tt_center', ['deleted' => 0]);

        echo json_encode([
            'status'  => true,
            'message' => 'Center retrieved successfully'
        ]);
        exit;
    }
}