<div class="main-contant">
    <!-- //////////////// Tab section start ////////////// -->
    <div class="my-booking-tab px-4">

        <a href="javascript:void(0)"
            class="booking-tab active"
            onclick="changeTab(0)">
            All Bookings
        </a>

        <a href="javascript:void(0)"
            class="booking-tab"
            onclick="changeTab(1)">
            In Review
        </a>

        <a href="javascript:void(0)"
            class="booking-tab"
            onclick="changeTab(2)">
            Confirmed Bookings
        </a>

        <a href="javascript:void(0)"
            class="booking-tab"
            onclick="changeTab(3)">
            Rejected History
        </a>

        <a href="javascript:void(0)"
            class="booking-tab"
            onclick="changeTab(4)">
            Postponed Bookings
        </a>

    </div>
    <!-- ///////////////// Tab section end /////////////// -->


    <!-- //////////////// Matrix and table section start ////////////// -->
    <div class="paginationCnt">
        <div class="Matrix-table-cnt center active">
            <div class="matrix-wrapper">
                <div class="col-4">
                    <div class="matrix-box total-bookings">
                        <div class="matrix-icon total-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Total Bookings</p>
                            <h2><?= $total_booking_req_count ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Seats Booked -->
                <div class="col-4">
                    <div class="matrix-box seats-booked">
                        <div class="matrix-icon seats-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Seats Booked</p>
                            <h2><?= $number_of_seats ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Box 3: Custom Booking + Edit Profile -->
                <div class="col-4">
                    <div class="matrix-box custom-booking-box">
                        <div class="custom-booking-btn-box">
                            <a href="<?php echo base_url('my-self-booking') ?>">
                                <button class="custom-btn">
                                    <i class="fas fa-plus-circle btn-icon"></i> Custom Booking
                                </button>
                            </a>
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
                    <div class="table-header">
                        <div class="table-input"><img src="<?php echo base_url('assets/asserts/search.png') ?>" alt="">
                            <input type="text" placeholder="Enter exam name.." id="searchExam">
                        </div>
                        <div>
                            <button class="py-2 px-3 border rounded bg-dark text-white exportBtn">Export
                                <img src="<?php echo base_url('assets/asserts/Download.png') ?>" alt=""></button>
                        </div>
                    </div>
                    <?php
                    $bookings = $activeBookings;
                    include(APPPATH . 'views/booking/partials/booking-table.php');
                    ?>
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
    <div class="paginationCnt">
        <div class="Matrix-table-cnt In-Review center">
            <div class="matrix-wrapper">
                <div class="col-4">
                    <div class="matrix-box total-bookings">
                        <div class="matrix-icon total-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="matrix-content">
                            <p>In Review</p>
                            <h2><?= count($inReviewBookings) ?>/<?= $total_booking_req_count ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Seats Booked -->
                <div class="col-4">
                    <div class="matrix-box seats-booked">
                        <div class="matrix-icon seats-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Seats Booked</p>
                            <h2><?= $number_of_seats ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box 3: Custom Booking + Edit Profile -->
                <div class="col-4">
                    <div class="matrix-box custom-booking-box">
                        <div class="custom-booking-btn-box">
                            <a href="<?php echo base_url('my-self-booking') ?>">
                                <button class="custom-btn">
                                    <i class="fas fa-plus-circle btn-icon"></i> Custom Booking
                                </button>
                            </a>
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
                    <div class="table-header">
                        <div class="table-input"><img src="<?php echo base_url('assets/asserts/search.png') ?>" alt="">
                            <input type="text" placeholder="Enter exam name.." id="searchExam2">
                        </div>
                        <div>
                            <button class="py-2 px-3 border rounded bg-dark text-white exportBtn2">Export
                                <img src="<?php echo base_url('assets/asserts/Download.png') ?>" alt="">
                            </button>
                        </div>
                    </div>
                    <?php
                    $bookings = $inReviewBookings;
                    include(APPPATH . 'views/booking/partials/booking-table.php');
                    ?>
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
    <div class="paginationCnt">
        <div class="Matrix-table-cnt confirm-bookings center">
            <div class="matrix-wrapper">
                <div class="col-4">
                    <div class="matrix-box total-bookings">
                        <div class="matrix-icon total-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Confirmed bookings</p>
                            <h2><?= count($confirmedBookings) ?>/<?= $total_booking_req_count ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Seats Booked -->
                <div class="col-4">
                    <div class="matrix-box seats-booked">
                        <div class="matrix-icon seats-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Seats Booked</p>
                            <h2><?= $number_of_seats ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Box 3: Custom Booking + Edit Profile -->
                <div class="col-4">
                    <div class="matrix-box custom-booking-box">
                        <div class="custom-booking-btn-box">
                            <a href="<?php echo base_url('my-self-booking') ?>">
                                <button class="custom-btn">
                                    <i class="fas fa-plus-circle btn-icon"></i> Custom Booking
                                </button>
                            </a>
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
                    <div class="table-header">
                        <div class="table-input"><img src="<?php echo base_url('assets/asserts/search.png') ?>" alt="">
                            <input type="text" placeholder="Enter exam name.." id="searchExam3">
                        </div>
                        <div>
                            <button class="py-2 px-3 border rounded bg-dark text-white exportBt3">Export
                                <img src="<?php echo base_url('assets/asserts/Download.png') ?>" alt="">
                            </button>
                        </div>
                    </div>
                    <?php
                    $bookings = $confirmedBookings;
                    include(APPPATH . 'views/booking/partials/booking-table.php');
                    ?>
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
    <div class="paginationCnt">
        <div class="Matrix-table-cnt reject-bookings center">
            <div class="matrix-wrapper">
                <div class="col-4">
                    <div class="matrix-box total-bookings">
                        <div class="matrix-icon total-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Rejected Bookings</p>
                            <h2><?= count($rejectedBookings) ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Seats Booked -->
                <div class="col-4">
                    <div class="matrix-box seats-booked">
                        <div class="matrix-icon seats-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Seats Booked</p>
                            <h2><?= $number_of_seats ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Box 3: Custom Booking + Edit Profile -->
                <div class="col-4">
                    <div class="matrix-box custom-booking-box">
                        <div class="custom-booking-btn-box">
                            <a href="<?php echo base_url('my-self-booking') ?>">
                                <button class="custom-btn">
                                    <i class="fas fa-plus-circle btn-icon"></i> Custom Booking
                                </button>
                            </a>
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
                    <!-- <div class="table-header"> -->
                    <!-- <div class="table-input">
                                <img src="<?php echo base_url('assets/asserts/search.png') ?>" alt="">
                                <input type="text" placeholder="Enter exam name.." id="searchExam4">
                            </div> -->
                    <!-- <div>
                                <button class="py-2 px-3 border rounded bg-dark text-white exportBt3">Export
                                    <img src="<?php echo base_url('assets/asserts/Download.png') ?>" alt="">
                                </button>
                            </div> -->
                    <!-- </div> -->
                    <?php
                    $bookings = $rejectedBookings;
                    include(APPPATH . 'views/booking/partials/booking-table.php');
                    ?>
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
    <div class="paginationCnt">
        <div class="Matrix-table-cnt postponded-bookings center">
            <div class="matrix-wrapper">
                <div class="col-4">
                    <div class="matrix-box total-bookings">
                        <div class="matrix-icon total-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Postponed Bookings</p>
                            <h2><?= count($postponedBookings) ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Seats Booked -->
                <div class="col-4">
                    <div class="matrix-box seats-booked">
                        <div class="matrix-icon seats-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="matrix-content">
                            <p>Seats Booked</p>
                            <h2><?= $number_of_seats ?></h2>
                        </div>
                        <div>
                            <select class="matrix-dropdown">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Box 3: Custom Booking + Edit Profile -->
                <div class="col-4">
                    <div class="matrix-box custom-booking-box">
                        <div class="custom-booking-btn-box">
                            <a href="<?php echo base_url('my-self-booking') ?>">
                                <button class="custom-btn">
                                    <i class="fas fa-plus-circle btn-icon"></i> Custom Booking
                                </button>
                            </a>
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
                    <!-- <div class="table-header"> -->
                    <!-- <div class="table-input">
                                <img src="<?php echo base_url('assets/asserts/search.png') ?>" alt="">
                                <input type="text" placeholder="Enter exam name.." id="searchExam4">
                            </div> -->
                    <!-- <div>
                                <button class="py-2 px-3 border rounded bg-dark text-white exportBt3">Export
                                    <img src="<?php echo base_url('assets/asserts/Download.png') ?>" alt="">
                                </button>
                            </div> -->
                    <!-- </div> -->
                    <?php
                    $bookings = $postponedBookings;
                    include(APPPATH . 'views/booking/partials/booking-table.php');
                    ?>
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
    <!-- //////////////// Matrix and table section end ////////////// -->
