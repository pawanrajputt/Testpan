<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubadminController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->load->database();
    }

    /* =======================================================
       LIST PAGE
    ======================================================= */
    public function index()
    {
        $this->check_permission('subadmin_list');
        $data['page_title'] = 'Subadmin List';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/subadmin/index');
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

        $this->db->select('u.id, u.username, u.email, u.approved, u.user_type, r.name as role_name');
        $this->db->from('tt_admin_users u');
        $this->db->join('roles r', 'r.id = u.role_id', 'left');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.username', $search);
            $this->db->or_like('u.email', $search);
            $this->db->or_like('r.name', $search);
            $this->db->group_end();
        }

        $recordsFiltered = $this->db->count_all_results('', false);
        $this->db->where('u.user_type IS NOT NULL');
        $this->db->limit($length, $start);
        $this->db->order_by('u.id', 'DESC');
        $query = $this->db->get();

        $recordsTotal = $this->db->count_all('tt_admin_users');

        $data = [];

        foreach ($query->result() as $row) {

            $statusBtn = ($row->approved == 1)
                ? '<button class="btn btn-sm btn-success changeStatus"
                    data-id="'.$row->id.'" data-status="0">Active</button>'
                : '<button class="btn btn-sm btn-danger changeStatus"
                    data-id="'.$row->id.'" data-status="1">Inactive</button>';

            
            if (has_permission('role_edit')){
                $editBtn = '<a href="'.base_url('admin/subadmin/edit/'.$row->id).'" 
                   class="btn btn-sm btn-primary">Edit</a>';
            }else{
               $editBtn = '--';
            }

            if (has_permission('role_delete')){
                $deleteBtn = '<button data-id="'.$row->id.'" 
                   class="btn btn-sm btn-danger deleteSubadmin">Delete</button>';
            }else{
                $deleteBtn = '--';
            }

            $actionBtn = "$editBtn $deleteBtn";

            $data[] = [
                'subadmin_name'  => htmlspecialchars($row->username),
                'subadmin_email' => htmlspecialchars($row->email),
                'role_name'      => htmlspecialchars($row->role_name),
                'status'         => $statusBtn,
                'action'         => $actionBtn
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
        $this->check_permission('subadmin_create');
        $data['page_title'] = 'Add Subadmin';
        $data['roles'] = $this->db->where('status',1)->get('roles')->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/subadmin/create',$data);
        $this->load->view('layouts/footer');
    }

    /* =======================================================
       STORE
    ======================================================= */
    public function store()
    {
        $username = trim($this->input->post('username'));
        $email    = strtolower(trim($this->input->post('email')));
        $mobile   = trim($this->input->post('mobile_phone'));
        $role_id  = $this->input->post('role_id');
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm_password');

        // Basic Required Validation
        if (empty($username) || empty($email) || empty($role_id) || empty($password)) {
            $this->session->set_flashdata('error','All required fields must be filled');
            redirect('admin/subadmin/create');
        }

        // Password Match Check
        if ($password !== $confirm) {
            $this->session->set_flashdata('error','Passwords do not match');
            redirect('admin/subadmin/create');
        }

        // Email Duplicate Check
        $emailExists = $this->db
            ->where('email', $email)
            ->where('user_type', 'subadmin')
            ->get('tt_admin_users')
            ->row();

        if ($emailExists) {
            $this->session->set_flashdata('error','Email already exists');
            redirect('admin/subadmin/create');
        }

        // Mobile Duplicate Check (only if provided)
        if (!empty($mobile)) {
            $mobileExists = $this->db
                ->where('mobile_phone', $mobile)
                ->where('user_type', 'subadmin')
                ->get('tt_admin_users')
                ->row();

            if ($mobileExists) {
                $this->session->set_flashdata('error','Mobile number already exists');
                redirect('admin/subadmin/create');
            }
        }

        // Insert
        $this->db->trans_start();

        $data = [
            'username'     => $username,
            'email'        => $email,
            'mobile_phone' => $mobile,
            'role_id'      => $role_id,
            'password'     => password_hash($password, PASSWORD_DEFAULT),
            'created_by'   => $this->session->userdata('admin_user')['id'],
            'approved'     => 1,
            'user_type'    => 'subadmin',
            'created'   => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tt_admin_users', $data);

        $this->db->trans_complete();

        $this->session->set_flashdata('success','Subadmin Created Successfully');
        redirect('admin/subadmins');
    }

    /* =======================================================
       EDIT PAGE
    ======================================================= */
    public function edit($id)
    {
        $this->check_permission('subadmin_edit');
        $data['page_title'] = 'Edit Subadmin';
        $data['subadmin'] = $this->db->get_where('tt_admin_users', ['id'=>$id])->row();
        $data['roles'] = $this->db->where('status',1)->get('roles')->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/subadmin/edit',$data);
        $this->load->view('layouts/footer');
    }

    /* =======================================================
       UPDATE
    ======================================================= */
    public function update($id)
    {
        $username = trim($this->input->post('username'));
        $email    = strtolower(trim($this->input->post('email')));
        $mobile   = trim($this->input->post('mobile_phone'));
        $role_id  = $this->input->post('role_id');
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm_password');

        // Duplicate Email Check
        $emailExists = $this->db
            ->where('email', $email)
            ->where('id !=', $id)
            ->get('tt_admin_users')
            ->row();

        if ($emailExists) {
            $this->session->set_flashdata('error','Email already exists');
            redirect('admin/subadmin/edit/'.$id);
        }

        // Duplicate Mobile Check
        if (!empty($mobile)) {
            $mobileExists = $this->db
                ->where('mobile_phone', $mobile)
                ->where('id !=', $id)
                ->get('tt_admin_users')
                ->row();

            if ($mobileExists) {
                $this->session->set_flashdata('error','Mobile already exists');
                redirect('admin/subadmin/edit/'.$id);
            }
        }

        $data = [
            'username'     => $username,
            'email'        => $email,
            'mobile_phone' => $mobile,
            'role_id'      => $role_id,
            'updated'   => date('Y-m-d H:i:s')
        ];

        // Update password only if entered
        if (!empty($password)) {
            if ($password !== $confirm) {
                $this->session->set_flashdata('error','Passwords do not match');
                redirect('admin/subadmin/edit/'.$id);
            }

            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->update('tt_admin_users', $data, ['id'=>$id , 'user_type' => 'subadmin']);

        $this->session->set_flashdata('success','Subadmin Updated Successfully');
        redirect('admin/subadmins');
    }

    /* =======================================================
       DELETE
    ======================================================= */
    public function delete($id)
    {
        $this->check_permission('subadmin_delete');
        $this->db->delete('tt_admin_users',['id'=>$id]);
        echo json_encode(['status'=>true]);
    }

    /* =======================================================
       CHANGE STATUS
    ======================================================= */
    public function changeStatus()
    {
        $Id     = (int)$this->input->post('Id');
        $status = $this->input->post('status');

        $this->db->update('tt_admin_users',
            ['approved'=>$status],
            ['id'=>$Id]
        );

        echo json_encode([
            'status'=>true,
            'message'=>$status==1 ? 'Activated' : 'Deactivated'
        ]);
    }
}