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

        <div class="module-statistics" id="client-statistics">

            <!-- Total Clients -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-users"></i>
                </div>

                <div class="stat-content">
                    <span>Total Clients</span>
                    <strong><?= $total_clients ?></strong>
                </div>

                <div class="stat-footer">
                    All Clients
                </div>

            </div>


            <!-- Approved -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Approved</span>
                    <strong><?= $approved_clients ?></strong>
                </div>

                <div class="stat-footer">
                    Approved Clients
                </div>

            </div>


            <!-- Pending -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-clock"></i>
                </div>

                <div class="stat-content">
                    <span>Pending</span>
                    <strong><?= $pending_clients ?></strong>
                </div>

                <div class="stat-footer">
                    Awaiting Approval
                </div>

            </div>


            <!-- Deleted -->
            <div class="stat-card stat-danger">

                <div class="stat-icon">
                    <i class="ti ti-trash"></i>
                </div>

                <div class="stat-content">
                    <span>Deleted</span>
                    <strong><?= $deleted_clients ?></strong>
                </div>

                <div class="stat-footer">
                    Deleted Clients
                </div>

            </div>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="w-100 mb-5">
                    <button class="btn btn-success me-1" onclick="bulkAction('activate')">Activate</button>
                    <button class="btn btn-warning me-1" onclick="bulkAction('inactive')">Inactive</button>
                    <button class="btn btn-danger me-1" onclick="bulkAction('delete')">Delete</button>
                    <a href="<?= base_url('admin/clients/export') ?>" class="btn btn-info">
                        Export
                    </a>
                    <button style="float: inline-end;margin-left: 8px;" class="btn btn-success filter-btn active" data-type="active">Active Clients</button>
                    <button style="float: inline-end;" class="btn btn-danger filter-btn" data-type="deleted">Deleted Clients</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-3"> <select id="filterStatus" class="form-select select2">
                            <option value="">Select Status</option>
                            <option value="1">Approved</option>
                            <option value="0">Not Approved</option>
                        </select> </div>
                    <div class="col-md-3"> <input type="date" id="filterFrom" class="form-control flatpickr-date" placeholder="Select From Date"> </div>
                    <div class="col-md-3"> <input type="date" id="filterTo" class="form-control flatpickr-date" placeholder="Select To Date"> </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="clientTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th width="2%">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>City/State</th>
                            <th>Project Count</th>
                            <th>Created</th>
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

<script>
    let clientType = 'active';
    let table;

    $(document).ready(function() {

        table = $('#clientTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            lengthChange: true,
            pageLength: 10,
            order: [
                [6, 'desc']
            ],

            ajax: {
                url: "<?= base_url('admin/clients/ajax-list') ?>",
                type: "POST",
                data: function(d) {
                    d.client_type = clientType;
                    d.status = $('#filterStatus').val();
                    d.from_date = $('#filterFrom').val();
                    d.to_date = $('#filterTo').val();
                }
            },

            columns: [{
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'company'
                },
                {
                    data: 'name'
                },
                {
                    data: 'mobile'
                },
                {
                    data: 'city'
                },
                {
                    data: 'projects'
                },
                {
                    data: 'created'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],

            drawCallback: function() {
                $('#checkAll').prop('checked', false);
            }
        });

        // Reload table when filter changes
        $('#filterStatus, #filterFrom, #filterTo').on('change', function() {
            table.ajax.reload();
        });

        // Check all
        $('#checkAll').on('click', function() {
            $('.client-checkbox').prop('checked', this.checked);
        });

    });
</script>
<script>
    function bulkAction(action) {

        let ids = [];
        $('.client-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        // If no checkbox selected
        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one client'
            });
            return;
        }

        // Confirmation Swal
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to perform this action?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/clients/bulk-action') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: action,
                        ids: ids
                    },
                    success: function(res) {

                        if (res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#clientTable').DataTable().ajax.reload(null, false);

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });

            }

        });
    }
</script>
<script>
    $(document).on('click', '.changeStatus', function() {

        const userId = $(this).data('id');
        const status = $(this).data('status');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/clients/change-status') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        user_id: userId,
                        status: status
                    },
                    success: function(res) {

                        if (res.status) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#clientTable').DataTable().ajax.reload(null, false);

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: res.message
                            });

                        }
                    },
                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });

                    }
                });

            }

        });

    });
</script>
<script>
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        clientType = $(this).data('type'); // active / deleted

        table.ajax.reload();
    });
</script>
<script>
    $(document).on('click', '.restoreClient', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Restore Client?',
            text: "This client account will be reactivated.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/clients/restore-client') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(res) {
                        let r = JSON.parse(res);

                        if (r.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Restored!',
                                text: r.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: r.message
                            });
                        }
                    }
                });

            }
        });
    });
</script>