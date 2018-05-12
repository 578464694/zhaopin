<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\job\models\searches\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '职位列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'addr',
            'city',
            'company_name',
            'degree_need',
            //'job_advantage',
            //'job_desc',
            //'job_type',
            //'publish_time',
            //'release_time',
            //'salary_max',
            //'salary_min',
            //'tags',
            //'title',
            //'url',
            //'url_object_id',
            //'website',
            //'work_years',
            //'suggest',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
