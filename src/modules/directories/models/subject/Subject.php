<?php

namespace app\modules\directories\models\subject;

use app\modules\directories\models\relation\SubjectRelation;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%subject}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $short_name
 * @property integer $practice
 *
 * @property SubjectRelation[] $relations
 */

class Subject extends ActiveRecord
{

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%subject}}';
    }

    /**
     * @inheritdoc
     * @return SubjectQuery the active query used by this AR class.
     */

    public static function find()
    {
        return new SubjectQuery(get_called_class());
    }


    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['practice'], 'integer'],
            [['title', 'short_name', 'code'], 'string', 'max' => 255],
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
            'code' => Yii::t('app', 'Code'),
            'short_name' => Yii::t('app', 'Short name'),
            'practice' => Yii::t('app', 'Practice'),
        ];
    }

    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::className(), ['subject_id' => 'id']);
    }

}
