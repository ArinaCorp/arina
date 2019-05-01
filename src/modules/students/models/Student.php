<?php
/* @author VasyaKog */

namespace app\modules\students\models;

use nullref\useful\behaviors\RelatedBehavior;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $student_code
 * @property integer $sseed_id
 * @property integer $user_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property integer $gender
 * @property string $birth_day
 * @property string $passport_code
 * @property string $tax_id
 * @property string $birth_certificate
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $photo
 * @property string $passport_issued
 * @property string $passport_issued_date
 *
 *
 * @property string $fullName
 *
 * @property FamilyRelation[] $familyRelations
 * @property FamilyRelation[] $familyRelationsList
 * @property Exemption[] $exemptions
 * @property StudentsPhone[] $phones
 * @property StudentsPhone[] $phonesList
 * @property StudentsEmail[] $emails
 * @property StudentsEmail[] $emailsList
 * @property StudentSocialNetwork[] $socialNetworks
 * @property StudentSocialNetwork[] $socialNetworksList
 * @property Group[] $groups
 *
 * @property integer $course
 *
 *
 * @method loadWithRelations($data, $formName = null)
 * @method validateWithRelations()
 */
class Student extends \yii\db\ActiveRecord
{

    public $payment_type;
    public $has_characteristics;

    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::className(),
            'image_upload' => [
                'class' => '\yiidreamteam\upload\ImageUploadBehavior',
                'attribute' => 'photo',
                'thumbs' => [
                    'thumb' => ['width' => 300, 'height' => 400, 'quality' => 50],
                ],
                'filePath' => '@webroot/uploads/students/photo/[[model]]_[[pk]].[[extension]]',
                'fileUrl' => '/uploads/students/photo/[[model]]_[[pk]].[[extension]]',
                'thumbPath' => '@webroot/uploads/students/photo/[[model]]_[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '/uploads/students/photo/[[model]]_[[profile]]_[[pk]].[[extension]]',
            ],
            'linker' => [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'exemption_ids' => 'exemptions',
                ],
            ],

            'related' => [
                'class' => RelatedBehavior::className(),
                'mappedType' => RelatedBehavior::MAPPED_TYPE_PK_FIELD,
                'fields' => [
                    'familyRelations' => FamilyRelation::className(),
                    'phones' => StudentsPhone::className(),
                    'emails' => StudentsEmail::className(),
                    'socialNetworks' => StudentSocialNetwork::className(),
                ],
            ]
        ];

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sseed_id', 'user_id', 'gender', 'status', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'gender', 'country_id', 'region_id', 'district_id'], 'required'],
            [['birth_day', 'passport_issued_date'], 'safe'],
            [['exemption_ids'], 'each', 'rule' => ['integer']],
            [['student_code', 'passport_code', 'birth_certificate'], 'string', 'max' => 12],
            [['last_name', 'first_name', 'middle_name', 'passport_issued'], 'string', 'max' => 255],
            [['tax_id'], 'string', 'min' => 10, 'max' => 10],
            [['student_code'], 'unique'],
            [['sseed_id'], 'unique'],
            [['user_id'], 'unique'],
            [['passport_code'], 'unique'],
            [['tax_id'], 'unique'],
            ['photo', 'file', 'extensions' => 'jpeg, jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_code' => Yii::t('app', 'Student Code'),
            'sseed_id' => Yii::t('app', 'Sseed ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'last_name' => Yii::t('app', 'Last Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'country_id' => Yii::t('app', 'Country'),
            'region_id' => Yii::t('app', 'Region'),
            'district_id' => Yii::t('app', 'District'),
            'gender' => Yii::t('app', 'Gender'),
            'birth_day' => Yii::t('app', 'Birth Day'),
            'passport_code' => Yii::t('app', 'Passport Code'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'paymentTypeLabel' => Yii::t('app', 'Payment Type'),
            'tax_id' => Yii::t('app', 'Tax Code'),
            'status' => Yii::t('app', 'Status'),
            'birth_certificate' => Yii::t('app', 'Birth Certificate'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'passport_issued' => Yii::t('app', 'Passport issued'),
            'photo' => Yii::t('app', 'Photo'),
            'passport_issued_date' => Yii::t('app', 'Passport issued date'),
            'exemptions' => Yii::t('app', 'Exemptions'),
            'exemption_ids' => Yii::t('app', 'Exemptions'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->birth_day = date('Y-m-d', strtotime($this->birth_day));
            if (is_null(!$this->passport_issued_date)) {
                $this->passport_issued_date = date('Y-m-d', strtotime($this->passport_issued_date));
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->birth_day = date('d.m.Y', strtotime($this->birth_day));
        if (!is_null($this->passport_issued_date)) {
            $this->passport_issued_date = date('d.m.Y', strtotime($this->passport_issued_date));
        }
    }

    public function getGenderName()
    {
        return $this->gender ? Yii::t('app', 'Female') : Yii::t('app', 'Male');
    }

    public function getFullNameAndCode()
    {
        return $this->getFullName() . ' ' . $this->student_code;
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

    public function getShortName()
    {
        return $this->last_name . ' ' . mb_substr($this->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->middle_name, 0, 1, 'UTF-8') . '.';
    }

    public function getShortNameInitialFirst()
    {
        return mb_substr($this->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->middle_name, 0, 1, 'UTF-8') . '.' . ' ' . $this->last_name;
    }

    public function getFullNameAndBirthDate()
    {
        return $this->fullName . " " . $this->birth_day;
    }

    public function getLink()
    {
        return Html::a($this->getFullName(), ['/students/default/view', 'id' => $this->id], ['target' => '_blank']);
    }

    public function getPhoto()
    {
        if (!is_null($this->getImageFileUrl('photo'))) {
            return Html::img($this->getImageFileUrl('photo'), ['height' => 200, 'width' => 150]);
        }
        return Yii::t('app', 'Image not set');
    }

    public function getPaymentTypeLabel()
    {
        return mb_substr(StudentsHistory::getPayments()[$this->payment_type], 0, 1, 'UTF-8');
    }

    /**
     * @param $file
     *
     * @TODO move to component
     */
    public static function importXml($file)
    {
        /**
         * @var $xml \SimpleXMLElement
         * @var file File;
         */

        $xmlFile = UploadedFile::getInstance($file, 'file');

        $xml = simplexml_load_file($xmlFile->tempName);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        $i = 0;
        foreach ($array['student'] as $item) {
            $student = self::findOne(['sseed_id' => $item['edbo_education_id']]);

            if (is_null($student)) {
                $student = new Student();
            }
            if (!is_null($item['last_name']['@attributes']['uk'])) $student->last_name = $item['last_name']['@attributes']['uk'];
            if (!is_null($item['first_name']['@attributes']['uk'])) $student->first_name = $item['first_name']['@attributes']['uk'];
            if (!is_null($item['middle_name']['@attributes']['uk'])) $student->middle_name = $item['middle_name']['@attributes']['uk'];
            if (!is_null($item['birthday'])) $student->birth_day = $item['birthday'];
            if (!is_null($item['sex'])) $student->gender = $item['sex'];
            if (!is_null($item['ipn'])) $student->tax_id = $item['ipn'];
            if (!is_null($item['person_document']['@attributes']['ID'])) if ($item['person_document']['@attributes']['ID'] == '1') {
                if (!is_null($item['person_document']['@attributes']['seria'])) $student->passport_code = $item['person_document']['@attributes']['seria'] . ' №' . $item['person_document']['@attributes']['number'];
                if (!is_null($item['person_document']['@attributes']['issued_by'])) $student->passport_issued = $item['person_document']['@attributes']['issued_by'];
                if (!is_null($item['person_document']['@attributes']['issued_date'])) $student->passport_issued_date = $item['person_document']['@attributes']['issued_date'];
            } else {
                $student->birth_certificate = $item['person_document']['@attributes']['seria'] . ' №' . $item['person_document']['@attributes']['number'];
            }
            if (!is_null($item['edbo_education_id'])) $student->sseed_id = $item['edbo_education_id'];
            if (!is_null($item['photo'])) $student->photo = $item['photo'];
            $student->save();
            if (!is_null($item['last_name']['@attributes']['uk'])) {
                $path = __DIR__ . "/../../../../web/uploads/students/photo/";
                copy($_FILES['File']['tmp_name']['photos'][$i], $path . 'student_' . $student->id . '.jpeg');
            }
            $i++;
        }
    }

    /**
     * @param $file
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     *
     * @TODO move to component
     */
    public static function importExcel($file)
    {
        $excelFile = UploadedFile::getInstance($file, 'file');
        $objPHPExcel = \PHPExcel_IOFactory::load($excelFile->tempName);
        $i = 2;
        while ($objPHPExcel->getActiveSheet()->getCell('A' . $i) != "") {
            $student = new Student();
            $student->last_name = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getValue();
            $student->first_name = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getValue();
            $student->middle_name = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getValue();
            $student->gender = mb_substr($student->middle_name, mb_strlen($student->middle_name, 'UTF-8') - 1, 1, 'UTF-8') == 'ч' ? 0 : 1;
            $student->birth_day = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getValue();
            if ($student->save()) {
                $group = Group::findOne(['title' => $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getValue()]);
                if ($group) {
                    $history = new StudentsHistory();
                    $history->student_id = $student->id;
                    $history->speciality_qualification_id = $group->speciality_qualifications_id;
                    $history->date = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getValue();
                    $history->action_type = StudentsHistory::$TYPE_INCLUDE;
                    $history->command = "Imported";
                    $history->course = round($objPHPExcel->getActiveSheet()->getCell('E' . $i)->getValue(), 0, PHP_ROUND_HALF_UP);
                    $history->payment_type = ($objPHPExcel->getActiveSheet()->getCell('F' . $i)->getValue() == "Контракт") ? StudentsHistory::$PAYMENT_CONTRACT : StudentsHistory::$PAYMENT_STATE;
                    $history->group_id = $group->id;
                    $history->date;
                    $history->save();
                }
            }
            $i++;
        }
    }

    public function getGroupLinksList()
    {
        $groups = $this->groups;
        if (empty($groups)) return Yii::t('app', 'This student has not group');
        $links = "";
        foreach ($groups as $item) {
            if ($links != "") $links .= "<br/>";
            $links .= Html::a($item->title . " " . StudentsHistory::getPaymentTitleById($this->getGroupArray()[$item->id]), ['/students/group/view', 'id' => $item->id]);
        }
        return $links;

    }

    /**
     * @return ActiveQuery
     */
    public function getStudentsHistory()
    {
        return $this->hasMany(StudentsHistory::class, ['student_id' => 'id']);
    }

    public function getFamilyRelations()
    {
        return $this->hasMany(FamilyRelation::className(), ['student_id' => 'id']);
    }

    public function getPhones()
    {
        return $this->hasMany(StudentsPhone::className(), ['student_id' => 'id']);
    }

    public function getSocialNetworks()
    {
        return $this->hasMany(StudentSocialNetwork::className(), ['student_id' => 'id']);
    }

    public function getEmails()
    {
        return $this->hasMany(StudentsEmail::className(), ['student_id' => 'id']);
    }

    public function getGroupArray()
    {
        return StudentsHistory::getGroupArray($this->id);
    }

    public function getAlumnusGroupArray()
    {
        return StudentsHistory::getAlumnusGroupArray($this->id);
    }


    /**
     * @return \app\modules\directories\models\department\Department[]|\app\modules\directories\models\speciality_qualification\SpecialityQualification[]|\app\modules\directories\models\StudyYear[]|\app\modules\plans\models\StudyPlan[]|\app\modules\plans\models\WorkPlan[]|CuratorGroup[]|Group[]|Student[]|array|\yii\db\ActiveRecord[]
     */
    public function getGroups()
    {
        return Group::find()->where(['id' => array_keys($this->getGroupArray())])->all();
    }

    public function getAlumnusGroup()
    {
        return Group::find()->where(['id' => $this->getAlumnusGroupArray()])->all();
    }

    public function getExemptions()
    {
        return $this->hasMany(Exemption::className(), ['id' => 'exemption_id'])->viaTable('{{%exemptions_students_relations}}', ['student_id' => 'id']);
    }

    public static function getList()
    {
        $models = self::find()->all();
        return ArrayHelper::map($models, 'id', 'fullNameAndCode');
    }

    /**
     * @param string $modelClass
     * @param array $multipleModels
     * @param string $pk
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [], $pk = 'id')
    {
        /** @var Model $model */
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

        unset($model, $formName, $post);

        return $models;
    }

    public function getCourse()
    {
        return $this->getGroups()[0]->getCourse();
    }


    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find()->orderBy(['last_name' => SORT_ASC, 'first_name' => SORT_ASC, 'middle_name' => SORT_ASC]);
    }

    public function _save($runValidation = true, $attributeNames = null, $withAllParams = true)
    {
        $saved = parent::save($runValidation, $attributeNames);
        if ($saved && $withAllParams) {
            FamilyRelation::saveSt($this->id, $this);
            StudentsPhone::saveSt($this->id, $this);
            StudentsEmail::saveSt($this->id, $this);
            StudentSocialNetwork::saveSt($this->id, $this);
        }
        return $saved;
    }
}

