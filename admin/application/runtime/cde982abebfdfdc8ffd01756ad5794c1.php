<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/libs/jquery/1.6/jquery.min.js"></script>
	<script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>

	<link rel="stylesheet" href="http://localhost/nn2/admin/public/views/pc/css/min.css" />
	<script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/validform/validform.js"></script>
	<script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/validform/formacc.js"></script>
	<script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/layer/layer.js"></script>
	<link rel="stylesheet" href="http://localhost/nn2/admin/public/views/pc/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="http://localhost/nn2/admin/public/views/pc/css/H-ui.min.css">
</head>
<body>
        <script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
        <script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/validform/validform.js"></script>
        <script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/validform/formacc.js"></script>
        <script type="text/javascript" src="http://localhost/nn2/admin/public/views/pc/js/layer/layer.js"></script>

        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="http://localhost/nn2/admin/public/views/pc/img/icons/dashboard.png" alt="" /> 交易费率设置
</h1>
                
<div class="bloc">
    <div class="title">
       交易费率设置信息
    </div>
    <div class="content dashboard">
        <div>
            <form action="http://localhost/nn2/admin/public/system/confsystem/scaleOfferOper/" method="post" class="form form-horizontal" id="form-scaleoffer-add" auto_submit no_redirect='1'>
        <div id="tab-system" class="HuiTab">
            
            <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>自由报盘收费设置</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-title" placeholder="1~100%" name='free' value="<?php echo isset($info['free'])?$info['free']:"";?>" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>保险金收取比例</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-title" placeholder="1~100%" name='deposite' value="<?php echo isset($info['deposite'])?$info['deposite']:"";?>" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>手续费收取比例</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-title" name='fee' placeholder="1~100%" value="<?php echo isset($info['fee'])?$info['fee']:"";?>" class="input-text">
                    </div>
                </div>

                <!-- 
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>关键词：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-Keywords" placeholder="5个左右,8汉字以内,用英文,隔开" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>描述：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-description" placeholder="空制在80个汉字，160个字符以内" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>css、js、images路径配置：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-static" placeholder="默认为空，为相对路径" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>上传目录配置：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-uploadfile" placeholder="默认为uploadfile" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>底部版权信息：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-copyright" placeholder="© 2014 H-ui.net" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">备案号：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-icp" placeholder="京ICP备00000000号" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">统计代码：</label>
                    <div class="formControls col-10">
                        <textarea class="textarea"></textarea>
                    </div>
                </div> -->
            </div>            
        </div>
    

            <div class="cb"></div>

        <div class="row cl">
            <div class="col-10 col-offset-2">
               <button  class="btn btn-primary radius" type="submit"><i class="icon-save"></i> 保存</button>
                <!-- <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
            </div>
        </div>
        </form>
        </div>
    </div>
</div>


                
       
</form>
</div>
        
        
    </body>
</html>
</body>
</html>