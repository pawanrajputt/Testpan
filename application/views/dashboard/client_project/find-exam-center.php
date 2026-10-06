<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a> /
                        <a href="<?= base_url('admin/client-project-detail-list/' . $encodedProjectId) ?>">
                            Project Detailing
                        </a> /
                    </span>
                    <?= $page_title ?> (Project Name : <?= $project->exam_name ?>)
                </h4>

            </div>
        </div>
        
        <div class="mb-4">
            <?php

            $this->load->view(

                'dashboard/client_project/common/project_batch_statistics',

                [
                    'batchStatistics' => $batchStatistics
                ]

            );

            ?>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="get">
                    <div class="row g-3">

                        <!-- Center Name -->
                        <div class="col-md-4">
                            <label class="form-label">Center Name</label>
                            <input type="text"
                                name="center_name"
                                class="form-control"
                                placeholder="Seach By Center Name"
                                value="<?= $filters['center_name'] ?>">
                        </div>

                        <!-- Capacity -->
                        <div class="col-md-4">
                            <label class="form-label">No. of System</label>
                            <input type="number"
                                name="capacity"
                                class="form-control"
                                placeholder="No. of System"
                                value="<?= $filters['capacity'] ?>">
                        </div>

                        <!-- Owner -->
                        <div class="col-md-4">
                            <label class="form-label">Owner</label>
                            <input type="text"
                                name="owner"
                                class="form-control"
                                placeholder="Owner Name / Email / Mobile"
                                value="<?= $filters['owner'] ?>">
                        </div>
                         
                        <!-- Subscription Status -->
                        <div class="col-md-4">
                            <label class="form-label">Subscription</label>
                            <select name="subscription_status" class="form-select select2">
                                <option value="">All Centers</option>
                                <option value="1" <?= ($filters['subscription_status'] == '1') ? 'selected' : '' ?>>
                                    Subscribed
                                </option>
                                <option value="0" <?= ($filters['subscription_status'] == '0') ? 'selected' : '' ?>>
                                    Non-Subscribed
                                </option>
                            </select>
                        </div>

                        <!-- City (locked, project based) -->
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <select class="form-select" disabled>
                                <?= $this->common_options->get_city_list($cityId); ?>
                            </select>
                        </div>


                        <!-- Monitor -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">Monitor</label>
                            <select name="monitor_type" class="form-select">
                                <option value="">All</option>
                                <option value="LCD" <?= ($filters['monitor_type'] == 'LCD' ? 'selected' : '') ?>>
                                    LCD
                                </option>
                                <option value="LED" <?= ($filters['monitor_type'] == 'LED' ? 'selected' : '') ?>>
                                    LED
                                </option>
                            </select>
                        </div> -->

                        <!-- RAM -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">RAM</label>
                            <select name="ram" class="form-select">
                                <option value="">All</option>
                                <?php foreach (['2GB', '4GB', '8GB', '16GB'] as $r): ?>
                                    <option value="<?= $r ?>" <?= ($filters['ram'] == $r ? 'selected' : '') ?>>
                                        <?= $r ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        <!-- Switch Category -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">Switch Category</label>
                            <select name="switch_category" class="form-select">
                                <option value="">All</option>
                                <option value="unmanaged" <?= ($filters['switch_category'] == 'unmanaged' ? 'selected' : '') ?>>
                                    Unmanaged
                                </option>
                                <option value="smart" <?= ($filters['switch_category'] == 'smart' ? 'selected' : '') ?>>
                                    Smart
                                </option>
                                <option value="managedL2" <?= ($filters['switch_category'] == 'managedL2' ? 'selected' : '') ?>>
                                    Managed L2
                                </option>
                                <option value="managedL3" <?= ($filters['switch_category'] == 'managedL3' ? 'selected' : '') ?>>
                                    Managed L3
                                </option>
                            </select>
                        </div> -->

                        <!-- HDD -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">HDD</label>
                            <select name="hdd" class="form-select">
                                <option value="">All</option>
                                <?php foreach (['128GB', '256GB', '512GB', '1TB'] as $h): ?>
                                    <option value="<?= $h ?>" <?= ($filters['hdd'] == $h ? 'selected' : '') ?>>
                                        <?= $h ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        <!-- OS -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">Operating System</label>
                            <select name="operating_system" class="form-select">
                                <option value="">All</option>
                                <option value="Windows" <?= ($filters['operating_system'] == 'Windows' ? 'selected' : '') ?>>
                                    Windows
                                </option>
                                <option value="Linux" <?= ($filters['operating_system'] == 'Linux' ? 'selected' : '') ?>>
                                    Linux
                                </option>
                                <option value="MacOS" <?= ($filters['operating_system'] == 'MacOS' ? 'selected' : '') ?>>
                                    MacOS
                                </option>
                            </select>
                        </div> -->

                        <!-- Ethernet Company -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">Switch Brand</label>
                            <select name="ethernet_company" class="form-select">
                                <option value="">All</option>
                                <?php foreach (['Cisco', 'Netgear', 'D-Link', 'TP-Link'] as $b): ?>
                                    <option value="<?= $b ?>" <?= ($filters['ethernet_company'] == $b ? 'selected' : '') ?>>
                                        <?= $b ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        <!-- Ethernet Ports -->
                        <!-- <div class="col-md-2">
                            <label class="form-label">Switch Ports</label>
                            <select name="no_of_each_ethernet_ports" class="form-select">
                                <option value="">All</option>
                                <?php foreach ([8, 16, 24] as $p): ?>
                                    <option value="<?= $p ?>" <?= ($filters['no_of_each_ethernet_ports'] == $p ? 'selected' : '') ?>>
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        <!-- Buttons -->
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                Apply Filters
                            </button>
                            <a href="<?= current_url() ?>" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Center</th>
                            <th class="text-center">Labs / Systems</th>
                            <th class="text-center">Availability</th>
                            <th class="text-center">Request</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($manage_project_infos)): ?>
                            <?php foreach ($manage_project_infos as $row): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            <?= $row['center_name'] ?>
                                            <br>
                                            <small>Owner Name: <?= $row['owner_name'] ?></small><br>
                                            <small>Owner Email: <?= $row['owner_email'] ?></small><br>
                                            <small>Owner Mobile: <?= $row['owner_phone'] ?></small><br>
                                            <?php if (!empty($row['package_name'])): ?>

                                                <div class="mt-1">

                                                    <span class="badge bg-warning">
                                                        ⭐ <?= $row['package_name'] ?>
                                                    </span>

                                                    <?php if ($row['verified_badge'] == 1): ?>

                                                        <span class="badge bg-primary">
                                                            ✓ Verified Partner
                                                        </span>

                                                    <?php endif; ?>

                                                </div>

                                                <small class="text-success">
                                                    Subscription Active
                                                </small>

                                            <?php else: ?>

                                                <div class="mt-1">
                                                    <span class="badge bg-secondary">
                                                        No Subscription
                                                    </span>
                                                </div>

                                            <?php endif; ?>

                                            <?php if (!empty($row['package_name'])): ?>

                                                <br>

                                                <small class="text-muted">
                                                    Booking Limit:
                                                    <?= $row['max_bookings'] == -1
                                                        ? 'Unlimited'
                                                        : $row['max_bookings'] ?>
                                                </small>

                                            <?php endif; ?>

                                            <?php if (!empty($row['expiry_date'])): ?>

                                                <br>

                                                <small class="text-muted">
                                                    Exp:
                                                    <?= date('d M Y', strtotime($row['expiry_date'])) ?>
                                                </small>

                                            <?php endif; ?>

                                            <small class="text-muted">
                                                <?= $this->common_options->get_city_name($row['city_id']) ?>
                                            </small>
                                        </div>

                                        <?php if ($row['admin_status'] == 2): ?>

                                            <span class="badge bg-danger">
                                                Admin Rejected
                                            </span>

                                        <?php endif; ?>

                                        <?php if ($row['admin_status'] == 3): ?>

                                            <span class="badge bg-secondary">
                                                On Hold
                                            </span>

                                        <?php endif; ?>

                                        <?php if ($row['admin_status'] == 4): ?>

                                            <span class="badge bg-dark">
                                                Not Required
                                            </span>

                                        <?php endif; ?>

                                        <?php if ($row['client_status'] == 2): ?>

                                            <span class="badge bg-danger">
                                                Client Rejected
                                            </span>

                                        <?php elseif ($row['exam_center_status'] == 2): ?>

                                            <span class="badge bg-danger">
                                                Center Rejected
                                            </span>

                                        <?php endif; ?>

                                        <?php if ($row['exam_center_status'] == 3): ?>

                                            <span class="badge bg-info">
                                                Center Price Negotiation
                                            </span>

                                        <?php endif; ?>

                                        <?php if (!empty($row['reject_comment'])): ?>

                                            <div class="small text-danger mt-1">
                                                Note: <?= $row['reject_comment'] ?>
                                            </div>

                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $row['total_no_lab'] ?> labs/<?= $row['total_no_system'] ?> systems
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        $badge = match ($row['booking_status']) {
                                            'Project Booking' => 'warning',
                                            'Self Booking'    => 'info',
                                            'Not Available'    => 'danger',
                                            default           => 'success'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $badge ?>">
                                            <?= $row['booking_status'] ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <?php

                                        if ($row['client_status'] == 2) {

                                            echo '<span class="badge bg-danger">
                                                    Client Rejected
                                                  </span>';
                                        } elseif ($row['exam_center_status'] == 2) {

                                            echo '<span class="badge bg-danger">
                                                    Center Rejected
                                                  </span>';
                                        } elseif ($row['admin_status'] == 2) {

                                            echo '<span class="badge bg-danger">
                                                    Admin Rejected
                                                  </span>';
                                        } elseif ($row['admin_status'] == 3) {

                                            echo '<span class="badge bg-secondary">
                                                    On Hold
                                                  </span>';
                                        } elseif ($row['admin_status'] == 4) {

                                            echo '<span class="badge bg-dark">
                                                    Not Required
                                                  </span>';
                                        } elseif (
                                            $row['exam_center_status'] == 1
                                            &&
                                            $row['admin_status'] == 1
                                            &&
                                            $row['client_status'] == 1
                                        ) {

                                            echo '<span class="badge bg-success">
                                        Assigned
                                      </span>';
                                        } elseif (
                                            $row['request_status'] == 1
                                        ) {

                                            echo '<span class="badge bg-warning">
                                        Request Sent
                                      </span>';
                                        } else {

                                            echo '<span class="badge bg-info">
                                        Not Requested Yet
                                      </span>';
                                        }

                                        ?>

                                    </td>

                                    <td class="text-center">
                                        <?php $allowResend = (
                                            $row['client_status'] == 2
                                            ||
                                            $row['exam_center_status'] == 2
                                            ||
                                            $row['admin_status'] == 2
                                        );
                                        ?>
                                        <?php

                                        if (
                                            $allowResend
                                        ) {
                                        ?>

                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-warning send-booking-request mb-2"
                                                data-url="<?= base_url(
                                                                'admin/send-booking-request/' .
                                                                    $encodedProjectId . '/' .
                                                                    $cityId . '/' .
                                                                    $row['center_id']
                                                            ) ?>"
                                                data-price="<?= $project->admin_price_per_seat ?>"

                                                data-capacity="<?= $row['capacity'] ?>"

                                                data-batches='<?= json_encode($project_batches) ?>'>

                                                Send Again

                                            </a>

                                        <?php
                                        } elseif (
                                            $row['booking_status'] === 'Available'
                                            &&
                                            empty($row['request_status'])
                                        ) {
                                        ?>

                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-success send-booking-request"

                                                data-url="<?= base_url(
                                                                'admin/send-booking-request/' .
                                                                    $encodedProjectId . '/' .
                                                                    $cityId . '/' .
                                                                    $row['center_id']
                                                            ) ?>"

                                                data-price="<?= $project->admin_price_per_seat ?>"

                                                data-capacity="<?= $row['capacity'] ?>"

                                                data-batches='<?= json_encode($project_batches) ?>'>

                                                Send Request

                                            </a>

                                        <?php
                                        }
                                        ?>

                                        <a target="_blank"
                                            href="<?= base_url('admin/view-exam-center/' . $row['center_id']) ?>"
                                            class="btn btn-sm btn-primary mb-2">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No centers found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->


