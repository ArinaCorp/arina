<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m170424_080707_init_accounting_year extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%accounting_year}}', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer(11),
            'teacher_id' => $this->integer(11),
            'mounth' => $this->integer(),
        ], $this->getTableOptions());

    }

    public function safeDown()
    {
        echo "m170424_080707_init_accounting_year cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170424_080707_init_accounting_year cannot be reverted.\n";

        return false;
    }
    */
}
