<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "exemptions".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 */
class Exemption extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%exemptions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
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

    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['id' => 'student_id'])->viaTable('{{%exemptions_students_relations}}', ['exemption_id' => 'id']);
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
