<?php

use yii\db\Migration;

/**
 * Handles the creation of table `study_form`.
 */
class m190605_182139_create_study_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('study_form', [
            'id' => $this->primaryKey(11),
            'title' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('study_form');
    }
}
