<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>{$ym_title}</title>
		<meta name="keywords" content="{$ym_keywords}" />
		<meta name="description" content="{$ym_description}" />
		<link rel="stylesheet" href="css/common.css" />
		<link rel="stylesheet" href="css/animate.min.css" />
		<style>
			.nav nav ul li a.ahover {
				border-bottom-color: #de342f;
			}
		</style>
	</head>

	<body>
<!--{tpl header}-->
		<div class="navtitleright nb"><a href="index.html">首页</a> {$crumbs_nav}</div>
		<div class="indbody pro-style">
			<div class="nb recom-box">
				<div class="part-price-sort">
					<ul class="pps">
						<li class="readychoose">
							<div class="lside-name">已选择</div>
							<div class="rside-navtitle">
								<!--{if $catinfo[name]}-->
								<a href="{if $lasturl}{$lasturl}{else}list.html?at={$at}&page={$page}&pr={$pr}{/if}" title="取消选择" style="margin-right:10px;">分类：<span>{$catinfo[name]}<em>×</em></span></a>
								<!--{/if}-->
								<!--{if $pr !='全部'}-->
								<a href="{$price_grade[0]['url']}" title="取消选择" style="margin-right:10px;">价格：<span>{$pr}<em>×</em></span></a>
								<!--{/if}-->
								<!--{loop $at_param $p}-->
								<a href="{$p[url]}" title="取消选择" style="margin-right:10px;">{$p[name]}：<span>{$p[val]}<em>×</em></span></a>
								<!--{/loop}-->
								{if $coupon}
								<span style="font-size: 16px; color: #2ab6b9;">优惠券：{$coupon['name']} 【满 {$coupon['amount_reached']}元减{$coupon['amount']}元】</span>
								{/if}
							</div>
						</li>
						<!--{if $cat_child}-->
						<li>
							<div class="lside-name">分类</div>
							<div class="rside-navtitle">
								<!--{loop $cat_child $p}-->
								<a href="{$p[url]}" {if $son==$p['id']}class="red"{/if}>{$p[name]}</a>
								<!--{/loop}-->
							</div>
						</li>
						<!--{/if}-->
						<!--{if $brand}-->
						<li>
							<div class="lside-name">品牌</div>
							<div class="rside-navtitle">
								<!--{loop $brand $p}-->
								<a href="{$p[url]}" {if $bid==$p['id']}class="red"{/if}>{$p['name']}</a>
								<!--{/loop}-->
							</div>
						</li>
						<!--{/if}-->
						<li>
							<div class="lside-name">价格</div>
							<div class="rside-navtitle">
								<!--{loop $price_grade $p}-->
								<a href="{$p['url']}" {if $pr==$p['name']}class="red"{/if}>{$p['name']}</a>
								<!--{/loop}-->
								 <span class="setprice">
								 	<input type="text" id="price-min" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');"/> - <input type="text" id="price-max" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" />
								 	<input type="button" id="btnprice" value="确定"/>
								 </span>
							</div>
						</li>
						<!--{if !$word && $word ==''}-->
						<!--{loop $attr $p}-->
						<li>
							<div class="lside-name">{$p[name]}</div>
							<div class="rside-navtitle">
								<!--{loop $p[value] $v}-->
								<a href="{$v['url']}" {if $v['cur']== 1}class="red"{/if}>{$v['name']}</a>
								<!--{/loop}-->
							</div>
						</li>
						<!--{/loop}-->
						<!--{/if}-->
						<li>
							<div class="lside-name">排序方式</div>
							<div class="rside-navtitle some-px">
								<a href="{$sort_add_time}" {$cur['a1']}>默认</a>
								<a href="{$sort_sale}" {$cur['s1']}><span>销量</span></a>
								<a href="{$sort_price}" {$cur['p1']}{$cur['p2']}><span class="price">价格</span><b {if $sort=='p2'}class="down"{elseif $sort=='p1'}class="up"{else}{/if}></b></a>
							</div>
						</li>
					</ul>
				</div>
                   <ul class="yourlike clearovermartb nobottompad">
                    	<?php if ($goods) : ?>
                    	<?php foreach ($goods as $k => $v) : ?>
                    	<li>
							<a href="<?= url(['/goods/detail','id'=>(string)$v['_id']]) ?>" class="picbox" target="_blank">
								<img src="<?php if(isset($v['image'][0])) echo Yii::$app->params['image'] . $v['image'][0] ; ?>" alt="">
							</a>
							<div class="elli">
								<a href="<?= url(['/goods/detail','id'=>(string)$v['_id']]) ?>" target="_blank"><?= $v['name'] ?></a>
							</div>
							<a href="<?= url(['/goods/detail','id'=>(string)$v['_id']]) ?>" class="price" target="_blank">￥<span><?= $v['shop_price'] ?></span></a>
							<div class="probottom">
                    			<a href="javascript:void(0);" onclick="addCart(<?= (string)$v['_id'] ?>,0,1);" class="buy">加入购物车</a><i class="line"></i>
                    			<a href="javascript:void(0);" onclick="addCart(<?= (string)$v['_id'] ?>,1,1);" class="addcart">立即购买</a>
                    		</div>
						</li>
                    	<?php endforeach; ?>
                    	<?php else: ?>
                    	<div style="width: 100%; height: 200px;padding-top: 50px; background-color: #FFF;text-align: center;font-size: 16px;">
                    		没有符合条件的商品，请尝试其他搜索条件。
                    	</div>
                    	<?php endif; ?>
					</ul>
					<div class="pages"><!--{$pages['pages']}--></div>
			</div>
		</div>
		
		<!--{tpl footer}-->
		<!--{tpl toolbar}-->
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>	
		<script type="text/javascript" src="js/main.js" ></script>
		<script>
 			$(function () {
 				loadLayer();
 			});
		$(".ul-pro-box li").each(function(){
			if($(this).index()%4==3){
				$(this).css("margin-right","4px");
			}
			if($(this).index()%4==0){
			   $(this).css("margin-left","4px");
			}
		});
		$(".pps li:last-child").css("border-bottom","none");
		$(".some-px a").each(function(){
			$(this).click(function(){
				$(this).addClass("red").siblings().removeClass("red");	
				if($(".some-px b").hasClass("down") || $(".some-px b").prop("class")==undefined){
					 $(this).find("b").removeClass("down").addClass("up");
				}
				else
				{
					$(this).find("b").removeClass("up").addClass("down");
				}
			});
		})
		</script>
	</body>

</html>