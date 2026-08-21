<style>
    /* ===== CALENDAR SECTION ===== */
    .calender-section {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: 1px solid #f0f2f5;
    }

    /* ===== HEADER & CONTROLS ===== */
    .calender-section .p-4 {
        padding: 25px 30px !important;
    }

    #monthSelect,
    #yearSelect {
        cursor: pointer;
        padding: 10px 20px;
        width: 100%;
        border: 2px solid #e8ecf1;
        border-radius: 12px;
        background: #f8fafc;
        font-weight: 600;
        font-size: 15px;
        color: #1a1a2e;
        transition: all 0.3s ease;
        outline: none;
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234a5568' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
    }

    #monthSelect:hover,
    #yearSelect:hover {
        border-color: #667eea;
        background-color: #f0f3ff;
    }

    #monthSelect:focus,
    #yearSelect:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
    }

    .calender-section p {
        font-size: 16px;
        color: #4a5568;
        font-weight: 500;
        margin-top: 12px !important;
        margin-bottom: 8px !important;
    }

    .calender-section strong {
        color: #1a1a2e;
        font-weight: 700;
        font-size: 14px;
    }

    .calender-section .fas.fa-circle {
        font-size: 10px;
        margin-right: 6px;
    }

    .calender-section .ms-3,
    .calender-section .ms-4 {
        color: #4a5568;
        font-size: 13px;
        font-weight: 500;
    }

    .text-success {
        color: #4CAF50 !important;
    }

    .text-danger {
        color: #F44336 !important;
    }

    /* ===== CALENDAR TABLE ===== */
    .calender-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .calender-table thead th {
        padding: 14px 10px;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
        color: #4a5568;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #e8ecf1;
        border-bottom: 2px solid #dce0e6;
    }

    .calender-table thead th:first-child {
        border-radius: 14px 0 0 0;
    }

    .calender-table thead th:last-child {
        border-radius: 0 14px 0 0;
    }

    .calender-table td {
        padding: 12px 8px;
        text-align: center;
        border: 1px solid #eef0f3;
        height: 65px;
        vertical-align: middle;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        color: #1a1a2e;
        transition: all 0.25s ease;
        position: relative;
        background: #ffffff;
    }

    .calender-table td:hover {
        background-color: #f8faff;
        transform: scale(1.02);
        z-index: 2;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.12);
        border-color: #667eea;
    }

    /* ===== PREV/NEXT MONTH ===== */
    .prev-month,
    .next-month {
        color: #b0b8c4 !important;
        background: #fafbfc !important;
    }

    .prev-month:hover,
    .next-month:hover {
        background: #f5f6f8 !important;
        transform: scale(1) !important;
        box-shadow: none !important;
    }

    /* ===== BOOKING TYPE STYLES ===== */
    /* Self Booking - Green */
    .has-exam.self_booking {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%) !important;
        color: #2e7d32 !important;
        font-weight: 600;
        border-color: #a5d6a7;
    }

    .has-exam.self_booking:hover {
        background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%) !important;
        border-color: #66bb6a;
    }

    /* Assigned Booking - Red */
    .has-exam.assigned_booking {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%) !important;
        color: #c62828 !important;
        font-weight: 600;
        border-color: #ef9a9a;
    }

    .has-exam.assigned_booking:hover {
        background: linear-gradient(135deg, #ffcdd2 0%, #ef9a9a 100%) !important;
        border-color: #e57373;
    }

    /* Mixed Booking - Both Self + Assigned */
    .has-exam.mixed_booking {
        background: linear-gradient(135deg, #e8f5e9 40%, #ffebee 40%, #ffcdd2 100%) !important;
        color: #1a1a2e !important;
        font-weight: 600;
        border-color: #b0bec5;
        position: relative;
    }

    .has-exam.mixed_booking::after {
        content: '● ●';
        position: absolute;
        bottom: 3px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 6px;
        letter-spacing: 4px;
        color: #4CAF50;
        text-shadow: 6px 0 #F44336;
    }

    /* ===== TODAY STYLING ===== */
    .today {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%) !important;
        border-color: #64b5f6 !important;
        color: #0d47a1 !important;
        font-weight: 700;
        box-shadow: inset 0 0 0 2px #1976d2;
        position: relative;
    }

    .today:hover {
        background: linear-gradient(135deg, #bbdefb 0%, #90caf9 100%) !important;
        border-color: #1976d2 !important;
    }

    .today-dot {
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 8px;
        background: linear-gradient(135deg, #1976d2, #1565c0);
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(25, 118, 210, 0.3);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {

        0%,
        100% {
            transform: translateX(-50%) scale(1);
            opacity: 1;
        }

        50% {
            transform: translateX(-50%) scale(1.3);
            opacity: 0.7;
        }
    }

    /* ===== SELECTED DATE ===== */
    .selected-date {
        background: linear-gradient(135deg, #fff9c4 0%, #ffeb3b 100%) !important;
        box-shadow: inset 0 0 0 2px #f9a825;
        color: #1a1a2e !important;
        font-weight: 700;
        transform: scale(1.04);
        z-index: 3;
        border-color: #f9a825 !important;
    }

    .selected-date:hover {
        background: linear-gradient(135deg, #ffeb3b 0%, #fdd835 100%) !important;
        transform: scale(1.06);
        box-shadow: 0 6px 24px rgba(255, 193, 7, 0.3);
    }

    /* If today is also selected */
    .today.selected-date {
        background: linear-gradient(135deg, #ffca28 0%, #ffb300 100%) !important;
        box-shadow: inset 0 0 0 3px #1976d2, 0 4px 20px rgba(255, 193, 7, 0.3);
        color: #0d47a1 !important;
        transform: scale(1.06);
    }

    .today.selected-date:hover {
        background: linear-gradient(135deg, #ffb300 0%, #ff8f00 100%) !important;
        transform: scale(1.08);
    }

    /* ===== DOTS FOR BOOKINGS (Custom) ===== */
    .has-exam.self_booking .today-dot {
        background: #2e7d32;
    }

    .has-exam.assigned_booking .today-dot {
        background: #c62828;
    }

    /* ===== RESPONSIVE ===== */
    @media screen and (max-width: 992px) {
        .calender-table td {
            height: 55px;
            padding: 8px 4px;
            font-size: 13px;
        }

        .calender-table thead th {
            padding: 10px 4px;
            font-size: 12px;
        }

        #monthSelect,
        #yearSelect {
            font-size: 13px;
            padding: 8px 16px;
            padding-right: 35px;
        }

        .calender-section .p-4 {
            padding: 18px 20px !important;
        }

        .calender-section p {
            font-size: 14px;
        }

        .calender-section .ms-3,
        .calender-section .ms-4 {
            font-size: 12px;
        }
    }

    @media screen and (max-width: 576px) {
        .calender-section {
            border-radius: 12px;
        }

        .calender-table td {
            height: 45px;
            padding: 4px 2px;
            font-size: 12px;
        }

        .calender-table thead th {
            padding: 8px 2px;
            font-size: 11px;
        }

        #monthSelect,
        #yearSelect {
            font-size: 12px;
            padding: 6px 12px;
            padding-right: 30px;
            width: 100%;
        }

        .calender-section .p-4 {
            padding: 12px 12px !important;
        }

        .calender-section p {
            font-size: 12px;
            margin-top: 8px !important;
        }

        .calender-section strong {
            font-size: 12px;
        }

        .calender-section .ms-3,
        .calender-section .ms-4 {
            font-size: 10px;
            margin-left: 8px !important;
        }

        .calender-section .fas.fa-circle {
            font-size: 8px;
            margin-right: 4px;
        }

        .today-dot {
            width: 6px;
            height: 6px;
        }

        .has-exam.mixed_booking::after {
            font-size: 5px;
            letter-spacing: 3px;
            bottom: 2px;
        }

        .selected-date {
            transform: scale(1.03);
        }

        .selected-date:hover {
            transform: scale(1.05);
        }

        .calender-table td:hover {
            transform: scale(1.04);
        }
    }

    @media screen and (max-width: 400px) {
        .calender-table td {
            height: 38px;
            font-size: 10px;
            padding: 2px 1px;
        }

        .calender-table thead th {
            font-size: 9px;
            padding: 6px 1px;
        }

        .calender-section .p-4 {
            padding: 8px 8px !important;
        }

        .today-dot {
            width: 4px;
            height: 4px;
            bottom: 2px;
        }
    }
</style>
<div class="booking-center w-100 calender-section active">
    <div class="d-flex">
        <div class="col-8">
            <div class="d-flex justify-content-between align-items-center p-4">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <select id="monthSelect" class="">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select id="yearSelect" class="">
                                <?php for ($y = date('Y') - 1; $y <= date('Y') + 2; $y++): ?>
                                    <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <p class="mt-2"><?= date('l, F jS, Y') ?></p>
                    <div class="">
                        <strong>Booking Indicators:</strong>

                        <span class="ms-3">
                            <i class="fas fa-circle text-success"></i>
                            Self Booking
                        </span>

                        <span class="ms-4">
                            <i class="fas fa-circle text-danger"></i>
                            Assigned Booking
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <table class="calender-table">
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
                        <?php foreach ($calendar['weeks'] as $week): ?>
                            <tr>
                                <?php foreach ($week as $day): ?>
                                    <?php if ($day['month'] == 'current'): ?>
                                        <td class="<?= $day['has_exam'] ? 'has-exam ' . implode(' ', $day['booking_types']) : '' ?> <?= date('Y-m-d') == $day['date'] ? 'today' : '' ?>"
                                            data-date="<?= $day['date'] ?>">
                                            <?= $day['day'] ?>
                                            <?php if ($day['has_exam']): ?>
                                                <?php foreach ($day['booking_types'] as $type): ?>
                                                    <span class="<?= date('Y-m-d') == $day['date'] ? 'today-dot' : '' ?> <?= $type ?>"></span>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="<?= date('Y-m-d') == $day['date'] ? 'today-dot' : '' ?>"></span>
                                            <?php endif; ?>
                                        </td>
                                    <?php elseif ($day['month'] == 'prev'): ?>
                                        <td class="prev-month text-muted"><?= $day['day'] ?></td>
                                    <?php else: ?>
                                        <td class="next-month text-muted"><?= $day['day'] ?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-4">
            <div class="event-aside" id="eventAside">
                <div>
                    <h3>Events</h3>
                    <p>Exam Scheduled for the day</p>
                </div>
                <div id="bookingDetailsContainer">
                    <!-- Content will be loaded via AJAX -->
                    <div class="text-center p-4">
                        <p>Select a date to view exam details</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--/////////////////// View All booking modal start ////////////////////////-->
<div class="modal right fade" id="viewBookingDetailModal" tabindex="-1" aria-labelledby="viewBookingDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="text-end border-bottom p-3  bg-white">
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="project-details-bg-modal">
                <div id="innerHtmlViewBookingModal"></div>
            </div>
        </div>
    </div>
</div>
<!--/////////////////////// View All booking modal end /////////////////////-->