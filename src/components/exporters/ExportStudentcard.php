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
use app\modules\journal\helpers\MarkHelper;
use app\modules\journal\models\record\JournalMark;
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
     * @throws \yii\base\InvalidConfigException
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

        // if(condition) TODO: For now leave with no underline. To be implemented later.
        $activeSheet->getCell('E24')->getStyle()->getFont()->setUnderline(false); // with experience
        // else
        $activeSheet->getCell('J24')->getStyle()->getFont()->setUnderline(false); // without experience

        $activeSheet->setCellValue('I25', $student->finished_inst);
        $activeSheet->setCellValue('F27', ''); //by_direction
        $activeSheet->setCellValue('N29', ''); //by_special_conditions_of_partaking_in_the_competition
        $activeSheet->setCellValue('E30', $student->withoutCompetition ? Yii::t('app', 'On exemption basis') : '');

        // if(condition) TODO: implement(?) Discuss
        $activeSheet->getCell('L31')->getStyle()->getFont()->setUnderline(false); // gov. credit
        // elseif
        $activeSheet->getCell('O31')->getStyle()->getFont()->setUnderline(false); // individual
        // else
        $activeSheet->getCell('P31')->getStyle()->getFont()->setUnderline(false); // legal entity

        $activeSheet->setCellValue('F32', ''); // employment history book
        $activeSheet->setCellValue('C35', $student->tax_id); //TODO: We don't have a checkbox to check if someone uses passport serial and number instead

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

        // Page 2
        $spreadsheet->setActiveSheetIndex(1);
        $activeSheet = $spreadsheet->getActiveSheet();

        //Semester 1: begins with 5
        $row = 5;
        // TODO: Implement a better way to get group's course, as at some point it will return >4. Define Max course for a group? Define finishing year?
        // TODO: Start with the semester (Course) when student was enrolled.(It already does just put it in a method)
        for ($semester = ($student->enrollmentEdict->course * 2) - 1; $semester <= $student->course * 2; $semester++) {
            $semesterId = $semester - 1;

            /**
             * We have 4 tables for 4 courses on 2nd page of the template
             *
             * Right now the headers are written out even when no marks are found.
             * The $row incrementation is currently distributed to if() conditions which check if any marks are found per given course.
             *
             * Imp_#1
             * So, with this implementation headers are basically rewritten on the first table and the output begins with the first course that has marks.
             * Ex.: table 1 has headers and is filled with 4th course marks, tables 2,3,4 are empty.
             *
             * Imp_#2
             * Another way to do it is to ignore "marks per given course are present" conditions and simply fill the courses according to their tables
             * Ex.: all tables have headers, table 1,2,4 are empty, table 3 is filled with 3rd course marks.
             */

            // Set up the headers
            if (($semester) % 2) { // this header for each new course (odd semester)
                $studyYear = $student->firstGroup->getStudyYearForCourse(GlobalHelper::getCourseForSemester($semester));
                $courseHeader = mb_strtoupper(GlobalHelper::getOrderLiteral(GlobalHelper::getCourseForSemester($semester), 'uk') . " $studyYear->title навчальний рік");
                $activeSheet->setCellValue("A$row", $courseHeader);
            }
            $semesterHeader = mb_strtoupper(GlobalHelper::getOrderLiteral($semester, 'uk'));
            $activeSheet->setCellValue("B$row", $semesterHeader);

            if ($marks = $student->getMarks([], $semester)) {
                // Output marks if there are any
                foreach ($marks as $mark) {
                    $activeSheet->setCellValue("C$row", $mark->workSubject->title);
                    $activeSheet->setCellValue("D$row", $mark->workSubject->total[$semesterId]);
                    $activeSheet->setCellValue("E$row", number_format($mark->workSubject->total[$semesterId] / 30, 2));
                    $activeSheet->setCellValue("F$row", $mark->valueLiteral);
                    $activeSheet->setCellValue("G$row", $mark->valueScaleLiteral);
                    $activeSheet->setCellValue("H$row", $mark->date);
                    //Insert next
                    $activeSheet->insertNewRowBefore($row + 1);
                    $row++;
                }
                // actually have to remove 2 rows, but PhpSpreadsheet fucks up a doc if you have merged rows nearby, so leave 1 empty
                // TODO: Btw this empty row may be used for Average Grade per semester, seen these in some student card examples
                $activeSheet->removeRow($row);
                // TODO: Implement empty row here(before incrementation)
                $row++;

            } else {
                //If no marks found for odd semester, increase row increment by 2
                //But only if the next semester, which is even, has any marks
                //Required for Imp_#1
                //if (($semester % 2) && $student->getMarks($semester + 1)) {
                $row += 2;
                //}
            }

            //For Imp_#1, move it inside the if() block
            if (!(($semester) % 2)) {
                // At the end of each course, output the line with the transfer edict.
                if ($courseEdict = $student->getCourseEdict(GlobalHelper::getCourseForSemester($semester))) {
                    $courseTransferStr = 'Переведено на ' . GlobalHelper::getOrderLiteral($courseEdict->course, 'uk')
                        . ' курс. Наказ від' . Yii::t('app', '{date} year №{cmd}', ['date' => $courseEdict->date, 'cmd' => $courseEdict->command]);
                }
                $activeSheet->setCellValue("A$row", $courseEdict ? $courseTransferStr : 'ERR: Наказ не знайдено.');
                $row += 7;
            }

        }

        // Page 3
        $spreadsheet->setActiveSheetIndex(2);
        $activeSheet = $spreadsheet->getActiveSheet();

        //Set Dep Head Initials and Second name
        $activeSheet->setCellValue("F32", $student->currentGroup->specialityQualification->speciality->department->head->getNameWithInitials());
        $activeSheet->setCellValue("F48", $student->currentGroup->specialityQualification->speciality->department->head->getNameWithInitials());


        $allMarks = $student->getMarks();

        $total = count($allMarks);
        $satisfiable = count(array_filter($allMarks, function (JournalMark $mark) {
            return MarkHelper::getMarkScale($mark->value, $mark->evaluationSystem->id) === MarkHelper::MARK_SCALE_SATISFIABLE;
        }));
        $good = count(array_filter($allMarks, function (JournalMark $mark) {
            return MarkHelper::getMarkScale($mark->value, $mark->evaluationSystem->id) === MarkHelper::MARK_SCALE_GOOD;
        }));
        $excellent = count(array_filter($allMarks, function (JournalMark $mark) {
            return MarkHelper::getMarkScale($mark->value, $mark->evaluationSystem->id) === MarkHelper::MARK_SCALE_EXCELLENT;
        }));

        //set total count
        $activeSheet->setCellValue("F26", $total);
        //set scale counts
        $activeSheet->setCellValue("J30", $satisfiable);
        $activeSheet->setCellValue("J29", $good);
        $activeSheet->setCellValue("J28", $excellent);

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