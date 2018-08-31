<?php

namespace common\models\shop;

use Yii;
use yii\helpers\Html;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $user_id
 * @property string $name
 * @property string $mobile
 * @property integer $province_id
 * @property string $province
 * @property integer $city_id
 * @property string $city
 * @property integer $district_id
 * @property string $district
 * @property string $detail
 * @property integer $is_default
 * @property integer $addtime
 * @property integer $is_delete
 */
class Address extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }
	
    public static function getDb()
    {
    	return \Yii::$app->get('mongodbShop');
    }
    
    public function attributes()
    {
    	return ['_id',
    	'user_id',
    	'name',
    	'mobile',
    	'province',
    	'city',
    	'district',
    	'detail',
    	'province_id',
    	'city_id',
    	'district_id',
    	'is_default',
    	'created_at'];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'mobile', 'province', 'city', 'district', 'detail'], 'required'],
            [['user_id', 'province_id', 'city_id', 'district_id', 'is_default', 'created_at'], 'integer'],
            [['name', 'mobile', 'province', 'city', 'district'], 'string', 'max' => 255],
            [['detail'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'user_id' => 'User ID',
            'name' => '姓名',
            'mobile' => '手机号',
            'province_id' => 'Province ID',
            'province' => '省份名称',
            'city_id' => 'City ID',
            'city' => '城市名称',
            'district_id' => 'District ID',
            'district' => '县区名称',
            'detail' => '详细地址',
            'is_default' => '是否是默认地址：0=否，1=是',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
        ];
    }

    public function beforeSave($insert)
    {
        $this->name = Html::encode($this->name);
        $this->mobile = Html::encode($this->mobile);
        $this->detail = Html::encode($this->detail);
        return parent::beforeSave($insert);
    }
}
