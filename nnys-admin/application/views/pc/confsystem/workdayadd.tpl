<!DOCTYPE html>
<html>
 <head>
        <title>添加假日/工作日</title>
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
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />系统管理
</h1>
                
<div class="bloc">
    <div class="title">
       添加假日/工作日
    </div>
   <div class="pd-20">
  <form action="{url:system/confsystem/workdayadd}" method="post" class="form form-horizontal" id="form-admin-add" auto_submit redirect_url="{url:system/confsystem/workdaylist}">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>选择银行：</label>

      <div class="formControls col-5">
        <select class='input-select' name='bank' >
              <option value="js">建设银行</option>
              <option value="gd">光大银行</option>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>类型：</label>

          <div class="formControls col-5">
              <select class='input-select roles' name='type' >
                  <option value="1">休假</option>
                  <option value="2">工作</option>
              </select>
          </div>
          <div class="col-4"> </div>
      </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>日期：</label>
      <div class="formControls col-5">
          <input name="day" class="Wdate text Validform_error" datatype="*" value="" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"  >
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