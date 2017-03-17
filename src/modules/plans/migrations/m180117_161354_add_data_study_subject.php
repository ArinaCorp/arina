<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m180117_161354_add_data_study_subject extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->batchInsert('{{%study_subject}}', [
            'id', 'study_plan_id', 'subject_id', 'total', 'lectures', 'lab_works', 'practices', 'weeks',
            'control', 'practice_weeks', 'diploma_name', 'certificate_name', 'dual_practice', 'dual_lab_work'
        ],
            [
                [
                    1, 13, 105, 140, 96, 0, 18, '["2","2","2","","","","",""]',
                    '[["0","0","0","0","0","0"],["1","0","0","0","0","0"],
                    ["0","0","1","0","0","0"],["0","0","0","0","0","0"],
                    ["0","0","0","0","0","0"],["0","0","0","0","0","0"],
                    ["0","0","0","0","0","0"],["0","0","0","0","0","0"]]',
                    NULL, '', '', 0, 0
                ],
                [
                    2, 13, 106, 210, 2, 0, 170, '["4","3","2","","","","",""]',
                    '[["0","0","0","0","0","0"],["1","0","0","0","0","0"],
                    ["0","0","1","0","0","0"],["0","0","0","0","0","0"],
                    ["0","0","0","0","0","0"],["0","0","0","0","0","0"],
                    ["0","0","0","0","0","0"],["0","0","0","0","0","0"]]',
                    NULL, '', '', 0, 0
                ],
            ]
        );
    }

    /**
     * @return bool
     * @inheritdoc
     */
    public function down()
    {
        echo "m180117_161354_add_data_study_subject cannot be reverted.\n";
        return false;
    }
}