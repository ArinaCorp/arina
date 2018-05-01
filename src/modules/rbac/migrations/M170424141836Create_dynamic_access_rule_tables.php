<?php

namespace app\modules\rbac\migrations;

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class M170424141836Create_dynamic_access_rule_tables extends Migration
{
    use MigrationTrait;

    public function safeUp()
    {
        $this->createTable('{{%action_access}}', [
            'id' => $this->primaryKey(),
            'module' => $this->string(),
            'controller' => $this->string(),
            'action' => $this->string(),
        ], $this->getTableOptions());

        $this->createTable('{{%action_access_item}}', [
            'action_access_id' => $this->integer(),
            'auth_item_name' => $this->string(),
        ], $this->getTableOptions());

        $this->addPrimaryKey('action_access_item_pk', '{{%action_access_item}}', ['action_access_id', 'auth_item_name']);
    }

    public function safeDown()
    {
        $this->dropPrimaryKey('action_access_item_pk', '{{%action_access_item}}');

        $this->dropTable('{{%action_access_item}}');
        $this->dropTable('{{%action_access}}');

        return true;
    }
}
