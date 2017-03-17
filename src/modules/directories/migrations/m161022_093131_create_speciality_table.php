<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;
/**
 * Handles the creation of table `speciality`.
 */
class m161022_093131_create_speciality_table extends Migration
{

    use MigrationTrait;
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('speciality', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'department_id' => $this->integer(),
            'number' => $this->string(),
            'accreditation_date' => $this->date(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('speciality');
    }
}
