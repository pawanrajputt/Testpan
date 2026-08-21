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
                    <button class="btn btn-custom waves-effect waves-light" id="addNewsBtn"><span class="ti-xs ti ti-plus me-1"></span>
                        Add News</button>
                </div>
            </div>
        </div>

        <div class="module-statistics" id="custom-news-statistics">

            <!-- Total News -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-news"></i>
                </div>

                <div class="stat-content">
                    <span>Total News</span>
                    <strong><?= $total_news ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    All News
                </div>

            </div>


            <!-- Active News -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Active News</span>
                    <strong><?= $active_news ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Currently Active
                </div>

            </div>


            <!-- Inactive News -->
            <div class="stat-card stat-danger">

                <div class="stat-icon">
                    <i class="ti ti-circle-x"></i>
                </div>

                <div class="stat-content">
                    <span>Inactive News</span>
                    <strong><?= $inactive_news ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Currently Inactive
                </div>

            </div>

        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="customNewsTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th width="250px">Title</th>
                            <th>Link</th>
                            <th>Media Type</th>
                            <th>Preview</th>
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

<style>
    .news-preview iframe {
        border-radius: 6px;
    }
</style>

<!-- MODAL -->
<div class="modal fade" id="newsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="newsForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add / Edit News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="news_id" name="id">

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>

                    <div class="mb-3">
                        <label>News Link</label>
                        <input type="url" class="form-control" name="news_link" id="news_link" required>
                    </div>

                    <div id="previewBox"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {

        const table = $('#customNewsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            pageLength: 25,
            scrollX: true,

            ajax: {
                url: "<?= base_url('admin/custom-news/ajax-list') ?>",
                type: "POST"
            },

            columns: [{
                    data: 'title',
                    width: "250px"
                },
                {
                    data: 'link'
                },
                {
                    data: 'type'
                },
                {
                    data: 'preview'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                }
            ]
        });

        $('#addNewsBtn').click(() => {
            $('#newsForm')[0].reset();
            $('#news_id').val('');
            $('#previewBox').html('');
            $('#newsModal').modal('show');
        });

        $('#newsForm').submit(function(e) {
            e.preventDefault();
            const id = $('#news_id').val();
            const url = id ?
                "<?= base_url('admin/custom-news/update/') ?>" + id :
                "<?= base_url('admin/custom-news/store') ?>";

            $.post(url, $(this).serialize(), res => {
                if (res.status) {
                    $('#newsModal').modal('hide');
                    table.ajax.reload();
                }
            }, 'json');
        });

        $(document).on('click', '.editBtn', function() {
            const id = $(this).data('id');
            $.getJSON("<?= base_url('admin/custom-news/edit/') ?>" + id, res => {
                $('#news_id').val(res.id);
                $('#title').val(res.title);
                $('#news_link').val(res.news_link).trigger('change');
                $('#newsModal').modal('show');
            });
        });

        $(document).on('click', '.deleteBtn', function() {

            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This news will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.post("<?= base_url('admin/custom-news/delete/') ?>" + id, function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'News deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        table.ajax.reload();

                    }, 'json');

                }
            });
        });

        /* ========== LIVE PREVIEW ========== */
        $('#news_link').on('keyup change blur', function() {
            let url = $(this).val();
            if (!url) return;

            // YouTube preview
            if (url.includes('youtube') || url.includes('youtu.be')) {
                let id = url.includes('v=') ? url.split('v=')[1].split('&')[0] : url.split('/').pop();
                $('#previewBox').html(
                    `<iframe width="100%" height="250"
                    src="https://www.youtube.com/embed/${id}"
                    frameborder="0" allowfullscreen></iframe>`
                );
                return;
            }

            // Website preview (OG metadata)
            $('#previewBox').html('Loading preview...');

            $.post(
                '<?= base_url("admin/custom-news/link-preview") ?>', {
                    url: url
                },
                function(res) {
                    if (!res || !res.title) {
                        $('#previewBox').html(`<a href="${url}" target="_blank">${url}</a>`);
                        return;
                    }

                    $('#previewBox').html(`
                    <div style="border:1px solid #ddd;padding:10px;border-radius:6px;display:flex;gap:10px;">
                        ${res.image ? `<img src="${res.image}" style="width:120px;height:80px;object-fit:cover;">` : ''}
                        <div>
                            <strong>${res.title}</strong>
                            <p style="margin:5px 0;font-size:13px;">${res.description || ''}</p>
                            <a href="${res.url}" target="_blank">${res.url}</a>
                        </div>
                    </div>
                `);
                },
                'json'
            );
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
            text: "You want to " + actionText + " this news?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('admin/custom-news/change-status') ?>",
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

                            $('#customNewsTable').DataTable().ajax.reload(null, false);

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