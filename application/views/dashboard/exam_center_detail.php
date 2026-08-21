<div class="row">
    <div class="col-5">
        <div class="Approved-left-cnt p-3 rounded">
            <div class="">
                <img src="<?php echo $result->exam_center_url.'/'.$result->logo; ?>" alt="" style="height:100px ;">
                <h2 class="my-3"><?=$result->center_name?></h2>
                <p><?=$result->center_description?></p>
                <?php
                    $req_qry1 = $this->db->query("SELECT * FROM tt_send_booking_request WHERE 1=1 AND project_id='".$project_id."' and center_id='".$result->center_id."'")->row();          
                    $sendRequestStatus = $req_qry1->client_status ?? 0;

                    if($sendRequestStatus == 0){
                        ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="reject-btn-Approved center-booking-status-by-client" data-center-id="<?=$result->center_id?>" data-project-id="<?=$project_id?>" data-type="reject">Reject</a>
                            <a href="#" class="approved-btn-Approved center-booking-status-by-client" data-center-id="<?=$result->center_id?>" data-project-id="<?=$project_id?>" data-type="approve">Approve</a>
                        </div>
                <?php } ?>
            </div>
            <hr>
            <div class="">
                <h2 class="fs-6 text-secondary mb-3">Center details</h2>
                <div class="d-flex justify-content-between align-items-center">
                    <p>Location</p>
                    <p><?=$result->local_area_name?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-0">Rating</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <p class="d-flex me-3 bg-white m-0 p-1 rounded">
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/stars.png')?>" alt="">
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/stars.png')?>" alt="">
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/stars.png')?>" alt="">
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/stars.png')?>" alt="">
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/stars.png')?>" alt="">
                        </p>
                        <p class="m-0">5/5</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="m-0">Requirements</p>
                    <a href="#" class="compelet-btn">Matching</a>
                </div>
            </div>
            <hr>
            <div class="">
                <h2 class="fs-6 text-secondary mb-3">Requirement status</h2>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0">Seating</p>
                    <p class="m-0 text-primary"><?=$result->capacity?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <p class="m-0">Audited</p>
                    <a href="#" class="compelet-btn"><?=$result->audit_status==1 ? 'Yes' : 'No' ;?></a>
                </div>
                <div class="d-flex justify-content-between align-items-center ">
                    <p class="m-0">Status</p>
                    <a href="#" class="compelet-btn">Available</a>
                </div>
            </div>
        </div>

    </div>
    <div class="col-7">
        <div>
            <p>Center photos</p>
            <div class="d-flex justify-content-between align-items-center">
                <?php if (!empty($images)) {
                    foreach ($images as $image) { ?>
                        <img src="<?php echo $result->exam_center_url.'/'.$image['center_image']; ?>" alt="Center Image" style="width: 100px;height: 100px;object-fit: contain;">
                <?php } } ?>
            </div>
        </div>
        <hr>
        <div>
            <p>Audit history</p>
            <div
                class="d-flex justify-content-between align-items-center Audit-history-cnt">
                <div class="d-flex align-items-center">
                    <div><img src="<?php echo base_url('assets/icon-folder/project-icons/Audit-history-icon.png')?>"
                            alt=""></div>
                    <div class="ms-2">
                        <h2 class="m-0">Audit report</h2>
                        <?php 
                        if($result->last_audited!=''){ ?>
                        <p class="m-0">Last audited on <?=date('M d, Y', strtotime($result->last_audited))?></p>
                         <?php } ?>
                    </div>
                </div>
                <div>
                    <button class="view-report-btn">
                        <a style="text-decoration: none;" href="<?php echo ADMIN_URL.'/'.'uploads/center_audit_file/'.$result->audit_file?>" target="_blank"> View report
                        </a>
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <p>Location</p>
            <div class="d-flex justify-content-between align-items-center Audit-history-cnt">
                <div class="d-flex align-items-center">
                    <div>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/view-location-icon.png')?>" alt="">
                    </div>
                    <div class="ms-2">
                        <h2 class="m-0"><?= $result->center_name ?></h2>
                        <p class="m-0"><?= $result->local_area_name ?></p>
                    </div>
                </div>
                <div>
                    <a href="https://www.google.com/maps?q=<?= $result->address_lat ?>,<?= $result->address_long ?>" 
                       target="_blank" 
                       class="view-location-btn btn btn-primary">
                        View location
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>