<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

/**
 * Handles the creation of table `department`.
 */
class m161020_101318_create_department_table extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'head_id' => $this->integer(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('department');
    }
}
