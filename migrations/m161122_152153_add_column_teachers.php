<?php

use yii\db\Migration;

class m161122_152153_add_column_teachers extends Migration
{
    const TABLENAME = '{{%teachers}}';

    public function up()
    {
        $this->addColumn(self::TABLENAME, 'serial_no', $this->string());
    }

    public function down()
    {
        $this->dropColumn(self::TABLENAME, 'serial_no');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
