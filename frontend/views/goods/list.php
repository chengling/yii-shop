<?php
use yii\helpers\Url;
?>
<!-- 主体内容 start  -->
		<div class="container2">
            <section class="laber_goods">
            	<div class="goods auto clearfix">
            		<div class="goods_main" id="goods">
            			<div v-show="noneCar" class="noneCar">
            				<img src="/img/kong.png"/>
            				<p>暂时没有任何商品，商家正在紧急上货中...</p>           				
            			</div>
            			<ul v-show="goooList">
            				<li v-for="lis in aLis">
            					<a :href="lis.thisUrl">
            						<img v-bind:src="imgurl + lis.image[0]" alt="橘子"/>
            						<span>{{lis.name}}</span>
            						<p class="price">{{'￥' + lis.shop_price}}</p>
            					</a>
            				</li>
            			</ul>
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
		var goods = new Vue({
			el: '#goods',
			data: {
				aLis: [],
				id:'',
				thisUrl:'',
				noneCar: true,
				goooList: true
			},
			created: function(){
				var _this = this;										
				$.ajax({
	                url: 'goods/getlist',
	                type: 'POST',
	                dataType: 'json',
	                data: '',
	                success: function(data) {	                 	
		                if(data.status =='0')
			            {
			            	_this.aLis = data.data;
			            	if(_this.aLis.length != 0){
				            	_this.goooList = true;
				            	_this.noneCar = false;
				            }else{
				            	_this.goooList = false;
				            	_this.noneCar = true;
				            }
			                var list = data.data
		                 	for(var i in list){
								_this.id = list[i]._id.$oid;
								list[i].thisUrl = goodsUrl + '?id=' + _this.id;
							}	                 	
				        }else{
				        	alert('页面信息错误');
				        }
	                }
	            })
	            
			}
		})
	</script>
</html>


