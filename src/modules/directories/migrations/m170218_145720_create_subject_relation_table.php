<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170218_145720_create_subject_relation_table extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%subject_relation}}', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer(),
            'speciality_qualification_id' => $this->integer(),
            'subject_cycle_id' => $this->integer(),
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%subject_relation}}');
    }
}