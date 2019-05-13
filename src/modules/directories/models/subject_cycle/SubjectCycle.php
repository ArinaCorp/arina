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
 * @property int $parent_id
 *
 * @property SubjectRelation[] $subjectRelations
 * @property EvaluationSystem $evaluationSystem
 * @property SubjectCycle $parentCycle
 * @property SubjectCycle[] $subCycles
 */
class SubjectCycle extends ActiveRecord
{
    use Mappable;

    const ROOT_ID = 0;

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
            [['title', 'evaluation_system_id'], 'required'],
            [['id', 'evaluation_system_id', 'parent_id'], 'integer'],
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
            'parent_id' => Yii::t('app', 'Subject cycle'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubjectRelations()
    {
        return $this->hasMany(SubjectRelation::class, ['subject_cycle_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getEvaluationSystem()
    {
        return $this->hasOne(EvaluationSystem::class, ['id' => 'evaluation_system_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParentCycle()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubCycles()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }
}
