<?php

/**
 * @var $this yii\web\View
 * @var $filter \app\forms\FilterForm
 * @var $cities \app\models\City[]
 * @var $days array
 * @var $days_data array
 */

use app\calendar\CalendarWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Weather app';
?>

<style>
    td.max_in_week {
        background-color: #eb9316;
    }

    td.max_in_month {
        background-color: #ff0000;
    }
</style>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($filter, 'from') ?>

    <?= $form->field($filter, 'to') ?>

    <?= $form->field($filter, 'city_id')->dropDownList(ArrayHelper::map($cities, 'id', 'name'), [
        'prompt' => 'Не выбрано',
    ]) ?>

    <div class="form-group">
        <div class="col-md-12" style="text-align: center;">
            <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<div style="clear: both"></div>

<div style="margin-top: 20px">
    <?= CalendarWidget::widget(['from' => $from, 'to' => $to, 'data' => $days_data]) ?>
</div>