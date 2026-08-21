$(document).ajaxStart(function () {
  $(".ajax-loader").css("display", "flex");
});

$(document).ajaxStop(function () {
  $(".ajax-loader").hide();
});

// ===============Signup Form==========
$("#signupButton").click(function () {
  let name = $("input[name='name']").val();
  let email = $("input[name='email']").val();
  let country_code = $("select[name='country_code']").val();
  let phone = $("input[name='mobile_phone']").val();
  let agree = $("input[name='is_agree']").is(":checked");
  let panFile = $("#owner_pan_card")[0].files[0];
  let aadhaarFile = $("#owner_aadhaar_card")[0].files[0];

  // VALIDATIONS

  if (name === "") {
    toastr.error("Name is required");
    return false;
  }

  if (email === "") {
    toastr.error("Email is required");
    return false;
  }

  if (!validateEmail(email)) {
    toastr.error("Please enter a valid email address");
    return false;
  }

  if (phone === "") {
    toastr.error("Phone number is required");
    return false;
  }

  if (phone.length != 10) {
    toastr.error("Phone number must be of 10 digits");
    return false;
  }

  if (!agree) {
    toastr.error("You must agree to the terms and privacy policy");
    return false;
  }

  if (!panFile && !aadhaarFile) {
    toastr.error("Please upload PAN Card or Aadhaar Card");
    return false;
  }

  // SAVE TEMP DATA (important)
  window.signupData = {
    name: name,
    email: email,
    phone: phone,
    country_code: country_code,
    owner_pan_card: $("#owner_pan_card")[0].files[0] || null,
    owner_aadhaar_card: $("#owner_aadhaar_card")[0].files[0] || null,
  };

  // OPEN MODAL
  $("#docConfirmModal").modal("show");
});

$("#confirmDocsBtn").click(function () {
  let form_url = $("#signupButton").data("form-url");
  let data = window.signupData;

  // Disable button
  $("#confirmDocsBtn").prop("disabled", true);

  // Show loader
  $("#confirmDocsBtn .btn-text").addClass("d-none");
  $("#confirmDocsBtn .btn-loader").removeClass("d-none");

  // ================= FORM DATA =================
  let formData = new FormData();

  formData.append("mobile_phone", data.phone);
  formData.append("email", data.email);
  formData.append("name", data.name);
  formData.append("country_code", data.country_code);

  // PAN Card
  if (data.owner_pan_card) {
    formData.append("owner_pan_card", data.owner_pan_card);
  }

  // Aadhaar Card
  if (data.owner_aadhaar_card) {
    formData.append("owner_aadhaar_card", data.owner_aadhaar_card);
  }

  $.ajax({
    url: form_url,
    type: "POST",
    data: formData,
    dataType: "json",

    // IMPORTANT for file upload
    processData: false,
    contentType: false,

    success: function (response) {
      // Enable button again
      $("#confirmDocsBtn").prop("disabled", false);

      // Hide loader
      $("#confirmDocsBtn .btn-text").removeClass("d-none");
      $("#confirmDocsBtn .btn-loader").addClass("d-none");

      if (response.status === "success") {
        // Hide modal ONLY after success
        $("#docConfirmModal").modal("hide");

        $(".username_cls").html(data.name);

        localStorage.setItem("username", data.name);
        localStorage.setItem("useremail", data.email);
        localStorage.setItem("usermobile", data.phone);

        $(".otp-phone-number").html(data.phone);

        toastr.success(response.message);

        // Move to OTP screen
        showPage(2);
      } else {
        toastr.error(response.message);
      }
    },

    error: function () {
      // Enable button again
      $("#confirmDocsBtn").prop("disabled", false);

      // Hide loader
      $("#confirmDocsBtn .btn-text").removeClass("d-none");
      $("#confirmDocsBtn .btn-loader").addClass("d-none");

      toastr.error("An error occurred. Please try again.");
    },
  });
});

// Function to validate email format
function validateEmail(email) {
  // Comprehensive email regex pattern
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

// Function to check if phone exists (you'll need to implement the endpoint)
function checkPhoneExists(phone, callback) {
  $.ajax({
    url: base_url + "check-phone-exists",
    type: "POST",
    data: { mobile_phone: phone },
    dataType: "json",
    success: function (response) {
      callback(response.exists);
    },
    error: function () {
      callback(false);
    },
  });
}

// ================VerifyOtp=================
$("#verifyOtpButton").click(function () {
  let otp = "";
  $(".otp-each-box").each(function () {
    otp += $(this).val();
  });
  let form_url = $(this).data("form-url");

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
          showPage(3);
      } else {
        toastr.error(response.message);
      }
    },
  });
});

