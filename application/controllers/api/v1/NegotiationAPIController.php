<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);

class NegotiationAPIController extends CI_Controller
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
     * GET /api/client/negotiation-modal
     * Returns negotiation modal data in JSON
     */
    public function fetchNegotiationData()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get project ID from Form Data
            $projectId = $this->input->post('project_id');

            if (empty($projectId)) {
                throw new Exception('Invalid Project.', 400);
            }

            // 3. Fetch project detail
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
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->where('deleted', 0)
                ->get('tt_project_detail')
                ->row_array();

            if (empty($project)) {
                throw new Exception('Project not found.', 404);
            }

            // 4. Calculate original amount
            $originalAmount =
                (int)$project['number_of_seats']
                *
                (float)$project['price_per_seat'];

            // 5. Calculate final amount
            $finalAmount =
                !empty($project['admin_client_final_amount'])
                ? (float)$project['admin_client_final_amount']
                : $originalAmount;

            // 6. Build response
            $responseData = [
                'project_id'        => $project['project_id'],
                'exam_name'         => $project['exam_name'],
                'client_name'       => $project['client_name'],
                'original_amount'   => $originalAmount,
                'final_amount'      => $finalAmount,
                'remark'            => $project['client_negotiate_remark'],
                'negotiation_status' => $project['client_negotiation_status']
            ];

            // 7. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Negotiation details fetched successfully.',
                    'data'    => $responseData
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


    public function saveClientNegotiation()
    {
        $this->output->set_content_type('application/json');

        try {

            /**
             * Authenticate Client
             */
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            /**
             * Form Data
             */
            $projectId  = $this->input->post('project_id');
            $finalAmount = $this->input->post('final_amount');
            $remark     = trim($this->input->post('remark'));

            /**
             * Required Validation
             */
            if (empty($projectId) || $finalAmount === '' || $finalAmount === null) {

                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Required fields missing.'
                    ]));
            }

            /**
             * Get Project
             */
            $project = $this->db
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->where('deleted', 0)
                ->get('tt_project_detail')
                ->row();

            if (!$project) {

                return $this->output
                    ->set_status_header(404)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Project not found.'
                    ]));
            }

            /**
             * Old Amount
             */
            $oldAmount = !empty($project->admin_client_final_amount)
                ? $project->admin_client_final_amount
                : (
                    $project->number_of_seats *
                    $project->price_per_seat
                );

            /**
             * Start Transaction
             */
            $this->db->trans_begin();

            /**
             * Update Project Negotiation
             */
            $this->db
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->update('tt_project_detail', [

                    // Client latest demand
                    'client_negotiate_amount'   => $finalAmount,

                    // Admin counter amount aane tak same amount rahega
                    'admin_client_final_amount' => $finalAmount,

                    'client_negotiate_remark'   => $remark,

                    // Client requested
                    'client_negotiation_status' => 1
                ]);

            /**
             * Insert Negotiation History
             */
            $this->db->insert(
                'tt_booking_negotiation_logs',
                [
                    'project_id'      => $projectId,
                    'client_id'       => $project->client_id,
                    'center_id'       => 0,
                    'raised_by'       => 'client',
                    'old_price'       => $oldAmount,
                    'new_price'       => $finalAmount,
                    'remark'          => $remark,
                    'status'          => 'Client Requested',
                    'negotiation_type' => 'client',
                    'final_flag'      => 0,
                    'created_by'      => $ac_id,
                    'created_at'      => date('Y-m-d H:i:s')
                ]
            );

            /**
             * Transaction Check
             */
            if ($this->db->trans_status() === false) {

                $this->db->trans_rollback();

                return $this->output
                    ->set_status_header(500)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Unable to save negotiation.'
                    ]));
            }

            /**
             * Commit Transaction
             */
            $this->db->trans_commit();

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Negotiation submitted successfully.'
                ]));
        } catch (Exception $e) {

            if ($this->db->trans_status() !== false) {
                $this->db->trans_rollback();
            }

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            return $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }


    public function getClientNegotiationHistory()
    {
        $this->output->set_content_type('application/json');

        try {

            /**
             * Authenticate Client
             */
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            /**
             * Form Data
             */
            $projectId = $this->input->post('project_id');

            /**
             * Required Validation
             */
            if (empty($projectId)) {

                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Project ID is required.'
                    ]));
            }

            /**
             * Check Project Ownership
             */
            $project = $this->db
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->where('deleted', 0)
                ->get('tt_project_detail')
                ->row();

            if (!$project) {

                return $this->output
                    ->set_status_header(404)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Project not found.'
                    ]));
            }

            /**
             * Get Negotiation History
             */
            $history = $this->db
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->where('negotiation_type', 'client')
                ->order_by('id', 'DESC')
                ->get('tt_booking_negotiation_logs')
                ->result();

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Negotiation history fetched successfully.',
                    'data'    => $history
                ]));
        } catch (Exception $e) {

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            return $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }


    public function acceptClientNegotiation()
    {
        $this->output->set_content_type('application/json');

        try {

            /**
             * Authenticate Client
             */
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            /**
             * Form Data
             */
            $projectId = $this->input->post('project_id');

            /**
             * Required Validation
             */
            if (empty($projectId)) {

                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Project ID is required.'
                    ]));
            }

            /**
             * Get Project
             */
            $project = $this->db
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->where('deleted', 0)
                ->get('tt_project_detail')
                ->row();

            if (!$project) {

                return $this->output
                    ->set_status_header(404)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Project not found.'
                    ]));
            }

            /**
             * Check Admin Offer
             */
            if (
                $project->admin_client_final_amount === null ||
                $project->admin_client_final_amount === ''
            ) {

                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'No admin offer available to accept.'
                    ]));
            }

            /**
             * Check Already Finalized
             */
            if ((int) $project->client_negotiation_status === 3) {

                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'This offer has already been accepted.'
                    ]));
            }

            /**
             * Start Transaction
             */
            $this->db->trans_begin();

            /**
             * Update Negotiation Status
             */
            $this->db
                ->where('project_id', $projectId)
                ->where('client_id', $ac_id)
                ->update('tt_project_detail', [
                    'client_negotiation_status' => 3
                ]);

            /**
             * Insert Negotiation History
             */
            $this->db->insert('tt_booking_negotiation_logs', [
                'project_id'       => $projectId,
                'client_id'        => $project->client_id,
                'center_id'        => 0,
                'raised_by'        => 'client',
                'old_price'        => $project->admin_client_final_amount,
                'new_price'        => $project->admin_client_final_amount,
                'remark'           => 'Client accepted admin offer.',
                'status'           => 'Finalized',
                'negotiation_type' => 'client',
                'final_flag'       => 1,
                'created_by'       => $ac_id,
                'created_at'       => date('Y-m-d H:i:s')
            ]);

            /**
             * Transaction Check
             */
            if ($this->db->trans_status() === false) {

                $this->db->trans_rollback();

                return $this->output
                    ->set_status_header(500)
                    ->set_output(json_encode([
                        'status'  => false,
                        'message' => 'Unable to accept offer.'
                    ]));
            }

            /**
             * Commit Transaction
             */
            $this->db->trans_commit();

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Offer accepted successfully.'
                ]));
        } catch (Exception $e) {

            $this->db->trans_rollback();

            $code = ($e->getCode() >= 400 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            return $this->output
                ->set_status_header($code)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }
}
