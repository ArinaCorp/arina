<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m010517_092305_create_table_load extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%load}}', [
            'id' => $this->primaryKey(),
            'study_year_id' => $this->integer(10),
            'employee_id' => $this->integer(10),
            'group_id' => $this->integer(10),
            'work_subject_id' => $this->integer(10),
            'type' => $this->integer(10),
            'course' => $this->integer(10),
            'consult' => $this->string(255),
            'students' => $this->string(255),
            'fall_hours' => $this->string(255),
            'spring_hours' => $this->string(255),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%load}}');
    }
}