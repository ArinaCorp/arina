<?php

namespace app\modules\students\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "curator_group".
 *
 * @property int $id
 * @property int $group_id
 * @property int $teacher_id
 * @property int $type
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 */
class CuratorGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%curator_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'teacher_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['group_id', 'teacher_id', 'type', 'date'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getType()
    {
        return ($this->type) ? Yii::t('app', 'Accepted') : Yii::t('app', 'De accepted');
    }

    public static function getTypesList()
    {
        return [
            0 => Yii::t('app', 'De accepted'),
            1 => Yii::t('app', 'Accepted'),
        ];
    }

    public static function getGroupsByTeacher($teacher_id)
    {
        $query = self::find();
        $groups_id = ArrayHelper::index(Group::getActiveGroups(),'id');
        $query->andWhere(['group_id'=>$groups_id]);
        $listRecord = $query->all();
        foreach ($listRecord as $item){
            if($item->type==1) {
                $k=0;
                if(in_array($item->group_id,$listGroup)) continue;
                foreach($listRecord as $item2){
                    if($item->group_id==$item2->group_id) {
                        if ($item != $item2 && $item2->type == 0) {
                            $k+=1;
                        }
                    }
                }
                if($k%2==0){
                    array_push($listGroup,$item->group_id)  ;
                }
            }
        }

    }
}
