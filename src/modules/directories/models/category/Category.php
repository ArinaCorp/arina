<?php

namespace app\modules\directories\models\category;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\modules\employee\models\Employee;

/**
 * This is the model class for table "position".
 *
 * The followings are the available columns in table 'position':
 * @property integer $id
 * @property string $title
 *
 * @property Employee[] $employee
 */
class Category extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id', 'title'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasMany(Employee::className(), ['category_id' => 'id']);
    }

}
