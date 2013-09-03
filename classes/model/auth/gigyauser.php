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
	protected $_is_new = true;
	
	private $_account;
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
    
    public $avatars;
    public $metadata;

   	public function __construct(\Gigya\Model\GigyaAccount $gigya_account, $debug = false)
	{

		if(!$gigya_account->hasErrors()) 
		{
			// Set core model data
			$this->id = $gigya_account->UID;
			$this->user_id = $gigya_account->UID;
			$this->group_id = $gigya_account->data->group_id;
			if (!empty($gigya_account->loginIDs->username)) {
				$this->username = $gigya_account->loginIDs->username;
			} else {
				$this->username = $gigya_account->profile->email;
			}
			$this->email = $gigya_account->profile->email; // TO DO: user loginIDs->emails
			$this->password = null;
			if (!empty($gigya_account->data->login_hash)) {
				$this->login_hash = $gigya_account->data->login_hash;
			} else {
				$this->login_hash = null;
			}
			if(!empty($gigya_account->loginProvider)) {
				$this->loginProvider = $gigya_account->loginProvider;
			} else {
				$this->loginProvider = null;
			}
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
			
			// Set user avatars
			$this->avatars = array();
			
			foreach($gigya_account->identities as $identity) {
				if(!empty($identity->photoURL)) {
					$this->avatars[] = $identity->photoURL;
				}
			}
			
			// Set model "metadata", according to config mapping
			$this->metadata = array();
			
			foreach(\Config::get('gigyaauth.metadata') as $metadata_key => $gigya_key) {
				if(!empty($gigya_account->profile->{$gigya_key})) {
					$metadata_object = new \stdClass;
					$metadata_object->key = $metadata_key;
					$metadata_object->value = $gigya_account->profile->{$gigya_key};
					$this->metadata[] = $metadata_object;
				}
			}
			
			// Load metadata into the model
			// TO TO: See how to do this better, a la ORM EAV
			foreach($this->metadata as $metadata) {
				$this->{$metadata->key} = $metadata->value;
			}
			
			// Keep Gigya Account objct handy
			$this->_account = $gigya_account;
			
			// Set this to not be a new object (to follow ORM pattern)
			$this->_is_new = false;
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
	 * Return whether this is a new object
	 */
	public function is_new()
	{
		return $this->_is_new;
	}
	
	/**
	 * Get account data from Gigya
	 */
	public function find()
	{
	
	}
	
	/**
	 * Save the data back to Gigya
	 */
	public function save()
	{
		// TO DO: Update this so it's "smart" about organizing $profile, $data, etc.
		$this->_account->setAccountInfo(
			$this->id,
			null,
			array(),
			array(
				'group_id' => $this->group_id,
				'login_hash' => $this->login_hash
			)
		);
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