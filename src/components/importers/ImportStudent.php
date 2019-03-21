<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 19.03.2019
 * Time: 17:10
 */

namespace app\components\importers;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;
use app\modules\students\models\CsvImportDocument as Document;
use app\modules\students\models\CsvImportDocumentItem as DocumentItem;
use app\modules\students\models\Student;
use app\modules\students\models\StudentsHistory;
use Exception;
use ruskid\csvimporter\CSVReader;

class ImportStudent
{
    public $models = [];

    public function import(Document $document)
    {
        $this->beforeImport($document);

        if ($document->status === Document::STATUS_NEW) {
            $this->load($document);
        }

        $this->validateItems($document);

        $this->processingItems($document);

        $this->afterImport($document);

        return true;
    }

    public function load(Document $document)
    {
        $lines = $this->loadCsv($document);
        try {
            foreach ($lines as $line) {
                $data = $this->extractAttributes($line);
                $this->loadItem($document, $data);
            }
        } catch (Exception $e) {
            $document->status = Document::STATUS_ERROR;
            $document->save(false);
        }
    }

    public function loadCsv(Document $document)
    {
        $document->status = Document::STATUS_LOADING;

        $document->save(false);

        $reader = new CSVReader([
            'filename' => $document->file_path,
            'fgetcsvOptions' => [
                'delimiter' => ';'
            ]
        ]);

        return $reader->readFile();
    }

    public function extractAttributes($line)
    {
        $data = [];
        foreach (self::getColumns() as $column) {
            $data[$column['target']] = $column['value']($line);
        }

        return $data;
    }

    public static function getColumns()
    {
        return $columns = [
            [
                'target' => 'sseed_id',
                'label' => 'ID картки',
                'value' => function ($line) {
                    return $line[1];
                }
            ],
            [
                'target' => 'last_name',
                'label' => 'Прізвище',
                'value' => function ($line) {
                    $value = explode(' ', $line[4])[0];
                    $value = self::getConvertedValue($value);
                    return $value;
                }
            ],
            [
                'target' => 'first_name',
                'label' => 'Ім\'я',
                'value' => function ($line) {
                    $value = explode(' ', $line[4])[1];
                    $value = self::getConvertedValue($value);
                    return $value;
                }
            ],
            [
                'target' => 'middle_name',
                'label' => 'По батькові',
                'value' => function ($line) {
                    $value = explode(' ', $line[4])[2];
                    $value = self::getConvertedValue($value);
                    return $value;
                }
            ],
            [
                'target' => 'birth_day',
                'label' => 'Дата народження',
                'value' => function ($line) {
                    return $line[5];
                }
            ],
            [
                'target' => 'passport_code',
                'label' => 'Серія та номер паспорта',
                'value' => function ($line) {
                    if (empty($line[7])) {
                        $result = $line[8];
                        if (strlen($line[8]) < 9) {
                            $result = str_pad($line[8], 9, '00000000', STR_PAD_LEFT);
                        }
                    } else {
                        $result = $line[7] . '№' . $line[8];
                    }
                    return $result;
                }
            ],
            [
                'target' => 'passport_issued_date',
                'label' => 'Дата видачі паспорта',
                'value' => function ($line) {
                    return $line[9];
                }
            ],
            [
                'target' => 'gender',
                'label' => 'Стать',
                'value' => function ($line) {
                    return mb_substr($line[10], 0) == 'Ч' ? 1 : 0;
                }
            ],
            [
                'target' => 'tax_id',
                'label' => 'РНОКПП',
                'value' => function ($line) {
                    return $line[13];
                }
            ],
            [
                'target' => 'student_code',
                'label' => 'Студентський квиток',
                'value' => function ($line) {
                    return explode(';', $line[43])[0];
                }
            ],

            //Student History
            [
                'target' => 'payment_type',
                'label' => 'Джерело фінансування',
                'value' => function ($line) {
                    $value = self::getConvertedValue($line[21]);
                    return $value == 'Бюджет' ? StudentsHistory::$PAYMENT_STATE : StudentsHistory::$PAYMENT_CONTRACT;
                }
            ],
            [
                'target' => 'action_type',
                'label' => 'Тип дії',
                'value' => function ($line) {
                    return StudentsHistory::$TYPE_INCLUDE;
                }
            ],
            [
                'target' => 'command',
                'label' => '№ наказу',
                'value' => function ($line) {
                    $value = self::getConvertedValue($line[38]);
                    preg_match_all('!\d+!', $value, $matches);
                    return $matches[0][1];
                }
            ],
            [
                'target' => 'date',
                'label' => 'Дата',
                'value' => function ($line) {
                    $value = self::getConvertedValue($line[38]);
                    preg_match_all('!\d+!', $value, $matches);
                    $result = implode('.', [$matches[0][2], $matches[0][3], $matches[0][4]]);
                    return $result;
                }
            ],
            [
                'target' => 'course',
                'label' => 'Курс',
                'value' => function ($line) {
                    $currentYear = StudyYear::getCurrentYear()->year_start;
                    $startYear = date('Y', strtotime($line[15]));
                    return $currentYear - $startYear;
                }
            ],
            [
                'target' => 'speciality_qualification_id',
                'label' => 'speciality qualification id',
                'value' => function ($line) {
                    $qualification_title = self::getConvertedValue($line[18]);
                    $speciality_number = explode(' ', self::getConvertedValue($line[24]))[0];

                    return SpecialityQualification::find()->joinWith(['qualification', 'speciality'])->where([
                        'qualification.title' => $qualification_title,
                        'speciality.number' => $speciality_number
                    ])->one()->id;
                }
            ],
        ];
    }

