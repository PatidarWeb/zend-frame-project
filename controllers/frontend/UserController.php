<?php
/**
* DotBoost Technologies Inc.
* DotKernel Application Framework
*
* @category   DotKernel
* @package    Frontend
* @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @version    $Id: UserController.php 708 2012-05-15 16:43:03Z andrei $
*/

/**
* User Controller
* @author     DotKernel Team <team@dotkernel.com>
*/

$session = Zend_Registry::get('session');
// instantiate classes related to User module: model & view
$userModel = new User(); 
$userView = new User_View($tpl);
// all actions MUST set  the variable  $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
switch ($registry->requestAction)
{
	default:
	case 'login':
		if(!isset($session->user))
		{
			// display Login form
			$userView->loginForm('login');
		}
		else
		{
			header('Location: '.$registry->configuration->website->params->url.'/user/account');
			exit;
		}
	break;
	case 'authorize':
		// authorize user login
		if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST))
		{
			// validate the authorization request parameters 
			$values = array('username' => array('username' => $_POST['username']), 
							'password' => array('password' => $_POST['password'])
						  );
			$dotValidateUser = new Dot_Validate_User(array('who' => 'user', 'action' => 'login', 'values' => $values));
			if($dotValidateUser->isValid())
			{
				$userModel->authorizeLogin($dotValidateUser->getData());
			}
			else
			{
				$error = $dotValidateUser->getError();
				// login info are NOT VALID
				$txt = array();
				$field = array('username', 'password');
				foreach ($field as $v)
				{
					if(array_key_exists($v, $error))
					{
						 $txt[] = $error[$v];
					}
				}
				$session->validData = $dotValidateUser->getData();
				$session->message['txt'] = $txt;
				$session->message['type'] = 'error';
			}
		}
		else
		{
			$session->message['txt'] = $option->warningMessage->userPermission;
			$session->message['type'] = 'warning';
		}
		header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestController. '/login');
		exit;
	break;
	case 'account':
		// display My Account page, if user is logged in 
		//Dot_Auth::checkIdentity();
		$data = array();
		$error = array();
		if($_SERVER['REQUEST_METHOD'] === "POST")
		{
			Dot_Auth::checkUserToken('user');
			// POST values that will be validated
			$values = array('details' => 
								array('firstName'=>(isset($_POST['firstName']) ? $_POST['firstName'] : ''),
									  'lastName'=>(isset($_POST['lastName']) ? $_POST['lastName'] : '')
									 ),
							'email' => array('email' => (isset($_POST['email']) ? $_POST['email'] : '')),
							'password' => array('password' => (isset($_POST['password']) ? $_POST['password'] : ''),
												'password2' =>  (isset($_POST['password2']) ? $_POST['password'] : '')
											   )
						  );
			$dotValidateUser = new Dot_Validate_User(array(
				'who' => 'user',
				'action' => 'update',
				'values' => $values,
				'userId' => $registry->session->user->id
			));
			if($dotValidateUser->isValid())
			{
				// no error - then update user
				$data = $dotValidateUser->getData();
				$data['id'] = $registry->session->user->id;
                
                // Save log
                $log = new Dot_Model_Log();
                $vLog = array(
                    'iduser_id' => $registry->session->user->id,
                    'activity'  => 'aaa',
                    'activity_description'  => 'sadsa',
                    'activity_time' => time()
                );
                $log->saveLog($vLog);
				$userModel->updateUser($data);
				$session->message['txt'] = $option->infoMessage->update;
				$session->message['type'] = 'info';
			}
			else
			{
				$data = $dotValidateUser->getData();
				$session->message['txt'] = $dotValidateUser->getError();
				$session->message['type'] = 'error';
			}
		}
		$data = $userModel->getUserInfo($registry->session->user->id);
		$userView->details('update',$data);
	break;
	case 'register':
		// display signup form and allow user to register
		$data = array();
		$error = array();
		if ($_SERVER['REQUEST_METHOD'] === "POST")
		{
			// POST values that will be validated
			$values = array('details' => 
								array('firstName'=>(isset($_POST['firstName']) ? $_POST['firstName'] : ''),
									  'lastName'=>(isset($_POST['lastName'])? $_POST['lastName'] : ''),
									 ),
							'username' => array('username'=>(isset($_POST['username']) ? $_POST['username'] : '')),
							'email' => array('email' => (isset($_POST['email']) ? $_POST['email'] : '')),
							'password' => array('password' => (isset($_POST['password']) ? $_POST['password'] : ''),
												'password2' =>  (isset($_POST['password2']) ? $_POST['password2'] : '')
											   ),
							'captcha' => array('recaptcha_challenge_field' => (isset($_POST['recaptcha_challenge_field']) ? $_POST['recaptcha_challenge_field'] : ''),
											   'recaptcha_response_field' => (isset($_POST['recaptcha_response_field']) ? $_POST['recaptcha_response_field'] : ''))
						  );
			$dotValidateUser = new Dot_Validate_User(array('who' => 'user', 'action' => 'add', 'values' => $values));
			if($dotValidateUser->isValid())
			{
				// no error - then add user
				$data = $dotValidateUser->getData();
				$userModel->addUser($data);
				$session->message['txt'] = $option->infoMessage->add;
				$session->message['type'] = 'info';
				//login user
				$userModel->authorizeLogin($data);
			}
			else
			{
				if(array_key_exists('password', $data))
				{
					// do not display password in the add form
					$data = $dotValidateUser->getData();
					unset($data['password']);
				}
			}
			// add action and validation are made with ajax, so return json string
			header('Content-type: application/json');  
			echo Zend_Json::encode(array('data'=>$dotValidateUser->getData(), 'error'=>$dotValidateUser->getError()));
			// return $data and $error as json
			exit;
		}
		$userView->details('add',$data);
	break;
	case 'forgot-password':
		// send an emai with the forgotten password
		$data = array();
		$error = array();
		if($_SERVER['REQUEST_METHOD'] === "POST")
		{
			$values = array('email' => array('email' => (isset($_POST['email']) ? $_POST['email'] : '' )));
			$dotValidateUser = new Dot_Validate_User(array('who' => 'user', 'action' => 'forgot-password', 'values' => $values));
			if($dotValidateUser->isValid())
			{
				// no error - then send password
				$data = $dotValidateUser->getData();
				$userModel->forgotPassword($data['email']);
			}
			else
			{
				$session->message['txt'] = $dotValidateUser->getError();
				$session->message['type'] = 'error';
			}
		}
		$userView->details('forgot_password',$data);
	break;
	case 'logout':
		$dotAuth = Dot_Auth::getInstance();
		$dotAuth->clearIdentity('user');
		header('location: '.$registry->configuration->website->params->url);
		exit;
	break;
}