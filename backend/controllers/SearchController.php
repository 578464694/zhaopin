<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/4/30
 * Time: 13:05
 */

namespace backend\controllers;


use yii\web\Controller;

class SearchController extends Controller
{
    public $layout = 'white';

    public function actionIndex()
    {
        return $this->render('index');
    }
}