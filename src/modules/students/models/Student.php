<?php
/* @author VasyaKog */

namespace app\modules\students\models;

use app\modules\directories\models\department\Department;
use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\geo\models\City;
use app\modules\geo\models\Country;
use app\modules\geo\models\Region;
use nullref\useful\behaviors\RelatedBehavior;
use voskobovich\linker\LinkerBehavior;
use Yii;
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
 * @property string $country_id
 * @property string $region_id
 * @property integer $city_id
 * @property string $address
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
 * @property SpecialityQualification $specialityQualification
 * @property Speciality $speciality
 * @property Department $department
 *
 * @property Country $country
 * @property Region $region
 * @property City $city
 *
 * @property FamilyRelation $mother
 * @property FamilyRelation $father
 * @property FamilyRelation $spouse
 *
 * @property string $familyStatus
 * @property string $fullAddress
 * @property string $fullPhoneString
 * @property string $livingAddress
 *
 * @property string $finished_inst
 * @property string $finished_year
 * @property string $finishedInstitution
 *
 * @property string $fullExemptionString
 * @property bool $withoutCompetition
 *
 * @property StudentsHistory[] $edicts
 * @property StudentsHistory $enrollmentEdict
 * @property Group $currentGroup
 * @property Group $firstGroup
 *
 * @method loadWithRelations($data, $formName = null)
 * @method validateWithRelations()
 */
