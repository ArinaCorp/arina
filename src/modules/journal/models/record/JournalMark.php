<?php

namespace app\modules\journal\models\record;

use app\modules\journal\models\evaluation\Evaluation;
use app\modules\journal\models\evaluation\EvaluationSystem;
use app\modules\students\models\Student;
use Yii;
use yii\behaviors\TimestampBehavior;
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
 * @property string $date
 * @property int $retake_evaluation_id
 * @property string $retake_date
 * @property string $comment
 *
 * @property Evaluation $evaluation
 * @property EvaluationSystem $evaluationSystem
 * @property Evaluation $retakeEvaluation
 * @property EvaluationSystem $retakeEvaluationSystem
 * @property JournalRecord $journalRecord
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

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'student_id'], 'required'],
            [['record_id', 'student_id', 'presence', 'not_presence_reason_id', 'evaluation_system_id', 'evaluation_id', 'retake_evaluation_id'], 'integer'],
            [['date', 'retake_date'], 'safe'],
            [['comment'], 'string'],
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
            'evaluation_system_id' => Yii::t('app', 'Evaluation System ID'),
            'evaluation_id' => Yii::t('app', 'Evaluation ID'),
            'date' => Yii::t('app', 'Date'),
            'retake_evaluation_id' => Yii::t('app', 'Retake Evaluation ID'),
            'retake_date' => Yii::t('app', 'Retake Date'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @param $students Student[]
     * @param $list JournalRecord[]
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
            return Html::tag('div', '', ['class' => 'mark not-available', 'style' => 'background-color: gainsboro;']);
        } else {

            return Html::tag('div',
                Html::a(
                    Yii::t('app', 'Add mark'),
                    [
                        'journal-mark/create',
                        'record_id' => $record->id,
                        'student_id' => $student->id,
                    ]
                ),
                [
                    'class' => 'mark'
                ]
            );
        }
    }

    public function getEvaluation()
    {
        return $this->hasOne(Evaluation::className(), ['id' => 'evaluation_id']);
    }

    public function getEvaluationSystem()
    {
        return $this->hasOne(EvaluationSystem::className(), ['id' => 'evaluation_system_id']);
    }

    public function getRetakeEvaluation()
    {
        return $this->hasOne(Evaluation::className(), ['id' => 'evaluation_id']);
    }

    public function getRetakeEvaluationSystem()
    {
        return $this->hasOne(EvaluationSystem::className(), ['id' => 'evaluation_system_id']);
    }

    public function getLabelLink()
    {
        $label = "";
        if (!$this->presence) {
            $label .= Yii::t('app', "Np");
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
        return Html::tag('div',
            Html::a(
                $label,
                [
                    'journal-mark/view',
                    'record_id' => $this->record_id
                ]
            ),
            [
                'class' => 'mark'
            ]
        );
    }

    public function getJournalRecord(){
        $this->hasOne(JournalRecord::className(),['id'=>'record_id']);
    }
}
