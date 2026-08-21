<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Dompdf\Dompdf;
use Dompdf\Options;

class CenterController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_permission('center_list');

        $this->load->database();
        $this->load->library(['session']);
        $this->load->helper(['url']);
        $this->load->library("common_options");
        $this->load->model('Common_model');
        $this->load->helper('email');
        $this->load->helper('project_status');
        $this->load->helper('project_helper');

        // Auth Guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }
    }

    /**
     * Page load
     */
    public function index()
    {
        $this->check_permission('center_list');
        $data['page_title'] = 'Center Listing';
        $data['admin']      = $this->session->userdata('admin_user');

        $data['owner_data'] = $this->Common_model->getdata_array('tt_admin_users', array('role_id' => 9));
        $data['country_data'] = $this->Common_model->getdata_array('tt_countries', '');


        // Total Centers
        $data['total_centers'] = $this->db
            ->where('deleted', 0)
            ->count_all_results('tt_center');

        // Approved Centers
        $data['approved_centers'] = $this->db
            ->where('deleted', 0)
            ->where('approved', 1)
            ->count_all_results('tt_center');

        // Pending Centers
        $data['pending_centers'] = $this->db
            ->where('deleted', 0)
            ->where('approved', 0)
            ->count_all_results('tt_center');

        // Audited Centers
        $data['audited_centers'] = $this->db
            ->where('deleted', 0)
            ->where('audit_status', 1)
            ->count_all_results('tt_center');

        // Nonudited Centers
        $data['non_audited_centers'] = $this->db
            ->where('deleted', 0)
            ->where('audit_status', 0)
            ->count_all_results('tt_center');


        // Total Systems Capacity
        $data['total_systems'] = $this->db
            ->select_sum('total_no_system')
            ->where('deleted', 0)
            ->get('tt_center')
            ->row()
            ->total_no_system ?? 0;


        // Total Covered Countries
        $data['total_countries'] = $this->db
            ->select('COUNT(DISTINCT NULLIF(TRIM(country_id), "")) AS total')
            ->where('deleted', 0)
            ->get('tt_center')
            ->row()
            ->total ?? 0;

        // Total Covered States
        $data['total_states'] = $this->db
            ->select('COUNT(DISTINCT NULLIF(TRIM(state_id), "")) AS total')
            ->where('deleted', 0)
            ->get('tt_center')
            ->row()
            ->total ?? 0;

        // Total Covered Cities
        $data['total_cities'] = $this->db
            ->select('COUNT(DISTINCT NULLIF(TRIM(city_id), "")) AS total')
            ->where('deleted', 0)
            ->get('tt_center')
            ->row()
            ->total ?? 0;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/index');
        $this->load->view('layouts/footer');
    }

    /**
     * AJAX DataTable (search + pagination + filters)
     */
    public function ajaxList()
    {
        ini_set('display_errors', 0);
        error_reporting(0);

        $this->output->enable_profiler(false);
        while (ob_get_level()) ob_end_clean();

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = trim($this->input->post('search')['value']);

        /* ===============================
           TOTAL RECORDS
        =============================== */
        $recordsTotal = $this->db
            ->where('deleted', 0)
            ->count_all_results('tt_center');

        /* ===============================
           MAIN QUERY
        =============================== */
        $this->db
            ->select('
                c.id,
                c.center_name,
                c.owner_user_id,
                c.approved,
                c.capacity,
                c.total_no_system,
                c.total_no_lab,
                c.audit_status,
                c.audit_file,
                c.last_audited,
                c.created_on,
                c.cs_name,
                c.cs_contact_number,
                c.cs_email,
                c.admin_url,
                
                au.username   AS admin_username,
                au.email      AS admin_email,
                au.mobile_phone AS admin_mobile,
                au.mpin AS admin_mpin,
                co.name AS country,
                s.title AS state,
                ct.city_name AS city
            ')
            ->from('tt_center c')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->join('tt_countries co', 'co.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left')
            ->where('c.deleted', 0);

        // 🔍 GLOBAL SEARCH
        if ($search !== '') {
            $this->db->group_start()
                ->like('c.center_name', $search)
                ->or_like('co.name', $search)
                ->or_like('s.title', $search)
                ->or_like('ct.city_name', $search)
                ->or_like('c.capacity', $search)
                ->or_like('c.total_no_system', $search)
                ->or_like('au.username', $search)
                ->or_like('au.email', $search)
                ->or_like('au.mobile_phone', $search)
                ->group_end();
        }


        /* ===============================
           CUSTOM FILTERS
        =============================== */

        $country_id     = $this->input->post('country_id');
        $state_id       = $this->input->post('state_id');
        $city_id        = $this->input->post('city_id');
        $audit_status   = $this->input->post('audit_status');
        $approve_status = $this->input->post('approve_status');
        $center_type    = $this->input->post('center_type');
        $center_owner   = $this->input->post('center_owner');

        if (!empty($country_id)) {
            $this->db->where('c.country_id', $country_id);
        }

        if (!empty($state_id)) {
            $this->db->where('c.state_id', $state_id);
        }

        if (!empty($city_id)) {
            $this->db->where('c.city_id', $city_id);
        }

        if ($audit_status !== '' && $audit_status !== null) {
            $this->db->where('c.audit_status', $audit_status);
        }

        if ($approve_status !== '' && $approve_status !== null) {
            $this->db->where('c.approved', $approve_status);
        }

        if (!empty($center_type)) {
            $this->db->where('c.center_type', $center_type);
        }

        if (!empty($center_owner)) {
            $this->db->where('c.owner_user_id', $center_owner);
        }

        // 🔢 Filtered count
        $recordsFiltered = $this->db->count_all_results('', false);

        // Pagination
        $this->db->order_by('c.id', 'DESC');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        $data = [];
        $sr = $start + 1;

        foreach ($query->result() as $row) {

            $owner = ($row->owner_user_id == 1) ? 'BMTC Uploaded' : 'Registered';
            $approval = ($row->approved == 1)
                ? '<span class="badge bg-success">Approved</span>'
                : '<span class="badge bg-danger">Not Approved</span>';

            $created_on = !empty($row->created_on)
                ? date('d M Y', strtotime($row->created_on))
                : '--';

            $auditStatus = ($row->audit_status == 1)
                ? '<span class="badge bg-success">Completed</span>'
                : '<span class="badge bg-warning">Pending</span>';

            $auditFile = ($row->audit_status == 1)
                ? (!empty($row->audit_file) ? '<a href="' . base_url() . 'uploads/center_audit_file/' . $row->audit_file . '" target="_blank"><i class="fa fa-file-pdf"></i> View File</a>' : 'Not Uploaded Yet')
                : '--';

            $auditDate = !empty($row->last_audited)
                ? date('d M Y', strtotime($row->last_audited))
                : '--';


            $userName = $row->admin_url == '' ? $row->cs_name : $row->admin_username;
            $userEmail = $row->admin_url == '' ? $row->cs_email : $row->admin_email;
            $userPhone = $row->admin_url == '' ? $row->cs_contact_number : $row->admin_mobile;
            $userMpin = $row->admin_mpin;


            $data[] = [

                'center' => "
                    <strong>{$row->center_name}</strong><br>
                    <small>Owner Name: {$userName}</small><br>
                    <small>Owner Email: {$userEmail}</small><br>
                    <small>Owner Mobile: {$userPhone}</small><br>
                    <small>Owner MPIN: {$userMpin}</small><br>
                    <small>Total Systems: {$row->total_no_lab}/{$row->total_no_system}</small>
                ",

                'location' =>
                "<strong>$owner</strong>
                            <br>$approval
                            <br><small><strong>Created:</strong> $created_on</small>
                            <br><small><strong>Country:</strong> {$row->country}</small>
                            <br><small><strong>State:</strong> {$row->state}</small>
                            <br><small><strong>City:</strong> {$row->city}</small>",

                'audit' => "
                    $auditStatus<br>
                    <small>Audit File: $auditFile</small><br>
                    <small>Audited: $auditDate</small><br>

                    <button
                        class='btn btn-sm btn-info mt-1 btnAssignedManpower'
                        data-center='" . $row->id . "'>
                        <i class='fa fa-users'></i> Assigned Manpower
                    </button>
                ",

                'action' => '

                    <div class="d-flex gap-2 flex-wrap">

                        <!-- PRIMARY -->
                        <a target="_blank" 
                           href="' . base_url('admin/view-exam-center/' . $row->id) . '" 
                           class="btn btn-sm btn-info">
                           View
                        </a>

                        <!-- STATUS -->
                        <a href="javascript:void(0);" 
                           class="btn btn-sm toggleApprovalBtn ' . ($row->approved == 1 ? 'btn-success' : 'btn-warning') . '" 
                           data-id="' . $row->id . '" 
                           data-status="' . $row->approved . '">
                           ' . ($row->approved == 1 ? 'Approved' : 'Pending') . '
                        </a>

                        <!-- ACTION DROPDOWN -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-dark dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown">
                                Actions
                            </button>

                            <ul class="dropdown-menu">

                                <li>
                                    <a class="dropdown-item deleteCenterBtn" href="javascript:void(0)" data-id="' . $row->id . '">
                                        🗑 Delete Center
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item openAuditModal" href="javascript:void(0)" data-id="' . $row->id . '">
                                        📄 Audit File
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="' . base_url('admin/center-calendar/' . $row->id) . '" target="_blank">
                                        📅 Calendar
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" target="_blank"
                                       href="' . base_url('admin/center-logs/' . $row->id) . '">
                                        📜 View Logs
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <a class="dropdown-item" target="_blank"
                                       href="' . base_url('admin/export-center-pdf/' . $row->id) . '">
                                        📥 Export Normal PDF
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" target="_blank"
                                       href="' . base_url('admin/export-center-pdf/' . $row->id . '?type=audit') . '">
                                        📥 Export Audit PDF
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <!-- CENTER HISTORY -->
                        <a target="_blank" 
                           href="' . base_url('admin/view-exam-center-history/' . $row->id) . '" 
                           class="btn btn-sm btn-success">
                           History
                        </a>

                    </div>
                    '
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


    /**
     * Custom Export (CSV / Excel ready)
     */
    public function export()
    {
        $type = $this->input->get('type');

        if ($type == 'labs') {
            $this->exportWithLabs();
        } elseif ($type == 'custom') {
            $this->exportCustom();
        } else {
            $this->exportWithAll();
        }
    }

    // Filters
    private function applyFilters()
    {
        $country_id     = $this->input->get('country_id');
        $state_id       = $this->input->get('state_id');
        $city_id        = $this->input->get('city_id');
        $audit_status   = $this->input->get('audit_status');
        $approve_status = $this->input->get('approve_status');
        $center_type    = $this->input->get('center_type');
        $center_owner   = $this->input->get('center_owner');

        if ($country_id !== '') {
            $this->db->where('c.country_id', $country_id);
        }

        if ($state_id !== '') {
            $this->db->where('c.state_id', $state_id);
        }

        if ($city_id !== '') {
            $this->db->where('c.city_id', $city_id);
        }

        if ($audit_status !== '') {
            $this->db->where('c.audit_status', $audit_status);
        }

        if ($approve_status !== '') {
            $this->db->where('c.approved', $approve_status);
        }

        if ($center_type !== '') {
            $this->db->where('c.type', $center_type);
        }

        if ($center_owner !== '') {
            $this->db->where('c.owner_user_id', $center_owner);
        }
    }

    // Apply Search Filter
    private function applySearch()
    {
        $search = trim($this->input->get('search'));

        if (!empty($search)) {

            $this->db->group_start()
                ->like('c.center_name', $search)
                ->or_like('co.name', $search)
                ->or_like('s.title', $search)
                ->or_like('ct.city_name', $search)
                ->or_like('c.capacity', $search)
                ->or_like('c.total_no_system', $search)
                ->or_like('au.username', $search)
                ->or_like('au.email', $search)
                ->or_like('au.mobile_phone', $search)
                ->group_end();
        }
    }


    // With all
    private function exportWithAll()
    {
        $this->db
            ->select('
                c.*,
                co.name as country_name,
                s.title as state_name,
                ct.city_name,
                au.username as owner_name
            ')
            ->from('tt_center c')
            ->join('tt_countries co', 'co.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->where('c.deleted', 0);

        // APPLY FILTERS
        $this->applyFilters();
        $this->applySearch();

        $rows = $this->db->order_by('c.id', 'DESC')->get()->result_array();

        $this->generateExcel($rows, 'center_all_export');
    }

    // With custom fields
    private function exportCustom()
    {
        $this->db
            ->select('
                c.id,
                c.center_name,
                ct.city_name,
                s.title as state_name,
                co.name as country_name,
                au.username,
                au.email,
                au.mobile_phone,
                c.approved,
                c.capacity,
                c.total_no_system,
                c.audit_status
            ')
            ->from('tt_center c')
            ->join('tt_countries co', 'co.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->where('c.deleted', 0);

        // APPLY FILTERS
        $this->applyFilters();
        $this->applySearch();

        $rows = $this->db->order_by('c.id', 'DESC')->get()->result_array();

        $this->generateExcel($rows, 'center_custom_export');
    }

    // With labs
    private function exportWithLabs()
    {
        $this->db
            ->select('
                c.id,
                c.center_id,
                c.center_name,
                ct.city_name,
                s.title as state_name,
                co.name as country_name,
                au.username as owner_name,
                au.email,
                au.mobile_phone,
                c.approved,
                c.capacity,
                c.total_no_system,
                c.audit_status,

                l.floor_name,
                l.no_of_computer,
                l.no_of_ac,
                l.monitor_type,
                l.operating_system,
                l.ram,
                l.hard_disk,
                l.no_of_port_eth_switch,
                l.ehternet_swtch_company,
                l.switch_category,
                l.window_generation,
                l.ethernet_company_other
            ')
            ->from('tt_center c')

            // UPDATED LAB TABLE
            ->join('tt_lab l', 'l.center_id = c.id', 'left')

            ->join('tt_countries co', 'co.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')

            ->where('c.deleted', 0);

        // APPLY FILTERS
        $this->applyFilters();
        $this->applySearch();

        $rows = $this->db->order_by('c.id', 'DESC')->get()->result_array();

        $this->generateExcel($rows, 'center_with_labs');
    }

    // Generate Excel common
    private function generateExcel($rows, $filenamePrefix)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($rows)) {

            // HEADER
            $col = 'A';
            foreach (array_keys($rows[0]) as $header) {

                $sheet->setCellValue($col . '1', ucfirst(str_replace('_', ' ', $header)));
                $sheet->getStyle($col . '1')->getFont()->setBold(true);
                $sheet->getColumnDimension($col)->setAutoSize(true);

                $col++;
            }

            // DATA
            $rowNumber = 2;

            foreach ($rows as $row) {

                $row['approved'] = ($row['approved'] == 1) ? 'Approved' : 'Not Approved';
                $row['audit_status'] = ($row['audit_status'] == 1) ? 'Completed' : 'Pending';

                $col = 'A';

                foreach ($row as $value) {

                    $sheet->setCellValue($col . $rowNumber, $value);

                    $sheet->getStyle($col . $rowNumber)
                        ->getAlignment()
                        ->setWrapText(true);

                    $col++;
                }

                $rowNumber++;
            }
        }

        $sheet->freezePane('A2');

        $filename = $filenamePrefix . '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // Edit profile request list
    public function getCenterEditRequests()
    {
        $this->check_permission('center_edit_request');

        $data['page_title'] = 'Center Profile Edit Request';
        $data['admin']      = $this->session->userdata('admin_user');
        $data['centerData'] = $this->Common_model->getdata_array('tt_center', '');

        // Total Pending Requests
        $data['total_requests'] = $this->db
            ->where('status', 'pending')
            ->where('is_active', 1)
            ->count_all_results('profile_edit_requests');

        // Filter
        $centerId = $this->input->get('center_id');

        $this->db
            ->select('
            r.*,
            c.center_name,
            c.capacity as seats,
            c.total_no_system,
            c.total_no_lab,
            u.username as owner_name,
            u.email as owner_email,
            u.mobile_phone as owner_phone,
            co.name AS country,
            s.title AS state,
            city.city_name
        ')
            ->from('profile_edit_requests r')
            ->join('tt_center c', 'c.id = r.center_id')
            ->join('tt_admin_users u', 'u.id = r.owner_user_id')
            ->join('tt_countries co', 'co.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master city', 'city.city_id = c.city_id', 'left')
            ->where('r.status', 'pending')
            ->where('r.is_active', 1);

        if (!empty($centerId)) {
            $this->db->where('r.center_id', $centerId);
        }

        $data['result'] = $this->db
            ->order_by('r.requested_at', 'DESC')
            ->get()
            ->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/center-profile-edit-request', $data);
        $this->load->view('layouts/footer');
    }

    // Approve edit request
    public function approveCenterEdit($requestId)
    {
        // Get request
        $request = $this->db
            ->where('id', $requestId)
            ->where('status', 'pending')
            ->get('profile_edit_requests')
            ->row();

        if (empty($request)) {
            $this->session->set_flashdata('error', 'Invalid or already processed request.');
            redirect('admin/center-edit-request');
        }

        // Approve request
        $this->db->where('id', $requestId)->update(
            'profile_edit_requests',
            [
                'status'        => 'approved',
                'is_active'     => 0,
                'admin_user_id' => $this->session->userdata('admin_user')['id'],
                'action_at'     => date('Y-m-d H:i:s')
            ]
        );


        // Give edit permission (insert or update)
        $permission = $this->db
            ->where('center_id', $request->center_id)
            ->get('center_edit_permissions')
            ->row();

        if ($permission) {
            $this->db->where('center_id', $request->center_id)->update(
                'center_edit_permissions',
                [
                    'is_edit_allowed' => 1,
                    'granted_by'      => $this->session->userdata('admin_user')['id'],
                    'granted_at'      => date('Y-m-d H:i:s')
                ]
            );
        } else {
            $this->db->insert('center_edit_permissions', [
                'center_id'       => $request->center_id,
                'is_edit_allowed' => 1,
                'granted_by'      => $this->session->userdata('admin_user')['id'],
                'granted_at'      => date('Y-m-d H:i:s')
            ]);
        }


        // Fetch center + owner details
        $this->db->select('c.center_name, c.address, au.email, au.mobile_phone');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
        $this->db->where('c.center_id', $request->center_id);
        $centerData = $this->db->get()->row();

        $owner_email  = $centerData->email;
        $owner_mobile = $centerData->mobile_phone;
        $center_name  = $centerData->center_name;
        $address      = $centerData->address;


        $email_subject = "Profile Edit Request Approved – " . $center_name;


        $email_content = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color:#333; }
                    .header { color: #2c3e50; }
                    .content { margin: 20px 0; }
                    .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom:15px; }
                    .highlight { background: #e8f5e9; padding: 15px; border-left: 4px solid #28a745; margin: 15px 0; }
                    .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background: #3498db;
                        color: #fff !important;
                        text-decoration: none;
                        border-radius: 5px;
                        margin-top: 10px;
                    }
                </style>
            </head>
            <body>

                <h2 class="header">Profile Edit Request Approved</h2>
                
                <div class="content">
                    <p>Dear ' . htmlspecialchars($center_name) . ' Team,</p>
                    
                    <p>
                        We are pleased to inform you that your profile edit request has been 
                        reviewed and approved by the Admin team.
                    </p>

                    <div class="highlight">
                        <strong>Edit Access Granted.</strong><br>
                        You may now login to your center dashboard and update your profile details.
                    </div>

                    <div class="details">
                        <h3>Center Information:</h3>
                        <p><strong>Center Name:</strong> ' . htmlspecialchars($center_name) . '</p>
                        <p><strong>Registered Email:</strong> ' . htmlspecialchars($owner_email) . '</p>
                        <p><strong>Contact Number:</strong> ' . htmlspecialchars($owner_mobile) . '</p>
                        <p><strong>Address:</strong> ' . htmlspecialchars($address) . '</p>
                    </div>

                    <p>
                        Please ensure that all updated information is accurate and complete.
                    </p>

                    <p>
                        If you face any issues, feel free to contact the Admin team.
                    </p>

                    <div class="footer">
                        Regards,<br>
                        <strong>Testpan India Team</strong><br>
                        BookMyTestCenter
                    </div>
                </div>

            </body>
            </html>
            ';

        $send = send_email(
            $email_content,
            $email_subject,
            $owner_email,
            "centerbooking@bookmytestcenter.com"
        );

        // Flash message (Toastr)
        $this->session->set_flashdata('success', 'Center profile edit request approved successfully.');

        redirect('admin/center-edit-request');
    }


    // Reject edit request
    public function rejectCenterEdit($requestId)
    {
        $request = $this->db
            ->where('id', $requestId)
            ->where('status', 'pending')
            ->get('profile_edit_requests')
            ->row();

        if (empty($request)) {
            $this->session->set_flashdata('error', 'Invalid or already processed request.');
            redirect('admin/center-edit-request');
        }

        $this->db->where('id', $requestId)->update(
            'profile_edit_requests',
            [
                'status'        => 'rejected',
                'is_active'     => 0,
                'admin_user_id' => $this->session->userdata('admin_user')['id'],
                'action_at'     => date('Y-m-d H:i:s')
            ]
        );


        $this->session->set_flashdata('success', 'Center profile edit request rejected.');

        redirect('admin/center-edit-request');
    }

    // View center details
    public function viewExamCenter($centerId = null)
    {
        // Fetch Center Details with State & City
        $this->db->select('
            c.*, 
            au.username,
            au.email as useremail,
            au.mobile_phone as userphone,
            con.name as country_name,
            s.title as state_name,
            cm.city_name,

            sp.name AS package_name,
            sp.max_centers,
            sp.max_bookings,
            sp.verified_badge,
            sp.support_type,
            sp.duration,
            sp.duration_type,
            us.expiry_date,
            us.is_active
        ');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
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
        $this->db->join('tt_countries con', 'con.id = c.country_id', 'left');
        $this->db->join('tt_states s', 's.id = c.state_id', 'left');
        $this->db->join('tt_city_master cm', 'cm.city_id = c.city_id', 'left');
        $this->db->where('c.center_id', $centerId);
        $this->db->where('c.deleted', 0);

        $center = $this->db->get()->row();

        if (!$center) {
            show_404();
        }

        // Fetch Documents
        $documents = $this->db
            ->where('center_id', $centerId)
            ->where('deleted', 0)
            ->get('tt_center_document')
            ->result();

        // Fetch Images
        $images = $this->db
            ->where('center_id', $centerId)
            ->where('deleted', 0)
            ->get('tt_center_images')
            ->result();


        // Fetch labs
        $labs = $this->db
            ->where('center_id', $centerId)
            ->where('deleted', 0)
            ->get('tt_lab')
            ->result();

        // Fetch video
        $video = $this->db
            ->where('center_id', $centerId)
            ->where('deleted', 0)
            ->get('tt_center_video')
            ->result();

        $data['center']     = $center;
        $data['documents']  = $documents;
        $data['labs']       = $labs;
        $data['video']       = $video;
        $data['images']     = $images;
        $data['page_title'] = "Exam Center Detail : " . ucwords($center->center_name);
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/view-exam-center-detail', $data);
        $this->load->view('layouts/footer');
    }


    // View center history
    public function viewExamCenterHistory($centerId = null)
    {

        $year       = $this->input->get('year');
        $month      = $this->input->get('month');
        $dateRange  = $this->input->get('daterange');

        $fromDate = '';
        $toDate   = '';

        if (!empty($dateRange)) {

            $dates = explode(' - ', $dateRange);

            if (count($dates) == 2) {
                $fromDate = date('Y-m-d', strtotime($dates[0]));
                $toDate   = date('Y-m-d', strtotime($dates[1]));
            }
        }

        // Fetch Center Details with State & City
        $this->db->select('
            c.*, 
            au.username,
            au.email as useremail,
            au.mobile_phone as userphone,
            con.name as country_name,
            s.title as state_name,
            cm.city_name
        ');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
        $this->db->join('tt_countries con', 'con.id = c.country_id', 'left');
        $this->db->join('tt_states s', 's.id = c.state_id', 'left');
        $this->db->join('tt_city_master cm', 'cm.city_id = c.city_id', 'left');
        $this->db->where('c.center_id', $centerId);
        $this->db->where('c.deleted', 0);

        $center = $this->db->get()->row();

        if (!$center) {
            show_404();
        }

        $data['center']     = $center;

        // ================= CENTER OVERVIEW =================

        // Total Project Requests
        $this->db->where('center_id', $centerId);

        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);

        $data['center_stats']['total_projects'] = $this->db
            ->count_all_results('tt_send_booking_request');


        // Approved Projects
        $this->db->where('center_id', $centerId);
        $this->db->where('admin_status', 1);

        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);

        $data['center_stats']['approved_projects'] = $this->db
            ->count_all_results('tt_send_booking_request');


        // Rejected Projects
        $this->db->where('center_id', $centerId);
        $this->db->where('admin_status', 2);

        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);

        $data['center_stats']['rejected_projects'] = $this->db
            ->count_all_results('tt_send_booking_request');


        // Hold Projects
        $this->db->where('center_id', $centerId);
        $this->db->where('admin_status', 3);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $data['booking_summary']['hold'] = $this->db
            ->count_all_results('tt_send_booking_request');


        // Total Seats Delivered
        $totalSeatsDelivered = 0;

        $approvedBookings = $this->db
            ->select('sbr.project_id,sbr.center_seat,pd.number_of_seats')
            ->from('tt_send_booking_request sbr')
            ->join('tt_project_detail pd', 'pd.project_id = sbr.project_id', 'left')
            ->where('sbr.center_id', $centerId)
            ->where('sbr.admin_status', 1)
            ->where('sbr.exam_center_status', 1)
            ->where('sbr.client_status', 1);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $approvedBookings = $this->db
            ->get()
            ->result();

        foreach ($approvedBookings as $booking) {
            $totalSeatsDelivered += min(
                (int)$booking->center_seat,
                (int)$booking->number_of_seats
            );
        }

        $data['center_stats']['total_seats'] = $totalSeatsDelivered;

        // ================= BOOKING STATUS SUMMARY =================

        $data['booking_summary'] = [];

        // Total Requests
        $this->db->where('center_id', $centerId);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $data['booking_summary']['total_requests'] = $this->db
            ->count_all_results('tt_send_booking_request');

        // Approved
        $this->db->where('center_id', $centerId);
        $this->db->where('exam_center_status', 1);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $data['booking_summary']['approved'] = $this->db
            ->count_all_results('tt_send_booking_request');

        // Pending
        $this->db->where('center_id', $centerId);
        $this->db->where('exam_center_status', 0);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $data['booking_summary']['pending'] = $this->db
            ->count_all_results('tt_send_booking_request');

        // Rejected
        $this->db->where('center_id', $centerId);
        $this->db->where('exam_center_status', 2);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $data['booking_summary']['rejected'] = $this->db
            ->count_all_results('tt_send_booking_request');



        // Negotiation
        $this->db->where('center_id', $centerId);
        $this->db->where('exam_center_status', 3);
        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);
        $data['booking_summary']['negotiation'] = $this->db
            ->count_all_results('tt_send_booking_request');

        // ================= PROJECT BOOKING HISTORY =================

        $this->db
            ->select("
                sbr.*,

                pd.exam_name,
                pd.start_date,
                pd.end_date,
                pd.status,
                pd.project_remark,

                tc.company_name,
                cm.city_name,
            ")
            ->from('tt_send_booking_request sbr')

            ->join(
                'tt_project_detail pd',
                'pd.project_id = sbr.project_id
                AND pd.exam_city_id = sbr.city_id',
                'left'
            )

            ->join(
                'tt_client tc',
                'tc.ac_id = sbr.client_id',
                'left'
            )

            ->join('tt_city_master cm', 'cm.city_id = sbr.city_id', 'left')

            ->where('sbr.center_id', $centerId);

        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);

        $this->db->order_by('sbr.created_at', 'DESC');


        $data['project_history'] = $this->db->get()->result();


        // ================= REVENUE ANALYTICS =================

        // Total Seats Delivered
        $data['revenue_stats']['total_seats'] = $data['center_stats']['total_seats'];


        // Total Revenue
        // ================= REVENUE ANALYTICS =================

        // Total Seats Delivered
        $data['revenue_stats']['total_seats'] = $data['center_stats']['total_seats'];


        // Total Revenue
        $this->db
            ->select("
        SUM(
            IFNULL(sbr.center_seat, 0) *
            IFNULL(
                sbr.admin_center_final_price,
                pd.admin_price_per_seat
            )
        ) AS total_revenue
    ")
            ->from('tt_send_booking_request sbr')
            ->join(
                'tt_project_detail pd',
                'pd.project_id = sbr.project_id
         AND pd.exam_city_id = sbr.city_id',
                'left'
            )
            ->where('sbr.center_id', $centerId)
            ->where('sbr.admin_status', 1);

        $this->applyHistoryFilters(
            $year,
            $month,
            $fromDate,
            $toDate,
            'sbr.created_at'
        );

        $revenue = $this->db->get()->row();

        $data['revenue_stats']['total_revenue'] =
            $revenue->total_revenue ?? 0;


        // Highest Booking
        $this->db
            ->select("
        MAX(
            LEAST(
                IFNULL(sbr.center_seat, 0),
                IFNULL(pd.number_of_seats, 0)
            )
        ) AS highest_booking
    ")
            ->from('tt_send_booking_request sbr')
            ->join(
                'tt_project_detail pd',
                'pd.project_id = sbr.project_id
         AND pd.exam_city_id = sbr.city_id',
                'left'
            )
            ->where('sbr.center_id', $centerId);

        $this->applyHistoryFilters(
            $year,
            $month,
            $fromDate,
            $toDate,
            'sbr.created_at'
        );

        $highest = $this->db->get()->row();

        $data['revenue_stats']['highest_booking'] =
            $highest->highest_booking ?? 0;


        // Latest Booking
        $this->db->select('created_at');
        $this->db->from('tt_send_booking_request');
        $this->db->where('center_id', $centerId);

        $this->applyHistoryFilters($year, $month, $fromDate, $toDate);

        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $latest = $this->db->get()->row();

        $data['revenue_stats']['latest_booking'] = $latest->created_at ?? null;


        // Avg Price Per Seat

        if (
            $data['revenue_stats']['total_seats'] > 0
        ) {
            $data['revenue_stats']['avg_price']
                =
                round(
                    $data['revenue_stats']['total_revenue']
                        /
                        $data['revenue_stats']['total_seats']
                );
        } else {
            $data['revenue_stats']['avg_price'] = 0;
        }


        $data['years'] = $this->db
            ->select("YEAR(created_at) as year")
            ->where('center_id', $centerId)
            ->distinct()
            ->order_by('year', 'DESC')
            ->get('tt_send_booking_request')
            ->result();

        $data['months'] = [

            1 => "January",
            2 => "February",
            3 => "March",
            4 => "April",
            5 => "May",
            6 => "June",
            7 => "July",
            8 => "August",
            9 => "September",
            10 => "October",
            11 => "November",
            12 => "December"

        ];

        $data['page_title'] = "Exam Center History : " . ucwords($center->center_name);
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/view-exam-center-history', $data);
        $this->load->view('layouts/footer');
    }


    private function applyHistoryFilters($year = '', $month = '', $fromDate = '', $toDate = '', $column = 'created_at')
    {
        if (!empty($year)) {
            $this->db->where("YEAR($column)", $year);
        }

        if (!empty($month)) {
            $this->db->where("MONTH($column)", $month);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $this->db->where("DATE($column) >=", $fromDate);
            $this->db->where("DATE($column) <=", $toDate);
        }
    }

    // Self Booking
    public function centerSelfBookingList($centerId)
    {
        $data['booking_data'] = $this->Common_model->get_bookings_with_center($centerId);
        $data['center_info'] = $this->Common_model->get_center_info($centerId);

        $data['page_title'] = 'Center Self Booking Listing';
        $data['admin']      = $this->session->userdata('admin_user');
        $data['center_id']  = $centerId;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/self_booking/index');
        $this->load->view('layouts/footer');
    }

    // Self Booking Load via ajax
    public function selfBookingAjaxList()
    {
        $this->output->set_content_type('application/json');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'];
        $center_id = $this->input->post('center_id');

        // Base Query
        $this->db->from('tt_self_bookings');
        $this->db->where('center_id', $center_id);

        // Global Search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('client_name', $search);
            $this->db->or_like('client_email', $search);
            $this->db->or_like('client_phone', $search);
            $this->db->or_like('exam_name', $search);
            $this->db->or_like('exam_type', $search);
            $this->db->group_end();
        }

        // Count after filter
        $recordsFiltered = $this->db->count_all_results('', false);

        // Pagination
        $this->db->limit($length, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();

        // Total Records
        $recordsTotal = $this->db
            ->where('center_id', $center_id)
            ->count_all_results('tt_self_bookings');

        $data = [];

        foreach ($query->result() as $row) {

            // Client Info
            $client_info = '
                <strong>' . htmlspecialchars($row->client_name) . '</strong><br>
                <small>' . htmlspecialchars($row->client_email) . '</small><br>
                <small>' . htmlspecialchars($row->client_phone) . '</small>
            ';

            // Exam Info
            $exam_info = '
                <strong>' . htmlspecialchars($row->exam_name) . '</strong><br>
                <small>Type: ' . htmlspecialchars($row->exam_type) . '</small>
            ';

            // Exam Date
            $exam_date = date('d M Y', strtotime($row->start_date))
                . ' - ' .
                date('d M Y', strtotime($row->end_date));

            // Action
            $action = '
                <a target="_blank" href="' . base_url('admin/center-self-booking/view/' . $row->id) . '" 
                   class="btn btn-sm btn-primary">
                    View
                </a>
            ';

            $data[] = [
                'client_info'   => $client_info,
                'exam_info'     => $exam_info,
                'exam_location' => htmlspecialchars($row->exam_location ?? '--'),
                'exam_date'     => $exam_date,
                'seats_booked'  => '<span class="badge bg-label-primary">' . $row->seats_booked . '</span>',
                'action'        => $action
            ];
        }

        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
    }

    // View Center Self Booking
    public function viewCenterSelfBookingList($id)
    {
        $data['booking'] = $this->Common_model->get_self_booking_detail($id);

        $data['page_title'] = 'Center Self Booking Detail';
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/self_booking/self-booking-detail', $data);
        $this->load->view('layouts/footer');
    }

    // Delete Center
    public function deleteCenter()
    {
        $this->check_permission('deleted_center');
        $this->output->set_content_type('application/json');

        $center_id = $this->input->post('center_id');
        $reason    = trim($this->input->post('reason'));

        if (empty($center_id) || !is_numeric($center_id)) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Invalid Center ID.'
            ]);
            return;
        }

        if (empty($reason)) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Reason for deletion is required.'
            ]);
            return;
        }

        // 🔒 Booking Protection
        if ($this->Common_model->has_any_booking($center_id)) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Center cannot be deleted. Bookings exist.'
            ]);
            return;
        }

        // Soft Delete Center
        $update_data = [
            'deleted' => 1,
            'reason_of_delete' => $reason,
            'last_modified_on' => date('Y-m-d H:i:s')
        ];

        $this->db->where('center_id', $center_id);
        $center_deleted = $this->db->update('tt_center', $update_data);

        if ($center_deleted) {
            echo json_encode([
                'status' => 'pass',
                'message' => 'Center deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    // Status change
    public function toggleApprovalStatus()
    {
        $this->output->set_content_type('application/json');

        $center_id = $this->input->post('center_id');
        $status    = $this->input->post('status');

        if (empty($center_id) || !is_numeric($center_id)) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Invalid center ID.'
            ]);
            return;
        }

        if (!in_array($status, [0, 1])) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Invalid approval status.'
            ]);
            return;
        }

        // Update approval status
        $this->db->where('id', $center_id);
        $updated = $this->db->update('tt_center', [
            'approved' => $status,
            'last_modified_on' => date('Y-m-d H:i:s')
        ]);

        if (!$updated) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Failed to update status.'
            ]);
            return;
        }

        // 🔥 If Approved → Send Email
        if ($status == 1) {

            $this->db->select('
                c.center_name,
                c.center_id,
                c.owner_user_id,
                c.address,
                c.pin_code,
                ci.city_name,
                a.email,
                a.username,
            ');
            $this->db->from('tt_center c');
            $this->db->join('tt_admin_users a', 'a.id = c.owner_user_id', 'left');
            $this->db->join('tt_city_master ci', 'ci.city_id = c.city_id', 'left');
            $this->db->where('c.id', $center_id);
            $center = $this->db->get()->row();

            if ($center) {

                $full_address = implode(', ', array_filter([
                    $center->address,
                    $center->city_name,
                    $center->pin_code
                ]));

                $subject = "Your Exam Center Registration Has Been Approved - " . $center->center_name;

                $content = "
                    <h3>Exam Center Approval Notification</h3>
                    <p>Dear {$center->username},</p>
                    <p>Your exam center has been approved.</p>
                    <p><strong>Center Name:</strong> {$center->center_name}</p>
                    <p><strong>Address:</strong> {$full_address}</p>
                ";

                $send = send_email(
                    $content,
                    $subject,
                    $center->email,
                    "centerbooking@bookmytestcenter.com"
                );


                // Notification title & message
                $notification_title = 'Center Approved';

                $notification_message = 'Your center has been approved successfully. Now you can access you center dashboard';


                // Prepare notification data (FOR CENTER)
                $notification_data = [
                    'admin_user_id' => $center->owner_user_id,
                    'center_id'     => $center_id,
                    'client_id'     => null,
                    'title'         => $notification_title,
                    'message'       => $notification_message,
                    'type'          => 'center',
                    'is_read'       => 0,
                    'is_remove'     => 0,
                    'created_at'    => date('Y-m-d H:i:s')
                ];

                // Insert notification
                $this->db->insert('notifications', $notification_data);
            }
        }

        echo json_encode([
            'status' => 'pass',
            'message' => $status == 1
                ? 'Center Approved Successfully.'
                : 'Center Pending Successfully.'
        ]);
    }

    // Upload audit file
    public function uploadAuditFile()
    {
        $this->output->set_content_type('application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Invalid request.'
            ]);
            return;
        }

        $center_id    = $this->input->post('center_id');
        $audit_status = $this->input->post('audit_status');

        if (empty($center_id) || !is_numeric($center_id)) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Invalid center ID.'
            ]);
            return;
        }

        if (!in_array($audit_status, ['0', '1'])) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Please select audit status.'
            ]);
            return;
        }

        // Check File
        if (empty($_FILES['audit_file']['name'])) {
            echo json_encode([
                'status' => 'fail',
                'message' => 'Audit file is required.'
            ]);
            return;
        }

        // Upload Config
        $upload_path = FCPATH . 'uploads/center_audit_file/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 4096;
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('audit_file')) {
            echo json_encode([
                'status' => 'fail',
                'message' => strip_tags($this->upload->display_errors())
            ]);
            return;
        }

        $upload_data = $this->upload->data();

        $update_data = [
            'audit_status' => $audit_status,
            'audit_file'   => $upload_data['file_name'],
            'last_audited' => date('Y-m-d H:i:s'),
            'approved'     => $audit_status == 1 ? 1 : 0
        ];

        $this->db->where('id', $center_id);
        $updated = $this->db->update('tt_center', $update_data);

        if ($updated) {
            echo json_encode([
                'status' => 'pass',
                'message' => 'Audit data updated successfully.'
            ]);
        } else {

            @unlink($upload_path . $upload_data['file_name']);

            echo json_encode([
                'status' => 'fail',
                'message' => 'Failed to update audit data.'
            ]);
        }
    }


    // Get States
    public function getStates()
    {
        $country_id = $this->input->post('country_id');

        if (empty($country_id)) {
            echo json_encode([]);
            return;
        }

        $states = $this->db
            ->where('country_id', $country_id)
            ->order_by('title', 'ASC')
            ->get('tt_states')
            ->result_array();

        echo json_encode($states);
    }


    // Get Cities
    public function getCities()
    {
        $state_id = $this->input->post('state_id');

        if (empty($state_id)) {
            echo json_encode([]);
            return;
        }

        $cities = $this->db
            ->where('state_id', $state_id)
            ->order_by('city_name', 'ASC')
            ->get('tt_city_master')
            ->result_array();

        echo json_encode($cities);
    }


    // Export a center to PDF
    public function exportCenterPdf($center_id)
    {
        $this->load->library('pdf');

        $type = $this->input->get('type');

        // CENTER DATA
        $this->db->select('
            c.*,
            au.username as owner_name,
            au.email as owner_email,
            au.mobile_phone as owner_mobile,
            co.name as country,
            s.title as state,
            ct.city_name as city
        ');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
        $this->db->join('tt_countries co', 'co.id = c.country_id', 'left');
        $this->db->join('tt_states s', 's.id = c.state_id', 'left');
        $this->db->join('tt_city_master ct', 'ct.city_id = c.city_id', 'left');
        $this->db->where('c.id', $center_id);

        $center = $this->db->get()->row();

        // LABS
        $labs = $this->db->get_where('tt_lab', [
            'center_id' => $center_id
        ])->result_array();

        $fileName = $type == 'audit' ? 'center_audit_pdf' : 'center_pdf';

        // VIEW LOAD
        $html = $this->load->view('dashboard/center/pdf/' . $fileName, [
            'center' => $center,
            'labs'   => $labs,
            'type'   => $type
        ], true);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();

        $this->pdf->stream("center_audit.pdf", ["Attachment" => 0]);
    }

    // Download bulk images
    public function downloadCenterImages($centerId)
    {
        ini_set('memory_limit', '512M');

        $center = $this->db
            ->where('center_id', $centerId)
            ->where('deleted', 0)
            ->get('tt_center')
            ->row();

        if (!$center) {
            show_404();
        }

        $images = $this->db
            ->where('center_id', $centerId)
            ->where('deleted', 0)
            ->get('tt_center_images')
            ->result();

        $folder_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $center->center_name);

        // ZIP PATH
        $zip_path = FCPATH . 'uploads/' . $folder_name . '.zip';

        // Remove old zip
        if (file_exists($zip_path)) {
            unlink($zip_path);
        }

        $zip = new ZipArchive();

        if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            die('Cannot create zip');
        }

        $base_url = CENTER_URL . '/';

        // ================= LOGO =================
        if (!empty($center->logo)) {

            // logo already contains uploads/...
            $logo_url = $base_url . $center->logo;

            $data = @file_get_contents($logo_url);

            if ($data !== false) {

                $zip->addFromString(
                    $folder_name . '/Center_Logo/' . basename($center->logo),
                    $data
                );
            }
        }

        // ================= IMAGES =================
        foreach ($images as $img) {

            if (empty($img->center_image)) {
                continue;
            }

            // center_image already contains uploads/...
            $img_url = $base_url . $img->center_image;

            $data = @file_get_contents($img_url);

            if ($data !== false) {

                $type_folder = ucfirst(str_replace('_', ' ', $img->image_type));

                $zip->addFromString(
                    $folder_name . '/' . $type_folder . '/' . basename($img->center_image),
                    $data
                );
            }
        }

        $zip->close();

        // ================= DOWNLOAD =================
        if (!file_exists($zip_path)) {
            die('Zip file not generated');
        }

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zip_path) . '"');
        header('Content-Length: ' . filesize($zip_path));

        readfile($zip_path);

        unlink($zip_path);

        exit;
    }


    // Center logs
    public function centerLogs($center_id)
    {
        $this->check_permission('center_list');

        $data['page_title'] = 'Center Change Logs';
        $data['admin']      = $this->session->userdata('admin_user');

        // Center Info (optional for header)
        $data['center'] = $this->Common_model->getdata('tt_center', [
            'center_id' => $center_id
        ]);

        // Logs Data
        $this->db->select('l.*, a.username as admin_name');
        $this->db->from('tt_center_logs l');
        $this->db->join('tt_admin_users a', 'a.id = l.changed_by', 'left');
        $this->db->where('l.center_id', $center_id);
        $this->db->order_by('l.changed_on', 'DESC');

        $data['logs'] = $this->db->get()->result();

        // Load Views (Uvexy structure)
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center/center_logs', $data);
        $this->load->view('layouts/footer');
    }

    // Download the image
    public function downloadCenterImage()
    {
        $file = $this->input->get('file');

        if (empty($file)) {
            show_404();
        }

        $file_name = basename(parse_url($file, PHP_URL_PATH));

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        readfile($file);

        exit;
    }

    public function fixCenterLogoPathByManualQuery()
    {
        $folder = FCPATH . '../center/uploads/center_logo/';

        $centers = $this->db
            ->where("logo !=", "")
            ->get("tt_center")
            ->result();

        foreach ($centers as $center) {

            $dbPath = $center->logo;

            // filename only
            $partialName = basename($dbPath);

            // scan folder
            $files = glob($folder . $partialName . '*');

            if (!empty($files)) {

                // first matched file
                $matchedFile = basename($files[0]);

                $newPath = 'uploads/center_logo/' . $matchedFile;

                // update db
                $this->db
                    ->where('center_id', $center->center_id)
                    ->update('tt_center', [
                        'logo' => $newPath
                    ]);

                echo "Updated Center ID: {$center->center_id} <br>";
            }
        }
    }


    public function getAssignedManpower()
    {
        $center_id = $this->input->post('center_id');

        $url = "https://manpowerx.co.in/api/v1/online_audit_manpower/" . $center_id;

        $response = file_get_contents($url);

        echo $response;
    }


    // Export Center History
    public function centerHistoryExportExcel($centerId = null)
    {
        $year      = $this->input->get('year');
        $month     = $this->input->get('month');
        $dateRange = $this->input->get('daterange');

        $fromDate = '';
        $toDate   = '';

        if (!empty($dateRange)) {

            $dates = explode(' - ', $dateRange);

            if (count($dates) == 2) {
                $fromDate = date('Y-m-d', strtotime($dates[0]));
                $toDate   = date('Y-m-d', strtotime($dates[1]));
            }
        }

        // ================= CENTER INFO =================

        $center = $this->db
            ->select('
            c.*,
            au.username,
            au.email as useremail,
            au.mobile_phone as userphone,
            con.name as country_name,
            s.title as state_name,
            cm.city_name
        ')
            ->from('tt_center c')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->join('tt_countries con', 'con.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master cm', 'cm.city_id = c.city_id', 'left')
            ->where('c.center_id', $centerId)
            ->where('c.deleted', 0)
            ->get()
            ->row();

        if (!$center) {
            show_404();
        }


        // ================= PROJECT HISTORY =================

        $this->db
            ->select("
            sbr.*,
            pd.exam_name,
            pd.start_date,
            pd.end_date,
            pd.status,
            pd.project_remark,
            pd.number_of_seats,
            pd.admin_price_per_seat,
            tc.company_name,
            cm.city_name
        ")
            ->from('tt_send_booking_request sbr')
            ->join(
                'tt_project_detail pd',
                'pd.project_id = sbr.project_id
             AND pd.exam_city_id = sbr.city_id',
                'left'
            )
            ->join(
                'tt_client tc',
                'tc.ac_id = sbr.client_id',
                'left'
            )
            ->join(
                'tt_city_master cm',
                'cm.city_id = sbr.city_id',
                'left'
            )
            ->where('sbr.center_id', $centerId);

        $this->applyHistoryFilters(
            $year,
            $month,
            $fromDate,
            $toDate,
            'sbr.created_at'
        );

        $this->db->order_by('sbr.created_at', 'DESC');

        $projects = $this->db->get()->result();


        // ================= SUMMARY =================

        $totalSeats = 0;
        $totalRevenue = 0;
        $highestBooking = 0;

        foreach ($projects as $project) {

            if ((int)$project->admin_status == 1) {

                $seats = min(
                    (int)$project->center_seat,
                    (int)$project->number_of_seats
                );

                $price = !empty($project->admin_center_final_price)
                    ? $project->admin_center_final_price
                    : $project->admin_price_per_seat;

                $totalSeats += $seats;

                $totalRevenue += $seats * (float)$price;

                if ($seats > $highestBooking) {
                    $highestBooking = $seats;
                }
            }
        }

        $avgPrice = $totalSeats > 0
            ? round($totalRevenue / $totalSeats)
            : 0;


        // ================= EXCEL =================

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Center History');


        // Title
        $sheet->mergeCells('A1:J1');

        $sheet->setCellValue(
            'A1',
            'Exam Center History - ' . $center->center_name
        );

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);


        // ================= FILTERS =================

        $sheet->setCellValue('A3', 'Applied Filters');
        $sheet->getStyle('A3')->getFont()->setBold(true);

        $sheet->setCellValue('A4', 'Year');
        $sheet->setCellValue('B4', $year ?: 'All Years');

        $sheet->setCellValue('C4', 'Month');
        $sheet->setCellValue(
            'D4',
            $month
                ? date('F', mktime(0, 0, 0, $month, 1))
                : 'All Months'
        );

        $sheet->setCellValue('E4', 'Date Range');
        $sheet->setCellValue('F4', $dateRange ?: 'All Dates');


        // ================= CENTER INFO =================

        $sheet->setCellValue('A6', 'CENTER INFORMATION');
        $sheet->getStyle('A6')->getFont()->setBold(true);

        $centerInfo = [
            ['Center Name', $center->center_name],
            ['Country', $center->country_name],
            ['State', $center->state_name],
            ['City', $center->city_name],
            ['Owner Name', $center->username],
            ['Owner Email', $center->useremail],
            ['Owner Phone', $center->userphone],
            ['Capacity', $center->capacity],
            ['Center ID', $center->center_id],
            ['Created At', $center->created_on],
        ];

        $row = 7;

        foreach ($centerInfo as $info) {

            $sheet->setCellValue('A' . $row, $info[0]);
            $sheet->setCellValue('B' . $row, $info[1]);

            $sheet->getStyle('A' . $row)
                ->getFont()
                ->setBold(true);

            $row++;
        }


        // ================= ANALYTICS =================

        $row += 1;

        $sheet->setCellValue(
            'A' . $row,
            'REVENUE & PERFORMANCE ANALYTICS'
        );

        $sheet->getStyle('A' . $row)
            ->getFont()
            ->setBold(true);

        $row++;

        $analytics = [
            ['Total Seats Delivered', $totalSeats],
            ['Total Revenue', $totalRevenue],
            ['Average Price / Seat', $avgPrice],
            ['Highest Seats Booked', $highestBooking],
        ];

        foreach ($analytics as $item) {

            $sheet->setCellValue('A' . $row, $item[0]);
            $sheet->setCellValue('B' . $row, $item[1]);

            $row++;
        }


        // ================= PROJECT HISTORY =================

        $row += 2;

        $sheet->setCellValue(
            'A' . $row,
            'PROJECT BOOKING HISTORY'
        );

        $sheet->getStyle('A' . $row)
            ->getFont()
            ->setBold(true);

        $row++;

        $headers = [
            'Exam',
            'Client',
            'City',
            'Seats',
            'Booking Date',
            'Booking Status',
            'Project Status',
            'Price / Seat',
            'Revenue',
            'Remark'
        ];

        $col = 'A';

        foreach ($headers as $header) {

            $sheet->setCellValue($col . $row, $header);

            $sheet->getStyle($col . $row)
                ->getFont()
                ->setBold(true);

            $col++;
        }

        $row++;

        foreach ($projects as $project) {

            $seats = min(
                (int)$project->center_seat,
                (int)$project->number_of_seats
            );

            $price = !empty($project->admin_center_final_price)
                ? $project->admin_center_final_price
                : $project->admin_price_per_seat;

            $revenue = ((int)$project->admin_status == 1)
                ? $seats * (float)$price
                : 0;

            $dataRow = [
                $project->exam_name,
                $project->company_name,
                $project->city_name,
                $seats,
                !empty($project->created_at)
                    ? date('d M Y', strtotime($project->created_at))
                    : '',
                $project->exam_center_status,
                $project->status,
                $price,
                $revenue,
                $project->project_remark
            ];

            $col = 'A';

            foreach ($dataRow as $value) {

                $sheet->setCellValue(
                    $col . $row,
                    $value
                );

                $col++;
            }

            $row++;
        }


        // Auto width
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }


        $filename =
            'exam-center-history-' .
            preg_replace('/[^A-Za-z0-9\-]/', '-', $center->center_name) .
            '-' .
            date('Y-m-d') .
            '.xlsx';


        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment;filename="' . $filename . '"'
        );

        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);

        $writer->save('php://output');

        exit;
    }

    public function centerHistoryExportPdf($centerId = null)
    {
        $year      = $this->input->get('year');
        $month     = $this->input->get('month');
        $dateRange = $this->input->get('daterange');

        $fromDate = '';
        $toDate   = '';

        if (!empty($dateRange)) {

            $dates = explode(' - ', $dateRange);

            if (count($dates) == 2) {
                $fromDate = date('Y-m-d', strtotime($dates[0]));
                $toDate   = date('Y-m-d', strtotime($dates[1]));
            }
        }


        // Center
        $center = $this->db
            ->select('
            c.*,
            au.username,
            au.email as useremail,
            au.mobile_phone as userphone,
            con.name as country_name,
            s.title as state_name,
            cm.city_name
        ')
            ->from('tt_center c')
            ->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left')
            ->join('tt_countries con', 'con.id = c.country_id', 'left')
            ->join('tt_states s', 's.id = c.state_id', 'left')
            ->join('tt_city_master cm', 'cm.city_id = c.city_id', 'left')
            ->where('c.center_id', $centerId)
            ->where('c.deleted', 0)
            ->get()
            ->row();

        if (!$center) {
            show_404();
        }


        // Project History
        $this->db
            ->select("
            sbr.*,
            pd.exam_name,
            pd.start_date,
            pd.end_date,
            pd.status,
            pd.project_remark,
            pd.number_of_seats,
            pd.admin_price_per_seat,
            tc.company_name,
            cm.city_name
        ")
            ->from('tt_send_booking_request sbr')
            ->join(
                'tt_project_detail pd',
                'pd.project_id = sbr.project_id
             AND pd.exam_city_id = sbr.city_id',
                'left'
            )
            ->join(
                'tt_client tc',
                'tc.ac_id = sbr.client_id',
                'left'
            )
            ->join(
                'tt_city_master cm',
                'cm.city_id = sbr.city_id',
                'left'
            )
            ->where('sbr.center_id', $centerId);

        $this->applyHistoryFilters(
            $year,
            $month,
            $fromDate,
            $toDate,
            'sbr.created_at'
        );

        $this->db->order_by('sbr.created_at', 'DESC');

        $projects = $this->db->get()->result();


        // Analytics
        $totalSeats = 0;
        $totalRevenue = 0;
        $highestBooking = 0;

        foreach ($projects as $project) {

            if ((int)$project->admin_status == 1) {

                $seats = min(
                    (int)$project->center_seat,
                    (int)$project->number_of_seats
                );

                $price = !empty($project->admin_center_final_price)
                    ? $project->admin_center_final_price
                    : $project->admin_price_per_seat;

                $totalSeats += $seats;

                $totalRevenue += $seats * (float)$price;

                $highestBooking = max(
                    $highestBooking,
                    $seats
                );
            }
        }

        $avgPrice = $totalSeats > 0
            ? round($totalRevenue / $totalSeats)
            : 0;


        $html = $this->load->view(
            'dashboard/center/history/center-history-export-pdf',
            [
                'center'         => $center,
                'projects'       => $projects,
                'year'           => $year,
                'month'          => $month,
                'dateRange'      => $dateRange,
                'totalSeats'     => $totalSeats,
                'totalRevenue'   => $totalRevenue,
                'avgPrice'       => $avgPrice,
                'highestBooking' => $highestBooking
            ],
            true
        );


        $options = new Options();

        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $filename =
            'exam-center-history-' .
            preg_replace('/[^A-Za-z0-9\-]/', '-', $center->center_name) .
            '-' .
            date('Y-m-d') .
            '.pdf';

        $dompdf->stream(
            $filename,
            [
                'Attachment' => true
            ]
        );

        exit;
    }
}
