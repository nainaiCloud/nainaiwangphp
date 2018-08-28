<script type="text/javascript" src="{root:js/arttemplate/artTemplate.js}"></script>
<input type="hidden" name="js_sign_banner" value="1">


<script type="text/javascript">
/*最新咨询动态效果*/
function timer(opj){
    $(opj).find('ul').animate({
      marginTop : "-60px"  
      },500,function(){  
      $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
    })  
  }
$(function() {
   $('.js_rep_offer .li_select').trigger('click');
    {if:isset($productData[0])}
    showIndexOffers('jingjiaTemplate','jingjiaBox',{$productData[0]['id']});
    {/if}

    {if:isset($productData[1])}
    showIndexOffers('shebeiTemplate','shebeiBox',{$productData[1]['id']});
    {/if}

    {if:isset($productData[2])}
    showIndexOffers('rexiaoTemplate','rexiaoBox',{$productData[2]['id']});
    {/if}

    //异步获取排行榜报盘，获取6条
    var offerPaihangUrl = '{url:/ajaxdata/offerRank@deal}';
    $.ajax({
        type : 'post',
        url : offerPaihangUrl,
        async  : true,
        dataType : 'json',
        success : function(data){
            // alert(JSON.stringify(data));
            //console.log(data[0].name);
            //data = JSON.parse(data);
            if(data){
                var offerList = template.render('paihangTemplate',{data:data});
                $('#paihangBox').html(offerList);

            }
        }

    })

    //异步获取最新资讯，默认获取10条
    var infoInterUrl = '{url:/ajaxdata/zixunData}';
    $.ajax({
        type : 'post',
        url : infoInterUrl,
        async  : true,
        dataType : 'json',
        success : function(data){
            //console.log(data[0].name);
			//data = JSON.parse(data);
            if(data){
                var newsList = template.render('newsBox',{data:data});
                $('#news_box').html(newsList);

            }
            var num = $('.notice_active').find('li').length;
            if(num > 1){
                var time=setInterval('timer(".notice_active")',3500);

            }
        }

    })



})
</script>
    <!------------------导航 开始-------------------->
    <form method="post" action="" id="form1">
        <div class="aspNetHidden">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="b7kHdN58Jsi2cPaAmmpEqXjSD5M7lilMmnUNdKzTkgYwpBrDsYEml4gvo/iOj8sf">
        </div>
    </form>


    <input type="hidden" id="UserID">
      <!-- 轮播大图 开始 -->
      <script type="text/javascript">
      /*根据顶部图片的高度，改变轮播图距离顶部的高度*/
          $(function(){
            var o=$(".top_ad");
            var h = o.height();
            $(".banner").css({"top":155+h});
          })
          /*根据顶部图片的高度，改变轮播图距离顶部的高度end*/
      </script>
    <div class="banner">
        <!-- 代码 开始 -->
    <link href="{views:css/nav.css}" rel="stylesheet" />
    <script src="{views:js/jquery.nav.js}" type="text/javascript"></script>
        <div id="inner">
            <div class="hot-event">
            {set:$count = count($indexSlide)}
                {foreach: items=$indexSlide}
                <div class="event-item" style="{if:$key==0}display: block;{else:}display:none;{/if}background:{$item['bgcolor']}">
                    <a href="{if:$item['link']}{$item['link']}{else:}javascript:;{/if}">
                        <img src="{$item['img']}" class="photo" style="width: 100%; height: 470px;margin:0 auto" alt="{$itme['name']}" />
                    </a>
                </div>
                {/foreach}
                <div class="switch-tab">
                    {foreach: items=$indexSlide}
                    {set:$key++}
                    <a href="javascript:;" onclick="return false;" {if:$key == 1} class="current"{/if}>{$key}</a>
                    {/foreach}
                </div>
            </div>
        </div>
        <script type="text/javascript">
             var _c = {$count};
             $('#inner').nav({ t: 5000, a: 1000, c: _c});
        </script>
        <!-- 代码 结束 -->
      </div> 
    <!-- 轮播大图 结束 -->


<!--资讯板块模板-->
<script type='text/html' id='newsBox'>
    <ul>
        <%if (data.length>0) { %>
        <%for (var i=0;i<data.length;i++) { %>
        <li class="notice_active_ch">
            <p class="data_title"><a href="{url:/detail/index@info}/id/<%=data[i].id%>"><%=data[i].name%></a></p>
            <p class="data_content"><%=data[i].short_content%></p>
        </li>
        <% } %>
        <% } %>
    </ul>
