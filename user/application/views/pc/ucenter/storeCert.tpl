
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{views:js/upload.js}"></script>
<script type="text/javascript" src="{views:js/cert/cert.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
			<div class="user_c">
				<div class="user_zhxi">

					<div class="zhxi_tit">
						<p><a>账号管理</a>><a>身份认证</a>><a>仓库管理员认证</a></p>
					</div>
					<div class="rz_title">
						<ul class="rz_ul">
							<li class="rz_start"></li>
							<li class="rz_li cur"><a class="rz">选择仓库</a></li>
							<li class="rz_li"><a class="yz">认证信息</a></li>
							<li class="rz_li"><a class="shjg">审核结果</a></li>
							<li class="rz_end"></li>
						</ul>

					</div>
					<form method="post" action="{url:/ucenter/doStoreCert}" auto_submit>
						<div class="re_xx">
								<div class="zhxi_con">
									<span class="con_tit"><i></i>选择仓库：</span>
									<span><select name="store_id" datatype="/[1-9][0-9]*/" errormsg="请选择仓库">
											<option value="0" >请选择</option>
											{foreach:items=$store}
												<option value="{$item['id']}" {if:isset($store_id) && $store_id==$item['id']}selected{/if}>{$item['name']}</option>
											{/foreach}
										</select>
									</span>
									<span></span>


								</div>
							<div class="zhxi_con">
								<span ><input class="submit" type="button" id="next_step"  value="下一步"/></span>
							</div>

						</div>

					<div class="yz_img">

						<!--公司信息-->
						{if:$userType==1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>公司名：</span>
								<span>
									<input class="text" type="text" name="company_name" datatype="zh2-9" errormsg="请输入2-30个字符" value="{$certData['company_name']}"/>
								</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>法定代表人：</span>

							<span>
								<input class="text" type="text" name="legal_person" datatype="s2-30" errormsg="请输入2-30个字符" value="{$certData['legal_person']}"/>
							</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系人：</span>
							<span>
								<input class="text" type="text" name="contact" datatype="s2-30" errormsg="请输入2-30个字符" value="{$certData['contact']}"/>
							</span>
								<span></span>
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系电话：</span>
							<span>
								<input class="text" type="text" name="phone" datatype="n6-16" errormsg="请正确填写手机号" value="{$certData['contact_phone']}"/>
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地区：</span>
							<span>
								{area:data=$certData['area'] }
							</span><span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>详细地址：</span>
							<span>
								<input class="text" type="text" name="address" datatype="s2-100" errormsg="请正确填写地址" value="{$certData['address']}"/>
							</span>
							</div>



						{else:}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>真实姓名：</span>
								<span>
									<input class="text" type="text" name="true_name" datatype="s2-30" errormsg="请输入2-30个字符" value="{$certData['true_name']}"/>
								</span>
								<span></span>
							</div>


							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地区：</span>
							<span>
								{area:data=$certData['area']}
							</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>详细地址：</span>
							<span>
								<input class="text" name="address" type="text" datatype="s2-100" errormsg="请正确填写地址" value="{$certData['address']}"/>
							</span>
							</div>


						{/if}

						<div class="zhxi_con">
							<span><input class="submit"  type="submit" value="提交审核"></span>
						</div>

					</div>


					</form>
					<div class="sh_jg">
						<div class="success_text">
							<p><b class="b_size">认证状态：{$certShow['status_text']}</b></p>
							<p>{$certData['message']}</p>
							{if:$certShow['button_show']===true}
							<p>您还可以进行以下操作:</p>
							<p><a class="look" href="javascript:void(0)" onclick="nextTab(1)">{$certShow['button_text']}</a>
							{/if}
						</div>
					</div>
				</form>
				</div>
			</div>
<script type="text/javascript">
	$(function(){
		nextTab({$certShow['step']});
	})
</script>