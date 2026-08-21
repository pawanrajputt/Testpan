// ===============Signup Form==========
$("#signupButton").click(function () {
    let name = $("input[name='name']").val().trim();
    let email = $("input[name='email']").val().trim();
    let phone = $("input[name='mobile_phone']").val().trim();
    let agree = $("input[name='is_agree']").is(":checked");
    let form_url = $(this).data('form-url');

    // Validation
    if (name === "") {
        toastr.error("Name is required");
        return;
    }
    
    if (email === "") {
        toastr.error("Email is required");
        return;
    }
    
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        toastr.error("Please enter a valid email address");
        return;
    }
    
    if (phone === "") {
        toastr.error("Phone number is required");
        return;
    }
    
    let phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
        toastr.error("Phone number must be exactly 10 digits");
        return;
    }
    
    if (!agree) {
        toastr.error("You must agree to the terms and privacy policy");
        return;
    }

    // First check if phone exists
    $.ajax({
        url: base_url + 'check-phone-exists',
        type: "POST",
        data: { mobile_phone: phone },
        dataType: "json",
        success: function (response) {
            if (response.exists) {
                toastr.error("This phone number is already registered");
            } else {
                // If phone doesn't exist, submit the form
                submitSignupForm(name, email, phone, form_url);
            }
        },
        error: function(xhr, status, error) {
            toastr.error("Error checking phone number");
            console.error(error);
        }
    });
});

function submitSignupForm(name, email, phone, form_url) {
    $.ajax({
        url: form_url,
        type: "POST",
        data: { 
            name: name,
            email: email,
            mobile_phone: phone
        },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                localStorage.setItem('username', name);
                localStorage.setItem('useremail', email);
                localStorage.setItem('usermobile', phone);
                $('.otp-name').html(name);
                $('.otp-phone-number').html(phone);
                toastr.success(response.message);
                showPage(1);
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            toastr.error("An error occurred while processing your request");
            console.error(error);
        }
    });
}


// ==============ResentOtp==================
$("#resendOtpButton").click(function () {

    let form_url = $(this).data('form-url');

    $.ajax({
        url: form_url,
        type: "POST",
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        processData: true,
        success: function (response) {
            if (response.status === "success") {
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        }
    });
});

// ================VerifyOtp=================
$("#verifyOtpButton").click(function () {

	let otp = "";
    $(".otp-each-box").each(function () {
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
                showPage(2);
            } else {
                toastr.error(response.message);
            }
        }
    });
});


// ================MPin Create===========
$("#mPinCreateButton").click(function () {

	let mpin = "";
    $(".mpin-box").each(function () {
        mpin += $(this).val();
    });

    if(mpin == ''){
        toastr.error("MPIN is required");
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

                const name = localStorage.getItem('username');
                const email = localStorage.getItem('useremail');
                const mobile = localStorage.getItem('usermobile');


                showPage(3);
            } else {
                toastr.error(response.message);
            }
        }
    });
});

// ===============Login Form==============
$("#LoginInBtn").click(function () {

    let mpin = "";
    $(".login-mpin-box").each(function () {
        mpin += $(this).val();
    });

    if(mpin == ''){
        toastr.error("MPIN is required");
        return;
    }

    let mobile_phone = $('#login_mobile_phone').val();

    if(mobile_phone== ''){
        toastr.error("Mobile number is required");
        return;
    }

    let form_url = $(this).data('form-url');
    let base_url = $(this).data('base-url');

    $.ajax({
        url: form_url,
        type: "POST",
        data: { mpin: mpin, mobile_phone:mobile_phone },
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        processData: true,
        success: function (response) {
            if (response.status === "success") {
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.href = base_url+"dashboard";
                }, 1000);
                
            } else {
                toastr.error(response.message);
            }
        }
    });
});


