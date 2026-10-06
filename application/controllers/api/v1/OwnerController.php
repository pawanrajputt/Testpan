<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OwnerController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->model('FirebaseNotification_model');
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

    /* =======================================================
     DASHBOARD
    ======================================================= */
    public function dashboard()
    {
        $owner = $this->authenticateOwner();

        // Total centers
        $total = $this->db
            ->where('owner_user_id', $owner->id)
            ->where('deleted', 0)
            ->count_all_results('tt_center');

        // Approved centers
        $approved = $this->db
            ->where('owner_user_id', $owner->id)
            ->where('deleted', 0)
            ->where('approved', 1)
            ->count_all_results('tt_center');

        // Pending centers
        $pending = $this->db
            ->where('owner_user_id', $owner->id)
            ->where('deleted', 0)
            ->where('approved', 0)
            ->count_all_results('tt_center');

        echo json_encode([
            'status' => 'success',
            'owner' => [
                'id' => (int)$owner->id,
                'name' => $owner->username,
                'mobile' => $owner->mobile_phone
            ],
            'stats' => [
                'total_centers' => (int)$total,
                'approved' => (int)$approved,
                'pending' => (int)$pending
            ]
        ]);
    }


    /* =======================================================
     ALL CENTERS BY OWNER
    ======================================================= */
    public function allCenterListing()
    {
        $owner = $this->authenticateOwner();

        $centers = $this->Common_model->getdata_array(
            'tt_center',
            ['owner_user_id' => $owner->id, 'deleted' => 0]
        );

        foreach ($centers as $key => $center) {

            // If api_token is empty → generate and update
            if (empty($center['api_token'])) {

                $token = bin2hex(random_bytes(32));

                $this->db->where('id', $center['id']);
                $this->db->update('tt_center', [
                    'api_token' => $token
                ]);

                // assign new token
                $centers[$key]['api_token'] = $token;
            }

            // ALWAYS send as center_api_token
            $centers[$key]['center_api_token'] = $centers[$key]['api_token'];

            // OPTIONAL: remove original api_token if you don't want to expose it
            unset($centers[$key]['api_token']);
        }

        // Fetch related data
        $countries = $this->Common_model->getdata_array('tt_countries', '');
        $states = $this->Common_model->getdata_array('tt_states', '');
        $cities = $this->Common_model->getdata_array('tt_city_master', '');

        echo json_encode([
            'status' => 'success',
            'centers' => $centers,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ]);
    }

    /* =======================================================
     OWNER PROFILE
    ======================================================= */
    public function profile()
    {
        $owner = $this->authenticateOwner();

        $profile_pic = '';
        $pan_card = '';
        $aadhaar_card = '';

        if (!empty($owner->profile_pic)) {
            $profile_pic = base_url(
                'uploads/owner_profile/' . $owner->profile_pic
            );
        }

        if (!empty($owner->owner_pan_card)) {
            $pan_card = base_url(
                'uploads/temp_owner_documents/' . $owner->owner_pan_card
            );
        }

        if (!empty($owner->owner_aadhaar_card)) {
            $aadhaar_card = base_url(
                'uploads/temp_owner_documents/' . $owner->owner_aadhaar_card
            );
        }

        echo json_encode([
            'status' => 'success',
            'data' => [
                'name'         => $owner->username,
                'email'        => $owner->email,
                'mobile_phone' => $owner->mobile_phone,
                'profile_pic'  => $profile_pic,
                'pan_card'     => $pan_card,
                'aadhaar_card' => $aadhaar_card
            ]
        ]);
    }

    /* =======================================================
     UPDATE PROFILE
    ======================================================= */
    public function updateProfile()
    {
        $owner = $this->authenticateOwner();

        $name  = trim($this->input->post('name'));
        $email = trim($this->input->post('email'));

        if (!$name) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Name field is required'
            ]);
            return;
        }

        if (!$email) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email field is required'
            ]);
            return;
        }

        $name_parts = preg_split('/\s+/', $name);

        $updateData = [
            'username'   => $name,
            'first_name' => $name_parts[0] ?? '',
            'last_name'  => $name_parts[1] ?? '',
            'email'      => $email,
            'updated'    => date('Y-m-d H:i:s')
        ];


        /* --------------------------------
       Profile Pic Upload
    -------------------------------- */

        if (!empty($_FILES['profile_pic']['name'])) {

            $uploadDir = FCPATH . 'uploads/owner_profile/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $config['upload_path']   = $uploadDir;
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name']  = true;
            $config['max_size']      = 2048;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_pic')) {

                $uploadData = $this->upload->data();

                $updateData['profile_pic'] = $uploadData['file_name'];

                // Delete old image
                if (!empty($owner->profile_pic)) {

                    $oldFile = FCPATH .
                        'uploads/owner_profile/' .
                        $owner->profile_pic;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => strip_tags(
                        $this->upload->display_errors()
                    )
                ]);
                return;
            }
        }


        /* --------------------------------
       Owner Documents Upload
    -------------------------------- */

        $documentDir = FCPATH . 'uploads/temp_owner_documents/';

        if (!is_dir($documentDir)) {
            mkdir($documentDir, 0755, true);
        }

        $this->load->library('upload');


        /* ---------- PAN CARD ---------- */

        if (!empty($_FILES['owner_pan_card']['name'])) {

            $config = [];

            $config['upload_path']   = $documentDir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['encrypt_name']  = true;
            $config['max_size']      = 5120;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('owner_pan_card')) {

                $uploadData = $this->upload->data();

                $updateData['owner_pan_card'] =
                    $uploadData['file_name'];

                // Delete old PAN card
                if (!empty($owner->owner_pan_card)) {

                    $oldFile = $documentDir .
                        $owner->owner_pan_card;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'PAN Card: ' .
                        strip_tags(
                            $this->upload->display_errors()
                        )
                ]);
                return;
            }
        }


        /* ---------- AADHAAR CARD ---------- */

        if (!empty($_FILES['owner_aadhaar_card']['name'])) {

            $config = [];

            $config['upload_path']   = $documentDir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['encrypt_name']  = true;
            $config['max_size']      = 5120;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('owner_aadhaar_card')) {

                $uploadData = $this->upload->data();

                $updateData['owner_aadhaar_card'] =
                    $uploadData['file_name'];

                // Delete old Aadhaar card
                if (!empty($owner->owner_aadhaar_card)) {

                    $oldFile = $documentDir .
                        $owner->owner_aadhaar_card;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Aadhaar Card: ' .
                        strip_tags(
                            $this->upload->display_errors()
                        )
                ]);
                return;
            }
        }


        /* --------------------------------
       Update Database
       -------------------------------- */

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            $updateData,
            ['id' => $owner->id]
        );


        /* --------------------------------
       Response URLs
       -------------------------------- */

        $profile_pic_url = '';
        $pan_card_url = '';
        $aadhaar_card_url = '';


        if (!empty($updateData['profile_pic'])) {

            $profile_pic_url = base_url(
                'uploads/owner_profile/' .
                    $updateData['profile_pic']
            );
        } elseif (!empty($owner->profile_pic)) {

            $profile_pic_url = base_url(
                'uploads/owner_profile/' .
                    $owner->profile_pic
            );
        }


        if (!empty($updateData['owner_pan_card'])) {

            $pan_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $updateData['owner_pan_card']
            );
        } elseif (!empty($owner->owner_pan_card)) {

            $pan_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $owner->owner_pan_card
            );
        }


        if (!empty($updateData['owner_aadhaar_card'])) {

            $aadhaar_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $updateData['owner_aadhaar_card']
            );
        } elseif (!empty($owner->owner_aadhaar_card)) {

            $aadhaar_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $owner->owner_aadhaar_card
            );
        }


        echo json_encode([
            'status' => 'success',
            'message' => 'Profile updated',
            'data' => [
                'name'         => $updateData['username'],
                'email'        => $updateData['email'],
                'profile_pic'  => $profile_pic_url,
                'pan_card'     => $pan_card_url,
                'aadhaar_card' => $aadhaar_card_url
            ]
        ]);
    }


    /* =======================================================
     OWNER MPIN RESET VIA PROFILE
    ======================================================= */
    public function resetMpin()
    {
        $owner = $this->authenticateOwner();

        $current = trim($this->input->post('current_mpin'));
        $new     = trim($this->input->post('new_mpin'));
        $confirm = trim($this->input->post('confirm_mpin'));

        if (!$current || !$new || !$confirm) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'All MPIN fields are required'
            ]);
            return;
        }

        if ($current !== $owner->mpin) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Current MPIN is incorrect'
            ]);
            return;
        }

        if ($new !== $confirm) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'New MPIN and Confirm MPIN do not match'
            ]);
            return;
        }

        if (!ctype_digit($new) || strlen($new) !== 4) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'MPIN must be exactly 4 digits'
            ]);
            return;
        }

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            [
                'mpin'    => $new,
                'updated' => date('Y-m-d H:i:s')
            ],
            ['id' => $owner->id]
        );

        echo json_encode([
            'status'  => 'success',
            'message' => 'MPIN reset successfully'
        ]);
    }


    public function viewCenterDetail($center_id)
    {
        header("Content-Type: application/json");

        // Authenticate owner via token
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        // Fetch center
        $center = $this->Common_model->getdata('tt_center', [
            'id' => $center_id,
            'owner_user_id' => $owner_id,
            'deleted' => 0
        ]);

        if (!$center) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Center not found or access denied'
            ]);
            return;
        }

        $baseUrl = base_url();

        // Documents
        $documents = $this->db
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_center_document')
            ->result();

        foreach ($documents as &$doc) {
            $doc->url = $baseUrl . $doc->url;
        }

        // Images
        $images = $this->db
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_center_images')
            ->result();

        foreach ($images as &$img) {
            $img->center_image = $baseUrl . $img->center_image;
        }

        // Videos
        $videos = $this->db
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_center_video')
            ->result();

        foreach ($videos as &$video) {
            $video->center_video = $baseUrl . $video->center_video;
        }

        // Labs
        $labs = $this->db
            ->where('center_id', $center_id)
            ->get('tt_lab')
            ->result();

        // GST file & Logo
        if (!empty($center->gst_file)) {
            $center->gst_file = $baseUrl . $center->gst_file;
        }

        if (!empty($center->logo)) {
            $center->logo = $baseUrl . $center->logo;
        }

        // Fetch related data
        $where = '';
        $countries = $this->Common_model->getdata_array('tt_countries', $where);
        $states = $this->Common_model->getdata_array('tt_states', $where);
        $cities = $this->Common_model->getdata_array('tt_city_master', $where);

        // Final Response
        echo json_encode([
            'status' => 'success',
            'data' => [
                'center'     => $center,
                'documents'  => $documents,
                'images'     => $images,
                'videos'     => $videos,
                'labs'       => $labs,
                'countries'   => $countries,
                'states'   => $states,
                'cities'   => $cities,
            ]
        ]);
    }


    /* =======================================================
     OWNER ACCOUNT DELETE
    ======================================================= */
    public function deleteOwnerAccountApi()
    {
        $owner = $this->authenticateOwner();

        $owner_user_id = $owner->id;

        $centerExists = $this->db
            ->where('owner_user_id', $owner_user_id)
            ->where('deleted', 0)
            ->limit(1)
            ->count_all_results('tt_center') > 0;

        if ($centerExists) {
            echo json_encode([
                'status'  => false,
                'message' => 'Account cannot be deleted because center exist.'
            ]);
            return;
        }

        $data = ['deleted' => 1];

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            $data,
            ['id' => $owner_user_id]
        );

        echo json_encode([
            'status'    => true,
            'message'   => 'Account deleted successfully!',
            'id'        => $owner_user_id
        ]);
    }
}
