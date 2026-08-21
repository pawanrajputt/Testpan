<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DashboardController extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->helper('project_status');

        if (empty($this->session->userdata('exam_center_id'))) {
            return redirect('signup');
        }

        if (
            !$this->session->userdata('is_owner_logged_in') ||
            !$this->session->userdata('selected_center_id')
        ) {
            redirect('/');
        }
    }

    public function dashboard()
    {
        $center_id = $this->session->userdata('exam_center_id');

        $data['countries'] = $this->Common_model->getdata_array('tt_countries', ['is_active' => 1]);
        $data['center_type'] = $this->Common_model->getdata_array('tt_center_type', ['deleted' => 0]);
        $data['result'] = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);
        $cityId = $data['result']->city_id;
        $data['labs'] = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);
        $data['documents'] = $this->Common_model->getdata_array('tt_center_document', ['center_id' => $center_id]);
        $data['images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0]);

        $data['number_of_seats'] = $this->Common_model->get_total_booked_seat('tt_send_booking_request', $center_id);

        $data['activeBookings'] =
            $this->Common_model
            ->get_total_booking_request(
                $center_id,
                '',
                '',
                '',
                $cityId
            );

        $data['inReviewBookings'] =
            $this->Common_model
            ->get_inreview_booking_request(
                $center_id,
                $cityId
            );

        $data['confirmedBookings'] =
            $this->Common_model
            ->get_confirmed_booking_request(
                $center_id,
                $cityId
            );

        $data['rejectedBookings'] =
            $this->Common_model
            ->get_rejected_booking_request(
                $center_id,
                $cityId
            );

        $data['postponedBookings'] =
            $this->Common_model
            ->get_postponed_booking_request(
                $center_id,
                $cityId
            );

        $data['total_postponed_booking_count'] = count($data['postponedBookings']);

        $data['allBookings'] = $this->Common_model->get_total_booking_request($center_id, '', '', '', $cityId);
        $data['total_booking_req_count'] = count($data['allBookings']);


        $data['selfBookingData'] = $this->Common_model->get_client_self_booking($center_id, '', '');
        $data['total_self_booking_req_count'] = count($data['selfBookingData']);


        // Calendar data
        $month = $this->input->get('month') ?? date('n');
        $year = $this->input->get('year') ?? date('Y');

        $exam_dates = $this->Common_model->get_exam_dates($month, $year, $center_id);
        $calendar = $this->generate_calendar($month, $year, $exam_dates);

        // Add to existing $data array
        $data['calendar'] = $calendar;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['exam_dates'] = $exam_dates;

        if (!$this->session->userdata('site_settings')) {
            $result = $this->Common_model->getdata_array('custom_settings', '');

            // Convert to key-value array
            $settings = [];
            foreach ($result as $item) {
                $settings[$item['setting_key']] = $item['setting_value'];
            }

            // Session
            $this->session->set_userdata('site_settings', $settings);
        }

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/dashboard', $data);
        $this->load->view('layouts/footer');
    }


    public function searchBookingRequest()
    {

        $center_id = $this->session->userdata('exam_center_id');
        $search = $this->input->post('search');
        $type   = $this->input->post('type');
        $cityId = null;

        if ($type == 'all') {
            $data = $this->Common_model->get_total_booking_request($center_id, '', '', $search, $cityId);
        } elseif ($type == 'inreview') {
            $data = $this->Common_model->get_total_inreview_booking_request($center_id, $search, $cityId);
        } elseif ($type == 'confirmed') {
            $data = $this->Common_model->get_total_booking_request($center_id, 1, 1, $search, $cityId);
        } else {
            $data = [];
        }

        $html = '';
        if (count($data) > 0) {
            foreach ($data as $row) {
                $duration = 'N/A';
                if (!empty($row['start_date']) && !empty($row['end_date'])) {
                    $start = new DateTime($row['start_date']);
                    $end = new DateTime($row['end_date']);
                    $diff = $start->diff($end)->days + 1;
                    $duration = $diff . ' day' . ($diff > 1 ? 's' : '');
                }

                $status = '<span class="badge bg-warning">Pending</span>';
                if ($row['exam_center_status'] == 1) {
                    $status = '<span class="badge bg-success">Approved</span>';
                } elseif ($row['exam_center_status'] == 2) {
                    $status = '<span class="badge bg-danger">Rejected</span>';
                }

                $html .= '<tr>

                    <td>
                        <input type="checkbox" data-id="' . $row['project_id'] . '" class="me-2">
                        ' . $row['exam_name'] . '
                        <br>
                        <strong>Project ID:</strong> ' . $row['project_id'] . '
                    </td>

                    <td>' . $row['client_name'] . '</td>

                    <td>' . $duration . '</td>

                    <td>'
                    . date('M d, Y', strtotime($row['start_date'])) .
                    ' - ' .
                    date('M d, Y', strtotime($row['end_date'])) .
                    '</td>

                    <td>' . $row['number_of_seats'] . '</td>

                    <td>Rs. ' . $row['admin_center_final_price'] . '/seat</td>

                    <td>';

                switch ($row['exam_center_status']) {

                    case 1:
                        $html .= '<span class="badge bg-success">Approved</span>';
                        break;

                    case 2:
                        $html .= '<span class="badge bg-danger">Rejected</span>';
                        break;

                    case 3:
                        $html .= '<span class="badge bg-info">Negotiation</span>';
                        break;

                    default:
                        $html .= '<span class="badge bg-warning">Pending</span>';
                }

                $html .= '</td><td>';

                switch ($row['client_status']) {

                    case 1:
                        $html .= '<span class="badge bg-success">Approved</span>';
                        break;

                    case 2:
                        $html .= '<span class="badge bg-danger">Rejected</span>';
                        break;

                    default:
                        $html .= '<span class="badge bg-warning">Pending</span>';
                }

                $html .= '</td><td>';

                switch ($row['admin_status']) {

                    case 1:
                        $html .= '<span class="badge bg-success">Approved</span>';
                        break;

                    case 2:
                        $html .= '<span class="badge bg-danger">Rejected</span>';
                        break;

                    case 3:
                        $html .= '<span class="badge bg-info">Hold</span>';
                        break;

                    case 4:
                        $html .= '<span class="badge bg-secondary">Not Required</span>';
                        break;

                    default:
                        $html .= '<span class="badge bg-warning">Pending</span>';
                }

                $html .= '</td>

                    <td>
                        <a href="javascript:void(0);"
                            onclick="showProjectDetail(\'' . $row['project_id'] . '\', \'' . $row['id'] . '\')"
                            class="View-btn">
                            View
                        </a>
                    </td>

                </tr>';
            }
        } else {
            $html .= '<tr>
                <td colspan="10" class="text-center">
                    No Booking Found...
                </td>
            </tr>';
        }

        echo $html;
    }


    public function exportBookingRequest()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $search = $this->input->get('search');
        $type   = $this->input->get('type');
        $cityId = null;

        if ($type == 'all') {
            $data = $this->Common_model->get_total_booking_request($center_id, '', '', $search, $cityId);
        } elseif ($type == 'inreview') {
            $data = $this->Common_model->get_total_inreview_booking_request($center_id, $search, $cityId);
        } elseif ($type == 'confirmed') {
            $data = $this->Common_model->get_total_booking_request($center_id, 1, 1, $search, $cityId);
        } else {
            $data = [];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Exam Name');
        $sheet->setCellValue('B1', 'Project ID');
        $sheet->setCellValue('C1', 'Client Name');
        $sheet->setCellValue('D1', 'Duration');
        $sheet->setCellValue('E1', 'Exam Dates');
        $sheet->setCellValue('F1', 'Seats');
        $sheet->setCellValue('G1', 'Price');
        $sheet->setCellValue('H1', 'Status');

        // Data rows
        $rowNumber = 2;
        foreach ($data as $row) {
            $duration = 'N/A';
            if (!empty($row['start_date']) && !empty($row['end_date'])) {
                $start = new DateTime($row['start_date']);
                $end   = new DateTime($row['end_date']);
                $diff  = $start->diff($end)->days + 1;
                $duration = $diff . ' day' . ($diff > 1 ? 's' : '');
            }

            $status = 'Pending';
            if ($row['exam_center_status'] == 1) {
                $status = 'Approved';
            } elseif ($row['exam_center_status'] == 2) {
                $status = 'Rejected';
            }

            $sheet->setCellValue('A' . $rowNumber, $row['exam_name']);
            $sheet->setCellValue('B' . $rowNumber, $row['project_id']);
            $sheet->setCellValue('C' . $rowNumber, $row['client_name']);
            $sheet->setCellValue('D' . $rowNumber, $duration);
            $sheet->setCellValue('E' . $rowNumber, $row['start_date'] . ' to ' . $row['end_date']);
            $sheet->setCellValue('F' . $rowNumber, $row['number_of_seats']);
            $sheet->setCellValue('G' . $rowNumber, $row['admin_center_final_price']);
            $sheet->setCellValue('H' . $rowNumber, $status);

            $rowNumber++;
        }

        // ✅ Auto column width
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $writer = new Xlsx($spreadsheet);
        $date = date('d-m-Y h:i:s');
        $filename = "booking_requests_$date.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    public function get_booking_details()
    {

        $center_id = $this->session->userdata('exam_center_id');

        $date = $this->input->get('date');

        $bookings = $this->Common_model->get_bookings_by_date($date, $center_id);

        echo json_encode($bookings);
    }

    private function generate_calendar($month, $year, $exam_dates)
    {
        // Create array for calendar
        $calendar = [];

        // Get first day of month and total days
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $days_in_month = date('t', $first_day);
        $day_of_week = date('w', $first_day); // 0=Sunday, 6=Saturday

        // Get previous month and year
        $prev_month = ($month == 1) ? 12 : $month - 1;
        $prev_year = ($month == 1) ? $year - 1 : $year;

        // Get next month and year
        $next_month = ($month == 12) ? 1 : $month + 1;
        $next_year = ($month == 12) ? $year + 1 : $year;

        // Get days from previous month to show
        $days_in_prev_month = date('t', mktime(0, 0, 0, $prev_month, 1, $prev_year));

        // Fill calendar with previous month's days
        for ($i = 0; $i < $day_of_week; $i++) {
            $calendar[] = [
                'day' => $days_in_prev_month - ($day_of_week - $i - 1),
                'month' => 'prev',
                'has_exam' => false
            ];
        }

        // Fill calendar with current month's days
        for ($day = 1; $day <= $days_in_month; $day++) {
            $current_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            $bookings = [];

            // Check all exam dates
            foreach ($exam_dates as $exam) {
                if ($current_date >= $exam['start_date'] && $current_date <= $exam['end_date']) {
                    $bookings[] = $exam;
                }
            }

            $has_exam = !empty($bookings);
            $booking_types = array_unique(array_column($bookings, 'type'));

            // Add mixed_booking class if both types exist
            if (count($booking_types) > 1) {
                $booking_types = ['mixed_booking'];
            }

            $calendar[] = [
                'day' => $day,
                'month' => 'current',
                'has_exam' => $has_exam,
                'date' => $current_date,
                'booking_types' => $booking_types
            ];
        }

        // Fill calendar with next month's days
        $days_left = 42 - count($calendar); // 6 weeks calendar
        for ($day = 1; $day <= $days_left; $day++) {
            $calendar[] = [
                'day' => $day,
                'month' => 'next',
                'has_exam' => false
            ];
        }

        // Split into weeks (7 days each)
        $weeks = array_chunk($calendar, 7);

        return [
            'weeks' => $weeks,
            'month_name' => date('F', $first_day),
            'year' => $year,
            'prev_month' => $prev_month,
            'prev_year' => $prev_year,
            'next_month' => $next_month,
            'next_year' => $next_year
        ];
    }

    public function get_calendar()
    {
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $center_id = $this->session->userdata('exam_center_id');

        $exam_dates = $this->Common_model->get_exam_dates($month, $year, $center_id);
        $calendar = $this->generate_calendar($month, $year, $exam_dates);

        // Prepare data to return
        $data = [
            'calendar' => $calendar,
            'month' => $month,
            'year' => $year
        ];

        // Load a view that just contains the calendar HTML
        $this->load->view('booking/calendar_partial', $data);
    }

    public function updateExamCenterData()
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $examCenterId = $this->session->userdata('exam_center_id');
        $lastInsertId = $this->session->userdata('exam_center_id');

        // Center Details
        $examCenterDetailsdata = [
            'center_type'              => $this->input->post('center_type') ?? 'online',
            'type_of_center'           => $this->input->post('type_of_center'),
            'center_name'              => $this->input->post('center_name'),
            'center_description'       => $this->input->post('center_description'),
            'capacity'                 => $this->input->post('total_no_system'),
            'pin_code'                 => $this->input->post('pin_code'),
            'country_id'               => $this->input->post('country_id'),
            'state_id'                 => $this->input->post('state_id'),
            'city_id'                  => $this->input->post('city_id'),
            'local_area_name'          => $this->input->post('local_area_name'),
            'address'                  => $this->input->post('address'),
            "address_lat"              => $this->input->post('address_lat'),
            "address_long"             => $this->input->post('address_long'),
            'landmark'                 => $this->input->post('landmark'),
            'for_ph_candidate'         => $this->input->post('for_ph_candidate'),
            'nearest_railway_station' => $this->input->post('nearest_railway_station'),
            'distance_from_station'   => $this->input->post('distance_from_railway_station'),
            'nearest_bus_stop'        => $this->input->post('nearest_bus_stop'),
            'distance_from_bus_stop'  => $this->input->post('distance_from_bus_stop'),
            'nearest_metro_station'   => $this->input->post('nearest_metro_station'),
            'distance_from_metro'     => $this->input->post('distance_from_metro_station'),
            'nearest_airport'         => $this->input->post('nearest_airport'),
            'distance_from_airport'   => $this->input->post('distance_from_airport'),


            'poc_name'                 => $this->input->post('poc_name'),
            'poc_contact_no'           => $this->input->post('poc_contact_no'),
            'poc_mobile_alternate'     => $this->input->post('poc_mobile_alternate'),
            'poc_email'                => $this->input->post('poc_email'),
            'cs_name'                  => $this->input->post('cs_name'),
            'cs_contact_number'        => $this->input->post('cs_contact_number'),
            'cs_email'                 => $this->input->post('cs_email'),
            'am_name'                  => $this->input->post('am_name'),
            'am_contact_no'            => $this->input->post('am_contact_no'),
            'am_email'                 => $this->input->post('am_email'),
            'emergency_contact_no'     => $this->input->post('emergency_contact_no'),
            'landline_number'          => $this->input->post('landline_number'),


            'total_no_lab'              => $this->input->post('total_no_lab'),
            'total_no_system'           => $this->input->post('total_no_system'),
            'connected_single_network'  => $this->input->post('connected_single_network'),
            'how_many_network'          => $this->input->post('how_many_network'),
            'partitaion_each_lab'        => $this->input->post('partitaion_each_lab'),
            'ac_in_each_lab'            => $this->input->post('ac_in_each_lab'),
            'network_printer'           => $this->input->post('network_printer'),
            'is_there_projector_in_each_lab'    => $this->input->post('is_there_projector_in_each_lab'),
            'is_there_sound_sytem_in_each_lab'    => $this->input->post('is_there_sound_sytem_in_each_lab'),
            'how_many_fire_extinguisher_in_each_lab' => $this->input->post('how_many_fire_extinguisher_in_each_lab'),
            'locker_facility'           => $this->input->post('locker_facility'),
            'drinking_water_facility'   => $this->input->post('drinking_water_facility'),


            'primary_isp_name'          => $this->input->post('primary_isp_name'),
            'primary_isp_connect_type'  => $this->input->post('primary_isp_connect_type'),
            'primary_isp_speed'         => $this->input->post('primary_isp_speed') ?? 10,
            'primary_internet_speed_unit' => $this->input->post('primary_internet_speed_unit'),

            'secondary_isp_name'        => $this->input->post('secondary_isp_name'),
            'secondary_isp_connect_type'  => $this->input->post('secondary_isp_connect_type'),
            'secondary_isp_speed'       => $this->input->post('secondary_isp_speed') ?? 0,
            'secondary_internet_speed_unit' => $this->input->post('secondary_internet_speed_unit'),

            'is_generator_backup'       => $this->input->post('is_generator_backup'),
            'generator_backup_capacity' => $this->input->post('generator_backup_capacity'),
            'generator_fuel_tank_capacity'     => $this->input->post('generator_fuel_tank_capacity'),

            'power_back_ups_kv'         => $this->input->post('power_back_ups_kv'),
            'ups_backup_time'           => $this->input->post('ups_backup_time'),

            'total_no_of_connection'    => $this->input->post('total_no_of_connection'),

            'beneficiary_name'    => $this->input->post('beneficiary_name'),
            'bank_name'           => $this->input->post('bank_name'),
            'bank_account_number' => $this->input->post('bank_account_number'),
            'bank_ifsc_code'      => $this->input->post('bank_ifsc_code'),
            'pan_no'              => $this->input->post('pan_no'),
            'gst_no'              => $this->input->post('gst_no'),
            'gst_state_code'      => $this->input->post('gst_state_code'),
            'uidai_number'        => $this->input->post('uidai_number'),
            'udyam_number'        => $this->input->post('uidai_number'),
            'msme_number'         => $this->input->post('msme_number'),
            'has_gst'             => $this->input->post('has_gst'),
            'has_msme'            => $this->input->post('has_msme'),
            'last_modified_on'    => $updated_at,
        ];


        // gst file
        $gstFilePath = $result->gst_file ?? '';

        if (!empty($_FILES['gst_file']['name'])) {

            $logoDir = FCPATH . 'uploads/gst_file/';
            if (!is_dir($logoDir)) {
                mkdir($logoDir, 0777, true);
            }

            $logoName = time() . '_' . $_FILES['gst_file']['name'];
            $targetGSTFilePath = 'uploads/gst_file/' . $logoName;

            if (move_uploaded_file($_FILES['gst_file']['tmp_name'], FCPATH . $targetGSTFilePath)) {
                $gstFilePath = $targetGSTFilePath;

                $this->Common_model->UpdateRecord(
                    'tt_center',
                    ['gst_file' => $gstFilePath],
                    ['center_id' => $examCenterId]
                );
            }
        }

        // now this will have correct value
        $examCenterDetailsdata['gst_file'] = $gstFilePath;


        // Upload logo
        $logoDir = 'uploads/center_logo/';
        if (!is_dir($logoDir)) {
            mkdir($logoDir, 0777, true);
        }

        $logoPath = '';

        if (!empty($_FILES['center_logo']['name'][0])) {

            // Take first image only
            $logoName = time() . '_' . basename($_FILES['center_logo']['name'][0]);
            $targetLogoPath = $logoDir . $logoName;

            if (move_uploaded_file($_FILES['center_logo']['tmp_name'][0], $targetLogoPath)) {

                $logoPath = $targetLogoPath;

                // Update logo
                $this->Common_model->UpdateRecord('tt_center', [
                    'logo' => $logoPath
                ], ['center_id' => $examCenterId]);
            }
            $examCenterDetailsdata['logo'] = $logoPath;
        }

        // STEP 1: Get old data
        $oldData = $this->Common_model->getdata('tt_center', [
            'center_id' => $examCenterId
        ]);

        if ($oldData) {

            foreach ($examCenterDetailsdata as $field => $newValue) {

                $oldValue = $oldData->$field ?? null;

                // Normalize values (important)
                $oldValue = is_null($oldValue) ? '' : trim((string)$oldValue);
                $newValue = is_null($newValue) ? '' : trim((string)$newValue);

                // Compare
                if ($oldValue != $newValue) {

                    $logData = [
                        'center_id'   => $examCenterId,
                        'field_name'  => $field,
                        'old_value'   => $oldValue,
                        'new_value'   => $newValue,
                        'changed_by'  => $examCenterId, // or user id
                        'changed_on'  => date('Y-m-d H:i:s')
                    ];

                    $this->Common_model->insertData('tt_center_logs', $logData);
                }
            }
        }


        $this->Common_model->UpdateRecord('tt_center', $examCenterDetailsdata, ['center_id' => $examCenterId]);

        $this->db->where('center_id', $examCenterId)
            ->update('center_edit_permissions', [
                'is_edit_allowed' => 0
            ]);



        // Upload documents and update/insert into tt_center_document
        $uploadPath = 'uploads/center_documents/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $expectedDocs = [
            'canceled_cheque',
            'agreement',
            'mou',
            'gst_certificate',
            'udyam_certificate',
            'pan_number',
            'NDA',
        ];

        foreach ($expectedDocs as $docName) {
            if (!empty($_FILES[$docName]['name'])) {
                $fileName = time() . '_' . basename($_FILES[$docName]['name']);
                $targetPath = $uploadPath . $fileName;

                if (move_uploaded_file($_FILES[$docName]['tmp_name'], $targetPath)) {
                    // Check if document already exists
                    $existingDoc = $this->Common_model->getdata('tt_center_document', [
                        'center_id' => $examCenterId,
                        'doc_name'  => $docName,
                        'deleted'   => 0
                    ]);

                    $documentData = [
                        'center_id' => $examCenterId,
                        'doc_name'  => $docName,
                        'doe'       => date('Y-m-d H:i:s'),
                        'added_by'  => $examCenterId,
                        'url'       => $targetPath,
                        'source'    => 1,
                        'deleted'   => 0
                    ];

                    if ($existingDoc) {
                        $this->Common_model->UpdateRecord('tt_center_document', $documentData, [
                            'center_id' => $examCenterId,
                            'doc_name'  => $docName
                        ]);
                    } else {
                        $this->Common_model->insertData('tt_center_document', $documentData);
                    }
                }
            }
        }

        // Upload Lab Photos
        $this->uploadMultipleImages('center_entrances', 'uploads/center_entrances/', $lastInsertId, 'tt_center_entrances', 'center_entrance');

        // Upload Lab Photos
        $this->uploadMultipleImages('lab_photos', 'uploads/lab_photos/', $lastInsertId, 'tt_center_lab_photos', 'lab_photo');

        // Upload Main Gate Images
        $this->uploadMultipleImages('main_gate_images', 'uploads/main_gate_images/', $lastInsertId, 'tt_center_gate_images', 'gate_image');

        // Upload Server Room Images
        $this->uploadMultipleImages('server_room_images', 'uploads/server_room_images/', $lastInsertId, 'tt_center_server_images', 'server_image');

        // Upload Observer Room Images
        $this->uploadMultipleImages('observer_room_images', 'uploads/observer_room_images/', $lastInsertId, 'tt_center_observer_images', 'observer_image');

        // Upload UPS/Generator Images
        $this->uploadMultipleImages('ups_generator_images', 'uploads/ups_generator_images/', $lastInsertId, 'tt_center_ups_images', 'ups_image');


        // ============= WALKTHROUGH VIDEO UPDATE (Multiple) ================
        if (!empty($_FILES['walkthrough_video']['name'][0])) {

            $videoDir = 'uploads/center_videos/';
            if (!is_dir($videoDir)) {
                mkdir($videoDir, 0777, true);
            }

            $files = $_FILES['walkthrough_video'];
            $about_videos = $this->input->post('about_video');

            // Optional: delete old videos
            // $this->Common_model->Deletedata('tt_center_video', ['center_id' => $examCenterId]);

            for ($i = 0; $i < count($files['name']); $i++) {

                if ($files['error'][$i] == 0) {

                    $vName = time() . '_' . basename($files['name'][$i]);
                    $targetVideoPath = $videoDir . $vName;

                    if (move_uploaded_file($files['tmp_name'][$i], $targetVideoPath)) {

                        $videoData = [
                            'center_id'   => $examCenterId,
                            'about_video' => isset($about_videos[$i]) ? $about_videos[$i] : '',
                            'center_video' => $targetVideoPath,
                            'doe'         => date("Y-m-d H:i:s"),
                            'added_by'    => $examCenterId,
                            'deleted'     => 0
                        ];

                        $this->Common_model->insertData('tt_center_video', $videoData);
                    }
                }
            }
        }


        // Lab details
        $floors = $this->input->post('floor_number') ?? [];
        $totalComputers = $this->input->post('no_of_computer') ?? [];
        $windowGenerations = $this->input->post('window_generation') ?? [];
        $monitorTypes = $this->input->post('monitor_type') ?? [];
        $operatingSystems = $this->input->post('operating_system') ?? [];
        $rams = $this->input->post('ram') ?? [];
        $hdds = $this->input->post('hard_disk') ?? [];
        $ethernetCompanies = $this->input->post('ehternet_swtch_company') ?? [];
        $switchCategories = $this->input->post('switch_category') ?? [];
        $noOfEachEthernetPorts = $this->input->post('no_of_port_eth_switch') ?? [];
        $ethernetCompanyOthers = $this->input->post('ethernet_company_other') ?? [];

        // Center Log
        $oldLabs = $this->Common_model->getdata_array('tt_lab', [
            'center_id' => $examCenterId
        ]);

        $newLabs = $this->input->post('floor_number') ?? [];

        if (!empty($oldLabs)) {

            // simple compare (count based)
            if (count($oldLabs) != count($newLabs)) {

                $this->Common_model->insertData('tt_center_logs', [
                    'center_id'  => $examCenterId,
                    'field_name' => 'lab_count',
                    'old_value'  => count($oldLabs),
                    'new_value'  => count($newLabs),
                    'changed_by' => $examCenterId,
                    'changed_on' => date('Y-m-d H:i:s')
                ]);
            }
        }

        /* STEP 1: Delete all old labs of this center */
        $this->Common_model->Deletedata(
            'tt_lab',
            ['center_id' => $examCenterId]
        );

        /* STEP 2: Insert fresh labs */
        if (!empty($floors)) {
            foreach ($floors as $key => $floor) {

                $labData = [
                    'center_id' => $examCenterId,
                    'floor_name' => $floor,
                    'no_of_computer' => $totalComputers[$key] ?? null,
                    'window_generation' => $windowGenerations[$key] ?? null,
                    'monitor_type' => $monitorTypes[$key] ?? null,
                    'operating_system' => $operatingSystems[$key] ?? null,
                    'ram' => $rams[$key] ?? null,
                    'hard_disk' => $hdds[$key] ?? null,
                    'ehternet_swtch_company' => $ethernetCompanies[$key] ?? null,
                    'ethernet_company_other' => $ethernetCompanyOthers[$key] ?? null,
                    'switch_category' => $switchCategories[$key] ?? null,
                    'no_of_port_eth_switch' => $noOfEachEthernetPorts[$key] ?? null,
                    'created_on' => $created_at,
                    'last_modify_on' => $updated_at,
                ];

                $this->Common_model->InsertData('tt_lab', $labData);
            }
        }


        // Send response
        echo json_encode([
            'status' => 'success',
            'message' => 'Data updated successfully!',
        ]);
        exit;
    }


    // Function to handle multiple uploads
    private function uploadMultipleImages($fieldName, $uploadDir, $lastInsertId, $tableName, $columnName)
    {
        if (!empty($_FILES[$fieldName]['name'][0])) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filesCount = count($_FILES[$fieldName]['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                if (!empty($_FILES[$fieldName]['name'][$i])) {
                    $imageName = time() . '_' . basename($_FILES[$fieldName]['name'][$i]);
                    $imagePath = $uploadDir . $imageName;

                    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$i], $imagePath)) {
                        $imageData = [
                            'center_id'     => $lastInsertId,
                            'center_image'  => $imagePath,
                            'image_type'    => $columnName,
                            'doe'           => date('Y-m-d H:i:s'),
                            'added_by'      => $lastInsertId,
                            'deleted'       => 0,
                        ];
                        $this->Common_model->insertData('tt_center_images', $imageData);
                    }
                }
            }
        }
    }

    public function removeImages()
    {
        $id = $this->input->post('id');
        $where = array('id' => $id);
        $data = array('deleted' => 1);
        $this->Common_model->UpdateRecord('tt_center_images', $data, $where);

        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to send OTP. Please try again.'
        ]);
        exit;
    }


    public function detailProject()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $result = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);
        $cityId = $result->city_id ?? null;
        $project_id = $this->input->post('project_id');
        $booking_id = $this->input->post('booking_id');
        $data['project'] = $this->Common_model->get_single_booking_request($center_id, $project_id, $cityId, $booking_id);

        $data['batchAllocation'] = $this->db
            ->select("
                b.batch_no,
                b.batch_start,
                b.batch_end,
                b.seat AS required_seat,
                sbrb.center_seat
            ")
            ->from('tt_send_booking_request_batch sbrb')
            ->join(
                'tt_project_batch_detail b',
                'b.project_id = sbrb.project_id
                AND b.city_id = sbrb.city_id
                AND b.batch_no = sbrb.batch_no'
            )
            ->where('sbrb.request_id', $booking_id)
            ->order_by('b.batch_no')
            ->get()
            ->result_array();

        // Load view and return it as string
        $html = $this->load->view('booking/project_detail', $data, TRUE);
        echo $html;
    }


    public function updateBookingStatus()
    {
        $center_id  = $this->input->post('center_id');
        $project_id = $this->input->post('project_id');

        if (empty($center_id) || empty($project_id)) {

            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request.'
            ]);
            exit;
        }

        $this->load->helper('email');

        $where = [
            'center_id'  => $center_id,
            'project_id' => $project_id
        ];

        $data = [
            'exam_center_status'        => 1,
            'center_response_date'      => date('Y-m-d H:i:s'),
            'admin_status'              => 0,
            'final_booking_flag'        => 0,
            'center_booking_accept_date' => date('Y-m-d H:i:s')
        ];

        $this->Common_model->UpdateRecord('tt_send_booking_request', $data, $where);

        $bookingData = $this->Common_model->getdata('tt_send_booking_request', $where);

        if (empty($bookingData)) {

            echo json_encode([
                'status'  => false,
                'message' => 'Booking not found.'
            ]);
            exit;
        }

        $centerData = $this->Common_model->getdata(
            'tt_center',
            ['center_id' => $bookingData->center_id]
        );

        $booking_details = $this->db
            ->select('
            pd.exam_name,
            pd.client_id,
            pd.client_name,
            c.center_name,
            c.address,
            ci.city_name,
            c.pin_code,
            au.email as client_email
        ')
            ->from('tt_send_booking_request sbr')
            ->join('tt_project_detail pd', 'pd.project_id = sbr.project_id')
            ->join('tt_center c', 'c.center_id = sbr.center_id')
            ->join('tt_admin_users au', 'au.id = pd.client_id')
            ->join('tt_city_master ci', 'ci.city_id = c.city_id', 'left')
            ->where('sbr.center_id', $center_id)
            ->where('sbr.project_id', $project_id)
            ->get()
            ->row();

        if (!empty($booking_details) && !empty($centerData)) {

            $notification_data = [

                'admin_user_id' => 1,
                'center_id'     => $center_id,
                'client_id'     => null,

                'title'   => 'Center Accepted',

                'message' => $centerData->center_name .
                    ' accepted booking for ' .
                    $booking_details->exam_name,

                'type'       => 'admin',
                'is_read'    => 0,
                'is_remove'  => 0,
                'created_at' => date('Y-m-d H:i:s')

            ];

            $this->db->insert('notifications', $notification_data);
        }

        echo json_encode([
            'status'  => true,
            'message' => 'Booking accepted successfully.'
        ]);
        exit;
    }


    public function rejectBookingStatus()
    {
        $project_id = $this->input->post('project_id');
        $center_id  = $this->input->post('center_id');
        $action     = $this->input->post('action'); // reject | negotiate

        if (empty($project_id) || empty($center_id) || empty($action)) {

            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request.'
            ]);
            exit;
        }

        $where = [
            'project_id' => $project_id,
            'center_id'  => $center_id
        ];

        // NEGOTIATION FLOW
        if ($action === 'negotiate') {

            $data = [
                'exam_center_status' => 3, // Negotiation Requested
                'negotiate'          => $this->input->post('negotiate'),
                'comment'            => $this->input->post('rejection_comment'),
                'updated_at'         => date('Y-m-d H:i:s')
            ];

            $this->Common_model->UpdateRecord('tt_send_booking_request', $data, $where);


            // Get booking details with joins
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
                ->where('sbr.center_id', $center_id)
                ->where('sbr.project_id', $project_id)
                ->get()
                ->row();

            // Format full address
            $full_address = implode(', ', array_filter([
                $booking_details->address,
                $booking_details->city_name,
                $booking_details->pin_code
            ]));

            // Prepare negotiation email content
            $email_subject = "Price Negotiation Request: " . $booking_details->exam_name . " at " . $booking_details->center_name;

            $email_content = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .header { color: #2c3e50; }
                        .content { margin: 20px 0; }
                        .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                        .negotiation { background: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                        .button { 
                            display: inline-block; 
                            padding: 10px 20px; 
                            background: #3498db; 
                            color: white !important; 
                            text-decoration: none; 
                            border-radius: 5px; 
                            margin: 10px 0;
                        }
                        .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                    </style>
                </head>
                <body>
                    <h2 class="header">Price Negotiation Request</h2>
                    
                    <div class="content">
                        <p>Dear Admin,</p>
                        
                        <p>The following center has requested price negotiation for a booking:</p>
                        
                        <div class="details">
                            <h3>Project Details:</h3>
                            <p><strong>Exam Name:</strong> ' . htmlspecialchars($booking_details->exam_name) . '</p>
                            <p><strong>Client Name:</strong> ' . htmlspecialchars($booking_details->client_name) . '</p>
                        </div>
                        
                        <div class="details">
                            <h3>Center Details:</h3>
                            <p><strong>Center Name:</strong> ' . htmlspecialchars($booking_details->center_name) . '</p>
                            <p><strong>Contact Person:</strong> ' . htmlspecialchars($booking_details->center_owner_mobile) . '</p>
                            <p><strong>Email:</strong> ' . htmlspecialchars($booking_details->center_owner_email) . '</p>
                            <p><strong>Address:</strong> ' . htmlspecialchars($full_address) . '</p>
                        </div>
                        
                        <div class="negotiation">
                            <h3>Negotiation Details:</h3>
                            <p><strong>Negotiation Price:</strong> ₹' . htmlspecialchars($this->input->post('negotiate')) . '</p>
                            <p><strong>Rejection Reasons:</strong> ' . htmlspecialchars($rejection_reasons) . '</p>
                            <p><strong>Additional Comments:</strong> ' . htmlspecialchars($rejection_comment) . '</p>
                        </div>
                        
                        <p>Please review this negotiation request in the admin panel:</p>
                    </div>
                </body>
                </html>
            ';

            // Send email to admin
            $send = send_email(
                $email_content,
                $email_subject,
                "admin@testpanindia.com",
                "centerbooking@bookmytestcenter.com"
            );


            // ====================== Admin NOTIFICATION ======================

            // Title & Message
            $notification_title = "Price Negotiation";

            $notification_message =
                "Center has requested price negotiation for a booking. "
                . "Center Name: {$booking_details->center_name} "
                . "and Email: {$booking_details->center_owner_email}";

            // Notification data
            $notification_data = [
                'admin_user_id' => $booking_details->admin_user_id,
                'center_id'     => $center_id,
                'client_id'     => null,
                'title'         => $notification_title,
                'message'       => $notification_message,
                'type'          => 'admin',
                'is_read'       => 0,
                'is_remove'     => 0,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            // Insert notification
            $this->db->insert('notifications', $notification_data);

            echo json_encode([
                'status'  => true,
                'message' => 'Negotiation request sent to admin successfully.'
            ]);
            exit;
        }

        // FINAL REJECT FLOW
        $data = [
            'exam_center_status' => 2,
            'center_response_date' => date('Y-m-d H:i:s'),
            'reason'             => implode(',', $this->input->post('rejection_reasons')),
            'comment'            => $this->input->post('rejection_comment'),
            'updated_at'         => date('Y-m-d H:i:s')
        ];

        $this->Common_model->UpdateRecord('tt_send_booking_request', $data, $where);

        echo json_encode([
            'status'  => true,
            'message' => 'Booking rejected successfully.'
        ]);
        exit;
    }



    public function fetchRejectBookingContent()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $project_id = $this->input->post('project_id');

        $data['center_id'] = $center_id;
        $data['project_id'] = $project_id;

        // Load view and return it as string
        $html = $this->load->view('booking/reject_booking', $data, TRUE);
        echo $html;
    }


    public function fetchNegotiateBookingContent()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $project_id = $this->input->post('project_id');

        $data['center_id'] = $center_id;
        $data['project_id'] = $project_id;

        // Load view and return it as string
        $html = $this->load->view('booking/negotiate_booking', $data, TRUE);
        echo $html;
    }


    public function createSelfBooking()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $center_id = $this->session->userdata('exam_center_id');

        // Check if dates conflict in `tt_self_bookings`
        $selfBookingConflict = $this->Common_model->check_date_conflict_self_booking($center_id, $start_date, $end_date);

        // Check if dates conflict in `tt_project_detail` (via `tt_send_booking_request`)
        $projectConflict = $this->Common_model->check_date_conflict_project($center_id, $start_date, $end_date);

        if ($selfBookingConflict || $projectConflict) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking dates conflict with an existing booking!',
            ]);
            exit;
        }


        // If no conflict, proceed with booking creation
        $exam_date  = $start_date . '-' . $end_date;
        $exam_batch = $this->input->post('exam_batch');

        $batchData = [];

        for ($i = 1; $i <= 5; $i++) {

            $start = trim($this->input->post('batch' . $i . '_start'));
            $end   = trim($this->input->post('batch' . $i . '_end'));

            $batchData['batch' . $i . '_start'] = str_replace("'", "&#8217;", $start);
            $batchData['batch' . $i . '_end']   = str_replace("'", "&#8217;", $end);
        }
        $created_at = date('Y-m-d H:i:s');

        $data = array(
            'client_name' => $this->input->post('client_name'),
            'client_email' => $this->input->post('client_email'),
            'client_phone' => $this->input->post('client_phone'),
            'exam_name' => $this->input->post('exam_name'),
            'exam_type' => $this->input->post('exam_type'),
            'exam_location' => $this->input->post('exam_location'),
            'exam_date' => $exam_date,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'exam_duration' => $this->input->post('exam_duration'),
            'exam_time' => $this->input->post('exam_time'),
            'seats_booked' => $this->input->post('seats_booked'),
            'labs_assigned' => $this->input->post('labs_assigned'),
            'center_id' => $center_id,
            'total_batch' => $this->input->post('exam_batch'),
            'created_at'     => $created_at,
            'updated_at'     => $created_at,
        );

        // merge batch start/end columns
        $data = array_merge($data, $batchData);

        $insert_id = $this->Common_model->insertData('tt_self_bookings', $data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Booking created successfully!',
        ]);
        exit;
    }


    public function fetchBookingViewById()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $center_id = $this->session->userdata('exam_center_id');

        if ($type == 'self-booking') {
            $data['result'] = $this->Common_model->get_self_booking_data_by_id($id);
            $data['booking_type'] = 'self';
        } elseif ($type == 'assigned-booking') {
            $data['result'] = $this->Common_model->get_assigned_booking_data_by_id($id);
            $data['booking_type'] = 'assigned';
        }

        // Load view and return it as string
        $html = $this->load->view('booking/view_booking', $data, TRUE);
        echo $html;
    }


    public function editSelfBookingById()
    {
        $id = $this->input->post('id');
        $center_id = $this->session->userdata('exam_center_id');

        $data['result'] = $this->Common_model->getdata('tt_self_bookings', array('id' => $id));
        $data['labs'] = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);

        // Load view and return it as string
        $html = $this->load->view('booking/edit_self_booking', $data, TRUE);
        echo $html;
    }


    public function updateSelfBooking()
    {
        $id = $this->input->post('id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $center_id = $this->session->userdata('exam_center_id');

        // Check for date conflicts (excluding the current booking being updated)
        $selfBookingConflict = $this->Common_model->check_date_conflict_self_booking(
            $center_id,
            $start_date,
            $end_date,
            $id // Exclude current booking
        );

        $projectConflict = $this->Common_model->check_date_conflict_project(
            $center_id,
            $start_date,
            $end_date
        );

        if ($selfBookingConflict || $projectConflict) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking dates conflict with an existing booking!',
            ]);
            exit;
        }

        // Proceed with update if no conflicts
        $exam_date = $start_date . '-' . $end_date;
        $updated_at = date('Y-m-d H:i:s');
        $data = [
            'client_name'    => $this->input->post('client_name'),
            'client_email'   => $this->input->post('client_email'),
            'client_phone'   => $this->input->post('client_phone'),
            'exam_name'      => $this->input->post('exam_name'),
            'exam_type'      => $this->input->post('exam_type'),
            'exam_location'  => $this->input->post('exam_location'),
            'exam_date'      => $exam_date,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'exam_duration'  => $this->input->post('exam_duration'),
            'seats_booked'   => $this->input->post('seats_booked'),
            'labs_assigned'  => $this->input->post('labs_assigned'),
            'total_batch'    => $this->input->post('exam_batch'),
            'updated_at'     => $updated_at,
        ];

        // Add batch timings
        for ($i = 1; $i <= 5; $i++) {

            $start = trim($this->input->post('batch' . $i . '_start'));
            $end   = trim($this->input->post('batch' . $i . '_end'));

            if (!empty($start)) {
                $data['batch' . $i . '_start'] = str_replace("'", "&#8217;", $start);
            }

            if (!empty($end)) {
                $data['batch' . $i . '_end'] = str_replace("'", "&#8217;", $end);
            }
        }

        $this->Common_model->UpdateRecord('tt_self_bookings', $data, ['id' => $id]);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Booking updated successfully!',
        ]);
        exit;
    }


    public function deleteSelfBooking()
    {
        header('Content-Type: application/json');

        $booking_id = $this->input->post('booking_id');
        $center_id  = $this->session->userdata('exam_center_id');

        if (!$booking_id || !$center_id) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Invalid request.'
            ]);
            return;
        }

        // Fetch booking
        $booking = $this->db
            ->where('id', $booking_id)
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_self_bookings')
            ->row();

        if (!$booking) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Booking not found.'
            ]);
            return;
        }

        /* =====================================================
           ⏱️ 24 HOURS DELETE RESTRICTION
        ===================================================== */

        // If exam_time exists, combine it, else default 00:00:00
        $examTime = !empty($booking->exam_time) ? $booking->exam_time : '00:00:00';

        $examDateTime = strtotime($booking->start_date . ' ' . $examTime);
        $currentTime  = time();

        $hoursLeft = ($examDateTime - $currentTime) / 3600;

        if ($hoursLeft <= 24) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Booking cannot be deleted within 24 hours of exam start.'
            ]);
            return;
        }

        /* =====================================================
           SAFE TO DELETE
        ===================================================== */

        $this->Common_model->Deletedata('tt_self_bookings', array('id' => $booking_id));

        echo json_encode([
            'status'  => 'success',
            'message' => 'Booking deleted successfully.'
        ]);
        exit;
    }


    public function myCenter()
    {
        $center_id = $this->session->userdata('exam_center_id');

        $data['countries'] = $this->Common_model->getdata_array('tt_countries', ['is_active' => 1]);
        $data['center_type'] = $this->Common_model->getdata_array('tt_center_type', ['deleted' => 0]);
        $data['bank_name'] = $this->Common_model->getdata_array('tt_bank_name', ['deleted' => 0]);
        $data['result'] = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);
        $data['labs'] = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);
        $data['documents'] = $this->Common_model->getdata_array('tt_center_document', ['center_id' => $center_id]);
        $data['walkthrough_video'] = $this->Common_model->getdata_array('tt_center_video', ['center_id' => $center_id, 'deleted' => 0]);
        $data['center_entrances'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'center_entrance']);
        $data['lab_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'lab_photo']);
        $data['gate_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'gate_image']);
        $data['server_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'server_image']);
        $data['observer_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'observer_image']);
        $data['ups_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'ups_image']);

        $ownerUserId = $data['result']->owner_user_id ?? 0;

        $data['editRequest']    = $this->getProfileEditRequest($center_id, $ownerUserId);
        $data['editPermission'] = $this->getEditPermission($center_id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/my-center', $data);
        $this->load->view('layouts/footer');
    }


    public function myCalendar()
    {
        $center_id = $this->session->userdata('exam_center_id');

        $data['selfBookingData'] = $this->Common_model->get_client_self_booking($center_id, '', '');
        $data['total_self_booking_req_count'] = count($data['selfBookingData']);

        // Calendar data
        $month = $this->input->get('month') ?? date('n');
        $year = $this->input->get('year') ?? date('Y');

        $exam_dates = $this->Common_model->get_exam_dates($month, $year, $center_id);
        $calendar = $this->generate_calendar($month, $year, $exam_dates);

        // Add to existing $data array
        $data['calendar'] = $calendar;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['exam_dates'] = $exam_dates;

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/my-calendar', $data);
        $this->load->view('layouts/footer');
    }


    public function mySelfBooking()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $search    = trim($this->input->get('search')); // GET search

        $data['labs'] = $this->Common_model->getdata_array(
            'tt_lab',
            ['center_id' => $center_id]
        );

        // Search
        $data['selfBookingData'] = $this->Common_model
            ->get_client_self_booking($center_id, $search);

        $data['total_self_booking_req_count'] = count($data['selfBookingData']);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/my-self-booking', $data);
        $this->load->view('layouts/footer');
    }



    public function exportSelfBooking()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $search    = trim($this->input->get('search')); // SAME FILTER

        $selfBookingData = $this->Common_model
            ->get_client_self_booking($center_id, $search);

        // Load PhpSpreadsheet library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Client Name');
        $sheet->setCellValue('B1', 'Client Email');
        $sheet->setCellValue('C1', 'Client Phone');
        $sheet->setCellValue('D1', 'Exam Name');
        $sheet->setCellValue('E1', 'Exam Type');
        $sheet->setCellValue('F1', 'Exam Date');
        $sheet->setCellValue('G1', 'Seats Booked');
        $sheet->setCellValue('H1', 'Exam Location');

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

        // Fill data
        $row = 2;
        foreach ($selfBookingData as $booking) {
            $sheet->setCellValue('A' . $row, $booking['client_name']);
            $sheet->setCellValue('B' . $row, $booking['client_email']);
            $sheet->setCellValue('C' . $row, $booking['client_phone']);
            $sheet->setCellValue('D' . $row, $booking['exam_name']);
            $sheet->setCellValue('E' . $row, $booking['exam_location']);
            $sheet->setCellValue('F' . $row, date('M d, Y', strtotime($booking['start_date'])) . ' - ' . date('M d, Y', strtotime($booking['end_date'])));
            $sheet->setCellValue('G' . $row, $booking['seats_booked']);
            $sheet->setCellValue('H' . $row, $booking['exam_location']);
            $row++;
        }

        // Set column widths
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="self_bookings_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    public function helpSupport()
    {
        $data['result'] = $this->Common_model->getdata_array('custom_settings', '');

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/support', $data);
        $this->load->view('layouts/footer');
    }

    public function settings()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $data['center_data'] = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));
        $data['result'] = $this->Common_model->getdata('tt_admin_users', array('id' => $data['center_data']->owner_user_id));


        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/setting', $data);
        $this->load->view('layouts/footer');
    }


    public function updateSetting()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $data['center_data'] = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));

        $updated_at = date('Y-m-d H:i:s');
        $name = $this->input->post('name');

        // Split the name into parts
        $name_parts = explode(' ', trim($name));

        // Assign first and last names
        $first_name = isset($name_parts[0]) ? $name_parts[0] : '';
        $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

        $examCenterdata = [
            'username'     => $name,
            'email'        => $this->input->post('email'),
            'mobile_phone' => $this->input->post('mobile_phone'),
            'updated' => $updated_at,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];

        $result = $this->Common_model->UpdateRecord('tt_admin_users', $examCenterdata, ['id' => $data['center_data']->owner_user_id]);

        if ($result) {
            $this->session->set_flashdata('success', 'Data updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update data');
        }

        redirect('settings');

        exit;
    }


    public function deleteAccount()
    {
        $center_id = $this->session->userdata('exam_center_id');

        if (empty($center_id)) {
            return redirect()->back()->with('error', 'Invalid center.');
        }

        // 🔒 Booking protection
        if ($this->Common_model->has_any_booking($center_id)) {
            return redirect()->back()->with(
                'error',
                'Account cannot be deleted because self or assigned bookings exist.'
            );
        }

        $data = ['deleted' => 1];

        $this->Common_model->UpdateRecord(
            'tt_center',
            $data,
            ['center_id' => $center_id]
        );

        return redirect('/center-owner-dashboard')->with('success', 'Account deleted successfully.');
    }


    public function updateCenterLogo()
    {
        $updated_at   = date('Y-m-d H:i:s');
        $examCenterId = $this->session->userdata('exam_center_id');

        // Upload logo
        $logoPath = 'uploads/center_logo/';
        if (!is_dir($logoPath)) {
            mkdir($logoPath, 0777, true);
        }

        $updateData = [
            'last_modified_on' => $updated_at
        ];

        if (!empty($_FILES['logo']['name'])) {
            $logoFileName   = time() . '_' . basename($_FILES['logo']['name']);
            $logoTargetPath = $logoPath . $logoFileName;

            if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoTargetPath)) {
                $updateData['logo'] = $logoTargetPath;
            }
        }

        // ✅ Update only if we have data
        if (!empty($updateData)) {
            $this->Common_model->UpdateRecord('tt_center', $updateData, ['center_id' => $examCenterId]);
        }

        // Send response
        echo json_encode([
            'success' => true,
            'message' => 'Logo updated successfully!',
        ]);
        exit;
    }


    public function getProfileEditRequest($centerId, $ownerUserId)
    {
        return $this->db
            ->where('center_id', $centerId)
            ->where('owner_user_id', $ownerUserId)
            ->where('is_active', 1)
            ->order_by('id', 'DESC')
            ->get('profile_edit_requests')
            ->row();
    }

    public function getEditPermission($centerId)
    {
        return $this->db
            ->where('center_id', $centerId)
            ->where('is_edit_allowed', 1)
            ->get('center_edit_permissions')
            ->row();
    }

    public function requestProfileEdit()
    {
        $center_id = $this->session->userdata('exam_center_id');

        $center = $this->Common_model->getdata(
            'tt_center',
            ['center_id' => $center_id]
        );

        $ownerUserId = $center->owner_user_id ?? 0;

        // deactivate old pending requests
        $this->db->where('center_id', $center_id)
            ->where('status', 'pending')
            ->update('profile_edit_requests', ['is_active' => 0]);

        $data = [
            'center_id'       => $center_id,
            'owner_user_id'   => $ownerUserId,
            'request_message' => $this->input->post('request_message'),
            'status'          => 'pending',
            'is_active'       => 1
        ];

        $this->db->insert('profile_edit_requests', $data);


        $this->db->select('c.center_name, c.address, au.email, au.mobile_phone');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
        $this->db->where('c.center_id', $center_id);
        $result = $this->db->get()->row();

        $owner_email  = $result->email;
        $owner_mobile = $result->mobile_phone;

        $email_subject = "Profile Edit Request Submitted – " . $center->center_name;

        $email_content = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color:#333; }
                    .header { color: #2c3e50; }
                    .content { margin: 20px 0; }
                    .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom:15px; }
                    .highlight { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                    .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                </style>
            </head>
            <body>

                <h2 class="header">Profile Edit Request Notification</h2>
                
                <div class="content">
                    <p>Dear Admin,</p>
                    
                    <p>
                        A profile edit request has been submitted by the following center. 
                        Kindly review and take the necessary action.
                    </p>

                    <div class="highlight">
                        <strong>Status:</strong> Pending Approval<br>
                        Please login to the admin panel to review the requested changes.
                    </div>

                    <div class="details">
                        <h3>Center Details:</h3>
                        <p><strong>Center Name:</strong> ' . htmlspecialchars($center->center_name) . '</p>
                        <p><strong>Registered Email:</strong> ' . htmlspecialchars($owner_email) . '</p>
                        <p><strong>Contact Number:</strong> ' . htmlspecialchars($owner_mobile) . '</p>
                        <p><strong>Address:</strong> ' . htmlspecialchars($center->address) . '</p>
                    </div>

                    <div class="details">
                        <h3>Request Message:</h3>
                        <p>' . nl2br(htmlspecialchars($this->input->post('request_message'))) . '</p>
                    </div>

                    <p>
                        Please review the request at your earliest convenience.
                    </p>
                </div>

            </body>
            </html>
            ';


        $send = send_email(
            $email_content,
            $email_subject,
            "admin@testpanindia.com",
            "centerbooking@bookmytestcenter.com"
        );

        $this->session->set_flashdata('success', 'Edit request submitted successfully.');
        redirect('my-center');
    }


    public function centerAllNotification()
    {
        $owner_id = $this->session->userdata('owner_id');
        $center_id = $this->session->userdata('exam_center_id');

        $this->load->library('pagination');

        // Base query
        $this->db->from('notifications');
        $this->db->where([
            'admin_user_id' => $owner_id,
            'type'          => 'center',
            'is_remove'     => 0
        ]);

        if (!empty($center_id)) {
            $this->db->where('notifications.center_id', $center_id);
        }

        $config['base_url'] = base_url('owner-all-notifications');
        $config['per_page'] = 20;
        $config['total_rows'] = $this->db->count_all_results('', false);

        $this->db->select('notifications.*, centers.center_name');
        $this->db->join('tt_center as centers', 'centers.id = notifications.center_id', 'left');
        $this->db->order_by('notifications.created_at', 'DESC');
        $this->db->limit($config['per_page'], $this->uri->segment(2));

        $data['notifications'] = $this->db->get()->result();

        $data['selected_center'] = $center_id;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/common/all_notifications', $data);
        $this->load->view('layouts/footer');
    }


    public function markAllRead()
    {
        $owner_id  = $this->session->userdata('owner_id');
        $center_id = $this->session->userdata('exam_center_id');

        $this->db->where([
            'admin_user_id' => $owner_id,
            'type'          => 'center',
            'is_remove'     => 0
        ]);

        if (!empty($center_id)) {
            $this->db->where('center_id', $center_id);
        }

        $this->db->update('notifications', ['is_read' => 1]);

        redirect($_SERVER['HTTP_REFERER']);
    }


    public function removeNotification($id)
    {
        $owner_id = $this->session->userdata('owner_id');

        $this->db->where([
            'id'            => $id,
            'admin_user_id' => $owner_id
        ]);

        $this->db->update('notifications', [
            'is_remove' => 1
        ]);

        redirect($_SERVER['HTTP_REFERER']);
    }
}
