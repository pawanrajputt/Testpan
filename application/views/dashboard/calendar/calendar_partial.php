<table class="calendar-table">
    <thead>
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $days_in_month = date('t', $first_day);
        $day_of_week = date('w', $first_day);
        
        $prev_month = ($month == 1) ? 12 : $month - 1;
        $prev_year = ($month == 1) ? $year - 1 : $year;
        $days_in_prev_month = date('t', mktime(0, 0, 0, $prev_month, 1, $prev_year));
        
        $current_day = 1;
        $total_cells = ceil(($days_in_month + $day_of_week) / 7) * 7;
        
        for ($i = 0; $i < $total_cells; $i++): 
            if ($i % 7 == 0) echo '<tr>';
            
            if ($i < $day_of_week || $current_day > $days_in_month):
                // Previous or next month days
                echo '<td class="other-month"></td>';
            else:
                $current_date = date('Y-m-d', mktime(0, 0, 0, $month, $current_day, $year));
                $is_booked = false;
                $type= '';
                
                foreach ($booked_dates as $booking) {
                    if ($current_date >= $booking['start_date'] && $current_date <= $booking['end_date']) {
                        $is_booked = true;
                        $type = $booking['type'];
                        break;
                    }
                }
                
                $class = $is_booked ? 'booked '. $type : '';
                $class .= date('Y-m-d') == $current_date ? ' today' : '';
                
                $selfCount = isset($calendar_counts[$current_date])
                    ? $calendar_counts[$current_date]['self']
                    : 0;

                $assignedCount = isset($calendar_counts[$current_date])
                    ? $calendar_counts[$current_date]['assigned']
                    : 0;

                $tooltip = "";

                if(isset($calendar_tooltips[$current_date])){

                    if(!empty($calendar_tooltips[$current_date]['self'])){

                        $tooltip .= "SELF BOOKINGS\n";

                        foreach($calendar_tooltips[$current_date]['self'] as $row){

                            $tooltip .= "• ".$row."\n";

                        }

                        $tooltip .= "\n";
                    }

                    if(!empty($calendar_tooltips[$current_date]['assigned'])){

                        $tooltip .= "ASSIGNED BOOKINGS\n";

                        foreach($calendar_tooltips[$current_date]['assigned'] as $row){

                            $tooltip .= "• ".$row."\n";

                        }

                    }

                }

                echo '<td
                    class="'.$class.'"
                    data-date="'.$current_date.'"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="'.htmlspecialchars($tooltip).'">';

                echo '<div class="day-number">'.$current_day.'</div>';

                if($selfCount>0){

                    echo '<div class="booking-count self-count">
                            <span class="dot green"></span> S : '.$selfCount.'
                          </div>';

                }

                if($assignedCount>0){

                    echo '<div class="booking-count assigned-count">
                            <span class="dot red"></span> A : '.$assignedCount.'
                          </div>';

                }

                echo '</td>';
                $current_day++;
            endif;
            
            if ($i % 7 == 6) echo '</tr>';
        endfor; 
        ?>
    </tbody>
</table>