<?php

use app\modules\directories\models\subject_cycle\SubjectCycle;
use yii\db\Migration;

/**
 * Class m190523_155100_add_sort_order_to_subject_cycle
 */
class m190523_155100_add_sort_order_to_subject_cycle extends Migration
{
    public function up()
    {
        $this->addColumn('subject_cycle', 'sort_order', $this->float()->notNull());

        $subjectCycles = SubjectCycle::find()->all();

        foreach ($subjectCycles as $key => $subjectCycle) {
            $subjectCycle->sort_order = $key + 1;
            $subjectCycle->save(false, ['sort_order']);
        }
    }

    public function down()
    {
        $this->dropColumn('subject_cycle', 'sort_order');
    }
}
