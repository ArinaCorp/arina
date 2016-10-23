<?php

use yii\db\Migration;

/**
 * Handles the creation of table `department`.
 */
class m161020_101318_create_department_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'head_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('department');
    }
}
