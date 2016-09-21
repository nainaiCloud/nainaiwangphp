
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 结算管理</h1>
<div class="bloc">
    <div class="title">
        收费明细列表
    </div>
    <div class="content">
        <div class="pd-20">
			{include:layout/search.tpl}

	 <!-- <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash fa-trash"></i>批量删除</a> <a class="btn btn-primary radius" href="{url:/system/admin/adminAdd}"><i class=" icon-plus fa-plus"></i> 添加管理员</a> </span>  </div> -->
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="" value=""></th> -->
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="100">订单类型</th>
				<th width="100">收费类别</th>
				<th width="100">金额</th>
				<th width="150">所属订单</th>
				<th width="130">时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name=""></td> -->
				<td>{$item['id']}</td>
				<td>{$item['username']}</td>
				<td>{$item['mode_text']}</td>
				<td>{$item['charge_type_text']}</td>
				<td>{$item['num']}</td>
				<td>{$item['order_no']}</td>
				<td>{$item['create_time']}</td>
				
				<td class="td-manage">
					
				 <a title="详情" href="{url:/balance/paytoMarket/detail}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
				 </td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>
<script type="text/javascript">
	;$(function(){
		$('.search-admin').click(function(){
			var name = $(this).siblings('input').val();
			window.location.href = "{url:/balance/paytoMarket/index}"+"?name="+name;
		});
	})
</script>



