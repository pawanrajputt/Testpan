<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->library('session');
    }


    // Increase visitor count
    public function increaseCount()
    {
        $visitor_id = $this->input->post('visitor_id', true);

        if (empty($visitor_id)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Visitor ID required.'
            ]);
            return;
        }

        // Check whether this visitor has already been counted
        $exists = $this->db
            ->where('visitor_id', $visitor_id)
            ->get('visitor_logs')
            ->row();

        // Already counted
        if ($exists) {
            echo json_encode([
                'status'  => true,
                'counted' => false
            ]);
            return;
        }

        // Save unique visitor
        $this->db->insert('visitor_logs', [
            'visitor_id' => $visitor_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Increase total visitor count
        $this->db
            ->set('total_visitors', 'total_visitors + 1', false)
            ->set('updated_at', date('Y-m-d H:i:s'))
            ->where('id', 1)
            ->update('visitor_counter');

        echo json_encode([
            'status'  => true,
            'counted' => true
        ]);
    }


    // Get visitor count
    public function getCount()
    {
        $visitor = $this->db
            ->where('id', 1)
            ->get('visitor_counter')
            ->row();

        echo json_encode([
            'status' => true,
            'total_visitors' => $visitor->total_visitors ?? 0
        ]);
    }
}