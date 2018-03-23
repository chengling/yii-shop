<?php
/**
 * Created by PhpStorm.
 * User: grace
 * Date: 2017\12\7 0007
 * Time: 13:56
 */

namespace common\service\goods;

use Yii;
use common\models\goods\mongodb\Goods;
use common\service\BaseService;
use common\models\goods\mongodb\Cart;
class CartService extends BaseService
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }
	
    /**
     * 添加 到购物车(在没有登录的时候)
     * */
    public static function addCart($goodsNum,$goodsId)
    {	
    	$cookie = \Yii::$app->request->cookies;
    	$key = Yii::$app->params['goods.cart'];
    	$data = [];
    	if($cookie->has($key))
    	{
    		$data = $cookie->getValue($key);
    		$data = json_decode($data,true);
    		if(isset($data[$goodsId]))
    		{
    			$data[$goodsId]+=$goodsNum;
    		}else{
    			$data[$goodsId] = $goodsNum;
    		}
    	}else
    	{	
    		$data[$goodsId] = $goodsNum;
    	}
    	$cookie = new \yii\web\Cookie([
    			'name' => $key,
    			'expire' => time() + 3600*24*30,
    			'httpOnly' => true,
    			'value' => json_encode($data) 
    	 ]);
    	Yii::$app->response->getCookies()->add($cookie);
    }
    
    
    
    public static function addLoginCart($goodsNum,$goodsId)
    {
    	$userId = Yii::$app->user->identity->id;
    	$data = ['goods_num'=>$goodsNum,'goods_id' =>$goodsId,'created_at' => time(),'user_id' => $userId];
    	$model = Cart::findOne(['goods_id' =>$goodsId,'user_id' =>$userId]);
    	if($model)
    	{
    		$model->goods_num+=$goodsNum;
    		$model->save();
    	}else
    	{
    		$cartModel = new Cart();
    		$cartModel->setAttributes($data,false);
    		$cartModel->save();
    	}
    	
    	return true;
    	
    }
    
    /*
     * 把没有登录前的购物车放入到mongodb
     * **/
    private static function tranfer()
    {	
    	$userId = Yii::$app->user->identity->id;
    	$cookie = Yii::$app->request->cookies;
    	$key = Yii::$app->params['goods.cart'];
    	$data =  json_decode($cookie->getValue($key),true);
    	foreach($data as $k => $v)
    	{
    		$model = Goods::findOne(['goods_id' =>$k,'user_id' =>$userId]);
    		if($model)
    		{
	    		$model->goods_num+=$v;
	    		$model->save();
    		}else
    		{
    			$goodsModel = new Goods();
    			$cart = ['goods_num'=>$v,'goods_id' =>$k,'created_at' => time(),'user_id' => $userId];
    			$goodsModel->setAttributes($cart,false);
    			$goodsModel->save();	
    		}
    	}
    	$cookie->remove($key);
    	return true;
    }
    
    
    public static function getList()
    {
    	$cookie = \Yii::$app->request->cookies;
    	$key = Yii::$app->params['goods.cart'];
    	$data =  json_decode($cookie->getValue($key),true);
    	$result = [];
    	if($data)
    	{
	    	foreach($data as $k=>$v)
	    	{	
				$temp = [];
	    		$goods = Goods::find($k)->asArray()->one();
	    		$temp['shop_price'] = $goods['shop_price'];
	    		$temp['name'] = $goods['name'];
	    		$temp['image'] = $goods['image'][0];
	    		$temp['goods_num'] = $v;
	    		$result[] = $temp;
	    	}
    	}
    	return $result;
    }
    
    
    
    /**
     * @desc 登录的情况 下
     */
    public static function getCartData()
    {
    	$userId = Yii::$app->user->identity->id;
    	$data = Cart::find()->where(['user_id' =>$userId])->select(['user_id','goods_id','goods_num'])->asArray()->all();
    	$result = [];
    	if($data)
    	{
    		foreach($data as $k=>$v)
    		{
    			$temp = [];
    			$goods = Goods::find()->where(['_id' =>$v['goods_id']])->asArray()->one();
    			$temp['shop_price'] = $goods['shop_price'];
    			$temp['name'] = $goods['name'];
    			$temp['image'] = $goods['image'][0];
    			$temp['goods_num'] = $v['goods_num'];
    			$temp['id'] = $v['_id'];
    			$temp['goods_id'] = $v['goods_id'];
    			$result[$k] = $temp;
    		}
    	}
    	return $result;
    }
    
    /**
    * @desc 不建议用deleteAll
    */
    public static function remove($pk)
    {
    	$userId = Yii::$app->user->identity->id;
    	$cartModel = Cart::findOne($pk);
    	if($cartModel->user_id == $userId)
    	{
    		$cartModel->delete();
    	}
    	return true;
    }

}