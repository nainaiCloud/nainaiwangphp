<?php
namespace schema\Transfer;

use \Library\M;
use \Library\Query;
/**
 * ×Ö¶Î×ª»»
 *

 */
class JingjiaTransfer
{


    public function accept_area_code($val,$args,$context){
         $areaCode = $val['accept_area_code'];
         if(isset($args['type']) && $args['type']==1)
             return $areaCode;
         return \Library\tool::areaText($areaCode);
    }




}
