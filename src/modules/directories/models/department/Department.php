<?php

namespace app\modules\directories\models\department;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 *
 * @property \app\modules\directories\models\speciality\Speciality[] $specialities
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['head_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'],'required'],
        ];
    }

    public static function getList()
    {
        $departments = Department::find()->all();
        $items = ArrayHelper::map($departments,'id','title');
        return $items;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'head_id' => 'Head ID',
        ];
    }
    public function getSpecialities(){
        return $this->hasMany(\app\modules\directories\models\speciality\Speciality::className(), ['department_id' => 'id']);
    }
    public function getSpecialitiesListLinks(){
        $string="";
        foreach ($this->specialities as $speciality) {
         $string.=Html::a($speciality->title,Url::to(['directories/speciality/view',$speciality->id])).'</br>';
        }
        return $string;
    }
}
