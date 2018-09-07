
  <link rel="stylesheet" href="{views:css/ssi-uploader.css}" />
  <link rel="stylesheet" href="{views:css/bond.css}" />
   <script type="text/javascript" src="{url:js/arttemplate/artTemplate.js}"></script>
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
          <!--   <h1><img src="{views:img/icons/dashboard.png}" alt="" /></h1> -->
                
          <div class="bloc">
              <div class="title">
                 保证金录入
              </div>
             <div class="pd-20">
                <div class="col-md-7">
                  <div class="bondTitle">上传银行收款凭证：</div>
                  <div class="imgUp">
                    <input type="hidden" name="bondImg" value="{url:balance/fundout/upload@admin}"><!-- 上传图片接口地址 -->
                    <input type="text"  id="bonduploadImg" style="display: none"/><!-- 获取存储上传图片地址 -->
                    <input data-validate="required:" type="file" multiple id="ssi-upload"/>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="bondTitle">检索审核录入信息：</div>
                  <div class="bondRight">
                    <input type="hidden" name="bankSearch" value="{url:balance/fundin/bankSearch@admin}"><!-- 开户查询接口地址 -->
                    <input type="hidden" name="bankbankflowAdd" value="{url:balance/fundin/bankflowAdd@admin}"><!-- 录入保证金接口地址 -->
                    <div class="searchtitle">
                      <div class="stitle enter-title"><a class="cur">企业</a></div>
                      <div class="stitle per-title"><a>个人</a></div>
                    </div>
                    <div class="searchtext">检索条件</div>
                    <div class="enterprise">
                      <div class="search">
                        <input name="bondName" class="text_cl" placeholder="请输入企业名称" type="text"/>
                        <!--  <input type="hidden" name="bankType" value="1">企业 -->
                      </div>
                      <div class="bank-but"> 
                        <button type="button" class="bankselectBtn enterselect" name="enterselect">开始检索</button>
                      </div>
                      <div class="select-result">
                        <div class="resultTitle">检索结果如下<span class="right_line"></span></div>
                        <div id="enterbondContent"></div>
                        <script type="text/html" id="enterbankTemplat">
                          <%if(enterDatas.users!=null) { %>
                          <% if(enterDatas.users.length==1) { %>
                           <% if(enterDatas.users[0].dealer != null) { %>
                            <div class="select_info">
                            
                              <div class="bankInfo">
                                <span class="infoName">企业名称：</span>
                                <span><input type="text"  class="info_input" disabled="disabled" value="<%=enterDatas.users[0].true_name%>" name="enUser"></span>
                              </div>
                               <% if(enterDatas.users[0].bank == null) { %>
                              <div class="bankNo">
                              该企业为未开户的用户！
                              </div>
                              <% } %>
                              <div class="bankInfo">
                                <span class="infoName">用户名：</span>
                                <span><input type="text"  class="info_input" disabled="disabled" value="<%=enterDatas.users[0].username%>" name=""></span>
                              </div>
                              <% if(enterDatas.users[0].bank != null) { %>
                              <div class="bankInfo">
                                <span class="infoName">开户银行：</span>
                                <span><input type="text"  class="info_input" disabled="disabled" value="<%=enterDatas.users[0].bank.bank_name%>" name=""></span>
                              </div>
                              <div class="bankInfo">
                                <span class="infoName">银行账号：</span>
                                <span><input type="text"  class="info_input" value="<%=enterDatas.users[0].bank.card_no%>" name="enbanknum"></span>
                              </div>
                              <% } %>
                              <div class="bankInfo">
                                <span class="infoName">金额：</span>
                                <span><input type="text"  class="info_input" placeholder="请输入保证金金额"  name="enbandatm"></span>
                              </div>
                              <div class="bankInfo">
                                <span class="infoName">流水号：</span>
                                <span><input type="text" class="info_input" placeholder="请输入银行流水号" name="enbandlogno"></span>
                              </div>
                              <div class="bankInfo">
                                <span class="infoName"></span>
                                <span class=infoTip><!-- !系统已经录入该流水账号，请检查输入是否正确 --></span>
                              </div>
                              <div class="bankInfo"><div class="upbtn"><button class="ssi-button enupload-btn" >确认提交</button></div></div>
                           
                            </div>
                              <% } else {%>
                                <div class="no_info"><p class="no_info_p">该企业未进行认证，请核实企业名称是否输入正确！</p></div>
                              <% } %>
                            <% } else {%>
                            <div class="no_info"><p class="no_info_p">该企业未进行认证，请核实企业名称是否输入正确！</p></div>
                            <% } %>
                            <% } else{%>
                            <div class="no_info"><p class="no_info_p">该企业未进行认证，请核实企业名称是否输入正确！</p></div>
                            <%}%>
                        </script>
                      </div>
                    </div>
                    <!-- 个人保证金录入 -->
                    <div class="personal">
                      <div class="search">
                        <input name="perbondName" class="text_cl" placeholder="请输入姓名" type="text"/>
                        <!-- <input type="hidden" name="perbankType" value="0"> 个人 -->
                      </div>
                      <div class="bank-but"> 
                        <button type="button" class="bankselectBtn perselect" name="perselect">开始检索</button>
                      </div>
                      <div class="select-result">
                        <div class="resultTitle">检索结果如下<span class="right_line"></span></div>
                        <div id="preContent"></div>
                        <script type="text/html" id="perbankTemplat">
                          <% if(perDatas.users!=null) {%>         
                          <div class="select_info">
                            <% if(perDatas.users.length==1 && perDatas.users[0].dealer!=null) { %> 
                             <div class="preResult-list">
                              <div class="preResult preTextcur">
                                <i class="i_radio cur"><i class="cur_i"></i></i>
                                <span class="preType">
                                  <% if(perDatas.users[0].bank!=null ){%>
                                    <span class="preType_yes">已开户</span>
                                  <% } else {%>
                                    <span class="preType_no">未开户</span>
                                  <% } %>
                                </span>
                                <div class="preText clear">
                                  <div class="preName">姓名：<span class="preName-text"><%=perDatas.users[0].true_name%></span></div>
                                  <div class="preMobile">手机号：<span><%=perDatas.users[0].mobile%></span></div>
                                </div>
                                <div class="preText">
                                  <div class="preuser">用户名：<%=perDatas.users[0].username%></div>
                                </div>
                                 <% if(perDatas.users[0].bank!=null ){%>
                                 <div class="preText">
                                  <div class="preBank">开户银行：<%=perDatas.users[0].bank.bank_name%></div>
                                </div>
                                <div class="preText">
                                  <div class="preBanknum">银行账号：<span class="preBanknums"><%=perDatas.users[0].bank.card_no%></span></div>
                                </div>
                                
                                <% } else {%>
                                  <div class="preText">
                                    <div class="preBankNull">该个人是还未开户的用户，请联系该人进行开户！</div>
                                  </div>
                                <% } %>
                              </div>
                            </div>
                            <% if(perDatas.users[0].bank!=null ){%>
                            <div class="perbankInfo">
                                <div class="bankInfo">
                                  <span class="infoName">金额：</span>
                                  <span><input type="text"  class="info_input" placeholder="请输入保证金金额"  name="perbandatm"></span>
                                </div>
                                <div class="bankInfo">
                                  <span class="infoName">流水号：</span>
                                  <span><input type="text" class="info_input" placeholder="请输入银行流水号" name="perbandlogno"></span>
                                </div>
                                <div class="bankInfo">
                                  <span class="infoName"></span>
                                  <span class=infoTip><!-- !系统已经录入该流水账号，请检查输入是否正确 --></span>
                                </div>
                                <div class="bankInfo"><div class="upbtn"><button class="ssi-button perupload-btn" >确认提交</button></div></div>
                              </div>
                            <% } %>
                            <% } else if(perDatas.users.length>1  && perDatas.users[0].dealer!=null){%>
                            <div class="preResult-list">
                              <%for (var i=0;i<perDatas.users.length;i++) { %>
                               <div class="preResult">
                                <i class="i_radio"><i class="cur_i"></i></i>
                                <span class="preType">
                                  <% if(perDatas.users[i].bank!=null ){%>
                                    <span class="preType_yes">已开户</span>
                                  <% } else {%>
                                    <span class="preType_no">未开户</span>
                                  <% } %>
                                </span>
                                <div class="preText clear">
                                  <div class="preName">姓名：<span class="preName-text"><%=perDatas.users[i].true_name%></span></div>
                                  <div class="preMobile">手机号：<span><%=perDatas.users[i].mobile%></span></div>
                                </div>
                                <div class="preText">
                                  <div class="preuser">用户名：<%=perDatas.users[i].username%></div>
                                </div>
                                <% if(perDatas.users[i].bank!=null ){%>
                                 <div class="preText">
                                  <div class="preBank">开户银行：<%=perDatas.users[i].bank.bank_name%></div>
                                </div>
                                <div class="preText">
                                  <div class="preBanknum">银行账号：<%=perDatas.users[i].bank.card_no%></div>
                                </div>
                                
                                <% }%>
                              </div>
                              <% } %>
                            </div>
                            <div class="perbankInfo">
                              <div class="bankInfo">
                                <span class="infoName">金额：</span>
                                <span><input type="text"  class="info_input" placeholder="请输入保证金金额"  name="perbandatm"></span>
                              </div>
                              <div class="bankInfo">
                                <span class="infoName">流水号：</span>
                                <span><input type="text" class="info_input" placeholder="请输入银行流水号" name="perbandlogno"></span>
                              </div>
                              <div class="bankInfo">
                                <span class="infoName"></span>
                                <span class=infoTip><!-- !系统已经录入该流水账号，请检查输入是否正确 --></span>
                              </div>
                              <div class="bankInfo"><div class="upbtn"><button class="ssi-button perupload-btn" >确认提交</button></div></div>
                            </div>
                            <% } %>
                            
                          </div>
                          <% } else {%>
                            <div class="no_info"><p class="no_info_p">该用户还未进行认证，请核实用户姓名是否输入正确！</p></div>
                          <% } %>
                        </script>
                      </div>
                    </div>
                    <!-- 个人保证金录入 end-->
                    
                    
                </div>
                </div>
            </div>
          </div>
      </div>
<!-- 遮罩层 -->
<div class="bidbond_result">
  <div class="mark"></div>
  <div class="result">
    <div class="result_title">
      提示
      <i class="close"></i>
    </div>
    <div class="tipCont">
      
    </div>
    <div id="resule_success" class="result_cont">
      <div class="result_img"><img src="{views:images/successIcon.png}"/></div>
      <div class="result_tip">恭喜，您提交的保证金信息已录入系统成功！</div>
      <div class="result_tip success_tip">系统将在3秒后自动关闭该提示界面</div>
    </div>
    
  </div>
</div>
 <script type="text/javascript" src="{views:js/ssi-uploader.js}"></script>
 <script type="text/javascript" src="{views:js/bond.js}"></script>
 <script type="text/javascript">
  $('#ssi-upload').ssi_uploader({
  //接收ajax请求的地址，必须填写
   // url:'http://192.168.13.119/nn2/nnys-admin/balance/fundout/upload',
    url:$('input[name=bondImg]').val(),
    maxFileSize:6,//允许上传的最大文件尺寸。
    allowed:['jpg','gif','txt','png','pdf'],
    maxNumberOfFiles:1,
  });
$(function(){
  $(".close,.mark").click(function(){
         $(".bidbond_result").hide()
    })
})
</script>