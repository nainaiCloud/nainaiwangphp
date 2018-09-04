
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
                    <input type="hidden" name="bondImg" value="{url:/nnys-admin/balance/fundin/bankSearch}"><!-- 上传图片接口地址 -->
                    <input data-validate="required:" type="file" multiple id="ssi-upload"/>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="bondTitle">检索审核录入信息：</div>
                  <div class="bondRight">
                    <input type="hidden" name="bankSearch" value="{url:/nnys-admin/balance/fundin/bankSearch}"><!-- 开户查询接口地址 -->
                    <input type="hidden" name="bankbankflowAdd" value="{url:/nnys-admin/balance/fundin/bankSearchbankflowAdd}"><!-- 录入保证金接口地址 -->
                    <div class="searchtitle">
                      <div class="stitle enter-title"><a class="cur">企业</a></div>
                      <div class="stitle per-title"><a>个人</a></div>
                    </div>
                    <div class="searchtext">检索条件</div>
                    <div class="enterprise">
                      <div class="search">
                        <input name="bondName" class="text_cl" placeholder="请输入企业名称" type="text"/>
                      </div>
                      <div class="bank-but"> 
                        <button type="button" class="bankselectBtn" name="">开始检索</button>
                      </div>
                      <div class="select-result">
                        <div class="resultTitle">检索结果如下<span class="right_line"></span></div>
                        <div id="bondContent"></div>
                        <script type="text/html" id="bankTemplat">
                          <% if(bondDatas!=null) { %>
                          <div class="select_info">
                            <div class="bankInfo">
                              <span class="infoName">企业名称：</span>
                              <span><input type="text"  class="info_input" disabled="disabled" value="<%=bondDatas[0].true_name%>" name=""></span>
                            </div>
                            <div class="bankInfo">
                              <span class="infoName">用户名：</span>
                              <span><input type="text"  class="info_input" disabled="disabled" value="<%=bondDatas[0].bank_name%>" name=""></span>
                            </div>
                            <div class="bankInfo">
                              <span class="infoName">开户银行：</span>
                              <span><input type="text"  class="info_input" disabled="disabled" value="<%=bondDatas[0].bank_name%>" name=""></span>
                            </div>
                            <div class="bankInfo">
                              <span class="infoName">银行账号：</span>
                              <span><input type="text"  class="info_input" value="<%=bondDatas[0].card_no%>" name="banknum"></span>
                            </div>
                            <div class="bankInfo">
                              <span class="infoName">金额：</span>
                              <span><input type="text"  class="info_input" placeholder="请输入保证金金额"  name="bandatm"></span>
                            </div>
                            <span style="display:none;border:0" id="bandatmspan" >请输入数字</span>
                            <div class="bankInfo">
                              <span class="infoName">流水号：</span>
                              <span><input type="text" class="info_input" placeholder="请输入银行流水号" name="bandlogno"></span>
                            </div>
                            <span style="display:none;border:0" id="bandlognospan" >请输入数字</span>
                            <div class="bankInfo">
                              <span class="infoName"></span>
                              <span class=infoTip><!-- !系统已经录入该流水账号，请检查输入是否正确 --></span>
                            </div>
                            <div class="bankInfo"><div class="upbtn"><button id="ssi-uploadBtn" class="ssi-button upload-btn" >确认提交</button></div></div>
                            <div class="bankInfo">
                              <div class="systemtip">温馨提示：请认真核对金额及流水号信息无误后再确认提交！</div>
                            </div>
                          </div>
                          <% } %>
                        </script>
                      </div>
                    </div>
                    <!-- 个人保证金录入 -->
                    <div class="personal">
                      <div class="search">
                        <input name="perbondName" class="text_cl" placeholder="请输入姓名" type="text"/>
                      </div>
                      <div class="bank-but"> 
                        <button type="button" class="bankselectBtn" name="">开始检索</button>
                      </div>
                      <div class="select-result">
                        <div class="resultTitle">检索结果如下<span class="right_line"></span></div>
                        <div id="preContent"></div>
                
                          <div class="select_info">
                            <div class="preResult-list">
                              <div class="preResult">
                                <i class="i_radio cur"><i class="cur_i"></i></i>
                                <span class="preType">
                                  <span class="preType_no">未开户</span>
                                   <span class="preType_yes" style="display: none;">已开户</span>
                                </span>
                                <div class="preText clear">
                                  <div class="preName">姓名：<span class="preName-text">张三</span></div>
                                  <div class="preMobile">手机号：<span>1203030000</span></div>
                                </div>
                                <div class="preText">
                                  <div class="preuser">用户名：张耐耐三</div>
                                </div>
                                
                              </div>
                              <div class="preResult">
                                <i class="i_radio"><i class="cur_i"></i></i>
                                <span class="preType">
                                  <span class="preType_no" style="display: none;">未开户</span>
                                   <span class="preType_yes">已开户</span>
                                </span>
                                <div class="preText clear">
                                  <div class="preName">姓名：<span class="preName-text">张三</span></div>
                                  <div class="preMobile">手机号：<span>1203030000</span></div>
                                </div>
                                <div class="preText">
                                  <div class="preuser">用户名：张耐耐三</div>
                                </div>
                                <div class="preText">
                                  <div class="preBank">开户银行：中国银行上海支行</div>
                                </div>
                                <div class="preText">
                                  <div class="preBanknum">银行账号：23339908089098090</div>
                                </div>
                              </div>
                            </div>
                           
                            <div class="bankInfo">
                              <span class="infoName">金额：</span>
                              <span><input type="text"  class="info_input" placeholder="请输入保证金金额"  name="bandatm"></span>
                            </div>
                            <span style="display:none;border:0" id="prebandlognospan" >请输入数字</span>
                            <div class="bankInfo">
                              <span class="infoName">流水号：</span>
                              <span><input type="text" class="info_input" placeholder="请输入银行流水号" name="bandlogno"></span>
                            </div>
                            <span style="display:none;border:0" id="prebandlognospan" >请输入数字</span>
                            <div class="bankInfo">
                              <span class="infoName"></span>
                              <span class=infoTip><!-- !系统已经录入该流水账号，请检查输入是否正确 --></span>
                            </div>
                            <div class="bankInfo"><div class="upbtn"><button id="ssi-uploadBtn" class="ssi-button upload-btn" >确认提交</button></div></div>
                            <div class="bankInfo">
                              <div class="systemtip">温馨提示：请认真核对金额及流水号信息无误后再确认提交！</div>
                            </div>
                          </div>
                       
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
      <div class="result_tip">恭喜，您的保证金录入信息已提交成功！</div>
      <div class="result_tip success_tip">系统将自动在3秒内跳转到竞价页面</div>
    </div>
    
  </div>
</div>
 <script type="text/javascript" src="{views:js/ssi-uploader.js}"></script>
 <script type="text/javascript" src="{views:js/bond.js}"></script>
 <script type="text/javascript">
  var api="http://192.168.13.4:3000/mock/9"
  $('#ssi-upload').ssi_uploader({
    url:api+'/nnys-admin/balance/fundout/upload',//接收ajax请求的地址，必须填写
    //url:$('input[name=bondImg]').val(),
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