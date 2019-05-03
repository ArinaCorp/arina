<?php

namespace app\modules\directories\models\department;

use app\modules\directories\models\speciality\Speciality;
use app\modules\employee\models\Employee;
use nullref\useful\traits\Mappable;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 * @property Employee $head
 *
 * @property \app\modules\directories\models\speciality\Speciality[] $specialities
 */
class Department extends \yii\db\ActiveRecord
{
    use Mappable;

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
            [['title'], 'required'],
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
            'head_id' => Yii::t('app', 'HeadID'),
            'specialities' => Yii::t('app', 'Specialities'),
            'headName' => Yii::t('app', 'HeadID'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialities()
    {
        return $this->hasMany(Speciality::class, ['department_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getSpecialitiesListLinks()
    {
        $string = "";
        foreach ($this->specialities as $speciality) {
            $string .= Html::a($speciality->title, Url::to(['speciality/view', 'id' => $speciality->id])) . '</br>';
        }
        return $string;
    }

    /**
     * @return string
     */
    public function getHeadName()
    {
        if (isset($this->head)) {
            return $this->head->getFullName();
        } else {
            return Yii::t('base', 'Not selected');
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(Employee::class, ['id' => 'head_id']);
    }
}
