<?php
/**
 * @var $days array
 * @var $data array
 */

use app\calendar\CalendarWidget;
?>
<table class="table table-bordered">
    <?php foreach ($days as $day): ?>
        <?php $day_data = isset($data[date('Y-m-d', $day['unix_time'])]) ? $data[date('Y-m-d', $day['unix_time'])] : null ?>
        <?php if ($day['first_day']): ?>
            <tr>
                <td></td>
                <td colspan="7" class="text-center"><?= date('F', $day['unix_time']) ?></td>
            </tr>

            <tr>
                <td>Неделя</td>

                <?php foreach (CalendarWidget::WEEK_DAYS as $week_day): ?>
                    <td><?= $week_day ?></td>
                <?php endforeach ?>
            </tr>

            <tr>
            <td><?= date('W', $day['unix_time']) ?></td>

            <?php
            if (date('N', $day['unix_time']) > 0)
                echo str_repeat('<td></td>', date('N', $day['unix_time']) - 1);
            ?>

            <?= $this->render('_day', [
                'day' => date('d F', $day['unix_time']),
                'day_data' => $day_data
            ]) ?>
        <?php else: ?>
            <?php if (date('w', $day['unix_time']) == 1): ?>
                <tr>
                <td><?= date('W', $day['unix_time']) ?></td>
            <?php endif ?>

            <?= $this->render('_day', [
                'day' => date('d F', $day['unix_time']),
                'day_data' => $day_data
            ]) ?>

            <?php if (date('w', $day['unix_time']) == 0): ?>
                </tr>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
</table>
