<!DOCTYPE html>
<html>
 <head>
        <title>添加银行流水</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
        <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>

		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css" />
    </head>
    <body>     
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />
</h1>
                
<div class="bloc">
    <div class="title">
       添加银行流水
    </div>
   <div class="pd-20">
  <form action="{url:balance/fundin/bankflowadd}" method="post" class="form form-horizontal" id="form-admin-add" auto_submit redirect_url="{url:balance/fundin/bankflowlist}">
    <input type="hidden" name="id" value="{$data['id']}" />
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>对方账号：</label>

      <div class="formControls col-5">
          <input type="text" class="input-text" value="{$data['OP_ACCT_NO_32']}" placeholder=""  name="OP_ACCT_NO_32" dataType="*" >

      </div>
      <div class="col-4"> </div>
    </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red"></span>户名：</label>

          <div class="formControls col-5">
              <input type="text" class="input-text" value="{$data['OP_CUST_NAME']}" placeholder=""  name="OP_CUST_NAME"  >
          </div>
          <div class="col-4"> </div>
      </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>金额：</label>

          <div class="formControls col-5">
              <input type="text" class="input-text" value="{$data['TX_AMT']}" placeholder=""  name="TX_AMT"  dataType="*">
          </div>
          <div class="col-4"> </div>
      </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>流水号：</label>

          <div class="formControls col-5">
              <input type="text" class="input-text" value="{$data['TX_LOG_NO']}" placeholder=""  name="TX_LOG_NO" dataType="*" >
          </div>
          <div class="col-4"> </div>
      </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>日期：</label>
      <div class="formControls col-5">
          <input name="TX_DT" class="Wdate text Validform_error" datatype="*" value="{$data['TX_DT']}" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"  >
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        &emsp;<a class="btn btn-primary radius" href="{url:system/confsystem/workdaylist}">&nbsp;&nbsp;返回&nbsp;&nbsp;</a>
      </div>
    </div>
  </form>
</div>
</div>
</div>

</div>  
    </body>
</html>