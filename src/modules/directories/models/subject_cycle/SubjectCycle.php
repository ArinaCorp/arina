<?php

namespace app\modules\directories\models\subject_cycle;

use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\journal\models\evaluation\EvaluationSystem;
use nullref\core\widgets\ActiveRangeInputGroup;
use nullref\useful\traits\Mappable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subject_cycle".
 *
 * The followings are the available columns in table 'subject_cycle':
 * @property integer $id
 * @property string $title
 * @property string $fullTitle
 * @property int $evaluation_system_id
 * @property int $parent_id
 *
 * @property SubjectRelation[] $subjectRelations
 * @property EvaluationSystem $evaluationSystem
 * @property SubjectCycle $parentCycle
 * @property SubjectCycle[] $subCycles
 * @property SubjectCycle[] $parents
 * @property float $sort_order [float]
 */
class SubjectCycle extends ActiveRecord
{
    use Mappable;

    const ROOT_ID = 0;

    /**
     * Using when move node
     * @var integer
     */
    public $beforeId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subject_cycle}}';
    }

    /**
     * Returns all of subject cycles as tree
     *
     * @param array $options
     * @param array $list
     * @return mixed
     */
    public static function getTree(array $options = [], array $list = [])
    {
        $depth = ArrayHelper::remove($options, 'depth', -1);
        /** @var \Closure $filter */
        $filter = ArrayHelper::remove($options, 'filter', function ($item) {
            return true;
        });

        if (!$list) {
            $list = self::find()->all();
        }

        $list = ArrayHelper::remove($options, 'list', $list);
        $getChildren = function ($id, $depth) use ($list, &$getChildren, $filter) {
            $result = [];
            foreach ($list as $item) {
                if ((int)$item['parent_id'] === (int)$id) {
                    $r = [
                        'title' => $item['title'],
                        'sort_order' => $item['sort_order'],
                        'id' => $item['id'],
                        'subjects' => []
                    ];
                    $c = $depth ? $getChildren($item['id'], $depth - 1) : null;
                    if (!empty($c)) {
                        $r['children'] = $c;
                    }
                    if ($filter($r)) {
                        $result[] = $r;
                    }
                }
            }
            usort($result, function ($a, $b) {
                return $a['sort_order'] > $b['sort_order'];
            });
            return $result;
        };
        return $getChildren(0, $depth);
    }

    /**
     * @inheritdoc
     * @return SubjectCycleQuery the active query used by this AR class.
     */

    public static function find()
    {
        return new SubjectCycleQuery(get_called_class());
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
            ['parent_id', 'default', 'value' => self::ROOT_ID],
            ['beforeId', 'safe']
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

    public function getFullTitle()
    {
        return $this->parent_id ? $this->parentCycle->title . ' | ' . $this->title : $this->title;
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
    public function getParents()
    {
        return $this->hasMany(self::class, ['id' => 'parent_id'])
            ->alias('parents');
    }

    /**
     * @return ActiveQuery
     */
    public function getSubCycles()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $sort_order = $this->getSiblings()->max('sort_order');
            $this->sort_order = $sort_order + 1;
        } else {
            if ($this->beforeId !== null) {
                $this->changeOrder((int)$this->beforeId);
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return ActiveQuery
     */
    public function getSiblings()
    {
        $query = self::find()->siblings($this);
        $query->multiple = true;
        return $query;
    }

    /**
     * @param $before
     */
    protected function changeOrder($before)
    {
        if ($before) {
            /** @var self $prev */
            $prevSortOrder = self::find()
                ->andWhere(['id' => $before])
                ->limit(1)
                ->min('sort_order');

            $nextSortOrder = self::find()
                ->andWhere(['>', 'sort_order', (float)$prevSortOrder])
                ->andWhere(['parent_id' => $this->parent_id])
                ->limit(1)
                ->min('sort_order');

            if ($nextSortOrder > $prevSortOrder) {
                $newOrder = ($prevSortOrder + $nextSortOrder) / 2;
            } else {
                $newOrder = $prevSortOrder + 1;
            }
        } else {
            $prevSortOrder = self::find()
                ->andWhere(['parent_id' => $this->parent_id])
                ->limit(1)
                ->min('sort_order');
            $newOrder = $prevSortOrder / 2;
        }

        $this->sort_order = $newOrder;
    }
}
