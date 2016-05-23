<!DOCTYPE html>
<html>
<head>
  <title>缴纳保证金</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  <link href="../css/user_index.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../js/user_index.js"></script>
   <script src="../js/center.js" type="text/javascript"></script>
  <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="../css/pay_ment.css" rel="stylesheet" type="text/css" /> 
  <script src="../js/pay_ment.js" type="text/javascript"></script>

   <!-- 头部控制 -->
  <link href="../css/topnav20141027.css" rel="stylesheet" type="text/css">
  <script src="../js/topnav20141027.js" type="text/javascript"></script>
    <!-- 头部控制 -->
</head>
<body>
<!-- 	公用头部控件 -->
	<div class="bg_topnav">
    <div class="topnav_width">
        <div class="topnav_left">
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="login.html" target="_blank" class="topnav_login">登录</a>
                <div class="login_box" id="login_boxMain" style="display: none;">
                    <input name="gtxh_LoginMobile" type="text" id="gtxh_LoginMobile" class="txt_topnav" value="手机号码" maxlength="11">
                    <br>
                    <input type="text" id="gtxh_importpwd" class="txt_topnav" value="登录密码" maxlength="11">
                    <input name="gtxh_LoginPwd" type="password" id="gtxh_LoginPwd" maxlength="20" style=" display:none;">
                    <br>
                    <input type="button" value="登录" id="gtxh_btnLogin" class="btn_topnav_login" onclick="javascript:_utaq.push(['trackEvent','btn-log']);">
                    &nbsp;
                    <input name="gtxh_autoLogin" type="checkbox" id="gtxh_autoLogin" style="vertical-align: middle" checked="checked">
                    <label for="checkbox">两周内自动登录</label>
                    <br>
                    <a href="PasswordReset.html" target="_blank">忘记密码</a> <a href="register.html" target="_blank">立即注册</a>
                </div>
                <div class="topnav_regsiter" style=" float:right;">
                    <a rel="external nofollow" href="register.html" target="_blank">免费注册</a>
                </div>
            </div>
            <div class="topnav_login_in" id="userCenterbox" style="display: none;">
                您好，<label class="icon_topnav_loginin" id="gtxh_uame"></label>
                <a id="userCenter" href="centre/user_index.html" target="_blank">会员中心</a>
                <a id="loginOut" href="javascript:">退出</a>
                <iframe id="iframe_loginOut" frameborder="0" height="1" width="1" scrolling="no"></iframe>
            </div>
        </div>
        <div class="topnav_right">
            <ul>
                <li>
					<div class="top_app" id="topPhone">
                        <a href="javascript:;"><em class="icons iphone"></em><span>手机APP</span></a>
						<a rel="external nofollow" href="http://app.nainaiwang.com/" class="top_a" target="_blank" style="display:none !important;visibility: hidden"><!--<em class="icons zz"></em>--><i style="font-size:14px;">▪</i><span>掌中耐耐APP</span></a>
					</div>
                </li>
                <li>
                    <div class="popueButton">
                        <a href="javascript:window.external.AddFavorite('http://www.nainaiwang.com', '耐耐网——大宗商品交易中心')">加入收藏</a>
                    </div>
                </li>
                <li>
                    <div class="popueButton">
                        <div id="popue_quick">
                            网站导航<b> </b></div>
                    </div>
                    <div class="popuePanel" id="quickPanel" style="display: none;">
                        <div class="quick_market">
                            <b>产品分类</b><br>
                            <span>耐火市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2411" target="_blank">低合金板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2414" target="_blank">容器板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2406" target="_blank">热轧开平板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2410" target="_blank">中厚板</a><br>
                            <span>建材市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2405" target="_blank">热轧卷板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2592" target="_blank">镀锌带钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2415" target="_blank">冷轧卷板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2603" target="_blank">低合金卷</a><br>
                            <span>钢铁市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2475" target="_blank">等边角钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2423" target="_blank">H型钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2421" target="_blank">槽钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2422" target="_blank">工字钢</a><br>
                            <span>冶金化工 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2434" target="_blank">无缝管</a>
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2435" target="_blank">方管</a>
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2433" target="_blank">镀锌管</a>
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2432" target="_blank">焊管</a><br>
                            <span>其他市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2427" target="_blank">螺纹钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2429" target="_blank">圆钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2430" target="_blank">高线</a>
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2522" target="_blank">盘螺</a><br>
                            <span>核心企业 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2440" target="_blank">合结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2439" target="_blank">碳结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2631" target="_blank">合金钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2458" target="_blank">轴承钢</a><br>
                            <span>仓储专区 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2440" target="_blank">合结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2439" target="_blank">碳结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2631" target="_blank">合金钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2458" target="_blank">轴承钢</a>
                        </div>
                        <div class="quick_info">
                            <div class="quick_city">
                                <b>地区分站</b><br>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E4%B8%8A%E6%B5%B7" target="_blank">上海</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%9D%AD%E5%B7%9E" target="_blank">杭州</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%97%A0%E9%94%A1" target="_blank">无锡</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%83%91%E5%B7%9E" target="_blank">郑州</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%AD%A6%E6%B1%89" target="_blank">武汉</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%95%BF%E6%B2%99" target="_blank">长沙</a><br>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E5%B9%BF%E5%B7%9E" target="_blank">广州</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E5%94%90%E5%B1%B1" target="_blank">唐山</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%88%90%E9%83%BD" target="_blank">成都</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%82%AF%E9%83%B8" target="_blank">邯郸</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%87%8D%E5%BA%86" target="_blank">重庆</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E5%A4%A9%E6%B4%A5" target="_blank">天津</a>
                            </div>
                            <b>信息行情</b><br>
                            <a href="http://news.nainaiwang.com/xianhuojiage.html" target="_blank">现货价格</a>
                            <a href="http://news.nainaiwang.com/gangweizixun.html" target="_blank">钢为资讯</a>
                            <a href="http://news.nainaiwang.com/hangyefenxi.html" target="_blank">行业分析</a><br>
                            <a href="http://news.nainaiwang.com/jiageyuce.html" target="_blank">价格预测</a>
                            <a href="http://news.nainaiwang.com/gangchangtiaojia.html" target="_blank">钢厂调价</a>
                            <a href="http://news.nainaiwang.com/yuancailiao.html" target="_blank">原材料</a>
                            <div class="quick_info_bottom">
                                <span><a href="http://market.nainaiwang.com/brand.html" target="_blank">品牌店</a></span>
                                <span><a href="http://bbs.nainaiwang.com/" target="_blank">耐耐朋友圈</a></span>
                                <span class="red"> <a href="http://app.nainaiwang.com/" target="_blank">掌中耐耐APP</a></span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- 公用头部控件 -->
