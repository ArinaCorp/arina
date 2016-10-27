<?php

namespace app\modules\directories\models\relation;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subject_cycle".
 *
 * The followings are the available columns in table 'subject_cycle':
 * @property integer $id
 * @property string $title
 *
 * @property $relations SubjectRelation[]
 */

class SubjectCycle extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%subject_cycle}}';
    }

    /**
     * @return array validation rules for model attributes.
     */

    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 255),
            array('id', 'required'),
            array('id', 'numerical', 'integerOnly' => true),
            array('id', 'unique'),
            array('id, title', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('subject', 'Cycle number'),
            'title' => Yii::t('base', 'Title'),
        );
    }

    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::className(), ['subject_cycle_id' => 'id']);
    }

}
