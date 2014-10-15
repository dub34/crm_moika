<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author v.kriuchkov
 * @since 2.0
 */
class PrintActAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/printact.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
