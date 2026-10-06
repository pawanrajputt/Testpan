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

        <div class="module-statistics" id="project-statistics">

            <!-- Total Projects -->
            <div class="stat-card stat-purple">
                <div class="stat-icon">
                    <i class="ti ti-briefcase"></i>
                </div>

                <div class="stat-content">
                    <span>Total Projects</span>
                    <strong><?= $total_projects ?></strong>
                </div>

                <div class="stat-footer">
                    All Projects
                </div>
            </div>


            <!-- Completed -->
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Completed</span>
                    <strong><?= $completed_projects ?></strong>
                </div>

                <div class="stat-footer">
                    Finished
                </div>
            </div>


            <!-- Upcoming -->
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="ti ti-calendar-event"></i>
                </div>

                <div class="stat-content">
                    <span>Upcoming</span>
                    <strong><?= $upcoming_projects ?></strong>
                </div>

                <div class="stat-footer">
                    Starting Soon
                </div>
            </div>


            <!-- Running -->
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="ti ti-run"></i>
                </div>

                <div class="stat-content">
                    <span>Running</span>
                    <strong><?= $running_projects ?></strong>
                </div>

                <div class="stat-footer">
                    Active Projects
                </div>
            </div>


            <!-- Postponed -->
            <div class="stat-card stat-danger">
                <div class="stat-icon">
                    <i class="ti ti-clock-exclamation"></i>
                </div>

                <div class="stat-content">
                    <span>Postponed</span>
                    <strong><?= $postponed_projects ?></strong>
                </div>

                <div class="stat-footer">
                    Delayed
                </div>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" id="filterExamName" class="form-control" placeholder="Search Exam Name">
                    </div>

                    <div class="col-md-3">
                        <select id="filterClientSelect" class="form-select select2">
                            <option value="">Select Client</option>
                            <?php
                            foreach ($clientData as $row) { ?>
                                <option value="<?= $row['id'] ?>"><?= $row['username'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="filterStatus" class="form-select select2">
                            <option value="">Project Status</option>
                            <option value="Upcoming">Upcoming</option>
                            <option value="Running">Running</option>
                            <option value="Postponed">Postponed</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="date" id="filterFrom" class="form-control flatpickr-date" placeholder="Select From Date">
                    </div>

                    <div class="col-md-3">
                        <input type="date" id="filterTo" class="form-control flatpickr-date" placeholder="Select To Date">
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2">
                        <a href="<?= base_url('admin/client-projects/export') ?>" class="btn btn-info">
                            <i class="ti ti-download"></i> Export Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="projectTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Exam Name</th>
                            <th>Client</th>
                            <th>Seats</th>
                            <th>Requirement</th>
                            <th>Exam Date</th>
                            <th>Total Cities</th>
                            <th>Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<!-- Modal -->
<div class="modal fade" id="changeStatusModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="changeStatusForm">

                <div class="modal-header text-white">
                    <h5 class="modal-title">Postpone Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden"
                        name="project_id"
                        id="project_id">

                    <div class="mb-3">

                        <label>Remark <span class="text-danger">*</span></label>

                        <textarea
                            name="remark"
                            class="form-control"
                            required></textarea>

                    </div>

                    <div class="mb-3">

                        <label>
                            Do you have future exam date?
                        </label>

                        <br>

                        <label>

                            <input
                                type="radio"
                                name="has_future_date"
                                value="1">

                            Yes

                        </label>

                        &nbsp;&nbsp;

                        <label>

                            <input
                                type="radio"
                                name="has_future_date"
                                value="0"
                                checked>

                            No

                        </label>

                    </div>

                    <div
                        id="futureDateDiv"
                        style="display:none;">

                        <div class="mb-2">

                            <label>Start Date</label>

                            <input
                                type="date"
                                class="form-control"
                                name="start_date"
                                min="<?= date('Y-m-d') ?>">

                        </div>

                        <div>

                            <label>End Date</label>

                            <input
                                type="date"
                                class="form-control"
                                name="end_date"
                                min="<?= date('Y-m-d') ?>">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-primary">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const table = $('#projectTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            pageLength: 10,
            order: [
                [4, 'desc']
            ],

            ajax: {
                url: "<?= base_url('admin/client-projects/ajax-list') ?>",
                type: "POST",
                data: function(d) {
                    d.exam_name = $('#filterExamName').val();
                    d.client_id = $('#filterClientSelect').val();
                    d.status = $('#filterStatus').val();
                    d.from = $('#filterFrom').val();
                    d.to = $('#filterTo').val();
                }
            },

            columns: [{
                    data: 'project'
                },
                {
                    data: 'client'
                },
                {
                    data: 'seat',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'req_status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'exam_date'
                },
                {
                    data: 'city',
                    searchable: false
                },
                {
                    data: 'status',
                    searchable: false
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Reload table on filter change
        $('#globalSearch, #filterExamName, #filterClientSelect, #filterStatus, #filterFrom, #filterTo').on('change keyup', function() {
            table.ajax.reload();
        });

        // Search button click
        $('#searchBtn').on('click', function() {
            table.ajax.reload();
        });

        // Search on Enter key in global search
        $('#globalSearch').on('keyup', function(e) {
            if (e.keyCode === 13) {
                table.ajax.reload();
            }
        });
    });
</script>

<script>
    $(document).on('click', '.changeProjectStatus', function() {

        $('#project_id').val($(this).data('project_id'));

        $('#changeStatusModal').modal('show');

    });

    $('input[name=has_future_date]').change(function() {

        if ($(this).val() == 1) {

            $('#futureDateDiv').slideDown();

        } else {

            $('#futureDateDiv').slideUp();

        }

    });

    $('#changeStatusForm').submit(function(e) {

        e.preventDefault();

        Swal.fire({

            title: 'Are you sure?',

            text: 'Do you want to postpone this project?',

            icon: 'warning',

            showCancelButton: true

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    title: 'Final Confirmation',

                    text: 'All booked centers and manpower will be released.',

                    icon: 'warning',

                    showCancelButton: true

                }).then((res) => {

                    if (res.isConfirmed) {

                        $.ajax({

                            url: base_url + 'admin/update-client-project-status',

                            type: 'POST',

                            data: $('#changeStatusForm').serialize(),

                            success: function(r) {

                                $('#changeStatusModal').modal('hide');

                                $('#projectTable').DataTable().ajax.reload(null, false);

                                Swal.fire(
                                    'Success',
                                    'Project updated successfully',
                                    'success'
                                );

                            }

                        });

                    }

                });

            }

        });

    });

    $('input[name=start_date]').on('change', function() {
        $('input[name=end_date]').attr('min', $(this).val());
    });
</script>

<script>
    $(document).on('change', '.work-progress-status', function() {

        let select = $(this);
        let projectId = select.data('project-id');
        let newValue = select.val();
        let oldValue = newValue == '1' ? '0' : '1';

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update the project work progress status?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: '<?= base_url("admin/update-project-book-flag"); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        project_id: projectId,
                        book_flag: newValue
                    },
                    success: function(response) {

                        if (response.status) {
                            Swal.fire('Updated!', response.message, 'success');
                        } else {
                            select.val(oldValue);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        select.val(oldValue);
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });

            } else {
                select.val(oldValue);
            }
        });
    });
</script>