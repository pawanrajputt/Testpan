<style>
    /* Preview container styles */
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .image-preview-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .delete-image-btn {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 0 0 0 4px;
        cursor: pointer;
        font-size: 12px;
        line-height: 20px;
        padding: 0;
    }

    .delete-image-btn:hover {
        background: rgba(255, 0, 0, 1);
    }

    .document-preview-container {
        margin-top: 10px;
    }

    .document-preview-wrapper {
        display: flex;
        align-items: center;
        padding: 8px;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        position: relative;
    }

    .document-icon {
        margin-right: 10px;
        font-size: 24px;
        color: #d32f2f;
        /* Red color for document icons */
    }

    .document-info {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .document-name {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .document-size {
        font-size: 12px;
        color: #6c757d;
    }

    .delete-document-btn {
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 12px;
        line-height: 20px;
        padding: 0;
        margin-left: 10px;
    }

    .delete-document-btn:hover {
        background: rgba(255, 0, 0, 1);
    }

    .pl-33 {
        padding-left: 33.33% !important;
    }

    @media (max-width: 768px) {
        .pl-33 {
            padding-left: 8px !important;
        }

        .indicatorCnt {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }
</style>
<div id="loader" style="display:none; 
    position: fixed; 
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.6); 
    z-index: 9999;
    text-align: center; 
    color: #fff;
    padding-top: 20%;
    font-size: 22px;">
    <div class="spinner-border"></div>
    <br><br>
    Please wait...
</div>
<!-- Aside section start-->
<div class="aside-container">
    <div class="container-fluid">
        <div class="row vh-100" id="signupScreenPage">
            <div class="col-4 aside-bg d-none d-lg-block">
                <a href="#" class="aside-heading">BookMyTestCenter</a>
                <div class="aside-tag-wrapper">
                    <div class="aside-tag-cnt tab active">
                        <div class="icon-box">
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/icon1-grey.png') ?>"
                                alt="user-icon-white" class="user-grey" />
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/Active1-white.png') ?>"
                                alt="user-icon-grey" class="user-white" />
                        </div>
                        <div>
                            <h3 class="m-0">Your details</h3>
                            <p class="m-0">Enter your full name, email & phone no.</p>
                        </div>
                    </div>
                    <div class="aside-tag-cnt tab ">
                        <div class="icon-box">
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/icon-right-grey.png') ?>"
                                alt="circleRight" class="user-grey" />
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/icon-right-white.png') ?>"
                                alt="circleRight" class="user-white" />
                        </div>
                        <div>
                            <h3 class="m-0">Verify your phone number</h3>
                            <p class="m-0">Enter the OTP sent on your phone number</p>
                        </div>
                    </div>
                    <div class="aside-tag-cnt tab">
                        <div class="icon-box">
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/Mpin-grey-icon.png') ?>"
                                alt="Mpin" class="user-grey" />
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/Mpin-white-icon.png') ?>"
                                alt="Mpin" class="user-white" />
                        </div>
                        <div>
                            <h3 class="m-0">Choose your M-PIN</h3>
                            <p class="m-0">Enter your M-PIN for easy access.</p>
                        </div>
                    </div>
                    <div class="aside-tag-cnt tab">
                        <div class="icon-box">
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/compDetails-grey.png') ?>"
                                alt="comp" class="user-grey" />
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/compDatils-white.png') ?>"
                                alt="comp" class="user-white" />
                        </div>
                        <div>
                            <h3 class="m-0">Enter your company details</h3>
                            <p class="m-0">Add the required company information.</p>
                        </div>
                    </div>
                    <div class="aside-tag-cnt tab">
                        <div class="icon-box">
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/welcom-grey.png') ?>"
                                alt="welcom" class="user-grey" />
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/welcom-white.png') ?>"
                                alt="welcom" class="user-white" />
                        </div>
                        <div>
                            <h3 class="m-0">Welcome to BookMyTestCenter</h3>
                            <p class="m-0">Get started right away.</p>
                        </div>
                    </div>
                </div>
                <p class="company-year">@2016 | Testpan India Private Limited</p>
            </div>
            <div class="col-8 right-section w-100 mx-auto">
                <div class='need-help-otp-cnt'>
                    <button button=" submit" class='go-back-btn mainGoBackBtn' id="mainGoBackBtn"><img
                    src="<?php echo base_url('assets/icon-folder/project-icons/Arrow-left.png') ?>" alt=""
                    class="me-2">Go back</button>
            </div>
            <div class="create-account-cnt px-3 pl-33">
                <div id="ACForm">
                    <input type="hidden" id="ACFormUrl" value="<?php echo base_url('store-ac-data') ?>">
                    <input type="hidden" value="<?= base_url() ?>" class="base_url">
                    <!-- /////////////////login part//////////////// -->
                    <form class="form-cnt section tab-content show">
                        <div class="form-heading">
                            <div class="commom-header-icon">
                                <span class="icon-box-form"><img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/login-page-icon.png') ?>"
                                        alt="" /></span>
                            </div>
                            <h1 class="mt-3">Create an account</h1>
                            <p>Provide your full name, email and phone number</p>
                        </div>
                        <div class="form-input-cnt">
                            <p>
                                <label htmlFor="">Name*</label><br />
                                <span class="input-icon-person">
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/user-name-login.png') ?>"
                                        alt="" />
                                </span>
                                <input type="text" name="name" />
                            </p>
                            <p>
                                <label htmlFor="">Email*</label><br />
                                <span class="input-icon-at">
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/user-email-login.png') ?>"
                                        alt="" />
                                </span>
                                <input type="email" name="email" />
                            </p>
                            <p>
                                <label htmlFor="">Phone number*</label><br />
                                <span class="input-icon-flag"><img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/user-number-login.png') ?>"
                                        alt="flag" /></span>
                                <input type="number" name="mobile_phone" />
                            </p>
                        </div>
                        <div class="form-footer">
                            <p class="checkbox-cnt">
                                <input type="checkbox" name="is_agree" value="1" />
                                <label htmlFor="">I agree to the
                                    <span>
                                        <a target="_blank"
                                            href="<?= base_url('cms/' . $privacyPolicy->slug) ?>"><?= $privacyPolicy->title ?></a>
                                        &
                                        <a target="_blank"
                                            href="<?= base_url('cms/' . $termsCondition->slug) ?>"><?= $termsCondition->title ?></a>
                                    </span>
                            </p>
                            <button type="button" class="proceed-btn nextFormBtn" id="signupButton"
                                data-form-url="<?php echo base_url('send-otp') ?>">Proceed<img
                                    src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>"
                                    alt=""></button>
                            <p class="login-text">
                                Already have an account?<a href="#" id="loginHref">Log in</a>
                            </p>
                        </div>
                    </form>
                    <!-- ////////////// OTP section ////////////////////  -->
                    <form class="form-otp-cnt section tab-content">
                        <div class="form-heading">
                            <div class='commom-header-icon'><span class='icon-box-form'><img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/otp-head-icon.png') ?>"
                                        alt="" /></span></div>
                            <h1 class='mt-3'>Verify your phone number, <span class="otp-name"></span></h1>
                            <p>We sent a 6 digit OTP to <span class="otp-phone-number"></span></p>
                        </div>
                        <div class='form-input-otp-cnt'>
                            <input type="number" class="otp-each-box" />
                            <input type="number" class="otp-each-box" />
                            <input type="number" class="otp-each-box" />
                            <input type="number" class="otp-each-box" />
                            <input type="number" class="otp-each-box" />
                            <input type="number" class="otp-each-box" />
                        </div>
                        <div class="form-footer">
                            <p class='login-text'>Didn’t get a code?<a href="#" id="resendOtpButton"
                                    data-form-url="<?php echo base_url('resend-otp') ?>">Resend</a></p>
                            <button type="button" class='proceed-btn nextFormBtn' id="verifyOtpButton"
                                data-form-url="<?php echo base_url('verify-otp') ?>">Verify <img
                                    src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>"
                                    alt=""></button>
                            <p class='login-text'>Incorrect phone number?
                                <a href="<?= base_url('/') ?>">Change</a>
                            </p>
                        </div>
                    </form>
                    <!-- /////////////// M-Pin section//////////////////// -->
                    <form class="form-otp-cnt section tab-content">
                        <div class="form-heading">
                            <div class='commom-header-icon'><img
                                    src="<?php echo base_url('assets/icon-folder/aside-icon/M-pin-header-icon.png') ?>"
                                    alt=""></div>
                            <h1 class='mt-3'>Setup your 4 digit M-PIN</h1>
                            <p>The M-Pin will be used for logging in in the future</p>
                        </div>
                        <div class='form-input-mpin-cnt'>
                            <input type="number" class="mpin-box" name="mpin[]" />
                            <input type="number" class="mpin-box" name="mpin[]" />
                            <input type="number" class="mpin-box" name="mpin[]" />
                            <input type="number" class="mpin-box" name="mpin[]" />
                        </div>
                        <div class="form-footer">
                            <button type="button" class='proceed-btn mt-3 nextFormBtn'
                                data-form-url="<?php echo base_url('store-mpin') ?>" id="mPinCreateButton">Proceed
                                <img src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>"
                                    alt=""></button>
                        </div>
                    </form>
                    <div class="tab-content w-100">
                        <!-- /////Company Details section first ////// -->
                        <div class="company-contetnt show">
                            <div class="form-heading">
                                <div class='commom-header-icon'><img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/comp-detls-1.png') ?>"
                                        alt=""></div>
                                <h1 class='mt-3'>Enter company details</h1>
                                <p>Add the required company information</p>
                            </div>
                            <div class='row'>
                                <div class='col-4'>
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/comp-detils-icons.png') ?>"
                                        alt="">
                                </div>
                                <div class='col-4'>
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/contact-detils-icon.png') ?>"
                                        alt="">
                                </div>
                                <div class='col-4'>
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/bank-detials-icon.png') ?>"
                                        alt="">
                                </div>
                            </div>
                            <div class="progress my-2">
                                <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-4'>
                                    <p class='first-comp'>01: Company details</p>
                                </div>
                                <div class='col-4'>
                                    <p>02: Point of Contact details</p>
                                </div>
                                <div class='col-4'>
                                    <p>03: Bank details & documents</p>
                                </div>
                            </div>
                            <div class="comp-basic-details">
                                <p>Basic details</p>
                                <div class='row py-2'>
                                    <div class="col-6">
                                        <label htmlFor="">Company Name</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1' name="company_name" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Company type</label></div>
                                    <div class="col-6">
                                        <select class="form-control" name="company_type">
                                            <option value="LLP">LLP</option>
                                            <option value="PVT_LTD">PVT LTD.</option>
                                            <option value="Sole_Proprietorship">Sole Proprietorship</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Company website</label></div>
                                    <div class="col-6"><input type="text" class='w-100 rounded input-bg py-1'
                                            name="company_website" /></div>
                                </div>
                            </div>
                            <div class='location details pt-4'>
                                <p>Location details</p>
                                <div class='row py-2'>
                                    <div class="col-6">
                                        <label htmlFor="">Which Country is the company based in</label>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-control select2-country" name="country_id"
                                            onchange="fetchStateByCountryId(this.value)">
                                            <option value="">Select Country</option>
                                            <?php foreach ($countries as $row): ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6">
                                        <label htmlFor="">State</label>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-control select2-state state_selection" name="state_id"
                                            onchange="fetchCityByStateId(this.value)">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6">
                                        <label htmlFor="">City</label>
                                    </div>
                                    <div class="col-6 ">
                                        <select class="form-control select2-city city_selection" name="city_id">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6">
                                        <label htmlFor="">Pincode</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg px-2 py-1' name="pincode" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6">
                                        <label htmlFor="">Company Address</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg px-2 py-1' name="address" />
                                    </div>
                                </div>
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6">
                                        <label htmlFor="">Upload Logo</label>
                                    </div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label For="file-input7" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input7" name="logo" required
                                                    onchange="previewLogo2(event)" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 1 MB</p>
                                                <p>File type: jpeg, png, jpg</p>
                                            </div>
                                        </div>
                                        <!-- Preview Container -->
                                        <div id="logo-preview-container2" class="preview-container"
                                            style="display: none; margin-top: 15px;">
                                            <div class="image-preview-wrapper">
                                                <img id="logo-preview2" class="preview-image" src="#"
                                                    alt="Logo preview" />
                                                <button type="button" class="delete-image-btn"
                                                    onclick="removeLogo2()">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class='comp-details-btn-cnt'>
                                <button type="button" class='proceed-btn comapnyNextBtn'>Next <img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>"
                                        alt="right-qrrow"></button>
                            </div>
                        </div>
                        <!--//////// Company Details section second ///////  -->
                        <div class="company-contetnt">
                            <div class="form-heading">
                                <div class='commom-header-icon'><img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/comp-detls-1.png') ?>"
                                        alt=""></div>
                                <h1 class='mt-3'>Enter company details</h1>
                                <p>Add the required company information</p>
                            </div>
                            <div class='row'>
                                <div class='col-4'>
                                    <span><img
                                            src="<?php echo base_url('assets/icon-folder/aside-icon/comp-detils-icons.png') ?>"
                                            alt="icon1" /></span>
                                </div>
                                <div class='col-4'>
                                    <span><img
                                            src="<?php echo base_url('assets/icon-folder/aside-icon/contact-detials-color-icon.png') ?>"
                                            alt="icon2" /></span>
                                </div>
                                <div class='col-4'>
                                    <span><img
                                            src="<?php echo base_url('assets/icon-folder/aside-icon/bank-detials-icon.png') ?>"
                                            alt="icon3" /></span>
                                </div>
                            </div>
                            <div class="progress my-2">
                                <div class="progress-bar w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <div class='row'>
                                <div class='col-4'>
                                    <p class='first-comp'>01: Company details</p>
                                </div>
                                <div class='col-4'>
                                    <p class='first-comp'>02: Point of Contact details</p>
                                </div>
                                <div class='col-4'>
                                    <p>03: Bank details & documents</p>
                                </div>
                            </div>
                            <div class="comp-basic-details">
                                <p>Basic details</p>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Name of the Co-ordinator</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1'
                                            name="coordinator_name" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Email</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1'
                                            name="coordinator_email" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Mobile number</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1'
                                            name="coordinator_mobile_number" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Alternate mobile number</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1'
                                            name="coordinator_alternative_number" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Landline number</label></div>
                                    <div class="col-6 d-flex">
                                        <div class='w-50'>
                                            <input placeholder="e.g. 91" type="text" class='w-100 rounded input-bg py-1'
                                                name="coordinator_landline_code" autocomplete="off" />
                                        </div>
                                        <div class='w-50 mx-2'>
                                            <input placeholder="e.g. 11" type="text" class='w-100 rounded input-bg py-1'
                                                name="coordinator_landline_type" maxlength="3" pattern="[0-9]+"
                                                autocomplete="off" />
                                        </div>
                                        <div class='w-100'>
                                            <input placeholder="e.g. 23456789" type="text"
                                                class='w-100 rounded input-bg py-1 mt-2'
                                                name="coordinator_landline_number" maxlength="8" pattern="[0-9]+"
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='comp-details-btn-cnt'>
                                <button class='Go-back-btn comapnyBackBtn pb-2'>Go back</button>
                                <button type="button" class='proceed-btn comapnyNextBtn'>Next <img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>"
                                        alt=""></button>
                            </div>
                        </div>
                        <!--////////// Bank detials section //////////////////-->
                        <div class="w-100 company-contetnt">
                            <div class="form-heading">
                                <div class='commom-header-icon'> <img
                                        src="<?php echo base_url('assets/icon-folder/aside-icon/comp-detls-1.png') ?>"
                                        alt=""></div>
                                <h1 class='mt-3'>Enter company details</h1>
                                <p>Add the required company information</p>
                            </div>
                            <div class='row'>
                                <div class='col-4'>
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/comp-detils-icons.png') ?>"
                                        alt="">
                                </div>
                                <div class='col-4'>
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/contact-detials-color-icon.png') ?>"
                                        alt="">
                                </div>
                                <div class='col-4'>
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/bank-details-icon-color.png') ?>"
                                        alt="">
                                </div>
                            </div>
                            <div class="progress  my-2">
                                <div class="progress-bar w-50" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <div class='row'>
                                <div class='col-4'>
                                    <p class='first-comp'>01: Company details</p>
                                </div>
                                <div class='col-4'>
                                    <p class='first-comp'>02: Point of Contact details</p>
                                </div>
                                <div class='col-4'>
                                    <p>03: Bank details & documents</p>
                                </div>
                            </div>
                            <div class="comp-basic-details">
                                <p>Bank details</p>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Enter bank name</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1' name="bank_name" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Account number</label></div>
                                    <div class="col-6">
                                        <input type="number" class='w-100 rounded input-bg py-1'
                                            name="bank_account_number" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">IFSC code</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1' name="bank_ifsc_code" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Beneficiary name</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1'
                                            name="beneficiary_name" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">PAN number</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1' name="pannumber" />
                                    </div>
                                </div>
                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">GST number</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1' name="gst_number" />
                                    </div>
                                </div>
                            </div>
                            <div class="upload-documents">
                                <p class='pt-5'>Upload documents</p>

                                <!-- Canceled Cheque -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload Canceled Cheque</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input1" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input1" name="canceled_cheque"
                                                    accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input1', 'preview-container1', 'file-name1', 'file-size1')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container1" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name1" class="document-name"></span>
                                                    <span id="file-size1" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input1', 'preview-container1')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Agreement -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload Agreement</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input2" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input2" name="agreement"
                                                    accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input2', 'preview-container2', 'file-name2', 'file-size2')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container2" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name2" class="document-name"></span>
                                                    <span id="file-size2" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input2', 'preview-container2')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='row py-2'>
                                    <div class="col-6"><label htmlFor="">Agreement start date</label></div>
                                    <div class="col-6">
                                        <input type="date" class='w-100 rounded input-bg py-1'
                                            name="agreement_start_date" />
                                    </div>

                                    <div class="col-6"><label htmlFor="">Agreement end date</label></div>
                                    <div class="col-6">
                                        <input type="date" class='w-100 rounded input-bg py-1 mt-2'
                                            name="agreement_end_date" />
                                    </div>
                                </div>

                                <!-- NDA -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload NDA</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input07" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input07" name="nda" accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input07', 'preview-container07', 'file-name07', 'file-size07')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container07" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name07" class="document-name"></span>
                                                    <span id="file-size07" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input07', 'preview-container07')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MOU -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload MOU</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input3" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input3" name="mou" accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input3', 'preview-container3', 'file-name3', 'file-size3')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container3" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name3" class="document-name"></span>
                                                    <span id="file-size3" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input3', 'preview-container3')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- GST Certificate -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload GST Certificate</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input4" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input4" name="gst_certificate"
                                                    accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input4', 'preview-container4', 'file-name4', 'file-size4')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container4" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name4" class="document-name"></span>
                                                    <span id="file-size4" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input4', 'preview-container4')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PAN Number -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload PAN Number</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input5" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input5" name="pan_number_document"
                                                    accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input5', 'preview-container5', 'file-name5', 'file-size5')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container5" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name5" class="document-name"></span>
                                                    <span id="file-size5" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input5', 'preview-container5')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Udyam Certificate -->
                                <div class='row py-2 align-items-center'>
                                    <div class="col-6"><label>Upload Udyam Certificate</label></div>
                                    <div class="col-6">
                                        <div class='bank-fileUpload-cnt'>
                                            <div>
                                                <label for="file-input6" class="custom-file-label">
                                                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Chooses-icon.png') ?>"
                                                        alt="Upload Logo" />
                                                    Choose File
                                                </label>
                                                <input type="file" id="file-input6" name="udyam_certificate"
                                                    accept=".doc,.docx,.pdf"
                                                    onchange="previewDocument('file-input6', 'preview-container6', 'file-name6', 'file-size6')" />
                                            </div>
                                            <div class='devider-line'></div>
                                            <div>
                                                <p>Max file size: 2 MB</p>
                                                <p>File type: doc, docx, pdf</p>
                                            </div>
                                        </div>
                                        <div id="preview-container6" class="document-preview-container"
                                            style="display: none;">
                                            <div class="document-preview-wrapper">
                                                <div class="document-icon">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div class="document-info">
                                                    <span id="file-name6" class="document-name"></span>
                                                    <span id="file-size6" class="document-size"></span>
                                                </div>
                                                <button type="button" class="delete-document-btn"
                                                    onclick="removeDocument('file-input6', 'preview-container6')">×</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Udyam Aadhar number -->
                                <div class='row py-2 align-items-start'>
                                    <div class="col-6"><label>Enter Udyam Aadhar number</label></div>
                                    <div class="col-6">
                                        <input type="text" class='w-100 rounded input-bg py-1' name="udyam_adhar_number"
                                            placeholder="UDYAM-MH-12-0000001" />
                                    </div>
                                </div>
                            </div>
                            <div class='comp-details-btn-cnt'>
                                <button class='Go-back-btn comapnyBackBtn'>Go back</button>
                                <button type="button" class='proceed-btn nextFormBtn submitFormBtn'>Submit
                                    <img src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>"
                                        alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/////////////////// Good to go section //////////////////////////-->
                <form class="form-otp-cnt tab-content last-step-from hide">
                    <div class="form-heading">
                        <div class='commom-header-icon'><img
                                src="<?php echo base_url('assets/icon-folder/aside-icon/good to go icon.png') ?>"
                                alt=""></div>
                        <h1 class='mt-3'>Welcome to BookMyTestCenter</h1>
                        <p>You are good to go!</p>
                    </div>
                    <div class='form-input-mpin-cnt'>
                        <div class="video-container">
                            <video width="640" height="360" controls>
                                <source
                                    src="<?php echo base_url('assets/video/assessment-company-welcome.mp4" type="video/mp4') ?>">
                            </video>
                            <!-- <div class="play-icon"></div> -->
                        </div>
                    </div>
                    <div class="finish-btn-cnt">
                        <a href="<?php echo base_url('/dashboard') ?>" class='finish-btn'><img
                                src="<?php echo base_url('assets/icon-folder/aside-icon/Finish up 🚀.png') ?>"
                                alt=""></a>
                    </div>
                </form>
            </div>
            <div class="indicatorCnt mt-2 pl-33">
                <ul class="indicatorWrapper" id="indicatorCnt">
                    <li class="indicatorItem active"></li>
                    <li class="indicatorItem"></li>
                    <li class="indicatorItem"></li>
                    <li class="indicatorItem"></li>
                    <li class="indicatorItem"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row hide" id="loginScreenPage">
        <div class="col-4 aside-bg">
            <a href="#" class="aside-heading">BookMyTestCenter</a>
            <div class="aside-tag-wrapper">
                <div class="aside-tag-cnt tab active">
                    <div class="icon-box">
                        <img src="<?php echo base_url('assets/icon-folder/aside-icon/icon1-grey.png') ?>"
                            alt="user-icon-white" class="user-grey" />
                        <img src="<?php echo base_url('assets/icon-folder/aside-icon/Active1-white.png') ?>"
                            alt="user-icon-grey" class="user-white" />
                    </div>
                    <div>
                        <h3 class="m-0">Login</h3>
                        <p class="m-0">Enter your Mpin and phone no.</p>
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
                            <span class="icon-box-form"><img
                                    src="<?php echo base_url('assets/icon-folder/aside-icon/login-page-icon.png') ?>"
                                    alt="" /></span>
                        </div>
                        <h1 class="mt-3">Welcome back</h1>
                        <p>Enter your 4 digit M-Pin to log in</p>
                    </div>
                    <div class="form-otp-cnt">
                        <div class='form-input-mpin-cnt'>
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin" />
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin" />
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin" />
                            <input type="number" class="me-2 login-mpin-box" name="login_mpin" />
                        </div>
                    </div>
                    <div class="form-input-cnt mt-2">
                        <p>
                            <label htmlFor="">Phone number*</label><br />
                            <span class="input-icon-flag" style="top: 50%;">
                                <img src="<?php echo base_url('assets/icon-folder/aside-icon/user-number-login.png') ?>"
                                    alt="flag" />
                            </span>
                            <input type="number" name="login_mobile_phone" id="login_mobile_phone" />
                        </p>
                    </div>
                    <div class="form-footer">
                        <button type="button" class="proceed-btn" id="LoginInBtn"
                            data-form-url="<?php echo base_url('do-login') ?>"
                            data-base-url="<?php echo base_url() ?>">Login
                            <img src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png') ?>" alt="">
                        </button>
                        <p class="login-text">Don’t have an account?
                            <a href="<?= base_url('/') ?>">Sign up
                            </a>
                        </p>
                        <p class="login-text">Reset/Forgit Mpin
                            <a href="<?= base_url('/reset-forgot-mpin') ?>">Go
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Aside section end-->