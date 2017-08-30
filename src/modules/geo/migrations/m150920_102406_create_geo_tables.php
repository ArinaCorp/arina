<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;
use yii\db\Schema;

class m150920_102406_create_geo_tables extends Migration
{
    use MigrationTrait;

    protected $geo = [
        'country' => '{{%country}}',
        'region' => '{{%region}}',
        'city' => '{{%city}}',
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
         * Create country table
         */
        $this->createTable($this->geo['country'], [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING. '(10) NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

        /**
         * Create region table
         */
        $this->createTable($this->geo['region'], [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'country_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

        /**
         * Create region table
         */
        $this->createTable($this->geo['city'], [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'region_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'country_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

    }

    public function down()
    {
        $this->dropTable($this->geo['city']);
        $this->dropTable($this->geo['region']);
        $this->dropTable($this->geo['country']);
        return true;
    }

}