</script>
<!--资讯板块模板-->
<script type="text/html" id="configZXBox">
    <%if (data.length>0) { %>
    <%for (var i=0;i<data.length;i++) { %>
    <%if (i<6) { %>
    <li>
        <a class="two_ul_li_a" href="{url:/detail/index@info}/id/<%=data[i].id%>">
            <img class="two_product_img" src="<%=data[i].cover_pic%>"/>
            <div class="right">
                <h4><%=data[i].name%></h4>
                <p><%=data[i].short_content%></p>
            </div>
        </a>
    </li>
    <% } %>
    <% } %>
    <% } %>
</script>


<!--最新数据 开始-->
  <div class="mostnew_date" >
  
   <div id="row1_clinch" class="row1_clinch">
       <div class="clinch_tit">
           <div class="tit_time">
               <p id="time_year" class="time_year">{echo:date('Y')}<br><span class="time_month">{echo:date('m')}/{echo:date('d')}</span></p>
               <!-- <p id="time_day" class="time_day">11</p> -->
           </div>
           <div class="tit_font">
               <b>最新<span>资讯</span></b>
               <br>
               RECENT DATAS</div>
       </div>

       <div class="notice_active" id="news_box">

    
      </div>                  
   </div>
   
  </div>  
   <!--最新数据 结束-->
    <!--主要内容 开始-->

                            </div>
    <div id="mainContent">
        <div class="page_width">
            <!----第一行搜索  开始---->
            <div class="mainRow1">
                <!--搜索条件 开始-->
                <div class="wrap">
                    
             
 <!--搜索条件 结束-->

                
            </div>
            <!-----第一行搜索  结束---->
            

            
            <!----五大类  开始---->
            <div class="mainRow3">                
        <link rel="stylesheet" type="text/css" href="{views:css/style_main.css}">
                <!-- 中间内容 -->
                <div class="WebBox">
                   <!--人民币市场-->
                     <div class="i_market clearfix">

                    <div class="i_market_left" id="rmb_market">
                        <div id="floor-1" class="item"></div>

                        <div class="i_leftTit clearfix">
                            <div class="i_left_title" name="1" id="item1">交易市场</div>
                            <ul class="js_rep_offer">
                                {foreach:items=$topCat}
                                    <li class="{if:$key==0}li_select{/if}" onclick="showOffers({$item['id']},$(this))"><a href="javascript:void(0)"><em></em><span></span>{$item['name']}</a></li>

                                {/foreach}
                       <!--         <li class="li_select" onclick="showOffers(1,$(this))"><a href="javascript:void(0)"><em></em><span></span>冶金化工市场</a></li>
                            </ul> -->
                            </ul>
                          <span class="i_more"><a rel="{url:/offers/offerlist}" href="{url:/offers/offerlist}">更多&gt;&gt;</a></span>  
                        </div>

                        <div class="i_leftCon" id="offerRowBox">

                        </div>

                    </div>



                </div>    

        <link rel="stylesheet" type="text/css" href="{views:css/index.css}" />
        <link rel="stylesheet" href="{views:css/swiper.min.css}" />
        <script src="{views:js/swiper-3.4.2.jquery.min.js}"></script>
        <script>
            $(function(){
                var swiper = new Swiper('.swiper-container', {
                    pagination: '.swiper-pagination',
                    paginationClickable: true,
                    spaceBetween: 30,
                    observer:true,
                    observeParents:true,
                    autoplay: 3000
                });
                $(".nn-shebei-item").hover(function(){
                    $(this).find(".nn-jingpai-hover").fadeIn(200)
                },function() {
                    $(this).find(".nn-jingpai-hover").fadeOut(200)
                })
            })
            
        </script>
      <!--排行榜 拼眼力 设备 开始-->
        <div class="block-1">
            <div class="containers clear" >
                <div class="box nn-order">
                    <div class="nn-order-hd">
                        <a href="#">
                            <h3 class="nn-order-title">排行榜</h3>
                            <span class="nn-order-subtitle">产品热销排行榜</span>
                        </a>
                    </div>
                    <div class="nn-order-bd">
                        <div class="swiper-container">
                            <div class="swiper-wrapper" id="paihangBox">

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>

                <div class="box nn-shebei">
                    <div class="nn-shebei-hd">
                        <a href="#">
                            <h3 class="nn-order-title">竞拍专区</h3>
                            <span class="nn-order-subtitle">竞拍专区</span>
                        </a>
                    </div>

                    <div class="nn-shebei-bd clear">
                        <div class="swiper-container">
                            <div class="swiper-wrapper" id="jingjiaBox">
                                
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--排行榜 拼眼力 设备结束-->
        <div class="block-guanggao">
            <div class="containers">
                {echo: \Library\Ad::show("首页1")}
               <!--  <img src="{views:images/img_index/20160902152314953.png}" alt="" /> -->
            </div>
        </div>
        <!--光学仪器-->
        <div class="block-guess">
            <div class="containers clear" id="shebeiBox">

            </div>
        </div>
        <!--光学仪器结束-->
        <!--视频直播开始-->
        <div class="block-live">
            <div class="containers">
                <div class="nn-live-hd nn-tile-hd">
                    <h3 class="nn-live-title">—— 耐耐直播 ——</h3>
                    <span class="nn-live-subtitle">好产品实时观看</span>
                </div>
                <div class="nn-live-bd clear">
                    <div class="nn-live-left float-l">
                        <h3 class="nn-live-left-title">
                            耐耐直播
                        </h3>
                        <div class="nn-live-bg">
                            <video width="570" height="310" controls="controls" poster="{views:images/img_index/live1.jpg}">
                            <source src="movie.ogg" type="video/ogg">
                            <source src="{views:images/video/dongdacangku.mp4}" type="video/mp4">
                            <!-- <a href="#">
                                <img src="{views:images/img_index/live1.jpg}" />
                                <div class="nn-live-zhezhao"></div>
                            </a> -->
                        </div>
                    </div>
                    <div class="nn-live-right float-r">
                        <h3 class="nn-live-right-title">
                            商家直播
                        </h3>
                        <div class="nn-live-bg">
                             <video width="570" height="310" controls="controls" poster="{views:images/img_index/live2.jpg}">
                            <source src="movie.ogg" type="video/ogg">
                            <source src="{views:images/video/vode1.mp4}" type="video/mp4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--视频直播结束-->
        <!--热销产品开始-->
        <div class="block-hot">
            <div class="containers clear" id="rexiaoBox">

            </div>
        </div>
        <!--热销产品结束-->
        <!--猜你需要开始-->
                    <!--
        <div class="block-guess" >
            <div class="containers clear">
                <div class="nn-live-hd">
                    <h3 class="nn-live-title">猜你需要</h3>
                    <span class="nn-live-subtitle">我懂你的需要</span>
                </div>
                <div class="nn-guess-item">
                    <a href="#">
                        <img src="{views:images/img_index/c.jpg}" alt="" />
                        <p class="nn-guess-title">耐火球 蓄热球</p>
                        <p class="nn-guess-con"> 耐火球 直径15-60 含量65-85 厂家直销 没有中间商赚差价</p>
                        <p class="nn-guess-price">￥ <span>1500.00/吨</span></p>
                    </a>
                </div>

            </div>
        </div>
        <!--猜你需要结束-->        

                </div>

                <!-- //中间内容 -->

                            <!--//通用底部-->
            <!-- 最新交易js -->
            <script type="text/javascript" src="{views:js/script-2-AQTnlOGb8Z1ylR8UZZJBEg.js}"></script>
            <!-- 最新交易js end -->               
            </div>
            <!----五大类  结束---->
            <script type="text/javascript">
                $('document').ready(function(){
                    var obj=$('#item3').next().children().first();
                    var id=obj.attr('attr');
                    var obj2=$('#item2').next().children().first();;
                    var id2=obj.attr('attr');
                    obj2.addClass('li_select');
                    obj.addClass('li_select');
                    var recObj=$('#rec'+id);
                    var recObj2=$('#statc'+id2);
                    recObj2.css('display','block');
                    recObj.css('display','block');

                });

                //交易市场板块信息填充
                function showOffers(id,obj){
					var offerData = {$offerCateList};
                    obj.siblings().removeClass('li_select');
                    obj.addClass('li_select');

                    template.helper('getAreaText', function(area_data){
                          var areatextObj = new Area();
                          var text = areatextObj.getAreaText(area_data);
                           return text;
                    });
					if(offerData[id]){
						 var offerRowHtml = template.render('offerRowTemplate',{data:offerData[id]});
                         $('#offerRowBox').html(offerRowHtml);
					}

                }

                //填充后台配置的首页产品模块
                function showIndexOffers(templateID,boxID,configID){
                    var ajaxUrl = "{url:/AjaxData/getIndexProduct}";
                   var configId = configID;
                    $.ajax({
                        type : 'get',
                        url : ajaxUrl,
                        async  : true,
                        dataType : 'json',
                        data : {config_id:configId},
                        success : function(data){
                            if(data){
                                //alert(JSON.stringify(data));
                                var proList = template.render(templateID,{data:data});
                                $('#'+boxID).html(proList);
                            }

                        }
                    })

                }

            </script>
        </div>
    </div>  
    <!--主要内容 结束-->
        <!--耐耐网服务-->

