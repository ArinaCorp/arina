<?php

use yii\db\Migration;

class m161020_172816_add_subjects_table extends Migration
{
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
        $this->dropTable('{{%directories_audience}}');
    }

    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
}
