<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/17 0017
 * Time: 下午 5:43
 */

namespace Library\log;

class table{

    public static function get(){
        return  array(
            'dealer'=>'交易商认证',
            'store_manager'=>'仓库管理员认证',
            'user_group'=>'用户组',
        );
    }

}
