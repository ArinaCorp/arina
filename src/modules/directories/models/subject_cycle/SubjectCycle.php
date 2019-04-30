<?php

namespace app\modules\directories\models\subject_cycle;

use app\modules\directories\models\subject_relation\SubjectRelation;
use nullref\useful\traits\Mappable;
use Yii;
use yii\db\ActiveQuery;
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
    use Mappable;

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
        return [
            [['title'], 'required'],
            [['id'], 'integer'],
            [['id'], 'unique']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('subject', 'Cycle number'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::class, ['subject_cycle_id' => 'id']);
    }

}
