<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomNewsController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(['session']);
        $this->load->helper(['url', 'news']);
        $this->load->model('CustomNews_model');

        // Auth Guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('custom_news');
    }

    /* ===============================
       PAGE LOAD
    =============================== */
    public function index()
    {
        $data['page_title'] = 'Custom News';
        $data['admin']      = $this->session->userdata('admin_user');

        // Custom News Statistics
        $data['total_news']   = $this->db->count_all('custom_news');

        $data['active_news']  = $this->db
            ->where('status', 1)
            ->count_all_results('custom_news');

        $data['inactive_news'] = $this->db
            ->where('status', 0)
            ->count_all_results('custom_news');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/custom_news/index', $data);
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
        $this->db->from('custom_news');

        // 🔍 Global search (ALL columns, DB-level)
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('news_link', $search);
            $this->db->group_end();
        }

        $recordsFiltered = $this->db->count_all_results('', false);

        // Pagination
        $this->db->limit($length, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();

        // Total records
        $recordsTotal = $this->db
            ->count_all_results('custom_news');

        $data = [];

        foreach ($query->result() as $row) {

            $preview = preview_media(
                $row->news_link,
                $row->media_type,
                $row->preview_image
            );
            $statusBtn = ($row->status == 1)
                ? '<button class="btn btn-sm btn-success changeStatus"
                    data-id="' . $row->id . '" data-status="0">Active</button>'
                : '<button class="btn btn-sm btn-danger changeStatus"
                    data-id="' . $row->id . '" data-status="1">Inactive</button>';

            $data[] = [
                'title'   => htmlspecialchars($row->title ?? ''),
                'link'    => '<a href="' . ($row->news_link ?? '#') . '" target="_blank">Open Link</a>',
                'type'    => ucfirst($row->media_type ?? ''),
                'preview' => $preview ? $preview : '--',
                'status'  => $statusBtn,
                'action'  => '
                    <button class="btn btn-sm btn-primary editBtn" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">Delete</button>
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

    /* ===============================
       STORE
    =============================== */
    public function store()
    {
        $link = trim($this->input->post('news_link'));
        $mediaType = detect_media_type($link);

        $data = [
            'title'      => $this->input->post('title'),
            'news_link'  => $link,
            'media_type' => $mediaType,
            'preview_title' => null,
            'preview_description' => null,
            'preview_image' => null,
            'embed_url' => null,
        ];

        if ($mediaType === 'youtube') {
            if (preg_match('/(youtu\.be\/|v=)([^&]+)/', $link, $m)) {
                $vid = $m[2];
                $data['embed_url'] = 'https://www.youtube.com/embed/' . $vid;
                $data['preview_image'] = 'https://img.youtube.com/vi/' . $vid . '/hqdefault.jpg';
                $data['preview_title'] = $data['title'];
            }
        } else {
            $preview = fetch_link_preview($link);
            if (!empty($preview)) {
                $data['preview_title'] = $preview['title'] ?? null;
                $data['preview_description'] = $preview['description'] ?? null;
                $data['preview_image'] = $preview['image'] ?? null;
            }
        }

        $newsId = $this->CustomNews_model->insert($data);

        if ($newsId) {

            $this->load->model('FirebaseNotification_model');
            $this->load->library('NotificationService');

            $tokens = $this->FirebaseNotification_model->getAllActiveTokens();

            $response = $this->notificationservice->sendByRecords(
                $tokens,
                'Breaking News',
                $data['title'],
                [
                    'type'    => 'news',
                    'news_id' => $newsId,
                    'screen'  => 'news_detail'
                ]
            );

            log_message('info', 'News Notification : ' . json_encode($response));
        }

        echo json_encode(['status' => true]);
    }

    public function edit($id)
    {
        echo json_encode($this->CustomNews_model->getById($id));
    }

    public function update($id)
    {
        $link = trim($this->input->post('news_link'));
        $mediaType = detect_media_type($link);

        $data = [
            'title'      => $this->input->post('title'),
            'news_link'  => $link,
            'media_type' => $mediaType,
            'preview_title' => null,
            'preview_description' => null,
            'preview_image' => null,
            'embed_url' => null,
        ];

        if ($mediaType === 'youtube') {
            if (preg_match('/(youtu\.be\/|v=)([^&]+)/', $link, $m)) {
                $vid = $m[2];
                $data['embed_url'] = 'https://www.youtube.com/embed/' . $vid;
                $data['preview_image'] = 'https://img.youtube.com/vi/' . $vid . '/hqdefault.jpg';
                $data['preview_title'] = $data['title'];
            }
        } else {
            $preview = fetch_link_preview($link);
            if (!empty($preview)) {
                $data['preview_title'] = $preview['title'] ?? null;
                $data['preview_description'] = $preview['description'] ?? null;
                $data['preview_image'] = $preview['image'] ?? null;
            }
        }

        $this->CustomNews_model->update($id, $data);

        echo json_encode(['status' => true]);
    }

    public function delete($id)
    {
        $this->CustomNews_model->delete($id);
        echo json_encode(['status' => true]);
    }

    public function linkPreview()
    {
        $url = $this->input->post('url');
        echo json_encode(fetch_link_preview($url));
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
            ->update('custom_news', [
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
