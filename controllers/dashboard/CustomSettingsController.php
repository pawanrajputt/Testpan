<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomSettingsController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(['session']);
        $this->load->model('CustomSettings_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
        $this->load->model('CompanyLogos_model');

        // Auth Guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('custom_setting');
    }

    public function index()
    {
        if ($this->input->method() === 'post') {
            $this->_saveSettings();

            $this->session->set_flashdata(
                'success',
                'Settings updated successfully'
            );

            redirect(base_url('admin/custom-settings'));
        }

        $data['settings'] = $this->CustomSettings_model->get_all();

        $data['company_logos'] = $this->CompanyLogos_model->get_all();

        $data['page_title'] = 'Custom Settings';
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/custom_settings/index', $data);
        $this->load->view('layouts/footer');
    }

    /* ===============================
       PRIVATE SAVE HANDLER
    =============================== */
    private function _saveSettings()
    {
        $upload_path = FCPATH . 'uploads/settings/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        /* ---------- LOGOS ---------- */
        foreach (['header_logo', 'footer_logo'] as $logo) {

            if (!empty($_FILES[$logo]['name'])) {

                $config = [
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|webp',
                    'encrypt_name'  => true
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload($logo)) {
                    $file = $this->upload->data();
                    $this->CustomSettings_model->update_setting($logo, $file['file_name']);
                }
            }
        }

        /* ---------- TEXT SETTINGS ---------- */
        $fields = [
            'site_title',
            'site_description',
            'support_title',
            'support_description',
            'support_email',
            'support_phone'
        ];

        foreach ($fields as $field) {
            $this->CustomSettings_model->update_setting(
                $field,
                $this->input->post($field, true)
            );
        }
    }


    public function addCompanyLogo()
    {
        $company_name = trim($this->input->post('company_name', true));
        $sort_order   = (int) $this->input->post('sort_order');

        if (empty($company_name)) {
            $this->session->set_flashdata(
                'error',
                'Company name is required.'
            );

            redirect(base_url('admin/custom-settings'));
        }

        if (empty($_FILES['company_logo']['name'])) {
            $this->session->set_flashdata(
                'error',
                'Please select a company logo.'
            );

            redirect(base_url('admin/custom-settings'));
        }

        $upload_path = FCPATH . 'uploads/settings/company_logos/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => 2048
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('company_logo')) {

            $this->session->set_flashdata(
                'error',
                $this->upload->display_errors('', '')
            );

            redirect(base_url('admin/custom-settings'));
        }

        $file = $this->upload->data();

        $this->CompanyLogos_model->insert([
            'company_name' => $company_name,
            'logo'         => $file['file_name'],
            'sort_order'   => $sort_order,
            'status'       => 1,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata(
            'success',
            'Company logo added successfully.'
        );

        redirect(base_url('admin/custom-settings'));
    }


    public function deleteCompanyLogo($id)
    {
        $logo = $this->CompanyLogos_model->get_by_id($id);

        if (!$logo) {
            $this->session->set_flashdata(
                'error',
                'Company logo not found.'
            );

            redirect(base_url('admin/custom-settings'));
        }

        $file_path = FCPATH .
            'uploads/settings/company_logos/' .
            $logo['logo'];

        if (!empty($logo['logo']) && file_exists($file_path)) {
            unlink($file_path);
        }

        $this->CompanyLogos_model->delete($id);

        $this->session->set_flashdata(
            'success',
            'Company logo removed successfully.'
        );

        redirect(base_url('admin/custom-settings'));
    }
}
