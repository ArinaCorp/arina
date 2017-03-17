<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170228_100541_tbl_employee_education extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%employee_education}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(11),
            'name_of_institution' => $this->string(64),
            'document' => $this->string(64),
            'graduation_year' => $this->integer(),
            'speciality' => $this->string(64),
            'qualification' => $this->string(64),
            'education_form' => $this->string(64),
        ], $this->getTableOptions());
    }

    public function down()
    {
        echo "m170228_100541_tbl_employee_education cannot be reverted.\n";

        return false;
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
