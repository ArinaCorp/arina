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
use ruskid\csvimporter\ARImportStrategy;
use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
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
}