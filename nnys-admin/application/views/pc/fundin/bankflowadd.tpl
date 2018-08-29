
  <link rel="stylesheet" href="{views:css/ssi-uploader.css}" />
  <link rel="stylesheet" href="{views:css/bond.css}" />
   
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
                <div class="col-md-5">
                  <div class="bondTitle">上传银行收款凭证：</div>
                  <div class="imgUp">
                    <input type="file" multiple id="ssi-upload"/>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="bondTitle">检索审核录入信息：</div>
                  <div class="bondRight">
                    <div class="searchTitle">检索条件</div>
                    <div class="search">
                      <input name="bondName" class="text_cl" placeholder="请输入账户名称" type="text"/>
                    </div>
                    <div class="search">
                       <input name="bankNum" class="text_cl" placeholder="请输入银行账号" type="text"/>
                    </div>
                    <div class="bank-but"> 
                      <button type="button" class="bankselectBtn" id="stasearch" name="">开始检索</button>
                    </div>
                    <div class="select-result">
                      <div class="resultTitle">检索结果如下<span class="right_line"></span></div>
                      <div class="no_info" style="display: none;">
                        <p class="no_info_p">暂无检索到匹配收款信息，请重新确认精准检索！</p>
                      </div>
                      <div class="select_info">
                        <div class="bankInfo">
                          <span class="infoName">账号名称：</span>
                          <span><input type="text"  class="info_input" disabled="disabled" value="阳泉耐火" name=""></span>
                        </div>
                        <div class="bankInfo">
                          <span class="infoName">开户行：</span>
                          <span><input type="text"  class="info_input" disabled="disabled" value="中信银行" name=""></span>
                        </div>
                        <div class="bankInfo">
                          <span class="infoName">银行账号：</span>
                          <span><input type="text"  class="info_input" disabled="disabled" value="22222" name=""></span>
                        </div>
                        <div class="bankInfo">
                          <span class="infoName">金额：</span>
                          <span><input type="text"  class="info_input" placeholder="请输入保证金金额"  name=""></span>
                        </div>
                        <div class="bankInfo">
                          <span class="infoName">流水号：</span>
                          <span><input type="text" class="info_input" placeholder="请输入银行流水号" name=""></span>
                        </div>
                        <div class="bankInfo">
                          <span class="infoName"></span>
                          <span class=infoTip>!系统已经录入该流水账号，请检查输入是否正确</span>
                        </div>
                        <div class="bankInfo"><div class="upbtn"></div></div>
                        <div class="bankInfo">
                          <div class="systemtip">温馨提示：请认真核对金额及流水号信息无误后再确认提交！</div>
                        </div>
                      </div>
                    </div>
                    
                    
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
 <script type="text/javascript">
  $('#ssi-upload').ssi_uploader({
    url:'#',//接收ajax请求的地址，必须填写
    maxFileSize:6,//允许上传的最大文件尺寸。
    allowed:['jpg','gif','txt','png','pdf'],
    maxNumberOfFiles:1
  });
$(function(){
  $(".close,.mark").click(function(){
         $(".bidbond_result").hide()
    })
})
</script>