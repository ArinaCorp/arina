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
                [1, 'Program', 2, '5.05010301', '2014-01-20', 'PR'],
                [2, 'Comps', 3, '5.05010201', '2014-01-20', 'KC'],
                [3, 'Mater', 4, '5.05050302', '2014-02-20', 'OM'],
                [4, 'Economy', 4, '5.03050401', '2014-02-20', 'EC'],
                [5, 'Org', 4, '5.03060101', '2014-02-20', 'OB'],
                [6, 'Vers', 5, '5.05050202', '2014-01-23', 'BP'],
                [7, 'Auto', 5, '5.07010602', '2014-01-23', 'OA'],
            ]
        );
    }

    public function down()
    {
        echo "m180117_161354_add_data_study_subject cannot be reverted.\n";
        return false;
    }
}