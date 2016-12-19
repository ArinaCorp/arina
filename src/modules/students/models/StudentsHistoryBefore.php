<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;


use yii\base\Model;
use Yii;

class StudentsHistoryBefore extends Model
{
    public $category_id;
    public $group_search_id;
    public $child;
    public $student_id;
    public $parent_id;
    public $date;
    public $study_year_id;
    public $action_type;

    public function rules()
    {
        return [
            [['student_id', 'action_type', 'date'], 'required'],
            ['parent_id', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'student_id' => Yii::t('app', 'Student ID'),
            'date' => Yii::t('app', 'Date'),
            'action_type' => Yii::t('app', 'Action type'),
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'group_search_id' => Yii::t('app', 'Group Search ID'),
        ];
    }
}