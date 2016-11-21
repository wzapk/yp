<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%map_mark}}".
 *
 * @property integer $id
 * @property integer $cid
 * @property string $lat
 * @property string $lng
 *
 * @property Contents $c
 */
class MapMark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%map_mark}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid'], 'integer'],
            [['lat', 'lng'], 'string', 'max' => 255],
            [['lat'], 'unique'],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => Contents::className(), 'targetAttribute' => ['cid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/mapmark', 'ID'),
            'cid' => Yii::t('app/mapmark', 'Cid'),
            'lat' => Yii::t('app/mapmark', 'Lat'),
            'lng' => Yii::t('app/mapmark', 'Lng'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Contents::className(), ['id' => 'cid']);
    }

    public function import($markarr)
    {
        $retval = [];
        foreach ($markarr as $index => $arr) {
            list($lot, $lng) = explode('|', $arr->point);
            $retval[] = [
                'name' => $arr->title,
                'lot' => $lot,
                'lng' => $lng,
            ];
        }
        return $retval;
    }
}
