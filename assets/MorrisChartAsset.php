<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author v.kriuchkov
 */
class MorrisChartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/adminlte/css/morris/morris.css',
    ];
    public $js = [
        'themes/adminlte/js/plugins/morris/morris.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
