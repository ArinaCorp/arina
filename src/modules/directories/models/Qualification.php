<?php

namespace app\modules\directories\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "qualification".
 *
 * @property integer $id
 * @property string $title
 */
class Qualification extends \yii\db\ActiveRecord
{
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

    public static function getList() {
        $data = Qualification::find()->all();
        $items=ArrayHelper::map($data,'id','title');
        return $items;
    }
}
