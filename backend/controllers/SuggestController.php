<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/2
 * Time: 22:03
 */

namespace backend\controllers;



use backend\models\forms\SuggestForm;
use backend\models\Job;
use backend\services\ZhiweiService;
use yii\web\Controller;
use yii\web\Response;

class SuggestController extends Controller
{
    private static $_suggestService;
    /**
     * 搜索建议
     * @param $s
     * @return array|mixed
     */
    public function actionZhiwei($s)
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $form = new SuggestForm();
        $form->s = $s;
        if(! $form->validate()) {
            return ['msg' => '校验未通过'];
        }
        $result = Job::find()->addSuggester('suggest', [
            'text' => $s,
            'completion' => [
                'field' => 'suggest',
                'fuzzy' => [
                    'fuzziness' => 2,
                ],
                'size' => 10,
            ],

        ])->source(['title'])->search();
        $result = $this->getZhiweiService()->suggest($result);

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

    public function getZhiweiService()
    {
        if(! self::$_suggestService) {
           self::$_suggestService = new ZhiweiService();
        }
        return self::$_suggestService;
    }
}