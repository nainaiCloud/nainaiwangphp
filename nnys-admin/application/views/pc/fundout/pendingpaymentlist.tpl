
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 线下出金</h1>
<div class="bloc">
    <div class="title">
        待打款列表
    </div>
    <div class="content">
        <div class="pd-20">
			{include:layout/search.tpl}
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="checkall" value=""></th>
				<th width="60">会员号</th>
				<th width="70">用户名</th>
				<th width="90">订单号</th>
				<th width="60">金额</th>
				<th width="50">状态</th>
				<th width="100">时间</th>
				<th width='100'>操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">
				<td><input type="checkbox" value="" name="check"></td>
				<td>{$item['user_no']}</td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['username']}</u></td>
				<td>{$item['request_no']}</td>
				<td>{$item['amount']}</td>
				<td>{$item['status_text']}</td>
				<td>{$item['create_time']}</td>
				<td class="td-manage">
					<a title="审核" href="{url:/balance/fundOut/fundOutEdit}?id={$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
					<a title="删除" href="javascript:void(0);" ajax_status=-1 ajax_url="{url:/balance/fundOut/del}?id={$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>