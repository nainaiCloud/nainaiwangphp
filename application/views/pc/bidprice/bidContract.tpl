<link href="{views:css/home.css?v=2}" rel="stylesheet" type="text/css" />
 <style type="text/css">
        p{text-indent: 24px;}
 </style>
<script type="text/javascript" src="{views:js/jquery-1.8.0.min.js}"></script>
<script type="text/javascript" src="{url:js/arttemplate/artTemplate.js}"></script>
<div class="wraps">
  <!-- 合同弹出层 -->
<div class="cd-popup_ht" style="margin:0 auto;width:760px;">
    <div class="cd-popup-container_ht">
        <span class="pop_con_tit"></span>

        <div class="main">
            <p align="center"><strong style="font-size:20px;">耐耐网电子交易平台竞价交易电子合同</strong></p>
           <input type="hidden" name="bidContract" value="{url:/offers/jingjiaContract}"/>
            <div id="bidContract"></div>
        <script type="text/html" id="contractTemplat">

            <div style="padding-left:20px;margin-top:10px;">
                买卖双方根据《中华人民共和国合同法》、《耐耐网交易规则》的相关规则，通过耐耐网电子交易平台进行交易，签订本电子交易合同。               
                <table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" width="100%"
                style="border:1px #000 solid; border-collapse:collapse; margin:10px 0px;">
                    <tr style="height:35px">
                        <td style="padding:0 10px; " width="110px">卖方（甲方）</td>
                        <td style="padding:0 10px; " width="110px"><%=contDatas.seller.true_name%></td>
                        <td style="padding:0 10px; " width="110px">合同编号</td>
                        <td style="padding:0 10px; " width="110px"></td>
                    </tr>
                    <tr style="height:35px">
                        <td style="padding:0 10px;" width="110px">买方（乙方）</td>
                        <td style="padding:0 10px;" width="110px"></td>
                        <td style="padding:0 10px; " width="110px">签约时间</td>
                        <td style="padding:0 10px;" width="110px"><%=contDatas.end_time%></td>
                    </tr>
                </table>
            </div>

            <div style="padding-left:20px; margin-top:10px;">
                一、交易商品
                <div style="padding-left:20px;">第一条 交易商品：</div>
                <table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" width="100%"
                        style="border:1px #000 solid; border-collapse:collapse; margin:10px 0px;">
                    <tr style="height:35px">
                        <td style="padding:0 10px">商品名称:</td>
                         <td style="padding:0 10px">商品规格:</td>
                         <td style="padding:0 10px">生产地:</td>
                        
                    </tr>
                    <tr style="height:35px">
                       <td style="padding:0 10px"><%=contDatas.pro_name%></td>
                        <td style="padding:0 10px">
                          <%for(i=0;i<contDatas.product.attribute.length;i++){%>
                            <%=contDatas.product.attribute[i].name%>: <%=contDatas.product.attribute[i].value%>
                          <%}%>
                        </td>
                        <td style="padding:0 10px" id='areatextarea'><%=contDatas.product.produce_address%></td>
                    </tr>
                </table>
                <div style="text-align:center">（以竞价交易中的相关商品描述为准，或买卖双方自行约定）</div>
            </div>

            <div style="padding-left:20px; line-height:25px; margin-top:10px;">二、数量
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第二条 买卖双方通过交易平台电子交易平台成交的数量：______<%=contDatas.max_num%>____________。（以竞价交易中双方达成的交易数量为准） 。（以竞价交易中双方达成的约定为准）</li>
                    <li style="text-indent: 20px;">第三条 产品质量补充说明（以竞价交易中的相关商品描述为准，或双方自行约定）
                    ________<%=contDatas.product.note%>______________________</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">三、保证金
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">    第四条：在参与竞价出价前，乙方需缴纳甲方规定的起拍价货款金额的10%作为保证金
                    </li>
                    <li style="text-indent: 20px;">第五条：保证金在竞拍结束后的1个工作日内原路退回。若竞价成功，需要2个小时日内支付全部货款，否则保证金相应扣除作为违约赔付。</li>
                    <li style="text-indent: 20px;"> 第六条：缴纳保证金账户必须为在耐耐网的开户账户，否则造成保证金缴纳失败由乙方自行承担.</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">四、成交价格与成交时间
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第七条 买卖双方通过交易平台电子交易系统成交的产品的含税单价为_____________元（人民币）/_<%=contDatas.product.unit%>___(单位)。（以挂牌竞价交易中买卖双方达成的交易价格为准）</li>
                    <li style="text-indent: 20px;">第八条 成交时间:___________（以竞价交易中双方约定的竞价结束时间为准）</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">五、交收地点
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;"> 本合同项下货物的交收地点在交易所指定的交收地，该商品交收地为___<%=contDatas.accept_area%>____________。（以竞价交易中约定的交收地点，或买卖双方自行约定的交收地点为准）</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">六、交收时间及期限
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第十条 本合同从乙方点击出价后开始生效，直至合同履约完毕。</li>
                    <li style="text-indent: 20px;">第十一条 买卖双方通过交易平台电子交易系统就当日订立成功的产品申报交收，交收需按照交易平台的有关规定进行。</li>
                     <li style="text-indent: 20px;">第十二条  卖方在向买方转移货权之日起，超过   日（以竞价交易中双方约定的交收时间为准）未出库部分，乙方应按仓库要求支付相关仓储费用。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">七、质量标准及异议处理
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">用于交收的产品应符合以下规定：</li>
                    <li style="text-indent: 20px;">第十三条  以竞价交易中双方达成的交易的产品质量为准。</li>
                    <li style="text-indent: 20px;">第十四条 实际重量按出库数量为准；如有磅差异议的按国家相关规定执行。</li>
                    <li style="text-indent: 20px;">第十五条  买方应在出价前确认货物质量，出价后表示买方对卖方所交付的货物无任何异议。</li>
                    <li style="text-indent: 20px;">第十六条  如有质量异议，以耐耐网交易平台推荐的、具有国家认定产品检验资质的第三方质检机构或甲乙双方另行商定双方认可的质检机构出具的检验报告为准。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">八、货款结算与手续费
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第十七条 本合同成立后，按照《耐耐云商科技有限公司交易管理办法》的规定，进行货款结算。买卖双方自主交收或另有协议的以甲乙双方另行签订的补充协议为准。</li>
                    <li style="text-indent: 20px;">第十八条  卖方在收到买方本合同全额货款后，向需方转移货权。</li>
                    <li style="text-indent: 20px;">第十九条  本合同生效后，按照《耐耐云商科技有限公司交易管理办法》的规定，耐耐网电子交易平台不向交易商收取任何交易手续费或交收手续费。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">九、增值税专用发票
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第二十条 买卖双方进行实物交收时，卖方根据《耐耐云商科技有限公司交易管理办法》规定，买方提货后由卖方结算并开具与此合同金额相对应的增值税发票，货款多退少补。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">十、违约责任
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第二十一条 以下情况视为违约行为：卖方未按时交货的；卖方货物的数量和质量不符合买卖合同约定的；买方未及时、足额交付货款的；卖方未开具或未足额开具增值税发票的；耐耐网电子交易平台认定的其它违约行为。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">十一、免责条款
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第二十二条 因不可抗力因素导致不能完全或部分履行本合同义务，受不可抗力影响的一方或双方不承担违约责任，但应在不可抗力发生后24小时内通知对方，并在其后15日内向对方提供有效证明文件。受不可抗力影响的一方可依法部分或全部免除责任。本合同所称不可抗力包括但不限于火灾、地震、海啸、台风、洪水等自然灾害及其它不可预见、不可避免、不可克服的事件。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">十二、合同的签署
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第二十三条 买卖双方登录耐耐网电子交易平台现货竞价交易系统，并输入交易指令后达成交易即视为买卖双方签署本合同，本合同即行生效。</li>
                </ol>
            </div>
            <div style="padding-left:20px; line-height:25px; margin-top:10px;">十三、其他条款
                <ol style=" margin-top:5px;">
                    <li style="text-indent: 20px;">第二十四条 本合同一式两份，供需双方各执一份。传真件盖章有效。</li>
                    <li style="text-indent: 20px;">第二十五条 本合同项下货物毁损、灭失的风险，在货物交付之前由卖方承担，货物交付之后由买方承担。</li>
                    <li style="text-indent: 20px;">第二十六条 本合同未尽事宜，买卖双方同意按照《耐耐云商科技有限公司交易管理办法》及本中心相关业务规则的规定执行。</li>
                     <li style="text-indent: 20px;">第二十七条 因履行本合同所发生的或与本合同有关的一切争议，买卖双方应友好协商或由耐耐网电子交易平台调解解决；如自该争议提起之日起7个工作日内仍未能通过友好协商或由交易中心调解解决的，任何一方均有权依法向人民法院提起诉讼。提交法院裁决。本合同所涉耐耐网电子交易平台相关业务规则解释权归交易平台。</li>
                      <li style="text-indent: 20px;">第二十八条 本合同有以下附件。本合同附件是本合同不可分割的组成部分，与本合同具有同等法律效力。</li>
                </ol>
                <div>以上全部细则参照《耐耐云商科技有限公司交易管理办法》；</div>
            </div>

        </script>

        </div>
    </div>

</div>

<!-- 合同弹出层end -->
</div>
<script type="text/javascript">
    //获取url中的参数,获取报盘id
    function getUrlParam(name) {
       var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
       var r = window.location.search.substr(1).match(reg); //匹配目标参数
       if (r != null) return unescape(r[2]); return null; //返回参数值
    }
    var id =getUrlParam("id");
    console.log(id,"dd")
    contractData()
    function contractData(){
         $.ajax({
          /*  'url':'http://124.166.246.120:3000/mock/9/offers/jingjiaContract',*/
            'url':$('input[name=bidContract]').val(),
            'type':'get',
            'dataType':'json',
            'data':{
                id:id,//报盘id
            },
            success: function(data){
                console.log(data,'datas')
                if(data){
                    var ContData = template.render('contractTemplat',{contDatas:data});
                    //console.log(ContData)
                    $('#bidContract').html(ContData); 
                    
                }
               
            }
        })
    }
</script>
