<script src="{views:js/jquery.extend.js}"></script>
<script src="{views:js/passwordReset.js}"></script>
<link href="{views:css/center_top.css}" rel="stylesheet" type="text/css" />
<!-- 基本信息css -->
<link href="{views:css/center_date.css}" rel="stylesheet" type="text/css" />
    <div class="right_c">
      <div class="r_c_title">
        <a class="tit_span">支付密码申诉找回</a>
      </div>
      <div class="rc_bate">
        <div class="jd_img">
          <img src="{views:images/icon/icon_jd.jpg}">
          <div class="jd_ts">
            <img src="{views:images/icon/icon_ts.jpg}"/>
            <span>请确保手机通畅，以便于我们计算与您联系，并接收申诉结果。</span>
          </div>
        </div>

          <div class="bate-input clear">
            <span class="span_in_tit">
              手机号：
            </span>
            <span class="input_span">{$info['mobile']}</span>
          </div>
          <div class="bate-input clear">
            <span class="span_in_tit">
              验证码：
            </span>
            <div class="input_span">
              <input id="inputCode" placeholder="请输入验证码" type="text" id="inputCode" class="gradient wbk">
              <!-- <span id="code" class="mycode" style="overflow: hidden;"> -->
                <img id="image"src="{url:/login/getCaptcha}" onclick="this.src='{url:/login/getCaptcha}?'+Math.random()"/>
              <!-- </span> -->

              <!-- <input type="button" class="yzm_submit" value="确定" id="submit"> -->
            </div>
          </div>
          <div class="bate-input clear">
            <span class="span_in_tit">
              短信验证码：
            </span>
            <span class="input_span">
              <input type="text" id="txtCode" class="infos wbk" placeholder="请输入验证码"/>
              <input class="send1"  type="button" value="获取验证码" id="yzmBtn"/></span>
          </div>
          <div class="bate-input clear">
          <input type="hidden" class="text1" id="txtMobile" name="mobile" value="{$info['mobile']}"> 
           <input type='hidden' value='{url:/ucenter/checkpayMobileCode}' id='findUrl'>
           <input type='hidden' value='{url:/ucenter/getMobileCode}' id='codeUrl'>
          <input type="hidden" name="uid" id="uid" value="{$info['id']}">
            <div class="but_div"><a class="but_in" id="btnSubmit" href=#"/>下一步</a></div>
          </div>
      </div>
    </div>