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
	//console.log("dd",id,"-",pass)
//开户信息
 	bzjData()
	function bzjData(){
	    $.ajax({
	        //'url':'http://ceshi.nainaiwang.com/ajaxdata/jingjiadepositpage',
	        //'url':'http://192.168.13.4:3000/mock/9/ajaxdata/jingjiadepositpage',
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
	        	//企业用户提示
	        	var enterTip="保证金实际缴纳金额必须同需要缴纳金额完全一致，否则造成的缴纳不成功自行负责"
	        	//个人用户提示
	        	var perTip="保证金实际缴纳金额必须同需要缴纳金额完全一致，且必须使用开户账户关联的银行账户进汇款。否则造成的缴纳不成功自行负责"
	        	//console.log("用户类型：",bzjDatas.user.type)
	        	if(bzjDatas.user.type == 1){
	        		//bzjDatas.user.type == 1 企业
	        		var BankInfo = template.render('banktemplat',{bankInfo:bzjDatas.user.bank});
			        	$('#BankInfo').html(BankInfo);
			        $(".bidBond_tip .sktip").html(enterTip)
	        	}else if(bzjDatas.user.type == 0){
	        		//bzjDatas.user.type == 1 个人
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
		        	 $(".bidBond_tip .sktip").html(perTip)
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
	    	//console.log(datas,"bzjyz")
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
               /* url: "http://ceshi.nainaiwang.com/ajaxdata/alrealydeposit" ,*///匹配数据url
                url:$('input[name=bidmatch]').val(),
                data:{
	            	id:id,//报盘id
	        	},
                success: function (result) {
                	var tiphtml=''
                    //console.log(result);//打印服务端返回的数据(调试用)
                    if (result.success == 1) {
                    	tiphtml='<div id="resule_success" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/successIcon.png"/></div>'
	        			+'<div class="result_tip">恭喜，您的保证金已缴纳成功，现在可以去竞价！</div>'
	        			+'<div class="result_tip success_tip">系统将自动在3秒内跳转到竞价页面</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml)
                    	$(".bidbond_result").fadeIn(1000,setTimeout(function () {
                    		var biddetail =$('input[name=biddetail]').val()
					           location.href=biddetail+"?id="+id+"&pass="+pass;
					        },3000)
                    	)
                    }else if(result.success == 2){
                    	tiphtml='<div id="resule_fail" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/failIcon.png"/></div>'
	        			+'<div class="result_tip">已缴纳成功，不要重复匹配！</div>'
	        			+'<div class="result_tip fail_tip">若有疑问，联系客服热线400-6238086</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml) 
                    	$(".bidbond_result").fadeIn()  
                    }else if(result.success == 3){
						tiphtml='<div id="resule_fail" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/failIcon.png"/></div>'
	        			+'<div class="result_tip">不能给自己的竞价缴纳！</div>'
	        			+'<div class="result_tip fail_tip">若有疑问，联系客服热线400-6238086</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml) 
                    	$(".bidbond_result").fadeIn()                
                    }else if(result.success == 0){
                    	tiphtml='<div id="resule_fail" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/failIcon.png"/></div>'
	        			+'<div class="result_tip">很抱歉，系统未收到到账的保证金，请先进行保证金缴纳！</div>'
	        			+'<div class="result_tip fail_tip">若有疑问，联系客服热线400-6238086</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml)
                    	$(".bidbond_result").fadeIn()
                    }else if(result.success == 4){
                    	tiphtml='<div id="resule_fail" class="result_cont">'
	        			+'<div class="result_img"><img src="../views/pc/images/icon/failIcon.png"/></div>'
	        			+'<div class="result_tip">很抱歉，您实际缴纳的保证金金额同所需缴纳金额不一致，请核实！</div>'
	        			+'<div class="result_tip fail_tip">若有疑问，联系客服热线400-6238086</div></div>'
                    	$(".bidbond_result .tipCont").html(tiphtml)
                    	$(".bidbond_result").fadeIn()
                    }
                },
                error : function() {
                    //console.log("异常！");
                }
            });
	})
}
	
 })
