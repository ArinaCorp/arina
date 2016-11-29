<?php

namespace app\modules\directories\models;

use Yii;

/**
 * This is the model class for table "study_years".
 *
 * @property integer $id
 * @property integer $year_start
 */

class StudyYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_years';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['year_start','required'],
            [['year_start'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'year_start' => Yii::t('app', 'Start of the study year'),
            'year_end' => Yii::t('app','End of the study year'),
        ];
    }

    public function getYearEnd(){
        return $this->year_start+1;
    }
    public function getYearPrefix(){
        $str = (string)$this->year_start;
        return $str[sizeof($this)-2].$str[sizeof($this)-1];
    }
    public static function getYearList(){
        $studyYears = StudyYear::find()->all();
        $items=[];
        foreach ($studyYears as $studyYear){
            /**
             * @var StudyYear $studyYear
             */
            $items[$studyYear->id]=$studyYear->year_start.'/'.$studyYear->getYearEnd();
        }
        return $items;
    }
}
