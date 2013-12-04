<?php

/**
* @package    Admin
* @version    $Id: MessageController.php 
*/

// instantiate classes related to Message module: model & view
$messageModel  = new Message();
$messageView   = new Message_View($tpl);
// all actions MUST set  the variable  $pageTitle

$pageTitle = $option->pageTitle->action->{$registry->requestAction};

switch ($registry->requestAction)
{
	case 'compose':
		// display form and add new message
       	$data = $_POST;
		if($_SERVER['REQUEST_METHOD'] === "POST")
		{
			Dot_Auth::checkUserToken();
			// POST values that will be validated
			$values = array(
							'message_from' => array('message_from' => $_POST['message_from']),
							'message_from_email' => array('message_from_email' => $_POST['message_from_email']),
							'message_to' => array('message_to' => $_POST['message_to']),
							'message_to_email' => array('message_to_email' => $_POST['message_to_email']),
							'subject' => array('subject' => $_POST['subject']),
							'message_text' => array('message_text' => $_POST['message_text'])
						  );
			$dotValidateMessage = new Dot_Validate_Message(array('who' => 'user', 'action' => 'compose', 'values' => $values));
			if($dotValidateMessage->isValid())
			{

				// no error - then add Message   
                $result = $dotValidateMessage->getData();
                $result['parent'] = 0;
                $result['message_date'] = time();
               	$messageModel->addMessage($result);
				
                //sending email
                $mail = new Zend_Mail();
                $mail->setBodyHTML($result['message_text']);
                $mail->setFrom($result['message_from_email'], $result['message_from']);
                $mail->addTo($result['message_to_email'], $result['message_to']);
                $mail->setSubject($result['subject']);
               # $mail->send();

                $registry->session->message['txt']  = $option->infoMessage->messageSent;
				$registry->session->message['type'] = 'info';
				header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/compose/');
				exit;
				
			}else{
                $registry->session->message['txt']  = $dotValidateMessage->getError();
				$registry->session->message['type'] = 'error';
			}
			$data = $dotValidateMessage->getData();
		}
		$messageView->details('compose',$data);
	break;
	
}