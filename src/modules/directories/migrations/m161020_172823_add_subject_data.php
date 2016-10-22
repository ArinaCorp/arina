<?php

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m161020_172823_add_subject_data extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->batchInsert('{{%subject}}', ['title','code','short_name','practice'],
            [
                ['ukr m','3.11','um','???'],
            ]
        );
    }

    public function down()
    {
        $this->truncateTable('{{%subject}}');
    }

}
