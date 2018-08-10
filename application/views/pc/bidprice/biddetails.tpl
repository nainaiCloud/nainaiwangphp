<link rel="stylesheet" type="text/css" href="{views:css/bidprice.css}">
<script type="text/javascript" src="{views:js/biddetails.js}"></script>
<script type="text/javascript">
var now = {echo:time()};
var s = 0;
</script>
    <!--主要内容 开始-->
    <div id="mainContent">
        <div class="page_width">
            <!-- 未登录招标内容start -->
           <div class="bidpriceContent">
                <div class="bidpriceTop">
                    <a>竞价</a> &gt; <a>竞价商品详情</a> 
                </div>
                <input type="hidden" name="detail" value="{url:/ajaxdata/jingjiadetail}">
                <input type="hidden" name="baojiaList" value="{url:/ajaxdata/baojiadata}">
                <input type="hidden" name="baojiaPost" value="{url:/trade/jingjiabaojia}">
                <input type="hidden" name="jingjiaPost" value="{url:/ajaxdata/jingjiadeposit}"><!-- 是否缴纳保证金 -->
                <input type="hidden" name="bidUrl" value="{url:/bidprice/bidbond}"> <!-- 支付保证金界面 -->
                <!-- 保证金用户信息 -->
                <input type="hidden" name="bidInfo" value="{url:/ajaxdata/jingjiadepositpage}">
                <div class="biddetails_top clear" id="commodityTop">
                <script type="text/html" id="commdToptemplat">
                    <%if (detailtop!=null) { %>
                    <div class="biddetails_left">
                        <div class="demo">
                            <div class="box">
                                <div class="tb-booth tb-pic">
                                    <a href="">
                                        <img src="<%=detailtop.origphotos[0]%>" class="jqzoom" width="100%" />
                                    </a>
                                </div>
                                <div class="lefts"></div>
                                <div class="rights"></div>  
                                <div class="imglist">
                                <ul class="tb-thumb" id="thumblist">
                                   <!-- 图片 -->
                                  
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="biddetails_right">
                        <div class="bidTitle">
                            <span class="cate_chain"><!-- 耐火市场 --></span>
                           <!--  <span>铝矾土</span>> -->
                            <span class="name"><%=detailtop.pro_name%><!-- 铝矾土一级生矿混料 --></span>
                        </div>
                        <div class="price">
                            <div class="price_type dqprice">
                                <span class="dqprice_con"><!-- 当前价：980 --></span>
                                <span>元</span>
                            </div>
                            <div class="cprice"><!-- 出价人：耐****公司 --></div>
                        </div>
                        <div class="bidInfor">
                            <div class="bidinfortitle">
                                <div class="bid_left">
                                    <!-- 竞价暂未开始 -->
                                    <!-- 竞价进行中 -->
                                    <!-- 竞价已截止 -->
                                    <!-- 竞价结束，该商品竞价失败！-->
                                    <!-- 竞价已结束，该商品成功竞价！ -->
                                </div>
                                <div class="bid_right">
                                    <!-- 距离开始还有<span id="time_d">7</span>天<span id="time_h">06</span>:<span id="time_m">58</span>:<span id="time_s">28</span> -->
                                    <span class="bid_time"></span><span id="time_d">00</span>天<span id="time_h">00</span>:<span id="time_m">00</span>:<span id="time_s">00</span>
                                   <!--  该商品已竞价结束<span id="time_d">0</span>天<span id="time_h">00</span>:<span id="time_m">00</span>:<span id="time_s">00</span>-->

                                </div>
                            </div>
                            <div class="bidinfor_cont clear">
                                <div class="bidfor_cont_left">
                                    <div class="cj">
                                        <span>出价</span>
                                        <span class="reduce" id="jian"><i class="reduce_icon"></i></span>
                                        <span class="inputName">
                                            
                                            <input type="text" id="num"  value="0.00" /><input type="text" id="cs"  style="position:absolute;top:0px;z-index: -1" />
                                        </span>
                                        <span class="add" id="add">
                                            <i class="add_l"></i>
                                            <i class="add_h"></i>
                                        </span>
                                    </div>
                                    <div class="but">
                                        <input class="submitBut yes" type="submit" name="" value="确认出价">
                                        <!-- <input class="submitBut end" type="submit" name="" value="竞价已截止"> -->
                                    </div>
                                    <div class="tip">
                                        <!--  <span class="tipcolor1">*提示：出价需要先交支付保证金</span> -->
                                        <span class="tipcolor1"><!-- *提示：您已支付定金可以出价竞拍 --></span>
                                        <!-- <span class="tipcolor2">*提示：竞价成功后请尽快完成货款交纳</span> -->
                                    </div>
                                </div>
                                <div class="bidfor_cont_center">
                                    <p>加价幅度：<span class="jsfd"><%=detailtop.jing_stepprice%></span>元</p>
                                    <p>竞拍数量：<span class="bidnum"><%=detailtop.max_num%></span><%=detailtop.unit%></p>
                                    <p>起拍价：<span class="qpmoney"><%=detailtop.price_l%><!-- 360.00 --></span>元</p>
                                </div>
                                <div class="bidfor_cont_right">
                                    <p class="seller">卖方：<span><%=detailtop.user.true_name%><!-- 阳泉耐火厂 --></span></p>
                                    <p>合同：<a href="{url:/bidprice/bidContract}?id=<%==detailtop.id%>">预览合同协议</a></p>
                                </div>
                            </div>

                        </div>
                        <div class="bidContent">
                            <p>保证金金额：<span class="bzjprice">￥<%=detailtop.jingjia_deposit%><!-- 10000元 --></span></p>
                            <p>竞拍开始时间：<span class="stratTime"><%=detailtop.start_time%></span></p>
                            <p>竞拍结束时间：<span class="endTime"><%=detailtop.end_time%></span></p>
                        </div>
                        <hr/>
                        <div class="bidBottom clear">
                            <div class="bidpricepop">
                                <i class="icon_pop"></i>
                                <span class=""><span class="pepNum"></span>人已出价</span>
                            </div>
                            <div class="bidwk">
                                 <i class="icon_wk"></i>
                                <span class=""><span class="viewNum"><!-- 5590 --></span>次围观</span>
                            </div>
                            <!-- 暂未开始竞价显示申请看货提示 -->
                            <div class="sqkh" style="display: none;">
                                申请看货请联系耐耐网客服热线 400-6238-086
                            </div>
                        </div>
                    </div>
                    <% } %>
                </script>
                </div>
                <div class="bidintroduce">
                    <div class="introduce_title">
                        <a  href="#title1">商品介绍</a>
                        <a  href="#bj_a">竞价记录(<span class="numt"><!-- 16 --></span>条)</a>
                    </div>
                    <div class="cont_1">
                        <h5 class="tit"><i><img src="{views:images/pro_show_03.jpg}"></i><a  name="#title1">商品介绍</a></h5>
                        <table id="commoditydetail">
                            <script type="text/html" id="commdetailtemplat">
                           <%if (detailData!=null) { %>
                            <tr> <th colspan="2">商品明细</th></tr>
                            <tr>
                                <td>商品品名</td>
                                <td><%=detailData.pro_name%></td>
                            </tr>
                             <!-- <tr class="attr">
                                属性
                            </tr> -->
                            <tr class="attrAfter">
                                <td>产地</td>
                                <td><span id="area"><%=detailData.produce_area%>&nbsp;<%=detailData.produce_address%></span></td>
                            </tr>
                            <tr>
                                <td>交货地点</td>
                                <td><%=detailData.accept_area_code%>&nbsp;<%=detailData.accept_area%></td>
                            </tr>
                           
                            <tr>
                                <td style="width:15%;">商品描述</td>
                                <td><%=detailData.note%></td>
                            </tr>
                            <tr>
                                <td>补充条款</td>
                                <td><%=detailData.other%></td>
                            </tr>
                            <% } %>
                            </script>
                        </table>
                    </div>
                    <!-- 拍卖价格情况 -->
                    <div class="cont_1">
                         <h5 class="tit"><i><img src="{views:images/jIcon.png}"></i><span><a name="bj_a">竞价记录</a></span></h5>
                         <div class="auction">
                            <ul class="auction_title">
                                <li><span>出价人</span></li>
                                <li><span>出价价格</span></li>
                                <li><span>出价时间</span></li>
                                <li><span>竞价结果</span></li>
                            </ul>
                            <div id="baojiaList">
                            <!-- <script type="text/html" id="bidListtemplat">
                                 <%if (data.length>0) { %>
                                <ul class="auction_cont first" >
                                <li><span><%=data[0].name%></span></li>
                                <li><span>980.00元</span></li>
                                <li><span>2018年7月01日 12:30:09</span></li>
                                <li><span>领先</span></li>                         
                                </ul>
                                <%for (var i=1;i<data.length;i++) { %>
                                <ul class="auction_cont">
                                    <li><span><%=data[i].name%>耐******</span></li>
                                    <li><span>970.00元</span></li>
                                    <li><span>2018年7月01日 12:20:09</span></li>
                                    <li><span>出局</span></li>
                                </ul>
                                <% } %>
                                <% } else{%> 
                                <div>暂无出价</div>
                                <% } %>
                            </script> -->
                            </div>

                         </div>
                    </div>
                    <!-- 拍卖价格情况 end-->
                </div>

            </div>
        </div>        
    </div>
<div class="pay_password">
   <div class="mark"></div>
   <div class="pay_cont">
        <div class="pay_title">
            支付密码
            <i class="close"></i>
        </div>
       <div class="pay_input">
        <div class="tip_password"></div>
         <input type="password" placeholder="请输入支付密码" name="payPassword" value=""/>
       </div>
       <div class="pay_but"><input type="button" name="butPassword" value="确定"/></div>
   </div>
</div>
