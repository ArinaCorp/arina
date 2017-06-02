<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;
use yii\db\Schema;

class m170521_132704_add_column_country_id_to_district extends Migration
{
    use MigrationTrait;

    protected $geo = [
        'district' => '{{%district}}',
    ];

    public function up()
    {
        /**
         * Create district.country_id colummn
         */

        $this->addColumn($this->geo['district'],'country_id', Schema::TYPE_INTEGER . ' NOT NULL');

    }

    public function down()
    {
        /**
         * Delete district.country_id colummn
         */

        $this->dropColumn($this->geo['district'],'country_id');
        return true;
    }
}
