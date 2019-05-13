<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 07.05.2019
 * Time: 0:52
 */

namespace app\modules\directories\models\subject_relation;

use Yii;
use yii\base\Model;

class CreateSubjectRelationForm extends Model
{
    public $subject_id;
    public $subject_cycle_id;
    public $speciality_qualification_ids = [];

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['subject_id', 'subject_cycle_id', 'speciality_qualification_ids'], 'required'],
//            [['subject_id', 'subject_cycle_id', 'speciality_qualification_ids'], 'unique', 'targetAttribute' => ['subject_id', 'subject_cycle_id', 'speciality_qualification_ids']],
            [['subject_id', 'subject_cycle_id'], 'integer'],
            [['subject_id'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'subject_id' => Yii::t('app', 'Subject'),
            'subject_cycle_id' => Yii::t('app', 'Subject cycle'),
            'speciality_qualification_ids' => Yii::t('app', 'Speciality Qualifications'),
        ];
    }

    public function process()
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->speciality_qualification_ids as $speciality_qualification_id) {
            $model = new SubjectRelation([
                'subject_id' => $this->subject_id,
                'subject_cycle_id' => $this->subject_cycle_id,
                'speciality_qualification_id' => $speciality_qualification_id
            ]);
            $model->save();
        }

        return true;
    }
}