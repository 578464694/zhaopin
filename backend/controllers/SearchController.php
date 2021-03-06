<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/4/30
 * Time: 13:05
 */

namespace backend\controllers;


use backend\helpers\Redis;
use backend\models\forms\SuggestForm;
use backend\models\Job;
use backend\services\ZhiweiService;
use Exception;
use yii\web\Controller;
use yii\web\Response;

class SearchController extends Controller
{
    public $layout = 'white';
    private static $_suggestService;

    public function actionIndex()
    {
        return $this->render('index');
    }

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
        if (!$form->validate()) {
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
        $result = array_values(array_unique($result));

        return $result;
    }

    /**
     * 搜索结果
     * @param $q
     * @return string
     */
    public function actionResult($q)
    {
        $page = \Yii::$app->request->get('p',1);
        try{
            $page = (int)($page);
        }catch (Exception $e) {
            $page = 1;
        }
        Redis::getRedis()->zIncrBy("search_key_words",1, $q);
        $top_search = Redis::getRedis()->zRevRangeByScore("search_key_words",
            "+inf", "-inf",
            [
                'start' => 0,
                'num' => 5
            ]);

        $begin = microtime(true);
        $result = Job::find()->query([
            "multi_match" => [
                "query" => $q,
                "fields" => ['tags', 'title', 'content']
            ],

        ])->highlight([
                'pre_tags' => '<span class="keyWord">',
                'post_tags' => '</span>',
                "fields" => [
                    "title" => new \stdClass(),
                    "content" => new \stdClass(),
            ]
        ])->offset(($page-1)*10)->limit(10)->asArray()->search();
        $result = $this->getZhiweiService()->search($result);
        $result['search_word'] = $q;
        $result['time'] = round(microtime(true)-$begin,2);
        $result['page'] = $page;
        return $this->render('result',[
            'allHits' => $result,
            'lagou' => Redis::getRedis()->get('lagou_count'),
            'yingcai' => Redis::getRedis()->get('yingcai_count'),
            'top_search' => $top_search
        ]);
    }


    public function getZhiweiService()
    {
        if(! self::$_suggestService) {
            self::$_suggestService = new ZhiweiService();
        }
        return self::$_suggestService;
    }
}