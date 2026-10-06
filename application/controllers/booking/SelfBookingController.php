<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class SelfBookingController extends MY_Controller
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
    
}