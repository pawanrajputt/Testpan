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

        <div class="module-statistics" id="owner-statistics">

            <!-- Total Owners -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-users"></i>
                </div>

                <div class="stat-content">
                    <span>Total Owners</span>
                    <strong><?= $total_owners ?></strong>
                </div>

                <div class="stat-footer">
                    All Owners
                </div>

            </div>


            <!-- Active -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-user-check"></i>
                </div>

                <div class="stat-content">
                    <span>Active</span>
                    <strong><?= $active_owners ?></strong>
                </div>

                <div class="stat-footer">
                    Active Owners
                </div>

            </div>


            <!-- Inactive -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-user-off"></i>
                </div>

                <div class="stat-content">
                    <span>Inactive</span>
                    <strong><?= $inactive_owners ?></strong>
                </div>

                <div class="stat-footer">
                    Inactive Owners
                </div>

            </div>


            <!-- Deleted -->
            <div class="stat-card stat-danger">

                <div class="stat-icon">
                    <i class="ti ti-trash"></i>
                </div>

                <div class="stat-content">
                    <span>Deleted</span>
                    <strong><?= $deleted_owners ?></strong>
                </div>

                <div class="stat-footer">
                    Deleted Owners
                </div>

            </div>


            <!-- Subscribed -->
            <div class="stat-card stat-info">

                <div class="stat-icon">
                    <i class="ti ti-crown"></i>
                </div>

                <div class="stat-content">
                    <span>Subscribed</span>
                    <strong><?= $subscribed_owners ?></strong>
                </div>

                <div class="stat-footer">
                    Subscribed Owners
                </div>

            </div>


            <!-- Non-Subscribed -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-user-minus"></i>
                </div>

                <div class="stat-content">
                    <span>Non-Subscribed</span>
                    <strong><?= $non_subscribed_owners ?></strong>
                </div>

                <div class="stat-footer">
                    Non-Subscribed Owners
                </div>

            </div>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="w-100 mb-5">
                    <button class="btn btn-success me-1" onclick="bulkAction('activate')">Activate</button>
                    <button class="btn btn-warning me-1" onclick="bulkAction('inactive')">Inactive</button>
                    <button class="btn btn-danger me-1" onclick="bulkAction('delete')">Delete</button>
                    <button id="exportBtn" class="btn btn-info me-1">
                        <i class="ti ti-download"></i> Export
                    </button>
                    <button style="float: inline-end;margin-left: 8px;" class="btn btn-success filter-btn active" data-type="active">Active Owners</button>
                    <button style="float: inline-end;" class="btn btn-danger filter-btn" data-type="deleted">Deleted Owners</button>
                </div>
                <div class="row g-3">

                    <div class="col-md-3">
                        <select id="filterStatus" class="form-select select2">
                            <option value="">Select Status</option>
                            <option value="1">Approved</option>
                            <option value="0">Not Approved</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="date" id="filterFrom" class="form-control flatpickr-date" placeholder="Select From Date">
                    </div>

                    <div class="col-md-3">
                        <input type="date" id="filterTo" class="form-control flatpickr-date" placeholder="Select To Date">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="ownerTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th width="2%">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th style="300px">Username</th>
                            <th>Email/Mobile</th>
                            <th>Total Centers</th>
                            <th>Status</th>
                            <th>Documents</th>
                            <th>Created</th>
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


<script>
    let ownerType = 'active';
    let table;

    $(document).ready(function() {

        table = $('#ownerTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            pageLength: 25,
            scrollX: true,

            ajax: {
                url: "<?= base_url('admin/center-owners/ajax-list') ?>",
                type: "POST",
                data: function(d) {
                    d.owner_type = ownerType;

                    // Filters
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
                    data: 'username',
                    width: 400
                },
                {
                    data: 'email'
                },
                {
                    data: 'centers',
                    width: '120px'
                },
                {
                    data: 'status',
                    orderable: false
                },
                {
                    data: 'documents',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created',
                    width: '120px'
                },
                {
                    data: 'action',
                    width: '120px'
                },
            ]
        });

        // Reload table when filter changes
        $('#filterStatus, #filterFrom, #filterTo').on('change', function() {
            table.ajax.reload();
        });

        $('#exportBtn').on('click', function() {
            window.location.href = "<?= base_url('admin/center-owners/export') ?>";
        });

    });
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
                    url: "<?= base_url('admin/center-owner/change-status') ?>",
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

                            $('#ownerTable').DataTable().ajax.reload(null, false);

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
    $('#checkAll').on('click', function() {
        $('.owner-checkbox').prop('checked', this.checked);
    });

    function bulkAction(action) {

        let ids = [];
        $('.owner-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        // If no checkbox selected
        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one owner'
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
                    url: "<?= base_url('admin/center-owner/bulk-action') ?>",
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

                            $('#ownerTable').DataTable().ajax.reload(null, false);

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
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        ownerType = $(this).data('type');

        table.ajax.reload();
    });
</script>
<script>
    $(document).on('click', '.restoreOwner', function() {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Restore Owner?',
            text: "Account will be reactivated.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/center-owners/restore-owner') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(res) {

                        let r = JSON.parse(res);

                        if (r.status) {
                            Swal.fire('Restored!', r.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', r.message, 'error');
                        }
                    }
                });

            }
        });
    });
</script>
<script>
    $(document).on('click', '.deleteOwner', function() {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete Owner?',
            text: "Owner account will be deactivated.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/center-owners/delete-owner') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(res) {

                        let r = JSON.parse(res);

                        if (r.status) {
                            Swal.fire('Deleted!', r.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', r.message, 'error');
                        }
                    }
                });

            }
        });
    });
</script>