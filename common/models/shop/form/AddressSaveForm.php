<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/25
 * Time: 15:44
 */

namespace common\models\shop\form;


use common\models\shop\Address;
use common\models\shop\District;

class AddressSaveForm extends Model
{
    public $store_id;
    public $user_id;
    public $address_id;
    public $name;
    public $mobile;
    public $province_id;
    public $city_id;
    public $district_id;
    public $detail;
    
    public $province;
    public $city;
    public $district;

    public function rules()
    {
        return [
            [['name', 'mobile', 'province_id', 'city_id', 'district_id', 'detail'], 'trim'],
            [['name', 'mobile', 'province_id', 'city_id', 'district_id', 'detail',], 'required','on' =>'weixin'],
            [['name', 'mobile', 'province', 'city', 'district', 'detail',], 'required','on' => 'pc'],
            [['address_id','user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '收货人',
            'mobile' => '联系电话',
            'province_id' => '所在地区',
            'city_id' => '所在地区',
            'district_id' => '所在地区',
            'detail' => '详细地址',
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->getModelError();
        $address = Address::findOne([
            'user_id' => $this->user_id,
            'id' => $this->address_id,
        ]);
        if (!$address) {
            $address = new Address();
            $address->user_id = $this->user_id;
            $address->is_default = 0;
            $address->created_at = time();
        }
        $address->name = $this->name;
        $address->mobile = $this->mobile;
        $address->detail = $this->detail;

        $province = District::findOne($this->province_id);
        if (!$province) {
            return [
                'code' => 1,
                'msg' => '省份数据错误，请重新选择',
            ];
        }
        $address->province_id = $province->id;
        $address->province = $province->name;

        $city = District::findOne($this->city_id);
        if (!$city) {
            return [
                'code' => 1,
                'msg' => '城市数据错误，请重新选择',
            ];
        }
        $address->city_id = $city->id;
        $address->city = $city->name;

        $district = District::findOne($this->district_id);
        if (!$district) {
            return [
                'code' => 1,
                'msg' => '地区数据错误，请重新选择',
            ];
        }
        $address->district_id = $district->id;
        $address->district = $district->name;

        if ($address->save()) {
            return [
                'code' => 0,
                'msg' => '保存成功',
            ];
        } else {
            return [
                'code' => 1,
                'msg' => '操作失败，请稍后重试',
            ];
        }

    }
    
    
    public function saveIgnore()
    {
    	if (!$this->validate())
    		return $this->getModelError();
    	$address = Address::findOne([
    			'user_id' => $this->user_id,
    			'id' => $this->address_id,
    			]);
    	if (!$address) {
    		$address = new Address();
    		$address->user_id = $this->user_id;
    		$address->is_default = 0;
    		$address->created_at = time();
    	}
    	$address->name = $this->name;
    	$address->mobile = $this->mobile;
    	$address->detail = $this->detail;
    	
    	$address->province = $this->province;
    	
    	$address->city = $this->city;
    	$address->district = $this->district;
    	
    	if ($address->save()) {
    		return [
    		'code' => 0,
    		'msg' => '保存成功',
    		];
    	} else {
    		$errors = $address->getErrors();
    		print_r($errors);exit;
    		return [
    		'code' => 1,
    		'msg' => '操作失败，请稍后重试',
    		];
    	}
    }
}