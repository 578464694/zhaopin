<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/2
 * Time: 22:03
 */

namespace backend\controllers;



use backend\models\Job;
use yii\web\Controller;
use yii\web\Response;

class SuggestController extends Controller
{
    /**
     * 搜索建议
     * @param $s
     * @return array|mixed
     */
    public function actionZhiwei()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $result = Job::find()->addSuggester('suggest', [
            'text' => '学习',
            'completion' => [
                'field' => 'suggest',
                'fuzzy' => [
                    'fuzziness' => 2,
                ],
                'size' => 10,
            ],

        ])->source(['title'])->search();
        return $result;
    }

    public function actionTest()
    {
        $job = new Job();
        $job->primaryKey = 'wangnima';
        $job->attributes  = ['title' => 'test'];
        if($job->save()) {
            print_r('ok');
        }
    }
}