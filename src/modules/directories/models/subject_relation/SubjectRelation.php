<?php

namespace app\modules\directories\models\subject_relation;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;

/**
 * This is the model class for table "subject_cycle".
 *
 * The followings are the available columns in table 'subject_cycle':
 * @property integer $id
 * @property integer $subject_id
 * @property integer $speciality_qualification_id
 * @property integer $subject_cycle_id
 *
 * @property Subject $subject;
 * @property SpecialityQualification $specialityQualification;
 * @property SubjectCycle $subjectCycle;
 */
class SubjectRelation extends ActiveRecord
{
    public static function getProviderById($id)
    {
        $deleted = isset(Yii::$app->session['subject']['delete']) ? Yii::$app->session['subject']['delete'] : [];
        $added = isset(Yii::$app->session['subject']['add']) ? Yii::$app->session['subject']['add'] : [];
        $list = [];
        $relations = isset($id) ? self::findAll(['subject_id' => $id]) : [];
        foreach ($added as $item) {
            /**@var SubjectRelation $item */
            $continue = false;
            foreach ($relations as $i) {
                /**@var SubjectRelation $i */
                if ($i->getId() == $item->getId()) {
                    $continue = true;
                    break;
                }
            }
            if ($continue) continue;
            $relations[] = $item;
        }
        foreach ($relations as $item) {
            /**@var SubjectRelation $item */
            $continue = false;
            foreach ($deleted as $i) {
                if ($i['id'] == $item->getId()) {
                    $continue = true;
                    break;
                }
            }
            if ($continue) continue;
            $list[] = [
                'id' => $item->getId(),
                'link' => $item->getLinkId(),
                'specialityQualification' => $item->specialityQualification->title,
                'cycle' => $item->subjectCycle->title
            ];
        }
        return new ArrayDataProvider($list);
    }

    public function getId()
    {
        return $this->subject_id . '.' . $this->speciality_qualification_id . '.' . $this->subject_cycle_id;
    }

    public function getLinkId()
    {
        return [
            'id1' => $this->subject_id,
            'id2' => $this->speciality_qualification_id,
            'id3' => $this->subject_cycle_id
        ];
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
            [['subject_id'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::class, ['id' => 'subject_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubjectCycle()
    {
        return $this->hasOne(SubjectCycle::class, ['id' => 'subject_cycle_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialityQualification()
    {
        return $this->hasOne(SpecialityQualification::class, ['id' => 'speciality_qualification_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'subject_id' => Yii::t('app', 'Subject'),
            'speciality_qualification_id' => Yii::t('app', 'Speciality qualification'),
            'subject_cycle_id' => Yii::t('app', 'Subject cycle'),
        ];
    }
}
