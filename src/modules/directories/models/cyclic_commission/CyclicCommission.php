<?php

namespace app\modules\directories\models\cyclic_commission;

use Yii;
use yii\db\ActiveRecord;
use app\modules\teacher\models\Teacher;

/**
 * This is the model class for table "cyclic_commission".
 *
 * The followings are the available columns in table 'cyclic_commission':
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 *
 * The followings are the available model relations:
 * @property Teacher[] $teachers
 * @property Teacher $head
 */

class CyclicCommission extends ActiveRecord
{
    public function getHeadName()
    {
        if (isset($this->head))
            return $this->head->getFullName();
        else
            return Yii::t('base', 'Not selected');
    }

    /**
     * @return string the associated database table name
     */

    public static function tableName()
    {
        return '{{%cyclic_commission}}';
    }

    /**
     * @return array validation rules for model attributes.
     */

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['head_id'], 'required', 'on' => 'update'],
            [['head_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id', 'title', 'head_id'], 'safe'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getTeachers()
    {
        return $this->hasMany(Teacher::className(), ['cyclic_commission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getHead()
    {
        return $this->hasOne(Teacher::className(), ['head_id' => 'id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('terms', 'Title'),
            'head_id' => Yii::t('terms', 'Head'),
            'teachers'=>Yii::t('terms', 'Teachers'),
        ];
    }

}