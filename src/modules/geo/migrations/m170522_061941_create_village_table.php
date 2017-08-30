<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `village`.
 */
class m170522_061941_create_village_table extends Migration
{
    use MigrationTrait;

    protected $geo = [
        'village' => '{{%village}}',
    ];

    public function up()
    {
        foreach ($this->geo as $table) {
            if ($this->tableExist($table)){
                $this->stdout("Table '{$table}' already exists\n");
                if ($this->confirm('Drop and create new?')) {
                    $this->dropTable($table);
                } else {
                    return true;
                }
            }
        }

        /**
         * Create district table
         */
        $this->createTable($this->geo['village'], [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'region_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'country_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'district_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

    }

    public function down()
    {
        $this->dropTable($this->geo['village']);
        return true;
    }
}
