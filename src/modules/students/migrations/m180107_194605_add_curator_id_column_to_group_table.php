<?php

use yii\db\Migration;

class m180107_194605_add_curator_id_column_to_group_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%group}}', 'curator_id', $this->integer());
    }

    public function down()
    {
        $this-> dropColumn('{{%group}}', 'curator_id');
    }
}
