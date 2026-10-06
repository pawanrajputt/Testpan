<div class="col-2 p-0 project-aside pe-3">
    <div>
        <button class="cross-icon">✕</button>
        <div class="pt-2 ps-2 pb-2">
            <img src="<?php echo base_url('assets/images/logo.png')?>" style="height: 100px; width: 100px;margin: 0px 50px;">
            <a href="<?php echo base_url('dashboard')?>" class="bookmytestcenter-heading">
                BookMyTestCenter
            </a>
        </div>

        <hr />
        <div class="ps-2  main">
            <!-- <p>GENERAL</p> -->
            <ul>
                <li class="tablecalenderTab <?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : '' ?>">
                    <a href="<?php echo base_url('dashboard')?>">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/radio_button_checked_white.png')?>"
                            alt="radio" class="white-radio" />
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/radio_button_checked_grey.png')?>" alt="radio"
                            class="black-radio" />
                        <span>Projects</span>
                    </a>
                    <p class="createProject" id="createProject">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/radio_button_checked_white.png')?>"
                            alt="radio" class="white-radio me-2" />
                        <span>Create Project</span>
                    </p>
                </li>
                <li class="tablecalenderTab <?= $this->uri->segment(1) == 'my-calendar' ? 'active' : '' ?>">
                    <a href="<?php echo base_url('my-calendar')?>">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/Calendar_grey.png')?>" alt="radio"
                            class="black-radio" />
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/Calendar_white.png')?>" alt="radio"
                            class="white-radio" />
                        <span>Calendar</span>
                    </a>
                </li>
                <li class="tablecalenderTab <?= $this->uri->segment(1) == 'my-settings' ? 'active' : '' ?>">
                    <a href="<?php echo base_url('my-settings')?>">
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/settings.png')?>" alt="radio"
                            class="black-radio" />
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/settings-white.png')?>" alt="radio"
                            class="white-radio" />
                        Settings
                    </a>
                </li>
                <li class="tablecalenderTab">
                    <a href="#" onclick="logoutAC()">
                        <img src="https://cdn-icons-png.flaticon.com/512/450/450387.png" alt="radio" style="height: 25px;width: 18px;background: #2a75ae;" />
                       Logout
                    </a>
                </li>
            </ul>
            <div class="aside-footer-cnt">
                <hr class="line-brake-bottom" />
                <p class="">@2016 | Testpan India Private Limited</p>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-lg-10 px-3 right-section-project dashboard-page">