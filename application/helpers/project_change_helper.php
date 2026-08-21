<?php

if (!function_exists('saveProjectChangeLog')) {

    function saveProjectChangeLog(
        $projectId,
        $cityId,
        $type,
        $oldValue,
        $newValue,
        $updatedBy = 0
    ) {

        $CI =& get_instance();

        $CI->db->insert(
            'tt_project_change_log',
            [
                'project_id'  => $projectId,
                'city_id'     => $cityId,
                'change_type' => $type,
                'old_value'   => json_encode($oldValue),
                'new_value'   => json_encode($newValue),
                'updated_by'  => $updatedBy,
                'created_at'  => date('Y-m-d H:i:s')
            ]
        );

    }

}