</div>

        <div class="footer_clude">
            <!--耐耐网服务-->
            <div class="i_service clearfix">
                <div class="iServiceCon clearfix">
                    <ul>
                        {foreach:items=$fuwuList}
                            <li class="iServiceTit">
                                <div class="fw_img"><img src="{echo:\Library\Thumb::get($item['img'])}" onerror="{views:images/index/kongbai.png}"/></div>
                                <div class="wi_fw"><a href="{url:help/help}?cat_id={$item['cat_id']}&id={$item['id']}">{$item['name']}</a></div>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            <div class="div_flink">
                <ul>
                    <li class="ul_tit"><b>友情链接</b></li>
                    {set: $sum=count($frdLinkList)}
                    <ul class="lin_lists">
                    {foreach: items=$frdLinkList}
                        <li class="li_txt">
                            <a class="li_a" href="{$item['link']}">{$item['name']}</a>
                        </li>
                        {if:$key!=$sum-1}
                            <li class="li_l">
                                <span class="span_l">|</span>
                            </li>    
                        {/if}
                    {/foreach}
                    </ul> 
                </ul>
            </div>
        </div>


        <!-- 浮动楼层 -->
<link rel="stylesheet" type="text/css" href="{views:css/global_site_index_new.css}">
<div class="floor_left_box" id="floornav" data-tpa="YHD_HOMEPAGE_FLOORNAV" style="display: block;">
              <div class="show_div">
                <a href="#floor-1" data="#floor-1" rel="floor-1" class="cur fhdb_a">
                    <i class="left_iconfont " display="block"><img src="{views:images/floor_01.png}">交易市场</i>
                    <em class="two_line" display="none"><img src="{views:images/floor_cur_01.png}">交易市场</em>
                </a>
                 <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">交易市场</a>
                </div>
              </div>

            <div class="show_div">
              <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" 
              data="#toTop" rel="floor-4" style="margin-top:7px;" class="cur fhdb_a">
                  <i class="left_iconfont " display="none"><img src="{views:images/floor_04.png}">客服</i>
                  <em class="two_line" display="black"><img src="{views:images/floor_cur_04.png}">客服</em>
              </a>
               <div class="hover_div">
                    <em></em>
                    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" data="#toTop" rel="toTop" class="hove_a">联系客服</a>
                </div>
            </div>
            <div class="show_div">
                  <a href="javascript:scroll(0,0)" class="fhdb_a" data="#toTop" rel="toTop">
                      <i class="left_iconfont " display="none"><img src="{views:images/floor_05.png}">返回顶部</i>
                      <em class="two_line" display="black"><img src="{views:images/floor_cur_05.png}">返回顶部</em>
                  </a>
                <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">返回顶部</a>
                </div>
            </div>

        </div>
        <!-- 浮动楼层 end -->


