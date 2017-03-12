<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170218_161703_add_subject_cycle_data extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->batchInsert('{{%subject_cycle}}', [
            'id', 'title',
        ],
            [
                [8, 'Вибіркові навчальні дисципліни'],
                [4, 'Дисципліни природничо-наукової  (фундаментальної) підготовки'],
                [2, 'Гуманітарні  та соціально економічні дисципліни'],
                [1, 'Цикл загальноосвітніх предметів'],
                [6, 'Дисципліни професійної і практичної підготовки']
            ]
        );
    }

    /**
     * @return bool
     * @inheritdoc
     */
    public function down()
    {
        echo "m170218_161703_add_subject_cycle_data cannot be reverted.\n";
        return false;
    }
}