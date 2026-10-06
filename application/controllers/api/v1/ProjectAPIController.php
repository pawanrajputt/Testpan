<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);

class ProjectAPIController extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->library("common_options");
        $this->load->helper('project_status');
        $this->load->helper('project_change_helper');
    }


    /* =======================================================
     AUTH HELPER
    ======================================================= */
    private function authenticateClient()
    {
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!$token) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'API token missing']);
            exit;
        }

        $client = $this->Common_model->getdata('tt_admin_users', [
            'api_token' => $token,
            'role_id'   => 12
        ]);

        if (!$client) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'Invalid API token']);
            exit;
        }

        return $client;
    }

    /**
     * POST /api/client/createProject
     * Create new project with multiple cities and batches
     */
    public function createProject()
    {
        $this->output->set_content_type('application/json');

        try {
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            $exam_name = $this->input->post('exam_name');
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // Get input data
            $invigilator_ratio_1 = trim($this->input->post('invigilator_ratio_1'));
            $invigilator_ratio_2 = trim($this->input->post('invigilator_ratio_2'));
            $invigilator_ratio = $invigilator_ratio_1 . ':' . $invigilator_ratio_2;
            $invigilator_male = trim($this->input->post('invigilator_male'));
            $invigilator_female = trim($this->input->post('invigilator_female'));

            $sucurity_guard_ratio1 = trim($this->input->post('security_guard_ratio_1'));
            $sucurity_guard_ratio2 = trim($this->input->post('security_guard_ratio_2'));
            $sucurity_guard_ratio = $sucurity_guard_ratio1 . ':' . $sucurity_guard_ratio2;
            $security_guard_male = trim($this->input->post('security_guard_male'));
            $security_guard_female = trim($this->input->post('security_guard_female'));

            $tech_person_count = trim($this->input->post('tech_person_count'));
            $center_suptn_count = trim($this->input->post('center_suptn_count'));

            $tt_admin_users = $this->Common_model->getdata('tt_admin_users', ['id' => $ac_id]);

            $city_name_val = $this->input->post('city_id');
            $citySeats     = $this->input->post('city_seats');
            $cityBatches   = $this->input->post('batch');

            // Handle if single city sent as string, convert to array
            if (!is_array($city_name_val)) {
                $city_name_val = [$city_name_val];
                $citySeats = [$city_name_val[0] => $citySeats];
                $cityBatches = [$city_name_val[0] => $cityBatches];
            }

            $cityCount = count($city_name_val);

            $companyName = preg_replace('/[^A-Za-z]/', '', $tt_admin_users->username);
            $projectName = preg_replace('/[^A-Za-z]/', '', $exam_name);

            $companyCode = strtoupper(substr($companyName, 0, 4));
            $projectCode = strtoupper(substr($projectName, 0, 4));

            $examDate = date('d-m-Y', strtotime($this->input->post('start_date')));
            $project_group_id = $companyCode . '-' . $projectCode . '-' . $examDate;

            // Check if project already exists (optional)
            $oldProject = $this->Common_model->getdata('tt_project_detail', ['project_id' => $project_group_id]);

            for ($k = 0; $k < $cityCount; $k++) {
                $cityId = $city_name_val[$k];
                $state_ids = $this->db->select('state_id')->where('city_id', $cityId)->get('tt_city_master')->row()->state_id;

                $projectData = [
                    'project_id'    => $project_group_id,
                    'client_id'     => $ac_id,
                    'created_by'    => $ac_id,
                    'client_name'   => $tt_admin_users->username,
                    'exam_name'    => $this->input->post('exam_name'),
                    'exam_type'    => $this->input->post('exam_category'),
                    "state_id" => $state_ids,
                    "exam_city_id" => $cityId,
                    "exam_city_name" => $this->common_options->get_city_name($cityId),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'total_batch' => isset($cityBatches[$cityId]) ? count($cityBatches[$cityId]) : 0,
                    'batch1_start' => null,
                    'batch1_end'   => null,
                    'batch2_start' => null,
                    'batch2_end'   => null,
                    'batch3_start' => null,
                    'batch3_end'   => null,
                    'batch4_start' => null,
                    'batch4_end'   => null,
                    'batch5_start' => null,
                    'batch5_end'   => null,
                    'exam_mode' => $this->input->post('exam_mode'),
                    'inet_mode_os' => $this->input->post('operating_system'),
                    'inet_mode_ram'    => $this->input->post('ram'),
                    'inet_mode_display' => $this->input->post('display_resolution'),
                    'inet_mode_internet_each' => $this->input->post('internet_on_each_device') ?? 0,
                    'parking_facility' => $this->input->post('parking') ?? 0,
                    'security_guard' => $this->input->post('security_guard') ?? 'male',
                    'locker_facility' => $this->input->post('lockers') ?? 0,
                    'waiting_area'        => $this->input->post('waiting_area') ?? 0,
                    'power_backup' => $this->input->post('power_backup') ?? 0,
                    'ph_handicaped' => $this->input->post('ph_handicapped') ?? 0,
                    'printer'    => $this->input->post('printer') ?? 0,
                    'rough_sheet' => $this->input->post('rough_sheet') ?? 0,
                    'partition_in_lab' => $this->input->post('partition') ?? 0,
                    'ac_in_lab' => $this->input->post('ac_in_lab') ?? 0,
                    'cctv_required'         => $this->input->post('cctv_required') ?? 0,
                    'cctv_recording'         => $this->input->post('cctv_recording') ?? 0,
                    "tech_person_count" => $tech_person_count,
                    "center_suptn_count" => $center_suptn_count,
                    "invigilator_ratio" => $invigilator_ratio,
                    "security_guard_ratio" => $sucurity_guard_ratio,
                    "invigilator_female" => $invigilator_female,
                    "invigilator_male" => $invigilator_male,
                    "security_guard_male" => $security_guard_male,
                    "security_guard_female" => $security_guard_female,
                    "number_of_seats"   => isset($citySeats[$cityId]) ? $citySeats[$cityId] : 0,
                    "exam_required_seat"   => isset($citySeats[$cityId]) ? $citySeats[$cityId] : 0,
                    "price_per_seat" => $this->input->post('price_per_seat'),
                    "admin_price_per_seat" => $this->input->post('price_per_seat'),
                    "client_negotiate_amount" => (
                        (isset($citySeats[$cityId]) ? $citySeats[$cityId] : 0)
                        *
                        $this->input->post('price_per_seat')
                    ),
                    "admin_client_final_amount" => (
                        (isset($citySeats[$cityId]) ? $citySeats[$cityId] : 0)
                        *
                        $this->input->post('price_per_seat')
                    ),
                    "client_negotiate_remark" => null,
                    "client_negotiation_status" => 0,
                    'created_on' => $oldProject ? $oldProject->created_on : $updated_at,
                    'last_modified_on' => $updated_at,
                ];

                $this->Common_model->insertData('tt_project_detail', $projectData);

                // Insert batches
                if (!empty($cityBatches[$cityId])) {
                    foreach ($cityBatches[$cityId] as $batchNo => $batch) {
                        $batchData = [
                            'project_id' => $project_group_id,
                            'city_id'    => $cityId,
                            'batch_no'   => $batchNo,
                            'batch_start' => $batch['start'],
                            'batch_end'  => $batch['end'],
                            'seat'       => $batch['seat'],
                            'created_at' => $created_at,
                            'updated_at' => $updated_at
                        ];
                        $this->db->insert('tt_project_batch_detail', $batchData);
                    }
                }
            }

            // Send email notification (using private method)
            $this->_sendProjectCreationEmail($client, $project_group_id, $exam_name);

            // Insert notification
            $notification_data = [
                'admin_user_id' => $tt_admin_users->id,
                'center_id'     => null,
                'client_id'     => $ac_id,
                'title'         => "New Project Created",
                'message'       => "Client has created new project. Project Name: {$exam_name} Client Name: {$tt_admin_users->username} and Email: {$tt_admin_users->email}",
                'type'          => 'admin',
                'is_read'       => 0,
                'is_remove'     => 0,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $this->db->insert('notifications', $notification_data);

            $this->output
                ->set_status_header(201)
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Project created successfully!',
                    'data' => [
                        'project_id' => $project_group_id
                    ]
                ]));
        } catch (Exception $e) {
            $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }

    /**
     * Private method to send project creation email
     */
    private function _sendProjectCreationEmail($client, $project_group_id, $exam_name)
    {
        $email_subject = "New Project Created: " . $exam_name;
        $email_content = $this->_getProjectCreationEmailContent($client, $project_group_id);
        send_email(
            $email_content,
            $email_subject,
            "admin@testpanindia.com",
            "centerbooking@bookmytestcenter.com"
        );
    }

    /**
     * Get project creation email HTML content
     */
    private function _getProjectCreationEmailContent($client, $project_group_id)
    {
        return '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .header { color: #2c3e50; }
                    .content { margin: 20px 0; }
                    .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                    .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                </style>
            </head>
            <body>
                <h2 class="header">New Project Created</h2>
                <div class="content">
                    <p>Hello BMTC Admin,</p>
                    <p>A new project has been created by <strong>' . htmlspecialchars($client->username) . '</strong>.</p>
                    <div class="details">
                        <h3>Project Details:</h3>
                        <p><strong>Project ID:</strong> ' . htmlspecialchars($project_group_id) . '</p>
                        <p><strong>Exam Name:</strong> ' . htmlspecialchars($this->input->post('exam_name')) . '</p>
                        <p><strong>Exam Type:</strong> ' . htmlspecialchars($this->input->post('exam_category')) . '</p>
                        <p><strong>Start Date:</strong> ' . htmlspecialchars($this->input->post('start_date')) . '</p>
                        <p><strong>End Date:</strong> ' . htmlspecialchars($this->input->post('end_date')) . '</p>
                        <p><strong>Number of Seats:</strong> ' . htmlspecialchars($this->input->post('number_of_seats')) . '</p>
                    </div>
                </div>
            </body>
            </html>
        ';
    }


    /**
     * GET /api/client/editProject/:project_id
     * Returns project details for editing
     */
    public function editProject($project_id = null)
    {
        $this->output->set_content_type('application/json');

        try {
            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Validate project_id
            if (empty($project_id)) {
                throw new Exception('Project ID is required.');
            }

            // 3. Fetch project details (all rows for this project)
            $projectData = $this->db
                ->where('project_id', $project_id)
                ->get('tt_project_detail')
                ->result();

            if (empty($projectData)) {
                throw new Exception('Project not found.', 404);
            }

            // 4. Security: ensure project belongs to authenticated client
            if ($projectData[0]->client_id != $ac_id) {
                throw new Exception('You are not authorized to view this project.', 403);
            }

            // 5. Prepare data
            $data = [
                'project' => $projectData[0],               // first row as project header
                'projectCities' => $projectData,            // all city rows
                'selectedCities' => array_column($projectData, 'exam_city_id'),
                'city' => $this->db->get('tt_city_master')->result_array(),
                'projectBatchData' => []                    // will be filled below
            ];

            // 6. Fetch batches
            $batches = $this->db
                ->where('project_id', $project_id)
                ->order_by('city_id')
                ->order_by('batch_no')
                ->get('tt_project_batch_detail')
                ->result();

            // Group batches by city_id
            $batchGrouped = [];
            foreach ($batches as $row) {
                $batchGrouped[$row->city_id][] = $row;
            }
            $data['projectBatchData'] = $batchGrouped;

            // 7. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Project details fetched successfully.',
                    'data'    => $data
                ]));
        } catch (Exception $e) {
            $statusCode = ($e->getCode() >= 400 && $e->getCode() < 600) ? $e->getCode() : 500;
            $this->output
                ->set_status_header($statusCode)
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }

    /**
     * PUT /api/v1/client/update-project
     * Update project details (accepts JSON or form-data)
     */
    public function updateProject()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get form-data input
            $input = $this->input->post();

            // 3. Validate required fields
            $required = [
                'project_id',
                'city_id',
                'exam_name',
                'start_date',
                'end_date',
                'price_per_seat'
            ];

            foreach ($required as $field) {
                if (!isset($input[$field]) || $input[$field] === '' || $input[$field] === null) {
                    throw new Exception("Missing required field: {$field}", 400);
                }
            }

            // 4. City IDs
            $city_ids = $input['city_id'];

            // Same format as createProject
            if (!is_array($city_ids)) {
                $city_ids = [$city_ids];
            }

            $city_ids = array_map('intval', $city_ids);

            // 5. Project ID
            $project_id = $input['project_id'];

            $updated_at = date('Y-m-d H:i:s');

            // 6. Prepare ratios
            $invigilator_ratio = ($input['invigilator_ratio_1'] ?? '') . ':' .
                ($input['invigilator_ratio_2'] ?? '');

            $security_ratio = ($input['security_guard_ratio_1'] ?? '') . ':' .
                ($input['security_guard_ratio_2'] ?? '');

            // 7. City seats and batches
            $city_seats = $input['city_seats'] ?? [];
            $batchData  = $input['batch'] ?? [];

            // Handle single city
            if (!is_array($city_seats)) {

                $city_seats = [
                    $city_ids[0] => $city_seats
                ];
            }

            if (!is_array($batchData)) {
                $batchData = [];
            }

            // =====================================================
            // Transaction Start
            // =====================================================

            $this->db->trans_begin();

            // =====================================================
            // Get Existing Project Data
            // =====================================================

            $oldProjects = [];

            $oldRows = $this->db
                ->where('project_id', $project_id)
                ->where('client_id', $ac_id)
                ->where('deleted', 0)
                ->get('tt_project_detail')
                ->result();

            if (empty($oldRows)) {
                throw new Exception('Project not found.', 404);
            }

            foreach ($oldRows as $row) {
                $oldProjects[$row->exam_city_id] = $row;
            }

            // =====================================================
            // Get Existing Batch Data
            // =====================================================

            $oldProjectBatches = [];

            $oldBatchRows = $this->db
                ->where('project_id', $project_id)
                ->get('tt_project_batch_detail')
                ->result_array();

            foreach ($oldBatchRows as $row) {

                $oldProjectBatches[$row['city_id']][$row['batch_no']] = $row;
            }

            // =====================================================
            // Removed City Log
            // =====================================================

            foreach ($oldProjects as $oldCityId => $oldProjectRow) {

                if (!in_array($oldCityId, $city_ids, true)) {

                    if (function_exists('saveProjectChangeLog')) {

                        saveProjectChangeLog(
                            $project_id,
                            $oldCityId,
                            'CITY_REMOVED',
                            [
                                'city' => $oldProjectRow->exam_city_name,
                                'seat' => $oldProjectRow->number_of_seats
                            ],
                            null,
                            $ac_id
                        );
                    }
                }
            }

            // =====================================================
            // Delete Existing Project Data
            // =====================================================

            $this->db
                ->where('project_id', $project_id)
                ->where('client_id', $ac_id)
                ->delete('tt_project_detail');

            $this->db
                ->where('project_id', $project_id)
                ->delete('tt_project_batch_detail');

            // =====================================================
            // Process Cities
            // =====================================================

            foreach ($city_ids as $cityId) {

                $oldProject = $oldProjects[$cityId] ?? null;

                $isRequirementChanged = 0;

                // -------------------------------------------------
                // City Seats
                // -------------------------------------------------

                $seat = isset($city_seats[$cityId])
                    ? (int)$city_seats[$cityId]
                    : 0;

                // -------------------------------------------------
                // Compare City
                // -------------------------------------------------

                if (!$oldProject) {

                    if (function_exists('saveProjectChangeLog')) {

                        saveProjectChangeLog(
                            $project_id,
                            $cityId,
                            'CITY_ADDED',
                            null,
                            [
                                'city' => $this->common_options->get_city_name($cityId),
                                'seat' => $seat
                            ],
                            $ac_id
                        );
                    }

                    $isRequirementChanged = 1;
                } else {

                    if ((int)$oldProject->number_of_seats != $seat) {

                        if (function_exists('saveProjectChangeLog')) {

                            saveProjectChangeLog(
                                $project_id,
                                $cityId,
                                'SEAT_UPDATED',
                                [
                                    'seat' => $oldProject->number_of_seats
                                ],
                                [
                                    'seat' => $seat
                                ],
                                $ac_id
                            );
                        }

                        $isRequirementChanged = 1;
                    }
                }

                // =================================================
                // Compare Batch
                // =================================================

                $oldBatchMap = [];
                $oldBatchCount = 0;

                if (isset($oldProjectBatches[$cityId])) {

                    foreach ($oldProjectBatches[$cityId] as $row) {

                        $oldBatchMap[$row['batch_no']] = $row['seat'];
                    }

                    $oldBatchCount = count($oldProjectBatches[$cityId]);
                }

                $newBatchCount = 0;

                if (isset($batchData[$cityId]) && is_array($batchData[$cityId])) {

                    $newBatchCount = count($batchData[$cityId]);
                }

                if ($oldProject && $oldBatchCount != $newBatchCount) {

                    if (function_exists('saveProjectChangeLog')) {

                        saveProjectChangeLog(
                            $project_id,
                            $cityId,
                            'BATCH_UPDATED',
                            [
                                'batch' => $oldBatchCount
                            ],
                            [
                                'batch' => $newBatchCount
                            ],
                            $ac_id
                        );
                    }

                    $isRequirementChanged = 1;
                }

                // Compare batch seats
                if (isset($batchData[$cityId]) && is_array($batchData[$cityId])) {

                    foreach ($batchData[$cityId] as $batchNo => $batch) {

                        $newSeat = (int)($batch['seat'] ?? 0);

                        if (isset($oldBatchMap[$batchNo])) {

                            $oldSeat = (int)$oldBatchMap[$batchNo];

                            if ($oldSeat != $newSeat) {

                                if (function_exists('saveProjectChangeLog')) {

                                    saveProjectChangeLog(
                                        $project_id,
                                        $cityId,
                                        'BATCH_SEAT_UPDATED',
                                        [
                                            'batch' => $batchNo,
                                            'seat' => $oldSeat
                                        ],
                                        [
                                            'batch' => $batchNo,
                                            'seat' => $newSeat
                                        ],
                                        $ac_id
                                    );
                                }

                                $isRequirementChanged = 1;
                            }
                        }
                    }
                }

                // =================================================
                // State
                // =================================================

                $state_info = $this->db
                    ->select('state_id')
                    ->where('city_id', $cityId)
                    ->get('tt_city_master')
                    ->row();

                $state_id = $state_info
                    ? $state_info->state_id
                    : null;

                // =================================================
                // Default Amount
                // =================================================

                $defaultAmount =
                    $seat * ($input['price_per_seat'] ?? 0);

                // =================================================
                // Project Data
                // =================================================

                $updateData = [

                    'project_id' => $project_id,

                    'client_id' => $ac_id,

                    'client_name' =>
                    $input['client_name'] ?? $client->username,

                    'exam_name' =>
                    $input['exam_name'],

                    'exam_type' =>
                    $input['exam_category'] ?? '',

                    'state_id' =>
                    $state_id,

                    'exam_city_id' =>
                    $cityId,

                    'exam_city_name' =>
                    $this->common_options->get_city_name($cityId),

                    'start_date' =>
                    $input['start_date'],

                    'end_date' =>
                    $input['end_date'],

                    'total_batch' =>
                    $newBatchCount,

                    'exam_mode' =>
                    $input['exam_mode'] ?? '',

                    'inet_mode_os' =>
                    $input['operating_system'] ?? '',

                    'inet_mode_ram' =>
                    $input['ram'] ?? '',

                    'inet_mode_display' =>
                    $input['display_resolution'] ?? '',

                    'inet_mode_internet_each' =>
                    $input['internet_on_each_device'] ?? 0,

                    'parking_facility' =>
                    $input['parking'] ?? 0,

                    'security_guard' =>
                    $input['security_guard'] ?? 'male',

                    'locker_facility' =>
                    $input['lockers'] ?? 0,

                    'waiting_area' =>
                    $input['waiting_area'] ?? 0,

                    'power_backup' =>
                    $input['power_backup'] ?? 0,

                    'ph_handicaped' =>
                    $input['ph_handicapped'] ?? 0,

                    'printer' =>
                    $input['printer'] ?? 0,

                    'rough_sheet' =>
                    $input['rough_sheet'] ?? 0,

                    'partition_in_lab' =>
                    $input['partition'] ?? 0,

                    'ac_in_lab' =>
                    $input['ac_in_lab'] ?? 0,

                    'cctv_required' =>
                    $input['cctv_required'] ?? 0,

                    'cctv_recording' =>
                    $input['cctv_recording'] ?? 0,

                    'tech_person_count' =>
                    $input['tech_person_count'] ?? '',

                    'center_suptn_count' =>
                    $input['center_suptn_count'] ?? '',

                    'invigilator_ratio' =>
                    $invigilator_ratio,

                    'security_guard_ratio' =>
                    $security_ratio,

                    'invigilator_male' =>
                    $input['invigilator_male'] ?? '',

                    'invigilator_female' =>
                    $input['invigilator_female'] ?? '',

                    'security_guard_male' =>
                    $input['security_guard_male'] ?? '',

                    'security_guard_female' =>
                    $input['security_guard_female'] ?? '',

                    'number_of_seats' =>
                    $seat,

                    'exam_required_seat' =>
                    $seat,

                    'price_per_seat' =>
                    $input['price_per_seat'] ?? 0,

                    'admin_price_per_seat' =>
                    $input['price_per_seat'] ?? 0,

                    'client_negotiate_amount' =>
                    $oldProject
                        ? $oldProject->client_negotiate_amount
                        : $defaultAmount,

                    'admin_client_final_amount' =>
                    $oldProject
                        ? $oldProject->admin_client_final_amount
                        : $defaultAmount,

                    'client_negotiate_remark' =>
                    $oldProject
                        ? $oldProject->client_negotiate_remark
                        : null,

                    'client_negotiation_status' =>
                    $oldProject
                        ? $oldProject->client_negotiation_status
                        : 0,

                    'client_negotiation_updated_at' =>
                    $oldProject
                        ? $oldProject->client_negotiation_updated_at
                        : null,

                    'status' =>
                    $oldProject
                        ? $oldProject->status
                        : 0,

                    'valid' =>
                    $oldProject
                        ? $oldProject->valid
                        : 1,

                    'deleted' => 0,

                    'manual_status' =>
                    $oldProject
                        ? $oldProject->manual_status
                        : 0,

                    'has_future_date' =>
                    $oldProject
                        ? $oldProject->has_future_date
                        : 0,

                    'old_start_date' =>
                    $oldProject
                        ? $oldProject->old_start_date
                        : null,

                    'old_end_date' =>
                    $oldProject
                        ? $oldProject->old_end_date
                        : null,

                    'project_remark' =>
                    $oldProject
                        ? $oldProject->project_remark
                        : null,

                    'created_on' =>
                    $oldProject
                        ? $oldProject->created_on
                        : $updated_at,

                    'last_modified_on' =>
                    $updated_at,

                    'requirement_updated' =>
                    $isRequirementChanged,
                ];

                // =================================================
                // Reset Negotiation If Requirement Changed
                // =================================================

                if ($isRequirementChanged) {

                    $updateData['client_negotiate_amount'] =
                        $defaultAmount;

                    $updateData['admin_client_final_amount'] =
                        $defaultAmount;

                    $updateData['client_negotiate_remark'] =
                        null;

                    $updateData['client_negotiation_status'] =
                        0;

                    $updateData['client_negotiation_updated_at'] =
                        null;

                    $updateData['status'] =
                        0;
                }

                // =================================================
                // Insert Updated Project
                // =================================================

                $this->db->insert(
                    'tt_project_detail',
                    $updateData
                );

                // =================================================
                // Insert Batch Details
                // =================================================

                if (
                    isset($batchData[$cityId]) &&
                    is_array($batchData[$cityId])
                ) {

                    foreach ($batchData[$cityId] as $batchNo => $batch) {

                        $this->db->insert(
                            'tt_project_batch_detail',
                            [
                                'project_id' =>
                                $project_id,

                                'city_id' =>
                                $cityId,

                                'batch_no' =>
                                $batchNo,

                                'batch_start' =>
                                $batch['start'] ?? null,

                                'batch_end' =>
                                $batch['end'] ?? null,

                                'seat' =>
                                (int)($batch['seat'] ?? 0),

                                'created_at' =>
                                $updated_at,

                                'updated_at' =>
                                $updated_at
                            ]
                        );
                    }
                }
            }

            // =====================================================
            // Transaction Check
            // =====================================================

            if ($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();

                throw new Exception(
                    'Something went wrong while updating.',
                    500
                );
            }

            $this->db->trans_commit();

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Project updated successfully.',
                    'data'    => [
                        'project_id' => $project_id
                    ]
                ]));
        } catch (Exception $e) {

            $this->db->trans_rollback();

            $code = (
                $e->getCode() >= 400 &&
                $e->getCode() < 600
            )
                ? $e->getCode()
                : 500;

            return $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }


    /**
     * POST /api/v1/client/detail-project
     * Get project details with city-wise summary, booking info, etc.
     */
    public function detailProject()
    {
        $this->output->set_content_type('application/json');

        try {
            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get input from Form Data
            $project_id = $this->input->post('project_id');

            if (empty($project_id)) {
                throw new Exception('Project ID is required.', 400);
            }

            // 3. Fetch project detail (ensure project belongs to this client)
            $project = $this->Common_model->getProjectDetail($project_id);

            if (!$project) {
                throw new Exception('Project not found.', 404);
            }

            if ($project->client_id != $ac_id) {
                throw new Exception('You are not authorized to view this project.', 403);
            }

            // 4. Get exam booking details
            $exam_booking_detail = $this->Common_model->getAssignCenterForAc(
                $project->project_id ?? 0
            );

            // 5. Total cities covered in this project
            $this->db->select("COUNT(DISTINCT exam_city_id) AS total_cities");
            $this->db->from("tt_project_detail");
            $this->db->where("project_id", $project_id);
            $totalCityCovered = $this->db->get()->row();

            // 6. Approved center count
            $approvedCenter = $this->Common_model->get_approved_center_count(
                'tt_send_booking_request',
                $ac_id,
                $project_id
            );

            // 7. City-wise seat summary
            $cityWiseSummary = $this->Common_model->get_city_wise_seat_summary(
                $project_id,
                $ac_id
            );

            $cities = $cityWiseSummary;

            // 8. Adjusted booked and required seats
            $adjustedBooked = 0;
            $adjustedRequired = 0;

            foreach ($cityWiseSummary as $city) {

                $reqSeats = (int)($city['total_seats'] ?? 0);
                $booked   = (int)($city['booked_seats'] ?? 0);

                $adjustedBooked   += min($booked, $reqSeats);
                $adjustedRequired += $reqSeats;
            }

            // 9. Build response
            $responseData = [
                'project'             => $project,
                'exam_booking_detail' => $exam_booking_detail,
                'totalCityCovered'    => $totalCityCovered,
                'approvedCenter'      => $approvedCenter,
                'cityWiseSummary'     => $cityWiseSummary,
                'cities'              => $cities,
                'totalBookedSeat'     => $adjustedBooked,
                'number_of_seats'     => $adjustedRequired,
            ];

            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Project details fetched successfully.',
                    'data'    => $responseData
                ]));
        } catch (Exception $e) {

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }

    /**
     * POST /api/v1/client/delete-project
     * Delete project details with city-wise summary, booking info, etc.
     */
    public function deleteProject()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get project ID from Form Data
            $project_id = $this->input->post('project_id');

            if (empty($project_id)) {
                throw new Exception('Project ID is required.', 400);
            }

            // 3. Check if project belongs to this client
            $this->db->from('tt_project_detail');
            $this->db->where('project_id', $project_id);
            $this->db->where('client_id', $ac_id);
            $this->db->where('deleted', 0);

            $project = $this->db->get()->row();

            if (!$project) {
                throw new Exception('Project not found.', 404);
            }

            // 4. Check if any booking exists for this project
            $this->db->from('tt_send_booking_request');
            $this->db->where('project_id', $project_id);

            $bookingCount = $this->db->count_all_results();

            // 5. If booking exists → block delete
            if ($bookingCount > 0) {
                throw new Exception(
                    'This project cannot be deleted because bookings already exist.',
                    400
                );
            }

            // 6. Safe soft delete
            $updateData = [
                'deleted' => 1
            ];

            $this->Common_model->UpdateRecord(
                'tt_project_detail',
                $updateData,
                [
                    'project_id' => $project_id,
                    'client_id'  => $ac_id
                ]
            );

            // 7. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Project deleted successfully.'
                ]));
        } catch (Exception $e) {

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }

    /**
     * POST /api/v1/client/view-project-detail
     * View project details with city-wise summary, booking info, etc.
     */
    public function viewProjectDetail()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get project ID from Form Data
            $project_id = $this->input->post('project_id');

            if (empty($project_id)) {
                throw new Exception('Project ID is required.', 400);
            }

            // 3. Fetch project detail
            $projects = $this->Common_model->viewProjectDetail($project_id);

            if (empty($projects)) {
                throw new Exception('Project not found.', 404);
            }

            // 4. Check project belongs to this client
            $project = $projects[0];

            if ($project->client_id != $ac_id) {
                throw new Exception(
                    'You are not authorized to view this project.',
                    403
                );
            }

            // 5. Get project batches
            $project_batches = $this->db
                ->where('project_id', $project_id)
                ->order_by('city_id')
                ->order_by('batch_no')
                ->get('tt_project_batch_detail')
                ->result();

            // 6. Build API response
            $responseData = [
                'project'        => $project,
                'project_batches' => $project_batches
            ];

            // 7. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Project details fetched successfully.',
                    'data'    => $responseData
                ]));
        } catch (Exception $e) {

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }


    /**
     * POST /api/v1/client/view-exam-center-detail
     * View exam center details etc.
     */
    public function detailExamCenter()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get input from Form Data
            $center_id = $this->input->post('center_id');
            $project_id = $this->input->post('project_id');

            if (empty($center_id)) {
                throw new Exception('Center ID is required.', 400);
            }

            if (empty($project_id)) {
                throw new Exception('Project ID is required.', 400);
            }

            // 3. Fetch center detail
            $result = $this->Common_model->getdata(
                'tt_center',
                ['center_id' => $center_id]
            );

            if (!$result) {
                throw new Exception('Exam center not found.', 404);
            }

            // 4. Fetch labs
            $labs = $this->Common_model->getdata_array(
                'tt_lab',
                ['center_id' => $center_id]
            );

            // 5. Fetch documents
            $documents = $this->Common_model->getdata_array(
                'tt_center_document',
                ['center_id' => $center_id]
            );

            // 6. Fetch images
            $images = $this->Common_model->getdata_array(
                'tt_center_images',
                [
                    'center_id' => $center_id,
                    'deleted'   => 0
                ]
            );

            // 7. Build response
            $responseData = [
                'result'     => $result,
                'labs'       => $labs,
                'documents'  => $documents,
                'images'     => $images,
                'project_id' => $project_id
            ];

            // 8. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Exam center details fetched successfully.',
                    'data'    => $responseData
                ]));
        } catch (Exception $e) {

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }

    /**
     * POST /api/v1/client/update-center-booking-status
     * Update exam center booking status.
     */
    public function updateCenterBookingStatus()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get input from Form Data
            $center_id  = $this->input->post('center_id');
            $project_id = $this->input->post('project_id');
            $type       = $this->input->post('type');

            if (empty($center_id) || empty($project_id) || empty($type)) {
                throw new Exception('Invalid request.', 400);
            }

            // 3. Approve / Reject
            $client_status = ($type == 'approve') ? 1 : 2;

            // 4. Check booking belongs to this client
            $this->db->from('tt_send_booking_request');
            $this->db->where('center_id', $center_id);
            $this->db->where('project_id', $project_id);
            $this->db->where('client_id', $ac_id);

            $booking = $this->db->get()->row();

            if (!$booking) {
                throw new Exception('Booking not found.', 404);
            }

            // 5. Update booking status
            $data = [
                'client_status'              => $client_status,
                'client_accept_booking_date' => date('Y-m-d H:i:s')
            ];

            $where = [
                'center_id'  => $center_id,
                'project_id' => $project_id,
                'client_id'  => $ac_id
            ];

            $this->Common_model->UpdateRecord(
                'tt_send_booking_request',
                $data,
                $where
            );

            // 6. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Booking status updated successfully.'
                ]));
        } catch (Exception $e) {

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }
}