<script type='text/html' id='offerRowTemplate'>
    <ul class="i_leftCon_ul">
        <%if (data.length>0) { %>
        <%for (var i=0;i<data.length;i++) { %>
        <li class="market_ul_li">
            <a href="{url:/offers/offerdetails}/id/<%==data[i].id%>/pid/<%=data[i].product_id%>">
                <div class="product_img"><img src=" <%=data[i].img%>"></div>
                <h4> <%=data[i].pname%></h4>
                <p> <%=data[i].note%></p>
                <p class="product_price">
                    <%if (data[i].sub_mode==1) {%>
                    ￥<%=data[i].price_l%>-<%=data[i].price_r%>
                    /<%=data[i].unit%>
                    <% } else {%>
                    ￥<%=data[i].price%>/ <%=data[i].unit%>
                    <% } %>
                </p>
            </a>
        </li>

        <% } %>
        <% } %>
    </ul>
</script>

<script type="text/html" id="jingjiaTemplate">
    <%if (data.length>0) { %>
    <div class="swiper-slide" >                           
    <%for (var i=0;i<data.length;i++) { %>
    <%if (i<6) { %>
    <div class="nn-shebei-item jingpai-new">
        <a href="{url:/bidprice/biddetails}?id=<%==data[i].id%>" target="_blank">
            <img src="<%=data[i].img%>" alt="" />
            <h3 class="nn-shebei-title"><%=data[i].name%></h3>
            <p class="nn-shebei-con"><%=data[i].note%></p>
            <p class="nn-shebei-price">￥
                <span class="shebei-price-num">
                    <%=data[i].price_l%>-
                    <%=data[i].price_r%>
                    </span> /<%=data[i].unit%>
            </p>
            <div class="nn-jingpai-hover">
                <div class="nn-jingpai-cir">
                    去竞拍
                </div>
            </div>
        </a>
    </div>
    <% } %>
    <% } %>
    </div>
    <% } %>

    <%if (data.length>6) { %>
     <div class="swiper-slide" >
    <%for (var i=0;i<data.length;i++) { %>
    <%if (i>5&&i<12) { %>
    <div class="nn-shebei-item jingpai-new">
        <a href="{url:/bidprice/biddetails}?id=<%==data[i].id%>" target="_blank">
            <img src="<%=data[i].img%>" alt="" />
            <h3 class="nn-shebei-title"><%=data[i].name%></h3>
            <p class="nn-shebei-con"><%=data[i].note%></p>
            <p class="nn-shebei-price">￥
                <span class="shebei-price-num">
                    <%=data[i].price_l%>-
                    <%=data[i].price_r%>
                </span>/<%=data[i].unit%>
            </p>
            <div class="nn-jingpai-hover">
                <div class="nn-jingpai-cir">
                    去竞拍
                </div>
            </div>
        </a>
    </div>
    <% } %>
    <% } %>
    </div>
    <% } %>
