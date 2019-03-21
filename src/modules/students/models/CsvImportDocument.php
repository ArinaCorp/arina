<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "student_csv_import_document".
 *
 * @property int $id
 * @property string $file_path
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CsvImportDocumentItem[] $studentCsvImportDocumentItems
 */
class CsvImportDocument extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_LOADING = 1;
    const STATUS_VALIDATING = 2;
    const STATUS_VALIDATED = 3;
    const STATUS_PROCESSING = 4;
    const STATUS_DONE = 5;
    const STATUS_ERROR = 99;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_csv_import_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_path' => Yii::t('app', 'File Path'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
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
            self::STATUS_LOADING => 'Loading',
            self::STATUS_VALIDATING => 'Validating',
            self::STATUS_VALIDATED => 'Validated',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_DONE => 'Done',
            self::STATUS_ERROR => 'Error',
        ];
    }

    public function getShortPath()
    {
        return basename($this->file_path);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentItems()
    {
        return $this->hasMany(CsvImportDocumentItem::className(), ['document_id' => 'id']);
    }
}
