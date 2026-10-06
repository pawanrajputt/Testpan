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
            'title'                => $this->input->post('title'),
            'news_link'            => $link,
            'media_type'           => $mediaType,
            'preview_title'        => null,
            'preview_description'  => null,
            'preview_image'        => null,
            'embed_url'            => null,
        ];


        /* ==========================================
       YOUTUBE
    ========================================== */

        if ($mediaType === 'youtube') {

            if (preg_match('/(youtu\.be\/|v=)([^&]+)/', $link, $m)) {

                $vid = $m[2];

                $data['embed_url'] =
                    'https://www.youtube.com/embed/' . $vid;

                $data['preview_image'] =
                    'https://img.youtube.com/vi/' . $vid . '/hqdefault.jpg';

                $data['preview_title'] =
                    $data['title'];
            }
        } else {

            /* ==========================================
           WEBSITE OG PREVIEW
        ========================================== */

            $preview = fetch_link_preview($link);

            if (!empty($preview)) {

                $data['preview_title'] =
                    $preview['title'] ?? null;

                $data['preview_description'] =
                    $preview['description'] ?? null;

                $data['preview_image'] =
                    $preview['image'] ?? null;
            }
        }


        /* ==========================================
       CUSTOM IMAGE UPLOAD
       Custom image gets highest priority
    ========================================== */

        if (
            !empty($_FILES['custom_image']['name']) &&
            $_FILES['custom_image']['error'] === UPLOAD_ERR_OK
        ) {

            $customImage = $this->upload_custom_news_image();

            if ($customImage) {

                $data['preview_image'] = $customImage;
            }
        }


        /* ==========================================
       INSERT
    ========================================== */

        $newsId = $this->CustomNews_model->insert($data);


        if ($newsId) {

            $this->load->library('NotificationService');

            $this->notificationservice->sendNotification(
                'Breaking News',
                $data['title'],
                $data['preview_image'],
                $newsId,
                'news',
                'news_detail'
            );

            echo json_encode([
                'status' => true
            ]);

            return;
        }


        echo json_encode([
            'status'  => false,
            'message' => 'Unable to save news.'
        ]);
    }


    private function upload_custom_news_image()
    {
        $uploadPath = FCPATH . 'uploads/custom_news/';


        /*
     * Create folder if not exists
     */
        if (!is_dir($uploadPath)) {

            mkdir($uploadPath, 0755, true);
        }


        /*
     * Upload configuration
     */
        $config['upload_path']   = $uploadPath;
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size']      = 5120; // 5 MB
        $config['encrypt_name']  = TRUE;


        $this->load->library('upload');

        $this->upload->initialize($config);


        if (!$this->upload->do_upload('custom_image')) {

            return null;
        }


        $uploadData = $this->upload->data();


        /*
     * Return URL which will be stored in DB
     */
        return base_url(
            'uploads/custom_news/' . $uploadData['file_name']
        );
    }

    public function edit($id)
    {
        echo json_encode($this->CustomNews_model->getById($id));
    }

    public function update($id)
    {
        $link = trim($this->input->post('news_link'));
        $mediaType = detect_media_type($link);

        // Get existing news record
        $existingNews = $this->CustomNews_model->getById($id);

        if (!$existingNews) {
            echo json_encode([
                'status'  => false,
                'message' => 'News not found.'
            ]);
            return;
        }

        /*
     * Check whether news link has changed
     */
        $linkChanged = ($existingNews->news_link !== $link);

        /*
     * Keep existing preview image by default
     */
        $data = [
            'title'               => $this->input->post('title'),
            'news_link'           => $link,
            'media_type'          => $mediaType,
            'preview_title'       => $existingNews->preview_title,
            'preview_description' => $existingNews->preview_description,
            'preview_image'       => $existingNews->preview_image,
            'embed_url'           => $existingNews->embed_url,
        ];


        /* ==========================================
       ONLY GENERATE NEW PREVIEW IF LINK CHANGED
    ========================================== */

        if ($linkChanged) {

            // Reset preview data for new link
            $data['preview_title'] = null;
            $data['preview_description'] = null;
            $data['preview_image'] = null;
            $data['embed_url'] = null;


            /* ==========================================
           YOUTUBE
        ========================================== */

            if ($mediaType === 'youtube') {

                if (preg_match('/(youtu\.be\/|v=)([^&]+)/', $link, $m)) {

                    $vid = $m[2];

                    $data['embed_url'] =
                        'https://www.youtube.com/embed/' . $vid;

                    $data['preview_image'] =
                        'https://img.youtube.com/vi/' . $vid . '/hqdefault.jpg';

                    $data['preview_title'] =
                        $data['title'];
                }
            } else {

                /* ==========================================
               WEBSITE OG PREVIEW
            ========================================== */

                $preview = fetch_link_preview($link);

                if (!empty($preview)) {

                    $data['preview_title'] =
                        $preview['title'] ?? null;

                    $data['preview_description'] =
                        $preview['description'] ?? null;

                    $data['preview_image'] =
                        $preview['image'] ?? null;
                }
            }
        }


        /* ==========================================
       CUSTOM IMAGE UPLOAD
       HIGHEST PRIORITY
    ========================================== */

        if (
            !empty($_FILES['custom_image']['name']) &&
            $_FILES['custom_image']['error'] === UPLOAD_ERR_OK
        ) {

            $customImage = $this->upload_custom_news_image();

            if ($customImage) {

                $data['preview_image'] = $customImage;
            }
        }


        /* ==========================================
        UPDATE DATABASE
        ========================================== */

        $this->CustomNews_model->update($id, $data);


        echo json_encode([
            'status' => true
        ]);
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
