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
    public function import(Document $document)
    {
        $this->load($document);

        $items = $this->getItems($document);

        $this->beforeImport($document);

        foreach ($items as $item) {
            $this->modifyItem($item);
        }

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

        $document->status = Document::STATUS_DONE;
        $document->save(false);
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
        $data['sseed_id'] = $line[1];

        $value = explode(' ', $line[4])[0];
        $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
        $data['last_name'] = $value;

        $value = explode(' ', $line[4])[1];
        $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
        $data['first_name'] = $value;

        $value = explode(' ', $line[4])[2];
        $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
        $data['middle_name'] = $value;

        $data['birth_day'] = $line[5];

        $data['passport_code'] = $line[7] . $line[8];

        $data['passport_issued_date'] = $line[9];

        $data['gender'] = mb_substr($line[10], 0) == 'Ч' ? 1 : 0;

        $data['tax_id'] = $line[13];

        $data['student_code'] = explode(';', $line[43])[0];

        //TODO: add other fields

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

    public function getItems(Document $document)
    {
        $queue = $document->getDocumentItems();
        return $queue->each();
    }

    public function beforeImport(Document $document)
    {
        $document->status = Document::STATUS_LOADING;
        $document->save(false);
    }

    public function modifyItem(DocumentItem $item)
    {
        $data = unserialize($item->data);
        $model = new Student();
        foreach ($data as $attribute => $value) {
            if ($model->hasAttribute($attribute)) {
                $model->setAttribute($attribute, $value);
            }
        }

        $model->save();

        if ($model->errors) {
            $item->errors = serialize($model->errors);
            $item->status = DocumentItem::STATUS_ERROR;
            $item->save();
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