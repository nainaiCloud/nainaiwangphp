
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 银行流水</h1>
<div class="bloc">
    <div class="title">
        银行流水列表
    </div>
    <div class="content">
        <div class="pd-20">
			<div class="cl pd-5 bg-1 bk-gray"> <span class="l">
                    <a class="btn btn-primary radius" href="{url:/balance/fundin/bankflowadd}"><i class=" icon-plus fa-plus"></i> 添加流水
                    </a>

                </span>
			</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="60">用户账号</th>
				<th width="70">户名</th>
				<th width="60">金额</th>
				<th width="150">流水号</th>
				<th width="100">日期</th>
				<th width="100">图片</th>
				<th width='100'>操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['data']}
			<tr class="text-c">
				<td>{$item['OP_ACCT_NO_32']}</td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['OP_CUST_NAME']}</u></td>
				<td>{$item['TX_AMT']}</td>
				<td>{$item['TX_LOG_NO']}</td>
				<td>{$item['TX_DT']}</td>
				<td><a href="{$item['img']}" ><img height="50" src="{$item['img']}" /></a></td>
				<td class="td-manage">
					<a title="删除" ajax_status=-1 ajax_url="{url:balance/fundin/bankflowdel}?id={$item['id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>

