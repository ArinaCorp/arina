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
            'plan_id' => $this->integer(5),
            'subject_id' => $this->integer(5),
            'total' => $this->integer(5),
            'lectures' => $this->integer(5),
            'lab_works' => $this->integer(5),
            'practices' => $this->integer(5),
            'practice_weeks' => $this->integer(5),
            'weeks' => $this->string(255),
            'control' => $this->string(255),
            'certificate_name' => $this->string(255),
            'diploma_name' => $this->string(255),
            'dual_lab_work' => $this->boolean(),
            'dual_practice' => $this->boolean(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%study_subject}}');
    }
}