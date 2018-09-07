	$(function(){
		var curpage = 1;//
		var curpid="";
		var curstatus=""
		bidData();
		function bidData(){
			$.ajax({
				'url':$('input[name=bidList]').val(),
				/*'url':'http://ceshi.nainaiwang.com/ajaxdata/jingjiaList',*/
				'type':'get',
				'dataType':'json',
				'data':{
					page:curpage,
					pid:curpid,
					status:curstatus
				},
				success: function(data){
					if(data){
		               var bidList = template.render('bidListtemplat',data);
		               //console.log(data,"lieb")
		               $('#bidcomBox').html(bidList);
		              	var pagestr=""
		              	if(data.page!=null){
		              		for(var i=0; i<data.page.totalPage;i++){
		             		var num = i+1
		             		pagestr+="<a class='numPage'>"+num+"</a>"
		             		}
		              	}
		               $(".page").html(pagestr)
		               $(".curpage").text(data.page.current);
		               $(".total").text(data.page.totalPage)
		               $(".page .numPage").eq(data.page.current-1).addClass("current_page")
		               var w;
		               if(data.page.totalPage<11){
		               	w=data.page.totalPage
		               }else{
		               	w=10
		               }
		               $(".pagediv").css("width",38*w)
		               onClickA();
		            }
				},error:function(data){
					//alert("失败")
				}
			})
		}
			//获取当前交易类型
		$(".jileix .criterItem").click(function(){
			$(".jileix .criterItem a").removeClass("cur");
			curpid = $(this).attr('id')
			//alert(curpid,"市场类型")
			bidData();
			$(this).children("a").addClass("cur");
			
		})
		//获取当前竞价状态
		$(".jijia .criterItem").click(function(){
			$(".jijia .criterItem a").removeClass("cur");
			curstatus =$(this).attr('id')
			bidData();
			$(this).children("a").addClass("cur");
		})
		//分页数据
		function onClickA(){
			$(".pages_bar a").click(function(){

			curpid =$(".jileix .criterItem a.addClass").attr('id')
			curstatus =$(".jijia .criterItem").attr('id')
			var curContent=parseInt($(".page_num .pages_bar a.current_page").text());//当前内容
			var alength = $(".page_num .pages_bar a.numPage").length
			var aContent = $(this).text();//单击的当前内容
			if(aContent =="首页"){
			 curpage=1;
			}else if(aContent=="尾页"){
				curpage =""	
			}else if(aContent=="上一页"){
				if(curContent>1){
					curpage=curContent-1
				}
			}else if(aContent=="下一页"){
				if(curContent<alength){
					curpage=curContent+1
				}
			}else{
				curpage=parseInt(aContent);
			}
			var leftJl
			if(curpage>=8 && curpage<alength-1){
				leftJl=38*(curpage-8)
		        $(".pagediv .page").animate({
		                left:-leftJl
		        },1000);
			}
			$(".page_num .pages_bar a").removeClass("current_page");
			//console.log(curContent,"-",curpage,"-",alength,"单击的当前内容")
			bidData();

		});
		}
		 
		

	})