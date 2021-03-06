<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/17
 * Time: 11:47
 */

namespace app\controllers;


use common\models\shop\Order;
use app\behaviors\LoginBehavior;
use app\modules\api\models\ExpressDetailForm;
use common\models\shop\form\LocationForm;
use common\models\shop\form\OrderClerkForm;
use common\models\shop\form\OrderCommentForm;
use common\models\shop\form\OrderCommentPreview;
use common\models\shop\form\OrderConfirmForm;
use common\models\shop\form\OrderDetailForm;
use common\models\shop\form\OrderListForm;
use common\models\shop\form\OrderPayDataForm;
use common\models\shop\form\OrderRefundDetailForm;
use common\models\shop\form\OrderRefundForm;
use common\models\shop\form\OrderRefundPreviewForm;
use common\models\shop\form\OrderRevokeForm;
use common\models\shop\form\OrderSubmitForm;
use common\models\shop\form\OrderSubmitPreviewForm;
use common\models\shop\form\QrcodeForm;
use yii\helpers\VarDumper;

class OrderController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'login' => [
                'class' => LoginBehavior::className(),
            ],
        ]);
    }

    //订单提交前的预览页面
    public function actionSubmitPreview()
    {
        $form = new OrderSubmitPreviewForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //订单提交
    public function actionSubmit()
    {
        $form = new OrderSubmitForm();
        $model = \Yii::$app->request->post();
        if($model['offline'] == 0){
            $form->scenario = "EXPRESS";
        }else{
            $form->scenario = "OFFLINE";
        }
        $form->attributes = $model;
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        //$form->version = $this->version;
        $this->renderJson($form->save());
    }

    //订单支付数据
    public function actionPayData()
    {
        $form = new OrderPayDataForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user = \Yii::$app->user->identity;
        $this->renderJson($form->search());
    }

    //订单列表
    public function actionList()
    {
        $form = new OrderListForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //订单取消
    public function actionRevoke()
    {
        $form = new OrderRevokeForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }

    //订单确认收货
    public function actionConfirm()
    {
        $form = new OrderConfirmForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }

    //订单各个状态数量
    public function actionCountData()
    {
        $res = OrderListForm::getCountData($this->store->id, \Yii::$app->user->id);
        return $this->renderJson([
            'code' => 0,
            'msg' => 'success',
            'data' => $res,
        ]);
    }


    //订单详情
    public function actionDetail()
    {
        $form = new OrderDetailForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //售后页面
    public function actionRefundPreview()
    {
        $form = new OrderRefundPreviewForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //售后提交
    public function actionRefund()
    {
        $form = new OrderRefundForm();
        $form->attributes = \Yii::$app->request->post();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }

    //售后订单详情
    public function actionRefundDetail()
    {
        $form = new OrderRefundDetailForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //评论预览页面
    public function actionCommentPreview()
    {
        $form = new OrderCommentPreview();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //评论提交
    public function actionComment()
    {
        $form = new OrderCommentForm();
        $form->attributes = \Yii::$app->request->post();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }

    //订单物流信息
    public function actionExpressDetail()
    {
        $form = new ExpressDetailForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }
    //核销订单
    public function actionClerk()
    {
        $form = new OrderClerkForm();
        $form->order_id = \Yii::$app->request->get('order_id');
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }
    //核销订单详情
    public function actionClerkDetail()
    {
        if(\Yii::$app->user->identity->is_clerk != 1){
            $this->renderJson([
                'code' => 1,
                'msg' => '不是核销员禁止核销'
            ]);
        }
        $form = new OrderDetailForm();
        $form->order_no = \Yii::$app->request->get('order_no');
        $form->store_id = $this->store->id;
//        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->clerk());
    }
    public function actionGetQrcode()
    {
        $order_no = \Yii::$app->request->get('order_no');
        $order = Order::findOne(['order_no'=>$order_no,'store_id'=>$this->store->id]);
        $form = new QrcodeForm();
//        $form->order_no = $order_no;
        $form->data = [
            'scene'=>"{$order_no}",
            'page'=>"pages/clerk/clerk",
            'width'=>100
        ];
        $form->store = $this->store;
        $res = $form->getQrcode();
        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }

    public function actionLocation()
    {
        $form = new LocationForm();
        $form->store_id = $this->store->id;
        $form->attributes = \Yii::$app->request->get();
        $this->renderJson($form->search());
    }
}