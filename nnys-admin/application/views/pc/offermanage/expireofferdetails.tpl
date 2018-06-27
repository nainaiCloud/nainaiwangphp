
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />报盘管理
</h1>
                
<div class="bloc">
    <div class="title">
       过期报盘信息
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
                 <td>{$info['type']}</td>
                 <th>报盘类型</th>
                 <td>{$info['mode_txt']}</td>
                 <th>报盘费率</th>
                 <td>{$info['offer_fee']}</td>
             </tr>
             <tr>
                 <th>商品名称</th>
                 <td>{$info['product_name']}</td>
                 <th>商品产地</th>
                 <td id="area">{areatext: data=$info['produce_area'] id=area}</td>
                 <th></th>
                 <td></td>

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
                 {if:$info['type']=='买盘'}
                     <th>价格区间</th>
                     <td>{$info['price_l']}--{$info['price_r']}</td>
                 {else:}
                     <th>挂牌价</th>
                     <td>{$info['price']}</td>
                 {/if}

                 <th>计量单位</th>
                 <td>{$info['unit']}</td>
                 <th></th>
                 <td></td>
            

             </tr>
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
                 <td>{$info['quantity']}</td>
                 <th>冻结数量</th>
                 <td>{$info['freeze']}</td>
                 <th>已售数量</th>
                 <td>{$info['sell']}</td>
             </tr>
             <tr>
                 <th>交收时间</th>
                 <td>{if: $info['type'] == \nainai\offer\product::TYPE_SELL}{$info['accept_day']}{else:}--{/if}</td>
                 <th>交收地点</th>
                 <td>{$info['accept_area']}</td>
                 {if:$info['mode']==\nainai\offer\product::DEPUTE_OFFER}
                     <th>委托书</th>
                     <td><img src="{$info['sign_thumb']}" /></td>
                 {else:}
                     <th></th>
                     <td></td>
                 {/if}
             </tr>
             <tr>
                 <th>图片</th>
                 <td></td>
                 <th>商品属性</th>
                 <td >
                     {foreach:items=$info['attr_arr']}
                         {$key}:{$item}</br>
                     {/foreach}
                 </td>
                 <th>描述</th>
                 <td>{$info['note']}</td>
             </tr>
             {if:!empty($info['stage_set'])}
                 {foreach: items=$info['stage_set']}
                     <tr>
                         <th scope="col" colspan="6">
                             竞价第{echo:$key+1}阶段
                         </th>
                     </tr>
                     <tr>
                         <th>开始时间</th>
                         <td>{$item['start_time']}</td>
                         <th>结束时间</th>
                         <td>{$item['end_time']}</td>
                         <th>起拍价</th>
                         <td>￥{$item['price_l']}</td>
                     </tr>
                     <tr>
                         <th>递增价</th>
                         <td>￥{$item['price_step']}</td>
                         <th>验证码</th>
                         <td>{$item['pass']}</td>
                         <th>结束时有报价</th>
                         <td>{if:$item['always_next']==1}转入下一阶段{else:}忽略后续阶段{/if}</td>
                     </tr>
                 {/foreach}

             {/if}

             <tr>
                 <th>操作</th>

                 <th scope="col" colspan="7">


                     <a onclick="history.go(-1)" class="btn btn-default radius"><i class="icon-remove fa-remove"></i> 返回</a>
                 </th>

            </tr>
	 	</table>
 	</div>
</div>

</div>
        
        
    </body>
</html>