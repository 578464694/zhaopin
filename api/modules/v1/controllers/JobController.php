<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/6/10
 * Time: 19:44
 */
namespace api\modules\v1\controllers;

use api\helpers\Response;
use api\modules\v1\models\Job;
use api\services\ZhiweiService;
use yii\web\Controller;

class JobController extends Controller
{
    private static $_suggestService;
    public function actionSuggest()
    {
        Response::setJsonResponse();
        $keyword = \Yii::$app->getRequest()->get('keyword');
        $result = Job::find()->addSuggester('suggest', [
            'text' => $keyword,
            'completion' => [
                'field' => 'suggest',
                'fuzzy' => [
                    'fuzziness' => 2,
                ],
                'size' => 10,
            ],

        ])->source(['title'])->search();
        $result = $this->getZhiweiService()->suggest($result);
        $result = array_values(array_unique($result));
        return $result;
    }

    /**
     * 搜索结果
     * @param $q
     * @return string
     */
    public function actionSearch()
    {
        Response::setJsonResponse();
        $page = \Yii::$app->request->get('page',1);
        $keyword = \Yii::$app->request->get('keyword','php');
        $size = \Yii::$app->request->get('size',10);
        $result = Job::find()->query([
            "multi_match" => [
                "query" => $keyword,
                "fields" => ['title', 'company_short_name'],
            ],

        ])->orderBy([
            'release_time' => SORT_DESC
        ])->offset(($page-1)*10)->limit($size)->asArray()->search();
        $result = $this->getZhiweiService()->search($result);
        $result['search_word'] = $keyword;
        $result['page'] = $page;
        return $result;
    }

    /**
     * 相似职位
     * @return array
     */
    public function actionSimilar()
    {
        Response::setJsonResponse();
        $id = \Yii::$app->request->get('id');
        $result = [];
        $job = Job::findOne(['_id' => $id]);
        if(empty($job)) {
            $result['exists'] = false;
            return $result;
        }
        $jobs = Job::find()->query([
            "multi_match" => [
                "query" =>  $job->tags,
                "fields" => ['title'],
            ] ])->orderBy(['release_time' => SORT_DESC])
                ->offset(1)->limit(3)->search();
        if(empty($jobs['hits']['hits'])) {
            $result['exists'] = false;
            return $result;
        } else {
            $result['exists'] =  true;
        }
        foreach ($jobs['hits']['hits'] as $job) {
            if($job->getPrimaryKey() === $id) {
                continue;
            }
            $result['jobs'][] = $this->getZhiweiService()->similar($job);
        }
        return $result;
    }

    public function actionDetail()
    {
        Response::setJsonResponse();
        $id = \Yii::$app->request->get('id');
        if(empty($id)) {
            return ['exists' => false];
        }
        $job = Job::findOne(['_id' => $id]);
        if(empty($job)) {
            return ['exists' => false];
        }
        $result = $this->getZhiweiService()->detail($job);
        $result['id'] = $id;
        return $result;
    }


    /**
     * @return ZhiweiService
     */
    public function getZhiweiService()
    {
        if(! self::$_suggestService) {
            self::$_suggestService = new ZhiweiService();
        }
        return self::$_suggestService;
    }
}