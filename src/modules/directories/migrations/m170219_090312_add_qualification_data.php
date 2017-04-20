<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170219_090312_add_qualification_data extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->batchInsert('{{%qualification}}', [
            'id', 'title',
        ],
            [
                [1, 'Молодший спеціаліст'],
                [2, 'Бакалавр'],
            ]
        );
    }

    public function down()
    {
        echo "m170219_090312_add_qualification_data cannot be reverted.\n";
        return false;
    }
}