<?php

namespace app\modules\directories\models\audience;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%directories_audience}}".
 *
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property integer $type
 * @property integer $id_teacher
 * @property string $typeTitle
 */

class Audience extends ActiveRecord
{
    const TYPE_LECTURE = 1;
    const TYPE_LABORATORY = 2;
    const TYPE_WORKSHOP = 3;
    const TYPE_GUM = 4;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%directories_audience}}';
    }

    /**
     * @inheritdoc
     * @return AudienceQuery the active query used by this AR class.
     */

    public static function find()
    {
        return new AudienceQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getTypeTitle()
    {
        $list = self::getTypeList();
        return $list[$this->type];
    }

    /**
     * Array for dropDownList
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_LECTURE => Yii::t('audience', 'Lecture'),
            self::TYPE_LABORATORY => Yii::t('audience', 'Laboratory'),
            self::TYPE_WORKSHOP => Yii::t('audience', 'Workshop'),
            self::TYPE_GUM => Yii::t('audience', 'Gum'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'id_teacher'], 'integer'],
            [['number', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'id_teacher' => Yii::t('app', 'Id Teacher'),
        ];
    }
}
