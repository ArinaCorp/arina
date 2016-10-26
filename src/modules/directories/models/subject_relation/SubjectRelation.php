<?php

namespace app\modules\directories\models\relation;

use Yii;
use yii\db\ActiveRecord;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\specialityqualification\SpecialityQualification;

/**
 * This is the model class for table "subject_has_speciality_and_cycle".
 *
 * The followings are the available columns in table 'subject_has_speciality_and_cycle':
 * @property string $id
 * @property integer $subject_id
 * @property integer $speciality_id
 * @property integer $cycle_id
 *
 * @property Subject $subject;
 * @property SpecialityQualification $speciality_qualification;
 * @property SubjectCycle $subject_cycle;
 */

class SubjectRelation extends ActiveRecord
{
    public static function getProviderById($id)
    {
        $deleted = isset(Yii::app()->session['subject']['delete']) ? Yii::app()->session['subject']['delete'] : array();
        $added = isset(Yii::app()->session['subject']['add']) ? Yii::app()->session['subject']['add'] : array();
        $list = array();
        $relations = isset($id) ? self::model()->findAllByAttributes(array('subject_id' => $id)) : array();
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
            $list[] = array('id' => $item->getId(), 'link' => $item->getLinkId(), 'speciality' => $item->speciality->title, 'cycle' => $item->cycle->title);
        }
        return new CArrayDataProvider($list);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SubjectRelation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getId()
    {
        return $this->subject_id . '.' . $this->speciality_id . '.' . $this->cycle_id;
    }

    public function getLinkId()
    {
        return array('id1' => $this->subject_id, 'id2' => $this->speciality_id, 'id3' => $this->cycle_id);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'subject_has_speciality_and_cycle';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('subject_id, speciality_id, cycle_id', 'required'),
            array('subject_id, speciality_id, cycle_id', 'numerical', 'integerOnly' => true),
            array('subject_id, speciality_id, cycle_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
            'cycle' => array(self::BELONGS_TO, 'SubjectCycle', 'cycle_id'),
            'speciality' => array(self::BELONGS_TO, 'Speciality', 'speciality_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'subject_id' => Yii::t('base', 'Subject'),
            'speciality_id' => Yii::t('base', 'Speciality'),
            'cycle_id' => Yii::t('base', 'Subject cycles'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('subject_id', $this->subject_id);
        $criteria->compare('speciality_id', $this->speciality_id);
        $criteria->compare('cycle_id', $this->cycle_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
