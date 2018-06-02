<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/25/18
 * Time: 5:27 PM
 */

namespace app\modules\students\models;


use app\components\exporters\GroupExporter;
use Yii;
use yii\base\Model;

class GroupExport extends Model
{

    public $telephone, $birth_day, $payment_type_label;
    protected $groupId;

    public function __construct($groupId, array $config = [])
    {
        $this->groupId = $groupId;
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['telephone'], 'boolean'],
            [['birth_day'], 'boolean'],
            [['payment_type_label'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'telephone' => Yii::t('app', 'Phone number'),
            'birth_day' => Yii::t('app', 'Birth date'),
            'payment_type_label' => Yii::t('app', 'Payment type')
        ];
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        $optional = ['Phone' => $this->telephone, 'BirthDay' => $this->birth_day, 'PaymentTypeLabel' => $this->payment_type_label];
        $model = Group::findOne($this->groupId);
        return GroupExporter::getDocument($model, $optional);
    }

}