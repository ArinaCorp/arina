<?php

namespace app\modules\directories\models\subject;

use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\directories\models\subject_relation\SubjectRelation;
use nullref\useful\traits\Mappable;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $short_name
 * @property integer $practice
 *
 * @property SubjectRelation[] $relations
 */
class Subject extends ActiveRecord
{
    use Mappable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subject}}';
    }

    /**
     * @inheritdoc
     * @return SubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubjectQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code', 'short_name'], 'required'],
            [['id', 'practice'], 'integer'],
            [['title', 'code', 'short_name'], 'unique'],
            [['title', 'short_name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'code' => Yii::t('app', 'Code'),
            'short_name' => Yii::t('app', 'Short title'),
            'practice' => Yii::t('app', 'Practice'),
        ];
    }

    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::class, ['subject_id' => 'id']);
    }

    /**
     * @param integer $id speciality id
     * @return array for dropDownList
     */
    public static function getListForSpecialityQualification($id)
    {
        $list = [];
        $relations = SubjectRelation::find()->where(['speciality_qualification_id' => $id])->all();
        foreach ($relations as $relation) {
            /**@var $relation SubjectRelation */
            if (!isset($list[$relation->subjectCycle->title])) {
                $list[$relation->subjectCycle->title] = [];
            }
            $list[$relation->subjectCycle->title][$relation->subject_id] = $relation->subject->title;
        }
        return $list;
    }

    public static function getList()
    {
        $model = self::find()->all();
        return ArrayHelper::map($model,'id','title');

    }

    /**
     * @param $speciality_qualification_id
     * @return SubjectCycle
     */
    public function getCycle($speciality_qualification_id)
    {
        return SubjectRelation::findOne([
            'speciality_qualification_id' => $speciality_qualification_id,
            'subject_id' => $this->id])->subjectCycle;
    }

    /**
     * @return array Returns list of optional subjects
     */
    public static function getOptionalList()
    {
        $subjects = Subject::find()->where(['like', 'code', 'ПВС'])->all();
        $items = ArrayHelper::map($subjects, 'id', 'title');
        return $items;
    }

}
