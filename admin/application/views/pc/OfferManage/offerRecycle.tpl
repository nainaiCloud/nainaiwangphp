    
        <!--            
              CONTENT 
                        --> 
<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 报盘信息</h1>
<div class="bloc">
    <div class="title">
     垃圾箱
    </div>
    <div class="content">
        <div class="pd-20">
			 <div class="text-c"> 
			<input type="text" class="input-text" style="width:250px" placeholder="输入标号" id="" name="">
			<button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜标号</button>
		</div>
			<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"></span> <span class="r">共有数据：<strong>{$count}</strong> 条</span> </div>
    <table class="table table-border table-bordered table-hover table-bg">
        <thead>
            <tr>
                <th scope="col" colspan="12">报盘信息</th>
            </tr>
            <tr class="text-c">
                <th><input type="checkbox" value="" name=""></th>
                <th>ID</th>
                <th >标的编号</th>
                <th>客户编码</th>
                <th>委托方</th>
                <th>交易方式</th>
                <th>可否拆分</th>
                <th>数量</th>
                <th>挂牌价</th>
                <th>状态</th>
                <th>类型</th>
				<th>操作</th>
            </tr>
        </thead>
        <tbody>
            {foreach:items=$data}
                <tr class="text-c">
                    <td><input type="checkbox" value="" name=""></td>
                    <td>{$item['id']}</td>
                    <td>DG0020160405000002</td>
                    <td>02100078</td>
                    <td><a href="#">{$item['username']}</a></td>
                    <td>采购</td>
                    <td>{if:$item['divide'] == 0}可拆分{else:}否{/if}</td>
                    <td>{$item['minimum']}</td>
                    <td>{$item['price']}</td>
                    <td>已删除</td>
                    <td>{if:$item['mode']==1}自由{elseif:$item['mode']==2}保证金{elseif:$item['mode']==3}仓单{/if}</td>
                     <td class="td-manage"> <a title="查看" href="{url:/trade/OfferManage/offerDetails}id/{$item['id']}/user/{$item['username']}" class="ml-5" style="text-decoration:none"><i class="icon-eye-open"></i></a> <a title="恢复" href="javascript:;" ajax_status=1 ajax_url="{url:/trade/OfferManage/setStatus}id/{$item['id']}" to_list=1 class="ml-5" style="text-decoration:none"><i class="icon-trash"></i></a></td>
                </tr>
           {/foreach}
           
        </tbody>
    </table>
</div>


     
        
    </body>
</html>