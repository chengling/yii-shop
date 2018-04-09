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
	
    
    public static function getList($page,$size)
    {	
    	$size = $size ?: 10;
    	$page = $page ?: 1;
    	$offset = ($page-1)*$size;
     	$goods = Goods::find()->select(['name','short_name','cid','image','_id','shop_price'])->orderBy('updated_at desc')->limit($size)->offset($offset)->asArray()->all();
    	return $goods ?: [];
    }
    
    
    public static function getCount()
    {
    	return Goods::find()->count();
    }
    
    
    public static function getOne($id)
    {
    	$data = Goods::find()->where(['_id' =>$id])->select(['name','short_name','cid','image','shop_price','_id','content','ext'])->asArray()->one();
    	if($data['content'])
    	{
	    	$data['content'] = htmlspecialchars_decode($data['content']);
    	}
    	return $data ?: [];
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
	
	/**
	* @desc 根据id查询
	*/
	public static function getListByids(array $data)
	{
		$goodsIds = array_column($data,'goods_id');
		$data = Goods::find()->where(['in','_id',$goodsIds])->select(['image','_id','shop_price','name'])->asArray()->all();
		return $data ?: [];
	}
    
	
}