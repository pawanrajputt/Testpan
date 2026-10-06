<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-6">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?=base_url('admin/dashboard')?>">Dashboard</a> /
                    </span>
                    <?=$page_title?>
                </h4>
            </div>

            <?php if (has_permission('subadmin_create')): ?>
            <div class="col-md-6">
                <div class="table-btn-css">
                    <a href="<?=base_url('admin/subadmin/create')?>"
                       class="btn btn-custom waves-effect waves-light">
                        <i class="ti ti-plus"></i> Add Subadmin
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="subadminTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
$(function(){

    $('#subadminTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        paging: true,
        pageLength: 25,
        scrollX: true,

        ajax: {
            url: "<?= base_url('admin/subadmin/ajax-list') ?>",
            type: "POST"
        },

        columns: [
            { data: 'subadmin_name' },
            { data: 'subadmin_email' },
            { data: 'role_name' },
            { data: 'status', orderable:false, searchable:false },
            { data: 'action', orderable:false, searchable:false }
        ]
    });
});
</script>

<!-- Change Status -->
<script>
$(document).on('click', '.changeStatus', function () {

    const Id = $(this).data('id');
    const status = $(this).data('status');
    let actionText = status == 1 ? 'activate' : 'deactivate';

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + actionText + " this subadmin?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "<?= base_url('admin/subadmin/change-status') ?>",
                type: "POST",
                dataType: "json",
                data: { Id: Id, status: status },
                success: function (res) {

                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        $('#subadminTable').DataTable().ajax.reload(null, false);
                    }
                }
            });

        }
    });
});
</script>

<!-- Delete -->
<script>
$(document).on('click', '.deleteSubadmin', function () {

    const id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This subadmin will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.post("<?= base_url('admin/subadmin/delete/') ?>" + id, function () {

                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Subadmin deleted successfully.',
                    timer: 1200,
                    showConfirmButton: false
                });

                $('#subadminTable').DataTable().ajax.reload(null, false);

            }, 'json');
        }
    });
});
</script>