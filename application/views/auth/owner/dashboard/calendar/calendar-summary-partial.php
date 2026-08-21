<style>
    .dashboard-card {
        border: none;
        border-radius: 12px;
        transition: 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .card-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
    }

    .bg-soft-primary {
        background: rgba(13, 110, 253, 0.1);
    }

    .bg-soft-success {
        background: rgba(25, 135, 84, 0.1);
    }

    .bg-soft-warning {
        background: rgba(255, 193, 7, 0.1);
    }

    .bg-soft-danger {
        background: rgba(220, 53, 69, 0.1);
    }

    .text-primary-dark {
        color: #0d6efd;
    }

    .text-success-dark {
        color: #198754;
    }

    .text-warning-dark {
        color: #d39e00;
    }

    .text-danger-dark {
        color: #dc3545;
    }
</style>


<div class="row">

    <!-- Monthly Self -->
    <div class="col-xl-3 col-md-3 col-sm-6 mb-3">
        <div class="card dashboard-card shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #0D6EFD 0%, #0A58CA 45%, #084298 100%);box-shadow: 0 10px 25px rgba(13, 110, 253, 0.25);">
            <div class="card-body d-flex justify-content-between align-items-center p-0">
                <div>
                    <p class=" mb-1 small fw-bold text-white fs-6">Monthly Self Booking</p>
                    <h3 class="mb-0 fw-bold text-white fs-4 fw-bold">
                        <?= $summary['monthly_self'] ?>
                    </h3>
                </div>
                <div class="card-icon bg-primary text-white px-2">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Assigned -->
    <div class="col-xl-3 col-md-3 col-sm-6 mb-3">
        <div class="card dashboard-card shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #198754 0%, #157347 45%, #0F5132 100%);box-shadow: 0 10px 25px rgba(25, 135, 84, 0.25);">
            <div class="card-body d-flex justify-content-between align-items-center p-0">
                <div>
                    <p class="mb-1 small text-white fw-bold fs-6">Monthly Assigned Booking</p>
                    <h3 class="mb-0 fw-bold text-white fs-4">
                        <?= $summary['monthly_assigned'] ?>
                    </h3>
                </div>
                <div class="card-icon bg-success text-white px-2">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Self -->
    <div class="col-xl-3 col-md-3 col-sm-6 mb-3">
        <div class="card dashboard-card shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #ffc107 0%, #eaa900 45%, #d39e00 100%);box-shadow: 0 10px 25px rgba(255, 193, 7, 0.25);">
            <div class="card-body d-flex justify-content-between align-items-center p-0">
                <div>
                    <p class=" mb-1 small text-white fs-6 fw-bold">Overall Self Booking</p>
                    <h3 class="mb-0 fw-bold text-white fs-4">
                        <?= $summary['overall_self'] ?>
                    </h3>
                </div>
                <div class="card-icon bg-warning text-warning-dark px-2">
                    <i class="bi bi-graph-up text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Assigned -->
    <div class="col-xl-3 col-md-3 col-sm-6 mb-3">
        <div class="card dashboard-card shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 45%, #b01727 100%);box-shadow: 0 10px 25px rgba(220, 53, 69, 0.25);">
            <div class="card-body d-flex justify-content-between align-items-center p-0">
                <div>
                    <p class="mb-1 small text-white fs-6 fw-bold">Overall Assigned Booking</p>
                    <h3 class="mb-0 fw-bold text-white fs-4">
                        <?= $summary['overall_assigned'] ?>
                    </h3>
                </div>
                <div class="card-icon bg-danger text-danger-dark px-2">
                    <i class="bi bi-bar-chart text-white"></i>
                </div>
            </div>
        </div>
    </div>

</div>