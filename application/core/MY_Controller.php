<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $owner_id = $this->session->userdata('owner_id');
        $center_id = $this->session->userdata('exam_center_id');

        if($owner_id){

            $this->db->limit(20);
            $this->db->order_by('created_at','DESC');

            $this->db->select('notifications.*, centers.center_name');
            $this->db->from('notifications');
            $this->db->join('tt_center as centers', 'centers.id = notifications.center_id', 'left');

            $this->db->where([
                'notifications.admin_user_id' => $owner_id,
                'notifications.type'          => 'center',
                'notifications.is_remove'     => 0
            ]);

            if(!empty($center_id)){
                $this->db->where('notifications.center_id', $center_id);
            }

            $this->db->order_by('notifications.created_at','DESC');
            $this->db->limit(20);

            $notifications = $this->db->get()->result();


            /* -------------------------
               Unread Count
            --------------------------*/

            $this->db->from('notifications');
            $this->db->where([
                'admin_user_id' => $owner_id,
                'type'          => 'center',
                'is_read'       => 0,
                'is_remove'     => 0
            ]);

            if(!empty($center_id)){
                $this->db->where('center_id', $center_id);
            }

            $unread_count = $this->db->count_all_results();

            /* -------------------------
               Total Count
            --------------------------*/

            $this->db->from('notifications');
            $this->db->where([
                'admin_user_id' => $owner_id,
                'type'          => 'center',
                'is_remove'     => 0
            ]);

            if(!empty($center_id)){
                $this->db->where('center_id', $center_id);
            }

            $total_notifications = $this->db->count_all_results();

            $this->load->vars([
                'notifications'       => $notifications,
                'unread_count'        => $unread_count,
                'total_notifications' => $total_notifications
            ]);
        }
    }
}