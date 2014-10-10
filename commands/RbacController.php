<?php

namespace app\commands;

use yii\console\Controller;
use Yii;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // user
        $user = $auth->createPermission('user');
        $user->description = 'its user';
        $auth->add($user);

        // admin
        $admin = $auth->createPermission('admin');
        $admin->description = 'its admin';
        $auth->add($admin);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 101);
        $auth->assign($admin, 100);
    }
}
