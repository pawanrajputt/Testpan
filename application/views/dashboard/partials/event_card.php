<?php
$startDate = new DateTime($event->start_date);
$endDate = new DateTime($event->end_date);
$today = new DateTime();
$daysLeft = $endDate < $today ? 'Booking Completed' : $today->diff($startDate)->days .' days left';


$project_id = $event->project_id;

// Safe query for cities count
$totalCityCovered = $this->db->query(
    "SELECT COUNT(DISTINCT exam_city_id) AS total_cities 
     FROM tt_project_detail 
     WHERE project_id = ?", 
    [$project_id]
)->row()->total_cities;

// Safe query for centers count
$centerBooked = $this->db->query(
    "SELECT COUNT(DISTINCT center_id) AS total_booked_center 
     FROM tt_send_booking_request 
     WHERE project_id = ?", 
    [$project_id]
)->row()->total_booked_center;

// Get candidates assessed from project_detail (number_of_seats)
$candidatesAssessed = $event->number_of_seats;

// Get all assigned centers for this project
$assignedCenters = $this->db->query(
    "SELECT c.center_name, r.center_booking_accept_date
     FROM tt_center c
     JOIN tt_send_booking_request r ON c.center_id = r.center_id
     WHERE r.project_id = ?", 
    [$project_id]
)->result();


$centerArray = [];
foreach ($assignedCenters as $ac) {
    $centerArray[] = [
        'id'   => $ac->center_id,
        'name' => $ac->center_name,
        'date' => !empty($ac->center_booking_accept_date) 
                    ? date('M d, Y', strtotime($ac->center_booking_accept_date)) 
                    : 'N/A'
    ];
}

$centerJson = htmlspecialchars(json_encode($centerArray));


$current_date = date('Y-m-d');
$start_date = date('Y-m-d', strtotime($event->start_date));
$end_date = date('Y-m-d', strtotime($event->end_date));

if($current_date < $start_date) {
    $bstatus = "Upcoming";
} elseif($current_date >= $start_date && $current_date <= $end_date) {
    $bstatus = "In progress";
} else {
    $bstatus = "Completed";
}
?>

<div class='border rounded d-flex mb-3 <?= isset($isPast) && $isPast ? 'past-event' : '' ?>' id="popupButton"
    data-assign-centers='<?php echo $centerJson; ?>'
    data-exam-status="<?=$bstatus?>"
    data-exam-name="<?php echo htmlspecialchars($event->exam_name); ?>"
    data-start-date="<?php echo $event->start_date; ?>"
    data-end-date="<?php echo $event->end_date; ?>"
    data-days-left="<?php echo $daysLeft; ?>"
    data-centers-booked="<?php echo $centerBooked; ?>"
    data-candidates-assessed="<?php echo number_format($event->total_required); ?>"
    data-cities-covered="<?php echo $event->total_cities; ?>"
    data-city-names="<?php echo htmlspecialchars($event->city_names); ?>"
    data-assessed="<?php echo $event->total_required; ?>"
    data-booked="<?php echo $event->total_booked; ?>"
    data-description="<?php echo htmlspecialchars($event->exam_type_detail); ?>">

    <div class='d-flex justify-content-center align-items-center w-25 bg-light border-right'>
        <div class='py-3'>
            <p class='m-0'><?php echo $startDate->format('D'); ?></p>
            <h2 class='mb-3 fs-2'><?php echo $startDate->format('M-d') . ' to ' . $endDate->format('M-d'); ?></h2>
            <p class='m-0'><?php echo $daysLeft; ?></p>
        </div>
    </div>
    <div class='d-flex justify-content-between w-75 px-3 align-items-center'>
        <div>
            <div class='d-flex align-items-center py-3'>
                <h2 class='m-0'><?php echo $event->exam_name; ?></h2>
                <button class='booked-btn'>Booked Center</button>
                <button class='panding-calender-btn <?= $bstatus === "Completed" ? "completed-btn" : "" ?>'><?=$bstatus?></button>
            </div>
            <div class='d-flex py-3 justify-content-between'>
                <div class='d-flex align-items-center '>
                    <div class='me-2'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/calender.png'); ?>" alt="" />
                    </div>
                    <div class='d-flex align-items-center justify-content-between'>
                        <div>
                            <h2 class='m-0'><?php echo $centerBooked; ?></h2>
                            <p class='m-0'>Centers booked</p>
                        </div>
                    </div>
                </div>
                <div class='d-flex align-items-center ms-5'>
                    <div class='me-2'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/calender-user.png'); ?>" alt="" />
                    </div>
                    <div class='d-flex align-items-center justify-content-between'>
                        <div class=''>
                            <h2 class='m-0'><?php echo number_format($event->total_required); ?></h2>
                            <p class='m-0'>Candidates assessed</p>
                        </div>
                    </div>
                </div>
                <div class='d-flex align-items-center ms-5'>
                    <div class='me-2'>
                        <img src="<?php echo base_url('assets/icon-folder/project-icons/calender-user.png'); ?>" alt="" />
                    </div>
                    <div class='d-flex align-items-center justify-content-between'>
                        <div>
                            <h2 class='m-0'><?php echo $totalCityCovered; ?></h2>
                            <p class='m-0'>Cities covered</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <img src="<?php echo base_url('assets/icon-folder/project-icons/aside circle.png'); ?>" alt="" />
        </div>
    </div>
</div>