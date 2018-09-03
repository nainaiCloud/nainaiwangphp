<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<style type="text/css">
.required{
    padding-right: 5px;
    color: #c53026;
    position: absolute;
    top: 7px;
    left: 20px;
}
.munit{
    color:#bfbfbf;
    position: relative;
    right:15px;
}
</style>
<input type="hidden" name="attr_url" value="{url:/ManagerDeal/ajaxGetCategory}"  />
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
<div class="class_jy" id="cate_box" style="display:none;">
    <span class="jy_title"></span>
    <ul>
        <!-- <li value=""   class="a_choose" ><a></a></li>
-->
    </ul>

    <ul class="infoslider" style="display: none;">
        <li value=""   class="a_choose"  ><a></a></li>

    </ul>
    <!--<div class="sl_ext">
        <a href="javascript:;" class="sl_e_more info-show" style="visibility: visible;">展开</a>
    </div>-->

</div>
   <!--start中间内容-->    
   <div class="user_c">
      <div class="user_zhxi pro_classify">
        <div class="zhxi_tit">
            <p><a>产品管理</a>><a>竞价发布</a></p>
        </div>
        <div class="center_tabl">
            <div class="lx_gg">
                <b>商品类型</b>
            </div>
            {if: !empty($categorys)}
                {foreach: items=$categorys item=$category key=$level}
                    <div class="class_jy" id="level{$level}">
                        <span class="jy_title">
                            {if: isset($childName)}                                    {$childName}：
                            {else:}
                                市场类型：
                            {/if}
                        </span>
                        <ul>
                            {foreach: items=$category['show'] item=$cate}
                            <li value="{$cate['id']}"  {if: $key==0} class="a_choose" {/if} ><a>{$cate['name']}</a></li>                                    {if: $key == 0}
                                {set: $childName = $cate['childname']}
                            {/if}
                            {/foreach}
                        </ul>


                    </div>
                {/foreach}
            {/if}
            <form id="form_bidInfo" action="{url:/ManagerDeal/xinjingjia}" method="POST" auto_submit="1" redirect_url="{url:/ManagerDeal/jingjialist}">
                {include:/layout/product2.tpl}
                <tr>
                    <td></td>

                    <td colspan="2" class="btn">
                        <input type="hidden" name='cate_id' id="cate_id" value="{$cate_id}">
                        <input class="submit_form" id="btn_sub"  type="submit"  value="确定提交" />
                    </td>
                </tr>
                             
             </table>
            </form>
        </div>
    </div>
<!-- 遮罩层 -->
<div class="bidbond_result">
    <div class="mark"></div>
    <div class="result">
        <div class="result_title">
            提示
            <i class="close"></i>
        </div>
        <div id="resule_success" class="result_cont">
            <div class="result_img"><img src="{views:images/icon/successIcon.png}"/></div>
            <div class="result_tip" id="success_text">恭喜，您的商品竞价已发布成功！</div>
            <div class="result_tip success_tip">系统将自动在10秒内跳转到商品竞价列表</div>
        </div>
    </div>
<script type="text/javascript">
$(function(){
    getCategory({$cate_id});
    formacc.successMsg = function(a) {
        $(".bidbond_result #resule_success #success_text").html(a);
        $(".bidbond_result").fadeIn(1000);
    };

    formacc.addressRule('areabox1');
    $(".close,.mark").click(function(){
        $(".bidbond_result").fadeOut()
    })
    //竞价人群选择
    $("select[name='jingjia_mode']").change(function(){
        if($(this).val() == 0){
            console.log($(this).val())
            $(".jzrqselect").hide();
        }else if($(this).val() == 1){
             console.log("s",$(this).val())
             $(".jzrqselect").show()
        }
    })

    $("input[name=warename]").blur(function() {
        var pro_name = $(this).val();
        var url = "{url:/managerdeal/searchJingjia}";
        $.ajax({
            type:'get',
            url:url,
            data:{pro_name:pro_name},
            dataType:'json',
            success:function(data){
                console.log(JSON.stringify(data));
                $('input[name=produce_address]').val('');
                $('input[name=accept_area]').val('');
                $('input[name=accept_day]').val('');
                $('input[name=pay_days]').val('');
                $('[name=note]').val('');
                $('[name=other]').val('');
                $('input[name^=attribute]').val('');
                var Obj1 = new Area();
                Obj1.initComplexArea('seachprov', 'seachcity', 'seachdistrict', '','area');
                var Obj2 = new Area();
                Obj2.initComplexArea('seachprovarea1', 'seachcityarea1', 'seachdistrictarea1', '','accept_area_code');
                $('input[name=area]').val('');
                $('input[name=accept_area_code]').val('');
                if(data['jingjia']){
                    var jingjia = data['jingjia'];
                    if(jingjia['product']['attribute']){
                        $.each(jingjia['product']['attribute'],function(i,v) {
                            $('input[name=attribute\\['+v.id+'\\]]').val(v.value);
                        });

                    }
                    Obj1.initComplexArea('seachprov', 'seachcity', 'seachdistrict', jingjia['product']['produce_area'],'area');
                    $('input[name=area]').val(jingjia['product']['produce_area']);
                    Obj2.initComplexArea('seachprovarea1', 'seachcityarea1', 'seachdistrictarea1', jingjia['accept_area_code'],'accept_area_code');
                    $('input[name=accept_area_code]').val(jingjia['accept_area_code']);
                    $('input[name=produce_address]').val(jingjia['product']['produce_address']);
                    $('input[name=accept_area]').val(jingjia['accept_area']);
                    $('input[name=accept_day]').val(jingjia['accept_day']);
                    $('input[name=pay_days]').val(jingjia['pay_days']);
                    $('[name=weight_type]').val(jingjia['weight_type']);
                    $('[name=note]').val(jingjia['product']['note']);
                    $('[name=other]').val(jingjia['other']);

                    //弹出提示框
                    
                }

            }
        })
    });
})
</script>



