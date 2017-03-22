<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

/**
 * Handles the creation of table `qualification`.
 */
class m161022_095057_create_qualification_table extends Migration
{
    use MigrationTrait;
    
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('qualification', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('qualification');
    }
}
