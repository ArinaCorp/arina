<?php

namespace app\modules\rbac\migrations;

use app\modules\rbac\models\AuthItem;
use app\modules\rbac\models\AuthItemChild;
use app\modules\rbac\models\AuthRule;
use app\modules\rbac\models\rules\ProjectRule;
use app\modules\rbac\models\rules\TaskRule;
use app\modules\user\models\User;
use Yii;
use yii\db\Migration;
use yii\rbac\Item;

class M170417145342Create_basic_roles extends Migration
{
    public function up()
    {
        AuthItem::deleteAll();

        /** @var \dektrium\rbac\components\DbManager $authManager */
        $authManager = Yii::$app->getAuthManager();
        $time = time();
        $this->batchInsert($authManager->itemTable, ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], [
            //Administrator
            ['administrator', Item::TYPE_ROLE, 'Адміністратор', null, null, $time, $time],
            //Dash board
            ['dashboard', Item::TYPE_ROLE, 'Панель управління', null, null, $time, $time],
            //Users management
            ['user-manager', Item::TYPE_ROLE, 'Користувачі', null, null, $time, $time],
            //Projects management
            ['project-manager', Item::TYPE_ROLE, 'Проекти', null, null, $time, $time],
            //Developer
            ['developer', Item::TYPE_ROLE, 'Розробник', null, null, $time, $time],
            //Access management
            ['access-management', Item::TYPE_ROLE, 'Контроль доступами', null, null, $time, $time],

        ]);

        $this->batchInsert($authManager->itemChildTable, ['parent', 'child'], [
            //Administrator has
            ['administrator', 'dashboard'],
            ['administrator', 'user-manager'],
            ['administrator', 'project-manager'],
            ['administrator', 'access-management'],

            ////Project manager has
            ['project-manager', 'developer'],
        ]);

        //Add rules
        $projectRule = new ProjectRule();
        $authManager->add($projectRule);
        $taskRule = new TaskRule();
        $authManager->add($taskRule);

        //Permissions
        $this->batchInsert($authManager->itemTable, ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], [
            //Project permissions for project-manager
            ['indexProject', Item::TYPE_PERMISSION, 'Перегляд проектів', null, null, $time, $time],
            ['createProject', Item::TYPE_PERMISSION, 'Створення проекту', null, null, $time, $time],
            ['viewProject', Item::TYPE_PERMISSION, 'Перегляд проекту', null, null, $time, $time],
            ['updateProject', Item::TYPE_PERMISSION, 'Оновлення проекту', null, null, $time, $time],
            ['deleteProject', Item::TYPE_PERMISSION, 'Видалення проекту', null, null, $time, $time],
            ['updateOwnProject', Item::TYPE_PERMISSION, 'Оновлення власного проекту', $projectRule->name, null, $time, $time],
            ['deleteOwnProject', Item::TYPE_PERMISSION, 'Видалення власного проекту', $projectRule->name, null, $time, $time],
            //Task permissions for developer
            ['indexTask', Item::TYPE_PERMISSION, 'Перегляд завдань', null, null, $time, $time],
            ['createTask', Item::TYPE_PERMISSION, 'Створення завдання', null, null, $time, $time],
            ['createTaskForProject', Item::TYPE_PERMISSION, 'Створення завдання до проекту', $projectRule->name, null, $time, $time],
            ['viewTask', Item::TYPE_PERMISSION, 'Перегляд завдання', null, null, $time, $time],
            ['updateTask', Item::TYPE_PERMISSION, 'Оновлення завдання', null, null, $time, $time],
            ['deleteTask', Item::TYPE_PERMISSION, 'Видалення завдання', null, null, $time, $time],
            ['updateOwnTask', Item::TYPE_PERMISSION, 'Оновлення власного завдання', $taskRule->name, null, $time, $time],
            ['deleteOwnTask', Item::TYPE_PERMISSION, 'Видалення власного завдання', $taskRule->name, null, $time, $time],
        ]);


        $this->batchInsert($authManager->itemChildTable, ['parent', 'child'], [
            //Bind permissions to roles
            ['project-manager', 'indexProject'],
            ['project-manager', 'createProject'],
            ['project-manager', 'viewProject'],
            ['project-manager', 'updateProject'],
            ['project-manager', 'deleteProject'],
            ['developer', 'indexProject'],
            ['developer', 'viewProject'],
            ['developer', 'indexTask'],
            ['developer', 'createTask'],
            ['developer', 'viewTask'],
            ['developer', 'updateTask'],
            ['developer', 'deleteTask'],
            //Bind permissions to permissions
            ['updateProject', 'updateOwnProject'],
            ['deleteProject', 'deleteOwnProject'],
            ['createTask', 'createTaskForProject'],
            ['updateTask', 'updateOwnTask'],
            ['deleteTask', 'deleteOwnTask'],
        ]);

        /** @var User $user */
        $user = User::findOne([
            'username' => 'admin',
            'email' => 'admin@test.com',
        ]);

        $this->insert($authManager->assignmentTable, [
            'item_name' => 'administrator',
            'user_id' => $user->id,
            'created_at' => $time,
        ]);
    }

    public function down()
    {
        AuthRule::deleteAll();
        AuthItemChild::deleteAll();
        AuthItem::deleteAll();
        return true;
    }
}