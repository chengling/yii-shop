<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\CartService;
class CartController extends BaseController
{


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAddcart()
    {	
    	$goodsNum = (int)Yii::$app->request->get('goods_num');
    	$goodsId = (string)Yii::$app->request->get('goods_id');
    	if(Yii::$app->user->isGuest)
    	{
    		CartService::addCart($goodsNum, $goodsId);
    	}else
    	{
    		CartService::addLoginCart($goodsNum, $goodsId);	
    	}
        
       	return json_encode(['status' => 0,'msg'=>'添加成功']);
    }
    
    
    
    
    public function actionIndex()
    {	
    	$cart = [];
    	if(Yii::$app->user->isGuest)
    	{
    		$cart = CartService::getCart();
    	}
    	return $this->render('index',['cart'=>$cart]);
    }
}