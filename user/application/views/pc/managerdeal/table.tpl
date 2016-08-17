<!DOCTYPE html>
<html>
<head>
  <title>仓单管理</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  <link href="{views:css/table.css}" rel="stylesheet" type="text/css" />
</head>
<body>
  <!-- 表格详情样式 strat-->
  <div class="details">
    <div class="detail_title">
      <strong>仓单详情 </strong>
    </div>
    <div class="table_details">
      <table cellpadding="0"cellspacing="0">
        <tr class="tr_title">
          <td  colspan="2"><span>入库详细信息</span></td>
        </tr>
        <tr>
          <td><span>仓库名称</span></td>
          <td><span>{$storeDetail['sname']}</span></td>
        </tr>
        <tr>
          <td><span>状态</span></td>
          <td><span>{$storeDetail['status_txt']}</span></td>
        </tr>
        <tr>
          <td><span>库位</span></td>
          <td><span> {$storeDetail['store_pos']}</span></td>
        </tr>
        <tr>
          <td><span>仓位</span></td>
          <td><span>{$storeDetail['cang_pos']}</span></td>
        </tr>
        <tr>
          <td><span>租库价格</span></td>
          <td><span>{$storeDetail['store_price']}（/{$storeDetail['unit']}/天）</span></td>
        </tr>
        <tr>
          <td><span>签发时间</span></td>
          <td><span>{$storeDetail['sign_time']}</span></td>
        </tr>
        <tr>
          <td><span>用户确认时间：</span></td>
          <td><span>{$storeDetail['user_time']}</span></td>
        </tr>
        <tr>
          <td><span>后台审核时间</span></td>
          <td><span>{$storeDetail['market_time']}</span></td>
        </tr>
        <tr>
          <td><span>入库日期</span></td>
          <td><span>{$storeDetail['in_time']}</span></td>
        </tr>
        <tr>
          <td><span>租库日期</span></td>
          <td><span>{$storeDetail['rent_time']}</span></td>
        </tr>
        <tr>
          <td><span>检测机构</span></td>
          <td><span>{$storeDetail['check_org']}</span></td>
        </tr>
        <tr>
          <td><span>质检证书编号</span></td>
          <td><span>{$storeDetail['check_no']}</span></td>
        </tr>
        <tr>
          <td><span>是否包装</span></td>
          <td><span> {if: $storeDetail['package'] == 1} 是 {else:} 否{/if}</span></td>
        </tr>
        {if: $storeDetail['package'] == 1}
        <tr>
          <td><span>包装单位<span></td>
          <td><span>   {$storeDetail['package_unit']}<span></td>
        </tr>
        <tr>
          <td><span>包装数量</span></td>
          <td><span> {$storeDetail['package_num']}</span></td>
        </tr>
        <tr>
          <td><span>包装重量</span></td>
          <td><span> {$storeDetail['package_weight']}({$storeDetail['unit']})</span></td>
        </tr>
        {/if}
        <tr class="tr_title">
          <td colspan="2"><span>商品信息</span></td>
        </tr>
        <tr>
          <td><span>商品名称</span></td>
          <td><span>  {$storeDetail['pname']}</span></td>
        </tr>
        <tr>
          <td><span>属性</span></td>
          <td><span> {$storeDetail['attrs']}</span></td>
        </tr>
        <tr>
          <td><span>分类</span></td>
          <td><span>  
                   {foreach:items=$storeDetail['cate'] item=$cate key=$k}
                                {if:$k==0}
                                    {$cate['name']}
                                {else:}
                                    > {$cate['name']}
                                {/if}

                            {/foreach}</span></td>
        </tr>
        <tr>
          <td><span>重量</span></td>
          <td><span>{$storeDetail['quantity']}({$storeDetail['unit']})</span></td>
        </tr>
        <tr>
          <td><span>产地</span></td>
          <td><span>{areatext:data=$storeDetail['produce_area']}</span></td>
        </tr>
        <tr>
          <td><span>商品描述</span></td>
          <td><span>{$storeDetail['note']}</span></td>
        </tr>
        <tr>
          <td><span>图片预览</span></td>
          <td><span> {foreach: items=$photos item=$url}
                                        <img src="{$url}"/>
                                    {/foreach}</span></td>
        </tr>
        <tr>
          <td><span>签字入库单</span></td>
          <td><span><img src="{$storeDetail['confirm_thumb']}" /></span></td>
        </tr>
        <tr>
          <td><span>质检证书</span></td>
          <td><span><img src="{$storeDetail['quality_thumb']}" /></span></td>
        </tr>
        <tr class="tr_title">
          <td colspan="2"><span>用户信息</span></td>
        </tr>
        <tr>
          <td><span>用户名</span></td>
          <td><span>{$user['username']}</span></td>
        </tr>
        <tr>
          <td><span>手机号</span></td>
          <td><span>{$user['mobile']}</span></td>
        </tr>
        <tr>
          <td><span>地址</span></td>
          <td><span>{$user['address']}</span></td>
        </tr>
        <tr>
          <td><span>公司名称</span></td>
          <td><span>{$user['company_name']}</span></td>
        </tr>
        <tr>
          <td><span>联系人</span></td>
          <td><span>{$user['contact']}</span></td>
        </tr>
        <tr>
          <td><span>联系电话</span></td>
          <td><span>{$user['contact_phone']}</span></td>
        </tr>
        <tr>
          <td colspan="2">
              <button onClick="window.print()">打印</button>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <!-- 表格详情样式 end-->
</body>
</html>