<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 19.03.2019
 * Time: 17:10
 */

namespace app\components\importers;


use app\modules\students\models\CsvImportDocument as Document;
use app\modules\students\models\CsvImportDocumentItem as DocumentItem;
use app\modules\students\models\Student;
use ruskid\csvimporter\CSVReader;

class ImportStudent
{
    public $models = [];

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
                    $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
                    return $value;
                }
            ],
            [
                'target' => 'first_name',
                'label' => 'Ім\'я',
                'value' => function ($line) {
                    $value = explode(' ', $line[4])[1];
                    $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
                    return $value;
                }
            ],
            [
                'target' => 'middle_name',
                'label' => 'По батькові',
                'value' => function ($line) {
                    $value = explode(' ', $line[4])[2];
                    $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
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
                    return $line[7] . $line[8];
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
            ]
        ];
    }

    public function import(Document $document)
    {
        $this->load($document);

        $this->validateItems($document);

        $this->processingItems($document);

        $this->afterImport($document);

        return true;
    }

    public function load(Document $document)
    {
        $lines = $this->loadCsv($document);

        $savedRows = 0;
        try {
            foreach ($lines as $line) {
                $data = $this->extractAttributes($line);
                if ($this->loadItem($document, $data)) {
                    $savedRows++;
                }
            }
        } catch (\Exception $e) {
            $document->status = Document::STATUS_ERROR;
            $document->save(false);
            throw $e;
        }

        return true;
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

    public function loadItem($document, $data)
    {
        $item = new DocumentItem();
        $item->data = serialize($data);

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
        $data = unserialize($item->data);
        $model = new Student();
        foreach ($data as $attribute => $value) {
            if ($model->hasAttribute($attribute)) {
                $model->setAttribute($attribute, $value);
            }
        }
        if (!$model->validate()) {
            $item->errors = serialize($model->errors);
            $item->status = DocumentItem::STATUS_ERROR;
            $item->save();
        } else {
            $this->models[] = $model;
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
                $model->save(false);
            }
        } else {
            $document->status = Document::STATUS_ERROR;
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

    public function beforeImport(Document $document)
    {
        $document->status = Document::STATUS_LOADING;
        $document->save(false);
    }
}