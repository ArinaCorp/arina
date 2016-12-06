<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161203_071322_create_table_employee extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'is_in_education' => $this->smallInteger()->notNull(),
            'position_id' => $this->integer(2)->notNull(),
            'category_id' => $this->integer(2),
            'type' => $this->integer(2)->notNull(),
            'first_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'gender' => $this->smallInteger()->notNull(),
            'cyclic_commission_id'=>$this->integer(2),
            'birth_date'=>$this->date(),
            'passport'=>$this->string(10)->unique(),
            'passport_issued_by'=>$this->string(10),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%employee}}');
    }
}
