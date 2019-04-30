<?php

namespace app\modules\journal\models\record;

use app\modules\load\models\Load;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%journal_student}}".
 *
 * @property int $id
 * @property int $load_id
 * @property int $student_id
 * @property int $type
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Student $student
 */
class JournalStudent extends \yii\db\ActiveRecord
{
    CONST TYPE_ACCEPTED = 1;
    CONST TYPE_DE_ACCEPTED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_student}}';
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
            [['load_id', 'student_id', 'type', 'date'], 'required'],
            [['load_id', 'student_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['date'], 'checkDateAndType'],
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
            'student_id' => Yii::t('app', 'Student ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function checkDateAndType()
    {
        $recordByStudent = self::find()
            ->where(['load_id' => $this->load_id, 'student_id' => $this->student_id])
            ->orderBy(['date' => SORT_ASC])
            ->all();
        if (!empty($recordByStudent)) {
            if (end($recordByStudent)) {
                $this->addError('date', Yii::t('app', 'The set date should be greater than the pre-set date'));
            }
        }
    }

    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    public static function getListTypes()
    {
        return [
            self::TYPE_DE_ACCEPTED => Yii::t('app', 'De accepted from list'),
            self::TYPE_ACCEPTED => Yii::t('app', 'Accepted to list'),
        ];
    }

    public static function getRecordsByLoad($load_id, $type = null, $dateTo = null, $dateFrom = null)
    {
        $query = self::find();
        $query->andWhere(['load_id' => $load_id]);
        if (!is_null($type)) {
            $query->andWhere(['type' => $type]);
        }
        if (!is_null($dateTo)) {
            $query->andFilterWhere(['<=', 'date', $dateTo]);
        }
        if (!is_null($dateFrom)) {
            $query->andFilterWhere(['>=', 'date', $dateFrom]);
        }
        $query->orderBy(['date' => SORT_ASC]);
        return $query->all();
    }

    /**
     * @param $load_id
     * @param null $dateTo
     * @param null $dateFrom
     * @return array
     */
    public static function getAllStudentsIdsByLoad($load_id, $dateTo = null, $dateFrom = null)
    {
        $query = new Query();
        $query
            ->from(self::tableName())
            ->select(['student_id'])
            ->where(['load_id' => $load_id]);
        if (!is_null($dateFrom)) {
            $query->andFilterWhere(['<=', 'data', $dateTo]);
        };
        if (!is_null($dateTo)) {
            $query->andFilterWhere(['>=', 'data', $dateFrom]);
        };
        $query->
        groupBy(['student_id']);
        return ArrayHelper::getColumn($query->all(), 'student_id');
    }

    /**
     * @param $load_id
     * @param null $dateTo
     * @param null $dateFrom
     * @return Student[]
     */
    public static function getAllStudentByLoad($load_id, $dateTo = null, $dateFrom = null)
    {
        return Student::find()
            ->where([
                'id' => self::getAllStudentsIdsByLoad($load_id, $dateTo, $dateFrom)
            ])
            ->all();
    }

    public static function getAvailableStudentIds($load_id)
    {
        $load = Load::getZaglushka();
        // $load = Load::findOne($load_id);
        $inGroup = $load->group->getStudentsIds();
        $inAlreadyLoad = self::getActiveStudentsIdsInLoad($load_id);
        return array_diff($inGroup, $inAlreadyLoad);
    }

    public static function getAvailableStudentArray($load_id)
    {
        return Student::findAll(self::getAvailableStudentIds($load_id));
    }

    public static function getAvailableStudentsList($load_id)
    {
        return ArrayHelper::map(self::getAvailableStudentArray($load_id), 'id', 'fullName');
    }


    /**
     * @param $load_id
     * @param null $dateTo
     * @return int[]
     */
    public static function getActiveStudentsIdsInLoad($load_id, $dateTo = null)
    {
        $records = self::getRecordsByLoad($load_id, $dateTo);
        $ids = [];
        /**
         * @var $records self[]
         */
        foreach ($records as $record) {
            if ($record->type == self::TYPE_ACCEPTED) {
                $ids[] = $record->student_id;
            } elseif ($record->type == self::TYPE_DE_ACCEPTED) {
                $key = array_search($record->student_id, $ids);
                if ($key !== false) {
                    unset($ids[$key]);
                }
            }
        }
        return $ids;
    }

    public static function getActiveStudentsInLoad($load_id, $dateTo = null)
    {
        return Student::findAll(self::getActiveStudentsIdsInLoad($load_id, $dateTo));
    }

    public static function getActiveStudentsInLoadList($load_id, $dateTo = null)
    {
        return ArrayHelper::map(self::getActiveStudentsInLoad($load_id, $dateTo), 'id', 'fullName');
    }

    public static function checkIsActive($student_id, $load_id, $dateTo)
    {
        /**
         * @var $record self
         */
        $record = self::find()
            ->andWhere(['student_id' => $student_id, 'load_id' => $load_id])
            ->andWhere(['<', 'date', $dateTo])
            ->orderBy(['id' => SORT_DESC])
            ->one();
       //var_dump($record);
        if ($record == null) return false;
        if ($record->type == self::TYPE_ACCEPTED) {
            return true;
        } else {
            return false;
        }
    }
}