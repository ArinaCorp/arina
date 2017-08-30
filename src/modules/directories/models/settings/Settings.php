<?php

namespace app\modules\directories\settings;

use app\components\VkDynamicModel;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property integer $id
 * @property string $field_key
 * @property string $field_value
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public function rules()
    {
        return [
            ['field_key', 'string', 'max' => 255],
            ['field_value', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'field_key' => Yii::t('app', 'Key'),
            'field_value' => Yii::t('app', 'Value'),
        ];
    }

    public static function getModel()
    {
        $attributes = self::getSettingsAttributes();
        $model = new VkDynamicModel($attributes);
        $model->setFormName('GeneralSettings');
        $model->addRule($attributes, 'required', ['message' => Yii::t('app', 'You need to specify option for all atributtes.')]);
        $model->setAttributeLabels([
            'companyFullName' => Yii::t('app', 'Company name'),
            'companyShortName' => Yii::t('app', 'Company name'),
            'ministryName' => Yii::t('app', 'Ministry name'),
            'directorId' => Yii::t('app', 'Footer contact block'),
        ]);

        foreach ($attributes as $setting) {
            $value = self::find()->andWhere(['field_key' => $setting])->one();
            $model->$setting = $value;
        }
        return $model;
    }

    public
    static function getSettingsAttributes()
    {
        return [
            'companyFullName',
            'companyShortName',
            'ministryName',
            'directorId',
        ];
    }

    public
    static function saveModel(VkDynamicModel $model)
    {
        $attributes = self::getSettingsAttributes();
        foreach ($attributes as $setting) {
            $value = self::find()->andWhere(['field_key' => $setting])->one();
            $value->field_value = $model->$setting;
            $value->save(false);
        }
    }
}
