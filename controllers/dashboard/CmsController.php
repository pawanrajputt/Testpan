<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CmsController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(['session']);
        $this->load->helper(['url']);
        $this->load->model('Common_model');

        // Auth Guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('cms_management');
    }

    /* ===============================
       PAGE LOAD
    =============================== */
    public function index()
    {
        $data['page_title'] = 'CMS List';
        $data['admin']      = $this->session->userdata('admin_user');

        // CMS Statistics
        $data['total_cms'] = $this->db
            ->count_all('cms');

        $data['active_cms'] = $this->db
            ->where('status', 1)
            ->count_all_results('cms');

        $data['inactive_cms'] = $this->db
            ->where('status', 0)
            ->count_all_results('cms');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/cms/index', $data);
        $this->load->view('layouts/footer');
    }

    /* ===============================
       DATATABLE AJAX LIST
    =============================== */
    public function ajaxList()
    {
        $this->output->set_content_type('application/json');

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'];

        // Base query
        $this->db->from('cms');

        // 🔍 Global search (ALL columns, DB-level)
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->group_end();
        }

        $recordsFiltered = $this->db->count_all_results('', false);

        // Pagination
        $this->db->limit($length, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();

        // Total records
        $recordsTotal = $this->db
            ->count_all_results('cms');

        $data = [];

        foreach ($query->result() as $row) {

            $statusBtn = ($row->status == 1)
                ? '<button class="btn btn-sm btn-success changeStatus"
                    data-id="' . $row->id . '" data-status="0">Active</button>'
                : '<button class="btn btn-sm btn-danger changeStatus"
                    data-id="' . $row->id . '" data-status="1">Inactive</button>';

            $data[] = [
                'title'   => htmlspecialchars($row->title ?? ''),
                'description' => mb_strimwidth($row->description, 0, 500, "..."),
                'status'  => $statusBtn,
                'action'  => '<a href="' . base_url('admin/cms/edit/' . $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                '
            ];
        }

        echo json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
    }


    private function generateSlug($title, $id = null)
    {
        $slug = url_title($title, '-', true); // CI helper

        $this->db->where('slug', $slug);

        if ($id) {
            $this->db->where('id !=', $id);
        }

        $exists = $this->db->get('cms')->row();

        $counter = 1;
        $originalSlug = $slug;

        while ($exists) {
            $slug = $originalSlug . '-' . $counter;
            $this->db->where('slug', $slug);

            if ($id) {
                $this->db->where('id !=', $id);
            }

            $exists = $this->db->get('cms')->row();
            $counter++;
        }

        return $slug;
    }


    /* ===============================
       PAGE LOAD
    =============================== */
    public function create()
    {
        $data['page_title'] = 'Add CMS';
        $data['admin']      = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/cms/create');
        $this->load->view('layouts/footer');
    }

    /* ===============================
       STORE
    =============================== */
    public function store()
    {
        $title = $this->input->post('title');
        $description = $this->input->post('description');

        $slug = $this->generateSlug($title);

        $data = [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'status'      => 1,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->Common_model->insertData('cms', $data);

        $this->session->set_flashdata('success', 'CMS Created Successfully');
        redirect(base_url('admin/cms'));
    }

    /* ===============================
       PAGE LOAD
    =============================== */
    public function edit($id)
    {
        $data['page_title'] = 'Edit CMS';
        $data['admin']      = $this->session->userdata('admin_user');
        $data['result']     = $this->Common_model->getdata('cms', ['id' => $id]);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/cms/edit');
        $this->load->view('layouts/footer');
    }


    public function update($id)
    {
        $title = $this->input->post('title');
        $description = $this->input->post('description');

        $slug = $this->generateSlug($title, $id);

        $data = [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        $this->Common_model->UpdateRecord('cms', $data, ['id' => $id]);

        $this->session->set_flashdata('success', 'CMS Updated Successfully');
        redirect(base_url('admin/cms'));
    }

    public function delete($id)
    {
        $this->Common_model->Deletedata('cms', array('id' => $id));
        echo json_encode(['status' => true]);
    }


    public function changeStatus()
    {
        ini_set('display_errors', 0);
        error_reporting(0);

        $this->output->set_content_type('application/json');

        $Id = (int) $this->input->post('Id');
        $status  = $this->input->post('status');

        if (!$Id || !in_array($status, ['0', '1'], true)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request'
            ]);
            exit;
        }

        $this->db->where('id', $Id)
            ->update('cms', [
                'status' => $status
            ]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status'  => true,
                'message' => $status == 1 ? 'Active successfully' : 'Deactived successfully'
            ]);
        } else {
            echo json_encode([
                'status'  => false,
                'message' => 'No changes made'
            ]);
        }

        exit;
    }
}
