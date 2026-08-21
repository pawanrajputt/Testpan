// Get DOM elements
const tabs = document.querySelectorAll(".aside-tag-cnt");
const tabContents = document.querySelectorAll(".tab-content");
const formNextBtns = document.querySelectorAll(".nextFormBtn");
const indicatorItems = document.querySelectorAll(".indicatorItem");
const companyNextBtns = document.querySelectorAll(".comapnyNextBtn");
const companyBackBtns = document.querySelectorAll(".comapnyBackBtn");
const companyContetnts = document.querySelectorAll(".company-contetnt");
const mainGoBackBtn = document.getElementById("mainGoBackBtn");
const indicatorCnt = document.getElementById("indicatorCnt");


const submitForm = () => {
    const container = document.getElementById("ACForm");
    const inputs = container.querySelectorAll("input, select, textarea");

    let formData = new FormData();

    inputs.forEach(input => {
        if (input.type === "file") {
            if (input.files.length > 0) {
                formData.append(input.name, input.files[0]);
            }
        } else {
            formData.append(input.name, input.value);
        }
    });

    let formUrl = document.getElementById('ACFormUrl').value;

    // Show Loader
    $('#loader').show(); // Replace with your loader selector

    $.ajax({
        url: formUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {
            $('#loader').show();
        },

        success: function (response) {

            if (typeof response === "string") {
                response = JSON.parse(response);
            }

            if (response.status) {

                toastr.success(response.message);

                $('.company-contetnt').removeClass('show');
                $('.last-step-from').removeClass('hide').addClass('show');

            } else {

                toastr.error(response.message);
            }
        },

        error: function (xhr) {

            let message = "Something went wrong.";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }

            toastr.error(message);
        },

        complete: function () {
            // Success ya Error dono me chalega
            $('#loader').hide();
        }
    });
};

