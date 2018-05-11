<?php

namespace app\modules\employee\models;

use app\modules\directories\models\position\Position;
use app\modules\employee\models\cyclic_commission\CyclicCommission;
use app\modules\students\models\CuratorGroup;
use app\modules\students\models\Group;
use nullref\useful\behaviors\RelatedBehavior;
use nullref\useful\traits\Mappable;
use PHPExcel_IOFactory;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "employee".
 * @property integer $id
 * @property integer $is_in_education
 * @property integer $position_id
 * @property integer $category_id
 * @property integer $type
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $gender
 * @property integer $cyclic_commission_id
 * @property string $birth_date
 * @property string $passport
 * @property string $passport_issued_by
 * @property string $passport_issued_date
 * @property string $start_date
 *
 * @property EmployeeEducation[] $education
 * @property EmployeeEducation[] $employeeEducationList
 */
class Employee extends ActiveRecord
{
    use Mappable;

    public $data;
    public $has_education;


    public function behaviors()
    {
        return [
            'related' => [
                'class' => RelatedBehavior::class,
                'mappedType' => RelatedBehavior::MAPPED_TYPE_PK_FIELD,
                'fields' => [
                    'employeeEducation' => EmployeeEducation::className(),
                ],
            ]
        ];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['id', 'position_id', 'category_id', 'is_in_education', 'gender', 'type', 'cyclic_commission_id'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'position_id', 'is_in_education',
                'gender', 'passport', 'birth_date', 'passport_issued_by', 'start_date', 'passport_issued_date', 'category_id'], 'required'],
            [['birth_date','cyclic_commission_id', 'passport', 'passport_issued_by'], 'safe'],
            [['passport', 'id'], 'unique'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'is_in_education' => Yii::t('app', 'Do teach?'),
            'position_id' => Yii::t('app', 'Position'),
            'category_id' => Yii::t('app', 'Category'),
            'type' => Yii::t('app', 'Type'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'cyclic_commission_id' => Yii::t('app', 'Cyclic commission'),
            'birth_date' => Yii::t('app', 'Birth Day'),
            'passport' => Yii::t('app', 'Passport Code'),
            'passport_issued_by' => Yii::t('app', 'Passport issued'),
            'passport_issued_date' => Yii::t('app', 'Passport issued date'),
            'start_date' => Yii::t('app', 'Start date'),
            'fullName' => Yii::t('app', 'Full Name'),
        ];
    }

    public function getFullName()
    {
        return trim("$this->last_name $this->first_name $this->middle_name");
    }

    public function getNameWithInitials()
    {
        $firstNameInitial = mb_substr($this->first_name, 0, 1, 'UTF-8');
        $middleNameInitial = mb_substr($this->middle_name, 0, 1, 'UTF-8');
        return trim("$this->last_name {$firstNameInitial}. {$middleNameInitial}.");
    }

    public function getShortName()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function getShortNameInitialFirst()
    {
        return mb_substr($this->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->middle_name, 0, 1, 'UTF-8') . '.' . ' '.$this->last_name;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getGenderName()
    {
        return $this->gender ? Yii::t('app', 'Female') : Yii::t('app', 'Male');
    }

    public function getIsInEducationName()
    {
        return $this->is_in_education ? Yii::t('app', 'Take part in education') : Yii::t('app', 'Not take part in education');
    }

    public static function getAllTeacher()
    {
        $query = self::find();
        $query->andWhere(['is_in_education' => 1]);
        $query->addOrderBy(['first_name' => SORT_ASC, 'middle_name' => SORT_ASC, 'last_name' => SORT_ASC]);
        return $query->all();
    }

    public static function getList()
    {
        $query = self::find();
        $query->addOrderBy(['first_name' => SORT_ASC, 'middle_name' => SORT_ASC, 'last_name' => SORT_ASC]);
        return $query->all();
    }

    public function getCyclicCommissionArray()
    {
        return CyclicCommission::getCyclicCommissionArray();
    }

    public function getEducation()
    {
        return $this->hasMany(EmployeeEducation::className(), ['employee_id' => 'id']);
    }

    public static function createMultiple($modelClass, $multipleModels = [], $pk = 'id')
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, $pk, $pk));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item[$pk]) && !empty($item[$pk]) && isset($multipleModels[$item[$pk]])) {
                    $models[] = $multipleModels[$item[$pk]];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }
    }

    public function getPosition()
    {
        return Position::findOne(['id' => $this->position_id])->title;
    }

    public  function getCyclicCommissionTitle()
    {
        $cyclicCommission = CyclicCommission::findOne(['id' => $this->cyclic_commission_id]);
        if ($cyclicCommission) {
            return $cyclicCommission->title;
        }
        return null;
    }

    public static function getAllTeacherList()
    {
        return ArrayHelper::map(self::getAllTeacher(), 'id', 'fullName', 'cyclic_commission_id');
    }

    public function getGroupArray()
    {
        /**
         * @var $listRecord CuratorGroup[];
         */
        $listRecord = CuratorGroup::find()->andWhere(['teacher_id' => $this->id])->orderBy('id ASC')->all();
        $listGroup = [];
        foreach ($listRecord as $item) {
            switch ($item->type) {
                case 1: {
                    array_push($listGroup, $item->group_id);
                    break;
                }
                case 2: {
                    if (($key = array_search($item->group_id, $listGroup)) !== false) {
                        unset($listGroup[$key]);
                    }

                }
            }
        }
        return $listGroup;
    }

    public function getGroups()
    {
        return Group::find()->where(['id' => $this->getGroupArray()])->all();
    }

    public function getLink()
    {
        return Html::a($this->getFullName(), Url::to(['/employee/default/view', 'id' => $this->id]));
    }

    /**
     * @TODO move to component
     *
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public static function getDocument()
    {
        $tmpfname = Yii::getAlias('@webroot') . "/templates/employee.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $excelObj = $excelReader->load($tmpfname);
        $excelObj->setActiveSheetIndex(0);

        /**
         * @var Employee[] $employees
         */
        $employees = Employee::getList();
        if (!is_null($employees)) {
            $startRow = 5;
            $current = $startRow;
            $i = 1;
            foreach ($employees as $employee) {
                $excelObj->getActiveSheet()->mergeCells("C" . $current . ":D" . $current);
                $excelObj->getActiveSheet()->mergeCells("E" . $current . ":I" . $current);
                $excelObj->getActiveSheet()->mergeCells("J" . $current . ":L" . $current);
                $excelObj->getActiveSheet()->mergeCells("M" . $current . ":O" . $current);

                $excelObj->getActiveSheet()->insertNewRowBefore($current + 1);
                $excelObj->getActiveSheet()->setCellValue('B' . $current, $i);
                $excelObj->getActiveSheet()->setCellValue('C' . $current, $employee->getPosition());
                $excelObj->getActiveSheet()->setCellValue('E' . $current, $employee->getFullName());
                $excelObj->getActiveSheet()->setCellValue('J' . $current, $employee->getCyclicCommissionTitle());
                $excelObj->getActiveSheet()->setCellValue('M' . $current, $employee->getStartDate());
                $i++;
                $current++;
            }
            $excelObj->getActiveSheet()->removeRow($current);
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Employee_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save('php://output');
        exit();
    }

    public function getEmployeeEducation()
    {
        return $this->hasMany(EmployeeEducation::className(),['employee_id'=>'id']);
    }
}
