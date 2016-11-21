<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_contents`.
 */
class m160529_050803_create_table_contents extends Migration
{
    // 自增id
    const TABLE_AUTO_INCREMENT = 10000;
    const TABLENAME = '{{%contents}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            $tableOptions .= ' AUTO_INCREMENT='.static::TABLE_AUTO_INCREMENT;
        }
        $this->createTable(static::TABLENAME, [
            // 数据标识
            'id' => $this->primaryKey(),
            // 分部名称
            'name' => $this->string()->notNull()->unique(),
            // 所在城市
            'location' => $this->string()->notNull(),
            // 负责人
            'manager' => $this->string()->notNull(),
            // 经营范围
            'business_scope' => $this->string(),
            // 详细地址
            'address' => $this->string(),
            // 联系电话
            'phone' => $this->string(),
            // 社会化联系方式
            'social' => $this->string(),
            // 缩略图
            'thumbnail' => $this->string(),
            // 数据状态
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-contents_name', static::TABLENAME, ['name'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx-contents_name', static::TABLENAME);
        $this->dropTable(static::TABLENAME);
    }
}
