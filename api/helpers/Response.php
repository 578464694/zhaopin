<?php
namespace api\helpers;

use Yii;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: WangSai
 * Date: 2016/12/22 0025
 * Time: 10:11
 */
class Response
{
    /**
     * 设置相应格式为json
     */
    public static function setJsonResponse()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * 设置格式为 raw
     */
    public static function setRawResponse()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    }

    /**
     * 规范化ajax返回数据，方便js进行处理
     *
     * code建议：
     * 0： 失败
     * 1： 成功
     *
     * @param $code
     * @param $msg
     * @return array
     */
    public static function ajaxFormat($code, $msg)
    {
        return [
            'code' => $code,
            'message' => $msg,
        ];
    }

    /**
     * @param $model ActiveRecord
     * @return mixed
     */
    public static function handleModelErrors($model)
    {
        $errors = $model->getErrors();

        while (! is_string($errors)) {
            $errors = reset($errors);
        }

        return $errors;
    }
}