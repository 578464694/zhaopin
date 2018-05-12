<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\job\models\searches\JobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',
        ],
    ]); ?>

    <?php // echo $form->field($model, 'job_type') ?>

    <?php // echo $form->field($model, 'publish_time') ?>

    <?php // echo $form->field($model, 'release_time') ?>

    <?php // echo $form->field($model, 'salary_max') ?>

    <?php // echo $form->field($model, 'salary_min') ?>


    <?php  echo $form->field($model, 'title')->label(false)->textInput(['placeholder' => '职位']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
