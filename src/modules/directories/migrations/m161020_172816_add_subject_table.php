<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m161020_172816_add_subject_table extends Migration
{

    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%subject}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'code' => $this->string(),
            'short_name' => $this->string(),
            'practice' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%subject}}');
    }
}
