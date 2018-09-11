
        <!--            
              CONTENT
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />报盘管理
</h1>
                
<div class="bloc">
    <div class="title">
       报盘信息
    </div>
     <div class="pd-20">
	 	 <table class="table table-border table-bordered table-bg">
             <tr>
                 <th>委托方</th>
                 <td>{$info['user']}</td>
                 <th>状态</th>
                 <td>{$info['status_txt']}</td>
                 <th></th>
                 <td></td>
             </tr>
             <tr>
                 <th>交易方式</th>
                 <td>{$info['type_txt']}</td>
                 <th>报盘类型</th>
                 <td>{if:$info['submode_txt']==''}
                     {$info['mode_txt']}
                     {else:}
                        {$info['submode_txt']}
                         {if:$info['sub_mode']==1}
                         -
                         {if:$info['jingjia_mode']==1}
                         场内竞价[口令：{$info['jingjia_pass']}]
                         {else:}
                         场外竞价
                         {/if}
                         {/if}
                     {/if}</td>
                 <th>报盘费率</th>
                 <td> {if: $info['mode'] == \nainai\offer\product::DEPUTE_OFFER}
                             {if:!empty($info['rate'])}

                             {if:$info['rate']['type'] == 0}
                             {$info['rate']['value']} %
                             {else:}
                             每{$info['unit']} {$info['rate']['value']}元
                             {/if}
                             {else:}
                             0
                             {/if}
                        {else:}
                             {$info['offer_fee']}
                         {/if}
                 </td>
             </tr>
             <tr>
                 <th>商品名称</th>
                 <td>{if:$info['pro_name']!=''}{$info['pro_name']}{else:}{$info['product_name']}{/if}</td>
                 <th>商品产地</th>
                 <td id="area">{areatext: data=$info['produce_area'] id=area}{$info['produce_address']}</td>
                 <th>记重方式</th>
                 <td>{$info['weight_type']}</td>

             </tr>
             <tr>
                 <th>商品大类</th>
                 <td>{$info['cate'][0]['name']}</td>
                 <th>商品种类</th>
                 <td>
                     {foreach:items=$info['cate']}
                         {if:$key!=0}
                             {if:$key==1}
                                 {$item['name']}
                             {else:}
                                 /{$item['name']}
                             {/if}
                         {/if}
                     {/foreach}
                 </td>

                 <th></th>
                 <td></td>


             </tr>

             <tr>
                 {if:$info['type']==\nainai\offer\product::TYPE_BUY}
                     <th>价格区间</th>

                     <td>{$info['price_l']}--{$info['price_r']}( 元/{$info['unit']})</td>
                     <th>会员价</th>
                     <td>-</td>
                 {else:}
                     <th>挂牌价</th>
                     <td>￥{$info['price']}</td>
                     <th>会员价</th>
                     <td>￥{$info['price_vip']}</td>
                 {/if}

                 <th>计量单位</th>
                 <td>{$info['unit']}</td>


             </tr>

             {if:$info['sub_mode']==1}
                 <tr>
                     <th>最低价格</th>
                     <td>{$info['price_l']}</td>


                     <th>最高价格</th>
                     <td>{if:$info['price_r']>0}{$info['price_r']}{else:}不限{/if}</td>
                     <th>递增价格</th>
                     <td>{$info['jing_stepprice']}</td>


                 </tr>
                 <tr>
                     <th>开始时间</th>
                     <td>{$info['start_time']}</td>


                     <th>结束时间</th>
                     <td>{$info['end_time']}</td>
                     <th></th>
                     <td></td>


                 </tr>
             {/if}
             {if: $info['type'] == \nainai\offer\product::TYPE_SELL}
             <tr>
                 <th>可否拆分</th>
                 <td>{if:$info['divide'] == 1}是{else:}否{/if}</td>
                 {if: $info['divide'] == 1}
                     <th>最小起订量</th>
                     <td>{$info['minimum']}</td>
                     <th>最小递增量</th>
                     <td>{$info['minstep']}</td>
                 {else:}
                     <th></th>
                     <td></td>
                     <th></th>
                     <td></td>
                 {/if}
             </tr>
             {/if}
             <tr>
                 <th>报盘数量</th>
                 <td>{$info['max_num']}</td>
                 <th>已售数量</th>
                 <td>{$info['sell_num']}</td>
                 <th></th>
                 <td></td>
             </tr>

             <tr>

                 <th>交收地点</th>
                 <td>{areatext: data=$info['accept_area_code'] id=area1}{$info['accept_area']}</td>
                 {if: $info['type'] == \nainai\offer\product::TYPE_SELL}
                 <th>交收时间</th>
                 <td>成交后{$info['accept_day']}天完成交收</td>
                     <th>缴费时间</th>
                     <td>竞价结束后{$info['pay_days']}天完成货款缴纳</td>
                 {else:}
                 <th></th>
                 <td></td>
                 {/if}
                 {if:$info['mode']==\nainai\offer\product::DEPUTE_OFFER}
                     <th>委托书</th>
                     <td><a href="{$info['sign_thumb']}" >[查看]</a></td>
                 {else:}
                     <th></th>
                     <td></td>
                 {/if}
             </tr>
               <tr>
                 <th>申请时间</th>
                 <td>{$info['apply_time']}</td>

                 <th>补充条款</th>
                 <td>{$info['other']}</td>
                   {if:$info['expire_time']}
                       <th>过期时间</th>
                       <td>{$info['expire_time']}</td>
                       {else:}
                       <th></th>
                       <td></td>
                   {/if}

             </tr>

             <tr>
                 <th>图片</th>

                 <td>
                     {foreach:items=$info['imgData']}
                         {img:data=$item width=100 height=100}
                      {/foreach}
                 </td>

                 <th>商品属性</th>
                 <td >

                     {foreach:items=$info['attr_arr']}
                         {$key}:{$item}</br>
                     {/foreach}
                 </td>
                 <th>描述</th>
                 <td>{$info['note']}</td>
             </tr>

                <tr>
                 <th>是否投保</th>

                 <td>
                     {if: $info['insurance'] == 1}是{else:}否{/if}
                 </td>
                    {if: $info['insurance'] == 1}
                 <th>保险产品</th>
                 <td >
 {foreach: items=$riskData}
                                    保险公司：{$item['company']} - 保险产品：{$item['name']} {if:$item['mode']==1}比例 : ({$item['fee']}){else:}定额 : ({$item['fee']}){/if}<br />
                                   {/foreach}
                 </td>
                 {else:}
                 <th></th>
                 <td >

                 </td>
                 {/if}
                 <th></th>
                 <td></td>
             </tr>

<tr>

                 <th>审核意见</th>
                 <td colspan="5">{$info['admin_msg']}</td>
             </tr>
             <tr>
                 <th>操作</th>

                 <th scope="col" colspan="7">
                     <form action="{url:trade/OfferManage/kefuAdd}" method="post" auto_submit redirect_url="{url:trade/OfferManage/offerList}">
                         <input type="hidden" name="offer_id" value="{$info['id']}" />
                         <select name="kefu" >
                             <option value="0">请选择客服</option>
                             {foreach:items=$kefu}
                                 <option value="{$item['admin_id']}" {if:$info['kefu']==$item['admin_id']}selected="true"{/if}>{$item['ser_name']}</option>
                             {/foreach}
                         </select>

                         <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;绑定客服&nbsp;&nbsp;">
                     </form>

                     <a onclick="history.go(-1)" class="btn btn-default radius"><i class="icon-remove fa-remove"></i> 返回</a>
                 </th>

            </tr>
	 	</table>
 	</div>
</div>

</div>
        
        
    </body>
</html>