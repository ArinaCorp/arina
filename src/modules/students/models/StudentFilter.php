<?php
/**
 * Created by IntelliJ IDEA.
 * User: vladi
 * Date: 24.03.2019
 * Time: 17:31
 */

namespace app\modules\students\models;


use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use yii\helpers\ArrayHelper;

class StudentFilter
{
    public static function getSpecialitiesByDepartmentId($dep_id)
    {
        $specialities_query = Speciality::findAll(['department_id' => $dep_id]);
        $specialities = [];
        foreach ($specialities_query as $speciality) {
            array_push($specialities, $speciality);
        }
        return ArrayHelper::map($specialities, 'id', 'title');
    }

    public static function getGroupsListBySpecialityId($spec_id, $dep_id)
    {
        if ($dep_id != null) {
            $specialities_query = Speciality::find()->andWhere(['id' => $spec_id])->andWhere(['department_id' => $dep_id])->all();
        } else {
            $specialities_query = Speciality::find()->andWhere(['id' => $spec_id])->all();
        }
        $specIds = [];
        foreach ($specialities_query as $query) {
            array_push($specIds, $query['id']);
        }
        $groups = [];
        foreach ($specIds as $specId) {
            $specialityQualifications = SpecialityQualification::findAll(["speciality_id" => $specId]);
            foreach ($specialityQualifications as $specialityQualification) {
                $group = Group::findAll(["speciality_qualifications_id" => $specialityQualification['id']]);
                foreach ($group as $item) {
                    if (!in_array($item, $groups, true)) {
                        array_push($groups, $item);
                    }
                }
            }
        }
        return ArrayHelper::map($groups, 'id', 'title');
    }
    public static function getStudentIdsBySpecialityId($spec_id)
    {
        $specialityQualifications = SpecialityQualification::findAll(["speciality_id" => $spec_id]);
        $student_ids = [];
        foreach ($specialityQualifications as $specialityQualification) {
            $groups = Group::findAll(["speciality_qualifications_id" => $specialityQualification['id']]);
            foreach ($groups as $group) {
                $ids = $group->getStudentsIds();
                foreach ($ids as $student_id)
                    if (!in_array($student_id, $student_ids, true)) {
                        array_push($student_ids, $student_id);
                    }
            }
        }
        return $student_ids;
    }
    public static function getStudentIdsByDepartmentId($dep_id)
    {
        $specialities = Speciality::findAll(['department_id' => $dep_id]);
        $ids = [];
        foreach ($specialities as $speciality) {
            $spec_id = $speciality['id'];
            foreach (self::getStudentIdsBySpecialityId($spec_id) as $id) {
                array_push($ids, $id);
            }
        }
        return $ids;
    }
    public static function getStudentsByExemptionArray($array = [])
    {
        if (empty($array)) return [];

        $students = [];
        foreach ($array as $item) {
            $student = ExemptionStudentRelation::find()->select("student_id")->where(['exemption_id' => $item])->column();
            if (!empty($student)) {
                foreach ($student as $stud) {
                    array_push($students, $stud);
                }
            }
        }
        return $students;
    }
    public static function getStateStudentIds()
    {
        $students = StudentsHistory::findAll(['payment_type' => StudentsHistory::$PAYMENT_STATE]);
        $ids = [];
        foreach ($students as $student) {
            array_push($ids, $student["student_id"]);
        }
        return $ids;
    }

    public static function getAllAlumnusStudentIds()
    {
        $students = StudentsHistory::findAll(['action_type' => StudentsHistory::$TYPE_EXCLUDE]);
        $ids = [];
        foreach ($students as $student) {
            array_push($ids, $student["student_id"]);
        }
        return $ids;
    }
    public static function getAllActiveStudentIds()
    {
        $students = StudentsHistory::findAll(['action_type' => StudentsHistory::$TYPE_INCLUDE]);
        $ids = [];
        foreach ($students as $student) {
            array_push($ids, $student["student_id"]);
        }
        return $ids;
    }
    public static function getAllRenewalStudentIds()
    {
        $students = StudentsHistory::findAll(['action_type' => StudentsHistory::$TYPE_RENEWAL]);
        $ids = [];
        foreach ($students as $student) {
            array_push($ids, $student["student_id"]);
        }
        return $ids;
    }

}