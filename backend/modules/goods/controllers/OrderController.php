<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\modules\goods\controllers;

use yii\data\ActiveDataProvider;
use backend\models\order\Order;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use common\service\order\ShippingService;
use common\service\order\OrderService;
use PHPExcel;
use PHPExcel_Writer_Excel5;
use Yii;
/**
 * FriendLink controller
 */
class OrderController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $searchModel = new Order();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel
                    ];
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Order::className(),
            ],
        ];
    }
	
    
    /**
    * @desc 发货
    */
    public function actionSend($id)
    {	
    	if(yii::$app->getRequest()->getIsPost())
    	{
    		if (! $id) throw new BadRequestHttpException(yii::t('app', "Id doesn't exit"));
    		$invoiceNo = Yii::$app->request->post('invoice_no');
    		$shippingId = Yii::$app->request->post('shipping_id');
    		$orderService = new OrderService();
    		if($orderService->send($id, $shippingId, $invoiceNo))
    		{
    			Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
    			return $this->redirect(['index']);
    		}
    		
    		Yii::$app->getSession()->setFlash('error', yii::t('app', 'Error'));
    		return $this->redirect(['index']);
    		
    	}else
    	{
	    	$service = new ShippingService();
	    	$data = $service->getList();
	    	return $this->render('send',['data' => $data]);
    	}
    	
    }
    
    
    public function actionViewLayer($id)
    {
    	$service = new OrderService();
    	$data = $service->getOrderGoodsByOrderId($id);
    	$model = Order::findOne($id);
    	return $this->render('view',['data' => $data,'model' =>$model]);
    }
    
    
    public function actionExport()
    {	
    	ob_end_clean() ; //解决ob缓存导致导出乱码的问题
    	$searchModel = new Order();
    	$dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
    	$query = $dataProvider->query;
    	$count = $query->count();
    	if($count>1000)
    	{
    		return ['code' => 1, 'message' => '导出的数据太于1000条，请筛选一些重试'];
    	}
    	$data = $query->select(['order_sn','trade_no','invoice_no','consignee','mobile','address'])->asArray()->all();
    	$objPHPExcel = new \PHPExcel();
    	
    	//表头的信息
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "订单号")->setCellValue('B1', "交易订单号")
    	->setCellValue('C1', "订单金额")->setCellValue('D1', "订单状态")->setCellValue('E1', "用户");
    	
    	$i=2;
    	foreach ($data as $key => $value) {
    		$objPHPExcel->getActiveSheet()                  //设置第一个内置表（一个xls文件里可以有多个表）为活动的
    			->setCellValue( 'A'.$i, $value['order_sn'] )       //给表的单元格设置数据
    			->setCellValue( 'B'.$i, $value['trade_no'] )      //数据格式可以为字符串
    			->setCellValue( 'C'.$i, $value['order_amount'])            //数字型
    			->setCellValue( 'D'.$i, $value['order_status'] )            //
    			->setCellValue( 'E'.$i, $value['user_id'] )           //布尔型
    			$i++;
    	}
    	
    	
    	$objActSheet =$objPHPExcel->getActiveSheet();
    	
    	$objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    	$objWriter->save('myexchel.xlsx');
    	header('Content-Type:application/vnd.ms-excel');
    	header('Content-Disposition:attachment;filename="订单'.date('Ymd').'.xls"');
    	header('Cache-Control:max-age=0');
    	$objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    	$objWriter->save('php://output');
    	return ['code' => 0, 'message' => '导出成功'];
    }
}
