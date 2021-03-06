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

use backend\assets\AttrAsset;
$this->title = '属性管理';
AttrAsset::register($this);
?>
<style>
.attr-box .attr_value i{
	margin:0 5px;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
            	<form id="j_formAttrEdit">
	            	<div class="attr-box">
						<div class="mail-tools tooltip-demo m-t-md">
							<strong>sku属性</strong>
							<a id="add-sku" class="btn btn-white btn-sm" href="javascript:;" title="创建" data-pjax="0"><i class="fa fa-plus"></i> 创建</a>
						</div> 
						<div id="w1" class="fixed-table-header">
							<table class="table table-hover u_tab" id="j_skuAttrTab">
								<thead><tr><th>属性名称</th><th>属性值</th><th>是否上传图片</th><th>操作</th></tr></thead>
								<tbody>
									<?php foreach($data as $value):?>
									<tr class="cate_attr" data-id="<?=$value['_id']?>"><td><input type="text" name="name" value="<?=$value['name']?>"/></td>
									<td><a href="javascript:;" class="attr-val-edit">编辑</a><span class="val attr_value"><?php foreach($value['value'] as $v):?><i><?=$v?></i><?php endforeach;?></span></td>
									 <td><select name="is_allow_img">
																<option value="0" <?php if($value['is_allow_img'] !=1) echo 'selected';?>>否</option>
												            	<option value="1" <?php if($value['is_allow_img'] ==1) echo 'selected';?>>是</option>
												        	</select>
												        </td>
												        <td><a href="javascript:;" class="attr-del">删除</a>
															<input type="hidden" name="value_model" value="1">
            						</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div>  
					</div> 
					<div class="form-group"><button class="btn btn-primary " type="button" style="margin-left:48%" id="j_btnSubmit"><i class="fa fa-check"></i>&nbsp;提交</button></div>     
           		</form>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="add-attr-sku">
	<tr class="cate_attr"><td><input type="text" name="name" /></td>
		<td><a href="javascript:;" class="attr-val-edit">编辑</a><span class="val attr_value"></span></td>
		<td><select name="is_allow_img">
			<option value="0" selected="">否</option>
            <option value="1">是</option>
        </select></td>
		<td><a href="javascript:;" class="attr-del">删除</a>
			<input type="hidden" name="value_model" value="1">
	</tr>
</script>
<script type="text/html" id="add-attr-val-html">
    <div class="f_p30">
        <table class="u_tab" width="100%" id="j_curEdit">
            <tr class="f_fwb">
                <td>属性值</td>
                <td width="100">操作</td>
            </tr>
            {{each val as v i}}
            <tr>
                <td><input type="text" data-id="{{v.id}}" value="{{v.name}}"></td>
                <td><a href="javascript:;" class="attr-del">删除</a></td>
            </tr>
            {{/each}}
        </table>
        <a href="javascript:;" class="u_btn f_mt15" id="add-attr-val">添加</a>
    </div>
</script>
<script type="text/javascript">
    var cate_id = <?= $_GET['id'];?>;
</script>