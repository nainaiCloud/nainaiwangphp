$(function(){
    $(".close,.mark").click(function(){
         $(".bidbond_result").hide()
    })
    //个人企业选择
    $(".searchtitle .stitle").click(function(){
    	 $(".searchtitle .stitle a").removeClass("cur");
    	$(this).find("a").addClass("cur")
    	var cont= $(this).find("a").text()
    	console.log(cont);
    	if(cont == "企业"){
    		$(".enterprise").show();
    		$(".personal").hide();
    	}else if(cont == "个人"){
    		$(".enterprise").hide();
    		$(".personal").show();
    	}
    })  //个人企业选择 end
    //var api="http://192.168.13.4:3000/mock/9"
    //企业开户信息查询
    $(".enterselect").click(function(){
    	var enbankUser =$('input[name=bondName]').val();
    	var enbankType =1 //企业类型为1
    	console.log("输入内容",enbankUser,"-",enbankType)
    	bankSearch(enbankUser,enbankType);
    })
    //个人信息查询
    $(".perselect").click(function(){
    	var perbankUser =$('input[name=perbondName]').val();
    	var perbankType = 0 //个人类型0
    	console.log("输入内容2",perbankUser,"-",perbankType)
    	bankSearch(perbankUser,perbankType);
    })

    function bankSearch(bankUser,bankType){
	    $.ajax({
	        //'url':api+'/nnys-admin/balance/fundin/bankSearch',
	        //'url':'http://ceshi.nainaiwang.com/nnys-admin/balance/fundin/banksearch',
	        'url':$('input[name=bankSearch]').val(),
	        'type':'get',
	        'dataType':'json',
	        'data':{
	            name:bankUser,//名称
	            type:bankType//类型
	        },
	        success: function(data){
	        	console.log("查询信息",data)
	        	if(bankType == 1){
	        		//bankType == 1 企业
	        		var enterbondData = template.render('enterbankTemplat',{enterDatas:data});
                    
                    $("#enterbondContent").html(enterbondData);
                    $("input[name='enbandatm']").keyup(function(){
                    	
				       $("input[name='enbandatmM']").val(DX($(this).val()))
				       console.log("企业大写金额",DX($(this).val()))
				     });
                    //企业录入保证金
                    $(".enupload-btn").click(function(){
                    	var OP_ACCT_NO_32=""
	                    var OP_CUST_NAME = $('input[name=enUser]').val();//账号名
	                    var	TX_AMT = $('input[name=enbandatm]').val();//金额
						var	TX_LOG_NO = $('input[name=enbandlogno]').val(); //流水号
	                    var img=$("#bonduploadImg").val();//图片img
                    	if(data!=null){
                    		if(data.users[0].bank != null){
                    			OP_ACCT_NO_32 =$('input[name=enbanknum]').val();//账号
                    		}
                    	}
                    	//console.log("企业录入",OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img)	
                    	if(img!=""){
                    		bankbankflowAdd(OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img)
                    	}else{
                    		alert("请上传凭证！")
                    	}
				 		
				 	}) //企业录入保证金 end

	        	}else if(bankType == 0){
	        		var perbondData = template.render('perbankTemplat',{perDatas:data});
                    //console.log("个人",perbondData)
                    $("#preContent").html(perbondData); 
                    $("input[name='perbandatm']").keyup(function(){
                    	console.log("个人大写金额",DX($(this).val()))
				       $("input[name='perbandatmM']").val(DX($(this).val()))
				     });
                    preselect();//多个用户时单击选择事件
                    //个人录入保证金 
                    $(".perupload-btn").click(function(){
                    	var OP_ACCT_NO_32=$(".preTextcur .preBanknums").text()//账号
	                    var OP_CUST_NAME = $(".preTextcur .preName-text").text();//账号名
	                    var	TX_AMT = $('input[name=perbandatm]').val();//金额
						var	TX_LOG_NO = $('input[name=perbandlogno]').val(); //流水号
	                    var img=$("#bonduploadImg").val();//图片img
	                    if($(".preResult").hasClass("preTextcur")){
	                    	if(img!=""){
	                    		if(TX_AMT!=""&&TX_LOG_NO!=""){
	                    		bankbankflowAdd(OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img)
		                    	}else{
		                    		alert("金额或流水号不能为空！")
		                    	}
	                    	}else{
	                    		alert("请上传凭证！")
	                    	}
	                    	
	                    	
	                    }else{
	                    	alert("请先选择用户！")
	                    }
                    	//console.log("个人录入",OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img)	
				 		
				 	}) //个人录入保证金 end
	        	}
	        }, 
	        error:function (data) {      
            	console.log("请求失败！",data);
        	}
	    })
	}
	 //开户信息查询 end
	 //保证金录入
	function bankbankflowAdd(OP_ACCT_NO_32,OP_CUST_NAME,TX_AMT,TX_LOG_NO,img){
		$.ajax({
	        //'url':api+'/nnys-admin/balance/fundin/bankSearchbankflowAdd',
	        //'url':'http://192.168.13.119/nn2/nnys-admin/balance/fundin/bankflowAdd',
	        'url':$('input[name=bankbankflowAdd]').val(),
	        'type':'post',
	        'dataType':'json',
	        'data':{
	            id:"",//编辑时使用
	            OP_ACCT_NO_32:OP_ACCT_NO_32,//账号
	            OP_CUST_NAME:OP_CUST_NAME,  //账户名
	            TX_AMT:TX_AMT, //金额
	            TX_LOG_NO:TX_LOG_NO,//流水号
	            img:img //图片
	        },
	        success: function(res){
	        	console.log("res:",res)
	        	if(res.success==1){
	        		$(".bankInfo .infoTip").html("");
	        		$(".bidbond_result").fadeIn(1000,setTimeout(function () {
					       $(".bidbond_result").hide()
					       location.reload();
					    },3000)
	                )
	        	}else{
	        		//alert(res.info)
	        		$(".bankInfo .infoTip").html("!系统已经录入该流水账号，请检查输入是否正确")
	        	}
	        },error:function (res) {      
            	console.log("录入请求失败！",res,res.responseText);
        	}
	    })
	}//保证金录入end
//个人用户选择
function preselect(){
	$(".i_radio").click(function(){
		$(".preResult").removeClass("preTextcur")
		$(".i_radio").removeClass("cur")
		$(this).addClass("cur")
		$(this).parent(".preResult").addClass("preTextcur")
		if($(this).parent(".preResult").find(".preType .preType_no").text() == "未开户"){
			$(".perbankInfo").hide();
		}else{
			$(".perbankInfo").show();
		}
	})
}

//个人用户选择end

//金额转大写
function DX(n) {
    if (!/^(0|[1-9]\d*)(\.\d+)?$/.test(n))
      return "数据非法";
    var unit = "千百拾亿千百拾万千百拾元角分", str = "";
      n += "00";
    var p = n.indexOf('.');
    if (p >= 0)
      n = n.substring(0, p) + n.substr(p+1, 2);
      unit = unit.substr(unit.length - n.length);
    for (var i=0; i < n.length; i++)
      str += '零壹贰叁肆伍陆柒捌玖'.charAt(n.charAt(i)) + unit.charAt(i);
    return str.replace(/零(千|百|拾|角)/g, "零").replace(/(零)+/g, "零").replace(/零(万|亿|元)/g, "$1").replace(/(亿)万|壹(拾)/g, "$1$2").replace(/^元零?|零分/g, "").replace(/元$/g, "元整");
}//金额转大写 end
	//金额和流水号限制数字()
	/*function inputCont(){
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
	}*///金额和流水号限制数字 end
})