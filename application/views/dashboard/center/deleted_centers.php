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

        <div class="module-statistics" id="deleted-center-statistics">

            <!-- Total Deleted Centers -->
            <div class="stat-card stat-danger">

                <div class="stat-icon">
                    <i class="ti ti-trash"></i>
                </div>

                <div class="stat-content">
                    <span>Total Deleted</span>
                    <strong><?= $deleted_centers ?></strong>
                </div>

                <div class="stat-footer">
                    Deleted Centers
                </div>

            </div>

        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="deletedCenterTable" class="table table-striped">
                    <thead class="table-danger">
                        <tr>
                            <th>S.No</th>
                            <th>Center / Owner</th>
                            <th>Location</th>
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


<script>
    $(function() {

        const table = $('#deletedCenterTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            pageLength: 25,

            ajax: {
                url: "<?= base_url('admin/deleted-centers/ajax-list') ?>",
                type: "POST"
            },

            columns: [{
                    data: 'sr',
                    width: '60px'
                },
                {
                    data: 'center_owner',
                    width: '260px'
                },
                {
                    data: 'location',
                    width: '180px'
                },
                {
                    data: 'audit',
                    width: '160px'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    width: '300px'
                }
            ]
        });

        /* 🔄 Retrieve Center */
        $(document).on('click', '.retrieveCenter', function() {

            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This center will be restored!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Retrieve',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28c76f',
                cancelButtonColor: '#d33'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.post(
                        "<?= base_url('admin/deleted-centers/retrieve') ?>", {
                            id: id
                        },
                        function(res) {

                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Restored!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                table.ajax.reload(null, false);

                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        'json'
                    );
                }
            });
        });


    });
</script>