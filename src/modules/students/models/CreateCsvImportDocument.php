<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 19.03.2019
 * Time: 21:06
 */

namespace app\modules\students\models;

use app\components\importers\ImportStudentJob;
use PhpParser\Node\Scalar\String_;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class CreateCsvImportDocument extends Model
{
    /**
     * @var $file UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            ['file', 'required'],
            [['file'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'csv', 'skipOnEmpty' => false]
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'Select file from import'),
        ];
    }

    public function upload()
    {
        $file = $this->file = UploadedFile::getInstance($this, 'file');
        $path = 'uploads/' . $this->file->getBaseName() . '_' . date('d_m_Y') . '.' . $this->file->getExtension();

        $result = $this->validate();

        if ($result) {
            $result = $file->saveAs($path);

            $importDocument = new CsvImportDocument([
                'file_path' => $path,
                'status' => CsvImportDocument::STATUS_NEW
            ]);

            if ($result) {
                $result &= $importDocument->save();
                self::runJob($importDocument);
            }
        }

        return $result;
    }

    /**
     * @param $model
     */
    public static function runJob($model)
    {
        $job = new ImportStudentJob();
        $job->id = $model->id;
        Yii::$app->queue->push($job);
    }

}