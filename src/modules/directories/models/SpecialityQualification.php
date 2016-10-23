<?php

namespace app\modules\directories\models;

use Yii;
use app\modules\directories\models\Speciality;
use app\modules\directories\models\Qualification;

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
 */
class SpecialityQualification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'speciality_qualification';
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
    public static function getTreeList(){
        $list = [];

        $department = Department::find()->all();
        foreach ($department as $item) {
            /* @var $item Department */
            $list[$item->title] = [];
            foreach ($item->specialities as $speciality) {
                /**
                 * @var $speciality Speciality
                 */
                $list[$item->title][$speciality->title] = [];
                foreach ($speciality->specialityQualifications as $specialityQualification){
                    /**
                     * @var $specialityQualification SpecialityQualification
                     */
                    $list[$item->title][$speciality->title][$specialityQualification->id]=$specialityQualification->title;
                }
            }
        }
        return $list;
    }
    
}
