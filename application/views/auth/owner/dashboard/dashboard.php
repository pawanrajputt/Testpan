<div class="col-12 col-lg-10 p-0">
    <div class="booking-center active">
        <!-- ///////////// Header section start -->
        <div class="my-booking-wrapper d-flex justify-content-between align-items-center py-3 border-bottom">

            <div class="my-booking-header ps-4">
                <h2 class="m-0 fs-3 text-white">My Dashboard</h2>

            </div>

            <?php $this->load->view('auth/owner/dashboard/common/notification'); ?>

        </div>

        <!-- Overview box -->
        <div class="container mt-4">
            <div class="row">
                <!-- Total Centers Box -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-white p-0" style="background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-75 mb-2 fw-bold fs-5">Total Centers</h6>
                                    <h2 class="fw-bold mb-0 text-white fs-3"><?= count($centers) ?></h2>
                                    <small class="text-white-75">All registered centers</small>
                                </div>
                                <div class="bg-white bg-opacity-25 px-3 py-2 rounded-circle">
                                    <i class="bi bi-bank fs-3 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved Centers Box -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-white p-0" style="background: linear-gradient(135deg, #10B981 0%, #047857 100%);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-75 mb-2 fs-5 fw-bold">Approved Centers</h6>
                                    <h2 class="fw-bold mb-0 text-white fs-4">
                                        <?= count(array_filter($centers, fn($c) => (int)$c['approved'] === 1)) ?>
                                    </h2>
                                    <small class="text-white-75">Active and running</small>
                                </div>
                                <div class="bg-white bg-opacity-25 px-3 py-2 rounded-circle">
                                    <i class="bi bi-check-circle fs-3 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Centers Box -->
                <div class="col-md-4 mb-4 ">
                    <div class="card border-0 shadow-sm h-100 text-white p-0" style="background: linear-gradient(135deg, #FACC15 0%, #EAB308 45%, #CA8A04 100%);box-shadow: 0 10px 25px rgba(234, 179, 8, 0.25);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-75 mb-2 fw-bold fs-5">Pending Centers</h6>
                                    <h2 class="fw-bold mb-0 text-white fs-3">
                                        <?= count(array_filter($centers, fn($c) => (int)$c['approved'] !== 1)) ?>
                                    </h2>
                                    <small class="text-white-75">Under review</small>
                                </div>
                                <div class="bg-white bg-opacity-25 px-3 py-2 rounded-circle">
                                    <i class="bi bi-clock-history fs-3 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-4 mb-2 container">
            <a target="_blank"
                class="btn btn-primary text-white fw-semibold px-4 py-2 shadow-sm"
                href="<?= base_url('create-center') ?>">
                <i class="bi bi-plus-circle me-2"></i>
                Create New Center
            </a>
        </div>

        <!-- Table section -->
        <div class="main-contant mt-0">
            <div class="mt-1">
                <?php if (empty($centers)): ?>
                    <div class="alert alert-warning">
                        No centers found for this account.
                    </div>
                <?php else: ?>
                    <div class="border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="centersTable" class="table table-hover table-striped align-middle w-100">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col" class="ps-4">Center Name</th>
                                            <th scope="col">City</th>
                                            <th scope="col">Total Systems/Labs</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center pe-4">Action</th>
                                            <th scope="col">Created On</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php foreach ($centers as $center): ?>
                                            <tr class="<?= (int)$center['approved'] === 1 ? 'table-active' : '' ?>">
                                                <td class="ps-4 fw-semibold">
                                                    <strong><?= htmlspecialchars($center['center_name']) ?></strong>
                                                </td>
                                                <td>
                                                    <div class="location-cell">
                                                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                                                        <span class="fw-semibold"><?= htmlspecialchars($center['city_name']) ?></span>
                                                        <span class="text-muted mx-1">|</span>
                                                        <span class="text-muted"><?= htmlspecialchars($center['state_name']) ?></span>
                                                        <span class="text-muted mx-1">|</span>
                                                        <span class="text-muted"><?= htmlspecialchars($center['country_name']) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-people me-1"></i>
                                                        <?= htmlspecialchars($center['total_no_system']) . ' / ' . htmlspecialchars($center['total_no_lab']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ((int)$center['approved'] === 1): ?>
                                                        <span class="badge rounded-pill bg-success border-0 text-white px-3 py-2 d-inline-flex align-items-center">
                                                            <i class="bi bi-shield-check me-2"></i>
                                                            Approved
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge rounded-pill bg-warning border-0 text-white px-3 py-2 d-inline-flex align-items-center">
                                                            <i class="bi bi-hourglass-top me-2"></i>
                                                            Under Review
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center pe-4">
                                                    <?php if ((int)$center['approved'] === 1): ?>
                                                        <a href="<?= site_url('select-center/' . $center['id']) ?>"
                                                            class="btn btn-sm btn-primary rounded-pill px-3">
                                                            <i class="bi bi-speedometer2 me-1"></i>
                                                            Go to Dashboard
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>
                                                            <i class="bi bi-hourglass-split me-1"></i>
                                                            Waiting Approval
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date('Y-m-d', strtotime($center['created_on'])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>