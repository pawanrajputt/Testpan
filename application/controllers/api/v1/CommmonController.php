<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CommmonController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Common_model');
        $this->load->model('CompanyLogos_model');

        // Set JSON header
        header("Content-Type: application/json");
    }

    // ====================================================
    // GET COUNTRY LIST  (API: /api/v1/get-country-list)
    // ====================================================
    public function getCountryList()
    {
        // Fetch active countries
        $where = array('is_active' => 1);
        $countries = $this->Common_model->getdata_array('tt_countries', $where);

        if (!empty($countries)) {

            // Format response array
            $result = array();
            foreach ($countries as $row) {
                $result[] = array(
                    'country_id'     => $row['id'],
                    'countrye_name'  => $row['name']
                );
            }

            $response = array(
                'success'      => 1,
                'message'      => 'Country info found !!',
                'app_message'  => 'Country info found !!',
                'state_detail' => $result
            );
        } else {

            $response = array(
                'success'      => 0,
                'message'      => 'Country info not found',
                'app_message'  => 'Country info not found'
            );
        }

        echo json_encode($response);
    }

    // ====================================================
    // GET STATE LIST BY COUNTRY ID (API: /api/v1/get-state-list)
    // ====================================================
    public function getStateList()
    {
        // Read country_id from POST or GET
        $country_id = $this->input->post('country_id');
        if (empty($country_id)) {
            $country_id = $this->input->get('country_id');
        }

        // Check required field
        if (empty($country_id)) {
            echo json_encode([
                'success'     => 0,
                'message'     => 'Country Id is required',
                'app_message' => 'Country Id is required'
            ]);
            return;
        }

        // Fetch states
        $where = array('country_id' => $country_id);
        $states = $this->Common_model->getdata_array('tt_states', $where);

        if (!empty($states)) {

            $result = [];
            foreach ($states as $row) {
                $result[] = [
                    'state_id'   => $row['id'],
                    'state_name' => $row['title']
                ];
            }

            $response = [
                'success'      => 1,
                'message'      => 'State info found !!',
                'app_message'  => 'State info found !!',
                'state_detail' => $result
            ];
        } else {

            $response = [
                'success'     => 0,
                'message'     => 'State info not found',
                'app_message' => 'State info not found'
            ];
        }

        echo json_encode($response);
    }


    // ====================================================
    // GET CITY LIST BY STATE ID (API: /api/v1/get-city-list)
    // ====================================================
    public function getCityList()
    {
        // Get state_id from POST or GET
        $state_id = $this->input->post('state_id');
        if (empty($state_id)) {
            $state_id = $this->input->get('state_id');
        }

        // Validate
        if (empty($state_id)) {
            echo json_encode([
                'success'     => 0,
                'message'     => 'State Id is required',
                'app_message' => 'State Id is required'
            ]);
            return;
        }

        // Fetch cities
        $where = array('state_id' => $state_id);
        $cities = $this->Common_model->getdata_array('tt_city_master', $where);

        if (!empty($cities)) {

            $result = [];
            foreach ($cities as $row) {
                $result[] = [
                    'city_id'   => $row['city_id'],
                    'city_name' => $row['city_name']
                ];
            }

            $response = [
                'success'     => 1,
                'message'     => 'City info found !!!',
                'app_message' => 'City info found !!!',
                'city_detail' => $result
            ];
        } else {
            $response = [
                'success'     => 0,
                'message'     => 'City info not found',
                'app_message' => 'City info not found'
            ];
        }

        echo json_encode($response);
    }


    // ====================================================
    // GET CENTER TYPE LIST (API: /api/v1/get-center-type)
    // ====================================================
    public function getCenterType()
    {
        // Fetch center types (no filters)
        $centerTypes = $this->Common_model->getdata_array('tt_center_type', []);

        if (!empty($centerTypes)) {

            $result = [];
            foreach ($centerTypes as $row) {
                $result[] = [
                    'id'           => $row['id'],
                    'center_type'  => $row['center_type']
                ];
            }

            $response = [
                'success'     => 1,
                'message'     => 'Center Type info found !!',
                'app_message' => 'Center Type info found !!',
                'data'        => $result
            ];
        } else {

            $response = [
                'success'     => 0,
                'message'     => 'Center Type info not found',
                'app_message' => 'Center Type info not found'
            ];
        }

        echo json_encode($response);
    }

    // ====================================================
    // GET BANK NAME LIST
    // ====================================================
    public function getBankName()
    {
        // Fetch center types (no filters)
        $bankNames = $this->Common_model->getdata_array('tt_bank_name', ['deleted' => 0]);

        if (!empty($bankNames)) {

            $result = [];
            foreach ($bankNames as $row) {
                $result[] = [
                    'id'           => $row['id'],
                    'bank_name'    => $row['bank_name']
                ];
            }

            $response = [
                'success'     => 1,
                'message'     => 'Bank name info found !!',
                'app_message' => 'Bank name info found !!',
                'data'        => $result
            ];
        } else {

            $response = [
                'success'     => 0,
                'message'     => 'Bank name info not found',
                'app_message' => 'Bank name info not found'
            ];
        }

        echo json_encode($response);
    }


    /**
     * GET list
     */
    public function getNewsList()
    {
        $news = $this->Common_model->getActiveNews();

        $response = [];

        foreach ($news as $row) {

            $item = [
                'id'         => (int) $row->id,
                'title'      => $row->title,
                'link'       => $row->news_link,
                'media_type' => $row->media_type,
                'preview'    => null
            ];

            // YouTube
            if ($row->media_type === 'youtube') {
                $item['preview'] = [
                    'type'      => 'video',
                    'embed_url' => $row->embed_url,
                    'thumbnail' => $row->preview_image
                ];
            }
            // Website / News
            else {
                $item['preview'] = [
                    'type'        => 'link',
                    'title'       => $row->preview_title,
                    'description' => $row->preview_description,
                    'image'       => $row->preview_image
                ];
            }

            $response[] = $item;
        }

        echo json_encode([
            'status' => true,
            'count'  => count($response),
            'data'   => $response
        ], JSON_UNESCAPED_SLASHES);
    }


    public function getSettingList()
    {
        // array of arrays
        $result = $this->Common_model->getdata_array('custom_settings', []);

        // admin_url row (object)
        $admin = $this->Common_model->getdata(
            'custom_settings',
            ['setting_key' => 'admin_url']
        );

        $admin_url = rtrim($admin->setting_value ?? '', '/') . '/';

        foreach ($result as $key => $each) {

            if (
                ($each['setting_key'] === 'header_logo' ||
                    $each['setting_key'] === 'footer_logo')
                && !empty($each['setting_value'])
            ) {
                $result[$key]['setting_value'] =
                    $admin_url . 'uploads/settings/' . $each['setting_value'];
            }
        }

        $company_logos = $this->CompanyLogos_model->get_active();

        foreach ($company_logos as $key => $logo) {

            $company_logos[$key]['logo'] =
                $admin_url . 'uploads/settings/company_logos/' . $logo['logo'];
        }

        echo json_encode([
            'status' => true,
            'data'   => $result,
            'company_logos' => $company_logos
        ], JSON_UNESCAPED_SLASHES);
    }
}
