<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="<?=base_url('admin/dashboard')?>">Dashbaord</a> /
                  </span>
                  <?=$page_title?>
                </h4>
            </div>
            <?php if (has_permission('role_create')): ?>
            <div class="col-md-6">
                <div class="table-btn-css">
                    <a href="<?=base_url('admin/role/create')?>"><button class="btn btn-custom waves-effect waves-light"><span class="ti-xs ti ti-plus me-1"></span>
                    Add New Role</button></a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="roleTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Role Name</th>
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
$(function(){

    const table = $('#roleTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        paging: true,
        pageLength: 25,
        scrollX: true,

        ajax: {
            url: "<?= base_url('admin/role/ajax-list') ?>",
            type: "POST"
        },

        columns: [
            { data: 'role_name' },
            { data: 'status' },
            { data: 'action' }
        ]
    });
});
</script>
<script>
$(document).on('click', '.changeStatus', function () {

    const Id = $(this).data('id');
    const status = $(this).data('status');

    // Optional: Dynamic text based on status
    let actionText = status == 1 ? 'activate' : 'deactivate';

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + actionText + " this role?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "<?= base_url('admin/role/change-status') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    Id: Id,
                    status: status
                },
                success: function (res) {

                    if (res.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#roleTable').DataTable().ajax.reload(null, false);

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: res.message
                        });

                    }
                },
                error: function () {

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
    $(document).on('click', '.deleteRole', function () {

        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.post("<?= base_url('admin/role/delete/') ?>" + id, function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Role deleted successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#roleTable').DataTable().ajax.reload(null, false);

                }, 'json');

            }
        });
    });
</script>