
			<!--start中间内容-->	
            <style type="text/css">
                .bid .bid_cont{margin: 0 100px;float: left;width: 300px;height: 105px;}
                .bid .bid_cont p{font-size: 16px;}
                .bid .bid_cont p span{font-size: 16px;}
            </style>
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>我的招标</a>><a>发布招标</a></p>
					</div>
					<div class="center_tabl">
                                                            <ul class="step_list">
                                                                <li class="step">
                                                                    <span class="val_on on">1</span>
                                                                    <p class="step_name">
                                                                        <span class="on">选择招标类型</span>
                                                                    </p>
                                                                </li>
                                                                <li class="step">                                                                    
                                                                    <span class="val_on on">2</span>
                                                                    <p class="step_name">
                                                                        <span class="on">上传招标文件</span>
                                                                    </p>
                                                                </li>
                                                                <li class="step">                                                                    
                                                                    <span class="val_on on">3</span>
                                                                    <p class="step_name">
                                                                        <span class="on">填写招标公告</span>
                                                                    </p>
                                                                </li>
                                                                <li class="step">                                                                    
                                                                    <span class="val_on on">4</span>
                                                                    <p class="step_name">
                                                                        <span class="on">提交保证金，发布招标</span>
                                                                    </p>
                                                                </li>
                                                            </ul>

                                                            <div class="clear"></div>

                                                            <form method="post" action="{url:/bid/bidRelease}" auto_submit="1">
                                                                <input type="hidden" name="bid_id" value="{$data['id']}" />
                                                            <div class="bid" style="margin-top:30px;">
                                                                <div class="bid_cont" >
                                                                    <p>
                                                                        <span>招标类型：</span>{$data['mode_text']}
                                                                    </p>
                                                                    <p>
                                                                        <span>项目名称：</span>{$data['pro_name']}
                                                                    </p>
                                                                    <p>
                                                                        <span>所&nbsp;&nbsp;在&nbsp;&nbsp;地：</span>{$data['address']}
                                                                    </p>
                                                                </div>
                                                                <div class="bid_bond">
                                                                    <h3>招标保证金</h3>
                                                                    <p class="bond">￥{$data['bail']}元</p>
                                                                    <ul class="tip">
                                                                        <li>请确信账户内金额足够支付保证金</li>
                                                                        <li>若余额不足请先<a href="{url:/fund/cz}" class="1a59d9">充值</a></li>
                                                                        <li>保证金将于招投标结束后返还</li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="clear"></div>

                                                            <div class="button"><button style="margin:0;">发布</button></div>
                                                        </form>
                                                        </div>
				</div>
			</div>
			<!--end中间内容-->	
			<!--start右侧广告			
			<div class="user_r">
				<div class="wrap_con">
					<div class="tit clearfix">
						<h3>公告</h3>
					</div>
					<div class="con">
						<div class="con_medal clearfix">
							<ul>
								<li><a>暂无勋章</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--end右侧广告-->
