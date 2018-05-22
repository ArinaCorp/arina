<?php

namespace app\modules\directories\models\qualification;

use nullref\useful\traits\Mappable;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "qualification".
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort_order
 */
class Qualification extends ActiveRecord
{
    use Mappable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qualification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['sort_order'], 'integer'],
            [['title', 'sort_order'],'required'],
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
            'sort_order' => Yii::t('app', 'Sort order'),
        ];
    }

    /**
     * @inheritdoc
     * @return QualificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QualificationQuery(get_called_class());
    }
}
