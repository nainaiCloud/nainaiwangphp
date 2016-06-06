<?php
/**
 * 广告管理
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/5/25
 * Time: 10:21
 */

namespace Library;


class ad
{
    /**
     * @获取广告数据
     *
     */
    public static function getAdData($position){
        $positionObject = array();
        $adList        = array();

        $positionObject = self::getPositionInfo($position);
        if($positionObject)
        {
            $adList = self::getAdList($positionObject['id'],0);
            $adList['width'] = $positionObject['width'];
            $adList['height'] = $positionObject['height'];
        }
        return $adList;
    }
    /**
     * @brief 获取广告位置的信息
     * @param $position mixed 广告位ID 或者 广告位名称
     * @return array
     */
    public static function getPositionInfo($position){
        $adPositionDB = new M("ad_position");

        if(is_int($position))
        {
            $where=array('id'=>$position);
            return $adPositionDB->where($where)->getObj();
        }
        else
        {  // echo 4;
            $where=array('name'=>$position);
            return $adPositionDB->where($where)->getObj();
        }
    }
    /**
     * @brief 展示广告位数据
     * @param $adData array 广告数据
     * @return string
     */
    private static function display($adData){
        $result = array();
        if ($adData['link']) {
            $linkHtml='onclick=window.open("'.$adData['link'].'","_blank")';
        } else {
            $linkHtml = "";
        }
                $size = ($adData['width'] > 0 && $adData['height'] > 0) ? 'width:'.$adData['width'].'px;height:'.$adData['height'].'px' : '';
                $result = array
                (
                    'type' => 1,
                    'data' => '<img src="'.Thumb::get($adData['content'],180,180).'" style="cursor:pointer;'.$size.'" '.$linkHtml.' />'
                );

        return $result;
    }
    /**
     * @brief 获取当前时间段正在使用的广告数据
     * @param $position int 广告位ID
     * @param $goods_cat_id 商品分类ID
     * @return array
     */
    public static function getAdList($position,$goods_cat_id = 0)
    {
        $now    = date("Y-m-d H:i:s",time());
        $adDB   = new Query("ad_manage");
        $adDB->where="position_id = :position_id and start_time < '{$now}' AND end_time > '{$now}' order by `order` ASC";
        $adDB->bind=array('position_id'=>$position);
        return $adDB->find();
    }
    /**
     * @brief 展示制定广告位的广告内容
     * @param $position mixed 广告位ID 或者 广告位名称
     * @param $goods_cat_id 商品分类ID
     * @return string
     */
    public static function show($position,$goods_cat_id = 0,$nav=0)
    {
        $positionObject = array();
        $adArray        = array();

        $positionObject = self::getPositionInfo($position);
        if($positionObject)
        {
            $adList = self::getAdList($positionObject['id'],$goods_cat_id);
           $width=$positionObject['width'];
            $height=$positionObject['height'];
            foreach($adList as $key => $val)
            {
               $val['width']=$width;
                $val['height']=$height;
                $adArray[] = self::display($val);
            }
        }

        //有广告内容数据
        if($adArray)
        {
            $positionJson = JSON::encode($positionObject);
            $adJson       = JSON::encode($adArray);

            //引入 adloader js类库
            $loadJs = '';
      /*      if(self::$isLoadJs == false)
            {
                $loadJs = IJSPackage::load('admanage');
                self::$isLoadJs = true;
            }*/
            $fileName=url::getViewDir().'js/adloader.js';
            $juery=url::getViewDir().'js/libs/jquery/1.11/jquery.min.js';
           $loadJs='</script><script type="text/javascript" charset="utf8" src="'.$fileName.'"></script>';
            $adPositionJsId = md5("AD_{$position}");
            //生成HTML代码
            $htmlOutput =
                <<< OEF
                			{$loadJs}
			<div id='{$adPositionJsId}' class='admanage'>
			</div>
			<script type='text/javascript'>
				(new adLoader()).load({$positionJson},{$adJson},"{$adPositionJsId}",$nav);
			</script>
OEF;
            echo $htmlOutput;
        }else{

        }

    }

}