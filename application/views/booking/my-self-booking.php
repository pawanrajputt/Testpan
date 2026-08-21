<div class="booking-center self-booking active">

    <div class="main-contant">
        <!-- //////////////// Self and table section start ////////////// -->
        <div class="paginationCnt">
            <div class="Matrix-table-cnt center active">
                <div class="matrix-wrapper">
                    <div class="col-4">
                        <div class="matrix-box total-bookings">
                            <div class="matrix-icon total-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="matrix-content">
                                <p>Total Self Bookings</p>
                                <h2><?= $total_self_booking_req_count ?></h2>
                            </div>
                            <div>
                                <select class="matrix-dropdown">
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Box 2: Custom Booking + Edit Profile -->
                    <div class="col-4">
                        <div class="matrix-box custom-booking-box">
                            <div class="custom-booking-btn-box">
                                <button class="w-100 mb-2 custom-btn" data-bs-toggle="modal"
                                    data-bs-target="#add-new-bookingModal"> <i class="fas fa-plus-circle btn-icon"></i> Add custom
                                    booking</button>
                                <a href="<?php echo base_url('my-center') ?>">
                                    <button class="center-profile-btn">
                                        <i class="fas fa-edit btn-icon"></i> Edit Center Profile
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-wrapper px-4">
                    <div class="table-container">
                        <form method="get">
                            <div class="table-header">
                                <div class="table-input">
                                    <img src="<?= base_url('assets/asserts/search.png') ?>" alt="">
                                    <input
                                        type="text"
                                        name="search"
                                        value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
                                        placeholder="Search by name, email or exam"
                                        class="form-control px-3">
                                </div>
                                <div>
                        </form>
                        <button class="p-2  rounded bg-dark text-white" type="submit" style="width: max-content;">
                            Search
                        </button>
                        <a href="<?= base_url('my-self-booking') ?>" style="margin-right: 130px;">
                            <button class="p-2  rounded bg-dark text-white" type="button" style="width: max-content;">
                                Clear Filter
                            </button>
                        </a>
                        <select name="" id="" class="p-2 me-4 border rounded">
                            <option value="all">All</option>
                        </select>
                        <button class="py-2 px-3 border rounded bg-dark text-white" onclick="window.location.href='<?php echo base_url('export-self-booking'); ?>'">
                            Export
                            <img src="<?php echo base_url('assets/asserts/Download.png') ?>" alt="">
                        </button>
                    </div>
                </div>
                <table id="dataTable" class="dataTable">
                    <thead>
                        <tr>
                            <th>Client Details</th>
                            <th>Exam Details</th>
                            <th>Seats Booked</th>
                            <th>Exam Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($selfBookingData) > 0) {
                            foreach ($selfBookingData as $row) { ?>
                                <tr>
                                    <td>
                                        <strong>Name:</strong> <?= $row['client_name'] ?>
                                        <br>
                                        <strong>Email:</strong> <?= $row['client_email'] ?>
                                        <br>
                                        <strong>Phone:</strong> <?= $row['client_phone'] ?>
                                    </td>
                                    <td>
                                        <strong>Exam Name:</strong> <?= $row['exam_name'] ?>
                                        <br>
                                        <strong>Location:</strong> <?= $row['exam_location'] ?>
                                        <br>
                                        <strong>Date:</strong> <?= date('M d, Y', strtotime($row['start_date'])) ?> - <?= date('M d, Y', strtotime($row['end_date'])) ?>
                                        <br>
                                        <strong>Duration:</strong> <?= $row['exam_duration'] ?>
                                    </td>
                                    </td>
                                    <td><?= $row['seats_booked'] ?></td>
                                    <td>
                                        <?php
                                        $today = date('Y-m-d');

                                        if ($today < $row['start_date']) {
                                            echo '<span class="badge rounded-pill bg-warning text-dark">Upcoming</span>';
                                        } elseif ($today > $row['end_date']) {
                                            echo '<span class="badge rounded-pill bg-success">Completed</span>';
                                        } else {
                                            echo '<span class="badge rounded-pill bg-info text-dark">Processing</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <i class="fa fa-pencil cursor-pointer" onclick="editSelfBooking('<?= $row['id'] ?>');"></i>

                                        <i class="fa fa-trash cursor-pointer" onclick="deleteSelfBooking('<?= $row['id'] ?>');"></i>

                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td class="text-center" colspan="9">No Self Booking Found...</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4 d-flex justify-content-between align-items-center pagination">
            <button class="prevBtn" id="prevBtn"><img
                    src="<?php echo base_url('assets/asserts/Line 175.png') ?>" alt="">Previous
            </button>
            <div id="pageBox" class="pageBox">Page 1</div>
            <button class="nextBtn" id="nextBtn">Next<img
                    src="<?php echo base_url('assets/asserts/right-arrow.png') ?>" alt="next">
            </button>
        </div>
    </div>

</div>
<!-- //////////////// Self and table section end ////////////// -->
</div>
</div>

<!-- /////////////// Self booking modal ////////////////////////-->
<div class="modal fade" id="add-new-bookingModal" tabindex="-1"
    aria-labelledby="add-new-bookingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content" style="overflow: auto;">
            <form id="createSelfBookingForm" method="POST">
                <input type="hidden" id="SelfBookingFormUrl" value="<?php echo base_url('create-self-booking') ?>">
                <div class="modal-header d-block border-bottom-0">
                    <div class="close-btn-wrapper p-3 text-end">
                        <button type="button" class="btn-close " data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="">
                        <div class="text-center">
                            <img src="<?php echo base_url('assets/asserts/plus-icon.png') ?>" alt="plus-icon">
                        </div>
                        <div class="text-center">
                            <h3 class="modal-title my-3" id="add-new-bookingModal">Add a new booking
                            </h3>
                            <p>Please enter the following details to create a booking.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <p>Client details.</p>
                    <!-- Client Details -->
                    <div class="Client-detail-box">
                        <p>
                            <label>Client name</label>
                            <input type="text" class="form-control mb-2" placeholder="..." name="client_name" required>
                        </p>
                        <p>
                            <label for="">Client email</label>
                            <input type="email" class="form-control mb-2" placeholder="..." name="client_email" required>
                        </p>
                        <p>
                            <label for="">Client Phone number</label>
                            <input type="text" class="form-control mb-3" placeholder="..." name="client_phone" required>
                        </p>
                    </div>
                    <!-- Exam Details -->
                    <p class="mt-3">Exam details.</p>
                    <div class="Client-detail-box">
                        <p>
                            <label for="">Exam name</label>
                            <input type="text" class="form-control mb-2" placeholder="..." name="exam_name" required>
                        </p>
                        <p>
                            <label>Exam type</label>
                            <select class="form-select mb-2" name="exam_type" required>
                                <option selected>Select an option</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Exam location</label>
                            <input type="text" class="form-control mb-2" placeholder="..." name="exam_location" required>
                        </p>
                        <p>
                            <label>Exam Start Date</label>
                            <input type="date" class="form-control mb-2"
                                name="start_date" id="start_date"
                                onchange="handleStartDateChange()"
                                required>
                        </p>

                        <p>
                            <label>Exam End Date</label>
                            <input type="date" class="form-control mb-2"
                                name="end_date" id="end_date"
                                onchange="calculateDuration()"
                                required>
                        </p>
                        <p>
                            <label for="">Exam duration (in days)</label>
                            <input type="number" class="form-control mb-2" placeholder="Exam duration in days" name="exam_duration" id="exam_duration" required readonly>
                        </p>
                        <p>
                            <label for="">Exam Batch</label>
                            <select name="exam_batch" id="changeBatch" class='w-100 border rounded py-2 px-3'>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </p>

                        <?php for ($i = 1; $i <= 5; $i++) { ?>

                            <div class="row align-items-center mt-3 batch-div" id="divexbatch<?php echo $i; ?>" style="display:none">

                                <div class="col-12">
                                    <strong>Timing for batch <?php echo $i; ?></strong>
                                </div>

                                <div class="col-md-6">
                                    <label>Start Time</label>
                                    <input type="time"
                                        name="batch<?php echo $i; ?>_start"
                                        class="form-control batch-start"
                                        data-batch="<?php echo $i; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label>End Time</label>
                                    <input type="time"
                                        name="batch<?php echo $i; ?>_end"
                                        class="form-control batch-end"
                                        data-batch="<?php echo $i; ?>">
                                </div>

                            </div>

                        <?php } ?>
                    </div>
                    <!-- Booking Details -->
                    <p class="mt-3">Booking details</p>
                    <div class="Client-detail-box">
                        <p>
                            <label for="">Seats booked</label>
                            <input type="number" class="form-control mb-2" placeholder="Seats booked" name="seats_booked" required>
                        </p>
                        <p>
                            <label for="">Labs assigned</label>
                            <select class="form-select mb-3" name="labs_assigned">
                                <option>Select labs</option>
                                <?php
                                if (count($labs) > 0)
                                    foreach ($labs as $lab) { ?>
                                    <option value="<?= $lab['id'] ?>"><?= $lab['floor_name'] ?> (<?= $lab['no_of_computer'] ?>)</option>
                                <?php } ?>
                            </select>
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-dark w-100" id="createSelfBooking">Confirm booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit self booking -->
<div class="modal fade" id="edit-self-bookingModal" tabindex="-1"
    aria-labelledby="edit-self-bookingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content" style="overflow: auto;">
            <form id="updateSelfBookingForm" method="POST">
                <input type="hidden" id="updateSelfBookingFormUrl" value="<?php echo base_url('update-self-booking') ?>">
                <div class="modal-header d-block border-bottom-0">
                    <div class="close-btn-wrapper p-3 text-end">
                        <button type="button" class="btn-close " data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="">
                        <div class="text-center">
                            <img src="<?php echo base_url('assets/asserts/plus-icon.png') ?>" alt="plus-icon">
                        </div>
                        <div class="text-center">
                            <h3 class="modal-title my-3" id="add-new-bookingModal">Update a booking
                            </h3>
                            <p>Please enter the following details to update a booking.</p>
                        </div>
                    </div>
                </div>
                <div id="innerHtmlSelfBookingEditModal"></div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-dark w-100" id="updateSelfBooking">Update Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- //////////////  Self booking modal //////////////////////////-->