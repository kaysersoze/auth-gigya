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
 
namespace Auth\Model;

class Auth_GigyaUser extends \Model implements \ArrayAccess
{
	private $_data;
	private $_debug;

	public $id;
	public $user_id;
	public $group_id;
	public $username;
    public $email;
    public $password;
    public $login_hash;
    public $last_login;
    public $previous_login;
    public $created_at;
    public $updated_at;

   	public function __construct(\Gigya\Model\GigyaAccount $gigya_account, $debug = false)
	{

		if(!$gigya_account->hasErrors()) 
		{
			$this->id = $gigya_account->UID;
			$this->user_id = $gigya_account->UID;
			$this->group_id = $gigya_account->data->group_id;
			$this->username = $gigya_account->loginIDs->username;
			$this->email = $gigya_account->profile->email; // TO DO: user loginIDs->emails
			$this->password = null;
			$this->login_hash = $gigya_account->data->login_hash;
			if(!empty($gigya_account->lastLoginTimestamp)) {
				$this->last_login = $gigya_account->lastLoginTimestamp;
			} else {
				$this->last_login = null;
			}
			if(!empty($gigya_account->lastLoginTimestamp)) {
				$this->previous_login = $gigya_account->lastLoginTimestamp;
			} else {
				$this->previous_login = null;
			}
			$this->created_at = $gigya_account->createdTimestamp;
			$this->updated_at = $gigya_account->lastUpdatedTimestamp;
		}
		
		return !empty($this->id) ? $this : null;
	}
	
	/**
	 * init the class
	 */
   	public static function _init()
	{
		// auth config
		\Config::load('gigyaauth', true);

		// model language file
		// \Lang::load('auth_model_user', true);
	}
	
	/**
	 * Sets the value of the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @param   string  $value   value
	 * @return  void
	 */
	public function offsetSet($offset, $value)
	{
		$this->{$offset} = $value;
	}

	/**
	 * Checks if the given offset (class property) exists.
	 *
	 * @param   string  $offset  class property
	 * @return  bool
	 */
	public function offsetExists($offset)
	{
		return property_exists($this, $offset);
	}

	/**
	 * Unsets the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @return  void
	 */
	public function offsetUnset($offset)
	{
		unset($this->{$offset});
	}

	/**
	 * Gets the value of the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @return  mixed
	 */
	public function offsetGet($offset)
	{
		if (property_exists($this, $offset))
		{
			return $this->{$offset};
		}

		throw new \OutOfBoundsException('Property "'.$offset.'" not found for '.get_called_class().'.');
	}
	
}