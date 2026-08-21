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
<div class="tablecalenderContent show">
    <div class="project-pages-section">
        <!-- top project-create- navbar section -->
        <div class='notification-navbar'>
            <h2 class='m-0 fs-4'>My Project</h2>
            <div>
                <button class='create-project-btn createProjectBtn'>
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create Project
                </button>
            </div>
        </div>
        <hr>

        <!-- Numerical card section  -->
        <div class="row">
            <div class="col-4 ">
                <div class='d-flex numerical-box1'>
                    <div class='numerical-img-cnt'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/total-project-icon.png')?>"
                            alt="total-project" />
                    </div>
                    <div class='Numerical-text-cnt'>
                        <p>Total Projects</p>
                        <h2><?=$totalCityCovered->total_cities?> 
                            <span><i class="bi bi-arrow-up-short"></i>✅</span>
                        </h2>
                    </div>
                    <div class='numerical-opption-btn'>
                        <select>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php
            $assessed = $totalAssessed ?? 0;
            $required = $totalRequired ?? 0;
            $percent  = ($required > 0) ? round(min(($assessed / $required) * 100, 100)) : 0;
            ?>
            <div class="col-4 ">
                <div class='d-flex numerical-box1'>
                    <div class='numerical-img-cnt'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/assessed condidates.png')?>"
                            alt="assessed-condidates" />
                    </div>
                    <div class='Numerical-text-cnt'>
                        <p>Assessed Candidates</p>
                        <h2><?= $assessed ?> 
                            <span><i class="bi bi-arrow-up-short">✅</i></span>
                        </h2>
                    </div>
                    <div class='numerical-opption-btn'>
                        <select>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4 ">
                <div class='d-flex numerical-box1'>
                    <div class='numerical-img-cnt'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/cities icon.png')?>"
                            alt="total-project" />
                    </div>
                    <div class='Numerical-text-cnt'>
                        <p>Cities Covered</p>
                        <h2><?=$totalCityCovered->total_cities?>
                            <span><i class="bi bi-arrow-up-short"></i>✅</span>
                        </h2>
                    </div>
                    <div class='numerical-opption-btn'>
                        <select>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- tab change and project-create-btn section -->
        <div class="row align-items-center">
            <div class="col-8 py-4">
                <div class='project-create-cnt'>
                    <ul>
                        <li><a href="#" class="allProjectTabBtn all-project-tab">All
                                <span><?=count($projects)?></span></a></li>
                        <li><a href="#" class="allProjectTabBtn">Upcoming <span><?=count($pendingProjects)?></span></a></li>
                        <li><a href="#" class="allProjectTabBtn">Completed <span><?=count($completeProjects)?></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-4 py-4 projectCreate-btn-cnt">
                <button class='create-project-btn createProjectBtn'><img
                        src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create
                    Project</button>
            </div>
        </div>
        <!-- Table-top section -->
        <div class="all-table-cnt">
            <!-- all table -->
            <div class="projectTableContent table-cnt show" id="table1">
                <div class="tableCnt">
                    <div class='tableHeading'>
                        <div class='exam-name-input-cnt'>
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/search.png')?>" alt="" style="position: absolute;top: 45px;left: 35px;"/>
                            <input class="examNameFilter" type='text' placeholder='Enter exam name..' />
                        </div>
                        <div class='filter-download-cnt'>
                            <button type="button" class="exportProjectBtn" data-status="all">
                                Export 
                                <img src="<?= base_url('assets/icon-folder/project-icons/Download.png') ?>" />
                            </button>
                        </div>
                    </div>
                    <!-- All table -->
                    <?php
                    $projects = $projects;
                    include(APPPATH . 'views/dashboard/partials/booking-table.php');
                    ?>
                </div>
                <div class='table-footer-btn-cnt py-3'>
                    <div class='pre-arrow-btn-cnt'>
                        <button class=""><img src="<?php echo base_url('assets/icon-folder/project-icons/previus-arrow.png')?>"
                                alt="pre-arrow" />Previous</button>
                    </div>
                    <div class='no-of-page-btn'>
                        <button class="">Page 1 of 3</button>
                    </div>
                    <div class='next-arrow-btn-cnt'>
                        <button class="">Next<img src="<?php echo base_url('assets/icon-folder/project-icons/next -arrow.png')?>"
                                alt="next-icon" /></button>
                    </div>
                </div>
            </div>
            <!-- upcoming table -->
            <div class="table-cnt projectTableContent" id="table2">
                <div class="tableCnt">
                    <div class='tableHeading'>
                        <div class='exam-name-input-cnt'>
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/search.png')?>" alt="" style="position: absolute;top: 45px;left: 35px;"/>
                            <input class="examNameFilter" type='text' placeholder='Enter exam name..' />
                        </div>
                        <div class='filter-download-cnt'>
                            <button type="button" class="exportProjectBtn" data-status="pending">
                                Export 
                                <img src="<?= base_url('assets/icon-folder/project-icons/Download.png') ?>" />
                            </button>
                        </div>
                    </div>
                    <?php
                    $projects = $pendingProjects;
                    include(APPPATH . 'views/dashboard/partials/booking-table.php');
                    ?>
                </div>
                <div class='table-footer-btn-cnt py-3'>
                    <div class='pre-arrow-btn-cnt'>
                        <button class=""><img src="<?php echo base_url('assets/icon-folder/project-icons/previus-arrow.png')?>"
                                alt="pre-arrow" />Previous</button>
                    </div>
                    <div class='no-of-page-btn'>
                        <button class="">Page 1 of 3</button>
                    </div>
                    <div class='next-arrow-btn-cnt'>
                        <button class="">Next<img src="<?php echo base_url('assets/icon-folder/project-icons/next -arrow.png')?>"
                                alt="next-icon" /></button>
                    </div>
                </div>
            </div>
            <!-- complete table -->
             <div class="table-cnt projectTableContent" id="table3">
                <div class="tableCnt">
                    <div class='tableHeading'>
                        <div class='exam-name-input-cnt'>
                            <img src="<?php echo base_url('assets/icon-folder/project-icons/search.png')?>" alt="" style="position: absolute;top: 45px;left: 35px;"/>
                            <input class="examNameFilter" type='text' placeholder='Enter exam name..' />
                        </div>
                        <div class='filter-download-cnt'>
                            <button type="button" class="exportProjectBtn" data-status="completed">
                                Export 
                                <img src="<?= base_url('assets/icon-folder/project-icons/Download.png') ?>" />
                            </button>
                        </div>
                    </div>
                    <?php
                    $projects = $completeProjects;
                    include(APPPATH . 'views/dashboard/partials/booking-table.php');
                    ?>
                </div>
                <div class='table-footer-btn-cnt py-3'>
                    <div class='pre-arrow-btn-cnt'>
                        <button class=""><img src="<?php echo base_url('assets/icon-folder/project-icons/previus-arrow.png')?>"
                                alt="pre-arrow" />Previous</button>
                    </div>
                    <div class='no-of-page-btn'>
                        <button class="">Page 1 of 3</button>
                    </div>
                    <div class='next-arrow-btn-cnt'>
                        <button class="">Next<img src="<?php echo base_url('assets/icon-folder/project-icons/next -arrow.png')?>"
                                alt="next-icon" /></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="createProjectSection" id="createProjectSection">
    <form id="createProjectForm" method="POST">
        <input type="hidden" id="ProjectFormUrl" value="<?php echo base_url('create-project')?>">
        <input type="hidden" value="<?=base_url()?>" class="base_url">
        <!--///////////////// create project step section /////////////////////-->
        <!-- project details section -->
        <div class="Project details wrapper createProjectForm show">
            <!-- top navbar section -->
            <div class="project-detials-header-section">
                <div class="row">
                    <div class='notification-navbar'>
                        <h2 class='m-0 fs-4'>Create a Project<span>/ Project details</span></h2>
                        <div>
                            <button class='create-project-btn'> <img
                                    src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create
                                Project</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- infobar -section -->
            <div class="project-infobar-section pb-4">
                <div class="row ">
                    <div class="col-4 active-img-cnt">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/project-detials-info-01.png')?>"
                            alt="active" />
                        <span class='ms-2 conect-line'>Project details</span>
                    </div>
                    <div class="col-4 inactive-img-cnt">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/project-amenity-02.png')?>" alt="inactive" />
                        <span class='ms-2 inactive-img-line'>Amenity requirements</span>
                    </div>
                    <div class="col-4">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/project-manpower-ratio-03.png')?>" alt="" />
                        <span class='ms-2'>Manpower ratio</span>
                    </div>
                </div>
            </div>
            <!-- first info detials section -->
            <div class="main-projectDetials-enter-cnt">
                <div class="">
                    <h3>Enter Project details</h3>
                    <div class='py-1 px-3'>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Enter Exam name</label>
                            </div>
                            <div class="col-6">
                                <input type="text" placeholder='Enter Exam name'
                                    class='w-100 py-2 px-3 rounded border' name="exam_name" required/>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Exam category</label>
                            </div>
                            <div class="col-6 ">
                                <div class='d-flex justify-content-between'>
                                    <div
                                        class='d-flex border w-50 align-items-center rounded py-2 px-3 bg-white me-2'>
                                        <input type="radio" class='me-2' name="exam_category" checked value="government" required/>
                                        <label htmlFor="">Government</label>
                                    </div>
                                    <div
                                        class='d-flex border w-50 py-2 px-3 align-items-center rounded bg-white ms-2'>
                                        <input type="radio" class='me-2' name='exam_category' value="private" required/>
                                        <label htmlFor="">Private</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Exam Start & End Date</label>
                            </div>
                            <?php $today = date('Y-m-d'); ?>

                            <div class="col-6">
                                <div class='row'>
                                    <div class='col-6'>
                                        <input type="date"
                                               class="me-2 border w-100 align-items-center rounded py-2 px-3 bg-white"
                                               name="start_date"
                                               min="<?= $today ?>"
                                               required />
                                    </div>
                                    <div class='col-6'>
                                        <input type="date"
                                               class="border w-100 py-2 px-3 align-items-center rounded bg-white"
                                               name="end_date"
                                               min="<?= $today ?>"
                                               required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label>Exam city</label>
                            </div>
                            <div class="col-6">
                                <select name="city_id[]" id="citySelect" class="w-100 border rounded py-2 px-3" multiple>
                                    <?php foreach ($city as $row): ?>
                                        <option value="<?= $row['city_id'] ?>"><?= $row['city_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="cityBatchContainer" class="mt-3"></div>
                            </div>
                        </div>

                        <div class="row align-items-center pb-3 mt-4">
                            <div class="col-6">
                                <label htmlFor="">Price Per Seat</label>
                            </div>
                            <div class="col-6">
                                <input type="number" placeholder='10'
                                    class='w-100 py-2 px-3 rounded border' name="price_per_seat" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="container">
                    <h3>Enter Software and Hardware requirements</h3>
                    <div class='p-4 bg-white rounded'>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Exam mode</label>
                            </div>
                            <div class="col-6 ">
                                <div class='d-flex justify-content-between'>
                                    <div
                                        class='d-flex border w-50 align-items-center rounded py-2 px-3 bg-white me-2'>
                                        <input type="radio" class='me-2' name="exam_mode" value="internet_based" checked />
                                        <label htmlFor="">Internet based</label>
                                    </div>
                                    <div
                                        class='d-flex border w-50 py-2 px-3 align-items-center rounded bg-white ms-2'>
                                        <input type="radio" class='me-2' name='exam_mode' value="server_based" />
                                        <label htmlFor="">Server based</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class='my-4'>Select Computer configuration</h3>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Operating System</label>
                            </div>
                            <div class="col-6">
                                <select name="operating_system" id="" class='w-100 border rounded py-2 px-3'>
                                    <option value="Windows11">Windows 11</option>
                                    <option value="Windows10">Windows 10</option>
                                    <option value="ubuntu">Ubuntu</option>
                                    <option value="linux">Linux</option>
                                    <option value="mac">Mac</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Select RAM</label>
                            </div>
                            <div class="col-6">
                                <select name="ram" id="" class='w-100 border rounded py-2 px-3'>
                                    <option value="4">4GB</option>
                                    <option value="6">6GB</option>
                                    <option value="8">8GB</option>
                                    <option value="12">12GB</option>
                                    <option value="16">16GB</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Display Resolution</label>
                            </div>
                            <div class="col-6">
                                <select name="display_resolution" id="" class='w-100 border rounded py-2 px-3'>
                                        <option value="800x600">800 × 600</option>
                                        <option value="1024x768">1024 × 768</option>
                                        <option value="1152x864">1152 × 864</option>
                                        <option value="1280x720">1280 × 720</option>
                                        <option value="1280x768">1280 × 768</option>
                                        <option value="1280x800">1280 × 800</option>
                                        <option value="1280x960">1280 × 960</option>
                                        <option value="1280x1024">1280 × 1024</option>
                                        <option value="1360x768">1360 × 768</option>
                                        <option value="1366x768">1366 × 768</option>
                                        <option value="1440x900">1440 × 900</option>
                                        <option value="1440x1050">1440 × 1050</option>
                                        <option value="1600x900">1600 × 900</option>
                                        <option value="1680x1050">1680 × 1050</option>
                                        <option value="1920x1080">1920 × 1080</option>
                                        <option value="2560x1440">2560 × 1440</option>
                                        <option value="3840x2160">3840 × 2160</option>
                                        <option value="5120x2880">5120 × 2880</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">
                                <label htmlFor="">Internet on each device</label>
                            </div>
                            <div class="col-6 ">
                                <div class='d-flex justify-content-between'>
                                    <div
                                        class='d-flex border w-50 align-items-center rounded py-2 px-3 bg-white me-2'>
                                        <input type="radio" class='me-2' name="internet_on_each_device" value="1" checked />
                                        <label htmlFor="">Yes</label>
                                    </div>
                                    <div
                                        class='d-flex border w-50 py-2 px-3 align-items-center rounded bg-white ms-2'>
                                        <input type="radio" class='me-2' name='internet_on_each_device' value="0" />
                                        <label htmlFor="">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='project-Detials-btn-cnt'>
                    <button class='cancel-btn'>Cancel</button>
                    <button type="button" class='Next-btn createProjectNextBtn'>Next</button>
                </div>
            </div>
        </div>
        <!-- project Amenity requirements section-->
        <div class="project-amenity-details-wrapper createProjectForm">
            <!-- Amenity navbar section -->
            <div class="row">
                <div class='notification-navbar'>
                    <h2 class='m-0 fs-4'>Create a Project<span>/ Amenity requirements</span></h2>
                    <div>
                        <button class='create-project-btn'><img
                                src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create
                            Project</button>
                    </div>
                </div>
            </div>
            <hr>
            <!-- project infobar detials step2 -->
            <div class="row py-3">
                <div class="col-4 active-img-cnt">
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/project-detials-info-01.png')?>" alt="active" />
                    <span class='ms-2 conect-line'>Project details</span>
                </div>
                <div class="col-4 inactive-img-cnt">
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/project-amenity-02.png')?>" alt="inactive" />
                    <span class='ms-2 inactive-img-line'>Amenity requirements</span>
                </div>
                <div class="col-4">
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/project-manpower-ratio-03.png')?>" alt="" />
                    <span class='ms-2'>Manpower ratio</span>
                </div>
            </div>
            <!-- Enter Amenity detials section -->
            <div class="main-wrapper-section">
                <div class="container">
                    <div class="row heading">
                        <h3>Enter Amenity requirements</h3>
                    </div>
                    <div class="all-field-cnt px-2">
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Parking facility</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='parking' value="1"  />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='parking' value="0"  />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Security Guard</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='security_guard' value="male" />
                                        <span class='ms-2'>Male</span>
                                    </div>
                                    <div class='border w-50 mx-2  px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='security_guard' value="female" />
                                        <span class='ms-2'>Female</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='security_guard' value="both"  />
                                        <span class='ms-2'>Both</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Lockers</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='lockers' value="1"  />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='lockers' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Waiting area</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='waiting_area' value="1"  />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='waiting_area' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Power Backup</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='power_backup' value="1"  />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='power_backup' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">PH Handicapped</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='ph_handicapped' value="1"  />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='ph_handicapped' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Printer</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='printer' value="1"  />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='printer' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Rough sheet</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='rough_sheet' value="1" />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='rough_sheet' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">Partition</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='partition' value="1" />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='partition' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">AC in lab</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='ac_in_lab' value="1" />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='ac_in_lab' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-6">CCTV required</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='cctv_required' value="1" />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex bg-white'>
                                        <input type="radio" name='cctv_required' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='py-3 px-5 bg-white rounded d-flex align-items-center '>
                            <div class="col-6">CCTV Recording</div>
                            <div class="col-6">
                                <div class='d-flex justify-content-between'>
                                    <div class='border w-50 me-2 px-3 py-2 rounded d-flex '>
                                        <input type="radio" name='cctv_recording' value="1" />
                                        <span class='ms-2'>Yes</span>
                                    </div>
                                    <div class='border w-50 ms-2 px-3 py-2 rounded d-flex '>
                                        <input type="radio" name='cctv_recording' value="0" />
                                        <span class='ms-2'>No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='go-back-next-btn-cnt text-center py-4'>
                        <button type="button" class='go-back-btn createProjectPrevBtn'>Go back</button>
                        <button type="button" class='next-btn createProjectNextBtn'>Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- project Manpower requirements section-->
        <div class="project-manpower-details-wrapper createProjectForm">
            <!-- Manpower navbar section -->
            <div class="row">
                <div class='notification-navbar'>
                    <h2 class='m-0 fs-4'>Create a Project<span>/ Manpower requirements</span></h2>
                    <div>
                        <button class='create-project-btn'><img
                                src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create
                            Project</button>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Manpower infobar section -->
            <div class="row py-3">
                <div class="col-4 active-img-cnt disabled">
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/project-detials-info-01.png')?>" alt="active" />
                    <span class='ms-2 conect-line'>Project details</span>
                </div>
                <div class="col-4 inactive-img-cnt disabled">
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/project-amenity-02.png')?>" alt="inactive" />
                    <span class='ms-2 inactive-img-line'>Amenity requirements</span>
                </div>
                <div class="col-4">
                    <img src="<?php echo base_url('assets/icon-folder/project-icons/project-manpower-ratio-03.png')?>" alt="" />
                    <span class='ms-2'>Manpower ratio</span>
                </div>
            </div>
            <!-- Enter Manpower details section -->
            <div class="main-wrapper-section">
                <div class="container">
                    <div class="row heading">
                        <h3>Enter Manpower/Staff Requirements</h3>
                    </div>
                    <div class="all-field-cnt px-2">
                        <div class="row g-4">

                            <!-- Center Superintendent -->
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="mb-3 fw-bold">Center Superintendent</h6>

                                    <!-- Ratio -->
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-4 col-form-label">No. of Center Superintendent</label>
                                        <div class="col-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-center"
                                                       name="center_suptn_count"
                                                       value="1" 
                                                       onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Person -->
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="mb-3 fw-bold">Technical Person</h6>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-4 col-form-label">No. of Technical Person</label>
                                        <div class="col-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-center"
                                                       name="tech_person_count"
                                                       value="1" 
                                                       onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Invigilator -->
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="mb-3 fw-bold">Invigilator</h6>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-4 col-form-label">Ratio</label>
                                        <div class="col-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-center"
                                                       name="invigilator_ratio_1"
                                                       id="invigilator_ratio_1"
                                                       onkeypress="return isNumberKey(event)" required>
                                                <span class="input-group-text">:</span>
                                                <input type="text" class="form-control text-center"
                                                       name="invigilator_ratio_2"
                                                        id="invigilator_ratio_2"
                                                       onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label">Male</label>
                                            <input type="text" class="form-control"
                                                   name="invigilator_male"
                                                   id="invigilator_male"
                                                   onkeypress="return isNumberKey(event)" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Female</label>
                                            <input type="text" class="form-control"
                                                   name="invigilator_female"
                                                    id="invigilator_female"
                                                   onkeypress="return isNumberKey(event)" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Guard -->
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="mb-3 fw-bold">Security Guard</h6>

                                    <div class="row mb-3 align-items-center">
                                        <label class="col-4 col-form-label">Ratio</label>
                                        <div class="col-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-center"
                                                       name="security_guard_ratio_1"
                                                       id="security_guard_ratio_1"
                                                       onkeypress="return isNumberKey(event)" required>
                                                <span class="input-group-text">:</span>
                                                <input type="text" class="form-control text-center"
                                                       name="security_guard_ratio_2"
                                                       id="security_guard_ratio_2"
                                                       onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label">Male</label>
                                            <input type="text" class="form-control"
                                                   name="security_guard_male"
                                                   onkeypress="return isNumberKey(event)" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Female</label>
                                            <input type="text" class="form-control"
                                                   name="security_guard_female"
                                                   onkeypress="return isNumberKey(event)" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class='go-back-next-btn-cnt text-center py-4'>
                        <button type="button" class='go-back-btn createProjectPrevBtn'>Go back</button>
                        <button id="submitProjectButton" class='next-btn' type="button">Submit</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Right Side Popup (Offcanvas) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="viewProjectDetailModal">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Center Requirements!</h5>
        <button type="button" class="btn-close"
            data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
         <div class="innerHtmlViewProjectDetail">
         </div>
    </div>
</div>


<!-- Eligible center section -->
<div class="eligible-wrapper eligibleCnt">
    <div class="container">
        <div class="row">
            <div class='notification-navbar'>
                <button class='m-0 border-0' id="backButton"><img
                        src="<?php echo base_url('assets/icon-folder/project-icons/previus-arrow.png')?>" alt="" class="me-2">Back
                    to projects</button>
                <div>
                    <button class='create-project-btn createProjectBtn'><img
                            src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create
                        Project</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="innerHtmlProjectDetail">
        
    </div>
</div>

<!-- Approval Page -->
<div class="approveCnt">
    <div class="container">
        <div class="row">
            <div class='notification-navbar'>
                <button class='m-0 border-0' id="backButtonApprove"><img
                        src="<?php echo base_url('assets/icon-folder/project-icons/previus-arrow.png')?>" alt="" class="me-2">Back
                    to eligible centers</button>
                <div>
                    <button class='create-project-btn createProjectBtn'><img
                            src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png')?>" alt="">Create
                        Project</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="Approved-cnt">
        <div class="container">
            <div class="innerHtmlCenterDetail"></div>
        </div>
    </div>
</div>

<!-- ==========================================================
     Client Negotiation Modal
=========================================================== -->

<div class="modal fade"
     id="clientNegotiationModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">

                    <i class="fa fa-handshake-o me-2"></i>

                    Client Price Negotiation

                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="project_id">

                <div class="row">

                    <!-- Original Amount -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Original Amount

                        </label>

                        <input
                            type="text"
                            id="original_amount"
                            class="form-control"
                            readonly>

                    </div>

                    <!-- Final Amount -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Revised Amount

                        </label>

                        <input
                            type="number"
                            id="final_amount"
                            class="form-control"
                            placeholder="Enter Revised Amount">

                    </div>

                </div>

                <!-- Remark -->

                <div class="mb-3">

                    <label class="form-label fw-bold">

                        Negotiation Remark

                    </label>

                    <textarea
                        id="client_remark"
                        rows="4"
                        class="form-control"
                        placeholder="Write reason for revised quotation..."></textarea>

                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">

                    <h6 class="mb-0">

                        Negotiation History

                    </h6>

                    <button
                        type="button"
                        class="btn btn-sm btn-dark"
                        id="loadHistory">

                        <i class="fa fa-history"></i>

                        Load History

                    </button>

                </div>

                <div
                    id="historyArea"
                    class="mt-3">

                    <div class="text-center text-muted py-4">

                        Click

                        <strong>

                            Load History

                        </strong>

                        to view previous negotiations.

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close

                </button>

                <button
                    type="button"
                    id="saveNegotiation"
                    class="btn btn-info">

                    <i class="fa fa-save"></i>

                    Save Negotiation

                </button>

                <button
                    id="btnAcceptOffer"
                    class="btn btn-success">

                    Accept Offer

                </button>

            </div>

        </div>

    </div>

</div>