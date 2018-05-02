<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
//        'search/js/jquery.js',
//        'search/js/common.js',
        'search/js/global.js',
//        'search/js/pagination.js',
    ];
    public $depends = [
        JqueryAsset::class
    ];
    public $css = [
        'search/css/index.css',
        'search/css/style.css',
    ];


}
