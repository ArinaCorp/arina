<?php

namespace app\modules\journal\models\record;

use app\modules\directories\models\audience\Audience;
use app\modules\employee\models\Employee;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap\Html;
use yii\db\Query;

/**
 * This is the model class for table "{{%journal_record}}".
 *
 * @property int $id
 * @property int $load_id
 * @property int $teacher_id
 * @property int $type
 * @property string $date
 * @property string $description
 * @property string $home_work
 * @property int $number
 * @property int $number_in_day
 * @property int $hours
 * @property int $audience_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property JournalRecordType $typeObj
 * @property Employee $teacher
 * @property Audience $audience
 * @property JournalMark[] $journalMarks
 */
class JournalRecord extends \yii\db\ActiveRecord
{
    const TYPE_ATTESTATION = 0;
    const TYPE_EXAM = 1;

    /**
     * @param $loadId
     * @param int $employeeId
     * @return JournalRecord
     */
    public static function create($loadId, int $employeeId)
    {
        $model = new self();
        $model->load_id = $loadId;
        $model->teacher_id = $employeeId;
        return $model;
    }

    /**
     * @param $load_id
     * @return JournalRecord[]
     */
    public static function getByLoadArray($load_id)
    {
        $records = self::find()
            ->where(['load_id' => $load_id])
            ->orderBy(['date' => SORT_ASC])
            ->all();
        return $records;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['load_id', 'teacher_id', 'type', 'date'], 'required'],
            [['load_id', 'teacher_id', 'type', 'number', 'number_in_day', 'hours', 'audience_id', 'created_at', 'updated_at'], 'integer'],
//            ['number', 'required', 'when' => function ($model) {
//                /**
//                 * @var $model JournalRecord
//                 */
//                return $model->typeObj->n_pp;
//            }],
//            ['number_in_day', 'required', 'when' => function ($model) {
////                /**
////                 * @var $model JournalRecord
////                 */
////                return $model->typeObj->n_in_day;
////            }],
////            ['hours', 'required', 'when' => function ($model) {
////                /**
////                 * @var $model JournalRecord
////                 */
////                return $model->typeObj->hours;
////            }],
////            ['audience_id', 'required', 'when' => function ($model) {
////                /**
////                 * @var $model JournalRecord
////                 */
////                return $model->typeObj->audience;
////            }],
////            [['date'], 'safe'],
////            ['date', 'required', 'when' => function ($model) {
////                /**
////                 * @var $model JournalRecord
////                 */
////                return $model->typeObj->date;
////            }],
////            [['description', 'home_work'], 'string'],
////            ['description', 'required', 'when' => function ($model) {
////                /**
////                 * @var $model JournalRecord
////                 */
////                return $model->typeObj->description;
////            }],
////            ['home_work', 'required', 'when' => function ($model) {
////                /**
////                 * @var $model JournalRecord
////                 */
////                return $model->typeObj->homework;
////            }],
            [['date'], 'validateData']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'load_id' => Yii::t('app', 'Load ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
            'description' => Yii::t('app', 'Description'),
            'home_work' => Yii::t('app', 'Home Work'),
            'number' => Yii::t('app', 'N Pp'),
            'number_in_day' => Yii::t('app', 'Number In Day'),
            'hours' => Yii::t('app', 'Hours'),
            'audience_id' => Yii::t('app', 'Audience ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getType()
    {
        return self::getTypes()[$this->type];
    }

    public static function getTypes()
    {
        return [
            self::TYPE_ATTESTATION => Yii::t('journal', 'Attestation'),
            self::TYPE_EXAM => Yii::t('journal', 'Exam')
        ];
    }

    public function getJournalMarks()
    {
        return $this->hasMany(JournalMark::class, ['record_id' => 'id']);
    }

    public function getLabel()
    {
        $label = '';
        $options = [];
        if ($this->typeObj && $this->typeObj->date && !$this->typeObj->is_report) {
            $label = date('d', strtotime($this->date)) . '<br/>' . date('m', strtotime($this->date));
        } else {
            $label = $this->typeObj ? $this->typeObj->title : '';
            $options = ['class' => 'vertical-label'];
        }
        return Html::tag(
            'div',
            Html::a(
                $label,
                ['journal-record/view', 'id' => $this->id],
                $options)
        );
    }

    public function getTypeObj()
    {
        return $this->hasOne(JournalRecordType::class, ['id' => 'type']);
    }

    public function getTeacher()
    {
        return $this->hasOne(Employee::class, ['id' => 'teacher_id']);
    }

    public function getAudience()
    {
        return $this->hasOne(Audience::class, ['id' => 'audience_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->typeObj && $this->typeObj->n_pp) {
                $this->number = self::getLastNumber($this->load_id) + 1;
            }
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function getLastNumber($load_id)
    {
        $query = new Query();
        $query->from(self::tableName())
            ->select(['number'])
            ->where(['not', ['number' => null]])
            ->andWhere(['load_id' => $load_id])
            ->orderBy(['number' => SORT_DESC]);
        $record = $query->one();
        if ($record) {
            return $record['number'];
        }
        return 0;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_record}}';
    }

    /**
     *
     */
    public function validateData()
    {
        if ($this->isNewRecord) {
            $last_date = self::getLastDate($this->load_id);
            if ($last_date) {
                if (strtotime($this->date) < strtotime($last_date)) $this->addError('date', Yii::t('app', 'The record date should be greater or equal') . $last_date);
            }
        }
    }

    public static function getLastDate($load_id)
    {
        $query = new Query();
        $query->from(self::tableName())
            ->select(['date'])
            ->andWhere(['load_id' => $load_id])
            ->orderBy(['date' => SORT_DESC]);
        $record = $query->one();
        if ($record) {
            return $record['date'];
        }
        return false;
    }
}
