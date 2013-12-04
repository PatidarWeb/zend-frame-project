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
// instantiate classes related to Log module: model & view

$modelLog =  new Log();
$viewLog =  new Log_View($tpl);
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
switch ($registry->requestAction) {
    case 'view':
        // List all of the log
        $page = (isset($registry->request['page']) && $registry->request['page'] > 0) ? $registry->request['page'] : 1;
        $_data = $modelLog->getAllLog($page);
        $viewLog->listLog('view', $_data, $page);
        break;

    case 'delete':
        // display confirmation form and delete menu
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ('on' == $_POST['confirm']) {
                // delete user
                $modelLog->deleteLog($registry->request['id']);
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
        $data = $modelLog->getLogBy('idactivity_log', $registry->request['id']);
        $viewLog->setExtraBreadcrumb($data['activity']);
        $pageTitle .= ' "' . $data['activity'] . '"';
        // delete page confirmation
        $viewLog->details('delete', $data);
        break;
}


    