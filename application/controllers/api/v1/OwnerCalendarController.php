<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OwnerCalendarController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->model('Booking_model');
        $this->load->library('session');
    }
    

    /* =======================================================
     AUTH HELPER
    ======================================================= */
    private function authenticateOwner()
    {
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!$token) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'API token missing']);
            exit;
        }

        $owner = $this->Common_model->getdata('tt_admin_users', [
            'api_token' => $token,
            'role_id'   => 9
        ]);

        if (!$owner) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'Invalid API token']);
            exit;
        }

        return $owner;
    }


    // ==============================
    // GET CALENDAR DATA API
    // ==============================
    public function get_calendar()
    {
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        $month     = $this->input->post('month') ?: date('n');
        $year      = $this->input->post('year') ?: date('Y');
        $center_id = $this->input->post('center_id');

        // Owner centers
        $owner_centers = $this->db
            ->select('id')
            ->where('owner_user_id', $owner_id)
            ->where('deleted', 0)
            ->get('tt_center')
            ->result_array();

        $owner_center_ids = array_column($owner_centers, 'id');

        // If specific center selected
        if (!empty($center_id) && in_array($center_id, $owner_center_ids)) {
            $center_ids = [$center_id];
        } else {
            $center_ids = $owner_center_ids;
        }

        // Booked Dates
        $booked_dates = $this->Booking_model
            ->get_booked_dates($month, $year, $center_ids);

        // Summary
        $summary = $this->Booking_model
            ->get_center_booking_summary($month, $year, $center_ids);

        echo json_encode([
            "status" => true,
            "message" => "Calendar data fetched successfully",
            "data" => [
                "month" => $month,
                "year"  => $year,
                "booked_dates" => $booked_dates,
                "summary" => $summary
            ]
        ]);
    }


    // ==============================
    // BOOKINGS BY DATE API
    // ==============================
    public function get_bookings_by_date()
    {
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        $date      = $this->input->post('date');

        $bookings = $this->Booking_model
            ->get_bookings_by_date($date);

        echo json_encode([
            "status" => true,
            "message" => "Bookings fetched successfully",
            "data" => $bookings
        ]);
    }

    
}