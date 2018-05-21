<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m170219_091635_add_cyclic_commission_records extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->truncateTable('{{%cyclic_commission}}');

        $this->batchInsert('{{%cyclic_commission}}', ['id', 'title', 'short_title', 'head_id'], [
                [1, 'Інженерної механіки', 'ІМ', 19],
                [2, 'Економіки і менеджменту', 'ЕМ', 18],
                [3, 'Комп\'ютерних систем', 'КС', 17],
                [4, 'Програмного забезпечення', 'ПЗ', 1],
                [5, 'Фізичного виховання', 'ФВ', 78],
                [6, 'Природничо-математичних наук', 'ПМ', 15],
                [7, 'Соціально-економічних наук', 'СЕ', 14],
                [8, 'Гуманітарних дисциплін', 'ГД', 13],
            ]
        );
    }

    public function down()
    {
        $this->truncateTable('{{%cyclic_commission}}');
    }
}