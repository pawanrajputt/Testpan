<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashbaord</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
            <div class="col-md-6">
                <div class="table-btn-css">
                    <a href="<?= base_url('admin/cms/create') ?>"><button class="btn btn-custom waves-effect waves-light"><span class="ti-xs ti ti-plus me-1"></span>
                            Add CMS</button></a>
                </div>
            </div>
        </div>

        <div class="module-statistics" id="cms-statistics">

            <!-- Total CMS -->
            <div class="stat-card stat-purple">
                <div class="stat-icon">
                    <i class="ti ti-files"></i>
                </div>

                <div class="stat-content">
                    <span>Total CMS</span>
                    <strong><?= $total_cms ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    All CMS Pages
                </div>
            </div>


            <!-- Active CMS -->
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Active CMS</span>
                    <strong><?= $active_cms ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Currently Active
                </div>
            </div>


            <!-- Inactive CMS -->
            <div class="stat-card stat-danger">
                <div class="stat-icon">
                    <i class="ti ti-circle-x"></i>
                </div>

                <div class="stat-content">
                    <span>Inactive CMS</span>
                    <strong><?= $inactive_cms ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Currently Inactive
                </div>
            </div>

        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="cmsTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
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
    $(function() {

        const table = $('#cmsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            pageLength: 25,
            scrollX: true,

            ajax: {
                url: "<?= base_url('admin/cms/ajax-list') ?>",
                type: "POST"
            },

            columns: [{
                    data: 'title'
                },
                {
                    data: 'description'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                }
            ]
        });
    });
</script>
<script>
    $(document).on('click', '.changeStatus', function() {

        const Id = $(this).data('id');
        const status = $(this).data('status');

        // Optional: Dynamic text based on status
        let actionText = status == 1 ? 'activate' : 'deactivate';

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to " + actionText + " this cms?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/cms/change-status') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        Id: Id,
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

                            $('#cmsTable').DataTable().ajax.reload(null, false);

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