class Student extends \yii\db\ActiveRecord
{
    public $payment_type;
    public $has_characteristics;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * @param $file
     *
     * @TODO move to component
     * @TODO check if it used
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
     * @TODO check if it used
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

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find()->orderBy(['last_name' => SORT_ASC, 'first_name' => SORT_ASC, 'middle_name' => SORT_ASC]);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
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
                'class' => LinkerBehavior::class,
                'relations' => [
                    'exemption_ids' => 'exemptions',
                ],
            ],

            'related' => [
                'class' => RelatedBehavior::class,
                'mappedType' => RelatedBehavior::MAPPED_TYPE_PK_FIELD,
                'fields' => [
                    'familyRelations' => FamilyRelation::class,
                    'phones' => StudentsPhone::class,
                    'emails' => StudentsEmail::class,
                    'socialNetworks' => StudentSocialNetwork::class,
                ],
            ]
        ];

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sseed_id', 'user_id', 'gender', 'status', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'gender'], 'required'],
//            [['last_name', 'first_name', 'middle_name', 'gender', 'country_id', 'region_id', 'district_id'], 'required'],
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
            [['country_id', 'region_id', 'address'], 'string'],
            [['city_id'], 'integer'],
            [['finished_inst'], 'string'],
            [['finished_year'], 'integer'],
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
            'city_id' => Yii::t('app', 'City ID'),
            'address' => Yii::t('app', 'Address'),
            'fullAddress' => Yii::t('app', 'Full address'),
            'finished_inst' => Yii::t('app', 'Finished'),
            'finished_year' => Yii::t('app', 'Input year'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->birth_day = date('Y-m-d', strtotime($this->birth_day));
            if (!is_null($this->passport_issued_date)) {
                $this->passport_issued_date = date('Y-m-d', strtotime($this->passport_issued_date));
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     *
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->birth_day = date('d.m.Y', strtotime($this->birth_day));
        if (!is_null($this->passport_issued_date)) {
            $this->passport_issued_date = date('d.m.Y', strtotime($this->passport_issued_date));
        }
    }

    /**
     * @return string
     */
    public function getGenderName()
    {
        return $this->gender ? Yii::t('app', 'Female') : Yii::t('app', 'Male');
    }

    /**
     * @return string
     */
    public function getFullNameAndCode()
    {
        return $this->getFullName() . ' ' . $this->student_code;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->last_name . ' ' . mb_substr($this->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->middle_name, 0, 1, 'UTF-8') . '.';
    }

    /**
     * @return string
     */
    public function getShortNameInitialFirst()
    {
        return mb_substr($this->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->middle_name, 0, 1, 'UTF-8') . '.' . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getFullNameAndBirthDate()
    {
        return $this->fullName . " " . $this->birth_day;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return Html::a($this->getFullName(), ['/students/default/view', 'id' => $this->id], ['target' => '_blank']);
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        if (!is_null($this->getImageFileUrl('photo'))) {
            return Html::img($this->getImageFileUrl('photo'), ['height' => 200, 'width' => 150]);
        }
        return Yii::t('app', 'Image not set');
    }

    /**
     * @return string
     */
    public function getPaymentTypeLabel()
    {
        return mb_substr(StudentsHistory::getPayments()[$this->payment_type], 0, 1, 'UTF-8');
    }

    /**
     * @return string
     */
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
     * @return array
     */
    public static function getList()
    {
        $models = self::find()->all();
        return ArrayHelper::map($models, 'id', 'fullNameAndCode');
    }

    /**
     * @return array
     */
    public function getGroupArray()
    {
        return StudentsHistory::getGroupArray($this->id);
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
        return $this->hasMany(FamilyRelation::class, ['student_id' => 'id']);
    }

    public function getPhones()
    {
        return $this->hasMany(StudentsPhone::class, ['student_id' => 'id']);
    }

    public function getSocialNetworks()
    {
        return $this->hasMany(StudentSocialNetwork::class, ['student_id' => 'id']);
    }

    public function getEmails()
    {
        return $this->hasMany(StudentsEmail::class, ['student_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getGroups()
    {
        return Group::find()->where(['id' => array_keys($this->getGroupArray())])->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAlumnusGroup()
    {
        return Group::find()->where(['id' => $this->getAlumnusGroupArray()])->all();
    }

    /**
     * @return array
     */
    public function getAlumnusGroupArray()
    {
        return StudentsHistory::getAlumnusGroupArray($this->id);
    }

    /**
     * @return ActiveQuery
     */
    public function getExemptions()
    {
        return $this->hasMany(Exemption::class, ['id' => 'exemption_id'])->viaTable('{{%exemptions_students_relations}}', ['student_id' => 'id']);
    }

    /**
     * @return integer
     */
    public function getCourse()
    {
        return $this->getGroups()[0]->getCourse();
    }

    /**
     * @return SpecialityQualification
     */
    public function getSpecialityQualification()
    {
        //TODO: Implement a proper "Get current group method"
        return $this->groups[count($this->groups) - 1]->specialityQualification;
    }

    /**
     * @return Speciality
     */
    public function getSpeciality()
    {
        return $this->specialityQualification->speciality;
    }

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->speciality->department;
    }


    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['code' => 'country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['country_code' => 'country_id', 'division_code' => 'region_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['geoname_id' => 'city_id']);
    }

    /**
     * @return string
     */
    public function getFullAddress()
    {
        return implode(', ', [$this->country->name, $this->region->name, $this->city->name, $this->address]);
    }

    /**
     * Returns all phones(relatives, etc.) in a string imploded with commas.
     * @param null $lang
     * @return string
     */
    public function getFullPhoneString($lang = null)
    {
        $motherPhone = $this->mother ? Yii::t('app', 'mothers tel. {phone}', ['phone' => $this->mother->phone1], $lang) : '';
        $fatherPhone = $this->father ? Yii::t('app', 'fathers tel. {phone}', ['phone' => $this->father->phone1], $lang) : '';
        $studentPhone = (count($this->phones) > 0) ? Yii::t('app', 'students tel. {phone}', ['phone' => $this->phones[0]->number], $lang) : '';
        return implode(', ', array_filter([$motherPhone, $fatherPhone, $studentPhone], function ($value) {
            return !empty($value);
        }));
    }

    /**
     * Returns full address and all phones.
     * @param null $lang
     * @return string
     */
    public function getLivingAddress($lang = null)
    {
        return $this->getFullAddress() . ', ' . $this->getFullPhoneString($lang);
    }

    /**
     * @param null $lang
     * @return string
     */
    public function getFamilyStatus($lang = null)
    {
        if ($this->gender) {
            return $this->spouse ? Yii::t('app', 'Married (f)', [], $lang) : Yii::t('app', 'Unmarried (f)', [], $lang);
        } else {
            return $this->spouse ? Yii::t('app', 'Married (m)', [], $lang) : Yii::t('app', 'Unmarried (m)', [], $lang);
        }
    }

    /**
     * @return Student|array|\yii\db\ActiveRecord|null
     */
    public function getMother()
    {
        return $this->getFamilyRelations()->where(['type_id' => FamilyRelation::TYPE_MOTHER])->one();
    }

    /**
     * @return Student|array|\yii\db\ActiveRecord|null
     */
    public function getFather()
    {
        return $this->getFamilyRelations()->where(['type_id' => FamilyRelation::TYPE_FATHER])->one();
    }

    /**
     * @return Student|array|\yii\db\ActiveRecord|null
     */
    public function getSpouse()
    {
        return $this->getFamilyRelations()->where(['type_id' => FamilyRelation::TYPE_SPOUSE])->one();
    }

    /**
     * @param null $lang
     * @return string
     */
    public function getFinishedInstitution($lang = null)
    {
        return Yii::t('app', '{something} in {year} year', ['something' => $this->finished_inst, 'year' => $this->finished_year], $lang);
    }

    /**
     * String with all exemptions imploded with comas.
     * @return string
     */
    public function getFullExemptionString()
    {
        return implode(', ', ArrayHelper::getColumn($this->exemptions, 'title'));
    }

    /**
     * Returns the first edict(StudentsHistory record) which enrolled the student to the college
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getEnrollmentEdict()
    {
        return $this->getStudentsHistory()->where(['action_type' => StudentsHistory::$TYPE_INCLUDE])->orderBy(['date' => SORT_ASC])->one();
    }

    /**
     * TODO: Might want to review StudentsHistory implementation and this method in general
     * @return Group|null
     */
    public function getCurrentGroup()
    {
        $lastHistoryRecord = StudentsHistory::find()->where(['student_id' => $this->id])->orderBy(['date' => SORT_DESC])->one();
        return Group::findOne($lastHistoryRecord->group);
    }

    /**
     * First group (enrollment group) of a student.
     * @return Group
     */
    public function getFirstGroup()
    {
        return $this->enrollmentEdict->group;
    }

    /**
     * Check if student has any of defined exemptions, if so - he enrolls without competition.
     * @return bool
     */
    public function getWithoutCompetition()
    {
        return $this->getExemptions()->where(['id' => [
                Exemption::TYPE_ORPHAN,
                Exemption::TYPE_DISABLED_GROUP_2,
                Exemption::TYPE_DISABLED_GROUP_3,
                Exemption::TYPE_ATO
            ]])->count() > 0;
    }

    /**
     * All StudentsHistory records with ascending sorting by date (the newest are in the end).
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getEdicts()
    {
        return $this->getStudentsHistory()->orderBy(['date' => SORT_ASC])->all();
    }

}

