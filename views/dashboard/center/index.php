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

        <div class="module-statistics" id="center-statistics">

            <!-- Total Centers -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-building-community"></i>
                </div>

                <div class="stat-content">
                    <span>Total Centers</span>
                    <strong><?= $total_centers ?></strong>
                </div>

                <div class="stat-footer">
                    All Centers
                </div>

            </div>


            <!-- Approved -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Approved</span>
                    <strong><?= $approved_centers ?></strong>
                </div>

                <div class="stat-footer">
                    Approved Centers
                </div>

            </div>


            <!-- Pending -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-clock"></i>
                </div>

                <div class="stat-content">
                    <span>Pending</span>
                    <strong><?= $pending_centers ?></strong>
                </div>

                <div class="stat-footer">
                    Awaiting Approval
                </div>

            </div>


            <!-- Audited -->
            <div class="stat-card stat-info">

                <div class="stat-icon">
                    <i class="ti ti-clipboard-check"></i>
                </div>

                <div class="stat-content">
                    <span>Audited</span>
                    <strong><?= $audited_centers ?></strong>
                </div>

                <div class="stat-footer">
                    Audited Centers
                </div>

            </div>


            <!-- Non-Audited -->
            <div class="stat-card stat-danger">

                <div class="stat-icon">
                    <i class="ti ti-clipboard-x"></i>
                </div>

                <div class="stat-content">
                    <span>Non-Audited</span>
                    <strong><?= $non_audited_centers ?></strong>
                </div>

                <div class="stat-footer">
                    Audit Pending
                </div>

            </div>


            <!-- Total Systems -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-device-desktop"></i>
                </div>

                <div class="stat-content">
                    <span>Total Systems</span>
                    <strong><?= number_format($total_systems) ?></strong>
                </div>

                <div class="stat-footer">
                    Total Systems
                </div>

            </div>


            <!-- Countries Covered -->
            <div class="stat-card stat-blue">

                <div class="stat-icon">
                    <i class="ti ti-world"></i>
                </div>

                <div class="stat-content">
                    <span>Countries Covered</span>
                    <strong id="overview-countries">
                        <?= number_format($total_countries) ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Unique Countries
                </div>

            </div>


            <!-- States Covered -->
            <div class="stat-card stat-info">

                <div class="stat-icon">
                    <i class="ti ti-map"></i>
                </div>

                <div class="stat-content">
                    <span>States Covered</span>
                    <strong id="overview-states">
                        <?= number_format($total_states) ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Unique States
                </div>

            </div>


            <!-- Cities Covered -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-map-pin"></i>
                </div>

                <div class="stat-content">
                    <span>Cities Covered</span>
                    <strong id="overview-cities">
                        <?= number_format($total_cities) ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Unique Cities
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="ti ti-download"></i> Export
                </button>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item exportOption" data-type="all">Export Center All Data</a></li>
                    <li><a class="dropdown-item exportOption" data-type="labs">Export With Labs</a></li>
                    <li><a class="dropdown-item exportOption" data-type="custom">Export With Few Columns</a></li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <select id="country_id" class="form-control select2 form-select select-country">
                            <option value="">Select Country</option>
                            <?php
                            foreach ($country_data as $each) { ?>
                                <option value="<?= $each['id'] ?>"><?= $each['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="state_id" class="form-select select2 select-state">
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="city" class="form-select select2 select-city">
                            <option value="">Select City</option>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <select id="audit_status" class="form-select">
                            <option value="">Select Audit Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="approve_status" class="form-select">
                            <option value="">Select Approve Status</option>
                            <option value="1">Approved</option>
                            <option value="0">Pending</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="centertype" class="form-select">
                            <option value="">Center Type</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="center_owner" class="form-select select2">
                            <option value="">Center Owner</option>
                            <?php
                            foreach ($owner_data as $each) { ?>
                                <option value="<?= $each['id'] ?>"><?= $each['username'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3 d-grid">
                        <button id="searchBtn" class="btn btn-success">
                            <i class="ti ti-search"></i> Search
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-datatable">
                <table id="centerTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Center/Owner</th>
                            <th>Approval & Location</th>
                            <th>Audit Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->


<!-- Delete Center Modal -->
<div class="modal fade" id="deleteCenterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Center</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="delete_center_id">

                <div class="mb-3">
                    <label class="form-label">Reason for Deletion <span class="text-danger">*</span></label>
                    <textarea class="form-control"
                        id="delete_reason"
                        rows="4"
                        placeholder="Enter reason..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" id="confirmDeleteCenter">
                    Submit & Delete
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Audit Modal -->
<div class="modal fade" id="auditModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Upload Audit File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="auditForm" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="center_id" id="audit_center_id">

                    <div class="mb-3">
                        <label class="form-label">Upload Audit File (PDF) <span class="text-danger">*</span></label>
                        <input type="file"
                            name="audit_file"
                            class="form-control"
                            accept="application/pdf"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Audit Status <span class="text-danger">*</span></label>
                        <select name="audit_status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="1">Approve</option>
                            <option value="0">Not Approve</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Manpower -->
<div class="modal fade" id="assignedManpowerModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Assigned Audit Manpower</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Form</th>

                            <th>Assigned At</th>

                        </tr>

                    </thead>

                    <tbody id="assignedManpowerBody">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {

        const table = $('#centerTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            pageLength: 50,

            scrollX: true,
            scrollY: false,
            scrollCollapse: true,

            autoWidth: true,
            responsive: true,
            fixedHeader: true,

            ajax: {
                url: "<?= base_url('admin/centers/ajax-list') ?>",
                type: "POST",
                data: function(d) {
                    d.country_id = $('#country_id').val();
                    d.state_id = $('#state_id').val();
                    d.city_id = $('#city').val();
                    d.audit_status = $('#audit_status').val();
                    d.approve_status = $('#approve_status').val();
                    d.center_type = $('#centertype').val();
                    d.center_owner = $('#center_owner').val();
                }
            },

            columnDefs: [{
                    targets: 0,
                    width: "400px"
                },
                {
                    targets: 1,
                    width: "200px"
                },
                {
                    targets: 2,
                    width: "150px"
                },
                {
                    targets: 3,
                    width: "300px",
                    orderable: false,
                    searchable: false
                }
            ],

            columns: [{
                    data: 'center'
                },
                {
                    data: 'location'
                },
                {
                    data: 'audit'
                },
                {
                    data: 'action'
                }
            ]
        });

        $('#searchBtn').on('click', function() {
            table.ajax.reload();
        });

        $('.exportOption').on('click', function() {

            let type = $(this).data('type');

            let search = $('input[type="search"]').val();

            let params = $.param({
                type: type,
                search: search,
                country_id: $('#country_id').val(),
                state_id: $('#state_id').val(),
                city_id: $('#city').val(),
                audit_status: $('#audit_status').val(),
                approve_status: $('#approve_status').val(),
                center_type: $('#centertype').val(),
                center_owner: $('#center_owner').val()
            });

            window.location.href = "<?= base_url('admin/centers/export') ?>?" + params;
        });


    });
</script>

<!-- Search -->
<script>
    $(document).ready(function() {

        let searchTimeout = null;

        // DataTable default search box
        $('#centerTable_filter input')
            .off()
            .on('keyup', function() {
                let value = this.value;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    $('#centerTable').DataTable().search(value).draw();
                }, 500); // debounce
            });

    });
