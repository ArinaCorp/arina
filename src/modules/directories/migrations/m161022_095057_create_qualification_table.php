<?php

use yii\db\Migration;

/**
 * Handles the creation of table `qualification`.
 */
class m161022_095057_create_qualification_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('qualification', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('qualification');
    }
}
