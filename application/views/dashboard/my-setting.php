<style>
    .profile-card,
    .section-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .profile-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
    }

    .edit-btn {
        background-color: #f9fafa;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .logout-btn {
        background-color: #f63e3e;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .delete-btn {
        background-color: #fff0f0;
        color: #d93025;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .danger-text {
        color: #d93025;
        font-size: 14px;
        margin-top: 5px;
    }

    .info-label {
        font-size: 13px;
        color: gray;
        margin-bottom: 2px;
    }

    .info-value {
        font-weight: 500;
        font-size: 17px;
        color: black
    }
    .fw-bold{
        font-size: 20px;
        font-weight: 600;
    }
    a{
        text-decoration: unset;
    }
</style>
<div class="tablecalenderContent show">
    <!--/////////////////////// Setting Page my-profile ///////////////////-->
    <div class="setting-my-profile-container ">
        <div class='notification-navbar'>
            <h2 class='m-0 fs-4'>Settings</h2>
            <div>
                <a href="<?php echo base_url('dashboard')?>">
                    <button class='create-project-btn createProjectBtn'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create Project
                    </button>
                </a>
            </div>
        </div>
        <hr>
        <div>
            <div class="setting-tab-container mb-3 ">
                <button class="setting-tab my-profile-btn">My Profile</button>
                <button class="setting-tab mx-3">Account</button>
                <button class="setting-tab">Help & Support</button>
            </div>
            <hr>
            <div class="setting-my-profile-wrapper show">
                <div class="company-logo-setting-page mb-3">
                    <div class="p-3 bg-white rounded d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <img class="profile-img" id="profilePreview" src="<?= base_url('uploads/client_logo/'.$result->logo); ?>" 
                                     alt="Profile Logo" style="height: 100px;width: 100px;">
                            </div>
                            <div class="ms-2">
                                <h2 class="m-0"><?= $result->company_name ?></h2>
                                <p class="m-0"><?= $result->co_ordinator_name ?></p>
                                <p class="m-0"><?= $result->country_name ?></p>
                            </div>
                        </div>
                        <div>
                            <form id="profilePicForm" method="POST" action="<?= base_url('update-profile-picture') ?>" enctype="multipart/form-data">
                                <input type="file" name="logo" id="profilePicInput" accept="image/*" hidden>
                                <button type="button" id="editPicBtn" class="edit-btn">
                                   ✏️ Edit logo
                                </button>
                                <button type="submit" id="savePicBtn" class="btn btn-success d-none">Save logo</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Flash Message -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mt-2"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mt-2"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <div class="company-information-setting-page mb-3">
                    <div class="p-3 bg-white rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-bold mb-0">Company Information</div>
                            <div>
                                <button type="button" id="editCompanyBtn" class="edit-btn">
                                   ✏️ Edit
                                </button>
                            </div>
                        </div>

                        <!-- Static info -->
                        <div id="companyInfoStatic">
                            <div class="d-flex">
                                <div class="me-5">
                                    <div class="mb-4">
                                        <p class="info-label">Company name</p>
                                        <h3 class="info-value"><?= $result->company_name ?></h3>
                                    </div>
                                    <div class="mb-4">
                                        <p class="info-label">Company type</p>
                                        <h3 class="info-value"><?= $result->company_type ?></h3>
                                    </div>
                                    <div>
                                        <p class="info-label">State</p>
                                        <h3 class="info-value"><?= $result->state_name ?></h3>
                                    </div>
                                </div>
                                <div class="ms-5">
                                    <div class="mb-4">
                                        <p class="info-label">Address</p>
                                        <h3 class="info-value"><?= $result->address ?></h3>
                                    </div>
                                    <div class="mb-4">
                                        <p class="info-label">City</p>
                                        <h3 class="info-value"><?= $result->city_name ?></h3>
                                    </div>
                                    <div>
                                        <p class="info-label">Pin code</p>
                                        <h3 class="info-value"><?= $result->pincode ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Editable form (hidden initially) -->
                        <div id="companyInfoForm" class="d-none">
                            <?= $this->load->view('dashboard/company_info_form', ['result'=>$result,'city'=>$city,'state'=>$state], true) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="setting-my-profile-wrapper">
                <div class="account-logo-setting-page mb-3">
                    <div class="p-3 bg-white rounded d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <img class="profile-img" id="personalProfilePreview" 
                                     src="<?= base_url('uploads/client_logo/'.$result->logo); ?>" 
                                     alt="Profile Logo" style="height: 100px;width: 100px;">
                            </div>
                            <div class="ms-2">
                                <h2 class="m-0"><?= $result->company_name ?></h2>
                                <p class="m-0"><?= $result->co_ordinator_name ?></p>
                                <p class="m-0"><?= $result->country_name ?></p>
                            </div>
                        </div>
                        <div>
                            <form id="personalProfilePicForm" method="POST" action="<?= base_url('update-profile-picture') ?>" enctype="multipart/form-data">
                                <input type="file" name="logo" id="personalProfilePicInput" accept="image/*" hidden>
                                <button type="button" id="personalEditPicBtn" class="edit-btn">
                                    ✏️ Edit logo
                                </button>
                                <button type="submit" id="personalSavePicBtn" class="btn btn-success d-none">Save logo</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="Personal-Information-setting-page mb-3">
                    <div class="p-3 bg-white rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-bold mb-0">Personal Information</div>
                            <div>
                                <button type="button" id="editPersonalBtn" class="edit-btn">
                                    ✏️ Edit
                                </button>
                            </div>
                        </div>

                        <!-- Static Info -->
                        <div id="personalInfoStatic">
                            <div class="d-flex">
                                <div class="me-5">
                                    <div class="mb-4">
                                        <p class="info-label">Full Name</p>
                                        <h3 class="info-value"><?= $result->co_ordinator_name ?></h3>
                                    </div>
                                    <div class="mb-4">
                                        <p class="info-label">Phone number 
                                            <img src="<?= base_url('assets/icon-folder/project-icons/Edit-profile-icon.png')?>" alt="" class="ms-2">
                                        </p>
                                        <h3 class="info-value"><?= $result->coordinator_mobile_number ?></h3>
                                    </div>
                                    <div>
                                        <p class="info-label">Landline number</p>
                                        <h3 class="info-value"><?= $result->landline_number ?></h3>
                                    </div>
                                </div>
                                <div class="ms-5">
                                    <div class="mb-4">
                                        <p class="info-label">Email</p>
                                        <h3 class="info-value"><?= $result->coordinator_email ?></h3>
                                    </div>
                                    <div class="mb-4">
                                        <p class="info-label">Alternate mobile number</p>
                                        <h3 class="info-value"><?= $result->coordinator_alternative_number ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Editable Form (Hidden Initially) -->
                        <div id="personalInfoForm" class="d-none">
                            <form method="POST" action="<?= base_url('update-personal-information') ?>">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6 class="m-0 fw-bold">Edit Personal Information</h6>
                                    <button type="submit" class="save-btn">Save</button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control" 
                                               value="<?= htmlspecialchars($result->co_ordinator_name ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone number</label>
                                        <input type="text" name="mobile" class="form-control" 
                                               value="<?= htmlspecialchars($result->coordinator_mobile_number ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Landline number</label>
                                        <input type="text" name="landline" class="form-control" 
                                               value="<?= htmlspecialchars($result->landline_number ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" 
                                               value="<?= htmlspecialchars($result->coordinator_email ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Alternate Mobile number</label>
                                        <input type="text" name="alt_mobile" class="form-control" 
                                               value="<?= htmlspecialchars($result->coordinator_alternative_number ?? '') ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="section-card d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Account</h6>
                    <button class="logout-btn" onclick="logoutAC()">🔒 Log out</button>
                </div>
                <div class="section-card d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-2">Delete account</h6>
                        <p class="danger-text">This action cannot be undone</p>
                    </div>
                    <div>
                        <button class="delete-btn" onclick="deleteAcAccount(<?=$result->ac_id?>)">🗑️ Delete Account</button>
                    </div>
                </div>
            </div>
            <div class="setting-my-profile-wrapper">

                <?php
                  // Convert array to key-value pairs for easy access
                  $settings = [];
                  foreach ($settigData as $item) {
                      $settings[$item['setting_key']] = $item['setting_value'];
                  }
                  
                  // Check if support settings exist
                  $support_title = isset($settings['support_title']) ? $settings['support_title'] : 'Help & Support';
                  $support_description = isset($settings['support_description']) ? $settings['support_description'] : 'We are here to help you with your queries';
                  $support_phone = isset($settings['support_phone']) ? $settings['support_phone'] : '+91-9228764523';
                  $support_email = isset($settings['support_email']) ? $settings['support_email'] : 'support@testpanindia.com';
                  ?>

                <div class="p-3 bg-white rounded">
                    <h2>
                        <?php echo htmlspecialchars($support_title); ?>
                    </h2>
                    <p><?php echo htmlspecialchars($support_description); ?></p>
                    <div class="d-flex">
                        <div class="me-5">
                            <p>Call us</p>
                            <?php if (!empty($support_phone)): ?>
                              <a href="tel:+91<?php echo preg_replace('/[^0-9]/', '', $support_phone); ?>">
                                  <h2>+91 <?php echo htmlspecialchars($support_phone); ?></h2>
                              </a>
                          <?php else: ?>
                              <span>Not available</span>
                          <?php endif; ?>
                        </div>
                        <div class="ms-5">
                            <p>Email us</p>
                            <?php if (!empty($support_email)): ?>
                              <a href="mailto:<?php echo htmlspecialchars($support_email); ?>">
                                  <h2><?php echo htmlspecialchars($support_email); ?></h2>
                              </a>
                            <?php else: ?>
                              <span>Not available</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("editPicBtn").addEventListener("click", function() {
    document.getElementById("profilePicInput").click();
});