</div>

<!-- //////////////// Active bookings Modal start /////////////////-->
<div class="modal fade" id="projectDetailModal" tabindex="-1" aria-labelledby="bookingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="innerHtmlProjectDetail"></div>
    </div>
</div>
<!-- ////////////////// Active bookings modal end ////////////////-->


<!--///////////////// rejection modal start ////////////////////////-->
<div class="modal fade" id="rejectionModal" tabindex="-1" aria-hidden="true">
    <div class="innerHtmlRejectModal"></div>
</div>
<!--/////////////////// rejection modal end /////////////////////////-->

<!--///////////////// Negotiation modal start ////////////////////////-->
<div class="modal fade" id="negotiationModal" tabindex="-1" aria-hidden="true">
    <div class="innerHtmlNegotiationModal"></div>
</div>
<!--/////////////////// Negotiation modal end /////////////////////////-->
</div>
<!-- =================================My Booking=========================== -->


<!-- /////////////////////////// Setting section start //////////////////// -->
<div class="booking-center Settings-section">
    <h2>Settings</h2>
</div>
<!-- /////////////////////////// Setting section end //////////////////// -->

<!-- ////////////////////////// Help section start ///////////////////// -->
<div class="booking-center help-section">
    <h2>Help-Supports</h2>
</div>
<!-- ////////////////////////// Help section end ///////////////////// -->

