<!--{tpl header}-->
<div class="navtitleright nb"><a href="index.html">首页</a> {$crumbs_nav}</div>
<div class="indbody pro-style">
    <div class="nb recom-box">
        <div class="pro-view" id="ym-item">
            <div class="pview-left">
                <div class="ovclear">
                    <div class="slide-fish">
                        <div class="t2">
                            <a href="<?= $goods['image'][0] ?>" id="bigimg" class="MagicZoom MagicThumb" >
                                <img src="<?php if(isset($goods['image'][0])) echo Yii::$app->params['image'] . $goods['image'][0] ; ?>" id="main_img" class="main_img" style="width:410px;height: 410px;" />
                            </a>
                        </div>
                        <div class="small-scroll">
                            <a class="prev" href="javascript:void(0);"></a>
                            <a class="next" href="javascript:void(0);"></a>
                            <div class="bd">
                                <ul class="smallImg" id="imglist">
                                    <li><a rel="bigimg" rev="{$goods['img']}"><img src="<?php if(isset($goods['image'][0])) echo Yii::$app->params['image'] . $goods['image'][0] ; ?>" /></a></li>
                                    <?php if ($goods['image']) : ?>
                                        <?php foreach ($goods['image'] as $k => $v) : ?>
                                    <li><a rel="bigimg" rev="<?= $v ?>"><img src="<?= $v ?>" /></a></li>
                                            <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="fish-detail">
                        <h3><?= $goods['name'] ?></h3>
                        <p><?= $goods['name'] ?></p>
                        <div class="price">
                            <div>市场价：<s>￥<?= $goods['shop_price'] ?></s></div>
                            <div>价格：<span class="redbold">￥<b id="ym-price"><?= $goods['shop_price'] ?></b></span></div>
                        </div>
                        <div class="deliver">
                            <div>配送：<span><?php if( $goods['shop_price']>0) echo '<b>有货</b>'; else echo '暂时无货'; ?>
									{if $ym_express_type==1}
									{if $express_fee !=0}，<a href="{$express_fee_news['url']}" target="_blank" title="">满{$express_fee}元免运费</a>{/if}
									<a href="javascript:void" style="display: none;">自提点</a>
									<div style="display: none;">
										<ul>
											<li value="24242">广东</li>
											<li value="24242">北京</li>
										</ul>
										<select>
											<option value="24242">佛山</option>
											<option value="24242">广州</option>
										</select>
										<ul>
											<li>某某223442424fwrw <span>15834442424</span></li>
											<li>某某223442424fwrw <span>15834442424</span></li>
											<li>某某223442424fwrw <span>15834442424</span></li>
											<li>某某223442424fwrw <span>15834442424</span></li>
										</ul>
									</div>
									{elseif $ym_express_type==2}免运费{/if}</span></div>
                        </div>
                        <div class="spec" id="goods-spec">
                            <!--{loop $spec $p}-->
                            <div class="it">
                                <span class="spec-name">{$p[name]}</span>：<span class="select-mod">
										<!--{loop $p['val'] $v}-->
                                    <!--{if $p['is_img']==1}-->
											<a href="javascript:void(0);" data-img='{$v[imgs]}' id="{$v['name']}">{$v['name']}<i class="icon-check-zf"></i></a>
                                    <!--{else}-->
											<a href="javascript:void(0);" id="{$v}">{$v}<i class="icon-check-zf"></i></a>
                                    <!--{/if}-->
                                    <!--{/loop}-->
										</span>
                            </div>
                            <!--{/loop}-->
                        </div>
                        <div class="pro-number">
                            <a class="reduce" href="javascript:void(0);">-</a>
                            <input type="text" id="goods_num" class="result" data-max="{$goods['number']}" value="1" maxlength="10"/>
                            <a class="add" href="javascript:void(0);">+</a>
                        </div>
                        <div class="cart-buy">
                            {if $goods['status'] == goods_down}
                            <br /><p class="red" style="font-size: 14px;">来晚了~~  商品已下架</p>
                            {else}
                            <a href="javascript:void(0);" onclick="addCart({$goods[goods_id]},1,'', 0);" class="buy-btn">立即购买</a>
                            <a href="javascript:void(0);" onclick="addCart({$goods[goods_id]},0,'',0);" class="cart-btn">加入购物车</a>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
            <div class="pview-right">
                <h2>相关推荐</h2>
                <div class="slider-protj">
                    <div class="bd">
                        <ul>
                            <!--{loop $remmend_goods $p}-->
                            <li>
                                <a href="{$p[url]}" target="_blank"><img src="{$p[thumb]}" alt=""/></a>
                                <p><a href="{$p[url]}" target="_blank">{$p[name]}</a><span>￥{$p[price]}</span></p>
                            </li>
                            <!--{/loop}-->
                        </ul>
                    </div>
                    <div class="hd">
                        <a href="javascript:void(0);" class="prev"></a>
                        <a href="javascript:void(0);" class="next"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-tab">
            <div class="slide-detail">
                <div class="hdd">
                    <ul>
                        <li class="good-detail on">商品详情</li>
                        <li class="good-evalate">客户评价<em>({$commnet_total})</em></li>
                        <li class="good-other">售后保障</li>
                    </ul>
                </div>
                <div class="bdd">
                    <div class="box1">
                        <div class="box1detail">
                            <div class="attr">
                                <ul>
                                    <!--{loop $attr $p}-->
                                    <li>
                                        {$p['name']}：
                                        <!--{loop $p['val'] $v}-->
                                        {$v}
                                        <!--{/loop}-->
                                    </li>
                                    <!--{/loop}-->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <br />
                            {$goods['details']}
                        </div>
                        <div class="evalute">
                            <h3 class="title">商品评价</h3>
                            <div class="percentgood">
                                <div class="pgbox">
                                    <dl class="total">
                                        <dt>{$good_pacent}%</dt>
                                        <dd>好评度</dd>
                                    </dl>
                                </div>
                                <div class="pgbox">
                                    <dl>
                                        <dt>好评（{$good_pacent}%）</dt>
                                        <dd class="percentjd"><i class="" style="width:{$good_pacent}%;"></i></dd>
                                    </dl>
                                </div>
                                <div class="pgbox">
                                    <dl>
                                        <dt>中评（{$mid_pacent}%）</dt>
                                        <dd class="percentjd"><i class="" style="width:{$mid_pacent}%"></i></dd>
                                    </dl>
                                </div>
                                <div class="pgbox">
                                    <dl>
                                        <dt>差评（{$bad_pacent}%）</dt>
                                        <dd class="percentjd"><i class="" style="width:{$bad_pacent}%;"></i></dd>
                                    </dl>
                                </div>

                            </div>

                            <div class="tab-gbw">
                                <div class="hd">
                                    <ul class="evalute-titleul">
                                        <li class="check" data-level = "" data-page="2"><a href="javascript:void(0);">全部评价<em class="embold">({$commnet_total})</em></a></li>
                                        <li data-level="good" data-page="0"><a href="javascript:void(0);">好评<em>({$good_count})</em></a></li>
                                        <li data-level="mid" data-page="0"><a href="javascript:void(0);">中评<em>({$mid_count})</em></a></li>
                                        <li data-level="bad" data-page="0"><a href="javascript:void(0);">差评<em>({$bad_count})</em></a></li>
                                    </ul>
                                </div>
                                <div class="bd">
                                    <div class="evalute-detail" id="all">
                                        <ul>
                                            <!--{if !$comment}--><li style="text-align: center;">暂无评价~</li><!--{/if}-->
                                            <!--{loop $comment $p}-->
                                            <li id="{$p['id']}">
                                                <div class="column starevalute">
                                                    <div class="column rankevalute">
                                                        <div class="member">
                                                            <img src="{if $p['uimg']!=''}{$p['uimg']}{else}{tpl_root}images/avatar.jpg{/if}" alt=""/>
                                                        </div>
                                                        <div class="menber-rank">
                                                            <span>{$p['anon_name']}</span>
                                                            <span class="red" style="display: none;">{$p['grade_name']}</span>
                                                        </div>
                                                    </div>
                                                    <div class="grade-stars grade{$p['star']}"></div>
                                                    <p>
                                                        {$p['addtime']}
                                                    </p>
                                                </div>
                                                <div class="column personeva">
                                                    <div class="comment">{$p['content']}
                                                        <!--{if $p['thumb']}-->
                                                        <div class="show-pic" id="show-pic">
                                                            <!--<a href="javascript:void(0);" class="sc_prev">&lt;</a>-->
                                                            <div class="sc_bd">
                                                                <dl>
                                                                    <!--{loop $p['thumb'] $i $t}-->
                                                                    <dd><a data-src="{$p['img'][$i]}"><img src="{$t}" width="80" height="80"/></a></dd>
                                                                    <!--{/loop}-->
                                                                </dl>
                                                            </div>
                                                            <!--<a href="javascript:void(0);" class="sc_next">&gt;</a>-->
                                                        </div>
                                                        <div class="sc_picbox">
                                                            <div class="sc_pictab">
                                                                <a href="javascript:void(0);" class="a_up"><em class="icon-up"></em>收起</a>
                                                                <a href="javascript:void(0);" class="a_left"><em class="round-left"></em>向左旋转</a>
                                                                <a href="javascript:void(0);" class="a_right"><em class="round-right"></em>向右旋转</a>
                                                            </div>
                                                            <div class="sc_photo">
                                                                <img src="{$p['img'][0]}" alt="" class="dyimg_src"/>
                                                            </div>
                                                        </div>
                                                        <!--{/if}-->
                                                    </div>
                                                    <!--{if $p['admin_reply']}-->
                                                    <div class="reply">
                                                        <ul>
                                                            <!--{loop $p['admin_reply'] $v}-->
                                                            <li>
                                                                <span>{$v['uname']}:</span>{$v['content']}
                                                            </li>
                                                            <!--{/loop}-->
                                                        </ul>
                                                    </div>
                                                    <!--{/if}-->
                                                    <div class="receive">
                                                        <a href="javascript:void(0);" onclick="javascript:get_reply(this);" class="receivea">回复(<em>{$p['reply_count']}</em>)</a>
                                                        <div class="receivebox">
                                                            <div class="inner">
                                                                <textarea placeholder="回复 {$p['anon_name']}:" class="textpj" onkeyup="words_deal(this);" maxlength="120"></textarea>
                                                            </div>
                                                            <p>
                                                                <span>还可以输入<em>120</em>字</span>
                                                                <input type="submit" data-pid="{$p['id']}" data-ptype="0" value="提交" class="submita" onclick="javascript:reply(this);"/>
                                                            </p>
                                                        </div>
                                                        <div class="replylist">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!--{/loop}-->
                                        </ul>
                                        <div class="loading" style="height: 100px;display: none; line-height: 100px; text-align: center; margin-top: 50px;"><span style="margin-left: 342px;">正在加载中，请稍候...</span></div>
                                        <!--{if $comment}-->
                                        <div class="pages" style="text-align: center;">
                                            <a class="loadmore">加载更多</a>
                                        </div>
                                        <!--{/if}-->
                                    </div>
                                    <div class="evalute-detail" id="good">
                                        <ul></ul>
                                        <div class="loading" style="height: 100px;line-height: 100px; text-align: center; margin-top: 50px;"><span style="margin-left: 342px;">正在加载中，请稍候...</span></div>
                                        <div class="pages" style="text-align: center;">
                                            <a class="loadmore">加载更多</a>
                                        </div>
                                    </div>
                                    <div class="evalute-detail" id="mid">
                                        <ul></ul>
                                        <div class="loading" style="height: 100px;line-height: 100px; text-align: center; margin-top: 50px;"><span style="margin-left: 342px;">正在加载中，请稍候...</span></div>
                                        <div class="pages" style="text-align: center;">
                                            <a class="loadmore">加载更多</a>
                                        </div>
                                    </div>
                                    <div class="evalute-detail" id="bad">
                                        <ul></ul>
                                        <div class="loading" style="height: 100px;line-height: 100px; text-align: center; margin-top: 50px;"><span style="margin-left: 342px;">正在加载中，请稍候...</span></div>
                                        <div class="pages" style="text-align: center;">
                                            <a class="loadmore">加载更多</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="title">售后保障</h3>
                        <div class="otherbox">
                            {$goods['service']}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="goods_id" value="{$goods['goods_id']}" />
