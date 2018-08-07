 $(function(){
	$(".close,.mark").click(function(){
         $(".bidbond_result").hide()
    })
//获取url中的参数,获取报盘id
	function getUrlParam(name) {
       var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
       var r = window.location.search.substr(1).match(reg); //匹配目标参数
       if (r != null) return unescape(r[2]); return null; //返回参数值
	}
	var id =getUrlParam("id");
	var pass =getUrlParam("pass")
	console.log("dd",id,"-",pass)
	console.log("去开户",$('input[name=biddetail]').val())
//开户信息
 	bzjData()
	function bzjData(){
	    $.ajax({
	        /*'url':'http://ceshi.nainaiwang.com/ajaxdata/jingjiadepositpage',*/
	        'url':$('input[name=bidInfo]').val(),
	        'type':'get',
	        'dataType':'json',
	        'data':{
	            id:id,//报盘id
	        },
	        success: function(bzjDatas){

	        	var tiphtml=''
	        	//console.log(bzjDatas.user.bank,"user")
	        	$(".bzjProduct").text(bzjDatas.jingjia.pro_name);//商品名字
	        	$(".bidbondprice .bzjPrice").text(bzjDatas.jingjia.jingjia_deposit);//需缴纳保证金
	        	if(bzjDatas.user.bank!=null){
	        		var BankInfo = template.render('banktemplat',{bankInfo:bzjDatas.user.bank});
			        $('#BankInfo').html(BankInfo);
	        		
	        	}else{
	        		$('#BankInfo').html('<div class="bidbondInfo"><div>暂无数据</div></div>');
	        		tiphtml='<div id="resule_fail" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/money_icon.png"/></div>'
	        			+'<div class="result_tip">很抱歉，您还未开户，需要开户后才能缴纳保证金！</div>'
	        			+'<div class="result_tip fail_tip">缴纳保证金必须使用开户账号关联的银行账户进行汇款</div>'
	        			+'<div class="result_tip success_tip">系统将自动在3秒后跳转去开户</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml)
	        			$(".bidbond_result").fadeIn(1000,setTimeout(function () {
				            location.href =$('input[name=qkh]').val()  //开户界面
				        },3000)
                   	)
	        	}
	        	bzjyz();
	        }
	    })
	} 

/*保证金验证*/
function bzjyz(){
	$.ajax({
		/*'url':'http://ceshi.nainaiwang.com/ajaxdata/jingjiadeposit',*/
	    'url':$('input[name=jingjiaPost]').val(),
	    'type':'get',
	    'dataType':'json',
	    'data':{
	        id:id,//报盘id
	    },
	    success: function(datas){
	    	console.log(datas,"bzjyz")
	    	if(datas.success == 0){
	    		$(".bidbond_btn").html('<input class="submitIn" type="button" value="缴纳完成" name="bankBut">')
	    	}else{
	    		$(".bidbond_btn").html('<input class="no_submit" disabled="disabled" type="button" value="缴纳完成" name="bankBut">')
	    	}
	    	clickBzj();//点击验证接口
	    }
	})
}
function clickBzj(){
	$(".bidbond_btn .submitIn").click(function(){
		$.ajax({
            //几个参数需要注意一下
                type: "POST",//方法类型
                dataType: "json",//预期服务器返回的数据类型
              /*  url: "http://ceshi.nainaiwang.com/ajaxdata/alrealydeposit" ,*///匹配数据url
                url:$('input[name=bidmatch]').val(),
                data:{
	            	id:id,//报盘id
	        	},
                success: function (result) {
                	var tiphtml=''
                    console.log(result);//打印服务端返回的数据(调试用)
                    if (result.success == 1) {
                    	tiphtml='<div id="resule_success" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/successIcon.png"/></div>'
	        			+'<div class="result_tip">恭喜，您的保证金已缴纳成功，现在可以去竞价！</div>'
	        			+'<div class="result_tip success_tip">系统将自动在3秒内跳转到竞价页面</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml)
                    	$(".bidbond_result").fadeIn(1000,setTimeout(function () {
                    		var biddetail =$('input[name=biddetail]').val()
					           location.href=bidUrls+"?id="+id+"&pass="+pass;
					        },3000)
                    	)
                    }else{
                    	tiphtml='<div id="resule_fail" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/failIcon.png"/></div>'
	        			+'<div class="result_tip">很抱歉，系统未收到到账的保证金，请先进行保证金缴纳！</div>'
	        			+'<div class="result_tip fail_tip">若有疑问，联系客服热线400-6238086</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml)
                    	$(".bidbond_result").fadeIn()
                    }
                },
                error : function() {
                    console.log("异常！");
                }
            });
	})
}
	
 })
