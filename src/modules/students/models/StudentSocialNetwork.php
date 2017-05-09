<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "{{%students_social_networks}}".
 *
 * @property int $id
 * @property int $student_id
 * @property int $network_id
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SocialNetwork $network;
 */
class StudentSocialNetwork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return '{{%students_social_networks}}';
    }

    /**
     * @inheritdoc
     */

    public function getNetwork()
    {
        return $this->hasOne(SocialNetwork::className(), ['id' => 'network_id']);
    }

    public function getNetworkName()
    {
        return $this->network->title;
    }

    public function rules()
    {
        return [
            [['student_id', 'network_id', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 128],
            [['network_id', 'url'], 'required']
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
            'network_id' => Yii::t('app', 'Social network'),
            'url' => Yii::t('app', 'Url/NickName'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param $student_id
     * @param $student
     * @return StudentSocialNetwork[]|array|\yii\db\ActiveRecord[]
     */

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

    /**
     * @param $student Student;
     * @return mixed
     */

    public static function validateSt($student)
    {
        $success = true;
        $modelsFamily = $student->has_socials;
        /**
         * @var $modelsFamily self[];
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
