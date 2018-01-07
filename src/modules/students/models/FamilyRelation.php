<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "family_relation".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $type_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $work_place
 * @property string $work_position
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 */
class FamilyRelation extends \yii\db\ActiveRecord
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
        return 'family_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'type_id'], 'required'],
            [['last_name', 'first_name', 'middle_name', 'work_place', 'work_position'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone1', 'phone2'], 'integer'],
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
            'type_id' => Yii::t('app', 'Type Family Tie'),
            'last_name' => Yii::t('app', 'Last Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'work_place' => Yii::t('app', 'Work Place'),
            'work_position' => Yii::t('app', 'Work Position'),
            'phone1' => Yii::t('app', 'Phone'),
            'phone2' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getType()
    {
        return $this->hasOne(FamilyRelationType::className(), ['id' => 'type_id']);
    }

    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['student_id' => 'id']);
    }

    public static function getList($student_id, $student)
    {
        $query = self::find();
        $query->andWhere([
            'student_id' => $student_id,
        ]);
        $list = $query->all();
        /**
         * @var $list FamilyRelation[];
         */
        foreach ($list as $key => $familyTie) {
            if ($familyTie->isNewRecord) {
                $list[$key]->id = null;
            }
        };
        $params = Yii::$app->request->post('FamilyTie');
        if ($params && is_array($params)) {
            $list = [];
            for ($i = 0; $i < count($params); $i++) {
                $model = new FamilyRelation();
                $model->setAttributes($params[$i]);
                $list[] = $model;
            }
        } elseif (Yii::$app->request->isPost) {
            $list = [];
        }
        if (Yii::$app->request->post('add-family-tie')) {
            $list[] = new FamilyRelation();;
        }
        if (Yii::$app->request->post('remove-family-tie')) {
            unset($list[Yii::$app->request->post('data-key')]);
            $oldList = $list;
            $list = [];
            foreach ($oldList as $familyTie) {
                $list[] = $familyTie;
            }
        }
        return $list;
    }

    /**
     * @param $student Student;
     * @return mixed
     */

    public static function validateSt($student)
    {
        $success = true;
        $modelsFamily = $student->has_family;
        /**
         * @var $modelsFamily FamilyRelation[];
         */
        foreach ($modelsFamily as $model) {
            $success = $success && $model->validate();
        }
        return $success;
    }

    public static function saveSt($student_id, $student)
    {
        if (empty($student_id)) {
            throw new BadRequestHttpException(Yii::t('app', 'Bad Request'));
        }
        $query = self::find()->select('id');
        $query->andWhere([
            'student_id' => $student_id
        ]);
        $ids = $query->asArray()->column();
        $list = self::getList($student_id, $student);
        foreach ($list as $params) {
            if (isset($params->id) && !empty($params->id)) {
                $attr = self::findOne($params->id);
                $key = array_search($params->id, $ids);

                if ($key !== false) {
                    unset($ids[$key]);
                }
            } else {
                $attr = new self();
                $attr->student_id = $student_id;
            }
            $new_atrib = array_filter($params->getAttributes());
            $attr->setAttributes($new_atrib);
            if (!$attr->save()) {
                $attr->delete();
            }
        }
        if (count($ids) > 0) {
            self::deleteAll(['in', 'id', $ids]);
        }
    }
}
