<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/4
 * Time: 22:14
 */
namespace api\modules\v1\models;

/**
 * Job model
 * @property string $url
 * @property string $title
 * @property integer $salary_min
 * @property integer $salary_max
 * @property string $company_short_name
 * @property string $job_desc
 * @property string $tags
 * @property string $city
 * @property string $work_years
 * @property string $degree_need
 * @property string $job_advantage
 * @package api\modules\v1\models
 */
class Job extends \api\models\Job
{
}