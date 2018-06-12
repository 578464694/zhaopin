<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/5
 * Time: 18:52
 */
namespace api\services;

use api\helpers\FormatterHepler;
use api\modules\v1\models\Job;
use yii\helpers\ArrayHelper;

class ZhiweiService extends \common\services\ZhiweiService
{
    /**
     * @param Job $job
     * @return array
     */
    public function detail(Job $job)
    {
        $salary = FormatterHepler::salaryFormat($job->salary_min, $job->salary_max);
        $result = ArrayHelper::toArray($job,[
            Job::class => [
                'url',
                'title',
                'company_short_name',
                'job_desc',
                'tags',
                'city',
                'work_years',
                'degree_need',
                'job_advantage',
                'company_img',
                'addr',
            ]
        ]);
        $result['salary'] = $salary;
        $result['exists'] = true;
        $result['tags'] = $this->formatTag($job->tags);
        return $result;
    }

    public function similar(Job $job) {
        $salary = FormatterHepler::salaryFormat($job->salary_min, $job->salary_max);
        $result = ArrayHelper::toArray($job,[
            Job::class => [
                'title',
                'company_short_name',
                'city',
                'work_years',
                'degree_need',
            ]
        ]);
        $result['salary'] = $salary;
        $result['tags'] = $this->formatTag($job->tags);
        $result['id'] = $job->getPrimaryKey();
        $result['short_time'] = date('m-d', strtotime($job->release_time));
        return $result;
    }

    private function formatTag($tags)
    {
        return explode(',', $tags);
    }
}