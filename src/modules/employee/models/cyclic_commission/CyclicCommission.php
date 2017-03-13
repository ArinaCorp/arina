<?php

namespace app\modules\employee\models\cyclic_commission;

use app\modules\employee\models\Employee;
use Yii;
use yii\helpers\ArrayHelper;

use PHPExcel;
use PHPExcel_IOFactory;

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

    /**
     * @return Employee[]
     */
    public function getEmployeeArray()
    {
        /**
         * @var $result Employee[];
         * @var $employees Employee[];
         */
        $result = [];
        $employees = Employee::find()->all();
        foreach ($employees as $employee) {
            $idsCyclicCommission = $employee->getCyclicCommissionArray($this->id);
            if (!is_null($idsCyclicCommission)) {
                if (array_key_exists($this->id, $idsCyclicCommission)) {
                  
                    array_push($result, $employee);
                };
            }
        }

        return $result;
    }

    public static function getCyclicCommissionArray($id)
    {
        $array = null;

        foreach (Employee::getAllTeacher() as $item) {

            if ($item->cyclic_commission_id == $id) {
                $array[] = $item->data;
            }
        }
        return $array;
    }

    public function getDocument()
    {
        $tmpfname = Yii::getAlias('@webroot') . "/templates/cyclic_commission.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $excelObj = $excelReader->load($tmpfname);
        $excelObj->setActiveSheetIndex(0);

        /**
         * @var Employee[] $employees
         */
        $employees = $this->getEmployeeArray();
        $excelObj->getActiveSheet()->SetCellValue('B2', "Циклова комісія ". $this->title);
        if (!is_null($employees)) {
            $startRow = 5;
            $current = $startRow;
            $i = 1;
            foreach ($employees as $employee) {
                $excelObj->getActiveSheet()->mergeCells("C" . $current . ":D" . $current);
                $excelObj->getActiveSheet()->mergeCells("E" . $current . ":I" . $current);

                $excelObj->getActiveSheet()->insertNewRowBefore($current + 1);
                $excelObj->getActiveSheet()->setCellValue('B' . $current, $i);
                $excelObj->getActiveSheet()->setCellValue('C' . $current, $employee->getPosition());
                $excelObj->getActiveSheet()->setCellValue('E' . $current, $employee->getFullName());
                $i++;
                $current++;
            }
            $excelObj->getActiveSheet()->removeRow($current);
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Cyclic_Commission_" . $this->title . "_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save('php://output');
    }


}
