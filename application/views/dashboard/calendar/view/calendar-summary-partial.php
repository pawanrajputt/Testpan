<div class="row mb-4">

    <!-- This Month Self -->
    <div class="col-xl-2 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-dark bg-opacity-10 p-3 me-3">
                    <i class="fa fa-user-circle text-primary fa-2x"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        This Month Self
                    </small>

                    <h3 class="mb-0 text-primary fw-bold">
                        <?= $summary['monthly_self']; ?>
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <!-- This Month Assigned -->
    <div class="col-xl-2 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="fa fa-tasks text-success fa-2x"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        This Month Assigned
                    </small>

                    <h3 class="mb-0 text-success fw-bold">
                        <?= $summary['monthly_assigned']; ?>
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <!-- This Year Self -->
    <div class="col-xl-2 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                    <i class="fa fa-user-plus text-warning fa-2x"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        This Year Self
                    </small>

                    <h3 class="mb-0 text-warning fw-bold">
                        <?= $summary['overall_self']; ?>
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <!-- This Year Assigned -->
    <div class="col-xl-2 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                    <i class="fa fa-users text-info fa-2x"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        This Year Assigned
                    </small>

                    <h3 class="mb-0 text-info fw-bold">
                        <?= $summary['overall_assigned']; ?>
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <!-- Lifetime Self -->
    <div class="col-xl-2 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                    <i class="fa fa-user-tie text-danger fa-2x"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Lifetime Self
                    </small>

                    <h3 class="mb-0 text-danger fw-bold">
                        <?= $summary['overall_self']; ?>
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <!-- Lifetime Assigned -->
    <div class="col-xl-2 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">

                <div class="rounded-circle bg-dark bg-opacity-10 p-3 me-3">
                    <i class="fa fa-flag-checkered text-dark fa-2x"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Lifetime Assigned
                    </small>

                    <h3 class="mb-0 text-dark fw-bold">
                        <?= $summary['overall_assigned']; ?>
                    </h3>
                </div>

            </div>
        </div>
    </div>

</div>