// /////////////////////////// pagination of table script start /////////////////////
document.addEventListener("DOMContentLoaded", function () {
  let table = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
  let rows = table.getElementsByTagName("tr");
  let rowsPerPage = 20;
  let currentPage = 1;

  function showPage(page) {
    let start = (page - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    for (let i = 0; i < rows.length; i++) {
      rows[i].style.display = i >= start && i < end ? "table-row" : "none";
    }

    document.getElementById("pageBox").innerText = `Page ${currentPage}`;
    document.getElementById("prevBtn").disabled = currentPage === 1;
    document.getElementById("nextBtn").disabled = currentPage === Math.ceil(rows.length / rowsPerPage);
  }

  document.getElementById("prevBtn").addEventListener("click", function () {
    if (currentPage > 1) {
      currentPage--;
      showPage(currentPage);
    }
  });

  document.getElementById("nextBtn").addEventListener("click", function () {
    if (currentPage < Math.ceil(rows.length / rowsPerPage)) {
      currentPage++;
      showPage(currentPage);
    }
  });

  showPage(currentPage);
});
// /////////////////////////// pagination of table script end ////////////////////////



// ////////////////////////// Pagr next and Previous script start //////////////////////////////////////////

function showPage(pageNumber) {
  // Sab pages hide kar do
  document.querySelectorAll(".page").forEach(page => {
    page.classList.remove("active");
  });

  // Sirf current page dikhana hai
  document.getElementById(`page${pageNumber}`).classList.add("active");
}

// ////////////////////////// Pagr next and Previous script end //////////////////////////////////////////


// ///////////////////////////////////// slider script start ///////////////////////////////////////////

// function createSlider(sliderId, images, indicatorClass) {
//   const slider = document.getElementById(sliderId);
//   const indicators = document.querySelectorAll(`${indicatorClass} div`);
//   let index = 0;
//   function changeSlide() {
//     slider.style.backgroundImage = `url('${images[index]}')`;
//     indicators.forEach(ind => ind.classList.remove("active"));
//     indicators[index].classList.add("active");
//     index = (index + 1) % images.length;
//   }
//   setInterval(changeSlide, 3000);
//   changeSlide();
// }
// createSlider("slider1", [
//   "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSguMMxq75VndXQlhJQgKRLSwcTnLAaYXryw&s",
//   "https://5.imimg.com/data5/QP/KK/MY-30533217/online-exam-center-creations.jpg",
//   "https://img.freepik.com/free-photo/woman-with-super-gesture-university-lecture_23-2147679176.jpg?t=st=1739945557~exp=1739949157~hmac=d93da0b90eab75ebc5c11f0e6b0ce526ae98f58159bd0109f28bfbfdf2fc9e3a&w=740"
// ], ".sliderIndicator1");

// createSlider("slider2", [
//   "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSguMMxq75VndXQlhJQgKRLSwcTnLAaYXryw&s",
//   "https://5.imimg.com/data5/QP/KK/MY-30533217/online-exam-center-creations.jpg",
//   "https://img.freepik.com/free-photo/woman-with-super-gesture-university-lecture_23-2147679176.jpg?t=st=1739945557~exp=1739949157~hmac=d93da0b90eab75ebc5c11f0e6b0ce526ae98f58159bd0109f28bfbfdf2fc9e3a&w=740"
// ], ".sliderIndicator2");

// createSlider("slider3", [
//   "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSguMMxq75VndXQlhJQgKRLSwcTnLAaYXryw&s",
//   "https://5.imimg.com/data5/QP/KK/MY-30533217/online-exam-center-creations.jpg",
//   "https://img.freepik.com/free-photo/woman-with-super-gesture-university-lecture_23-2147679176.jpg?t=st=1739945557~exp=1739949157~hmac=d93da0b90eab75ebc5c11f0e6b0ce526ae98f58159bd0109f28bfbfdf2fc9e3a&w=740"
// ], ".sliderIndicator3");

// createSlider("slider4", [
//   "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSguMMxq75VndXQlhJQgKRLSwcTnLAaYXryw&s",
//   "https://5.imimg.com/data5/QP/KK/MY-30533217/online-exam-center-creations.jpg",
//   "https://img.freepik.com/free-photo/woman-with-super-gesture-university-lecture_23-2147679176.jpg?t=st=1739945557~exp=1739949157~hmac=d93da0b90eab75ebc5c11f0e6b0ce526ae98f58159bd0109f28bfbfdf2fc9e3a&w=740"
// ], ".sliderIndicator4");

// ///////////////////////////////////////// slider script end ///////////////////////////////////////////


// //////////////////////////////////////// open pop-Up script start /////////////////////////////////////////
function openPopup() {
  document.getElementById("finalScreenPopup").style.display = "flex";
}
function closePopup() {
  document.getElementById("finalScreenPopup").style.display = "none";
}
// ///////////////////////////////////////  open pop-Up script start ////////////////////////////////////////
const formItems = document.querySelectorAll(".formStep");
const formPrevBtns = document.querySelectorAll(".formPreviousBtn");
const formNextBtns = document.querySelectorAll(".formNextBtn");
const popupButton = document.querySelectorAll(".popupButton");  
const formIndicators = document.querySelectorAll(".formIndicator");

let currentStep = 0;

// Function to validate fields for each step
// const validateStep = () => {
//     let isValid = true;
//     let firstErrorField = null; // To focus on the first invalid field
//     let showToastr = true; // To prevent multiple Toastr messages

//     const totalSteps = $(".formStep").length;

//     const hasGST = $("input[name='has_gst']:checked").val();
//     const hasMSME = $("input[name='has_msme']:checked").val();
//     const generatorAvailable = $("select[name='is_generator_backup']").val();

//     let excludedFields = [
//         'capacity',
//         'nearest_metro_station',
//         'distance_from_metro_station',
//         'secondary_infrastructure',
//         'secondary_isp_connect_type',
//         'secondary_internet_speed_unit',
//         'secondary_isp_speed',
//         'emergency_phone_number',
//         'emergency_landline_number',

//         // Bank & KYC Fields
//         'beneficiary_name',
//         'bank_name',
//         'bank_account_number',
//         'bank_ifsc',
//         'pannumber',
//         'gst_number',
//         'gst_state_code',
//         'uidai_number',
//         'msme_number',

//         // Optional flags (radio)
//         'has_gst',
//         'has_msme'
//     ];

//     // GST = NO
//     if (hasGST === "no") {
//         excludedFields.push('gst_number', 'gst_state_code', 'gst_file', 'gst_certificate');
//     }

//     // MSME = NO
//     if (hasMSME === "no") {
//         excludedFields.push('msme_number');
//     }

//     // Generator = NO
//     if (generatorAvailable === "no") {
//         excludedFields.push('generator_backup_capacity', 'generator_fuel_tank_capacity');
//     }

//     $(".formStep").eq(currentStep).find("input, textarea, select").each(function () {

//         let field = $(this);
//         let value = field.val().trim();
//         let name = field.attr("name") || "";
//         let type = field.attr("type");

//         // Skip excluded fields
//         if (excludedFields.some(f => name.includes(f))) {
//             return;
//         }

//         if (type === "file") {
//             return;
//         }

//         // Remove previous validation styles
//         field.removeClass("is-invalid is-valid");

//         // Required Field Check (Except Radio)
//         if (!value && type !== "radio") {
//             field.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = field;
//         }

//         // Radio Button Validation
//         if (type === "radio") {
//             let radioGroup = $(`input[name="${name}"]`);
//             let radioContainer = radioGroup.closest(".radio-container");

//             if (radioGroup.filter(":checked").length === 0) {
//                 radioGroup.addClass("is-invalid");
//                 radioContainer.addClass("is-invalid");
//                 isValid = false;
//                 if (!firstErrorField) firstErrorField = radioGroup.first();
//             } else {
//                 radioGroup.removeClass("is-invalid").addClass("is-valid");
//                 radioContainer.removeClass("is-invalid").addClass("is-valid");
//             }
//         }

//         // Phone Validation
//         if (
//             /phone_number|contact_phone_number|contact_alternate_phone_number|superintendent_number|assistant_manager_phone_number|emergency_phone_number|lab_phone_number|lab_landline_number/i.test(
//                 name
//             ) && value
//         ) {
//             let phoneRegex = /^\d{10}$/;
//             if (!phoneRegex.test(value)) {
//                 field.addClass("is-invalid");
//                 isValid = false;
//                 if (!firstErrorField) firstErrorField = field;

//                 if (showToastr || field.data("lastInvalid") !== value) {
//                     toastr.error(`${name.replace(/_/g, " ")} must be exactly 10 digits.`);
//                     field.data("lastInvalid", value);
//                     showToastr = false;
//                 }
//             } else {
//                 field.addClass("is-valid");
//                 field.removeData("lastInvalid");
//             }
//         }

//         // Landline Validation
//         if (/emergency_landline_number/i.test(name) && value) {

//             // Landline must start with 2-9 and be 8 digits
//             let phoneRegex = /^[2-9]\d{7}$/;

//             if (!phoneRegex.test(value)) {
//                 field.addClass("is-invalid");
//                 isValid = false;
//                 if (!firstErrorField) firstErrorField = field;

//                 if (showToastr || field.data("lastInvalid") !== value) {
//                     toastr.error(`${name.replace(/_/g, " ")} must be a valid 8 digit landline number.`);
//                     field.data("lastInvalid", value);
//                     showToastr = false;
//                 }
//             } else {
//                 field.removeClass("is-invalid");
//                 field.addClass("is-valid");
//                 field.removeData("lastInvalid");
//             }
//         }

//         // Numbers only
//         if (/total_number_of_lab|total_number_of_system/i.test(name) && value) {
//             let numberRegex = /^\d+$/;
//             if (!numberRegex.test(value)) {
//                 field.addClass("is-invalid");
//                 isValid = false;
//                 if (!firstErrorField) firstErrorField = field;

//                 if (showToastr) {
//                     toastr.error(`${name.replace(/_/g, " ")} must be a valid number.`);
//                     showToastr = false;
//                 }
//             } else {
//                 field.addClass("is-valid");
//             }
//         }

//         // Email validation
//         if (/email/i.test(name) && value) {
//             let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
//             if (!emailRegex.test(value)) {
//                 field.addClass("is-invalid");
//                 isValid = false;
//                 if (!firstErrorField) firstErrorField = field;

//                 if (showToastr) {
//                     toastr.error(`${name.replace(/_/g, " ")} is not valid`);
//                     showToastr = false;
//                 }
//             } else {
//                 field.addClass("is-valid");
//             }
//         }
//     });


//     if (currentStep === 0) {
//         let isValid = true;
//         let firstErrorField = null;
//         let showToastr = true;

//         // Helper function for file validation
//         function validateFiles(input, maxSize, allowedTypes, errorMsg, maxFiles, isRequired = false) {

//             // Safety check (important)
//             if (!input || input.length === 0 || !input[0]) {
//                 return;
//             }

//             let files = input[0].files;

//             // REQUIRED VALIDATION
//             if (isRequired && files.length === 0) {
//                 input.addClass("is-invalid");
//                 isValid = false;

//                 if (!firstErrorField) firstErrorField = input;

//                 if (showToastr) {
//                     toastr.error("Please upload " + errorMsg);
//                     showToastr = false;
//                 }
//                 return;
//             }

//             // MAX FILE LIMIT
//             if (files.length > maxFiles) {
//                 input.addClass("is-invalid");
//                 isValid = false;

//                 if (!firstErrorField) firstErrorField = input;

//                 if (showToastr) {
//                     toastr.error(errorMsg + " - You can upload maximum " + maxFiles + " file(s)");
//                     showToastr = false;
//                 }
//                 return;
//             }

//             // SIZE & TYPE CHECK
//             if (files.length > 0) {
//                 Array.from(files).forEach(file => {

//                     if (file.size > maxSize) {
//                         input.addClass("is-invalid");
//                         isValid = false;

//                         if (!firstErrorField) firstErrorField = input;

//                         if (showToastr) {
//                             toastr.error(errorMsg + " (file too large)");
//                             showToastr = false;
//                         }
//                     }

//                     if (!allowedTypes.includes(file.type)) {
//                         input.addClass("is-invalid");
//                         isValid = false;

//                         if (!firstErrorField) firstErrorField = input;

//                         if (showToastr) {
//                             toastr.error(errorMsg + " (invalid file type)");
//                             showToastr = false;
//                         }
//                     }

//                 });
//             }
//         }

//         // 1. Center Name
//         const centerName = $("input[name='center_name']");
//         if (!centerName.val().trim()) {
//             centerName.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = centerName;
//             if (showToastr) { toastr.error("Center name is required"); showToastr = false; }
//         }

//         // 2. Center Description
//         const centerDesc = $("input[name='center_description']");
//         if (!centerDesc.val().trim()) {
//             centerDesc.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = centerDesc;
//             if (showToastr) { toastr.error("Center description is required"); showToastr = false; }
//         } else if (centerDesc.val().trim().length < 20) {
//             centerDesc.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = centerDesc;
//             if (showToastr) { toastr.error("Center description should be at least 20 characters"); showToastr = false; }
//         }

//         // 3. Postal Address
//         const postalAddress = $("input[name='postal_address']");
//         if (!postalAddress.val().trim()) {
//             postalAddress.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = postalAddress;
//             if (showToastr) { toastr.error("Postal address is required"); showToastr = false; }
//         }

//         // 4. Latitude/Longitude
//         const lat = $("input[name='address_lat']");
//         const long = $("input[name='address_long']");
//         const latLongRegex = /^-?\d{1,9}\.\d{1,9}$/;
//         if (!lat.val().trim() || !latLongRegex.test(lat.val())) {
//             lat.addClass("is-invalid"); isValid = false;
//             if (!firstErrorField) firstErrorField = lat;
//             if (showToastr) { toastr.error("Please enter a valid latitude (xx.xxxxxx)"); showToastr = false; }
//         }
//         if (!long.val().trim() || !latLongRegex.test(long.val())) {
//             long.addClass("is-invalid"); isValid = false;
//             if (!firstErrorField) firstErrorField = long;
//             if (showToastr) { toastr.error("Please enter a valid longitude (xx.xxxxxx)"); showToastr = false; }
//         }

//         // 5. Capacity
//         // const capacity = $("input[name='capacity']");
//         // if (!capacity.val() || capacity.val() < 1) {
//         //     capacity.addClass("is-invalid"); isValid = false;
//         //     if (!firstErrorField) firstErrorField = capacity;
//         //     if (showToastr) { toastr.error("Capacity must be at least 1"); showToastr = false; }
//         // }

//         // 6. File uploads
//         validateFiles($("input[name='center_logo']"), 1048576, ['image/jpeg','image/png','image/jpg'], "Center Logo", 1, true);

//         validateFiles($("input[name='center_entrances[]']"), 1048576, ['image/jpeg','image/png','image/jpg'], "Center Entrance", 2, true);

//         validateFiles($("input[name='lab_photos[]']"), 1048576, ['image/jpeg','image/png','image/jpg'], "Lab photo", 2, true);

//         validateFiles($("input[name='main_gate_images[]']"), 1048576, ['image/jpeg','image/png','image/jpg'], "Main gate photo", 1, true);

//         validateFiles($("input[name='server_room_images[]']"), 1048576, ['image/jpeg','image/png','image/jpg'], "Server room photo", 1, true);

//         validateFiles($("input[name='observer_room_images[]']"), 1048576, ['image/jpeg','image/png','image/jpg'], "Observer room photo", 1, true);

//         validateFiles($("input[name='ups_generator_images[]']"), 1048576, ['image/jpeg','image/png','image/jpg'], "UPS/Generator photo", 2, true);

//         validateFiles($("input[name='walkthrough_video']"), 5242880, ['video/mp4','video/webm'], "Walkthrough video", 1, true);

//         // 7. Nearby Landmark
//         const landmark = $("input[name='nearby_landmark']");
//         if (!landmark.val().trim()) {
//             landmark.addClass("is-invalid"); isValid = false;
//             if (!firstErrorField) firstErrorField = landmark;
//             if (showToastr) { toastr.error("Nearby landmark is required"); showToastr = false; }
//         }

//         // 8. Location Fields
//         const country = $("select[name='country_id']");
//         const state = $("select[name='state_id']");
//         const city = $("select[name='city_id']");
//         const localArea = $("input[name='local_area_name']");
//         const pincode = $("input[name='pincode']");

//         if (!country.val()) { country.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = country; if (showToastr){ toastr.error("Country is required"); showToastr = false; } }
//         if (!state.val()) { state.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = state; if (showToastr){ toastr.error("State is required"); showToastr = false; } }
//         if (!city.val()) { city.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = city; if (showToastr){ toastr.error("City is required"); showToastr = false; } }
//         if (!localArea.val().trim()) { localArea.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = localArea; if (showToastr){ toastr.error("Local area is required"); showToastr = false; } }
//         if (!pincode.val()) { pincode.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = pincode; if (showToastr){ toastr.error("Pincode is required"); showToastr = false; } }
//         else if (!/^\d{6}$/.test(pincode.val())) { pincode.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = pincode; if (showToastr){ toastr.error("Pincode must be 6 digits"); showToastr = false; } }

//         // 9. Center Category
//         const centerCategory = $("select[name='test_center_category']");
//         if (!centerCategory.val()) { centerCategory.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = centerCategory; if (showToastr){ toastr.error("Center category is required"); showToastr = false; } }

//         // 10. Lift Availability
//         const liftAvailable = $("input[name='is_lift_available']");
//         if (liftAvailable.filter(":checked").length === 0) {
//             liftAvailable.addClass("is-invalid"); isValid = false;
//             if (!firstErrorField) firstErrorField = liftAvailable.first();
//             if (showToastr) { toastr.error("Please specify lift availability"); showToastr = false; }
//         }

//         // 11. Station & Distance validation
//         const locations = [
//             { station: "nearest_railway_station", distance: "distance_from_railway_station", name: "Railway station" },
//             { station: "nearest_bus_stop", distance: "distance_from_bus_stop", name: "Bus station" },
//             // { station: "nearest_metro_station", distance: "distance_from_metro_station", name: "Metro station" },
//             { station: "nearest_airport", distance: "distance_from_airport", name: "Airport" }
//         ];

//         locations.forEach(loc => {
//             const station = $(`input[name='${loc.station}']`);
//             const distance = $(`select[name='${loc.distance}']`);
//             if (!station.val().trim()) { station.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = station; if (showToastr){ toastr.error(`${loc.name} name is required`); showToastr = false; } }
//             if (!distance.val()) { distance.addClass("is-invalid"); isValid = false; if (!firstErrorField) firstErrorField = distance; if (showToastr){ toastr.error(`${loc.name} distance is required`); showToastr = false; } }
//         });

//         if (firstErrorField) firstErrorField.focus();
//         return isValid;
//     }


//     if (currentStep === 1) {
//         let isValid = true;
//         let firstErrorField = null;
//         let showToastr = true;

//         // Point of Contact
//         const contactName = $("input[name='point_of_contact']");
//         const contactPhone = $("input[name='contact_phone_number']");
//         const contactAltPhone = $("input[name='contact_alternate_phone_number']");
//         const contactEmail = $("input[name='contact_email']");

//         if (!contactName.val().trim()) {
//             contactName.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = contactName;
//             if (showToastr) { toastr.error("Point of contact name is required"); showToastr = false; }
//         }

//         if (!contactPhone.val() || !/^\d{10}$/.test(contactPhone.val())) {
//             contactPhone.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = contactPhone;
//             if (showToastr) { toastr.error("Valid 10-digit phone number is required"); showToastr = false; }
//         }

//         if (!contactAltPhone.val().trim() || !/^\d{10}$/.test(contactAltPhone.val())) {
//             contactAltPhone.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = contactAltPhone;
//             if (showToastr) { toastr.error("Alternate phone must be 10 digits"); showToastr = false; }
//         }

//         if (!contactEmail.val() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(contactEmail.val())) {
//             contactEmail.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = contactEmail;
//             if (showToastr) { toastr.error("Valid contact email is required"); showToastr = false; }
//         }

//         // IT Manager (Assistant Manager) - REQUIRED now
//         const asstManagerName = $("input[name='assistant_manager_name']");
//         const asstManagerPhone = $("input[name='assistant_manager_phone_number']");
//         const asstManagerEmail = $("input[name='assistant_manager_email']");

//         if (!asstManagerName.val().trim()) {
//             asstManagerName.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = asstManagerName;
//             if (showToastr) { toastr.error("IT Manager name is required"); showToastr = false; }
//         }

//         if (!asstManagerPhone.val() || !/^\d{10}$/.test(asstManagerPhone.val())) {
//             asstManagerPhone.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = asstManagerPhone;
//             if (showToastr) { toastr.error("Valid 10-digit IT Manager phone is required"); showToastr = false; }
//         }

//         if (!asstManagerEmail.val() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(asstManagerEmail.val())) {
//             asstManagerEmail.addClass("is-invalid");
//             isValid = false;
//             if (!firstErrorField) firstErrorField = asstManagerEmail;
//             if (showToastr) { toastr.error("Valid IT Manager email is required"); showToastr = false; }
//         }

//         // Emergency Contact - REQUIRED
//         const emergencyPhone = $("input[name='emergency_phone_number']");
//         const emergencyLandline = $("input[name='emergency_landline_number']");

//         // if (!emergencyPhone.val() || !/^\d{10}$/.test(emergencyPhone.val())) {
//         //     emergencyPhone.addClass("is-invalid");
//         //     isValid = false;
//         //     if (!firstErrorField) firstErrorField = emergencyPhone;
//         //     if (showToastr) { toastr.error("Emergency phone number is required and must be 10 digits"); showToastr = false; }
//         // }

//         // if (!emergencyLandline.val() || !/^\d{6,12}$/.test(emergencyLandline.val())) {
//         //     emergencyLandline.addClass("is-invalid");
//         //     isValid = false;
//         //     if (!firstErrorField) firstErrorField = emergencyLandline;
//         //     if (showToastr) { toastr.error("Emergency landline number is required (6-12 digits)"); showToastr = false; }
//         // }

//         if (firstErrorField) firstErrorField.focus();
//     }


//     if (currentStep === 2) {
//       // --- General Lab Details ---
//       const totalLabs = $("input[name='total_number_of_lab']");
//       const totalSystems = $("input[name='total_number_of_system']");
//       const singleNetwork = $("select[name='lab_are_connect_to_single_network']");
//       const totalNetworks = $("input[name='total_network']");
//       const partition = $("select[name='partition_in_each_lab']");
//       const ac = $("select[name='ac_in_each_lab']");
//       const printer = $("select[name='is_network_printer_availabel']");
//       const projector = $("select[name='is_there_projector_in_each_lab']");
//       const soundSytem = $("select[name='is_there_sound_sytem_in_each_lab']");
//       const fireExt = $("select[name='how_many_fire_extinguisher_in_each_lab']");
//       const locker = $("select[name='is_there_a_locker_facility_in_lab']");
//       const water = $("select[name='is_there_a_drinking_water_facility_in_lab']");

//       // Total Labs
//       if (!totalLabs.val() || parseInt(totalLabs.val()) < 1) {
//           totalLabs.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = totalLabs;
//           if (showToastr) { toastr.error("Please enter total number of labs (min 1)"); showToastr = false; }
//       }

//       // Total Systems
//       if (!totalSystems.val() || !/^\d+$/.test(totalSystems.val())) {
//           totalSystems.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = totalSystems;
//           if (showToastr) { toastr.error("Please enter total number of systems"); showToastr = false; }
//       }

//       // Single Network
//       if (!singleNetwork.val()) {
//           singleNetwork.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = singleNetwork;
//           if (showToastr) { toastr.error("Please select if labs are connected via single network"); showToastr = false; }
//       }

//       // Total Networks (only if single network = no)
//       if (singleNetwork.val() === "no" && (!totalNetworks.val() || parseInt(totalNetworks.val()) <= 0)) {
//           totalNetworks.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = totalNetworks;
//           if (showToastr) { toastr.error("Please enter total number of networks"); showToastr = false; }
//       }

//       // Partition, AC, Printer, Projector, Fire Ext, Locker, Water
//       const infraSelects = [partition, ac, printer, projector, soundSytem, fireExt, locker, water];

//         const infraLabels = [
//             "Partition in each lab",
//             "AC in each lab",
//             "Network Printer",
//             "Projector",
//             "Sound System",
//             "Fire Extinguisher",
//             "Locker Facility",
//             "Drinking Water Facility"
//         ];

//       infraSelects.forEach((field, i) => {
//           if (!field.val()) {
//               field.addClass("is-invalid");
//               isValid = false;
//               if (!firstErrorField) firstErrorField = field;
//               if (showToastr) { toastr.error(`${infraLabels[i]} is required`); showToastr = false; }
//           }
//       });
      

//       // --- Lab Infrastructure ---
//       const primaryISP = $("input[name='primary_infrastructure']");
//       const primaryISPConnectionType = $("select[name='primary_isp_connect_type']");
//       const primarySpeed = $("input[name='primary_isp_speed']");
//       const generatorAvailable = $("select[name='is_generator_backup']");
//       const generatorCapacity = $("input[name='generator_backup_capacity']");
//       const generatorFuelCapacity = $("select[name='generator_fuel_tank_capacity']");
//       const upsBackup = $("input[name='ups_backup']");
//       const upsTime = $("select[name='ups_backup_time']");

//       // Primary ISP
//       if (!primaryISP.val().trim()) {
//           primaryISP.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = primaryISP;
//           if (showToastr) { toastr.error("Primary ISP name is required"); showToastr = false; }
//       }

//       // Primary Speed
//       if (!primarySpeed.val() || parseInt(primarySpeed.val()) <= 0) {
//           primarySpeed.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = primarySpeed;
//           if (showToastr) { toastr.error("Primary ISP speed is required"); showToastr = false; }
//       }
      
//       // Primary Connection Type
//       if (!primaryISPConnectionType.val()) {
//           primaryISPConnectionType.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = primaryISPConnectionType;
//           if (showToastr) { toastr.error("Please select primary ISP connection type"); showToastr = false; }
//       }

//       // Generator Available
//       if (!generatorAvailable.val()) {
//           $("select[name='is_generator_backup']").addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = $("select[name='is_generator_backup']");
//           if (showToastr) { toastr.error("Please select if generator is available"); showToastr = false; }
//       }

//       // Generator & UPS (only if generator = yes)
//       if (generatorAvailable.val() === "yes") {
//           if (!generatorCapacity.val().trim()) {
//               generatorCapacity.addClass("is-invalid");
//               isValid = false;
//               if (!firstErrorField) firstErrorField = generatorCapacity;
//               if (showToastr) { toastr.error("Generator capacity is required"); showToastr = false; }
//           }
//           if (!generatorFuelCapacity.val()) {
//               generatorFuelCapacity.addClass("is-invalid");
//               isValid = false;
//               if (!firstErrorField) firstErrorField = generatorFuelCapacity;
//               if (showToastr) { toastr.error("Generator backup time is required"); showToastr = false; }
//           }
//       }

//       // Ups
//       if (!upsBackup.val().trim()) {
//           upsBackup.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = upsBackup;
//           if (showToastr) { toastr.error("UPS backup capacity is required"); showToastr = false; }
//       }
//       if (!upsTime.val()) {
//           upsTime.addClass("is-invalid");
//           isValid = false;
//           if (!firstErrorField) firstErrorField = upsTime;
//           if (showToastr) { toastr.error("UPS backup time is required"); showToastr = false; }
//       }

//       // --- Lab Details Loop (already in your code) ---
//       $(".newLabWrapperChange").each(function(index) {
//           const labNumber = index + 1;
//           const labWrapper = $(this);

//           const totalComputers = labWrapper.find("input[name='no_of_computer[]']");
//           const windowGeneration = labWrapper.find("select[name='window_generation[]']");
//           const monitorType = labWrapper.find("select[name='monitor_type[]']");
//           const operatingSystem = labWrapper.find("select[name='operating_system[]']");
//           const ram = labWrapper.find("select[name='ram[]']");
//           const hdd = labWrapper.find("select[name='hdd[]']");
//           const ethernetCompany = labWrapper.find("select[name='ethernet_company[]']");
//           const switchCategory = labWrapper.find("select[name='switch_category[]']");
//           const ethernetPorts = labWrapper.find("select[name='no_of_each_ethernet_ports[]']");

//           if (!totalComputers.val() || !/^\d+$/.test(totalComputers.val())) {
//               totalComputers.addClass("is-invalid");
//               isValid = false;
//               if (!firstErrorField) firstErrorField = totalComputers;
//               if (showToastr) { toastr.error(`Valid number of computers is required in Lab ${labNumber}`); showToastr = false; }
//           }

//           const selects = [windowGeneration, monitorType, operatingSystem, ram, hdd, ethernetCompany, switchCategory, ethernetPorts];
//           const labels = ["Window Generation", "Monitor Type", "Operating System", "RAM", "HDD", "Ethernet Switch Company", "Switch Category", "Ethernet Ports"];

//           selects.forEach((field, i) => {
//               if (!field.val()) {
//                   field.addClass("is-invalid");
//                   isValid = false;
//                   if (!firstErrorField) firstErrorField = field;
//                   if (showToastr) { toastr.error(`${labels[i]} is required in Lab ${labNumber}`); showToastr = false; }
//               }
//           });
//       });
//     }


//     if (currentStep === totalSteps - 1) {

//       $(".is-invalid").removeClass("is-invalid");

//       // // --- Field selectors ---
//       // const beneficiaryName = $("input[name='beneficiary_name']");
//       // const bankName = $("input[name='bank_name']");
//       // const accountNumber = $("input[name='bank_account_number']");
//       // const ifscCode = $("input[name='bank_ifsc']");
//       // const panNumber = $("input[name='pannumber']");
//       // const gstNumber = $("input[name='gst_number']");
//       // const gstStateCode = $("input[name='gst_state_code']");
//       // const uidaiNumber = $("input[name='uidai_number']");
//       // const msmeNumber = $("input[name='msme_number']");
//       // const hasGST = $("input[name='has_gst']:checked").val();
//       // const hasMSME = $("input[name='has_msme']:checked").val();

//       // --- Always required fields ---
//       // if (!beneficiaryName.val().trim()) {
//       //     beneficiaryName.addClass("is-invalid"); isValid = false;
//       //     if (!firstErrorField) firstErrorField = beneficiaryName;
//       //     if (showToastr) { toastr.error("Beneficiary name is required"); showToastr = false; }
//       // }

//       // if (!bankName.val().trim()) {
//       //     bankName.addClass("is-invalid"); isValid = false;
//       //     if (!firstErrorField) firstErrorField = bankName;
//       //     if (showToastr) { toastr.error("Bank name is required"); showToastr = false; }
//       // }

//       // if (!accountNumber.val() || !/^\d{9,18}$/.test(accountNumber.val())) {
//       //     accountNumber.addClass("is-invalid"); isValid = false;
//       //     if (!firstErrorField) firstErrorField = accountNumber;
//       //     if (showToastr) { toastr.error("Account number must be 9-18 digits"); showToastr = false; }
//       // }

//       // if (!ifscCode.val() || !/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/.test(ifscCode.val())) {
//       //     ifscCode.addClass("is-invalid"); isValid = false;
//       //     if (!firstErrorField) firstErrorField = ifscCode;
//       //     if (showToastr) { toastr.error("IFSC code must be 11 characters (format: ABCD0123456)"); showToastr = false; }
//       // }

//       // if (!panNumber.val() || !/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(panNumber.val())) {
//       //     panNumber.addClass("is-invalid"); isValid = false;
//       //     if (!firstErrorField) firstErrorField = panNumber;
//       //     if (showToastr) { toastr.error("PAN must be 10 characters (format: AAAAA9999A)"); showToastr = false; }
//       // }

//       // // --- GST Section ---
//       // if (hasGST === "yes") {

//       //     if (!gstNumber.val() || !/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9]{1}$/.test(gstNumber.val())) {
//       //         gstNumber.addClass("is-invalid"); isValid = false;
//       //         if (!firstErrorField) firstErrorField = gstNumber;
//       //         if (showToastr) { toastr.error("Invalid GST number (format: 22AAAAA0000A1Z5)"); showToastr = false; }
//       //     }


//       //      // --- File Uploads ---
//       //     const gstFileValidations = [
//       //         { name: "gst_file", required: false },
//       //     ];

//       //     gstFileValidations.forEach(({ name, required }) => {
//       //         const fileInput = $(`input[name="${name}"]`);
//       //         fileInput.removeClass("is-invalid");
//       //         const file = fileInput[0].files.length > 0 ? fileInput[0].files[0] : null;
//       //         const formattedName = name.replace(/_/g, " ");

//       //         if (required && !file) {
//       //             fileInput.addClass("is-invalid"); isValid = false;
//       //             if (!firstErrorField) firstErrorField = fileInput;
//       //             if (showToastr) { toastr.error(`Please upload the ${formattedName}`); showToastr = false; }
//       //         } else if (file) {
//       //             const validTypes = [
//       //                 "application/pdf",
//       //                 "application/msword",
//       //                 "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
//       //             ];
//       //             if (!validTypes.includes(file.type)) {
//       //                 fileInput.addClass("is-invalid"); isValid = false;
//       //                 if (!firstErrorField) firstErrorField = fileInput;
//       //                 if (showToastr) { toastr.error(`${formattedName} must be PDF or Word document`); showToastr = false; }
//       //             }
//       //             if (file.size > 2097152) {
//       //                 fileInput.addClass("is-invalid"); isValid = false;
//       //                 if (!firstErrorField) firstErrorField = fileInput;
//       //                 if (showToastr) { toastr.error(`${formattedName} must be less than 2MB`); showToastr = false; }
//       //             }
//       //         }
//       //     });

//       //     if (!gstStateCode.val() || !/^\d{2}$/.test(gstStateCode.val())) {
//       //         gstStateCode.addClass("is-invalid"); isValid = false;
//       //         if (!firstErrorField) firstErrorField = gstStateCode;
//       //         if (showToastr) { toastr.error("GST state code must be 2 digits"); showToastr = false; }
//       //     }
//       // }

//       // // --- UIDAI (always required, 12 digits) ---
//       // if (!uidaiNumber.val() || !/^\d{12}$/.test(uidaiNumber.val())) {
//       //     uidaiNumber.addClass("is-invalid"); isValid = false;
//       //     if (!firstErrorField) firstErrorField = uidaiNumber;
//       //     if (showToastr) { toastr.error("UIDAI number must be 12 digits"); showToastr = false; }
//       // }

//       // // --- MSME Section ---
//       // if (hasMSME === "yes") {
//       //       if (!msmeNumber.val() || msmeNumber.val().length < 8) {
//       //           msmeNumber.addClass("is-invalid");
//       //           isValid = false;

//       //           if (!firstErrorField) firstErrorField = msmeNumber;
//       //           if (showToastr) {
//       //               toastr.error("MSME number must be at least 8 characters");
//       //               showToastr = false;
//       //           }
//       //       }
//       // }

//         // --- File Uploads ---
//         const fileValidations = [
//             { name: "canceled_cheque" },
//             { name: "agreement" },
//             { name: "mou" },
//             { name: "pan_number" },
//             { name: "gst_certificate" },
//             { name: "udyam_certificate" },
//             { name: "NDA" }
//         ];

//         fileValidations.forEach(({ name }) => {

//             // GST skip logic
//             if (name === "gst_certificate" && hasGST !== "yes") return;

//             const fileInput = $(`input[name="${name}"]`);
//             if (fileInput.length === 0) return;

//             const file = fileInput[0].files.length > 0 ? fileInput[0].files[0] : null;

//             fileInput.removeClass("is-invalid");

//             // Only validate if file is uploaded
//             if (file) {
//                 const validTypes = [
//                     "application/pdf",
//                     "application/msword",
//                     "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
//                 ];

//                 const maxSize = 1 * 1024 * 1024; // 1MB

//                 if (!validTypes.includes(file.type)) {
//                     fileInput.addClass("is-invalid");
//                     isValid = false;

//                     if (showToastr) {
//                         toastr.error(`Invalid file type for ${name.replace(/_/g, " ")}`);
//                         showToastr = false;
//                     }
//                 }

//                 if (file.size > maxSize) {
//                     fileInput.addClass("is-invalid");
//                     isValid = false;

//                     if (showToastr) {
//                         toastr.error(`File size must be less than 1MB for ${name.replace(/_/g, " ")}`);
//                         showToastr = false;
//                     }
//                 }
//             }
//         });
//     }

//     window.scrollTo({ top: 0, behavior: 'smooth' });

//     return isValid;
// };

const validateStep = () => {
    let isValid = true;
    let firstErrorField = null;
    let showToastr = true;

    const totalSteps = $(".formStep").length;
    const currentStepIndex = currentStep;

    // Helper function for file validation
    function validateFiles(input, maxSize, allowedTypes, errorMsg, maxFiles, isRequired = false) {
        // Safety check
        if (!input || input.length === 0 || !input[0]) {
            return;
        }

        let files = input[0].files;

        // REQUIRED VALIDATION - REMOVED (set to false for all files)
        if (isRequired && files.length === 0) {
            input.addClass("is-invalid");
            isValid = false;

            if (!firstErrorField) firstErrorField = input;

            if (showToastr) {
                toastr.error("Please upload " + errorMsg);
                showToastr = false;
            }
            return;
        }

        // MAX FILE LIMIT - Only check if files exist
        if (files.length > 0 && files.length > maxFiles) {
            input.addClass("is-invalid");
            isValid = false;

            if (!firstErrorField) firstErrorField = input;

            if (showToastr) {
                toastr.error(errorMsg + " - You can upload maximum " + maxFiles + " file(s)");
                showToastr = false;
            }
            return;
        }

        // SIZE & TYPE CHECK - Only validate if files are uploaded
        if (files.length > 0) {
            Array.from(files).forEach(file => {
                if (file.size > maxSize) {
                    input.addClass("is-invalid");
                    isValid = false;

                    if (!firstErrorField) firstErrorField = input;

                    if (showToastr) {
                        toastr.error(errorMsg + " (file too large - max " + (maxSize / (1024 * 1024)) + "MB)");
                        showToastr = false;
                    }
                }

                if (!allowedTypes.includes(file.type)) {
                    input.addClass("is-invalid");
                    isValid = false;

                    if (!firstErrorField) firstErrorField = input;

                    if (showToastr) {
                        toastr.error(errorMsg + " (invalid file type - allowed: " + allowedTypes.join(", ") + ")");
                        showToastr = false;
                    }
                }
            });
        }
    }

    // ==================== STEP 0 VALIDATIONS ====================
    if (currentStepIndex === 0) {
        // File uploads validation - NOT REQUIRED, only validate if uploaded
        validateFiles($("input[name='center_logo']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "Center Logo", 1, false);
        validateFiles($("input[name='center_entrances[]']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "Center Entrance", 2, false);
        validateFiles($("input[name='lab_photos[]']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "Lab photo", 2, false);
        validateFiles($("input[name='main_gate_images[]']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "Main gate photo", 1, false);
        validateFiles($("input[name='server_room_images[]']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "Server room photo", 1, false);
        validateFiles($("input[name='observer_room_images[]']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "Observer room photo", 1, false);
        validateFiles($("input[name='ups_generator_images[]']"), 1048576, ['image/jpeg', 'image/png', 'image/jpg'], "UPS/Generator photo", 2, false);
        validateFiles($("input[name='walkthrough_video']"), 5242880, ['video/mp4', 'video/webm'], "Walkthrough video", 1, false);
    }

    // ==================== STEP 1 VALIDATIONS ====================
    if (currentStepIndex === 1) {
        // No validations for step 1 (no file uploads in this step)
        // All other field validations removed as requested
    }

    // ==================== STEP 2 VALIDATIONS ====================
    if (currentStepIndex === 2) {
        // No file uploads in step 2, so no validations needed
        // All other field validations removed as requested
    }

    // ==================== LAST STEP VALIDATIONS ====================
    if (currentStepIndex === totalSteps - 1) {
        // Clear any previous invalid classes
        $(".is-invalid").removeClass("is-invalid");
        
        // Get GST value for conditional validation
        const hasGST = $("input[name='has_gst']:checked").val();

        // File uploads validation - ONLY validate if files are uploaded (NOT REQUIRED)
        const fileValidations = [
            { name: "canceled_cheque", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] },
            { name: "agreement", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] },
            { name: "mou", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] },
            { name: "pan_number", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] },
            { name: "gst_certificate", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] },
            { name: "udyam_certificate", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] },
            { name: "NDA", maxSize: 1 * 1024 * 1024, allowedTypes: ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"] }
        ];

        fileValidations.forEach(({ name, maxSize, allowedTypes }) => {
            // Skip GST certificate if GST is not yes
            if (name === "gst_certificate" && hasGST !== "yes") return;
            
            const fileInput = $(`input[name="${name}"]`);
            if (fileInput.length === 0) return;
            
            const files = fileInput[0].files;
            
            // ONLY validate if files are uploaded
            if (files && files.length > 0) {
                const file = files[0]; // Assuming single file upload
                
                fileInput.removeClass("is-invalid");
                
                // Type validation
                if (!allowedTypes.includes(file.type)) {
                    fileInput.addClass("is-invalid");
                    isValid = false;
                    
                    if (showToastr) {
                        toastr.error(`Invalid file type for ${name.replace(/_/g, " ")}. Allowed: ${allowedTypes.join(", ")}`);
                        showToastr = false;
                    }
                }
                
                // Size validation
                if (file.size > maxSize) {
                    fileInput.addClass("is-invalid");
                    isValid = false;
                    
                    if (showToastr) {
                        toastr.error(`File size must be less than ${maxSize / (1024 * 1024)}MB for ${name.replace(/_/g, " ")}`);
                        showToastr = false;
                    }
                }
            }
        });
    }

    // Focus on first error field if any
    if (firstErrorField) {
        firstErrorField.focus();
    }

    // Scroll to top for better UX
    window.scrollTo({ top: 0, behavior: 'smooth' });

    return isValid;
};


// Function to update form steps and indicators
const updateSteps = () => {
    formItems.forEach((item, index) => item.classList.toggle("show", index === currentStep));
    formIndicators.forEach((indicator, index) => {
        indicator.classList.toggle("border-dark", index === currentStep);
        indicator.classList.toggle("stepFilled", index < currentStep);
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });

    if (currentStep === formItems.length) {
        submitForm();
    } else {
        formNextBtns.forEach(btn => btn.classList.remove("d-none"));
    }
};

// Event listeners for "Next" and "Previous" buttons
formNextBtns.forEach((btn) => {
    btn.addEventListener("click", (event) => {
        if (!validateStep()) {
            event.preventDefault();
            return;
        }

        // Move to the next step
        currentStep += 1;
        updateSteps();
        
    });
});

formPrevBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        if(currentStep != 0){
            currentStep -= 1;
            updateSteps();
        }
    });
});

// Initialize form step UI
updateSteps();

let isSubmitting = false;

const submitForm = () => {

    if (isSubmitting) return; // 🚀 prevent double click

    isSubmitting = true;

    let formData = new FormData($("#examCenterForm")[0]);
    let formUrl = $('#examCenterFormUrl').val();

    $("#loader").show();
    $('.formNextBtn').attr('disabled', true);

    $.ajax({
        url: formUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",

        success: function(response) {

            isSubmitting = false;

            $("#loader").hide();
            $('.formNextBtn').prop('disabled', false);

            if (response.status == "success") {

                openPopup();
                toastr.success("Your information is under verification. Please wait for 24 hours.");

            } else {

                toastr.error(response.message);

            }
        },

        error: function(xhr) {

            isSubmitting = false;

            $("#loader").hide();
            $('.formNextBtn').prop('disabled', false);

            toastr.error("Something went wrong. Please try again.");
        }
    });
};



// //////////////////// my-booking section start///////////////////

function changeTab(index) {
  let tabs = document.querySelectorAll('.booking-tab');
  let contents = document.querySelectorAll('.center');

  tabs.forEach((tab, i) => {
    tab.classList.toggle('active', i === index);
    contents[i].classList.toggle('active', i === index);
  });
}
// //////////////////// my-booking section end///////////////////


// ////////////////////////////// Aside script start ///////////////////

function openCenterBooking(index) {
  let asideLink = document.querySelectorAll('.link');
  let bookCenter = document.querySelectorAll('.booking-center');

  asideLink.forEach((tab, i) => {
    tab.classList.toggle('active', i === index);
    bookCenter[i].classList.toggle('active', i === index);
  });
}

// /////////////////////////// Aside script end ///////////////////////

// /////////////////////////// Center edit section script start ///////////////////////////
function editProfileFunction(){
  let editCenter = document.getElementById("edit-center");
  let centerProfile = document.getElementById("center-Profile");
  let editBtnCnt = document.getElementById("editBtnCnt");
  let editCenterBtn = document.getElementById("edit-center-btn-cnt")
  
  editCenter.style.display="block";
  centerProfile.style.display ="none";
  editBtnCnt.style.display = "block";
  editCenterBtn.style.display = "none";
}


function getSave() {

    let isValid = true;
    const errors = [];

    // Clear borders
    // document.querySelectorAll("#examCenterEditForm input, #examCenterEditForm select").forEach(el => {
    //     el.style.border = "";
    // });

    // ===== Dynamic Values =====
    // const hasGST = $("input[name='has_gst']:checked").val() || "no";
    // const hasMSME = $("input[name='has_msme']:checked").val() || "no";
    // const generator = $("select[name='is_generator_backup']").val() || "";
    // const singleNetwork = $("select[name='connected_single_network']").val() || "";

    // ===== Excluded Fields =====
    // let excludedFields = [
    //     "agreement","mou","NDA",
    //     "secondary_isp_connect_type",
    //     "secondary_isp_speed",
    //     "secondary_internet_speed_unit",
    //     "nearest_metro_station",
    //     "distance_from_metro_station",
    //     "capacity",

    //     // Ec
    //     'emergency_phone_number',
    //     'emergency_landline_number',

    //     // Bank & KYC Fields
    //     'beneficiary_name',
    //     'bank_name',
    //     'bank_account_number',
    //     'bank_ifsc',
    //     'pannumber',
    //     'gst_number',
    //     'gst_state_code',
    //     'uidai_number',
    //     'msme_number',

    //     // Optional flags (radio)
    //     'has_gst',
    //     'has_msme'
    // ];

    // if (hasGST === "no") {
    //     excludedFields.push("gst_no","gst_state_code","gst_certificate","gst_file");
    // }

    // if (hasMSME === "no") {
    //     excludedFields.push("msme_number");
    // }

    // if (generator === "no") {
    //     excludedFields.push("generator_backup_capacity","generator_fuel_tank_capacity");
    // }

    // ===== Required Fields (BASE) =====
    // const baseRequiredFields = [
    //     'center_name','address','center_description','pin_code',
    //     'country_id','state_id','city_id','local_area_name','address_lat','address_long','landmark',

    //     'for_ph_candidate',

    //     'nearest_railway_station','distance_from_station',
    //     'nearest_bus_stop','distance_from_bus_stop',
    //     'nearest_airport','distance_from_airport',

    //     'poc_name','poc_contact_no','poc_mobile_alternate','poc_email',
    //     'cs_name','cs_contact_number','cs_email',
    //     'am_name','am_contact_no','am_email',
    //     'emergency_contact_no','landline_number',

    //     'total_no_lab','total_no_system','connected_single_network',
    //     'partitaion_each_lab','ac_in_each_lab','network_printer',
    //     'is_there_projector_in_each_lab',
    //     'is_there_sound_sytem_in_each_lab',
    //     'how_many_fire_extinguisher_in_each_lab',
    //     'locker_facility','drinking_water_facility',

    //     'primary_isp_name','primary_isp_connect_type',
    //     'primary_isp_speed','primary_internet_speed_unit',

    //     'is_generator_backup','power_back_ups_kv','ups_backup_time',

    //     'beneficiary_name','bank_name','bank_account_number',
    //     'bank_ifsc_code','pan_no','uidai_number'
    // ];

    // Clone (important)
    // let finalRequiredFields = [...baseRequiredFields];

    // ===== Conditional Required =====
    // if (singleNetwork === "no") {
    //     finalRequiredFields.push("how_many_network");
    // }

    // if (generator === "yes") {
    //     finalRequiredFields.push("generator_backup_capacity","generator_fuel_tank_capacity");
    // }

    // if (hasGST === "yes") {
    //     finalRequiredFields.push("gst_no","gst_state_code");
    // }

    // if (hasMSME === "yes") {
    //     finalRequiredFields.push("msme_number");
    // }

    // ===== Helpers =====
    // function getLabel(input){
    //     return input.closest("p")?.querySelector("label")?.innerText 
    //         || input.closest(".form-group")?.querySelector("label")?.innerText
    //         || input.previousElementSibling?.innerText
    //         || input.name.replace(/_/g," ");
    // }

    // function setError(input,msg){
    //     input.style.border="1px solid red";
    //     input.classList.add("error-field"); // add this
    //     if (!errors.includes(msg)) errors.push(msg);
    //     isValid=false;
    // }

    // // ===== Required Validation =====
    // finalRequiredFields.forEach(name => {

    //     if (excludedFields.some(f => name.includes(f))) return;

    //     let inputs = document.querySelectorAll(`#examCenterEditForm [name='${name}']`);
    //     if (!inputs.length) return;

    //     let input = Array.from(inputs).find(el => el.offsetParent !== null) || inputs[0];

    //     if (input.type === "file") return;

    //     if (input.type === "radio") {
    //         if (!document.querySelector(`#examCenterEditForm [name='${name}']:checked`)) {
    //             setError(input, `${getLabel(input)} is required`);
    //         }
    //     } 
    //     else if (input.tagName === "SELECT") {
    //         if (!input.value) {
    //             setError(input, `${getLabel(input)} is required`);
    //         }
    //     } 
    //     else {
    //         if (!input.value.trim()) {
    //             setError(input, `${getLabel(input)} is required`);
    //         }
    //     }
    // });


    // ===== STOP IF REQUIRED FAIL =====
    // if (!isValid) {
    //     toastr.clear();
    //     toastr.error(errors[0]);

    //     let firstErrorField = document.querySelector("#examCenterEditForm .error-field");

    //     if (firstErrorField) {
    //         firstErrorField.scrollIntoView({
    //             behavior: "smooth",
    //             block: "center"
    //         });

    //         setTimeout(() => {
    //             firstErrorField.focus();
    //         }, 300);
    //     }

    //     return false;
    // }

    // ===== Pattern Validations =====

    // const patterns = {
    //     phone:/^\d{10}$/,
    //     email:/^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    //     pin:/^\d{6}$/,
    //     ifsc:/^[A-Z]{4}0[A-Z0-9]{6}$/,
    //     pan:/^[A-Z]{5}\d{4}[A-Z]$/,
    //     gst:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/,
    //     uidai:/^\d{12}$/
    // };

    // Phones
    // ["poc_contact_no","poc_mobile_alternate","cs_contact_number","am_contact_no","emergency_contact_no"]
    // .forEach(n=>{
    //     let i=document.querySelector(`[name='${n}']`);
    //     if(i && i.value && !/^\d{10}$/.test(i.value)){
    //         setError(i,"Must be 10 digits");
    //     }
    // });

    // Landline
    // let landline = document.querySelector("[name='landline_number']");
    // if(landline && landline.value && !/^\d{6,12}$/.test(landline.value)){
    //     setError(landline,"Landline must be 6 to 12 digits");
    // }

    // Email
    // ["poc_email","cs_email","am_email"].forEach(n=>{
    //     let i=document.querySelector(`[name='${n}']`);
    //     if(i && i.value && !patterns.email.test(i.value)) setError(i,"Invalid email");
    // });
    
    // Has Gst
    // if (!$("input[name='has_gst']:checked").length) {
    //     let el = document.querySelector("[name='has_gst']");
    //     setError(el.closest("div") || el, "Select GST option");
    // }

    // if (!$("input[name='has_msme']:checked").length) {
    //     let el = document.querySelector("[name='has_msme']");
    //     setError(el.closest("div") || el, "Select MSME option");
    // }


    // ===== LAB VALIDATION =====

    // Total Labs
    // let totalLabs = document.querySelector("[name='total_no_lab']");
    // if (totalLabs && (!totalLabs.value || parseInt(totalLabs.value) < 1)) {
    //     setError(totalLabs, "Total labs must be at least 1");
    // }

    // Total Systems
    // let totalSystems = document.querySelector("[name='total_no_system']");
    // if (totalSystems && (!totalSystems.value || !/^\d+$/.test(totalSystems.value))) {
    //     setError(totalSystems, "Total systems must be a number");
    // }

    // Network
    // if (singleNetwork === "no") {
    //     let networks = document.querySelector("[name='how_many_network']");
    //     if (networks && (!networks.value || parseInt(networks.value) <= 0)) {
    //         setError(networks, "Total networks required");
    //     }
    // }

    // Infra selects
    // [
    //     "partitaion_each_lab",
    //     "ac_in_each_lab",
    //     "network_printer",
    //     "is_there_projector_in_each_lab",
    //     "is_there_sound_sytem_in_each_lab",
    //     "how_many_fire_extinguisher_in_each_lab",
    //     "locker_facility",
    //     "drinking_water_facility"
    // ].forEach(name => {
    //     let input = document.querySelector(`[name='${name}']`);
    //     if (input && !input.value) {
    //         setError(input, `${getLabel(input)} is required`);
    //     }
    // });

    // ISP
    // let isp = document.querySelector("[name='primary_isp_name']");
    // if (isp && !isp.value.trim()) setError(isp, "Primary ISP required");

    // let ispSpeed = document.querySelector("[name='primary_isp_speed']");
    // if (ispSpeed && (!ispSpeed.value || parseInt(ispSpeed.value) <= 0)) {
    //     setError(ispSpeed, "ISP speed required");
    // }

    // Generator
    // if (generator === "yes") {
    //     let cap = document.querySelector("[name='generator_backup_capacity']");
    //     let fuel = document.querySelector("[name='generator_fuel_tank_capacity']");

    //     if (cap && !cap.value.trim()) setError(cap, "Generator capacity required");
    //     if (fuel && !fuel.value) setError(fuel, "Generator fuel capacity required");
    // }

    // UPS
    // let ups = document.querySelector("[name='power_back_ups_kv']");
    // let upsTime = document.querySelector("[name='ups_backup_time']");

    // if (ups && !ups.value.trim()) setError(ups, "UPS backup required");
    // if (upsTime && !upsTime.value) setError(upsTime, "UPS time required");

    // ===== LAB ARRAY (DYNAMIC) =====
    // document.querySelectorAll(".newLabWrapperChange").forEach((lab, index) => {

    //     let labNo = index - 1 + 1;

    //     // correct field name
    //     let computers = lab.querySelector("[name='no_of_computer[]']");

    //     let selects = [
    //         "window_generation[]",
    //         "monitor_type[]",
    //         "operating_system[]",
    //         "ram[]",
    //         "hard_disk[]",
    //         "ethernet_company[]",
    //         "switch_category[]",
    //         "no_of_port_eth_switch[]"
    //     ];

    //     // computer validation (separate)
    //     if (computers && (!computers.value || !/^\d+$/.test(computers.value))) {
    //         setError(computers, `Lab ${labNo}: Computers required`);
    //     }

    //     // select validation
    //     selects.forEach(name => {
    //         let field = lab.querySelector(`[name='${name}']`);
    //         if (field && !field.value) {

    //             let label = name
    //                 .replace('[]','')
    //                 .replace(/_/g, ' ')
    //                 .replace(/\b\w/g, l => l.toUpperCase());

    //             setError(field, `Lab ${labNo}: ${label} required`);
    //         }
    //     });

    // });

    // Others
    // let pin = document.querySelector("[name='pin_code']");
    // if(pin && pin.value && !patterns.pin.test(pin.value)) setError(pin,"Invalid PIN");

    // let ifsc = document.querySelector("[name='bank_ifsc_code']");
    // if(ifsc && ifsc.value && !patterns.ifsc.test(ifsc.value)) setError(ifsc,"Invalid IFSC");

    // let pan = document.querySelector("[name='pan_no']");
    // if(pan && pan.value && !patterns.pan.test(pan.value)) setError(pan,"Invalid PAN");

    // let gst = document.querySelector("[name='gst_no']");
    // if(hasGST==="yes" && gst && gst.value && !patterns.gst.test(gst.value)) setError(gst,"Invalid GST");

    // let uidai = document.querySelector("[name='uidai_number']");
    // if(uidai && uidai.value && !patterns.uidai.test(uidai.value)) setError(uidai,"Invalid UIDAI");

    // ===== ERROR SHOW =====
    // if(errors.length){
    //     toastr.clear();
    //     toastr.error(errors[0]); // clean UX
    //     let firstErrorField = document.querySelector("#examCenterEditForm .error-field");

    //     if (firstErrorField) {
    //         firstErrorField.scrollIntoView({
    //             behavior: "smooth",
    //             block: "center"
    //         });

    //         setTimeout(() => {
    //             firstErrorField.focus();
    //         }, 300);
    //     }
    //     return false;
    // }

    // ===== AJAX =====
    let formData = new FormData($("#examCenterEditForm")[0]);
    let url = $('#examCenterEditFormUrl').val();

    $.ajax({
        url:url,
        type:"POST",
        data:formData,
        processData:false,
        contentType:false,
        success:function(){
            toastr.success("Profile updated successfully!");
            setTimeout(()=>location.reload(),1500);
        },
        error:function(){
            toastr.error("Something went wrong");
        }
    });

    return true;
}


// /////////////////////////// Center edit section script end ///////////////////////////


// Checking the doc file type
document.querySelectorAll('input[type="file"]').forEach(input => {
  const allowedNames = [
    'canceled_cheque',
    'agreement',
    'mou',
    'gst_certificate', // Note: Typo? Should it be 'gst_certificate'?
    'udyam_certificate',
    'pan_number'
  ];

  // Only add event listener if the input's name matches allowedNames
  if (allowedNames.includes(input.name)) {
    input.addEventListener('change', function () {
      const file = this.files[0];
      const allowedTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
      ];

      if (file && (!allowedTypes.includes(file.type) || file.size > 2 * 1024 * 1024)) {
        alert('Invalid file type or size. Max 2MB. Allowed: doc, docx, pdf');
        this.value = ''; // Clear the selection
      }
    });
  }
});


function handleImageDelete(id) {

    Swal.fire({
        title: 'Delete Image?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            Swal.fire({
                title: 'Deleting...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: base_url + 'remove-images',
                type: 'POST',
                data: { id: id },

                success: function(response) {

                    Swal.close();

                    toastr.success('Image removed successfully.');

                    $(`[onclick="handleImageDelete('${id}')"]`)
                        .closest('.image-container')
                        .remove();
                },

                error: function() {

                    Swal.close();

                    toastr.error('Something went wrong. Please try again.');
                }
            });
        }
    });
}