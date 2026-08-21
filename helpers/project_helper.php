<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Get Project Seat Allocation
 *
 * Project level:
 *      getProjectSeatAllocation($projectId)
 *
 * City level:
 *      getProjectSeatAllocation($projectId, $cityId)
 *
 * IMPORTANT:
 * Project ID is a STRING value.
 *
 * Example:
 *      VARU-AIMA-31-08-2026
 *
 * Allocation logic is kept same as Project Planner:
 *      admin_status = 1
 *
 * @param string $projectId
 * @param int|null $cityId
 * @return array
 */

if (!function_exists('getProjectSeatAllocation')) {

    function getProjectSeatAllocation($projectId, $cityId = NULL)
    {
        $CI = &get_instance();


        // =====================================================
        // PROJECT ID
        // IMPORTANT:
        // Do NOT cast project_id to integer.
        // Project IDs are strings.
        // =====================================================

        $projectId = trim((string)$projectId);


        if ($projectId === '') {

            return [
                'required'  => 0,
                'allocated' => 0,
                'percent'   => 0,
                'status'    => 'Pending',
                'badge'     => '<span class="badge bg-danger">Pending</span>'
            ];
        }


        // =====================================================
        // CITY-WISE
        //
        // Used by:
        // Project Planner
        // Project Detail
        // =====================================================

        if ($cityId !== NULL) {

            $cityId = (int)$cityId;


            // =================================================
            // REQUIRED SEATS
            // =================================================

            $requiredRow = $CI->db
                ->select_sum(
                    'number_of_seats',
                    'required_seats'
                )
                ->where(
                    'project_id',
                    $projectId
                )
                ->where(
                    'exam_city_id',
                    $cityId
                )
                ->where(
                    'deleted',
                    0
                )
                ->get(
                    'tt_project_detail'
                )
                ->row();


            $required = (int)(
                $requiredRow->required_seats ?? 0
            );


            // =================================================
            // ALLOCATED SEATS
            // Same logic as Project Planner
            // =================================================

            $allocatedRow = $CI->db
                ->select_sum(
                    'center_seat',
                    'allocated_seats'
                )
                ->where(
                    'project_id',
                    $projectId
                )
                ->where(
                    'city_id',
                    $cityId
                )
                ->where(
                    'admin_status',
                    1
                )
                ->get(
                    'tt_send_booking_request'
                )
                ->row();


            $rawAllocated = (int)(
                $allocatedRow->allocated_seats ?? 0
            );


            // =================================================
            // CAP ALLOCATION
            // =================================================

            $allocated = min(
                $rawAllocated,
                $required
            );
        }


        // =====================================================
        // PROJECT-WISE
        //
        // Used by:
        // Client Project List
        // Dashboard
        //
        // Multiple cities are possible.
        //
        // Allocation is calculated city-wise and then
        // added together.
        // =====================================================

        else {

            $cityRows = $CI->db
                ->select('
                    exam_city_id,
                    SUM(number_of_seats) AS required_seats
                ')
                ->where(
                    'project_id',
                    $projectId
                )
                ->where(
                    'deleted',
                    0
                )
                ->group_by(
                    'exam_city_id'
                )
                ->get(
                    'tt_project_detail'
                )
                ->result();


            $required  = 0;
            $allocated = 0;


            foreach ($cityRows as $cityRow) {

                $cityId = (int)$cityRow->exam_city_id;


                $cityRequired = (int)(
                    $cityRow->required_seats ?? 0
                );


                // =============================================
                // ALLOCATED SEATS FOR CITY
                // =============================================

                $allocatedRow = $CI->db
                    ->select_sum(
                        'center_seat',
                        'allocated_seats'
                    )
                    ->where(
                        'project_id',
                        $projectId
                    )
                    ->where(
                        'city_id',
                        $cityId
                    )
                    ->where(
                        'admin_status',
                        1
                    )
                    ->get(
                        'tt_send_booking_request'
                    )
                    ->row();


                $cityAllocated = (int)(
                    $allocatedRow->allocated_seats ?? 0
                );


                // =============================================
                // NEVER ALLOW CITY ALLOCATION
                // ABOVE CITY REQUIREMENT
                // =============================================

                $cityAllocated = min(
                    $cityAllocated,
                    $cityRequired
                );


                // =============================================
                // PROJECT TOTAL
                // =============================================

                $required += $cityRequired;

                $allocated += $cityAllocated;
            }
        }


        // =====================================================
        // ALLOCATION PERCENTAGE
        // =====================================================

        $percent = 0;

        if ($required > 0) {

            $percent = round(
                ($allocated / $required) * 100
            );
        }


        $percent = min(
            100,
            $percent
        );


        // =====================================================
        // ALLOCATION STATUS
        // =====================================================

        if ($allocated <= 0) {

            $status = 'Pending';

            $badge = '
                <span class="badge bg-danger">
                    Pending
                </span>
            ';

        } elseif ($allocated < $required) {

            $status = 'Partial';

            $badge = '
                <span class="badge bg-warning">
                    Partial
                </span>
            ';

        } else {

            $status = 'Completed';

            $badge = '
                <span class="badge bg-success">
                    Completed
                </span>
            ';
        }


        // =====================================================
        // RETURN
        // =====================================================

        return [
            'required'  => $required,
            'allocated' => $allocated,
            'percent'   => $percent,
            'status'    => $status,
            'badge'     => $badge
        ];
    }
}


/**
 * Generate Seat Progress HTML
 */

if (!function_exists('getSeatProgressHtml')) {

    function getSeatProgressHtml($seat)
    {
        $required  = (int)($seat['required'] ?? 0);
        $allocated = (int)($seat['allocated'] ?? 0);
        $percent   = (int)($seat['percent'] ?? 0);


        return '

            <strong>
                ' . number_format($allocated) . '
                /
                ' . number_format($required) . '
            </strong>

            <div
                class="progress mt-1"
                style="height:8px;"
            >

                <div
                    class="progress-bar bg-success"
                    style="width:' . $percent . '%;"
                ></div>

            </div>

            <small>
                ' . $percent . '%
            </small>

        ';
    }
}