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
<form id="examCenterForm">
    <input type="hidden" id="examCenterFormUrl" value="<?php echo base_url('store-exam-center-data') ?>">
    <input type="hidden" value="<?= base_url() ?>" class="base_url">

    <!-- ////////////////// Center details section start ////////////// -->
    <div class="center-details-section page active" id="page4">
        <div class="px-4 d-flex justify-content-between align-items-center flex-wrap fixed-top  navbar">
            <img src="<?php echo base_url('assets/asserts/BMTC Logo.png') ?>" alt="" class="img-fluid" style="max-width:70px;">
            <div class="d-flex  align-items-center gap-3">
                <p class="m-0 intro-tab">
                    Hi, <span class="username_cls"><?= $owner->first_name . ' ' . $owner->last_name ?></span>
                </p>
            </div>
        </div>
        <div class="container-fluid py-2 ">
            <!-- ////////////////////// steps //////////////////  -->
            <div class="row border-shadow py-3">

                <!-- Center Tabs -->
                <div class="mt-5" style="margin-top: 40px;">
                    <div class="d-flex overflow-auto flex-nowrap hide-scrollbar px-2 justify-content-between align-items-center">

                        <div class="d-flex justify-content-center align-items-center me-3 scroll-tab">
                            <p class="m-0 border py-2 px-3 d-flex justify-content-center align-items-center rounded-pill formIndicator border-dark">
                                <img src="<?php echo base_url('assets/asserts/Mask group.png') ?>"
                                    alt=""
                                    class="me-2"
                                    style="width: 20px; height: 20px; object-fit: contain;">
                                <span>1. Center details</span>
                            </p>

                            <div class="mx-2">
                                <img src="<?php echo base_url('assets/asserts/Chevron right.png') ?>"
                                    alt=""
                                    style="width: 18px; height: 18px;">
                            </div>
                        </div>


                        <div class="d-flex justify-content-center align-items-center me-3 scroll-tab">
                            <p class="m-0 border py-2 px-3 d-flex justify-content-center align-items-center rounded-pill formIndicator">
                                <img src="<?php echo base_url('assets/asserts/Profile.png') ?>"
                                    alt=""
                                    class="me-2"
                                    style="width: 20px; height: 20px; object-fit: contain;">
                                <span>2. Admin details</span>
                            </p>

                            <div class="mx-2">
                                <img src="<?php echo base_url('assets/asserts/Chevron right.png') ?>"
                                    alt=""
                                    style="width: 18px; height: 18px;">
                            </div>
                        </div>


                        <div class="d-flex justify-content-center align-items-center me-3 scroll-tab">
                            <p class="m-0 border py-2 px-3 d-flex justify-content-center align-items-center rounded-pill formIndicator">
                                <img src="<?php echo base_url('assets/asserts/group.png') ?>"
                                    alt=""
                                    class="me-2"
                                    style="width: 20px; height: 20px; object-fit: contain;">
                                <span>3. Infrastructure</span>
                            </p>

                            <div class="mx-2">
                                <img src="<?php echo base_url('assets/asserts/Chevron right.png') ?>"
                                    alt=""
                                    style="width: 18px; height: 18px;">
                            </div>
                        </div>


                        <div class="d-flex justify-content-center align-items-center scroll-tab">
                            <p class="m-0 border py-2 px-3 d-flex justify-content-center align-items-center rounded-pill formIndicator">
                                <img src="<?php echo base_url('assets/asserts/Mask group.png') ?>"
                                    alt=""
                                    class="me-2"
                                    style="width: 20px; height: 20px; object-fit: contain;">
                                <span>4. Bank details</span>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
            <!-- ////////////////////// steps ////////////////// -->
        </div>

        <div class="container">

            <!-- first step code -->
            <div class="row formStep">
                <div class="col-12 col-md-6 m-auto py-5 bg-color-form rounded-3">
                    <div class="text-center">
                        <p>Step1</p>
                        <h2>Center details</h2>
                        <p class="mb-5">Please enter all the details of the center</p>
                    </div>
                    <div class="center-details-form">
                        <p>
                            <label for="">Center Name</label><br>
                            <input type="text" name="center_name">
                        </p>
                        <p>
                            <label for="">Center Description(About Center)</label>
                            <input type="text" name="center_description">
                        </p>
                        <p>
                        <div class="">
                            <label for="">Center Type</label>
                            <select class="form-control form-select p-10" name="center_type" disabled>
                                <option value="online" selected>Online</option>
                                <option value="offline">Offline</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                        </p>
                        <p>
                            <label for="">Center’s Postal Address?</label><br>
                            <input type="text" name="postal_address">
                        </p>
                        <p class="fw-bold">Are you in center?</p>

                        <label>
                            <input type="radio" name="center_location" value="inside" checked>
                            At the Center
                        </label>

                        <label style="margin-left: 15px;">
                            <input type="radio" name="center_location" value="outside">
                            Outside the Center
                        </label>

                        <hr>

                        <p>
                            <label>Center’s Latitude</label><br>
                            <input type="text" name="address_lat" id="address_lat">
                        </p>

                        <p>
                            <label>Center’s Longitude</label><br>
                            <input type="text" name="address_long" id="address_long">
                        </p>

                        <!-- At the Center Button -->
                        <button type="button" id="getLocationBtn" class="btn mt-1 MB-5 sign-up-btn text-white">
                            📍 Get Current Location
                        </button>

                        <!-- Outside the Center Button -->
                        <button type="button" id="checkLocationBtn" class="btn mt-1 MB-5 sign-up-btn text-white" style="display:none;">
                            <img src="https://static.vecteezy.com/system/resources/previews/017/396/764/non_2x/google-maps-icon-free-png.png"
                                style="height: 20px;width: 20px;">
                            Get Latitude and Longitude By Map
                        </button>


                        <div id="locationStatus" style="display: none; color: green; margin-bottom: 15px;">
                            Location retrieved successfully!
                        </div>

                        <br>
                        <!-- Center logo -->
                        <div class="upload-group">
                            <label class="mb-0">Upload Center Logo</label>
                            <div class="custom-file-upload">
                                <label for="center-logo-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="center-logo-upload"
                                    name="center_logo"
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'center-logo-preview')">
                                <div class="state_line"></div>
                                <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="center-logo-preview" class="preview-container"></div>
                        </div>

                        <!-- center entrance -->
                        <div class="upload-group">
                            <label class="mb-0">Upload Center Entrance</label>
                            <div class="custom-file-upload">
                                <label for="center-entrance-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="center-entrance-upload"
                                    name="center_entrances[]" multiple
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'center-entrance-preview')">
                                <div class="state_line"></div>
                                <span class="note">
                                    <span style="color:red; font-weight:600;">
                                        Max files allowed: 2
                                    </span><br>
                                    Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="center-entrance-preview" class="preview-container"></div>
                        </div>


                        <!-- Lab Photos -->
                        <div class="upload-group">
                            <label class="mb-0">Lab Photos</label>
                            <div class="custom-file-upload">
                                <label for="lab-photos-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="lab-photos-upload"
                                    name="lab_photos[]" multiple
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'lab-photos-preview')">
                                <div class="state_line"></div>
                                <span class="note">
                                    <span style="color:red; font-weight:600;">
                                        Max files allowed: 2
                                    </span><br>
                                    Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="lab-photos-preview" class="preview-container"></div>
                        </div>

                        <!-- Main Gate/Entrance -->
                        <div class="upload-group">
                            <label class="mb-0">Main Gate/Entrance</label>
                            <div class="custom-file-upload">
                                <label for="main-gate-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="main-gate-upload"
                                    name="main_gate_images[]" multiple
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'main-gate-preview')">
                                <div class="state_line"></div>
                                <span class="note">
                                    <span style="color:red; font-weight:600;">
                                        Max files allowed: 1
                                    </span><br>
                                    Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="main-gate-preview" class="preview-container"></div>
                        </div>

                        <!-- Server Room -->
                        <div class="upload-group">
                            <label class="mb-0">Server Room</label>
                            <div class="custom-file-upload">
                                <label for="server-room-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="server-room-upload"
                                    name="server_room_images[]" multiple
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'server-room-preview')">
                                <div class="state_line"></div>
                                <span class="note">
                                    <span style="color:red; font-weight:600;">
                                        Max files allowed: 1
                                    </span><br>
                                    Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="server-room-preview" class="preview-container"></div>
                        </div>

                        <!-- Observer/Conference Room -->
                        <div class="upload-group">
                            <label class="mb-0">Observer/Conference room</label>
                            <div class="custom-file-upload">
                                <label for="observer-room-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="observer-room-upload"
                                    name="observer_room_images[]" multiple
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'observer-room-preview')">
                                <div class="state_line"></div>
                                <span class="note">
                                    <span style="color:red; font-weight:600;">
                                        Max files allowed: 1
                                    </span><br>
                                    Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="observer-room-preview" class="preview-container"></div>
                        </div>

                        <!-- UPS & Generator -->
                        <div class="upload-group">
                            <label class="mb-0">UPS & Generator photo</label>
                            <div class="custom-file-upload">
                                <label for="ups-generator-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="ups-generator-upload"
                                    name="ups_generator_images[]" multiple
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewFiles(event, 'ups-generator-preview')">
                                <div class="state_line"></div>
                                <span class="note">
                                    <span style="color:red; font-weight:600;">
                                        Max files allowed: 2
                                    </span><br>
                                    Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                            </div>
                            <div id="ups-generator-preview" class="preview-container"></div>
                        </div>

                        <!-- Center Walkthrough Video -->
                        <div class="upload-group">
                            <label class="mb-0">Center Walkthrough video</label>
                            <div class="custom-file-upload">
                                <label for="walkthrough-video-upload" class="upload-btn">
                                    <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                </label>
                                <input type="file" id="walkthrough-video-upload"
                                    name="walkthrough_video"
                                    accept="video/mp4, video/webm"
                                    onchange="previewFiles(event, 'walkthrough-video-preview')">
                                <div class="state_line"></div>
                                <span class="note">Max file size: 5 MB<br>File type: mp4, webm</span>
                            </div>
                            <div id="walkthrough-video-preview" class="preview-container"></div>
                        </div>
                        <p>
                        <div class="row">
                            <label for="">Where is your Center located?</label>
                            <div class="col-12 mb-3">
                                <select class="form-control form-select p-10 select2" name="country_id" onchange="fetchStateByCountryId(this.value)">
                                    <option value="">Select Country</option>
                                    <?php foreach ($countries as $row): ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <select class="form-control state_selection form-select p-10 select2" name="state_id" onchange="fetchCityByStateId(this.value)">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <select class="form-control city_selection form-select p-10 select2" name="city_id">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                            <div class="col-12 my-3">
                                <input type="text" placeholder="Local Area Name" name="local_area_name">
                            </div>
                            <div class="col-12">
                                <input type="number" placeholder="Pin Code" name="pincode">
                            </div>
                        </div>
                        </p>
                        <p>
                        <div class="">
                            <label for="">What is the Category of your Test Center?</label>
                            <select class="form-control form-select p-10" name="test_center_category">
                                <option value="">Select Center Category Type</option>
                                <?php foreach ($center_type as $row): ?>
                                    <option value="<?= $row['center_type'] ?>"><?= $row['center_type'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        </p>
                        <p class="m-0">
                            <label for="">Any nearby Landmark</label>
                        <div class="gst-state-code-wrapper">
                            <input type="text" placeholder="Ex: Lal Bahadur Metro Station" name="nearby_landmark">
                            <p class="m-0 px-2">Could be a Metro or Police station, a building etc.</p>
                        </div>
                        </p>
                        <p>
                        <div class="row">
                            <label for="">Is the Lift available for Physically Handicapped Candidate?</label>
                            <div class="col-6">
                                <div class="radio-container">
                                    <label for="" class="m-0">
                                        <input type="radio" name="is_lift_available" value="yes" class="radio-input">Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="radio-container">
                                    <label for="" class="m-0">
                                        <input type="radio" name="is_lift_available" value="no" class="radio-input">No
                                    </label>
                                </div>
                            </div>
                        </div>
                        </p>
                        <p>
                            <label for="nearest_railway_station">Name of Railway Station</label>
                            <input type="text" id="nearest_railway_station" name="nearest_railway_station" placeholder="Enter station name">
                        </p>
                        <p>
                            <label for="">Distance from the main Railway Station</label>
                            <select id="distance_from_railway_station" name="distance_from_railway_station" class="form-control p-10 form-select">
                                <option value="">Select distance</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </p>
                        <p>
                            <label for="nearest_bus_stop">Name of Bus Station</label>
                            <input type="text" id="nearest_bus_stop" name="nearest_bus_stop" placeholder="Enter station name">
                        </p>
                        <p>
                            <label for="">Distance from the nearby Bus Station</label>
                            <select id="distance_from_bus_stop" name="distance_from_bus_stop" class="form-control p-10 form-select">
                                <option value="">Select distance</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </p>
                        <p>
                            <label for="nearest_metro_station">Name of Metro Station</label>
                            <input type="text" id="nearest_metro_station" name="nearest_metro_station" placeholder="Enter Metro Station Name">
                        </p>
                        <p>
                            <label for="">Distance from the main Metro Station</label>
                            <select id="distance_from_metro_station" name="distance_from_metro_station" class="form-control p-10 form-select">
                                <option value="">Select distance</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </p>
                        <p>
                            <label for="nearest_airport">Name of Airport</label>
                            <input type="text" id="nearest_airport" name="nearest_airport" placeholder="Enter Airport Name">
                        </p>
                        <p>
                            <label for="">Distance from the main Airport</label>
                            <select id="distance_from_airport" name="distance_from_airport" class="form-control p-10 form-select">
                                <option value="">Select distance</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </p>
                    </div>
                </div>
            </div>

            <!-- second step code -->
            <div class="row formStep">
                <div class="col-md-6 m-auto py-5 px-4 bg-color-form rounded-3">
                    <div class="text-center">
                        <p class="text-center">Step2</p>
                        <h2>Center Administration details</h2>
                        <p class="mb-5">Please enter the details of the points of contact at the center</p>
                    </div>
                    <div class="center-details-form">
                        <div>
                            <label for="">Point of Contact</label><br>
                            <p>
                                <input type="text" placeholder="Name" name="point_of_contact">
                            </p>
                            <p>
                                <input type="number" placeholder="Phone number" name="contact_phone_number">
                            </p>
                            <p>
                                <input type="number" placeholder="Alternate Phone number" name="contact_alternate_phone_number">
                            </p>
                            <p>
                                <input type="email" placeholder="Email" name="contact_email">
                            </p>
                        </div>

                        <div>
                            <label for="">Center Superintendent details</label>
                            <p>
                                <input type="text" placeholder="Name" name="superintendent_name">
                            </p>
                            <p>
                                <input type="number" placeholder="Phone number" name="superintendent_number">
                            </p>
                            <p>
                                <input type="email" placeholder="Email" name="superintendent_email">
                            </p>
                        </div>
                        <div>
                            <label for="">IT Manager details</label>
                            <p>
                                <input type="text" placeholder="Name" name="assistant_manager_name">
                            </p>
                            <p>
                                <input type="number" placeholder="Phone number" name="assistant_manager_phone_number">
                            </p>
                            <p>
                                <input type="email" placeholder="Email" name="assistant_manager_email">
                            </p>
                        </div>
                        <div>
                            <label for="">Emergency Contact number of the Center</label>
                            <p>
                                <input type="number" placeholder="Phone number" name="emergency_phone_number">
                            </p>
                            <p>
                                <input type="number" placeholder="Landline number" name="emergency_landline_number">
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- third step -->
            <div class="row formStep">
                <div class="col-md-6 m-auto py-5 px-5 bg-color-form rounded-3">
                    <div class="text-center">
                        <p class="text-center">Step3</p>
                        <h2>Exam Infrastructure details</h2>
                        <p class="mb-5">Please enter the required information</p>
                    </div>
                    <div class="center-details-form">
                        <div class="mb-5">
                            <p>General Lab details</p>
                            <label for="">Total number of labs</label><br>
                            <p>
                                <input type="number" placeholder="Enter total number of labs" id="total_number_of_lab" name="total_number_of_lab" value="1">
                            </p>
                            <p>
                                <label for="">Total number of systems</label><br>
                                <input type="text" placeholder="..." name="total_number_of_system" id="total_number_of_system">
                            </p>
                            <label for="">Are all labs connected through a single network?</label><br>
                            <p>
                                <select id="single-network" class="network-option p-10 form-select" name="lab_are_connect_to_single_network">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>

                            <label for="">Total networks</label><br>
                            <p>
                                <input type="number" id="total-networks" placeholder="..." name="total_network" min="1">
                            </p>
                            <label for="">Is There a Partition in each System</label><br>
                            <p>
                                <select id="" class="network-option  p-10 form-select" name="partition_in_each_lab">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                            <label for="">Is there an AC in each lab?</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select" name="ac_in_each_lab">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                            <label for="">Is the Network Printer available?</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select" name="is_network_printer_availabel">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                            <label for="">Is there a projector in each lab?</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select" name="is_there_projector_in_each_lab">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                            <label for="">Is there a sound system in each lab?</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select" name="is_there_sound_sytem_in_each_lab">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                            <label for="">How Many Fire Extinguisher in each lab</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select" name="how_many_fire_extinguisher_in_each_lab">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </p>
                            <label for="">Is there a Free Baggage Space ?</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select" name="is_there_a_locker_facility_in_lab">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                            <label for="">Is there a drinking water facility in/near the labs?</label><br>
                            <p>
                                <select id="" class="network-option p-10 form-select"
                                    name="is_there_a_drinking_water_facility_in_lab">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>
                        </div>
                        <div>
                            <p>Lab Infrastructure details</p>
                            <p>
                                <label for="">Name of the Primary ISP</label>
                                <input type="text" placeholder="..." name="primary_infrastructure">
                            </p>
                            <p><label>Primary ISP Connection Type</label>
                                <select name="primary_isp_connect_type" class="form-select">
                                    <option value="">Select</option>
                                    <option value="broadband">Broadband</option>
                                    <option value="lease_line">Lease line</option>
                                    <option value="fibre_optics">Fibre Optics</option>
                                    <option value="air_fibre">Air Fibre</option>
                                </select>
                            </p>
                            <p class="m-0">
                                <label for="">Primary Internet Speed</label><br>
                            <div class="d-flex justify-contant-start align-item-center">
                                <input name="primary_isp_speed" type="number" placeholder="Internet speed" class="p-10">
                                <select name="primary_internet_speed_unit" class="p-10 ms-2">
                                    <option value="Mbps">Mbps</option>
                                    <option value="Gbps">Gbps</option>
                                </select>
                            </div>

                            </p>
                            <p>
                                <label for="">Name of the Secondary ISP</label>
                                <input type="text" placeholder="..." name="secondary_infrastructure">
                            </p>
                            <p><label>Secondary ISP Connection Type</label>
                                <select name="secondary_isp_connect_type" class="form-select">
                                    <option value="">Select</option>
                                    <option value="broadband">Broadband</option>
                                    <option value="lease_line">Lease line</option>
                                    <option value="fibre_optics">Fibre Optics</option>
                                    <option value="air_fibre">Air Fibre</option>
                                </select>
                            </p>
                            <p class="m-0">
                                <label for="">Secondary ISP Speed</label><br>
                            <div class="d-flex justify-contant-start align-item-center">
                                <input name="secondary_isp_speed" type="number" placeholder="Internet speed" class="p-10">
                                <select name="secondary_internet_speed_unit" class="p-10 ms-2">
                                    <option value="Mbps">Mbps</option>
                                    <option value="Gbps">Gbps</option>
                                </select>
                            </div>
                            </p>
                            <p>
                                <label for="">Generator Available</label><br>
                                <select class="form-control p-10 form-select" name="is_generator_backup" id="generator-available">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </p>

                            <p id="generator-backup-section" style="display: none;">
                                <label for="">Generator Capacity (in KVA)</label>
                                <input type="text" placeholder="Generator Capacity (in KVA)" name="generator_backup_capacity" class="form-control p-10">

                                <label for="generator-fuel-tank-capacity">Generator Fuel Tank Capacity (in Ltr.)</label>
                                <select name="generator_fuel_tank_capacity" id="generator-fuel-tank-capacity" class="form-control p-10 form-select">
                                    <option value="">Select Capacity</option>
                                    <!-- JS will populate options -->
                                </select>
                            </p>

                            <p>
                                <label for="">UPS Backup (KVA)</label>
                                <input type="text" placeholder="UPS Backup (KVA)" name="ups_backup" class="form-control p-10">

                                <label for="ups-time">UPS Backup Time (in mins)</label>
                                <select name="ups_backup_time" id="ups-time" class="form-control p-10 form-select">
                                    <option value="">Select time</option>
                                    <!-- Populated by JS -->
                                </select>
                            </p>
                        </div>
                        <p>Lab details</p>
                        <div id="labContainerHtml"></div>

                        <button type="button" id="addLabBtn"
                            class="btn rounded w-100 d-flex justify-content-center align-items-center addNewLab mt-3 lab-number text-white">
                            <span class="fs-4 me-2">+</span>Add new lab
                        </button>
                    </div>
                </div>
            </div>

            <!-- fourth tep -->
            <div class="row formStep">
                <div class="col-md-6 col-12 m-auto py-5 bg-color-form rounded-3">
                    <div class="text-center">
                        <p class="text-center">Step4</p>
                        <h2>Bank Account details</h2>
                        <p class="mb-5">Please enter your bank details</p>
                    </div>
                    <div class="center-details-form">
                        <div>
                            <p>
                                <label for="beneficiary_name">Beneficiary name</label><br>
                                <input type="text" placeholder="..." name="beneficiary_name">
                            </p>
                            <p>
                                <label for="bank_name">Name of the bank</label><br>
                                <select class="form-control p-10 select2" name="bank_name">
                                    <option value="">Select Bank</option>
                                    <?php
                                    foreach ($bank_name as $row) { ?>
                                        <option value="<?= $row['bank_name'] ?>"><?= $row['bank_name'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label for="bank_account_number">Bank Account number</label><br>
                                <input type="text" placeholder="..." name="bank_account_number">
                            </p>
                            <p>
                                <label for="bank_ifsc">Bank IFSC code</label><br>
                                <input type="text" placeholder="..." name="bank_ifsc">
                            </p>
                            <p>
                                <label for="pan_number">PAN number</label><br>
                                <input type="text" placeholder="..." name="pannumber">
                            </p>
                            <p>
                                <label>Do you have a GST number?</label><br>
                                <input type="radio" name="has_gst" value="yes"> Yes
                                <input type="radio" name="has_gst" value="no" checked> No
                            </p>

                            <div id="gst-section" style="display:none;">
                                <p>
                                    <label for="gst_number">GST number</label><br>
                                    <input type="text" placeholder="Enter GST number..." name="gst_number">
                                </p>
                                <p>
                                    <label for="gst_file">Upload GST Document</label><br>
                                    <input type="file" name="gst_file" id="gst_file" accept=".pdf">
                                </p>

                                <p class="m-0">
                                    <label for="gst_state_code">GST State code</label><br>
                                <div class="gst-state-code-wrapper">
                                    <input type="text" placeholder="..." class="border-top" name="gst_state_code">
                                    <p class="m-0 px-2">
                                        Here’s a
                                        <a href="https://www.iifl.com/blogs/business-loan/gst-code-list-and-jurisdiction" target="_blank">
                                            link
                                        </a>
                                        to find your GST code:
                                    </p>
                                </div>
                                </p>
                            </div>
                            <p>
                                <label for="">UIDAI Number</label>
                                <input type="text" placeholder="Enter UIDAI Number" name="uidai_number">
                            </p>
                            <p>
                                <label>Do you have an MSME number?</label><br>
                                <input type="radio" name="has_msme" value="yes"> Yes
                                <input type="radio" name="has_msme" value="no" checked> No
                            </p>
                            <div id="msme-section" style="display:none;">
                                <p>
                                    <label for="msme_number">MSME Number</label><br>
                                    <input type="text" placeholder="Enter MSME Number" name="msme_number">
                                </p>
                            </div>
                            <div class="upload-group">
                                <label class="mb-0">Upload Canceled Cheque</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="canceled_cheque" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                            <div class="upload-group">
                                <label class="mb-0">Upload Agreement</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="agreement" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                            <div class="upload-group">
                                <label class="mb-0">Upload MOU</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="mou" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                            <div class="upload-group">
                                <label class="mb-0">Upload NDA</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="NDA" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                            <div class="upload-group">
                                <label class="mb-0">Upload GST Certificate</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="gst_certificate" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                            <div class="upload-group">
                                <label class="mb-0">Upload Udyam Certificate</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="udyam_certificate" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                            <div class="upload-group">
                                <label class="mb-0">Upload PAN Card</label>
                                <div class="custom-file-upload">
                                    <label class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up mb-0"></i> Upload File
                                        <input type="file" name="pan_number" accept=".doc,.docx,.pdf" hidden>
                                    </label>
                                    <div class="state_line"></div>
                                    <span class="note">Max file size: 1 MB<br>File type: doc, docx, pdf</span>
                                    <div class="file-preview mt-2"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <!-- previous button and submit button start-->
            <div class="row py-3">
                <div class="col-6">
                    <div class="ps-3">
                        <button type="button" class="btn border Previous-btn formPreviousBtn"><img src="<?php echo base_url('assets/asserts/Arrow 3 (1).png') ?>"
                                alt="">
                            Previous</button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="pe-3 text-end">
                        <button type="button" class="btn border Submit_btn text-white formNextBtn">Submit <img src="<?php echo base_url('assets/asserts/Arrow 3 (2).png') ?>" alt=""></button>
                    </div>
                </div>
            </div>
            <!-- previous button and submit button end-->


        </div>
    </div>
    <!-- /////////////// Center details section end /////////////////////// -->

</form>


<!-- ////////////////////////////////// open pop-up ////////////////// -->
<div class="popup-overlay" id="finalScreenPopup">
    <div class="popup-content">
        <h2>Welcome to BookMyTestCenter</h2>
        <p>We’re extremely exited to have you as a center partner</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap mt-4 mb-4">

            <!-- Dashboard -->
            <a href="<?= base_url('center-owner-dashboard') ?>"
                class="btn btn-primary text-white fw-semibold px-4 py-2 shadow-sm">
                <i class="bi bi-speedometer2 me-2"></i>
                Go To Dashboard
            </a>

            <!-- Add More Center -->
            <a href="<?= base_url('create-center') ?>"
                class="btn btn-success text-white fw-semibold px-4 py-2 shadow-sm">
                <i class="bi bi-plus-circle me-2"></i>
                Add More Center
            </a>

        </div>
        <video
            style="width: 100%; height: 300px;"
            width="600"
            height="350"
            controls
            autoplay
            muted
            playsinline
            poster="<?php echo base_url('assets/video/poster.jpg') ?>">

            <source src="<?php echo base_url('assets/video/exam-center-welcome.mp4') ?>" type="video/mp4">

            Your browser does not support the video tag.
        </video>
    </div>
</div>

<!-- ===================Get Current location==================== -->
<script>
    document.getElementById('getLocationBtn').addEventListener('click', function() {
        const statusDiv = document.getElementById('locationStatus');
        const originalText = this.innerHTML;
        if (navigator.geolocation) {
            // Show loading state
            this.innerHTML = '⏳ Detecting location...';
            this.style.opacity = '0.7';
            statusDiv.style.display = 'none';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const long = position.coords.longitude;

                    document.getElementById('address_lat').value = lat.toFixed(6);
                    document.getElementById('address_long').value = long.toFixed(6);

                    // Show success message
                    statusDiv.style.display = 'block';
                    statusDiv.style.color = 'green';
                    statusDiv.innerHTML = '✅ Location retrieved successfully!';

                    // Reset button
                    document.getElementById('getLocationBtn').innerHTML = '📍 Location Retrieved';
                    document.getElementById('getLocationBtn').style.opacity = '1';
                },
                function(error) {
                    let errorMessage = "Could not retrieve location.";

                    if (error.code === error.PERMISSION_DENIED) {
                        errorMessage = "Location access was denied. Please allow location access in your browser settings.";
                    }

                    // Show error message
                    statusDiv.style.display = 'block';
                    statusDiv.style.color = 'red';
                    statusDiv.innerHTML = '❌ ' + errorMessage;

                    // Reset button
                    document.getElementById('getLocationBtn').innerHTML = originalText;
                    document.getElementById('getLocationBtn').style.opacity = '1';
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 60000
                }
            );
        } else {
            statusDiv.style.display = 'block';
            statusDiv.style.color = 'red';
            statusDiv.innerHTML = '❌ Geolocation is not supported by your browser.';
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Populate distance dropdowns in meters
        const railwayDistanceDropdown = document.getElementById('distance_from_railway_station');
        const busDistanceDropdown = document.getElementById('distance_from_bus_stop');
        const metroDistanceDropdown = document.getElementById('distance_from_metro_station');
        const airportDistanceDropdown = document.getElementById('distance_from_airport');

        // Create options for 100m to 10000m (10km) in 100m increments
        for (let meters = 100; meters <= 300000; meters += 100) {
            const km = (meters / 1000).toFixed(2);
            const optionText = meters <= 1000 ? `${meters} meters` : `${km} km`;

            const option1 = document.createElement('option');
            option1.value = meters;
            option1.textContent = optionText;

            const option2 = document.createElement('option');
            option2.value = meters;
            option2.textContent = optionText;

            const option3 = document.createElement('option');
            option3.value = meters;
            option3.textContent = optionText;


            const option4 = document.createElement('option');
            option4.value = meters;
            option4.textContent = optionText;

            railwayDistanceDropdown.appendChild(option1);
            busDistanceDropdown.appendChild(option2);
            metroDistanceDropdown.appendChild(option3);
            airportDistanceDropdown.appendChild(option4);
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Populate Generator Time dropdown (5 to 180 mins, step 5)
        for (let mins = 5; mins <= 480; mins += 5) {
            $('#ups-time').append(`<option value="${mins}">${mins} mins</option>`);
        }

        for (let ltr = 1; ltr <= 500; ltr += 0.5) {
            $('#generator-fuel-tank-capacity').append(`<option value="${ltr}">${ltr} ltr</option>`);
        }


        // Show/hide Generator and UPS backup sections
        $('#generator-available').change(function() {
            const value = $(this).val();
            if (value === 'yes') {
                $('#generator-backup-section').show();
            } else {
                $('#generator-backup-section').hide();
                $('#generator-fuel-tank-capacity').val('');
            }
        }).trigger('change');
    });
</script>

<script>
    function showFilePreview(input) {
        const file = input.files[0];
        const previewContainer = $(input).closest(".custom-file-upload").find(".file-preview");
        previewContainer.empty();

        if (!file) return;

        const fileType = file.type;

        if (fileType === "application/pdf") {
            // Inline PDF preview
            const fileURL = URL.createObjectURL(file);
            previewContainer.html(`<iframe src="${fileURL}" width="100%" height="200px"></iframe>`);
        } else if (
            fileType === "application/msword" ||
            fileType === "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        ) {
            // Word file link preview
            previewContainer.html(`
                <div class="doc-preview">
                    <i class="fa-solid fa-file-word text-primary"></i> ${file.name}
                </div>
            `);
        } else {
            previewContainer.html(`<p class="text-danger">Unsupported file format</p>`);
        }
    }

    // Bind change event
    $("input[type='file']").on("change", function() {
        showFilePreview(this);
    });
</script>

<script>
    document.getElementById("checkLocationBtn").addEventListener("click", function() {
        // Open Google Maps at the given lat/long
        window.open(
            "https://www.google.com/maps/place/India/@20.9346246,68.8072768,2875006m/data=!3m1!1e3!4m15!1m8!3m7!1s0x30635ff06b92b791:0xd78c4fa1854213a6!2sIndia!3b1!8m2!3d20.593684!4d78.96288!16zL20vMDNyazA!3m5!1s0x30635ff06b92b791:0xd78c4fa1854213a6!8m2!3d20.593684!4d78.96288!16zL20vMDNyazA?entry=ttu&g_ep=EgoyMDI1MDkyMy4wIKXMDSoASAFQAw%3D%3D",
            "_blank"
        );
    });
</script>

<script>
    document.getElementById("single-network").addEventListener("change", function() {
        let totalNetworks = document.getElementById("total-networks");
        if (this.value === "yes") {
            totalNetworks.value = 1;
            totalNetworks.readOnly = true; // Lock field so user can't change
        } else {
            totalNetworks.value = "";
            totalNetworks.readOnly = false; // Unlock field
        }
    });
</script>

<script>
    document.querySelectorAll('input[name="has_gst"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'yes') {
                document.getElementById('gst-section').style.display = 'block';
            } else {
                document.getElementById('gst-section').style.display = 'none';
            }
        });
    });
</script>

<script>
    document.querySelectorAll('input[name="has_msme"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'yes') {
                document.getElementById('msme-section').style.display = 'block';
            } else {
                document.getElementById('msme-section').style.display = 'none';
            }
        });
    });
</script>

<script>
    document.querySelectorAll('input[name="center_location"]').forEach((radio) => {
        radio.addEventListener('change', function() {

            if (this.value === 'inside') {
                document.getElementById('getLocationBtn').style.display = 'inline-block';
                document.getElementById('checkLocationBtn').style.display = 'none';
            } else {
                document.getElementById('getLocationBtn').style.display = 'none';
                document.getElementById('checkLocationBtn').style.display = 'inline-block';
            }

        });
    });
</script>