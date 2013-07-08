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
 * GigyaAuth group driver for Giya User360 (Registration-as-a-service) platform
 *
 * @package     Fuel
 * @subpackage  Auth
 */
class Auth_Group_Gigyagroup extends \Auth_Group_Driver
{
	/*
	 * @var  array  list of valid groups
	 */
	protected static $_valid_groups = array();

	/*
	 * class init
	 */
	public static function _init()
	{
		// get the list of valid groups
		
	}

	/*
	 * additional drivers to load
	 */
	protected $config = array(
		'drivers' => array('acl' => array('Gigyaacl'))
	);

	/*
	 * Return the list of defined groups
	 */
	public function groups()
	{
		return static::$_valid_groups;
	}

	/*
	 * check for group membership
	 */
	public function member($group, $user = null)
	{
		
	}

	/*
	 * get the name of a specific group, or of the users default group
	 */
	public function get_name($group = null)
	{
		
	}

	/*
	 * get the roles assigned to a group, or to the users default group
	 */
	public function get_roles($group = null)
	{
		
	}
}