<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(['session']);
        $this->load->helper(['url']);
        $this->load->helper('project_status');

        // Auth Guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('client_list');
    }

    /**
     * Client List Page
     */
    public function index()
    {
        $data['page_title'] = 'Client List';
        $data['admin']      = $this->session->userdata('admin_user');

        // Total Clients
        $data['total_clients'] = $this->db
            ->where('role_id', 12)
            ->where('deleted', 0)
            ->count_all_results('tt_admin_users');

        // Approve Clients
        $data['approved_clients'] = $this->db
            ->where('role_id', 12)
            ->where('approved', 1)
            ->where('deleted', 0)
            ->count_all_results('tt_admin_users');

        // Pending Clients
        $data['pending_clients'] = $this->db
            ->where('role_id', 12)
            ->where('approved', 0)
            ->where('deleted', 0)
            ->count_all_results('tt_admin_users');

        // Deleted Clients
        $data['deleted_clients'] = $this->db
            ->where('role_id', 12)
            ->where('deleted', 1)
            ->count_all_results('tt_admin_users');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client/index');
        $this->load->view('layouts/footer');
    }

    /**
     * Server-side DataTable (search, pagination, ordering)
     */
    public function ajaxList()
    {
        $this->output->set_content_type('application/json');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'];
        $type = $this->input->post('client_type');
        $status    = $this->input->post('status');
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');

        // ================= MAIN QUERY =================
        $this->db
            ->select('
                tc.*,
                u.username,
                u.email,
                u.mobile_phone,
                u.approved,
                cm.city_name,
                ts.title AS state_name,
                co.name AS country_name,
                COUNT(DISTINCT tp.project_id) AS total_projects
            ')
            ->from('tt_client tc')
            ->join('tt_city_master cm', 'cm.city_id = tc.city', 'left')
            ->join('tt_states ts', 'ts.id = tc.state', 'left')
            ->join('tt_countries co', 'co.id = tc.country_id', 'left')
            ->join('tt_project_detail tp', 'tp.client_id = tc.ac_id', 'left')
            ->join('tt_admin_users u', 'u.id = tc.ac_id AND u.deleted = 0', 'left');

        if ($type == 'deleted') {
            $this->db->where('tc.deleted', 1);
        } else {
            $this->db->where('tc.deleted', 0);
        }

        /* -------- STATUS FILTER -------- */
        if ($status !== '' && $status !== null) {
            $this->db->where('u.approved', (int) $status);
        }

        /* -------- DATE FILTER -------- */
        if (!empty($from_date)) {
            $this->db->where('DATE(tc.created_on) >=', $from_date);
        }

        if (!empty($to_date)) {
            $this->db->where('DATE(tc.created_on) <=', $to_date);
        }

        $this->db->group_by('tc.id');

        // 🔍 Global search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tc.company_name', $search);
            $this->db->or_like('u.username', $search);
            $this->db->or_like('u.mobile_phone', $search);
            $this->db->or_like('u.email', $search);
            $this->db->or_like('cm.city_name', $search);
            $this->db->or_like('ts.title', $search);
            $this->db->group_end();
        }

        // Filtered count
        $recordsFiltered = $this->db->count_all_results('', false);

        // Pagination
        $this->db->order_by('tc.id', 'DESC');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        // Total count (without search)
        $recordsTotal = $this->db
            ->where('deleted !=', 1)
            ->count_all_results('tt_client');

        $data = [];

        foreach ($query->result() as $row) {

            $statusBtn = ($row->approved == 1)
                ? '<button class="btn btn-sm btn-success changeStatus"
                    data-id="' . $row->ac_id . '" data-status="0">Approved</button>'
                : '<button class="btn btn-sm btn-danger changeStatus"
                    data-id="' . $row->ac_id . '" data-status="1">Not Approved</button>';

            $status = $row->deleted == 0 ? 'Active' : 'Inactive';
            $city  = !empty($row->city_name) ? $row->city_name : '-';
            $state = !empty($row->state_name) ? $row->state_name : '-';
            $cityState = $city . '<br><small class="text-muted">' . $state . '</small>';

            if ($row->deleted == 1) {
                $action = '<button class="btn btn-sm btn-warning restoreClient" data-id="' . $row->ac_id . '">Restore</button>';
            } else {
                $action = '<a target="_blank" href="' . base_url('admin/client-view/' . $row->ac_id) . '" class="btn btn-sm btn-info">View</a>';
            }

            $data[] = [
                'checkbox' => '<input type="checkbox" class="client-checkbox" value="' . $row->ac_id . '">',
                'company'  => ucwords($row->company_name),
                'name'     => $row->username,
                'mobile'   => $row->mobile_phone,
                'city'     => $cityState,
                'projects' => '<span class="badge bg-primary">' . $row->total_projects . '</span>',

                'created'  => date('d M Y', strtotime($row->created_on)),
                'status'   => $statusBtn,
                'action' => $action
            ];
        }

        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
    }



    /**
     * Bulk Action (Activate / Inactive / Delete)
     */
    public function bulkAction()
    {
        $this->output->set_content_type('application/json');

        $action = $this->input->post('action');
        $ids    = $this->input->post('ids');

        if (empty($ids) || !in_array($action, ['activate', 'inactive', 'delete'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request']);
            return;
        }

        $this->db->trans_start();

        if ($action == 'activate') {

            $this->db->where_in('id', $ids)
                ->update('tt_admin_users', ['approved' => 1]);
        } elseif ($action == 'inactive') {

            $this->db->where_in('id', $ids)
                ->update('tt_admin_users', ['approved' => 0]);
        } elseif ($action == 'delete') {

            foreach ($ids as $ac_id) {

                // Check projects
                $this->db->from('tt_project_detail');
                $this->db->where('client_id', $ac_id);
                $this->db->where('deleted', 0);
                $projectCount = $this->db->count_all_results();

                // Check bookings
                $this->db->from('tt_send_booking_request');
                $this->db->where('client_id', $ac_id);
                $bookingCount = $this->db->count_all_results();

                if ($projectCount > 0 || $bookingCount > 0) {
                    echo json_encode([
                        'status'  => false,
                        'message' => 'Some selected accounts have bookings or projects associated. Deletion stopped.'
                    ]);
                    return;
                }
            }

            // If all safe → delete
            $this->db->where_in('id', $ids)
                ->update('tt_admin_users', ['deleted' => 1]);

            $this->db->where_in('ac_id', $ids)
                ->update('tt_client', ['deleted' => 1]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Database error']);
        } else {
            echo json_encode([
                'status'  => true,
                'message' => 'Action applied successfully'
            ]);
        }
    }

    // Restore Clients
    public function restoreClient()
    {
        $id = $this->input->post('id');

        // Check if same mobile/email already exists
        $this->db->select('u.mobile_phone, u.email');
        $this->db->from('tt_admin_users u');
        $this->db->where('u.id', $id);
        $user = $this->db->get()->row();

        if (!$user) {
            echo json_encode(['status' => false, 'message' => 'User not found']);
            return;
        }

        // Check duplicate
        $this->db->from('tt_admin_users');
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile_phone', $user->mobile_phone);
        $this->db->or_where('email', $user->email);
        $this->db->group_end();

        $exists = $this->db->count_all_results();

        if ($exists > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Client already re-registered with same mobile/email. Cannot restore.'
            ]);
            return;
        }

        // Restore
        $this->db->where('id', $id)->update('tt_admin_users', ['deleted' => 0]);
        $this->db->where('ac_id', $id)->update('tt_client', ['deleted' => 0]);

        echo json_encode(['status' => true, 'message' => 'Client restored successfully']);
    }

    /**
     * Custom Export (NOT table dependent)
     */
    public function export_excel()
    {
        $filename = "clients_" . date('Ymd_His') . ".csv";

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Content-Type: text/csv; charset=utf-8");

        $file = fopen('php://output', 'w');

        // 🔹 CSV Headers
        fputcsv($file, [
            'Company Name',
            'Company Type',
            'Website',
            'Address',
            'Pincode',
            'City',
            'State',
            'Country',
            'Coordinator Name',
            'Coordinator Email',
            'Coordinator Mobile',
            'Coordinator Alternate Mobile',
            'GST State Code',
            'GST Number',
            'Bank Name',
            'Bank Account No',
            'Bank IFSC Code',
            'Bank Beneficiary Name',
            'PAN Number',
            'Udyam Number',
            'Agreement Start Date',
            'Agreement End Date',
            'Created Date',
            'Status'
        ]);

        // 🔹 Data query with joins
        $clients = $this->db
            ->select('
                tc.company_name,
                tc.company_type,
                tc.website,
                tc.address,
                tc.pincode,
                cm.city_name,
                ts.title AS state_name,
                co.name AS country_name,
                tc.co_ordinator_name,
                tc.coordinator_email,
                tc.coordinator_mobile_number,
                tc.coordinator_alternative_number,
                tc.gst_state_code,
                tc.gst_number,
                tc.bank_name,
                tc.bank_account_no,
                tc.bank_ifsc_code,
                tc.bank_beneficial_name,
                tc.pan_number,
                tc.udyam_number,
                tc.agreement_start_date,
                tc.agreement_end_date,
                tc.created_on,
                tc.deleted
            ')
            ->from('tt_client tc')
            ->join('tt_city_master cm', 'cm.city_id = tc.city', 'left')
            ->join('tt_states ts', 'ts.id = tc.state', 'left')
            ->join('tt_countries co', 'co.id = tc.country_id', 'left')
            ->where('tc.deleted !=', 2)
            ->order_by('tc.id', 'DESC')
            ->get()
            ->result_array();

        foreach ($clients as $row) {

            $status = ($row['deleted'] == 0) ? 'Active' : 'Inactive';

            fputcsv($file, [
                $row['company_name'],
                $row['company_type'],
                $row['website'],
                $row['address'],
                $row['pincode'],
                $row['city_name'],
                $row['state_name'],
                $row['country_name'],
                $row['co_ordinator_name'],
                $row['coordinator_email'],
                $row['coordinator_mobile_number'],
                $row['coordinator_alternative_number'],
                $row['gst_state_code'],
                $row['gst_number'],
                $row['bank_name'],
                $row['bank_account_no'],
                $row['bank_ifsc_code'],
                $row['bank_beneficial_name'],
                $row['pan_number'],
                $row['udyam_number'],
                $row['agreement_start_date'] ? date('d-m-Y', strtotime($row['agreement_start_date'])) : '',
                $row['agreement_end_date'] ? date('d-m-Y', strtotime($row['agreement_end_date'])) : '',
                date('d-m-Y', strtotime($row['created_on'])),
                $status
            ]);
        }

        fclose($file);
        exit;
    }


    public function export_pdf()
    {
        require_once FCPATH . 'vendor/autoload.php';

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);

        $clients = $this->db
            ->select('
            tc.company_name,
            tc.company_type,
            tc.website,
            tc.address,
            tc.pincode,
            cm.city_name,
            ts.title AS state_name,
            co.name AS country_name,
            tc.co_ordinator_name,
            tc.coordinator_email,
            tc.coordinator_mobile_number,
            tc.coordinator_alternative_number,
            tc.gst_state_code,
            tc.gst_number,
            tc.bank_name,
            tc.bank_account_no,
            tc.bank_ifsc_code,
            tc.bank_beneficial_name,
            tc.pan_number,
            tc.udyam_number,
            tc.agreement_start_date,
            tc.agreement_end_date,
            tc.created_on,
            tc.deleted
        ')
            ->from('tt_client tc')
            ->join('tt_city_master cm', 'cm.city_id = tc.city', 'left')
            ->join('tt_states ts', 'ts.id = tc.state', 'left')
            ->join('tt_countries co', 'co.id = tc.country_id', 'left')
            ->where('tc.deleted !=', 2)
            ->order_by('tc.id', 'DESC')
            ->get()
            ->result_array();

        $data['clients'] = $clients;

        // Load PDF view
        $html = $this->load->view(
            'dashboard/client/client_pdf',
            $data,
            true
        );

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A3', 'landscape');

        $dompdf->render();

        $filename = 'clients_' . date('Ymd_His') . '.pdf';

        $dompdf->stream($filename, [
            'Attachment' => 1
        ]);

        exit;
    }


    /**
     * View Client Detail
     */
    public function viewClientDetail($clientId)
    {
        // ===== Client Main Details =====
        $this->db
            ->select('
                tc.*,
                au.username,
                au.email,
                au.mobile_phone,
                cm.city_name,
                ts.title AS state_name,
                co.name AS country_name
            ')
            ->from('tt_client tc')
            ->join('tt_admin_users au', 'au.id = tc.ac_id', 'left')
            ->join('tt_city_master cm', 'cm.city_id = tc.city', 'left')
            ->join('tt_states ts', 'ts.id = tc.state', 'left')
            ->join('tt_countries co', 'co.id = tc.country_id', 'left')
            ->where('tc.ac_id', $clientId)
            ->where('tc.deleted !=', 2);

        $data['client'] = $this->db->get()->row();

        // ================= CLIENT OVERVIEW STATS =================

        $data['client_stats'] = [];

        // Total Projects
        $data['client_stats']['total_projects'] = $this->db
            ->where('client_id', $clientId)
            ->count_all_results('tt_project_detail');

        // Active Projects
        $today = date('Y-m-d');

        $data['client_stats']['active_projects'] = $this->db
            ->where('client_id', $clientId)
            ->where('start_date <=', $today)
            ->where('end_date >=', $today)
            ->count_all_results('tt_project_detail');

        // Upcoming Projects
        $data['client_stats']['upcoming_projects'] = $this->db
            ->where('client_id', $clientId)
            ->where('start_date >', $today)
            ->count_all_results('tt_project_detail');

        // Completed Projects
        $data['client_stats']['completed_projects'] = $this->db
            ->where('client_id', $clientId)
            ->where('end_date <', $today)
            ->count_all_results('tt_project_detail');

        // Total Cities Covered
        $data['client_stats']['cities_covered'] = $this->db
            ->select('COUNT(DISTINCT exam_city_id) as total')
            ->where('client_id', $clientId)
            ->get('tt_project_detail')
            ->row()
            ->total ?? 0;


        // Total Centers Used
        $data['client_stats']['centers_used'] = $this->db
            ->select('COUNT(DISTINCT center_id) as total')
            ->where('client_id', $clientId)
            ->where('admin_status', 1)
            ->where('client_status', 1)
            ->where('exam_center_status', 1)
            ->get('tt_send_booking_request')
            ->row()
            ->total ?? 0;


        // Total Seats Allocated (Never exceed project required seats)

        $totalAllocatedSeats = 0;

        $projects = $this->db
            ->select('project_id, number_of_seats')
            ->from('tt_project_detail')
            ->where('client_id', $clientId)
            ->get()
            ->result();

        foreach ($projects as $project) {
            $allocatedSeats = $this->db
                ->select('SUM(center_seat) as total')
                ->where('project_id', $project->project_id)
                ->where('admin_status', 1)
                ->where('client_status', 1)
                ->where('exam_center_status', 1)
                ->get('tt_send_booking_request')
                ->row()
                ->total ?? 0;

            $totalAllocatedSeats += min(
                (int)$allocatedSeats,
                (int)$project->number_of_seats
            );
        }

        $data['client_stats']['seats_allocated'] = $totalAllocatedSeats;


        // ===== Client Projects =====
        $this->db
            ->select('
                tp.project_id,
                tp.exam_city_id,
                tp.exam_name,
                tp.start_date,
                tp.end_date,
                tp.exam_type,
                tp.exam_mode,
                tp.number_of_seats,
                tp.manual_status,
                tp.project_remark,
                tp.status,
                cm.city_name
            ')
            ->from('tt_project_detail tp')
            ->join('tt_city_master cm', 'cm.city_id = tp.exam_city_id', 'left')
            ->where('tp.client_id', $clientId);

        $data['projects'] = $this->db->get()->result();

        // Project Summary
        $data['project_summary'] = [];

        $data['project_summary']['total_projects'] = count($data['projects']);

        $data['project_summary']['total_seats'] = array_sum(
            array_column($data['projects'], 'number_of_seats')
        );

        $data['project_summary']['total_centers'] = $this->db
            ->select('COUNT(DISTINCT center_id) as total')
            ->where('client_id', $clientId)
            ->get('tt_send_booking_request')
            ->row()
            ->total ?? 0;

        foreach ($data['projects'] as $key => $project) {
            $center_count = $this->db
                ->where('project_id', $project->project_id)
                ->count_all_results('tt_send_booking_request');

            $data['projects'][$key]->center_count = $center_count;

            // Status
            if ($project->end_date < date('Y-m-d')) {
                $status = 'Completed';
            } elseif ($project->start_date > date('Y-m-d')) {
                $status = 'Upcoming';
            } else {
                $status = 'Active';
            }
            $status = getProjectStatusBadge($project);
            $status .= isHaveAnyRemark($project->project_remark);

            $approved = $this->db
                ->where('project_id', $project->project_id)
                ->where('admin_status', 1)
                ->count_all_results('tt_send_booking_request');

            $pending = $this->db
                ->where('project_id', $project->project_id)
                ->where('admin_status', 0)
                ->count_all_results('tt_send_booking_request');

            if ($approved > 0 && $pending == 0) {
                $booking_status = 'Approved';
            } elseif ($approved > 0 && $pending > 0) {
                $booking_status = 'Partial';
            } else {
                $booking_status = 'Pending';
            }

            $data['projects'][$key]->booking_status = $booking_status;
            $data['projects'][$key]->project_status = $status;
        }


        $data['page_title'] = 'Client Details';
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client/client-detail', $data);
        $this->load->view('layouts/footer');
    }


    /**
     * Status Change
     */
    public function changeStatus()
    {
        // no HTML, no errors
        ini_set('display_errors', 0);
        error_reporting(0);

        $this->output->set_content_type('application/json');

        $user_id = (int) $this->input->post('user_id');
        $status  = $this->input->post('status'); // 0 or 1

        if (!$user_id || !in_array($status, ['0', '1'], true)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request'
            ]);
            exit;
        }

        $this->db->where('id', $user_id)
            ->where('role_id', 12)
            ->update('tt_admin_users', [
                'approved' => $status
            ]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status'  => true,
                'message' => $status == 1 ? 'Approved successfully' : 'Disapproved successfully'
            ]);
        } else {
            echo json_encode([
                'status'  => false,
                'message' => 'No changes made'
            ]);
        }

        exit;
    }
}
