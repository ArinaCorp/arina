<?php

namespace app\modules\students\models;

use Yii;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "students_characteristics".
 *
 * @property int $id
 * @property int $student_id
 * @property int $type_id
 * @property string $title
 * @property string $date
 * @property string $from
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 */
class StudentCharacteristic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%students_characteristics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string'],
            [['title', 'from'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'title' => Yii::t('app', 'Title'),
            'date' => Yii::t('app', 'Date'),
            'from' => Yii::t('app', 'From'),
            'text' => Yii::t('app', 'Text'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function shortClassName()
    {
        $reflector = new \ReflectionClass(get_called_class());

        return $reflector->getShortName();
    }

    public static function getList($student_id, $student)
    {
        $query = self::find();
        $query->andWhere([
            'student_id' => $student_id,
        ]);
        $list = $query->all();
        /**
         * @var $list self[];
         */
        foreach ($list as $key => $familyTie) {
            if ($familyTie->isNewRecord) {
                $list[$key]->id = null;
            }
        };
        $params = Yii::$app->request->post(self::shortClassName());
        if ($params && is_array($params)) {
            $list = [];
            for ($i = 0; $i < count($params); $i++) {
                $model = new self();
                $model->setAttributes($params[$i]);
                $list[] = $model;
            }
        } elseif (Yii::$app->request->isPost) {
            $list = [];
        }
        if (Yii::$app->request->post('add-' . self::shortClassName())) {
            $list[] = new self();;
        }
        if (Yii::$app->request->post('remove-' . self::shortClassName())) {
            unset($list[Yii::$app->request->post('data-key')]);
            $oldList = $list;
            $list = [];
            foreach ($oldList as $familyTie) {
                $list[] = $familyTie;
            }
        }
        return $list;
    }
}
