<?php

namespace app\modules\directories\models\relation;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;

/**
 * This is the model class for table "subject_has_speciality_and_cycle".
 *
 * The followings are the available columns in table 'subject_has_speciality_and_cycle':
 * @property string $id
 * @property integer $subject_id
 * @property integer $speciality_qualification_id
 * @property integer $subject_cycle_id
 *
 * @property Subject $subject;
 * @property SpecialityQualification $speciality_qualification;
 * @property SubjectCycle $subject_cycle;
 */
class SubjectRelation extends ActiveRecord
{
    public function getId()
    {
        return $this->subject_id . '.' . $this->speciality_qualification_id . '.' . $this->subject_cycle_id;
    }

    public function getLinkId()
    {
        return array('id1' => $this->subject_id, 'id2' => $this->speciality_qualification_id, 'id3' => $this->subject_cycle_id);
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%subject_relation}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['subject_id', 'speciality_qualification_id', 'subject_cycle_id'], 'required'],
            [['subject_id', 'speciality_qualification_id', 'subject_cycle_id'], 'integer'],
            [['subject_id', 'speciality_qualification_id', 'subject_cycle_id'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubjectCycle()
    {
        return $this->hasOne(SubjectCycle::className(), ['id' => 'subject_cycle_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialityQualification()
    {
        return $this->hasOne(SpecialityQualification::className(), ['id' => 'speciality_qualification_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'subject_id' => Yii::t('base', 'Subject'),
            'speciality_qualification_id' => Yii::t('base', 'Speciality qualification'),
            'subject_cycle_id' => Yii::t('base', 'Subject cycles'),
        );
    }
}
