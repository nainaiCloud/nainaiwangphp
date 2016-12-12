
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 仓库管理员认证</h1>
<div class="bloc">
    <div class="title">
        会员认证
    </div>
    <div class="content">
        <div class="pd-20">
            {include:layout/search.tpl}
           <table class="table table-border table-bordered table-hover table-bg">
        <thead>
            <tr>
                <th scope="col" colspan="9">会员账户</th>
            </tr>
            <tr class="text-c">
                <!--<th><input type="checkbox" value="" name="checkall"></th>-->
                <th>ID</th>
                <th >登录账号</th>
                <th>会员类型</th>
                <th>手机号</th>
                <th>认证仓库</th>
				<th>认证状态</th>
				<th>申请时间</th>
				<th>操作</th>
            </tr>
        </thead>
        <tbody>
        {foreach:items=$data['list']}
            <tr class="text-c">
               <!-- <td><input type="checkbox" value="" name="check"></td>-->
                <td>{$item['id']}</td>
                <td>{$item['username']}</td>
                <td>{echo:\nainai\member::getType($item['type'])}</td>
                <td>{$item['mobile']}</td>
                <td>{$item['store_name']}</td>
				<td>{echo:\nainai\cert\certDealer::getStatusText($item['status'])}</td>
				<td>{$item['apply_time']}</td>

                <td class="f-14"><a title="编辑" href="{url:member/certManage/storecertDetail?uid=$item['id']}"  style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> </td>
				
            </tr>
        {/foreach}

        </tbody>
    </table>
        </div>
        {$data['bar']}
    </div>
</div>


     
        
