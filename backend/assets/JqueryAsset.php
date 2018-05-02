<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/4/30
 * Time: 13:46
 */

namespace backend\assets;


use yii\web\AssetBundle;

class JqueryAsset extends AssetBundle
{
    public $sourcePath = '@webroot/search/js';
    public $js = [
        'jquery.js',
    ];
}