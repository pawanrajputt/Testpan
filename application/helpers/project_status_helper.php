<?php

if (!function_exists('getProjectStatusBadge')) {

    function getProjectStatusBadge($project)
    {
        $today = date('Y-m-d');

        $status       = is_array($project) ? $project['status'] : $project->status;
        $manualStatus = is_array($project) ? $project['manual_status'] : $project->manual_status;
        $startDate    = is_array($project) ? $project['start_date'] : $project->start_date;
        $endDate      = is_array($project) ? $project['end_date'] : $project->end_date;

        // Postponed
        if ($manualStatus == 1) {
            return '<span class="badge bg-danger">Postponed</span>';
        }

        // Requirement Completed + End Date Passed
        if ($status == 1) {
            return '<span class="badge bg-success">Completed</span>';
        }

        // Requirement Pending after end date
        if ($status == 2) {
            return '<span class="badge bg-warning text-dark">Requirement Pending</span>';
        }

        // Running
        if ($today >= $startDate && $today <= $endDate) {
            return '<span class="badge bg-primary">Running</span>';
        }

        // Upcoming
        return '<span class="badge bg-info">Upcoming</span>';
    }
}


if (!function_exists('isProjectUpcoming')) {

    function isProjectUpcoming($project)
    {
        $today = date('Y-m-d');

        $status       = is_array($project) ? $project['status'] : $project->status;
        $manualStatus = is_array($project) ? $project['manual_status'] : $project->manual_status;
        $startDate    = is_array($project) ? $project['start_date'] : $project->start_date;

        // Completed OR Requirement Pending
        if ($status == 1 || $status == 2) {
            return false;
        }

        // Postponed
        if ($manualStatus == 1) {
            return false;
        }

        return ($today < $startDate);
    }
}


if (!function_exists('isHaveAnyRemark')) {

    function isHaveAnyRemark($project_remark)
    {
        $result = '';

        if ($project_remark != '') {
            $result = '<p class="mt-2"><strong>Remark: </strong> ' . htmlspecialchars($project_remark) . '</p>';
        }

        return $result;
    }
}


if (!function_exists('getProjectStatusText')) {

    function getProjectStatusText($project)
    {
        $today = date('Y-m-d');

        $status       = is_array($project) ? $project['status'] : $project->status;
        $manualStatus = is_array($project) ? $project['manual_status'] : $project->manual_status;
        $startDate    = is_array($project) ? $project['start_date'] : $project->start_date;
        $endDate      = is_array($project) ? $project['end_date'] : $project->end_date;

        // Postponed
        if ($manualStatus == 1) {
            return 'Postponed';
        }

        // Completed
        if ($status == 1) {
            return 'Completed';
        }

        // Requirement Pending
        if ($status == 2) {
            return 'Requirement Pending';
        }

        // Upcoming
        if ($today < $startDate) {
            return 'Upcoming';
        }

        // Running
        if ($today >= $startDate && $today <= $endDate) {
            return 'Running';
        }

        return 'Upcoming';
    }
}


