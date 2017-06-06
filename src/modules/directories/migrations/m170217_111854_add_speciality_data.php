<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170217_111854_add_speciality_data extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->batchInsert('{{%speciality}}', [
            'id', 'title', 'department_id', 'number', 'accreditation_date', 'short_title'
        ],
            [
                [1, 'Інженерія програмного забезпечення', 1, '5.05010301', '2014-01-20', 'ПІ'],
                [2, 'Інженерія компю\'терних систем', 2, '5.05010201', '2014-01-20', 'КІ'],
                [3, 'Обробка матеріалів', 3, '5.05050302', '2014-02-20', 'ОМ'],
                [4, 'Економіка підприємства', 4, '5.03050401', '2014-02-20', 'ЕП'],
            ]
        );
    }

    public function down()
    {
        echo "m180117_161354_add_data_study_subject cannot be reverted.\n";
        return false;
    }
}