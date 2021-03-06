<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%pt_order_detail}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property integer $num
 * @property string $total_price
 * @property integer $addtime
 * @property integer $is_delete
 * @property string $attr
 * @property string $pic
 */
class PtOrderDetail extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pt_order_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'attr', 'pic'], 'required'],
            [['order_id', 'goods_id', 'num', 'addtime', 'is_delete'], 'integer'],
            [['total_price'], 'number'],
            [['attr'], 'string'],
            [['pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'num' => '商品数量',
            'total_price' => '此商品的总价',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
            'attr' => '商品规格',
            'pic' => '商品规格图片',
        ];
    }
}
