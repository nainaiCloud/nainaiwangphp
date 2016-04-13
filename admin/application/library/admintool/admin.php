<?php 

/**
 * 管理员常用方法
 */
namespace admintool;
class admin{

	/**
	 * 判断是否为超级管理员
	 * @param  integer $id [description]
	 * @return boolean     [description]
	 */
	public static function is_admin($id = 0){
		$super_admin = \Library\tool::getConfig('rbac')['super_admin'];
		if($id){
			$adminModel = new \Library\M('admin');
			$name = $adminModel->where(array('id'=>$id))->getField('name');
		}else{
			$name = \Library\Session::get(\Library\tool::getConfig('rbac')['user_session'])['name'];
		}
		return $name == $super_admin ? true : false;
	}

	/**
	 * 取出当前session中的用户信息
	 * @return array
	 */
	public static function sessionInfo(){
		return \Library\Session::get(isset(\Library\tool::getConfig('rbac')['user_session']) ? \Library\tool::getConfig('rbac')['user_session'] : '');
	}

	/**
	 * 登出
	 * @return [type] [description]
	 */
	public static function logout(){
		\Library\Session::set(\Library\tool::getConfig('rbac')['user_session'],array());
	} 
}
 ?>
