$(document).ready(function(){
  //左侧导航栏
    $(".nav-first").click(function() {
       $(this).parents(".btn1").find(".zj_zh").toggle();
       if(!$(this).parents(".btn1").find(".zj_zh").is(":hidden")){
          $(this).find("i").addClass("icon-caret-down");
          $(this).find("i").removeClass("icon-caret-right");
       }else{
           $(this).find("i").addClass("icon-caret-right");
           $(this).find("i").removeClass("icon-caret-down");
       }
    
    });
      //end左侧导航栏

//商品分类展开
    $(".class_jy").delegate(".info-show", "click", function () {
      $(this).parents(".class_jy").find(".infoslider").show(); 
      $(this).removeClass("info-show").addClass("info-hide").html("收起");
    });    
    $(".class_jy").delegate(".info-hide", "click", function () {
      $(this).parents(".class_jy").find(".infoslider").hide();
      $(this).removeClass("info-hide").addClass("info-show").html("展开")
    });    
    // end商品分类展开                
});

/*数量加减控件*/
$(document).ready(function(){
$("#add").click(function(){
  var n=$("#num").val();
  var num=parseInt(n)+1;
 if(num==0){alert("cc");}
  $("#num").val(num);
});
$("#jian").click(function(){
  var n=$("#num").val();
  var num=parseInt(n)-1;
 if(num==0){alert("不能为0!"); return}
  $("#num").val(num);
  });
});
//企业认证切换
$(document).ready(function(){
  $(".rz_ul .rz").click(function(){
    $(".rz_ul .rz_li").removeClass("cur");
    $(".re_xx").show();
    $(".yz_img").hide();
    $(".sh_jg").hide();
    $(this).parents(".rz_li").addClass("cur");

  });
  $(".rz_ul .yz").click(function(){
    $(".rz_ul .rz_li").removeClass("cur");
    $(".yz_img").show();
    $(".re_xx").hide();
    $(".sh_jg").hide();
    $(this).parents(".rz_li").addClass("cur");

  });
  $(".rz_ul .shjg").click(function(){
    $(".rz_ul .rz_li").removeClass("cur");
    $(".sh_jg").show();
    $(".yz_img").hide();
    $(".re_xx").hide();
    $(this).parents(".rz_li").addClass("cur");

  });
});
//end企业认证切换
//发布报盘弹出提示窗
jQuery(document).ready(function($){
  //open popup
  $('.bzjin').on('click', function(event){
    event.preventDefault();
    $('.cd-popup').addClass('is-visible');
  });
  
  //close popup
  $('.cd-popup').on('click', function(event){
    if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });
  //close popup when clicking the esc keyboard button
  $(document).keyup(function(event){
      if(event.which=='27'){
        $('.cd-popup').removeClass('is-visible');
      }
    });
  //报盘弹出信息end

  //合同列表用户信息显示。
      $(".Place").mouseover(function () {
          $(this).find(".prompt-01").css("display", "block");
      });
      $(".Place").mouseout(function () {
          $(this).find(".prompt-01").css("display", "none");
      });
      
    //合同列表用户信息显示end
        
});

// chongzhi

      //图片上传预览    IE是用了滤镜。
        function previewImage(file)
        {
          var MAXWIDTH  = 260; 
          var MAXHEIGHT = 180;
          var div = document.getElementById('preview');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead>';
              var img = document.getElementById('imghead');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead>';
            var img = document.getElementById('imghead');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight )
            {
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;
                
                if( rateWidth > rateHeight )
                {
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else
                {
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }
            
            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }

/*控制消息页面中详情显示和隐藏 start*/ 
                          $(function (){
                            $('.tact').each(function(){
                                $(this).mouseover(function(){
                                    $(this).closest('.clear').next('.jy_deal').show();
                                    var _this=$(this);
                                    var id=$(this).attr('messID');
                                    var url=$('#messUrl').val();
                                    $.ajax(
                                        {   type:'post',
                                            url:url,
                                            data:{id:id},
                                            dataType:'json',
                                            success:function(msg){
                                                if(msg.success==1){
                                                    _this.find('a').css('color','#777');
                                                    getNeedMessage();
                                                }
                                            }
                                        }
                                    )
                                })
                                $(this).mouseout(function(){
                                    $(this).closest('.clear').next('.jy_deal').hide();
                                })
                            })
                            $('.jy_deal').each(function(){
                                $(this).mouseover(function(){
                                    $(this).show();
                                })
                                $(this).mouseout(function(){
                                    $(this).hide();
                                })
                            })
                        })
                                   
/*控制消息页面中详情显示和隐藏 end*/



//密码修改页面说明框 鼠标的移入移出  
       $(function(){
        $(".ck_span").mouseover(function (){  
            $(".cksl_bk").show();  
        }).mouseout(function (){  
            $(".cksl_bk").hide();  
        }); 
        //鼠标的移入移出  
        $(".ck_span2").mouseover(function (){  
            $(".cksl_bk2").show();  
        }).mouseout(function (){  
            $(".cksl_bk2").hide();  
        });  
        //鼠标的移入移出  
        $(".ck_span3").mouseover(function (){  
            $(".cksl_bk3").show();  
        }).mouseout(function (){  
            $(".cksl_bk3").hide();  
        });  
       }) 

       /*在线招投标（bidOper3.tpl）金额计算*/
       $(function(){
        
            $(".djia_price").keyup(function(){
             // alert("d")
            var num = $(this).parent().parent("tr").find("td .itme_num").val();
            $(this).parent().parent("tr").find("td .amount").html($(this).val()*num);
            var freight_fee = $(this).parent().parent("tr").find(".freight_fee").val();
            var total_amounts = $(this).val()*num + Number(freight_fee);
            $(this).parent().parent("tr").find("td .total_amount").html(total_amounts);
          })
          
          $(".freight_fee").keyup(function(){
            var num = $(this).parent().parent("tr").find("td .itme_num").val();
            //alert(num)
            var total_amount = $(this).parent().parent("tr").find("td .djia_price").val()*num + Number($(this).val())
            $(this).parent().parent("tr").find("td .total_amount").html(total_amount);
          })
       })
   