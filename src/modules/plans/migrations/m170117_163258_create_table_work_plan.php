<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170117_163258_create_table_work_plan extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%work_plan}}', [
            'id' => $this->primaryKey(),
            'speciality_qualification_id' => $this->integer(10),
            'semesters' => $this->string(255),
            'graph' => $this->text(),
            'created' => $this->integer(),
            'updated' => $this->integer(),
            'study_year_id' => $this->integer(10),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%work_plan}}');
    }
}