// ================MPin Create===========
$("#mPinCreateButton").click(function () {
  let mpin = "";
  $(".mpin-box").each(function () {
    mpin += $(this).val();
  });

  if (mpin == "") {
    toastr.error("MPIN is required");
    return;
  }

  let form_url = $(this).data("form-url");

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
        window.location.href = base_url+'/center-owner-dashboard';
      } else {
        toastr.error(response.message);
      }
    },
  });
});

// ==============ResentOtp==================
$("#resendOtpButton").click(function () {
  let form_url = $(this).data("form-url");

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
    },
  });
});

// ===============Login Form==============
$("#LoginInBtn").click(function () {
  let mpin = "";
  $(".login-mpin-box").each(function () {
    mpin += $(this).val();
  });

  let mobile_phone = $("#login_mobile_phone").val();
  let form_url = $(this).data("form-url");

  $.ajax({
    url: form_url,
    type: "POST",
    data: { mpin: mpin, mobile_phone: mobile_phone },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        toastr.success(response.message);

        setTimeout(function () {
          // IMPORTANT: backend redirect follow karo
          window.location.href = response.redirect;
        }, 800);
      } else {
        if (response.step) {
          $(".username_cls").html(response.data.username);

          $('input[name="name"]').val(response.data.username);
          $('input[name="email"]').val(response.data.email);
          $('input[name="mobile_phone"]').val(response.data.mobile_phone);

          $('input[name="superintendent_name"]').val(response.data.username);
          $('input[name="superintendent_email"]').val(response.data.email);
          $('input[name="superintendent_number"]').val(
            response.data.mobile_phone,
          );

          showPage(response.step);
        }

        toastr.error(response.message);
      }
    },
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

// =================Add New Lab=====================
$(document).ready(function () {
  // Function to generate a new lab block
  function getLabHTML(labCount) {
    let deleteBtn =
      labCount === 1
        ? ""
        : `<div class="saveBtnWrapper">
                    <button type="button" class="btn btn-outline-danger delete-btn">Delete</button>
               </div>`;

    return `
            <div class="mt-3 newLabWrapperChange">
                <span class="bg-dark text-white p-2 rounded-top lab-number">Lab number ${labCount}</span>
                <div class="lab-details-wrapper p-4 rounded bg-white mt-2">
                    <p><label>Floor number</label>
                        <select class="form-control form-select" name="floor_number[]">
                            <option value="basement">Basement</option>
                            <option value="0">Ground</option>
                            ${Array.from({ length: 30 }, (_, i) => `<option value="${i + 1}">${i + 1}</option>`).join("")}
                        </select>
                    </p>
                    <p><label>Total number of computers?</label>
                        <input type="number" name="no_of_computer[]" class="form-control" min="0">
                    </p>
                    <p><label>System Processor</label>
                        <select name="window_generation[]" class="form-select">
                            <option value="">Select</option>
                            <option value="Core 2 Duo">Core 2 Duo</option>
                            <option value="i3">i3</option>
                            <option value="i5">i5</option>
                            <option value="i7">i7</option>
                        </select>
                    </p>
                    <p><label>Monitor type</label>
                        <select name="monitor_type[]" class="form-select">
                            <option value="">Select</option>
                            <option value="LCD">LCD</option>
                            <option value="LED">LED</option>
                        </select>
                    </p>
                    <p><label>Operating system</label>
                        <select name="operating_system[]" class="form-select">
                            <option value="">Select</option>
                            <option value="Win 7">Win 7</option>
                            <option value="Win 8">Win 8</option>
                            <option value="Win 10">Win 10</option>
                            <option value="Win 11">Win 11</option>
                            <option value="Linux">Linux</option>
                            <option value="MacOS">MacOS</option>
                        </select>
                    </p>
                    <p><label>RAM (in GB)</label>
                        <select name="ram[]" class="form-select">
                            <option value="">Select</option>
                            <option value="2GB">2GB</option>
                            <option value="4GB">4GB</option>
                            <option value="8GB">8GB</option>
                            <option value="16GB">16GB</option>
                            <option value="32GB">32GB</option>
                        </select>
                    </p>
                    <p><label>Hard Disk Drive Capacity in GB</label>
                        <select name="hdd[]" class="form-select">
                            <option value="">Select</option>
                            <option value="80GB">80GB</option>
                            <option value="128GB">128GB</option>
                            <option value="160GB">160GB</option>
                            <option value="256GB">256GB</option>
                            <option value="320GB">320GB</option>
                            <option value="500GB">500GB</option>
                            <option value="1TB">1TB</option>
                            <option value="1.5TB">1.5TB</option>
                            <option value="2TB">2TB</option>
                            <option value="4TB">4TB</option>
                        </select>
                    </p>
                    <p><label>Ethernet Switch’s company</label>
                        <select name="ethernet_company[]" class="form-select">
                            <option value="">Select</option>
                            <option value="Cisco">Cisco</option>
                            <option value="Netgear">Netgear</option>
                            <option value="D-Link">D-Link</option>
                            <option value="TP-Link">TP-Link</option>
                            <option value="Dex">Dex</option>
                            <option value="other">Other</option>
                        </select>
                    </p>
                    <p><label>Switch’s Category</label>
                        <select name="switch_category[]" class="form-select">
                            <option value="">Select</option>
                            <option value="unmanaged">unmanaged</option>
                            <option value="smart">smart</option>
                            <option value="managedL2">managed L2</option>
                            <option value="managedL3">managed L3</option>
                        </select>
                    </p>
                    <p><label>No. of ports of each Ethernet switch?</label>
                        <select name="no_of_each_ethernet_ports[]" class="form-select">
                            <option value="">Select</option>
                            <option value="8">8</option>
                            <option value="16">16</option>
                            <option value="24">24</option>
                            <option value="48">48</option>
                        </select>
                    </p>
                    ${deleteBtn}
                </div>
            </div>`;
  }

  // Re-render labs based on input
  function renderLabs(count) {
    if (count < 1) count = 1;
    $("#labContainerHtml").empty();
    for (let i = 1; i <= count; i++) {
      $("#labContainerHtml").append(getLabHTML(i));
    }
    $("#total_number_of_lab").val(count);
  }

  // Update lab numbering after delete
  function updateLabNumbers() {
    $(".newLabWrapperChange").each(function (index) {
      $(this)
        .find(".lab-number")
        .text("Lab number " + (index + 1));
      // Hide delete button for Lab 1
      if (index === 0) {
        $(this).find(".delete-btn").remove();
      }
    });
    $("#total_number_of_lab").val($(".newLabWrapperChange").length);
  }

  // On input change → rebuild labs
  $("#total_number_of_lab").on("input", function () {
    let count = parseInt($(this).val()) || 1;
    renderLabs(count);
  });

  // Add new lab
  $("#addLabBtn").click(function () {
    let count = $(".newLabWrapperChange").length + 1;
    $("#labContainerHtml").append(getLabHTML(count));
    updateLabNumbers();
  });

  // Delete lab
  $(document).on("click", ".delete-btn", function () {
    $(this).closest(".newLabWrapperChange").remove();
    updateLabNumbers();
  });

  // Initialize with 1 lab by default
  renderLabs(1);
});

// Show input when selecting "Other" in Ethernet Switch’s company
$(document).on("change", 'select[name="ethernet_company[]"]', function () {
  const selectedVal = $(this).val();
  const parent = $(this).closest("p"); // find the current dropdown container

  // Remove any existing custom input first
  parent.find(".custom-ethernet-input").remove();

  if (selectedVal === "other") {
    parent.append(`
            <input type="text" name="ethernet_company_other[]" 
                   class="form-control mt-2 custom-ethernet-input" 
                   placeholder="Enter other Ethernet company name">
        `);
  }
});

// ===============State Fetch===============
function fetchStateByCountryId(country_id) {
  if (country_id == "") {
    $(".state_selection")
      .html('<option value="">Select State</option>')
      .trigger("change");
    $(".city_selection")
      .html('<option value="">Select City</option>')
      .trigger("change");
    return;
  }

  $.ajax({
    url: base_url + "fetch-state-by-country-id",
    type: "POST",
    data: { country_id: country_id },
    dataType: "json",
    success: function (response) {
      console.log(response);
      let options = '<option value="">Select State</option>';
      if (response.length > 0) {
        response.forEach(function (state) {
          options += `<option value="${state.id}">${state.title}</option>`;
        });
      }
      $(".state_selection")
        .html(options)
        .select2({ placeholder: "Search State" });
    },
    error: function () {
      console.log(response);
      alert("Failed to fetch states. Please try again.");
    },
  });
}

// ===============City Fetch===============
function fetchCityByStateId(state_id) {
  $.ajax({
    url: base_url + "fetch-city-by-state-id",
    type: "POST",
    data: { state_id: state_id },
    dataType: "json",
    success: function (response) {
      let options = '<option value="">Select City</option>';
      if (response.length > 0) {
        response.forEach(function (city) {
          options += `<option value="${city.city_id}">${city.city_name}</option>`;
        });
      }
      $(".city_selection")
        .html(options)
        .select2({ placeholder: "Search City" });
    },
    error: function () {
      alert("Failed to fetch city. Please try again.");
    },
  });
}

// ================Project Detail================
function showProjectDetail(project_id, booking_id) {
  $.ajax({
    url: base_url + "detail-project",
    type: "POST",
    data: { project_id: project_id, booking_id: booking_id },
    success: function (response) {
      $(".innerHtmlProjectDetail").html(response);
      $("#projectDetailModal").modal("show");
    },
    error: function () {
      alert("Failed to load project details!");
    },
  });
}

$(document).on("click", ".project-status-change-btn", function () {
  const project_id = $(this).data("project-id");
  const center_id = $(this).data("center-id");

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to accept this booking?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#7367F0",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Accept",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (!result.isConfirmed) {
      return;
    }

    $.ajax({
      url: base_url + "update-booking-status",
      type: "POST",
      dataType: "json",
      data: {
        project_id: project_id,
        center_id: center_id,
      },
      success: function (response) {
        if (response.status) {
          $("#projectDetailModal").modal("hide");

          toastr.success(response.message);

          setTimeout(function () {
            location.reload();
          }, 1500);
        } else {
          toastr.error(response.message);
        }
      },
      error: function () {
        toastr.error("Something went wrong. Please try again.");
      },
    });
  });
});

