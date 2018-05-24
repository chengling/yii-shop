<?php
namespace frontend\controllers;

use common\libs\CommonController;
use common\service\CategoryService;
use Yii;
use common\models\Options;

/**
 * Base controller
 */
class BaseController extends CommonController
{
    public $category = [];
    
    protected $loginController = ['cart','order','address'];
    
    protected  $userId;
    
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $view = YII::$app->view;
        $options = Options::find()->where(['<','id',4])->select('*')->asArray()->all();
        $view->params['title'] = $options[2]['value'];
        $view->params['keywords'] = $options[0]['value'];
        $view->params['description'] = $options[1]['value'];
        
        $controller = $action->controller->id;
        if(Yii::$app->user->isGuest)
        {
        	$view->params['isLogin'] = '0';
        }else
        {
        	$view->params['isLogin'] = '1';
        	$this->userId = Yii::$app->user->identity->id;
        }
        if(Yii::$app->request->isAjax)
        {	
        	$this->layout = false;
        	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
    }
    
    
    public function beforeAction($action)
    {
    	$controller =  $action->controller->id;
    	if(in_array($controller, $this->loginController) && Yii::$app->user->isGuest)
    	{
	 		if(Yii::$app->request->isAjax)
	 		{
	 			exit(json_encode(['status' =>1,'msg' =>'请先进行登录操作']));
	 		}else
	 		{
	 			return $this->redirect('/site/login');
	 		}   		
    	}
    	return true;
    }
	
}