// ================Otp Box=================
document.addEventListener("DOMContentLoaded", function () {
    const otpInputs = document.querySelectorAll(".otp-each-box");

    otpInputs.forEach((input, index) => {
        input.addEventListener("input", (e) => {
            if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus(); // Move to the next input box
            }
        });

        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && index > 0 && input.value === "") {
                otpInputs[index - 1].focus(); // Move to the previous input box on backspace
            }
        });
    });
});

// =================MPin Box==================
document.addEventListener("DOMContentLoaded", function () {
    let mpinBoxes = document.querySelectorAll(".mpin-box");

    mpinBoxes.forEach((box, index) => {
        box.addEventListener("input", function () {
            if (this.value.length === 1 && index < mpinBoxes.length - 1) {
                mpinBoxes[index + 1].focus(); // Move to next input
            }
        });

        box.addEventListener("keydown", function (e) {
            if (e.key === "Backspace" && this.value.length === 0 && index > 0) {
                mpinBoxes[index - 1].focus(); // Move to previous input on backspace
            }
        });
    });
});


// =================Loin MPin Box==================
document.addEventListener("DOMContentLoaded", function () {
    let mpinBoxes = document.querySelectorAll(".login-mpin-box");

    mpinBoxes.forEach((box, index) => {
        box.addEventListener("input", function () {
            if (this.value.length === 1 && index < mpinBoxes.length - 1) {
                mpinBoxes[index + 1].focus(); // Move to next input
            }
        });

        box.addEventListener("keydown", function (e) {
            if (e.key === "Backspace" && this.value.length === 0 && index > 0) {
                mpinBoxes[index - 1].focus(); // Move to previous input on backspace
            }
        });
    });
});


// ===============State Fetch===============
function fetchStateByCountryId(country_id) {

    $.ajax({
        url: base_url + 'fetch-state-by-country-id',
        type: 'POST',
        data: { country_id: country_id },
        dataType: 'json',
        success: function(response) {
            let options = '<option value="">Select State</option>';
            if (response.length > 0) {
                response.forEach(function(state) {
                    options += `<option value="${state.id}">${state.title}</option>`;
                });
            }
            $('.state_selection').html(options);
        },
        error: function() {
            alert('Failed to fetch states. Please try again.');
        }
    });
}


// ===============City Fetch===============
function fetchCityByStateId(state_id) {

    $.ajax({
        url: base_url + 'fetch-city-by-state-id',
        type: 'POST',
        data: { state_id: state_id },
        dataType: 'json',
        success: function(response) {
            let options = '<option value="">Select City</option>';
            if (response.length > 0) {
                response.forEach(function(city) {
                    options += `<option value="${city.city_id}">${city.city_name}</option>`;
                });
            }
            $('.city_selection').html(options);
        },
        error: function() {
            alert('Failed to fetch city. Please try again.');
        }
    });
}

// ===================Logout==============
function logoutAC(){
    localStorage.removeItem('username');
    localStorage.removeItem('useremail');
    localStorage.removeItem('usermobile');

    $.ajax({
        url: base_url + 'logout',
        type: 'GET',
        success: function(response) {
            window.location.href = base_url;
        },
        error: function() {
            alert('Logout failed!');
        }
    });
}


// ===================Delete Account==============
function deleteAcAccount(ac_id) {

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete your account!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: base_url + 'delete-account',
                type: 'POST',
                dataType: 'json',
                data: {
                    ac_id: ac_id
                },
                success: function(response) {

                    if (response.status) {

                        toastr.success(response.message);

                        setTimeout(function () {
                            window.location.href = base_url;
                        }, 1500);

                    } else {

                        toastr.error(response.message);

                    }
                },
                error: function() {
                    toastr.error('Something went wrong. Please try again.');
                }
            });

        }

    });
}

