<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 19.03.2019
 * Time: 17:10
 */

namespace app\components\importers;


use app\modules\students\models\CsvImportDocument as Document;
use app\modules\students\models\CsvImportDocument;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class ImportStudentJob extends BaseObject implements JobInterface
{

    public $id;

    public function execute($queue)
    {
        $document = Document::findOne($this->id);
        $importer = new ImportStudent();
        $importer->import($document);
    }

    public function import()
    {
        $document = Document::findOne($this->id);
        $importer = new ImportStudent();
        $importer->import($document);
    }
}