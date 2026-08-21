<!-- //////////// create an account section start //////////////////////-->
<div class="create_an_account_section page active" id="page1">
    <!-- Header -->
    <div class="px-4 d-flex justify-content-between align-items-center flex-wrap">
        <img src="<?php echo base_url('assets/asserts/BMTC Logo.png') ?>" alt="" class="img-fluid" style="max-width:70px;">
        <a href="https://www.bookmytestcenter.com/" target="_blank"
            class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">
            Back to Website
            <img src="<?php echo base_url('assets/asserts/Line 204.png') ?>" alt="">
        </a>
    </div>
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="card  shadow-lg rounded-4 overflow-hidden">
                    <!-- Body -->
                    <div class="card-body p-0">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">
                                Welcome to BookMyTestCenter
                            </h2>
                            <h5 class="mt-3">
                                Create an account
                            </h5>
                            <p class="text-muted">
                                You are just a few steps away, please give us your details.
                            </p>
                        </div>
                        <!-- Name -->
                        <input type="text"
                            placeholder="Full Name"
                            class="form-control  rounded-3 mb-4"
                            name="name">
                        <!-- Email -->
                        <input type="text"
                            placeholder="Enter your email"
                            class="form-control  rounded-3 mb-4"
                            name="email">
                        <!-- Phone -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <select
                                    class="form-select  rounded-3 country-code custom-select"
                                    name="country_code">
                                    <option value="+91">
                                        Ind (+91)
                                        <img src="<?php echo base_url('assets/asserts/Chevron down.png') ?>" alt="">
                                    </option>
                                </select>
                            </div>
                            <div class="col-8">
                                <input
                                    type="number"
                                    placeholder="Enter your phone number"
                                    class="form-control  rounded-3"
                                    name="mobile_phone">
                            </div>
                        </div>

                        <!-- Center Owner PAN Card -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Owner PAN Card
                            </label>

                            <input
                                type="file"
                                class="form-control rounded-3"
                                name="owner_pan_card"
                                id="owner_pan_card"
                                accept=".jpg,.jpeg,.png,.pdf">

                            <small class="text-muted">
                                JPG, JPEG, PNG or PDF
                            </small>
                        </div>

                        <!-- Center Owner Aadhaar Card -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Owner Aadhaar Card
                            </label>

                            <input
                                type="file"
                                class="form-control rounded-3"
                                name="owner_aadhaar_card"
                                id="owner_aadhaar_card"
                                accept=".jpg,.jpeg,.png,.pdf">

                            <small class="text-muted">
                                JPG, JPEG, PNG or PDF
                            </small>
                        </div>

                        <!-- Terms -->
                        <div class="form-check mb-4">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="1"
                                name="is_agree">
                            <label class="form-check-label">
                                I agree to the
                                <a target="_blank"
                                    href="<?= base_url('cms/' . $privacyPolicy->slug) ?>" class="">
                                    <?= $privacyPolicy->title ?>
                                </a>
                                &
                                <a target="_blank"
                                    href="<?= base_url('cms/' . $termsCondition->slug) ?>" class="">
                                    <?= $termsCondition->title ?>
                                </a>
                            </label>
                        </div>

                        <!-- Button -->
                        <button
                            type="button"
                            class="btn btn-primary w-100 py-2 rounded-3 fw-semibold"
                            id="signupButton"
                            data-form-url="<?php echo base_url('send-otp') ?>">
                            Sign Up
                            <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">
                        </button>
                        <p class="text-center mt-4 mb-0">
                            Already have an account?
                            <a href="#"
                                onclick="showPage(8)"
                                class="fw-bold text-decoration-none">
                                Log in
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //////////// create an account section end ////////////////////////// -->


<!-- /////////////////// phone numberse ction start ///////////////////// -->
<div class="Verify_your_phone_number_section page " id="page2">
    <div class="px-4 d-flex justify-content-between align-items-center flex-wrap">
        <img src="<?php echo base_url('assets/asserts/BMTC Logo.png') ?>" alt="" class="img-fluid" style="max-width:70px;">
        <a href="https://www.bookmytestcenter.com/" target="_blank"
            class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">
            Back to Website
            <img src="<?php echo base_url('assets/asserts/Line 204.png') ?>" alt="">
        </a>
    </div>

    <div class="container d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-8 col-12">

                <div class="Create_phone_number d-flex justify-content-center align-items-center">

                    <div class="form-container">

                        <div class="text-center mb-4">

                            <h2 class="fw-bold mb-2">
                                Verify OTP
                            </h2>

                            <p class="text-muted mb-1">
                                Welcome <span class="username_cls fw-semibold"></span>
                            </p>

                            <p class="text-muted">
                                We've sent a 6-digit OTP to
                                <strong class="otp-phone-number"></strong>
                            </p>

                        </div>

                        <div class="form-wrapper-phone-number d-flex justify-content-between align-items-center">

                            <input type="number" class="otp-each-box">

                            <input type="number" class="otp-each-box">

                            <input type="number" class="otp-each-box">

                            <input type="number" class="otp-each-box">

                            <input type="number" class="otp-each-box">

                            <input type="number" class="otp-each-box">

                        </div>

                        <div class="text-center mt-4">

                            <p class="mb-3">
                                Didn't receive the OTP?
                                <a class="cursor-pointer fw-semibold"
                                    id="resendOtpButton"
                                    data-form-url="<?php echo base_url('resend-otp') ?>">
                                    Resend OTP
                                </a>
                            </p>

                            <button
                                type="button"
                                class="btn sign-up-btn w-100 text-white"
                                id="verifyOtpButton"
                                data-form-url="<?php echo base_url('verify-otp') ?>">

                                Verify OTP

                                <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">

                            </button>

                            <p class="mt-4 mb-0">

                                Wrong phone number?

                                <a href="<?= base_url('/') ?>" class="fw-bold text-decoration-none">

                                    Change

                                </a>

                            </p>

                        </div>

                        <div class="line-indicator mt-4">
                            <div class="first-indicator"></div>
                            <div></div>
                            <div></div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<!-- //////////////// phone number section end //////////////////////// -->


