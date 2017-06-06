<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170218_161329_create_subject_cycle_table extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%subject_cycle}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%subject_cycle}}');
    }
}