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
                        <td class="<?= $day['has_exam'] ? 'has-exam ' . implode(' ', $day['booking_types']) : '' ?><?= date('Y-m-d') == $day['date'] ? 'today' : '' ?>"
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