<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161027_055442_create_table_group extends Migration
{
    use MigrationTrait;
    public function up()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'speciality_qualifications_id'=> $this->integer(11),
            'created_study_year_id'=>$this->integer(11),
            'number_group' => $this->smallInteger(),
            'title'=>$this->string(8),
            'group_leader_id'=>$this->integer(11),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->delete('{{%group}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
