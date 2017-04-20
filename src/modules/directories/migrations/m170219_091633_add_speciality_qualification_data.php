<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170219_091633_add_speciality_qualification_data extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->batchInsert('{{%speciality_qualification}}', [
            'id', 'title', 'speciality_id', 'qualification_id', 'years_count', 'months_count',
        ],
            [
                [1, 'Технік програміст', 1, 1, 3, 10,],
                [2, 'Бакалавр програміст', 1, 2, 3, 10,],
                [3, 'Молодший інженер комп\'ютерних систем', 2, 1, 3, 10,],
                [4, 'Бакалавр з інженерії комп\'ютерних систем', 2, 1, 3, 10,],
                [5, 'Технічний обробник матеріалів', 3, 1, 3, 10,],
                [6, 'Бакалавр обробки матеріалів', 3, 2, 3, 10,],
                [7, 'Молодший економіст підприємства', 4, 1, 3, 0,],
                [8, 'Бакалавр економіки', 4, 2, 3, 0,],
            ]
        );
    }

    public function down()
    {
        echo "m170219_091633_add_speciality_qualification_data cannot be reverted.\n";
        return false;
    }
}