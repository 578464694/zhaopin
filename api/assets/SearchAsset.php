<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

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
        'search/css/style.css',
    ];

    /**
     * 按需加载样式文件
     * @param $view View
     * @param $cssfile
     */
    public static function addStyle($view, $cssfile)
    {
        $view->registerCssFile($cssfile);
    }

    /**
     * 按需加载样式文件
     * @param $view View
     * @param $cssfile
     */
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile);
    }

}
