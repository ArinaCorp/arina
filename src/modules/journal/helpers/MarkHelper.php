<?php

namespace app\modules\journal\helpers;

use app\modules\journal\models\evaluation\EvaluationSystem;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use Yii;

class MarkHelper
{
    const MARK_SCALE_UNSATISFIABLE = 2;
    const MARK_SCALE_SATISFIABLE = 3;
    const MARK_SCALE_GOOD = 4;
    const MARK_SCALE_EXCELLENT = 5;

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

    /**
     * Returns the national scale for a mark value
     * 0 - no match
     * 1 - uncompleted/unfair
     * 2 - unsatisfiable
     * 3 - satisfiable
     * 4 - good
     * 5 - excellent
     * @param $mark int
     * @param $evalSystemId int
     * @return string
     */
    public static function getMarkScale($mark, $evalSystemId)
    {
        // Five-level system is equal to the scale, In both systems mark 1 equals scale 1
        if ($evalSystemId == EvaluationSystem::FIVE_POINT_SCALE || $mark == 1) {
            return $mark;
        }

        // Twelve-level system
        if ($evalSystemId == EvaluationSystem::TWELVE_POINT_SCALE) {
            if ($mark < 4) {
                return 2;
            } elseif ($mark < 7) {
                return 3;
            } elseif ($mark < 10) {
                return 4;
            } elseif ($mark < 13) {
                return 5;
            }
        }

        // No match
        return 0;
    }

    public static function getMarkScaleLiteral($mark, $evalSystemId, $lang = null)
    {
        return Yii::t('number', [
            '0' => 'ERR?',
            '1' => 'Uncompleted/Unfair',
            '2' => 'Unsatisfiable',
            '3' => 'Satisfiable',
            '4' => 'Good',
            '5' => 'Excellent',
        ][self::getMarkScale($mark, $evalSystemId)], [], $lang);
    }

}