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
                [1, 'Вибіркові навчальні дисципліни'],
                [2, 'Дисципліни природничо-наукової  (фундаментальної) підготовки'],
                [3, 'Гуманітарні  та соціально економічні дисципліни'],
                [4, 'Цикл загальноосвітніх предметів'],
                [5, 'Дисципліни професійної і практичної підготовки']
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