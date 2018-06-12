<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/12
 * Time: 12:57
 */

namespace api\helpers;


class FormatterHepler
{
    /**
     * 格式化薪资
     * @param $salary_min
     * @param $salary_max
     * @return string
     */
    public static function salaryFormat($salary_min, $salary_max)
    {
        if($salary_max < 900000) {
            return ($salary_min/1000)."k-".($salary_max/1000).'k';
        }else{
            return ($salary_min/1000).'k以上';
        }
    }
}