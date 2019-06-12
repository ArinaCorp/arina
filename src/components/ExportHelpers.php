<?php


namespace app\components;


use codemix\excelexport\ActiveExcelSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Yii;

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
        foreach ($subjects as $subject) {
            foreach ($students as $student) {
                array_push($marks, [
                    'value' => $range[array_rand($range)],
                    'subject_id' => $subject->id,
                    'student_id' => $student->id
                ]);
            }
        }
        return $marks;
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

}