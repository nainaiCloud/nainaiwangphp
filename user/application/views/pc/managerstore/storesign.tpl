﻿
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<script type="text/javascript" src="{views:js/product/storeproduct.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
<form action="{url:/ManagerStore/doStoreSign}" method="post" auto_submit redirect_url="{url:/managerstore/applystorelist?type=2}">

            <div class="user_c">
                <div class="user_zhxi">

                    <div class="zhxi_tit">
                        <p><a>仓库管理</a>><a>仓单签发</a></p>
                    </div>
                    <div class="rz_title">
                        <ul class="rz_ul">
                            <li class="rz_start"></li>
                            <li class="rz_li cur"><a class="rz">会员信息</a></li>
                            <li class="rz_li "><a class="yz">商品信息</a></li>
                            <li class="rz_li"><a class="shjg">入库详细信息</a></li>
                            <li class="rz_end"></li>
                        </ul>

                    </div>
                    <div class="class_jy" id="cate_box" style="display:none;">
                        <span class="jy_title"></span>
                        <ul>
                            <!-- <li value=""   class="a_choose" ><a></a></li>
                    -->
                        </ul>

                        <ul class="infoslider" style="display: none;">
                            <li value=""   class="a_choose"  ><a></a></li>

                        </ul>


                    </div>
                    <div class="re_xx">
                        <div class="user_c" style="border:0px;margin-left:0px;">
                            <div class="user_zhxi">
                                <div class="center_tabl">
                                    <div class="lx_gg sear_mx" style="background:#fff;">
                                        <span>用户名：</span>
                                        <input name="username" type="text" />
                                        <input type="hidden" name="getUserUrl" value="{url:/managerstore/getUser}" />
                                        <button class="search_an" onclick="fundUser()" type="button">获取</button>
                                    </div>
                                    <div class="lx_gg">
                                        <table class="table2" cellpadding="0" cellspacing="0" id="userData">
                                            <tr>
                                                <td class="spmx_title" colspan="2">会员信息</td>
                                            </tr>
                                            <tr>
                                                <td>用户名</td>
                                                <td id="username"></td>
                                            </tr>
                                            <tr>
                                                <td>企业名称</td>
                                                <td id="company_name"></td>
                                            </tr>
                                            <tr>
                                                <td>地区</td>
                                                <td id="area"></td>
                                            </tr>
                                            <tr>
                                                <td>地址</td>
                                                <td id="address"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="zhxi_con">
                                        <span><input class="submit next_step"  type="button"  value="下一步"/></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="yz_img">
                        <input type="hidden" name="attr_url" value="{url:/ManagerDeal/ajaxGetCategory}"  />
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
            <!--start中间内容-->

                        <div class="user_c" style="border:0px;margin-left:0px;">
                <div class="user_zhxi pro_classify">
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>商品类型</b>
                    </div>
                         {if: !empty($categorys)}
                        {foreach: items=$categorys item=$category key=$level}   
                            <div class="class_jy" id="level{$level}">
                                <span class="jy_title">市场类型：</span>
                                <ul>
                                    {foreach: items=$category['show'] item=$cate}
                                    <li value="{$cate['id']}"  {if: $key==0} class="a_choose"{/if}  ><a>{$cate['name']}</a></li>
                                    {/foreach}
                                </ul>


                            </div>
                        {/foreach}
                        {/if}
                  
                        <table border="0"  >
                            <input type="hidden" name="user_id" datatype="n"/>
                            <tr>
                               <th colspan="3">基本挂牌信息</th>
                            </tr>
                            <tr>
                            <td nowrap="nowrap"><span></span>商品标题：</td>
                            <td colspan="2"> 
                                <span><input class="text" type="text" datatype="s1-30" errormsg="填写商品标题" name="warename">
                                    </span>
                                <span></span>
                            </td>
                        </tr>


<!--                                 <td> 
    请选择付款方式:
    <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;"> 线上
    <input type ="radio" name ="safe" style="width:auto;height:auto;"> 线下
