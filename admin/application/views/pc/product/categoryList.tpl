﻿
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 分类管理</h1>
<div class="bloc">
    <div class="title">
        分类列表
    </div>
    <div class="content">
        <div class="pd-20">

	 <div class="cl pd-5 bg-1 bk-gray">
		 <span class="l">
			 <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
				 <i class="icon-trash"></i>批量删除
			 </a>
			 <a class="btn btn-primary radius" href="{url:/product/categoryAdd}">
				 <i class=" icon-plus"></i> 添加分类
			 </a>
		 </span>

	 </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="100">名称</th>
				<th width="90">属性</th>
				<th width="150">排序</th>
				<th width="70">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$cate}
			<tr class="text-c">
				<td><input type="checkbox" value="" name=""></td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>

				<td>{$item['attrs']}</td>
				<td>{$item['sort']}</td>
				<td class="td-status"><span class="label label-success radius">已启用</span></td>
				<td class="td-manage"><a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用"><i class="icon-pause"></i></a> <a title="编辑" href="{url:/product/categoryAdd?cid=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit"></i></a> <a style="text-decoration:none" class="ml-5"  href="javascript:;" title="修改密码"><i class="icon-unlock"></i></a> <a title="删除" href="javascript:;" onclick="member_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$bar}
	</div>
</div>