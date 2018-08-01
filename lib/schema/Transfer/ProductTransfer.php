<?php
namespace schema\Transfer;

use \Library\M;
use \Library\Query;
/**
 * ×Ö¶Î×ª»»
 *

 */
class ProductTransfer
{


    public function produce_area($val,$args,$context){
         $areaCode = $val['produce_area'];
         return \Library\tool::areaText($areaCode);
    }

    public function attribute($val,$args,$context){
        $attr = $val['attr_json'];

    }

    public function attr_json($val,$args,$context){
        $attr = $val['attr_json'];

    }




}
