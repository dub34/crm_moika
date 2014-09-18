<?php

namespace app\components\behaviors;

//use yii\base\Behavior;
use Yii;
/**
 * @author ElisDN <mail@elisdn.ru>, Yii2.0 adapter v.kriuchkov
 * @link http://www.elisdn.ru
 */
class LiveLayoutBehavior extends \yii\base\Behavior
{
    public function initLayout()
    {
        $owner = $this->owner;
 
        if (empty($owner->layout))
        {
            $layouts=[]; //array of all possible layouts
            $theme = $owner->view->theme->pathMap;
            $module = $owner->module!==null?$owner->module->id:null;
            $controller = $owner->id;
            $action = $owner->action->id;
// 
//            $cacheId = "layout_{$module}_{$controller}_{$action}";
            if (is_array($theme))
            {
                foreach($theme as $path){
                    if($module!==null){
                        $layouts[]="{$path}/{$module}/layouts/{$module}_{$controller}_{$action}";
                        $layouts[]="{$path}/{$module}/layouts/{$module}_{$controller}";
                        $layouts[]="{$path}/{$module}/layouts/{$module}";
                        $layouts[]="{$path}/{$module}/layouts/main";
                    }else
                    {
                        $layouts[]="{$path}/layouts/{$controller}_{$action}";
                        $layouts[]="{$path}/layouts/{$controller}";
                    }
                }
                $layouts[]="{$path}/layouts/main";
            }
//            $owner->layout='index';
//            if (!$owner->layout = Yii::$app->cache->get($cacheId))
//            {
//                $layouts = array(
//                    "webroot.themes.{$theme}.views.{$module}.layouts.{$module}_{$controller}_{$action}",
////                    "application.modules.{$module}.views.layouts.{$module}_{$controller}_{$action}",
//                    "webroot.themes.{$theme}.views.{$module}.layouts.{$module}_{$controller}",
////                    "application.modules.{$module}.views.layouts.{$module}_{$controller}",
//                    "webroot.themes.{$theme}.views.{$module}.layouts.{$module}",
////                    "application.modules.{$module}.views.layouts.{$module}",
//                    "webroot.themes.{$theme}.views.layouts.default",
////                    "application.views.layouts.default",
//                );
 
                foreach ($layouts as $layout)
                {
                    $layoutpath = Yii::getAlias($layout . '.php');
                    if (file_exists($layoutpath))
                    {
                        $owner->layout = $layout;
                        break;
                    }
                }
//// 
//                Yii::app()->cache->set($cacheId, $owner->layout, 3600 * 24);
//            }
        }
    }
}