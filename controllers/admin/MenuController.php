<?php

/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @package    Admin
 * @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: UserController.php 774 2013-06-05 15:20:09Z andrei $
 */
/**
 * User Controller
 * @author     DotKernel Team <team@dotkernel.com>
 */
// instantiate classes related to User module: model & view
$menuModel = new Menu();
$menuView = new Menu_View($tpl);
// all actions MUST set  the variable  $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
switch ($registry->requestAction) {
    case 'view':
        // list users
        $page = (isset($registry->request['page']) && $registry->request['page'] > 0) ? $registry->request['page'] : 1;
        $menus = $menuModel->getMenuList($page);
        $menuView->listMenu('view', $menus, $page);
        break;
    case 'add': 
        // display form and add new user
        $data = $_POST;
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            // POST values that will be validated
             $values = array(
                'menu_title' => array('menu_title' => isset($_POST['menu_title']) ? $_POST['menu_title'] : 0 ),
                'path' => array('path' => isset($_POST['path']) ? $_POST['path'] : 0 ),
                'menu_alias' => array('menu_alias' => isset($_POST['menu_alias']) ? $_POST['menu_alias'] : 0),
            );
            $tmp = array(
                'menu_type' => isset($_POST['menu_type']) ? $_POST['menu_type'] : 0 ,
                'is_deleted' => isset($_POST['is_deleted']) ? $_POST['is_deleted'] : 0 
            );
            
            $dotValidateMenu = new Dot_Validate_Menu(array('who' => 'menu', 'action' => 'add', 'values' => $values));
            if ($dotValidateMenu->isValid()) {
                // no error - then add user
                $data = array_merge($dotValidateMenu->getData(),$tmp);
                $menuModel->addMenu($data);
                $registry->session->message['txt'] = $option->infoMessage->menuAdd;
                $registry->session->message['type'] = 'info';
                
                // save visible options
                $typeVis = isset($_POST['type']) ? $_POST['type'] : null;
                $arrayVis = array(
                    'visibility' => $typeVis,
                    'idmenu_id' => $menuModel->getLastRecord()
                );
                
                switch ($typeVis) {
                    case 1:
                        $menuModel->saveVisible($arrayVis, $registry->request['id']);
                        break;
                    case 2:
                        saveOptionVis($menuModel, $arrayVis, $registry->request['id']);
                        break;
                    case 3:
                        saveOptionVis($menuModel, $arrayVis, $registry->request['id']);
                        break;
                }
                
                header('Location: ' . $registry->configuration->website->params->url . '/' . $registry->requestModule . '/' . $registry->requestController . '/view/');
                exit;
            } else {
                $registry->session->message['txt'] = $dotValidateMenu->getError();
                $registry->session->message['type'] = 'error';
            }
            $data = array_merge($dotValidateMenu->getData(),$tmp);
        }
        
        $visible  = $menuModel->listOption();
        $menuView->details('add', $data, $visible);
        break;
    case 'update':
                // display form and update user
        $error = array();
        if ($_SERVER['REQUEST_METHOD'] === "POST") { 
            // POST values that will be validated
            $values = array(
                'menu_title' => array('menu_title' => isset($_POST['menu_title']) ? $_POST['menu_title'] : 0 ),
                'path' => array('path' => isset($_POST['path']) ? $_POST['path'] : 0 ),
                'menu_alias' => array('menu_alias' => isset($_POST['menu_alias']) ? $_POST['menu_alias'] : 0),
            );
            $tmp = array(
                'menu_type' => isset($_POST['menu_type']) ? $_POST['menu_type'] : 0 ,
                'is_deleted' => isset($_POST['is_deleted']) ? $_POST['is_deleted'] : 0 
            );
            
            $dotValidateUser = new Dot_Validate_Menu(array('who' => 'menu', 'action' => 'update', 'values' => $values, 'menuId' => $registry->request['id']));
            if ($dotValidateUser->isValid()) {
                // no error - then update user
                $data = $dotValidateUser->getData();
                $data['idmenu'] = $registry->request['id'];
                $data = array_merge($tmp, $data);
                $menuModel->updateMenu($data);
                $registry->session->message['txt'] = $option->infoMessage->menuUpdate;
                $registry->session->message['type'] = 'info';
                
                // save visible options
                $menuModel->deleteVis($registry->request['id']);
                $typeVis = isset($_POST['type']) ? $_POST['type'] : null;
                $arrayVis = array(
                    'visibility' => $typeVis,
                    'idmenu_id' => $registry->request['id'],
                );
                
                switch ($typeVis) {
                    case 1:
                        $menuModel->saveVisible($arrayVis, $registry->request['id']);
                        break;
                    case 2:
                        saveOptionVis($menuModel, $arrayVis, $registry->request['id']);
                        break;
                    case 3:
                        saveOptionVis($menuModel, $arrayVis, $registry->request['id']);
                        break;
                }
                
                header('Location: ' . $registry->configuration->website->params->url . '/' . $registry->requestModule . '/' . $registry->requestController . '/view/');
                exit;
            } else {
                $registry->session->message['txt'] = $dotValidateUser->getError();
                $registry->session->message['type'] = 'error';
            }
        }
        $data = $menuModel->getMenuBy('idmenu', $registry->request['id']);
        $visible  = $menuModel->listOption();
        $menuView->setExtraBreadcrumb($data['menu_title']);
        $pageTitle .= ' "' . $data['menu_title'] . '"';
        $menuView->details('update', $data, $visible, $menuModel, $registry->request['id']);
        break;
    case 'delete':
        // display confirmation form and delete menu
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ('on' == $_POST['confirm']) {
                // delete user
                $menuModel->deleteMenu($registry->request['id']);
                $registry->session->message['txt'] = $option->infoMessage->menuDelete;
                $registry->session->message['type'] = 'info';
            } else {
                $registry->session->message['txt'] = $option->infoMessage->noMenuDelete;
                $registry->session->message['type'] = 'info';
            }
            header('Location: ' . $registry->configuration->website->params->url . '/' . $registry->requestModule . '/' . $registry->requestController . '/view/');
            exit;
        }
        if (!$registry->request['id']) {
            header('Location: ' . $registry->configuration->website->params->url . '/' . $registry->requestModule . '/' . $registry->requestController . '/view/');
            exit;
        }
        $data = $menuModel->getMenuBy('idmenu', $registry->request['id']);
        $menuView->setExtraBreadcrumb($data['menu_title']);
        $pageTitle .= ' "' . $data['menu_title'] . '"';
        // delete page confirmation
        $menuView->details('delete', $data);
        break;
    case 'option':
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
        }
        $data = $menuModel->listOption();
        $menuView->showOption('option', $data);
        break;
}

/**
 * 
 */
function saveOptionVis($_model, $_data, $_id)
{
    $routers = isset($_POST['Router']) ? $_POST['Router'] : array();
    if (!empty($routers))
    {
        $routers = array_unique($routers);
        foreach ($routers as $k => $v)
        {
            $_data = array_merge($_data, array('route' => $v));
            $_model->saveVisible($_data, $_id);
        }
    }
}