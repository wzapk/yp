<?php

use yii\db\Migration;

class m160607_055241_add_city_state_region_column_contents extends Migration
{
    const TABLENAME = '{{%contents}}';

    public function up()
    {
        $this->addColumn(self::TABLENAME, 'city', $this->string());
        $this->addColumn(self::TABLENAME, 'state', $this->string());
        $this->addColumn(self::TABLENAME, 'region', $this->string());
    }

    public function down()
    {
        $this->dropColumn(self::TABLENAME, 'city');
        $this->dropColumn(self::TABLENAME, 'state');
        $this->dropColumn(self::TABLENAME, 'region');
    }
}
