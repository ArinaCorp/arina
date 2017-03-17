<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170117_164527_create_table_study_plan extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%study_plan}}', [
            'id' => $this->primaryKey(),
            'speciality_qualification_id' => $this->integer(10),
            'semesters' => $this->string(255),
            'graph' => $this->text(),
            'created' => $this->integer(),
            'updated' => $this->integer(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%study_plan}}');
    }
}