<?php

namespace app\modules\directories\models\speciality_qualification;

use Yii;
use \yii\db\ActiveRecord;
use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\qualification\Qualification;
use app\modules\directories\models\relation\SubjectRelation;


/**
 * This is the model class for table "speciality_qualification".
 *
 * @property integer $id
 * @property string $title
 * @property integer $years_count
 * @property integer $months_count
 * @property integer $qualification_id
 * @property integer $speciality_id
 *
 * @property $speciality Speciality
 * @property $qualification Qualification
 * @property $relations SubjectRelation[]
 */

class SpecialityQualification extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%speciality_qualification}}';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['years_count', 'months_count','speciality_id','qualification_id'], 'required'],
            [['years_count', 'months_count','speciality_id','qualification_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'years_count' => Yii::t('app', 'Years Count'),
            'months_count' => Yii::t('app', 'Months Count'),
        ];
    }

    public function getQualification(){
        return $this->hasOne(Qualification::className(),['id'=>'qualification_id']);
    }

    public function getSpeciality() {
        return $this->hasOne(Speciality::className(),['id'=>'speciality_id']);
    }

    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::className(), ['speciality_qualification_id' => 'id']);
    }

}
