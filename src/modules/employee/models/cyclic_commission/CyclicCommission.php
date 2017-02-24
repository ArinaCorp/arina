<?php

namespace app\modules\employee\models\cyclic_commission;

use app\modules\employee\models\Employee;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cyclic_commission".
 *
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 * @property Employee $head
 */
class CyclicCommission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cyclic_commission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['head_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'title' => Yii::t('app','Title'),
            'head_id' => Yii::t('app','Head ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return CyclicCommissionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CyclicCommissionQuery(get_called_class());
    }

    public function getHeadName()
    {
        if (isset($this->head)) {
            return $this->head->getFullName();
        } else {
            return Yii::t('base', 'Not selected');
        }
    }

    public function getHead(){
        return $this->hasOne(Employee::className(),['id'=>'head_id']);
    }

    public static function getList()
    {
        $data = CyclicCommission::find()->all();
        $items = ArrayHelper::map($data,'id','title');
        return $items;
    }


}
