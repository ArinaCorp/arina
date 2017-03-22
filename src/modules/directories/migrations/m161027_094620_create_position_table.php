<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

/**
 * Handles the creation of table `position`.
 */

class m161027_094620_create_position_table extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->createTable('{{%position}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'max_hours_1' => $this->integer(),
            'max_hours_2' => $this->integer(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */

    public function down()
    {
        $this->dropTable('{{%position}}');
    }

}
