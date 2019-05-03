<?php

use yii\db\Migration;

class m180107_194700_create_csv_import_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%student_csv_import_document}}', [
            'id' => $this->primaryKey(),
            'file_path' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%student_csv_import_document_item}}', [
            'id' => $this->primaryKey(),
            'document_id' => $this->integer(),
            'data' => $this->text(),
            'status' => $this->integer(),
            'errors' => $this->text(),
        ]);

        $this->createIndex(
            'idx-student_csv_import_document_item-document_id',
            'student_csv_import_document_item',
            'document_id'
        );

        // add foreign key for table `student_csv_import_document_item`
        $this->addForeignKey(
            'fk-student_csv_import_document_item-document_id',
            'student_csv_import_document_item',
            'document_id',
            'student_csv_import_document',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%student_csv_import_document}}');
        $this->dropTable('{{%student_csv_import_document_item}}');
    }
}
