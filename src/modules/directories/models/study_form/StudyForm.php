<?php

namespace app\modules\directories\models\study_form;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\students\models\StudentsHistory;
use nullref\useful\traits\Mappable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap\Alert;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "study_form".
 *
 * @property integer $id
 * @property string $title
 *
 */
class StudyForm extends ActiveRecord
{
    use Mappable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%study_form}}';
    }

    /**
     * @inheritdoc
     * @return StudyFormQuery
     */
    public static function find()
    {
        return new StudyFormQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app','Title'),
        ];
    }

}
