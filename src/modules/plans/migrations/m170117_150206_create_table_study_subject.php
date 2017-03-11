<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170117_150206_create_table_study_subject extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%study_subject}}', [
            'id' => $this->primaryKey(),
            'study_plan_id' => $this->integer(10),
            'subject_id' => $this->integer(10),
            'total' => $this->integer(10),
            'lectures' => $this->integer(10),
            'lab_works' => $this->integer(10),
            'practices' => $this->integer(10),
            'weeks' => $this->string(255),
            'control' => $this->text(),
            'practice_weeks' => $this->integer(10),
            'diploma_name' => $this->string(255),
            'certificate_name' => $this->string(255),
            'dual_practice' => $this->boolean(),
            'dual_lab_work' => $this->boolean(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%study_subject}}');
    }
}