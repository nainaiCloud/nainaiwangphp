<!--start中间内容-->
<div class="user_c">
    <div class="user_zhxi">
        <div class="zhxi_tit">
            <p><a>申述管理</a>><a>申述列表</a></p>
        </div>
        <div class="chp_xx">
            <!--<form action="{url:contract/complainList}" method="POST">
                <div class="text-c"> 订单号：
                    <input type="text" class="input-text" style="width:250px" placeholder="输入订单号" id="" name="order_no" value="{$order_no}">
                    <button type="submit" class="btn btn-success radius" id="" name="">搜申述</button>
                </div>
            </form>-->
            <br />
            <div class="xx_center">

                <table border="0"  cellpadding="" cellspacing="">
                    <tr class="title">
                        <td>订单号</td>
                        <td>申述类型</td>
                        <td>申述标题</td>
                        <td>凭证图片</td>
                        <td>申述时间</td>
                        <td>申述状态</td>
                        <td>操作</td>
                    </tr>
                    {foreach:  items=$complainList item=$list}

                        <tr>
                            <td>{$list['order_no']}</td>
                            <td>{$list['type']}</td>
                            <td>{$list['title']}</td>
                            <td>
                                <ul>
                                    {foreach: items=$list['proof']  item=$img}
                                        <li><img src="{$img}"></li>
                                    {/foreach}
                                </ul>
                            </td>
                            <td>{$list['apply_time']}</td>
                            <td>{$list['status']}</td>


                            <td><a href='{url:/Contract/complainDetail?id=$list['id']}'>查看详情</a></td>

                        </tr>
                    {/foreach}
                </table>

            </div>

            <!-- <div class="tab_bt">
                <div class="t_bt">
                    <a class="a_1" title="编辑" href="user_cd.html"></a>
                    <a class="a_2" title="添加" href="user_cd.html"></a>
                    <a class="a_3" title="删除" href="user_cd.html"></a>
                </div>
            </div> -->
            <div class="page_num">
                <!-- 							共0条记录&nbsp;当前第<font color="#FF0000">1</font>/0页&nbsp;
                <a href="#">第一页</a>&nbsp;
                <a href="#">上一页</a>&nbsp;
                <a href="#">下一页</a>&nbsp;
                <a href="#">最后页</a>&nbsp;
                跳转到第 <input name="pagefind" id="pagefind" type="text" style="width:20px;font-size: 12px;" maxlength="5" value="1"> 页
                <a><span class="style1">确定</span></a> -->
                {$pageHtml}
            </div>
        </div>
    </div>


</div>