$(document).on("click", ".reject-modal-open-btn", function () {
  const project_id = $(this).data("project-id");
  const center_id = $(this).data("center-id");

  $.ajax({
    url: base_url + "fetch-reject-booking-content",
    type: "POST",
    data: { project_id: project_id, center_id: center_id },
    success: function (response) {
      $(".innerHtmlRejectModal").html(response);
      $("#rejectionModal").modal("show");
    },
    error: function () {
      alert("Failed to load the data!");
    },
  });
});

$(document).on("click", ".negotiate-modal-open-btn", function () {
  const project_id = $(this).data("project-id");
  const center_id = $(this).data("center-id");

  $.ajax({
    url: base_url + "fetch-negotiate-booking-content",
    type: "POST",
    data: { project_id: project_id, center_id: center_id },
    success: function (response) {
      $(".innerHtmlNegotiationModal").html(response);
      $("#negotiationModal").modal("show");
    },
    error: function () {
      alert("Failed to load the data!");
    },
  });
});

$(document).on("click", ".submit-negotiate-btn", function () {
  const project_id = $(this).data("project-id");
  const center_id = $(this).data("center-id");
  const negotiate = $("#negotiate-price").val().trim();
  const comment = $("#negotiate-comment").val().trim();

  if (negotiate == "") {
    toastr.error("Please enter negotiation price.");
    return;
  }

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to send this negotiation request to the admin?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#7367F0",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Send",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (!result.isConfirmed) {
      return;
    }

    $.ajax({
      url: base_url + "reject-booking-status",

      type: "POST",

      dataType: "json",

      data: {
        project_id: project_id,
        center_id: center_id,
        action: "negotiate",
        negotiate: negotiate,
        rejection_comment: comment,
      },

      success: function (response) {
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
        toastr.error("Something went wrong. Please try again.");
      },
    });
  });
});

