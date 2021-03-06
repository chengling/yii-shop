	<div class="container2" id="winwBg">
		<section class="laber_details">
			<div class="details auto clearfix">
				<div class="details_main">
					<div class="details_top">
						<div class="details_fl">
							<div class="data_img">
								<img :src="pic_list[num]" alt="柚子" />
							</div>
							<ul class="view">
								<li @click="btnImg(index)" v-for="(img, index) in pic_list">
									<img :src="img" alt="柚子" />
								</li>
							</ul>
							<div @click="preve" class="preve"></div>
							<div @click="next" class="next"></div>
						</div>
						<div class="details_fr">
							<h1>{{ goodName }}</h1>
							<p>￥{{ goodPrice }}</p>
							<div id="" class="data_number">
								<em>购买数量：</em><input @click="btnjj" class="" type="button" value="-" />
								<input class="sl" type="text" v-model="goods_num" />
								<input @click="btnAdd" type="button" value="+" />
							</div>
							<a @click="buyShop" class="gm" href="javascript:;">立即购买</a>
							<a @click="tjCar" href="javascript:;">添加购物车</a>
							<ul>
								<li>
									<span v-for="arr in keyArr" class="li_w">{{ arr.key }}：<em>{{ arr.value }}</em></span>
								</li>
							</ul>
							<strong>生产日期：<em>见包装盒喷码标识</em></strong>
						</div>
					</div>
					 <div class="loadingMain" id="loadMain"></div>
					<div class="details_center" v-html="content">
						
					</div>
				</div>
			</div>
		</section>
		<div>
		<?php include dirname(__DIR__).'/layouts/footer.php'?> 
		</div>
		<div v-show="carShow" @click="carBg" id="carBg" class="carBg"></div>
		<div v-show="popupShow" id="carPopup" class="carPopup">
			<i @click="carQx"></i>
			<span>已成功添加至购物车！</span>
			<div class="linkShop">
				<a href="/goods/list">继续逛逛</a>
				<a href="/cart/index" class="al1">前往购物车结算</a>
			</div>
		</div>
		
		<!--错误提示-->
		<div v-show="popupShow2" id="carPopup" class="carPopup">
			<span>{{ PromptMsg }}</span>
			<div class="linkShop">
				<a @click="PromptOk" href="javascript:;">确定</a>
			</div>
		</div>
	</div>
	<!-- 主体内容 end  -->
</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
		var id = "<?=$id?>";
		var goodCar = new Vue({
			el: '#winwBg',
			data: {
				carShow:false,
				popupShow:false,
				//提示错误
				popupShow2: false,
				PromptMsg: '',
				goodUrl: '/goods/getdetail',
				goodName: '',
				goodPrice: '',
				num: 0,
				pic_list:[],
				id: '',
				keyArr: [],
				goods_num: 1,
				content:'',
			    imgUrl: imgurl,
			    goodData: []
			},
			created: function(){
				var _this = this;
				_this.id = id;										    
				$.ajax({
	                url: _this.goodUrl + '?id=' + _this.id,
	                type: 'POST',
	                dataType: 'json',
	                data: '',
	                beforeSend: function () {
	                	var load = document.createElement('div');
					    load.className = 'loader circle-round-fade small';
					    for(var i=0;i<8;i++){
					    	load.innerHTML += '<small></small>';
					    }
					    $('#loadMain').html(load);
					    
					},
	                success: function(data) {
	                	if(data.status == 0){
	                		$('#loadMain').html('');
	                		_this.goodName = data.data.name;
						    _this.goodPrice = data.data.price;
						    _this.pic_list = data.data.pic_list;
						    _this.keyArr = data.data.ext;
						    _this.content = data.data.content;						    
	                	}else {
	                		alert('商品加载错误...');
	                	}                 	
	                }
	            })	            	            	                    
			},
            methods: {
            	tempFun: function(){
            		var _this = this;
            		var temp = {};
	       	    	temp.goods_id = _this.id;
				    temp.goods_num =  _this.goods_num;
				    _this.goodData.push(temp);
            	},
            	tjCar: function(){
            		var _this = this;
            		if(islogin == 1){
            			$.ajax({
		                url: '/cart/addcart',
		                type: 'POST',
		                dataType: 'json',
		                data: {goods_num: this.goods_num, goods_id: this.id},
		                success: function(data) {
			                	if(data.status == 0){
			                		_this.carShow = true;
	            		            _this.popupShow = true;
			                	}else if(data.status == 1){
			                		_this.carShow = true;
	            		            _this.popupShow2 = true;
	            		            _this.PromptMsg = data.msg;
			                	}else {
			                		alert('加入购物车失败...')
			                	}                 	
			                }
			           }) 
            		}else{
            			window.location = '/site/login';
            		}
            		         		            		
            	},
            	PromptOk: function(){
            		var _this = this;
            		_this.carShow = false;
	            	_this.popupShow2 = false;
            	},
            	//直接购买
            	buyShop: function(){
            		var _this = this;
            		_this.tempFun();
            		if(islogin == 1){
            			$.ajax({
		                url: '/order/confirm',
		                type: 'POST',
		                dataType: 'json',
		                data: {goods: _this.goodData},
		                success: function(data) {
			                	if(data.status == 0){
			                		window.location = '/order/index';
			                	}else if(data.status == 1){
			                		_this.carShow = true;
	            		            _this.popupShow2 = true;
	            		            _this.PromptMsg = data.msg;
			                	}		                 	
			                }
			           }) 
            		}else{
            			window.location = '/site/login';
            		}
            	},
            	carQx: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	},
            	carBg: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	},
            	btnImg:function(index){           		
            		this.toImg = imgurl + this.pic_list[index];
            		this.num = index;         		
            	},
            	preve: function(){
            		if(this.num == 0){
            			this.num = this.pic_list.length;
            		}
            		this.num--;            		
            	},
            	next: function(){            		
            		if(this.num == this.pic_list.length - 1){
            			this.num = -1;
            		}
            		this.num++;
            	},
            	btnjj:function(){
            		this.goods_num--;
            		if(this.goods_num <= 0){
            			this.goods_num = 1;
            		}
            	},
            	btnAdd:function(){
            		this.goods_num++;
            	}
            }
		})
	</script>