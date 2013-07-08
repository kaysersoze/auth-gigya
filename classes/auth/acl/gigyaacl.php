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

namespace Auth;

/**
 * GigyaAuth acl driver for Giya User360 (Registration-as-a-service) platform
 *
 * @package     Fuel
 * @subpackage  Auth
 */
class Auth_Acl_Gigyaacl extends \Auth_Acl_Driver
{
	/*
	 * @var  array  list of valid roles
	 */
	protected static $_valid_roles = array();

	/*
	 * class init
	 */
	public static function _init()
	{
		// get the list of valid roles
		
	}

	/*
	 * Return the list of defined roles
	 */
	public function roles()
	{
		return static::$_valid_roles;
	}

	/*
	 * Check if the user has the required permissions
	 */
	public function has_access($condition, Array $entity)
	{
		
	}
}