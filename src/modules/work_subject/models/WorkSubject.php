<?php

namespace app\modules\work_subject\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\modules\directories\models\subject\Subject;

/**
 * @property integer $id
 * @property integer $subject_id
 * @property integer $plan_id
 * @property array $total
 * @property array $lectures
 * @property array $labs
 * @property array $practices
 * @property array $weeks
 * @property array $control
 * @property integer $cyclic_commission_id
 * @property string $certificate_name
 * @property string $diploma_name
 * @property integer $project_hours
 * @property array $control_hours
 * @property bool $dual_labs
 * @property bool $dual_practice
 *
 * @property Subject $subject
 *
 */
class WorkSubject extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'StrBehavior' => [
                    'class' => 'application.behaviors.StrBehavior',
                    'fields' => [
                        'total',
                        'lectures',
                        'labs',
                        'practices',
                        'weeks',
                    ]
                ],
                'JSONBehavior' => [
                    'class' => 'application.behaviors.JSONBehavior',
                    'fields' => [
                        'control',
                        'control_hours',
                    ]
                ],
                // TODO: create behaviors
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wp_subject}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plan_id', 'subject_id', 'cyclic_commission_id', 'project_hours'], 'integer'],
            [['subject_id', 'dual_labs', 'dual_practice'], 'required'],
            [['total', 'lectures', 'labs', 'practices', 'weeks', 'control'], 'default', 'value' => ''],
            [['certification', 'diploma_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan_id' => Yii::t('app', 'Plan ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'total' => Yii::t('app', 'Total'),
            'lectures' => Yii::t('app', 'Lectures'),
            'labs' => Yii::t('app', 'Laboratory'),
            'practices' => Yii::t('app', 'Practices'),
            'weeks' => Yii::t('app', 'Weeks'),
            'control' => Yii::t('app', 'Control'),
            'cyclic_commission_id' => Yii::t('app', 'Cyclic Commission ID'),
            'certification_name' => Yii::t('app', 'Certification name'),
            'diploma_name' => Yii::t('app', 'Diploma name'),
            'project_hours' => Yii::t('app','Project hours'),
            'control_hours' => Yii::t('app', 'Control hours'),
            'dual_labs' => Yii::t('app', 'Dual laboratory works'),
            'dual_practice'=>Yii::t('app', 'Dual practice works'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

}