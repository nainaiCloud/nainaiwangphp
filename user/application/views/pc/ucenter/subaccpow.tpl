
<style type="text/css">
	.node_tree li {float: left;text-decoration: none;list-style: none;}
	.clearfix{clear: left;}
	.node_tree .v1{background-color: #14A8FF;border: 1px solid #ddd;padding: 3px 6px;color: #fff;border-radius: 3px;font-weight: border;margin-bottom: 5px;margin-top: 5px;}
	.node_tree .v2{text-indent: 2em;font-weight: bolder;}
	.node_tree .v3{padding-left: 50px;}
	.v3_li{position: relative;padding-left: 25px;}
	b.del{cursor: pointer;}
</style>
<div class="user_c">
	<div class="user_zhxi">
		<div class="zhxi_tit">
			<p>{$navi}</p>
		</div>
		<div class="xx_center">
		<form action="{url:/ucenter/subaccpow}" method="post" class="form form-horizontal" id="form-access-add" no_redirect="1" auto_submit>
			<div class='node_tree'>
				<input type="hidden" name="id" value="{$roleInfo['id']}" />
				{foreach:$items=$lists key=$k}
				<!-- 模块 -->
				<div class='root'>
					<div class='v1'><input type="checkbox" name="menuIds[]" value="{$item['id']}" {if: !empty($roleInfo['gid']) && in_array($item['id'],$roleInfo['gid'])}checked='checked'{/if}/>&nbsp;{$item['title']}</div>
					{foreach:$items=$item['list'] item=$v1 key=$k1}
					<!-- 控制器 -->
						<div class='controller'>
							<div class='v2'><span><input type="checkbox" name="menuIds[]" value="{$v1['id']}" {if: !empty($roleInfo['gid']) && in_array($v1['id'],$roleInfo['gid'])}checked='checked'{/if}/>&nbsp;{$v1['title']}</span>
							</div>
							<div class='v3'>
								{foreach:$items=$v1['list'] item=$v2 key=$k2}
									<ul>
									<div class='ins'><input type="checkbox" {if: !empty($roleInfo['gid']) && in_array($v2['id'],$roleInfo['gid'])}checked='checked'{/if} name="menuIds[]" value="{$v2['id']}" />&nbsp;[{$v2['title']}]</div>
									<!-- action -->
									{foreach:$items=$v2['list'] item=$v3 }
										<li class='v3_li'>
											<input type="checkbox" name="menuIds[]" value="{$v3['id']}"  {if: !empty($roleInfo['gid']) && in_array($v3['id'],$roleInfo['gid'])}checked='checked'{/if}/>&nbsp;{$v3['title']}
										</li>
									{/foreach}
									</ul>	
									<div class='clearfix'></div>
								{/foreach}
								
							</div>
							<div class='clearfix'></div>
						</div>
					{/foreach}
				</div>
				{/foreach}
			</div>
			<div class="col-9 col-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	;$(function(){
		$(".ins").each(function(){
			var _this = this;
			$(this).siblings("li").each(function(i){
				var bo = $(this).find(":checkbox").is(":checked");
				if(bo){
					$(_this).find(":checkbox").prop("checked",true);
				}
			});
		});


		$('.v1 :checkbox').unbind('click').click(function(){
			$(this).parent().siblings('.controller').find('.v3 :checkbox,.v2 :checkbox').prop("checked",this.checked);
		});

		$('.v2 :checkbox').click(function(){
			$(this).parents('.controller').find('.v3 :checkbox').prop("checked",this.checked);
			if($(this).is(":checked")){
				$(this).parents('.root').find('.v1 :checkbox').prop('checked',true);
			}
		});

		$('.v3 li :checkbox').click(function(){
			if($(this).is(":checked")){
				$(this).parents('.controller').find('.v2 :checkbox').prop('checked',true);
				$(this).parents('.root').find('.v1 :checkbox').prop('checked',true);
				$(this).parents('ul').find('.ins :checkbox').prop('checked',true);
			}
		});

		$('.ins :checkbox').click(function(){
			$(this).parents('ul').find(':checkbox').prop("checked",this.checked);
			if($(this).is(":checked")){
				$(this).parents('.root').find('.v1 :checkbox').prop('checked',true);
				$(this).parents('.v3').siblings('.v2').find(':checkbox').prop('checked',true);
			}
		});

		var url = "{url:/system/rbac/accessList}";
		//切换角色
		$('.roles').change(function(){
			var role_id = $(this).val();
			var rec_url = url+'?role_id='+role_id;
			window.location.href=rec_url;
		});



		$('b.del').click(function(){
			var _this = $(this);
			var url = "{url:system/rbac/nodeDel}";
			layer.confirm('确认删除',{
				shade:false
			},function(){
				layer.closeAll();
				layer.load(2);
				var node_id = _this.attr('node_id');

				$.ajax({
					type:'post',
					data:{node_id:node_id},
					url:url,
					success:function(data){
						layer.closeAll();
						
						if(data.success == 1){
							window.location.reload();
						}else{
							layer.msg(data.info);
						}

					},
					error:function(){
						layer.closeAll();
						layer.msg('服务器错误');
					},
					dataType:'json'
				});
			});
		});
	})

</script>






