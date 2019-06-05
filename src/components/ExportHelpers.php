<?php


namespace app\components;


use codemix\excelexport\ActiveExcelSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

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
        foreach ($_array as $array){
            if(is_array($array)){
            $count+=count($array);
            }
        }
        return $count;
    }

    public static function getMarks($subjects =[],$students=[]){
        $marks = [];
        foreach ($subjects as $subject){
            foreach ($students as $student){
                array_push($marks,[
                    'value'=>rand(2,5),
                    'subject_id'=>$subject->id,
                    'student_id'=>$student->id
                ]);
            }
        }
        return $marks;
    }

    public static function getPropusk($students=[])
    {
        $propusks = [];
        foreach ($students as $student){
            $hours = rand(0,100);
            array_push($propusks,[
                "student_id"=>$student->id,
                "hours"=>$hours,
                "with_reason"=>rand(0,$hours)
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
    public static function MarkColorized($spreadSheet,$mark,$cords)
    {
        switch ($mark){
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

}