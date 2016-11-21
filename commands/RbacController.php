<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "createContent" permission
        // 新建分部数据权限
        $createContent = $auth->createPermission('createContent');
        $createContent->description = '新建分部数据权限';
        $auth->add($createContent);

        // add "updateContent" permission
        // 修改分部数据权限
        $updateContent = $auth->createPermission('updateContent');
        $updateContent->description = '修改分部数据权限';
        $auth->add($updateContent);

        // 新建用户权限
        $createUser = $auth->createPermission('createUser');
        $createUser->description = '新建用户权限';
        $auth->add($createUser);

        // 修改用户资料权限
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = '修改用户资料权限';
        $auth->add($updateUser);

        // 授权角色'manager' 具有新建修改分部数据权限
        $manager = $auth->createRole('manager');
        $manager->description = '管理员';
        $auth->add($manager);
        $auth->addChild($manager, $createContent);
        $auth->addChild($manager, $updateContent);



        // 授权角色'admin' 具有新建修改分部数据权限和新建修改用户资料权限
        $admin = $auth->createRole('admin');
        $admin->description = '超级管理员';
        $auth->add($admin);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $manager);

        // 普通会员
        $member = $auth->createRole('member');
        $admin->description = '注册会员';
        $auth->add($member);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($manager, 100);
        $auth->assign($admin, 99);
    }
}