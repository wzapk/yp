<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_options`.
 */
class m160612_031349_create_table_options extends Migration
{
    const TABLENAME = '{{%options}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLENAME, [
            'id' => $this->primaryKey(),
            'key' => $this->string()->unique(),
            'value' => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);
        $this->createIndex('idx-options_key', self::TABLENAME, ['key'], true);
        $this->batchInsert(self::TABLENAME, ['key', 'value', 'description'], [
            ['ICP', '京IPC备123456789', 'ICP备案号'],
            ['supportEmail', 'support@yiiboard.com', '技术支持Email'],
            ['support', '伊波', '技术支持名称'],
            ['supportLink', 'http://www.yiiboard.com', '技术支持链接'],
            ['appname', '魔菇教育黄页', '应用名称'],
            ['shortappname', '魔菇黄页', '应用短名称'],
            ['copyright', '吉他中国', '版权名称'],
            ['copyrightLink', 'http://www.guitarchina.com', '版权链接'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx-options_key', self::TABLENAME);
        $this->dropTable(self::TABLENAME);
    }
}
