<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%students_social_networks}}".
 *
 * @property int $id
 * @property int $student_id
 * @property int $network_id
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SocialNetwork $network;
 */
class StudentSocialNetwork extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%students_social_networks}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetwork()
    {
        return $this->hasOne(SocialNetwork::class, ['id' => 'network_id']);
    }

    /**
     * @return string
     */
    public function getNetworkName()
    {
        return $this->network->title;
    }

    public function rules()
    {
        return [
            [['student_id', 'network_id', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 128],
            [['network_id', 'url'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'network_id' => Yii::t('app', 'Social network'),
            'url' => Yii::t('app', 'Url/NickName'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