<script>
    // All Bookings search
    $('#searchExam').on('keyup', function() {
        var search = $(this).val();
        $.ajax({
            url: "<?= base_url('booking/DashboardController/searchBookingRequest') ?>",
            type: "POST",
            data: {
                search: search,
                type: 'all'
            },
            success: function(response) {
                $('#dataTable tbody').html(response);
            }
        });
    });

    // In Review search
    $('#searchExam2').on('keyup', function() {
        var search = $(this).val();
        $.ajax({
            url: "<?= base_url('booking/DashboardController/searchBookingRequest') ?>",
            type: "POST",
            data: {
                search: search,
                type: 'inreview'
            },
            success: function(response) {
                $('#dataTable2 tbody').html(response);
            }
        });
    });

    // Confirmed search
    $('#searchExam3').on('keyup', function() {
        var search = $(this).val();
        $.ajax({
            url: "<?= base_url('booking/DashboardController/searchBookingRequest') ?>",
            type: "POST",
            data: {
                search: search,
                type: 'confirmed'
            },
            success: function(response) {
                $('#dataTable3 tbody').html(response);
            }
        });
    });

    // Export buttons
    $('.exportBtn').on('click', function() {
        var search = $('#searchExam').val();
        window.location.href = "<?= base_url('booking/DashboardController/exportBookingRequest') ?>?search=" + search + "&type=all";
    });
    $('.exportBtn2').on('click', function() {
        var search = $('#searchExam2').val();
        window.location.href = "<?= base_url('booking/DashboardController/exportBookingRequest') ?>?search=" + search + "&type=inreview";
    });
    $('.exportBt3').on('click', function() {
        var search = $('#searchExam3').val();
        window.location.href = "<?= base_url('booking/DashboardController/exportBookingRequest') ?>?search=" + search + "&type=confirmed";
    });
</script>