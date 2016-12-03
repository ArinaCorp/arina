<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161203_074404_create_table_work_subject extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%work_subject}}', [
            'id' => $this->primaryKey()->unique(),
            'subject_id' => $this->integer(2)->notNull(),
            'plan_id' => $this->integer(2),
            'total' => $this->string(),
            'lectures' => $this->string(),
            'labs' => $this->string(),
            'practices' => $this->string(),
            'weeks' => $this->string(),
            'control' => $this->string(),
            'cyclic_commission_id' => $this->integer(2),
            'certificate_name' => $this->string(),
            'diploma_name' => $this->string(),
            'project_hours' => $this->integer(),
            'control_hours' => $this->string(),
            'dual_labs' => $this->smallInteger(),
            'dual_practice' => $this->smallInteger(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%work_subject}}');
    }
}