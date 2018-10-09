<!DOCTYPE html>
<html>
 <head>
        <title>交易管理后台</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="x-ua-compatible" content="IE=edge" >

        
        <!-- jQuery AND jQueryUI -->
     <script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>

     <script type="text/javascript" src="{views:js/libs/jqueryui/1.8.13/jquery-ui.min.js}"></script>
     <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
        <link rel="stylesheet" href="{views:css/min.css}" />
        <script type="text/javascript" src="{views:js/min.js}"></script>
        <style type="text/css">
            html { overflow-y:hidden; }
        </style>
        
    </head>
    <body>
        
        <script type="text/javascript" src="{views:content/settings/main.js}"></script>
		  <script type="text/javascript">
		  $(function(){
		      var h = $(window).height() -42;
		      $('iframe').attr('height',h+'px');
		  })
				
		
		</script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />
        <div id="head">
            <div class="left">
                <a href="#" class="button profile"><img src="{views:img/icons/top/huser.png}" alt="" /></a>
                {$info['role']}
                <a href="#">{$info['name']}</a>
                |
                <a href="{url:/login/logout}">退出</a>
                <a href="{url:/index/index@deal}">返回网站首页</a>
                <a name='clearCache' href="javascript:void(0)" onclick="clearCache('{url:/index/clearCache}')">清除缓存</a>
                <a name='clearCache' href="{url:system/admin/comadminPwd?id=$info['id']}" target="content">修改密码</a>

            </div>
          <!--   <div class="right">
                <form action="#" id="search" class="search placeholder">
                    <label>查找</label>
                    <input type="text" value="" name="q" class="text"/>
                    <input type="submit" value="rechercher" class="submit"/>
                </form>
            </div> -->
        </div>
                
                
        <!--            
                SIDEBAR
                         --> 
        <div id="sidebar">
            <ul>
                <li>
                    <a href="#" no_access='no_access'>
                        <img src="{views:img/icons/menu/inbox.png}" alt="" />
                        耐耐网后台管理系统
                    </a>
                </li>
                <li class="current"><a target="content"><img src="{views:img/icons/menu/layout.png}" alt="" />系统管理</a>
                    <ul>
                        <li class="current"><a target="content">权限管理</a>
                            <ul>
                                <li><a href="{url:system/rbac/roleList}" target="content">管理员分组</a></li>
                                <li><a href="{url:system/rbac/accessList}" target="content">权限分配</a></li>
                            </ul>
                        </li>
                        <li><a target="content">系统配置项</a>
                            <ul>
                                <li><a href="{url:system/Confsystem/creditList}" target="content">信誉值配置列表</a></li>
                                <li><a href="{url:system/Confsystem/scaleOfferOper}" target="content">报盘费率设置</a></li>
                                <li><a href="{url:system/Confsystem/entrustList}" target="content">委托费率设置</a></li>
                                <li><a href="{url:system/Confsystem/generalList}" target="content">一般设置</a></li>
                                <li><a href="{url:system/Confsystem/productset}" target="content">商品排序设置</a></li>
                                <li><a href="{url:system/Confsystem/indexconfigList}" target="content">首页配置</a></li>
                                <li><a href="{url:system/Confsystem/workdaylist}" target="content">银行假日管理</a></li>
                            </ul>
                        </li>
                        <li><a target="content">管理员信息</a>
                            <ul>
                                <li><a href="{url:system/admin/adminAdd}" target="content">新增管理员</a></li>
                                <li><a href="{url:system/admin/adminList}" target="content">管理员列表</a></li>
                                <li><a href="{url:system/admin/logList}" target="content">管理员操作记录</a></li>
                                <li><a href="{url:system/admin/checkNotice}" target="content">审核通知</a></li>
                            </ul>
                        </li>
                        <!-- <li><a  target="content">系统设置</a></li> -->

                        <li><a href="{url:system/kefu/kefuList}" target="content">客服管理</a></li>
                        <li><a href="{url:system/yewu/kefuList}" target="content">业务员管理</a></li>
                    </ul>
                </li>
                <li><a target="content"><img src="{views:img/icons/menu/brush.png}" alt="" />会员管理</a>
                    <ul>
                        <li><a target="content">用户认证</a>
                            <ul>
                                <li><a  target="content">交易商认证</a>
                                    <ul>
                                        <li><a href="{url:member/certManage/dealerCert}" target="content">待审核</a></li>
                                        <li><a href="{url:member/certManage/dealerCerted}" target="content">已审核</a></li>
                                    </ul>
                                </li>
                                <li><a  target="content">仓库认证</a>
                                    <ul>
                                        <li><a href="{url:member/certManage/storeCert}" target="content">待审核</a></li>
                                        <li><a href="{url:member/certManage/storeCerted}" target="content">已审核</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!--
                        <li><a href='' target="content">子账户权限管理</a>
                            <ul>
                                <li><a href="{url:member/subRoleList}" target="content">角色列表</a></li>
                                <li><a href="{url:member/roleAdd}" target="content">添加角色</a></li>
                            </ul>
                        </li>-->

                        <li><a href="{url:member/usergroup/groupList}" target="content">用户等级</a></li>
                        <li><a href="{url:member/payUserGroup/groupList}" target="content">收费会员等级</a></li>
                        <li><a target="content">会员管理</a>
                            <ul>
                                <li><a href="{url:member/vipManage/applyList}" target="content">申请会员列表</a></li>
                                <li><a href="{url:member/vipManage/vipList}" target="content">会员列表</a></li>
                            </ul>
                        </li>
                        <li><a target="content">用户管理</a>
                            <ul>
                                <li><a href="{url:member/member/memberList}" target="content">用户列表</a></li>
                                <li><a href="{url:member/member/userNotice}" target="content">通知用户</a></li>
                                <li><a href="{url:member/member/OnLineList}" target="content">在线用户信息</a></li>
                                <li><a href="{url:member/member/userlog}" target="content">用户日志列表</a></li>
                                <li><a href="{url:member/member/userfund}" target="content">用户资金列表</a></li>
                            </ul>
                        </li>

                        <li><a target="content">菜单管理</a>
                         <ul>
                                <li><a href="{url:member/Menu/MenuList}" target="content"> 菜单列表</a></li>
                                <li><a href="{url:member/Menu/addMenu}" target="content">菜单添加</a></li>
                                <li><a href="{url:member/Menu/menuRoleList}" target="content">菜单角色列表</a></li>
                            </ul>
                            </li>
                        <li><a target="content">代理商管理</a>
                            <ul>
                                <li><a href="{url:member/agent/agentList}" target="content">代理商列表</a></li>
                                <li><a href="{url:member/agent/addAgent}" target="content">代理商添加</a></li>
                            </ul>
                        </li>
                        <li>
                            <a target="content">推荐商户</a>
                            <ul>
                                <li><a href="{url:member/companyRec/recList}" target="content" >推荐商户</a></li>
                                <li><a href="{url:member/companyRec/recAdd}" target="content" >添加推荐</a></li>
                            </ul>
                        </li>
                        <li>
                            <a target="content">支付密码修改</a>
                            <ul>
                                <li><a href="{url:member/member/applyPayList}" target="content" >待审核</a></li>
                                <li><a href="{url:member/member/resetpayList}" target="content" >重置密码</a></li>
                                <li><a href="{url:member/member/checkPayList}" target="content" >已审核</a></li>
                            </ul>
                        </li>
                        <li>
                            <a target="content">修改手机号</a>
                            <ul>
                                <li><a href="{url:member/member/applyTelList}" target="content" >待审核</a></li>
                                <li><a href="{url:member/member/resetTelList}" target="content" >修改手机号</a></li>
                                <li><a href="{url:member/member/checkTelList}" target="content" >已审核</a></li>
                            </ul>
                        </li>
                        <!--<li><a href="shop-list.html" target="content">商铺管理</a></li>-->
                       <!-- <li><a href="business-list.html" target="content">业务撮合人员列表</a></li>-->
                       <li>
                        <a target="content">企业管理</a>
                            <ul>
                                <li> <a href="{url:member/member/addcompany}" target="content">新增企业及列表</a></li>
                                <li><a href="{url:member/member/asscompany}" target="content">关联账号审核</a></li> 
                            </ul>
                       
                       </li>
                    </ul>
                </li>
                <li><a target="content"><img src="{views:img/icons/menu/brush.png}" alt="" />交易管理</a>
                    <ul>
                        <li><a href="{url:trade/product/categoryAdd}" target="content">产品设置</a>
                            <ul>
                                <li><a href="{url:trade/product/categoryList}" target="content">分类列表</a></li>
                                <li><a href="{url:trade/product/attributeList}" target="content">属性列表</a></li>
                            </ul>
                        </li>


                        <li><a target="content">报盘管理</a>
                            <ul>
                                <li><a href="{url:trade/OfferManage/kefuOfferList}" target="content">客服报盘列表</a></li>
                                <li><a href="{url:trade/OfferManage/offerList}" target="content">报盘管理</a></li>
                                <li><a href="{url:trade/OfferManage/jingjiaList}" target="content">竞价管理</a></li>
                                <li><a href="{url:trade/OfferManage/offerReview}" target="content">报盘审核</a></li>
                                <li><a href="{url:trade/OfferManage/expireOfferList}" target="content">历史报盘信息查询</a></li>
                                <li><a href="{url:trade/OfferManage/offerRecycle}" target="content">报盘信息垃圾箱</a></li>
                                <li><a href="{url:trade/OfferManage/cancelList}" target="content">撤销报盘列表</a></li>
                            </ul>
                        </li>
                        <li><a target="content">招投标管理</a>
                            <ul>
                                <li><a href="{url:trade/bid/bidlist}" target="content">招标列表</a></li>
                             </ul>
                        </li>
                        <li><a target="content">保险管理</a>
                            <ul>
                                <li><a href="{url:trade/Insurance/insuranceList}" target="content">保险产品列表</a></li>
                                <li><a href="{url:trade/Insurance/rateList}" target="content">产品费率列表</a></li>
                            </ul>
                        </li>
                        <li><a target="content">合同管理</a>
                            <ul>
                                <li><a href="{url:trade/pairing/allcontractList}" target="content">合同列表</a></li>
                                <li><a href="{url:trade/pairing/contractList}" target="content">添加撮合人</a></li>
                                <li><a href="{url:trade/pairing/pairingContractList}" target="content">未完成撮合合同列表</a></li>
                                <li><a href="{url:trade/pairing/pairingContractComList}" target="content">已完成撮合合同列表</a></li>
                            </ul>
                        </li>
                        <li><a  target="content">申诉管理</a>
                            <ul>
                                <li><a href="{url:trade/complain/uncomplainList}" target="content">未处理申述列表</a></li>
                                <li><a href="{url:trade/complain/complainList}" target="content">已处理申述列表</a></li>
                            </ul>
                        </li>
                        <li><a href="{url:trade/found/foundList}" target="content">找货信息列表</a>
                        </li>
                    </ul>
                </li>
                <li><a target="content"><img src="{views:img/icons/menu/lab.png}" alt="" /> 结算管理</a>
                    <ul>
                    
                    <li><a  target="content">银行签到/签退设置</a>

                            <ul>
                                <li><a href="{url:balance/BankSign/manu}" target="content">手动签到/退</a></li>
                                <li><a href="{url:balance/BankSign/auto}" target="content">自动签到/退</a></li>
                            </ul>
                        </li>
                     <li><a  target="content">开闭市设置</a>
                            <ul>
                                <li><a href="{url:balance/Open/day}" target="content">日结</a></li>
                                <li><a href="{url:balance/Open/calendar}" target="content">交易日历</a></li>
                            </ul>
                        </li>
                        <li><a  target="content">会员开户管理</a>
                            <ul>
                                <li><a href="{url:balance/accManage/checkbankList}" target="content">待审核</a></li>
                                <li><a href="{url:balance/accManage/checkedbankList}" target="content">已审核</a></li>
                            </ul>
                        </li>
                        <li><a  target="content">入金审核</a>
                            <ul>
                                <li><a href="{url:balance/fundIn/onlineList}" target="content">线上入金</a></li>
                                <li><a href="{url:balance/fundIn/checkOfflineList}" target="content">线下待审核</a></li>
                                <li><a href="{url:balance/fundIn/checkedOfflineList}" target="content">线下已审核</a></li>
                                <li><a href="{url:balance/fundIn/bankflowList}" target="content">银行流水</a></li>
                                <li><a href="{url:balance/fundIn/bankflowadd}" target="content">保证金录入</a></li>
                            </ul>
                        </li>
                        <li><a target="content">出金审核</a>
                            <ul>
                                <li><a href="{url:balance/fundOut/checkFundOutList}" target="content">出金待审核</a></li>
                                <li><a href="{url:balance/fundOut/checkedFundOutList}" target="content">出金已审核</a></li>
                                <li><a href="{url:balance/fundOut/pendingPaymentList}" target="content">待打款</a></li>
                            </ul>
                        </li>
                        <li><a target="content">账户管理</a>
                            <ul>
                                <li><a href="{url:balance/accManage/userAccList}" target="content">会员账户</a></li>

                                <li><a href="{url:balance/accManage/zxAccList}" target="content">中信账户</a></li>

                                <li><a href="{url:balance/accManage/userCreditList}" target="content">信誉保证金账户</a></li>

                            </ul>
                        </li>
                        <li><a target="content">中信资金管理</a>
                            <ul>
                                <li><a href="{url:balance/zx/txingList}" target="content">出金待审核</a></li>
                                <li><a href="{url:balance/zx/txedList}" target="content">出金已审核</a></li>
                            </ul>
                        </li>
                        <li><a target="content">收费明细</a>
                            <ul>
                                <li><a href="{url:balance/paytoMarket/index}" target="content">明细列表</a></li>
                            </ul>
                        </li>
                      <!--   <li><a href="{url:balance/fundIn/bankflowadd}"
                          target="content" >保证金录入</a></li> -->
                    </ul>
                </li>
                <li><a target="content"><img src="{views:img/icons/menu/lab.png}" alt="" /> 统计管理</a>
                    <ul>
                   <!--     <li><a target="content">市场统计</a>
                            <ul>
                                <li><a href="{url:information/marketStats/cateList}" target="content">统计项列表</a></li>
                                <li><a href="{url:information/marketStats/marketStatsList}" target="content">市场统计</a></li>
                            </ul> </li>-->
                            <li><a target="content">市场统计</a>
                            <ul>
                                <li><a href="{url:information/statsMarket/statsList2}" target="content">订单统计数据</a></li>
                                <li><a href="{url:information/statsMarket/statsMarketList}" target="content">统计项列表</a></li>
                                <li><a href="{url:information/statsMarket/statsList}" target="content">市场统计数据</a></li>
                            </ul>
                            </li>
                        
                        <li><a target="content">商品统计</a>
                            <ul>
                                <li><a href="{url:information/productStats/productStatsList}" target="content">统计项</a></li>
                                <li><a href="{url:information/productStats/statsDataList}" target="content">统计数据</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
               <!-- <li class="nosubmenu"><a href="modal.html" class="zoombox w450 h700" target="content"><img src="{views:img/icons/menu/comment.png}" alt="" /> 数据统计</a></li>
               -->
                <li><a   target="content"><img src="{views:img/icons/menu/comment.png}" alt="" /> 仓库管理</a>
                    <ul>
                        <li><a  target="content">仓库管理</a>
                            <ul>
                                <li><a target="content" href="{url:store/store/storeList}">仓库列表</a></li>
                                <li><a href="{url:store/store/storeAdd}" target="content">仓库添加</a></li>
                            </ul>
                        </li>
                         <li><a  target="content"  href="{url:store/store/repertory}">库存管理</a>
                        </li>
                        <li><a  target="content">仓单管理</a>
                            <ul>
                                <li><a target="content" href="{url:store/storeProduct/getList}">仓单列表</a></li>
                                <li><a href="{url:store/storeProduct/reviewList}" target="content">仓单审核</a></li>
                                <li><a target="content" href="{url:store/storeProduct/againlist}">仓单反审核</a></li>
                            </ul>
                        </li>

                        <li><a  target="content">订单出库管理</a>
                            <ul>
                                <li><a target="content" href="{url:store/storeOrder/checkedorderList}">已出库列表</a></li>
                                <li><a href="{url:store/storeOrder/checkorderList}" target="content">待审核</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>

                <li><a   target="content"><img src="{views:img/icons/menu/comment.png}" alt="" /> 工具管理</a>
                    <ul>
                        <li><a  target="content">广告管理</a>
                            <ul>
                                <li><a target="content" href="{url:tool/advert/adPositionList}">广告位列表</a></li>
                                <li><a href="{url:tool/advert/adManageList}" target="content">广告列表</a></li>
                            </ul>
                        </li>
                        <li><a target="content">帮助管理</a>
                            <ul>
                                <li><a href="{url:tool/help/helpCatList}" target="content">帮助分类</a></li>
                                <li><a href="{url:tool/help/helpList}" target="content">帮助列表</a></li>
                            </ul>
                        </li>
                            <li><a href="{url:tool/friendlyLink/frdLinkList}" target="content">友情链接管理</a>
                                <ul>
                                    <li><a href="{url:tool/friendlyLink/addFrdLink}" target="content">新增友情链接</a></li>
                                    <li><a href="{url:tool/friendlyLink/frdLinkList}" target="content">友情链接列表</a></li>
                                </ul>
                            </li>
                            <li><a href="{url:tool/slide/slideList}" target="content">幻灯片管理</a>
                                <ul>
                                    <li><a href="{url:tool/slide/addSlide}" target="content">新增幻灯片</a></li>
                                    <li><a href="{url:tool/slide/slideList}" target="content">幻灯片列表</a></li>
                                </ul>
                            </li>
                    </ul>
                </li>
                <li><a   target="content"><img src="{views:img/icons/menu/comment.png}" alt="" /> 风险管理</a>
                    <ul>
                        <li><a  target="content">预警管理</a>
                            <ul>
                                <li><a target="content" href="{url:riskMgt/riskMgt/userRiskList}">会员预警</a></li>
                                <li><a target="content" href="{url:riskMgt/riskMgt/adminRiskList}">管理员预警</a></li>
                            </ul>
                        </li>


                    </ul>
                </li>


            </ul>


        </div>
        <script type="text/javascript">
            $(function(){
                var menus = {$menus};
                if(menus != 'admin'){
                    $('ul a').each(function(){
                        var href = $(this).attr('href');
                        if($(this).attr('no_access') != 'no_access'){
                            var flag = 0;
                            if(href){
                                for(var i=0;i<menus.length;i++){
                                    var href = href.toLocaleLowerCase();
                                    var len = menus[i].length-href.length;
                                    // if(href.indexOf(menus[i]) > 0){
                                    // console.log(menus[i].lastIndexOf(href));
                                    
                                    if(href.lastIndexOf(menus[i]) == -len){
                                        flag = 1;
                                    }
                                }
                            }else{
                                flag = 1;
                            }
                            if(flag == 0){
                                $(this).parent().remove();
                            }
                        }        
                    });
                    $("#sidebar>ul>li>ul>li>a").each(function(){
                        if($(this).siblings('ul').length == 0 || $(this).siblings('ul').children().length == 0){
                            if(!$(this).attr('href') || $(this).attr('href').length < 10){
                                $(this).parent().remove();
                            }
                        }
                    });
                    $("#sidebar>ul>li>ul>li>ul").each(function(){
                        if($(this).find('li').length == 0){
                            $(this).remove();
                        }
                    });
                    // $("#sidebar>ul>li>ul>li").each(function(){
                    //     if($(this).find('ul').length == 0){
                    //         $(this).remove();
                    //     }
                    // });
                    // 
                    
                    $("#sidebar>ul>li>ul").each(function(){
                        if($(this).find('li').length == 0){
                            $(this).remove();
                        }
                    });

                    $("#sidebar>ul>li:not(:first)").each(function(){
                        if($(this).find('ul').length == 0){
                            $(this).remove();
                        }
                    });

                    
                    // 
                    // 
                    


                }
            });    
        </script>
        
                
        <!--            
              CONTENT 
                        --> 
        <div class="main_content" id="content_1" >
            <iframe class="white" scrolling="yes" frameborder="0" src="{url:/index/index/welcome}" name="content" marginheight="0" marginwidth="0" width="100%" height="728px"  id="iframe" style="overflow-y:scroll;"></iframe>

     </div>
</div>
        <input type="hidden" name="getMsgUrl" value="{url:/index/getMsg}" />
        <script type="text/javascript" src="{views:js/index/index.js}"></script>

    </body>
</html>