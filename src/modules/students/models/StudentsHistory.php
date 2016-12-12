<?php

namespace app\modules\students\models;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%students_history}}".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $parent_id
 * @property string $date
 * @property integer $study_year_id
 * @property integer $action_type
 * @property integer $speciality_qualification_id
 * @property integer $payment_type
 * @property integer $group_id
 * @property integer $course
 * @property string $command
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property StudentsHistory $lastChild
 */
class StudentsHistory extends \yii\db\ActiveRecord
{
    public $category_id;
    public $group_search_id;
    public $child;

    public static $_HISTORY;
    public static $PAYMENT_STATE = 1;
    public static $PAYMENT_CONTRACT = 2;

    public static $TYPE_EXCLUDE = 1;
    public static $TYPE_INCLUDE = 2;
    public static $TYPE_TRANSFER_FOUNDING = 3;
    public static $TYPE_TRANSFER_SPECIALITY_QA = 4;
    public static $TYPE_RENEWAL = 5;
    public static $TYPE_TRANSFER_GROUP = 6;
    public static $TYPE_TRANSFER_COURSE = 7;


    public static $CATEGORY_NEW = 1;
    public static $CATEGORY_ACTIVE = 2;
    public static $CATEGORY_ALUMNUS = 3;
    /**
     * @author VasyaKog
     * Kosteli and velosupedu
     */
    public $data;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%students_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'speciality_qualification_id', 'action_type', 'group_id', 'payment_type', 'course', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['command'], 'string', 'max' => 128],
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
            'speciality_qualification_id' => Yii::t('app', 'Speciality Qualification ID'),
            'date' => Yii::t('app', 'Date'),
            'type' => Yii::t('app', 'Type'),
            'payment' => Yii::t('app', 'Funding'),
            'course' => Yii::t('app', 'Course'),
            'command' => Yii::t('app', 'Command'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    public static function getListTypes()
    {
        return [
            self::$TYPE_INCLUDE => Yii::t('app', 'Include'),
            self::$TYPE_EXCLUDE => Yii::t('app', 'Exclude'),
            self::$TYPE_TRANSFER_FOUNDING => Yii::t('app', 'Transfer founding'),
            self::$TYPE_TRANSFER_SPECIALITY_QA => Yii::t('app', 'Transfer speciality_qualification'),
            self::$TYPE_RENEWAL => Yii::t('app', 'Renewal'),
            self::$TYPE_TRANSFER_GROUP => Yii::t('app', 'Transfer group'),
        ];
    }

    public static function getPayments()
    {
        return [
            self::$PAYMENT_CONTRACT => Yii::t('app', 'Contract payment'),
            self::$PAYMENT_STATE => Yii::t('app', 'State payment'),
        ];
    }

    public static function getStudentCategoryList()
    {
        return [
            self::$CATEGORY_NEW => Yii::t('app', 'New'),
            self::$CATEGORY_ACTIVE => Yii::t('app', 'Active'),
            self::$CATEGORY_ALUMNUS => Yii::t('app', 'Alumnus'),
        ];
    }

    public static function getStudentHistory($id)
    {
        if (is_null(self::$_HISTORY[$id])) {
            $trees = [];
            $rows = StudentsHistory::findAll(['student_id' => $id, 'parent_id' => null]);
            foreach ($rows as $row) {
                $trees[] = $row->buildTree();
            }
            self::$_HISTORY[$id] = $trees;
        }
        return self::$_HISTORY[$id];
    }

    public static function getStudentHistoryArray($id)
    {
        $records = [];
        $rows = StudentsHistory::findAll(['student_id' => $id, 'parent_id' => null]);
        $i = 0;
        foreach ($rows as $row) {
            $next = $row;
            while (!is_null($next)) {
                $records[$i][] = $next;
                $next = self::find()->where(['parent_id' => $next->id]);
            }
            $i++;
        }
        return $records;
    }

    private function buildTree()
    {
        $child = self::findOne(['parent_id' => $this->id]);
        if (!is_null($child)) {
            $child->data = self::mergeHistoriesData($this->data, $child->data);
            $this->child = $child->buildTree();
        }
        return $this;
    }

    public
    static function getNewStudents()
    {
        $students = Student::find()->all();
        foreach ($students as $key => $student) {
            if (!empty(self::getParents($student->id))) unset($students[$key]);
        }
        return $students;
    }

    public
    static function getNewStudentList()
    {
        return ArrayHelper::map(self::getNewStudents(), 'id', 'fullName');
    }

    public
    static function getActiveStudentByGroup($id)
    {
        $students = Student::find()->all();
        /**
         * @var $students
         */
        foreach ($students as $key => $student) {
            if (!in_array($id, self::getGroupArray($student->id))) unset($students[$key]);
        }
        return $students;
    }

    public
    static function getActiveStudentByGroupList($id)
    {
        return ArrayHelper::map(self::getActiveStudentByGroup($id), 'id', 'fullNameAndCode');
    }

    /**
     * @param integer $student_id
     * @return StudentsHistory[]
     */
    public
    static function getParents($student_id)
    {
        $history = self::getStudentHistory($student_id);
        $parents = [];
        foreach ($history as $item) {
            $parents[] = self::getLastChild($item);
        }
        return $parents;
    }

    public static
    function getLastChild($story)
    {
        if (!is_null($story->child)) $story = self::getLastChild($story->child);
        return $story;
    }


    public
    function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        switch ($this->action_type) {
            case self::$TYPE_EXCLUDE : {
                $this->data['current'] = [
                    'speciality_qualification_id' => null,
                    'payment_type' => null,
                    'group_id' => null,
                    'course' => null,
                ];
                break;
            }
            case self::$TYPE_INCLUDE : {
                $this->data['current'] = [
                    'speciality_qualification_id' => $this->speciality_qualification_id,
                    'payment_type' => $this->payment_type,
                    'group_id' => $this->group_id,
                    'course' => $this->course,
                ];
                break;
            }
            case self::$TYPE_RENEWAL : {
                $this->data['current'] = [
                    'speciality_qualification_id' => $this->speciality_qualification_id,
                    'payment_type' => $this->payment_type,
                    'group_id' => $this->group_id,
                    'course' => $this->course,
                ];
                break;
            }
            case self::$TYPE_TRANSFER_COURSE : {
                $this->data['current'] = [
                    'course' => $this->course,
                ];
                break;
            }
            case self::$TYPE_TRANSFER_FOUNDING : {
                $this->data['current'] = [
                    'payment_type' => $this->payment_type,
                ];
                break;
            }
            case self::$TYPE_TRANSFER_GROUP : {
                $this->data['current'] = [
                    'group_id' => $this->group_id,
                ];
                break;
            }
            case self::$TYPE_TRANSFER_SPECIALITY_QA : {
                $this->data['current'] = [
                    'speciality_qualification_id' => $this->speciality_qualification_id,
                    'payment_type' => $this->payment_type,
                    'group_id' => $this->group_id,
                    'course' => $this->course,
                ];
                break;
            }
            default:
                break;
        }
    }

    /**
     * @param $id
     * @return array
     */
    public static function getGroupArray($id)
    {
        $array = [];
        foreach (self::getParents($id) as $item) {
            $array[] = $item->data['group_id'];
        }
        return $array;
    }

    public static function getAlumnusGroupArray($id)
    {
        $array = [];
        foreach (self::getParents($id) as $item) {
            if (!is_null($item->data['old']['group_id']))
                foreach ($item->data['old']['group_id'] as $id)
                    $array[] = $id;
        }
        return array_unique($array);
    }

    /**
     * @param $object1 StudentsHistory
     * @param $object2 StudentsHistory
     * @return StudentsHistory
     */
    public static function mergeHistoriesData($data1, $data2)
    {
        if (!is_null($data2['current'])) {
            foreach ($data2['current'] as $key => $value) {
                $data1['old'][$key][] = $data1['current'][$key];
                $data1['current'][$key] = $value;
            }
        } else {
            if (!is_null($data1['current'])) {
                foreach ($data1['current'] as $key => $value) {
                    $data1['old'][$key][] = $data1['current'][$key];
                    $data1['current'][$key] = null;
                }
            }
        }
        return $data1;
    }


    public static function getAlumnusStudentByGroup($id)
    {
        /**
         * @var $students Student[]
         */
        $students = Student::find()->all();

        foreach ($students as $key => $student) {
            if (!in_array($id, $student->getAlumnusGroupArray())) unset($students[$key]);
        }
        return $students;
    }

    public static function getAlumnusStudentByGroupList($id)
    {
        return ArrayHelper::map(self::getAlumnusStudentByGroup($id), 'id', 'fullNameAndCode');
    }

    public static function getStudentParents($id)
    {
        $data = [];
        $parents = self::getParents($id);
        if (!is_null($parents))
            foreach ($parents as $parent) {
                $data[] = ['id' => $parent->id, 'text' => $parent->getInformation()];
            }
        return $data;
    }

    public static function getStudentParentsList($id)
    {
        return ArrayHelper::map(self::getStudentParents($id), 'id', 'text');
    }

    public function getInformation()
    {
        $text = "";
        switch ($this->action_type) {
            case self::$TYPE_INCLUDE:
            case self::$TYPE_RENEWAL: {
                $text =
                    Yii::t('app', 'Group') . ":" .
                    Group::getTitleById($this->data['current']['group_id']) .
                    " " .
                    Yii::t('app', 'Payment') . ":" .
                    self::getPaymentTitleById($this->data['current']['payment_type']) .
                    " " .
                    Yii::t('app', 'Course') . ":" .
                    $this->data['current']['course'];
                break;
            }
            case self::$TYPE_EXCLUDE : {
                $text =
                    Yii::t('app', 'Excluded') .
                    " " .
                    Yii::t('app', 'Group') . ":" .
                    Group::getTitleById(array_pop($this->data['old']['group_id'])) .
                    " " .
                    Yii::t('app', 'Payment') . ":" .
                    self::getPaymentTitleById(array_pop($this->data['old']['payment_type'])) .
                    " " .
                    Yii::t('app', 'Course') . ":" .
                    array_pop($this->data['old']['course']);
                break;
            }
            case self::$TYPE_TRANSFER_GROUP : {
                $text =
                    Yii::t('app', 'Group') . ":" .
                    Group::getTitleById($this->data['current']['group_id']) .
                    " " .
                    Yii::t('app', 'Payment') . ":" .
                    self::getPaymentTitleById(array_pop($this->data['old']['payment_type'])) .
                    " " .
                    Yii::t('app', 'Course') . ":" .
                    array_pop($this->data['old']['course']);
                break;
            }
            case self::$TYPE_TRANSFER_COURSE : {
                $text =
                    Yii::t('app', 'Group') . ":" .
                    Group::getTitleById(array_pop($this->data['old']['group_id'])) .
                    " " .
                    Yii::t('app', 'Payment') . ":" .
                    self::getPaymentTitleById(array_pop($this->data['old']['payment_type'])) .
                    " " .
                    Yii::t('app', 'Course') . ":" .
                    array_pop($this->data['current']['course']);
                break;
            }
            case self::$TYPE_TRANSFER_FOUNDING : {
                $text =
                    Yii::t('app', 'Excluded') .
                    " " .
                    Yii::t('app', 'Group') . ":" .
                    Group::getTitleById(array_pop($this->data['old']['group_id'])) .
                    " " .
                    Yii::t('app', 'Payment') . ":" .
                    self::getPaymentTitleById($this->data['current']['payment_type']) .
                    " " .
                    Yii::t('app', 'Course') . ":" .
                    array_pop($this->data['old']['course']);
                break;
            }
            case self::$TYPE_TRANSFER_SPECIALITY_QA: {
                $text =
                    Yii::t('app', 'Group') . ":" .
                    Group::getTitleById($this->data['current']['group_id']) .
                    " " .
                    Yii::t('app', 'Payment') . ":" .
                    self::getPaymentTitleById($this->data['current']['payment_type']) .
                    " " .
                    Yii::t('app', 'Course') . ":" .
                    $this->data['current']['course'];
                break;
            }
        }
        return $text;
    }

    public static function getPaymentTitleById($id)
    {
        return self::getPayments()[$id];
    }

    public static function getPermittedActionList($action_type)
    {
        $array = [];
        switch ($action_type) {
            case self::$TYPE_INCLUDE:
            case self::$TYPE_RENEWAL:
            case self::$TYPE_TRANSFER_FOUNDING:
            case self::$TYPE_TRANSFER_GROUP:
            case self::$TYPE_TRANSFER_SPECIALITY_QA:
            case self::$TYPE_TRANSFER_COURSE: {
                $array = [
                    self::$TYPE_EXCLUDE => Yii::t('app', 'Exclude'),
                    self::$TYPE_TRANSFER_COURSE => Yii::t('app', 'Transfer course'),
                    self::$TYPE_TRANSFER_GROUP => Yii::t('app', 'Transfer group'),
                    self::$TYPE_TRANSFER_SPECIALITY_QA => Yii::t('app', 'Transfer speciality_qualification'),
                    self::$TYPE_TRANSFER_FOUNDING => Yii::t('app', 'Transfer payment'),
                ];
                break;
            }
            case self::$TYPE_EXCLUDE: {
                $array = [
                    self::$TYPE_RENEWAL => Yii::t('app', 'Renewal'),
                    self::$TYPE_INCLUDE => Yii::t('app', 'Include'),
                ];
                break;
            }
            case null: {
                $array = [
                    self::$TYPE_INCLUDE => Yii::t('app', 'Include'),
                ];
                break;
            }
        }
        return $array;
    }
}