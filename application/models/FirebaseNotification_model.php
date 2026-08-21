<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FirebaseNotification_model extends CI_Model
{
    protected $table = 'tt_user_device_tokens';

    /**
     * Insert or Update Device Token
     */
    public function saveDeviceToken($data)
    {
        $this->db->where('device_token', $data['device_token']);
        $record = $this->db->get($this->table)->row();

        if ($record) {

            $update = [
                'user_id'       => $data['user_id'],
                'device_type'   => $data['device_type'],
                'app_version'   => isset($data['app_version']) ? $data['app_version'] : NULL,
                'is_active'     => 1,
                'last_login_at' => date('Y-m-d H:i:s'),
                'updated'       => date('Y-m-d H:i:s')
            ];

            $this->db->where('id', $record->id);
            return $this->db->update($this->table, $update);
        }

        $insert = [
            'user_id'       => $data['user_id'],
            'device_token'  => $data['device_token'],
            'device_type'   => $data['device_type'],
            'app_version'   => isset($data['app_version']) ? $data['app_version'] : NULL,
            'is_active'     => 1,
            'last_login_at' => date('Y-m-d H:i:s'),
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s')
        ];

        return $this->db->insert($this->table, $insert);
    }

    /**
     * Get Active Tokens By User
     */
    public function getUserTokens($userId)
    {
        return $this->db
            ->select('device_token')
            ->from($this->table)
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->get()
            ->result();
    }

    /**
     * Get All Active Tokens
     */
    public function getAllActiveTokens()
    {
        return $this->db
            ->select('device_token')
            ->from($this->table)
            ->where('is_active', 1)
            ->get()
            ->result();
    }

    /**
     * Deactivate Device Token
     */
    public function deactivateToken($deviceToken)
    {
        return $this->db
            ->where('device_token', $deviceToken)
            ->update($this->table, [
                'is_active' => 0,
                'updated'   => date('Y-m-d H:i:s')
            ]);
    }

    /**
     * Delete Invalid Token
     */
    public function deleteToken($deviceToken)
    {
        return $this->db
            ->where('device_token', $deviceToken)
            ->delete($this->table);
    }
}