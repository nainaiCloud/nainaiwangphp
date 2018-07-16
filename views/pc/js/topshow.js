/**
 * Created by Administrator on 2018/3/8 0008.
 */
var  AsyncCheck = function(){
    this.callbackArr = [];
    this.checkLogin = function(){
        var callbacks = this.callbackArr;
        $.ajax({
            'url' :  $('input[name=checkLogin]').val(),
            'type' : 'post',
            'async':true,
            'dataType': 'json',
            success: function (data) {
                if(callbacks.length>0){
                    for(var item in callbacks){
                        callbacks[item](data)
                    }
                }
            }
            /**
             * ����json���£�
             * {
             *   login : 1 #�ѵ�¼
             *   username:
             *   user_id:
             *   cert:{
             *      deal : 1 #��������֤״̬
             *      store:1 #�ֹ���֤
             *      vip:1 #�Ƿ���vip
             *   }
             *   mess : #��Ϣ����
             *
             * }
             */
        })
    };

    this.pushCallback = function(func){
        this.callbackArr.push(func);
    }

};

var checkLogin = new AsyncCheck();

/**
 * ��ȡͷ�����û���¼��Ϣ
 * @param data
 */
 function getUser(data){
    if(data.login===1){
        var topHtml = template.render('topBarTemplate',{data:data});
        $('#topBox').html(topHtml);
    }
}
checkLogin.pushCallback(getUser);

 $(function(){
     checkLogin.checkLogin();
 });





