<!DOCTYPE html>
<html>
<head>
  <title>个人中心</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  <link href="http://localhost/nn2/user/public/views/pc/css/user_index.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://localhost/nn2/user/public/js/jquery/jquery-1.7.2.min.js"></script>



  <script language="javascript" type="text/javascript" src="http://localhost/nn2/user/public/views/pc/js/My97DatePicker/WdatePicker.js"></script>
  <script type="text/javascript" src="http://localhost/nn2/user/public/views/pc/js/regular.js"></script>
   <script src="http://localhost/nn2/user/public/views/pc/js/center.js" type="text/javascript"></script>
  <link href="http://localhost/nn2/user/public/views/pc/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
   <!-- 头部控制 -->
  <link href="http://localhost/nn2/user/public/views/pc/css/topnav20141027.css" rel="stylesheet" type="text/css">
  <script src="http://localhost/nn2/user/public/views/pc/js/topnav20141027.js" type="text/javascript"></script>
    <!-- 头部控制 -->

    <script type="text/javascript" src="http://localhost/nn2/user/public/js/form/validform.js" ></script>
    <script type="text/javascript" src="http://localhost/nn2/user/public/js/form/formacc.js" ></script>
    <script type="text/javascript" src="http://localhost/nn2/user/public/js/layer/layer.js"></script>
