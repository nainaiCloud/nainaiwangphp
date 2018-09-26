<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<div id="content" class="white">
<h1><img src="{views:img/icons/posts.png}" alt="" /> 合同管理</h1>
<div class="bloc">
    <div class="title">
        合同列表
    </div>
    <div class="content">
        <div class="pd-20">
	{include:layout/search.tpl}
	</div>
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash fa-trash"></i>批量删除</a>  --> </span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="checkall" value=""></th> -->
				
				<th width="100">订单编号</th>
				<th width="100">合同开始日期</th>
				<th width="100">合同完成日期</th>
				<th width="100">商品名称</th>
				<th width="100">买方名称</th>
				<th width="100">卖方名称</th>
				<th width="100">交易方式</th>
				<th width="100">报盘方式</th>
				<th width="100">子报盘方式</th>
				<th width="100">支付方式</th>
				<th width="100">成交数量</th>
				<th width="100">合同金额</th>
				<th width="100">质量扣款金额</th>
				<th width="100">结算金额</th>
				<th width="100">合同状态</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name="check"></td> -->
				
				<td>{$item['order_no']}</td>
				<td>{$item['create_time']}</td>
				<td>{$item['end_time']}</td>
				<td>{$item['product_name']}</td>
				<td>{$item['buyer_name']}</td>
				<td>{$item['seller_name']}</td>
				<td>{$item['type_txt']}</td>
				<td>{$item['mode_txt']}</td>
				<td>{$item['submode_txt']}</td>
				<td>{if:$item['mode']==1}
                       线下支付
				    {/if}
				</td>
				<td>{$item['num']}{$item['unit']}</td>
				<td>{$item['amount']}</td>
				<td>{$item['reduce_amount']}</td>
				<td>{$item['account']}</td>
				<td>{$item['title']}</td>
				
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
			window.location.href = "{url:/trade/pairing/allcontractList}"+"/name/"+name;
		});
	})
</script>



