<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%goods_card}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $card_id
 * @property integer $is_delete
 * @property integer $addtime
 */
class GoodsCard extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'card_id', 'is_delete', 'addtime'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'card_id' => '卡券id',
            'is_delete' => 'Is Delete',
            'addtime' => 'Addtime',
        ];
    }
}
