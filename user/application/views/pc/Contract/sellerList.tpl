	
			<!--start中间内容-->	
			<div class="user_c_list">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>合同管理</a>><a>销售合同</a></p>
					</div>
					<div class="chp_xx">
						<div class="xx_top">
							<form action="{url:/Contract/depositList}" method="post" name="">
								<ul>
									<li>名称：<input id="warename" name="name" value="" type="text"></li>
									<li>发布状态：
									<select id="classcode" name="classcode">
									<option value="">--全部--</option>
									<option value="">审核中</option>
									<option value="">发布成功</option>
									<option value="">被驳回</option>
									<option value="">已过期</option>
									</select></li>
									<li>时间：<input class="Wdate" type="text" onclick="WdatePicker()"> <span style="position: relative;left: -3px;">—</span><input class="Wdate" type="text" onclick="WdatePicker()">
									</li>
									<li> <a class="chaz" onclick="javascript:$('form').submit();">查找</a></li>
								</ul>
							</form>
							<div style="clear:both;"></div>
						</div>
						<div class="xx_center">
							<table class="sales_table" border="0"  cellpadding="0" cellspacing="0">
								<tr class="first_tr">
									<td width="80px"><input onclick="selectAll1();" name="controlAll" style="controlAll" id="controlAll" type="checkbox">全选
									</td>
									<td width="180px">产品详情</td>
									<th width="260px">金额及付款方式</th>
									<th width="200px">主要指标</td>
									<th>买家信息</th>
									<th>交易操作</th>
								</tr>
                                <tr>
									<td colspan="6">&nbsp;</td>
								</tr>
                                
								
                                {foreach:items=$data}
									<tr class="title">
										<td colspan="6">
											<input id="controlAll" type="checkbox">
											单号:<a href="{url:/contract/sellerDetail?id=$item['id']}"><span class="col2517EF">{$item['order_no']}</span></a>
											<span class="colaa0707 ht_padd"></span>
											<span><img class="middle_img" src="{views:images/center/ico_cj.jpg}">{if:$item['company_name']}购买单位：{$item['company_name']}{else:}购买个人：{$item['true_name']}{/if}</span>
											<span class="ht_padd">
												<!-- <img class="middle_img" src="{views:images/center/ico_kf.png}">  客服 -->
											</span>
										</td>
										
										<td colspan="3"></td>
									</tr>
									<tr>
										<td colspan="2">
											<img class="middle_img" src="{views:images/banner/551b861eNe1c401dc.jpg}" align="left" width="100px"/>
											<div class="div_height">&nbsp;{$item['product_name']}</div>
											<!-- <div class="div_height">&nbsp;是否含税：是</div>
											<div class="div_height">&nbsp;是否含保险：是</div> -->
											{if:isset($item['store_name']) && $item['mode'] == \nainai\order\Order::ORDER_STORE}
											<div class="div_height">&nbsp;所在地：{$item['store_name']}</div>
											{/if}
										</td>
										<td>
											<div class="div_heights colaa0707">合同总额：￥{$item['amount']}</div>
											<!-- <div class="div_heights colA39F9F">等级折扣：￥10.00</div> -->
											<div class="hr"></div>
											<!-- <div class="div_heights">保证金支付（{$item['percent']}%）</div> -->

										</td>
										<td>
											<!-- <div class="div_heights">规格：230*114*65</div> -->
											<!-- <div class="div_heights">材质：高铝质</div> -->
											<div class="div_heights">数量：{$item['num']}{$item['unit']}</div>
										</td>
										<td>
											<div class="div_heights">{$item['username']} <i class="icon-user-md "></i></div>
										</td>
										<td>
											
											<div class="div_heights">
												{if:$item['action_href']}
													<a href='{$item['action_href']}'><b>{$item['action']}<b></a>
												{else:}
													{$item['action']}
												{/if}
											</div>
										</td>
									</tr>
								{/foreach}
										
							</table>

						</div>
						
						<div class="page_num">
							<!-- 共0条记录&nbsp;当前第<font color="#FF0000">1</font>/0页&nbsp;
							<a href="#">第一页</a>&nbsp;
							<a href="#">上一页</a>&nbsp;
							<a href="#">下一页</a>&nbsp;
							<a href="#">最后页</a>&nbsp; 
							跳转到第 <input name="pagefind" id="pagefind" type="text" style="width:20px;font-size: 12px;" maxlength="5" value="1"> 页 
							<a><span class="style1">确定</span></a> -->

							{$page}
						</div>

					</div>
				</div>
				
				
			</div>
			<!--end中间内容-->	