// Check if elements exist before proceeding
if (mainGoBackBtn) {
    formNextBtns.forEach((element, index) => {
        if (index === 0) {
            mainGoBackBtn.style.display = "none";
        }
        element.addEventListener("click", () => {
            if (index === 3) {
                const inputs = companyContetnts[companyIndex].querySelectorAll("input");
                let allValid = true;

                const requiredFiles = [
                    "canceled_cheque",
                    "agreement",
                    "mou",
                    "nda",
                    "gst_certificate",
                    "udyam_certificate",
                    "pan_number_document",
                ];

                // for (let input of inputs) {
                //     const value = input.value.trim();
                //     input.style.border = "";
                //     const name = input.name;

                //     if (input.type !== "file") {
                //         // Required fields check
                //         if (
                //             [
                //                 "bank_name",
                //                 "bank_account_number",
                //                 "bank_ifsc_code",
                //                 "beneficiary_name",
                //                 "pannumber",
                //                 "agreement_start_date",
                //                 "agreement_end_date",
                //                 "udyam_adhar_number"
                //             ].includes(name)
                //         ) {
                //             if (!value) {
                //                 input.style.border = "1px solid red";
                //                 toastr.error(`${name.replace(/_/g, " ")} is required (e.g., ${
                //                     name === "bank_ifsc_code" ? "HDFC0001234" :
                //                     name === "pannumber" ? "ABCDE1234F" :
                //                     name === "bank_account_number" ? "123456789012" :
                //                     name === "bank_name" ? "HDFC Bank" :
                //                     name === "beneficiary_name" ? "John Doe" : "example"
                //                 })`);
                //                 return;
                //             }

                //             // Specific field format validations
                //             if (name === "bank_account_number" && !/^\d{9,18}$/.test(value)) {
                //                 input.style.border = "1px solid red";
                //                 toastr.error("Account number must be 9–18 digits (e.g., 123456789012)");
                //                 return;
                //             }

                //             if (name === "bank_ifsc_code" && !/^[A-Z]{4}0[A-Z0-9]{6}$/.test(value)) {
                //                 input.style.border = "1px solid red";
                //                 toastr.error("Invalid IFSC code format (e.g., HDFC0001234)");
                //                 return;
                //             }

                //             if (name === "pannumber" && !/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value)) {
                //                 input.style.border = "1px solid red";
                //                 toastr.error("Invalid PAN number format (e.g., ABCDE1234F)");
                //                 return;
                //             }
                //         }

                //         // GST number: optional but validate format
                //         if (name === "gst_number" && value) {
                //             const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                //             if (!gstRegex.test(value)) {
                //                 input.style.border = "1px solid red";
                //                 toastr.error("Invalid GST number format (e.g., 27ABCDE1234F1Z5)");
                //                 return;
                //             }
                //         }

                //         // Udyam Aadhaar: optional but validate format
                //         if (name === "udyam_adhar_number" && value) {

                //             const upperValue = value.toUpperCase();
                //             input.value = upperValue;

                //             if (!/^UDYAM-[A-Z]{2}-\d{2}-\d{7}$/.test(upperValue)) {
                //                 input.style.border = "1px solid red";
                //                 toastr.error(
                //                     "Invalid Udyam Number. Format must be UDYAM-MH-12-0000001"
                //                 );
                //                 return;
                //             }
                //         }
                //     }
                // }
                
                // star date and end date validations
                const startDateInput = [...inputs].find(inp => inp.name === "agreement_start_date");
                const endDateInput = [...inputs].find(inp => inp.name === "agreement_end_date");

                // if (startDateInput && endDateInput) {
                //     const startDate = new Date(startDateInput.value);
                //     const endDate = new Date(endDateInput.value);

                //     if (startDateInput.value && endDateInput.value) {
                //         if (startDate > endDate) {
                //             startDateInput.style.border = "1px solid red";
                //             endDateInput.style.border = "1px solid red";

                //             toastr.error("Agreement start date must be before end date");
                //             return;
                //         }
                //     }
                // }

                // ✅ FILE VALIDATION (one error at a time)
                // for (let requiredName of requiredFiles) {
                //     const fileInput = [...inputs].find(inp => inp.type === "file" && inp.name === requiredName);

                //     if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                //         if (fileInput) fileInput.style.border = "1px solid red";
                //         toastr.error(`Please upload ${requiredName.replace(/_/g, " ")} (PDF/DOC/DOCX, max 2MB)`);
                //         return;
                //     }

                //     const file = fileInput.files[0];
                //     const validTypes = [
                //         'application/pdf',
                //         'application/msword',
                //         'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                //     ];
                //     const isValidType = validTypes.includes(file.type);
                //     const isValidSize = file.size <= 1 * 1024 * 1024;

                //     if (!isValidType || !isValidSize) {
                //         fileInput.style.border = "1px solid red";
                //         toastr.error(`${requiredName.replace(/_/g, " ")} must be PDF/DOC/DOCX and ≤1MB`);
                //         return;
                //     }
                // }

                // ✅ All validations passed
                submitForm();
            }

        });
    });

    let companyIndex = 0;

    // Next button for company contents
    companyNextBtns.forEach((element) => {
        element.addEventListener("click", () => {
            const currentContent = companyContetnts[companyIndex];
            const inputs = currentContent.querySelectorAll("input, select");
            let allValid = true;

            // inputs.forEach((input) => {
            //     const value = input.value.trim();
            //     const name = input.name;
            //     const type = input.type;
                
            //     // Reset previous error style
            //     input.style.border = "";
            //     const errorElement = document.getElementById(`${name}_error`);
            //     if (errorElement) errorElement.remove();

            //     if (input.required || name === 'logo') {
            //         if (type === 'file') {
            //             if (input.files.length === 0) {
            //                 showFieldError(input, `${getFieldLabel(name)} is required`);
            //                 allValid = false;
            //                 return;
            //             }
            //         } else if (!value) {
            //             showFieldError(input, `${getFieldLabel(name)} is required`);
            //             allValid = false;
            //             return;
            //         }
            //     }

            //     if (input.required && !value) {
            //         showFieldError(input, `${getFieldLabel(name)} is required`);
            //         allValid = false;
            //         return;
            //     }

            //     // Field-specific validations
            //     switch(name) {
            //         case 'company_name':
            //             if (value.length < 2 || value.length > 100) {
            //                 showFieldError(input, 'Company name must be 2-100 characters');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'company_website':
            //             if (value && !/^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}(\/[^\s]*)?$/.test(value)) {
            //                 showFieldError(input, 'Please enter a valid website URL');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'country_id':
            //         case 'state_id':
            //         case 'city_id':
            //             if (!value) {
            //                 showFieldError(input, `Please select a ${getFieldLabel(name)}`);
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'pincode':
            //             if (!/^\d{6}$/.test(value)) {
            //                 showFieldError(input, 'Pincode must be 6 digits');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'logo':
            //             if (input.files.length > 0) {
            //                 const file = input.files[0];
            //                 const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            //                 const maxSize = 1 * 1024 * 1024; // 1MB
                            
            //                 if (!validTypes.includes(file.type)) {
            //                     showFieldError(input, 'Only JPG, JPEG, PNG files are allowed');
            //                     allValid = false;
            //                 } else if (file.size > maxSize) {
            //                     showFieldError(input, 'File size must be less than 1MB');
            //                     allValid = false;
            //                 }
            //             } else {
            //                 // This case is already handled above, but can be here for clarity
            //                 showFieldError(input, 'Company logo is required');
            //                 allValid = false;
            //             }
            //         break;

            //         case 'coordinator_name':
            //             if (!value) {
            //                 showFieldError(input, 'Coordinator name is required');
            //                 allValid = false;
            //             } else if (value.length < 2 || value.length > 100) {
            //                 showFieldError(input, 'Name must be 2-100 characters');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'coordinator_email':
            //             if (!value) {
            //                 showFieldError(input, 'Email is required');
            //                 allValid = false;
            //             } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            //                 showFieldError(input, 'Please enter a valid email');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'coordinator_mobile_number':
            //             if (!value) {
            //                 showFieldError(input, 'Mobile number is required');
            //                 allValid = false;
            //             } else if (!/^\d{10}$/.test(value)) {
            //                 showFieldError(input, 'Mobile must be 10 digits');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'coordinator_alternative_number':
            //             if (value && !/^\d{10}$/.test(value)) {
            //                 showFieldError(input, 'Alternate mobile must be 10 digits');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'coordinator_landline_code':
            //             if (value && !/^\d{1,4}$/.test(value)) {
            //                 showFieldError(input, 'Country code must be 1-4 digits');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'coordinator_landline_type':
            //             if (value && !/^\d{1,4}$/.test(value)) {
            //                 showFieldError(input, 'State code must be 1-4 digits');
            //                 allValid = false;
            //             }
            //             break;
                        
            //         case 'coordinator_landline_number':
            //             if (value && !/^\d{6,10}$/.test(value)) {
            //                 showFieldError(input, 'Landline number must be 6-10 digits');
            //                 allValid = false;
            //             }
            //         break;
            //     }
            // });

            if (!allValid) return;

            // Proceed to next content section
            if (companyContetnts[companyIndex]) {
                companyContetnts[companyIndex].classList.remove("show");
            }
            if (companyContetnts[companyIndex + 1]) {
                companyContetnts[companyIndex + 1].classList.add("show");
                companyIndex++;
            }
        });
    });

    // Helper functions
    function getFieldLabel(name) {
        const labels = {
            'company_name': 'Company name',
            'company_type': 'Company type',
            'company_website': 'Company website',
            'country_id': 'Country',
            'state_id': 'State',
            'city_id': 'City',
            'pincode': 'Pincode',
            'address': 'Company address',
            'logo': 'Company logo',
            'coordinator_name': 'Coordinator name',
            'coordinator_email': 'Email',
            'coordinator_mobile_number': 'Mobile number',
            'coordinator_alternative_number': 'Alternate mobile number',
            'coordinator_landline_code': 'Country code',
            'coordinator_landline_type': 'State code',
            'coordinator_landline_number': 'Landline number',
        };
        return labels[name] || name;
    }

    function showFieldError(input, message) {
        input.style.border = "1px solid red";
        const errorElement = document.createElement('div');
        errorElement.id = `${input.name}_error`;
        errorElement.className = 'text-danger small mt-1';
        errorElement.textContent = message;
        input.parentNode.appendChild(errorElement);
    }


    // Back button for company contents
    companyBackBtns.forEach((element) => {
        element.addEventListener("click", () => {
            if (companyContetnts[companyIndex]) {
                companyContetnts[companyIndex].classList.remove("show");
            }
            if (companyContetnts[companyIndex - 1]) {
                companyContetnts[companyIndex - 1].classList.add("show");
                companyIndex--;
            }
        });
    });

    // Main Go Back Button: Reload the page
    mainGoBackBtn.addEventListener("click", () => {
        location.reload(); // Reload the page
    });
}



