<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubscriptionPackage extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Auth Guard (industry standard)
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->load->model('Common_model');
    }

    /* =================================
       LISTING
    ================================= */

    public function index()
    {
        $data['page_title'] = 'Subscription Packages';
        $data['admin']      = $this->session->userdata('admin_user');

        // Subscription Package Statistics
        $data['total_packages'] = $this->db
            ->count_all('subscription_packages');

        $data['active_packages'] = $this->db
            ->where('status', 1)
            ->count_all_results('subscription_packages');

        $data['inactive_packages'] = $this->db
            ->where('status', 0)
            ->count_all_results('subscription_packages');

        $data['packages'] = $this->db
            ->order_by('id', 'DESC')
            ->get('subscription_packages')
            ->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/subscription_packages/index', $data);
        $this->load->view('layouts/footer');
    }

    /* =================================
       CREATE PAGE
    ================================= */

    public function create()
    {
        $data['page_title'] = 'Create Subscription Package';
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/subscription_packages/create');
        $this->load->view('layouts/footer');
    }

    /* =================================
       STORE
    ================================= */

    public function store()
    {
        $name             = trim($this->input->post('name'));
        $duration         = $this->input->post('duration');
        $duration_type    = $this->input->post('duration_type');
        $price            = $this->input->post('price');
        $gst_percent      = $this->input->post('gst_percent');
        $package_color    = $this->input->post('package_color');
        $tag_line         = $this->input->post('tag_line');
        $free_user_limit  = $this->input->post('free_user_limit');
        $is_recommended   = $this->input->post('is_recommended');
        $key_points       = $this->input->post('key_points');
        $max_centers      = $this->input->post('max_centers');
        $max_bookings     = $this->input->post('max_bookings');
        $support_type     = $this->input->post('support_type');
        $verified_badge   = $this->input->post('verified_badge');

        $slug = $this->generateSlug($name);

        $data = [
            'name'              => $name,
            'slug'              => $slug,
            'duration'          => $duration,
            'duration_type'     => $duration_type,
            'price'             => $price,
            'gst_percent'       => $gst_percent,
            'package_color'     => $package_color,
            'tag_line'          => $tag_line,
            'key_points'        => $key_points,
            'free_user_limit'   => $free_user_limit,
            'is_recommended'    => $is_recommended ? 1 : 0,
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'max_centers'      => $max_centers,
            'max_bookings'     => $max_bookings,
            'support_type'     => $support_type,
            'verified_badge'   => $verified_badge ? 1 : 0,
        ];

        $this->Common_model->insertData('subscription_packages', $data);

        $this->session->set_flashdata('success', 'Package Created Successfully');

        redirect(base_url('admin/subscription-packages'));
    }

    /* =================================
       EDIT PAGE
    ================================= */

    public function edit($id)
    {
        $data['page_title'] = 'Edit Subscription Package';
        $data['admin']      = $this->session->userdata('admin_user');

        $data['result'] = $this->Common_model
            ->getdata('subscription_packages', ['id' => $id]);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/subscription_packages/edit');
        $this->load->view('layouts/footer');
    }

    /* =================================
       UPDATE
    ================================= */

    public function update()
    {
        $id = $this->input->post('id');

        $name             = trim($this->input->post('name'));
        $duration         = $this->input->post('duration');
        $duration_type    = $this->input->post('duration_type');
        $price            = $this->input->post('price');
        $gst_percent      = $this->input->post('gst_percent');
        $package_color    = $this->input->post('package_color');
        $tag_line         = $this->input->post('tag_line');
        $free_user_limit  = $this->input->post('free_user_limit');
        $is_recommended   = $this->input->post('status');
        $status           = $this->input->post('status');
        $key_points       = $this->input->post('key_points');
        $max_centers      = $this->input->post('max_centers');
        $max_bookings     = $this->input->post('max_bookings');
        $support_type     = $this->input->post('support_type');
        $verified_badge   = $this->input->post('verified_badge');

        $slug = $this->generateSlug($name);

        $data = [
            'name'              => $name,
            'slug'              => $slug,
            'duration'          => $duration,
            'duration_type'     => $duration_type,
            'price'             => $price,
            'gst_percent'       => $gst_percent,
            'package_color'     => $package_color,
            'tag_line'          => $tag_line,
            'key_points'        => $key_points,
            'free_user_limit'   => $free_user_limit,
            'is_recommended'    => $is_recommended ? 1 : 0,
            'status'            => $status,
            'updated_at'        => date('Y-m-d H:i:s'),
            'max_centers'      => $max_centers,
            'max_bookings'     => $max_bookings,
            'support_type'     => $support_type,
            'verified_badge'   => $verified_badge ? 1 : 0,
        ];

        $this->Common_model
            ->UpdateRecord('subscription_packages', $data, ['id' => $id]);

        $this->session->set_flashdata('success', 'Package Updated Successfully');

        redirect(base_url('admin/subscription-packages'));
    }

    /* =================================
       DELETE
    ================================= */

    public function delete($id)
    {
        $this->Common_model
            ->Deletedata('subscription_packages', ['id' => $id]);

        $this->session->set_flashdata('success', 'Package Deleted Successfully');

        redirect(base_url('admin/subscription-packages'));
    }

    /* =================================
       GENERATE SLUG
    ================================= */

    private function generateSlug($string)
    {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);

        return $slug . '-' . time();
    }
}
