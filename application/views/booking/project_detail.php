<div class="modal-content">
    <div class="modal-header border-bottom pb-3">
        <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
    </div>
    <div class="project-details-bg-modal">
        <div class="heading p-3">
            <h5 class="modal-title fw-bold"><?= $project->exam_name ?></h5>
            <p class="m-0">Booking Received on <span class="text-dark fw-bold"><?= date('M d, Y H:m:s', strtotime($project->booking_received)) ?></span></p>
        </div>
        <?php
        if (!empty($project->center_booking_accept_date) && empty($project->client_accept_booking_date)) { ?>
            <div class="p-3">
                <div class="bg-white p-3 rounded">
                    <?php
                    if ($project->exam_center_status == 2) {
                        $status = 'cancelled';
                    ?>
                        <div class="mb-4">
                            <img src="<?php echo base_url("assets/asserts/booking-cancel-icon.jpg") ?>" alt="" style="height: 35px;width: 35px;object-fit: cover;">
                            <span>Booking <?= $status ?> on <?= date('M d, Y H:m:s', strtotime($project->center_booking_accept_date)) ?></span>
                        </div>
                    <?php
                    } else {
                        $status = 'accepted';
                    ?>
                        <div class="mb-4">
                            <img src="<?php echo base_url("assets/asserts/booking-accept-icon.png") ?>" alt="">
                            <span>Booking <?= $status ?> on <?= date('M d, Y H:m:s', strtotime($project->center_booking_accept_date)) ?></span>
                        </div>
                        <div>
                            <img src="<?php echo base_url("assets/asserts/booking-review-icon.png") ?>" alt="">
                            <span>Booking in review. Please wait for confirmation</span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php
        if (!empty($project->center_booking_accept_date) && !empty($project->client_accept_booking_date)) { ?>
            <div class="p-3">
                <div class="bg-white p-3 rounded">
                    <?php
                    if ($project->client_status == 2) {
                        $status = 'cancelled';
                    ?>
                        <div class="mb-4">
                            <img src="<?php echo base_url("assets/asserts/booking-accept-icon.png") ?>" alt="">
                            <span>Booking accepted on <?= date('M d, Y H:m:s', strtotime($project->center_booking_accept_date)) ?></span>
                        </div>
                        <div class="">
                            <img src="<?php echo base_url("assets/asserts/booking-cancel-icon.jpg") ?>" alt="" style="height: 35px;width: 35px;object-fit: cover;">
                            <span>Booking <?= $status ?> on <?= date('M d, Y H:m:s', strtotime($project->client_accept_booking_date)) ?></span>
                        </div>
                    <?php
                    } else {
                        $status = 'confirmed ';
                    ?>
                        <div class="mb-4">
                            <img src="<?php echo base_url("assets/asserts/booking-accept-icon.png") ?>" alt="">
                            <span>Booking accepted on <?= date('M d, Y H:m:s', strtotime($project->center_booking_accept_date)) ?></span>
                        </div>
                        <div>
                            <img src="<?php echo base_url("assets/asserts/booking-accept-icon.png") ?>" alt="">
                            <span>Booking <?= $status ?> on <?= date('M d, Y H:m:s', strtotime($project->client_accept_booking_date)) ?></span>
                            <p class="ms-4 m-0">Entry added to your Calendar, <a href="<?php echo base_url('my-calendar') ?>"><span
                                        class="fw-bold text-dark">Check Now</span></a></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <hr>
        <div class="modal-body">
            <h6 class="fw-semibold">01: Project Details</h6>

            <div class="form-group">
                <label class="form-label">Exam Date</label>
                <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($project->start_date)) ?> - <?= date('M d, Y', strtotime($project->end_date)) ?>"
                    readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Exam Category</label>
                <input type="text" class="form-control" value="<?= $project->exam_type ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">From</label>
                <input type="text" class="form-control" value="<?= $project->client_name ?>" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">Exam City</label>
                <input type="text" class="form-control" value="<?= $project->city_name ?>" readonly>
            </div>
            
            <div class="mt-4">

                <h6 class="mb-3">

                    Batch Allocation

                </h6>

                <table class="table table-bordered">

                    <thead class="table-light">

                        <tr>

                            <th>

                                Batch

                            </th>

                            <th>

                                Timing

                            </th>

                            <th>

                                Allocated To You

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($batchAllocation as $batch) { ?>

                            <tr>

                                <td>

                                    Batch <?= $batch['batch_no']; ?>

                                </td>

                                <td>

                                    <?= date('h:i A', strtotime($batch['batch_start'])) ?>

                                    -

                                    <?= date('h:i A', strtotime($batch['batch_end'])) ?>

                                </td>


                                <td>

                                    <span class="badge bg-success">

                                        <?= $batch['center_seat']; ?>

                                    </span>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

            <div class="form-group">
                <label class="form-label">Pricing</label>
                <input type="text" class="form-control" value="Rs. <?= $project->admin_center_final_price ?> / seat" readonly>
            </div>

            <h6 class="fw-semibold mt-4">02: Software & Hardware Requirements</h6>
            <div class="form-group">
                <label class="form-label">Exam Mode</label>
                <input type="text" class="form-control" readonly
                    value="<?= ucwords(str_replace('_', ' ', $project->exam_mode ?? '')) ?>">
            </div>


            <h6 class="fw-semibold mt-4">Computer Configuration</h6>
            <div class="form-group">
                <label class="form-label">Operating System</label>
                <input type="text" class="form-control" value="<?= $project->inet_mode_os ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">RAM</label>
                <input type="text" class="form-control" value="<?= $project->inet_mode_ram ?>GB" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Display Resolution</label>
                <input type="text" class="form-control" value="<?= $project->inet_mode_display ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label d-block">Internet on each device</label>

                <div class="d-flex justify-content-between">
                    <div class="border w-50 me-2 px-3 py-2 rounded d-flex align-items-center bg-white">
                        <input type="radio" disabled
                            name="internet_each_device"
                            value="1"
                            <?= isset($project->inet_mode_internet_each) && $project->inet_mode_internet_each == 1 ? 'checked' : '' ?>>
                        <span class="ms-2">Yes</span>
                    </div>

                    <div class="border w-50 ms-2 px-3 py-2 rounded d-flex align-items-center bg-white">
                        <input type="radio" disabled
                            name="internet_each_device"
                            value="0"
                            <?= isset($project->inet_mode_internet_each) && $project->inet_mode_internet_each == 0 ? 'checked' : '' ?>>
                        <span class="ms-2">No</span>
                    </div>
                </div>
            </div>

            <h6 class="fw-semibold mt-4">03: Amenity Requirements</h6>
            <div class="form-group">
                <label class="form-label">Parking Facility</label>
                <input type="text" class="form-control" value="<?= $project->parking_facility ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Security Guard</label>
                <input type="text" class="form-control" value="<?= $project->security_guard ? 'Male' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Lockers</label>
                <input type="text" class="form-control" value="<?= $project->locker_facility ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Waiting area</label>
                <input type="text" class="form-control" value="<?= $project->waiting_area ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Power Backup</label>
                <input type="text" class="form-control" value="<?= $project->power_backup ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">PH Handicapped</label>
                <input type="text" class="form-control" value="<?= $project->ph_handicaped ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Printer</label>
                <input type="text" class="form-control" value="<?= $project->printer ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Rough sheet</label>
                <input type="text" class="form-control" value="<?= $project->rough_sheet ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Partition</label>
                <input type="text" class="form-control" value="<?= $project->partition_in_lab ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">AC in lab</label>
                <input type="text" class="form-control" value="<?= $project->ac_in_lab ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">CCTV required</label>
                <input type="text" class="form-control" value="<?= $project->cctv_required ? 'Yes' : 'No' ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Footage required</label>
                <input type="text" class="form-control" value="<?= $project->cctv_recording ? 'Yes' : 'No' ?>" readonly>
            </div>

        </div>
        <?php if ($project->exam_center_status == 0 || $project->exam_center_status == 4) { ?>

            <div class="pt-4 ps-4 pe-3 bg-white">

                <button class="btn btn-success accept-details project-status-change-btn"
                    data-project-id="<?= $project->project_id ?>"
                    data-center-id="<?= $project->center_id ?>">
                    Accept
                </button>

                <button class="btn btn-warning negotiate-modal-open-btn"
                    data-project-id="<?= $project->project_id ?>"
                    data-center-id="<?= $project->center_id ?>">
                    Negotiate Price
                </button>

                <button class="btn btn-danger reject-details reject-modal-open-btn"
                    data-project-id="<?= $project->project_id ?>"
                    data-center-id="<?= $project->center_id ?>">
                    Reject
                </button>

            </div>

        <?php } elseif ($project->exam_center_status == 3) { ?>

            <div class="alert alert-info mt-3">
                ⏳ <strong>Negotiation request already sent.</strong><br>
                Please wait for admin response.
            </div>

        <?php } elseif ($project->exam_center_status == 2) { ?>

            <div class="alert alert-danger mt-3">
                ❌ <strong>This booking has been rejected.</strong>
            </div>

        <?php } ?>

        <p class="text-center mt-3 fs-5">Have a question? <a href="<?php echo base_url('settings') ?>" class="fs-5 text-decoration-none">Contact us</a></p>
    </div>
</div>