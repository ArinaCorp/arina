<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 6:40 PM
 */

namespace app\components\exporters;


use app\components\ExportToExcel;
use app\modules\plans\models\StudentPlan;
use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\students\models\StudentCard;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ExportStudentcard
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $studentCard StudentCard
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet, $studentCard)
    {
        $student = $studentCard->student;
        $studyYear = $studentCard->studyYear;

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        // Fill in the form on the first sheet with student data.
        $activeSheet->setCellValue('C6', $student->department->title);
        $activeSheet->setCellValue('L7', $student->specialityQualification->title);
        $activeSheet->setCellValue('D8', $student->speciality->title);
        $activeSheet->setCellValue('J11', $student->fullName);
        $activeSheet->setCellValue('F12', $student->birth_day);
        $activeSheet->setCellValue('G13', 'birth_place');
        $activeSheet->setCellValue('E14', 'citizenship');
        $activeSheet->setCellValue('E15', 'finished_institution');
        $activeSheet->setCellValue('E17', 'family_status');
        $activeSheet->setCellValue('J18', 'living_address_1');
        $activeSheet->setCellValue('J19', 'living_address_2');
        $activeSheet->setCellValue('J20', 'living_address_3');
        $activeSheet->setCellValue('J22', 'exemptions_upon_enrolling');
        $activeSheet->setCellValue('J23', 'enrolled_by_edict_since');

        // if(condition) TODO: implement(?)
        $activeSheet->getCell('E24')->getStyle()->getFont()->setUnderline(true); // with experience
        // else
        $activeSheet->getCell('J24')->getStyle()->getFont()->setUnderline(true); // without experience

        $activeSheet->setCellValue('I25', 'transferred_in_order_from');
        $activeSheet->setCellValue('F27', 'by_direction');
        $activeSheet->setCellValue('N29', 'by_special_conditions_of_partaking_in_the_competition');
        $activeSheet->setCellValue('E30', 'without_competition');

        // if(condition) TODO: implement(?)
        $activeSheet->getCell('L31')->getStyle()->getFont()->setUnderline(true); // gov. credit
        // elseif
        $activeSheet->getCell('O31')->getStyle()->getFont()->setUnderline(true); // individual
        // else
        $activeSheet->getCell('P31')->getStyle()->getFont()->setUnderline(true); // legal entity

        $activeSheet->setCellValue('F32', 'employment_history');
        $activeSheet->setCellValue('C35', 'long_sentence_with_id');

        //Some edict list logic, TODO: Discuss and implement(?) edicts
        // ---

        $spreadsheet->setActiveSheetIndex(1);
        $activeSheet = $spreadsheet->getActiveSheet();

        //Roll the subjects, marks&stuff
        $orderDict = [
            '1' => Yii::t('app', 'First'),
            '2' => Yii::t('app', 'Second'),
            '3' => Yii::t('app', 'Third'),
            '4' => Yii::t('app', 'Fourth'),
            '5' => Yii::t('app', 'Fifth'),
            '6' => Yii::t('app', 'Sixth'),
            '7' => Yii::t('app', 'Seventh'),
            '8' => Yii::t('app', 'Eighth'),
        ];
        //Semester 1: begins with 5
        $row = 5;
        //$counter = 1; useless
        for ($semester = 1; $semester <= 4 /* $student->getCourse()*2 */; $semester++) { // TODO: For now, demonstrate only 1-4 semesters
            if ($marks = $studentCard->getMarks($semester)) {
                if ($semester % 2) { // set this header for each new course (odd semester)
                    $courseHeader = mb_strtoupper($orderDict[self::getCourseForSemester($semester)] . " $studyYear->title навчальний рік");
                    $activeSheet->setCellValue("A$row", $courseHeader);
                }
                $semesterHeader = mb_strtoupper($orderDict[$semester]);
                $activeSheet->setCellValue("B$row", $semesterHeader);
                foreach ($marks as $mark) {
                    $activeSheet->setCellValue("C$row", $mark->workSubject->title);
                    $activeSheet->setCellValue("D$row", $mark->workSubject->total[$semester]); // TODO: Same here, hours should probs be taken from load
                    $activeSheet->setCellValue("E$row", number_format($mark->workSubject->total[$semester] / 30, 2));
                    $activeSheet->setCellValue("F$row", $mark->valueLiteral);
                    $activeSheet->setCellValue("G$row", $mark->valueScale);
                    $activeSheet->setCellValue("H$row", $mark->retake_date ? $mark->retake_date : $mark->date);
                    //Insert next
                    $activeSheet->insertNewRowBefore($row + 1);
                    $row++;
                }
                // actually have to remove 2 rows, but PhpSpreadsheet fucks up a doc if you have merged rows nearby, so leave 1 empty
                // TODO: Btw this empty row may be used for Average Grade per semester, seen these in some student card examples
                $activeSheet->removeRow($row);
                $row++;
            }
            // the offset is +7 per course, that is until edicts are implemented
            if (!($semester % 2)) { // the course ends on even semester
                $row += 7;
            }
        }

        //$activeSheet->setCellValue("C" . ($row + 7), 'SHIEEET BOIII');  High quality debugging

        return $spreadsheet;
    }

    public static function getCourseForSemester($semester)
    {
        $semToCourse = [
            1 => 1,
            2 => 1,
            3 => 2,
            4 => 2,
            5 => 3,
            6 => 3,
            7 => 4,
            8 => 4,
        ];
        return $semToCourse[$semester];
    }

    /**
     * Find alias in cell and replace it into current value
     * @param Worksheet $sheet
     * @param $cell
     * @param $value
     * @param string $alias
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */

    private static function setValue($sheet, $cell, $value, $alias = '@value')
    {
        $sheet->setCellValue($cell, str_replace($alias, $value, $sheet->getCell($cell)->getCalculatedValue()));
    }


}