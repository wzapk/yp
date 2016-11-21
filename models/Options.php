<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%options}}".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $description
 */
class Options extends \yii\db\ActiveRecord
{
    private static $__items = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value', 'description'], 'string', 'max' => 255],
            ['key', 'required'],
            ['key', 'unique'],
            ['key', 'match', 'pattern' => '/^[_a-zA-Z][_0-9a-zA-Z]{0,}$/i', 'message'=>'键名必须以下划线或字母开头，由下划线、字母和数字组成'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/options', 'ID'),
            'key' => Yii::t('app/options', 'Key'),
            'value' => Yii::t('app/options', 'Value'),
            'description' => Yii::t('app/options', 'Description'),
        ];
    }

    public static function getAllValues()
    {
        self::loadItems();
        return self::$__items;
    }

    public static function getValueByKey($key, $default = '')
    {
        self::loadItems();
        if (array_key_exists($key, self::$__items)) {
            return self::$__items[$key];
        }
        return $default;
    }

    public static function v($key, $default = '')
    {
        return self::getValueByKey($key, $default);
    }


    private static function loadItems()
    {
        if (!self::$__items) {
            self::$__items = ArrayHelper::map(self::find()->all(), 'key', 'value');
        }
    }
}
