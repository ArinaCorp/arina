<?php
namespace app\modules\journal\models\accounting;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 14:12
 */

class MarksAccountingForm extends Model
{
    public $load_id;

    public function rules()
    {
        return [
          ['load_id', 'required']
        ];
    }
}