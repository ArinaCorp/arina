<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170117_164527_create_table_study_plan extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%study_plan}}', [
            'id' => $this->primaryKey(),
            'speciality_id' => $this->integer(5),
            'semesters' => $this->string(255),
            'graphs' => $this->string(255),
            'created' => $this->date(),
            'updated' => $this->date(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%study_plan}}');
    }
}