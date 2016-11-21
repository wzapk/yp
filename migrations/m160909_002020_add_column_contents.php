<?php

use yii\db\Migration;

class m160909_002020_add_column_contents extends Migration
{
    const TABLENAME = '{{%contents}}';

    public function up()
    {
        $this->addColumn(self::TABLENAME, 'taobao', $this->string());
        $this->addColumn(self::TABLENAME, 'homepage', $this->string());
    }

    public function down()
    {
        $this->dropColumn(self::TABLENAME, 'homepage');
        $this->dropColumn(self::TABLENAME, 'taobao');
    }

}
