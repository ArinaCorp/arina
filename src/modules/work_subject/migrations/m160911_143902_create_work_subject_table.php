<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m161110_095907_create_work_subject_table extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%work_subject}}', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer(),
            'plan_id' => $this->integer(),
            'total' => $this->string(),
            'lectures' => $this->string(),
            'labs' => $this->string(),
            'practices' => $this->string(),
            'weeks' => $this->string(),
            'control' => $this->string(),
            'cyclic_commission_id' => $this->integer(),
            'certificate_name' => $this->string(),
            'diploma_name' => $this->string(),
            'project_hours' => $this->integer(),
            'control_hours' => $this->string(),
            'dual_labs' => $this->integer(),
            'dual_practice' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%work_subject}}');
    }
}
