<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-21 14:14
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use backend\grid\GridView;
use backend\widgets\Bar;
use yii\helpers\Html;
use backend\models\FriendLink;
use yii\helpers\Url;
use common\libs\Constants;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;

$this->title = "品牌";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh} {create} {delete}',
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                        [
                            'attribute' => 'name',
                        ],
                         [
                            'attribute' => 'image',
                			'format' => [
                				'image',['width'=>'84','height'=>'84']
                			],
							'value'=>function($model){
								return Yii::$app->params['image'].($model->image);
							}
						 ],
                        [
                            'attribute' => 'created_at',
                            'format' => ['date','php:Y-m-d'],
                			'label' =>'创建时间',
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => ['date','php:Y-m-d'],
                			'label' =>'修改时间',
                        ],
                        [
                            'class' => ActionColumn::className(),
                        ]
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>