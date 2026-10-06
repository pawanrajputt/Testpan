<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);

class DashboardAPIController extends CI_Controller
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
     * GET /api/client/dashboard
     * Returns dashboard statistics in JSON
     */
    public function dashboard()
    {
        $this->output->set_content_type('application/json');

        try {
            // Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // Fetch data
            $clientData = $this->Common_model->getSignleClientData($ac_id);
            $cityList = $this->Common_model->getdata_array('tt_city_master', []);
            $projects = $this->Common_model->getClientProjectDataGroupBy($ac_id, '');
            $pendingProjects = $this->Common_model->getClientProjectDataGroupBy($ac_id, 'pending');
            $completeProjects = $this->Common_model->getClientProjectDataGroupBy($ac_id, 'completed');
            $totalProjectCount = count($projects);

            $summary = $this->Common_model->get_total_assessed_candidates($ac_id);
            $totalAssessed = $summary['assessed'] ?? 0;
            $totalRequired = $summary['required'] ?? 0;

            $totalCityCovered = $this->Common_model->get_total_cities_covered($ac_id);
            $totalSystemCities = $this->db->count_all('tt_city_master');
            $cityPercent = ($totalSystemCities > 0)
                ? round(($totalCityCovered->total_cities / $totalSystemCities) * 100)
                : 0;

            // Response
            $response = [
                'status' => 'success',
                'message' => 'Dashboard data fetched successfully',
                'data' => [
                    'client' => $clientData,
                    'city' => $cityList,
                    'projects' => $projects,
                    'pendingProjects' => $pendingProjects,
                    'completeProjects' => $completeProjects,
                    'totalProjectCount' => $totalProjectCount,
                    'totalAssessed' => $totalAssessed,
                    'totalRequired' => $totalRequired,
                    'totalCityCovered' => $totalCityCovered->total_cities ?? 0,
                    'cityPercent' => $cityPercent
                ]
            ];

            $this->output
                ->set_status_header(200)
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            log_message('error', 'Dashboard API error: ' . $e->getMessage());
            $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }

    /**
     * DELETE /api/client/deleteAccount
     * Soft delete client account (only if no projects or bookings exist)
     */
    public function deleteAccount()
    {
        $this->output->set_content_type('application/json');

        try {
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            if (!$ac_id) {
                throw new Exception('Invalid account.');
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
                $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Account cannot be deleted because bookings or projects are associated with this account.'
                    ]));
                return;
            }

            // Soft Delete
            $data = ['deleted' => 1];

            $this->Common_model->UpdateRecord('tt_admin_users', $data, ['id' => $ac_id]);
            $this->Common_model->UpdateRecord('tt_client', $data, ['ac_id' => $ac_id]);

            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Account deleted successfully.'
                ]));
        } catch (Exception $e) {
            $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }

}