document.getElementById("profilePicInput").addEventListener("change", function(event) {
    if (event.target.files && event.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("profilePreview").src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);

        // Show Save button, hide Edit button
        document.getElementById("editPicBtn").classList.add("d-none");
        document.getElementById("savePicBtn").classList.remove("d-none");
    }
});

document.getElementById("editCompanyBtn").addEventListener("click", function() {
    document.getElementById("companyInfoStatic").classList.add("d-none");
    document.getElementById("companyInfoForm").classList.remove("d-none");
    this.style.visibility = "hidden"; // hide Edit button
});
</script>

<script>
// Personal Profile Picture
document.getElementById("personalEditPicBtn").addEventListener("click", function() {
    document.getElementById("personalProfilePicInput").click();
});
document.getElementById("personalProfilePicInput").addEventListener("change", function(event) {
    if (event.target.files && event.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("personalProfilePreview").src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);

        // Toggle buttons
        document.getElementById("personalEditPicBtn").classList.add("d-none");
        document.getElementById("personalSavePicBtn").classList.remove("d-none");
    }
});

// Personal Information Edit
document.getElementById("editPersonalBtn").addEventListener("click", function() {
    document.getElementById("personalInfoStatic").classList.add("d-none");
    document.getElementById("personalInfoForm").classList.remove("d-none");
    this.style.visibility = "hidden"; // Hide Edit button
});
</script>
