<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/5
 * Time: 18:52
 */
namespace common\services;

use api\helpers\FormatterHepler;

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
        if(empty($search['hits']['hits'])) {
            $result['has_more'] = false;
        } else {
            $result['has_more'] = true;
        }
        foreach ($search['hits']['hits'] as $key => $hit) {
            if(isset($hit['highlight']["title"][0])) {
                $result['jobs'][$key]['title'] = $hit['highlight']["title"][0];
            }else{
                $result['jobs'][$key]['title'] = $hit['_source']['title'];
            }

            if(isset($hit['highlight']["content"][0])) {
                $result['jobs'][$key]['job_desc'] = mb_substr($hit['highlight']["job_desc"][0],0,500,'utf8');
            }else{
                $result['jobs'][$key]['job_desc'] = mb_substr($hit['_source']['job_desc'],0,500,'utf8');
            }

            $result['jobs'][$key]['release_time'] = $hit['_source']['release_time'];
            $result['jobs'][$key]['short_time'] =
                date('m-d', strtotime($result['jobs'][$key]['release_time']));
            $result['jobs'][$key]['website'] = $hit['_source']['website'];
            $result['jobs'][$key]['tags'] = explode(',', $hit['_source']['tags']);
            $result['jobs'][$key]['url'] = $hit['_source']['url'];
            $result['jobs'][$key]['salary_min'] = $hit['_source']['salary_min'];
            $result['jobs'][$key]['salary_max'] = $hit['_source']['salary_max'];
            $result['jobs'][$key]['salary'] = FormatterHepler::salaryFormat(
                $hit['_source']['salary_min'], $hit['_source']['salary_max']);
            $result['jobs'][$key]['work_years'] = str_replace("经验",'',
                $hit['_source']['work_years']);
            $result['jobs'][$key]['degree_need'] = $hit['_source']['degree_need'];
            $result['jobs'][$key]['company_img'] = $hit['_source']['company_img'];
            $result['jobs'][$key]['score'] = round($hit['_score'],2);
            $result['jobs'][$key]['company_short_name'] = $hit['_source']['company_short_name'];
            $result['jobs'][$key]['city'] = $hit['_source']['city'];
            $result['jobs'][$key]['addr'] = $hit['_source']['addr'];
            $result['jobs'][$key]['id'] = $hit['_id'];
        }
        return $result;
    }
}