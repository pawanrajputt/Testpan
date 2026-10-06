<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashbaord</a> / <a
                            href="<?= base_url('admin/client-projects') ?>">Client Project</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
        </div>

        <!-- Here is the rest code -->
        <div class="row mb-4">

            <?php $this->load->view('dashboard/client_project/common/project_change_log', ['changeLogs' => $changeLogs]); ?>

            <div class="col-12">
                <h5 class="fw-semibold mb-3">Total City</h5>
            </div>

            <?php

            $this->load->view(

                'dashboard/client_project/common/project_batch_statistics',

                [
                    'batchStatistics' => $batchStatistics
                ]

            );

            ?>
        </div>



        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-end">

                <a target="_blank"
                    href="<?= base_url('admin/client-negotiation-management/' . $projectId) ?>"
                    class="btn btn-warning">

                    <i class="fa fa-credit-card-alt me-2"></i>
                    Manage Client Negotiations

                </a>

            </div>
        </div>

        <!-- Here is the table code -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Project</th>
                            <th>Client</th>
                            <th class="text-center">Seat / Requirement</th>
                            <th class="text-center">Exam Date</th>
                            <th class="text-center">Price / Seat</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($all_project_info as $row):

                            // =====================================================
                            // URL-SAFE PROJECT ID
                            // =====================================================

                            $encodedProjectId = rtrim(
                                strtr(
                                    base64_encode($row['project_id']),
                                    '+/',
                                    '-_'
                                ),
                                '='
                            );


                            // =====================================================
                            // CITY-WISE SEAT ALLOCATION
                            //
                            // Project ID + City ID
                            // =====================================================

                            $seat = getProjectSeatAllocation(
                                $row['project_id'],
                                $row['exam_city_id']
                            );


                            $required_seats =
                                $seat['required'];

                            $allocated_capacity =
                                $seat['allocated'];

                            $allocation_percent =
                                $seat['percent'];


                            // =====================================================
                            // SEAT PROGRESS
                            // =====================================================

                            $seatProgress =
                                getSeatProgressHtml($seat);


                            // =====================================================
                            // ALLOCATION STATUS
                            // =====================================================

                            $requirement_status =
                                $seat['badge'];


                            // =====================================================
                            // PROJECT STATUS
                            // =====================================================

                            $project_status =
                                getProjectStatusBadge($row);

                            $projectRemark =
                                isHaveAnyRemark(
                                    $row['project_remark']
                                );

                        ?>

                            <tr>

                                <!-- =================================================
                 PROJECT + CITY
                 ================================================= -->

                                <td>

                                    <div class="fw-semibold">
                                        <?= htmlspecialchars(
                                            $row['exam_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </div>

                                    <span class="badge bg-label-primary mt-1">
                                        <?= htmlspecialchars(
                                            $row['city_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                </td>


                                <!-- =================================================
                 CLIENT
                 ================================================= -->

                                <td>

                                    <?= ucwords(
                                        htmlspecialchars(
                                            $row['client_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ) ?>

                                    <div class="text-muted small">

                                        <a
                                            href="javascript:void(0)"
                                            onclick="showProjectInfo(
                            '<?= addslashes($row['company_name']) ?>',
                            '<?= addslashes($row['company_type']) ?>',
                            '<?= addslashes($row['client_name']) ?>',
                            '<?= addslashes($row['project_id']) ?>',
                            '<?= addslashes($row['exam_name']) ?>'
                        )">
                                            Project ID:
                                            <?= htmlspecialchars(
                                                $row['project_id'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </a>

                                    </div>

                                </td>


                                <!-- =================================================
                 SEAT / REQUIREMENT
                 ================================================= -->

                                <td class="text-center">

                                    <?= $seatProgress ?>

                                    <div class="mt-1">
                                        <?= $requirement_status ?>
                                    </div>

                                </td>


                                <!-- =================================================
                 EXAM DATE
                 ================================================= -->

                                <td class="text-center">

                                    <?= date(
                                        'd M Y',
                                        strtotime(
                                            $row['start_date']
                                        )
                                    ) ?>

                                    <br>

                                    <span class="text-muted small">
                                        to
                                    </span>

                                    <br>

                                    <?= date(
                                        'd M Y',
                                        strtotime(
                                            $row['end_date']
                                        )
                                    ) ?>

                                </td>


                                <!-- =================================================
                 PROJECT PRICE
                 ================================================= -->

                                <td class="text-center">

                                    <div class="fw-semibold">
                                        Client Price:
                                        ₹<?= number_format(
                                                $row['price_per_seat'],
                                                2
                                            ) ?>
                                    </div>

                                    <div class="text-primary">

                                        Our Price For Centers:
                                        ₹<?= number_format(
                                                $row['admin_price_per_seat'],
                                                2
                                            ) ?>

                                        <a
                                            href="javascript:void(0);"
                                            class="ms-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#priceModal"
                                            data-project="<?= htmlspecialchars(
                                                                $row['project_id'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>"
                                            data-city="<?= (int)$row['exam_city_id'] ?>"
                                            data-price="<?= htmlspecialchars(
                                                            $row['admin_price_per_seat'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                    </div>

                                </td>


                                <!-- =================================================
                 PROJECT STATUS
                 ================================================= -->

                                <td class="text-center">

                                    <?= $project_status ?>

                                    <?= $projectRemark ?>

                                </td>


                                <!-- =================================================
                 ACTION
                 ================================================= -->

                                <td class="text-center">

                                    <!-- Booking Status -->

                                    <a
                                        target="_blank"
                                        href="<?= base_url(
                                                    'admin/booking-request-status/' .
                                                        $encodedProjectId . '/' .
                                                        $row['exam_city_id']
                                                ) ?>"
                                        class="btn btn-sm btn-info mb-1">
                                        Booking Status
                                    </a>


                                    <!-- View Detail -->

                                    <a
                                        target="_blank"
                                        href="<?= base_url(
                                                    'admin/view-project-detail/' .
                                                        $encodedProjectId . '/' .
                                                        $row['exam_city_id']
                                                ) ?>"
                                        class="btn btn-sm btn-success mb-1">
                                        View Detail
                                    </a>


                                    <!-- Find Center -->

                                    <?php if (
                                        $allocated_capacity <
                                        $required_seats
                                    ): ?>

                                        <a
                                            target="_blank"
                                            href="<?= base_url(
                                                        'admin/find-exam-center/' .
                                                            $encodedProjectId . '/' .
                                                            $row['exam_city_id']
                                                    ) ?>"
                                            class="btn btn-sm btn-warning mb-1">
                                            Find Center
                                        </a>

                                    <?php endif; ?>


                                    <!-- Booking Overview -->

                                    <a
                                        target="_blank"
                                        href="<?= base_url(
                                                    'admin/project-overview/' .
                                                        $encodedProjectId . '/' .
                                                        $row['exam_city_id']
                                                ) ?>"
                                        class="btn btn-sm btn-dark mb-1">
                                        Booking Overview
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<div class="modal fade" id="priceModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <form id="updateSeatPriceForm">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Update Seat Price For Centers</h5>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="project_id" id="modal_project_id">

                    <input type="hidden" name="exam_city_id" id="modal_city_id">

                    <div class="mb-3">
                        <label class="form-label">Admin Price / Seat</label>

                        <input type="number"
                            step="0.01"
                            class="form-control"
                            name="admin_price_per_seat"
                            id="modal_price"
                            required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <button type="button"
                        class="btn btn-label-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                </div>

            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('priceModal').addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget;

        document.getElementById('modal_project_id').value = button.getAttribute('data-project');
        document.getElementById('modal_city_id').value = button.getAttribute('data-city');
        document.getElementById('modal_price').value = button.getAttribute('data-price');
    });
</script>

<script>
    $('#updateSeatPriceForm').on('submit', function(e) {

        e.preventDefault();

        let form = $(this);

        Swal.fire({

            title: 'Are you sure?',
            text: 'Do you want to update the seat price for this project?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7367F0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update'

        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            $.ajax({

                url: "<?= base_url('admin/update-admin-seat-price') ?>",

                type: "POST",

                data: form.serialize(),

                dataType: "json",

                beforeSend: function() {

                    form.find('button[type=submit]')
                        .prop('disabled', true)
                        .html('<i class="fa fa-spinner fa-spin me-1"></i> Updating...');

                },

                success: function(response) {

                    if (response.status) {

                        $('#updateSeatPriceModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });

                    }

                },

                error: function() {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });

                },

                complete: function() {

                    form.find('button[type=submit]')
                        .prop('disabled', false)
                        .html('Update');

                }

            });

        });

    });
</script>