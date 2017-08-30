<?php
/**
 * Created by PhpStorm MyBe.
 * User: MyBe
 * Date: 21.05.2017
 * Time: 19:07
 */

namespace app\components;

use app\modules\geo\models\Country;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Geo extends Widget
{
    public $model;

    public $field;

    public $form;

    public function init()
    {
        parent::init();
        if ($this->field !== null) {
            switch ($this->field) {
                case 'country_id' : {

                }
            }
        }
    }

    public function run()
    {
        return $this->form->field($this->model, $this->field)->dropDownList(
            Country::getDropDownArray(),
            [
                'prompt' => Yii::t('app', 'Choose country')
            ]
        )->label(Yii::t('app', 'Country'));

    }
}