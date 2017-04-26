<?php

namespace app\modules\directories\models\subject;

use Yii;
use yii\db\ActiveRecord;

use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\directories\models\subject_cycle\SubjectCycle;

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
            [['id', 'practice'], 'integer'],
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
        return $this->hasMany(SubjectRelation::className(), ['subject_id' => 'id']);
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

}
