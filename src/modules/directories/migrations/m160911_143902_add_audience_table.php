<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m160911_143902_add_audience_table extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%directories_audience}}', [
            'id' => $this->primaryKey(),
            'number' => $this->string(),
            'name' => $this->string(),
            'type' => $this->integer(),
            'id_teacher' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%audience}}');
    }
}