const tablecalenderTabs = document.querySelectorAll(".tablecalenderTab");
const tablecalenderContents = document.querySelectorAll(".tablecalenderContent");
const createProjectBtns = document.querySelectorAll(".createProjectBtn");
const createProject = document.getElementById("createProject");
const createProjectSection = document.getElementById("createProjectSection");
const allProjectTabBtns = document.querySelectorAll(".allProjectTabBtn");
const projectTableContents = document.querySelectorAll(".projectTableContent");
const createProjectForms = document.querySelectorAll(".createProjectForm");
const createProjectNextBtns = document.querySelectorAll(".createProjectNextBtn");
const createProjectPrevBtns = document.querySelectorAll(".createProjectPrevBtn");
const examCenterBtns = document.querySelectorAll(".examCenterBtn");
const approveItemBtns = document.querySelectorAll(".approveItemBtn");
const eligibleCnt = document.querySelector(".eligibleCnt");
const approveCnt = document.querySelector(".approveCnt");
let backButton = document.getElementById("backButton");
let backButtonApprove = document.getElementById("backButtonApprove");



// Tab switching logic for table calendar
tablecalenderTabs.forEach((element, index) => {
    element.addEventListener("click", () => {
        tablecalenderTabs.forEach(tab => tab.classList.remove("active"));
        tablecalenderContents.forEach(content => content.classList.remove("show"));
        approveCnt.classList.remove("show")
        eligibleCnt.classList.remove("show")
        if (createProject) createProject.classList.remove("active");
        if (createProjectSection) createProjectSection.classList.remove("show");

        tablecalenderTabs[index].classList.add("active");
        tablecalenderContents[index].classList.add("show");
        // document.querySelectorAll(".eligibleCnt-all-project").forEach(element => {
        //     element.style.display = "none";
        // });
    });
});

