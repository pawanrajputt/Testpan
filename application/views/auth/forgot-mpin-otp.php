<!-- //////////// Welcome back M-pin section start ///////////////// -->
<div class="Welcome_back M-Pin_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 border-end px-0">
                <div class="left-account-box border-bottom d-flex justify-content-between align-items-center p-3 ">
                    <div>
                        <h3 class="m-0">BookMyTestCenter</h3>
                    </div>
                    <div>
                        <a href="<?php echo base_url('/') ?>" class="btn back-to-website">Back to website <img src="<?php echo base_url('assets/asserts/Line 204.png') ?>"
                                alt="right-arrow"></a>
                    </div>
                </div>
                <div class="Create_phone_number  d-flex justify-content-center align-items-center ">
                    <div class="form-container">
                        <div class="text-wrapper">
                            <h2 class="mb-4">Reset/Forgot Mpin</h2>
                            <h5>Enter the otp</h5>
                        </div>
                        <div class="form-wrapper-M-pin d-flex justify-content-between align-items-center">
                            <input type="number" class="me-2 forgot-otp-box otp-each-box">
                            <input type="number" class="me-2 forgot-otp-box otp-each-box">
                            <input type="number" class="me-2 forgot-otp-box otp-each-box">
                            <input type="number" class="me-2 forgot-otp-box otp-each-box">
                            <input type="number" class="me-2 forgot-otp-box otp-each-box">
                            <input type="number" class="me-2 forgot-otp-box otp-each-box">
                        </div>
                        <div class="mt-3">
                            <div class="my-3">
                                <button type="button" class="btn w-100 sign-up-btn text-white mt-3" id="VerifyOtpForResetMpin" data-form-url="<?php echo base_url('verify-reset-forgot-mpin-otp') ?>" data-base-url="<?php echo base_url() ?>">
                                Verify Otp
                                <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">
                                </button>
                                <a href="<?php echo base_url('/reset-forgot-mpin') ?>">
                                   <button type="button" class="btn w-100 sign-up-btn text-white mt-3">
                                    Back To Previous Page
                                    <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 center-profile d-none d-md-block">
                <div class="d-flex justify-content-center align-items-center h-100vh">
                    <div class="testimonial-box">
                        <div class="testimonial-img-box" id="slider1"></div>
                        <div class="testimonial-text-box"></div>
                        <div class="text-center my-3">
                            <h2 class="">Create your Center Profile</h2>
                            <p>Create and showcase your center profiles to get <br> more exam bookings.</p>
                        </div>
                        <div class="sliderIndicator1 center-profile-indecater">
                            <div class="active"></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ////////////// Welcome back M-pin section end ///////////////////////-->

<script>
    $("#VerifyOtpForResetMpin").click(function () {

        let otp = "";
        $(".forgot-otp-box").each(function () {
            otp += $(this).val();
        });
        let form_url = $(this).data('form-url');

        $.ajax({
            url: form_url,
            type: "POST",
            data: { otp: otp },
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            processData: true,
            success: function (response) {
                if (response.status === "success") {
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.href = base_url+"new-mpin-set";
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
</script>