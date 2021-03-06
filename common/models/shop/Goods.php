<?php

namespace common\models\shop;

use Yii;
use yii\helpers\VarDumper;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for table "ushop_goods".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $name
 * @property string $price
 * @property string $original_price
 * @property string $detail
 * @property string $cat_id
 * @property integer $status
 * @property integer $addtime
 * @property integer $is_delete
 * @property string $attr
 * @property string $service
 * @property integer $sort
 * @property integer $virtual_sales
 * @property string $cover_pic
 * @property string $video_url
 * @property string $unit
 * @property integer $individual_share
 * @property string $share_commission_first
 * @property string $share_commission_second
 * @property string $share_commission_third
 * @property double $weight
 * @property string $freight
 * @property string $full_cut
 * @property string $integral
 * @property integer $use_attr
 * @property integer $share_type
 */
class Goods extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }
	
    

	public static function getDb()
	{
		return \Yii::$app->get('mongodbShop');
	}
	
	
	public function attributes()
	{
		return [
		'_id',
		'cid', //栏目id
		'bid',//品牌id
		'store_id',//商家id
		'shipping_id',//运费模板ID
		'status',//状态 1-上架 0-下架
		'is_delete',//0没有删除1已经删除
		'sort',//排序
		'created_at',
		'updated_at',
		'comment_sum',//评论数量
		'collect_sum',//收藏数量
		'sales_sum',//销售数量
		'virtual_sales',//虚拟销售数量
		'name',//名字
		'short_name',//短名称
		'brief',//商品短介绍
		'image',//相册
		'shop_price',//销售价
		'cost_price',//成本价格
		'weight',//重量
		'content',//详情
		'ext',//扩展属性
		'store',
		'integral',//积分
		'is_product'//是否生成product
		];
	}
	
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'name', 'content'], 'required'],
            [['store_id', 'cat_id', 'status', 'created_at', 'is_delete', 'sort', 'virtual_sales', 'individual_share'], 'integer'],
            [['shop_price', 'cost_price'], 'number'],
            [['content','integral'], 'string'],
            [['name',], 'string', 'max' => 255],
        ];
    }


  

  

    public function getCat()
    {
        return $this->hasOne(Cat::className(), ['id' => 'cat_id']);
    }

    /**
     * 获取商品总库存
     * @param int $id 商品id
     */
    public function getNum($id = null)
    {
        $goods = null;
        if (!$id)
            $goods = $this;
        else {
            $goods = static::findOne($id);
            if (!$goods)
                return 0;
        }
        if (!$goods->attr)
            return 0;
        $num = 0;
        $attr_rows = json_decode($goods->attr, true);
        foreach ($attr_rows as $attr_row) {
            $num += intval($attr_row['num']);
        }
        return $num;
    }

    /**
     * 根据规格获取商品的库存及规格价格信息
     * @param array $attr_id_list 规格id列表 eg. [1,4,9]/["绿色","18"]
     * @return array|null eg.
     */
    public function getAttrInfo($attr_id_list)
    {	
    	if(!$this->is_product)
    	{
    		return null;
    	}
    	$product = Product::find()->where(['goods_id' => $this->_id])->select(['shop_price','store','attr','id'])->asArray()->all();
        if (empty($product))
        {
            return null;
        }
        
        foreach ($product as $k => $v) {
        	$attr = json_decode($v['attr'],true);
        	$find = false;
        	foreach($attr as $at)
        	{
        	   if(!in_array($at['value'],$attr_id_list))
        		{	
        			$find = false;
        	    	break;
        		}
        		$find = true;	
        	}
        	if($find)
        	{
        	  return ['price' => $v['shop_price'],'num' => $v['store'],'product_id'=>$v['id'],'seckill_data' =>[]];
        	}
        }
        return null;
    }

    /**
     * 获取商品可选的规格列表
     */
    public function getAttrGroupList()
    {	
    	if(!$this->is_product)
    	{
    		return null;
    	}
       	$products = Product::find()->where(['goods_id' => $this->_id])->select(['attr'])->all();
       	$hasAttr = [];
       	foreach($products as $p)
       	{	
       		$hasAttr = array_merge($hasAttr,(array_column(json_decode($p->attr,true),'value')));
       	}
        $attr = json_decode($products[0]->attr,true);
        $attr_group_list = [];
        if($attr)
        {	//拼装数据的格式 根据接口变化调整
        	foreach($attr as $v)
        	{
        		$attrInfo = Attr::findOne($v['attr_id'])->toArray();
        		$tmp = [];
        		$tmp['attr_group_id'] = $attrInfo['_id'];
        		$tmp['attr_group_name'] = $attrInfo['name'];
        		$attrList = [];
        		foreach($attrInfo['value'] as $k=>$a)
        		{	
        			if(!in_array($a, $hasAttr))
        			{
        				continue;
        			}
        			$tmpAttrList = [];
        			$tmpAttrList['attr_id'] = $k;
        			$tmpAttrList['attr_name']= $a;
        			$attrList[] = $tmpAttrList;
        		}
        		$tmp['attr_list'] = $attrList;
        		$attr_group_list[] = $tmp;
        	}
        }
       	return $attr_group_list;
    }

    /**
     * 库存增加操作
     */
    public function numAdd($attr_id_list, $num)
    {
        sort($attr_id_list);
        $attr_group_list = json_decode($this->attr);
        $add_attr_num = false;
        foreach ($attr_group_list as $i => $attr_group) {
            $group_attr_id_list = [];
            foreach ($attr_group->attr_list as $attr)
                array_push($group_attr_id_list, $attr->attr_id);
            sort($group_attr_id_list);
            if (!array_diff($attr_id_list, $group_attr_id_list)) {
                $attr_group_list[$i]->num = intval($attr_group_list[$i]->num) + $num;
                $add_attr_num = true;
                break;
            }
        }
        if (!$add_attr_num)
            return false;
        $this->attr = json_encode($attr_group_list, JSON_UNESCAPED_UNICODE);
        $this->save();
        return true;
    }

    /**
     * 库存减少操作
     * @param array $attr_id_list eg. [1,4,2]
     */
    public function numSub($attr_id_list, $num)
    {
        sort($attr_id_list);
        $attr_group_list = json_decode($this->attr);
        $sub_attr_num = false;
        foreach ($attr_group_list as $i => $attr_group) {
            $group_attr_id_list = [];
            foreach ($attr_group->attr_list as $attr)
                array_push($group_attr_id_list, $attr->attr_id);
            sort($group_attr_id_list);
            if (!array_diff($attr_id_list, $group_attr_id_list)) {
                if ($num > intval($attr_group_list[$i]->num))
                    return false;
                $attr_group_list[$i]->num = intval($attr_group_list[$i]->num) - $num;
                $sub_attr_num = true;
                break;
            }
        }
        if (!$sub_attr_num)
            return false;
        $this->attr = json_encode($attr_group_list, JSON_UNESCAPED_UNICODE);
        $this->save();
        return true;
    }

    /**
     * 库存增加操作
     */
    public static function numAddStatic($goods_id, $attr_id_list, $num)
    {
        $goods = Goods::findOne($goods_id);
        if (!$goods)
            return false;
        return $goods->numAdd($attr_id_list, $num);
    }

    /**
     * 库存减少操作
     */
    public static function numSubStatic($goods_id, $attr_id_list, $num)
    {
        $goods = Goods::findOne($goods_id);
        if (!$goods)
            return false;
        return $goods->numSub($attr_id_list, $num);
    }

    /**
     * 获取商品销量
     */
    public function getSalesVolume()
    {
        $res = OrderDetail::find()->alias('od')
            ->select('SUM(od.num) AS sales_volume')
            ->leftJoin(['o' => Order::tableName()], 'od.order_id=o.id')
            ->where(['od.is_delete' => 0, 'od.goods_id' => $this->id, 'o.is_delete' => 0, 'o.is_pay' => 1,])
            ->asArray()->one();
        return empty($res['sales_volume']) ? 0 : intval($res['sales_volume']);
    }

    /**
     * 减满
     */
    public function cutFull($goodsList)
    {
        // 将商品ID相同的商品合并
        $newGoodsList = [];
        foreach ($goodsList AS $row) {
            if (isset($newGoodsList[$row['goods_id']])) {
                $newGoodsList[$row['goods_id']]['num'] += $row['num'];
                $newGoodsList[$row['goods_id']]['weight'] += $row['weight'] * $row['num'];
                $newGoodsList[$row['goods_id']]['price'] += $row['price'] * $row['num'];
            } else {
                $newGoodsList[$row['goods_id']] = $row;
            }
        }
        $resGoodsList = [];
        foreach ($newGoodsList AS $val) {
            if ($val['full_cut']) {
                $full_cut = json_decode($val['full_cut'], true);
            } else {
                $full_cut = json_decode([
                    'pieces' => 0,
                    'forehead' => 0,
                ], true);
            }

            if ((empty($full_cut['pieces']) || $val['num'] < ($full_cut['pieces'] ?: 0)) && (empty($full_cut['forehead']) || $val['price'] < ($full_cut['forehead'] ?: 0))) {
                $resGoodsList[] = $val;
            }


        }
        return $resGoodsList;
    }

    public static function getGoodsCard($id = null)
    {
        if (!$id) {
            return [];
        }
        //商品卡券
        $goods_card_list = GoodsCard::find()->alias('gc')->where(['gc.is_delete' => 0, 'goods_id' => $id])
            ->leftJoin(Card::tableName() . ' c', 'c.id=gc.card_id')->select([
                'gc.card_id', 'c.name', 'c.pic_url', 'gc.goods_id', 'c.content'
            ])->asArray()->all();
        foreach ($goods_card_list as $index => $value) {
            $goods_card_list[$index]['id'] = $value['card_id'];
        }
        return $goods_card_list;
    }

    public function getAttrData()
    {
        if ($this->isNewRecord)
            return [];
        if (!$this->use_attr) {
            return [];
        }
        if (!$this->attr)
            return [];
        $attr_group_list = [];

        $attr_data = json_decode($this->attr, true);
        foreach ($attr_data as $i => $attr_data_item) {
            foreach ($attr_data[$i]['attr_list'] as $j => $attr_list) {
                $attr_group = $this->getAttrGroupByAttId($attr_data[$i]['attr_list'][$j]['attr_id']);
                if ($attr_group) {
                    $in_list = false;
                    foreach ($attr_group_list as $k => $exist_attr_group) {
                        if ($exist_attr_group['attr_group_name'] == $attr_group->attr_group_name) {
                            $attr_item = [
                                'attr_name' => $attr_data[$i]['attr_list'][$j]['attr_name'],
                            ];
                            if (!in_array($attr_item, $attr_group_list[$k]['attr_list']))
                                $attr_group_list[$k]['attr_list'][] = $attr_item;
                            $in_list = true;
                        }
                    }
                    if (!$in_list) {
                        $attr_group_list[] = [
                            'attr_group_name' => $attr_group->attr_group_name,
                            'attr_list' => [
                                [
                                    'attr_name' => $attr_data[$i]['attr_list'][$j]['attr_name'],
                                ],
                            ],
                        ];
                    }
                }
            }
        }
        return $attr_group_list;
    }

    public function getCheckedAttrData()
    {
        if ($this->isNewRecord)
            return [];
        if (!$this->use_attr) {
            return [];
        }
        if (!$this->attr)
            return [];
        $attr_data = json_decode($this->attr, true);
        foreach ($attr_data as $i => $attr_data_item) {
            if (!isset($attr_data[$i]['no']))
                $attr_data[$i]['no'] = '';
            if (!isset($attr_data[$i]['pic']))
                $attr_data[$i]['pic'] = '';
            foreach ($attr_data[$i]['attr_list'] as $j => $attr_list) {
                $attr_group = $this->getAttrGroupByAttId($attr_data[$i]['attr_list'][$j]['attr_id']);
                $attr_data[$i]['attr_list'][$j]['attr_group_name'] = $attr_group ? $attr_group->attr_group_name : null;
            }
        }
        return $attr_data;
    }

    private function getAttrGroupByAttId($att_id)
    {
        $cache_key = 'get_attr_group_by_attr_id_' . $att_id;
        $attr_group = Yii::$app->cache->get($cache_key);
        if ($attr_group)
            return $attr_group;
        $attr_group = AttrGroup::find()->alias('ag')
            ->leftJoin(['a' => Attr::tableName()], 'a.attr_group_id=ag.id')
            ->where(['a.id' => $att_id])
            ->one();
        if (!$attr_group)
            return $attr_group;
        Yii::$app->cache->set($cache_key, $attr_group, 10);
        return $attr_group;
    }

}
