<!--   <link rel="stylesheet" href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/H-ui.min.css" />
 -->
                
        <!--            
              CONTENT 
                        --> 
<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 假日管理</h1>
<div class="bloc">
    <div class="title">
      假日信息列表
    </div>
    <div class="content">
        <div class="pd-20">
            <form action="" method="get" >
                <div class="text-c">
                    <select name="bank" >
                        <option value="all">所有银行</option>
                        <option value="js" {if:$bank=='js'}selected{/if}>建设银行</option>
                        <option value="gd" {if:$bank=='gd'}selected{/if}>光大银行</option>
                    </select>
                    <button type="submit" class="btn btn-success radius" id="" name=""><i class="icon-search fa-search"></i> 搜索</button>

                </div>
            </form>

            <div class="cl pd-5 bg-1 bk-gray"> <span class="l">
                    <a class="btn btn-primary radius" href="{url:/system/confsystem/workdayadd}"><i class=" icon-plus fa-plus"></i> 添加假日
                    </a>

                    <a class="btn btn-primary radius" href="{url:/system/confsystem/workdaycopy}"><i class=" "></i> 复制假日
                    </a>
                </span>
            </div>

        </div>
		 <table class="table table-border table-bordered table-hover table-bg">
        <thead>
            <tr>
                <th scope="col" colspan="12">假日信息</th>
            </tr>
            <tr class="text-c">

                <th>银行</th>
                <th>日期</th>
                <th>休息/工作</th>
                <th>操作</th>
            </tr>
             <tbody>
             {foreach:items=$data}
             <tr class="text-c">
                 <td>{$item['bank']}</td>
                 <td>{$item['day']}</td>
                 <td>{if:$item['type']==1}休假{else:}工作{/if}</td>
                 <td class="td-manage">

                     <a title="删除" ajax_status=-1 ajax_url="{url:system/confsystem/workdaydel}?id={$item['id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a>
                 </td>
             </tr>
             {/foreach}
             </tbody>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>