<input type="hidden" id="user_discount" value="{$user['discount']}" />
<!--{tpl footer}-->
<!--{tpl toolbar}-->

<link rel="stylesheet" href="css/MagicZoom.css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<!--<script type="text/javascript" src="js/location.js" ></script>-->
<script type="text/javascript" src="js/MagicZoom.js" ></script>
<script type="text/javascript" src="js/jquery.SuperSlide.2.1.1.js" ></script>
<script type="text/javascript" src="js/main.js" ></script>

<script type="text/javascript">
    $(function() {
        $("#goods-spec .it a").each(function() {
            $(this).click(function() {
                if ($(this).data("img") !='') {
                    var imgs = $(this).data("img");
                    var html ='';
                    $.each(imgs, function(k, v) {
                        html +='<li><a rel="bigimg" rev="'+v.img+'"><img src="'+v.thumb+'"></a></li>';
                    })
                    $("#imglist").html(html);
                    $(".slide-fish ul.smallImg").children("li").eq(0).find("img").trigger("mouseover");
                }
            });
        });
    })

    var goods_id = $("#goods_id").val();
    var time =0;
    //回复
    function reply(th) {
        if (time != 0) {
            msg("请别回复太快哦"); return;
        }
        var t = $(th),txt = t.parent().siblings().children(".textpj");
        var reply = txt.attr("placeholder"),
            content = $.trim(txt.val()),
            pid = t.data("pid"),
            ptype = t.data("ptype"),
            cid = t.parents("li").attr("id");

        if(content =='')
        {
            msg('请输入回复内容');
            return;
        }

        $.getJSON("/user.html", {act:'add_comment_reply', gid: goods_id, pid: pid,ptype: ptype, content: content,cid:cid}, function(res) {
            if(res.err && res.err != '') {
                msg('操作失败，' + res.err);return;
            }
            if(res.url && res.url != '') {
                window.location.href = res.url; return;
            }
            else
            {
                var html= '<div class="receive"><p><span class="user-name">{$ym_uname} '+reply+'：</span>'+content+'</p></div>';
                if (ptype==1) {
                    t.parents(".replylist").append(html);
                } else{
                    t.parents(".receivebox").siblings(".replylist").append(html);
                }
                t.parents(".receivebox").hide().find(".textpj").val('');
                var n = t.parents(".personeva").children().children("a").children("em");
                n.html(parseInt(n.html())+1);
                time =60;
                var ti =setInterval(function() {
                    if (time == 0) {
                        clearInterval(i);return;
                    }
                    time--;
                },1000);
            }
        });
    };

    $(".ul-pro-box li").each(function(){
        if($(this).index()%4==3){
            $(this).css("margin-right","4px");
        }
        if($(this).index()%4==0){
            $(this).css("margin-left","4px");
        }
    });

    //获取回复
    function get_reply(t){
        if ($(t).siblings(".replylist").hasClass("loaded")==false) {
            var cid = $(t).parents("li").attr("id");
            $.getJSON("/user.html", {act:'get_comment_reply', cid:cid}, function(res) {
                if(res.err && res.err != '') {
                }
                else
                {
                    var html='';
                    $.each(res.data, function(k, v) {
                        html += '<div class="receive"><div class="content"><span class="user-name">'+ v.uname +' 回复 '+ v.reply_name+'：</span><span>'+ v.content+'</span><p><a href="javascript:void(0);" onclick="javascript:show_replybox(this);" class="receivea">回复</a></p></div><span style="float:right;">'+ v.addtime +'</span>';
                        html += '';
                        html += '<div class="receivebox"><div class="inner"><textarea placeholder="回复 '+ v.uname +':" class="textpj" onkeyup="words_deal(this);" maxlength="120"></textarea></div>';
                        html += '<p> <span>还可以输入<em>120</em>字</span> <input type="submit" data-pid="'+v.id+'" data-ptype="1" value="提交" class="submita" onclick="javascript:reply(this);"/> </p></div></div>';
                        html += '</div>';
                    });
                    $(t).siblings(".replylist").append(html).addClass("loaded");
                }
            });
        }
        show_replybox(t);
    };

    //显示回复框
    function show_replybox(th) {
        var t =$(th);
        t.siblings(".receivebox,.replylist").toggle();
        t.parents(".content").siblings(".receivebox").toggle();
        t.toggleClass("showvisi");
    }

    //
    $(".evalute-titleul li").each(function(){
        var t = $(this);
        t.click(function(){
            t.addClass("check").siblings().removeClass("check");
            t.find("em").addClass("embold").siblings().removeClass("embold");
            var level =t.data("level"),
                page = t.data("page");

            //加载评价数据
            if (t.hasClass("loaded")==false) {
                loadComment(t,level,page);
            }
        });
    });

    //加载更多评价
    $(".loadmore").click(function() {
        var t = $(".evalute-titleul").children().eq($(this).parents(".evalute-detail").index());
        var level =t.data("level"),
            page = t.data("page");
        loadComment(t,level,page);
    });

    function loadComment(t,level,page) {
        $("#"+(level==''?'all':level)).children(".loading").show();
        $.getJSON("/user.html", {act:'get_comment', id:goods_id, level: level,page: page}, function(res) {
            if(res.err && res.err != '') {

            }
            else
            {
                var html='';
                $.each(res.data, function(k, v) {
                    html +='<li id="'+ v.id +'"><div class="column starevalute">';
                    html +='<div class="column rankevalute"><div class="member"><img src="'+(v.uimg!=''? v.uimg :'{tpl_root}images/avatar.jpg')+'" alt="" /></div>';
                    //html +='<span class="red">'+ v.grade_name +'</span>';
                    html +='<div class="menber-rank"><span>'+ v.anon_name +'</span></div></div>';
                    html +='<div class="grade-stars grade'+ v.star +'"></div><p> '+ v.addtime +' </p></div>';
                    html +='<div class="column personeva"><div class="comment">'+ v.content;
                    if (v.thumb && v.thumb.length>0) {
                        html +='<div class="show-pic"><dl>';
                        $.each(v.thumb, function(key, val) {
                            html +='<dd><a data-src="'+v.img[key]+'"><img src="'+val+'" width="80" height="80"/></a></dd>';
                        });
                        html+='</dl></div><div class="sc_picbox"><div class="sc_pictab"><a href="javascript:void(0);" class="a_up"><em class="icon-up"></em>收起</a><a href="javascript:void(0);" class="a_left"><em class="round-left"></em>向左旋转</a><a href="javascript:void(0);" class="a_right"><em class="round-right"></em>向右旋转</a></div><div class="sc_photo"><img src="'+v.img[0]+'" alt="" class="dyimg_src"/></div></div>';
                    }
                    html +='</div><div class="receive"><a href="javascript:void(0);" onclick="javascript:get_reply(this);" class="receivea showvisi">回复(<em>'+ v.reply_count +'</em>)</a>';
                    html +='<div class="receivebox">';
                    html +='<div class="inner"><textarea placeholder="回复 '+ v.anon_name +':" class="textpj" onkeyup="words_deal(this);" maxlength="120"></textarea></div>';
                    html +='<p> <span>还可以输入<em>120</em>字</span> <input type="submit" data-pid="'+ v.id +'" data-ptype="0" value="提交" class="submita" onclick="javascript:reply(this);" /> </p></div>';
                    html +='<div class="replylist"></div></div></div></li>';
                });

                level= level==''?'all':level;
                $("#"+level).children("ul").append(html);
                t.data("page",page + 1);
                if (t.hasClass("loaded")==false) {
                    t.addClass("loaded");
                }
                if (res.data.length==0 || (res.res && res.res==1)) {
                    $("#"+level).children(".pages").html("没有更多评价了~");
                }
                inti_showpic();
            }
            $("#"+level).children(".loading").hide();
        });
    }

    $(".tab-gbw").slide({trigger:"click"});
    $(".slide-detail .hdd li").each(function(){
        $(this).click(function(){
            $(this).addClass("on").siblings().removeClass("on");
            if($(this).index()==0){
                $(".box1detail,.otherbox,.evalute,.box1 h3.title").show();
            }
            else if($(this).index()==1)
            {
                $(".box1detail,.otherbox").hide();
                $(".evalute").show();
                $(".box1 h3.title").hide();
            }
            else{
                $(".box1detail,.evalute").hide();
                $(".otherbox").show();
                $(".box1 h3.title").hide();
            }
        });
    });

    $(".pps li:last-child").css("border-bottom","none");
    $(document).ready(function() {
        loadLayer();

        $(".slide-fish").slide({ titCell:".smallImg li", mainCell:".bigImg", effect:"left", autoPlay:false,delayTime:200});
        $(".slide-fish .small-scroll").slide({mainCell:"ul.smallImg",effect:"left",autoPlay:false ,autoPage: true,vis: 5,delayTime:100});
        $(".slide-fish ul.smallImg").on("mouseover","li img", function() {
            $(this).parents("li").css("border-color","#de342f").siblings().css({"border-color":"#fff"});
            var s=$(this).parents(".small-scroll").siblings(".t2").children();
            s.children(".main_img").prop("src", $(this).parent().prop("rev"));
            s.children(".MagicZoomBigImageCont").find("img").prop("src", $(this).parent().prop("rev"));
        });
    });
    $(".slider-protj").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:false,vis:2});
    $(window).scroll(function(){
        var topproview=$(".pro-view").outerHeight()+$(".header").height();
        if($(window).scrollTop()>topproview){
            $(".pro-tab .hdd").addClass("hdfix");
        }
        else{
            $(".pro-tab .hdd").removeClass("hdfix");
        }
    });
