<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CenterAvailabilityController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('CenterAvailability_model', 'availabilityModel');
        $this->load->library('CenterAvailabilityService');

        $this->load->database();
        $this->load->library(['session']);
        $this->load->helper(['url']);
        $this->load->model('Common_model');

        // Auth Guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('center_availability');
    }

    /* ================================
       Main Page
    ================================= */
    public function index()
    {
        $data['page_title'] = "Center Availability";
        $data['admin']      = $this->session->userdata('admin_user');

        $data['owner_data'] = $this->Common_model->getdata_array(
            'tt_admin_users',
            array('role_id' => 9)
        );

        $data['country_data'] = $this->Common_model->getdata_array(
            'tt_countries',
            ''
        );

        // Initial overview
        $data['overview'] = $this->centeravailabilityservice
            ->getAvailabilityOverview([]);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/center_availability/index', $data);
        $this->load->view('layouts/footer');
    }

    /* ================================
       AJAX Listing
    ================================= */
    public function ajaxList()
    {
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $filters = [
            'city_id'      => $this->input->post('city_id'),
            'date_from'    => $this->input->post('date_from'),
            'date_to'      => $this->input->post('date_to'),
            'capacity'     => $this->input->post('capacity'),
            'country_id'   => $this->input->post('country_id'),
            'state_id'     => $this->input->post('state_id'),
            'city'         => $this->input->post('city'),
            'center_owner' => $this->input->post('center_owner'),
            'search'       => trim($this->input->post('search')['value']),
        ];

        $result = $this->centeravailabilityservice
            ->getAvailabilityList($filters, $start, $length);

        $overview = $this->centeravailabilityservice
            ->getAvailabilityOverview($filters);

        echo json_encode([
            "draw"            => $draw,
            "recordsTotal"    => $result['total'],
            "recordsFiltered" => $result['total'],
            "data"            => $result['data'],
            "overview"        => $overview
        ]);

        exit;
    }
}
