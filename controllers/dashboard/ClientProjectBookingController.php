<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);

class ClientProjectBookingController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url']);
        $this->load->model('Common_model');
        $this->load->model('Project_model');
        $this->load->library("Common_options");
        $this->load->helper('project_status');

        // Auth guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('client_project');
    }


    /**
     * Page load
     */
    public function checkBookingRequestStatus($encodedProjectId = NULL, $cityId = NULL)
    {
        if (!$encodedProjectId || !$cityId) {
            show_404();
        }

        /**
         * ===============================
         * Decode URL-safe base64 project ID
         * ===============================
         */

        // 🔓 URL-safe base64 decode
        $encodedProjectId = strtr($encodedProjectId, '-_', '+/');

        // Restore removed padding
        $padding = strlen($encodedProjectId) % 4;
        if ($padding) {
            $encodedProjectId .= str_repeat(
                '=',
                4 - $padding
            );
        }

        $projectId = base64_decode(
            $encodedProjectId,
            true
        );

        if ($projectId === false || empty($projectId)) {
            show_error('Invalid Project ID');
        }

        /**
         * ===============================
         * Project info (same as old panel)
         * ===============================
         */
        $project = $this->db
            ->select('exam_name, client_name, requirement_updated')
            ->from('tt_project_detail')
            ->where([
                'project_id' => $projectId,
                'exam_city_id' => $cityId,
                'deleted' => 0
            ])
            ->get()
            ->row();

        if (!$project) {
            show_error('Project not found for selected city.');
        }

        /**
         * ===============================
         * Booking request list (MODEL)
         * ===============================
         */
        $this->load->model('Booking_model');

        $type = $this->input->get('type');

        if (empty($type)) {
            $type = 'current';
        }

        $data['currentType'] = $type;

        $data['booking_requests'] =
            $this->Project_model->getBookingRequestStatusList($projectId, $cityId, $type);

        $data['requirementUpdated'] =
            (int)$project->requirement_updated;

        $data['changeLogs'] = $this->db

            ->select('
                pcl.*,
                cm.city_name
            ')

            ->from('tt_project_change_log pcl')

            ->join(
                'tt_city_master cm',
                'cm.city_id = pcl.city_id',
                'left'
            )

            ->where('pcl.project_id', $projectId)

            ->where('pcl.is_read', 0)

            ->order_by('pcl.id', 'DESC')

            ->get()

            ->result();

        /**
         * ===============================
         * View data
         * ===============================
         */
        $data['project'] = $project;
        $data['cityId'] = $cityId;
        $data['page_title'] =
            "Booking Request List: {$project->exam_name} (Client: {$project->client_name})";

        $data['admin'] = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/booking-request-status', $data);
        $this->load->view('layouts/footer');
    }


    // =================== Start Seat Allocation Functions =========================
    public function getAllocationModal()
    {
        $requestId = $this->input->post('request_id');

        $request = $this->db
            ->where('id', $requestId)
            ->get('tt_send_booking_request')
            ->row();

        if (!$request) {

            echo json_encode([
                'status' => 'fail'
            ]);

            exit;
        }

        $data['request'] = $request;

        $data['batchStatistics'] =
            $this->Common_model
            ->getProjectBatchStatistics(
                $request->project_id,
                $request->city_id
            );

        $data['allocatedBatch'] =

            $this->db

            ->where('request_id', $requestId)

            ->order_by('batch_no')

            ->get('tt_send_booking_request_batch')

            ->result_array();


        $html = $this->load->view(

            'dashboard/client_project/common/edit_allocation_modal',

            $data,

            true

        );

        echo json_encode([

            'status' => 'success',

            'html' => $html

        ]);
    }

    public function updateAllocation()
    {
        $requestId = $this->input->post("request_id");

        $allocation = json_decode(

            $this->input->post("allocation"),

            true

        );

        $request = $this->db

            ->where("id", $requestId)

            ->get("tt_send_booking_request")

            ->row();

        if (!$request) {

            echo json_encode([

                "status" => "fail",

                "message" => "Invalid Request."

            ]);

            exit;
        }

        $this->db->trans_begin();

        /*
        =================================
        Required Batch Seat
        =================================
        */

        $requiredBatch = [];

        $rows = $this->db
            ->select('batch_no, seat')
            ->where('project_id', $request->project_id)
            ->where('city_id', $request->city_id)
            ->get('tt_project_batch_detail')
            ->result_array();

        foreach ($rows as $r) {

            $requiredBatch[$r['batch_no']] = (int)$r['seat'];
        }


        /*
        =================================
        Center Capacity
        =================================
        */

        $center = $this->db
            ->select('capacity')
            ->where('center_id', $request->center_id)
            ->get('tt_center')
            ->row();

        /*
        ==========================
        Delete old allocation
        ==========================
        */

        $this->db

            ->where(

                "request_id",

                $requestId

            )

            ->delete(

                "tt_send_booking_request_batch"

            );

        $totalSeat = 0;

        foreach ($allocation as $row) {

            $seat = (int)$row["seat"];

            $batchNo = (int)$row["batch_no"];



            /*
            =================================
            Negative Validation
            =================================
            */

            if ($seat < 0) {

                $this->db->trans_rollback();

                echo json_encode([
                    "status" => "fail",
                    "message" => "Invalid seat value."
                ]);

                exit;
            }


            /*
            =================================
            Batch Seat Validation
            =================================
            */

            $requiredSeat = isset($requiredBatch[$batchNo])

                ? $requiredBatch[$batchNo]

                : 0;

            if ($seat > $requiredSeat) {

                $this->db->trans_rollback();

                echo json_encode([

                    "status" => "fail",

                    "message" => "Batch {$batchNo} allocation cannot exceed required seat ({$requiredSeat})."

                ]);

                exit;
            }

            /*
            =================================
            Center Capacity Per Batch Validation
            =================================
            */

            if ($seat > (int)$center->capacity) {

                $this->db->trans_rollback();

                echo json_encode([
                    "status" => "fail",
                    "message" => "Batch {$batchNo} allocation cannot exceed center capacity ({$center->capacity})."
                ]);

                exit;
            }

            $totalSeat += $seat;

            $this->db->insert(

                "tt_send_booking_request_batch",

                [

                    "request_id" => $requestId,

                    "project_id" => $request->project_id,

                    "city_id" => $request->city_id,

                    "center_id" => $request->center_id,

                    "batch_no" => $row["batch_no"],

                    "center_seat" => $seat,

                    "created_at" => date("Y-m-d H:i:s"),

                    "updated_at" => date("Y-m-d H:i:s")

                ]

            );
        }

        /*
        ==========================
        Update Summary Seat
        ==========================
        */

        $this->db

            ->where(

                "id",

                $requestId

            )

            ->update(

                "tt_send_booking_request",

                [

                    "center_seat" => $totalSeat,

                    "updated_at" => date("Y-m-d H:i:s")

                ]

            );

        /*
        ==========================
        Requirement Updated = 0
        ==========================
        */

        $this->db

            ->where(

                "project_id",

                $request->project_id

            )

            ->where(

                "exam_city_id",

                $request->city_id

            )

            ->update(

                "tt_project_detail",

                [

                    "requirement_updated" => 0

                ]

            );

        $this->db

            ->where(

                'project_id',

                $request->project_id

            )

            ->update(

                'tt_project_change_log',

                [

                    'is_read' => 1

                ]

            );

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();

            echo json_encode([

                "status" => "fail",

                "message" => "Something went wrong."

            ]);
        } else {

            $this->db->trans_commit();

            echo json_encode([

                "status" => "success",

                "message" => "Allocation updated successfully."

            ]);
        }
    }

    // =================== End Seat Allocation Functions =========================



    public function saveClientNegotiation()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $projectId = $this->input->post('project_id');
        $cityId = $this->input->post('city_id');

        $finalAmount = $this->input->post('final_amount');
        $remark = trim($this->input->post('remark'));

        if (
            empty($projectId)
            ||
            empty($finalAmount)
        ) {
            echo json_encode([
                'status' => false,
                'message' => 'Required fields missing.'
            ]);
            exit;
        }

        $project = $this->db
            ->where('project_id', $projectId)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {

            echo json_encode([
                'status' => false,
                'message' => 'Project not found.'
            ]);

            exit;
        }

        $originalAmount =
            $project->number_of_seats
            *
            $project->price_per_seat;

        $this->db
            ->where('project_id', $projectId)
            ->update(
                'tt_project_detail',
                [

                    'admin_client_final_amount'
                    => $finalAmount,

                    'client_negotiation_status'
                    => 2,

                    'client_negotiate_remark'
                    => $remark,

                    'client_negotiation_updated_at'
                    => date('Y-m-d H:i:s')

                ]
            );

        $this->db->insert(
            'tt_booking_negotiation_logs',
            [

                'booking_request_id' => 0,

                'project_id' => $projectId,

                'city_id' => $cityId,

                'client_id' => $project->client_id,

                'center_id' => 0,

                'raised_by' => 'admin',

                'old_price' => $originalAmount,

                'new_price' => $finalAmount,

                'remark' => $remark,

                'status' => 1,

                'negotiation_type' => 'client',

                'final_flag' => 1,

                'created_by'
                =>
                $this->session
                    ->userdata('admin_user')['id'],

                'created_at'
                =>
                date('Y-m-d H:i:s')

            ]
        );

        echo json_encode([

            'status' => true,

            'message'
            =>
            'Client negotiation saved successfully.'

        ]);
    }


    public function getClientNegotiationHistory()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $projectcId = $this->input->post('project_id');
        $projectcId = strtr($projectcId, '-_', '+/');
        $projectId = base64_decode($projectcId);

        $cityId = $this->input->post('city_id');

        $history = $this->db

            ->select("
                l.*,
                au.username
            ")

            ->from('tt_booking_negotiation_logs l')

            ->join(
                'tt_admin_users au',
                'au.id=l.created_by',
                'left'
            )

            ->where('l.project_id', $projectId)

            // ->where('l.city_id',$cityId)

            ->where('l.negotiation_type', 'client')

            ->order_by('l.id', 'DESC')

            ->get()

            ->result();

        echo json_encode($history);
    }


    public function clientCounterNegotiation()
    {
        $projectId = $this->input->post('project_id');
        $cityId    = $this->input->post('city_id');
        $amount    = $this->input->post('final_amount');
        $remark    = trim($this->input->post('remark'));

        if (empty($projectId) || empty($cityId) || empty($amount)) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid Request.'
            ]);
            return;
        }

        $project = $this->db
            ->where('project_id', $projectId)
            ->where('exam_city_id', $cityId)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {
            echo json_encode([
                'status' => false,
                'message' => 'Project not found.'
            ]);
            return;
        }

        $oldAmount = !empty($project->admin_client_final_amount)
            ? $project->admin_client_final_amount
            : ($project->number_of_seats * $project->price_per_seat);

        $this->db->where('project_id', $projectId);
        $this->db->where('exam_city_id', $cityId);
        $this->db->update('tt_project_detail', [

            'admin_client_final_amount' => $amount,

            'client_negotiate_remark' => $remark,

            // Admin Counter Offer
            'client_negotiation_status' => 2

        ]);

        $this->db->insert('tt_booking_negotiation_logs', [

            'project_id' => $projectId,

            'city_id' => $cityId,

            'client_id' => $project->client_id,

            'raised_by' => 'admin',

            'old_price' => $oldAmount,

            'new_price' => $amount,

            'remark' => $remark,

            'status' => 'Pending',

            'negotiation_type' => 'client',

            'created_by' => $this->session->userdata('admin_id'),

            'created_at' => date('Y-m-d H:i:s')

        ]);

        echo json_encode([

            'status' => true,

            'message' => 'Counter offer sent successfully.'

        ]);
    }


    public function clientFinalizeNegotiation()
    {
        $projectId = $this->input->post('project_id');
        $cityId    = $this->input->post('city_id');

        if (empty($projectId) || empty($cityId)) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid Request.'
            ]);
            return;
        }

        $project = $this->db
            ->where('project_id', $projectId)
            ->where('exam_city_id', $cityId)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {
            echo json_encode([
                'status' => false,
                'message' => 'Project not found.'
            ]);
            return;
        }

        $oldAmount = $project->number_of_seats * $project->price_per_seat;

        $newAmount = !empty($project->admin_client_final_amount)
            ? $project->admin_client_final_amount
            : $oldAmount;

        $this->db->where('project_id', $projectId);
        $this->db->where('exam_city_id', $cityId);
        $this->db->update('tt_project_detail', [

            // Finalized
            'client_negotiation_status' => 3

        ]);

        $this->db->insert('tt_booking_negotiation_logs', [

            'project_id' => $projectId,

            'city_id' => $cityId,

            'client_id' => $project->client_id,

            'raised_by' => 'admin',

            'old_price' => $oldAmount,

            'new_price' => $newAmount,

            'remark' => 'Negotiation Finalized',

            'status' => 'Finalized',

            'negotiation_type' => 'client',

            'final_flag' => 1,

            'created_by' => $this->session->userdata('admin_id'),

            'created_at' => date('Y-m-d H:i:s')

        ]);

        echo json_encode([

            'status' => true,

            'message' => 'Negotiation finalized successfully.'

        ]);
    }


    public function resetClientNegotiation()
    {

        $projectId = $this->input->post('project_id');

        $cityId = $this->input->post('city_id');

        $this->db

            ->where('project_id', $projectId)

            ->where('exam_city_id', $cityId)

            ->update(

                'tt_project_detail',

                [

                    'admin_client_final_amount' => NULL,

                    'client_negotiation_status' => 0,

                    'client_negotiate_remark' => NULL

                ]

            );

        echo 1;
    }



    public function acceptClientNegotiation()
    {
        if (!$this->input->is_ajax_request()) {
            exit;
        }

        $projectcId = $this->input->post('project_id');

        $projectcId = strtr($projectcId, '-_', '+/');
        $projectId = base64_decode($projectcId);

        $project = $this->db
            ->where('project_id', $projectId)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {

            echo json_encode([
                'status'  => false,
                'message' => 'Project not found.'
            ]);
            return;
        }

        $this->db
            ->where('project_id', $projectId)
            ->update('tt_project_detail', [

                // Final Amount = Client Latest Amount
                'admin_client_final_amount'
                => $project->client_negotiate_amount,

                // Finalized
                'client_negotiation_status'
                => 3
            ]);

        // History
        $this->db->insert(
            'tt_booking_negotiation_logs',
            [

                'project_id'      => $projectId,
                'client_id'       => $project->client_id,

                'old_price'
                => $project->admin_client_final_amount,

                'new_price'
                => $project->client_negotiate_amount,

                'remark'
                => 'Admin accepted client offer.',

                'status'
                => 3,

                'negotiation_type'
                => 'client',

                'created_by'
                => 'admin',

                'created_at'
                => date('Y-m-d H:i:s')
            ]
        );

        echo json_encode([
            'status'  => true,
            'message' => 'Client offer accepted successfully.'
        ]);
    }


    public function updateAdminBookingStatus()
    {

        $id = $this->input
            ->post('id');

        $status = $this->input
            ->post('status');

        $remark = $this->input
            ->post('remark') ?? 'Approved by Admin';

        $admin =

            $this->session
            ->userdata(
                'admin_user'
            );


        $update = [

            'admin_status' => $status,

            'admin_remark' => $remark,

            'admin_action_by' => $admin['id'],

            'admin_action_date' => date('Y-m-d H:i:s')

        ];


        $this->db
            ->where(
                'id',
                $id
            );

        $this->db
            ->update(

                'tt_send_booking_request',

                $update

            );

        echo json_encode([

            'status' => 'success'

        ]);
    }


    public function bulkApproveBooking()
    {

        $ids = $this->input
            ->post(
                'booking_ids'
            );

        if (
            empty($ids)
        ) {

            echo json_encode([

                'status' => 'error'

            ]);

            return;
        }

        $this->db
            ->where_in(

                'id',

                $ids

            );

        $this->db
            ->update(

                'tt_send_booking_request',

                [

                    'admin_status' => 1,

                    'admin_action_by' =>

                    $this->session
                        ->userdata(
                            'admin_user'
                        )['id'],

                    'admin_action_date' =>

                    date(
                        'Y-m-d H:i:s'

                    )

                ]

            );

        echo json_encode([

            'status' => 'success'

        ]);
    }


    public function updateSendBookingPrice()
    {
        $request_id = $this->input->post('request_id');
        $price = $this->input->post('admin_center_final_price');

        if (!$request_id || !$price) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        $this->db->where('id', $request_id)
            ->update('tt_send_booking_request', [
                'admin_center_final_price' => $price,
                'exam_center_status' => 4, // Admin Revised Price
                'updated_at' => date('Y-m-d H:i:s')
            ]);


        $booking_details = $this->db->select('
                pd.exam_name,
                pd.client_id,
                pd.client_name,
                c.center_name,
                c.address,
                ci.city_name,
                c.pin_code,

                client.email as client_email,

                center.email as center_owner_email,
                center.mobile_phone as center_owner_mobile

            ')
            ->from('tt_send_booking_request sbr')
            ->join('tt_project_detail pd', 'pd.project_id = sbr.project_id')
            ->join('tt_center c', 'c.center_id = sbr.center_id')

            // Client join
            ->join('tt_admin_users client', 'client.id = pd.client_id')

            // Center owner join
            ->join('tt_admin_users center', 'center.id = c.owner_user_id')

            ->join('tt_city_master ci', 'ci.city_id = c.city_id', 'left')
            ->where('sbr.id', $request_id)
            ->get()
            ->row();


        // Prepare negotiation email content
        $email_subject = "Update on Price Negotiation – " . $booking_details->exam_name . " | " . $booking_details->center_name;

        $email_content = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color:#333; }
                .header { color: #2c3e50; }
                .content { margin: 20px 0; }
                .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom:15px; }
                .highlight { background: #e8f4fd; padding: 15px; border-left: 4px solid #3498db; margin: 15px 0; }
                .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
            </style>
        </head>
        <body>

            <h2 class="header">Price Negotiation Update</h2>
            
            <div class="content">
                <p>Dear ' . htmlspecialchars($booking_details->center_name) . ' Team,</p>
                
                <p>
                    This is to inform you that the price negotiation request submitted by your center 
                    has been reviewed and processed by the Admin team.
                </p>

                <div class="highlight">
                    <strong>The revised pricing details have been updated in your center portal.</strong><br>
                    Kindly login to your dashboard to review the updated information and proceed accordingly.
                </div>

                <div class="details">
                    <h3>Project Details:</h3>
                    <p><strong>Exam Name:</strong> ' . htmlspecialchars($booking_details->exam_name) . '</p>
                    <p><strong>Client Name:</strong> ' . htmlspecialchars($booking_details->client_name) . '</p>
                </div>

                <div class="details">
                    <h3>Center Details:</h3>
                    <p><strong>Center Name:</strong> ' . htmlspecialchars($booking_details->center_name) . '</p>
                    <p><strong>Registered Email:</strong> ' . htmlspecialchars($booking_details->center_owner_email) . '</p>
                    <p><strong>Contact Number:</strong> ' . htmlspecialchars($booking_details->center_owner_mobile) . '</p>
                    <p><strong>Address:</strong> ' . htmlspecialchars($full_address) . '</p>
                </div>

                <p>
                    If you have any further queries, please feel free to reach out to the Admin team.
                </p>

                <p>Thank you for your cooperation.</p>

                <div class="footer">
                    Regards,<br>
                    <strong>Testpan India Team</strong><br>
                    BookMyTestCenter
                </div>
            </div>

        </body>
        </html>
        ';

        // Send email to center owner
        $send = send_email(
            $email_content,
            $email_subject,
            $booking_details->center_owner_email,
            "centerbooking@bookmytestcenter.com"
        );

        $this->session->set_flashdata('success', 'Price updated successfully');

        echo json_encode([
            'status' => 'success',
            'message' => 'Price updated successfully'
        ]);
        exit;
    }



    public function clientNegotiationManagement($encodedProjectId = NULL)
    {
        if (!$encodedProjectId) {
            show_404();
        }

        /**
         * ===============================
         * Decode URL-safe base64 project ID
         * ===============================
         */

        // 🔓 URL-safe base64 decode
        $encodedProjectId = strtr($encodedProjectId, '-_', '+/');

        // Restore removed padding
        $padding = strlen($encodedProjectId) % 4;
        if ($padding) {
            $encodedProjectId .= str_repeat(
                '=',
                4 - $padding
            );
        }

        $projectId = base64_decode(
            $encodedProjectId,
            true
        );

        if ($projectId === false || empty($projectId)) {
            show_error('Invalid Project ID');
        }


        /**
         * ===============================
         * Project info (same as old panel)
         * ===============================
         */
        $project = $this->db
            ->select('exam_name, client_name')
            ->from('tt_project_detail')
            ->where([
                'project_id' => $projectId,
                'deleted' => 0
            ])
            ->get()
            ->row();

        if (!$project) {
            show_error('Project not found for selected city.');
        }


        /**
         * ===============================
         * Booking request list (MODEL)
         * ===============================
         */
        $this->load->model('Booking_model');

        $type = $this->input->get('type');

        if (empty($type)) {
            $type = 'current';
        }

        $data['currentType'] = $type;

        $data['booking_requests'] =
            $this->Project_model->getBookingRequestStatusList($projectId, '', $type);


        /**
         * ==========================================
         * Booking Summary & Financial Summary
         * ==========================================
         */

        $summary = $this->db

            ->select("
                MAX(pd.exam_name) AS exam_name,
                MAX(pd.client_name) AS client_name,

                (
                    SELECT SUM(number_of_seats)
                    FROM tt_project_detail
                    WHERE project_id = pd.project_id
                    AND deleted = 0
                ) AS required_seats,
                MAX(pd.price_per_seat) AS client_price,
                MAX(pd.admin_price_per_seat) AS admin_price,

                MAX(pd.admin_client_final_amount) AS admin_client_final_amount,
                MAX(pd.client_negotiation_status) AS negotiation_status,
                MAX(pd.client_negotiate_remark) AS negotiation_remark,
                MAX(pd.client_negotiation_updated_at) AS negotiation_date,

                COUNT(sbr.id) AS total_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN 1
                        ELSE 0
                    END
                ) AS approved_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 0
                        THEN 1
                        ELSE 0
                    END
                ) AS pending_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 2
                        THEN 1
                        ELSE 0
                    END
                ) AS rejected_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 3
                        THEN 1
                        ELSE 0
                    END
                ) AS hold_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN sbr.center_seat
                        ELSE 0
                    END
                ) AS allocated_seats,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN
                            sbr.center_seat *
                            IFNULL(
                                sbr.admin_center_final_price,
                                pd.admin_price_per_seat
                            )
                        ELSE 0
                    END
                ) AS center_amount

            ", false)

            ->from('tt_project_detail pd')

            ->join(
                'tt_send_booking_request sbr',
                'sbr.project_id = pd.project_id
                AND sbr.city_id = pd.exam_city_id',
                'left'
            )

            ->where('pd.project_id', $projectId)

            ->where('pd.deleted', 0)

            ->get()

            ->row();


        $requiredSeats = (int)$summary->required_seats;

        $allocatedSeats = min(
            $requiredSeats,
            (int)$summary->allocated_seats
        );

        $remainingSeats = max(
            0,
            $requiredSeats - $allocatedSeats
        );

        $completion = 0;

        if ($requiredSeats > 0) {
            $completion = round(
                ($allocatedSeats / $requiredSeats) * 100
            );
        }

        $clientOriginalAmount =
            $requiredSeats *
            (float)$summary->client_price;


        $clientFinalAmount =
            !empty($summary->admin_client_final_amount)
            ?
            (float)$summary->admin_client_final_amount
            :
            $clientOriginalAmount;

        $centerAmount =
            (float)$summary->center_amount;


        /**
         * Per Seat Calculations
         */

        $originalClientRate = (float)$summary->client_price;

        $finalClientRate = 0;

        if ($requiredSeats > 0) {

            $finalClientRate =
                $clientFinalAmount / $requiredSeats;
        }

        $centerAvgRate = 0;

        if ($allocatedSeats > 0) {

            $centerAvgRate =
                $centerAmount / $allocatedSeats;
        }

        $expectedProfit =
            $clientFinalAmount -
            $centerAmount;

        $marginPercent = 0;

        if ($clientFinalAmount > 0) {
            $marginPercent = round(
                ($expectedProfit / $clientFinalAmount) * 100,
                2
            );
        }


        $data['booking_summary'] = [

            'required_seats' => $requiredSeats,

            'allocated_seats' => $allocatedSeats,

            'remaining_seats' => $remainingSeats,

            'completion' => $completion,

            'total_centers' => (int)$summary->total_centers,

            'approved_centers' => (int)$summary->approved_centers,

            'pending_centers' => (int)$summary->pending_centers,

            'rejected_centers' => (int)$summary->rejected_centers,

            'hold_centers' => (int)$summary->hold_centers,

            'client_original_amount' => $clientOriginalAmount,

            'admin_client_final_amount' => $clientFinalAmount,

            'center_amount' => $centerAmount,

            'expected_profit' => $expectedProfit,

            'margin_percent' => $marginPercent,

            'negotiation_status' => (int)$summary->negotiation_status,

            'negotiation_remark' => $summary->negotiation_remark,

            'negotiation_date' => $summary->negotiation_date,

            'original_client_rate' => round($originalClientRate, 2),

            'final_client_rate'    => round($finalClientRate, 2),

            'center_avg_rate'      => round($centerAvgRate, 2),

        ];

        /**
         * ===============================
         * View data
         * ===============================
         */
        $data['project'] = $project;
        $data['page_title'] =
            "Manage Client Negotiations : {$project->exam_name} (Client: {$project->client_name})";

        $data['admin'] = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/client-negotiation-list', $data);
        $this->load->view('layouts/footer');
    }
}
