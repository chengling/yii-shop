<?php use yii\helpers\Url;
?>
		<div class="container2">
			<section class="laber_news">
				<div class="news auto">
					<div class="news_main" id="news_main">

						<!--<div class="item">
							<a class="link_pic" href="<?=Url::to('/site/detail?id='.$v['id'])?>"><img src="<?=Yii::$app->params['image'].$v['thumb']?>"></a>
							<span><?=$v['title']?></span>
							<a class="link_p" href="#"><?=$v['summary']?></a>
						</div>-->

					</div>
				</div>
			</section>
			<div class="contmain4">
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>			
		</div>
		<!-- 主体内容 end  -->
		<script language="javascript"> 
			var mySwiper = new Swiper('.swiper-container',{
			slidesPerView : 3,
			spaceBetween : 15,
			})
			$('.arrow-left01').on('click', function(e){
			    e.preventDefault()
			    mySwiper.swipePrev()
			})
			$('.arrow-right01').on('click', function(e){
			    e.preventDefault()
			    mySwiper.swipeNext()
			})
		</script>
		<script type="text/javascript">
			$(function(){
			    /*初始化*/
			    var counter = 0; /*计数器*/
			    var pageStart = 0; /*offset*/
			    var pageSize = 6; /*size*/
			    var isEnd = false;/*结束标志*/
			    
			    /*首次加载*/
			    getData(pageStart, pageSize);
			    
			     
				/*监听加载更多*/
				$(window).scroll(function(){
				  if(isEnd == true){
				    return;
				  }
				 
				  // 当滚动到最底部以上100像素时， 加载新内容
				  // 核心代码
				  if ($(document).height() - $(this).scrollTop() - $(this).height()<100){
				    counter ++;
				    pageStart = counter * pageSize;
				       
				    getData(pageStart, pageSize);
				  }
				});
			});
		</script>
	</body>
</html>

