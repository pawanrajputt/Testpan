<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);

class SettingAPIController extends CI_Controller
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
     * GET /api/client/settings
     * Returns client settings in JSON
     */
    public function mySettings()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get client data
            $result = $this->Common_model->getSignleClientData($ac_id);

            if (!$result) {
                throw new Exception('Client data not found.', 404);
            }

            // 3. Get cities
            $city = $this->Common_model->getdata_array(
                'tt_city_master',
                []
            );

            // 4. Get states
            $state = $this->Common_model->getdata_array(
                'tt_states',
                []
            );

            // 5. Get custom settings
            $settigData = $this->Common_model->getdata_array(
                'custom_settings',
                ''
            );

            // 6. Build response
            $responseData = [
                'result'     => $result,
                'city'       => $city,
                'state'      => $state,
                'settigData' => $settigData
            ];

            // 7. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Settings fetched successfully.',
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


    public function updateProfilePicture()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Check file
            if (empty($_FILES['logo']['name'])) {
                throw new Exception('Profile picture is required.', 400);
            }

            // 3. Upload configuration
            $config['upload_path']   = './uploads/client_logo/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = time() . '_' . $_FILES['logo']['name'];

            $this->load->library('upload', $config);

            // 4. Upload file
            if (!$this->upload->do_upload('logo')) {
                throw new Exception(
                    strip_tags($this->upload->display_errors()),
                    400
                );
            }

            $uploadData = $this->upload->data();
            $logo = $uploadData['file_name'];

            // 5. Update DB
            $this->db->where('ac_id', $ac_id)
                ->update('tt_client', ['logo' => $logo]);

            // 6. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Profile picture updated successfully.',
                    'data'    => [
                        'logo' => $logo
                    ]
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


    public function updateCompanyInformation()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get input from Form Data
            $company_name = $this->input->post('company_name');

            if (empty($company_name)) {
                throw new Exception('Company name is required.', 400);
            }

            // 3. Prepare update data
            $data = [
                'company_name' => $company_name,
                'company_type' => $this->input->post('company_type'),
                'address'      => $this->input->post('address'),
                'state'        => $this->input->post('state'),
                'city'         => $this->input->post('city'),
                'pincode'      => $this->input->post('pincode'),
                'update_on'    => date('Y-m-d H:i:s'),
            ];

            // 4. Update client information
            $result = $this->Common_model->UpdateRecord(
                'tt_client',
                $data,
                ['ac_id' => $ac_id]
            );

            if (!$result) {
                throw new Exception('Failed to update company information.', 500);
            }

            // 5. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Company information updated successfully.'
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


    public function updatePersonalInformation()
    {
        $this->output->set_content_type('application/json');

        try {

            // 1. Authenticate client
            $client = $this->authenticateClient();
            $ac_id = $client->id;

            // 2. Get input from Form Data
            $data = [
                'co_ordinator_name'               => $this->input->post('full_name'),
                'coordinator_mobile_number'       => $this->input->post('mobile'),
                'landline_number'                 => $this->input->post('landline'),
                'coordinator_email'               => $this->input->post('email'),
                'coordinator_alternative_number'  => $this->input->post('alt_mobile')
            ];

            // 3. Update personal information
            $result = $this->db
                ->where('ac_id', $ac_id)
                ->update('tt_client', $data);

            if (!$result) {
                throw new Exception(
                    'Failed to update personal information.',
                    500
                );
            }

            // 4. Success response
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Personal information updated successfully.'
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
