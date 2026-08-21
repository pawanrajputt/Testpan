<div class="booking-center my-centers-section active">
    <div class="my-booking-wrapper d-flex justify-content-between align-items-center">
        <div class="my-booking-header ps-4">
            <h2 class="m-0 fs-3">Manage Profile</h2>
        </div>

        <?php if (!empty($editPermission)) { ?>

            <!-- Edit Profile Button -->
            <div class="pe-4" id="edit-center-btn-cnt">
                <button class="btn btn-dark text-white" onclick="editProfileFunction()">
                    <img src="<?= base_url('assets/asserts/edit-btn.png') ?>" class="me-2">
                    Edit Center
                </button>
            </div>

        <?php } elseif (!empty($editRequest) && $editRequest->status == 'pending') { ?>

            <span class="badge bg-info">Edit request pending approval</span>

        <?php } else { ?>

            <!-- Request Edit Button -->
            <div class="pe-4" id="request-edit-btn">
                <button class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#editRequestModal">
                    Request Profile Edit
                </button>
            </div>

        <?php } ?>

        <div class="pe-4" id="editBtnCnt">
            <a href="<?php echo base_url('my-center') ?>"><button class="btn btn-white border rounded text-dark me-3">Go Back</button></a>
            <button class="btn btn-success" onclick="getSave()">Save</button>
        </div>
    </div>
    <div class="my-center-wrapper " id="center-Profile">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-5">
                    <div class="card border position-sticky top-0">
                        <div class="mb-3">
                            <?php
                            if (isset($result->logo) && $result->logo != '') { ?>
                                <img src="<?php echo base_url($result->logo); ?>" alt="" style="height:100px ;">
                            <?php } ?>
                        </div>
                        <h4 class="mb-3"><?= $result->center_name ?></h4>
                        <p class="text-muted"><?= $result->center_description ?></p>
                        <hr>
                        <p class="d-flex justify-content-between location">
                            <strong>Location:</strong>
                            <span class="text-primary text-dark"><?= $result->local_area_name ?></span>
                        </p>
                        <p class="d-flex justify-content-between"><strong>Seating:</strong> <?= $result->capacity ?></p>
                        <p class="d-flex justify-content-between"><strong>Audited:</strong> <span class="badge Audited-btn"><?= $result->audit_status == 1 ? 'Yes' : 'No'; ?></span></p>
                        <p class="d-flex justify-content-between"><strong>Available:</strong> <span class="badge Available-btn">Yes</span></p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center audit-cnt">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-2">
                                    <img src="<?php echo base_url('assets/asserts/audit-img.png') ?>" alt="">
                                </div>
                                <div>
                                    <h5 class="m-0">Audit report</h5>
                                    <p class="m-0">
                                        <?php
                                        if ($result->last_audited != '') { ?>
                                            Last audited on <?= date('M d, Y', strtotime($result->last_audited)) ?>
                                        <?php } else { ?>
                                            No uploaded yet!
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                            if ($result->last_audited != '') { ?>
                                <div>
                                    <a style="text-decoration: none;" href="<?= ADMIN_URL . '/' . 'uploads/center_audit_file/' . $result->audit_file ?>" target="_blank">
                                        <button class="btn border rounded">View</button>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center audit-cnt">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-2">
                                    <img src="<?php echo base_url('assets/asserts/location-icon.png') ?>" alt="">
                                </div>
                                <div>
                                    <h5 class="m-0"><?= $result->center_name ?></h5>
                                    <p class="m-0"><?= $result->local_area_name ?></p>
                                </div>
                            </div>
                            <div>
                                <a href="https://www.google.com/maps?q=<?= $result->address_lat ?>,<?= $result->address_long ?>" target="_blank">
                                    <button class="btn border rounded">View</button>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-7">
                    <div class="image-accordian-wrapper">
                        <div class="card bg-transparent">
                            <h5 class="mb-3">Center details</h5>
                            <div class="accordion" id="accordionDetails">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#centerDetails">
                                            Basic details
                                        </button>
                                    </h2>
                                    <div id="centerDetails" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-5 m-auto py-2 w-100 bg-white ">
                                                    <div class="center-details-form">
                                                        <p>
                                                            <label>What is the Center name?</label><br>
                                                            <input type="text" value="<?= $result->center_name ?>" readonly>
                                                        </p>
                                                        <p>
                                                            <label>Center Description(About Center)</label><br>
                                                            <input type="text" value="<?= $result->center_description ?>" readonly>
                                                        </p>
                                                        <p>
                                                            <label>What is the center’s Postal Address?</label><br>
                                                            <input type="text" value="<?= $result->address ?>" readonly>
                                                        </p>

                                                        <p>
                                                        <div class="">
                                                            <label for="">Center Type</label>
                                                            <select class="form-control form-select p-10" name="center_type">
                                                                <option <?= $result->center_type == 'online' ? 'selected' : '' ?> value="online">Online</option>
                                                            </select>
                                                        </div>
                                                        </p>

                                                        <p>
                                                            <label>Center's Latitude</label><br>
                                                            <input type="text" value="<?= $result->address_lat ?>" readonly>
                                                        </p>

                                                        <p>
                                                            <label>Center's Longitude</label><br>
                                                            <input type="text" value="<?= $result->address_long ?>" readonly>
                                                        </p>

                                                        <p>
                                                            <label>Center Capacity</label><br>
                                                            <input type="text" value="<?= $result->capacity ?>" readonly>
                                                        </p>

                                                        <p>
                                                            <label>Upload Center Entrance</label>
                                                            <?php if (!empty($center_entrances)) {
                                                                foreach ($center_entrances as $index => $image) { ?>
                                                        <div style="position: relative;" class="image-container" data-index="<?php echo $index; ?>">
                                                            <img src="<?php echo base_url($image['center_image']); ?>" alt="Center Image" class="center-img">
                                                            <div class="delete-img-btn" onclick="handleImageDelete('<?php echo htmlspecialchars($image['id'], ENT_QUOTES); ?>')">
                                                                <img src="<?php echo base_url('assets/asserts/delete-img-icon.png'); ?>" alt="Delete" style="cursor: pointer;">
                                                            </div>
                                                        </div>
                                                <?php }
                                                            } else {
                                                                echo "<p class='text-center'>No File Uploaded Yet!</p>";
                                                            } ?>
                                                </p>

                                                <p>
                                                    <label>Lab Photos</label>
                                                    <?php if (!empty($lab_images)) {
                                                        foreach ($lab_images as $index => $image) { ?>
                                                <div style="position: relative;" class="image-container" data-index="<?php echo $index; ?>">
                                                    <img src="<?php echo base_url($image['center_image']); ?>" alt="Center Image" class="center-img">
                                                    <div class="delete-img-btn" onclick="handleImageDelete('<?php echo htmlspecialchars($image['id'], ENT_QUOTES); ?>')">
                                                        <img src="<?php echo base_url('assets/asserts/delete-img-icon.png'); ?>" alt="Delete" style="cursor: pointer;">
                                                    </div>
                                                </div>
                                        <?php }
                                                    } else {
                                                        echo "<p class='text-center'>No File Uploaded Yet!</p>";
                                                    } ?>
                                        </p>

                                        <p>
                                            <label>Main Gate/Entrance</label>
                                            <?php if (!empty($gate_images)) {
                                                foreach ($gate_images as $index => $image) { ?>
                                        <div style="position: relative;" class="image-container" data-index="<?php echo $index; ?>">
                                            <img src="<?php echo base_url($image['center_image']); ?>" alt="Center Image" class="center-img">
                                            <div class="delete-img-btn" onclick="handleImageDelete('<?php echo htmlspecialchars($image['id'], ENT_QUOTES); ?>')">
                                                <img src="<?php echo base_url('assets/asserts/delete-img-icon.png'); ?>" alt="Delete" style="cursor: pointer;">
                                            </div>
                                        </div>
                                <?php }
                                            } else {
                                                echo "<p class='text-center'>No File Uploaded Yet!</p>";
                                            } ?>
                                </p>

                                <p>
                                    <label>Server Room</label>
                                    <?php if (!empty($server_images)) {
                                        foreach ($server_images as $index => $image) { ?>
                                <div style="position: relative;" class="image-container" data-index="<?php echo $index; ?>">
                                    <img src="<?php echo base_url($image['center_image']); ?>" alt="Center Image" class="center-img">
                                    <div class="delete-img-btn" onclick="handleImageDelete('<?php echo htmlspecialchars($image['id'], ENT_QUOTES); ?>')">
                                        <img src="<?php echo base_url('assets/asserts/delete-img-icon.png'); ?>" alt="Delete" style="cursor: pointer;">
                                    </div>
                                </div>
                        <?php }
                                    } else {
                                        echo "<p class='text-center'>No File Uploaded Yet!</p>";
                                    } ?>
                        </p>

                        <p>
                            <label>Observer/Conference room</label>
                            <?php if (!empty($observer_images)) {
                                foreach ($observer_images as $index => $image) { ?>
                        <div style="position: relative;" class="image-container" data-index="<?php echo $index; ?>">
                            <img src="<?php echo base_url($image['center_image']); ?>" alt="Center Image" class="center-img">
                            <div class="delete-img-btn" onclick="handleImageDelete('<?php echo htmlspecialchars($image['id'], ENT_QUOTES); ?>')">
                                <img src="<?php echo base_url('assets/asserts/delete-img-icon.png'); ?>" alt="Delete" style="cursor: pointer;">
                            </div>
                        </div>
                <?php }
                            } else {
                                echo "<p class='text-center'>No File Uploaded Yet!</p>";
                            } ?>
                </p>


                <p>
                    <label>UPS & Generator photo</label>
                    <?php if (!empty($ups_images)) {
                        foreach ($ups_images as $index => $image) { ?>
                <div style="position: relative;" class="image-container" data-index="<?php echo $index; ?>">
                    <img src="<?php echo base_url($image['center_image']); ?>" alt="Center Image" class="center-img">
                    <div class="delete-img-btn" onclick="handleImageDelete('<?php echo htmlspecialchars($image['id'], ENT_QUOTES); ?>')">
                        <img src="<?php echo base_url('assets/asserts/delete-img-icon.png'); ?>" alt="Delete" style="cursor: pointer;">
                    </div>
                </div>
        <?php }
                    } else {
                        echo "<p class='text-center'>No File Uploaded Yet!</p>";
                    } ?>
        </p>

        <p>
            <label>Center Walkthrough Video</label><br>

            <?php if (!empty($walkthrough_video)) : ?>

                <?php foreach ($walkthrough_video as $video): ?>
                    <video width="320" height="240" controls preload="metadata" style="margin-bottom:10px;">
                        <source src="<?= base_url($video['center_video']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endforeach; ?>
            <?php else : ?>
        <p class='text-center'>No Video Uploaded Yet!</p>
    <?php endif; ?>

    </p>

    <p>
    <div class="row">
        <label>Where is your Center located?</label><br>
        <div class="col-6 mb-3">
            <select class="form-control" disabled>
                <option value="">Select Country</option>
                <?php foreach ($countries as $row): ?>
                    <option value="<?= $row['id'] ?>" <?= ($result->country_id == $row['id']) ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-6 mb-3">
            <select class="form-control state_selection" disabled>
                <option value="">Select State</option>
                <?php if (!empty($result->country_id)) :
                    $states = $this->Common_model->getdata_array('tt_states', ['country_id' => $result->country_id]);
                    foreach ($states as $state): ?>
                        <option value="<?= $state['id'] ?>" <?= ($result->state_id == $state['id']) ? 'selected' : '' ?>>
                            <?= $state['title'] ?>
                        </option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>

        <div class="col-6 mb-3">
            <select class="form-control city_selection" disabled>
                <option value="">Select City</option>
                <?php if (!empty($result->state_id)) :
                    $cities = $this->Common_model->getdata_array('tt_city_master', ['state_id' => $result->state_id]);
                    foreach ($cities as $city): ?>
                        <option value="<?= $city['city_id'] ?>" <?= ($result->city_id == $city['city_id']) ? 'selected' : '' ?>>
                            <?= $city['city_name'] ?>
                        </option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>

        <div class="col-6 mb-3">
            <input type="text" placeholder="Local Area Name" value="<?= $result->local_area_name ?>" readonly>
        </div>

        <div class="col-6">
            <input type="text" placeholder="Pin Code" value="<?= $result->pin_code ?>" readonly>
        </div>
    </div>
    </p>

    <p>
    <div class="row">
        <label>What is the Category of your Test Center?</label>
        <div class="col-12 mb-3">
            <select class="form-control" disabled>
                <option value="">Select Your Center Category</option>
                <?php foreach ($center_type as $row): ?>
                    <option value="<?= $row['center_type'] ?>" <?= ($result->type_of_center == $row['center_type']) ? 'selected' : '' ?>>
                        <?= $row['center_type'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    </p>

    <p>
        <label>Any nearby Landmark</label>
    <div class="gst-state-code-wrapper">
        <input type="text" placeholder="Ex: Lal Bahadur Metro Station" value="<?= $result->landmark ?>" readonly>
        <p class="m-0 px-2">Could be a Metro or Police station, a building etc.</p>
    </div>
    </p>

    <p>
    <div class="row">
        <label>Is the Lift available for Physically Handicapped Candidate?</label>
        <div class="col-6">
            <div class="radio-container">
                <label>
                    <input type="radio" name="for_ph_candidate" value="yes" <?= ($result->for_ph_candidate == 'yes') ? 'checked' : '' ?> disabled> Yes
                </label>
            </div>
        </div>
        <div class="col-6">
            <div class="radio-container">
                <label>
                    <input type="radio" name="for_ph_candidate" value="no" <?= ($result->for_ph_candidate == 'no') ? 'checked' : '' ?> disabled> No
                </label>
            </div>
        </div>
    </div>
    </p>

    <p>
        <label>Name of Railway Station</label>
        <input type="text" value="<?= $result->nearest_railway_station ?>" readonly>
    </p>

    <p>
        <label>Distance from the main Railway Station</label>
        <input type="text" value="<?= $result->distance_from_station ?>" readonly>
    </p>
    <p>
        <label>Name of Bus Station</label>
        <input type="text" value="<?= $result->nearest_bus_stop ?>" readonly>
    </p>

    <p>
        <label>Distance from the nearby Bus Station</label>
        <input type="text" value="<?= $result->distance_from_bus_stop ?>" readonly>
    </p>
    <p>
        <label>Name of Metro Station</label>
        <input type="text" value="<?= $result->nearest_metro_station ?>" readonly>
    </p>

    <p>
        <label>Distance from the main Metro Station</label>
        <input type="text" value="<?= $result->distance_from_metro ?>" readonly>
    </p>
    <p>
        <label>Name of Airport</label>
        <input type="text" value="<?= $result->nearest_airport ?>" readonly>
    </p>

    <p>
        <label>Distance from the main Airport</label>
        <input type="text" value="<?= $result->distance_from_airport ?>" readonly>
    </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#adminDetails">
                                            Admin details
                                        </button>
                                    </h2>
                                    <div id="adminDetails" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-5 m-auto py-2 w-100 bg-white">
                                                    <div class="center-details-form">
                                                        <!-- Point of Contact -->
                                                        <div>
                                                            <label for="">Point of Contact</label><br>
                                                            <p>
                                                                <input type="text" value="<?= $result->poc_name ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="number" placeholder="Phone number" value="<?= $result->poc_contact_no ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="number" placeholder="Alternate Phone number" value="<?= $result->poc_mobile_alternate ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="email" placeholder="Email" value="<?= $result->poc_email ?>" readonly>
                                                            </p>
                                                        </div>

                                                        <!-- Center Superintendent -->
                                                        <div>
                                                            <label for="">Center Superintendent details</label>
                                                            <p>
                                                                <input type="text" placeholder="Name" value="<?= $result->cs_name ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="number" placeholder="Phone number" value="<?= $result->cs_contact_number ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="email" placeholder="Email" value="<?= $result->cs_email ?>" readonly>
                                                            </p>
                                                        </div>

                                                        <!-- Assistant Manager -->
                                                        <div>
                                                            <label for="">IT Manager Details</label>
                                                            <p>
                                                                <input type="text" placeholder="Name" value="<?= $result->am_name ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="text" placeholder="Phone number" value="<?= $result->am_contact_no ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="email" placeholder="Email" value="<?= $result->am_email ?>" readonly>
                                                            </p>
                                                        </div>

                                                        <!-- Emergency Contact -->
                                                        <div>
                                                            <label for="">Emergency Contact number of the Center</label>
                                                            <p>
                                                                <input type="number" placeholder="Phone number" value="<?= $result->emergency_contact_no ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <input type="number" placeholder="Landline number" value="<?= $result->landline_number ?>" readonly>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#infraDetails">
                                            Infrastructure details
                                        </button>
                                    </h2>
                                    <div id="infraDetails" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">
                                            <div class="row ">
                                                <div class="col-md-5 m-auto py-2 w-100 bg-white">
                                                    <div class="center-details-form">
                                                        <div class="mb-5">
                                                            <p>General Lab details</p>

                                                            <label>Total number of labs</label><br>
                                                            <p>
                                                                <input type="text" readonly placeholder="..." value="<?= $result->total_no_lab ?>">
                                                            </p>

                                                            <label>Total number of systems</label><br>
                                                            <p>
                                                                <input type="text" readonly placeholder="..." value="<?= $result->total_no_system ?>">
                                                            </p>

                                                            <label>Are all labs connected through a single network?</label><br>
                                                            <p>
                                                                <select name="lab_are_connect_to_single_network" class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->connected_single_network == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->connected_single_network == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Total networks</label><br>
                                                            <p>
                                                                <input type="number" readonly placeholder="..." value="<?= $result->how_many_network ?>">
                                                            </p>

                                                            <label>Is There a Partition in each System</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->partitaion_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->partitaion_each_lab == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is there an AC in each lab?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->ac_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->ac_in_each_lab == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is the Network Printer available?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->network_printer == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->network_printer == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is there a projector in each lab?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->is_there_projector_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->projector_sound_system == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is there a sound system in each lab?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->is_there_sound_sytem_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->projector_sound_system == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is there Fire Extinguisher in each lab?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->how_many_fire_extinguisher_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->fire_extinguisher == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is there a Free Baggage Space ?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->locker_facility == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->locker_facility == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>

                                                            <label>Is there a drinking water facility in/near the labs?</label><br>
                                                            <p>
                                                                <select class="network-option border" disabled>
                                                                    <option value="yes" <?= ($result->drinking_water_facility == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                                    <option value="no" <?= ($result->drinking_water_facility == 'no') ? 'selected' : '' ?>>No</option>
                                                                </select>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>Lab Infrastructure details</p>

                                                            <label>Name of the Primary ISP</label>
                                                            <input type="text" readonly value="<?= $result->primary_isp_name ?>">

                                                            <p class="mt-3">
                                                                <label>Primary ISP Connection Type</label>
                                                                <select disabled class="form-select">
                                                                    <option value="">Select</option>
                                                                    <option <?= ($result->primary_isp_connect_type == 'broadband') ? 'selected' : '' ?> value="broadband">Broadband</option>
                                                                    <option <?= ($result->primary_isp_connect_type == 'lease_line') ? 'selected' : '' ?> value="lease_line">Lease line</option>
                                                                    <option <?= ($result->primary_isp_connect_type == 'fibre_optics') ? 'selected' : '' ?> value="fibre_optics">Fibre Optics</option>
                                                                    <option <?= ($result->primary_isp_connect_type == 'air_fibre') ? 'selected' : '' ?> value="air_fibre">Air Fibre</option>
                                                                </select>
                                                            </p>

                                                            <label>Primary Internet speed</label>
                                                            <input type="text" readonly value="<?= $result->primary_isp_speed ?> / <?= $result->primary_internet_speed_unit ?>">

                                                            <label>Name of the Secondary ISP</label>
                                                            <input type="text" readonly value="<?= $result->secondary_isp_name ?>">


                                                            <p class="mt-3"><label>Secondary ISP Connection Type</label>
                                                                <select disabled class="form-select">
                                                                    <option value="">Select</option>
                                                                    <option <?= ($result->secondary_isp_connect_type == 'broadband') ? 'selected' : '' ?> value="broadband">Broadband</option>
                                                                    <option <?= ($result->secondary_isp_connect_type == 'lease_line') ? 'selected' : '' ?> value="lease_line">Lease line</option>
                                                                    <option <?= ($result->secondary_isp_connect_type == 'fibre_optics') ? 'selected' : '' ?> value="fibre_optics">Fibre Optics</option>
                                                                    <option <?= ($result->secondary_isp_connect_type == 'air_fibre') ? 'selected' : '' ?> value="air_fibre">Air Fibre</option>
                                                                </select>
                                                            </p>

                                                            <label>Secondary ISP speed</label>
                                                            <input type="text" readonly placeholder="..." value="<?= $result->secondary_isp_speed ?> / <?= $result->secondary_internet_speed_unit ?>">

                                                            <p>
                                                                <label for="">Generator Available</label><br>
                                                                <select class="form-control p-10 form-select">
                                                                    <option value="">Select</option>
                                                                    <option <?= ($result->is_generator_backup == 'yes') ? 'selected' : '' ?> value="yes">Yes</option>
                                                                    <option <?= ($result->is_generator_backup == 'no') ? 'selected' : '' ?> value="no">No</option>
                                                                </select>
                                                            </p>
                                                            <?php
                                                            if ($result->is_generator_backup == 'yes') { ?>
                                                                <p>
                                                                    <label for="">Generator Capacity (in KVA)</label>
                                                                    <input type="text" value="<?= $result->generator_backup_capacity ?>" class="form-control p-10">

                                                                    <label for="generator-fuel-tank-capacity">Generator Fuel Tank Capacity (in Ltr.)</label>
                                                                    <select class="form-control p-10 form-select">
                                                                        <option value="">Select Capacity</option>
                                                                        <?php
                                                                        for ($ltr = 1; $ltr <= 500; $ltr += 0.5) {
                                                                        ?>
                                                                            <option <?= ($result->generator_fuel_tank_capacity == $ltr) ? 'selected' : '' ?> value="<?= $ltr ?>"><?= $ltr ?> ltr</option>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </p>
                                                            <?php } ?>

                                                            <p>
                                                                <label for="">UPS Backup (KVA)</label>
                                                                <input type="text" value="<?= $result->power_back_ups_kv ?>" class="form-control p-10">

                                                                <label for="ups-time">UPS Backup Time (in mins)</label>
                                                                <select name="ups_backup_time" id="ups-time" class="form-control p-10 form-select">
                                                                    <option value="">Select time</option>
                                                                    <?php
                                                                    for ($mins = 5; $mins <= 480; $mins += 5) {
                                                                    ?>
                                                                        <option <?= ($result->ups_backup_time == $mins) ? 'selected' : '' ?> value="<?= $mins ?>"><?= $mins ?> mins</option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </p>

                                                            <p>Lab details</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div id="">
                                                            <?php if (!empty($labs)) {
                                                                foreach ($labs as $index => $lab) { ?>
                                                                    <div class="mt-3 newLabWrapperChange">
                                                                        <span class="bg-dark text-white p-2 rounded-top lab-number">Lab number <?= $index + 1 ?></span>
                                                                        <div class="lab-details-wrapper p-4 rounded bg-white mt-2">
                                                                            <p>
                                                                                <label>Floor number</label>
                                                                                <select class="form-control" disabled>

                                                                                    <option value="basement"
                                                                                        <?= ($lab['floor_name'] === 'basement') ? 'selected' : '' ?>>
                                                                                        Basement
                                                                                    </option>

                                                                                    <option value="0"
                                                                                        <?= ((string)$lab['floor_name'] === '0') ? 'selected' : '' ?>>
                                                                                        Ground
                                                                                    </option>

                                                                                    <?php for ($i = 1; $i <= 30; $i++) { ?>
                                                                                        <option value="<?= $i ?>"
                                                                                            <?= ((string)$lab['floor_name'] === (string)$i) ? 'selected' : '' ?>>
                                                                                            <?= $i ?>
                                                                                        </option>
                                                                                    <?php } ?>

                                                                                </select>
                                                                            </p>
                                                                            <p><label>Total number of computers?</label>
                                                                                <input type="text" class="form-control" value="<?= $lab['no_of_computer'] ?>">
                                                                            </p>
                                                                            <p><label>System Processer</label>
                                                                                <select disabled class="form-select">
                                                                                    <option value="">Select</option>
                                                                                    <option <?= ($lab['window_generation'] == 'Core 2 Duo') ? 'selected' : '' ?> value="Core 2 Duo">Core 2 Duo</option>
                                                                                    <option <?= ($lab['window_generation'] == 'i3') ? 'selected' : '' ?> value="i3">i3</option>
                                                                                    <option <?= ($lab['window_generation'] == 'i5') ? 'selected' : '' ?> value="i5">i5</option>
                                                                                    <option <?= ($lab['window_generation'] == 'i7') ? 'selected' : '' ?> value="i7">i7</option>
                                                                                </select>
                                                                            </p>
                                                                            <p><label>Monitor type</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="LCD" <?= $lab['monitor_type'] == 'LCD' ? 'selected' : '' ?>>LCD</option>
                                                                                    <option value="LED" <?= $lab['monitor_type'] == 'LED' ? 'selected' : '' ?>>LED</option>
                                                                                </select>
                                                                            </p>
                                                                            <p><label>Operating system</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="Win 7" <?= $lab['operating_system'] == 'Win 7' ? 'selected' : '' ?>>Win 7</option>
                                                                                    <option value="Win 8" <?= $lab['operating_system'] == 'Win 8' ? 'selected' : '' ?>>Win 8</option>
                                                                                    <option value="Win 10" <?= $lab['operating_system'] == 'Win 10' ? 'selected' : '' ?>>Win 10</option>
                                                                                    <option value="Win 11" <?= $lab['operating_system'] == 'Win 11' ? 'selected' : '' ?>>Win 11</option>
                                                                                    <option value="Linux" <?= $lab['operating_system'] == 'Linux' ? 'selected' : '' ?>>Linux</option>
                                                                                    <option value="MacOS" <?= $lab['operating_system'] == 'MacOS' ? 'selected' : '' ?>>MacOS</option>
                                                                                </select>
                                                                            </p>
                                                                            <p><label>RAM (in GB)</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="2GB" <?= $lab['ram'] == '2GB' ? 'selected' : '' ?>>2GB</option>
                                                                                    <option value="4GB" <?= $lab['ram'] == '4GB' ? 'selected' : '' ?>>4GB</option>
                                                                                    <option value="8GB" <?= $lab['ram'] == '8GB' ? 'selected' : '' ?>>8GB</option>
                                                                                    <option value="16GB" <?= $lab['ram'] == '16GB' ? 'selected' : '' ?>>16GB</option>
                                                                                    <option value="32GB" <?= $lab['ram'] == '32GB' ? 'selected' : '' ?>>32GB</option>
                                                                                </select>
                                                                            </p>
                                                                            <p><label>Hard Disk Drive capacity (in GB)</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="80GB" <?= $lab['hard_disk'] == '80GB' ? 'selected' : '' ?>>80GB</option>
                                                                                    <option value="128GB" <?= $lab['hard_disk'] == '128GB' ? 'selected' : '' ?>>128GB</option>
                                                                                    <option value="160GB" <?= $lab['hard_disk'] == '160GB' ? 'selected' : '' ?>>160GB</option>
                                                                                    <option value="256GB" <?= $lab['hard_disk'] == '256GB' ? 'selected' : '' ?>>256GB</option>
                                                                                    <option value="320GB" <?= $lab['hard_disk'] == '320GB' ? 'selected' : '' ?>>320GB</option>
                                                                                    <option value="500GB" <?= $lab['hard_disk'] == '500GB' ? 'selected' : '' ?>>500GB</option>
                                                                                    <option value="1TB" <?= $lab['hard_disk'] == '1TB' ? 'selected' : '' ?>>1TB</option>
                                                                                    <option value="1.5TB" <?= $lab['hard_disk'] == '1.5TB' ? 'selected' : '' ?>>1.5TB</option>
                                                                                    <option value="2TB" <?= $lab['hard_disk'] == '2TB' ? 'selected' : '' ?>>2TB</option>
                                                                                    <option value="4TB" <?= $lab['hard_disk'] == '4TB' ? 'selected' : '' ?>>4TB</option>
                                                                                </select>
                                                                            </p>
                                                                            <p><label>Ethernet Switch’s company</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="Cisco" <?= $lab['ehternet_swtch_company'] == 'Cisco' ? 'selected' : '' ?>>Cisco</option>
                                                                                    <option value="Netgear" <?= $lab['ehternet_swtch_company'] == 'Netgear' ? 'selected' : '' ?>>Netgear</option>
                                                                                    <option value="D-Link" <?= $lab['ehternet_swtch_company'] == 'D-Link' ? 'selected' : '' ?>>D-Link</option>
                                                                                    <option value="TP-Link" <?= $lab['ehternet_swtch_company'] == 'TP-Link' ? 'selected' : '' ?>>TP-Link</option>
                                                                                    <option value="Dex" <?= $lab['ehternet_swtch_company'] == 'Dex' ? 'selected' : '' ?>>Dex</option>
                                                                                    <option value="other" <?= $lab['ehternet_swtch_company'] == 'other' ? 'selected' : '' ?>>Other</option>
                                                                                </select>
                                                                                <?php
                                                                                if ($lab['ehternet_swtch_company'] == 'other') { ?>
                                                                                    <input class="form-control mt-2" readonly value="<?= $lab['ethernet_company_other'] ?>">
                                                                                <?php }
                                                                                ?>
                                                                            </p>
                                                                            <p><label>Switch’s Category</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="unmanaged" <?= $lab['switch_category'] == 'unmanaged' ? 'selected' : '' ?>>unmanaged</option>
                                                                                    <option value="smart" <?= $lab['switch_category'] == 'smart' ? 'selected' : '' ?>>smart</option>
                                                                                    <option value="managedL2" <?= $lab['switch_category'] == 'managedL2' ? 'selected' : '' ?>>managed L2</option>
                                                                                    <option value="managedL3" <?= $lab['switch_category'] == 'managedL3' ? 'selected' : '' ?>>managed L3</option>
                                                                                </select>
                                                                            </p>
                                                                            <p><label>No. of ports of each Ethernet switch?</label>
                                                                                <select class="form-select" disabled>
                                                                                    <option value="8" <?= $lab['no_of_port_eth_switch'] == '8' ? 'selected' : '' ?>>8</option>
                                                                                    <option value="16" <?= $lab['no_of_port_eth_switch'] == '16' ? 'selected' : '' ?>>16</option>
                                                                                    <option value="24" <?= $lab['no_of_port_eth_switch'] == '24' ? 'selected' : '' ?>>24</option>
                                                                                    <option value="48" <?= $lab['no_of_port_eth_switch'] == '48' ? 'selected' : '' ?>>48</option>
                                                                                </select>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#bankDetails">
                                            Bank details
                                        </button>
                                    </h2>
                                    <div id="bankDetails" class="accordion-collapse collapse" data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-5 m-auto py-2 w-100 bg-white">
                                                    <div class="center-details-form">
                                                        <div>
                                                            <p>
                                                                <label for="">Beneficiary name</label><br>
                                                                <input type="text"
                                                                    value="<?= isset($result->beneficiary_name) ? $result->beneficiary_name : '' ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <label for="">Name of the bank</label><br>
                                                                <input type="text" placeholder="..."
                                                                    value="<?= isset($result->bank_name) ? $result->bank_name : '' ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <label for="">Bank Account number</label><br>
                                                                <input type="text" placeholder="..."
                                                                    value="<?= isset($result->bank_account_number) ? $result->bank_account_number : '' ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <label for="">Bank IFSC code</label><br>
                                                                <input type="text" placeholder="..."
                                                                    value="<?= isset($result->bank_ifsc_code) ? $result->bank_ifsc_code : '' ?>" readonly>
                                                            </p>
                                                            <p>
                                                                <label for="">PAN Number</label><br>
                                                                <input type="text" placeholder="..."
                                                                    value="<?= isset($result->pan_no) ? $result->pan_no : '' ?>" readonly>
                                                            </p>
                                                            <!-- GST Section -->
                                                            <p>
                                                                <label>Do you have a GST number?</label><br>
                                                                <input readonly type="radio" value="yes" <?= ($result->has_gst == 'yes') ? 'checked' : '' ?>> Yes
                                                                <input readonly type="radio" value="no" <?= ($result->has_gst == 'no') ? 'checked' : '' ?>> No
                                                            </p>
                                                            <?php
                                                            if ($result->has_gst == 'yes') { ?>
                                                                <p>
                                                                    <label for="">GST number</label><br>
                                                                    <input type="text" placeholder="..."
                                                                        value="<?= isset($result->gst_no) ? $result->gst_no : '' ?>" readonly>
                                                                </p>
                                                                <p>
                                                                <div class="row">
                                                                    <div class="col-md-4 mb-3">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                Upload GST Document
                                                                            </div>
                                                                            <div class="card-body text-center">
                                                                                <?php
                                                                                if (isset($result->gst_file) && $result->gst_file != '') { ?>
                                                                                    <iframe src="<?= base_url($result->gst_file) ?>" width="100%" height="300px"></iframe>
                                                                                <?php } else { ?>
                                                                                    <p>No file uploaded</p>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </p>
                                                                <p class="m-0">
                                                                    <label for="">GST State code</label><br>
                                                                <div class="gst-state-code-wrapper">
                                                                    <input type="text" placeholder="..." class="border-top"
                                                                        value="<?= isset($result->gst_state_code) ? $result->gst_state_code : '' ?>" readonly>
                                                                    <p class="m-0 px-2">
                                                                        Here’s a <a href="https://www.iifl.com/blogs/business-loan/gst-code-list-and-jurisdiction"
                                                                            target="_blank">link</a> to find your GST code:
                                                                    </p>
                                                                </div>
                                                                </p>
                                                            <?php } ?>
                                                            <p>
                                                                <label for="">UIDAI Number</label>
                                                                <input type="text" placeholder="Enter UIDAI Number" value="<?= $result->uidai_number ?>" readonly>
                                                            </p>

                                                            <!-- MSME Section -->
                                                            <p>
                                                                <label>Do you have an MSME number?</label><br>
                                                                <input readonly type="radio" value="yes" <?= ($result->has_msme == 'yes') ? 'checked' : '' ?>> Yes
                                                                <input readonly type="radio" value="no" <?= ($result->has_msme == 'no') ? 'checked' : '' ?>> No
                                                            </p>

                                                            <?php
                                                            if ($result->has_msme == 'yes') { ?>
                                                                <p>
                                                                    <label for="">MSME Number</label>
                                                                    <input type="text" placeholder="Enter MSME Number" value="<?= $result->msme_number ?>" readonly>
                                                                </p>
                                                            <?php } ?>
                                                            <h4>Uploaded Documents</h4>
                                                            <div class="row">
                                                                <?php foreach ($documents as $doc): ?>

                                                                    <?php
                                                                    // strict checks
                                                                    if (
                                                                        !isset($doc['url']) ||
                                                                        trim($doc['url']) === '' ||
                                                                        !pathinfo($doc['url'], PATHINFO_FILENAME)
                                                                    ) {
                                                                        continue; // skip this document safely
                                                                    }

                                                                    $fileExtension = strtolower(pathinfo($doc['url'], PATHINFO_EXTENSION));
                                                                    $fileUrl       = base_url($doc['url']);
                                                                    ?>

                                                                    <div class="col-md-4 mb-3">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <?= ucfirst(str_replace('_', ' ', $doc['doc_name'])) ?>
                                                                            </div>

                                                                            <div class="card-body text-center">
                                                                                <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>

                                                                                    <img src="<?= $fileUrl ?>"
                                                                                        alt="<?= $doc['doc_name'] ?>"
                                                                                        class="img-fluid"
                                                                                        style="max-height: 200px;">

                                                                                <?php elseif ($fileExtension === 'pdf'): ?>

                                                                                    <iframe src="<?= $fileUrl ?>"
                                                                                        width="100%"
                                                                                        height="300px"></iframe>

                                                                                <?php else: ?>

                                                                                    <a href="<?= $fileUrl ?>" target="_blank">
                                                                                        Download <?= strtoupper($fileExtension) ?> file
                                                                                    </a>

                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-center-wrapper" id="edit-center">
        <div class="container py-4">
            <form id="examCenterEditForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card border position-sticky top-0">
                            <div class="mb-3">
                                <div id="center-logo-preview" class="preview-container">
                                    <?php
                                    if (
                                        isset($result->logo) &&
                                        trim($result->logo) !== '' &&
                                        pathinfo($result->logo, PATHINFO_FILENAME)
                                    ):
                                    ?>
                                        <img src="<?= base_url($result->logo); ?>"
                                            alt="Center Logo"
                                            style="height: 100px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="upload-group">
                                <label class="mb-0">Upload Center Logo</label>
                                <div class="custom-file-upload">
                                    <label for="center-logo-upload" class="upload-btn">
                                        <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                    </label>
                                    <input type="file" id="center-logo-upload"
                                        name="center_logo[]"
                                        multiple
                                        accept="image/jpeg, image/png, image/jpg"
                                        onchange="previewFiles(event, 'center-logo-preview')">
                                    <div class="state_line"></div>
                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <lable class="mb-3 fw-bold">Center description</lable>
                                <p class="">
                                    <textarea name="center_description" id="" class=" form-control text-start w-100 border rounded p-2"
                                        rows="5" cols="50"><?= $result->center_description ?>
                                </textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="image-accordian-wrapper">
                            <div class="card bg-transparent">
                                <input type="hidden" id="examCenterEditFormUrl" value="<?php echo base_url('update-exam-center-data') ?>">
                                <input type="hidden" value="<?= base_url() ?>" class="base_url">
                                <h5 class="mb-3">Center details</h5>
                                <div class="row">
                                    <div class="col-md-5 m-auto p-4 w-100 bg-white rounded border">
                                        <div class="center-details-form">
                                            <p>
                                                <label for="">What is the Center
                                                    name?</label><br>
                                                <input type="text" name="center_name" value="<?= $result->center_name ?>">
                                            </p>
                                            <p>
                                                <label for="">What is the center’s Postal Address?</label><br>
                                                <input type="text" name="address" value="<?= $result->address ?>">
                                            </p>
                                            <p>
                                            <div class="">
                                                <label for="">Center Type</label>
                                                <select class="form-control form-select p-10" name="center_type">
                                                    <option <?= $result->center_type == 'online' ? 'selected' : '' ?> value="online">Online</option>
                                                </select>
                                            </div>
                                            </p>
                                            <p>
                                            <div class="mt-3">
                                                <lable class="fw-bold">Center's Latitude</lable>
                                                <p class="">
                                                    <input type="text" placeholder="Latitude" name="address_lat" id="address_lat" class="border rounded w-100 px-3 py-2" value="<?= $result->address_lat ?>">
                                                </p>
                                            </div>
                                            </p>
                                            <p>
                                            <div class="mt-3">
                                                <lable class="fw-bold">Center's Longitude</lable>
                                                <p class="">
                                                    <input type="text" placeholder="Longitude" name="address_long" id="address_long" class="border rounded w-100 px-3 py-2" value="<?= $result->address_long ?>">
                                                </p>
                                            </div>
                                            </p>
                                            <button type="button" id="getLocationBtn" class="btn mt-2 mb-5 text-white sign-up-btn">
                                                📍 Get Current Location
                                            </button>
                                            <button type="button" id="checkLocationBtn" class="btn mt-2 mb-5 text-white sign-up-btn">
                                                <img src="https://static.vecteezy.com/system/resources/previews/017/396/764/non_2x/google-maps-icon-free-png.png" style="height: 20px;width: 20px;"> Get Latitude and Longitude By Map
                                            </button>

                                            <div id="locationStatus" style="display: none; color: green; margin-bottom: 15px;">
                                                Location retrieved successfully!
                                            </div>
                                            <!-- Center Entrance -->
                                            <div class="upload-group">
                                                <label class="mb-0">Upload Center Entrance</label>
                                                <div class="custom-file-upload">
                                                    <label for="center-entrances-upload" class="upload-btn">
                                                        <i class="fa-solid fa-file-arrow-up"></i>Upload File
                                                    </label>
                                                    <input type="file" id="center-entrances-upload"
                                                        name="center_entrances[]"
                                                        multiple
                                                        accept="image/jpeg, image/png, image/jpg"
                                                        onchange="previewFiles(event, 'center-entrances-preview')">
                                                    <div class="state_line"></div>
                                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
                                                </div>
                                                <div id="center-entrances-preview" class="preview-container"></div>
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
                                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
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
                                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
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
                                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
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
                                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
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
                                                    <span class="note">Max Each file size: 1 MB<br>File type: jpg, png, jpeg</span>
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
                                                        name="walkthrough_video[]"
                                                        accept="video/mp4, video/webm"
                                                        onchange="previewFiles(event, 'walkthrough-video-preview')">
                                                    <div class="state_line"></div>
                                                    <span class="note">Max file size: 5 MB<br>File type: mp4, webm</span>
                                                </div>
                                                <div id="walkthrough-video-preview" class="preview-container"></div>
                                            </div>
                                            <p>
                                            <div class="row">
                                                <label for="">Where is your Center located?</label><br>
                                                <div class="col-6 mb-3">
                                                    <select class="form-control select2" name="country_id" onchange="fetchStateByCountryId(this.value)">
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($countries as $row): ?>
                                                            <option value="<?= $row['id'] ?>" <?= ($result->country_id == $row['id']) ? 'selected' : '' ?>>
                                                                <?= $row['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <select class="form-control state_selection select2" name="state_id" onchange="fetchCityByStateId(this.value)">
                                                        <option value="">Select State</option>
                                                        <?php if (!empty($result->country_id)) :
                                                            $states = $this->Common_model->getdata_array('tt_states', ['country_id' => $result->country_id]);
                                                            foreach ($states as $state): ?>
                                                                <option value="<?= $state['id'] ?>" <?= ($result->state_id == $state['id']) ? 'selected' : '' ?>>
                                                                    <?= $state['title'] ?>
                                                                </option>
                                                        <?php endforeach;
                                                        endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <select class="form-control city_selection select2" name="city_id">
                                                        <option value="">Select City</option>
                                                        <?php if (!empty($result->state_id)) :
                                                            $cities = $this->Common_model->getdata_array('tt_city_master', ['state_id' => $result->state_id]);
                                                            foreach ($cities as $city): ?>
                                                                <option value="<?= $city['city_id'] ?>" <?= ($result->city_id == $city['city_id']) ? 'selected' : '' ?>>
                                                                    <?= $city['city_name'] ?>
                                                                </option>
                                                        <?php endforeach;
                                                        endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <input type="text" placeholder="Local Area Name" name="local_area_name" value="<?= $result->local_area_name ?>">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" placeholder="Pin Code" name="pin_code" value="<?= $result->pin_code ?>">
                                                </div>
                                            </div>
                                            </p>
                                            <p>
                                            <div class="row">
                                                <label for="">What is the Category of your Test Center?</label>
                                                <div class="col-12 mb-3">
                                                    <select class="form-control" name="type_of_center">
                                                        <option value="">Select Center Type</option>
                                                        <?php foreach ($center_type as $row): ?>
                                                            <option value="<?= $row['center_type'] ?>" <?= ($result->type_of_center == $row['center_type']) ? 'selected' : '' ?>>
                                                                <?= $row['center_type'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            </p>
                                            <p>
                                                <label for="">Any nearby
                                                    Landmark</label>
                                            <div class="gst-state-code-wrapper">
                                                <input type="text" placeholder="Ex: Lal Bahadur Metro Station" name="landmark" value="<?= $result->landmark ?>">
                                                <p class="m-0 px-2">Could be a Metro or Police station, a building etc.</p>
                                            </div>
                                            </p>
                                            <p>
                                            <div class="row">
                                                <label for="">Is the Lift available for Physically Handicapped Candidate?</label>

                                                <div class="col-6">
                                                    <div class="radio-container">
                                                        <label>
                                                            <input type="radio" name="for_ph_candidate" value="yes"
                                                                <?= ($result->for_ph_candidate == 'yes') ? 'checked' : '' ?>> Yes
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="radio-container">
                                                        <label>
                                                            <input type="radio" name="for_ph_candidate" value="no"
                                                                <?= ($result->for_ph_candidate == 'no') ? 'checked' : '' ?>> No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            </p>
                                            <p>
                                                <label for="nearest_railway_station">Name of Railway Station</label>
                                                <input type="text" id="nearest_railway_station" name="nearest_railway_station" value="<?= $result->nearest_railway_station ?? '' ?>" placeholder="Enter station name">
                                            </p>
                                            <p>
                                                <label for="">Distance from the main Railway Station</label>
                                                <select id="distance_from_railway_station" name="distance_from_railway_station"
                                                    class="form-control p-10 form-select" data-selected="<?= $result->distance_from_station ?? '' ?>">
                                                    <option value="">Select distance</option>
                                                </select>
                                            </p>
                                            <p>
                                                <label for="nearest_bus_stop">Name of Bus Station</label>
                                                <input type="text" id="nearest_bus_stop" name="nearest_bus_stop" value="<?= $result->nearest_bus_stop ?? '' ?>" placeholder="Enter station name">
                                            </p>

                                            <p>
                                                <label for="">Distance from the nearby Bus Station</label>
                                                <select id="distance_from_bus_stop" name="distance_from_bus_stop" class="form-control p-10 form-select" data-selected="<?= $result->distance_from_bus_stop ?? '' ?>">
                                                    <option value="">Select distance</option>
                                                </select>
                                            </p>

                                            <p>
                                                <label for="nearest_metro_station">Name of Metro Station</label>
                                                <input type="text" id="nearest_metro_station" name="nearest_metro_station" value="<?= $result->nearest_metro_station ?? '' ?>" placeholder="Enter Metro Station Name">
                                            </p>

                                            <p>
                                                <label for="">Distance from the main Metro Station</label>
                                                <select id="distance_from_metro_station" name="distance_from_metro_station" class="form-control p-10 form-select" data-selected="<?= $result->distance_from_metro ?? '' ?>">
                                                    <option value="">Select distance</option>
                                                </select>
                                            </p>
                                            <p>
                                                <label for="nearest_airport">Name of Airport</label>
                                                <input type="text" id="nearest_airport" name="nearest_airport" value="<?= $result->nearest_airport ?? '' ?>" placeholder="Enter Airport Name">
                                            </p>
                                            <p>
                                                <label for="">Distance from the main Airport</label>
                                                <select id="distance_from_airport" name="distance_from_airport" class="form-control p-10 form-select" data-selected="<?= $result->distance_from_airport ?? '' ?>">
                                                    <option value="">Select distance</option>
                                                </select>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-3 mt-4">Admin details</h5>
                                <div class="row">
                                    <div class="col-md-5 m-auto p-4 w-100 bg-white rounded border">
                                        <div class="center-details-form">
                                            <!-- Point of Contact -->
                                            <div>
                                                <label for="">Point of Contact</label><br>
                                                <p>
                                                    <input type="text" placeholder="Name" name="poc_name" value="<?= $result->poc_name ?>">
                                                </p>
                                                <p>
                                                    <input type="number" placeholder="Phone number" name="poc_contact_no" value="<?= $result->poc_contact_no ?>">
                                                </p>
                                                <p>
                                                    <input type="number" placeholder="Alternate Phone number" name="poc_mobile_alternate" value="<?= $result->poc_mobile_alternate ?>">
                                                </p>
                                                <p>
                                                    <input type="email" placeholder="Email" name="poc_email" value="<?= $result->poc_email ?>">
                                                </p>
                                            </div>
                                            <!-- Center Superintendent -->
                                            <div>
                                                <label for="">Center Superintendent details</label>
                                                <p>
                                                    <input type="text" placeholder="Name" name="cs_name" value="<?= $result->cs_name ?>">
                                                </p>
                                                <p>
                                                    <input type="number" placeholder="Phone number" name="cs_contact_number" value="<?= $result->cs_contact_number ?>">
                                                </p>
                                                <p>
                                                    <input type="email" placeholder="Email" name="cs_email" value="<?= $result->cs_email ?>">
                                                </p>
                                            </div>

                                            <!-- Assistant Manager -->
                                            <div>
                                                <label for="">IT Manager details</label>
                                                <p>
                                                    <input type="text" placeholder="Name" name="am_name" value="<?= $result->am_name ?>">
                                                </p>
                                                <p>
                                                    <input type="text" placeholder="Phone number" name="am_contact_no" value="<?= $result->am_contact_no ?>">
                                                </p>
                                                <p>
                                                    <input type="email" placeholder="Email" name="am_email" value="<?= $result->am_email ?>">
                                                </p>
                                            </div>

                                            <!-- Emergency Contact -->
                                            <div>
                                                <label for="">Emergency Contact number of the Center</label>
                                                <p>
                                                    <input type="number" placeholder="Phone number" name="emergency_contact_no" value="<?= $result->emergency_contact_no ?>">
                                                </p>
                                                <p>
                                                    <input type="number" placeholder="Landline number" name="landline_number" value="<?= $result->landline_number ?>">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-3 mt-4">Infrastructure details</h5>
                                <div class="row ">
                                    <div class="col-md-5 m-auto p-4 w-100 bg-white rounded border">
                                        <div class="center-details-form">
                                            <div class="mb-5">
                                                <p>General Lab details</p>

                                                <!-- Total number of labs -->
                                                <label for="">Total number of labs</label><br>
                                                <p>
                                                    <input type="number" placeholder="..." value="<?= $result->total_no_lab ?>" id="edit_total_number_of_lab" name="total_no_lab">
                                                </p>

                                                <!-- Total number of systems -->
                                                <label for="">Total number of systems</label><br>
                                                <p>
                                                    <input type="text" placeholder="..." name="total_no_system" value="<?= $result->total_no_system ?>">
                                                </p>

                                                <!-- Are all labs connected through a single network? -->
                                                <label for="">Are all labs connected through a single network?</label><br>
                                                <p>
                                                    <select name="connected_single_network" id="single-network" class="network-option border">
                                                        <option value="yes" <?= ($result->connected_single_network == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->connected_single_network == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Total networks -->
                                                <label for="">Total networks</label><br>
                                                <p>
                                                    <input type="number" placeholder="..." name="how_many_network" id="total-networks" value="<?= $result->how_many_network ?>" min="1">
                                                </p>

                                                <!-- Is there a partition in each lab? -->
                                                <label for="">Is there a partition in each lab?</label><br>
                                                <p>
                                                    <select name="partitaion_each_lab" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->partitaion_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->partitaion_each_lab == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Is there an AC in each lab? -->
                                                <label for="">Is there an AC in each lab?</label><br>
                                                <p>
                                                    <select name="ac_in_each_lab" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->ac_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->ac_in_each_lab == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Is the Network Printer available? -->
                                                <label for="">Is the Network Printer available?</label><br>
                                                <p>
                                                    <select name="network_printer" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->network_printer == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->network_printer == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Is there a projector in each lab? -->
                                                <label for="">Is there a projector in each lab?</label><br>
                                                <p>
                                                    <select name="is_there_projector_in_each_lab" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->is_there_projector_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->is_there_projector_in_each_lab == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Is there a sound system in each lab? -->
                                                <label for="">Is there a sound system in each lab?</label><br>
                                                <p>
                                                    <select name="is_there_sound_sytem_in_each_lab" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->is_there_sound_sytem_in_each_lab == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->is_there_sound_sytem_in_each_lab == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Is there Fire Extinguisher in each lab? -->
                                                <label for="">How Many Fire Extinguishers in Each Lab</label><br>
                                                <p>
                                                    <select id="" class="network-option p-10 form-select" name="how_many_fire_extinguisher_in_each_lab">
                                                        <option value="">Select</option>
                                                        <?php
                                                        for ($i = 1; $i <= 10; $i++) { ?>
                                                            <option value="<?= $i ?>" <?= ($i == $result->how_many_fire_extinguisher_in_each_lab) ? 'selected' : ''; ?>>
                                                                <?= $i ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </p>

                                                <!-- Is there a locker facility in the labs? -->
                                                <label for="">Is there a Free Baggage Space ?</label><br>
                                                <p>
                                                    <select name="locker_facility" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->locker_facility == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->locker_facility == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Is there a drinking water facility in/near the labs? -->
                                                <label for="">Is there a drinking water facility in/near the labs?</label><br>
                                                <p>
                                                    <select name="drinking_water_facility" id="" class="network-option border">
                                                        <option value="yes" <?= ($result->drinking_water_facility == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->drinking_water_facility == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>
                                            </div>

                                            <div>
                                                <p>Lab Infrastructure details</p>

                                                <!-- Name of the Primary ISP -->
                                                <label for="">Name of the Primary ISP</label>
                                                <input type="text" placeholder="..." name="primary_isp_name" value="<?= $result->primary_isp_name ?>">

                                                <p><label>Primary ISP Connection Type</label>
                                                    <select name="primary_isp_connect_type" class="form-select">
                                                        <option value="">Select</option>
                                                        <option <?= $result->primary_isp_connect_type == 'broadband' ? 'selected' : ''; ?> value="broadband">Broadband</option>
                                                        <option <?= $result->primary_isp_connect_type == 'lease_line' ? 'selected' : ''; ?> value="lease_line">Lease line</option>
                                                        <option <?= $result->primary_isp_connect_type == 'fibre_optics' ? 'selected' : ''; ?> value="fibre_optics">Fibre Optics</option>
                                                        <option <?= ($result->primary_isp_connect_type == 'air_fibre') ? 'selected' : '' ?> value="air_fibre">Air Fibre</option>
                                                    </select>
                                                </p>

                                                <!-- Primary Internet speed -->
                                                <label for="">Primary Internet Speed</label>
                                                <div style="display: flex; gap: 10px;">
                                                    <input type="text" placeholder="Enter speed" name="primary_isp_speed" style="flex: 1;" value="<?= $result->primary_isp_speed ?>">
                                                    <select name="primary_internet_speed_unit">
                                                        <option <?= $result->primary_internet_speed_unit == 'Mbps' ? 'selected' : ''; ?> value="Mbps">Mbps</option>
                                                        <option <?= $result->primary_internet_speed_unit == '' ? 'selected' : 'Gbps'; ?> value="Gbps">Gbps</option>
                                                    </select>
                                                </div>
                                                <p></p>
                                                <!-- Name of the Secondary ISP -->
                                                <label for="">Name of the Secondary ISP</label>
                                                <input type="text" placeholder="..." name="secondary_isp_name" value="<?= $result->secondary_isp_name ?>">
                                                <p><label>Secondary ISP Connection Type</label>
                                                    <select name="secondary_isp_connect_type" class="form-select">
                                                        <option value="">Select</option>
                                                        <option <?= $result->secondary_isp_connect_type == 'broadband' ? 'selected' : ''; ?> value="broadband">Broadband</option>
                                                        <option <?= $result->secondary_isp_connect_type == 'lease_line' ? 'selected' : ''; ?> value="lease_line">Lease line</option>
                                                        <option <?= $result->secondary_isp_connect_type == 'fibre_optics' ? 'selected' : ''; ?> value="fibre_optics">Fibre Optics</option>
                                                        <option <?= ($result->secondary_isp_connect_type == 'air_fibre') ? 'selected' : '' ?> value="air_fibre">Air Fibre</option>
                                                    </select>
                                                </p>

                                                <!-- Secondary ISP speed -->
                                                <label for="">Secondary ISP Speed</label>
                                                <div style="display: flex; gap: 10px;">
                                                    <input type="text" placeholder="Enter speed" name="secondary_isp_speed" style="flex: 1;" value="<?= $result->secondary_isp_speed ?>">
                                                    <select name="secondary_internet_speed_unit">
                                                        <option <?= $result->secondary_internet_speed_unit == 'Mbps' ? 'selected' : ''; ?> value="Mbps">Mbps</option>
                                                        <option <?= $result->secondary_internet_speed_unit == 'Gbps' ? 'selected' : ''; ?> value="Gbps">Gbps</option>
                                                    </select>
                                                </div>

                                                <p class="mt-3">
                                                    <label for="generator-available">Generator Available</label><br>
                                                    <select class="form-control p-10 form-select" name="is_generator_backup" id="generator-available">
                                                        <option value="">Select</option>
                                                        <option value="yes" <?= ($result->is_generator_backup == 'yes') ? 'selected' : '' ?>>Yes</option>
                                                        <option value="no" <?= ($result->is_generator_backup == 'no') ? 'selected' : '' ?>>No</option>
                                                    </select>
                                                </p>

                                                <!-- Generator backup (in KVA) -->
                                                <p id="generator-backup-section" style="display: <?= ($result->is_generator_backup == 'yes') ? 'block' : 'none' ?>;">
                                                    <label for="generator_capacity">Generator Capacity (in KVA)</label>
                                                    <input type="text" id="generator_capacity" placeholder="Generator Capacity (in KVA)" name="generator_backup_capacity" class="form-control p-10" value="<?= $result->generator_backup_capacity ?>">

                                                    <label for="generator-fuel-tank-capacity">Generator Fuel Tank Capacity (in Ltr.)</label>
                                                    <select name="generator_fuel_tank_capacity" class="form-control p-10 form-select">
                                                        <option value="">Select Capacity</option>
                                                        <?php
                                                        for ($ltr = 1; $ltr <= 500; $ltr += 0.5) { ?>
                                                            <option value="<?= $ltr ?>" <?= ($result->generator_fuel_tank_capacity == $ltr) ? 'selected' : '' ?>>
                                                                <?= $ltr ?> Ltr
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </p>


                                                <!-- UPS backup (KVA) -->
                                                <p>
                                                    <label for="">UPS Backup (KVA)</label>
                                                    <input type="text" placeholder="UPS Backup (KVA)" name="power_back_ups_kv" class="form-control p-10" value="<?= $result->power_back_ups_kv ?>">

                                                    <label for="ups-time">UPS Backup Time (in mins)</label>
                                                    <select name="ups_backup_time" id="ups-time" class="form-control p-10 form-select">
                                                        <option value="">Select time</option>
                                                        <?php
                                                        for ($min = 5; $min <= 480; $min += 5) { ?>
                                                            <option value="<?= $min ?>" <?= ($result->ups_backup_time == $min) ? 'selected' : '' ?>>
                                                                <?= $min ?> Mins
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </p>
                                            </div>
                                            <p>Lab details</p>
                                        </div>

                                        <div>
                                            <div id="profileLabContainerHtml">
                                                <?php
                                                if (!empty($labs)) {
                                                    foreach ($labs as $index => $lab) {
                                                ?>
                                                        <div class="mt-3 newLabWrapperChange">
                                                            <span class="bg-dark text-white p-2 rounded-top lab-number">Lab number <?= $index + 1 ?></span>
                                                            <div class="lab-details-wrapper p-4 rounded bg-white mt-2">
                                                                <p>
                                                                    <label>Floor number</label>
                                                                    <select class="form-control" name="floor_number[]">

                                                                        <option value="basement"
                                                                            <?= ($lab['floor_name'] === 'basement') ? 'selected' : '' ?>>
                                                                            Basement
                                                                        </option>

                                                                        <option value="0"
                                                                            <?= ((string)$lab['floor_name'] === '0') ? 'selected' : '' ?>>
                                                                            Ground
                                                                        </option>

                                                                        <?php for ($i = 1; $i <= 30; $i++) { ?>
                                                                            <option value="<?= $i ?>"
                                                                                <?= ((string)$lab['floor_name'] === (string)$i) ? 'selected' : '' ?>>
                                                                                <?= $i ?>
                                                                            </option>
                                                                        <?php } ?>

                                                                    </select>
                                                                </p>
                                                                <!-- Total Computers -->
                                                                <p>
                                                                    <label>Total number of computers?</label>
                                                                    <input type="number" name="no_of_computer[]" class="form-control" value="<?= $lab['no_of_computer'] ?>" min="0">
                                                                </p>

                                                                <!-- System Processor -->
                                                                <p>
                                                                    <label>System Processor</label>
                                                                    <select name="window_generation[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="Core 2 Duo" <?= $lab['window_generation'] == 'Core 2 Duo' ? 'selected' : '' ?>>Core 2 Duo</option>
                                                                        <option value="i3" <?= $lab['window_generation'] == 'i3' ? 'selected' : '' ?>>i3</option>
                                                                        <option value="i5" <?= $lab['window_generation'] == 'i5' ? 'selected' : '' ?>>i5</option>
                                                                        <option value="i7" <?= $lab['window_generation'] == 'i7' ? 'selected' : '' ?>>i7</option>
                                                                    </select>
                                                                </p>

                                                                <!-- Monitor Type -->
                                                                <p>
                                                                    <label>Monitor Type</label>
                                                                    <select name="monitor_type[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="LCD" <?= $lab['monitor_type'] == 'LCD' ? 'selected' : '' ?>>LCD</option>
                                                                        <option value="LED" <?= $lab['monitor_type'] == 'LED' ? 'selected' : '' ?>>LED</option>
                                                                    </select>
                                                                </p>

                                                                <!-- Operating System -->
                                                                <p>
                                                                    <label>Operating System</label>
                                                                    <select name="operating_system[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="Win 7" <?= $lab['operating_system'] == 'Win 7' ? 'selected' : '' ?>>Win 7</option>
                                                                        <option value="Win 8" <?= $lab['operating_system'] == 'Win 8' ? 'selected' : '' ?>>Win 8</option>
                                                                        <option value="Win 10" <?= $lab['operating_system'] == 'Win 10' ? 'selected' : '' ?>>Win 10</option>
                                                                        <option value="Win 11" <?= $lab['operating_system'] == 'Win 11' ? 'selected' : '' ?>>Win 11</option>
                                                                        <option value="Linux" <?= $lab['operating_system'] == 'Linux' ? 'selected' : '' ?>>Linux</option>
                                                                        <option value="MacOS" <?= $lab['operating_system'] == 'MacOS' ? 'selected' : '' ?>>MacOS</option>
                                                                    </select>
                                                                </p>

                                                                <!-- RAM -->
                                                                <p>
                                                                    <label>RAM (in GB)</label>
                                                                    <select name="ram[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="2GB" <?= $lab['ram'] == '2GB' ? 'selected' : '' ?>>2GB</option>
                                                                        <option value="4GB" <?= $lab['ram'] == '4GB' ? 'selected' : '' ?>>4GB</option>
                                                                        <option value="8GB" <?= $lab['ram'] == '8GB' ? 'selected' : '' ?>>8GB</option>
                                                                        <option value="16GB" <?= $lab['ram'] == '16GB' ? 'selected' : '' ?>>16GB</option>
                                                                        <option value="32GB" <?= $lab['ram'] == '32GB' ? 'selected' : '' ?>>32GB</option>
                                                                    </select>
                                                                </p>

                                                                <!-- Hard Disk -->
                                                                <p>
                                                                    <label>Hard Disk Drive Capacity (in GB)</label>
                                                                    <select name="hard_disk[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="80GB" <?= $lab['hard_disk'] == '80GB' ? 'selected' : '' ?>>80GB</option>
                                                                        <option value="128GB" <?= $lab['hard_disk'] == '128GB' ? 'selected' : '' ?>>128GB</option>
                                                                        <option value="160GB" <?= $lab['hard_disk'] == '160GB' ? 'selected' : '' ?>>160GB</option>
                                                                        <option value="256GB" <?= $lab['hard_disk'] == '256GB' ? 'selected' : '' ?>>256GB</option>
                                                                        <option value="320GB" <?= $lab['hard_disk'] == '320GB' ? 'selected' : '' ?>>320GB</option>
                                                                        <option value="500GB" <?= $lab['hard_disk'] == '500GB' ? 'selected' : '' ?>>500GB</option>
                                                                        <option value="1TB" <?= $lab['hard_disk'] == '1TB' ? 'selected' : '' ?>>1TB</option>
                                                                        <option value="1.5TB" <?= $lab['hard_disk'] == '1.5TB' ? 'selected' : '' ?>>1.5TB</option>
                                                                        <option value="2TB" <?= $lab['hard_disk'] == '2TB' ? 'selected' : '' ?>>2TB</option>
                                                                        <option value="4TB" <?= $lab['hard_disk'] == '4TB' ? 'selected' : '' ?>>4TB</option>
                                                                    </select>
                                                                </p>

                                                                <!-- Ethernet Company -->
                                                                <p>
                                                                    <label>Ethernet Switch’s Company</label>
                                                                    <select name="ehternet_swtch_company[]" class="form-select ethernet-company">
                                                                        <option value="">Select</option>
                                                                        <option value="Cisco" <?= $lab['ehternet_swtch_company'] == 'Cisco' ? 'selected' : '' ?>>Cisco</option>
                                                                        <option value="Netgear" <?= $lab['ehternet_swtch_company'] == 'Netgear' ? 'selected' : '' ?>>Netgear</option>
                                                                        <option value="D-Link" <?= $lab['ehternet_swtch_company'] == 'D-Link' ? 'selected' : '' ?>>D-Link</option>
                                                                        <option value="TP-Link" <?= $lab['ehternet_swtch_company'] == 'TP-Link' ? 'selected' : '' ?>>TP-Link</option>
                                                                        <option value="Dex" <?= $lab['ehternet_swtch_company'] == 'Dex' ? 'selected' : '' ?>>Dex</option>
                                                                        <option value="other" <?= $lab['ehternet_swtch_company'] == 'other' ? 'selected' : '' ?>>Other</option>

                                                                        <input class="form-control mt-2 ethernet-other-input"
                                                                            name="ethernet_company_other[]"
                                                                            value="<?= $lab['ethernet_company_other'] ?>"
                                                                            placeholder="Enter Ethernet Switch Company"
                                                                            style="<?= ($lab['ehternet_swtch_company'] == 'other') ? '' : 'display:none;' ?>">
                                                                    </select>

                                                                </p>

                                                                <!-- Switch Category -->
                                                                <p>
                                                                    <label>Switch’s Category</label>
                                                                    <select name="switch_category[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="unmanaged" <?= $lab['switch_category'] == 'unmanaged' ? 'selected' : '' ?>>unmanaged</option>
                                                                        <option value="smart" <?= $lab['switch_category'] == 'smart' ? 'selected' : '' ?>>smart</option>
                                                                        <option value="managedL2" <?= $lab['switch_category'] == 'managedL2' ? 'selected' : '' ?>>managed L2</option>
                                                                        <option value="managedL3" <?= $lab['switch_category'] == 'managedL3' ? 'selected' : '' ?>>managed L3</option>
                                                                    </select>
                                                                </p>

                                                                <!-- Number of Ethernet Ports -->
                                                                <p>
                                                                    <label>No. of Ports of Each Ethernet Switch?</label>
                                                                    <select name="no_of_port_eth_switch[]" class="form-select">
                                                                        <option value="">Select</option>
                                                                        <option value="8" <?= $lab['no_of_port_eth_switch'] == '8' ? 'selected' : '' ?>>8</option>
                                                                        <option value="16" <?= $lab['no_of_port_eth_switch'] == '16' ? 'selected' : '' ?>>16</option>
                                                                        <option value="24" <?= $lab['no_of_port_eth_switch'] == '24' ? 'selected' : '' ?>>24</option>
                                                                        <option value="48" <?= $lab['no_of_port_eth_switch'] == '48' ? 'selected' : '' ?>>48</option>
                                                                    </select>
                                                                </p>

                                                                <div class="saveBtnWrapper">
                                                                    <button type="button" class="btn btn-outline-danger profile-delete-btn">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <button type="button" id="profileAddLabBtn"
                                                class="btn border rounded w-100 p-2 d-flex justify-content-center align-items-center bg-white addNewLab mt-3"><img
                                                    src="<?php echo base_url('assets/asserts/Icon.png') ?>" alt=""
                                                    class="me-2">Add new lab
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-3 mt-4">Bank details</h5>
                                <div class="row">
                                    <div class="col-md-5 m-auto p-4 w-100 bg-white rounded border">
                                        <div class="center-details-form">
                                            <div>
                                                <p>
                                                    <label for="">Beneficiary name</label><br>
                                                    <input type="text" name="beneficiary_name" placeholder="..." value="<?= isset($result->beneficiary_name) ? $result->beneficiary_name : '' ?>">
                                                </p>
                                                <p>
                                                    <label for="">Name of the bank</label><br>
                                                    <select class="form-control select2" name="bank_name">
                                                        <option value="">Select Bank</option>
                                                        <?php foreach ($bank_name as $row) { ?>
                                                            <option value="<?= htmlspecialchars($row['bank_name']) ?>"
                                                                <?= (isset($result->bank_name) && $row['bank_name'] == $result->bank_name) ? 'selected' : ''; ?>>
                                                                <?= htmlspecialchars($row['bank_name']) ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </p>
                                                <p>
                                                    <label for="">Bank Account number</label><br>
                                                    <input type="text" name="bank_account_number" placeholder="..." value="<?= isset($result->bank_account_number) ? $result->bank_account_number : '' ?>">
                                                </p>
                                                <p>
                                                    <label for="">Bank IFSC code</label><br>
                                                    <input type="text" name="bank_ifsc_code" placeholder="..." value="<?= isset($result->bank_ifsc_code) ? $result->bank_ifsc_code : '' ?>">
                                                </p>
                                                <p>
                                                    <label for="">PAN number</label><br>
                                                    <input type="text" name="pan_no" placeholder="..." value="<?= isset($result->pan_no) ? $result->pan_no : '' ?>">
                                                </p>
                                                <!-- GST Section -->
                                                <p>
                                                    <label>Do you have a GST number?</label><br>
                                                    <input type="radio" name="has_gst" value="yes" <?= ($result->has_gst == 'yes') ? 'checked' : '' ?>> Yes
                                                    <input type="radio" name="has_gst" value="no" <?= ($result->has_gst == 'no') ? 'checked' : '' ?>> No
                                                </p>
                                                <div id="gst-section" style="display: <?= ($result->has_gst == 'yes') ? 'block' : 'none' ?>;">
                                                    <p>
                                                        <label for="gst_number">GST Number</label><br>
                                                        <input type="text" class="form-control" placeholder="Enter GST number..." name="gst_no" value="<?= $result->gst_no ?>">
                                                    </p>

                                                    <p>
                                                        <label for="gst_file">Upload GST Document</label><br>
                                                        <input type="file" name="gst_file" id="gst_file" accept=".pdf" class="form-control">
                                                        <?php if (!empty($result->gst_file)) { ?>
                                                            <iframe src="<?= base_url($result->gst_file) ?>" width="100%" height="300px" class="mt-2"></iframe>
                                                        <?php } ?>
                                                    </p>

                                                    <p class="m-0">
                                                        <label for="">GST State code</label><br>
                                                    <div class="gst-state-code-wrapper">
                                                        <input type="text" name="gst_state_code" placeholder="..." class="border-top" value="<?= isset($result->gst_state_code) ? $result->gst_state_code : '' ?>">
                                                        <p class="m-0 px-2">Here’s a <a
                                                                href="https://www.iifl.com/blogs/business-loan/gst-code-list-and-jurisdiction"
                                                                target="_blank">link</a> to find your GST code: </p>
                                                    </div>
                                                    </p>
                                                </div>
                                                <p>
                                                    <label for="">UIDAI Number</label>
                                                    <input type="text" placeholder="Enter UIDAI Number" name="uidai_number" value="<?= $result->uidai_number ?>">
                                                </p>
                                                <!-- MSME Section -->
                                                <p>
                                                    <label>Do you have an MSME number?</label><br>
                                                    <input type="radio" name="has_msme" value="yes" <?= ($result->has_msme == 'yes') ? 'checked' : '' ?>> Yes
                                                    <input type="radio" name="has_msme" value="no" <?= ($result->has_msme == 'no') ? 'checked' : '' ?>> No
                                                </p>

                                                <div id="msme-section" style="display: <?= ($result->has_msme == 'yes') ? 'block' : 'none' ?>;">
                                                    <p>
                                                        <label for="msme_number">MSME Number</label><br>
                                                        <input type="text" class="form-control" placeholder="Enter MSME Number" name="msme_number" value="<?= $result->msme_number ?>">
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
                                                        <span class="note">Max file size: 2 MB<br>File type: doc, docx, pdf</span>
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
                                                        <span class="note">Max file size: 2 MB<br>File type: doc, docx, pdf</span>
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
                                                        <span class="note">Max file size: 2 MB<br>File type: doc, docx, pdf</span>
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
                                                        <span class="note">Max file size: 2 MB<br>File type: doc, docx, pdf</span>
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
                                                        <span class="note">Max file size: 2 MB<br>File type: doc, docx, pdf</span>
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
                                                        <span class="note">Max file size: 2 MB<br>File type: doc, docx, pdf</span>
                                                        <div class="file-preview mt-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===========Request Modal============= -->
<div class="modal fade" id="editRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md" style="width: 90%;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Request Profile Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="<?= base_url('request-profile-edit') ?>">
                <div class="modal-body">

                    <input type="hidden" name="center_id" value="<?= $result->id ?>">

                    <div class="mb-3">
                        <label class="form-label">Center Name</label>
                        <input type="text" class="form-control"
                            value="<?= $result->center_name ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                        <textarea name="request_message" class="form-control" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- ===================Script====================== -->
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
                    statusDiv.innerHTML = 'Location retrieved successfully!';

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
        // Dropdown elements
        const dropdowns = [
            'distance_from_railway_station',
            'distance_from_bus_stop',
            'distance_from_metro_station',
            'distance_from_airport'
        ];

        // Populate options
        dropdowns.forEach(id => {
            const dropdown = document.getElementById(id);
            const selectedValue = dropdown.getAttribute('data-selected');

            for (let meters = 100; meters <= 300000; meters += 100) {
                const km = (meters / 1000).toFixed(2);
                const text = meters <= 1000 ? `${meters} meters` : `${km} km`;

                const option = document.createElement('option');
                option.value = meters;
                option.textContent = text;

                if (selectedValue && selectedValue == meters) {
                    option.selected = true; // auto-select if matches
                }

                dropdown.appendChild(option);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Populate Generator Time dropdown (5 to 180 mins, step 5)
        for (let mins = 5; mins <= 180; mins += 5) {
            $('#ups-time').append(`<option value="${mins}">${mins} mins</option>`);
        }

        for (let ltr = 1; ltr <= 20; ltr += 0.5) {
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
    $(document).ready(function() {
                // Function to generate a new lab block dynamically
                function getProfileLabHTML(labCount) {
                    return `
            <div class="mt-3 newLabWrapperChange">
                <span class="bg-dark text-white p-2 rounded-top lab-number">Lab number ${labCount}</span>
                <div class="lab-details-wrapper p-4 rounded bg-white mt-2">
                    <p><label>Floor number</label>
                        <select class="form-control form-select" name="floor_number[]">
                            <option value="basement">Basement</option>
                            <option value="0">Ground</option>
                            ${Array.from({length: 30}, (_, i) => ` < option value = "${i+1}" > $ {
                        i + 1
                    } < /option>`).join("")} < /
                    select > <
                        /p> <
                    p > < label > Total number of computers ? < /label> <
                    input type = "number"
                    name = "no_of_computer[]"
                    class = "form-control"
                    min = "0" >
                        <
                        /p> <
                    p > < label > System Processor < /label> <
                    select name = "window_generation[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "Core 2 Duo" > Core 2 Duo < /option> <
                    option value = "i3" > i3 < /option> <
                    option value = "i5" > i5 < /option> <
                    option value = "i7" > i7 < /option> < /
                    select > <
                        /p> <
                    p > < label > Monitor type < /label> <
                    select name = "monitor_type[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "LCD" > LCD < /option> <
                    option value = "LED" > LED < /option> < /
                    select > <
                        /p> <
                    p > < label > Operating system < /label> <
                    select name = "operating_system[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "Win 7" > Win 7 < /option> <
                    option value = "Win 8" > Win 8 < /option> <
                    option value = "Win 10" > Win 10 < /option> <
                    option value = "Win 11" > Win 11 < /option> <
                    option value = "Linux" > Linux < /option> <
                    option value = "MacOS" > MacOS < /option> < /
                    select > <
                        /p> <
                    p > < label > RAM(in GB) < /label> <
                    select name = "ram[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "2GB" > 2 GB < /option> <
                    option value = "4GB" > 4 GB < /option> <
                    option value = "8GB" > 8 GB < /option> <
                    option value = "16GB" > 16 GB < /option> <
                    option value = "32GB" > 32 GB < /option> < /
                    select > <
                        /p> <
                    p > < label > Hard Disk Drive Capacity in GB < /label> <
                    select name = "hard_disk[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "80GB" > 80 GB < /option> <
                    option value = "128GB" > 128 GB < /option> <
                    option value = "160GB" > 160 GB < /option> <
                    option value = "256GB" > 256 GB < /option> <
                    option value = "320GB" > 320 GB < /option> <
                    option value = "500GB" > 500 GB < /option> <
                    option value = "1TB" > 1 TB < /option> <
                    option value = "1.5TB" > 1.5 TB < /option> <
                    option value = "2TB" > 2 TB < /option> <
                    option value = "4TB" > 4 TB < /option> < /
                    select > <
                        /p> <
                    p > < label > Ethernet Switch’ s company < /label> <
                    select name = "ehternet_swtch_company[]"
                    class = "form-select ethernet-company" >
                    <
                    option value = "" > Select < /option> <
                    option value = "Cisco" > Cisco < /option> <
                    option value = "Netgear" > Netgear < /option> <
                    option value = "D-Link" > D - Link < /option> <
                    option value = "TP-Link" > TP - Link < /option> <
                    option value = "Dex" > Dex < /option> <
                    option value = "other" > Other < /option> < /
                    select >

                        <
                        input type = "text"
                    name = "ethernet_company_other[]"
                    class = "form-control mt-2 ethernet-other-input"
                    placeholder = "Enter Ethernet Switch Company"
                    style = "display:none;" >
                        <
                        /p> <
                    p > < label > Switch’ s Category < /label> <
                    select name = "switch_category[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "unmanaged" > unmanaged < /option> <
                    option value = "smart" > smart < /option> <
                    option value = "managedL2" > managed L2 < /option> <
                    option value = "managedL3" > managed L3 < /option> < /
                    select > <
                        /p> <
                    p > < label > No.of ports of each Ethernet
                    switch ? < /label> <
                    select name = "no_of_port_eth_switch[]"
                    class = "form-select" >
                    <
                    option value = "" > Select < /option> <
                    option value = "8" > 8 < /option> <
                    option value = "16" > 16 < /option> <
                    option value = "24" > 24 < /option> <
                    option value = "48" > 48 < /option> < /
                    select > <
                        /p> <
                    div class = "saveBtnWrapper" >
                    <
                    button type = "button"
                    class = "btn btn-outline-danger profile-delete-btn" > Delete < /button> < /
                    div > <
                        /div> < /
                    div > `;
        }

        // 🔹 Update lab numbering + input count
        function updateProfileLabNumbers() {
            $("#profileLabContainerHtml .newLabWrapperChange").each(function(index) {
                $(this).find(".lab-number").text("Lab number " + (index + 1));
            });

            $("#edit_total_number_of_lab").val(
                $("#profileLabContainerHtml .newLabWrapperChange").length
            );
        }

        $("#profileAddLabBtn").on("click", function() {
            let count = $("#profileLabContainerHtml .newLabWrapperChange").length + 1;
            $("#profileLabContainerHtml").append(getProfileLabHTML(count));
            updateProfileLabNumbers();
        });

        // 🔹 When total labs input changes
        $("#edit_total_number_of_lab").on("change keyup", function() {
            let requiredLabs = parseInt($(this).val()) || 0;
            let currentLabs = $("#profileLabContainerHtml .newLabWrapperChange").length;

            // ➕ Add labs
            if (requiredLabs > currentLabs) {
                for (let i = currentLabs + 1; i <= requiredLabs; i++) {
                    $("#profileLabContainerHtml").append(getProfileLabHTML(i));
                }
            }

            // ➖ Remove labs
            if (requiredLabs < currentLabs) {
                $("#profileLabContainerHtml .newLabWrapperChange")
                    .slice(requiredLabs)
                    .remove();
            }

            updateProfileLabNumbers();
        });

        // 🔹 Delete lab button
        $(document).on("click", ".profile-delete-btn", function() {
            $(this).closest(".newLabWrapperChange").remove();
            updateProfileLabNumbers();
        });

        // 🔹 Initial sync (for edit page)
        $("#edit_total_number_of_lab").trigger("change");
    });
</script>
<script>
    $(document).on('change', '.ethernet-company', function() {

        let labWrapper = $(this).closest('.newLabWrapperChange');
        let otherInput = labWrapper.find('.ethernet-other-input');

        if ($(this).val() === 'other') {
            otherInput.show().attr('required', true);
        } else {
            otherInput.hide().val('').removeAttr('required');
        }
    });
</script>