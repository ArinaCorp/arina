<?php

namespace app\modules\journal\helpers;

use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;

class MarksAccountingHelper
{
    /**
     * @param $loadId
     * @param JournalRecord[] $records
     * @return array
     */
    public static function getMarks($loadId, $records)
    {
        $marks = [];

        $load = Load::findOne(['id' => $loadId]);

        $marksRecords = JournalMark::find()
            ->joinWith('evaluation')
            ->where([
                'record_id' => $load->getJournalRecords()->select('id')->column(),
            ])->all();

        $students = $load->group->getStudentsArray();

        foreach ($students as $student) {
            foreach ($records as $journalRecord) {
                foreach ($marksRecords as $mark) {
                    if ($student->id == $mark->student_id && $journalRecord->id == $mark->record_id) {
                        $marks[$mark->student_id][$mark->record_id] = $mark;
                    }
                }
                if (!isset($marks[$student->id][$journalRecord->id])) {
                    $marks[$student->id][$journalRecord->id] = new JournalMark();
                }
            }
        }
        return $marks;
    }
}