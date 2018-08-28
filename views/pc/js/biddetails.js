
/* 商品详情页图片轮换*/
 $(function() {
    //图片切换
function imgzh(){
    function leftanimate(n){
        var leftJl=60*(n)
        $(".demo .box ul").animate({
                left:-leftJl
            },1000);
    }
    function show(m){
        var liIndex = $(".demo .box ul li.tb-selected").index()
        var content 
        $(".demo .box ul li").removeClass("tb-selected")
        $(".demo .box ul li a").removeClass("cur")
        content = $(".demo .box ul li").eq(m).find("a").html();
        $(".tb-booth a").html(content);//增加内容
        $(".demo .box ul li").eq(m).addClass("tb-selected")
        $(".demo .box ul li").eq(m).find("a").addClass("cur")
    }
    var line = $("ul#thumblist li").length;
    $("ul#thumblist li").click(function(){
        var idexM=$(this).index();
        show(idexM)
        if(line>5 && idexM>3 && line-idexM>1 ){
            leftanimate(idexM-3)
        }else if(line>5 && idexM<3 && line-idexM>4 && idexM !=0){
            leftanimate(idexM-1)
        }

    })
    $(".lefts").click(function(){

    	var leftIndex = $(".demo .box ul li.tb-selected").index()
    	if(leftIndex<=0){
    		show(0)
    	}else if(leftIndex>0){           
    		show(leftIndex-1)
            if(line>5 && leftIndex<4 && line-leftIndex>3 && leftIndex>1){
                leftanimate(leftIndex-2)
            }
    	}
        
    })
    $(".rights").click(function(){
    	var rightIndex = $(".demo .box ul li.tb-selected").index()
    	var content
    	if(4<=rightIndex<0){
    		show(0)
    	}else if(rightIndex+1<line){
            show(rightIndex+1)
            if(line>5 && rightIndex>3 && line-rightIndex>2){
                leftanimate(rightIndex-2)
            }
    	}
        
	   })
}//图片切换end
    /*支付密码遮罩层提示关闭*/
    $(".close,.mark").click(function(){
         $(".pay_password").fadeOut()
    }) /*支付密码遮罩层提示关闭 end*/
   //获取url中的参数,获取报盘id
function getUrlParam(name) {
       var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
       var r = window.location.search.substr(1).match(reg); //匹配目标参数
       if (r != null) return unescape(r[2]); return null; //返回参数值
}
var id =getUrlParam("id");
var pass =getUrlParam("pass")
console.log(id,pass,"dd")
//竞价详情数据获取
biddetailData();
function biddetailData(){
    $.ajax({
        'url':$('input[name=detail]').val(),
       /* 'url':'http://ceshi.nainaiwang.com/ajaxdata/jingjiadetail',*/
        'type':'get',
        'dataType':'json',
        'data':{
            id:id,//报盘id
            pass:pass,//竞价密码
        },
        success: function(data){           
            if(data !=null){
                  $.ajax({
                    'url':$('input[name=baojiaList]').val(),
                   /* 'url':'http://ceshi.nainaiwang.com/ajaxdata/baojiadata',*/
                    'type':'get',
                    'dataType':'json',
                    'data':{
                        id:id,//报盘id
                    },
                    success: function(res){
                         //商品明细
                        var commdetail = template.render('commdetailtemplat',{detailData:data});
                        var commdTop = template.render('commdToptemplat',{detailtop:data});
                             //console.log(commdetail,"shuj")
                        $('#commoditydetail').html(commdetail);
                        $('#commodityTop').html(commdTop);
                        //商品明细end
                        //商品属性
                        var attrItems=""
                        $.each(data.attr,function(n,attritem){
                            attrItems+="<tr><td>"
                            +attritem.name+"</td><td>"
                            +attritem.value+"</td></tr>"
                        })
                        $("tr.attrAfter").before(attrItems)
                        //商品图片strat
                        var imgList=""
                        $.each(data.origphotos,function(index,item){
                                imgList+="<li class='tb-selected'><a><img style='display:block !important' src="
                             +item+"></img></a></li>"
                        })
                    
                        $("#thumblist").append(imgList);
                        $("ul#thumblist li").eq(0).find("a").addClass("cur")
                        imgzh()//图片切换
                         //商品图片 end
                        //所属市场end
                        var catenames=""
                        $.each(data.cate,function(n,catename){
                            catenames+=catename.name+">"
                        })
                         $(".biddetails_right .bidTitle .cate_chain").text(catenames)//所属市场end
                    //时间计算
                        show_time();
                        function show_time(){ 
                            var nowTime = (now + s)*1000;
                            s++ ;
                            if(data.status ==1){
                               var time_end  = new Date(data.start_time).getTime();
                            }else if(data.status ==2){
                                time_end  = new Date(data.end_time).getTime()
                            }
                            // 计算时间差 
                            var time_distance = time_end - nowTime;
                            //console.log(time_distance,"时间差",s) 
                            // 天
                             if(time_distance > 0){
                            var int_day = Math.floor(time_distance/86400000) 
                            time_distance -= int_day * 86400000; 
                            // 时
                            var int_hour = Math.floor(time_distance/3600000) 
                            time_distance -= int_hour * 3600000; 
                            // 分
                            var int_minute = Math.floor(time_distance/60000) 
                            time_distance -= int_minute * 60000; 
                            // 秒 
                            var int_second = Math.floor(time_distance/1000) 
                            // 时分秒为单数时、前面加零 
                            if(int_day < 10){ 
                                int_day = "0" + int_day; 
                            } 
                            if(int_hour < 10){ 
                                int_hour = "0" + int_hour; 
                            } 
                            if(int_minute < 10){ 
                                int_minute = "0" + int_minute; 
                            } 
                            if(int_second < 10){
                                int_second = "0" + int_second; 
                            } 
                            // 显示时间 
                            $("#time_d").text(int_day); 
                            $("#time_h").text(int_hour); 
                            $("#time_m").text(int_minute); 
                            $("#time_s").text(int_second); 
                            setTimeout(show_time,1000);
                            }else if(time_distance==0){
                                window.location.reload();//倒计时为0 刷新页面
                            }else{
                                 // 显示时间 
                                $("#time_d").text("00"); 
                                $("#time_h").text("00"); 
                                $("#time_m").text("00"); 
                                $("#time_s").text("00");
                            }

                        }
                    //时间计算end
                        var bjListData = res.data//列表数据
                        console.log(res,"res数据")
                        //竞拍状态，价格
                        var priceText=""//价格
                        var bidType ="" //竞价状态
                        var cprice =""//出价人
                        var curprice;//input价格
                        var but=""//按钮
                        var tip=""//提示
                        var bid_time=""//时间说明
                        if(data.status ==1){
                            console.log(data.status,"res数据1")
                            priceText = "起拍价："+data.price_l
                            bidType ="竞价暂未开始"
                            cprice="出价人：竞价暂未开始，目前没有出价人"
                            curprice=data.price_l//input价格
                            tip="*提示：出价需要先交支付保证金"
                            bid_time ="距离开始还有"
                            if(data.login_user == data.user_id){
                                but=""
                            }else{
                                but='<input class="submitBut yes" type="button" name="bzj" value="支付保证金">'
                            }
                            
                        }else if (data.status ==2){
                            console.log(data.status,"res数据2")
                            if(bjListData.length>0){
                                priceText = "当前价："+bjListData[0].price
                                curprice=bjListData[0].price
                                cprice="出价人："+bjListData[0].true_name //出价人字段
                                }else{
                                    priceText = "当前价："+data.price_l
                                    curprice=data.price_l
                                    cprice="出价人：无出价"//出价人字段
                                }
                            bidType ="竞价进行中"
                            bid_time="距离结束还有"
                            bzjyz(data)

                        }else if(data.status ==3){
                            if(data.order_status == 0){//未成交
                                priceText = "成交价"+data.price_l
                                cprice="出价人：无出价"
                                curprice=data.price_l
                                bidType ="竞价结束，该商品竞价失败!"
                                tip=""
                            }else if(data.order_status == 1){//待付款
                                priceText = "成交价"+bjListData[0].price
                                cprice="出价人："+bjListData[0].true_name
                                curprice=bjListData[0].price
                                bidType ="竞价已截止,待货款缴纳!"
                                tip="*提示：竞价成功后请尽快完成货款缴纳。"
                            }else if(data.order_status == 2){//未缴纳货款
                                priceText = "成交价"+bjListData[0].price
                                cprice="出价人："+bjListData[0].true_name
                                curprice=bjListData[0].price
                                bidType ="竞价结束，该商品竞价失败！"
                                tip=""
                            }else if(data.order_status == 3){//已缴纳
                                 priceText = "成交价"+bjListData[0].price
                                cprice="出价人："+bjListData[0].true_name
                                curprice=bjListData[0].price
                                bidType ="竞价结束，该商品成功竞价！"
                                tip=""
                            }
                                bid_time="该商品已竞价结束"
                                but='<input class="submitBut end" type="button" disabled="disabled" name="jjend" value="竞价已结束">'
                        }
                            console.log(res.count,data.views,"res数据k")
                            $(".bidBottom .bidpricepop .pepNum").text(res.count);//出价人数
                            $(".bidBottom .bidwk .viewNum").text(data.views);//围观人数
                            $(".price .price_type .dqprice_con").text(priceText) ;//价格
                            $(".bidInfor .bidinfortitle .bid_left").text(bidType);//竞价状态提示
                            $(".price .cprice").text(cprice);//出价人
                            $(".cj .inputName input#num").val(curprice);//当前价格
                            $(".bidfor_cont_left .but").html(but);//按钮
                            $(".introduce_title .numt").text(bjListData.length);//竞价记录条数
                            $(".bid_right .bid_time").text(bid_time);//时间说明
                            $(".tip .tipcolor1").text(tip);
                            numprice(data.jing_stepprice,curprice);//价格加减
                            $(".but input[name='bzj']").click(function(){
                                bzj();
                            });//单击保证金按钮执行事件
                            $(".but input[name='yescj']").click(function(){
                                yescj()
                            })//单击出价按钮执行事件
                
                            //竞拍状态，价格 end
                            //出价列表
                            var baojiaListone=""//领先报价
                            var baojiaList ="" //报价列表
                            if(res.count==0){
                                baojiaList +="<div class='no_baojia'>暂未出价</div>"
                            }else{
                                baojiaListone="<ul class='auction_cont first'><li><span>"
                                +bjListData[0].true_name +"</span></li><li><span>"
                                +bjListData[0].price+" 元</span></li><li><span>"
                                +bjListData[0].time+"</span></li><li><span>领先</span></li></ul>"
                                for(var i=1;i<bjListData.length;i++){
                                    baojiaList+="<ul class='auction_cont'><li><span>"
                                    +bjListData[i].true_name +"</span></li><li><span>"
                                    +bjListData[i].price+" 元</span></li><li><span>"
                                    +bjListData[i].time+"</span></li><li><span>出局</span></li></ul>"
                                    }
                                }
                                $("#baojiaList").html(baojiaListone+baojiaList)

                    },error:function(res){
                        console.log("报价列表出错")    
                    }
                })
                //竞价列表
         }
          
        },error:function(data){
                console.log("网络出错")    
        }
    })
}

//竞价详情数据获取 end
/*保证金是否缴纳验证*/
function bzjyz(data){
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
            if(data.login_user == data.user_id){
                $(".bidfor_cont_left .but").html("")
            }else{
                if(datas.success == 0){
                    $(".bidfor_cont_left .but").html('<input class="submitBut yes" type="button" name="bzj" value="支付保证金">')
                    $(".tip .tipcolor1").text("*提示：出价需要先交支付保证金") 
                }else{
                    $(".bidfor_cont_left .but").html('<input class="submitBut yes" type="button" name="yescj" value="确认出价">')
                    $(".tip .tipcolor1").text("*提示：您已支付保证金可以出价竞拍")
                }
            }
            $(".but input[name='bzj']").click(function(){
                bzj();
             });//单击保证金按钮执行事件
            $(".but input[name='yescj']").click(function(){
                yescj()
            })//单击出价按钮执行事件
        }
    })
                            
}
//保证金数据
function bzj(){
    var bidUrls=$("input[name='bidUrl']").val()
     console.log("d",bidUrls)
    location.href=bidUrls+"?id="+id+"&pass="+pass;
}
//出价接口
function yescj(){
    var bidprice = $("#num").val();
    $(".pay_password").fadeIn();
    /*在事件执行的时候在同一个元素上注册执行的事件执行了多次。
    * 1绑定之前先解绑
    */
    //解除 $().off()
    $("input[name='butPassword']").off().click(function(){
        console.log('内部事件触发')
    })
    //绑定
    $("input[name='butPassword']").click(function(){
        var inputPay = $(".pay_input input[name='payPassword']").val();
         console.log(inputPay,"-",bidprice,"报价")
        baojiaPost(inputPay,bidprice)
    })
}
    function baojiaPost(pass,curprice){
        $.ajax({
            'url':$('input[name=baojiaPost]').val(),
           /*'url':'http://ceshi.nainaiwang.com/trade/jingjiabaojia',*/
            'type':'post',
            'dataType':'json',
            'data':{
                pass:pass,//支付密码
                price:curprice,//价格
                offer_id:id//报盘id
            },
            success: function(data){
                var url = data.returnUrl;//返回地址
                var times = data.time;//跳转时间
                console.log(data.success,"success")
                if(data.success==1){
                    biddetailData()
                    $(".pay_password").fadeOut()
                }else{
                    alert(data.info) 
                    $(".pay_password").fadeOut() 
                    
                }
            },error:function(data){
                  alert(data.info)     
            }
        })
    }
//出价接口 end
    //报价加减stepprice增加幅度 cursprice当前价格
    function numprice(stepprice,cursprice){
        var numPrice;
        $("#add").click(function(){
            var priceadd=$("#num").val() 
            numPrice=parseFloat(priceadd)+parseFloat(stepprice);
            $("#num").val(numPrice.toFixed(2)); 
        })
        $("#jian").click(function(){
            var pricejian=$("#num").val() 
            numPrice=parseFloat(pricejian)-parseFloat(stepprice);
            console.log(numPrice,"numPrice")
            if(numPrice>=cursprice){
               $("#num").val(numPrice.toFixed(2)); 
            }else{
                $("#num").val(cursprice); 
                 alert("当前已是最低出价")
            }

        })

    }

    
});
//绑定回车事件
$(document).keydown(function(event){ 
if(event.keyCode==13){ 
 $("input[name='butPassword']").click(); 
} 
}); 