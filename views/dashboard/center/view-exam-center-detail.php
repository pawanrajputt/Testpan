<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a> /
            </span>
            <?= $page_title ?>
        </h4>

        <!-- ================= BASIC INFO ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="mb-0">Center Information</h5>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/download-center-images/' . $center->center_id) ?>" class="btn btn-info mb-3 btn-sm"> <i class="fa fa-download"></i> <span class="" style="margin-left: 5px;">Download All Images</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <strong>Center Name :</strong> <?= $center->center_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Country :</strong> <?= $center->country_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>State :</strong> <?= $center->state_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>City :</strong> <?= $center->city_name ?>
                    </div>


                    <div class="col-md-4 mb-3">
                        <strong>Owner Name :</strong> <?= $center->username ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Owner Email :</strong> <?= $center->useremail ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Owner Phone :</strong> <?= $center->userphone ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Local Area Name :</strong> <?= $center->local_area_name ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Pincode :</strong> <?= $center->pin_code ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Landmark :</strong> <?= $center->landmark ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Capacity :</strong> <?= $center->capacity ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Center ID :</strong> <?= $center->id ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Type Of Center :</strong> <?= $center->type_of_center ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Status :</strong>
                        <?php if ($center->approved == 1) { ?>
                            <span class="badge bg-success">Approved</span>
                        <?php } else { ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Subscription :</strong>

                        <?php if (!empty($center->package_name)) { ?>

                            <span class="badge bg-warning">
                                <?= $center->package_name ?>
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-secondary">
                                No Subscription
                            </span>

                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Verified Partner :</strong>

                        <?php if ($center->verified_badge == 1) { ?>

                            <span class="badge bg-primary">
                                Yes
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-secondary">
                                No
                            </span>

                        <?php } ?>
                    </div>


                    <div class="col-md-4 mb-3">
                        <strong>Expiry Date :</strong>

                        <?= !empty($center->expiry_date)
                            ? date('d M Y', strtotime($center->expiry_date))
                            : '--' ?>
                    </div>


                    <div class="col-md-4 mb-3">
                        <strong>Booking Limit :</strong>

                        <?= $center->max_bookings == -1
                            ? 'Unlimited'
                            : $center->max_bookings ?>
                    </div>


                    <div class="col-md-4 mb-3">
                        <strong>Package Duration :</strong>

                        <?= $center->duration ?>
                        <?= ucfirst($center->duration_type) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Created At :</strong> <?= date('Y-m-d', strtotime($center->created_on)) ?? '--' ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Description :</strong> <?= $center->center_description ?? '--' ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= LOGO ================= -->
        <?php if (!empty($center->logo)) { ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Center Logo</h5>
                </div>
                <div class="card-body text-center">

                    <img src="<?= CENTER_URL . '/' . $center->logo ?>"
                        class="img-fluid rounded mb-3"
                        style="max-height:150px;">

                    <br>

                    <a href="<?= base_url('admin/download-center-image?file=' . rawurlencode(CENTER_URL . '/' . $center->logo)) ?>"
                        class="btn btn-sm btn-primary download-logo-btn">
                        Download Logo
                    </a>

                </div>
            </div>
        <?php } ?>



        <!-- ================= BANK & GST DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Bank & GST Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>PAN Number :</strong>
                        <?= !empty($center->pan_no) ? $center->pan_no : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>GST Number :</strong>
                        <?= !empty($center->gst_no) ? $center->gst_no : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>GST File :</strong>
                        <?php if (!empty($center->gst_file)) {
                            $gst_path = $center->gst_file;
                            $gst_path = ltrim($gst_path, '/');
                        ?>
                            <a href="<?= CENTER_URL . '/' . $gst_path ?>"
                                target="_blank"
                                class="btn btn-sm btn-primary">
                                View GST File
                            </a>
                        <?php } else {
                            echo '-';
                        } ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Bank Name :</strong>
                        <?= !empty($center->bank_name) ? $center->bank_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Account Number :</strong>
                        <?= !empty($center->bank_account_number) ? $center->bank_account_number : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>IFSC Code :</strong>
                        <?= !empty($center->bank_ifsc_code) ? $center->bank_ifsc_code : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Beneficiary Name :</strong>
                        <?= !empty($center->beneficiary_name) ? $center->beneficiary_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Has Gst:</strong>
                        <?= $center->has_gst ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>' ?>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Has Msme :</strong>
                        <?= $center->has_msme ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Msme Number :</strong>
                        <?= !empty($center->msme_number) ? $center->msme_number : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Uidai Number :</strong>
                        <?= !empty($center->uidai_number) ? $center->uidai_number : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Udyam Number :</strong>
                        <?= !empty($center->udyam_number) ? $center->udyam_number : '-' ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= TRANSPORT DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Transport Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Nearest Railway Station :</strong>
                        <?= !empty($center->nearest_railway_station) ? $center->nearest_railway_station : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Distance From Station :</strong>
                        <?= !empty($center->distance_from_station) ? formatDistance($center->distance_from_station) : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Nearest Bus Stop :</strong>
                        <?= !empty($center->nearest_bus_stop) ? $center->nearest_bus_stop : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Distance From Bus Stop :</strong>
                        <?= !empty($center->distance_from_bus_stop) ? formatDistance($center->distance_from_bus_stop) : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Nearest Metro Station :</strong>
                        <?= !empty($center->nearest_metro_station) ? $center->nearest_metro_station : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Distance From Metro :</strong>
                        <?= !empty($center->distance_from_metro) ? formatDistance($center->distance_from_metro) : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Nearest Airport :</strong>
                        <?= !empty($center->nearest_airport) ? $center->nearest_airport : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Distance From Airport :</strong>
                        <?= !empty($center->distance_from_airport) ? formatDistance($center->distance_from_airport) : '-' ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= INFRASTRUCTURE & CONTACT DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Infrastructure & Contact Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- Center Superintendent -->
                    <div class="col-md-6 mb-3">
                        <strong>CS Name :</strong>
                        <?= !empty($center->cs_name) ? $center->cs_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>CS Contact :</strong>
                        <?= !empty($center->cs_contact_number) ? $center->cs_contact_number : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>CS Email :</strong>
                        <?= !empty($center->cs_email) ? $center->cs_email : '-' ?>
                    </div>

                    <!-- Account Manager -->
                    <div class="col-md-6 mb-3">
                        <strong>AM Name :</strong>
                        <?= !empty($center->am_name) ? $center->am_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>AM Contact :</strong>
                        <?= !empty($center->am_contact_no) ? $center->am_contact_no : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>AM Email :</strong>
                        <?= !empty($center->am_email) ? $center->am_email : '-' ?>
                    </div>

                    <!-- POC -->
                    <div class="col-md-6 mb-3">
                        <strong>POC Name :</strong>
                        <?= !empty($center->poc_name) ? $center->poc_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>POC Contact :</strong>
                        <?= !empty($center->poc_contact_no) ? $center->poc_contact_no : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>POC Alternate :</strong>
                        <?= !empty($center->poc_mobile_alternate) ? $center->poc_mobile_alternate : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>POC Email :</strong>
                        <?= !empty($center->poc_email) ? $center->poc_email : '-' ?>
                    </div>

                    <!-- Emergency -->
                    <div class="col-md-6 mb-3">
                        <strong>Emergency Contact :</strong>
                        <?= !empty($center->emergency_contact_no) ? $center->emergency_contact_no : '-' ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= INTERNET / ISP DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Internet / ISP Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- Primary ISP -->
                    <div class="col-md-6 mb-3">
                        <strong>Primary ISP Name :</strong>
                        <?= !empty($center->primary_isp_name) ? $center->primary_isp_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Primary ISP Speed :</strong>
                        <?= !empty($center->primary_isp_speed)
                            ? $center->primary_isp_speed . ' ' . $center->primary_internet_speed_unit
                            : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Primary ISP Connection Type :</strong>
                        <?= !empty($center->primary_isp_connect_type) ? $center->primary_isp_connect_type : '-' ?>
                    </div>

                    <!-- Secondary ISP -->
                    <div class="col-md-6 mb-3">
                        <strong>Secondary ISP Name :</strong>
                        <?= !empty($center->secondary_isp_name) ? $center->secondary_isp_name : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Secondary ISP Speed :</strong>
                        <?= !empty($center->secondary_isp_speed)
                            ? $center->secondary_isp_speed . ' ' . $center->secondary_internet_speed_unit
                            : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Secondary ISP Connection Type :</strong>
                        <?= !empty($center->secondary_isp_connect_type) ? $center->secondary_isp_connect_type : '-' ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= POWER & SAFETY DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Power & Safety Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Generator Backup Capacity :</strong>
                        <?= !empty($center->generator_backup_capacity) ? $center->generator_backup_capacity : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Generator Fuel Tank Capacity :</strong>
                        <?= !empty($center->generator_fuel_tank_capacity) ? $center->generator_fuel_tank_capacity : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>UPS Backup Time :</strong>
                        <?= !empty($center->ups_backup_time) ? $center->ups_backup_time : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Power Backup (UPS KV) :</strong>
                        <?= !empty($center->power_back_ups_kv) ? $center->power_back_ups_kv : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Fire Extinguisher in Each Lab :</strong>
                        <?= !empty($center->how_many_fire_extinguisher_in_each_lab)
                            ? $center->how_many_fire_extinguisher_in_each_lab
                            : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Projector in Each Lab :</strong>
                        <?= !empty($center->is_there_projector_in_each_lab) ? $center->is_there_projector_in_each_lab : '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Sound System in Each Lab :</strong>
                        <?= !empty($center->is_there_sound_sytem_in_each_lab) ? $center->is_there_sound_sytem_in_each_lab : '-' ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= LAB & INFRASTRUCTURE SUMMARY ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Lab & Infrastructure Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <?php
                    function yesNo($val)
                    {
                        if ($val == 'yes' || $val == 1) {
                            return '<span class="badge bg-success">Yes</span>';
                        } elseif ($val == 'no' || $val == 0) {
                            return '<span class="badge bg-danger">No</span>';
                        } else {
                            return '-';
                        }
                    }
                    ?>

                    <div class="col-md-4 mb-3">
                        <strong>Drinking Water :</strong>
                        <?= yesNo($center->drinking_water_facility) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Locker Facility :</strong>
                        <?= yesNo($center->locker_facility) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Network Printer :</strong>
                        <?= yesNo($center->network_printer) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Generator Backup :</strong>
                        <?= yesNo($center->is_generator_backup) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>AC in Each Lab :</strong>
                        <?= yesNo($center->ac_in_each_lab) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Single Network Connected :</strong>
                        <?= yesNo($center->connected_single_network) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Partition in Each Lab :</strong>
                        <?= yesNo($center->partitaion_each_lab) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Total Systems :</strong>
                        <?= !empty($center->total_no_system) ? $center->total_no_system : '-' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Total Labs :</strong>
                        <?= !empty($center->total_no_lab) ? $center->total_no_lab : '-' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Total Networks :</strong>
                        <?= !empty($center->how_many_network) ? $center->how_many_network : '-' ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= LAB DETAILS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Lab Details</h5>
            </div>
            <div class="card-body">

                <?php if (!empty($labs)) { ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Floor</th>
                                    <th>No. of Computers</th>
                                    <th>Windows Generation</th>
                                    <th>Operating System</th>
                                    <th>RAM</th>
                                    <th>Hard Disk</th>
                                    <th>Monitor Type</th>
                                    <th>Ethernet Switch Company</th>
                                    <th>Switch Category</th>
                                    <th>No. of Ports</th>
                                    <th>Created On</th>
                                    <th>Last Modified</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($labs as $key => $lab) {

                                    // Proper Ethernet Logic
                                    if (!empty($lab->ehternet_swtch_company)) {

                                        if (strtolower(trim($lab->ehternet_swtch_company)) == 'other') {

                                            $ethernetCompany = !empty($lab->ethernet_company_other)
                                                ? $lab->ethernet_company_other . " (Other)"
                                                : "Other";
                                        } else {

                                            $ethernetCompany = $lab->ehternet_swtch_company;
                                        }
                                    } else {
                                        $ethernetCompany = '-';
                                    }

                                ?>

                                    <tr class="text-center">
                                        <td><?= $key + 1 ?></td>

                                        <td>
                                            <?= $lab->floor_name != '' ? $lab->floor_name == 0 ? 'Ground' : ucfirst($lab->floor_name) : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->no_of_computer) ? $lab->no_of_computer : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->window_generation) ? $lab->window_generation : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->operating_system) ? $lab->operating_system : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->ram) ? $lab->ram : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->hard_disk) ? $lab->hard_disk : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->monitor_type) ? $lab->monitor_type : '-' ?>
                                        </td>

                                        <td>
                                            <?= $ethernetCompany ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->switch_category) ? $lab->switch_category : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->no_of_port_eth_switch) ? $lab->no_of_port_eth_switch : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->created_on)
                                                ? date('d-m-Y H:i', strtotime($lab->created_on))
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($lab->last_modify_on)
                                                ? date('d-m-Y H:i', strtotime($lab->last_modify_on))
                                                : '-' ?>
                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>

                    <div class="alert alert-warning mb-0">
                        No lab records found for this center.
                    </div>

                <?php } ?>

            </div>
        </div>



        <!-- ================= DOCUMENTS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Documents</h5>
            </div>
            <div class="card-body">

                <?php if (!empty($documents)) { ?>
                    <ul class="list-group">
                        <?php foreach ($documents as $doc) { ?>

                            <?php
                            if ($doc->uploaded_by == 'center') {

                                // DB me path save hai
                                $fileUrl = rtrim(CENTER_URL, '/') . '/' . ltrim($doc->url, '/');
                            } else {

                                // DB me sirf filename save hai
                                $fileUrl = base_url('uploads/center_document/' . $doc->url);
                            }
                            ?>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= ucfirst(str_replace('_', ' ', $doc->doc_name)) ?>

                                <a target="_blank"
                                    href="<?= $fileUrl ?>"
                                    class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </li>

                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No documents uploaded for this center.
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>

        <!-- ===================Video=================== -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Center Video</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <?php if (!empty($video)) { ?>

                        <?php foreach ($video as $vid) { ?>

                            <?php

                            /**
                             * ============================================
                             * Center Panel Video
                             * ============================================
                             */
                            if (isset($vid->about_video) && trim($vid->about_video) != '') {

                                // Admin Panel Video
                                $videoPath = base_url('uploads/center_video/' . $vid->center_video);
                                $videoAbout = '';
                            }

                            /**
                             * ============================================
                             * Admin Panel Video
                             * ============================================
                             */
                            else {

                                // Center Panel Video
                                $videoPath = rtrim(CENTER_URL, '/') . '/' . ltrim($vid->center_video, '/');
                                $videoAbout = $vid->about_video;
                            }

                            ?>

                            <div class="col-md-6 mb-4">

                                <video width="100%" height="300" controls class="border rounded">
                                    <source src="<?= $videoPath ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                                <?php if (!empty($videoAbout)) { ?>

                                    <div class="mt-2">
                                        <strong>Video About :</strong><br>
                                        <?= nl2br(htmlspecialchars($videoAbout)) ?>
                                    </div>

                                <?php } ?>

                                <div class="mt-3">
                                    <a href="<?= $videoPath ?>"
                                        target="_blank"
                                        class="btn btn-primary">
                                        View Full Video
                                    </a>
                                </div>

                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <div class="col-12">
                            <p class="text-muted">No video available</p>
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>

        <!-- ================= IMAGES ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Center Images</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($images)) {

                        // Group images by type
                        $grouped_images = [];
                        foreach ($images as $img) {
                            $grouped_images[$img->image_type][] = $img;
                        }

                        // Human readable labels
                        $image_labels = [
                            'center_entrance' => 'Center Entrance',
                            'lab_photo'        => 'Lab Photos',
                            'gate_image'       => 'Main Gate',
                            'server_image'     => 'Server Room',
                            'observer_image'   => 'Observer Room',
                            'ups_image'        => 'UPS/Generator'
                        ];

                        foreach ($grouped_images as $image_type => $type_images) {

                            $label = !empty($image_type) && isset($image_labels[$image_type])
                                ? $image_labels[$image_type]
                                : 'Center Images';
                    ?>

                            <div class="mb-4">

                                <h6 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-image mr-2"></i>
                                    <?= $label ?> (<?= count($type_images) ?>)
                                </h6>

                                <div class="row">

                                    <?php foreach ($type_images as $img) {

                                        /**
                                         * ============================================
                                         * Center Panel Images
                                         * image_type has value
                                         * ============================================
                                         */
                                        if (!empty($img->image_type)) {

                                            if (!empty($img->doe) && date('Y', strtotime($img->doe)) < 2025) {

                                                $image_path = 'uploads/center_image/' . $img->center_image;
                                                $image_url = base_url($image_path);
                                                $download_path = $image_path;
                                            } else {

                                                $image_path = ltrim($img->center_image, '/');
                                                $image_url = rtrim(CENTER_URL, '/') . '/' . $image_path;
                                                $download_path = $image_path;
                                            }
                                        }
                                        /**
                                         * ============================================
                                         * Admin Panel Images
                                         * image_type empty
                                         * ============================================
                                         */
                                        else {

                                            $image_path = 'uploads/center_image/' . $img->center_image;

                                            $image_url = base_url($image_path);

                                            $download_path = $image_path;
                                        }

                                    ?>

                                        <div class="col-md-3 mb-3">

                                            <div class="image-container position-relative">

                                                <img src="<?= $image_url ?>"
                                                    class="img-fluid rounded border"
                                                    style="height:150px;object-fit:cover;width:100%;"
                                                    alt="<?= $label ?>"
                                                    onerror="this.src='<?= base_url('assets/images/default-image.jpg') ?>'">

                                                <!-- Download -->
                                                <a href="<?= base_url('admin/download-center-image?file=' . rawurlencode($download_path)) ?>"
                                                    class="position-absolute"
                                                    style="top:8px;right:50px;color:#fff;background:rgba(0,0,0,0.6);padding:6px;border-radius:50%;">

                                                    <i class="fa fa-download"></i>

                                                </a>

                                                <!-- View -->
                                                <a href="javascript:void(0);"
                                                    class="position-absolute view-image-btn"
                                                    data-img="<?= $image_url ?>"
                                                    style="top:8px;right:10px;color:#fff;background:rgba(0,0,0,0.6);padding:6px;border-radius:50%;">

                                                    <i class="fa fa-eye"></i>

                                                </a>

                                                <div class="image-caption mt-1 text-muted small">
                                                    <i class="fas fa-file-image"></i>
                                                    <?= $label ?>
                                                </div>

                                            </div>

                                        </div>

                                    <?php } ?>

                                </div>

                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <div class="col-12">

                            <div class="alert alert-info">

                                <i class="fas fa-info-circle"></i>

                                No images uploaded for this center.

                            </div>

                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Image modal -->
<div class="modal fade" id="imageViewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
            </div>

            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded" style="max-height:500px;">
            </div>

            <div class="modal-footer">
                <button class="button btn btn-primary closeImageViewModal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).on('click', '.view-image-btn', function() {

        let imgSrc = $(this).data('img');

        // Set image in modal
        $('#modalImage').attr('src', imgSrc);

        // Open modal
        $('#imageViewModal').modal('show');

    });

    $(document).on('click', '.closeImageViewModal', function() {

        // hide modal
        $('#imageViewModal').modal('hide');

    });
</script>