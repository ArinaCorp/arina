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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ExportStudentplan
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $plan StudentPlan
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function getSpreadsheet($spreadsheet, $plan)
    {
        // Default semester is 1 (fall), optional is 2 (spring)
        $semester = $plan->semester === 2 ? 'spring' : 'fall';
        $student = $plan->student;
        $group = $plan->student->groups[0];
        $workplan = $plan->workPlan;

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        // Set department head full name
        $activeSheet->setCellValue('F4', $workplan->specialityQualification->speciality->department->title);
        $activeSheet->setCellValue('F5', $workplan->specialityQualification->speciality->department->head->getFullName());

        // Set study year
        $activeSheet->setCellValue('A9', 'на ' . $workplan->getYearTitle() . 'н.р.');
        // Semester
        $activeSheet->setCellValue('A10', $plan->semester . ' семестр');

        // Set meta info (student, department, speciality)

        // Note, that all static data should be set before the dynamic data.
        // Because after the dynamic row insertion you'd have to calculate the offset for the rows that shifted after a table.

        $activeSheet->setCellValue('A11', 'Студент: ' . $student->fullName . ' (' . $group->title . ')');
        $activeSheet->setCellValue('A12', 'Відділення: ' . $workplan->specialityQualification->speciality->department->title);
        $activeSheet->setCellValue('A13', 'Спеціальність: ' . $workplan->specialityQualification->speciality->title);
        $activeSheet->setCellValue('A14', 'Освітній рівень: ' . $workplan->specialityQualification->qualification->title);

        // Set date of creation
        $activeSheet->setCellValue('A24', Yii::$app->formatter->asDate($plan->created,'dd.mm.y'));

        // Start listing out the mandatory subjects
        // Begin with headers, template expects them to come on row 17 and have 11 columns ( A - K included )
        // Headers could be included in template, but if we ever need to put localization here such approach would be nice.
        $headerRow =  17;
        $activeSheet->setCellValue("A$headerRow", '№ п/п');
        $activeSheet->setCellValue("B$headerRow", 'Назва навчальної дисципліни');
        $activeSheet->setCellValue("C$headerRow", 'Кільк. кред. ЄКТС');
        $activeSheet->setCellValue("D$headerRow", 'Заг. обсяг год.');
        $activeSheet->setCellValue("E$headerRow", 'Обсяг год. лек.');
        $activeSheet->setCellValue("F$headerRow", 'Обсяг год. лаб.');
        $activeSheet->setCellValue("G$headerRow", 'Обсяг год. практ.');
        $activeSheet->setCellValue("H$headerRow", 'Обсяг год. сам. роб..');
        $activeSheet->setCellValue("I$headerRow", 'Курсов. КР(КП)');
        $activeSheet->setCellValue("J$headerRow", 'Форма підс. контр.');
        $activeSheet->setCellValue("K$headerRow", 'Цикл. ком.');

        // Now continue with the list of subjects themselves
        // Here we decide which parts of the arrays to take data from, depending on a course, we select proper semesters
        // 2 semesters per course(year)
        switch ($plan->course) {
            case 1:
                $fall = 0;
                $spring = 1;
                break;
            case 2:
                $fall = 2;
                $spring = 3;
                break;
            case 3:
                // TODO: remove subtraction
                $fall = 4 - 1;
                $spring = 5 - 2;
                break;
            case 4:
                $fall = 6 - 3;
                $spring = 7 - 4;
                break;
            default:
                $fall = 0;
                $spring = 1;
        }
        // The row iterator begins with 16, the 17 is the row before which we insert others, to copy it's style
        // TODO: $mandatoryRow and $selectableRow are ambiguous names for variables
        $mandatoryRow = 18;
        $counter = 1;
        // Actual subject data
        foreach ($plan->getWorkSubjects() as $subject) {
            $activeSheet->setCellValue("A$mandatoryRow", $counter);
            $activeSheet->setCellValue("B$mandatoryRow", $subject->subject->title);
            $activeSheet->setCellValue("C$mandatoryRow", ($subject->total[${$semester}])/30);
            $activeSheet->setCellValue("D$mandatoryRow", $subject->total[${$semester}]);
            $activeSheet->setCellValue("E$mandatoryRow", $subject->lectures[${$semester}]);
            $activeSheet->setCellValue("F$mandatoryRow", $subject->lab_works[${$semester}]);
            $activeSheet->setCellValue("G$mandatoryRow", $subject->practices[${$semester}]);
            $activeSheet->setCellValue("H$mandatoryRow", $subject->getSelfWork(${$semester}));
            $activeSheet->setCellValue("I$mandatoryRow", $subject->project_hours ? $subject->project_hours : '0');
            $activeSheet->setCellValue("J$mandatoryRow", 'WIP');
            $activeSheet->setCellValue("K$mandatoryRow", $subject->cyclicCommission->short_title ? $subject->cyclicCommission->short_title : '');
            //Here is our row 17, well for the first iteration
            $activeSheet->insertNewRowBefore($mandatoryRow + 1);
            $mandatoryRow++;
            $counter++;
        }

        // Clean up the template rows, another left-over row is left after the 'foreach' cycle
        $activeSheet->removeRow($mandatoryRow);
        $activeSheet->removeRow($mandatoryRow);


        if ($plan->subject_block_id) {
            // If we have a selectable block, set up the row iterators and so on. The offset is +2 after mandatoryRow
            $selectableRow = $mandatoryRow + 2;
            // Set up headers
            $activeSheet->setCellValue("A$selectableRow", '№ п/п');
            $activeSheet->setCellValue("B$selectableRow", 'Назва навчальної дисципліни');
            $activeSheet->setCellValue("C$selectableRow", 'Кільк. кред. ЄКТС');
            $activeSheet->setCellValue("D$selectableRow", 'Заг. обсяг год.');
            $activeSheet->setCellValue("E$selectableRow", 'Обсяг год. лек.');
            $activeSheet->setCellValue("F$selectableRow", 'Обсяг год. лаб.');
            $activeSheet->setCellValue("G$selectableRow", 'Обсяг год. практ.');
            $activeSheet->setCellValue("H$selectableRow", 'Обсяг год. сам. роб..');
            $activeSheet->setCellValue("I$selectableRow", 'Курсов. КР(КП)');
            $activeSheet->setCellValue("J$selectableRow", 'Форма підс. контр.');
            $activeSheet->setCellValue("K$selectableRow", 'Цикл. ком.');

            $selectableRow++;
            $counter = 1;

            // Same story as for the mandatory subjects
            foreach ($plan->getWorkSubjectsBlock() as $subject) {
                $activeSheet->setCellValue("A$selectableRow", $counter);
                $activeSheet->setCellValue("B$selectableRow", $subject->subject->title);
                $activeSheet->setCellValue("C$selectableRow", ($subject->total[${$semester}])/30);
                $activeSheet->setCellValue("D$selectableRow", $subject->total[${$semester}]);
                $activeSheet->setCellValue("E$selectableRow", $subject->lectures[${$semester}]);
                $activeSheet->setCellValue("F$selectableRow", $subject->lab_works[${$semester}]);
                $activeSheet->setCellValue("G$selectableRow", $subject->practices[${$semester}]);
                $activeSheet->setCellValue("H$selectableRow", $subject->getSelfWork(${$semester}));
                $activeSheet->setCellValue("I$selectableRow", $subject->project_hours ? $subject->project_hours : '0');
                $activeSheet->setCellValue("J$selectableRow", 'WIP');
                $activeSheet->setCellValue("K$selectableRow", $subject->cyclicCommission->short_title);

                $activeSheet->insertNewRowBefore($selectableRow + 1);
                $selectableRow++;
                $counter++;
            }

            // Clean up
            $activeSheet->removeRow($selectableRow);
            $activeSheet->removeRow($selectableRow);

        } else {
            // If we have no selectable block, remove the template for it.
            for ($i = 0; $i < 5; $i++)
                $activeSheet->removeRow($mandatoryRow);
        }

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