    public static function getConvertedValue($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
    }

    public function loadItem($document, $data)
    {
        $item = new DocumentItem([
            'data' => $data,
        ]);

        if (!$item->validate()) {
            return false;
        }

        if ($item->status === null) {
            $item->status = DocumentItem::STATUS_NEW;
        }

        $item->link('document', $document);

        return $item->save(false);
    }

    public function validateItems(Document $document)
    {
        $items = $this->getItems($document);
        foreach ($items as $item) {
            $this->validateItem($item);
        }
    }

    public function getItems(Document $document)
    {
        $queue = $document->getDocumentItems();
        return $queue->each();
    }

    public function validateItem(DocumentItem $item)
    {
        /** @var array $data */
        $data = $item->data;
        $modelStudent = new Student();
        $modelHistory = new StudentsHistory();
        foreach ($data as $attribute => $value) {
            if ($modelStudent->hasAttribute($attribute)) {
                $modelStudent->setAttribute($attribute, $value);
            } else {
                if ($modelHistory->hasAttribute($attribute)) {
                    $modelHistory->setAttribute($attribute, $value);
                }
            }
        }
        if (!$modelStudent->validate() or !$modelHistory->validate(['action_type', 'date', 'command'])) {
            $errors = array_merge($modelStudent->errors, $modelHistory->errors);
            $item->errors = $errors;
            $item->status = DocumentItem::STATUS_ERROR;
            $item->save();
        } else {
            $this->models[] = [
                'student' => $modelStudent,
                'history' => $modelHistory,
            ];
        }
    }

    public function processingItems(Document $document)
    {
        $document->status = Document::STATUS_PROCESSING;
        $document->save(false);

        $errorsItems = $document->getDocumentItems()->where([
            'status' => DocumentItem::STATUS_ERROR
        ])->all();

        if (!$errorsItems and $this->models) {
            foreach ($this->models as $model) {
                $model['student']->save(false);
                $model['history']->link('student', $model['student']);
                $model['history']->save(false);
            }
        } else {
            $document->status = Document::STATUS_ERROR;
            $document->save(false);
        }
    }

    public function beforeImport(Document $document)
    {
        if (!$document->status){
            $document->status = Document::STATUS_NEW;
            $document->save(false);
        }
    }

    public function afterImport(Document $document)
    {
        if ($document->status !== Document::STATUS_ERROR) {
            $document->status = Document::STATUS_DONE;
        }
        $document->save(false);
    }
}