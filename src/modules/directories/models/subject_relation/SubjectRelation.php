<?php

namespace app\modules\directories\models\subject_relation;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\directories\models\speciality\Speciality;

/**
 * This is the model class for table "subject_has_speciality_and_cycle".
 *
 * The followings are the available columns in table 'subject_has_speciality_and_cycle':
 * @property string $id
 * @property integer $subject_id
 * @property integer $speciality_id
 * @property integer $subject_cycle_id
 *
 * @property Subject $subject;
 * @property Speciality $speciality;
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
            $list[] = ['id' => $item->getId(), 'link' => $item->getLinkId(), 'speciality' => $item->speciality->title, 'cycle' => $item->subjectCycle->title];
        }
        return new ArrayDataProvider($list);
    }

    public function getId()
    {
        return $this->subject_id . '.' . $this->speciality_id . '.' . $this->subject_cycle_id;
    }

    public function getLinkId()
    {
        return ['id1' => $this->subject_id, 'id2' => $this->speciality_id, 'id3' => $this->subject_cycle_id];
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
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'subject_id' => Yii::t('app', 'Subject'),
            'speciality_id' => Yii::t('app', 'Speciality'),
            'subject_cycle_id' => Yii::t('app', 'Subject cycle'),
        ];
    }
}
