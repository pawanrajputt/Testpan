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
            <?php

            $currentUrl = base_url(
                'admin/booking-request-status/' .
                    $this->uri->segment(3) . '/' .
                    $this->uri->segment(4)
            );

            ?>

            <?php $this->load->view('dashboard/client_project/common/project_change_log', ['changeLogs' => $changeLogs]); ?>

            <div class="mb-3">

                <button id="bulkApprove" class="btn btn-success bulk-approve-btn">
                    <i class="fa fa-check"></i>
                    Bulk Approve
                </button>

                <a href="<?= $currentUrl ?>?type=rejected"
                    class="btn bulk-approve-btn <?= ($currentType == 'rejected')
                                                    ? 'btn-danger'
                                                    : 'btn-outline-danger' ?>">

                    Rejected List

                </a>

                <a href="<?= $currentUrl ?>?type=current"
                    class="btn bulk-approve-btn <?= ($currentType == 'current' || empty($currentType))
                                                    ? 'btn-primary'
                                                    : 'btn-outline-primary' ?>">

                    Current List

                </a>

            </div>

            <div class="table-responsive booking-table-wrapper">
                <table class="table table-striped">
                    <thead class="table table-striped table-hover align-middle booking-table table-primary-custom">
                        <tr>

                            <th width="50">
                                <input type="checkbox" id="selectAll">
                            </th>

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

                            <th style="min-width:160px">
                                Action
                            </th>

                            <th style="min-width:220px">
                                Admin Remark
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($booking_requests) > 0) {

                            foreach ($booking_requests as $row): ?>

                                <tr>
                                    <td>

                                        <input type="checkbox" class="bookingIds" value="<?= $row['id'] ?>">

                                    </td>
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

                                        <div class="d-flex align-items-center">

                                            <small class="text-primary fw-bold">

                                                <strong>Requested Seats :</strong>

                                                <?= number_format($row['center_seat']) ?>

                                            </small>

                                            <?php if ($requirementUpdated == 1) { ?>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-warning ms-2 edit-allocation"

                                                    data-request="<?= $row['id'] ?>"

                                                    data-project="<?= $row['project_id'] ?>"

                                                    data-city="<?= $cityId ?>">

                                                    <i class="fa fa-edit"></i>

                                                </button>

                                            <?php } ?>

                                        </div>
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
                                    <td>

                                        <select class="form-select adminAction" data-id="<?= $row['id'] ?>" data-old-status="<?= $row['admin_status'] ?>" <?php echo $currentType == 'rejected' ? 'disabled' : '' ?>>

                                            <option value="">
                                                Select
                                            </option>

                                            <option value="1" <?= ($row['admin_status'] == 1)
                                                                    ? 'selected' : '' ?>>

                                                Approve

                                            </option>

                                            <option value="2" <?= ($row['admin_status'] == 2)
                                                                    ? 'selected' : '' ?>>

                                                Reject

                                            </option>

                                            <option value="3" <?= ($row['admin_status'] == 3)
                                                                    ? 'selected' : '' ?>>

                                                Hold

                                            </option>

                                            <option value="4" <?= ($row['admin_status'] == 4)
                                                                    ? 'selected' : '' ?>>

                                                Not Required

                                            </option>

                                        </select>

                                    </td>
                                    <td>

                                        <?php
                                        if (
                                            !empty($row['admin_remark'])
                                        ) {
                                        ?>

                                            <div class="small text-danger">

                                                <?=
                                                htmlspecialchars(
                                                    $row['admin_remark']
                                                )
                                                ?>

                                            </div>

                                        <?php
                                        } else {
                                            echo '-';
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

<!-- Admin Remark -->
<div class="modal fade" id="reasonModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Rejection Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <h6>Reasons:</h6>
                <ol id="reasonList" class="ps-3"></ol>

                <div id="negotiateContainer" class="mt-3" style="display:none;">
                    <h6>Negotiation Price:</h6>
                    <div class="alert alert-warning" id="negotiateText"></div>
                </div>

                <h6 class="mt-3">Comment:</h6>
                <div id="commentText" class="p-2 bg-light rounded"></div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<!-- MODAL (Admin price update) -->
<div class="modal fade" id="priceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title">Revise Price</h5>
                <!-- Close button added here -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="request_id">
                <label>Admin Final Price</label>
                <input type="number" id="admin_price" class="form-control">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="savePrice">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Seat and Batch Allocation Modal -->
<div
    class="modal fade"
    id="allocationModal"
    tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div id="allocationModalBody">

            </div>

        </div>

    </div>

</div>

<script>
    $('.revise-price-btn').click(function() {
        $('#request_id').val($(this).data('id'));
        $('#admin_price').val($(this).data('price'));
        new bootstrap.Modal('#priceModal').show();
    });

    $('#savePrice').click(function() {
        // Show SweetAlert loader
        Swal.fire({
            title: 'Please wait...',
            text: 'Updating price, please do not refresh the page.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.post(
            "<?= base_url('admin/update-send-booking-price') ?>", {
                request_id: $('#request_id').val(),
                admin_center_final_price: $('#admin_price').val()
            },
            function(res) {
                // Close the loader
                Swal.close();
                // Reload the page
                location.reload();
            },
            'json'
        ).fail(function(xhr, status, error) {
            // Handle errors
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.view-reason').forEach(function(btn) {

            btn.addEventListener('click', function() {

                const reason = this.dataset.reason || '';
                const comment = this.dataset.comment || '';
                const negotiate = this.dataset.negotiate || '';

                document.getElementById('reasonList').innerHTML = '';
                document.getElementById('commentText').innerText = '';
                document.getElementById('negotiateContainer').style.display = 'none';

                let hasPriceReason = false;

                reason.split(',').forEach(function(item) {
                    if (item.trim() !== '') {
                        const li = document.createElement('li');
                        li.textContent = item.trim();
                        document.getElementById('reasonList').appendChild(li);

                        if (item.trim() === 'Price is not up to the mark') {
                            hasPriceReason = true;
                        }
                    }
                });

                if (hasPriceReason && negotiate.trim() !== '') {
                    document.getElementById('negotiateText').innerText = negotiate;
                    document.getElementById('negotiateContainer').style.display = 'block';
                }

                document.getElementById('commentText').innerText = comment;

                new bootstrap.Modal(document.getElementById('reasonModal')).show();
            });

        });

    });
</script>

<script>
    $(document).on('change', '.adminAction', async function() {

        let $this = $(this);

        let status = $this.val();

        let bookingId = $this.data('id');

        let oldValue = $this.data('old-status') || '';

        let remark = '';

        // Status text
        let statusText = '';

        if (status == 1) {
            statusText = 'Approve';
        } else if (status == 2) {
            statusText = 'Reject';
        } else if (status == 3) {
            statusText = 'Hold';
        }

        // Remark required for Reject / Hold
        if (status == 2 || status == 3) {

            const result = await Swal.fire({
                title: 'Enter Remark',
                input: 'textarea',
                inputPlaceholder: 'Enter remark here...',
                inputAttributes: {
                    'aria-label': 'Enter remark'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Remark is required!';
                    }
                }
            });

            if (!result.isConfirmed) {
                $this.val(oldValue);
                return;
            }

            remark = result.value;
        }

        // Final Confirmation
        const confirmation = await Swal.fire({
            title: 'Are you sure?',
            text: 'You want to ' + statusText + ' this booking request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Continue',
            cancelButtonText: 'Cancel'
        });

        if (!confirmation.isConfirmed) {
            $this.val(oldValue);
            return;
        }

        $.ajax({
            url: base_url + 'admin/update-admin-booking-status',
            type: 'POST',
            dataType: 'json',
            data: {
                id: bookingId,
                status: status,
                remark: remark
            },
            success: function(response) {

                if (response.status == 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Booking status updated successfully.'
                    }).then(() => {
                        location.reload();
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong.'
                    });

                    $this.val(oldValue);
                }
            },
            error: function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Server error occurred.'
                });

                $this.val(oldValue);
            }
        });

    });
