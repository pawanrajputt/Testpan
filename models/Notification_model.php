<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    private $table = 'notifications';

    public function get_admin_notifications($limit = 20)
    {
        return $this->db
            ->where('type', 'admin')
            ->where('admin_is_remove', 0)
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    public function get_unread_count()
    {
        return $this->db
            ->where('type', 'admin')
            ->where('admin_is_read', 0)
            ->where('admin_is_remove', 0)
            ->count_all_results($this->table);
    }

    public function get_total_count()
    {
        return $this->db
            ->where('type', 'admin')
            ->where('admin_is_remove', 0)
            ->count_all_results($this->table);
    }

    public function mark_as_read($id)
    {
        return $this->db
            ->where('id', $id)
            ->where('type', 'admin')
            ->update($this->table, ['admin_is_read' => 1]);
    }

    public function mark_all_as_read()
    {
        return $this->db
            ->where('type', 'admin')
            ->update($this->table, ['admin_is_read' => 1]);
    }

    public function remove_notification($id)
    {
        return $this->db
            ->where('id', $id)
            ->where('type', 'admin')
            ->update($this->table, ['admin_is_remove' => 1]);
    }
}