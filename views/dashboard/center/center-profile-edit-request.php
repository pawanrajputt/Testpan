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


        <div class="module-statistics" id="center-edit-request-statistics">

            <!-- Total Requests -->
            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <i class="ti ti-edit"></i>
                </div>

                <div class="stat-content">
                    <span>Total Requests</span>
                    <strong><?= $total_requests ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Pending Edit Requests
                </div>
            </div>

        </div>

        <form method="get" action="<?= base_url('admin/center-edit-request') ?>">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label">Exam Center</label>
                            <select name="center_id" class="form-control select2 form-select select-center">
                                <option value="">All Centers</option>
                                <?php foreach ($centerData as $row) { ?>
                                    <option value="<?= $row['id'] ?>"
                                        <?= ($this->input->get('center_id') == $row['id']) ? 'selected' : '' ?>>
                                        <?= $row['center_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            <a href="<?= base_url('admin/center-edit-request') ?>"
                                class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </form>


        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="projectTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Center Name</th>
                            <th>Owner Detail</th>
                            <th>Total System/Labs</th>
                            <th>City</th>
                            <th>Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)) { ?>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?= $row->center_name ?></td>
                                    <td>
                                        <small>Owner Name: <?= $row->owner_name  ?></small><br>
                                        <small>Owner Email: <?= $row->owner_email  ?></small><br>
                                        <small>Owner Mobile: <?= $row->owner_phone  ?></small><br>
                                    </td>
                                    <td><?= $row->total_no_system . '/' . $row->total_no_lab ?></td>
                                    <td>
                                        <small><strong>Country:</strong> <?= $row->country ?></small>
                                        <br><small><strong>State:</strong> <?= $row->state ?></small>
                                        <br><small><strong>City:</strong> <?= $row->city_name ?></small>
                                    </td>

                                    <td>
                                        <span class="badge bg-warning">
                                            Pending
                                        </span>
                                        <br>
                                        <p class="mt-2"><strong>Message : </strong> <?= $row->request_message ?></p>
                                    </td>

                                    <td>
                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-success"
                                            onclick="confirmAction('<?= base_url('admin/approve-center-edit/' . $row->id) ?>', 'approve')">
                                            Approve
                                        </a>

                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmAction('<?= base_url('admin/reject-center-edit/' . $row->id) ?>', 'reject')">
                                            Reject
                                        </a>
                                    </td>

                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No edit requests found
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<script>
    function confirmAction(url, type) {

        let title = '';
        let text = '';
        let icon = '';

        if (type === 'approve') {
            title = 'Are you sure?';
            text = "You want to approve this request!";
            icon = 'success';
        } else {
            title = 'Are you sure?';
            text = "You want to reject this request!";
            icon = 'warning';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: type === 'approve' ? '#28a745' : '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, ' + type + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>