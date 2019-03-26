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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ExportStudentplan
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $plan StudentPlan
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     * @return Spreadsheet
     */
    public static function getSpreadsheet($spreadsheet, $plan)
    {
        $student = $plan->student;
        $group = $plan->student->groups[0];
        $workplan = $plan->workPlan;

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        // Set department head full name
        $activeSheet->setCellValue('F4', $workplan->specialityQualification->speciality->department->head->getFullName());

        // Set study year
        $activeSheet->setCellValue('A8', $workplan->getYearTitle());

        // Set meta info (student, department, speciality)

        // Note, that all static data should be set before the dynamic data.
        // Because after the dynamic row insertion you'd have to calculate the offset for the rows that shifted after a table.

        $activeSheet->setCellValue('A9', 'Студент: ' . $student->fullName);
        $activeSheet->setCellValue('A10', 'Відділення: ' . $workplan->specialityQualification->speciality->department->title);
        $activeSheet->setCellValue('A11', 'Спеціальність: ' . $workplan->specialityQualification->speciality->title);

        // Set date of creation
        $activeSheet->setCellValue('A24', Yii::$app->formatter->asDate($plan->created,'dd.mm.y'));

        // Start listing out the mandatory subjects
        // Begin with headers, template expects them to come on row 15 and have 8 columns ( A - I included )
        // Headers could be included in template, but if we ever need to put localization here such approach would be nice.
        $activeSheet->setCellValue('A15', '№ п/п');
        $activeSheet->setCellValue('B15', 'Назва навчальної дисципліни');
        $activeSheet->setCellValue('C15', 'Заг. обсяг год.');
        $activeSheet->setCellValue('D15', 'Обсяг год. лек.');
        $activeSheet->setCellValue('E15', 'Обсяг год. лаб.');
        $activeSheet->setCellValue('F15', 'Обсяг год. практ.');
        $activeSheet->setCellValue('G15', 'Самостійне опрац.');
        $activeSheet->setCellValue('H15', 'Курс. проекти');
        $activeSheet->setCellValue('I15', 'Цикл. ком.');

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
        $mandatoryRow = 16;
        $counter = 1;
        // Actual subject data
        foreach ($plan->getWorkSubjects() as $subject) {
            $activeSheet->setCellValue("A$mandatoryRow", $counter);
            $activeSheet->setCellValue("B$mandatoryRow", $subject->subject->title);
            $activeSheet->setCellValue("C$mandatoryRow", $subject->total[$fall] + $subject->total[$spring]);
            $activeSheet->setCellValue("D$mandatoryRow", $subject->lectures[$fall] + $subject->lectures[$spring]);
            $activeSheet->setCellValue("E$mandatoryRow", $subject->lab_works[$fall] + $subject->lab_works[$spring]);
            $activeSheet->setCellValue("F$mandatoryRow", $subject->practices[$fall] + $subject->practices[$spring]);
            $activeSheet->setCellValue("G$mandatoryRow", $subject->getSelfWork($fall) + $subject->getSelfWork($spring));
            $activeSheet->setCellValue("H$mandatoryRow", $subject->project_hours);
            $activeSheet->setCellValue("I$mandatoryRow", $subject->cyclicCommission->short_title);
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
            $activeSheet->setCellValue("C$selectableRow", 'Заг. обсяг год.');
            $activeSheet->setCellValue("D$selectableRow", 'Обсяг год. лек.');
            $activeSheet->setCellValue("E$selectableRow", 'Обсяг год. лаб.');
            $activeSheet->setCellValue("F$selectableRow", 'Обсяг год. практ.');
            $activeSheet->setCellValue("G$selectableRow", 'Самостійне опрац.');
            $activeSheet->setCellValue("H$selectableRow", 'Курс. проекти');
            $activeSheet->setCellValue("I$selectableRow", 'Цикл. ком.');

            $selectableRow++;
            $counter = 1;

            // Same story as for the mandatory subjects
            foreach ($plan->getWorkSubjectsBlock() as $subject) {
                $activeSheet->setCellValue("A$selectableRow", $counter);
                $activeSheet->setCellValue("B$selectableRow", $subject->subject->title);
                $activeSheet->setCellValue("C$selectableRow", $subject->total[$fall] + $subject->total[$spring]);
                $activeSheet->setCellValue("D$selectableRow", $subject->lectures[$fall] + $subject->lectures[$spring]);
                $activeSheet->setCellValue("E$selectableRow", $subject->lab_works[$fall] + $subject->lab_works[$spring]);
                $activeSheet->setCellValue("F$selectableRow", $subject->practices[$fall] + $subject->practices[$spring]);
                $activeSheet->setCellValue("G$selectableRow", $subject->getSelfWork($fall) + $subject->getSelfWork($spring));
                $activeSheet->setCellValue("H$selectableRow", $subject->project_hours);
                $activeSheet->setCellValue("I$selectableRow", $subject->cyclicCommission->short_title);

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