$(document).on("click", ".project-reject-btn", function () {
  const project_id = $(this).data("project-id");
  const center_id = $(this).data("center-id");
  const negotiate = $("#price-negotiate-input").val();

  // Get all selected rejection reasons
  const rejectionReasons = [];
  $('input[name="rejection_reasons[]"]:checked').each(function () {
    rejectionReasons.push($(this).val());
  });

  // Get the comment
  const rejectionComment = $('textarea[name="rejection_comment"]').val();

  // Show confirmation dialog
  Swal.fire({
    title: "Are you sure?",
    text: "You are about to reject this project. This action cannot be undone.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, Reject",
    cancelButtonText: "Recheck",
  }).then((result) => {
    if (result.isConfirmed) {
      // If confirmed, send the data
      $.ajax({
        url: base_url + "reject-booking-status",
        type: "POST",
        data: {
          project_id: project_id,
          center_id: center_id,
          rejection_reasons: rejectionReasons,
          rejection_comment: rejectionComment,
          negotiate: negotiate,
          action: "reject",
        },
        success: function (response) {
          $("#rejectionModal").modal("hide");
          $("#projectDetailModal").modal("hide");
          toastr.success("Booking Rejected Successfully");

          setTimeout(function () {
            location.reload();
          }, 2000);
        },
        error: function (xhr) {
          toastr.error(
            "Failed to update status: " +
              (xhr.responseJSON.message || "Unknown error"),
          );
        },
      });
    }
  });
});