</script>

<!--晒单图片-->
<script type="text/javascript">
    $(".show-pic").slide({mainCell:".sc_bd dl",autoPage:true,effect:"left",autoPlay:false,vis:5,prevCell:".sc_prev",nextCell:".sc_next"});

    function inti_showpic() {
        $(".evalute-detail li").each(function(){
            $(this).find(".show-pic dd a").click(function(){
                d=0;
                var img_src=$(this).attr("data-src");
                var showpic=$(this).parents(".show-pic").siblings(".sc_picbox");
                showpic.find(".dyimg_src").attr("src",img_src).css("transform","rotateZ(0deg)");
                $(this).addClass("on").parent().siblings().children().removeClass("on");
                showpic.show().parents("li").siblings("li").children(".sc_picbox").hide();
            });
        });

        $(".a_left").click(function(){
            move(-90, $(this));
        });
        $(".a_right").click(function(){
            move(90, $(this));
        });
        $(".sc_photo,.a_up").click(function(){
            $(".sc_picbox").hide();
            $(".show-pic dd a").removeClass("on");
        });
    }

    $(function() {
        inti_showpic();
    })

    var d=0;
    function move(s, t) {
        d+=s;
        t.parent().siblings().children(".dyimg_src").css("transform","rotateZ("+ d+"deg)");
    }

</script>