</head>
<body>
<!--    公用头部控件 -->
    <div class="bg_topnav">
    <div class="topnav_width">
        <div class="topnav_left">
            <div class="login_link" id="toploginbox">
                <?php if($login==0){?>
                <a rel="external nofollow" href="http://localhost/nn2/user/public/index/login" target="_blank" class="topnav_login">登录</a>
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
                    <a href="PasswordReset.html" target="_blank">忘记密码</a> <a href="http://localhost/nn2/user/public/index/register" target="_blank">立即注册</a>
                </div>
                <div class="topnav_regsiter" style=" float:right;">
                    <a rel="external nofollow" href="register.html" target="_blank">免费注册</a>
                </div>
                <?php }else{?>
                    您好，<?php echo isset($username)?$username:"";?>
                    <a rel="external nofollow" href="http://localhost/nn2/user/public/index/logout" >退出</a>
                <?php }?>
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
                <a href="../index.html" alt="返回耐耐首页"><img src="http://localhost/nn2/user/public/views/pc/images/icon/nainaiwang.png"/></a></dd>
            </div>
			<div class="nav-tit">
                <ul class="nav-list">
                    <?php foreach($topArray as $key => $topList){?>
                        <li>
                            <a href="<?php echo isset($topList['url'])?$topList['url']:"";?>" <?php if( $topList['isSelect']){?> class="cur" <?php }?>><?php echo isset($topList['title'])?$topList['title']:"";?></a>
                        </li>
                    <?php }?>

                </ul>
			</div>
		</div>
	</div>
	<div class="user_body">
		<div class="user_b">
			<!--start左侧导航--> 
            <div class="user_l">
                <?php if(!empty($leftArray)){?>
                <div class="left_navigation">
                    <ul>

                    	<?php foreach($leftArray as $k => $leftList){?>

                    		<?php if( $k == 0){?>
                    		<li class="let_nav_tit"><h3><?php echo isset($leftList['name'])?$leftList['name']:"";?></h3></li>
                    		<?php }else{?>
                            <li class="btn1" id="btn<?php echo isset($k)?$k:"";?>">
                                <a class="nav-first <?php if(isset($leftList['action']) && in_array($action,$leftList['action'])){?>cur<?php }?>" <?php if(isset($leftList['url'])){?> href="<?php echo isset($leftList['url'])?$leftList['url']:"";?>"<?php }?> >
                                    <?php echo isset($leftList['name'])?$leftList['name']:"";?>
                                    <i class="icon-caret-down"></i>
                                </a>
                                <?php if( !empty($leftList['list'])){?>
                                    <ul class="zj_zh" >
                                        <?php foreach($leftList['list'] as $key => $list){?>
                                            <li><a  href="<?php echo isset($list['url'])?$list['url']:"";?>" <?php if(in_array($action,$list['action'])){?>class="cur"<?php }?> ><?php echo isset($list['title'])?$list['title']:"";?></a></li>
                                        <?php }?>
                                    </ul>
                                <?php }?>
                            </li>

                    		<?php }?>



                    	<?php }?>
                        
                      
                    </ul>
                </div>
                <?php }else{?>
                    <div class="wrap_con">
                        <div class="personal_data">
                            <div class="head_portrait">
                                <a href="#">
                                    <img src="http://localhost/nn2/user/public/views/pc/images/icon/head_portrait.jpg">
                                </a>
                            </div>
                            <div class="per_username">
                                <p class="username_p"><b>上午好，<?php echo isset($username)?$username:"";?></b></p>
                                <p class="username_p"><img src="<?php echo isset($group['icon'])?$group['icon']:"";?>"><?php echo isset($group['group_name'])?$group['group_name']:"";?></p>
                                <p class="username_p">消息提醒：<b class="colaa0707">24</b></p>
                                <p class="username_p"><a class="padding_right" href="">去认证</a><a class="col1734b1" href="">仓储管理</a></p>
                            </div>
                            <div class="per_function">
                                <a href="user_zh.html">基本信息设置</a>
                                <a href="zh_mm.html">修改密码</a>
                            </div>
                            <div class="per_collection">
                                <p class="collection_padding col1734b1">信誉保证金有什么好处</p>
                                <p class="collection_padding colaa0707">已缴纳信誉保证金</p>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!--end左侧导航-->
            <div id="cont">
                <link href="http://localhost/nn2/user/public/views/pc/css/user_index.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/nn2/user/public/views/pc/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/nn2/user/public/views/pc/css/pay_ment.css" rel="stylesheet" type="text/css" /> 

   <!-- 头部控制 -->
  <link href="../css/topnav20141027.css" rel="stylesheet" type="text/css">
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
                                    <td colspan="3" width="230px"><?php echo isset($data['order_no'])?$data['order_no']:"";?></td>
                                    <td style="background-color: #F7F7F7;" width="100px">订单日期</td>
                                    <td colspan="5" width="230px"><?php echo isset($data['create_time'])?$data['create_time']:"";?></td>
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
                                            <td><?php echo isset($data['name'])?$data['name']:"";?></td>
                                         <!--   <td></td> --> 
                                            <td>多方位仓库</td>
                                            <td>
                                                    <label class="" id="d_price_1">
                                                        <?php echo isset($data['price'])?$data['price']:"";?> 
                                                    </label> 元/<?php echo isset($data['unit'])?$data['unit']:"";?>
                                            </td>
                                            <td>
                                            --
                                        </td>
                                            <td><?php echo isset($data['num'])?$data['num']:"";?>
                                            <?php echo isset($data['unit'])?$data['unit']:"";?></td>
                                            <td><label class="">
                                        
                                            <label class="price02">￥</label>
                                            <label class="" id="d_sum_money_1">
                                                <?php echo isset($data['amount'])?$data['amount']:"";?>
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
                                            <?php echo isset($data['amount'])?$data['amount']:"";?>
                                        </span>   
                                </td>
                                 <td style="background-color: #F7F7F7;" width="100px">保证金比例</td>
                                <td colspan="1" width="">
                                        <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;"></span>
                                        <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                            <?php echo isset($data['seller_percent'])?$data['seller_percent']:"";?>%
                                        </span>   
                                </td>

                                <td style="background-color: #F7F7F7;" width="100px">需缴纳保证金</td>
                                <td colspan="1" width="">
                                        <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                                        <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                            <?php echo isset($data['seller_deposit'])?$data['seller_deposit']:"";?>
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
                    <h5>待支付金额：<i><?php echo isset($data['seller_deposit'])?$data['seller_deposit']:"";?></i>元</h5>
                    <a href="http://localhost/nn2/user/public/deposit/sellerdeposit/order_id/<?php echo $data['id'];?>/pay/1/action_confirm/1/info/确认缴纳保证金">立即缴纳保证金</a>
                  </div>


                           </div>


               

                </div>              
                
            </div>
            <!--end中间内容-->  
                    
            </div>

				<!--end中间内容-->	
			<!--start右侧广告-->			
			<div class="user_r">
				<div class="wrap_con">
					<div class="tit clearfix">
						<h3>公告</h3>
					</div>
					<div class="con">
						<div class="con_medal clearfix">
							<ul>
								<li><a>暂无勋章</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--end右侧广告-->
		</div>
	</div>
<script type="text/javascript">
    $(function() {
        $('.left_navigation ').find('.cur').parents('.btn1').find('.nav-first').trigger('click');
    })
</script>
</body>
</html>