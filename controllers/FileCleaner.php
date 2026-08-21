<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileCleaner extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Set time limits for large migrations
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $this->old_db = $this->load->database('old', TRUE);
        $this->new_db = $this->load->database('default', TRUE);
    }
    
    
    // public function cleanCenterImages()
    // {
    //     set_time_limit(0);
    
    //     $folder = FCPATH . 'uploads/center_image/';
    
    //     if (!is_dir($folder)) {
    //         exit("Folder not found.");
    //     }
    
    //     echo "<h2>Center Image Verification</h2>";
    
    //     // ===============================
    //     // Get DB Images with Center Detail
    //     // ===============================
    
    //     $db_images = $this->new_db
    //         ->select('tt_center_images.center_image,
    //                   tt_center_images.center_id,
    //                   tt_center.center_name')
    //         ->from('tt_center_images')
    //         ->join('tt_center', 'tt_center.id = tt_center_images.center_id', 'left')
    //         ->where('tt_center_images.deleted', 0)
    //         ->get()
    //         ->result_array();
    
    //     $used_images = [];
    
    //     foreach ($db_images as $img) {
    
    //         $filename = basename(trim($img['center_image']));
    
    //         if ($filename == '') {
    //             continue;
    //         }
    
    //         $used_images[$filename] = [
    //             'center_id'   => $img['center_id'],
    //             'center_name' => $img['center_name']
    //         ];
    //     }
    
    //     // ===============================
    //     // Scan Folder
    //     // ===============================
    
    //     $files = scandir($folder);
    
    //     $used = 0;
    //     $unused = 0;
    
    //     echo "<table border='1' cellpadding='6' cellspacing='0'>";
    //     echo "<tr style='background:#333;color:#fff'>
    //             <th>Status</th>
    //             <th>Image</th>
    //             <th>Center ID</th>
    //             <th>Center Name</th>
    //           </tr>";
    
    //     foreach ($files as $file) {
    
    //         if ($file == '.' || $file == '..') {
    //             continue;
    //         }
    
    //         $full_path = $folder . $file;
    
    //         if (!is_file($full_path)) {
    //             continue;
    //         }
    
    //         if (isset($used_images[$file])) {
    
    //             echo "<tr style='background:#d4edda'>";
    //             echo "<td>✅ Used</td>";
    //             echo "<td>{$file}</td>";
    //             echo "<td>{$used_images[$file]['center_id']}</td>";
    //             echo "<td>{$used_images[$file]['center_name']}</td>";
    //             echo "</tr>";
    
    //             $used++;
    
    //         } else {
    
    //             echo "<tr style='background:#f8d7da'>";
    //             echo "<td>❌ Unused</td>";
    //             echo "<td>{$file}</td>";
    //             echo "<td>-</td>";
    //             echo "<td>-</td>";
    //             echo "</tr>";
    
    //             // After verification
    
    //             if(file_exists($full_path)){
    //                 unlink($full_path);
    //             }
    
    //             $unused++;
    //         }
    //     }
    
    //     echo "</table>";
    
    //     echo "<br><br>";
    
    //     echo "<h3>Summary</h3>";
    
    //     echo "<b>Total Used :</b> {$used}<br>";
    
    //     echo "<b>Total Unused :</b> {$unused}<br>";
    
    //     echo "<b>Total Files :</b> ".($used+$unused)."<br>";
    // }
    
    
    // public function cleanCenterDocuments()
    // {
    //     set_time_limit(0);
    
    //     $folder = FCPATH . 'uploads/center_document/'; // Change folder if required
    
    //     if (!is_dir($folder)) {
    //         exit("Folder not found.");
    //     }
    
    //     echo "<h2>Center Document Verification</h2>";
    
    //     // ==========================================
    //     // Get Documents with Center Details
    //     // ==========================================
    
    //     $db_docs = $this->new_db
    //         ->select('tt_center_document.url,
    //                   tt_center_document.center_id,
    //                   tt_center_document.doc_name,
    //                   tt_center.center_name')
    //         ->from('tt_center_document')
    //         ->join('tt_center', 'tt_center.id = tt_center_document.center_id', 'left')
    //         ->where('tt_center_document.deleted', 0)
    //         ->get()
    //         ->result_array();
    
    //     $used_docs = [];
    
    //     foreach ($db_docs as $doc) {
    
    //         $filename = basename(trim($doc['url']));
    
    //         if ($filename == '') {
    //             continue;
    //         }
    
    //         $used_docs[$filename] = [
    //             'center_id'   => $doc['center_id'],
    //             'center_name' => $doc['center_name'],
    //             'doc_name'    => $doc['doc_name']
    //         ];
    //     }
    
    //     // ==========================================
    //     // Scan Folder
    //     // ==========================================
    
    //     $files = scandir($folder);
    
    //     $used = 0;
    //     $unused = 0;
    
    //     echo "<table border='1' cellpadding='6' cellspacing='0'>";
    //     echo "<tr style='background:#333;color:#fff'>
    //             <th>Status</th>
    //             <th>Document File</th>
    //             <th>Document Name</th>
    //             <th>Center ID</th>
    //             <th>Center Name</th>
    //           </tr>";
    
    //     foreach ($files as $file) {
    
    //         if ($file == '.' || $file == '..') {
    //             continue;
    //         }
    
    //         $full_path = $folder . $file;
    
    //         if (!is_file($full_path)) {
    //             continue;
    //         }
    
    //         if (isset($used_docs[$file])) {
    
    //             echo "<tr style='background:#d4edda'>";
    //             echo "<td>✅ Used</td>";
    //             echo "<td>{$file}</td>";
    //             echo "<td>{$used_docs[$file]['doc_name']}</td>";
    //             echo "<td>{$used_docs[$file]['center_id']}</td>";
    //             echo "<td>{$used_docs[$file]['center_name']}</td>";
    //             echo "</tr>";
    
    //             $used++;
    
    //         } else {
    
    //             echo "<tr style='background:#f8d7da'>";
    //             echo "<td>❌ Unused</td>";
    //             echo "<td>{$file}</td>";
    //             echo "<td>-</td>";
    //             echo "<td>-</td>";
    //             echo "<td>-</td>";
    //             echo "</tr>";
    
    //             // After verification uncomment
    
    //             if(file_exists($full_path)){
    //                 unlink($full_path);
    //             }
                
    
    //             $unused++;
    //         }
    //     }
    
    //     echo "</table>";
    
    //     echo "<br><br>";
    
    //     echo "<h3>Summary</h3>";
    
    //     echo "<b>Total Used :</b> {$used}<br>";
    //     echo "<b>Total Unused :</b> {$unused}<br>";
    //     echo "<b>Total Files :</b> ".($used+$unused)."<br>";
    // }
    
    
    // public function cleanCenterVideos()
    // {
    //     set_time_limit(0);
    
    //     $folder = FCPATH . 'uploads/center_video/'; // Change if required
    
    //     if (!is_dir($folder)) {
    //         exit("Folder not found.");
    //     }
    
    //     echo "<h2>Center Video Verification</h2>";
    
    //     // ==========================================
    //     // Get Videos with Center Details
    //     // ==========================================
    
    //     $db_videos = $this->new_db
    //         ->select('tt_center_video.center_video,
    //                   tt_center_video.about_video,
    //                   tt_center_video.center_id,
    //                   tt_center.center_name')
    //         ->from('tt_center_video')
    //         ->join('tt_center', 'tt_center.id = tt_center_video.center_id', 'left')
    //         ->where('tt_center_video.deleted', 0)
    //         ->get()
    //         ->result_array();
    
    //     $used_videos = [];
    
    //     foreach ($db_videos as $video) {
    
    //         $filename = basename(trim($video['center_video']));
    
    //         if ($filename == '') {
    //             continue;
    //         }
    
    //         $used_videos[$filename] = [
    //             'center_id'   => $video['center_id'],
    //             'center_name' => $video['center_name'],
    //             'about_video' => $video['about_video']
    //         ];
    //     }
    
    //     // ==========================================
    //     // Scan Folder
    //     // ==========================================
    
    //     $files = scandir($folder);
    
    //     $used = 0;
    //     $unused = 0;
    
    //     echo "<table border='1' cellpadding='6' cellspacing='0'>";
    //     echo "<tr style='background:#333;color:#fff'>
    //             <th>Status</th>
    //             <th>Video File</th>
    //             <th>About Video</th>
    //             <th>Center ID</th>
    //             <th>Center Name</th>
    //           </tr>";
    
    //     foreach ($files as $file) {
    
    //         if ($file == '.' || $file == '..') {
    //             continue;
    //         }
    
    //         $full_path = $folder . $file;
    
    //         if (!is_file($full_path)) {
    //             continue;
    //         }
    
    //         if (isset($used_videos[$file])) {
    
    //             echo "<tr style='background:#d4edda'>";
    //             echo "<td>✅ Used</td>";
    //             echo "<td>{$file}</td>";
    //             echo "<td>{$used_videos[$file]['about_video']}</td>";
    //             echo "<td>{$used_videos[$file]['center_id']}</td>";
    //             echo "<td>{$used_videos[$file]['center_name']}</td>";
    //             echo "</tr>";
    
    //             $used++;
    
    //         } else {
    
    //             echo "<tr style='background:#f8d7da'>";
    //             echo "<td>❌ Unused</td>";
    //             echo "<td>{$file}</td>";
    //             echo "<td>-</td>";
    //             echo "<td>-</td>";
    //             echo "<td>-</td>";
    //             echo "</tr>";
                
    //             // After verification uncomment
    
    //             if(file_exists($full_path)){
    //                 unlink($full_path);
    //             }
    
    //             $unused++;
    //         }
    //     }
    
    //     echo "</table>";
    
    //     echo "<br><br>";
    
    //     echo "<h3>Summary</h3>";
    
    //     echo "<b>Total Used :</b> {$used}<br>";
    //     echo "<b>Total Unused :</b> {$unused}<br>";
    //     echo "<b>Total Files :</b> " . ($used + $unused) . "<br>";
    // }

}