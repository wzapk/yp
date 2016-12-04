<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "contents".
 *
 * @property integer $id
 * @property string $name
 * @property string $location
 * @property string $manager
 * @property string $business_scope
 * @property string $address
 * @property string $phone
 * @property string $social
 * @property string $qq
 * @property string $weibo
 * @property string $weixin
 * @property string $remark
 * @property string $taobao
 * @property string $homepage
 * @property string $city
 * @property string $state
 * @property string $region
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Contents extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const THUMBNAIL_PATH = '@webroot/thumbnails';
    const THUMBNAIL_URL = '@web/thumbnails';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('unix_timestamp()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'state', 'manager'], 'required'],
            [['name'], 'unique'],
            ['thumbnail', 'file', 'maxFiles' => 1, 'extensions' => 'png,jpg,gif', 'on' => ['insert', 'update']],
        ];
    }

    public function scenarios()
    {
        $arr = ['name','location','manager','business_scope','address','phone','social','thumbnail','serial_no','qq','weibo','weixin','taobao','homepage','remark','city','state','region','status','created_at','updated_at'];
        return [
            'default' => $arr,
            'insert' => $arr,
            'update' => $arr,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/contents', 'ID'),
            'name' => Yii::t('app/contents', 'Name'),
            'location' => Yii::t('app/contents', 'Location'),
            'manager' => Yii::t('app/contents', 'Manager'),
            'business_scope' => Yii::t('app/contents', 'Business Scope'),
            'address' => Yii::t('app/contents', 'Address'),
            'phone' => Yii::t('app/contents', 'Phone'),
            'social' => Yii::t('app/contents', 'Social'),
            'thumbnail' => Yii::t('app/contents', 'Thumbnail'),
            'serial_no' => Yii::t('app/contents', 'Serial No'),
            'qq' => Yii::t('app/contents', 'QQ'),
            'city' => Yii::t('app/contents', 'City'),
            'state' => Yii::t('app/contents', 'State'),
            'region' => Yii::t('app/contents', 'Region'),
            'weibo' => Yii::t('app/contents', 'Weibo'),
            'weixin' => Yii::t('app/contents', 'Weixin'),
            'taobao' => Yii::t('app/contents', 'Taobao'),
            'homepage' => Yii::t('app/contents', 'Homepage'),
            'remark' => Yii::t('app/contents', 'Remark'),
            'status' => Yii::t('app/contents', 'Status'),
            'created_at' => Yii::t('app/contents', 'Created At'),
            'updated_at' => Yii::t('app/contents', 'Updated At'),
        ];
    }

    public static function getLast($limit = 5)
    {
        return self::find()->orderBy('created_at desc')->limit($limit)->where(['status'=>self::STATUS_ACTIVE])->all();
    }

    public static function getStateNames()
    {
        return self::find()->select(['state'])->distinct()->where(['status'=>self::STATUS_ACTIVE])->all();
    }

    public static function getStateSum()
    {
        $db = self::getDb();
        $command = $db->createCommand('select state, count(state) as stateCount from '.self::tableName().' where status='.self::STATUS_ACTIVE.' group by state');
        $results = $command->queryAll();
        return $results;
    }

    public function getTeachers()
    {
        return $this->hasMany(Teachers::className(), ['cid' => 'id'])->where(['status'=>Teachers::STATUS_ACTIVE])->orderBy('name');
    }

    public function getMap()
    {
        return $this->hasOne(MapMark::className(), ['cid' => 'id']);
    }

    public function transactions()
    {
        return [
            'insert' => self::OP_INSERT,
            'update' => self::OP_UPDATE,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (parent::beforeSave($insert)) {
            $mapmark = MapMark::findOne(['cid' => $this->id]);
            if (!$mapmark) {
                $mapmark = new MapMark;
                $mapmark->cid = $this->id;
            }
            
            if ($mapmark) {
                $address = urlencode($this->address);
                $ak = '13reT2e9mO48UbkQg6gzD2I9';
                $url = 'http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak='.$ak;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch , CURLOPT_RETURNTRANSFER, true);
                $retval = curl_exec($ch);
                $retval = json_decode($retval, true);
                if (json_last_error() == 0) {
                    if ($retval['status'] == 0) {
                        $location = $retval['result']['location'];
                        $mapmark->lat = ''.$location['lat'];
                        $mapmark->lng = ''.$location['lng'];
                        $mapmark->save();
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