</script>

<!-- Delete -->
<script>
    $(document).on('click', '.deleteCenterBtn', function() {
        let id = $(this).data('id');
        $('#delete_center_id').val(id);
        $('#delete_reason').val('');
        $('#deleteCenterModal').modal('show');
    });

    $('#confirmDeleteCenter').on('click', function() {

        let center_id = $('#delete_center_id').val();
        let reason = $('#delete_reason').val().trim();

        if (reason === '') {
            Swal.fire('Error', 'Please enter reason for deletion.', 'error');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "This center will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/center/delete') ?>",
                    type: "POST",
                    data: {
                        center_id: center_id,
                        reason: reason
                    },
                    success: function(res) {

                        if (res.status === 'pass') {
                            Swal.fire('Deleted!', res.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }

                    }
                });

            }

        });
    });
</script>

<!-- Approve -->
<script>
    $(document).on('click', '.toggleApprovalBtn', function() {

        let center_id = $(this).data('id');
        let current_status = $(this).data('status');

        let new_status = current_status == 1 ? 0 : 1;
        let actionText = new_status == 1 ? 'Approve' : 'Pending';

        const proceedApproval = () => {

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${actionText} this center?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${actionText}`,
                confirmButtonColor: new_status == 1 ? '#28c76f' : '#ea5455'
            }).then((result) => {

                if (result.isConfirmed) {

                    // Loader
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we update the center and send email.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.post(
                        "<?= base_url('admin/center/toggle-approval') ?>", {
                            center_id: center_id,
                            status: new_status
                        },
                        function(res) {

                            if (res.status === 'pass') {

                                Swal.fire(
                                    'Success!',
                                    res.message,
                                    'success'
                                ).then(() => location.reload());

                            } else {

                                Swal.fire(
                                    'Error',
                                    res.message,
                                    'error'
                                );

                            }

                        },
                        'json'
                    );
                }

            });

        };

        // Extra confirmation only while Approving
        if (new_status == 1) {

            Swal.fire({
                title: 'Center Approval Confirmation',
                text: 'Are all required files uploaded?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#28c76f',
                cancelButtonColor: '#ea5455'
            }).then((result) => {

                if (result.isConfirmed) {
                    proceedApproval();
                }

            });

        } else {

            proceedApproval();

        }

    });
</script>

<!-- Audit -->
<script>
    // Open Modal
    $(document).on('click', '.openAuditModal', function() {
        let id = $(this).data('id');
        $('#audit_center_id').val(id);
        $('#auditForm')[0].reset();
        $('#auditModal').modal('show');
    });

    // Submit Form
    $('#auditForm').on('submit', function(e) {
        e.preventDefault();

        let form = this;

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to submit audit data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
            confirmButtonColor: '#28c76f'
        }).then((result) => {

            if (result.isConfirmed) {

                let formData = new FormData(form);

                $.ajax({
                    url: "<?= base_url('admin/center/upload-audit') ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    success: function(res) {

                        if (res.status === 'pass') {

                            Swal.fire({
                                icon: 'success',
                                title: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());

                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }

                    }
                });

            }

        });
    });
</script>

<script>
    $(document).on("click", ".btnAssignedManpower", function() {

        let center_id = $(this).data("center");

        $("#assignedManpowerModal").modal("show");

        $("#assignedManpowerBody").html(
            "<tr><td colspan='5' class='text-center'>Loading...</td></tr>"
        );

        $.ajax({

            url: base_url + "admin/view-assign-manpower",

            type: "POST",

            data: {
                center_id: center_id
            },

            dataType: "json",

            success: function(res) {

                let html = "";

                if (res.status && res.assign_list && res.assign_list.length > 0) {

                    $.each(res.assign_list, function(i, row) {

                        let pdf = "--";

                        if (row.form_uploaded != "") {
                            pdf = "<a target='_blank' href='" + res.base_url + row.form_uploaded + "'><i class='fa fa-file-pdf'></i></a>";
                        }

                        html += "<tr>";
                        html += "<td>" + row.manpower.full_name + "</td>";
                        html += "<td>" + row.manpower.email + "</td>";
                        html += "<td>" + row.role + "</td>";
                        html += "<td>" + pdf + "</td>";
                        html += "<td>" + row.assigned_at + "</td>";
                        html += "</tr>";

                    });

                } else {

                    html = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="fa fa-info-circle"></i> No manpower assigned.
                            </td>
                        </tr>
                    `;

                }

                $("#assignedManpowerBody").html(html);

            },
            error: function() {

                $("#assignedManpowerBody").html(`
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Unable to fetch data. Please try again.
                        </td>
                    </tr>
                `);

            }
        });

    });
</script>