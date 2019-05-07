<?php
/**
 * Created by IntelliJ IDEA.
 * User: vladi
 * Date: 27.03.2019
 * Time: 23:30
 */

namespace app\components\exporters;


use app\modules\directories\models\department\Department;
use app\modules\directories\models\speciality\Speciality;
use app\modules\students\models\Exemption;
use app\modules\students\models\Group;
use app\modules\students\models\StudentSearch;
use PhpOffice\PhpSpreadsheet\Style;
use app\modules\students\models\Student;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;

class ExportFilteredstudents
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $model StudentSearch
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet, $model)
    {
//        FORMATS
//        var_dump($params);

        $textCenter = array(
            'font' => [
                'size' => 12,
                'name' => 'Times'
            ],
            'alignment' => array(
                'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
            )
        );
        $textLeft = array(
            'alignment' => array(
                'horizontal' => Style\Alignment::HORIZONTAL_LEFT,
            )
        );
        $textRight = array(
            'alignment' => array(
                'horizontal' => Style\Alignment::HORIZONTAL_RIGHT,
            )
        );
        $allBorderMedium = array(
            'font' => [
                'bold' => true
            ],
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => Style\Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $allBorderThin = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => Style\Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $borderBottomMedium = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $borderBottomThin = array(
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => Style\Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $titleStyles = array(
            'font' => [
                'size' => 12,
                'bold'=>true,
                'name' => 'Times'
            ],
            'alignment' => array(
                'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
            )
        );
        $simpleText = [
            'font' => [
                'size' => 12,
                'name' => 'Times'
            ]
        ];
        $tinyText = array(
            'font' => [
                'size' => 11,
                'name' => 'Times'
            ],
            'alignment' => array(
                'vertical' => Style\Alignment::VERTICAL_TOP,
            )
        );

//        SETUP
        /** @var $query Student[] */
        $query = $model["students"]->query->all();
//      GET parameter
        $params = $model["parameters"];
        $activeSheet = $spreadsheet->getActiveSheet();

        if(!is_null($model['student_id'])){
        $query = [Student::findOne(['id'=>$model['student_id']])];
        }
//        var_dump($model["parameters"]);die;
        $foos = $query;
        $begin = "B";
        $studentL = "C";
        $studentLast = "N";
        $center = "I";
        $lastCell = $studentLast;

        $activeSheet->insertNewRowBefore(2);
        $activeSheet->insertNewRowBefore(2);
        $activeSheet->insertNewRowBefore(2);
//        STYLES

        //HEADERS
        $sList = 2;
        $offset = 3;
        $title = Yii::t('app', 'Students list');
//        exemption condition
        $hasExemptions = false;
        if (!empty($params["exemptions"])) {
            $lastCell = "O";
            $center = "J";
            $hasExemptions = true;
            if (count($params["exemptions"]) > 1) {
                $title .= ' пільговиків';
            } else if (count($params["exemptions"]) == 1) {
                $exemption = Exemption::findOne(['id' => $params["exemptions"]])["title"];
                $title .= ' пільги "' . $exemption . '"';
            }
        }

//      payment condition
        if (!empty($params["payment"])) {
            $row = $offset;
            $add = $params["state_payment"] === "1" ? " державної форми навчання" : " контрактної форми навчання";
            $activeSheet->getStyle($center . $row . ":" . $lastCell . $row)->applyFromArray($titleStyles);
            $title .= $add;
        }
//      Student header
        $row = $offset;
        $activeSheet->setCellValue($center . $sList, $title);
        $activeSheet->getStyle($center . $sList . ":" . $lastCell . $sList)->applyFromArray($titleStyles);
        $activeSheet->insertNewRowBefore($sList + 1);
//      department condition
        $hasDepartment = false;
        if ($params["department"] != "") {
            $hasDepartment = true;
            $department = "Відділення " . "\"" . Department::findOne(["id" => $params["department"]])["title"] . "\"";
            $row = $offset;
            $activeSheet->setCellValue($center . $row, $department);
            $activeSheet->getStyle($center . $row . ":" . $lastCell . $row)->applyFromArray($titleStyles);
            $activeSheet->insertNewRowBefore($row + 1);
            $offset++;
        }
//      qualification condition
        $hasSpeciality = false;
        if ($params["speciality"] != "") {
            $hasSpeciality = true;
            $qualification = "Спеціальності " . "\"" . Speciality::findOne(["id" => $params["speciality"]])["title"] . "\"";
            $row = $offset;
            $activeSheet->insertNewRowBefore($row + 1);
            $activeSheet->setCellValue($center . $row, $qualification);
            $activeSheet->getStyle($center . $row . ":" . $lastCell . $row)->applyFromArray($titleStyles);
            $offset++;
        }
//      group condition
        $hasGroup = false;
        if ($params["group"] != "") {
            $hasGroup = true;
            $group = "Групи " . Group::findOne(["id" => $params["group"]])["title"];
            $row = $offset;
            $activeSheet->insertNewRowBefore($row + 1);
            $activeSheet->insertNewRowBefore($row + 1);
            $activeSheet->setCellValue($center . $row, $group);
            $offset++;
        }

//      table headers
        $header = $sList + $offset;

        $headerParams = [
            "begin" => $begin,
            "studentL" => $studentL,
            "lastStudentLetter" => $studentLast,
            "hasExemptions" => $hasExemptions,
            "lastLetter" => $lastCell,
            "borders" => $allBorderMedium,
            "simpleText" => $simpleText,
            "textCenter" => $textCenter
        ];
        $tableParams = [
            "begin" => $begin,
            "studentL" => $studentL,
            'hasExemptions' => $hasExemptions,
            'lastLetter' => $lastCell,
            "lastStudentLetter" => $studentLast,
            "borders" => $allBorderThin,
            "textCenter" => $textCenter,
            "simpleText" => $simpleText
        ];

        //TABLE
        $row = $header;
        $id = 1;
        $studentCounter = 0;
        if (!$hasGroup) {
            $row--;
            $groups = Group::find()->all();
            $studentIds = [];
            /** @var $query Student [] */
            foreach ($query as $q) {
                array_push($studentIds, $q->id);
            }
            foreach ($groups as $group) {
                /**@var $group Group */
                $current_students = $group->getStudentsArray();
                $first = true;
                $id = 1;
                foreach ($current_students as $student) {
                    /** @var $student Student */

                    if (in_array($student->id, $studentIds)) {
                        if ($first) {
                            $activeSheet->insertNewRowBefore($row + 1);
                            $activeSheet->insertNewRowBefore($row + 1);
                            $activeSheet->insertNewRowBefore($row + 1);
                            $activeSheet->insertNewRowBefore($row + 1);
                            $row++;
                            $activeSheet->setCellValue("C$row", Yii::t('app', 'Group') . " " . $group->title)
                                ->getStyle("C$row")->applyFromArray($titleStyles);
                            $row += 2;
                            self::buildHeader($activeSheet, $row, $headerParams);
                            $row++;

                            $first = false;
                        }
                        self::buildTable($activeSheet, $student, $row, $id, $tableParams);
                        $id++;
                        $row++;
                        $activeSheet->insertNewRowBefore($row + 1);
                        $studentCounter++;
                    }
                }
            }
        } else {
            $first = true;
            /** @var $student Student */
            foreach ($foos as $student) {
                if ($first) {
                    self::buildHeader($activeSheet, $row, $headerParams);
                    $row++;
                    $activeSheet->insertNewRowBefore($row + 1);
                    $first = false;
                }
                self::buildTable($activeSheet, $student, $row, $id, $tableParams);
                $id++;
                $row++;
                $activeSheet->insertNewRowBefore($row + 1);
                $studentCounter++;
            }
        }

        $activeSheet->getColumnDimension($begin)->setWidth(10);

//      Footer
        $footer = $begin . $row . ":" . $lastCell . $row;
        $activeSheet->mergeCells($footer);
        $activeSheet
            ->getStyle($footer)->applyFromArray($borderBottomThin);
        $row++;
//        var_dump($footer);die;
        $activeSheet->setCellValue($studentL . $row, date('d.m.Y') . "   " . date('H:i'));
        $activeSheet->getStyle($studentL . $row)->applyFromArray($textLeft);
        if ($studentLast == $lastCell) {
            $activeSheet->getColumnDimension($studentLast)->setAutoSize(false);
        } else {
            $activeSheet->getColumnDimension($lastCell)->setAutoSize(true);
        }
        if(is_array($query)){
        $activeSheet->setCellValue($lastCell . $row, "Всього студентів " . count($query));
        }
        $activeSheet->getStyle($lastCell . $row)->applyFromArray($textRight);

        return $spreadsheet;
    }

    private static function buildTable($spreadsheet, $student, $row, $id, array $params)
    {
        $fullName = $student['last_name'] . " " . $student['first_name'] . " " . $student['middle_name'];
        $exemption = Exemption::findOne(['id' => $student["exemptions"]])["title"];
        $spreadsheet->setCellValue("${params['begin']}$row", $id)
            ->setCellValue("${params['studentL']}$row", $fullName)
            ->getStyle("${params['begin']}$row")->applyFromArray($params["textCenter"]);
        $spreadsheet->mergeCells("${params['studentL']}$row:${params["lastStudentLetter"]}$row");
        $spreadsheet->getStyle("${params['begin']}$row:${params["lastLetter"]}$row")->applyFromArray($params["borders"]);
        $params["hasExemptions"] ? $spreadsheet->setCellValue("${params["lastLetter"]}$row", $exemption) : "";
        $spreadsheet->getStyle("${params["lastLetter"]}$row")->applyFromArray($params["textCenter"]);
        $spreadsheet->getStyle("${params['begin']}$row:${params["lastLetter"]}$row")->applyFromArray($params["simpleText"]);

    }

    /**
     * @param $spreadsheet
     * @param $row
     * @param $params String[]
     */
    private static function buildHeader($spreadsheet, $row, $params)
    {
        $spreadsheet->setCellValue("${params['begin']}$row", Yii::t('app', '№'))
            ->setCellValue("${params["studentL"]}$row", Yii::t('app', 'Student'));
        $spreadsheet->mergeCells("${params['studentL']}$row:${params['lastStudentLetter']}$row");
        $spreadsheet->getStyle("${params['begin']}$row:${params['lastLetter']}$row")->applyFromArray($params['borders']);
        $spreadsheet->getStyle("${params['begin']}$row:${params['lastLetter']}$row")->applyFromArray($params['textCenter']);
        $params["hasExemptions"] ? $spreadsheet->setCellValue("${params['lastLetter']}$row", Yii::t('app', 'Exemptions')) : "";

    }

}
