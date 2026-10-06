<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row g-6 mb-3">

        <!-- Total Clients -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/clients') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-info h-100 stat-gradient-1">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="fa fa-users ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['total_clients'] ?? 0 ?></h2>
                            <p>Total Clients</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Centers -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/centers') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-info h-100 stat-gradient-2">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-building ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['total_centers'] ?? 0 ?></h2>
                            <p>Total Centers</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Projects (FY) -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/client-projects') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-success h-100 stat-gradient-3">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-trophy ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['projects_year'] ?? 0 ?></h2>
                            <p>Projects (FY)</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Projects (Month) -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/client-projects') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-warning h-100 stat-gradient-4">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-calendar ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['projects_month'] ?? 0 ?></h2>
                            <p>Projects (This Month)</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Today Bookings -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/client-projects?type=today') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-warning h-100 stat-gradient-5">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-calendar-event ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['today_bookings'] ?? 0 ?></h2>
                            <p>Today Bookings</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Upcoming Projects -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/client-projects?type=upcoming') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-primary h-100 stat-gradient-6">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-calendar-time ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['upcoming_projects'] ?? 0 ?></h2>
                            <p>Upcoming Projects</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Completed Projects -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/client-projects?type=completed') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-dark h-100 stat-gradient-7">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-checkup-list ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['completed_projects'] ?? 0 ?></h2>
                            <p>Completed Projects</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Mapped Cities -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card stat-card-info h-100 stat-gradient-8">
                <div class="card-body position-relative overflow-hidden">
                    <div class="stat-icon">
                        <i class="ti ti-map ti-100px"></i>
                    </div>
                    <div class="stat-content">
                        <h2><?= $stats['mapped_cities'] ?? 0 ?></h2>
                        <p>Mapped Cities</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Country Mapped -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card stat-card-primary h-100 stat-gradient-9">
                <div class="card-body position-relative overflow-hidden">
                    <div class="stat-icon">
                        <i class="ti ti-world ti-100px"></i>
                    </div>
                    <div class="stat-content">
                        <h2><?= $stats['country_mapped'] ?? 0 ?></h2>
                        <p>Country Mapped</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- BMTC Mobile APP Venue -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/centers') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-warning h-100 stat-gradient-10">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-device-mobile ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['bmtc_app_venue'] ?? 0 ?></h2>
                            <p>BMTC Mobile APP Venue</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Subscribed Owners -->
        <!-- <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/center-owners') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-success h-100 stat-gradient-11">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-crown ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['subscribed_owners'] ?? 0 ?></h2>
                            <p>Subscribed Owners</p>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->

        <!-- Non Subscribed Owners -->
        <!-- <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/center-owners') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-warning h-100 stat-gradient-12">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-user-off ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= $stats['non_subscribed_owners'] ?? 0 ?></h2>
                            <p>Non Subscribed Owners</p>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->


        <!-- Allocated Seats -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/project-planner') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-primary h-100 stat-gradient-4">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-armchair-2 ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= number_format($stats['allocated_seats'] ?? 0) ?></h2>
                            <p>Allocated Seats</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Manpower Deployed -->
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/project-planner') ?>" class="text-decoration-none">
                <div class="card stat-card stat-card-success h-100 stat-gradient-2">
                    <div class="card-body position-relative overflow-hidden">
                        <div class="stat-icon">
                            <i class="ti ti-users-group ti-100px"></i>
                        </div>
                        <div class="stat-content">
                            <h2><?= number_format($stats['allocated_manpower'] ?? 0) ?></h2>
                            <p>Manpower Deployed</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>


    <div class="row g-6">

        <!-- Table -->
        <?php if (has_permission('client_project')): ?>
            <div class="card mt-6">
                <div class="card-header text-center bg-primary">
                    <h5 class="text-white mb-0">
                        <?= strtoupper(date('M Y')) ?> PROJECTS
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-warning text-center">
                            <tr>
                                <th>Exam Name</th>
                                <th>Client Name</th>
                                <th>Exam Date</th>
                                <th>Seats</th>
                                <th>REQUIREMENT</th>
                                <th>Cities</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($stats['current_month_projects'])) : ?>

                                <?php foreach ($stats['current_month_projects'] as $row) :

                                    $encodedProjectId = rtrim(
                                        strtr(
                                            base64_encode($row['project_id']),
                                            '+/',
                                            '-_'
                                        ),
                                        '='
                                    );


                                    // =====================================================
                                    // CITY-WISE SEAT ALLOCATION
                                    // =====================================================

                                    $seat = getProjectSeatAllocation(
                                        $row['project_id'],
                                        $row['exam_city_id']
                                    );


                                    $requiredSeats =
                                        $seat['required'];

                                    $allocatedSeats =
                                        $seat['allocated'];


                                    // =====================================================
                                    // SEAT PROGRESS
                                    // =====================================================

                                    $seatProgress =
                                        getSeatProgressHtml($seat);


                                    // =====================================================
                                    // ALLOCATION / REQUIREMENT STATUS
                                    // =====================================================

                                    $allocationStatus =
                                        $seat['badge'];

                                ?>

                                    <tr class="text-center">

                                        <!-- Project -->

                                        <td class="text-start fw-semibold">

                                            <?= ucwords(
                                                $row['exam_name']
                                            ) ?>

                                            <br>

                                            <small>
                                                Exam Type:
                                                <?= ucfirst(
                                                    $row['exam_type']
                                                ) ?>
                                            </small>

                                            <br>

                                            <small>
                                                ProjectId:
                                                <?= ucfirst(
                                                    $row['project_id']
                                                ) ?>
                                            </small>

                                        </td>


                                        <!-- Company -->

                                        <td class="text-start fw-semibold">

                                            <?= strtoupper(
                                                $row['username']
                                            ) ?>

                                            <br>

                                            <small>
                                                Company Name:
                                                <?= strtoupper(
                                                    $row['company_name']
                                                ) ?>
                                            </small>

                                            <br>

                                            <small>
                                                Company Type:
                                                <?= ucfirst(
                                                    $row['company_type']
                                                ) ?>
                                            </small>

                                        </td>


                                        <!-- Date -->

                                        <td>

                                            <?= date(
                                                'd M',
                                                strtotime(
                                                    $row['start_date']
                                                )
                                            ) ?>

                                            -

                                            <?= date(
                                                'd M Y',
                                                strtotime(
                                                    $row['end_date']
                                                )
                                            ) ?>

                                        </td>


                                        <!-- =================================================
                                        SEAT PROGRESS
                                        ================================================= -->

                                        <td class="text-center">

                                            <?= $seatProgress ?>

                                        </td>


                                        <!-- =================================================
                                        ALLOCATION STATUS
                                        ================================================= -->

                                        <td class="text-center">

                                            <?= $allocationStatus ?>

                                        </td>


                                        <!-- City -->

                                        <td>

                                            <?= $row['city_name'] ?>

                                        </td>


                                        <!-- Status -->

                                        <?php

                                        $projectStatus =
                                            getProjectStatusBadge(
                                                $row
                                            );

                                        ?>

                                        <td>

                                            <?= $projectStatus ?>

                                        </td>


                                        <!-- Action -->

                                        <td>

                                            <a
                                                target="_blank"
                                                href="<?= base_url(
                                                            'admin/view-project-detail/' .
                                                                $encodedProjectId .
                                                                '/' .
                                                                $row['exam_city_id']
                                                        ) ?>"
                                                class="btn btn-sm btn-success mb-1">
                                                View Detail
                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center">
                                        No projects found for this month
                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>