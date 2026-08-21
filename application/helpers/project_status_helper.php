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