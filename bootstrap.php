<?php
/**
 * Gigya Auth
 *
 * Authentication driver for the Gigya User Management 360 platform
 * (http://developers.gigya.com/010_Developer_Guide/10_UM360)
 *
 * @package    Gigya Auth
 * @version    1.0
 * @author     Carlos Noguera
 * @license    MIT License
 * @copyright  2013 Carlos Noguera
 * @link       http://carlosnoguera.com
 */
 
Autoloader::add_core_namespace('Auth');

Autoloader::add_classes(array(
	'Auth\\Auth_Acl_Gigyaacl'              => __DIR__.'/classes/auth/acl/gigyaacl.php',
	'Auth\\Auth_Group_Gigyagroup'          => __DIR__.'/classes/auth/group/gigyagroup.php',
	'Auth\\Auth_Login_Gigyaauth'           => __DIR__.'/classes/auth/login/gigyaauth.php',
	
	'Auth\\Model\\Auth_GigyaUser'             => __DIR__.'/classes/model/auth/gigyauser.php'
));