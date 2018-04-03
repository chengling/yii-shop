		<div class="container2" id="orderList">
            <section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<p>您好，15038384758</p>
            			<ul>
            				<li><a href="">密码管理</a></li>
            				<li><a href="">购物车</a></li>
            				<li><a href="">收货地址</a></li>
            				<li><a href="">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
            <section class="laber_shop">
            	<div class="shop auto clearfix">
            		<div class="shop_main">
            			<span>订单信息：</span>
            			<div class="shop_orders">
            				<dl class="head">
            					<dd class="od1">商品详情</dd>
            					<dd class="od2">数量</dd>
            					<dd class="od3">收货人</dd>
            					<dd class="od4">总金额</dd>
            					<dd class="od5">订单状态</dd>
            					<dd>操作</dd>
            				</dl>
            				<ul>
            					<li v-for="(list, index) in ListData">
            						<div class="list_i od1" :class="{'lisBorder': list.goods_list.length > 1}">
	            						<a v-for="item in list.goods_list" class="order_list" :href="goodUrl + '?id=' + item.goods_id">
	            							<img :src="imgUrl + item.goods_image">
	            							<b>{{ item.goods_name }}</b>
	            							<p class="od2">{{ item.goods_num }}</p>
	            						</a>
	            					</div>
	            						<p class="od3">{{ list.consignee }}</p>
	            						<p class="od4">{{ list.order_amount }}</p>
	            						<p v-show="list.order_status == 1" class="od5">未付款</p>
	            						<p v-show="list.order_status == 2" class="od5">待发货</p>
	            						<p v-show="list.order_status == 3" class="od5">待收货</p>
	            						<p v-show="list.order_status == 4" class="od5">订单关闭</p>
	            						<p v-show="list.order_status == 5" class="od5">交易成功</p>
	            						<div class="btn_cz">
	            							<button type="button" v-show="list.order_status == 1" class="orders_qx">取消订单</button>
	            							<button type="button" v-show="list.order_status == 1" class="orders_zf">立即支付</button>
	            							<button type="button" v-show="list.order_status == 3" class="orders_zf">物流跟踪</button>
	            							<button type="button" v-show="list.order_status == 5" class="orders_zf">交易完成</button>
	            						</div>
            						
            					</li>
            				</ul>
            			</div>
            		</div>
            	</div>
            </section>
			<div>
				<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
		new Vue({
         	el: '#orderList',
         	data: {
         		ListData: [],
         		goodList: [],
         		statusNum: 0,
         		imgUrl: imgurl,
         		goodUrl: goodsUrl
         	},
         	created: function(){
         		let _this = this;
         		_this.orderList();
         	},
            methods: {
                orderList: function(){
                	let _this = this;
                	var goodList;
                	$.ajax({
                		type:"POST",
                		url:"/order/orderlist",
                		dataType: 'json',
                		data:'',
                		success: function(data){
                			if(data.status == 0){
                				console.log('数据获取成功');
                				_this.ListData = data.data;            				
                				console.log(_this.ListData);              				
                			}
                		}
                	});
                }
            }
         })
	</script>