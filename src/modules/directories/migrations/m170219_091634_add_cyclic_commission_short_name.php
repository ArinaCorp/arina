<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m170219_091634_add_cyclic_commission_short_name extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->addColumn('{{%cyclic_commission}}', 'short_title', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%cyclic_commission}}', 'short_title');
    }
}