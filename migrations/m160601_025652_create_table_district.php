<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_district`.
 */
class m160601_025652_create_table_district extends Migration
{
    const TABLENAME = '{{%district}}';

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
            'p_id' => $this->string() . ' comment \'省行政区码\'',
            'p_nm' => $this->string() . ' comment \'省行政区名称\'',
            'c_id' => $this->string() . ' comment \'市行政区码\'',
            'c_nm' => $this->string() . ' comment \'市行政区名称\'',
            'a_id' => $this->string() . ' comment \'区域行政区码\'',
            'a_nm' => $this->string() . ' comment \'区域行政区名称\'',
            'full_name' => $this->string() . ' comment \'行政区域全名\'',
            'disctrict_code' => $this->string() . ' comment \'行政区域编码\'',
            'zip_code' => $this->string() . ' comment \'行政区域邮政编码\'',
            'phone_code' => $this->string() . ' comment \'行政区域区号编码\'',
        ], $tableOptions);

        $this->createIndex('idx-district-p_nm', self::TABLENAME, 'p_nm');
        $this->createIndex('idx-district-c_nm', self::TABLENAME, 'c_nm');
        $this->createIndex('idx-district-a_nm', self::TABLENAME, 'a_nm');
        $this->createIndex('idx-district-disctrict_code', self::TABLENAME, 'disctrict_code');
        $this->createIndex('idx-district-zip_code', self::TABLENAME, 'zip_code');
        $this->createIndex('idx-district-phone_code', self::TABLENAME, 'phone_code');
        /*
comment on column L_Zip_District_PhoneCode.K_ID
  is '数据id';
comment on column L_Zip_District_PhoneCode.P_ID
  is '省行政区码';
comment on column L_Zip_District_PhoneCode.P_NM
  is '省行政区名称';
comment on column L_Zip_District_PhoneCode.C_ID
  is '市行政区码';
comment on column L_Zip_District_PhoneCode.C_NM
  is '市行政区名称';
comment on column L_Zip_District_PhoneCode.A_ID
  is '区域行政区码';
comment on column L_Zip_District_PhoneCode.A_NM
  is '区域行政区名称';
comment on column L_Zip_District_PhoneCode.FULL_NAME
  is '行政区域全名';
comment on column L_Zip_District_PhoneCode.DISCTRICT_CODE
  is '行政区域编码';
comment on column L_Zip_District_PhoneCode.ZIP_CODE
  is '行政区域邮政编码';
comment on column L_Zip_District_PhoneCode.PHONE_CODE
  is '行政区域区号编码';

        */
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx-district-phone_code', self::TABLENAME);
        $this->dropIndex('idx-district-zip_code', self::TABLENAME);
        $this->dropIndex('idx-district-disctrict_code', self::TABLENAME);
        $this->dropIndex('idx-district-a_nm', self::TABLENAME);
        $this->dropIndex('idx-district-c_nm', self::TABLENAME);
        $this->dropIndex('idx-district-p_nm', self::TABLENAME);
        $this->dropTable(self::TABLENAME);
    }
}
