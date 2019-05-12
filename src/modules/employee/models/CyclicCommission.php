<?php

namespace app\modules\employee\models;

use nullref\useful\traits\Mappable;
use PHPExcel_IOFactory;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cyclic_commission".
 *
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 * @property Employee $head
 * @property string $short_title
 */
class CyclicCommission extends ActiveRecord
{
    use Mappable;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%cyclic_commission}}';
    }

    /**
     * @param $commissionId
     * @return Employee[]|array
     */
    public static function getEmployeeByCyclicCommissionMap($commissionId)
    {
        return Employee::getMap('nameWithInitials', 'id', ['cyclic_commission_id' => $commissionId], false);
    }

    /**
     * @return string
     */
    public function getHeadName()
    {
        if (isset($this->head)) {
            return $this->head->getFullName();
        }
        return Yii::t('base', 'Not selected');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['title', 'short_title'], 'required'],
            [['head_id'], 'required', 'on' => 'update'],
            [['head_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id', 'title', 'head_id'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['cyclic_commission_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkSubjects()
    {
        return $this->hasMany(WorkSubject::class, ['cyclic_commission_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(Employee::class, ['id' => 'head_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('terms', 'Title'),
            'short_title' => Yii::t('terms', 'Short Title'),
            'head_id' => Yii::t('terms', 'Head'),
            'employees' => Yii::t('terms', 'Employees'),
        ];
    }

    /**
     * @TODO move it
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function getDocument()
    {
        $tmpfname = Yii::getAlias('@webroot') . "/templates/cyclic_commission.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $excelObj = $excelReader->load($tmpfname);
        $excelObj->setActiveSheetIndex(0);

        /**
         * @var Employee[] $employees
         */
        $employees = Employee::getAllTeacher($this->id);
        $excelObj->getActiveSheet()->SetCellValue('B2', "Циклова комісія " . $this->title);
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
