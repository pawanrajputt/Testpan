<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashbaord</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
        </div>


        <div class="card">

            <div class="row mb-4">

                <!-- Booking Summary -->
                <div class="col-lg-3 mb-3">

                    <div class="card shadow-sm h-100">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <strong>Booking Summary</strong>

                            <span class="badge bg-primary">
                                <?= $booking_summary['completion'] ?>% Complete
                            </span>

                        </div>

                        <div class="card-body mt-5">

                            <div class="row text-center">

                                <div class="col">

                                    <h4><?= number_format($booking_summary['required_seats']) ?></h4>

                                    <small class="text-muted">
                                        Required Seats
                                    </small>

                                </div>

                                <div class="col">

                                    <h4 class="text-success">
                                        <?= number_format($booking_summary['allocated_seats']) ?>
                                    </h4>

                                    <small class="text-muted">
                                        Allocated
                                    </small>

                                </div>

                                <div class="col">

                                    <h4 class="text-danger">
                                        <?= number_format($booking_summary['remaining_seats']) ?>
                                    </h4>

                                    <small class="text-muted">
                                        Remaining
                                    </small>

                                </div>

                                <div class="col">

                                    <h4>
                                        <?= $booking_summary['approved_centers'] ?>
                                    </h4>

                                    <small class="text-muted">
                                        Approved
                                    </small>

                                </div>

                                <div class="col">

                                    <h4>
                                        <?= $booking_summary['pending_centers'] ?>
                                    </h4>

                                    <small class="text-muted">
                                        Pending
                                    </small>

                                </div>

                                <div class="col">

                                    <h4>
                                        <?= $booking_summary['total_centers'] ?>
                                    </h4>

                                    <small class="text-muted">
                                        Total Centers
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Financial Summary -->

                <div class="col-lg-9 mb-3">

                    <?php

                    $statusText = "No Negotiation";
                    $statusClass = "secondary";

                    switch ($booking_summary['negotiation_status']) {
                        case 0:

                            $label = 'No Negotiation';
                            $class = 'secondary';

                            break;

                        case 1:
                            $statusText = "Client Requested";
                            $statusClass = "warning";
                            break;

                        case 2:
                            $statusText = "Admin Counter";
                            $statusClass = "info";
                            break;

                        case 3:
                            $statusText = "Finalized";
                            $statusClass = "success";
                            break;

                        case 4:
                            $statusText = "Cancelled";
                            $statusClass = "danger";
                            break;
                    }

                    ?>

                    <div class="card shadow-sm border-success h-100">

                        <div class="card-header d-flex justify-content-between">

                            <strong>
                                Financial Summary
                            </strong>

                            <span class="badge bg-<?= $statusClass ?>">
                                <?= $statusText ?>
                            </span>

                        </div>

                        <div class="card-body">

                            <table class="table table-borderless mb-0">

                                <tr>

                                    <td>
                                        Original Client Amount
                                    </td>

                                    <td class="text-end fw-bold">

                                        ₹<?= number_format(
                                                $booking_summary['client_original_amount']
                                            ) ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Original Client Rate / Seat

                                    </td>

                                    <td class="text-end fw-bold">

                                        ₹<?= number_format(
                                                $booking_summary['original_client_rate'],
                                                2
                                            ) ?>

                                    </td>

                                </tr>

                                <?php if (
                                    $booking_summary['admin_client_final_amount']
                                    !=
                                    $booking_summary['client_original_amount']
                                ) { ?>

                                    <tr>

                                        <td>

                                            Final Client Amount

                                        </td>

                                        <td class="text-end fw-bold text-primary">

                                            ₹<?= number_format(
                                                    $booking_summary['admin_client_final_amount']
                                                ) ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                                <?php if (
                                    $booking_summary['admin_client_final_amount']
                                    !=
                                    $booking_summary['client_original_amount']
                                ) { ?>

                                    <tr>

                                        <td>

                                            Final Client Rate / Seat

                                        </td>

                                        <td class="text-end fw-bold text-primary">

                                            ₹<?= number_format(
                                                    $booking_summary['final_client_rate'],
                                                    2
                                                ) ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                                <tr>

                                    <td>

                                        Center Cost

                                    </td>

                                    <td class="text-end fw-bold">

                                        ₹<?= number_format(
                                                $booking_summary['center_amount']
                                            ) ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Total Center Seats

                                    </td>

                                    <td class="text-end fw-bold">

                                        <?= number_format(
                                            $booking_summary['allocated_seats']
                                        ) ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Center Avg. Rate / Seat

                                    </td>

                                    <td class="text-end fw-bold">

                                        ₹<?= number_format(
                                                $booking_summary['center_avg_rate'],
                                                2
                                            ) ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Expected Profit

                                    </td>

                                    <td class="text-end fw-bold">

                                        <?php if ($booking_summary['expected_profit'] >= 0) { ?>

                                            <span class="text-success">

                                                ₹<?= number_format(
                                                        $booking_summary['expected_profit']
                                                    ) ?>

                                            </span>

                                        <?php } else { ?>

                                            <span class="text-danger">

                                                -₹<?= number_format(
                                                        abs($booking_summary['expected_profit'])
                                                    ) ?>

                                            </span>

                                        <?php } ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Margin %

                                    </td>

                                    <td class="text-end fw-bold">

                                        <?php

                                        $cls =
                                            $booking_summary['margin_percent'] >= 0
                                            ?
                                            'success'
                                            :
                                            'danger';

                                        ?>

                                        <span class="text-<?= $cls ?>">

                                            <?= $booking_summary['margin_percent'] ?>%

                                        </span>

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mb-4">

                <button style="float:right;margin-right: 10px;"
                    class="btn btn-warning"

                    id="btnClientNegotiation">

                    <i class="fa fa-comments"></i>

                    Client Negotiation

                </button>

            </div>

            <div class="table-responsive booking-table-wrapper">
                <table class="table table-striped">
                    <thead class="table table-striped table-hover align-middle booking-table table-primary-custom">
                        <tr>

                            <th style="min-width:290px">
                                Project Details
                            </th>

                            <th style="min-width:240px">
                                Center Details
                            </th>

                            <th style="min-width:140px">
                                Price (₹)
                            </th>

                            <th style="min-width:130px">
                                Client Status
                            </th>

                            <th style="min-width:130px">
                                Center Status
                            </th>

                            <th style="min-width:130px">
                                Admin Status
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($booking_requests) > 0) {

                            foreach ($booking_requests as $row): ?>

                                <tr>
                                    <td class="fw-semibold">
                                        <?= ucwords($row['exam_name']) ?>
                                        <br>
                                        <small><strong>Project ID:</strong>
                                            <?= ucwords($row['project_id']) ?>
                                        </small>
                                        <br>
                                        <small><strong>Client:</strong>
                                            <?= ucwords($row['client_name']) ?>
                                        </small>
                                        <br>
                                        <small><strong>Seats:</strong>
                                            <?= ucwords($row['number_of_seats']) ?>
                                        </small>
                                        <br>
                                        <small><strong>Date:</strong>
                                            <?= date('d M Y', strtotime($row['start_date'])) ?> to
                                            <?= date('d M Y', strtotime($row['end_date'])) ?>
                                        </small>
                                    </td>

                                    <td>

                                        <?= htmlspecialchars(ucwords($row['center_name'])) ?>

                                        <?php if (!empty($row['package_name'])) { ?>

                                            <br>

                                            <span class="badge bg-warning">
                                                <?= $row['package_name'] ?>
                                            </span>

                                            <?php if ($row['verified_badge'] == 1) { ?>

                                                <span class="badge bg-primary">
                                                    Verified Partner
                                                </span>

                                            <?php } ?>

                                        <?php } else { ?>

                                            <br>

                                            <span class="badge bg-secondary">
                                                No Subscription
                                            </span>

                                        <?php } ?>

                                        <br>

                                        <small>
                                            <strong>City:</strong>
                                            <?= ucwords($row['city_name']) ?>
                                        </small>

                                        <br>

                                        <small>
                                            <strong>Total System:</strong>
                                            <?= $row['total_no_lab'] ?>/<?= $row['total_no_system'] ?>
                                        </small>

                                        <br>

                                        <small class="text-primary fw-bold">
                                            <strong>Requested Seats:</strong>
                                            <?= number_format($row['center_seat']) ?>
                                        </small>

                                    </td>

                                    <td>
                                        <!-- CLIENT PRICE -->
                                        <div>
                                            <small class="text-muted">By Client:</small>
                                            ₹
                                            <?= number_format($row['price_per_seat'], 2) ?>
                                        </div>

                                        <!-- ADMIN BASE PRICE -->
                                        <div>
                                            <small class="text-muted">Admin To Center :</small>
                                            ₹
                                            <?= number_format($row['admin_center_final_price'], 2) ?>
                                        </div>

                                        <?php if ($row['exam_center_status'] == 3 && !empty($row['negotiate'])): ?>
                                            <!-- CENTER NEGOTIATED PRICE -->
                                            <div class="text-warning fw-semibold">
                                                Center Asked: ₹
                                                <?= number_format($row['negotiate'], 2) ?>
                                            </div>

                                        <?php elseif (in_array($row['exam_center_status'], [4, 1]) && !empty($row['admin_center_final_price'])): ?>
                                            <!-- FINAL ADMIN PRICE -->
                                            <div class="text-success fw-semibold">
                                                Final: ₹
                                                <?= number_format($row['admin_center_final_price'], 2) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>



                                    <!-- Client Status -->
                                    <td class="text-center">
                                        <?php
                                        if ($row['client_status'] == 1) {
                                            echo '<span class="badge bg-success">Approved</span>';
                                        } elseif ($row['client_status'] == 2) {
                                            echo '<span class="badge bg-danger">Rejected</span>';
                                        } else {
                                            echo '<span class="badge bg-warning">Pending</span>';
                                        }
                                        ?>
                                    </td>

                                    <!-- Center Status + Reason -->
                                    <td class="text-center">
                                        <?php
                                        if ($row['exam_center_status'] == 1) {
                                            echo '<span class="badge bg-success">Approved</span>';
                                        } elseif ($row['exam_center_status'] == 2) {
                                            echo '<span class="badge bg-danger">Rejected</span>';
                                            echo
                                            '<div class= small text-danger>' . $row->comment . '</div>';
                                        } else {
                                            echo '<span class="badge bg-warning">Pending</span>';
                                        }
                                        ?>

                                        <?php if ($row['exam_center_status'] == 2): ?>
                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-info view-reason"
                                                    data-reason="<?= htmlspecialchars($row['reason'] ?? '') ?>"
                                                    data-comment="<?= htmlspecialchars($row['comment'] ?? '') ?>"
                                                    data-negotiate="<?= htmlspecialchars($row['negotiate'] ?? '') ?>">
                                                    View Reason
                                                    <?php
                                                    if (
                                                        !empty($row['negotiate']) &&
                                                        strpos($row['reason'], 'Price is not up to the mark') !== false
                                                    ) {
                                                        echo '<span class="text-warning ms-1">(Negotiate)</span>';
                                                    }
                                                    ?>
                                                </button>
                                            </div>
                                        <?php endif; ?>


                                        <?php if ($row['exam_center_status'] == 3): ?>
                                            <button class="btn btn-sm btn-primary revise-price-btn mt-2" data-id="<?= $row['id'] ?>"
                                                data-price="<?= $row['negotiate'] ?>">
                                                Revise Price
                                            </button>
                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php

                                        switch ((int)
                                        $row['admin_status']) {

                                            case 1:

                                                echo
                                                '<span class="badge bg-success">Approved</span>';

                                                break;

                                            case 2:

                                                echo
                                                '<span class="badge bg-danger">Rejected</span>';

                                                break;

                                            case 3:

                                                echo
                                                '<span class="badge bg-warning">Hold</span>';

                                                break;

                                            case 4:

                                                echo
                                                '<span class="badge bg-secondary">Not Required</span>';

                                                break;

                                            default:

                                                echo
                                                '<span class="badge bg-info">Pending</span>';
                                        }

                                        ?>

                                    </td>
                                </tr>

                            <?php endforeach;
                        } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">No Record Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<!-- Client Price Modal -->
<div
    class="modal fade"
    id="clientNegotiationModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5>

                    Client Negotiation

                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="project_id"
                    value="<?= $this->uri->segment(3) ?>">

                <input
                    type="hidden"
                    id="city_id"
                    value="<?= $cityId ?>">

                <div class="mb-3">

                    <label class="form-label">

                        Original Client Amount

                    </label>

                    <div class="border rounded p-3 bg-light">

                        <h4 class="mb-0 text-primary">

                            ₹<?= number_format($booking_summary['client_original_amount'], 2) ?>

                        </h4>

                    </div>

                </div>

                <hr>

                <div class="mb-3">

                    <label>

                        Final Amount

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            ₹

                        </span>

                        <input
                            type="number"
                            id="final_amount"
                            class="form-control"
                            value="<?= $booking_summary['admin_client_final_amount'] ?>">

                    </div>

                </div>

                <div class="mb-3">

                    <label>

                        Remark

                    </label>

                    <textarea

                        id="client_remark"

                        class="form-control"

                        rows="4"><?= $booking_summary['negotiation_remark'] ?></textarea>

                </div>

                <button
                    class="btn btn-dark"

                    id="loadHistory">

                    Negotiation History

                </button>

                <div
                    id="historyArea"

                    class="mt-3">

                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close

                </button>

                <?php

                $status =
                    $booking_summary['client_negotiation_status'];

                ?>

                <?php if ($status == 1) { ?>

                    <button
                        id="btnCounterOffer"
                        class="btn btn-warning">

                        Counter Offer

                    </button>

                    <button
                        id="btnFinalize"
                        class="btn btn-success">

                        Finalize

                    </button>

                <?php } ?>

                <?php if ($status == 0 || $status == 2) { ?>

                    <button
                        id="saveClientNegotiation"
                        class="btn btn-success">

                        Save

                    </button>

                    <button
                        id="btnAcceptOffer"
                        class="btn btn-success">

                        Accept Offer

                    </button>

                <?php } ?>

                <?php if ($status == 3) { ?>

                    <button
                        class="btn btn-success"
                        disabled>

                        Finalized

                    </button>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<script>
    $('#btnClientNegotiation').click(function() {

        $('#clientNegotiationModal').modal('show');

    });


    $('#saveClientNegotiation').click(function() {

        $.ajax({

            url: "<?= base_url('admin/save-client-negotiation') ?>",

            type: 'POST',

            data: {

                project_id: atob(
                    $('#project_id')
                    .val()
                    .replace(/-/g, '+')
                    .replace(/_/g, '/')
                ),

                city_id: $('#city_id').val(),

                final_amount: $('#final_amount').val(),

                remark: $('#client_remark').val()

            },

            success: function(res) {

                let response =
                    JSON.parse(res);

                if (response.status) {

                    toastr.success(response.message);

                    setTimeout(function() {
                        location.reload();
                    }, 1500); // 1.5 seconds

                } else {

                    toastr.error(response.message);

                }

            }

        });

    });
</script>

<script>
    $('#loadHistory').click(function() {

        $.ajax({

            url: "<?= base_url('admin/client-negotiation-history') ?>",

            type: 'POST',

            data: {

                project_id: $('#project_id').val(),

                city_id: $('#city_id').val()

            },

            success: function(res) {

                let history = JSON.parse(res);

                let html = '';

                if (history.length == 0) {

                    html =
                        '<div class="alert alert-info">No Negotiation Yet</div>';

                }

                history.forEach(function(item) {

                    html += `

                    <div class="timeline-item mb-3">

                    <div class="card">

                    <div class="card-body">

                    <h6>

                    ₹${item.old_price}

                    →

                    ₹${item.new_price}

                    </h6>

                    <small>

                    ${item.remark}

                    </small>

                    <br>

                    <small class="text-muted">

                    By

                    ${item.username}

                    <br>

                    ${item.created_at}

                    </small>

                    </div>

                    </div>

                    </div>

                    `;

                });

                $('#historyArea').html(html);

            }

        });

    });
</script>

<script>
    $('#resetNegotiation').click(function() {

        if (!confirm('Reset negotiation?'))

            return;

        $.post(

            "<?= base_url('admin/reset-client-negotiation') ?>",

            {

                project_id: $('#project_id').val(),

                city_id: $('#city_id').val()

            },

            function() {

                location.reload();

            }

        );

    });
</script>

<script>
    $("#btnCounterOffer").click(function() {

        if (!confirm("Send counter offer to client?")) {
            return false;
        }

        $.ajax({

            url: "<?= base_url('admin/client-counter-negotiation') ?>",

            type: "POST",

            dataType: "json",

            data: {

                project_id: $("#project_id").val(),

                city_id: $("#city_id").val(),

                final_amount: $("#final_amount").val(),

                remark: $("#client_remark").val()

            },

            success: function(res) {

                if (res.status) {

                    toastr.success(res.message);

                    setTimeout(function() {
                        location.reload();
                    }, 1500);

                } else {

                    toastr.error(res.message);

                }

            }

        });

    });
</script>

<script>
    $("#btnFinalize").click(function() {

        if (!confirm("Finalize this negotiation?")) {
            return false;
        }

        $.ajax({

            url: "<?= base_url('admin/client-finalize-negotiation') ?>",

            type: "POST",

            dataType: "json",

            data: {

                project_id: $("#project_id").val(),

                city_id: $("#city_id").val()

            },

            success: function(res) {

                if (res.status) {

                    toastr.success(res.message);

                    setTimeout(function() {
                        location.reload();
                    }, 1500);

                } else {

                    toastr.error(res.message);

                }
            }

        });

    });
</script>

<script>
    $("#btnAcceptOffer").click(function() {

        Swal.fire({
            title: "Accept Client Offer?",
            text: "This action will finalize the negotiation.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Accept"
        }).then((result) => {

            if (!result.isConfirmed)
                return;

            $.post(
                base_url + "dashboard/accept-client-negotiation", {
                    project_id: $("#project_id").val(),
                    city_id: $("#city_id").val()
                },
                function(res) {

                    if (res.status) {

                        Swal.fire(
                            "Success",
                            res.message,
                            "success"
                        ).then(() => {

                            location.reload();

                        });

                    } else {

                        Swal.fire(
                            "Error",
                            res.message,
                            "error"
                        );

                    }

                },
                "json"
            );

        });

    });
</script>