// Create Project button logic
createProjectBtns.forEach((element) => {
    element.addEventListener("click", () => {
        tablecalenderTabs.forEach(tab => tab.classList.remove("active"));
        tablecalenderContents.forEach(content => content.classList.remove("show"));
        approveCnt.classList.remove("show")
        eligibleCnt.classList.remove("show")
        if (createProject) createProject.classList.add("active");
        if (createProjectSection) createProjectSection.classList.add("show");
    });
});

// Tab switching logic for project table tabs
allProjectTabBtns.forEach((element, index) => {
    element.addEventListener("click", () => {
        allProjectTabBtns.forEach(tab => tab.classList.remove("all-project-tab"));
        projectTableContents.forEach(content => content.classList.remove("show"));

        allProjectTabBtns[index].classList.add("all-project-tab");
        projectTableContents[index].classList.add("show");
    });
});

let projectIndex = 0;

// Logic for next buttons in Create Project forms
createProjectNextBtns.forEach((element, index) => {
    element.addEventListener("click", (e) => {
        e.preventDefault(); // Prevent default button behavior
        
        // Get all required fields in current form
        const currentForm = createProjectForms[index];
        const requiredFields = currentForm.querySelectorAll('[required]');
        let isValid = true;

        // First reset all validation classes
        currentForm.querySelectorAll('input, select').forEach(field => {
            field.classList.remove('is-invalid', 'is-valid');
            
            // For radio buttons, reset their containers
            if (field.type === 'radio') {
                const radioContainer = field.closest('.d-flex.border'); // Adjust this selector to match your radio container
                if (radioContainer) {
                    radioContainer.classList.remove('is-invalid', 'is-valid');
                }
            }
        });

        // Validate each required field
        requiredFields.forEach(field => {
            if (field.type === 'radio') {
                // For radio buttons, check if any in the group is checked
                const radioGroup = currentForm.querySelectorAll(`input[name="${field.name}"]`);
                const radioContainer = radioGroup[0].closest('.d-flex.border'); // Get container from first radio
                const isRadioChecked = Array.from(radioGroup).some(radio => radio.checked);
                
                if (!isRadioChecked) {
                    isValid = false;
                    radioGroup.forEach(radio => {
                        radio.classList.add('is-invalid');
                    });
                    if (radioContainer) {
                        radioContainer.classList.add('is-invalid');
                    }
                } else {
                    radioGroup.forEach(radio => {
                        radio.classList.add('is-valid');
                    });
                    if (radioContainer) {
                        radioContainer.classList.add('is-valid');
                    }
                }
            } else if (field.tagName === 'SELECT' && !field.value) {
                // For select fields
                isValid = false;
                field.classList.add('is-invalid');
            } else if (!field.value.trim()) {
                // For text input fields
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.add('is-valid');
            }
        });


        // ================= CITY MULTI SELECT VALIDATION =================
        const citySelect = currentForm.querySelector('#citySelect');

        if (citySelect) {

            citySelect.classList.remove('is-invalid', 'is-valid');

            if (!citySelect.value || citySelect.selectedOptions.length === 0) {
                isValid = false;
                citySelect.classList.add('is-invalid');
                toastr.error('Please select at least one exam city');
            } else {
                citySelect.classList.add('is-valid');
            }
        }

        // ================= BATCH TIME VALIDATION =================
        const batchSelect = currentForm.querySelector('#changeBatch');

        // ================= BATCH DROPDOWN VALIDATION =================
        if (batchSelect) {

            batchSelect.classList.remove('is-invalid', 'is-valid');

            if (!batchSelect.value) {
                isValid = false;
                batchSelect.classList.add('is-invalid');
                toastr.error('Please select exam batch');
            } else if (!isValid) {
                // batch selected but batch timing invalid
                batchSelect.classList.add('is-invalid');
            } else {
                batchSelect.classList.add('is-valid');
            }
        }

        // =============BATCH TIMING =============
        if (batchSelect && batchSelect.value) {

            const totalBatches = parseInt(batchSelect.value);

            for (let i = 1; i <= totalBatches; i++) {

                const startInput = currentForm.querySelector(`input[name="batch${i}_start"]`);
                const endInput   = currentForm.querySelector(`input[name="batch${i}_end"]`);

                if (!startInput || !endInput) continue;

                // reset first
                startInput.classList.remove('is-invalid');
                endInput.classList.remove('is-invalid');

                if (!startInput.value || !endInput.value) {
                    isValid = false;

                    if (!startInput.value) {
                        startInput.classList.add('is-invalid');
                    }

                    if (!endInput.value) {
                        endInput.classList.add('is-invalid');
                    }

                    toastr.error(`Please select start & end time for Batch ${i}`);
                }
            }
        }


        // ================= RADIO VALIDATIONS =================
        if (!validateRadioGroup(currentForm, 'parking', 'Please select parking facility')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'security_guard', 'Please select security guard option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'lockers', 'Please select lockers option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'waiting_area', 'Please select waiting area option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'power_backup', 'Please select power backup option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'ph_handicapped', 'Please select PH handicapped option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'printer', 'Please select printer option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'rough_sheet', 'Please select rough sheet option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'partition', 'Please select partition option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'ac_in_lab', 'Please select AC in lab option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'cctv_required', 'Please select CCTV required option')) {
            isValid = false;
            return;
        }

        if (!validateRadioGroup(currentForm, 'cctv_recording', 'Please select CCTV recording option')) {
            isValid = false;
            return;
        }




        // Only proceed if validation passes
        if (isValid && index < createProjectForms.length - 1) {
            createProjectForms[index].classList.remove("show");
            createProjectForms[index + 1].classList.add("show");
            projectIndex++;
        } else if (!isValid) {
            // Optionally focus the first invalid field
            const firstInvalidField = currentForm.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }
    });
});

