<?php

use yii\db\Migration;

class m161205_202505_tbl_exemptions_relations extends Migration
{
    use \nullref\core\traits\MigrationTrait;

    public function up()
    {
        $this->createTable('{{%exemptions_students_relations}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(11),
            'exemption_id' => $this->integer(11),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%exemptions_students_relations}}');
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
