<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m161023_200213_add_study_year extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable(
            '{{%study_years}}',
            [
                'id' => $this->primaryKey(),
                'year_start' => $this->integer(),
            ],
            $this->getTableOptions()
        );
    }

    public function down()
    {
        $this->dropTable('{{%study_years}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
