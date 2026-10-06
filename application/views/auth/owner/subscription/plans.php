<style>
    /* ============================================
       PROFESSIONAL SUBSCRIPTION STYLES
       ============================================ */

    /* ===== MAIN CONTAINER ===== */
    .main-contant {
        max-width: 98%;
        background: linear-gradient(135deg, #f0f4ff 0%, #e8edf5 100%);
        border-radius: 24px;
        padding: 20px;
        margin: 0 auto;
    }

    /* ===== SECTION TITLE ===== */
    .section-title {
        text-align: center;
        padding: 30px 0 20px 0;
    }

    .section-title h2 {
        font-size: 38px;
        font-weight: 800;
        color: #111827;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, #111827 0%, #374151 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-title p {
        color: #6b7280;
        margin-top: 10px;
        font-size: 16px;
        font-weight: 400;
    }

    /* ===== ACTIVE SUBSCRIPTION BOX ===== */
    .current-plan-box {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
        border-left: 5px solid #10b981 !important;
        border-radius: 16px !important;
        padding: 24px 28px !important;
        margin-bottom: 30px !important;
        margin-top: 15px !important;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .current-plan-box:hover {
        box-shadow: 0 8px 35px rgba(16, 185, 129, 0.25);
        transform: translateY(-2px);
    }

    .current-plan-box::before {
        content: '✅';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 48px;
        opacity: 0.10;
    }

    .current-plan-box::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .current-plan-box h5 {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 8px !important;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .current-plan-box h5::before {
        content: '🟢';
        font-size: 14px;
    }

    .current-plan-box p {
        color: #065f46;
        font-size: 15px;
        margin-bottom: 6px !important;
        position: relative;
        z-index: 1;
        opacity: 0.85;
    }

    .current-plan-box strong {
        color: #065f46;
        font-size: 15px;
        font-weight: 700;
        position: relative;
        z-index: 1;
        display: inline-block;
        padding: 6px 16px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 50px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .current-plan-box strong::before {
        content: '📅 ';
        font-size: 13px;
    }

    /* ===== PLAN CARDS ===== */
    .row.g-4.justify-content-center {
        padding: 0 20px;
    }

    .plan-section {
        padding: 25px 10px;
    }

    .card-plan {
        background: #ffffff;
        border-radius: 24px;
        padding: 35px 30px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid #eef2f7;
        height: 100%;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
    }

    .card-plan::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        opacity: 0;
        transition: all 0.4s ease;
    }

    .card-plan:hover::before {
        opacity: 1;
    }

    .card-plan:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.10);
        border-color: #667eea;
    }

    /* ===== PLAN HEADER ===== */
    .plan-header {
        margin-bottom: 25px;
    }

    .plan-name {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        letter-spacing: -0.5px;
    }

    .plan-duration {
        color: #6b7280;
        margin-top: 6px;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        padding: 4px 16px;
        background: #f3f4f6;
        border-radius: 50px;
    }

    /* ===== PRICE ===== */
    .price {
        font-weight: 800;
        color: #111827;
        margin-top: 15px;
        line-height: 1;
    }

    .price span {
        font-size: 16px;
        color: #6b7280;
        font-weight: 500;
    }

    .gst {
        margin-top: 8px;
        color: #6b7280;
        font-size: 13px;
        background: #f8fafc;
        padding: 4px 14px;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid #eef2f7;
    }

    /* ===== FEATURES LIST ===== */
    .features {
        list-style: none;
        padding: 0;
        margin: 30px 0;
        height: 220px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 8px;
    }

    .features li {
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f5;
        color: #374151;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .features li:hover {
        color: #111827;
        transform: translateX(4px);
    }

    .features li:last-child {
        border-bottom: none;
    }

    .features li i {
        color: #10b981;
        margin-right: 12px;
        font-size: 16px;
        background: #ecfdf5;
        padding: 4px;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ===== BUTTON ===== */
    .btn-plan {
        width: 100%;
        border: none;
        border-radius: 14px;
        padding: 14px 20px;
        font-size: 16px;
        font-weight: 700;
        transition: all 0.3s ease;
        color: #ffffff !important;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: block;
        margin-top: auto;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.25);
        letter-spacing: 0.3px;
    }

    .btn-plan:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 35px rgba(102, 126, 234, 0.35);
        color: #ffffff !important;
        text-decoration: none;
    }

    .btn-plan:active {
        transform: scale(0.98);
    }

    .btn-plan.current {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
        cursor: default;
    }

    .btn-plan.current:hover {
        transform: none;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
    }

    /* ===== BADGE POPULAR ===== */
    .badge-popular {
        /* position: absolute; */
        /* top: 18px; */
        /* right: -42px; */
        /* background: linear-gradient(135deg, #f59e0b, #d97706); */
        /* color: #fff; */
        padding: 5px 10px;
        /* transform: rotate(45deg); */
        font-size: 11px;
        font-weight: 700;
        /* text-transform: uppercase; */
        letter-spacing: 0.5px;
        /* box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); */
    }

    /* ===== CURRENT PLAN BADGE ===== */
    .current-plan-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        font-size: 12px;
        padding: 6px 16px;
        border-radius: 50px;
        display: inline-block;
        margin-top: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
    }

    /* ===== CURRENT PLAN CARD ===== */
    .current-plan {
        border: 2px solid #10b981 !important;
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%) !important;
        position: relative;
    }

    .current-plan::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%) !important;
        opacity: 1 !important;
    }

    .current-plan .btn-plan {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
    }

    .current-plan .btn-plan:hover {
        transform: none;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
    }

    .current-plan .plan-name {
        color: #065f46;
    }

    .current-plan .price {
        color: #065f46;
    }

    /* ===== PACKAGE META GRID ===== */
    .package-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 25px;
    }

    .meta-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #eef2f7;
        transition: all 0.3s ease;
    }

    .meta-item:hover {
        border-color: #667eea;
        background: #f0f3ff;
        transform: translateY(-2px);
    }

    .meta-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eef2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #4f46e5;
        flex-shrink: 0;
    }

    .meta-title {
        font-size: 11px;
        color: #94a3b8;
        margin-bottom: 1px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .meta-value {
        font-size: 13px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    /* ===== SCROLLBAR ===== */
    .features::-webkit-scrollbar {
        width: 5px;
    }

    .features::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 20px;
    }

    .features::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 20px;
    }

    .features::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ===== LOADER ===== */
    #pageLoader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        z-index: 999999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    /* ============================================
       RESPONSIVE
       ============================================ */

    @media screen and (max-width: 992px) {
        .section-title h2 {
            font-size: 30px;
        }

        .card-plan {
            padding: 28px 22px;
        }

        .plan-name {
            font-size: 26px;
        }

        .price {
            font-size: 42px;
        }

        .features {
            height: 180px;
        }
    }

    @media screen and (max-width: 768px) {
        .main-contant {
            max-width: 100%;
            padding: 15px;
            border-radius: 16px;
        }

        .section-title h2 {
            font-size: 26px;
        }

        .section-title p {
            font-size: 14px;
        }

        .card-plan {
            padding: 24px 18px;
            border-radius: 18px;
        }

        .plan-name {
            font-size: 24px;
        }

        .price {
            font-size: 36px;
        }

        .price span {
            font-size: 14px;
        }

        .features li {
            font-size: 13px;
            padding: 10px 0;
        }

        .features {
            height: 160px;
        }

        .btn-plan {
            font-size: 14px;
            padding: 12px 16px;
        }

        .current-plan-box {
            padding: 18px 20px !important;
            border-radius: 12px !important;
        }

        .current-plan-box h5 {
            font-size: 16px;
        }

        .current-plan-box p {
            font-size: 14px;
        }

        .current-plan-box strong {
            font-size: 14px;
            padding: 4px 14px;
        }

        .package-meta {
            gap: 8px;
        }

        .meta-item {
            padding: 8px 10px;
        }

        .meta-value {
            font-size: 12px;
        }

        .badge-popular {
            font-size: 9px;
            padding: 4px 35px;
            top: 14px;
            right: -35px;
        }

        .row.g-4.justify-content-center {
            padding: 0 10px;
        }
    }

    @media screen and (max-width: 576px) {
        .main-contant {
            padding: 10px;
            border-radius: 12px;
        }

        .section-title {
            padding: 20px 0 10px 0;
        }

        .section-title h2 {
            font-size: 22px;
        }

        .section-title p {
            font-size: 13px;
        }

        .card-plan {
            padding: 20px 14px;
            border-radius: 14px;
        }

        .plan-name {
            font-size: 20px;
        }

        .plan-duration {
            font-size: 12px;
            padding: 3px 12px;
        }

        .price {
            font-size: 30px;
            margin-top: 10px;
        }

        .price span {
            font-size: 12px;
        }

        .gst {
            font-size: 11px;
            padding: 3px 12px;
        }

        .features {
            height: 140px;
            margin: 20px 0;
            padding-right: 4px;
        }

        .features li {
            font-size: 12px;
            padding: 8px 0;
        }

        .features li i {
            font-size: 12px;
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        .btn-plan {
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 10px;
        }

        .current-plan-box {
            padding: 14px 16px !important;
            margin-bottom: 20px !important;
        }

        .current-plan-box h5 {
            font-size: 14px;
        }

        .current-plan-box p {
            font-size: 13px;
        }

        .current-plan-box strong {
            font-size: 12px;
            padding: 4px 12px;
        }

        .current-plan-box::before {
            font-size: 32px;
            right: 10px;
        }

        .package-meta {
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-bottom: 18px;
        }

        .meta-item {
            padding: 6px 8px;
            border-radius: 8px;
            gap: 6px;
        }

        .meta-icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .meta-title {
            font-size: 9px;
        }

        .meta-value {
            font-size: 11px;
        }

        .badge-popular {
            font-size: 8px;
            padding: 3px 28px;
            top: 12px;
            right: -30px;
        }

        .current-plan-badge {
            font-size: 10px;
            padding: 4px 12px;
        }

        .row.g-4.justify-content-center {
            padding: 0 5px;
        }
    }

    @media screen and (max-width: 400px) {
        .card-plan {
            padding: 16px 12px;
        }

        .plan-name {
            font-size: 18px;
        }

        .price {
            font-size: 26px;
        }

        .features li {
            font-size: 11px;
            padding: 6px 0;
        }

        .btn-plan {
            font-size: 12px;
            padding: 8px 12px;
        }

        .current-plan-box {
            padding: 12px 14px !important;
        }

        .current-plan-box h5 {
            font-size: 13px;
        }

        .current-plan-box p {
            font-size: 12px;
        }

        .current-plan-box strong {
            font-size: 11px;
            padding: 3px 10px;
        }

        .package-meta {
            grid-template-columns: 1fr;
            gap: 4px;
        }
    }
</style>

<div id="pageLoader" style="display:none;">
    <div class="loader-spinner"></div>
</div>

<div class="col-10 p-0">
    <div class="booking-center active">

        <!-- ///////////// Header section start -->
        <div class="my-booking-wrapper d-flex justify-content-between align-items-center py-3 border-bottom">

            <div class="my-booking-header ps-4">
                <h2 class="m-0 fs-3 text-white">Subscription Packages</h2>

            </div>

            <?php $this->load->view('auth/owner/dashboard/common/notification'); ?>

        </div>

        <div class="main-contant">

            <?php if (!empty($current_subscription)) { ?>

                <div class="current-plan-box">

                    <h5 class="mb-2">
                        Active Subscription
                    </h5>

                    <p class="mb-1">
                        Your current subscription is active.
                    </p>

                    <strong>
                        Expiry Date :
                        <?= date('d M Y', strtotime($current_subscription->expiry_date)) ?>
                    </strong>

                </div>

            <?php } ?>

            <div class="section-title">
                <h2>Choose Your Subscription Plan</h2>
                <p class="text-secondary">Flexible plans for your BookMyTestCenter portal</p>
            </div>

            <div class="row g-4 justify-content-center">

                <?php foreach ($packages as $package) { ?>

                    <?php

                    $gst_amount = ($package->price * $package->gst_percent) / 100;

                    $total_amount = $package->price + $gst_amount;

                    ?>

                    <div class="col-lg-4 col-md-6 mb-4">

                        <?php

                        $features = json_decode($package->key_points, true);

                        $is_current = (
                            !empty($current_subscription)
                            &&
                            $current_subscription->package_id == $package->id
                        );

                        ?>

                        <div class="card-plan <?= $is_current ? 'current-plan' : '' ?>">

                            <?php if ($package->is_recommended == 1) { ?>

                                <?php

                                $badge_text_color = '#ffffff';

                                ?>

                                <div class="badge-popular"
                                    style="
                                        background: <?= $package->package_color ?>;
                                        color: <?= $badge_text_color ?>;
                                     ">

                                    <?= !empty($package->tag_line)
                                        ? $package->tag_line
                                        : 'POPULAR'
                                    ?>

                                </div>

                            <?php } ?>



                            <div class="plan-header text-center">

                                <div class="plan-name">

                                    <?= $package->name ?>

                                </div>

                                <div class="plan-duration">

                                    <?= $package->duration ?>
                                    <?= ucfirst($package->duration_type) ?><?= $package->duration > 1 ? 's' : ''; ?>

                                </div>



                                <?php
                                /*
    |--------------------------------------------------------------------------
    | Free Subscription Display
    |--------------------------------------------------------------------------
    */

                                $show_free = (
                                    !empty($package->free_available)
                                    ||
                                    !empty($package->free_unlimited)
                                );

                                $show_free_remaining = (
                                    !empty($package->free_available)
                                    &&
                                    empty($package->free_unlimited)
                                    &&
                                    $package->free_remaining > 0
                                );
                                ?>

                                <?php if ($show_free) { ?>

                                    <div class="price">

                                        <span style="
            text-decoration: line-through;
            font-size: 20px;
            color: #9ca3af;
            margin-right: 8px;
        ">
                                            ₹<?= number_format($package->price) ?>
                                        </span>

                                        <span style="
            font-size: 32px;
            font-weight: 800;
            color: #16a34a;
        ">
                                            FREE
                                        </span>

                                    </div>

                                    <div class="gst" style="
        color: #16a34a;
        font-weight: 600;
    ">

                                        Free subscription
                                        <?php if ($package->free_unlimited) { ?>

                                            · Unlimited free allocations

                                        <?php } ?>

                                    </div>

                                    <?php if ($show_free_remaining) { ?>

                                        <div style="
            margin-top: 6px;
            font-size: 12px;
            color: #dc2626;
            font-weight: 600;
        ">

                                            <?= $package->free_remaining ?>
                                            free slot<?= $package->free_remaining > 1 ? 's' : '' ?>
                                            remaining

                                        </div>

                                    <?php } ?>

                                <?php } else { ?>

                                    <div class="price">

                                        ₹<?= number_format($package->price) ?>

                                        <span>
                                            / <?= $package->duration_type ?>
                                        </span>

                                    </div>

                                    <div class="gst">

                                        ₹<?= number_format($total_amount) ?>

                                        including <?= $package->gst_percent ?>% GST

                                    </div>

                                    <?php if (!empty($package->free_already_used)) { ?>

                                        <div style="
                                                margin-top: 6px;
                                                font-size: 12px;
                                                color: #6b7280;
                                                font-weight: 500;
                                            ">

                                            Free allocation already used

                                        </div>

                                    <?php } elseif (
                                        (int)$package->free_user_limit > 0
                                        &&
                                        (int)$package->free_remaining === 0
                                    ) { ?>

                                        <div style="
                                                margin-top: 6px;
                                                font-size: 12px;
                                                color: #dc2626;
                                                font-weight: 600;
                                            ">

                                            Free quota exhausted

                                        </div>

                                    <?php } ?>

                                <?php } ?>

                                <?php if ($is_current) { ?>

                                    <div class="current-plan-badge">

                                        Active Plan

                                    </div>

                                <?php } ?>

                            </div>

                            <div class="package-meta">

                                <!-- Centers -->

                                <div class="meta-item">

                                    <div class="meta-icon">
                                        <i class="bi bi-building"></i>
                                    </div>

                                    <div>

                                        <div class="meta-title">
                                            Centers
                                        </div>

                                        <div class="meta-value">

                                            <?= $package->max_centers == -1
                                                ? 'Unlimited'
                                                : $package->max_centers
                                            ?>

                                        </div>

                                    </div>

                                </div>



                                <!-- Bookings -->

                                <div class="meta-item">

                                    <div class="meta-icon">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>

                                    <div>

                                        <div class="meta-title">
                                            Bookings
                                        </div>

                                        <div class="meta-value">

                                            <?= $package->max_bookings == -1
                                                ? 'Unlimited'
                                                : number_format($package->max_bookings)
                                            ?>

                                        </div>

                                    </div>

                                </div>



                                <!-- Support -->

                                <div class="meta-item">

                                    <div class="meta-icon">
                                        <i class="bi bi-headset"></i>
                                    </div>

                                    <div>

                                        <div class="meta-title">
                                            Support
                                        </div>

                                        <div class="meta-value">

                                            <?= ucfirst($package->support_type) ?>

                                        </div>

                                    </div>

                                </div>



                                <!-- Verified Badge -->

                                <div class="meta-item">

                                    <div class="meta-icon">
                                        <i class="bi bi-patch-check-fill"></i>
                                    </div>

                                    <div>

                                        <div class="meta-title">
                                            Verified Badge
                                        </div>

                                        <div class="meta-value">

                                            <?= $package->verified_badge == 1
                                                ? 'Included'
                                                : 'Not Included'
                                            ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <ul class="features">

                                <?php foreach ($features as $feature) { ?>

                                    <?php if (!empty(trim($feature))) { ?>

                                        <li>
                                            <i class="bi bi-check-circle-fill"></i>
                                            <?= htmlspecialchars(trim($feature)) ?>
                                        </li>

                                    <?php } ?>

                                <?php } ?>

                            </ul>

                            <?php if ($is_current) { ?>

                                <button class="btn btn-success btn-plan">

                                    Current Active Plan

                                </button>

                            <?php } else { ?>

                                <a href="<?= base_url('purchase-package/' . $package->id) ?>"
                                    class="btn btn-plan choosePlanBtn"
                                    style="
                                        background: <?= $package->package_color ?>;
                                        color:#fff;
                                    ">

                                    <?php if (
                                        !empty($package->free_available)
                                        ||
                                        !empty($package->free_unlimited)
                                    ) { ?>

                                        Get Free Plan

                                    <?php } else { ?>

                                        Choose Plan

                                    <?php } ?>

                                </a>

                            <?php } ?>

                        </div>

                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.choosePlanBtn', function() {
        $('#pageLoader').css('display', 'flex');
    });
</script>