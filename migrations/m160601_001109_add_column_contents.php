<?php

use yii\db\Migration;

class m160601_001109_add_column_contents extends Migration
{
    const TABLENAME = '{{%contents}}';

    public function up()
    {
        $this->addColumn(self::TABLENAME, 'serial_no', $this->string());
        $this->addColumn(self::TABLENAME, 'qq', $this->string());
        $this->addColumn(self::TABLENAME, 'weibo', $this->string());
        $this->addColumn(self::TABLENAME, 'weixin', $this->string());
        $this->addColumn(self::TABLENAME, 'remark', $this->string());
    }

    public function down()
    {
        $this->dropColumn(self::TABLENAME, 'serial_no');
        $this->dropColumn(self::TABLENAME, 'qq');
        $this->dropColumn(self::TABLENAME, 'weibo');
        $this->dropColumn(self::TABLENAME, 'weixin');
        $this->dropColumn(self::TABLENAME, 'remark');
    }

}