function validateRadioGroup(form, name, message) {

    const radios = form.querySelectorAll(`input[name="${name}"]`);
    if (!radios.length) return true;

    const container = radios[0].closest('.d-flex');
    const isChecked = Array.from(radios).some(r => r.checked);

    // reset
    radios.forEach(r => r.classList.remove('is-invalid', 'is-valid'));
    if (container) container.classList.remove('is-invalid', 'is-valid');

    if (!isChecked) {
        radios.forEach(r => r.classList.add('is-invalid'));
        if (container) container.classList.add('is-invalid');
        toastr.error(message);
        return false;
    } else {
        radios.forEach(r => r.classList.add('is-valid'));
        if (container) container.classList.add('is-valid');
        return true;
    }
}


// Logic for next buttons in Create Project forms
createProjectPrevBtns.forEach((element, index) => {
    element.addEventListener("click", () => {
        // Ensure the form exists before modifying
        if (projectIndex < createProjectForms.length + 1) {
            createProjectForms[projectIndex].classList.remove("show");
            createProjectForms[projectIndex - 1].classList.add("show");
            projectIndex--;
        }
    });
});

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("approveItemBtn")) {
        tablecalenderContents.forEach(content => content.classList.remove("show"));
        eligibleCnt.classList.remove("show");
        approveCnt.classList.add("show");
    }
});


