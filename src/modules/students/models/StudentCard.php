<?php

namespace app\modules\students\models;

use app\components\ExportToExcel;
use app\modules\journal\models\record\JournalMark;
use Yii;
use yii\base\Model;

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
     * @param integer|null $semester
     * @return JournalMark[]|\app\modules\plans\models\WorkPlan[]|Group[]|Student[]|array|\yii\db\ActiveRecord[]
     */
    public function getMarks($semester = null)
    {
        return $this->student->getMarks($semester);
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