</td> -->
                            
                            <tr>
                                <td nowrap="nowrap"><span></span>数量：</td>
                                <td> <span>
                                         <input class="text" type="text" datatype="/^\d{1,10}(\.\d{0,5})?$/" errormsg="请正确填写数量" name="quantity">

                                    </span>
                                    <span></span>
                                      </td>
                               <!--  <td> 
                                   请选择支付保证金比例:
                                   <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">
                                           
                               </td> -->

                                </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>单位：</td>
                                <td>
                                    <span class="unit">{$unit}</span><input type="hidden" name="unit" value="{$unit}"/>
                                </td>
                                <!--  <td>
                                    请选择支付保证金比例:
                                    <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">

                                </td> -->
                            </tr>
{foreach: items=$attrs item=$attr}
                                    <tr class="attr">
                                        <td nowrap="nowrap"><span></span>{$attr['name']}：</td>
                                        <td colspan="2">
                                            <input class="text" type="text" name="attribute[{$attr['id']}]" >
                                        </td>
                                    </tr>
                            {/foreach}
                                 
                            <tr style="display:none" id='productAdd'>
                            <td ></td>
                            <td ></td>
                            </tr>
                            
                            <tr>
                            <td>产地：</td>
                            <td colspan="2" >
                                <span id="areabox">{area:}</span>
                                <span></span>
                            </td>
                         
                        </tr>
                            
                               

                            <tr>
                                <td>上传图片：</td>
                                <td>
                                   {include:layout/webuploader.tpl}
                                 </td>
                             </tr>
                         <tr>
                             <th colspan="3"><b>详细信息</b></th>
                        </tr>


                                   <tr>
                                        <td>是否包装：</td>
                                        <td colspan="2">
                                            <select name="package" id="package">
                                                <option value="1" selected="selected">是</option>
                                                <option value="0">否</option>
                                            </select>
                                        </td>

                                             </tr>

                                            <tr id="packUnit" >
                                                 <td>包装单位：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packUnit" >
                                            </td>
                                            </tr>
                                            <tr id='packNumber'>
                                            <td>包装数量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packNumber" >
                                            </td>
                                            </tr>
                                            <tr id='packWeight'>
                                            <td>包装重量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packWeight" >
                                            </td>
                                            </tr>


<!--                               <tr>
                            <td>是否投保：</td>
                            <td colspan="2">
  <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;">投保
      <input type ="radio" name ="safe" style="width:auto;height:auto;"> 不投保
                            </td>
                        </tr> -->
                        <tr>
                            <td>产品描述：</td>
                            <td colspan="2">
                                <textarea name="note"></textarea>
                            </td>
                        </tr>
                        <input type="hidden" name="token" value="{$token}" />
                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" name='cate_id' id="cate_id" value="{$cate_id}">
                            </td>
                        </tr>
                         
                 </table>
                        
                    </div>
                </div>
            </div>
                        <div class="zhxi_con">
                            <span><input class="submit next_step"  type="button"  value="下一步"/></span>
                        </div>

                    </div>

                    <div class="sh_jg">
                       <script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
                        <script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
            <!--end左侧导航-->  
            <!--start中间内容-->    
            <div class="user_c" style="border:0px;margin-left:0px;">
                <div class="user_zhxi">
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>入库详细信息</b>
                    </div>
                     
                        <table border="0">

                            <tr>
                                <td nowrap="nowrap"><span></span>库位：</td>
                                <td colspan="2"> 
                                    <span>
                                        <input class="text" type="text" name="pos" datatype="s1-20" errormsg="库位请填写1-20位字符" />
                                    </span>
                                    <span></span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>仓位：</td>
                                <td colspan="2"> 
                                    <input class="text" name="cang" type="text">
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>租库价格：</td>
                                <td colspan="2">
                                    <span>
                                      <input name="store_price" class="text" value="" datatype="money" errormsg="请填写价格" type="text" />（/<span class="unit">{$unit}</span>/天）

                                    </span>
                                    <span></span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>入库日期：</td>
                                <td colspan="2"> 
                                    <span>
                                        <input name="inTime" value="" datatype="datetime" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'});" type="text">
                                    </span>
                                    <span></span>
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>租库日期：</td>
                                <td colspan="2">
                                    <span>
                                        <input name="rentTime" value="" datatype="datetime" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'});" type="text">

                                    </span>
                                    <span></span>
                                     </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>检测机构：</td>
                                <td colspan="2"> 
                                    <input class="text" name="check" type="text">
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>质检证书编号：</td>
                                <td colspan="2"> 
                                    <input class="text" name="check_no" type="text">
                                </td>
                            </tr>
                              
                            <tr>
                                <td>双方签字入库单：</td>
                                <td>
                                    <div class="zhxi_con">
                                        <span><input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" ></span>
                                        <input type="hidden" name="imgfile1" value="" datatype="*" nullmsg="请上传签字入库单" />

                                    </div>
                                   
                                    <img name="file1" />
                                </td>
                            </tr>

                 </table>
                        
                    </div>
                </div>
            </div><input type="hidden" id="ajaxGetAddress" value="{url:/Ucenter/ajaxGetStoreAddress}">
            
                        <div class="zhxi_con">
                            <span><input class="submit"  type="submit" value="签发"></span>
                        </div>
                    </div>

                </div>
            </div>
</form>





       




