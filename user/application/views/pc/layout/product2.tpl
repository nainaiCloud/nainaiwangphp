
<table border="0" >

    <tr>
        <th colspan="3"><span class="infortitle">基本商品信息</span></th>
    </tr>
    <tr>
        <td nowrap="nowrap"><b class="required">*</b>商品名称：</td>
        <td colspan="2">
            <span><input class="text" type="text" name="warename" datatype="*" value="{$product['product_name']}" errormsg="填写商品名称" nullmsg="请填写信息！">
            </span>
        </td>

    </tr>
    <tr style="display:none" id='productAdd'>
        <td ></td>
        <td ></td>
    </tr>
    <input type="hidden" name="cate_id" id="cid" />
    <input type="hidden" name="ajax_url" id="ajax_url" value="{url: Trade/Insurance/ajaxGetCate}">

    <tr>
        <td><b class="required">*</b>产地：</td>
        <td colspan="2">
            <span class="area" id="areabox">{area:data=$product['produce_area'] inputName=area}</span>
            <span><input class="text" placeholder="请输入具体地址" value="{$product['produce_address']}" datatype="*" errormsg="请输入地址" nullmsg="请填写信息！" type="text" name="produce_address">
            </span>
            <span></span>
        </td>

    </tr>
    <tr>
        <td><b class="required">*</b>交收地点：</td>
        <td colspan="2">
            <span class="area" id="areabox1">{area:data=$product['produce_area'] id=area1 inputName=accept_area_code}</span>
            <span><input class="text" placeholder="请输入具体地址" value="" type="text" name="accept_area" datatype="*" errormsg="请输入地址" nullmsg="请填写信息！">
            </span>
        </td>
    </tr>
    <tr>
    <td><b class="required">*</b>交收时间：</td>
    <td colspan="2">
        <span><input class="text" datatype="float" value="" type="text"  name="accept_day" /> <span class="tip">输入成交后多少天完成交收</span>
        <span></span>
    </td>
    </tr>

    <tr>
    <td><b class="required">*</b>记重方式：</td>
    <td colspan="2">
        <span>
            <select class="jzselect" name="weight_type">
                <option value="理论值" {if:$offer['weight_type']=="理论值"}selected="true"{/if}>理论值</option>
                <option value="过磅" {if:$offer['weight_type']=="过磅"}selected="true"{/if} >过磅</option>
                <option value="轨道衡" {if:$offer['weight_type']=="轨道衡"}selected="true"{/if} >轨道衡</option>
                <option value="吃水" {if:$offer['weight_type']=="吃水"}selected="true"{/if} >吃水</option>
            </select>
            
        </span>
        <span></span>
    </td>
    </tr>
    <tr>
        <td>商品描述：</td>
        <td colspan="2">
            <textarea name="note">{$product['note']}</textarea>
        </td>
    </tr>

    <tr>
        <td>补充条款：</td>
        <td colspan="2">
            <textarea name="other">{$offer['other']}</textarea>
        </td>
    </tr>
    <tr>
        <td style="vertical-align:top;"><b class="required">*</b>上传图片：</td>
        <td>

            <script type="text/javascript" src="{root:/js/webuploader/webuploader.js}"></script>
            <script type="text/javascript" src="{root:/js/webuploader/upload.js}"></script>
            <link href="{root:/js/webuploader/webuploader.css}" rel="stylesheet" type="text/css" />
            <link href="{root:/js/webuploader/demo.css}" rel="stylesheet" type="text/css" />


            <div id="uploader" class="wu-example">
                <input type="hidden" name="uploadUrl" value="{url:/ucenter/upload}" />
                <input type="hidden" name="swfUrl" value="{root:/js/webuploader/Uploader.swf}" />
                <!--用来存放文件信息-->
                <ul id="filelist" class="filelist">
                    {if:isset($product['imgData'])}
                        {foreach:items=$product['imgData']}
                            <li   class="file-item thumbnail">
                                <p>
                                    <img width="110" src="{echo:\Library\thumb::get($item,110,110)}" />

                                </p>
                                <input type="hidden" name="imgData[]" value="{$item}" />
                            </li>
                        {/foreach}
                    {/if}
                </ul>
                <script type="text/javascript">
                    $('#filelist img').dblclick(function(){
                        $(this).parents('li').remove();
                    });
                </script>
                <div class="btns">
                {set:$filesize = \Library\tool::getConfig(array('application','uploadsize'))}
                    {if:!$filesize}
                        {set:$filesize = 2048;}
                    {/if}
                    {set:$filesize = $filesize / 1024;}
                    <div id="picker" style="line-height:15px;">
                        <span class="line_l"></span>
                        <span class="line_h"></span>
                    </div><span class="filesm">上传图片说明：上传的每张图片大小不能超过{$filesize}M。双击图片可以删除</span>
                    <div class="totalprogress" style="display:none;">
                        <span class="text">0%</span>
                        <span class="percentage"></span>
                    </div>
                    <div class="info"></div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="3"><span class="infortitle">竞价信息录入</span></th>
    </tr>

    <tr>
        <td><b class="required">*</b>竞价数量：</td>
        <td>
            <span><input type="text" datatype="*" name="quantity" value="{$product['quantity']}" class='text' placeholder="请输入竞价数量" ></span>
        </td>
    </tr>
    <tr>
        <td><b class="required">*</b>数量单位：</td>
        <td>
            <span><input type="text" class='text' datatype="*"  placeholder="请输入竞价数量单位" name="unit" value="{$product['unit']}" value="" placeholder="吨"></span>
        </td>
    </tr>
    <tr>
        <td><b class="required">*</b>参与竞价人群：</td>
        <td colspan="2">
            <span>
                <select name="jingjia_mode" class="jzselect">
                    <option value="1" {if:$offer['jingjia_mode']==1}selected="true"{/if}>自行指定交易商</option>
                    <option value="0" {if:$offer['jingjia_mode']==0}selected="true"{/if}>全部</option>
                </select>
            </span>
            <span class="tip">提示：请您将竞价口令码线下告知您通知的客户，竞价发布后，客户可输入竞价口令进入竞价详情页面</span>
        </td>
    </tr>
    <tr>
        <td><b class="required">*</b>竞价开始时间：</td>
        <td colspan="2">
            <span><input name="start_time" class="Wdate text Validform_error" datatype="*" value="" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd  HH:mm:ss',minDate:'%y-%M-#{%d}'})"  >
           <span class="tip">竞价信息发布选择的日期必须在距离开始竞价日期三日以上
            <!-- 若没选择正确，则提示语： -->
            <!-- 竞价开始时间为当前时间的3个工作日后，请您重新选择时间 --></span>
        </td>
    </tr>
    <tr>
        <td><b class="required">*</b>竞价结束时间：</td>
        <td colspan="2">
             <span><input name="end_time" class="Wdate text Validform_error" datatype="*" value="" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd  HH:mm:ss',minDate:'%y-%M-#{%d}'})"  nullmsg="请填写信息！">
        </td>
    </tr>
    <tr class='nowrap'>
        <td nowrap="nowrap" ><b class="required">*</b>起拍价：</td>
        <td>
            <span><input name="price_l" id="" datatype="money" errormsg="请输入金额" nullmsg="请填写信息！" type="text"  class="text" value="" /><span class="munit">￥</span></span>
        </td>
    </tr>
    <tr class='nowrap'>
        <td nowrap="nowrap" ><b class="required">*</b>递增幅度：</td>
        <td>
            <span><input name="step_price" datatype="n" type="text" class="text" value="" errormsg="请输入数字" nullmsg="请填写信息！" /><span class="munit">￥</span></span>
            <span></span>
        </td>
    </tr>
    
    
