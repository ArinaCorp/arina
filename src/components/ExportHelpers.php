<?php


namespace app\components;


use app\modules\directories\models\study_year\StudyYear;
use app\modules\directories\models\subject\Subject;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\journal\widgets\MarksAccounting;
use app\modules\load\models\Load;
use app\modules\plans\models\StudySubject;
use codemix\excelexport\ActiveExcelSheet;
use Mpdf\Tag\Sub;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Yii;
use yii\helpers\ArrayHelper;

class ExportHelpers
{
    public static function ConvertToRoman($number)
    {
        $digit = str_split($number . "");
        $romanNumber = "";
        foreach ($digit as $d) {
            switch ($d) {
                case "1":
                    $romanNumber .= "I";
                    break;
                case "2":
                    $romanNumber .= "II";
                    break;
                case "3":
                    $romanNumber .= "III";
                    break;
                case "4":
                    $romanNumber .= "IV";
                    break;
                case "5":
                    $romanNumber .= "V";
                    break;
                case "6":
                    $romanNumber .= "VI";
                    break;
                case "7":
                    $romanNumber .= "VII";
                    break;
                case "8":
                    $romanNumber .= "VIII";
                    break;

            }
        }
        return $romanNumber;
    }

    public static function isArrayAndIsEmpty($item)
    {
        $bool = false;
        if (is_array($item)) {
            if (count($item)) {
                $bool = true;
            }
        }
        return $bool;
    }

    public static function decrementLetter($Alphabet)
    {
        return chr(ord($Alphabet) - 1);
    }

    public static function coundLengthOfMultipleArrays($_array = [])
    {
        $count = 0;
        foreach ($_array as $array) {
            if (is_array($array)) {
                $count += count($array);
            }
        }
        return $count;
    }

    public static function getMarks($subjects = [], $students = [])
    {
        $marks = [];
        $range = [2, 5, 4, 5, 3, 4, 5, 3, 4, 5, 3];
//      var_dump($subjects[0]);die;
        foreach ($subjects as $subject) {
            foreach ($students as $student) {
                $subject_type = isset($subject['type']) ? $subject['type'] : "NaN";
                array_push($marks, [
                    'value' => $range[array_rand($range)],
                    'subject_id' => $subject['subject']->id,
                    'student_id' => $student->id,
                    'type' => $subject_type
                ]);
            }
        }
        return $marks;
    }

    /**
     * @param array $subjects
     * @param array $students
     * @param array $loads Load[]
     * @param null $type string
     * @param $firstDate Date
     * @param $lastDate Date
     * @return array
     */
    public static function getRealMarks($firstDate, $lastDate, $subjects = [], $students = [], $loads = [], $type = NULL)
    {
        $allMarks = [];
//        var_dump($subjects[0]);die;
        /**
         * @var $load Load
         * @var $subject Subject
         */
        $date1 = strtotime($firstDate);
        $date2 = strtotime($lastDate);
        foreach ($loads as $load) {
            foreach ($subjects as $subject) {
                foreach ($students as $student) {
                    foreach ($load->journalRecords as $journalRecord) {
                        $types = $journalRecord->type == $type;
                        $sub = $load->workSubject->subject->id == $subject['subject']->id;
                        $sem = $date1 <= strtotime($journalRecord->date) && strtotime($journalRecord->date) <= $date2;
                        $rec = $journalRecord->id == $subject['record_id'];
//                        var_dump(Date('d.m.Y',$date2).'   :   '.$journalRecord->date);die;

                        if ($types && $sub && $sem && $rec) {
                            $marks = JournalMark::findAll([
                                'student_id' => $student->id,
                                'record_id' => $journalRecord->id
                            ]);
                            foreach ($marks as $mark) {
                                $subject_type = isset($subject['type']) ? $subject['type'] : "NaN";
                                array_push($allMarks, [
                                    'value' => $mark->evaluation->value,
                                    'subject_id' => $subject['subject']->id,
                                    'student_id' => $student->id,
                                    'type' => $subject_type,
                                    'record_id' => $subject['record_id']
                                ]);
                            }
                            $marks = [];
                        }
                    }
                }
            }
        }
        return $allMarks;
    }


