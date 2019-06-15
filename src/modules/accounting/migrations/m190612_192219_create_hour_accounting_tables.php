<?php

use yii\db\Migration;

/**
 * Class m190612_192219_create_hour_accounting_tables
 */
class m190612_192219_create_hour_accounting_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%yearly_hour_accounting}}', [
            'id' => $this->primaryKey(),
            'study_year_id' => $this->integer(),
            'teacher_id' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createTable('{{%hour_accounting_record}}', [
            'id' => $this->primaryKey(),
            'load_id' => $this->integer(),
            'yearly_hour_accounting_id' => $this->integer(),
            'hours_per_month' => $this->text(),
        ]);


        // add foreign key and index for `study_year_id` field in table `yearly_hour_accounting`
        $this->createIndex(
            'idx-yearly_hour_accounting-study_year_id',
            'yearly_hour_accounting',
            'study_year_id'
        );

        $this->addForeignKey(
            'fk-yearly_hour_accounting-study_year_id',
            'yearly_hour_accounting',
            'study_year_id',
            'study_years',
            'id',
            'CASCADE',
            'CASCADE'
        );


        // add foreign key and index for `teacher_id` field in table `yearly_hour_accounting`
        $this->createIndex(
            'idx-yearly_hour_accounting-teacher_id',
            'yearly_hour_accounting',
            'teacher_id'
        );

        $this->addForeignKey(
            'fk-yearly_hour_accounting-teacher_id',
            'yearly_hour_accounting',
            'teacher_id',
            'employee',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // add foreign key and index for `yearly_hour_accounting_id` field in table `hour_accounting_record`
        $this->createIndex(
            'idx-hour_accounting_record-yearly_hour_accounting_id',
            'hour_accounting_record',
            'yearly_hour_accounting_id'
        );

        $this->addForeignKey(
            'fk-hour_accounting_record-yearly_hour_accounting_id',
            'hour_accounting_record',
            'yearly_hour_accounting_id',
            'yearly_hour_accounting',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // add foreign key and index for `load_id` field in table `hour_accounting_record`
        $this->createIndex(
            'idx-hour_accounting_record-load_id',
            'hour_accounting_record',
            'load_id'
        );

        $this->addForeignKey(
            'fk-hour_accounting_record-load_id',
            'hour_accounting_record',
            'load_id',
            'load',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-hour_accounting_record-load_id',
            'hour_accounting_record'
        );

        $this->dropIndex(
            'idx-hour_accounting_record-load_id',
            'hour_accounting_record'
        );


        $this->dropForeignKey(
            'fk-hour_accounting_record-yearly_hour_accounting_id',
            'hour_accounting_record'
        );

        $this->dropIndex(
            'idx-hour_accounting_record-yearly_hour_accounting_id',
            'hour_accounting_record'
        );


        $this->dropForeignKey(
            'fk-yearly_hour_accounting-teacher_id',
            'yearly_hour_accounting'
        );

        $this->dropIndex(
            'idx-yearly_hour_accounting-teacher_id',
            'yearly_hour_accounting'
        );


        $this->dropForeignKey(
            'fk-yearly_hour_accounting-study_year_id',
            'yearly_hour_accounting'
        );

        $this->dropIndex(
            'idx-yearly_hour_accounting-study_year_id',
            'yearly_hour_accounting'
        );


        $this->dropTable('{{%hour_accounting_record}}');
        $this->dropTable('{{%yearly_hour_accounting}}');
    }
}
