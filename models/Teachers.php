<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%teachers}}".
 *
 * @property integer $id
 * @property string $serial_no
 * @property integer $cid
 * @property string $name
 * @property string $avatar
 * @property string $certificate
 * @property string $contact
 * @property string $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Contents $c
 */
class Teachers extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%teachers}}';
    }

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
    public function rules()
    {
        return [
            [['cid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['name', 'contact', 'phone', 'serial_no'], 'string', 'max' => 255],
            [['avatar', 'certificate'], 'file'],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => Contents::className(), 'targetAttribute' => ['cid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/teacher', 'ID'),
            'cid' => Yii::t('app/teacher', 'Cid'),
            'serial_no' => Yii::t('app/teacher', 'Serial No'),
            'name' => Yii::t('app/teacher', 'Name'),
            'avatar' => Yii::t('app/teacher', 'Avatar'),
            'certificate' => Yii::t('app/teacher', 'Certificate'),
            'contact' => Yii::t('app/teacher', 'Contact'),
            'phone' => Yii::t('app/teacher', 'Phone'),
            'status' => Yii::t('app/teacher', 'Status'),
            'created_at' => Yii::t('app/teacher', 'Created At'),
            'updated_at' => Yii::t('app/teacher', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Contents::className(), ['id' => 'cid']);
    }

    public static function getLast($limit = 10)
    {
        return self::find()->orderBy('created_at desc')->limit($limit)->where(['status'=>self::STATUS_ACTIVE])->all();
    }
}