// Modal
const buttonsModal = document.querySelectorAll("#popupButton");
const closePopup = document.querySelector(".closePopup");
const modal = document.querySelector(".main-share-cnt");

buttonsModal.forEach(function (button) {
    button.addEventListener("click", function () {
        // Get all data attributes
        const examStatus = this.getAttribute('data-exam-status');
        const examName = this.getAttribute('data-exam-name');
        const startDate = new Date(this.getAttribute('data-start-date'));
        const endDate = new Date(this.getAttribute('data-end-date'));
        const daysLeft = this.getAttribute('data-days-left');
        const centersBooked = this.getAttribute('data-centers-booked');
        const candidatesAssessed = this.getAttribute('data-candidates-assessed');
        const citiesCovered = this.getAttribute('data-cities-covered');
        const cityNames = this.getAttribute('data-city-names');
        const description = this.getAttribute('data-description');

        // Format dates
        const formattedStartDate = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        const formattedEndDate = endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });

        // Create HTML for assigned centers
        const assignedCenters = JSON.parse(this.getAttribute('data-assign-centers'));

        let attachmentsHTML = assignedCenters.map(center => `
            <div class='d-flex px-4 justify-content-between align-items-center mb-3'>
                <div class='d-flex'>
                    <div><img src="${base_url}assets/icon-folder/project-icons/center-profile.png" alt="" class='me-3' /></div>
                    <div>
                        <h2 class='m-0'>${center.name}</h2>
                        <p class='m-0'>${center.date}</p>
                    </div>
                </div>
                <div class='d-flex align-items-center'>
                    <a href="${base_url}dashboard" class="d-flex align-items-center">
                        <img src="${base_url}assets/icon-folder/project-icons/views-icon.png" alt="" class='me-2' />
                        <span>View</span>
                    </a>
                </div>
            </div>
        `).join('');


        // Generate modal HTML
        const modalHTML = `
            <div class='main-share-wrapper'>
                <div class="share-header">
                    <div class=''> 
                         <img src="${base_url}assets/icon-folder/project-icons/Share - icon.png" alt="share" class='me-2' />
                        Share
                    </div>
                    <div class='closePopup'>
                        <img src="${base_url}assets/icon-folder/project-icons/cut-icon.png" alt="cut" />
                    </div>
                </div>
                <div class='info-cnt'>
                    <div class='py-4 ps-4'>
                        <button class='booked-btn m-0 me-3'>Booked</button>
                        <button class='panding-calender-btn'>${examStatus}</button>
                        <h2 class='my-3 fs-3'>${examName}</h2>
                        <div class='d-flex'>
                            <h2 class='m-0 me-3 fs-6'>${formattedStartDate} - ${formattedEndDate}</h2>
                            <h2 class='m-0 fs-6'>${daysLeft}</h2>
                        </div>
                    </div>
                </div>
                <hr class='mt-0' />
                <div class='numerical-info-cnt'>
                    <div class='d-flex ps-4 pe-5 justify-content-between'>
                        <div class='d-flex align-items-center'>
                            <div><img src="${base_url}assets/icon-folder/project-icons/calender.png" alt="" class='me-2' /></div>
                            <div>
                                <h2 class='m-0'>${centersBooked}</h2>
                                <p class='m-0'>Centers booked</p>
                            </div>
                        </div>
                        <div class='d-flex align-items-center'>
                            <div><img src="${base_url}assets/icon-folder/project-icons/calender-user.png" alt="" class='me-2' /></div>
                            <div>
                                <h2 class='m-0'>${candidatesAssessed}</h2>
                                <p class='m-0'>Candidates assessed</p>
                            </div>
                        </div>
                    </div>
                    <div class='ps-4 pt-3'>
                        <div class='d-flex align-items-center'>
                            <div><img src="${base_url}assets/icon-folder/project-icons/calender-user.png" alt="" class='me-2' /></div>
                            <div>
                                <h2 class='m-0'>${citiesCovered}</h2>
                                <p class='m-0'>Cities covered</p>
                                <small class="text-muted">${cityNames}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class='Description-cnt'>
                    <div class='ps-4 mt-3'>
                        <p><strong>Description</strong></p>
                    </div>
                    <div class='px-4'>
                        <p class='text-dark'>${description}</p>
                    </div>
                </div>
                <div class='mt-4'>
                    <div class='ps-4'>
                        <p>Attachments</p>
                    </div>
                    ${attachmentsHTML}
                </div>
            </div>
        `;

        // Set modal content
        modal.innerHTML = modalHTML;

        // Show modal
        modal.classList.add("show");
        document.body.classList.add("modal-open");

        // Re-attach close event to the new close button
        modal.querySelector('.closePopup').addEventListener('click', () => {
            modal.classList.remove("show");
            document.body.classList.remove("modal-open");
        });
    });
});