// ===============SHow Page================
function showPage(stepIndex) {
    // Remove active/show classes from all tabs
    document.querySelectorAll(".aside-tag-cnt").forEach(tab => tab.classList.remove("active"));
    document.querySelectorAll(".tab-content").forEach(content => content.classList.remove("show"));
    document.querySelectorAll(".indicatorItem").forEach(indicator => indicator.classList.remove("active"));

    // Add active/show classes to the current step
    const tabs = document.querySelectorAll(".aside-tag-cnt");
    const contents = document.querySelectorAll(".tab-content");
    const indicators = document.querySelectorAll(".indicatorItem");

    if (tabs[stepIndex]) tabs[stepIndex].classList.add("active");
    if (contents[stepIndex]) contents[stepIndex].classList.add("show");
    if (indicators[stepIndex]) indicators[stepIndex].classList.add("active");
}

// ====================Show Login Signup Page=================
$("#loginHref").click(function () {
   $('#signupScreenPage').addClass('hide');
   $('#loginScreenPage').removeClass('hide');
});



// ===============Create Project======================
$("#submitProjectButton").click(function () {
    let isValid = true;
    let $btn = $(this);
    $("#loader").show();

    const manpowerFields = [
        "invigilator_ratio_1", "invigilator_ratio_2", "invigilator_male", "invigilator_female",
        "security_guard_ratio_1", "security_guard_ratio_2", "security_guard_male", "security_guard_female"
    ];

    // Validate all manpower fields
    manpowerFields.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.classList.remove("is-invalid", "is-valid");

            if (!field.value.trim() || isNaN(field.value.trim()) || parseInt(field.value) < 0) {
                isValid = false;
                field.classList.add("is-invalid");
            } else {
                field.classList.add("is-valid");
            }
        }
    });

    // Prevent ratio like 1:0
    ["center_suptn_ratio_2", "tech_person_ratio_2", "invigilator_ratio_2", "security_guard_ratio_2"]
        .forEach(id => {
            const field = document.getElementById(id);
            if (field && parseInt(field.value) === 0) {
                isValid = false;
                field.classList.add("is-invalid");
            }
        });

    // 🚫 Stop submit if invalid
    if (!isValid) {
        toastr.error("⚠️ Please fill all manpower fields correctly.");
        const firstInvalid = document.querySelector(".is-invalid");
        if (firstInvalid) firstInvalid.focus();
        return; // 🔥 prevent AJAX call
    }

    // ✅ Submit only if valid
    let formUrl = document.getElementById('ProjectFormUrl').value;
    let formData = new FormData($("#createProjectForm")[0]);
    $btn.text('Submitting...').prop('disabled', true);

    $.ajax({
        url: formUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            toastr.success("Project Created Successfully");
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(xhr) {
            toastr.error("Something went wrong. Please try again.");
        }
    });
});


// ============Project Table Filter==================
$(document).ready(function () {
    $('.examNameFilter').on('keyup', function () {
        let input = $(this);
        let searchText = input.val().toLowerCase();

        // Find the closest .table-cnt (wrapper of current table)
        let tableWrapper = input.closest('.table-cnt');

        // Find the table inside the same section
        let table = tableWrapper.find('table');

        // Find and filter rows
        table.find('tbody tr').each(function () {
            let row = $(this);
            let labelText = row.find('.exam-name').text().toLowerCase();

            if (labelText.includes(searchText)) {
                row.show();
            } else {
                row.hide();
            }
        });
    });
});

// ================Project Detail================
function showProjectDetail(project_id) {
    $.ajax({
        url: base_url + 'detail-project',
        type: 'POST',
        data: { project_id: project_id },
        success: function(response) {
            $('.innerHtmlProjectDetail').html(response);
            tablecalenderContents.forEach(content => content.classList.remove("show"));
            approveCnt.classList.remove("show");
            eligibleCnt.classList.add("show");
        }
    });
}


$(document).on('click','.approveItemBtn',function(){
   var center_id = $(this).data('center-id');
   var project_id = $(this).data('project-id');
   $.ajax({
        url: base_url + 'detail-exam-center',
        type: 'POST',
        data: { center_id: center_id, project_id: project_id },
        success: function(response) {
            $('.innerHtmlCenterDetail').html(response);
        },
        error: function() {
            alert('Failed to load project details!');
        }
    });
});

