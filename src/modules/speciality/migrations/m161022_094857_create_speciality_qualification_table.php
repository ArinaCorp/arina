<?php

use yii\db\Migration;

/**
 * Handles the creation of table `speciality_qualification`.
 */
class m161022_094857_create_speciality_qualification_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('speciality_qualification', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'years count' => $this->integer(),
            'months count' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('speciality_qualification');
    }
}
