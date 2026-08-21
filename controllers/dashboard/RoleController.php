<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RoleController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->load->model('Common_model');
        $this->load->database();
    }

    /* =======================================================
       ROLE LIST PAGE
    ======================================================= */
    public function index()
    {
        $this->check_permission('role_list');

        $data['page_title'] = 'Role List';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/role/index');
        $this->load->view('layouts/footer');
    }

    /* =======================================================
       DATATABLE AJAX
    ======================================================= */
    public function ajaxList()
    {
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'];

        $this->db->from('roles');

        if (!empty($search)) {
            $this->db->like('name', $search);
        }

        $recordsFiltered = $this->db->count_all_results('', false);

        $this->db->limit($length, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();

        $recordsTotal = $this->db->count_all('roles');

        $data = [];

        foreach ($query->result() as $row) {

            $statusBtn = ($row->status == 1)
                ? '<button class="btn btn-sm btn-success changeStatus"
                    data-id="'.$row->id.'" data-status="0">Active</button>'
                : '<button class="btn btn-sm btn-danger changeStatus"
                    data-id="'.$row->id.'" data-status="1">Inactive</button>';

            if (has_permission('role_edit')){
                $editBtn = '<a href="'.base_url('admin/role/edit/'.$row->id).'" 
                   class="btn btn-sm btn-primary">Edit</a>';
            }else{
               $editBtn = '--';
            }

            if (has_permission('role_delete')){
                $deleteBtn = '<button data-id="'.$row->id.'" 
                   class="btn btn-sm btn-danger deleteRole">Delete</button>';
            }else{
                $deleteBtn = '--';
            }

            $actionBtn = "$editBtn $deleteBtn";

            $data[] = [
                'role_name' => htmlspecialchars($row->name),
                'status'    => $statusBtn,
                'action'    => $actionBtn
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }

    /* =======================================================
       CREATE PAGE
    ======================================================= */
    public function create()
    {
        $this->check_permission('role_create');
        $data['page_title'] = 'Add Role';
        $data['permissions'] = $this->db->get('permissions')->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/role/create');
        $this->load->view('layouts/footer');
    }

    /* =======================================================
       STORE ROLE
    ======================================================= */
    public function store()
    {
        $name        = trim($this->input->post('name'));
        $permissions = $this->input->post('permissions');

        if (empty($name)) {
            $this->session->set_flashdata('error', 'Role name is required');
            redirect('admin/role/create');
        }

        $this->db->trans_start();

        $roleData = [
            'name'       => $name,
            'status'     => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('roles', $roleData);
        $role_id = $this->db->insert_id();

        if (!empty($permissions)) {
            foreach ($permissions as $permission_id) {
                $this->db->insert('role_permissions', [
                    'role_id'       => $role_id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Role Created Successfully');
        redirect('admin/roles');
    }

    /* =======================================================
       EDIT PAGE
    ======================================================= */
    public function edit($id)
    {
        $this->check_permission('role_edit');

        $data['page_title'] = 'Edit Role';
        $data['role'] = $this->db->get_where('roles', ['id' => $id])->row();

        $data['permissions'] = $this->db->get('permissions')->result();

        $role_permissions = $this->db
            ->select('permission_id')
            ->from('role_permissions')
            ->where('role_id', $id)
            ->get()
            ->result_array();

        $data['assigned_permissions'] = array_column($role_permissions, 'permission_id');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/role/edit',$data);
        $this->load->view('layouts/footer');
    }

    /* =======================================================
       UPDATE ROLE
    ======================================================= */
    public function update($id)
    {
        $name        = trim($this->input->post('name'));
        $permissions = $this->input->post('permissions');

        if (empty($name)) {
            $this->session->set_flashdata('error', 'Role name required');
            redirect('admin/role/edit/'.$id);
        }

        $this->db->trans_start();

        $this->db->update('roles', [
            'name'       => $name,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $id]);

        // Remove old permissions
        $this->db->delete('role_permissions', ['role_id' => $id]);

        // Insert new permissions
        if (!empty($permissions)) {
            foreach ($permissions as $permission_id) {
                $this->db->insert('role_permissions', [
                    'role_id'       => $id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Role Updated Successfully');
        redirect('admin/roles');
    }

    /* =======================================================
       DELETE ROLE
    ======================================================= */
    public function delete($id)
    {
        $this->check_permission('role_delete');
        $this->db->trans_start();

        $this->db->delete('role_permissions', ['role_id' => $id]);
        $this->db->delete('roles', ['id' => $id]);

        $this->db->trans_complete();

        echo json_encode(['status' => true]);
    }

    /* =======================================================
       CHANGE STATUS
    ======================================================= */
    public function changeStatus()
    {
        $Id     = (int) $this->input->post('Id');
        $status = $this->input->post('status');

        if (!$Id || !in_array($status, ['0','1'], true)) {
            echo json_encode(['status' => false, 'message' => 'Invalid request']);
            return;
        }

        $this->db->update('roles', ['status' => $status], ['id' => $Id]);

        echo json_encode([
            'status'  => true,
            'message' => $status == 1 ? 'Activated successfully' : 'Deactivated successfully'
        ]);
    }
}