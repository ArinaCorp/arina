<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

/**
 * Handles the creation of table `speciality_qualification`.
 */
class m161022_094857_create_speciality_qualification_table extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('speciality_qualification', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'speciality_id'=>$this->integer(),
            'qualification_id'=>$this->integer(),
            'years_count' => $this->integer(),
            'months_count' => $this->integer(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('speciality_qualification');
    }
}
