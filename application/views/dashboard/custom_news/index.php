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

    .news-preview iframe {
        border-radius: 6px;
    }

    .custom-image-preview {
        position: relative;
        display: inline-block;
    }

    .custom-image-preview img {
        width: 180px;
        height: 110px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }
</style>

<!-- MODAL -->
<div class="modal fade" id="newsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="newsForm" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">Add / Edit News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="news_id" name="id">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text"
                            class="form-control"
                            name="title"
                            id="title"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">News Link</label>
                        <input type="url"
                            class="form-control"
                            name="news_link"
                            id="news_link"
                            required>
                    </div>

                    <!-- Preview -->
                    <div id="previewBox" class="mb-3"></div>

                    <!-- Custom Image Upload -->
                    <div id="customImageBox" class="mb-3" style="display:none;">

                        <label class="form-label">
                            Custom Preview Image
                        </label>

                        <input type="file"
                            class="form-control"
                            name="custom_image"
                            id="custom_image"
                            accept="image/jpeg,image/png,image/webp">

                        <small class="text-muted">
                            Upload an image if no preview image is available.
                            JPG, PNG or WEBP only.
                        </small>

                        <!-- Selected custom image preview -->
                        <div id="customImagePreview" class="mt-2"></div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">
                        Save
                    </button>
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


        /* ==========================================
           ADD NEWS
        ========================================== */

        $('#addNewsBtn').click(function() {

            $('#newsForm')[0].reset();

            $('#news_id').val('');

            $('#previewBox').html('');

            $('#customImageBox').hide();

            $('#customImagePreview').html('');

            $('#custom_image').val('');

            $('#newsModal').modal('show');
        });


        /* ==========================================
           CUSTOM IMAGE SELECT PREVIEW
        ========================================== */

        $('#custom_image').on('change', function() {

            const file = this.files[0];

            if (!file) {
                $('#customImagePreview').html('');
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Image',
                    text: 'Please select JPG, PNG or WEBP image.'
                });

                $(this).val('');
                $('#customImagePreview').html('');

                return;
            }

            const imageUrl = URL.createObjectURL(file);

            $('#customImagePreview').html(`
                <div class="custom-image-preview">
                    <img src="${imageUrl}" alt="Custom Preview">
                </div>
            `);
        });


        /* ==========================================
           SAVE / UPDATE NEWS
        ========================================== */

        $('#newsForm').submit(function(e) {

            e.preventDefault();

            const id = $('#news_id').val();

            const url = id ?
                "<?= base_url('admin/custom-news/update/') ?>" + id :
                "<?= base_url('admin/custom-news/store') ?>";

            const formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,

                beforeSend: function() {

                    $('#newsForm button[type="submit"]')
                        .prop('disabled', true)
                        .text('Saving...');
                },

                success: function(res) {

                    if (res.status) {

                        $('#newsModal').modal('hide');

                        table.ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: id ?
                                'News updated successfully.' :
                                'News added successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message || 'Something went wrong.'
                        });
                    }
                },

                error: function() {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while saving news.'
                    });
                },

                complete: function() {

                    $('#newsForm button[type="submit"]')
                        .prop('disabled', false)
                        .text('Save');
                }
            });
        });


        /* ==========================================
           EDIT NEWS
        ========================================== */

        $(document).on('click', '.editBtn', function() {

            const id = $(this).data('id');

            $.getJSON(
                "<?= base_url('admin/custom-news/edit/') ?>" + id,
                function(res) {

                    $('#news_id').val(res.id);

                    $('#title').val(res.title);

                    $('#news_link').val(res.news_link);

                    $('#custom_image').val('');

                    $('#customImagePreview').html('');

                    /*
                     * Existing preview image
                     */
                    if (res.preview_image) {

                        $('#previewBox').html(`
                            <div style="
                                border:1px solid #ddd;
                                padding:10px;
                                border-radius:6px;
                            ">

                                <img src="${res.preview_image}"
                                     style="
                                        width:200px;
                                        height:120px;
                                        object-fit:cover;
                                        border-radius:6px;
                                     ">

                                <div class="mt-2">
                                    <small class="text-muted">
                                        Current Preview Image
                                    </small>
                                </div>

                            </div>
                        `);

                        /*
                         * Existing image hai to custom upload
                         * optional rakhenge.
                         */
                        $('#customImageBox').show();

                    } else {

                        $('#previewBox').html('');

                        $('#customImageBox').show();
                    }

                    $('#newsModal').modal('show');
                }
            );
        });


        /* ==========================================
           DELETE NEWS
        ========================================== */

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

                    $.post(
                        "<?= base_url('admin/custom-news/delete/') ?>" + id,
                        function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'News deleted successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            table.ajax.reload();

                        },
                        'json'
                    );
                }
            });
        });


        /* ==========================================
           LIVE PREVIEW
        ========================================== */

        let previewRequest = null;

        $('#news_link').on('keyup change blur', function() {

            let url = $(this).val().trim();

            if (!url) {

                $('#previewBox').html('');

                $('#customImageBox').hide();

                return;
            }


            /* ------------------------------------------
               YouTube Preview
            ------------------------------------------ */

            if (
                url.includes('youtube.com') ||
                url.includes('youtu.be')
            ) {

                let id = '';

                if (url.includes('v=')) {

                    id = url
                        .split('v=')[1]
                        .split('&')[0];

                } else {

                    id = url
                        .split('/')
                        .pop()
                        .split('?')[0];
                }


                $('#previewBox').html(`
                    <div>
                        <iframe
                            width="100%"
                            height="250"
                            src="https://www.youtube.com/embed/${id}"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                `);

                /*
                 * YouTube ke liye custom image ki zarurat nahi.
                 */
                $('#customImageBox').hide();

                return;
            }


            /* ------------------------------------------
               Website Preview
            ------------------------------------------ */

            $('#previewBox').html(`
                <div class="text-muted">
                    Loading preview...
                </div>
            `);

            /*
             * Previous request cancel
             */
            if (previewRequest) {
                previewRequest.abort();
            }


            previewRequest = $.post(
                '<?= base_url("admin/custom-news/link-preview") ?>', {
                    url: url
                },
                function(res) {

                    /*
                     * Preview image available
                     */
                    if (res && res.image) {

                        $('#previewBox').html(`
                            <div style="
                                border:1px solid #ddd;
                                padding:10px;
                                border-radius:6px;
                                display:flex;
                                gap:10px;
                            ">

                                <img src="${res.image}"
                                     style="
                                        width:120px;
                                        height:80px;
                                        object-fit:cover;
                                        border-radius:5px;
                                     ">

                                <div>
                                    <strong>
                                        ${res.title || ''}
                                    </strong>

                                    <p style="
                                        margin:5px 0;
                                        font-size:13px;
                                    ">
                                        ${res.description || ''}
                                    </p>

                                    <a href="${res.url}"
                                       target="_blank">
                                        ${res.url}
                                    </a>
                                </div>

                            </div>
                        `);

                        /*
                         * Automatic image mil gayi.
                         * Custom upload hide.
                         */
                        $('#customImageBox').hide();

                    } else {

                        /*
                         * No image found.
                         * Custom upload show.
                         */
                        $('#previewBox').html(`
                            <div style="
                                border:1px solid #ddd;
                                padding:10px;
                                border-radius:6px;
                            ">

                                <strong>
                                    ${res && res.title
                                        ? res.title
                                        : 'Preview image not available'}
                                </strong>

                                <p style="
                                    margin:5px 0;
                                    font-size:13px;
                                ">
                                    Preview image is not available
                                    for this link.
                                </p>

                                <a href="${url}"
                                   target="_blank">
                                    ${url}
                                </a>

                            </div>
                        `);

                        $('#customImageBox').show();
                    }

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