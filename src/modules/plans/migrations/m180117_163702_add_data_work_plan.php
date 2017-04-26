<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m180117_163702_add_data_work_plan extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->batchInsert('{{%work_plan}}', [
            'id', 'speciality_qualification_id', 'semesters', 'created', 'updated', 'graph', 'study_year_id'
        ],
            [
                [
                    1, 1, '[17,24,16,17,16,17,16,7]', 1453466971, 1453466980,
                    '[["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T"
                    ,"H","H","H","H","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","T","T","T","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "H","H","H","H","T","T","T","T","T","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","T","T","T","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","H","H","P","P","P","P","P","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","T","S","S","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","H","H","P","P","P","P","P","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","T","S","S","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","H","H","P","P","P","P","P","T","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","S","S","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","H","H","P","P","P","P","P","T","T","T","T","T","T","T","T","T",
                    "T","T","T","T","T","T","T","T","S","S","H","H","H","H","H","H","H"],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","H","T","T","T","T","T","T","T","S","P","P","P","P","P","P","P",
                    "P","P","DP","DP","DP","DP","DP","DA"," "," "," "," "," "," "," "," "," "],
                    ["T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","T","S",
                    "H","H","H","T","T","T","T","T","T","T","S","P","P","P","P","P","P","P",
                    "P","P","DP","DP","DP","DP","DP","DA"," "," "," "," "," "," "," "," "," "]]', 1
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
        echo "m180117_163702_add_data_work_plan cannot be reverted.\n";
        return false;
    }
}