<div class="header">
		<div class="nav">
			<div class="logo-box zn-l">
				<a href="../index.html" alt="返回耐耐首页"><img src="../images/icon/nainaiwang.png"/></a></dd>
			</div>
			<div class="nav-tit">
				<ul class="nav-list">
					<li>
						<a href="user_index.html">会员中心</a>
					</li>
					<li>
						<a href="user_zh.html">账户信息</a>
					</li>
					<li>
						<a href="user_zj.html">资金管理</a>
					</li>
					<li>
						<a href="user_dd.html" class="cur">交易管理</a>
					</li>
					<li>
						<a href="user_cd.html">仓单管理</a>
					</li>
					<li>
						<a href="user_chl.html">车辆管理</a>
					</li>
					<li>
						<a href="user_gz.html">关注中心</a>
					</li>
			 	</ul>
			</div>
		</div>
	</div>
	<div class="user_body">
		<div class="user_b">
			
			<!--start左侧导航-->	
			<div class="user_l">
				<div class="left_navigation">
					<ul>
						<li class="let_nav_tit"><span class="line"></span><h3>交易管理</h3></li>
						<li class="btn1" id="btn1">
							<a class="nav-first">销售管理<i class="icon-caret-down"></i></a>
							<ul class="zj_zh">
								<li><a href="chp_list.html">销售列表</a></li>
								<li><a href="offer_index.html">发布产品</a></li>
							</ul>
						</li>								
						
						<li class="btn1" id="btn2">
							<a class="nav-first">采购管理<i class="icon-caret-right"></i></a>
							<ul class="zj_zh" id="zj_zh2">
								<li><a href="procurement_list.html">采购列表</a></li>
                                <li><a href="procurement_fb.html">发布采购</a></li>
							</ul>
						</li>
							
						<li class="btn1" id="btn3">
							<a class="nav-first">合同管理<i class=" icon-caret-right"></i></a>
							<ul class="zj_zh" id="zj_zh1">
								<li><a href="sales_list.html">销售合同</a></li>
								<li><a class="cur" href="buy_list.html">购买合同</a></li>
							</ul>

						</li>
						<li  class="btn1"><a class="nav-first">申诉管理<i class=" icon-caret-right"></i></a>
                            <ul class="zj_zh">
                                <li><a href="user_complaint.html">合同申诉</a></li>
                                <li><a href="user_complaint.html">提货申诉</a></li>
                            </ul>
                        </li>
					</ul>
				</div>
			</div>
			<!--end左侧导航-->
			<!--start中间内容-->	
			<div class="user_c_list no_bor">
				<div class="user_zhxi">


					
                   <div class="checkim">
                       <h2>核对买家下单信息</h2>

                       <table class="detail_tab" border="1" cellpadding="0" cellspacing="0" width="100%">
                                  <tbody><tr class="detail_title">
                                    <td colspan="10"><strong>订单详情</strong></td>
                                  </tr>
                                  <tr style="line-height: 30px;">
                                    <td style="background-color: #F7F7F7;" width="100px">订单号</td>
                                    <td colspan="3" width="230px">DBBD26014</td>
                                    <td style="background-color: #F7F7F7;" width="100px">订单日期</td>
                                    <td colspan="5" width="230px">2016-04-26 16:54:28</td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F7F7F7; padding-top: 5px;" valign="top" width="100px">商品信息</td>
                                    <td colspan="10" style="padding-left: 0px;">
                                        <table style="line-height: 30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                          <tbody><tr style="border-bottom:1px dashed #BFBFBF;">
                                            <td width="240px">品名</td>
                                            <!-- <td width="130px">生产厂家</td> -->
                                            <td width="120px">仓库</td>
                                            <td width="100px">单价</td>
                                            <td width="100px">数量</td>
                                            <td width="100px">重量</td>
                                            <td width="100px">小计</td>
                                            <td width="100px">手续费</td>
                                          </tr>

                                          
                                          <tr>
                                            <td>建材市场/五金产品/垫圈、挡圈</td>
                                         <!--   <td></td> --> 
                                            <td>多方位仓库</td>
                                            <td>
                                                    <label class="" id="d_price_1">
                                                        5.00 
                                                    </label> 元/吨
                                            </td>
                                            <td>
                                            --
                                        </td>
                                            <td>10
                                            吨</td>
                                            <td><label class="">
                                        
                                            <label class="price02">￥</label>
                                            <label class="" id="d_sum_money_1">
                                                50.00
                                            </label>
                                        
                                        
                                        </label></td>
                                        <td><label class="">
                                        
                                            <label class="price02">￥</label>
                                            <label class="" id="d_sum_comm_1">
                                                0.00
                                            </label>
                                        </label></td>
                                          </tr>  
                                           
                                        </tbody></table>
                                </td>
                              </tr>
                              <tr style="line-height: 35px;">
                                <td style="background-color: #F7F7F7;" width="100px">合同</td>
                                <td colspan="3" width="" style="color: #c81624;">已支付定金，等耐卖家缴纳保证金</td>
                                <td style="background-color: #F7F7F7;" width="100px">合同金额</td>
                                <td colspan="1" width="">
                                        <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                                        <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                            50.00
                                        </span>   
                                </td>
                                 <td style="background-color: #F7F7F7;" width="100px">保证金比例</td>
                                <td colspan="1" width="">
                                        <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                                        <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                            10%
                                        </span>   
                                </td>

                                <td style="background-color: #F7F7F7;" width="100px">需缴纳保证金</td>
                                <td colspan="1" width="">
                                        <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                                        <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                            5.00
                                        </span>   
                                </td>
                              </tr>
                            </tbody></table>

                          <div class="pay_type">
                              <h3 class="add_zhifu">支付方式：</h3>
                              <h3 class="addwidth">
                                <div class="yListr" id="yListr">
                                  
                                      <ul>
                                          <li><em name="chooice" class="yListrclickem">市场代理账户<i></i></em> <em name="chooice">银行签约账户<i></i></em> <em name="chooice">票据账户<i></i></em> </li>
                                      </ul>
                              </div> 

                        <script type="text/javascript">
                            $(function() {
                                $(".yListr ul li em").click(function() {
                                    $(this).addClass("yListrclickem").siblings().removeClass("yListrclickem");
                                })
                            });
                        </script>
                       
                   <div id="bain_bo">
                   <form action="" method="post">
                   <!-- <div class="sty_online" style="display:block;">
                        
						   <label for=""><input name="abc" type="radio" value="" />余额支付</label>
						    <label for=""><input name="abc" type="radio" value="" />支付宝</label>
						     <label for=""><input name="abc" type="radio" value="" />银联在线</label>

                   </div>
                   <div class="sty_offline">
                        <ul>
                        	<li>账户名称：XX科技有限公司</li>
                        	<li>开户银行：XX银行XXXX支行</li>
                        	<li>银行账号：100004454415113</li>
                        	<li>请您将贷款转到此账户，我们将为您审核，联系卖家发货！</li>
                        	<li><span>上传凭证：</span>
                            <div id="preview"></div>
    
							<input class="uplod" type="file" onchange="previewImage(this)" />


                        	</li>
                        </ul>
                      
                    
                    </div> -->
                   </form> 
                  </div>  
                            
                       </h3> 
                         </div>


                  <div class="pay_bton">
                  	<h5>待支付金额：<i>5</i>元</h5>
                  	<a href="pay_sucsure.html">立即缴纳保证金</a>
                  </div>


                           </div>


               

				</div>				
				
			</div>
			<!--end中间内容-->	
					
		</div>
	</div>
</body>
</html>
</html>