// backButton.addEventListener("click", function () {
//     tablecalenderContents.forEach(content => content.classList.remove("show"));
//     approveCnt.classList.remove("show")
//     eligibleCnt.classList.remove("show")
//     tablecalenderTabs[0].classList.add("active");
//     tablecalenderContents[0].classList.add("show");
// });

// backButtonApprove.addEventListener("click", function () {
//     tablecalenderContents.forEach(content => content.classList.remove("show"));
//     approveCnt.classList.remove("show")
//     eligibleCnt.classList.add("show")
// });


//////////////////////  pagination project table /////////

document.addEventListener("DOMContentLoaded", function () {
    function initializePagination(tableContainerSelector) {
      const container = document.querySelector(tableContainerSelector);
      if (!container) return; // Exit if the container doesn't exist

      const table = container.querySelector("table");
      if (!table) return; // Exit if no table found in the container

      const rows = table.querySelectorAll("tbody tr");
      const totalRows = rows.length;
      const rowsPerPage = Math.min(5, totalRows); // Dynamically decide rows per page (max 5)
      let currentPage = 1;
      const totalPages = Math.ceil(totalRows / rowsPerPage);

      const prevButton = container.querySelector(".pre-arrow-btn-cnt button");
      const nextButton = container.querySelector(".next-arrow-btn-cnt button");
      const pageButton = container.querySelector(".no-of-page-btn button");

      function displayTableRows() {
        rows.forEach((row, index) => {
          row.style.display = "none"; // Hide all rows initially
          if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
            row.style.display = ""; // Show only rows for the current page
          }
        });

        pageButton.innerText = `Page ${currentPage} of ${totalPages}`;
      }

      function updatePaginationButtons() {
        prevButton.disabled = currentPage === 1; // Disable "Previous" button if on the first page
        nextButton.disabled = currentPage === totalPages; // Disable "Next" button if on the last page
      }

      prevButton.addEventListener("click", function () {
        if (currentPage > 1) {
          currentPage--;
          displayTableRows();
          updatePaginationButtons();
        }
      });

      nextButton.addEventListener("click", function () {
        if (currentPage < totalPages) {
          currentPage++;
          displayTableRows();
          updatePaginationButtons();
        }
      });

      // Initialize table rows display and buttons
      displayTableRows();
      updatePaginationButtons();
    }

    // Initialize pagination for all table containers with the class "table-cnt"
    document.querySelectorAll(".table-cnt").forEach((container) => {
      initializePagination(`#${container.id}`);
    });
});


