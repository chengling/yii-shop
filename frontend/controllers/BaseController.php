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
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $view = YII::$app->view;
        $view->params['category'] = CategoryService::index();
    }

}