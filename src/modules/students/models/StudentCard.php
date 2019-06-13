<?php

namespace app\modules\students\models;

use app\components\ExportToExcel;
use app\modules\journal\models\record\JournalMark;
use Yii;
use yii\base\Model;
use yii\web\View;

/**
 * @property integer $id
 * @property Student $student
 * @property JournalMark[] $marks
 */
class StudentCard extends Model
{
    public $studentId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studentId'], 'required'],
            [['studentId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'studentId' => Yii::t('app', 'Student ID'),
        ];
    }

    /**
     * @return Student|null
     */
    public function getStudent()
    {
        return Student::findOne($this->studentId);
    }

    /**
     * @param $semester
     * @return JournalMark[]|Group[]|array|\yii\db\ActiveRecord[]
     */
    public function getMarks()
    {
        $allMarks = JournalMark::find()
            ->joinWith('journalRecord')
            ->joinWith('evaluation')
            ->leftJoin('load', 'load.id = journal_record.load_id')
            ->where(['student_id' => $this->studentId])->all();
//        $this->student->getCourse( TODO: Get the year for student's course
        $map[1][1] = [

        ];
        return [];
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getDocument()
    {
        ExportToExcel::getDocument('StudentCard', $this);
    }

}