<!-- /////////////// M-pin section start //////////////////////////-->
<div class="M-Pin_section page " id="page3">
    <div class="px-4 d-flex justify-content-between align-items-center flex-wrap">
        <img src="<?php echo base_url('assets/asserts/BMTC Logo.png') ?>" alt="" class="img-fluid" style="max-width:70px;">
        <a href="https://www.bookmytestcenter.com/" target="_blank"
            class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">
            Back to Website
            <img src="<?php echo base_url('assets/asserts/Line 204.png') ?>" alt="">
        </a>
    </div>
    <div class="container d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-12 w-100">

                <div class="Create_phone_number d-flex justify-content-center align-items-center">
                    <div class="form-container">
                        <div class="text-wrapper">
                            <h1 class=" mb-4">Welcome to BookMyTestCenter</h1>
                            <h2>Setup your 4 digit M-Pin</h2>
                            <p>The M-Pin will be used for logging in the future</span></p>
                        </div>
                        <div class="form-wrapper-M-pin d-flex justify-content-between align-items-center">
                            <input type="number" class="mpin-box" name="mpin[]">
                            <input type="number" class="mpin-box" name="mpin[]">
                            <input type="number" class="mpin-box" name="mpin[]">
                            <input type="number" class="mpin-box" name="mpin[]">
                        </div>
                        <div class="mt-3">
                            <div class="my-3">
                                <button type="button" class="btn w-100 sign-up-btn text-white mt-3" data-form-url="<?php echo base_url('store-mpin') ?>" id="mPinCreateButton">Proceed
                                    <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">
                                </button>
                            </div>
                        </div>
                        <div class="line-indicator">
                            <div class="first-indicator"></div>
                            <div class="first-indicator"></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ////////////////// M-pin section end/////////////////////////// -->

<!-- //////////// Welcome back M-pin section start ///////////////// -->
<div class="Welcome_back M-Pin_section page" id="page8">
    <div class="px-4 d-flex justify-content-between align-items-center flex-wrap fixed-top">
        <img src="<?php echo base_url('assets/asserts/BMTC Logo.png') ?>" alt="" class="img-fluid" style="max-width:70px;">
        <div class="d-flex  align-items-center gap-3">
            <a href="https://www.bookmytestcenter.com/" target="_blank"
                class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">
                Back to Website
                <img src="<?php echo base_url('assets/asserts/Line 204.png') ?>" alt="">
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 m-auto mt-3 p-0">
                <div class="Create_phone_number  d-flex justify-content-center align-items-center mt-5">
                    <div class="form-container">
                        <div class="text-wrapper">
                            <h2 class="mb-4">Welcome back</h2>
                            <h5>Enter your 4 digit M-Pin to log in</h5>
                            <p>Good to see you back</p>
                        </div>
                        <div class="form-group mb-3">
                            <input type="number" placeholder="Enter your phone number" class="p-2 w-100 p-10" name="login_mobile_phone" id="login_mobile_phone">
                        </div>
                        <div class="form-wrapper-M-pin d-flex justify-content-between align-items-center">
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin">
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin">
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin">
                            <input type="number" class=" login-mpin-box" name="login_mpin">
                        </div>
                        <div class="mt-3">
                            <div class="my-3">
                                <button type="button" class="btn w-100 sign-up-btn text-white mt-3" id="LoginInBtn" data-form-url="<?php echo base_url('do-login') ?>" data-base-url="<?php echo base_url() ?>">Log in
                                    <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt=""></button>
                            </div>
                            <p class="text-center">Don’t have an account
                                <a href="<?php echo base_url('/') ?>" class="fw-bold text-dark">Sign UP
                                </a>
                            </p>
                            <p class="text-center">Reset/Forgot MPIN
                                <a href="<?php echo base_url('reset-forgot-mpin') ?>" class="fw-bold text-dark">Go
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ////////////// Welcome back M-pin section end ///////////////////////-->

<!-- ////////////////////////////////// Document Modal ////////////////// -->
<div class="modal fade" id="docConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="right: -30%;position: relative;">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    📄 Confirm Required Documents
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-2">

                <div class="required-doc-box">

                    <p class="mb-3 text-muted">
                        Please ensure the following documents are available before proceeding with center registration:
                    </p>

                    <ul class="doc-list">
                        <li>
                            <span class="doc-icon">✔</span>
                            Canceled Cheque
                        </li>

                        <li>
                            <span class="doc-icon">✔</span>
                            GST Certificate
                        </li>

                        <li>
                            <span class="doc-icon">✔</span>
                            Udyam Certificate
                        </li>

                        <li>
                            <span class="doc-icon">✔</span>
                            PAN Card
                        </li>

                        <li>
                            <span class="doc-icon">✔</span>
                            Enter UIDAI Number (if available)
                        </li>
                    </ul>

                </div>

                <div class="alert alert-warning mt-3 mb-2 py-2 px-3">
                    <small>
                        ⚠ You may not be able to complete registration without these documents.
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="confirmDocsBtn">
                    <span class="btn-text">Yes, Proceed</span>
                    <span class="btn-loader d-none">
                        <span class="spinner-border spinner-border-sm"></span>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>