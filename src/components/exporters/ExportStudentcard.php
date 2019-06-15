<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 6:40 PM
 */

namespace app\components\exporters;


use app\components\ExportToExcel;
use app\helpers\GlobalHelper;
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

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        // Fill in the form on the first sheet with student data.
        // If there is a comment with a property name, it means it's not used(in the college workflow) right not.
        $activeSheet->setCellValue('C6', $student->department->title);
        $activeSheet->setCellValue('L7', $student->specialityQualification->title);
        $activeSheet->setCellValue('D8', $student->speciality->title);
        $activeSheet->setCellValue('J11', $student->fullName);
        $activeSheet->setCellValue('F12', $student->birth_day);
        $activeSheet->setCellValue('G13', 'birth_place'); //TODO: Implement birth place
        $activeSheet->setCellValue('E14', $student->country->name); //TODO: Implement citizenship later(?)
        $activeSheet->setCellValue('E15', $student->finishedInstitution);
        $activeSheet->setCellValue('E17', $student->familyStatus);
        $activeSheet->setCellValue('J18', $student->livingAddress);
        //$activeSheet->setCellValue('J19', 'living_address_2'); The cells are unified with wrap text
        //$activeSheet->setCellValue('J20', 'living_address_3');
        $activeSheet->setCellValue('J22', $student->fullExemptionString);
        $activeSheet->setCellValue('J23', $student->enrollmentEdict->yearCmdString);

        // if(condition) TODO: implement(?) Discuss
        $activeSheet->getCell('E24')->getStyle()->getFont()->setUnderline(true); // with experience
        // else
        $activeSheet->getCell('J24')->getStyle()->getFont()->setUnderline(true); // without experience

        $activeSheet->setCellValue('I25', $student->finished_inst); //TODO: It has to be discussed and changed(?)
        $activeSheet->setCellValue('F27', ''); //by_direction
        $activeSheet->setCellValue('N29', ''); //by_special_conditions_of_partaking_in_the_competition
        $activeSheet->setCellValue('E30', $student->withoutCompetition ? Yii::t('app', 'On exemption basis') : '');

        // if(condition) TODO: implement(?) Discuss
        $activeSheet->getCell('L31')->getStyle()->getFont()->setUnderline(true); // gov. credit
        // elseif
        $activeSheet->getCell('O31')->getStyle()->getFont()->setUnderline(true); // individual
        // else
        $activeSheet->getCell('P31')->getStyle()->getFont()->setUnderline(true); // legal entity

        $activeSheet->setCellValue('F32', ''); // employment_history
        $activeSheet->setCellValue('C35', $student->tax_id); //TODO: We don't have a checkbox to check if someone uses passport serial and number instead

        //Some edict list logic, TODO: Discuss and implement(?) edicts
        $row = 38;
        if ($student->edicts) {
            foreach ($student->edicts as $edict) {
                $activeSheet->setCellValue("A$row", $edict->course);
                $activeSheet->setCellValue("B$row", $edict->cmdSinceString);
                $activeSheet->setCellValue("N$row", $edict->content);
                //Insert next
                $activeSheet->insertNewRowBefore($row + 1);
                $row++;
            }
            //Don't want to risk fucking up the doc, so leave one empty row.
            //$activeSheet->removeRow($row);
            $activeSheet->removeRow($row);

        }

        $spreadsheet->setActiveSheetIndex(1);
        $activeSheet = $spreadsheet->getActiveSheet();

        //Roll the subjects, marks&stuff
        //GlobalHelper used instead.
        /*$orderDict = [
            '1' => Yii::t('app', 'First'),
            '2' => Yii::t('app', 'Second'),
            '3' => Yii::t('app', 'Third'),
            '4' => Yii::t('app', 'Fourth'),
            '5' => Yii::t('app', 'Fifth'),
            '6' => Yii::t('app', 'Sixth'),
            '7' => Yii::t('app', 'Seventh'),
            '8' => Yii::t('app', 'Eighth'),
        ];*/


        //Semester 1: begins with 5
        $row = 5;
        //$counter = 1; useless
        // TODO: Implement a better way to get group's course, as at some point it will return >4. Define Max course for a group? Define finishing year?
        // TODO: Start with the semester (Course) when student was enrolled.(It already does just put it in a method)
        for ($semester = ($student->enrollmentEdict->course * 2) - 1; $semester < $student->currentGroup->getCourse($student->currentGroup->created_study_year_id+4) * 2; $semester++) {
            if ($marks = $studentCard->getMarks($semester + 1)) {
                if (($semester + 1) % 2) { // set this header for each new course (odd semester)
                    $studyYear = $student->firstGroup->getStudyYearForCourse(GlobalHelper::getCourseForSemester($semester + 1));
                    $courseHeader = mb_strtoupper(GlobalHelper::getOrderLiteral(GlobalHelper::getCourseForSemester($semester + 1), 'uk') . " $studyYear->title навчальний рік");
                    $activeSheet->setCellValue("A$row", $courseHeader);
                }
                $semesterHeader = mb_strtoupper(GlobalHelper::getOrderLiteral($semester + 1, 'uk'));
                $activeSheet->setCellValue("B$row", $semesterHeader);
                foreach ($marks as $mark) {
                    $activeSheet->setCellValue("C$row", $mark->workSubject->title);
                    $activeSheet->setCellValue("D$row", $mark->workSubject->total[$semester]); // TODO: Same here, hours should probs be taken from load
                    $activeSheet->setCellValue("E$row", number_format($mark->workSubject->total[$semester] / 30, 2));
                    $activeSheet->setCellValue("F$row", $mark->valueLiteral);
                    $activeSheet->setCellValue("G$row", $mark->valueScaleLiteral);
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
            if (!(($semester + 1) % 2)) { // the course ends on even semester
                $row += 7;
            }
        }

        //$activeSheet->setCellValue("C" . ($row + 7), 'SHIEEET BOIII');  High quality debugging

        return $spreadsheet;
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