<!-- Modal for sending booking request -->
<div class="modal fade"
    id="bookingRequestModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5>

                    Send Booking Request

                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div id="batchSeatContainer">

                </div>

                <hr>

                <div class="mb-3">

                    <label>

                        Admin Price

                    </label>

                    <input
                        type="number"
                        id="modal_admin_price"
                        class="form-control">

                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    class="btn btn-success"
                    id="btnSendBookingRequest">

                    Send Request

                </button>

            </div>

        </div>

    </div>

</div>

<script>
    let bookingUrl = "";
    let centerCapacity = 0;

    $(document).on("click", ".send-booking-request", function() {

        bookingUrl = $(this).data("url");
        centerCapacity = parseInt($(this).data("capacity"));
        let price = $(this).data("price");
        let batches = $(this).data("batches");

        $("#modal_admin_price").val(price);

        let html = "";

        let totalRequired = 0;

        batches.forEach(function(batch) {

            totalRequired += parseInt(batch.seat);

            html += `

        <div class="card mb-3">

            <div class="card-header bg-light">

                <strong>Batch ${batch.batch_no}</strong>

            </div>

            <div class="card-body mt-3">

                <div class="row">

                    <div class="col-md-4">

                        <label>Required Seat</label>

                        <input
                            type="number"
                            class="form-control"
                            value="${batch.seat}"
                            readonly>

                    </div>

                    <div class="col-md-4">

                        <label>Assign Seat</label>

                        <input
                            type="number"
                            class="form-control assign-seat"
                            data-required="${batch.seat}"
                            value="${batch.seat}"
                            min="0">

                    </div>

                    <div class="col-md-4">

                        <label>Timing</label>

                        <input
                            type="text"
                            class="form-control"
                            readonly
                            value="${batch.batch_start} - ${batch.batch_end}">

                    </div>

                </div>

            </div>

        </div>

        `;

        });

        html += `

    <div class="alert alert-info mt-3">

        <strong>

            Total Assigned :

        </strong>

        <span id="assignedTotal">

            ${totalRequired}

        </span>

        /

        ${centerCapacity}

    </div>

    `;

        $("#batchSeatContainer").html(html);

        $("#bookingRequestModal").modal("show");

    });



    $(document).on("input", ".assign-seat", function() {

        let total = 0;

        $(".assign-seat").each(function() {

            total += parseInt($(this).val()) || 0;

        });

        $("#assignedTotal").text(total);

    });



    $("#btnSendBookingRequest").click(function() {

        let totalAssigned = 0;

        let batchData = [];

        let valid = true;

        $(".assign-seat").each(function(index) {

            let seat = parseInt($(this).val()) || 0;

            let required = parseInt($(this).data("required"));

            totalAssigned += seat;

            if (seat > required) {

                toastr.error("Assigned seat cannot exceed required seat.");

                valid = false;

                return false;

            }

            batchData.push({

                batch_no: index + 1,

                required_seat: required,

                center_seat: seat

            });

        });

        if (!valid) {

            return;

        }

        $("#btnSendBookingRequest")
            .prop("disabled", true)
            .text("Please Wait...");

        $.ajax({

            url: bookingUrl,

            type: "POST",

            data: {

                admin_price: $("#modal_admin_price").val(),

                center_seat: totalAssigned,

                batch_data: JSON.stringify(batchData)

            },

            dataType: "json",

            success: function(res) {

                $("#btnSendBookingRequest")
                    .prop("disabled", false)
                    .text("Send Request");

                if (res.status == "pass") {

                    toastr.success(res.message);

                    $("#bookingRequestModal").modal("hide");

                    setTimeout(function() {

                        location.reload();

                    }, 800);

                } else {

                    toastr.error(res.message);

                }

            },

            error: function() {

                $("#btnSendBookingRequest")
                    .prop("disabled", false)
                    .text("Send Request");

                toastr.error("Something went wrong.");

            }

        });

    });
</script>