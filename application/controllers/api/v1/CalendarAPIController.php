<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);

class CalendarAPIController extends CI_Controller
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
     * GET /api/client/calendar
     * Returns calendar data in JSON
     */
    public function myCalendar()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get all calendar bookings
            $calendarBookings = $this->Common_model->get_calendar_booking_data($ac_id);

            // 3. Organize by month (combined)
            $monthlyEvents = [];

            if ($calendarBookings) {
                foreach ($calendarBookings as $booking) {

                    $monthYear = date(
                        'F Y',
                        strtotime($booking->start_date)
                    );

                    $monthlyEvents[$monthYear][] = $booking;
                }
            }

            // 4. Total cities covered
            $query = $this->db->query("
            SELECT COUNT(DISTINCT exam_city_id) AS total_cities
            FROM tt_project_detail
            WHERE client_id = ?
            AND deleted = 0
        ", [$ac_id]);

            $totalCityCovered = $query->row();

            // 5. Total required seats
            $number_of_seats = $this->Common_model
                ->get_number_of_seats_of_client(
                    'tt_send_booking_request',
                    $ac_id
                );

            // 6. Total booked seats
            $totalBookedSeat = $this->Common_model
                ->get_total_booked_seat_of_client(
                    'tt_send_booking_request',
                    $ac_id
                );

            // 7. Build response
            $responseData = [
                'calendarBookings' => $calendarBookings,
                'monthlyEvents'     => $monthlyEvents,
                'totalCityCovered'  => $totalCityCovered,
                'number_of_seats'   => $number_of_seats,
                'totalBookedSeat'   => $totalBookedSeat
            ];

            // 8. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Calendar details fetched successfully.',
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
}
