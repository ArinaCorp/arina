<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m180117_162217_add_data_study_plan extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->batchInsert('{{%study_plan}}', [
            'id', 'speciality_qualification_id', 'semesters', 'created', 'updated', 'graph'
        ],
            [
                [
                    1, 1, '[16,24,15,4,7,7,16,8]', 1435148075, 1488353350,
                    '[["T","T","T","T","T","T","T","T","P","T","T","T","T","T","T","T","T",
                    "H","DP","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","DP","H","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S","S",
                    "H","DP","T","T","T","T","S","T","T","T","S","T","T","T","S","DP","T",
                    "T","T","S","S","P","P","P","P","P","H","DP","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","S","T","T","P","T","T","T","T","T","S",
                    "H","H","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","T","S","S","P","P","P","P","P","H","H","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S","H",
                    "DP","T","T","T","T","T","T","T","T","S","P","P","P","P","P","P","P",
                    "P","P","DP","DP","T","DP","DP"," ","T"," ","S"," "," "," "," "," "," "]]'
                ],
                [
                    2, 4, '[17,24,16,17,16,17,16,8]', 1435148140, 1435148140,
                    '[["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "H","H","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","H","H","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","S","S","P","P","P","P","P","H","H","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","S","S","P","P","P","P","P","H","H","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","T","T","T","T","T","T","T","T","S","P","P","P","P","P","P","P",
                    "P","P","DP","DP","DP","DP","DP","DA"," "," "," "," "," "," "," "," "," "]]',
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
        echo "m180117_162217_add_data_study_plan cannot be reverted.\n";
        return false;
    }
}