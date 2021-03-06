<?php
/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @package    DotLibrary
 * @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: Auth.php 735 2012-11-25 00:36:40Z julian $
 */

/**
 * Authorize user methods, used in all DotKernel Applications
 * @category   DotKernel
 * @package    DotLibrary
 * @author     DotKernel Team <team@dotkernel.com>
 */

class Dot_Auth
{
	/**
	 * Singleton instance
	 * @access protected
	 * @static
	 * @var Dot_Auth
	 */
	protected static $_instance = null;
	/**
	 * Singleton pattern implementation makes 'new' unavailable
	 * @access protected
	 * @return void
	 */
	protected function __construct()
	{
		$this->_identity = NULL;
		$this->acl = new Dot_Acl();
		$this->setRoles($this->acl->getRoles());
	}
	/**
	 * Singleton pattern implementation makes 'clone' unavailable
	 * @access protected
	 * @return void
	 */
	protected function __clone()
	{}
	/**
	 * Returns an instance of Dot_Auth
	 * Singleton pattern implementation
	 * @access public
	 * @static
	 * @return Dot_Auth
	 */
	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * Set the roles for authentification
	 * @access public
	 * @param array $roles
	 * @return  void
	 */
	public function setRoles($roles)
	{
		krsort($roles);
		$this->_roles = $roles;
	}
	/**
	 * Check permission based on the ACL roles
	 * Set wanted url if user is not logged
	 * @todo extension to check user level
	 * @access public
	 * @param string $who - who is checking the identity
	 * @return bool
	 */
	public function checkIdentity($who)
	{
		$role = 'guest';
		if($this->hasIdentity())
		{
			$user = $this->getIdentity();
			if(is_object($user))
			{
				$role = $user->role;
			}
		}
		$config = Zend_Registry::get('configuration');
		$session = Zend_Registry::get('session');
		if(!$this->acl->isAllowed($role))
		{
			//register wanted url
			if(!isset($session->wantUrl))
			{
				$session->wantUrl = Dot_Route::createCanonicalUrl();
			}
			$option = Zend_Registry::get('option');
			if(isset($option->warningMessage->userPermission))
			{
				$session->message['txt'] = $option->warningMessage->userPermission;
				$session->message['type'] = 'warning';
			}
			//create login url	to which will be redirect
			switch ($who)
			{
				case 'admin':
					$loginUrl = $config->website->params->url . '/admin/admin/login';
				break;
				default:
					$loginUrl = $config->website->params->url . '/' . $who . '/login';
				break;
			}
			header('Location: ' . $loginUrl);
			exit;
		}

		//if user is allowed, redirect him to wanted url
		if($role == 'admin' && isset($session->wantUrl))
		{
			$wantUrl = $session->wantUrl;
			unset($session->wantUrl);
			header('Location: ' . $wantUrl);
			exit;
		}
		return TRUE;
	}
	/**
	 * Check to see if identity exists - is log in
	 * @access public
	 * @return bool
	 */
	public function hasIdentity()
	{
		$session = Zend_Registry::get('session');
		foreach ($this->_roles as $who)
		{
			if(isset($session->$who) && !empty($session->$who))
			{
				$session->$who->role = $who;
				$this->_identity = $session->$who;
				return TRUE;
			}
		}
		return FALSE;
	}
	/**
	 * Return identity
	 * @access public
	 * @return object
	 */
	public function getIdentity()
	{
		return $this->_identity;
	}
	/**
	 * Clear the identity - log out
	 * @access public
	 * @static
	 * @param string $who [optional]
	 * @return void
	 */
	public function clearIdentity($who = 'user')
	{
		$session = Zend_Registry::get('session');
		if(isset($session->$who) && !empty($session->$who))
		{
			unset($session->$who);
			$this->_identity = NULL;
			unset($session->wantUrl);
		}
	}
	/**
	 * Process the authentification with Zend_Auth.
	 * Return TRUE or FALSE if succedded or not
	 * @access public
	 * @param string $who - who to authentificate
	 * @param array $values - values to process
	 * @param bool $storeInSession - should the result be stored in the session?
	 * @return bool
	 */
	public function process($who, $values, $storeInSession = true)
	{
		$adapter = $this->_getAuthAdapter($who);
		$adapter->setIdentity($values['username']);
		$adapter->setCredential($values['password']);
		$adapter->getDbSelect()->where('isActive = ?','1');
		// for admin, password is made with md5 and salt value
		if('admin' == $who)
		{
			$config = Zend_Registry::get('configuration');
			$password = md5($values['username'].$config->settings->admin->salt.$values['password']);
			$adapter->setCredential($password);
		}
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($adapter);
		if($result->isValid())
		{
			if ($storeInSession)
			{
				$session = Zend_Registry::get('session');
				$session->$who = $adapter->getResultRowObject();
			}
			return TRUE;
		}
		return FALSE;
	}
	/**
	 * Get the auth adapter
	 * @access private
	 * @param string $who
	 * @return Zend_Auth_Adapter_DbTable
	 */
	private function _getAuthAdapter($who)
	{
		$dbAdapter = Zend_Registry::get('database');
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		$authAdapter->setTableName($who)
			->setIdentityColumn('username')
			->setCredentialColumn('password');
		return $authAdapter;
	}
	/**
	 * Generate a token for a user
	 * @access public
	 * @static
	 * @param string $password - the users's password or password hash
	 * @return array
	 */
	public static function generateUserToken($password)
	{
		$config = Zend_Registry::get('configuration');
		// use the user's password hash and the site database password
		return sha1($config->database->params->password . $password);
	}
	/**
	 * Check if a user's token is set and is correct
	 * @access public
	 * @static
	 * @param string $type - the identity that is checked (i.e. admin)
	 * @return void
	 */
	public static function checkUserToken($type='admin')
	{
		$dotAuth = Dot_Auth::getInstance();
		$user = $dotAuth->getIdentity($type);
		if (!isset($_POST['userToken']) || (Dot_Auth::generateUserToken($user->password) != $_POST['userToken']))
		{
			exit;
		}
	}
}