
<!--主要内容 开始-->
    <div id="mainContent">
        <div class="page_width">
        <div class="mainRow1">
<div class="user_c">
     <div class="user_zhxi">
          <div class="zhxi_tit">
               <p>操作状态</p>
          </div>
          
       <div class="opera_suc">
          <div class="oprsuc_img"><img src="{views:images/icon/suc_fail.jpg}" alt="正确"></div>
          <h3 class="change_red">{$info}</h3>
         <h5><a href="javascript:history.back()">返回上个页面&gt;&gt;</a> <a href="user_index.html">返回个人中心&gt;&gt;</a></h5>
       </div>



     </div>
</div>
                </div>


<script type="text/javascript">
  $(function(){
    var redirect = "{$redirect}";
    console.log(redirect);

  })
</script>