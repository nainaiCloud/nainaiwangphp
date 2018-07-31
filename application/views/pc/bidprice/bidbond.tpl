<link rel="stylesheet" type="text/css" href="{views:css/bidprice.css}">
<div id="mainContent" class="">
	<div class="page_width">
		<div class="bidpriceContent">
			<div class="bidpriceTop">
                <a href="">竞价</a> &gt; <a>竞价商品详情</a> &gt; <a>缴纳保证金</a> 
			</div>
			<div class="bidbond">
				<div class="bidbond_top clear">
					<div class="bidbond_left">
						<div class="bidbondname">竞价物品名称：<span class="bzjProduct"></span></div>
						<div class="bidbondprice">
							需要缴纳保证金：<span>￥<span class="bzjPrice"></span>元</span>
						</div>
					</div>
					<div class="bidbond_right">
						<div class="bidbondsm clear">
							<span>说明：</span>
							<div class="sm_con">
								<p>1、此保证金仅适用于该竞价商品</p>
								<p>2、竞价结束后1个工作日内原路退回</p>
								<p>3、若竞价成功，需要2个小时内支付全部货款，否则保证金相应扣除作为违约赔付</p>
							</div>
						</div>
					</div>
				</div>
				<div class="bidBond_cont clear">
					<div class="bidbond_left">
						<div class="bidbondtitle">转账人信息</div>
						 <input type="hidden" name="bidInfo" value="{url:/offers/jingjiadeposit}">
                		 <input type="hidden" name="bidyz" value="{url:/ajaxdata/alrealyDeposit}">
						<div id="BankInfo"></div>
						<script type="text/html" id="banktemplat">
							<% if(bankInfo!=null) { %>
							<!-- 若用户有过转账信息则显示已有的账户信息 -->
							<div class="bidbondInfo">
			
								<div class="bidbondInput">
									<span class="spanName">转账用户名称:</span>
									<span class="spanCont"><%=bankInfo.true_name%></span>
									
								</div>
								<div class="bidbondInput">
									<span class="spanName">开户银行:</span>
									<span class="spanCont"><%=bankInfo.bank_name%></span>
									
								</div>
								<div class="bidbondInput">
									<span class="spanName">开户银行账号:</span>
									<span class="spanCont"><%=bankInfo.card_no%></span>
							
								</div>
								<div class="bidbond_btn">
									<input class="submitIn" type="button" value="缴纳完成" name="bankBut">
								</div>
							</div>
							<!-- 若用户有过转账信息则显示已有的账户信息 end-->
							
							<% } %>
			
							
						</script>
						
					</div>
					<div class="bidbond_right">
						<div class="bidbondtitle">收款人信息</div>
						<div class="bidbondInfo">
							<div class="bidbondInput">
								<span class="spanName">收款用户名称:</span>
								<span class="spanCont">耐耐云商科技有限公司</span>
							</div>
							<div class="bidbondInput">
								<span class="spanName">开户银行1:</span>
								<span class="spanCont">中国光大银行山西阳泉支行</span>
							</div>
							<div class="bidbondInput">
								<span class="spanName">开户银行账号:</span>
								<span class="spanCont">75410188000114781</span>
							</div>
							<div style="height: 40px;width: 0px;"></div>
							<div class="bidbondInput">
								<span class="spanName">开户银行2:</span>
								<span class="spanCont">建设银行河南省分行营业部</span>
							</div>
							<div class="bidbondInput">
								<span class="spanName">开户银行账号:</span>
								<span class="spanCont">41050100360800000080</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{views:js/bidBond.js}"></script>
<!-- 遮罩层 -->
<div class="bidbond_result">
	<div class="mark"></div>
	<div class="result">
		<div class="result_title">
			提示
			<i class="close"></i>
		</div>
		<div class="tipCont">
			
		</div>
		<!-- <div id="resule_success" class="result_cont">
			<div class="result_img"><img src="{views:images/icon/successIcon.png}"/></div>
			<div class="result_tip">恭喜，您的保证金已缴纳成功，现在可以去竞价！</div>
			<div class="result_tip success_tip">系统将自动在3秒内跳转到竞价页面</div>
		</div>
		<div id="resule_fail" class="result_cont" style="display: none;">
			<div class="result_img"><img src="{views:images/icon/failIcon.png}"/></div>
			<div class="result_tip">很抱歉，系统未收到帐的保证金，请先进行保证金缴纳！</div>
			<div class="result_tip fail_tip">若有疑问，联系客服热线400-6238086</div>
		</div> -->
		<!-- 未开户提示信息 -->
		<!-- <div id="resule_fail" class="result_cont" style="display: none;">
			<div class="result_img"><img src="{views:images/icon/money_icon.png}"/></div>
			<div class="result_tip">很抱歉，您还未开户，需要开户后才能缴纳保证金！</div>
			<div class="result_tip">缴纳保证金必须使用开户账号关联的银行账户进行汇款</div>
			<div class="result_tip success_tip">系统将自动在3秒后跳转去开户</div>
		</div> -->
		<!-- 未开户提示信息 end -->
	</div>
</div>