</script>

<script>
    $('#selectAll').on('change', function() {

        $('.bookingIds').prop(
            'checked',
            $(this).is(':checked')
        );

    });

    $('#bulkApprove').click(function() {

        let ids = [];

        $('.bookingIds:checked').each(function() {

            ids.push($(this).val());

        });

        if (ids.length == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select at least one booking.'
            });

            return;
        }

        Swal.fire({
            title: 'Approve Selected Bookings?',
            text: 'All selected booking requests will be approved.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve All',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: base_url + 'admin/bulk-approve-booking',
                type: 'POST',
                dataType: 'json',
                data: {
                    booking_ids: ids
                },
                success: function(res) {

                    if (res.status == 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Selected bookings approved successfully.'
                        }).then(() => {

                            location.reload();

                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong.'
                        });

                    }
                },
                error: function() {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Server error occurred.'
                    });

                }
            });

        });

    });
</script>

<!-- Seat and Batch Allocation Edit Script -->
<script>
    $(document).on(

        'click',

        '.edit-allocation',

        function() {

            let requestId = $(this).data('request');

            $.ajax({

                url: base_url + "admin/get-allocation-modal",

                type: "POST",

                data: {
                    request_id: requestId
                },

                dataType: "json",

                success: function(res) {

                    if (res.status == "success") {

                        $("#allocationModalBody").html(

                            res.html

                        );

                        $("#allocationModal").modal("show");

                    }

                }

            });

        });
</script>

<!-- Save allocation js -->
<script>
    $(document).on(
        "click",
        "#saveAllocation",
        function() {

            let btn = $(this);

            let requestId = btn.data("request");

            let formData = [];

            $(".allocation-seat").each(function() {

                formData.push({

                    batch_no: $(this).attr("name").match(/\d+/)[0],

                    seat: $(this).val()

                });

            });

            let isValid = true;

            $(".allocation-seat").each(function() {

                let newSeat = parseInt($(this).val()) || 0;

                let required = parseInt($(this).data("required")) || 0;

                let otherRequested = parseInt($(this).data("other")) || 0;

                if ((otherRequested + newSeat) > required) {

                    toastr.error(
                        "Batch allocation cannot exceed required seat."
                    );

                    $(this).focus();

                    isValid = false;

                    return false;
                }

            });

            if (!isValid) {

                return;

            }

            $.ajax({

                url: base_url + "admin/update-allocation",

                type: "POST",

                data: {
                    request_id: requestId,
                    allocation: JSON.stringify(formData)
                },

                dataType: "json",

                beforeSend: function() {

                    btn.prop("disabled", true);

                    btn.html(
                        '<i class="fa fa-spinner fa-spin"></i> Updating...'
                    );

                },

                success: function(res) {

                    btn.prop("disabled", false);

                    btn.html("Update Allocation");

                    if (res.status == "success") {

                        toastr.success(res.message);

                        $("#allocationModal").modal("hide");

                        location.reload();

                    } else {

                        toastr.error(res.message);

                    }

                }

            });

        }
    );
</script>