</script>

<script type="text/html" id="shebeiTemplate">
    <div class="nn-live-hd nn-tile-hd">
        <h3 class="nn-live-title">—— 有好货 ——</h3>
        <span class="nn-live-subtitle"></span>
    </div>
    <%if (data.length>0) { %>
        <%for (var i=0;i<data.length;i++) { %>
            <div class="nn-guess-item">
                <a href="{url:/offers/offerdetails}/id/<%==data[i].id%>/pid/<%=data[i].product_id%>" target="_blank">
                    <img src="<%=data[i].img%>" alt="" />
                    <p class="nn-guess-title"><%=data[i].name%></p>
                    <p class="nn-guess-con"> <%=data[i].note%></p>
                    <p class="nn-guess-price">￥<span><%=data[i].price%>/<%=data[i].unit%></span></p>
                </a>
            </div>
        <% } %>
    <% } %>
</script>

<script type="text/html" id="rexiaoTemplate">
    <div class="nn-live-hd nn-tile-hd">
        <h3 class="nn-live-title">—— 热销产品 ——</h3>
        <span class="nn-live-subtitle">热销产品</span>
    </div>
    <%if (data.length>0) { %>
        <%for (var i=0;i<data.length;i++) { %>
            <div class="nn-hot-item">
                <a href="{url:/offers/offerdetails}/id/<%==data[i].id%>/pid/<%=data[i].product_id%>" target="_blank">
                    <img src="<%=data[i].img%>" alt="" />
                    <p class="nn-guess-title"><%=data[i].name%></p>
                    <p class="nn-guess-con">  <%=data[i].note%></p>
                    <p class="nn-guess-price">￥<span><%=data[i].price%>/<%=data[i].unit%></span></p>
                </a>
            </div>
        <% } %>
    <% } %>
</script>

<script type="text/html" id="paihangTemplate">
    <div class="swiper-slide">
        <%if (data.length>0) { %>
        <%for (var i=0;i<data.length;i++) { %>
        <%if (i<3) { %>
        <div class="nn-order-item clear">
            <a class="nn-order-link" href="{url:/offers/offerdetails}/id/<%==data[i].id%>/pid/<%=data[i].product_id%>" target="_blank">
                <span class="nn-order-img">
                    <img src="<%=data[i].img%>" alt="" />
                </span>
                <span class="nn-order-num order-<%=i+1%>"><%=i+1%></span>
                <span class="nn-order-txt"><%=data[i].name%></span>
            </a>
        </div>
        <% } %>
        <% } %>
        <% } %>
    </div>
    <div class="swiper-slide">
        <%if (data.length>3) { %>
        <%for (var i=0;i<data.length;i++) { %>
        <%if (i>2&&i<6) { %>
        <div class="nn-order-item clear">
            <a class="nn-order-link" href="{url:/offers/offerdetails}/id/<%==data[i].id%>/pid/<%=data[i].product_id%>" target="_blank">
                <span class="nn-order-img">
                    <img src="<%=data[i].img%>" alt="" />
                </span>
                <span class="nn-order-num order-slib"><%=i+1%></span>
                <span class="nn-order-txt"><%=data[i].name%></span>
            </a>
        </div>
        <% } %>
        <% } %>
        <% } %>
    </div>
</script>


