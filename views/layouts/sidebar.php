<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="#" class="app-brand-link">
                    <?php if (!empty($header_logo)) : ?>
                        <img src="<?= base_url('uploads/settings/' . $header_logo->setting_value); ?>" 
                             alt="Logo" 
                             style="    max-height: 80px;width: 110px;object-fit: cover;margin-top: 5px;margin-left: 45px;">
                    <?php endif; ?>
                </a>
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
                    <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>
            <?php
                $currentUri = uri_string();
            ?>
            <ul class="menu-inner py-1">

                <!-- ================= Dashboard ================= -->
                <li class="menu-item <?= ($currentUri == 'admin/dashboard') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-smart-home"></i>
                        <div>Dashboard</div>
                    </a>
                </li>


                <!-- ================= Clients ================= -->
                <?php if (has_permission('client_list') || has_permission('client_project')): ?>
                <li class="menu-item <?= in_array($currentUri, ['admin/clients','admin/client-projects','admin/project-planner']) ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div>My Clients</div>
                        <div class="badge bg-danger rounded-pill ms-auto">3</div>
                    </a>

                    <ul class="menu-sub">

                        <?php if (has_permission('client_list')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/clients') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/clients') ?>" class="menu-link">
                                <div>Client List</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('client_project')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/client-projects') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/client-projects') ?>" class="menu-link">
                                <div>Client Project</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('client_project')): ?>
                            <li class="menu-item <?= ($currentUri == 'admin/project-planner') ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/project-planner') ?>" class="menu-link">
                                    <div>Project Planner</div>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php endif; ?>


                <!-- ================= Centers ================= -->
                <?php if (
                    has_permission('owner_list') ||
                    has_permission('center_list') ||
                    has_permission('deleted_center') ||
                    has_permission('center_edit_request') ||
                    has_permission('center_calendar') ||
                    has_permission('center_availability')
                ): ?>
                <li class="menu-item <?= strpos($currentUri, 'admin/center') !== false || in_array($currentUri, ['admin/deleted-centers']) ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building"></i>
                        <div>Manage Centers</div>
                        <div class="badge bg-danger rounded-pill ms-auto">6</div>
                    </a>

                    <ul class="menu-sub">

                        <?php if (has_permission('owner_list')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/center-owners') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/center-owners') ?>" class="menu-link">
                                <div>Owner List</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('center_list')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/centers') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/centers') ?>" class="menu-link">
                                <div>Center List</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('deleted_center')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/deleted-centers') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/deleted-centers') ?>" class="menu-link">
                                <div>Deleted Center</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('center_edit_request')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/center-edit-request') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/center-edit-request') ?>" class="menu-link">
                                <div>Center Edit Requests</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('center_calendar')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/center-calendar') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/center-calendar') ?>" class="menu-link">
                                <div>Booking Calendar</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('center_availability')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/center-availability') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/center-availability') ?>" class="menu-link">
                                <div>Center Availability</div>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php endif; ?>


                <!-- ================= News ================= -->
                <?php if (has_permission('custom_news')): ?>
                <li class="menu-item <?= ($currentUri == 'admin/custom-news') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/custom-news') ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-news"></i>
                        <div>Custom News</div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- ================= Subscription ================= -->
                <?php if (has_permission('custom_setting')): ?>
                <li class="menu-item <?= in_array($currentUri, ['admin/subscription-packages','admin/transaction-package']) ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div>Subscription Package</div>
                        <div class="badge bg-danger rounded-pill ms-auto">2</div>
                    </a>

                    <ul class="menu-sub">

                        <?php if (has_permission('custom_setting')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/subscription-packages') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/subscription-packages') ?>" class="menu-link">
                                <div>Package List</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('custom_setting')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/transaction-package') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/transaction-package') ?>" class="menu-link">
                                <div>Transaction History</div>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php endif; ?>


                <!-- ================= CMS ================= -->
                <?php if (has_permission('cms_management')): ?>
                <li class="menu-item <?= ($currentUri == 'admin/cms') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/cms') ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-menu"></i>
                        <div>CMS</div>
                    </a>
                </li>
                <?php endif; ?>


                <!-- ================= Settings ================= -->
                <?php if (has_permission('custom_setting')): ?>
                <li class="menu-item <?= ($currentUri == 'admin/custom-settings') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/custom-settings') ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <div>Custom Setting</div>
                    </a>
                </li>
                <?php endif; ?>


                <!-- ================= Roles ================= -->
                <?php if (has_permission('role_list') || has_permission('subadmin_list')): ?>
                <!-- <li class="menu-item <?= in_array($currentUri, ['admin/roles','admin/subadmins']) ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div>Roles & Permissions</div>
                        <div class="badge bg-danger rounded-pill ms-auto">2</div>
                    </a>

                    <ul class="menu-sub">

                        <?php if (has_permission('role_list')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/roles') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/roles') ?>" class="menu-link">
                                <div>Role List</div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_permission('subadmin_list')): ?>
                        <li class="menu-item <?= ($currentUri == 'admin/subadmins') ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/subadmins') ?>" class="menu-link">
                                <div>Subadmin List</div>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </li> -->
                <?php endif; ?>

            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="ti ti-menu-2 ti-md"></i>
                    </a>
                </div>
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Brand -->
                    <div class="dashboard-brand">
                        <div class="brand-title">
                            BookMyTestCenter
                        </div>
                        <div class="brand-subtitle">
                            Booking Management Portal
                        </div>
                    </div>
                    <ul class="navbar-nav flex-row align-items-center ms-auto">


                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                            <a
                              class="nav-link dropdown-toggle hide-arrow"
                              href="javascript:void(0);"
                              data-bs-toggle="dropdown"
                              data-bs-auto-close="outside"
                              aria-expanded="false">
                              <i class="ti ti-bell ti-md"></i>
                              <span class="badge bg-danger rounded-pill badge-notifications"><?= $this->admin_unread_count ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                      <h5 class="text-body mb-0 me-auto">Notification</h5>
                                      <a
                                        href="javascript:void(0)"
                                        class="dropdown-notifications-all text-body"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Mark as Read"
                                        ><i class="ti ti-mail-opened fs-4"></i
                                      ></a>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container">
                                    <ul class="list-group list-group-flush">
                                        <?php if(!empty($this->admin_notifications)) : ?>
                                            <?php foreach($this->admin_notifications as $row): ?>
                                                <li class="list-group-item list-group-item-action dropdown-notifications-item" id="notif_<?= $row->id ?>">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1"><?= $row->title ?></h6>
                                                            <p class="mb-0"><?= $row->message ?></p>
                                                            <small class="text-muted">
                                                                <?= timespan(strtotime($row->created_at), time(), 1) ?> ago
                                                            </small>
                                                        </div>

                                                        <div class="flex-shrink-0 dropdown-notifications-actions">

                                                            <?php if($row->admin_is_read == 0): ?>
                                                                <a href="javascript:void(0)" 
                                                                   class="mark-read" 
                                                                   data-id="<?= $row->id ?>">
                                                                    <span class="badge badge-dot bg-danger"></span>
                                                                </a>
                                                            <?php endif; ?>

                                                            <a href="javascript:void(0)" 
                                                               class="remove-notification"
                                                               data-id="<?= $row->id ?>">
                                                                <span class="ti ti-x"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="text-center p-3">No Notifications</li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php if($this->admin_total_count > 20): ?>
                                <li class="dropdown-menu-footer border-top">
                                    <a href="<?= base_url('admin/notifications') ?>"
                                       class="dropdown-item d-flex justify-content-center text-primary p-2">
                                        View All Notifications
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <!--/ Notification -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <i class="fa fa-user"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item mt-0" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar avatar-online">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0"><?=$this->session->userdata('admin_user')['username'];?></h6>
                                                <small class="text-muted"></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1 mx-n2"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?=base_url('admin/profile')?>">
                                        <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="d-grid px-2 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex" href="<?= base_url('admin/logout') ?>">
                                            <small class="align-middle">Logout</small>
                                            <i class="ti ti-logout ms-2 ti-14px"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>

                <!-- Search Small Screens -->
                <div class="navbar-search-wrapper search-input-wrapper d-none">
                    <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
                        aria-label="Search..." />
                    <i class="ti ti-x search-toggler cursor-pointer"></i>
                </div>
            </nav>

            <!-- / Navbar -->
            <!-- Content wrapper -->
            <div class="content-wrapper">