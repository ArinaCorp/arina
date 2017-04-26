<?php

use yii\db\Migration;

class m161027_094928_add_position_data extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%position}}', ['id', 'title', 'max_hours_1', 'max_hours_2'],[
            [1, 'Викладач', 720, 360],
            [2, 'Завідувач', 720, 360],
            [3, 'Директор', 720, 360],
        ]);
    }

    public function down()
    {
        echo "m161027_094928_add_position_data cannot be reverted.\n";

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
