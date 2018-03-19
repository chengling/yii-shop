<?php
/**
 * Created by PhpStorm.
 * User: grace
 * Date: 2017\12\7 0007
 * Time: 13:56
 */

namespace common\service\goods;


use common\models\goods\mongodb\Goods;
use common\models\goods\Category;
use common\service\BaseService;
use common\models\goods\Store;
use common\models\goods\Product;

class GoodsService extends BaseService
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public static function index($request=[])
    {	
    	$categorys = Category::find()->select('*')->where(['in','id',[5,6]])->asArray()->all();
        $goods = Goods::find()->select(['name','short_name','cid','image'])->where(['cid'=>[5,6]])->asArray()->all();
    	$categoryList = [];
    	$goodsList = [];
    	foreach ($goods as $v)
    	{
    		$goodsList[$v['cid']][] = $v;
    	}
    	foreach ($categorys as $v)
    	{
    		$categoryList[$v['id']] = $v;
    		$categoryList[$v['id']]['goods'] = $goodsList[$v['id']];
    	}
    	return $categoryList;
    }
	
    
    public static function getList($size,$offset)
    {	
    	$size = $size ?: 10;
    	$offset = $offset ?: 0;
     	$goods = Goods::find()->select(['name','short_name','cid','image','_id','shop_price'])->limit($size)->offset($offset)->asArray()->all();
    	return $goods ?: [];
    }
    
    
    public static function getOne($id)
    {
    	return Goods::find()->where(['_id' =>$id])->select(['name','short_name','cid','image','shop_price','_id','content','ext'])->asArray()->one();
    }
    /**
     * 获取库存
     * */
	public static function getStore($goodsId)
	{
		$store = Store::findOne(['goods_id' => $goodsId])->asArray()->one();
		return $store['store'];
	}  

	/**
	 * 获取库存
	 * */
	public static function getProductStore($productId)
	{
		$product = Product::findOne($productId);
		return $product->store;
	}
    
}