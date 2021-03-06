<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'themes/adminlte/css/AdminLTE.css',
        'themes/adminlte/css/ionicons.min.css',
        
    ];
    public $js = [
        'themes/adminlte/js/AdminLTE/app.js',
        'themes/adminlte/js/bootstrap.min.js',
        'themes/adminlte/js/custom_functions.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
