<?php
namespace frontend\controllers;

use common\libs\CommonController;
use common\service\CategoryService;
use Yii;

/**
 * Base controller
 */
class BaseController extends CommonController
{
    public $category = [];
    
    protected $loginController = ['cart'];
    
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $view = YII::$app->view;
        $controller = $action->controller->id;
        if(Yii::$app->user->isGuest)
        {
        	$view->params['isLogin'] = '0';
        }else
        {
        	$view->params['isLogin'] = '1';
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
	 			return false;
	 		}else
	 		{
	 			return $this->redirect('/site/login');
	 		}   		
    	}
    	return true;
    }
	
}