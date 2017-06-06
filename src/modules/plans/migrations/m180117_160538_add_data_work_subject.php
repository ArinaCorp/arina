<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m180117_160538_add_data_work_subject extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->batchInsert('{{%work_subject}}', [
            'id', 'work_plan_id', 'subject_id', 'total', 'lectures', 'lab_works', 'practices',
            'weeks', 'control', 'cyclic_commission_id', 'certificate_name', 'diploma_name',
            'control_hours', 'project_hours', 'dual_practice', 'dual_lab_work'
        ],
            [

                [
                    1, 1, 1,
                    '[43,55,42,0,0,0,0,0]', '[0,0,2,0,0,0,0,0,0]', '[0,0,0,0,0,0,0,0]',
                    '[34,46,30,0,0,0,0]', '[2,2,2,0,0,0,0,0]',
                    '[[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,1,0,0,0],[0,0,0,0,0,0],
                    [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]',
                    10, '', '', '{"total":"140","lectures":"96","lab_works":"0","practices":"18"}', '', 0, 0
                ]
            ]
        );
    }

    /**
     * @return bool
     * @inheritdoc
     */
    public function down()
    {
        echo "m180117_160538_add_data_work_subject cannot be reverted.\n";
        return false;
    }



}