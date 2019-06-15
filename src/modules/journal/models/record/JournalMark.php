<?php

namespace app\modules\journal\models\record;

use app\helpers\GlobalHelper;
use app\modules\journal\models\evaluation\Evaluation;
use app\modules\journal\models\evaluation\EvaluationSystem;
use app\modules\journal\models\presence\NotPresenceType;
use app\modules\load\models\Load;
use app\modules\plans\models\WorkSubject;
use app\modules\students\models\Student;
use Yii;
use yii\bootstrap\Html;

/**
 * This is the model class for table "{{%journal_mark}}".
 *
 * @property int $id
 * @property int $record_id
 * @property int $student_id
 * @property int $presence
 * @property int $not_presence_reason_id
 * @property int $evaluation_system_id
 * @property int $evaluation_id
 * @property string $ticket
 * @property string $date
 * @property int $retake_evaluation_id
 * @property string $retake_ticket
 * @property string $retake_date
 * @property string $comment
 *
 * @property int $value
 * @property string $valueLiteral
 * @property string $valueScaleLiteral
 * @property Evaluation $evaluation
 * @property EvaluationSystem $evaluationSystem
 * @property Evaluation $retakeEvaluation
 * @property EvaluationSystem $retakeEvaluationSystem
 * @property JournalRecord $journalRecord
 * @property Student $student
 * @property NotPresenceType $reason
 *
 * @property WorkSubject $workSubject
 */
class JournalMark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_mark}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'student_id', 'evaluation_id'], 'required'],
            [['record_id', 'student_id', 'presence', 'not_presence_reason_id', 'evaluation_system_id', 'evaluation_id', 'retake_evaluation_id'], 'integer'],
            [['date', 'retake_date'], 'safe'],
            [['comment', 'ticket', 'retake_ticket'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'record_id' => Yii::t('app', 'Record ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'presence' => Yii::t('app', 'Presence'),
            'not_presence_reason_id' => Yii::t('app', 'Not Presence Reason ID'),
            'evaluation_system_id' => Yii::t('app', 'Evaluation system'),
            'evaluation_id' => Yii::t('app', 'Evaluation'),
            'date' => Yii::t('app', 'Date'),
            'retake_evaluation_id' => Yii::t('app', 'Retake Evaluation'),
            'retake_date' => Yii::t('app', 'Retake Date'),
            'ticket' => Yii::t('app', 'One ticket'),
            'retake_ticket' => Yii::t('app', 'Retake ticket'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @param $students Student[]
     * @param $list JournalRecord[]
     * @return array
     */
    public static function getMap($students, $list)
    {
        $map = [];
        foreach ($students as $student) {
            foreach ($list as $item) {
                $map[$student->id][$item->id] = self::getMark($student, $item);
            }
        }
        return $map;
    }

    /**
     * @param $student Student
     * @param $record JournalRecord
     */
    public static function getMark($student, $record)
    {
        $mark = self::find()->where(['student_id' => $student->id, 'record_id' => $record->id])->one();
        /**
         * @var $mark self
         */
        if ($mark) {
            return $mark->getLabelLink();
        }
        if (!JournalStudent::checkIsActive($student->id, $record->load_id, $record->date)) {
            return Html::tag('div', '', ['class' => 'not-available', 'style' => 'background-color: gainsboro;']);
        } else {
            return Html::tag('div',
                Html::a(
                    Yii::t('app', 'Add mark'),
                    [
                        'journal-mark/create',
                        'record_id' => $record->id,
                        'student_id' => $student->id,
                    ]
                )
            );
        }
    }

    /**
     * Value shortcut
     * @return string
     */
    public function getValue()
    {
        return $this->evaluation->value;
    }

    public function getEvaluation()
    {
        return $this->hasOne(Evaluation::class, ['id' => 'evaluation_id']);
    }

    public function getEvaluationSystem()
    {
        return $this->hasOne(EvaluationSystem::class, ['id' => 'evaluation_system_id']);
    }

    public function getRetakeEvaluation()
    {
        return $this->hasOne(Evaluation::class, ['id' => 'retake_evaluation_id']);
    }

    public function getRetakeEvaluationSystem()
    {
        return $this->hasOne(EvaluationSystem::class, ['id' => 'evaluation_system_id']);
    }

    public function getLabelLink()
    {
        $label = "";
        if (!$this->presence) {
            $label .= Yii::t('app', "Np");
            if (isset($this->not_presence_reason_id)) {
                $reasonLabel = '(' . $this->reason->label . ')';
                $label .= $reasonLabel;
            }
        }
        if ($this->evaluation_id) {
            if ($label !== "") {
                $label .= "/";
            }
            $label .= $this->evaluation->value;
        }
        if ($this->retake_evaluation_id) {
            if ($label !== "") {
                $label .= "/";
            }
            $label .= $this->retakeEvaluation->value;
        }
        if (empty($label)) {
            $label = Yii::t('app', 'Add mark');
        }
        return Html::tag('div',
            Html::a(
                $label,
                [
                    'journal-mark/view',
                    'id' => $this->id
                ]
            )
        );
    }

    public function getJournalRecord()
    {
        return $this->hasOne(JournalRecord::class, ['id' => 'record_id']);
    }

    public function beforeSave($insert)
    {
        if (boolval($this->evaluation_id) && is_null($this->getOldAttribute('evaluation_id'))) {
            $this->date = date('Y-m-d');
        }
        if (boolval($this->retake_evaluation_id) && is_null($this->getOldAttribute('retake_evaluation_id'))) {
            $this->retake_date = date('Y-m-d');
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    public function getReason()
    {
        return $this->hasOne(NotPresenceType::class, ['id' => 'not_presence_reason_id']);
    }

    public static function getListOfEvaluations($evaluation_system_id)
    {
        $evaluations = Evaluation::getListBySystem($evaluation_system_id);
        $evaluations[null] = Yii::t('app', 'Not defined');
        return $evaluations;
    }

    /**
     * @return \app\modules\plans\models\WorkSubject
     */
    public function getWorkSubject()
    {
        return Load::findOne($this->journalRecord->load_id)->workSubject;
    }

    public function getValueLiteral()
    {
        return GlobalHelper::getNumberLiteral($this->value);
    }

    public function getValueScaleLiteral()
    {
        // TODO: WorkSubjects don't have subj. cycle implemented yet, so EvaluationSystem can only be accessed via StudySubject, it's supposed to be accessible from WorkSubject
        return GlobalHelper::getMarkScaleLiteral($this->value, $this->evaluation_system_id);
    }
}
