
<script src="{views:js/jquery-1.9.1.min.js}" type="text/javascript" language="javascript"></script>


用户名：<input type="text" name="username" />
支付金额：<input type="text" name="amount" />
<button type="button" >支付</button>

<script type="text/javascript">

    var url = '{url:/test/jsMock}';
    $('button').on('click',function(){
        var name = $('input[name=username]').val();
        var amount = $('input[name=amount]').val();
        var sendData = {username:name,amount:amount};
        $.ajax({
            type:'post',
            url:url,
            data:sendData,
            dataType:'json',
            success : function(data){
                console.log(JSON.stringify(data));
                if(data.success==1){
                    alert('成功');
                }else{
                    alert('失败');
                }
            }
        });
    })


</script>
