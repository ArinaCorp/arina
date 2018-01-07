<?php

use yii\db\Migration;

class m180107_154634_add_country_id_to_student extends Migration
{
    public function up()
    {
        $this->addColumn('{{%student}}', 'country_id', $this->integer());
        $this->addColumn('{{%student}}', 'region_id', $this->integer());
        $this->addColumn('{{%student}}', 'district_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%student}}', 'country_id');
        $this->dropColumn('{{%student}}', 'region_id');
        $this->dropColumn('{{%student}}', 'district_id');
    }
}
