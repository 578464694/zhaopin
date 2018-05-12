<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/5
 * Time: 18:52
 */
namespace backend\services;

class ZhiweiService extends \yii\base\Component
{
    public function suggest($suggest)
    {
        $result = [];
        if( isset($suggest['suggest']['suggest'][0]['options'])
            && is_array($suggest['suggest']['suggest'][0]['options'])
            && !empty($suggest['suggest']['suggest'][0]['options'])) {
            foreach ($suggest['suggest']['suggest'][0]['options'] as $option) {
                $result[] = strtolower($option['_source']['title']);
            }
        }
        return $result;
    }

    public function search($search)
    {
        $result = [];
        $result['total'] = $search['hits']['total'];
        foreach ($search['hits']['hits'] as $key => $hit) {
            if(isset($hit['highlight']["title"][0])) {
                $result[$key]['title'] = $hit['highlight']["title"][0];
            }else{
                $result[$key]['title'] = $hit['_source']['title'];
            }

            if(isset($hit['highlight']["content"][0])) {
                $result[$key]['job_desc'] = mb_substr($hit['highlight']["job_desc"][0],0,500,'utf8');
            }else{
                $result[$key]['job_desc'] = mb_substr($hit['_source']['job_desc'],0,500,'utf8');
            }

            $result[$key]['release_time'] = $hit['_source']['release_time'];
            $result[$key]['website'] = $hit['_source']['website'];
            $result[$key]['tags'] = explode(',', $hit['_source']['tags']);
            $result[$key]['url'] = $hit['_source']['url'];
            $result[$key]['release_time'] = $hit['_source']['release_time'];
            $result[$key]['salary_min'] = $hit['_source']['salary_min'];
            $result[$key]['salary_max'] = $hit['_source']['salary_max'];
            $result[$key]['work_years'] = $hit['_source']['work_years'];
            $result[$key]['degree_need'] = $hit['_source']['degree_need'];
            $result[$key]['score'] = round($hit['_score'],2);
        }
        return $result;
    }
}