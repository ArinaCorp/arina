<?php

use yii\db\Migration;

class m170622_064725_refactor_journal_tables extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%journal_mark}}', 'retake_ticket');
        $this->dropColumn('{{%journal_mark}}', 'retake_date');
        $this->dropColumn('{{%journal_mark}}', 'retake_evaluation_id');
        $this->addColumn('{{%journal_record_types}}', 'has_retake', $this->boolean());
        $this->addColumn('{{%journal_record}}', 'retake_for_id', $this->integer());
    }

    public function safeDown()
    {
        $this->addColumn('{{%journal_mark}}', 'retake_ticket', $this->string(128)->null()->defaultValue(null));
        $this->addColumn('{{%journal_mark}}', 'retake_date', $this->date()->null());
        $this->addColumn('{{%journal_mark}}', 'retake_evaluation_id', $this->integer()->null());
        $this->dropColumn('{{%journal_record_types}}', 'has_retake');
        $this->dropColumn('{{%journal_record}}', 'retake_for_id');
    }
}
