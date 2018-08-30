$(function(){
    $(".close,.mark").click(function(){
         $(".bidbond_result").hide()
    })
    var api="http://192.168.13.4:3000/mock/9"
    //开户信息查询
    $(".bankselectBtn").click(function(){
    	var bankUser =$('input[name=bondName]').val();
    	var bankNum =$('input[name=bankNum]').val();
    	console.log("输入内容",bankUser,"-",bankNum)
    	bankSearch(bankUser,bankNum);
    })

    function bankSearch(bankUser,bankNum){
	    $.ajax({
	        'url':api+'/nnys-admin/balance/fundin/bankSearch',
	        //'url':$('input[name=bankSearch]').val(),
	        'type':'get',
	        'dataType':'json',
	        'data':{
	            name:bankUser,//用户名
	            acc:bankNum//银行账号
	        },
	        success: function(data){
	        	var dataLenth=Object.getOwnPropertyNames(data).length
	        	console.log("查询信息",Object.getOwnPropertyNames(data).length)
	        	if(dataLenth!=1){
	        		var bondInfo ='<div class="no_info"><p class="no_info_p">暂无检索到匹配收款信息，请重新确认精准检索！</p></div>'
	        		$("#bondContent").html(bondInfo)
	        	}else{
	        		var bondData = template.render('bankTemplat',{bondDatas:data});
                    console.log("只有一条",bondData)
                    $('#bondContent').html(bondData); 
                    inputCont()
                    $("#ssi-uploadBtn").click(function(){
                    	var id = data[0].user_id
                    	var OP_ACCT_NO_32= data[0].card_no //账号
                    	var OP_CUST_NAME= data[0].true_name //账户名
                    	var TX_AMT= $('input[name=bandatm]').val(); //金额
                    	var TX_LOG_NO=$('input[name=bandlogno]').val(); //流水号
                    	var img=$("#ssi-previewBox img").attr("src");
                    	console.log("录入",id,OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img)
						console.log("jine",TX_AMT)
						if(TX_LOG_NO==""||TX_AMT=="" ){
							alert("金额和流水号不能为空")
						}else{
							bankbankflowAdd(id,OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img)
						}
						
                    })
	        	}
	        }
	    })
	}
	 //开户信息查询 end
	 //保证金录入
	function bankbankflowAdd(id,OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img){
		$.ajax({
	        'url':api+'/nnys-admin/balance/fundin/bankSearchbankflowAdd',
	        //'url':$('input[name=bankbankflowAdd]').val(),
	        'type':'post',
	        'dataType':'json',
	        'data':{
	            id:id,//编辑时使用
	            OP_ACCT_NO_32:OP_ACCT_NO_32,//账号
	            OP_CUST_NAME:OP_CUST_NAME,  //账户名
	            TX_AMT:TX_AMT, //金额
	            TX_LOG_NO:TX_LOG_NO,//流水号
	            img:img //图片
	        },
	        success: function(res){
	        	console.log("res:",res)
	        	if(res.success==true){
	        		$(".bankInfo .infoTip").html("");
	        		$(".bidbond_result").fadeIn(1000,setTimeout(function () {
	        			$(".bidbond_result").hide()
				            //location.href =$('input[name=qkh]').val()  //开户界面
				        },3000))
	        	}else{
	        		$(".bankInfo .infoTip").html("!系统已经录入该流水账号，请检查输入是否正确")
	        	}
	        }
	    })
	}//保证金录入end
	//金额和流水号限制数字
	function inputCont(){
		$('input[name=bandatm]').keyup(function(){
	    	var c=$(this);
	    	if(/[^\d]/.test(c.val())){
	    		var temp=c.val().replace(/[^\d]/g,'');
	    		$(this).val(temp);
	    		$("#bandatmspan").css({'display':'block'});
	    	}else{
	    		$("#bandatmspan").css({'display':'none'});
	    	}

		})
		$('input[name=bandlogno]').keyup(function(){
	    	var c=$(this);
	    	if(/[^\d]/.test(c.val())){
	    		var temp=c.val().replace(/[^\d]/g,'');
	    		$(this).val(temp);
	    		$("#bandlognospan").css({'display':'block'});
	    	}else{
	    		$("#bandlognospan").css({'display':'none'});
	    	}

		})
	}//金额和流水号限制数字 end
})