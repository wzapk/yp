<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%district}}".
 *
 * @property integer $id
 * @property string $p_id
 * @property string $p_nm
 * @property string $c_id
 * @property string $c_nm
 * @property string $a_id
 * @property string $a_nm
 * @property string $full_name
 * @property string $disctrict_code
 * @property string $zip_code
 * @property string $phone_code
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%district}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'p_nm', 'c_id', 'c_nm', 'a_id', 'a_nm', 'full_name', 'disctrict_code', 'zip_code', 'phone_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/authRule', 'ID'),
            'p_id' => Yii::t('app/authRule', 'P ID'),
            'p_nm' => Yii::t('app/authRule', 'P Nm'),
            'c_id' => Yii::t('app/authRule', 'C ID'),
            'c_nm' => Yii::t('app/authRule', 'C Nm'),
            'a_id' => Yii::t('app/authRule', 'A ID'),
            'a_nm' => Yii::t('app/authRule', 'A Nm'),
            'full_name' => Yii::t('app/authRule', 'Full Name'),
            'disctrict_code' => Yii::t('app/authRule', 'Disctrict Code'),
            'zip_code' => Yii::t('app/authRule', 'Zip Code'),
            'phone_code' => Yii::t('app/authRule', 'Phone Code'),
        ];
    }

    public static function import($file)
    {
        $retval = [];
        $total = $num = 0;
        $conn = self::getDb();
        if (file_exists($file)) {
            $handle = @fopen($file, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    $buffer = fgets($handle, 4096);
                    $buffer = str_replace("\n", "", $buffer);
                    $buffer = str_replace("\r", "", $buffer);
                    $buffer = iconv('GB2312', "UTF-8//IGNORE", $buffer);
                    $line_array = explode("\t", $buffer);

                    if (count($line_array) > 1) {
                        $retval[] = $line_array;
                    }
                    if ($num >= 1024) {
                        $num = 0;
                        
                        $conn->createCommand()->batchInsert(self::tableName(), ['p_id', 'p_nm', 'c_id', 'c_nm', 'a_id', 'a_nm', 'full_name', 'disctrict_code', 'zip_code', 'phone_code'],$retval)->execute();
                        $retval = [];
                    } else {
                        $num ++;
                    }
                }
                fclose($handle);
                if (count($retval)) {
                    $conn->createCommand()->batchInsert(self::tableName(), ['p_id', 'p_nm', 'c_id', 'c_nm', 'a_id', 'a_nm', 'full_name', 'disctrict_code', 'zip_code', 'phone_code'],$retval)->execute();
                }
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 返回省份列表
     * @param integer|boolean 省份id，false时返回所有省份名称列表
     */
    public static function getStates($p_id = false)
    {
        $conn = self::getDb();
        $sql = 'select distinct p_id,p_nm from'.self::tableName().($p_id ? ' where p_id='.$p_id : '');
        $query = $conn->createCommand($sql)->queryAll();
        return ArrayHelper::map($query, 'p_id', 'p_nm');
    }

    public static function getCities($p_id, $c_id = false)
    {
        $conn = self::getDb();
        $query = [];
        if ($p_id) {
            $sql = 'select distinct c_id,c_nm from'.self::tableName().' where p_id='.$p_id .($c_id ? ' and c_id='.$c_id : '');
            $query = $conn->createCommand($sql)->queryAll();
        }
        return ArrayHelper::map($query, 'c_id', 'c_nm');
    }

    public static function getRegions($p_id, $c_id, $a_id = false)
    {
        $conn = self::getDb();
        $query = [];
        if ($p_id && $c_id) {
            $sql = 'select distinct a_id,a_nm from'.self::tableName().' where p_id='.$p_id.' and c_id='.$c_id .($a_id ? ' and a_id='.$a_id : '');
            $query = $conn->createCommand($sql)->queryAll();
        }
        return ArrayHelper::map($query, 'a_id', 'a_nm');
    }
}