    public static function getPropusk($students = [])
    {
        $propusks = [];
        foreach ($students as $student) {
            $hours = rand(0, 100);
            array_push($propusks, [
                "student_id" => $student->id,
                "hours" => $hours,
                "with_reason" => rand(0, $hours)
            ]);
        }
        return $propusks;
    }

    /**
     * @param Spreadsheet $spreadSheet
     * @param $mark
     *
     * @return
     */
    public static function MarkColorized($spreadSheet, $mark, $cords)
    {
        switch ($mark) {
            case 5:
                return $spreadSheet->getActiveSheet()->getStyle($cords)->getFont()->getColor()->setARGB(Color::COLOR_RED);
                break;
            case 4:
                return $spreadSheet->getActiveSheet()->getStyle($cords)->getFont()->getColor()->setARGB(Color::COLOR_DARKGREEN);
                break;
            case 3:
                return $spreadSheet->getActiveSheet()->getStyle($cords)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
                break;
            case 2:
                return $spreadSheet->getActiveSheet()->getStyle($cords)->getFont()->getColor()->setARGB(Color::COLOR_BLACK);
                break;

        }
    }

    public static function getMarkLabels()
    {
        return [
            Yii::t('app', 'Excellent'),
            Yii::t('app', 'Good'),
            Yii::t('app', 'Satisfactorily'),
            Yii::t('app', 'Unsatisfactorily'),
        ];
    }

    public static function textBetween($words, $spaces)
    {

        $string = $words[0];
        $wordLength = strlen($words[0]);
        foreach ($spaces as $index => $space) {

            $after = strlen($string) + $space - $wordLength;
            while (strlen($string) <= $after) {
                $string .= " ";
            }
            $wordLength = strlen($words[$index + 1]);
            $string .= $words[$index + 1];
        }

        return $string;
    }

    public static function getTickets($count)
    {
        $tickets = [];
        for ($i = 1; $i <= $count; $i++) {
            array_push($tickets, $i);
        }
        shuffle($tickets);
        return $tickets;
    }

    public static function getSemesterList()
    {
        return [
            1 => Yii::t('app', 'First'),
            2 => Yii::t('app', 'Second'),
            3 => Yii::t('app', 'Third'),
            4 => Yii::t('app', 'Fourth'),
            5 => Yii::t('app', 'Fifth'),
            6 => Yii::t('app', 'Sixth'),
            7 => Yii::t('app', 'Seventh'),
            8 => Yii::t('app', 'Eighth'),
        ];
    }

    public static function getJournalRecordsByLoad($group_id)
    {
        $year = StudyYear::findOne(['year_start' => Yii::$app->get('calendar')->getCurrentYear()]);
        $loads = Load::findAll(['group_id' => $group_id, 'study_year_id' => $year]);
        $journal_records = [];
        foreach ($loads as $load) {
            array_push($journal_records, JournalRecord::findOne(['load_id' => $load->id]));
        }
        return ArrayHelper::map($journal_records, 'id', 'date');
    }

    /**
     * @param $dateFrom Date
     * @param $dateTo Date
     * @param $load Load
     */
    public static function getSemester($dateFrom, $dateTo, $load)
    {
        $date1 = strtotime($dateFrom);
        $date2 = strtotime($dateTo);
        $year = StudyYear::findOne(['id' => $load->study_year_id])->year_start;
        $education_begin = Date('d.m.Y', strtotime('01.09.' . $year));
        $education_center = Date('d.m.Y', strtotime($education_begin . '+ 6 months'));
        $education_end = Date('d.m.Y', strtotime($education_begin . '+ 1 year'));

        $f_begin = $date1 >= strtotime($education_begin);
        $f_center = $date2 < strtotime($education_center);
        $s_begin = $date1 >= strtotime($education_center);
        $s_center = $date2 < strtotime($education_end);
        if ($f_begin && $f_center) {
            return 1;
        } elseif ($s_begin && $s_center) {
            return 2;
        }
        return 1;
    }


    public static function debugger()
    {
        $params = func_get_args();
        echo '<p style="color:white;background: red;padding: 10px;font-size: 30px;margin: 0;">Debugger 2.2.8</p>';
        highlight_string("<?php\n" . var_export($params, true) . "?>");
        die;
    }

}