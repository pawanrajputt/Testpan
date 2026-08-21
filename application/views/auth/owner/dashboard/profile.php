<div class="col-10 p-0">
    <div class="booking-center active">
        <!-- Header section -->
        <div class="my-booking-wrapper d-flex justify-content-between align-items-center py-3">

            <div class="my-booking-header ps-4">
                <h2 class="m-0 fs-3 text-white">Profile</h2>

            </div>

            <?php $this->load->view('auth/owner/dashboard/common/notification'); ?>

        </div>

        <div class="main-contant">
            <div class="container py-4">
                <!-- Tab 1: Profile Form -->
                <div class="row" id="profileTab">
                    <div class="col-md-8 mx-auto">
                        <div class="card border-0 shadow-sm" style="background-color: #EFF6FF;">
                            <div class="card-header bg-transparent text-center border-0 pt-4">
                                <h4 class="fw-bold mb-0">
                                    <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                                    Profile Information
                                </h4>
                                <p class="text-muted mb-0">Update your personal information</p>
                            </div>

                            <div class="card-body p-4">
                                <form id="OwnerProfileForm" enctype="multipart/form-data">
                                    <?php
                                    $initials = '';

                                    if (!empty($owner->username)) {
                                        $words = explode(' ', trim($owner->username));

                                        foreach ($words as $word) {
                                            $initials .= strtoupper(substr($word, 0, 1));
                                        }

                                        $initials = substr($initials, 0, 2);
                                    }
                                    ?>

                                    <?php if (!empty($owner->profile_pic)) { ?>

                                        <img src="<?= base_url('uploads/owner_profile/' . $owner->profile_pic) ?>"
                                            class="rounded-circle mb-3 profile-avatar"
                                            width="50"
                                            height="50"
                                            style="object-fit:cover;">

                                    <?php } else { ?>

                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3"
                                            style="width:50px;height:50px;font-weight:600;">
                                            <?= $initials ?>
                                        </div>

                                    <?php } ?>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-image me-1 text-primary"></i>
                                            Profile Picture
                                        </label>

                                        <input type="file"
                                            class="form-control"
                                            name="profile_pic"
                                            accept="image/*">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-person me-1 text-primary"></i>
                                            Full Name
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person text-muted"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0"
                                                name="name"
                                                value="<?= htmlspecialchars($owner->username) ?>"
                                                placeholder="Enter your full name">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-envelope me-1 text-primary"></i>
                                            Email Address
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope text-muted"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 ps-0"
                                                name="email"
                                                value="<?= htmlspecialchars($owner->email) ?>"
                                                placeholder="Enter your email address">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-phone me-1 text-primary"></i>
                                            Mobile Number
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-telephone text-muted"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0 bg-light"
                                                value="<?= htmlspecialchars($owner->mobile_phone) ?>"
                                                disabled>
                                            <span class="input-group-text bg-success bg-opacity-10 text-white border-start-0">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Verified
                                            </span>
                                        </div>
                                        <small class="text-muted">Contact support to change mobile number</small>
                                    </div>

                                    <!-- Owner Documents -->
                                    <div class="border-top pt-4 mt-3">

                                        <h6 class="fw-bold mb-3">
                                            <i class="bi bi-file-earmark-text me-1 text-primary"></i>
                                            Identity Documents
                                        </h6>

                                        <div class="row g-3">

                                            <!-- PAN Card -->
                                            <div class="col-md-6">
                                                <div class="border rounded-3 p-3 bg-white h-100">

                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-credit-card-2-front me-1 text-primary"></i>
                                                        PAN Card
                                                    </label>

                                                    <?php if (!empty($owner->owner_pan_card)) { ?>

                                                        <?php
                                                        $panUrl = base_url(
                                                            'uploads/temp_owner_documents/' . $owner->owner_pan_card
                                                        );

                                                        $panExtension = strtolower(
                                                            pathinfo($owner->owner_pan_card, PATHINFO_EXTENSION)
                                                        );
                                                        ?>

                                                        <div class="document-preview mb-3">

                                                            <?php if (in_array($panExtension, ['jpg', 'jpeg', 'png', 'webp'])) { ?>

                                                                <img src="<?= $panUrl ?>"
                                                                    class="img-fluid rounded border"
                                                                    style="height:140px;width:100%;object-fit:contain;background:#f8f9fa;">

                                                            <?php } else { ?>

                                                                <div class="d-flex align-items-center justify-content-center border rounded"
                                                                    style="height:140px;background:#f8f9fa;">
                                                                    <div class="text-center">
                                                                        <i class="bi bi-file-earmark-pdf text-danger"
                                                                            style="font-size:45px;"></i>
                                                                        <div class="small text-muted">PDF Document</div>
                                                                    </div>
                                                                </div>

                                                            <?php } ?>

                                                        </div>

                                                        <div class="d-flex justify-content-between align-items-center mb-3">

                                                            <span class="badge bg-success bg-opacity-10 text-success text-white">
                                                                <i class="bi bi-check-circle me-1 text-white"></i>
                                                                Uploaded
                                                            </span>

                                                            <a href="<?= $panUrl ?>"
                                                                target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye me-1"></i>
                                                                View
                                                            </a>

                                                        </div>

                                                    <?php } else { ?>

                                                        <div class="d-flex align-items-center justify-content-center border rounded mb-3"
                                                            style="height:140px;background:#f8f9fa;">

                                                            <div class="text-center text-muted">
                                                                <i class="bi bi-file-earmark-x"
                                                                    style="font-size:40px;"></i>

                                                                <div class="small mt-2 text-white">
                                                                    Not Uploaded Yet
                                                                </div>
                                                            </div>

                                                        </div>

                                                    <?php } ?>

                                                    <input type="file"
                                                        class="form-control"
                                                        name="owner_pan_card"
                                                        id="owner_pan_card"
                                                        accept=".jpg,.jpeg,.png,.pdf">

                                                    <small class="text-muted">
                                                        JPG, PNG or PDF. Maximum 5 MB.
                                                    </small>

                                                </div>
                                            </div>


                                            <!-- Aadhaar Card -->
                                            <div class="col-md-6">
                                                <div class="border rounded-3 p-3 bg-white h-100">

                                                    <label class="form-label fw-semibold" style="width: 100%;">
                                                        <i class="bi bi-person-vcard me-1 text-primary"></i>
                                                        Aadhaar Card
                                                    </label>

                                                    <?php if (!empty($owner->owner_aadhaar_card)) { ?>

                                                        <?php
                                                        $aadhaarUrl = base_url(
                                                            'uploads/temp_owner_documents/' . $owner->owner_aadhaar_card
                                                        );

                                                        $aadhaarExtension = strtolower(
                                                            pathinfo($owner->owner_aadhaar_card, PATHINFO_EXTENSION)
                                                        );
                                                        ?>

                                                        <div class="document-preview mb-3">

                                                            <?php if (in_array($aadhaarExtension, ['jpg', 'jpeg', 'png', 'webp'])) { ?>

                                                                <img src="<?= $aadhaarUrl ?>"
                                                                    class="img-fluid rounded border"
                                                                    style="height:140px;width:100%;object-fit:contain;background:#f8f9fa;">

                                                            <?php } else { ?>

                                                                <div class="d-flex align-items-center justify-content-center border rounded"
                                                                    style="height:140px;background:#f8f9fa;">
                                                                    <div class="text-center">
                                                                        <i class="bi bi-file-earmark-pdf text-danger"
                                                                            style="font-size:45px;"></i>
                                                                        <div class="small text-muted">PDF Document</div>
                                                                    </div>
                                                                </div>

                                                            <?php } ?>

                                                        </div>

                                                        <div class="d-flex justify-content-between align-items-center mb-3">

                                                            <span class="badge bg-success bg-opacity-10 text-success text-white">
                                                                <i class="bi bi-check-circle me-1 text-white"></i>
                                                                Uploaded
                                                            </span>

                                                            <a href="<?= $aadhaarUrl ?>"
                                                                target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye me-1"></i>
                                                                View
                                                            </a>

                                                        </div>

                                                    <?php } else { ?>

                                                        <div class="d-flex align-items-center justify-content-center border rounded mb-3"
                                                            style="height:140px;background:#f8f9fa;">

                                                            <div class="text-center text-muted">
                                                                <i class="bi bi-file-earmark-x"
                                                                    style="font-size:40px;"></i>

                                                                <div class="small mt-2 text-white">
                                                                    Not Uploaded Yet
                                                                </div>
                                                            </div>

                                                        </div>

                                                    <?php } ?>

                                                    <input type="file"
                                                        class="form-control"
                                                        name="owner_aadhaar_card"
                                                        id="owner_aadhaar_card"
                                                        accept=".jpg,.jpeg,.png,.pdf">

                                                    <small class="text-muted">
                                                        JPG, PNG or PDF. Maximum 5 MB.
                                                    </small>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="border-top pt-4 mt-3">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-primary" onclick="showTab('mpin')">
                                                Next: Reset MPIN <i class="bi bi-arrow-right ms-1"></i>
                                            </button>
                                            <div>
                                                <button type="reset" class="btn btn-light me-2">
                                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                                    Reset
                                                </button>
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Update Profile
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: MPIN Reset Form -->
                <div class="row d-none" id="mpinTab">
                    <div class="col-md-8 mx-auto">
                        <div class="card border-0 shadow-sm" style="background-color: #EFF6FF;">
                            <div class="card-header bg-white border-0 pt-4">
                                <h4 class="fw-bold mb-0">
                                    <i class="bi bi-shield-lock me-2 text-primary"></i>
                                    Reset MPIN
                                </h4>
                                <p class="text-muted mb-0">Set a new MPIN for secure access</p>
                            </div>

                            <div class="card-body p-4">
                                <form id="MpinResetForm">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-lock me-1 text-primary"></i>
                                            Current MPIN
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-key text-muted"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control border-start-0 ps-0"
                                                name="current_mpin"
                                                placeholder="Enter current MPIN"
                                                maxlength="6">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-lock-fill me-1 text-primary"></i>
                                            New MPIN
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-key-fill text-muted"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control border-start-0 ps-0"
                                                name="new_mpin"
                                                placeholder="Enter new MPIN"
                                                maxlength="6">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Must be 4 digits</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-lock-fill me-1 text-primary"></i>
                                            Confirm New MPIN
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-key-fill text-muted"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control border-start-0 ps-0"
                                                name="confirm_mpin"
                                                placeholder="Confirm new MPIN"
                                                maxlength="6">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="border-top pt-4 mt-3">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-secondary" onclick="showTab('profile')">
                                                <i class="bi bi-arrow-left me-1"></i> Back to Profile
                                            </button>
                                            <div>
                                                <button type="reset" class="btn btn-light me-2">
                                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                                    Clear
                                                </button>
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-shield-check me-1"></i>
                                                    Reset MPIN
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab switching function
    function showTab(tabName) {
        if (tabName === 'profile') {
            document.getElementById('profileTab').classList.remove('d-none');
            document.getElementById('mpinTab').classList.add('d-none');

            // Update wizard steps
            document.querySelectorAll('.btn.rounded-circle')[0].className = 'btn btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center';
            document.querySelectorAll('.btn.rounded-circle')[1].className = 'btn btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center';

            document.querySelectorAll('.d-flex.justify-content-between.mt-2 span')[0].className = 'text-primary fw-semibold';
            document.querySelectorAll('.d-flex.justify-content-between.mt-2 span')[1].className = 'text-muted';
        } else {
            document.getElementById('profileTab').classList.add('d-none');
            document.getElementById('mpinTab').classList.remove('d-none');

            // Update wizard steps
            document.querySelectorAll('.btn.rounded-circle')[0].className = 'btn btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center';
            document.querySelectorAll('.btn.rounded-circle')[1].className = 'btn btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center';

            document.querySelectorAll('.d-flex.justify-content-between.mt-2 span')[0].className = 'text-muted';
            document.querySelectorAll('.d-flex.justify-content-between.mt-2 span')[1].className = 'text-primary fw-semibold';
        }
    }

    // Toggle password visibility
    function togglePassword(button) {
        const input = button.parentElement.querySelector('input');
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

<style>
    .input-group-text {
        transition: all 0.3s ease;
    }

    .input-group:focus-within .input-group-text {
        background-color: #e7f1ff;
        border-color: #86b7fe;
        color: #0d6efd;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border-color: #86b7fe;
    }

    .card {
        border-radius: 12px;
    }

    .btn.rounded-circle {
        width: 40px;
        height: 40px;
        font-weight: 600;
    }
</style>
<script>
    $('#OwnerProfileForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "<?= site_url('owner-profile-update') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                     setTimeout(()=>location.reload(),1500);

                    if (res.profile_pic_url) {
                        $('.profile-avatar').attr('src', res.profile_pic_url);
                    }
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });
</script>
<script>
    $('#MpinResetForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= site_url('owner-reset-mpin') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $('#MpinResetForm')[0].reset();
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });
</script>