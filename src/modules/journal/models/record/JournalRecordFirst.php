<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.06.2017
 * Time: 23:08
 */

namespace app\modules\journal\models\record;


use yii\base\Model;
use Yii;

class JournalRecordFirst extends Model
{
    public $type;
    public $load_id;

    public function rules()
    {
        return [
            [['type'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => Yii::t('app', "Type"),
        ];
    }
}