<?php 

if (!function_exists('has_permission')) {

    function has_permission($permission_slug)
    {
        $CI =& get_instance();

        $admin = $CI->session->userdata('admin_user');

        if (!$admin || !isset($admin['role_id'])) {
            return false;
        }

        $role_id = $admin['role_id'];

        // Super Admin bypass (recommended)
        if ($role_id == 1) {
            return true;
        }

        $CI->db->select('p.slug');
        $CI->db->from('role_permissions rp');
        $CI->db->join('permissions p', 'p.id = rp.permission_id');
        $CI->db->where('rp.role_id', $role_id);
        $CI->db->where('p.slug', $permission_slug);

        return $CI->db->get()->num_rows() > 0;
    }
}