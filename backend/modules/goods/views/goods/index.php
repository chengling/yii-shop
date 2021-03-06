<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 17:51
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider frontend\models\User
 * @var $searchModel backend\models\UserSearch
 */

use backend\grid\GridView;
use frontend\models\User;
use yii\helpers\Html;
use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;

$this->title = 'Users'
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh} {selectcate} {delete}',
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                        [
                            'attribute' => '_id',
                        ],
                		[
                			'attribute' => 'name'
                		],
                		[
                		'attribute' => 'virtual_sales'
                				],
                		[
                		'attribute' => 'sort'
                		],
                		[
                			'attribute' =>'status',
                			'value' => function($model){
                				return $model->goodsStatus[$model->status];
                			}
                		],
                		[
                			'attribute' => 'image',
                			'format' => [
                				'image',['width'=>'84','height'=>'84']
                			],
                			'value'=>function($model){
                				$images =(array)($model->image);	
               					return $images ? Yii::$app->params['image'].$images[0] : '';
               				 }
                		],
                        [
                            'attribute' => 'virtual_sales'
                        ],
                        [
                            'attribute' => 'shop_price'
                        ],
						/*[
							'attribute' => 'created_at',
							'format' => ['date','php:Y-m-d'],
							'filter' => Html::activeInput('text', $searchModel, 'create_start_at', [
									'class' => 'form-control layer-date',
									'placeholder' => '',
									'onclick' => "laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'});"
									]) . Html::activeInput('text', $searchModel, 'create_end_at', [
											'class' => 'form-control layer-date',
											'placeholder' => '',
											'onclick' => "laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
									]),
						],*/
                		[
                			'attribute' => 'updated_at',
                			'format' => ['date','php:Y-m-d'],
                			'label' =>'修改时间'
                		],
                        [
                            'class' => ActionColumn::className(),
                            'width' => '190px'
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>