<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CenterOwnerController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('owner_list');
    }

    /* ===============================
       PAGE LOAD
    =============================== */
    public function index()
    {
        $data['page_title'] = 'Center Owners';


        // Total Center Owners
        $data['total_owners'] = $this->db
            ->where('role_id', 9)
            ->where('deleted', 0)
            ->count_all_results('tt_admin_users');


        // Active Center Owners
        $data['active_owners'] = $this->db
            ->where('role_id', 9)
            ->where('deleted', 0)
            ->where('approved', 1)
            ->count_all_results('tt_admin_users');


        // Inactive Center Owners
        $data['inactive_owners'] = $this->db
            ->where('role_id', 9)
            ->where('deleted', 0)
            ->where('approved', 0)
            ->count_all_results('tt_admin_users');


        // Deelted Center Owners
        $data['deleted_owners'] = $this->db
            ->where('role_id', 9)
            ->where('deleted', 1)
            ->count_all_results('tt_admin_users');


        // Subscribed Owners
        $data['subscribed_owners'] = $this->db
            ->distinct()
            ->select('us.center_owner_id')
            ->from('user_subscriptions us')
            ->join(
                'tt_admin_users au',
                'au.id = us.center_owner_id',
                'inner'
            )
            ->where('au.role_id', 9)
            ->where('au.deleted', 0)
            ->where('us.is_active', 1)
            ->count_all_results();


        // Non Subscribed Owners
        $data['non_subscribed_owners'] =
            $data['total_owners'] - $data['subscribed_owners'];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center_owner/index');
        $this->load->view('layouts/footer');
    }

    /* ===============================
       AJAX LIST (DATATABLE)
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
        $type      = $this->input->post('owner_type');
        $status    = $this->input->post('status');
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');

        /* -------- TOTAL RECORDS (ROLE = 9 ONLY) -------- */
        $recordsTotal = $this->db
            ->where('role_id', 9)
            ->count_all_results('tt_admin_users');

        /* -------- MAIN QUERY -------- */
        $this->db
            ->select('
                u.id,
                u.username,
                u.first_name,
                u.email,
                u.mobile_phone,
                u.profile_pic,
                u.owner_pan_card,
                u.owner_aadhaar_card,
                u.approved,
                u.created,
                u.deleted,
                COUNT(c.id) AS total_centers,

                sp.name AS package_name,
                us.expiry_date,
                us.is_active
            ')
            ->from('tt_admin_users u')
            ->join(
                'user_subscriptions us',
                'us.center_owner_id = u.id AND us.is_active = 1',
                'left'
            )

            ->join(
                'subscription_packages sp',
                'sp.id = us.package_id',
                'left'
            )

            ->join(
                'tt_center c',
                'c.owner_user_id = u.id AND c.deleted = 0',
                'left'
            );

        $this->db->where('u.role_id', 9);

        if ($type == 'deleted') {
            $this->db->where('u.deleted', 1);
        } else {
            $this->db->where('u.deleted', 0);
        }

        /* -------- STATUS FILTER -------- */
        if ($status !== '' && $status !== null) {
            $this->db->where('u.approved', (int) $status);
        }

        /* -------- DATE FILTER -------- */
        if (!empty($from_date)) {
            $this->db->where('DATE(u.created) >=', $from_date);
        }

        if (!empty($to_date)) {
            $this->db->where('DATE(u.created) <=', $to_date);
        }

        $this->db->group_by('u.id');

        /* -------- GLOBAL SEARCH -------- */
        if ($search !== '') {
            $this->db->group_start()
                ->like('u.username', $search)
                ->or_like('u.email', $search)
                ->or_like('u.mobile_phone', $search)
                ->group_end();
        }

        /* -------- FILTERED COUNT -------- */
        $recordsFiltered = $this->db->count_all_results('', false);

        /* -------- PAGINATION -------- */
        $this->db
            ->order_by('u.id', 'DESC')
            ->limit($length, $start);

        $query = $this->db->get();

        /* -------- RESPONSE DATA -------- */
        $data = [];
        $sr = $start + 1;

        foreach ($query->result() as $row) {

            $name = $row->username ?? $row->first_name;
            $avatar = '';

            if (!empty($row->profile_pic)) {

                $avatar = '<img src="' . CENTER_URL . '/uploads/owner_profile/' . $row->profile_pic . '"
                            width="40"
                            height="40"
                            class="rounded-circle border"
                            style="object-fit:cover;">';
            } else {

                if ($row->username != '') {

                    $words = preg_split('/\s+/', trim($row->username));

                    if (count($words) >= 2) {
                        $initials = strtoupper(
                            substr($words[0], 0, 1) .
                                substr(end($words), 0, 1)
                        );
                    } else {
                        $initials = strtoupper(substr($row->username, 0, 2));
                    }
                } else {

                    $words = preg_split('/\s+/', trim($row->first_name));

                    if (count($words) >= 2) {
                        $initials = strtoupper(
                            substr($words[0], 0, 1) .
                                substr(end($words), 0, 1)
                        );
                    } else {
                        $initials = strtoupper(substr($row->first_name, 0, 2));
                    }
                }

                $avatar = '<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width:40px;height:40px;font-size:14px;font-weight:600;">
                            ' . $initials . '
                        </div>';
            }

            $statusBtn = ($row->approved == 1)
                ? '<button class="btn btn-sm btn-success changeStatus"
                    data-id="' . $row->id . '" data-status="0">Approved</button>'
                : '<button class="btn btn-sm btn-danger changeStatus"
                    data-id="' . $row->id . '" data-status="1">Not Approved</button>';

            $emailMobile = '
                    <small><strong>Name: </strong>' . $name . '</small><br>
                    <small><strong>Email: </strong>' . $row->email . '</small><br>
                    <small><strong>Mobile: </strong>' . $row->mobile_phone . '</small>
                    ';

            if ($row->deleted == 1) {
                $action = '<button class="btn btn-sm btn-warning restoreOwner" data-id="' . $row->id . '">Restore</button>';
            } else {
                $action = '<button class="btn btn-sm btn-danger deleteOwner" data-id="' . $row->id . '">Delete</button>';
            }


            $subscriptionHtml = '';

            if (!empty($row->package_name)) {
                $subscriptionHtml = '
                    <br>
                    <span class="badge bg-success">
                        ' . $row->package_name . '
                    </span>
                    <br>
                    <small class="text-muted">
                        Exp: ' . date('d M Y', strtotime($row->expiry_date)) . '
                    </small>';
            } else {
                $subscriptionHtml = '
                    <br>
                    <span class="badge bg-secondary">
                        No Subscription
                    </span>';
            }


            /* -------- DOCUMENTS -------- */

            $documentsHtml = '<div class="d-flex align-items-center justify-content-center gap-2">';


            $documentPath = CENTER_URL . '/uploads/temp_owner_documents/';

            /* PAN Card */
            if (!empty($row->owner_pan_card)) {

                $panUrl = $documentPath . rawurlencode($row->owner_pan_card);

                $documentsHtml .= '
                    <div class="text-center">
                        <small class="d-block text-muted mb-1">PAN</small>

                        <a href="' . $panUrl . '"
                        target="_blank"
                        class="btn btn-sm btn-outline-primary mb-2"
                        title="View PAN Card">
                            <i class="ti ti-eye"></i>
                        </a>

                        <a href="' . $panUrl . '"
                        download
                        class="btn btn-sm btn-outline-success"
                        title="Download PAN Card">
                            <i class="ti ti-download"></i>
                        </a>
                    </div>';
            }

            /* Aadhaar Card */
            if (!empty($row->owner_aadhaar_card)) {

                $aadhaarUrl = $documentPath . rawurlencode($row->owner_aadhaar_card);

                $documentsHtml .= '
                    <div class="text-center">
                        <small class="d-block text-muted mb-1">Aadhaar</small>

                        <a href="' . $aadhaarUrl . '"
                        target="_blank"
                        class="btn btn-sm btn-outline-primary mb-2"
                        title="View Aadhaar Card">
                            <i class="ti ti-eye"></i>
                        </a>

                        <a href="' . $aadhaarUrl . '"
                        download
                        class="btn btn-sm btn-outline-success"
                        title="Download Aadhaar Card">
                            <i class="ti ti-download"></i>
                        </a>
                    </div>';
            }

            if (empty($row->owner_pan_card) && empty($row->owner_aadhaar_card)) {
                $documentsHtml .= '<span class="text-muted">--</span>';
            }

            $documentsHtml .= '</div>';


            $data[] = [
                'checkbox' => '<input type="checkbox" class="owner-checkbox" value="' . $row->id . '">',

                'username' => '
                    <div class="d-flex align-items-center">
                        ' . $avatar . '
                        <div class="ms-2">
                            <strong>' . $row->username . '</strong>
                            ' . $subscriptionHtml . '
                        </div>
                    </div>',

                'email'    => $emailMobile,

                'centers'  => '<span class="badge bg-primary">' . (int)$row->total_centers . '</span>',

                'status'   => $statusBtn,

                'created'  => !empty($row->created)
                    ? date('d M Y', strtotime($row->created))
                    : '--',

                'documents' => $documentsHtml,

                'action' => $action
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


    // Delete center
    public function deleteOwner()
    {
        $id = $this->input->post('id');

        $centerExists = $this->db
            ->where('owner_user_id', $id)
            ->where('deleted', 0)
            ->count_all_results('tt_center');

        if ($centerExists > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Owner has active centers. Cannot delete.'
            ]);
            return;
        }

        $this->db->where('id', $id)
            ->update('tt_admin_users', ['deleted' => 1]);

        echo json_encode([
            'status' => true,
            'message' => 'Owner deleted successfully'
        ]);
    }

    // Restore center
    public function restoreOwner()
    {
        $id = $this->input->post('id');

        $user = $this->db
            ->where('id', $id)
            ->get('tt_admin_users')
            ->row();

        if (!$user) {
            echo json_encode(['status' => false, 'message' => 'User not found']);
            return;
        }

        // Duplicate check
        $this->db->where('deleted', 0);
        $this->db->group_start()
            ->where('mobile_phone', $user->mobile_phone)
            ->or_where('email', $user->email)
            ->group_end();

        $exists = $this->db->count_all_results('tt_admin_users');

        if ($exists > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Owner already registered again. Cannot restore.'
            ]);
            return;
        }

        $this->db->where('id', $id)
            ->update('tt_admin_users', ['deleted' => 0]);

        echo json_encode([
            'status' => true,
            'message' => 'Owner restored successfully'
        ]);
    }


    /* ===============================
       EXPORT CSV
    =============================== */
    public function export()
    {
        $filename = 'center_owners_' . date('Ymd_His') . '.csv';

        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv");

        $owners = $this->db
            ->select('
                u.username,
                u.email,
                u.mobile_phone,
                u.approved,
                u.created,
                COUNT(c.id) AS total_centers
            ')
            ->from('tt_admin_users u')
            ->join('tt_center c', 'c.owner_user_id = u.id AND c.deleted = 0', 'left')
            ->where('u.role_id', 9)
            ->group_by('u.id')
            ->order_by('u.id', 'DESC')
            ->get()
            ->result_array();

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Username',
            'Email',
            'Mobile',
            'Total Centers',
            'Status',
            'Created Date'
        ]);

        foreach ($owners as $o) {
            fputcsv($file, [
                $o['username'],
                $o['email'],
                $o['mobile_phone'],
                $o['total_centers'],
                $o['status'] == 1 ? 'Active' : 'Inactive',
                date('d-m-Y', strtotime($o['created_on']))
            ]);
        }

        fclose($file);
        exit;
    }

    /**
     * Bulk Action (Activate / Inactive)
     */
    public function bulkAction()
    {
        $this->output->set_content_type('application/json');

        $action = $this->input->post('action');
        $ids    = $this->input->post('ids');

        if (empty($ids) || !in_array($action, ['activate', 'inactive'])) {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request'
            ]);
            return;
        }

        // Make sure IDs are integers
        $ids = array_map('intval', (array) $ids);

        $newStatus = ($action === 'activate') ? 1 : 0;

        /*
     * Get current status before updating.
     * This allows us to notify only those owners
     * whose status actually changed.
     */
        $owners = $this->db
            ->select('id, approved')
            ->where_in('id', $ids)
            ->where('role_id', 9)
            ->get('tt_admin_users')
            ->result();

        if (empty($owners)) {
            echo json_encode([
                'status'  => false,
                'message' => 'No valid owners found'
            ]);
            return;
        }

        $changedOwnerIds = [];

        foreach ($owners as $owner) {

            if ((int) $owner->approved !== $newStatus) {
                $changedOwnerIds[] = (int) $owner->id;
            }
        }

        // Nothing actually changed
        if (empty($changedOwnerIds)) {

            echo json_encode([
                'status'  => false,
                'message' => 'No changes made'
            ]);

            return;
        }

        // Update only changed owners
        $this->db
            ->where_in('id', $changedOwnerIds)
            ->where('role_id', 9)
            ->update('tt_admin_users', [
                'approved' => $newStatus
            ]);

        if ($this->db->affected_rows() > 0) {

            $this->load->library('NotificationService');

            $title = $newStatus === 1
                ? 'Account Activated'
                : 'Account Deactivated';

            $description = $newStatus === 1
                ? 'Your account has been activated by the admin.'
                : 'Your account has been deactivated by the admin.';

            foreach ($changedOwnerIds as $ownerId) {

                $tokens = $this->FirebaseNotification_model
                    ->getActiveTokensByUserId($ownerId);

                if (!empty($tokens)) {

                    $this->notificationservice->sendNotification(
                        $title,
                        $description,
                        null,
                        $ownerId,
                        'owner_status',
                        'owner_profile',
                        $tokens
                    );
                }
            }

            echo json_encode([
                'status'  => true,
                'message' => $newStatus === 1
                    ? 'Selected owners activated successfully'
                    : 'Selected owners deactivated successfully'
            ]);

            return;
        }

        echo json_encode([
            'status'  => false,
            'message' => 'No changes made'
        ]);
    }


    public function changeStatus()
    {
        // ❌ no HTML, no errors
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
            ->where('role_id', 9)
            ->update('tt_admin_users', [
                'approved' => $status
            ]);

        if ($this->db->affected_rows() > 0) {

            $this->load->library('NotificationService');
            $this->load->model('FirebaseNotification_model');

            $title = $status == 1
                ? 'Account Activated'
                : 'Account Deactivated';

            $description = $status == 1
                ? 'Your account has been activated by the admin.'
                : 'Your account has been deactivated by the admin.';

            $tokens = $this->FirebaseNotification_model
                ->getActiveTokensByUserId($user_id);

            $this->notificationservice->sendNotification(
                $title,
                $description,
                null,
                $user_id,
                'owner_status',
                'owner_profile',
                $tokens
            );

            echo json_encode([
                'status'  => true,
                'message' => $status == 1
                    ? 'Approved successfully'
                    : 'Disapproved successfully'
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
