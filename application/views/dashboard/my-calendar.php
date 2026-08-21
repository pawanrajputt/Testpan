<div class="tablecalenderContent show">
    <div class="calender-wrapper">
        <div class="container">
            <div class="row">
                <div class='notification-navbar'>
                    <h2 class='m-0 fs-4'>My Calendar</h2>
                    <div>
                        <a href="<?php echo base_url('dashboard') ?>">
                            <button class='create-project-btn createProjectBtn'><img src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png') ?>" alt="">Create Project</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <!-- Flash Message -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success mt-2"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger mt-2"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8 py-4">
                    <div class='project-create-cnt'>
                        <ul class='px-0 w-50 justify-contant-start'>
                            <li><a href="#" class='all-project-tab active-tab' id="upcoming-tab">Upcoming<span class='ms-2'><?=
                                                                                                                            array_sum(array_map(function ($events) {
                                                                                                                                return count(array_filter($events, function ($event) {
                                                                                                                                    return (new DateTime($event->start_date)) >= new DateTime();
                                                                                                                                }));
                                                                                                                            }, $monthlyEvents))
                                                                                                                            ?></span></a></li>
                            <li><a href="#" class='me-5' id="past-tab">Past<span class='ms-2'><?=
                                                                                                array_sum(array_map(function ($events) {
                                                                                                    return count(array_filter($events, function ($event) {
                                                                                                        return (new DateTime($event->end_date)) < new DateTime();
                                                                                                    }));
                                                                                                }, $monthlyEvents))
                                                                                                ?></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class='tableHeading'>
            <div class='exam-name-input-cnt'>
                <img src="<?php echo base_url('assets/icon-folder/project-icons/search.png') ?>" alt="" style="position: absolute;top: 45px;left: 35px;" />
                <input type='text' placeholder='Enter exam name..' id="exam-search" />
            </div>
            <div class='filter-download-cnt'>
                <select id="filter-by">
                    <option value="">Filter By</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                <select id="sort-by">
                    <option value="">Sort By</option>
                    <option value="date-asc">Date (Oldest First)</option>
                    <option value="date-desc">Date (Newest First)</option>
                </select>
                <button id="export-btn">Export <img src="<?php echo base_url('assets/icon-folder/project-icons/Download.png') ?>" alt="download" /></button>
            </div>
        </div>
        <div class="container">
            <!-- Upcoming Events Section -->
            <div id="upcoming-events">
                <?php
                $hasUpcomingEvents = false;
                foreach ($monthlyEvents as $monthYear => $events):
                    $upcomingEvents = array_filter($events, function ($event) {
                        $today = new DateTime();
                        $startDate = new DateTime($event->start_date);
                        return $startDate >= $today;
                    });
                    if (!empty($upcomingEvents)):
                        $hasUpcomingEvents = true;
                ?>
                        <div class='main-calender-cnt mb-3'>
                            <p class='mt-4 mb-3'><?php echo $monthYear; ?></p>

                            <?php foreach ($upcomingEvents as $event):
                                $this->load->view('dashboard/partials/event_card', ['event' => $event]);
                            endforeach; ?>
                        </div>
                    <?php
                    endif;
                endforeach;
                if (!$hasUpcomingEvents): ?>
                    <div class="alert alert-info">No upcoming events found.</div>
                <?php endif; ?>
            </div>

            <!-- Past Events Section (initially hidden) -->
            <div id="past-events" style="display: none;">
                <?php
                $hasPastEvents = false;
                foreach ($monthlyEvents as $monthYear => $events):
                    $pastEvents = array_filter($events, function ($event) {
                        $today = new DateTime();
                        $endDate = new DateTime($event->end_date);
                        return $endDate < $today;
                    });
                    if (!empty($pastEvents)):
                        $hasPastEvents = true;
                ?>
                        <div class='main-calender-cnt mb-3'>
                            <p class='mt-4 mb-3'><?php echo $monthYear; ?></p>

                            <?php foreach ($pastEvents as $event):
                                $this->load->view('dashboard/partials/event_card', ['event' => $event, 'isPast' => true]);
                            endforeach; ?>
                        </div>
                    <?php
                    endif;
                endforeach;
                if (!$hasPastEvents): ?>
                    <div class="alert alert-info">No past events found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Pop-up section -->
    <div class="main-share-cnt fade">
    </div>
</div>