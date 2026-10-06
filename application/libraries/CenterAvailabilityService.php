<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CenterAvailabilityService
{

    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('CenterAvailability_model', 'availabilityModel');
    }

    public function getAvailabilityList($filters, $start, $length)
    {
        $centers = $this->ci->availabilityModel
            ->fetchCentersWithAvailability($filters, $start, $length);

        $data = [];

        foreach ($centers['result'] as $row) {
            $totalBlocked = $row->project_bookings + $row->self_bookings;

            if ($totalBlocked > 0) {
                $status = '<span class="badge bg-danger">Not Available</span>';
            } else {
                $status = '<span class="badge bg-success">Available</span>';
            }

            $location = '
                <small><strong>Country:</strong> ' . $row->country . '</small><br>
                <small><strong>State:</strong> ' . $row->state . '</small><br>
                <small><strong>City:</strong> ' . $row->city . '</small><br>
                <small><strong>Owner:</strong> ' . $row->owner_name . '</small>
            ';

            $center_name = $row->center_name;

            $approval = ($row->approved == 1)
                ? '<span class="badge bg-success">Approved</span>'
                : '<span class="badge bg-danger">Not Approved</span>';


            $auditStatus = ($row->audit_status == 1)
                ? '<span class="badge bg-success">Completed</span>'
                : '<span class="badge bg-warning">Pending</span>';

            $data[] = [
                'center_name' => '<strong>' . $center_name . '</strong>' . '<br><div class="mt-2">Center Status : ' . $approval . '</div><div class="mt-2">Audit Status : ' . $auditStatus . '</div>',
                'location'    => $location,
                'capacity'    => $row->capacity .' / '. $row->total_no_lab,
                'status'      => $status,
                'action'      => '<a target="_blank" href="' . base_url('admin/center-calendar/' . $row->id) . '" 
                                    class="btn btn-sm btn-primary">Calendar</a>'
            ];
        }

        return [
            'total' => $centers['total'],
            'data'  => $data
        ];
    }


    public function getAvailabilityOverview($filters)
    {
        return $this->ci->availabilityModel
            ->getAvailabilityOverview($filters);
    }
}
