<?php


namespace app\modules\students\models;


use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yii;

class ExportParams extends \yii\base\Model
{
    public $plan_id;
    public $semester;
    public $dateFrom;
    public $dateTo;
    public $year;
    public $subject_id;
    public $course;
    public $teachers_id;
    public $group_id;
    public $plan;
    public $marks_checker;
    public $years_id;
    public $journal_record_id;


    public function rules()
    {
        return [
            [['semester'],'required','message'=>Yii::t('app','Please enter a "semester" value')],
            ['semester','integer','max' => 8, 'min'=>1,
                'tooBig'=>Yii::t('app','Semester value must be >1 and <8'),
                'tooSmall'=>Yii::t('app','Semester value must be >1 and <8')],
            [['course'],'required','message'=>Yii::t('app','Please enter a "course" value')],
            ['course','integer','max' => 4, 'min'=>1,
                'tooBig'=>Yii::t('app','Course value must be >1 and <4'),
                'tooSmall'=>Yii::t('app','Course value must be >1 and <4')],
            [['group_id','course','subject_id','plan_id','plan','journal_record_id','years_id'],'required'],
            [['date-from','date-to','year'],'date'],
            [['marks_checker'],'boolean'],
            ['teachers_id', 'each', 'rule' => ['integer']],
            ['journal_record_id', 'each', 'rule' => ['integer']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'semester' => Yii::t('app', 'Semester'),
            'course' => Yii::t('app', 'Course'),
            'teachers_id' => Yii::t('app', 'Teachers'),
            'subject_id' => Yii::t('app', 'Subject'),
            'plan_id' => Yii::t('app', 'Plan'),
            'marks_checker'=>Yii::t('app', 'Marks'),
            'journal_record_id'=>Yii::t('app', 'Select attestations')
        ];
    }

}