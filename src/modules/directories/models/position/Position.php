<?php

namespace app\modules\directories\models\position;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use \yii\db\ActiveQuery;
use app\modules\employee\models\Employee;

/**
 * This is the model class for table "position".
 *
 * The followings are the available columns in table 'position':
 * @property integer $id
 * @property string $title
 * @property integer $max_hours_1
 * @property integer $max_hours_2
 *
 * @property Employee[] $employee
 */
class Position extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    /**
     * @inheritdoc
     * @return PositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PositionQuery(get_called_class());
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['id', 'max_hours_1', 'max_hours_2'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id', 'title'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'max_hour_1' => Yii::t('app', 'Max load hours').' 1',
            'max_hour_2' => Yii::t('app', 'Max load hours').' 2',
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasMany(Employee::className(), ['position_id' => 'id']);
    }

    public static function getList()
    {
        $departments = Position::find()->all();
        $items = ArrayHelper::map($departments,'id','title');
        return $items;
    }

}
