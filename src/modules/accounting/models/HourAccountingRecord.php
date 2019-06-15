<?php

namespace app\modules\accounting\models;

use app\modules\load\models\Load;
use nullref\useful\behaviors\JsonBehavior;
use Yii;

/**
 * This is the model class for table "hour_accounting_record".
 *
 * @property int $id
 * @property int $load_id
 * @property int $yearly_hour_accounting_id
 * @property string|array $hours_per_month
 *
 * @property Load $load
 * @property YearlyHourAccounting $yearlyHourAccounting
 */
class HourAccountingRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hour_accounting_record';
    }

    /**
     * {@inheritdoc}
     * @return HourAccountingRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HourAccountingRecordQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['load_id', 'yearly_hour_accounting_id'], 'integer'],
            ['hours_per_month', 'each', 'rule' => ['integer']],
            [['load_id'], 'exist', 'skipOnError' => true, 'targetClass' => Load::class, 'targetAttribute' => ['load_id' => 'id']],
            [['yearly_hour_accounting_id'], 'exist', 'skipOnError' => true, 'targetClass' => YearlyHourAccounting::class, 'targetAttribute' => ['yearly_hour_accounting_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'load_id' => Yii::t('app', 'Load ID'),
            'yearly_hour_accounting_id' => Yii::t('app', 'Yearly Hour Accounting ID'),
            'hours_per_month' => Yii::t('app', 'Hours Per Month'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoad()
    {
        return $this->hasOne(Load::class, ['id' => 'load_id']);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'serialize' => [
                'class' => JsonBehavior::class,
                'fields' => ['hours_per_month'],
                'default' => array_fill(0, 12, 0),
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYearlyHourAccounting()
    {
        return $this->hasOne(YearlyHourAccounting::class, ['id' => 'yearly_hour_accounting_id']);
    }
}
