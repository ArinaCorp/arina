<?php

namespace app\modules\directories\models\subject_cycle;

use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\journal\models\evaluation\EvaluationSystem;
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
 * @property int $evaluation_system_id
 *
 * @property $relations SubjectRelation[]
 * @property EvaluationSystem $evaluationSystem
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
            [['id', 'evaluation_system_id'], 'integer'],
            [['id'], 'unique'],
            [['evaluation_system_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluationSystem::class, 'targetAttribute' => ['evaluation_system_id' => 'id']],
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
            'evaluation_system_id' => Yii::t('app', 'Evaluation system'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::class, ['subject_cycle_id' => 'id']);
    }

    public function getEvaluationSystem()
    {
        return $this->hasOne(EvaluationSystem::class, ['id' => 'evaluation_system_id']);
    }
}
