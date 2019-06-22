<?php

namespace app\modules\geo\models;

use nullref\useful\traits\Mappable;
use Yii;

/**
 * This is the model class for table "country".
 */
class Country extends \tigrov\country\Country
{
    use Mappable;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'name_en' => Yii::t('app', 'English name'),
        ];
    }

    /**
     * Get name in current localization.
     * @param null|string $lang Optional excplicit localization
     * @return string
     */
    public function getName($lang = null)
    {
        return Yii::t('geo', $this->name_en, [], $lang);
    }

}
