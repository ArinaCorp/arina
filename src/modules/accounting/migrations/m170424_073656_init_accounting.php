<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m170424_073656_init_accounting extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%accounting_mounth}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(11),
            'subject_id' => $this->integer(11),
            'teacher_id' => $this->integer(11),
            'date' => $this->integer(),
            'hours' => $this->integer(),
        ], $this->getTableOptions());

    }

    public function safeDown()
    {
        echo "m170424_073656_init_accounting cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170424_073656_init_accounting cannot be reverted.\n";

        return false;
    }
    */
}
