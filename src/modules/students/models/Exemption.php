<?php

namespace app\modules\students\models;

use nullref\useful\traits\Mappable;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "exemptions".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Student[] $students
 */
class Exemption extends \yii\db\ActiveRecord
{
    use Mappable;

    //TODO: create a seed migration according to constants
    const TYPE_ORPHAN = 1,
        TYPE_DISABLED_GROUP_2 = 2,
        TYPE_DISABLED_GROUP_3 = 3,
        TYPE_UNDER_CARE = 4,
        TYPE_DISPLACED = 5,
        TYPE_ATO = 6;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%exemptions}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','id'], 'integer'],
            [['title'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function getExemptionTitleById($id)
    {
        $title = Exemption::find()->select("title")->where(["id"=>$id])->column();
        $str = $title[0];

        return $str;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['id' => 'student_id'])
            ->viaTable('{{%exemptions_students_relations}}', ['exemption_id' => 'id']);
    }
}
