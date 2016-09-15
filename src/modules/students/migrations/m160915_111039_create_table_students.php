<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m160915_111039_create_table_students extends Migration
{

    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%student}}', [
            'id' => $this->primaryKey(),
            'student_code' => $this->string(12)->unique(),
            'sseed_id' => $this->integer(11)->unique(),
            'user_id' => $this->integer(11)->unique(),
            'last_name' => $this->string()->notNull(),
            'first_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->notNull(),
            'gender' => $this->smallInteger(),
            'birth_day'=> $this->date(),
            'passport_code'=>$this->string(12)->unique(),
            'tax_id'=>$this->string(10)->unique(),
            'form_of_study_id'=>$this->smallInteger(),
            'status'=>$this->boolean(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
        ], $this->getTableOptions());

    }

    public function down()
    {
        $this->dropTable('{{%student}}');
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