$(document).on('click', '.center-booking-status-by-client', function () {

    var center_id  = $(this).data('center-id');
    var project_id = $(this).data('project-id');
    var type       = $(this).data('type');
    var actionText = (type === 'approve') ? 'approve' : 'reject';

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to ' + actionText + ' this booking request?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7367F0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + actionText.charAt(0).toUpperCase() + actionText.slice(1)
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }

        $.ajax({
            url: base_url + 'update-center-booking-status',
            type: 'POST',
            dataType: 'json',
            data: {
                center_id: center_id,
                project_id: project_id,
                type: type
            },
            success: function (response) {

                if (response.status) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });

                }

            },
            error: function () {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });

            }
        });

    });

});


function viewProjectDetail(project_id) {
    $.ajax({
        url: base_url + 'view-project-detail',
        type: 'POST',
        data: { project_id: project_id },
        success: function(response) {
            // Initialize the offcanvas first
            var offcanvasElement = document.getElementById('viewProjectDetailModal');
            var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            
            // Set the content
            $('.innerHtmlViewProjectDetail').html(response);
            
            // Show the offcanvas
            offcanvas.show();
        },
        error: function() {
            alert('Failed to load project details!');
        }
    });
}

// =================Change Batch====================
$(document).on(
'change',
'input[type=time]',
function(){

    let row=$(this).closest('.border');

    let start=row.find('input[type=time]').eq(0).val();

    let end=row.find('input[type=time]').eq(1).val();

    if(start && end){

        if(timeToMinutes(end)<=timeToMinutes(start)){

            toastr.error(
                "End time must be greater than Start time"
            );

            row.find('input[type=time]').eq(1).val('');

        }

    }

});


