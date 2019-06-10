<?php

namespace app\modules\students\models;

use app\components\ExportToExcel;
use app\modules\directories\models\StudyYear;
use app\modules\journal\models\record\JournalMark;
use Yii;
use yii\base\Model;
use yii\web\View;

/**
 * @property integer $id
 * @property Student $student
 * @property StudyYear $studyYear
 * @property JournalMark[] $marks
 */
class StudentCard extends Model
{
    public $studentId, $studyYearId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studentId', 'studyYearId'], 'required'],
            [['studentId', 'studyYearId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'studentId' => Yii::t('app', 'Student ID'),
            'studyYearId' => Yii::t('app', 'Study year'),
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
     * @return StudyYear|null
     */
    public function getStudyYear()
    {
        return StudyYear::findOne($this->studyYearId);
    }

    /**
     * @param $semester
     * @return JournalMark[]|Group[]|array|\yii\db\ActiveRecord[]
     */
    public function getMarks($semester = null)
    {
        //TODO: temporary bullshit for demonstrative purposes
        if ($semester) {
            if ($semester < 5) {
                $type = $semester + 3;
                $where = [
                    'student_id' => $this->studentId,
                    'study_year_id' => $this->studyYearId,
                    'journal_record.type' => $type,
                ];
            } else {
                return null;
            }
        } else $where = [
            'student_id' => $this->studentId,
            'study_year_id' => $this->studyYearId,
        ];
        return JournalMark::find()
            ->joinWith('journalRecord')
            ->joinWith('evaluation')
            ->leftJoin('load', 'load.id = journal_record.load_id')
            ->where($where)->all();
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

