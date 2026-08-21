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
        $CI =& get_instance();

        // Prevent multiple execution in same request
        static $alreadyRun = false;

        if ($alreadyRun) {
            return;
        }

        $alreadyRun = true;

        // ============================
        // STEP 1: Completed Projects
        // ============================

        $completedSql = "
            UPDATE tt_project_detail pd
            JOIN (
                SELECT
                    p.project_id,
                    SUM(p.required_seats) AS total_required,
                    SUM(
                        CASE
                            WHEN p.required_seats <= IFNULL(a.allocated_capacity,0)
                            THEN p.required_seats
                            ELSE IFNULL(a.allocated_capacity,0)
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
            ) x ON x.project_id = pd.project_id
            SET pd.status = 1
            WHERE pd.deleted = 0
              AND pd.end_date < CURDATE()
              AND x.total_required > 0
              AND x.total_allocated >= x.total_required
              AND pd.status != 1
        ";

        $CI->db->query($completedSql);

        // ============================
        // STEP 2: Requirement Pending
        // ============================

        $pendingSql = "
            UPDATE tt_project_detail pd
            JOIN (
                SELECT
                    p.project_id,
                    SUM(p.required_seats) AS total_required,
                    SUM(
                        CASE
                            WHEN p.required_seats <= IFNULL(a.allocated_capacity,0)
                            THEN p.required_seats
                            ELSE IFNULL(a.allocated_capacity,0)
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
            ) x ON x.project_id = pd.project_id
            SET pd.status = 2
            WHERE pd.deleted = 0
              AND pd.end_date < CURDATE()
              AND (x.total_allocated < x.total_required OR x.total_allocated IS NULL)
              AND pd.status != 2
        ";

        $CI->db->query($pendingSql);
    }
}