// =====================Calendar======================
document.addEventListener('DOMContentLoaded', function() {
    const upcomingTab = document.getElementById('upcoming-tab');
    const pastTab = document.getElementById('past-tab');
    const upcomingEvents = document.getElementById('upcoming-events');
    const pastEvents = document.getElementById('past-events');
    
    // Tab switching functionality
    upcomingTab.addEventListener('click', function(e) {
        e.preventDefault();
        upcomingEvents.style.display = 'block';
        pastEvents.style.display = 'none';
        
        // Add classes to active tab
        this.classList.add('active-tab');
        this.classList.add('all-project-tab');
        
        // Remove classes from inactive tab
        pastTab.classList.remove('active-tab');
        pastTab.classList.remove('all-project-tab');
    });
    
    pastTab.addEventListener('click', function(e) {
        e.preventDefault();
        upcomingEvents.style.display = 'none';
        pastEvents.style.display = 'block';
        
        // Add classes to active tab
        this.classList.add('active-tab');
        this.classList.add('all-project-tab');
        
        // Remove classes from inactive tab
        upcomingTab.classList.remove('active-tab');
        upcomingTab.classList.remove('all-project-tab');
    });

    // Search functionality
    const examSearch = document.getElementById('exam-search');
    examSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const events = document.querySelectorAll('.main-calender-cnt .border.rounded');
        
        events.forEach(event => {
            const examName = event.querySelector('h2.m-0').textContent.toLowerCase();
            if (examName.includes(searchTerm)) {
                event.style.display = 'flex';
            } else {
                event.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.getElementById('filter-by').addEventListener('change', function() {
        const filterValue = this.value;
        const events = document.querySelectorAll('.main-calender-cnt .border.rounded');
        
        events.forEach(event => {
            const status = event.querySelector('.panding-calender-btn').textContent.toLowerCase().replace(' ', '-');
            if (!filterValue || status === filterValue) {
                event.style.display = 'flex';
            } else {
                event.style.display = 'none';
            }
        });
    });

    // Export functionality
    document.getElementById('export-btn').addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get current active tab
        const activeTab = document.querySelector('.all-project-tab.active-tab').id;
        const tabType = (activeTab === 'past-tab') ? 'past' : 'upcoming';
        
        // Get filter values
        const filterValue = document.getElementById('filter-by').value;
        const searchValue = document.getElementById('exam-search').value;
        
        // Build export URL
        let exportUrl = window.location.pathname + '?export=excel&tab=' + tabType;
        
        if (filterValue) {
            exportUrl += '&filter=' + encodeURIComponent(filterValue);
        }
        if (searchValue) {
            exportUrl += '&search=' + encodeURIComponent(searchValue);
        }
        
        window.location.href = exportUrl;
    });
});

// ====================Image Preview===============
function previewLogo2(event) {
    const input = event.target;
    const previewContainer = document.getElementById('logo-preview-container2');
    const preview = document.getElementById('logo-preview2');
    
    if (input.files && input.files[0]) {
        // Validate file size (1MB = 1,048,576 bytes)
        if (input.files[0].size > 1048576) {
            alert('File size exceeds 1 MB limit');
            input.value = ''; // Clear the file input
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeLogo2() {
    const input = document.getElementById('file-input7');
    const previewContainer = document.getElementById('logo-preview-container2');
    
    input.value = ''; // Clear the file input
    previewContainer.style.display = 'none';
}

// ==============Preview of Document================
function previewDocument(inputId, previewContainerId, fileNameId, fileSizeId) {
    const input = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewContainerId);
    const fileNameElement = document.getElementById(fileNameId);
    const fileSizeElement = document.getElementById(fileSizeId);
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB = 2,097,152 bytes)
        if (file.size > 2097152) {
            alert('File size exceeds 2 MB limit');
            input.value = ''; // Clear the file input
            return;
        }
        
        // Validate file type
        const validExtensions = ['pdf', 'doc', 'docx'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!validExtensions.includes(fileExtension)) {
            alert('Invalid file type. Please upload PDF, DOC, or DOCX files.');
            input.value = ''; // Clear the file input
            return;
        }
        
        // Set appropriate icon based on file type
        const iconElement = previewContainer.querySelector('.document-icon i');
        if (fileExtension === 'pdf') {
            iconElement.className = 'fas fa-file-pdf';
        } else if (fileExtension === 'doc' || fileExtension === 'docx') {
            iconElement.className = 'fas fa-file-word';
        } else {
            iconElement.className = 'fas fa-file';
        }
        
        // Display file info
        fileNameElement.textContent = file.name;
        fileSizeElement.textContent = formatFileSize(file.size);
        previewContainer.style.display = 'block';
    }
}

// Function to remove document
function removeDocument(inputId, previewContainerId) {
    const input = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewContainerId);
    
    input.value = ''; // Clear the file input
    previewContainer.style.display = 'none';
}

// Helper function to format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

$(document).on('click', '.submitFormBtn', function () {

    const $btn = $(this);
    const originalText = $btn.text();

    // safety: already disabled ho to kuch mat karo
    if ($btn.prop('disabled')) return;

    // disable + text change
    $btn.prop('disabled', true).text('Submitting...');

    // 3 second baad wapas normal
    setTimeout(function () {
        $btn.prop('disabled', false).text(originalText);
    }, 3000);
});

$(document).on('click', '.exportProjectBtn', function () {
    let status = $(this).data('status');

    window.location.href = base_url+"/export-dashboard-project?status=" + status;
});

$(document).on('click', '.exportInternalCenterBtn', function () {
    let projectId = $(this).data('project-id');
    
    window.location.href = base_url+"/export-project-detail-assign-centers?project_id=" + projectId;
});

$(document).on('click', '.deleteProjectBtn', function () {

    let projectId   = $(this).data('project-id');
    let projectName = $(this).data('project-name');

    if (!projectId) {
        toastr.error('Invalid project.');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete project "' + projectName + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }

        $.ajax({
            url: base_url + "/delete-project",
            type: "POST",
            data: {
                project_id: projectId
            },
            success: function (res) {

                let response;

                try {
                    response = JSON.parse(res);
                } catch (e) {
                    toastr.error('Unexpected server response.');
                    return;
                }

                if (response.status) {

                    toastr.success(response.message);

                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {

                    toastr.error(response.message);

                }
            },
            error: function () {

                toastr.error('Something went wrong. Please try again.');

            }
        });

    });

});

