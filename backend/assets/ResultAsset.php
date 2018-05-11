<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ResultAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'search/js/pagination.js',
        'search/js/global.js',
    ];
    public $depends = [
        JqueryAsset::class
    ];
    public $css = [
        'search/css/style.css',
        'search/css/result.css',
    ];


}
