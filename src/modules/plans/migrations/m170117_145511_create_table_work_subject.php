<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170117_145511_create_table_work_subject extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%work_subject}}', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer(5),
            'work_plan_id' => $this->integer(5),
            'total' => $this->string(255),
            'lectures' => $this->string(255),
            'lab_works' => $this->string(255),
            'practices' => $this->string(255),
            'weeks' => $this->string(255),
            'control' => $this->string(255),
            'cyclic_commission_id' => $this->integer(5),
            'certificate_name' => $this->string(255),
            'diploma_name' => $this->string(255),
            'project_hours' => $this->integer(5),
            'control_hours' => $this->string(255),
            'dual_lab_work' => $this->boolean(),
            'dual_practice' => $this->boolean(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%work_subject}}');
    }
}