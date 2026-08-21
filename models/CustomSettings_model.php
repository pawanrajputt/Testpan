<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomSettings_model extends CI_Model
{
    protected $table = 'custom_settings';

    public function get_all()
    {
        $result = [];

        $query = $this->db->get($this->table);
        foreach ($query->result() as $row) {
            $result[$row->setting_key] = $row->setting_value;
        }

        return $result;
    }

    public function update_setting($key, $value)
    {
        return $this->db
            ->where('setting_key', $key)
            ->update($this->table, [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}