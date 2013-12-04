<?php

/**
* @package    Admin
* @version    $Id: TranslationController.php 
*/

// instantiate classes related to Translation module: model & view
$translationModel  = new Translation();
$translationView   = new Translation_View($tpl);
// all actions MUST set  the variable  $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
switch ($registry->requestAction)
{
	case 'list':

		//list Translation
		$page  = (isset($registry->request['page']) && $registry->request['page'] > 0) ? $registry->request['page'] : 1;
		$translation = $translationModel->getTranslationList($page);
		$translationView->listTranslation('translationlist', $translation, $page);
	break;

    case 'add':
		// display form and add new Translation
		$data = $_POST;
		if($_SERVER['REQUEST_METHOD'] === "POST")
		{
			Dot_Auth::checkUserToken();
			// POST values that will be validated
			$values = array(
							'original_string' => array('original_string' => $_POST['original_string']),
							'translated_string' => array('translated_string' => $_POST['translated_string']),
							'language' => array('language' => $_POST['language'])
						  );
			$dotValidateTranslation = new Dot_Validate_Translation(array('who' => 'user', 'action' => 'add', 'values' => $values,'idtranslations' =>0));
			if($dotValidateTranslation->isValid())
			{

				// no error - then add Translation     
                $result_array = $dotValidateTranslation->getData();
                //adding en Translation 
               	$translationModel->addTranslation($result_array);
				$registry->session->message['txt']  = $option->infoMessage->translationAdd;
				$registry->session->message['type'] = 'info';
				header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/list/');
				exit;
				
			}else{
                $registry->session->message['txt']  = $dotValidateTranslation->getError();
				$registry->session->message['type'] = 'error';
			}
			$data = $dotValidateTranslation->getData();
		}
		$translationView->details('translation_add',$data);
	break;
	case 'update':
		// display form and update Translation
		$error = array();
		if($_SERVER['REQUEST_METHOD'] === "POST")
		{
			Dot_Auth::checkUserToken();
			// POST values that will be validated
			$values = array(
							'original_string' => array('original_string' => $_POST['original_string']),
							'translated_string' => array('translated_string' => $_POST['translated_string']),
							'language' => array('language' => $_POST['language'])
						  );
			$dotValidateTranslation = new Dot_Validate_Translation(array('who' => 'user', 'action' => 'update', 'values' => $values, 'idtranslations' => $registry->request['id']));
			if($dotValidateTranslation->isValid())
			{
								
                 // no error - then add Translation     
                $result_array = $dotValidateTranslation->getData();
                //fetching trasalation information
                $id_data = $translationModel->getTranslationBy('idtranslations', $registry->request['id']);
                //checking valid result
                if( ! count($id_data) > 0 ){
             	 header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/list/');
			     exit;  
                }
                $translationModel->updateTranslation(array('idtranslations'=>$registry->request['id'],'original_string' => $_POST['original_string'],'translated_string' => $_POST['translated_string'],'language' => $_POST['language']));
           		$registry->session->message['txt']  = $option->infoMessage->translationUpdate;
				$registry->session->message['type'] = 'info';
				header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/list/');
				exit;
			}
			else
			{
				$registry->session->message['txt'] = $dotValidateTranslation->getError();
				$registry->session->message['type'] = 'error';
			}
		}

        //fetching orginal string value
		$data = $translationModel->getTranslationBy( 'idtranslations' , $registry->request['id'] );
		
        if( ! count($data) > 0 ){
        	header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/list/');
			exit;  
        }


        $data = array('idtranslations' => $registry->request['id'] ,'original_string' => $data['original_string'] , 'translated_string' =>$data['translated_string'],'language' => $data['language'] );
		$translationView->setExtraBreadcrumb($data['original_string']);
		$pageTitle .= ' "' . $data['original_string'] . '"';
		$translationView->details('update',$data);

	break;
	case 'delete':
		// display confirmation form and delete Translation
		if($_SERVER['REQUEST_METHOD'] === "POST")
		{
			Dot_Auth::checkUserToken();
			if ('on' == $_POST['confirm'])
			{
				$translationModel->deleteTranslation($registry->request['id']);
				$registry->session->message['txt'] = $option->infoMessage->translationDelete;
				$registry->session->message['type'] = 'info';
			}
			else
			{
				$registry->session->message['txt'] = $option->infoMessage->notranslationDelete;
				$registry->session->message['type'] = 'info';
			}
			header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/list/');
			exit;
		}
		if (!$registry->request['id'])
		{
			header('Location: '.$registry->configuration->website->params->url. '/' . $registry->requestModule . '/' . $registry->requestController. '/list/');
			exit;
		}
		$data = $translationModel->getTranslationBy('idtranslations', $registry->request['id']);
		$translationView->setExtraBreadcrumb($data['original_string']);
		$pageTitle .= ' "' . $data['original_string'] . '"';
		// delete page confirmation
		$translationView->details('delete', $data);
	break;
}