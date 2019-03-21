<?php

namespace app\modules\students\models;

use Yii;

/**
 * This is the model class for table "student_csv_import_document_item".
 *
 * @property int $id
 * @property int $document_id
 * @property string $data
 * @property string $status
 * @property string $errors
 *
 * @property CsvImportDocument $document
 */
class CsvImportDocumentItem extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_DONE = 2;
    const STATUS_ERROR = 99;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_csv_import_document_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id', 'status'], 'integer'],
            [['data', 'errors'], 'string'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => CsvImportDocument::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'document_id' => Yii::t('app', 'Document ID'),
            'data' => Yii::t('app', 'Data'),
            'status' => Yii::t('app', 'Status'),
            'errors' => Yii::t('app', 'Errors'),
        ];
    }

    public function getStatusReadable()
    {
        return self::getStatuses()[$this->status];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_DONE => 'Done',
            self::STATUS_ERROR => 'Error',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(CsvImportDocument::className(), ['id' => 'document_id']);
    }
}
