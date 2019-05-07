<?php


namespace app\components\exporters;

use app\components\ExportHelpers;
use app\modules\directories\models\subject\Subject;
use app\modules\plans\models\StudyPlan;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use DateTime;
use PhpOffice\PhpSpreadsheet;
use Yii;

class ExportAttestation
{
    /**
     *
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $data
     * @return PhpSpreadsheet\Spreadsheet
     * @throws PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet,$data)
    {
        $spreadsheet->setActiveSheetIndex(0);
        $id = $data["data"]["group_id"];
        if(!is_null($id)) {
//        var_dump($id);die;
            $group = Group::findOne($id);
            $students = $group->getStudentsArray();
            $studyPlan = StudyPlan::findOne(["speciality_qualification_id" => $group->specialityQualification]);
            $semester =$data["data"]["semester"];
            $romanSemester = ExportHelpers::ConvertToRoman($data["data"]["semester"]);
            $period = 1;
            $subjects = [];
            foreach ($studyPlan->studySubjects as $item) {
                if ($item->weeks[$semester - 1] != 0) {
                    array_push($subjects, $item->subject->title);
                }
            }

            $date = self::calculateDate($studyPlan, $semester, $period, $data["data"]["date"]);
            $firstYear = Date('Y', strtotime($data["data"]["date"]));
            $year = [$firstYear, $firstYear + 1];

            $spreadsheet->getActiveSheet()->setCellValue('A300', $romanSemester);
            $spreadsheet->getActiveSheet()->setCellValue('A301', $date[0]);
            $spreadsheet->getActiveSheet()->setCellValue('B301', $date[1]);
            $spreadsheet->getActiveSheet()->setCellValue('A302', Group::findOne($id)->title);
            $spreadsheet->getActiveSheet()->setCellValue('A303', $year[0]);
            $spreadsheet->getActiveSheet()->setCellValue('B303', $year[1]);
            if (!is_null($students)) {
                $startRow = 8;
                $current = $startRow;
                $i = 1;
                foreach ($students as $student) {
//                $spreadsheet->getActiveSheet()->mergeCells("C" . $current . ":G" . $current);
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($current + 2);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $current, $i);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $current, $student->getFullName());
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $current, $student->getPaymentTypeLabel());
                    $i++;
                    $current++;
                }
                $spreadsheet->getActiveSheet()->removeRow($current + 1);
                $spreadsheet->getActiveSheet()->removeRow($current);
                $spreadsheet->getActiveSheet()->removeRow($current);
                $colCurrent = "D7";
                if (!is_null($subjects)) {
                    foreach ($subjects as $subject) {
                        $spreadsheet->getActiveSheet()->setCellValue("D7", $subject);
                        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(4);
                        $spreadsheet->getActiveSheet()->insertNewColumnBefore("D", 1);
//                $spreadsheet->getActiveSheet()->setCellValue('A' . $current, $i);
//                $spreadsheet->getActiveSheet()->setCellValue('B' . $current, $student->getFullName());
//                $spreadsheet->getActiveSheet()->setCellValue('I' . $current, $student->getPaymentTypeLabel());
//                $i++;
//                $current++;
                    }
                    $spreadsheet->getActiveSheet()->removeColumn("C");
                    $spreadsheet->getActiveSheet()->removeColumn("C");
                    $spreadsheet->getActiveSheet()->setCellValue("C5", Yii::t("app", "Subject title"));
                }

                $spreadsheet->getActiveSheet()->setCellValue('I' . ($current + 3), "Якість_________%");
                $spreadsheet->getActiveSheet()->setCellValue('I' . ($current + 4), "Успішність______%");
                $spreadsheet->getActiveSheet()->setCellValue('G' . ($current + 8), "Куратор________/" . $group->getCuratorShortNameInitialFirst() . "/");
                $spreadsheet->getActiveSheet()->setCellValue('G' . ($current + 9), "Староста________/" . $group->getGroupLeaderShortNameInitialFirst() . "/");
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($current + 8), "Дата: " . date('d.m.Y') . "  Час: " . date('H:i:s'));
            }
        }
        return $spreadsheet;
    }

    private static function calculateDate($studyPlan,$semester,$period,$date){
        $daysFrom = 0;
        $daysTo = 0;
        $i = 1;
        foreach ($studyPlan->semesters as $week){

            if($i<$semester){
                $daysFrom +=$week*7;
            }
            if($i<$semester+$period){
                $daysTo +=$week*7;
            }
            $i++;
        }
        if($semester==1){
            $daysFrom = 0;
        }
        if($semester==8){
            $daysTo = 0;
        }
        $beginDate = Date("d.m",strtotime( $date."+".$daysFrom." days"));
        $endDate = Date("d.m",strtotime( $date."+".$daysTo." days"));
    return [$beginDate,$endDate];
    }

}