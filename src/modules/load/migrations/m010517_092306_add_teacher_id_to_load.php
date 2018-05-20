<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m010517_092306_add_teacher_id_to_load extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%load}}', 'teacher_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%load}}', 'teacher_id');
    }
}