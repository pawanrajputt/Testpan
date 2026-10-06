<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CenterCalendarController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->database();

        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('center_calendar');
    }

    /* ===============================
       CALENDAR PAGE
    =============================== */
    public function center_calendar()
    {
        // Get current month and year
        $current_month = date('n');
        $current_year = date('Y');

        // Get booked dates for current month
        $data['booked_dates'] = $this->Booking_model->get_booked_dates($current_month, $current_year);
        $data['month'] = $current_month;
        $data['year'] = $current_year;

        $data['all_centers'] = $this->db
            ->where('deleted', 0)
            ->order_by('center_name', 'ASC')
            ->get('tt_center')
            ->result_array();

        $data['summary'] = $this->Booking_model->get_calendar_summary(
            $current_month,
            $current_year
        );

        $data['calendar_counts'] = $this->Booking_model->get_calendar_day_counts(
            $current_month,
            $current_year
        );


        $data['calendar_tooltips'] = $this->Booking_model->get_calendar_tooltips(
            $current_month,
            $current_year
        );

        $data['month_counts'] = $this->Booking_model->get_assigned_booking_month_counts($current_year);

        $data['page_title'] = 'Booking Calendar';
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/calendar/center_calendar', $data);
        $this->load->view('layouts/footer');
    }

    public function get_bookings_by_date()
    {
        $date = $this->input->post('date');
        $data['bookings'] = $this->Booking_model->get_bookings_by_date($date);
        $this->load->view('dashboard/calendar/bookings_table', $data);
    }

    public function get_calendar()
    {

        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $center_id = $this->input->post('center_id'); // NEW

        $data['month'] = $month;
        $data['year'] = $year;
        $data['center_id'] = $center_id; // NEW

        $data['booked_dates'] = $this->Booking_model->get_booked_dates($month, $year, $center_id);

        $data['calendar_counts'] = $this->Booking_model->get_calendar_day_counts(
            $month,
            $year,
            $center_id
        );

        $data['calendar_tooltips'] = $this->Booking_model->get_calendar_tooltips(
            $month,
            $year,
            $center_id
        );

        $this->load->view('dashboard/calendar/calendar_partial', $data);
    }


    public function get_calendar_summary()
    {
        $month     = $this->input->post('month');
        $year      = $this->input->post('year');
        $center_id = $this->input->post('center_id');

        echo json_encode(
            $this->Booking_model->get_calendar_summary($month, $year, $center_id)
        );
    }

    public function get_month_counts()
    {
        $year      = $this->input->post('year');
        $center_id = $this->input->post('center_id');

        echo json_encode(
            $this->Booking_model
                ->get_assigned_booking_month_counts($year, $center_id)
        );
    }

    public function get_booking_statistics()
    {
        $year      = $this->input->post('year');
        $center_id = $this->input->post('center_id');

        echo json_encode(
            $this->Booking_model->get_booking_statistics(
                $year,
                $center_id
            )
        );
    }


    // ==================View Calendar of Center===============
    public function viewCenterCalendar($centerId = null)
    {
        if (empty($centerId)) {
            show_404();
        }

        // Month & Year from GET (optional for navigation)
        $month = $this->input->get('month') ?: date('n');
        $year  = $this->input->get('year') ?: date('Y');

        // Fetch booked dates
        $bookedDates = $this->Booking_model
            ->get_center_booked_dates($month, $year, $centerId);

        $summary = $this->Booking_model->get_center_booking_summary($month, $year, $centerId);


        $data['center_id']    = $centerId;
        $data['month']        = $month;
        $data['year']         = $year;
        $data['booked_dates'] = $bookedDates;
        $data['summary']      = $summary;

        $data['calendar_counts'] = $this->Booking_model->get_calendar_day_counts(
            $month,
            $year,
            $centerId
        );

        $data['calendar_tooltips'] = $this->Booking_model->get_calendar_tooltips(
            $month,
            $year,
            $centerId
        );

        $data['page_title']   = "Center Calendar";
        $data['admin']        = $this->session->userdata('admin_user');


        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/calendar/view/center-calendar', $data);
        $this->load->view('layouts/footer');
    }


    public function viewGetCenterCalendar()
    {
        $month     = $this->input->post('month');
        $year      = $this->input->post('year');
        $center_id = $this->input->post('center_id');

        // Get booked dates
        $booked_dates = $this->Booking_model
            ->get_center_booked_dates($month, $year, $center_id);

        // Get summary counts
        $summary = $this->Booking_model
            ->get_center_booking_summary($month, $year, $center_id);

        // Render calendar partial
        $calendar_html = $this->load->view(
            'dashboard/calendar/view/calendar-partial',
            [
                'month' => $month,
                'year' => $year,
                'booked_dates' => $booked_dates,
                'calendar_counts' => $calendar_counts,
                'calendar_tooltips' => $calendar_tooltips
            ],
            true
        );

        // Render summary partial
        $summary_html = $this->load->view(
            'dashboard/calendar/view/calendar-summary-partial',
            [
                'summary' => $summary
            ],
            true
        );

        $calendar_counts = $this->Booking_model->get_calendar_day_counts(
            $month,
            $year,
            $center_id
        );

        $calendar_tooltips = $this->Booking_model->get_calendar_tooltips(
            $month,
            $year,
            $center_id
        );

        echo json_encode([
            'calendar' => $calendar_html,
            'summary'  => $summary_html
        ]);
    }



    public function viewGetCenterBookingsByDate()
    {
        $date = $this->input->post('date');
        $center_id = $this->input->post('center_id');
        $data['bookings'] = $this->Booking_model->get_center_bookings_by_date($date, $center_id);
        $this->load->view('dashboard/calendar/view/bookings-table', $data);
    }
}
