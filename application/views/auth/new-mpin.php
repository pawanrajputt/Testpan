<style>
  .form-input-mpin-cnt {
      margin-bottom: 20px;
  }
</style>

<div class="row">
  <div class="col-4 aside-bg">
    <a href="#" class="aside-heading">BookMyTestCenter</a>
    <div class="aside-tag-wrapper">
      <div class="aside-tag-cnt tab active">
        <div class="icon-box">
          <img src="<?php echo base_url('assets/icon-folder/aside-icon/icon1-grey.png')?>" alt="user-icon-white" class="user-grey" />
          <img src="<?php echo base_url('assets/icon-folder/aside-icon/Active1-white.png')?>" alt="user-icon-grey" class="user-white" />
        </div>
        <div>
          <h3 class="m-0">Reset/Forgit Mpin</h3>
          <p class="m-0">Enter your phone no.</p>
        </div>
      </div>
    </div>
    <p class="company-year">@2016 | Testpan India Private Limited</p>
  </div>
  <div class="col-8 right-section">
    <div class='need-help-otp-cnt'>
        <div class="needHelpWrapper">
          <a href='/'>Need help?</a>
        </div>
    </div>
    <div class="create-account-cnt px-3">
      <form class="form-cnt section tab-content show">
        <div class="form-heading">
          <div class="commom-header-icon">
            <span class="icon-box-form"><img src="<?php echo base_url('assets/icon-folder/aside-icon/login-page-icon.png')?>" alt="" /></span>
          </div>
          <h1 class="mt-3">Reset/Forgot Mpin</h1>
          <p>Enter the mpin</p>
        </div>
        <div class="form-otp-cnt">
          <div class='form-input-mpin-cnt'>
            <input type="number" class="me-2 new-mpin-box mpin-box"/>
            <input type="number" class="me-2 new-mpin-box mpin-box"/>
            <input type="number" class="me-2 new-mpin-box mpin-box"/>
            <input type="number" class="me-2 new-mpin-box mpin-box"/>
          </div>
        </div>
        <div class="form-footer">
          <button type="button" class="proceed-btn" id="updateNewMpinBtn" data-form-url="<?php echo base_url('update-new-mpin-set')?>" data-base-url="<?php echo base_url()?>">Verify Otp
            <img
              src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png')?>" alt="">
          </button>
          <a href="<?php echo base_url('/reset-forgot-mpin-otp')?>">
            <button type="button" class="proceed-btn mt-2">Back To Previous Page
              <img
                src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png')?>" alt="">
            </button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$("#updateNewMpinBtn").click(function () {

    let mpin = "";
    $(".new-mpin-box").each(function () {
        mpin += $(this).val();
    });

    // 🔐 Frontend validation
    if (!mpin) {
        toastr.error("M-PIN is required");
        return;
    }

    if (!/^[0-9]{4}$/.test(mpin)) {
        toastr.error("M-PIN must be exactly 4 digits");
        return;
    }

    let form_url = $(this).data('form-url');

    $.ajax({
        url: form_url,
        type: "POST",
        data: { mpin: mpin },
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        processData: true,
        success: function (response) {
            if (response.status === "success") {
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.href = base_url + "/";
                }, 1000);
            } else {
                toastr.error(response.message);
            }
        }
    });
});
</script>