if (!function_exists('syncProjectStatuses')) {

    function syncProjectStatuses()
    {
        $CI = &get_instance();

        // Prevent multiple execution in same request
        static $alreadyRun = false;

        if ($alreadyRun) {
            return;
        }

        $alreadyRun = true;

        // ============================================================
        // STEP 1: Find projects which are becoming COMPLETED
        // ============================================================

        /*
         * IMPORTANT:
         * We first identify projects which:
         *
         * 1. End date has passed
         * 2. Required seats > 0
         * 3. Fully allocated
         * 4. At least one project detail row is not already completed
         *
         * This prevents sending duplicate notifications every time
         * syncProjectStatuses() runs.
         */

        $completedProjectsSql = "
            SELECT
                x.project_id,
                pd.exam_name,
                pd.client_name
            FROM (
                SELECT
                    p.project_id,

                    SUM(p.required_seats) AS total_required,

                    SUM(
                        CASE
                            WHEN p.required_seats <= IFNULL(a.allocated_capacity, 0)
                            THEN p.required_seats
                            ELSE IFNULL(a.allocated_capacity, 0)
                        END
                    ) AS total_allocated

                FROM (
                    SELECT
                        project_id,
                        exam_city_id,
                        SUM(number_of_seats) AS required_seats
                    FROM tt_project_detail
                    WHERE deleted = 0
                    GROUP BY project_id, exam_city_id
                ) p

                LEFT JOIN (
                    SELECT
                        project_id,
                        city_id,
                        SUM(center_seat) AS allocated_capacity
                    FROM tt_send_booking_request
                    WHERE exam_center_status = 1
                      AND client_status = 1
                      AND admin_status = 1
                    GROUP BY project_id, city_id
                ) a
                    ON a.project_id = p.project_id
                    AND a.city_id = p.exam_city_id

                GROUP BY p.project_id

            ) x

            INNER JOIN (
                SELECT
                    project_id,
                    MAX(exam_name) AS exam_name,
                    MAX(client_name) AS client_name,
                    MAX(end_date) AS end_date,

                    SUM(
                        CASE
                            WHEN status != 1 THEN 1
                            ELSE 0
                        END
                    ) AS pending_status_rows

                FROM tt_project_detail
                WHERE deleted = 0
                GROUP BY project_id

            ) pd
                ON pd.project_id = x.project_id

            WHERE pd.end_date < CURDATE()
              AND x.total_required > 0
              AND x.total_allocated >= x.total_required
              AND pd.pending_status_rows > 0
        ";

        $completedProjects = $CI->db
            ->query($completedProjectsSql)
            ->result();


        // ============================================================
        // STEP 2: Update COMPLETED Projects
        // ============================================================

        /*
         * Keep the existing completion logic.
         */

        $completedSql = "
            UPDATE tt_project_detail pd

            JOIN (
                SELECT
                    p.project_id,

                    SUM(p.required_seats) AS total_required,

                    SUM(
                        CASE
                            WHEN p.required_seats <= IFNULL(a.allocated_capacity, 0)
                            THEN p.required_seats
                            ELSE IFNULL(a.allocated_capacity, 0)
                        END
                    ) AS total_allocated

                FROM (
                    SELECT
                        project_id,
                        exam_city_id,
                        SUM(number_of_seats) AS required_seats
                    FROM tt_project_detail
                    WHERE deleted = 0
                    GROUP BY project_id, exam_city_id
                ) p

                LEFT JOIN (
                    SELECT
                        project_id,
                        city_id,
                        SUM(center_seat) AS allocated_capacity
                    FROM tt_send_booking_request
                    WHERE exam_center_status = 1
                      AND client_status = 1
                      AND admin_status = 1
                    GROUP BY project_id, city_id
                ) a
                    ON a.project_id = p.project_id
                    AND a.city_id = p.exam_city_id

                GROUP BY p.project_id

            ) x
                ON x.project_id = pd.project_id

            SET pd.status = 1

            WHERE pd.deleted = 0
              AND pd.end_date < CURDATE()
              AND x.total_required > 0
              AND x.total_allocated >= x.total_required
              AND pd.status != 1
        ";

        $CI->db->query($completedSql);


        // ============================================================
        // STEP 3: Send PROJECT COMPLETED notification
        // ============================================================

        /*
         * Notification is sent only for projects found in STEP 1.
         *
         * Therefore:
         *
         * First run:
         * status 2 -> status 1 -> notification
         *
         * Next run:
         * project already status 1 -> not selected in STEP 1
         * -> no duplicate notification
         */

        if (!empty($completedProjects)) {

            $CI->load->library('NotificationService');
            $CI->load->model('FirebaseNotification_model');

            foreach ($completedProjects as $project) {

                // ----------------------------------------------------
                // Get all successfully assigned centers for this project
                // ----------------------------------------------------

                $centerRows = $CI->db
                    ->select('
                        sbr.center_id,
                        c.center_name,
                        c.owner_user_id
                    ')
                    ->from('tt_send_booking_request sbr')
                    ->join(
                        'tt_center c',
                        'c.center_id = sbr.center_id',
                        'inner'
                    )
                    ->where('sbr.project_id', $project->project_id)
                    ->where('sbr.exam_center_status', 1)
                    ->where('sbr.client_status', 1)
                    ->where('sbr.admin_status', 1)
                    ->where('c.owner_user_id IS NOT NULL', null, false)
                    ->group_by([
                        'sbr.center_id',
                        'c.center_name',
                        'c.owner_user_id'
                    ])
                    ->get()
                    ->result();


                // ----------------------------------------------------
                // No assigned centers
                // ----------------------------------------------------

                if (empty($centerRows)) {
                    continue;
                }


                // ----------------------------------------------------
                // Send notification to each center owner
                // ----------------------------------------------------

                foreach ($centerRows as $center) {

                    if (empty($center->owner_user_id)) {
                        continue;
                    }


                    // Get owner's active Firebase device tokens
                    $tokens = $CI->FirebaseNotification_model
                        ->getActiveTokensByUserId(
                            $center->owner_user_id
                        );


                    // Owner has no active device
                    if (empty($tokens)) {
                        continue;
                    }


                    // Notification message
                    $description = sprintf(
                        'Congratulations! Your center "%s" has successfully completed the project "%s".',
                        $center->center_name,
                        $project->exam_name
                    );


                    // Send Firebase notification
                    $notificationResponse = $CI->notificationservice
                        ->sendNotification(
                            'Congratulations! Project Completed',
                            $description,
                            null,
                            $project->project_id,
                            'project_completed',
                            'project_detail',
                            $tokens
                        );


                    // Log notification result
                    log_message(
                        'info',
                        'Project Completed Notification | ' .
                            'Project ID: ' . $project->project_id .
                            ' | Center ID: ' . $center->center_id .
                            ' | Owner ID: ' . $center->owner_user_id .
                            ' | Response: ' . json_encode($notificationResponse)
                    );
                }
            }
        }


        // ============================================================
        // STEP 4: Requirement Pending
        // ============================================================

        /*
         * Existing pending logic remains unchanged.
         */

        $pendingSql = "
            UPDATE tt_project_detail pd

            JOIN (
                SELECT
                    p.project_id,

                    SUM(p.required_seats) AS total_required,

                    SUM(
                        CASE
                            WHEN p.required_seats <= IFNULL(a.allocated_capacity, 0)
                            THEN p.required_seats
                            ELSE IFNULL(a.allocated_capacity, 0)
                        END
                    ) AS total_allocated

                FROM (
                    SELECT
                        project_id,
                        exam_city_id,
                        SUM(number_of_seats) AS required_seats
                    FROM tt_project_detail
                    WHERE deleted = 0
                    GROUP BY project_id, exam_city_id
                ) p

                LEFT JOIN (
                    SELECT
                        project_id,
                        city_id,
                        SUM(center_seat) AS allocated_capacity
                    FROM tt_send_booking_request
                    WHERE exam_center_status = 1
                      AND client_status = 1
                      AND admin_status = 1
                    GROUP BY project_id, city_id
                ) a
                    ON a.project_id = p.project_id
                    AND a.city_id = p.exam_city_id

                GROUP BY p.project_id

            ) x
                ON x.project_id = pd.project_id

            SET pd.status = 2

            WHERE pd.deleted = 0
              AND pd.end_date < CURDATE()
              AND (
                    x.total_allocated < x.total_required
                    OR x.total_allocated IS NULL
              )
              AND pd.status != 2
        ";

        $CI->db->query($pendingSql);
    }


    if (!function_exists('sendExamReminders')) {

        function sendExamReminders()
        {
            $CI = &get_instance();

            // Prevent multiple execution in same request
            static $alreadyRun = false;

            if ($alreadyRun) {
                return;
            }

            $alreadyRun = true;

            /*
         * ============================================================
         * Configuration
         * ============================================================
         */

            // Exam se kitne hours pehle notification bhejni hai
            $reminderHours = 4;

            /*
         * Cron agar every 5 minutes run ho raha hai,
         * to 10 minutes ka window safe rahega.
         *
         * Example:
         * Exam = 10:00 AM
         * Reminder target = 06:00 AM
         *
         * Agar cron 06:00, 06:05, 06:10 par run kare:
         * notification sirf first matching run par jayegi.
         */
            $windowMinutes = 10;


            /*
         * ============================================================
         * Find exams which are approximately 4 hours away
         * ============================================================
         *
         * tt_project_detail
         *      ↓
         * project_id + city
         *      ↓
         * tt_project_batch_detail
         *      ↓
         * batch_start
         *      ↓
         * tt_send_booking_request
         *      ↓
         * assigned center
         *      ↓
         * center owner
         */

            $sql = "
            SELECT
                sbr.id AS booking_id,
                sbr.project_id,
                sbr.city_id,
                sbr.center_id,

                pd.exam_name,
                pd.client_name,
                pd.start_date,
                pd.end_date,

                c.center_name,
                c.owner_user_id,

                b.id AS batch_id,
                b.batch_no,
                b.batch_start,
                b.batch_end

            FROM tt_send_booking_request sbr

            INNER JOIN tt_project_detail pd
                ON pd.project_id = sbr.project_id
                AND pd.exam_city_id = sbr.city_id

            INNER JOIN tt_project_batch_detail b
                ON b.project_id = sbr.project_id
                AND b.city_id = sbr.city_id

            INNER JOIN tt_center c
                ON c.center_id = sbr.center_id

            WHERE sbr.exam_center_status = 1
              AND sbr.client_status = 1
              AND sbr.admin_status = 1

              AND pd.deleted = 0

              AND c.owner_user_id IS NOT NULL

              /*
               * Exam start time should be approximately
               * 4 hours from current time.
               */
              AND TIMESTAMP(pd.start_date, b.batch_start)
                    BETWEEN
                        DATE_ADD(NOW(), INTERVAL {$reminderHours} HOUR)
                    AND
                        DATE_ADD(
                            NOW(),
                            INTERVAL " . ($reminderHours * 60 + $windowMinutes) . " MINUTE
                        )

            ORDER BY
                pd.start_date ASC,
                b.batch_start ASC,
                sbr.center_id ASC
        ";

            $exams = $CI->db
                ->query($sql)
                ->result();


            /*
         * ============================================================
         * No upcoming exam reminder
         * ============================================================
         */

            if (empty($exams)) {
                return;
            }


            /*
         * ============================================================
         * Load Notification Services
         * ============================================================
         */

            $CI->load->library('NotificationService');
            $CI->load->model('FirebaseNotification_model');


            /*
         * ============================================================
         * Process each exam / center / batch
         * ============================================================
         */

            foreach ($exams as $exam) {

                if (empty($exam->owner_user_id)) {
                    continue;
                }


                /*
             * ========================================================
             * Unique notification check
             * ========================================================
             *
             * Same batch + same center + same exam date
             * should receive notification only once.
             */

                $notificationTitle = 'Exam Reminder';

                $examDateFormatted = date(
                    'd M Y',
                    strtotime($exam->start_date)
                );

                $batchTime = date(
                    'h:i A',
                    strtotime($exam->batch_start)
                );


                $notificationMessage = sprintf(
                    'Your center has an exam scheduled today at %s. Exam: %s, Batch: %s.',
                    $batchTime,
                    $exam->exam_name,
                    $exam->batch_no
                );


                /*
             * Check existing in-app notification.
             *
             * We use owner + center + project + batch information
             * through the notification message to avoid duplicates.
             */

                $alreadySent = $CI->db
                    ->where('admin_user_id', $exam->owner_user_id)
                    ->where('center_id', $exam->center_id)
                    ->where('title', $notificationTitle)
                    ->where('message', $notificationMessage)
                    ->where(
                        'DATE(created_at)',
                        date('Y-m-d', strtotime($exam->start_date))
                    )
                    ->limit(1)
                    ->get('notifications')
                    ->row();


                if ($alreadySent) {
                    continue;
                }


                /*
             * ========================================================
             * Get owner's active Firebase tokens
             * ========================================================
             */

                $tokens = $CI->FirebaseNotification_model
                    ->getActiveTokensByUserId(
                        $exam->owner_user_id
                    );


                /*
             * ========================================================
             * Create in-app notification
             * ========================================================
             *
             * This is independent of Firebase.
             * Even if Firebase fails, notification can remain
             * available inside the portal/app notification list.
             */

                $notificationData = [
                    'admin_user_id' => $exam->owner_user_id,
                    'center_id'     => $exam->center_id,
                    'client_id'     => null,
                    'title'         => $notificationTitle,
                    'message'       => $notificationMessage,
                    'type'          => 'center',
                    'is_read'       => 0,
                    'is_remove'     => 0,
                    'created_at'    => date('Y-m-d H:i:s')
                ];

                $CI->db->insert(
                    'notifications',
                    $notificationData
                );


                /*
             * ========================================================
             * Firebase Push Notification
             * ========================================================
             */

                if (!empty($tokens)) {

                    $firebaseResponse = $CI->notificationservice
                        ->sendNotification(
                            $notificationTitle,
                            $notificationMessage,
                            null,
                            $exam->booking_id,
                            'exam_reminder',
                            'booking_detail',
                            $tokens
                        );


                    /*
                 * Log Firebase response.
                 *
                 * Firebase failure should NOT stop processing
                 * other centers / batches.
                 */

                    log_message(
                        'info',
                        'Exam Reminder Notification | ' .
                            'Booking ID: ' . $exam->booking_id .
                            ' | Project ID: ' . $exam->project_id .
                            ' | Center ID: ' . $exam->center_id .
                            ' | Owner ID: ' . $exam->owner_user_id .
                            ' | Batch ID: ' . $exam->batch_id .
                            ' | Batch No: ' . $exam->batch_no .
                            ' | Response: ' . json_encode($firebaseResponse)
                    );
                }
            }
        }
    }
    
}
