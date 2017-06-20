<?php
namespace app\modules\journal\models;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.06.2017
 * Time: 0:33
 */
class SelectForm extends \yii\base\Model
{
    public $year_id;
    public $speciality_qualification_id;
    public $group_id;
    public $load_id;

    public function rules()
    {
        return [
            [['year_id', 'speciality_qualification_id', 'group_id', 'load_id'], 'required']
        ];
    }
}