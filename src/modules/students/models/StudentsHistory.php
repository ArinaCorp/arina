<?php

namespace app\modules\students\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
 * @property Student $student
 * @property StudentsHistory $lastChild
 */
class StudentsHistory extends ActiveRecord
{
    public $category_id;
    public $group_search_id;
    public $child;
    public $isAnalized = false;

    public static $_HISTORY;
    public static $PAYMENT_STATE = 1;
    public static $PAYMENT_CONTRACT = 2;

    //@TODO change to const

    public static $TYPE_EXCLUDE = 1;
    public static $TYPE_INCLUDE = 2;
    public static $TYPE_TRANSFER_FOUNDING = 3;
    public static $TYPE_TRANSFER_SPECIALITY_QA = 4;
    public static $TYPE_RENEWAL = 5;
    public static $TYPE_TRANSFER_GROUP = 6;
    public static $TYPE_TRANSFER_COURSE = 7;


    const CATEGORY_NEW = 1;
    const CATEGORY_ACTIVE = 2;
    const CATEGORY_ALUMNUS = 3;
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
            [['student_id', 'action_type', 'date', 'command'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'speciality_qualification_id' => Yii::t('app', 'Speciality Qualification ID'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'course' => Yii::t('app', 'Course'),
            'command' => Yii::t('app', 'Command'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'group_id' => Yii::t('app', 'Group ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'date' => Yii::t('app', 'Date'),
            'action_type' => Yii::t('app', 'Action type'),
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'group_search_id' => Yii::t('app', 'Group Search ID'),
            'information' => Yii::t('app', 'Information'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->date = date('Y-m-d', strtotime($this->date));
            return true;
        } else {
            return false;
        }
    }

    public static function getActionsTypes()
    {
        return [
            self::$TYPE_INCLUDE => Yii::t('app', 'Include'),
            self::$TYPE_EXCLUDE => Yii::t('app', 'Exclude'),
            self::$TYPE_TRANSFER_FOUNDING => Yii::t('app', 'Transfer payment'),
            self::$TYPE_TRANSFER_SPECIALITY_QA => Yii::t('app', 'Transfer speciality_qualification'),
            self::$TYPE_RENEWAL => Yii::t('app', 'Renewal'),
            self::$TYPE_TRANSFER_GROUP => Yii::t('app', 'Transfer group'),
            self::$TYPE_TRANSFER_COURSE => Yii::t('app', 'Transfer course'),
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
            self::CATEGORY_NEW => Yii::t('app', 'New'),
            self::CATEGORY_ACTIVE => Yii::t('app', 'Active'),
            self::CATEGORY_ALUMNUS => Yii::t('app', 'Alumnus'),
        ];
    }

    public static function getStudentHistory($id)
    {
        if (!isset(self::$_HISTORY[$id])) {
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

    /**
     * @param $current StudentsHistory
     * @return bool
     */
    public static function getFromHistory($current)
    {
        $history = self::getStudentHistory($current->student_id);
        foreach ($history as $trees) {
            while (!is_null($trees)) {
                if ($trees->id == $current->id) return $trees;
                $trees = $trees->child;
            }
        }

    }


    private
    function buildTree()
    {
        $child = self::findOne(['parent_id' => $this->id]);
        $this->isAnalized = true;
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
        /**
         * @var $students Student[]
         */
        if (is_null($id)) {
            return [];
        }
        $group = Group::findOne(['id' => $id]);
        return $group->getStudentsArray();
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

    public
    static
    function getLastChild($story)
    {
        if (!is_null($story->child)) $story = self::getLastChild($story->child);
        return $story;
    }


    public
    function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->date = date('d.m.Y', strtotime($this->date));
        switch ($this->action_type) {
            case self::$TYPE_EXCLUDE :
                {
                    $this->data['current'] = [
                        'speciality_qualification_id' => null,
                        'payment_type' => null,
                        'group_id' => null,
                        'course' => null,
                    ];
                    break;
                }
            case self::$TYPE_INCLUDE :
            case self::$TYPE_RENEWAL :
            case self::$TYPE_TRANSFER_SPECIALITY_QA :
                {
                    $this->data['current'] = [
                        'speciality_qualification_id' => $this->speciality_qualification_id,
                        'payment_type' => $this->payment_type,
                        'group_id' => $this->group_id,
                        'course' => $this->course,
                    ];
                    break;
                }
            case self::$TYPE_TRANSFER_COURSE :
                {
                    $this->data['current'] = [
                        'course' => $this->course,
                    ];
                    break;
                }
            case self::$TYPE_TRANSFER_FOUNDING :
                {
                    $this->data['current'] = [
                        'payment_type' => $this->payment_type,
                    ];
                    break;
                }
            case self::$TYPE_TRANSFER_GROUP :
                {
                    $this->data['current'] = [
                        'group_id' => $this->group_id,
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
            $array[$item->data['current']['group_id']] = $item->data['current']['payment_type'];
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

    public static function getInformationById($id)
    {
        $empty = StudentsHistory::findOne(['id' => $id]);
        $history = self::getFromHistory($empty);

    }

    public static function getStudentParentsList($id)
    {
        return ArrayHelper::map(self::getStudentParents($id), 'id', 'text');
    }

    public function getInformation()
    {
        $text = "";
        if (!$this->isAnalized)
            $current = self::getFromHistory($this);
        else
            $current = $this;
        switch ($current->action_type) {
            case self::$TYPE_INCLUDE:
            case self::$TYPE_RENEWAL:
                {
                    $text =
                        Yii::t('app', 'Group') . ":" .
                        Group::getTitleById($current->data['current']['group_id']) .
                        "<br/>" .
                        Yii::t('app', 'Payment') . ":" .
                        self::getPaymentTitleById($current->data['current']['payment_type']) .
                        "<br/>" .
                        Yii::t('app', 'Course') . ":" .
                        $current->data['current']['course'];
                    break;
                }
            case self::$TYPE_EXCLUDE :
                {
                    $text =
                        Yii::t('app', 'Excluded') .
                        "<br/>" .
                        Yii::t('app', 'Group') . ":" .
                        Group::getTitleById(array_pop($current->data['old']['group_id'])) .
                        "<br/>" .
                        Yii::t('app', 'Payment') . ":" .
                        self::getPaymentTitleById(array_pop($current->data['old']['payment_type'])) .
                        "<br/>" .
                        Yii::t('app', 'Course') . ":" .
                        array_pop($current->data['old']['course']);
                    break;
                }
            case self::$TYPE_TRANSFER_GROUP :
                {
                    $text =
                        Yii::t('app', 'Group') . ":" .
                        Group::getTitleById($current->data['current']['group_id']) .
                        "<br/>" .
                        Yii::t('app', 'Payment') . ":" .
                        self::getPaymentTitleById(array_pop($current->data['old']['payment_type'])) .
                        "<br/>" .
                        Yii::t('app', 'Course') . ":" .
                        array_pop($current->data['old']['course']);
                    break;
                }
            case self::$TYPE_TRANSFER_COURSE :
                {
                    $text =
                        Yii::t('app', 'Group') . ":" .
                        Group::getTitleById(array_pop($current->data['old']['group_id'])) .
                        "<br/>" .
                        Yii::t('app', 'Payment') . ":" .
                        self::getPaymentTitleById(array_pop($current->data['old']['payment_type'])) .
                        "<br/>" .
                        Yii::t('app', 'Course') . ":" .
                        array_pop($this->data['current']['course']);
                    break;
                }
            case self::$TYPE_TRANSFER_FOUNDING :
                {
                    $text =
                        Yii::t('app', 'Group') . ":" .
                        Group::getTitleById($current->data['current']['group_id']) .
                        "<br/>" .
                        Yii::t('app', 'Payment') . ":" .
                        self::getPaymentTitleById($current->data['current']['payment_type']) .
                        "<br/>" .
                        Yii::t('app', 'Course') . ":" .
                        $current->data['current']['course'];
                    break;
                }
            case self::$TYPE_TRANSFER_SPECIALITY_QA:
                {
                    $text =
                        Yii::t('app', 'Group') . ":" .
                        Group::getTitleById($current->data['current']['group_id']) .
                        "<br/>" .
                        Yii::t('app', 'Payment') . ":" .
                        self::getPaymentTitleById($current->data['current']['payment_type']) .
                        "<br/>" .
                        Yii::t('app', 'Course') . ":" .
                        $current->data['current']['course'];
                    break;
                }
        }
        return $text;
    }

    public static function getPaymentTitleById($id)
    {
        $arr = self::getPayments();
        return $arr[$id];
    }

    public static function getPermittedActionList($action_id)
    {
        $parent = self::findOne(['id' => $action_id]);
        $array = [];
        switch ($parent->action_type) {
            case self::$TYPE_INCLUDE:
            case self::$TYPE_RENEWAL:
            case self::$TYPE_TRANSFER_FOUNDING:
            case self::$TYPE_TRANSFER_GROUP:
            case self::$TYPE_TRANSFER_SPECIALITY_QA:
            case self::$TYPE_TRANSFER_COURSE:
                {
                    $array = [
                        self::$TYPE_EXCLUDE => Yii::t('app', 'Exclude'),
                        self::$TYPE_TRANSFER_COURSE => Yii::t('app', 'Transfer course'),
                        self::$TYPE_TRANSFER_GROUP => Yii::t('app', 'Transfer group'),
                        self::$TYPE_TRANSFER_SPECIALITY_QA => Yii::t('app', 'Transfer speciality_qualification'),
                        self::$TYPE_TRANSFER_FOUNDING => Yii::t('app', 'Transfer payment'),
                    ];
                    break;
                }
            case self::$TYPE_EXCLUDE:
                {
                    $array = [
                        self::$TYPE_RENEWAL => Yii::t('app', 'Renewal'),
                    ];
                    break;
                }
            case null:
                {
                    $array = [
                        self::$TYPE_INCLUDE => Yii::t('app', 'Include'),
                    ];
                    break;
                }
        }
        return $array;
    }

    public function getCurrentGroup()
    {
        $parents = self::getParents($this->student_id);
        foreach ($parents as $parent) {
            if ($parent->id == $this->id) {
                return Group::findOne(['id' => $parent->data['current']['group_id']]);
            }
        }
        return false;
    }

    /**
     * @param $id
     * @return bool|Group
     */
    public static function getCurrentGroupById($id)
    {

        return self::findOne(['id' => $id])->getCurrentGroup();
    }

    public function validateSpeciality($attribute, $params)
    {
        switch ($this->action_type) {
            case StudentsHistory::$TYPE_INCLUDE :
            case StudentsHistory::$TYPE_RENEWAL :
            case StudentsHistory::$TYPE_TRANSFER_SPECIALITY_QA :
                {
                    if (empty($this->$attribute)) {
                        $this->addError($attribute, Yii::t('app', 'This field is required'));
                        return false;
                    }
                    break;
                }
        }
        return true;
    }

    /**
     * @return ActiveQuery;
     */
    public static function find()
    {
        return parent::find()->alias('studentsHistory')->orderBy(['studentsHistory.id' => SORT_DESC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    /**
     * @param $groupIds
     * @return array
     */
    public static function getActiveStudentsIdsByGroups($groupIds)
    {
        return self::find()
            ->select('studentsHistory.student_id')
            ->andWhere(['studentsHistory.action_type' => StudentsHistory::$TYPE_INCLUDE])
            ->andWhere(['studentsHistory.group_id' => $groupIds])
            ->groupBy('studentsHistory.student_id')
            ->column();
    }

    /**
     * @return mixed
     */
    public function getStudentFullName()
    {
        return $this->student->getFullName();
    }
}