// ==========Create self booking===========
$("#createSelfBooking").click(function () {
  let formUrl = document.getElementById("SelfBookingFormUrl").value;
  let formData = new FormData($("#createSelfBookingForm")[0]);

  $.ajax({
    url: formUrl,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Parse JSON response
      let result = JSON.parse(response);

      if (result.status === "success") {
        toastr.success(result.message || "Booking Created Successfully");

        // Reload after 2 seconds
        setTimeout(function () {
          location.reload();
        }, 2000);
      } else if (result.status === "error") {
        toastr.error(
          result.message || "Booking dates conflict with an existing booking!",
        );
      }
    },
    error: function (xhr) {
      // Handle server errors (500, 404, etc.)
      let errorMsg = "Something went wrong. Please try again.";

      // If server returns a JSON error response
      if (xhr.responseJSON && xhr.responseJSON.message) {
        errorMsg = xhr.responseJSON.message;
      }

      toastr.error(errorMsg);
    },
  });
});

// ================Edit self booking=============
function editSelfBooking(id) {
  $.ajax({
    url: base_url + "fetch-edit-self-booking-by-id",
    type: "POST",
    data: { id: id },
    success: function (response) {
      $("#innerHtmlSelfBookingEditModal").html(response);
      $("#edit-self-bookingModal").modal("show");
      attachEditDateListeners();
    },
    error: function () {
      alert("Failed to load the data!");
    },
  });
}

$("#updateSelfBooking").click(function () {
  let $btn = $(this);
  $btn.prop("disabled", true); // Prevent double-click

  let formUrl = document.getElementById("updateSelfBookingFormUrl").value;
  let formData = new FormData($("#updateSelfBookingForm")[0]);

  $.ajax({
    url: formUrl,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      let result =
        typeof response === "object" ? response : JSON.parse(response);

      if (result.status === "success") {
        toastr.success(result.message || "Booking Updated Successfully");
        setTimeout(() => location.reload(), 2000);
      } else if (result.status === "error") {
        toastr.error(
          result.message || "Booking dates conflict with an existing booking!",
        );
      }
    },
    error: function (xhr) {
      let errorMsg =
        xhr.responseJSON?.message || "Something went wrong. Please try again.";
      toastr.error(errorMsg);
    },
    complete: function () {
      $btn.prop("disabled", false); // Re-enable button
    },
  });
});

function deleteSelfBooking(id) {
  Swal.fire({
    title: "Delete Booking?",
    text: "Are you sure you want to delete this booking?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, Delete",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Deleting...",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajax({
        url: base_url + "delete-self-booking",
        type: "POST",
        data: {
          booking_id: id,
        },

        success: function (response) {
          Swal.close();

          toastr.success(response.message || "Booking Deleted Successfully");

          setTimeout(() => {
            location.reload();
          }, 2000);
        },

        error: function () {
          Swal.close();

          toastr.error("Booking deletion failed!");
        },
      });
    }
  });
}

