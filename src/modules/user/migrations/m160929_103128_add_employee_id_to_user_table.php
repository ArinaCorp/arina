<?php

use yii\db\Migration;

class m160929_103128_add_employee_id_to_user_table extends Migration
{
  public function up()
  {
    $this->addColumn('{{%user}}', 'employee_id', $this->integer());
  }

  public function down()
  {
    $this->dropColumn('{{%user}}', 'employee_id');
  }
}
