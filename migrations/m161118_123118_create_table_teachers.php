<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_teachers`.
 */
class m161118_123118_create_table_teachers extends Migration
{
    const TABLENAME = '{{%teachers}}';
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
            // 分部数据ID
            'cid' => $this->integer(),
            // 姓名
            'name' => $this->string()->notNull(),
            // 照片
            'avatar' => $this->string(),
            // 证书照片
            'certificate' => $this->string(),
            // 联系方式
            'contact' => $this->string(),
            // 手机
            'phone' => $this->string(),
            // 数据状态
            'status' => $this->smallInteger()->defaultValue(10),
            // 时间戳
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        
        $this->createIndex('idx-teachers_name', self::TABLENAME, 'name');
        $this->addForeignKey('fk-teachers_cid-contents_id', self::TABLENAME, 'cid', 'contents', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-teachers_cid-contents_id', self::TABLENAME);
        $this->dropIndex('idx-teachers_name', self::TABLENAME);
        $this->dropTable(self::TABLENAME);
    }
}