///////////////////// Pagination second table.

const settingTabBtn = document.querySelectorAll(".setting-tab");
const settingProfile = document.querySelectorAll(".setting-my-profile-wrapper");
// Tab switching logic for project table tabs
settingTabBtn.forEach((element, index) => {
    element.addEventListener("click", () => {
        settingTabBtn.forEach(tab => tab.classList.remove("my-profile-btn"));
        settingProfile.forEach(content => content.classList.remove("show"));

        settingTabBtn[index].classList.add("my-profile-btn");
        settingProfile[index].classList.add("show");
    });
});



// ===========Profile Form Edit Field================
// document.addEventListener('DOMContentLoaded', function () {
//     const profileEditBtn = document.querySelector('.company-logo-setting-page button');
//     const profileImage = document.querySelector('.company-logo-setting-page img');

//     profileEditBtn.addEventListener('click', function () {
//         const isEditing = profileEditBtn.textContent === 'Edit';

//         if (isEditing) {
//             // Change button text to Save
//             profileEditBtn.textContent = 'Save';

//             // Make text editable
//             const textElements = document.querySelectorAll('.company-logo-setting-page h2, .company-logo-setting-page p');
//             textElements.forEach(el => {
//                 el.setAttribute('contenteditable', 'true');
//                 el.style.backgroundColor = '#fff9c4'; // light yellow
//                 el.style.border = '1px dashed #fbc02d';
//             });

//             // Create hidden file input if not exists
//             let fileInput = document.getElementById('profile-image-input');
//             if (!fileInput) {
//                 fileInput = document.createElement('input');
//                 fileInput.type = 'file';
//                 fileInput.accept = 'image/*';
//                 fileInput.id = 'profile-image-input';
//                 fileInput.style.display = 'none';
//                 document.body.appendChild(fileInput);

//                 fileInput.addEventListener('change', function (event) {
//                     const file = event.target.files[0];
//                     if (file) {
//                         const reader = new FileReader();
//                         reader.onload = function (e) {
//                             profileImage.src = e.target.result;
//                             profileImage.style.border = '2px dashed #4caf50'; // green highlight
//                         };
//                         reader.readAsDataURL(file);
//                     }
//                 });
//             }

//             fileInput.click(); // trigger file picker
//         } else {
//             // Change button text back to Edit
//             profileEditBtn.textContent = 'Edit';

//             // Turn off editable mode
//             const textElements = document.querySelectorAll('.company-logo-setting-page h2, .company-logo-setting-page p');
//             textElements.forEach(el => {
//                 el.removeAttribute('contenteditable');
//                 el.style.backgroundColor = '';
//                 el.style.border = '';
//             });

//             // Optionally, you can save the updated text here (e.g., send to backend)
//             alert('Changes saved successfully!');
//         }
//     });

//     document.querySelector('.company-information-setting-page button').addEventListener('click', function (e) {
//         toggleEditButton(e.target, '.company-information-setting-page h3');
//     });

//     document.querySelector('.Personal-Information-setting-page button').addEventListener('click', function (e) {
//         toggleEditButton(e.target, '.Personal-Information-setting-page h3');
//     });

//     function toggleEditButton(button, selector) {
//         const isEditing = button.textContent === 'Edit';
//         if (isEditing) {
//             button.textContent = 'Save';
//             makeEditable(selector);
//         } else {
//             button.textContent = 'Edit';
//             removeEditable(selector);
//             alert('Changes saved successfully!');
//         }
//     }

//     function makeEditable(selector) {
//         const elements = document.querySelectorAll(selector);
//         elements.forEach(el => {
//             el.setAttribute('contenteditable', 'true');
//             el.style.backgroundColor = '#fff9c4';
//             el.style.border = '1px dashed #fbc02d';
//         });
//     }

//     function removeEditable(selector) {
//         const elements = document.querySelectorAll(selector);
//         elements.forEach(el => {
//             el.removeAttribute('contenteditable');
//             el.style.backgroundColor = '';
//             el.style.border = '';
//         });
//     }
// });



