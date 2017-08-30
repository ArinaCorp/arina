<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;
use yii\db\Schema;

class m170521_141621_add_column_district_id_to_city extends Migration
{
    use MigrationTrait;

    protected $geo = [
        'city' => '{{%city}}',
    ];

    public function up()
    {
        /**
         * Create city.district_id colummn
         */

        $this->addColumn($this->geo['city'],'district_id', Schema::TYPE_INTEGER . ' NOT NULL');

    }

    public function down()
    {
        /**
         * Delete city.district_id colummn
         */

        $this->dropColumn($this->geo['city'],'district_id');
        return true;
    }
}
