<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_user`.
 */
class m160529_045148_create_table_user extends Migration
{
    // 自增id
    const USER_AUTO_INCREMENT = 10000;
    const TABLENAME = '{{%user}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            $tableOptions .= ' AUTO_INCREMENT='.static::USER_AUTO_INCREMENT;
        }

        $this->createTable(static::TABLENAME, [
            // 用户标识
            'id' => $this->primaryKey(),
            // 用户名(可登录)
            'username' => $this->string()->notNull()->unique(),
            // 认证token
            'auth_key' => $this->string(32)->notNull(),
            // 密码哈希
            'password_hash' => $this->string()->notNull(),
            // 密码重置token
            'password_reset_token' => $this->string()->unique(),
            // 邮箱(可登录)
            'email' => $this->string()->notNull()->unique(),
            
            // 数据状态
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-user_username', static::TABLENAME, ['username'], true);
        $this->createIndex('idx-user_email', static::TABLENAME, ['email'], true);

        $this->insert(static::TABLENAME, [
            'id' => 99,
            'username' => 'wangqiang',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'email' => '18313403@qq.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert(static::TABLENAME, [
            'id' => 100,
            'username' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'email' => 'admin@yiiboard.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->delete(static::TABLENAME, ['id' => 99]);
        $this->delete(static::TABLENAME, ['id' => 100]);
        $this->dropIndex('idx-user_email', static::TABLENAME);
        $this->dropIndex('idx-user_username', static::TABLENAME);
        $this->dropTable(static::TABLENAME);
    }
}
