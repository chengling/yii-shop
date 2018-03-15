<?php

namespace frontend\controllers;

use common\models\goods\mongodb\Goods;
use common\models\goods\mongodb\Attr;
use common\service\goods\GoodsService;
use Qiniu\json_decode;


/**
 * goods controller
 */
class GoodsController extends BaseController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionDetail()
    {
        $request = $this->myRequest();

        $data['goods'] = Goods::findOne((string)$request['id'])->toArray();
        $data['attr'] = Attr::getAttrByCid($data['goods']['cid']);
        //$data['goods'] = Goods::find()->select(['_id','name','shop_price','image'])->where(['id'=>(string)$request['id']])->asArray()->one();dd($data);
        return $this->render('detail',$data);
    }
    
    
    public function actionGetdetail()
    {	
    	$this->layout = false;
    	$request = $this->myRequest();
    	$data = Goods::findOne((string)$request['id'])->toArray();
    	$attr = Attr::getAttrByCid($data['goods']['cid']);
    	return json_encode(['data' =>$data,'attr' =>$attr,'status' =>0]);
    }
    
    
    public function actionList()
    {
    	return $this->render('list');
    }
    
    
    public function actionGetlist()
    {	
    	if(Yii::$app->request->isAjax)
    	{
    		$size = Yii::$app->request->post('size');
    		$offset = Yii::$app->request->post('offset');
    		return GoodsService::getList($size, $offset);
    	}
    }
}