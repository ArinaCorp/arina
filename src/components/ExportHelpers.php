<?php


namespace app\components;


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

}