<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DashboardController extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->library("common_options");
        $this->load->helper('project_status');
        $this->load->helper('project_change_helper');

        if (empty($this->session->userdata('ac_id'))) {
            return redirect('signup');
        }
    }


    public function dashboard()
    {
        $ac_id = $this->session->userdata('ac_id');
        $data['result'] = $this->Common_model->getSignleClientData($ac_id);
        $data['city'] = $this->Common_model->getdata_array('tt_city_master', []);
        $data['projects'] = $this->Common_model->getClientProjectDataGroupBy($ac_id, '');
        $data['pendingProjects'] = $this->Common_model->getClientProjectDataGroupBy($ac_id, 'pending');
        $data['completeProjects'] = $this->Common_model->getClientProjectDataGroupBy($ac_id, 'completed');
        $data['totalProjectCount'] = count($data['projects']);

        $summary = $this->Common_model->get_total_assessed_candidates($ac_id);
        $data['totalAssessed'] = $summary['assessed'];
        $data['totalRequired'] = $summary['required'];

        $data['totalCityCovered'] = $this->Common_model->get_total_cities_covered($ac_id);

        // total cities available in system (from master table)
        $totalSystemCities = $this->db->count_all('tt_city_master');
        $data['cityPercent'] = ($totalSystemCities > 0)
            ? round(($data['totalCityCovered']->total_cities / $totalSystemCities) * 100)
            : 0;

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    private function export_to_excel($bookings, $tab = null)
    {
        try {
            // Filter bookings based on active tab
            $filteredBookings = [];
            $today = new DateTime();

            foreach ($bookings as $booking) {
                $endDate = new DateTime($booking->end_date);

                // Apply tab filter if specified
                if ($tab === 'past' && $endDate >= $today)
                    continue;
                if ($tab === 'upcoming' && $endDate < $today)
                    continue;

                $filteredBookings[] = $booking;
            }

            // Check if we have data to export
            if (empty($filteredBookings)) {
                throw new Exception('No bookings found matching the selected tab');
            }

            // Create new Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers with styling
            $headers = [
                'Exam Name',
                'Start Date',
                'End Date',
                'Status',
                'Cities Covered',
                'Centers Booked',
                'Candidates Assessed',
                'Exam Type'
            ];
            $sheet->fromArray($headers, null, 'A1');

            // Style headers
            $sheet->getStyle('A1:H1')
                ->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => Color::COLOR_WHITE]],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4472C4']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ]);

            // Add data
            $row = 2;
            foreach ($filteredBookings as $booking) {
                $status = $this->get_booking_status($booking);

                $sheet->setCellValue('A' . $row, $booking->exam_name)
                    ->setCellValue('B' . $row, $booking->start_date)
                    ->setCellValue('C' . $row, $booking->end_date)
                    ->setCellValue('D' . $row, $status)
                    ->setCellValue('E' . $row, $this->get_cities_count($booking->project_id))
                    ->setCellValue('F' . $row, $this->get_centers_count($booking->project_id))
                    ->setCellValue('G' . $row, $booking->number_of_seats)
                    ->setCellValue('H' . $row, $booking->exam_type_detail);
                $row++;
            }

            // Auto-size columns
            foreach (range('A', 'H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Create and output file
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="bookings_' . date('Ymd_His') . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            log_message('error', 'Excel export failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('dashboard');
        }
    }

    private function get_booking_status($booking)
    {
        $today = new DateTime();
        $start = new DateTime($booking->start_date);
        $end = new DateTime($booking->end_date);

        if ($today < $start)
            return "Upcoming";
        if ($today <= $end)
            return "In Progress";
        return "Completed";
    }

    private function get_cities_count($project_id)
    {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT exam_city_id) AS total_cities 
             FROM tt_project_detail 
             WHERE project_id = ?",
            [$project_id]
        );
        return $query->row()->total_cities;
    }

    private function get_centers_count($project_id)
    {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT center_id) AS total_booked_center 
             FROM tt_send_booking_request 
             WHERE project_id = ?",
            [$project_id]
        );
        return $query->row()->total_booked_center;
    }

    public function deleteAccount()
    {
        $ac_id = $this->input->post('ac_id');

        if (!$ac_id) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid account.'
            ]);
            return;
        }

        // Check projects exist
        $this->db->from('tt_project_detail');
        $this->db->where('client_id', $ac_id);
        $this->db->where('deleted', 0);
        $projectCount = $this->db->count_all_results();

        // Check booking requests exist
        $this->db->from('tt_send_booking_request');
        $this->db->where('client_id', $ac_id);
        $bookingCount = $this->db->count_all_results();

        // Stop if related records exist
        if ($projectCount > 0 || $bookingCount > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Account cannot be deleted because bookings or projects are associated with this account.'
            ]);
            return;
        }

        // Soft Delete
        $data = ['deleted' => 1];

        $this->Common_model->UpdateRecord('tt_admin_users', $data, ['id' => $ac_id]);
        $this->Common_model->UpdateRecord('tt_client', $data, ['ac_id' => $ac_id]);

        echo json_encode([
            'status' => true,
            'message' => 'Account deleted successfully.'
        ]);
    }


    public function createProject()
    {
        $ac_id = $this->session->userdata('ac_id');
        $exam_name = $this->input->post('exam_name');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

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
        $citySeats = $this->input->post('city_seats');
        $cityBatches = $this->input->post('batch');

        $cityCount = count($city_name_val);

        $companyName = preg_replace('/[^A-Za-z]/', '', $tt_admin_users->username);
        $projectName = preg_replace('/[^A-Za-z]/', '', $exam_name);

        $companyCode = strtoupper(substr($companyName, 0, 4));
        $projectCode = strtoupper(substr($projectName, 0, 4));

        $examDate = date(
            'd-m-Y',
            strtotime($this->input->post('start_date'))
        );

        $project_group_id = $companyCode . '-' . $projectCode . '-' . $examDate;


        for ($k = 0; $k < $cityCount; $k++) {

            $cityId = $city_name_val[$k];
            $state_ids = $this->db->select('state_id')->where('city_id', $cityId)->get('tt_city_master')->row()->state_id;

            // Ac Details
            $projectData = [
                'project_id' => $project_group_id,
                'client_id' => $ac_id,
                'created_by' => $ac_id,
                'client_name' => $tt_admin_users->username,
                'exam_name' => $this->input->post('exam_name'),
                'exam_type' => $this->input->post('exam_category'),
                "state_id" => $state_ids,
                "exam_city_id" => $cityId,
                "exam_city_name" => $this->common_options->get_city_name($cityId),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'total_batch' => isset($cityBatches[$cityId])
                    ? count($cityBatches[$cityId])
                    : 0,

                'batch1_start' => null,
                'batch1_end' => null,

                'batch2_start' => null,
                'batch2_end' => null,

                'batch3_start' => null,
                'batch3_end' => null,

                'batch4_start' => null,
                'batch4_end' => null,

                'batch5_start' => null,
                'batch5_end' => null,
                'exam_mode' => $this->input->post('exam_mode'),
                'inet_mode_os' => $this->input->post('operating_system'),
                'inet_mode_ram' => $this->input->post('ram'),
                'inet_mode_display' => $this->input->post('display_resolution'),
                'inet_mode_internet_each' => $this->input->post('internet_on_each_device') ?? 0,

                'parking_facility' => $this->input->post('parking') ?? 0,
                'security_guard' => $this->input->post('security_guard') ?? 'male',
                'locker_facility' => $this->input->post('lockers') ?? 0,
                'waiting_area' => $this->input->post('waiting_area') ?? 0,
                'power_backup' => $this->input->post('power_backup') ?? 0,
                'ph_handicaped' => $this->input->post('ph_handicapped') ?? 0,
                'printer' => $this->input->post('printer') ?? 0,
                'rough_sheet' => $this->input->post('rough_sheet') ?? 0,
                'partition_in_lab' => $this->input->post('partition') ?? 0,
                'ac_in_lab' => $this->input->post('ac_in_lab') ?? 0,
                'cctv_required' => $this->input->post('cctv_required') ?? 0,
                'cctv_recording' => $this->input->post('cctv_recording') ?? 0,

                "tech_person_count" => $tech_person_count,
                "center_suptn_count" => $center_suptn_count,

                "invigilator_ratio" => $invigilator_ratio,
                "security_guard_ratio" => $sucurity_guard_ratio,

                "invigilator_female" => $invigilator_female,
                "invigilator_male" => $invigilator_male,
                "security_guard_male" => $security_guard_male,
                "security_guard_female" => $security_guard_female,

                "number_of_seats" => isset($citySeats[$cityId]) ? $citySeats[$cityId] : 0,
                "exam_required_seat" => isset($citySeats[$cityId]) ? $citySeats[$cityId] : 0,
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

                'created_on' =>
                    $oldProject
                    ? $oldProject->created_on
                    : $updated_at,
                'last_modified_on' => $updated_at,
            ];

            $this->Common_model->insertData('tt_project_detail', $projectData);


            if (!empty($cityBatches[$cityId])) {

                foreach ($cityBatches[$cityId] as $batchNo => $batch) {

                    $batchData = [

                        'project_id' => $project_group_id,

                        'city_id' => $cityId,

                        'batch_no' => $batchNo,

                        'batch_start' => $batch['start'],

                        'batch_end' => $batch['end'],

                        'seat' => $batch['seat'],

                        'created_at' => $created_at,

                        'updated_at' => $updated_at

                    ];

                    $this->db->insert(
                        'tt_project_batch_detail',
                        $batchData
                    );
                }
            }
        }

        // Prepare and send email notification
        $email_subject = "New Project Created: " . $this->input->post('exam_name');

        $email_content = '
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

        // Send email to admin
        $admin_email = 'admin@testpanindia.com';

        $send = send_email(
            $email_content,
            $email_subject,
            $admin_email,
            "centerbooking@bookmytestcenter.com"
        );


        // Title & Message
        $notification_title = "New Project Created";

        $notification_message = "Client has created new project. Project Name: {$this->input->post('exam_name')} Client Name: {$tt_admin_users->username} and Email: {$tt_admin_users->email}";

        // Notification data
        $notification_data = [
            'admin_user_id' => $tt_admin_users->id,
            'center_id' => null,
            'client_id' => $ac_id,
            'title' => $notification_title,
            'message' => $notification_message,
            'type' => 'admin',
            'is_read' => 0,
            'is_remove' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert notification
        $this->db->insert('notifications', $notification_data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Project created successfully!',
        ]);
        exit;
    }


    public function editProject($project_id)
    {
        $projectData = $this->db
            ->where('project_id', $project_id)
            ->get('tt_project_detail')
            ->result();

        if (empty($projectData)) {
            show_404();
        }

        // First row project common detail
        $data['project'] = $projectData[0];

        // All city rows
        $data['projectCities'] = $projectData;

        $data['projectBatchData'] = [];

        $batches = $this->db
            ->where('project_id', $project_id)
            ->order_by('city_id')
            ->order_by('batch_no')
            ->get('tt_project_batch_detail')
            ->result();

        foreach ($batches as $row) {

            $data['projectBatchData'][$row->city_id][] = $row;
        }

        // Selected city ids
        $data['selectedCities'] =
            array_column(
                $projectData,
                'exam_city_id'
            );

        $data['city'] = $this->db
            ->get('tt_city_master')
            ->result_array();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view(
            'dashboard/project/edit_project',
            $data
        );
        $this->load->view('layouts/footer');
    }


    public function updateProject()
    {
        $ac_id = $this->session->userdata('ac_id');
        $updated_at = date('Y-m-d H:i:s');

        $project_id = $this->input->post('project_id');

        $city_ids = $this->input->post('city_id');
        $city_ids = array_map('intval', $city_ids);
        $city_seats = $this->input->post('city_seats');
        $batchData = $this->input->post('batch');

        $invigilator_ratio =
            $this->input->post('invigilator_ratio_1') .
            ':' .
            $this->input->post('invigilator_ratio_2');

        $security_ratio =
            $this->input->post('security_guard_ratio_1') .
            ':' .
            $this->input->post('security_guard_ratio_2');

        $this->db->trans_begin();

        // =====================
        // Preserve Old Data
        // =====================

        $oldProjects = [];

        $oldRows = $this->db
            ->where('project_id', $project_id)
            ->where('client_id', $ac_id)
            ->get('tt_project_detail')
            ->result();

        foreach ($oldRows as $row) {
            $oldProjects[$row->exam_city_id] = $row;
        }

        $oldProjectBatches = [];

        $oldBatchRows = $this->db
            ->where('project_id', $project_id)
            ->get('tt_project_batch_detail')
            ->result_array();

        foreach ($oldBatchRows as $row) {
            $oldProjectBatches[$row['city_id']][$row['batch_no']] = $row;
        }

        // =====================
        // Removed City Log
        // =====================

        foreach ($oldProjects as $oldCityId => $oldProjectRow) {
            if (!in_array($oldCityId, $city_ids, true)) {
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

        // =====================
        // Delete old data
        // =====================

        $this->db
            ->where('project_id', $project_id)
            ->where('client_id', $ac_id)
            ->delete('tt_project_detail');

        $this->db
            ->where('project_id', $project_id)
            ->delete('tt_project_batch_detail');

        // =====================
        // Process each city
        // =====================

        foreach ($city_ids as $cityId) {

            $oldProject = isset($oldProjects[$cityId])
                ? $oldProjects[$cityId]
                : null;

            $isRequirementChanged = 0;

            // Get sanitized seat value
            $seat = isset($city_seats[$cityId])
                ? (int) $city_seats[$cityId]
                : 0;

            // =====================
            // 1. Compare City Data First
            // =====================

            if (!$oldProject) {
                // New City
                saveProjectChangeLog(
                    $project_id,
                    $cityId,
                    'CITY_ADDED',
                    null,
                    [
                        'city' => $this->common_options->get_city_name($cityId),
                        'seat' => $seat  // ✅ Using sanitized $seat
                    ],
                    $ac_id
                );
                $isRequirementChanged = 1;
            } else {
                // Seat Updated
                if ((int) $oldProject->number_of_seats != $seat) {
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
                    $isRequirementChanged = 1;
                }
            }

            // =====================
            // 2. Compare Batch Data
            // =====================

            if (
                isset($batchData[$cityId])
                &&
                is_array($batchData[$cityId])
            ) {

                $oldBatchMap = [];
                $oldBatchCount = 0;

                if (isset($oldProjectBatches[$cityId])) {
                    foreach ($oldProjectBatches[$cityId] as $row) {
                        $oldBatchMap[$row['batch_no']] = $row['seat'];
                    }
                    $oldBatchCount = count($oldProjectBatches[$cityId]);
                }

                $newBatchCount = isset($batchData[$cityId])
                    ? count($batchData[$cityId])
                    : 0;

                // Batch count changed (new batch added or removed)
                if ($oldProject && $oldBatchCount != $newBatchCount) {
                    saveProjectChangeLog(
                        $project_id,
                        $cityId,
                        'BATCH_UPDATED',
                        ['batch' => $oldBatchCount],
                        ['batch' => $newBatchCount],
                        $ac_id
                    );
                    $isRequirementChanged = 1;
                }

                // Individual batch seat changes (only for existing batches)
                foreach ($batchData[$cityId] as $batchNo => $batch) {
                    $newSeat = (int) $batch['seat'];

                    // ✅ Only log if batch already existed
                    if (isset($oldBatchMap[$batchNo])) {
                        $oldSeat = (int) $oldBatchMap[$batchNo];

                        if ($oldSeat != $newSeat) {
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
                            $isRequirementChanged = 1;
                        }
                    }
                    // New batch - no separate log needed, BATCH_UPDATED already covers it
                }
            }

            // =====================
            // 3. NOW Insert with final $isRequirementChanged
            // =====================

            $state_info = $this->db
                ->select('state_id')
                ->where('city_id', $cityId)
                ->get('tt_city_master')
                ->row();

            $state_id = $state_info ? $state_info->state_id : NULL;

            $defaultAmount = $seat * $this->input->post('price_per_seat');

            $updateData = [
                'project_id' => $project_id,
                'client_id' => $ac_id,
                'client_name' => $this->input->post('client_name'),
                'exam_name' => $this->input->post('exam_name'),
                'exam_type' => $this->input->post('exam_category'),
                'state_id' => $state_id,
                'exam_city_id' => $cityId,
                'exam_city_name' => $this->common_options->get_city_name($cityId),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'total_batch' => isset($batchData[$cityId])
                    ? count($batchData[$cityId])
                    : 0,
                'exam_mode' => $this->input->post('exam_mode'),
                'inet_mode_os' => $this->input->post('operating_system'),
                'inet_mode_ram' => $this->input->post('ram'),
                'inet_mode_display' => $this->input->post('display_resolution'),
                'inet_mode_internet_each' => $this->input->post('internet_on_each_device') ?? 0,
                'parking_facility' => $this->input->post('parking') ?? 0,
                'security_guard' => $this->input->post('security_guard') ?? 'male',
                'locker_facility' => $this->input->post('lockers') ?? 0,
                'waiting_area' => $this->input->post('waiting_area') ?? 0,
                'power_backup' => $this->input->post('power_backup') ?? 0,
                'ph_handicaped' => $this->input->post('ph_handicapped') ?? 0,
                'printer' => $this->input->post('printer') ?? 0,
                'rough_sheet' => $this->input->post('rough_sheet') ?? 0,
                'partition_in_lab' => $this->input->post('partition') ?? 0,
                'ac_in_lab' => $this->input->post('ac_in_lab') ?? 0,
                'cctv_required' => $this->input->post('cctv_required') ?? 0,
                'cctv_recording' => $this->input->post('cctv_recording') ?? 0,
                'tech_person_count' => $this->input->post('tech_person_count'),
                'center_suptn_count' => $this->input->post('center_suptn_count'),
                'invigilator_ratio' => $invigilator_ratio,
                'security_guard_ratio' => $security_ratio,
                'invigilator_male' => $this->input->post('invigilator_male'),
                'invigilator_female' => $this->input->post('invigilator_female'),
                'security_guard_male' => $this->input->post('security_guard_male'),
                'security_guard_female' => $this->input->post('security_guard_female'),
                'number_of_seats' => $seat,
                'exam_required_seat' => $seat,
                'price_per_seat' => $this->input->post('price_per_seat'),
                'admin_price_per_seat' => $this->input->post('price_per_seat'),
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
                    : NULL,
                'client_negotiation_status' =>
                    $oldProject
                    ? $oldProject->client_negotiation_status
                    : 0,
                'client_negotiation_updated_at' =>
                    $oldProject
                    ? $oldProject->client_negotiation_updated_at
                    : NULL,
                'status' =>
                    $oldProject
                    ? $oldProject->status
                    : 0,
                'valid' =>
                    $oldProject
                    ? $oldProject->valid
                    : 1,
                'deleted' => 0,
                'manual_status' => $oldProject ? $oldProject->manual_status : 0,
                'has_future_date' => $oldProject ? $oldProject->has_future_date : 0,
                'old_start_date' => $oldProject ? $oldProject->old_start_date : NULL,
                'old_end_date' => $oldProject ? $oldProject->old_end_date : NULL,
                'project_remark' => $oldProject ? $oldProject->project_remark : NULL,
                'created_on' => $oldProject
                    ? $oldProject->created_on
                    : $updated_at,
                'last_modified_on' => $updated_at,
                'requirement_updated' => $isRequirementChanged,
            ];

            /*
            |--------------------------------------------------------------------------
            | Requirement Changed?
            | Reset Negotiation
            |--------------------------------------------------------------------------
            */

            if ($isRequirementChanged) {

                $updateData['client_negotiate_amount'] = $defaultAmount;

                $updateData['admin_client_final_amount'] = $defaultAmount;

                $updateData['client_negotiate_remark'] = NULL;

                $updateData['client_negotiation_status'] = 0;

                $updateData['client_negotiation_updated_at'] = NULL;

                $updateData['status'] = 0;
            }

            $this->db->insert('tt_project_detail', $updateData);

            // =====================
            // 4. Insert Batch Details
            // =====================

            if (
                isset($batchData[$cityId])
                &&
                is_array($batchData[$cityId])
            ) {
                foreach ($batchData[$cityId] as $batchNo => $batch) {
                    $this->db->insert(
                        'tt_project_batch_detail',
                        [
                            'project_id' => $project_id,
                            'city_id' => $cityId,
                            'batch_no' => $batchNo,
                            'batch_start' => $batch['start'] ?? NULL,
                            'batch_end' => $batch['end'] ?? NULL,
                            'seat' => isset($batch['seat'])
                                ? (int) $batch['seat']
                                : 0,
                            'created_at' => $updated_at,
                            'updated_at' => $updated_at
                        ]
                    );
                }
            }
        }

        // =====================
        // Transaction Commit/Rollback
        // =====================

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode([
                'status' => 'error',
                'message' => 'Something went wrong.'
            ]);
        } else {
            $this->db->trans_commit();
            echo json_encode([
                'status' => 'success',
                'message' => 'Project updated successfully.'
            ]);
        }

        exit;
    }


    public function deleteProject()
    {
        $project_id = $this->input->post('project_id');
        $client_id = $this->session->userdata('ac_id'); // client account id

        if (!$project_id || !$client_id) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request.'
            ]);
            return;
        }

        // Check if any booking exists for this project
        $this->db->from('tt_send_booking_request');
        $this->db->where('project_id', $project_id);
        $bookingCount = $this->db->count_all_results();

        // ❌ If booking exists → block delete
        if ($bookingCount > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'This project cannot be deleted because bookings already exist.'
            ]);
            return;
        }

        // Safe soft delete
        $updateData = [
            'deleted' => 1
        ];

        $this->Common_model->UpdateRecord(
            'tt_project_detail',
            $updateData,
            [
                'project_id' => $project_id,
                'client_id' => $client_id
            ]
        );

        echo json_encode([
            'status' => true,
            'message' => 'Project deleted successfully.'
        ]);
    }


    public function detailProject()
    {
        $ac_id = $this->session->userdata('ac_id');
        $project_id = $this->input->post('project_id');
        $data['project'] = $this->Common_model->getProjectDetail($project_id);
        $data['exam_booking_detail'] = $this->Common_model->getAssignCenterForAc($data['project']->project_id ?? 0);

        $this->db->select("COUNT(DISTINCT exam_city_id) AS total_cities");
        $this->db->from("tt_project_detail");
        $this->db->where("project_id", $project_id);
        $data['totalCityCovered'] = $this->db->get()->row();


        $data['approvedCenter'] = $this->Common_model->get_approved_center_count('tt_send_booking_request', $ac_id, $project_id);

        $data['cityWiseSummary'] = $this->Common_model->get_city_wise_seat_summary($project_id, $ac_id);

        $data['cities'] = $data['cityWiseSummary'];


        // Adjust booked seats to not exceed requirement
        $adjustedBooked = 0;
        $adjustedRequired = 0;

        foreach ($data['cityWiseSummary'] as $city) {
            $reqSeats = (int) ($city['total_seats'] ?? 0);
            $booked = (int) ($city['booked_seats'] ?? 0);

            $adjustedBooked += min($booked, $reqSeats); // cap booked at required
            $adjustedRequired += $reqSeats;
        }

        // Replace the raw totals with capped totals
        $data['totalBookedSeat'] = $adjustedBooked;
        $data['number_of_seats'] = $adjustedRequired;


        // Load view and return it as string
        $html = $this->load->view('dashboard/project/project_detail', $data, TRUE);
        // 'project_detail' is the view filename
        echo $html;
    }


    public function detailExamCenter()
    {
        $center_id = $this->input->post('center_id');
        $project_id = $this->input->post('project_id');

        $data['result'] = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));
        $data['labs'] = $this->Common_model->getdata_array('tt_lab', array('center_id' => $center_id));
        $data['documents'] = $this->Common_model->getdata_array('tt_center_document', array('center_id' => $center_id));
        $data['images'] = $this->Common_model->getdata_array('tt_center_images', array('center_id' => $center_id, 'deleted' => 0));
        $data['project_id'] = $project_id;

        // Load view and return it as string
        $html = $this->load->view('dashboard/exam_center_detail', $data, TRUE);
        echo $html;
    }


    public function upateCenterBookingStatus()
    {
        $center_id = $this->input->post('center_id');
        $project_id = $this->input->post('project_id');
        $type = $this->input->post('type');

        if (empty($center_id) || empty($project_id) || empty($type)) {

            echo json_encode([
                'status' => false,
                'message' => 'Invalid request.'
            ]);
            exit;
        }

        $client_status = ($type == 'approve') ? 1 : 2;

        $where = [
            'center_id' => $center_id,
            'project_id' => $project_id
        ];

        $data = [
            'client_status' => $client_status,
            'client_accept_booking_date' => date('Y-m-d H:i:s')
        ];

        $this->Common_model->UpdateRecord(
            'tt_send_booking_request',
            $data,
            $where
        );

        echo json_encode([
            'status' => true,
            'message' => 'Booking status updated successfully.'
        ]);
        exit;
    }


    public function viewProjectDetail()
    {
        $project_id = $this->input->post('project_id');

        $data['projects'] = $this->Common_model->viewProjectDetail($project_id);

        $data['project'] = !empty($data['projects'])
            ? $data['projects'][0]
            : null;

        $data['project_batches'] = $this->db
            ->where('project_id', $project_id)
            ->order_by('city_id')
            ->order_by('batch_no')
            ->get('tt_project_batch_detail')
            ->result();

        $html = $this->load->view(
            'dashboard/project/view_project_detail',
            $data,
            TRUE
        );

        echo $html;
    }

    public function myCalendar()
    {
        $ac_id = $this->session->userdata('ac_id');

        // Get all calendar bookings
        $calendarBookings = $this->Common_model->get_calendar_booking_data($ac_id);
        $data['calendarBookings'] = $calendarBookings;

        // Organize by month (combined)
        $data['monthlyEvents'] = [];
        if ($calendarBookings) {
            foreach ($calendarBookings as $booking) {
                $monthYear = date('F Y', strtotime($booking->start_date));
                $data['monthlyEvents'][$monthYear][] = $booking;
            }
        }

        // Other data
        $query = $this->db->query("SELECT COUNT(DISTINCT exam_city_id) AS total_cities FROM tt_project_detail");
        $data['totalCityCovered'] = $query->row();
        $data['number_of_seats'] = $this->Common_model->get_number_of_seats_of_client('tt_send_booking_request', $ac_id);
        $data['totalBookedSeat'] = $this->Common_model->get_total_booked_seat_of_client('tt_send_booking_request', $ac_id);

        // Check if export request
        if ($this->input->get('export') && $this->input->get('export') == 'excel') {
            $this->export_to_excel($data['calendarBookings'], $this->input->get('tab'));
        }

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/my-calendar', $data);
        $this->load->view('layouts/footer');
    }


    public function helpSupport()
    {
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/support');
        $this->load->view('layouts/footer');
    }


    public function mySettings()
    {
        $ac_id = $this->session->userdata('ac_id');
        $data['result'] = $this->Common_model->getSignleClientData($ac_id);
        $data['city'] = $this->Common_model->getdata_array('tt_city_master', []);
        $data['state'] = $this->Common_model->getdata_array('tt_states', []);

        $data['settigData'] = $this->Common_model->getdata_array('custom_settings', '');

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/my-setting', $data);
        $this->load->view('layouts/footer');
    }


    public function updateProfilePicture()
    {
        $ac_id = $this->session->userdata('ac_id');
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path'] = './uploads/client_logo/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time() . '_' . $_FILES['logo']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $logo = $uploadData['file_name'];

                // Update DB
                $this->db->where('ac_id', $ac_id)
                    ->update('tt_client', ['logo' => $logo]);

                $this->session->set_flashdata('success', 'Profile picture updated successfully.');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }
        redirect('my-settings');
    }


    public function updateCompanyInformation()
    {
        $ac_id = $this->session->userdata('ac_id');

        $updated_at = date('Y-m-d H:i:s');
        $company_name = $this->input->post('company_name');

        $data = [
            'company_name' => $company_name,
            'company_type' => $this->input->post('company_type'),
            'address' => $this->input->post('address'),
            'state' => $this->input->post('state'),
            'city' => $this->input->post('city'),
            'pincode' => $this->input->post('pincode'),
            'update_on' => $updated_at,
        ];

        $result = $this->Common_model->UpdateRecord('tt_client', $data, ['ac_id' => $ac_id]);

        if ($result) {
            $this->session->set_flashdata('success', 'Data updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update data');
        }

        redirect('my-settings');

        exit;
    }


    public function updatePersonalInformation()
    {
        $ac_id = $this->session->userdata('ac_id');
        $data = [
            'co_ordinator_name' => $this->input->post('full_name'),
            'coordinator_mobile_number' => $this->input->post('mobile'),
            'landline_number' => $this->input->post('landline'),
            'coordinator_email' => $this->input->post('email'),
            'coordinator_alternative_number' => $this->input->post('alt_mobile')
        ];

        $this->db->where('ac_id', $ac_id)->update('tt_client', $data);

        $this->session->set_flashdata('success', 'Personal information updated successfully.');
        redirect('my-settings');
    }


    public function exportDashboardProject()
    {
        $ac_id = $this->session->userdata('ac_id');
        $status = $this->input->get('status');

        if ($status == 'all') {
            $status = null;
        }

        $projects = $this->Common_model->getClientProjectDataGroupBy($ac_id, $status);

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=projects_" . date('Ymdmi:s') . ".csv");

        $output = fopen("php://output", "w");

        fputcsv($output, [
            'Project Name',
            'Created On',
            'Total Seats',
            'Exam Start Date',
            'Exam End Date',
            'Total Cities',
            'Project Status'
        ]);

        foreach ($projects as $row) {

            $current = date('Y-m-d');
            if ($current < $row['start_date']) {
                $projectStatus = 'Upcoming';
            } elseif ($current > $row['end_date']) {
                $projectStatus = 'Completed';
            } else {
                $projectStatus = 'In Progress';
            }

            fputcsv($output, [
                $row['exam_name'],
                date('Y-m-d', strtotime($row['created_on'])),
                $row['total_seats'],
                $row['start_date'],
                $row['end_date'],
                $row['total_cities'],
                $projectStatus
            ]);
        }

        fclose($output);
        exit;
    }


    public function exportProjectDetailAssignCenter()
    {
        $project_id = $this->input->get('project_id');

        if (!$project_id) {
            show_error('Invalid Project');
        }

        $centers = $this->Common_model->getAssignCenterForAc($project_id);

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=project_centers_" . date('Ymdm:i:s') . ".csv");

        $output = fopen("php://output", "w");

        // CSV Headers
        fputcsv($output, [
            'Center Name',
            'Seats',
            'City',
            'Availability',
            'Audited',
            'Approval Status'
        ]);

        foreach ($centers as $row) {

            // Approval Status
            if ($row['client_status'] == 0) {
                $approval = 'Pending';
            } elseif ($row['client_status'] == 2) {
                $approval = 'Rejected';
            } else {
                $approval = 'Approved';
            }

            fputcsv($output, [
                $row['center_name'],
                $row['capacity'],
                $row['city_name'],
                'Available',
                'Yes',
                $approval
            ]);
        }

        fclose($output);
        exit;
    }


    public function openClientNegotiationModal()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $projectId = $this->input->post('project_id');

        if (empty($projectId)) {

            echo json_encode([
                'status' => false,
                'message' => 'Invalid Project.'
            ]);

            return;
        }

        $project = $this->db

            ->select("
                project_id,
                exam_name,
                client_name,
                number_of_seats,
                price_per_seat,
                client_negotiate_amount,
                admin_client_final_amount,
                client_negotiate_remark,
                client_negotiation_status
            ")

            ->where("project_id", $projectId)

            ->where("deleted", 0)

            ->get("tt_project_detail")

            ->row_array();

        if (empty($project)) {
            echo json_encode([
                'status' => false,
                'message' => 'Project not found.'
            ]);

            return;
        }

        $originalAmount =
            $project['number_of_seats']
            *
            $project['price_per_seat'];

        $finalAmount =
            !empty($project['admin_client_final_amount'])

            ?

            $project['admin_client_final_amount']

            :

            $originalAmount;

        echo json_encode([

            'status' => true,

            'data' => [

                'project_id' => $project['project_id'],

                'exam_name' => $project['exam_name'],

                'client_name' => $project['client_name'],

                'original_amount' => $originalAmount,

                'final_amount' => $finalAmount,

                'remark' => $project['client_negotiate_remark'],

                'negotiation_status' => $project['client_negotiation_status']

            ]

        ]);
    }


    public function saveClientNegotiation()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $projectId = $this->input->post('project_id');
        $finalAmount = $this->input->post('final_amount');
        $remark = trim($this->input->post('remark'));

        if (empty($projectId) || empty($finalAmount)) {

            echo json_encode([
                'status' => false,
                'message' => 'Required fields missing.'
            ]);

            return;
        }

        $project = $this->db
            ->where('project_id', $projectId)
            ->where('deleted', 0)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {

            echo json_encode([
                'status' => false,
                'message' => 'Project not found.'
            ]);

            return;
        }

        $oldAmount =
            !empty($project->admin_client_final_amount)
            ?
            $project->admin_client_final_amount
            : (
                $project->number_of_seats
                *
                $project->price_per_seat
            );

        $this->db->trans_begin();

        /**
         * Update Project
         */

        $this->db

            ->where('project_id', $projectId)

            ->update('tt_project_detail', [

                // Client Latest Demand
                'client_negotiate_amount' => $finalAmount,

                // Admin Final Amount bhi same ho jayega
                // jab tak admin counter na de
                'admin_client_final_amount' => $finalAmount,

                'client_negotiate_remark' => $remark,

                // Client Requested
                'client_negotiation_status' => 1

            ]);

        /**
         * Negotiation History
         */

        $this->db->insert(

            'tt_booking_negotiation_logs',

            [

                'project_id' => $projectId,

                'client_id' => $project->client_id,

                'center_id' => 0,

                'raised_by' => 'client',

                'old_price' => $oldAmount,

                'new_price' => $finalAmount,

                'remark' => $remark,

                'status' => 'Client Requested',

                'negotiation_type' => 'client',

                'final_flag' => 0,

                'created_by' => $this->session->userdata('ac_id'),

                'created_at' => date('Y-m-d H:i:s')

            ]

        );

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();

            echo json_encode([

                'status' => false,

                'message' => 'Unable to save negotiation.'

            ]);

            return;
        }

        $this->db->trans_commit();

        echo json_encode([

            'status' => true,

            'message' => 'Negotiation submitted successfully.'

        ]);
    }


    public function getClientNegotiationHistory()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $projectId = $this->input->post('project_id');

        $history = $this->db

            ->where('project_id', $projectId)

            ->where('negotiation_type', 'client')

            ->order_by('id', 'DESC')

            ->get('tt_booking_negotiation_logs')

            ->result();

        echo json_encode($history);
    }


    public function acceptClientNegotiation()
    {
        $projectId = $this->input->post('project_id');

        $project = $this->db
            ->where('project_id', $projectId)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {

            echo json_encode([
                'status' => false,
                'message' => 'Project not found.'
            ]);

            return;
        }

        $this->db
            ->where('project_id', $projectId)
            ->update('tt_project_detail', [

                'client_negotiation_status' => 3

            ]);

        $this->db->insert('tt_booking_negotiation_logs', [

            'project_id' => $projectId,

            'client_id' => $project->client_id,

            'raised_by' => 'client',

            'old_price' => $project->admin_client_final_amount,

            'new_price' => $project->admin_client_final_amount,

            'remark' => 'Client accepted admin offer.',

            'status' => 'Finalized',

            'negotiation_type' => 'client',

            'final_flag' => 1,

            'created_by' => $this->session->userdata('ac_id'),

            'created_at' => date('Y-m-d H:i:s')

        ]);

        echo json_encode([

            'status' => true,

            'message' => 'Offer accepted successfully.'

        ]);
    }
}
