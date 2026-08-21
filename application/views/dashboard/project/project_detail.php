<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="border p-3 rounded">
                <h2 class="fs-3 mb-1"><?=$project->exam_name ?></h2>
                <div class="d-flex justify-content-between align-items-center my-2">
                    <div>
                        <p class="m-0">Date : <?=$project->start_date ?> - <?=$project->end_date ?></p>
                    </div>
                    <div>
                        <?php
                            $current_date = date('Y-m-d');
                            $start_date = date('Y-m-d', strtotime($project->start_date));
                            $end_date = date('Y-m-d', strtotime($project->end_date));

                            if($current_date < $start_date) {
                                $bstatus = "Upcoming";
                                $bg = "#34ffff";
                            } elseif($current_date >= $start_date && $current_date <= $end_date) {
                                $bstatus = "In progress";
                                $bg = "yellow";
                            } else {
                                $bstatus = "Completed";
                                $bg = "#5df964";
                            }
                        ?>
                        <button class="border-0" style="background:<?=$bg?>;padding: 5px 10px;display: block;text-decoration: none;text-align: center;border-radius: 10px;color: #000;">
                            <img
                                src="<?php echo base_url('assets/icon-folder/project-icons/table-icon-yellow-circle.png')?>"
                                alt="">
                                <?=$bstatus?>
                        </button>
                    </div>
                </div>
                <p class="">
                   Client Name : <?=$project->client_name ?>
                </p>
                <p class="">
                   Exam Type : <?=$project->exam_type ?>
                </p>
            </div>
        </div>
        <?php
            // Avoid division by zero
            if ($number_of_seats > 0) {
                $percentage = ($totalBookedSeat / $number_of_seats) * 100;
            } else {
                $percentage = 0;
            }

            // Round and cap at 100
            $percentage = round(min($percentage, 100), 2);
        ?>
        <div class="col-4 ">
            <div class="border p-3 rounded prosses-bar-bg">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <span class="me-2">
                            <img src="<?= base_url('assets/icon-folder/project-icons/seats-booked-circle.png') ?>" alt="">
                        </span>
                        <span>Seats Booked</span>
                    </div>
                    <div class="d-flex">
                        <span class="me-2">
                            <img src="<?= base_url('assets/icon-folder/project-icons/seats-pending-circle.png') ?>" alt="">
                        </span>
                        <span>Seats Pending</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <!-- Total Required Seats -->
                    <h2 class="fs-3 m-0">
                        <?php 
                            echo ($totalBookedSeat >= $number_of_seats) 
                                ? $number_of_seats 
                                : ($totalBookedSeat);
                        ?>
                    </h2>

                    <!-- Pending Seats -->
                    <h2 class="fs-3 m-0">
                        <?php 
                            echo ($totalBookedSeat >= $number_of_seats) 
                                ? 0 
                                : ($number_of_seats - $totalBookedSeat);
                        ?>
                    </h2>
                </div>

                <!-- Progress Bar -->
                <div class="progress progress-height">
                    <div class="progress-bar Eligible-progress-bar" 
                        role="progressbar"
                        style="width: <?= $percentage ?>%;" 
                        aria-valuenow="<?= $percentage ?>" 
                        aria-valuemin="0"
                        aria-valuemax="100">
                        <?= $percentage ?>%
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="">
                <div class="d-flex border rounded p-3 mb-3">
                    <div><img src="<?php echo base_url('assets/icon-folder/project-icons/Approved-centers.png')?>" alt="">
                    </div>
                    <div class="ms-2">
                        <p class="m-0">Approved Centers</p>
                        <h2 class="fs-2 m-0"><?=$approvedCenter?></h2>
                    </div>
                </div>
                <div class="d-flex border rounded p-3">
                    <div><img src="<?php echo base_url('assets/icon-folder/project-icons/cities-covered.png')?>" alt="">
                    </div>
                    <div class="ms-2">
                        <p class="m-0">Cities Covered</p>
                        <h2 class="fs-2 m-0"><?=$totalCityCovered->total_cities?></h2>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .section-title {
          font-size: 18px;
          font-weight: bold;
          margin-bottom: 15px;
        }

        .centers-container {
          display: flex;
          gap: 15px;
          flex-wrap: wrap;
        }

        .center-box {
          flex: 1 1 200px;
          border: 1px solid #eee;
          border-radius: 8px;
          padding: 15px;
          text-align: center;
          background: #fff;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
          transition: transform 0.2s ease;
        }

        .center-box:hover {
          transform: translateY(-3px);
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .center-icon {
          font-size: 24px;
          color: #1a73e8;
          margin-bottom: 8px;
          display: block;
        }

        .center-name {
          font-size: 16px;
          font-weight: 600;
          margin-bottom: 4px;
        }

        .center-capacity {
          font-size: 14px;
          color: #555;
          margin-bottom: 8px;
        }

        .center-percent {
          font-size: 20px;
          font-weight: bold;
          color: #000;
        }
    </style> 
    <div class="section-title">Assigned Centers</div>
    <div class="centers-container">
        <?php if (!empty($cityWiseSummary)): ?>
          <?php foreach ($cityWiseSummary as $city): 
                $booked = (int)($city['booked_seats'] ?? 0);
                $total  = (int)($city['total_seats'] ?? 0);

                // cap booked at required
                $displayBooked = ($booked > $total) ? $total : $booked;

                // percentage (max 100)
                $percent = ($total > 0) ? round(min(($booked / $total) * 100, 100)) : 0;
            ?>
                <div class="center-box">
                    <span class="center-icon"><i class="fas fa-globe"></i></span>
                    <div class="center-name"><?= htmlspecialchars($city['city_name']) ?></div>
                    <div class="center-capacity"><?= $displayBooked ?>/<?= $total ?></div>
                    <div class="center-percent"><?= $percent ?>%</div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
          <p>No city data found.</p>
        <?php endif; ?>
    </div>
</div>
<div class="container">
    <div class="projectTableContent table-cnt show" id="table3">
        <div class="tableCnt my-3">
            <div class='tableHeading'>
                <div class="filter-download-cnt">
                    <select id="cityFilter" class="form-select" style="width:200px; display:inline-block; margin-right:10px;">
                        <option value="all">All Cities</option>
                        <?php foreach($cities as $city): ?>
                            <option value="<?= $city['city_id'] ?>"><?= htmlspecialchars($city['city_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button"
                            class="exportInternalCenterBtn"
                            data-project-id="<?= $project->project_id ?>">
                        Export
                        <img src="<?= base_url('assets/icon-folder/project-icons/Download.png') ?>" alt="download" />
                    </button>
                </div>
            </div>
            <!-- All table -->
            <table class="mytable">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" class='me-2' />Center
                            name
                        </th>
                        <th scope="col">Seats</th>
                        <th scope="col">City</th>
                        <th scope="col">Availability</th>
                        <th scope="col">Audited</th>
                        <th scope="col">Approval Status</th>
                        <th scope="col">Admin Status</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    if(count($exam_booking_detail) > 0){
                        foreach($exam_booking_detail as $row){
                    ?>
                        <tr data-city-id="<?=$row['city_id']?>">
                            <th scope="row">
                                <div class="approveItemBtns">
                                    <input type="checkbox" class='me-2' id="110" />
                                    <label for="110"><?=$row['center_name']?></label>
                                </div>
                            </th>
                            <td><?=$row['center_seat']?></td>
                            <td><?=$row['city_name']?></td>
                            <td>
                                <a href="#" class='compelet-btn'>
                                    <img
                                        src="<?php echo base_url('assets/icon-folder/project-icons/table-icon-green-circle.png')?>"
                                        alt="table-Icon" />Available
                                    </a>
                            </td>
                            <td>Yes</td>

                             <td>
                                <?php
                                if($row['client_status'] == 0){ ?>
                                <a href="#" class='panding-btn'><img
                                        src="<?php echo base_url('assets/icon-folder/project-icons/table-icon-yellow-circle.png')?>"
                                        alt="table-Icon" />Pending</a>
                                <?php }elseif($row['client_status'] == 2){ ?>
                                <a href="#" class='reject-btn'><img
                                        src="<?php echo base_url('assets/icon-folder/project-icons/table-icon-yellow-circle.png')?>"
                                        alt="table-Icon" />Rejected</a>
                                <?php }else{ ?>
                                    <a href="#" class='compelet-btn'><img
                                        src="<?php echo base_url('assets/icon-folder/project-icons/table-icon-green-circle.png')?>"
                                        alt="table-Icon" />Approved</a>
                                <?php } ?>
                            </td>


                            <td>

                                <?php

                                if(
                                $row['admin_status']==0
                                )
                                {

                                ?>

                                <a
                                href="#"
                                class='panding-btn'>

                                Pending Admin

                                </a>

                                <?php

                                }
                                elseif(
                                $row['admin_status']==2
                                )
                                {

                                ?>

                                <a
                                href="#"
                                class='reject-btn'>

                                Rejected

                                </a>

                                <?php

                                }
                                elseif(
                                $row['admin_status']==3
                                )
                                {

                                ?>

                                <a
                                href="#"
                                class='hold-btn'>

                                Hold

                                </a>

                                <?php

                                }
                                else
                                {

                                ?>

                                <a
                                href="#"
                                class='compelet-btn'>

                                Approved

                                </a>

                                <?php

                                }

                                ?>

                            </td>
                            <td> <a href="#" class="view-btn approveItemBtn" data-center-id="<?=$row['center_id']?>" data-project-id="<?=$project->project_id ?>">View</a></td>

                        </tr>
                    <?php } }else{
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">No Center Found........</td>
                        </tr>
                        <?php
                    } ?>
                </tbody>
            </table>
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
<script>
    document.getElementById('cityFilter').addEventListener('change', function () {
        let selectedCity = this.value;
        let rows = document.querySelectorAll('.mytable tbody tr');

        rows.forEach(row => {
            let cityId = row.getAttribute('data-city-id'); // custom attr we’ll add
            if (selectedCity === 'all' || cityId === selectedCity) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>