// ====================Calendar=======================
$(document).ready(function () {
  // Handle date selection
  $(document).on("click", ".calender-table td[data-date]", function () {
    const date = $(this).data("date");
    $(".selected-date").removeClass("selected-date");

    // Add selection to clicked date
    $(this).addClass("selected-date");
    loadBookingDetails(date);
  });

  // Handle month/year change with AJAX
  $("#monthSelect, #yearSelect").change(function () {
    const month = $("#monthSelect").val();
    const year = $("#yearSelect").val();

    $.ajax({
      url: base_url + "get_calendar",
      method: "GET",
      data: {
        month: month,
        year: year,
      },
      success: function (response) {
        // Replace the calendar table
        $(".calender-table").replaceWith(response);

        // Update the month/year display
        $("#currentDate").text(
          $("#monthSelect option:selected").text() + " " + year,
        );
      },
    });
  });

  // Load booking details for a date
  function loadBookingDetails(date) {
    $.ajax({
      url: base_url + "get_booking_details",
      method: "GET",
      data: { date: date },
      dataType: "json",
      success: function (response) {
        if (response.length > 0) {
          let html = "";
          response.forEach(function (booking) {
            const isAssigned = booking.type === "assigned_booking";
            const viewBtn = isAssigned
              ? `<button class="btn border-secondary w-100 viewAssignedBooking" data-id="${booking.id}" data-type="assigned-booking">View booking details</button>`
              : `<button class="btn border-secondary w-100 viewSelfBookingByC" data-id="${booking.id}" data-type="self-booking">View booking details</button>`;

            html += `
                        <div class="bg-white p-3 exam-seats-box mb-3">
                            <p>Exam Name: ${booking.exam_name}</p>
                            <p>Seat Booked: <strong>${booking.seats_booked} seats</strong></p>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>Date Range</div>
                                <div>${formatDate(booking.start_date)} to ${formatDate(booking.end_date)}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>Client</div>
                                <div>${booking.client_name}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>Duration</div>
                                <div>${dayDiff(booking.start_date, booking.end_date)} day(s)</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>Timings</div>
                                <div>${formatTime(booking.exam_time)}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>Status</div>
                                <div class="exam-status">${isAssigned ? "Assigned booking" : "Self booking"}</div>
                            </div>
                            <hr>
                            <div class="text-center">
                                ${viewBtn}
                            </div>
                        </div>
                        `;
          });
          $("#bookingDetailsContainer").html(html);
        } else {
          $("#bookingDetailsContainer").html(`
                        <div class="bg-white p-3 exam-seats-box">
                            <p>No exams scheduled for this date</p>
                        </div>
                    `);
        }

        // Update current date display
        $("#currentDate").text(formatDate(date));
      },
    });
  }

  function dayDiff(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end dates
  }

  function formatDate(dateString) {
    const date = new Date(dateString);
    const options = {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    };
    return date.toLocaleDateString("en-US", options);
  }

  function formatTime(timeString) {
    if (!timeString) return "All day";
    const time = timeString.split(":");
    let hours = parseInt(time[0]);
    const minutes = time[1];
    const ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    return hours + ":" + minutes + " " + ampm;
  }
});

// Keep your existing viewSelfBookingByC handler
$(document).on(
  "click",
  ".viewSelfBookingByC, .viewAssignedBooking",
  function () {
    const id = $(this).data("id");
    const type = $(this).data("type");

    $.ajax({
      url: base_url + "fetch-booking-view-by-id",
      type: "POST",
      data: { id: id, type: type },
      success: function (response) {
        $("#innerHtmlViewBookingModal").html(response);
        $("#viewBookingDetailModal").modal("show");
      },
      error: function () {
        alert("Failed to load the data!");
      },
    });
  },
);

// =================Change Batch====================
$(function () {
  $("#changeBatch").change(function () {
    let batchCount = parseInt($(this).val());

    $(".batch-div").hide();

    for (let i = 1; i <= batchCount; i++) {
      $("#divexbatch" + i).show();
    }
  });
});

$(document).on("change", ".batch-end", function () {
  let batch = $(this).data("batch");

  let start = $("input[name='batch" + batch + "_start']").val();
  let end = $(this).val();

  if (start && end) {
    if (end <= start) {
      alert("End time must be greater than start time for Batch " + batch);
      $(this).val("");
    }
  }
});

$(document).on("change", ".batch-start", function () {
  let batch = $(this).data("batch");
  let start = $(this).val();

  $("input[name='batch" + batch + "_end']").attr("min", start);
});

document.addEventListener("DOMContentLoaded", function () {
  let today = new Date().toISOString().split("T")[0];

  document.getElementById("start_date").min = today;
  document.getElementById("end_date").min = today;
});

