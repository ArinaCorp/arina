<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\components\exporters\marks;


use app\components\ExportToExcel;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;
use yii\base\Exception;

abstract class BaseMarkExporter
{
    public const TYPE_SEMESTER = 'semester';
    public const TYPE_CREDIT = 'credit';
    public const TYPE_EXAM = 'exam';

    public static function getTypeTitles()
    {
        return [
            self::TYPE_SEMESTER => Yii::t('app', 'Semester'),
            self::TYPE_CREDIT => Yii::t('app', 'Credit'),
            self::TYPE_EXAM => Yii::t('app', 'Exam'),
        ];
    }

    /**
     * @param JournalRecord $record
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function exportRecord(JournalRecord $record)
    {
        if ($record->typeObj == null) {
            throw new Exception('Record type is empty');
        }
        if (empty($record->typeObj->report_title)) {
            throw new Exception('Report is empty');
        }

        $exporterName = self::getList()[$record->typeObj->report_title];

        ExportToExcel::getDocument($exporterName, $record, 'marks');
    }

    public static function getList()
    {
        return [
            self::TYPE_SEMESTER => 'Semester',
            self::TYPE_CREDIT => 'Credit',
            self::TYPE_EXAM => 'Exam',
        ];
    }

    /**
     * @param $spreadsheet Spreadsheet
     * @param $record JournalRecord
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @return mixed
     */
    public static abstract function getSpreadsheet($spreadsheet, $record);

    /**
     * @param JournalRecord $record
     * @return \app\modules\students\models\Student[]
     */
    public static function getStudents(JournalRecord $record)
    {
        return $record->load->group->getStudentsArray();
    }

    /**
     * @param JournalRecord $record
     * @return JournalMark[]
     */
    public static function getMarks(JournalRecord $record)
    {
        return $record->getJournalMarks()->indexBy('student_id')->all();
    }
}