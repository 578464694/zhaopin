<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\job\models\Job */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'addr') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'company_url') ?>

    <?= $form->field($model, 'degree_need') ?>

    <?= $form->field($model, 'job_advantage') ?>

    <?= $form->field($model, 'job_desc') ?>

    <?= $form->field($model, 'job_type') ?>

    <?= $form->field($model, 'publish_time') ?>

    <?= $form->field($model, 'release_time') ?>

    <?= $form->field($model, 'salary_max') ?>

    <?= $form->field($model, 'salary_min') ?>

    <?= $form->field($model, 'tags') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'url_object_id') ?>

    <?= $form->field($model, 'website') ?>

    <?= $form->field($model, 'work_years') ?>

    <?= $form->field($model, 'suggest') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