function handleStartDateChange() {
  let startDate = document.getElementById("start_date").value;
  let endDateField = document.getElementById("end_date");

  if (startDate) {
    // Disable all dates before start date
    endDateField.min = startDate;

    // Automatically select same date in end date
    if (!endDateField.value || endDateField.value < startDate) {
      endDateField.value = startDate;
    }

    calculateDuration();
  }
}

//===============Duration calculation================
function calculateDuration() {
  const startDate = document.getElementById("start_date").value;
  const endDate = document.getElementById("end_date").value;

  if (startDate && endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);

    const diffTime = end - start;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

    const durationField = document.getElementById("exam_duration");

    if (diffDays >= 1) {
      durationField.value = diffDays;
    } else {
      durationField.value = "";
      toastr.error("End date should be after or same as start date.");
    }
  }
}

// Attach event listeners
document
  .getElementById("start_date")
  .addEventListener("change", calculateDuration);
document
  .getElementById("end_date")
  .addEventListener("change", calculateDuration);

function attachEditDateListeners() {
  const startDateField = document.getElementById("edit_start_date");
  const endDateField = document.getElementById("edit_end_date");

  function calculateEditDuration() {
    const startDate = startDateField.value;
    const endDate = endDateField.value;

    if (startDate && endDate) {
      const start = new Date(startDate);
      const end = new Date(endDate);

      const diffTime = end - start;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

      const durationField = document.getElementById("edit_exam_duration");

      if (diffDays >= 1) {
        durationField.value = diffDays;
      } else {
        durationField.value = "";
        toastr.error("End date should be after or same as start date.");
      }
    }
  }

  function handleEditStartDateChange() {
    const startDate = startDateField.value;

    if (startDate) {
      // Disable dates before start date
      endDateField.min = startDate;

      // Auto select start date if end date is empty or smaller
      if (!endDateField.value || endDateField.value < startDate) {
        endDateField.value = startDate;
      }

      calculateEditDuration();
    }
  }

  // Set initial min value when modal opens
  if (startDateField.value) {
    endDateField.min = startDateField.value;

    if (!endDateField.value || endDateField.value < startDateField.value) {
      endDateField.value = startDateField.value;
    }
  }

  // Remove old listeners (important if modal opens multiple times)
  startDateField.onchange = handleEditStartDateChange;
  endDateField.onchange = calculateEditDuration;

  // Initial duration calculation
  calculateEditDuration();
}

// ==========================Image Preview===================
function previewLogo(event) {
  const input = event.target;
  const previewContainer = document.getElementById("logo-preview-container");
  const preview = document.getElementById("logo-preview");

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      previewContainer.style.display = "block";
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function removeLogo() {
  const input = document.getElementById("logo-upload");
  const previewContainer = document.getElementById("logo-preview-container");

  input.value = ""; // Clear the file input
  previewContainer.style.display = "none";
}

// Multiple images preview and removal
function previewFiles(event, previewContainerId) {
  const input = event.target;
  const previewContainer = document.getElementById(previewContainerId);

  if (input.files) {
    previewContainer.innerHTML = "";

    Array.from(input.files).forEach((file, index) => {
      const reader = new FileReader();

      reader.onload = function (e) {
        const previewWrapper = document.createElement("div");
        previewWrapper.className = "image-preview-wrapper";

        let preview;

        if (file.type.startsWith("image/")) {
          preview = document.createElement("img");
          preview.className = "preview-image";
        } else if (file.type.startsWith("video/")) {
          preview = document.createElement("video");
          preview.className = "preview-video";
          preview.controls = true;
        }

        if (preview) {
          preview.src = e.target.result;

          const deleteBtn = document.createElement("button");
          deleteBtn.type = "button";
          deleteBtn.className = "delete-image-btn";
          deleteBtn.innerHTML = "×";
          deleteBtn.onclick = function () {
            removeFile(input, previewWrapper, index);
          };

          previewWrapper.appendChild(preview);
          previewWrapper.appendChild(deleteBtn);
          previewContainer.appendChild(previewWrapper);
        }
      };

      reader.readAsDataURL(file);
    });
  }
}

function removeFile(input, previewWrapper, index) {
  const files = Array.from(input.files);
  files.splice(index, 1);

  const dataTransfer = new DataTransfer();
  files.forEach((file) => dataTransfer.items.add(file));
  input.files = dataTransfer.files;

  previewWrapper.remove();

  const event = new Event("change");
  input.dispatchEvent(event);
}
