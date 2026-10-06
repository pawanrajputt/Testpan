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

        <div class="card">
            <?= form_open_multipart(base_url('admin/custom-settings')); ?>

            <!-- ================= SITE INFO ================= -->
            <div class="card mb-4">
                <div class="card-header fw-bold">Site Information</div>
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Site Title</label>
                        <input type="text" name="site_title" class="form-control"
                            value="<?= $settings['site_title'] ?? '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Site Description</label>
                        <textarea name="site_description" class="form-control" rows="2"><?= $settings['site_description'] ?? '' ?></textarea>
                    </div>

                </div>
            </div>

            <!-- ================= LOGOS ================= -->
            <div class="card mb-4">
                <div class="card-header fw-bold">Header & Footer Logo</div>
                <div class="card-body row g-3">

                    <?php foreach (['header_logo' => 'Header Logo', 'footer_logo' => 'Footer Logo'] as $key => $label): ?>
                        <div class="col-md-6">
                            <label class="form-label"><?= $label ?></label><br>

                            <?php if (!empty($settings[$key])): ?>
                                <img src="<?= base_url('uploads/settings/' . $settings[$key]) ?>" height="60" class="mb-2">
                            <?php else: ?>
                                <small class="text-muted">No logo uploaded</small>
                            <?php endif; ?>

                            <input type="file" name="<?= $key ?>" class="form-control mt-2" accept="image/jpeg, image/png, image/jpg">
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- ================= SUPPORT ================= -->
            <div class="card mb-4">
                <div class="card-header fw-bold">Support Page</div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Support Title</label>
                        <input type="text" name="support_title" class="form-control"
                            value="<?= $settings['support_title'] ?? '' ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Support Email</label>
                        <input type="email" name="support_email" class="form-control"
                            value="<?= $settings['support_email'] ?? '' ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Support Phone</label>
                        <input type="text" name="support_phone" class="form-control"
                            value="<?= $settings['support_phone'] ?? '' ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Support Description</label>
                        <textarea name="support_description" class="form-control" rows="3"><?= $settings['support_description'] ?? '' ?></textarea>
                    </div>

                </div>
            </div>

            <!-- ================= SAVE ================= -->
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-success px-4">Save Settings</button>
            </div>

            <?= form_close(); ?>

            <!-- ================= COMPANY LOGOS ================= -->
            <div class="card mb-4">

                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span>Partner / Company Logos</span>
                    <span class="badge bg-primary">
                        <?= count($company_logos ?? []) ?> Logos
                    </span>
                </div>

                <div class="card-body mt-3">

                    <!-- ADD LOGO -->
                    <form action="<?= base_url('admin/custom-settings/add-company-logo') ?>"
                        method="post"
                        enctype="multipart/form-data">

                        <div class="row g-3 align-items-end">

                            <div class="col-md-4">
                                <label class="form-label">Company Name</label>
                                <input type="text"
                                    name="company_name"
                                    class="form-control"
                                    placeholder="Enter company name"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Company Logo</label>
                                <input type="file"
                                    name="company_logo"
                                    class="form-control"
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Order</label>
                                <input type="number"
                                    name="sort_order"
                                    class="form-control"
                                    value="0"
                                    min="0">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-plus"></i>
                                    Add Logo
                                </button>
                            </div>

                        </div>

                    </form>


                    <?php if (!empty($company_logos)): ?>

                        <hr class="my-4">

                        <div class="table-responsive">

                            <table class="table table-bordered align-middle">

                                <thead>
                                    <tr>
                                        <th width="8%">Order</th>
                                        <th width="20%">Logo</th>
                                        <th>Company</th>
                                        <th width="12%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($company_logos as $logo): ?>

                                        <tr>

                                            <td>
                                                <?= (int) $logo['sort_order'] ?>
                                            </td>

                                            <td>
                                                <img
                                                    src="<?= base_url('uploads/settings/company_logos/' . $logo['logo']) ?>"
                                                    alt="<?= htmlspecialchars($logo['company_name']) ?>"
                                                    style="max-height:60px; max-width:180px; object-fit:contain;">
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($logo['company_name']) ?>
                                            </td>

                                            <td>
                                                <?php if ($logo['status']): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <a href="<?= base_url('admin/custom-settings/delete-company-logo/' . $logo['id']) ?>"
                                                    class="btn btn-sm btn-danger delete-company-logo">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="text-center text-muted py-4">
                            No company logos added yet.
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>


    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<script>
    $(document).on('click', '.delete-company-logo', function(e) {
        e.preventDefault();

        let deleteUrl = $(this).attr('href');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to remove this company logo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }

        });
    });
</script>