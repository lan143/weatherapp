<?php
/**
 * @var $day_data \app\calendar\ElementInterface
 * @var $day string
 */
?>
<td class="<?php if ($day_data && count($day_data->class)): ?><?= implode(' ', $day_data->class) ?><?php endif ?>">
    <?= $day ?>

    <?php if ($day_data): ?>
        <?=$day_data->text?>
    <?php endif ?>
</td>