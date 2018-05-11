<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/5
 * Time: 18:51
 */
namespace backend\models\forms;
class SuggestForm extends \yii\base\Model
{
    public $s;

    public function rules()
    {
        return [
            ['s', 'required'],
            ['s', 'string', 'min' => 1, 'max' => 20]
        ];
    }

}