$('input[name="start_date"]').on('change', function () {
    let startDate = $(this).val();
    $('input[name="end_date"]').attr('min', startDate);
});

$(document).on('click','#backButton',function(){
    window.location.href=base_url+'dashboard';
});


$(document).on("click",".openNegotiation",function(){

    let project_id=$(this).data("project");

    $.ajax({

        url:base_url+"dashboard/client-project/client-negotiation",

        type:"POST",

        data:{
            project_id:project_id
        },

        dataType:"json",

        success:function(res){

            if(!res.status){

                alert(res.message);

                return;
            }

            let d=res.data;

            $("#project_id").val(d.project_id);

            $("#original_amount").val(d.original_amount);

            $("#final_amount").val(d.final_amount);

            $("#client_remark").val(d.remark);

            $("#clientNegotiationModal").modal("show");

        }

    });

});


$("#saveNegotiation").click(function(){

    Swal.fire({

        title:"Submit Negotiation?",

        text:"Do you want to submit this negotiation request?",

        icon:"question",

        showCancelButton:true,

        confirmButtonText:"Yes",

        cancelButtonText:"Cancel"

    }).then((result)=>{

        if(!result.isConfirmed){

            return;

        }

        $.ajax({

            url:base_url+"dashboard/client-project/save-client-negotiation",

            type:"POST",

            data:{

                project_id:$("#project_id").val(),

                final_amount:$("#final_amount").val(),

                remark:$("#client_remark").val()

            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    Swal.fire({

                        icon:"success",

                        title:"Success",

                        text:res.message

                    }).then(()=>{

                        $("#clientNegotiationModal").modal("hide");

                        location.reload();

                    });

                }
                else{

                    Swal.fire({

                        icon:"error",

                        title:"Error",

                        text:res.message

                    });

                }

            }

        });

    });

});

$(document).on("click","#loadHistory",function(){

    $.ajax({

        url:base_url+"dashboard/client-project/negotiation-history",

        type:"POST",

        data:{
            project_id:$("#project_id").val()
        },

        dataType:"json",

        success:function(res){

            let html='';

            if(res.length==0){

                html=`
                    <div class="alert alert-warning mb-0">
                        No Negotiation History Found.
                    </div>
                `;

            }else{

                html+=`
                <table class="table table-bordered table-sm">

                    <thead class="table-light">

                        <tr>

                            <th>Date</th>

                            <th>By</th>

                            <th>Old Amount</th>

                            <th>New Amount</th>

                            <th>Remark</th>

                        </tr>

                    </thead>

                    <tbody>
                `;

                $.each(res,function(i,row){

                    html+=`

                    <tr>

                        <td>${row.created_at}</td>

                        <td>

                            ${
                            row.raised_by=="Client"

                            ?

                            '<span class="badge bg-primary">Client</span>'

                            :

                            '<span class="badge bg-dark">Admin</span>'

                            }

                        </td>

                        <td>₹${row.old_price}</td>

                        <td>₹${row.new_price}</td>

                        <td>${row.remark}</td>

                    </tr>

                    `;

                });

                html+=`

                    </tbody>

                </table>

                `;

            }

            $("#historyArea").html(html);

        }

    });

});


$("#btnAcceptOffer").click(function(){

    if(!confirm("Accept Admin Final Offer?")){
        return;
    }

    $.ajax({

        url:base_url+"dashboard/client-project/accept-negotiation",

        type:"POST",

        dataType:"json",

        data:{
            project_id:$("#project_id").val()
        },

        success:function(res){

            alert(res.message);

            if(res.status){

                location.reload();

            }

        }

    });

});