<?php

/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @package    Frontend
 * @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: View.php 708 2012-05-15 16:43:03Z andrei $
 */

/**
 * View Model
 * abstract over the Dot_Template class
 * @category   DotKernel
 * @package    Frontend
 * @author     DotKernel Team <team@dotkernel.com>
 */
class View extends Dot_Template {

    /**
     * Singleton instance
     * @access protected
     * @static
     * @var Dot_Template
     */
    protected static $_instance = null;

    /**
     * Returns an instance of Dot_View
     * Singleton pattern implementation
     * @access public
     * @param string $root     Template root directory
     * @param string $unknowns How to handle unknown variables
     * @param array  $fallback Fallback paths
     * @return Dot_Template
     */
    public static function getInstance($root = '.', $unknowns = 'remove', $fallback = '') {
        if (null === self::$_instance) {
            self::$_instance = new self($root, $unknowns, $fallback);
        }
        return self::$_instance;
    }

    /**
     * Initalize some parameter
     * @access public
     * @return void
     */
    public function init() {
        $this->requestModule = Zend_Registry::get('requestModule');
        $this->requestController = Zend_Registry::get('requestController');
        $this->requestAction = Zend_Registry::get('requestAction');
        $this->config = Zend_Registry::get('configuration');
        $this->seo = Zend_Registry::get('seo');
    }

    /**
     * Set the template file
     * @access public 
     * @return void
     */
    public function setViewFile() {
        $this->setFile('tpl_index', 'index.tpl');
    }

    /**
     * Set different paths url(site, templates, images)
     * @access public
     * @return void
     */
    public function setViewPaths() {
        $this->setVar('TEMPLATES_URL', $this->config->website->params->url . TEMPLATES_DIR);
        $this->setVar('IMAGES_URL', $this->config->website->params->url . IMAGES_DIR . '/' . $this->requestModule);
        $this->setVar('SITE_URL', $this->config->website->params->url);
    }

    /**
     * Set SEO values
     * @access public
     * @param string $pageTitle [optional]
     * @return void
     */
    public function setSeoValues($pageTitle = '') {
        $this->setVar('PAGE_KEYWORDS', $this->seo->defaultMetaKeywords);
        $this->setVar('PAGE_DESCRIPTION', $this->seo->defaultMetaDescription);
        $this->setVar('PAGE_TITLE', $this->seo->defaultPageTitle . ' | ' . $pageTitle);
        $this->setVar('PAGE_CONTENT_TITLE', $pageTitle);
        $this->setVar('SITE_NAME', $this->seo->siteName);
        $this->setVar('CANONICAL_URL', $this->seo->canonicalUrl);
    }

    /**
     * Display the menus
     * @access public 
     * @return void
     */
    public function setMenuLeft($model, $pos = 2) {
        $dotAuth = Dot_Auth::getInstance();
        $registry = Zend_Registry::getInstance();

        // this template variable will be replaced with "selected"
        $selectedItem = "SEL_" . strtoupper($registry->requestController . "_" . $registry->requestAction);

        // sidebar menu
        $this->setFile('tpl_menu_sidebar', 'blocks/menu_sidebar.tpl');
        $this->setBlock('tpl_menu_sidebar', 'sidebar_menu_1', 'sidebar_menu_1_block');
        $this->setBlock('tpl_menu_sidebar', 'sidebar_menu_logged', 'sidebar_menu_logged_block');
        $this->setBlock('tpl_menu_sidebar', 'sidebar_menu_not_logged', 'sidebar_menu_not_logged_block');

        // add selected to the correct menu item
        $this->setVar($selectedItem, 'selected');

        if ($dotAuth->hasIdentity('user')) {
            $this->parse('sidebar_menu_logged_block', 'sidebar_menu_logged', true);
            $this->parse('sidebar_menu_not_logged_block', '');
        } else {
            $this->parse('sidebar_menu_not_logged_block', 'sidebar_menu_not_logged', true);
            $this->parse('sidebar_menu_logged_block', '');
        }

        foreach ($model->getByPos($pos) as $k => $v) {
            $_vis = $model->getVis($v['idmenu']);
            foreach ($_vis as $key => $value)
            {
                if (isset($value['route']))
                {
                    if(substr($value['route'], 1) === $registry->requestAction)
                    {
                        $this->setVar('MENU_TITLE', $v['menu_title']);
                        $this->setVar('PATH', $v['path']);
                        $this->parse('sidebar_menu_1_block', 'sidebar_menu_1', true);
                    }
                }
                else
                {
                    $this->setVar('MENU_TITLE', $v['menu_title']);
                    $this->setVar('PATH', $v['path']);
                    $this->parse('sidebar_menu_1_block', 'sidebar_menu_1', true);
                }
            }
        }

        $this->parse('MENU_SIDEBAR', 'tpl_menu_sidebar');
    }

    /**
     * Display the menus
     * @access public 
     * @return void
     */
    public function setMenuTop($model, $pos = 1) {
        $dotAuth = Dot_Auth::getInstance();
        $registry = Zend_Registry::getInstance();

        // this template variable will be replaced with "selected"
        $selectedItem = "SEL_" . strtoupper($registry->requestController . "_" . $registry->requestAction);

        // top menu
        $this->setFile('tpl_menu_top', 'blocks/menu_top.tpl');
        $this->setBlock('tpl_menu_top', 'top_menu_1', 'top_menu_1_block');
        $this->setBlock('tpl_menu_top', 'top_menu_not_logged', 'top_menu_not_logged_block');
        $this->setBlock('tpl_menu_top', 'top_menu_logged', 'top_menu_logged_block');

        // add selected to the correct menu item
        $this->setVar($selectedItem, 'selected');

        if ($dotAuth->hasIdentity('user')) {
            $this->parse('top_menu_logged_block', 'top_menu_logged', true);
            $this->parse('top_menu_not_logged_block', '');
        } else {
            $this->parse('top_menu_not_logged_block', 'top_menu_not_logged', true);
            $this->parse('top_menu_logged_block', '');
        }
        
        foreach ($model->getByPos($pos) as $k => $v) {
            $_vis = $model->getVis($v['idmenu']);
            foreach ($_vis as $key => $value)
            {
                if (isset($value['route']))
                {
                    if(substr($value['route'], 1) === $registry->requestAction)
                    {
                        $this->setVar('TITLE', $v['menu_title']);
                        $this->setVar('LINK', $v['path']);
                        $this->parse('top_menu_1_block', 'top_menu_1', true);
                    }
                }
                else
                {
                    $this->setVar('TITLE', $v['menu_title']);
                    $this->setVar('LINK', $v['path']);
                    $this->parse('top_menu_1_block', 'top_menu_1', true);
                }
            }
        }
        $this->parse('MENU_TOP', 'tpl_menu_top');
    }

    /**
     * Display the menus
     * @access public 
     * @return void
     */
    public function setMenuBottom($model, $pos = 3) {
        $dotAuth = Dot_Auth::getInstance();
        $registry = Zend_Registry::getInstance();

        // this template variable will be replaced with "selected"
        $selectedItem = "SEL_" . strtoupper($registry->requestController . "_" . $registry->requestAction);

        // footer menu
        $this->setFile('tpl_menu_footer', 'blocks/menu_footer.tpl');
        $this->setBlock('tpl_menu_footer', 'footer_menu', 'footer_menu_block');
        // add selected to the correct menu item
        $this->setVar($selectedItem, 'selected');
        foreach ($model->getByPos($pos) as $k => $v) {
            $_vis = $model->getVis($v['idmenu']);
            foreach ($_vis as $key => $value)
            {
                if (isset($value['route']))
                {
                    if(substr($value['route'], 1) === $registry->requestAction)
                    {
                        $this->setVar('TITLE', $v['menu_title']);
                        $this->setVar('LINK', $v['path']);
                        $this->parse('footer_menu_block', 'footer_menu', true);
                    }
                }
                else
                {
                    $this->setVar('TITLE', $v['menu_title']);
                    $this->setVar('LINK', $v['path']);
                    $this->parse('footer_menu_block', 'footer_menu', true);
                }
            }
        }
        $this->parse('MENU_FOOTER', 'tpl_menu_footer');
    }

    /**
     * Display message - error, warning, info
     * @access public
     * @return void
     */
    public function displayMessage() {
        $session = Zend_Registry::get('session');
        if (isset($session->message)) {
            $this->setFile('tpl_msg', 'blocks/message.tpl');
            $this->setBlock('tpl_msg', 'msg_array', 'msg_array_row');
            $this->setVar('MESSAGE_TYPE', $session->message['type']);
            if (is_array($session->message['txt'])) {
                foreach ($session->message['txt'] as $k => $msg) {
                    $this->setVar('MESSAGE_ARRAY', is_string($k) ? $msg = ucfirst($k) . ' - ' . $msg : $msg);
                    $this->parse('msg_array_row', 'msg_array', true);
                }
            } else {
                $this->parse('msg_array_row', '');
                $this->setVar('MESSAGE_STRING', $session->message['txt']);
            }
            $this->parse('MESSAGE_BLOCK', 'tpl_msg');
            unset($session->message);
        }
    }

    /**
     * Add the user's token to the template
     * @access public
     * @return array
     */
    public function addUserToken() {
        $dotAuth = Dot_Auth::getInstance();
        $user = $dotAuth->getIdentity('user');
        $this->setVar('USERTOKEN', Dot_Auth::generateUserToken($user->password));
    }

    /**
     * Get captcha display box using Zend_Service_ReCaptcha api
     * @access public
     * @return Zend_Service_ReCaptcha
     */
    public function getRecaptcha() {
        $option = Zend_Registry::get('option');
        // add secure image using ReCaptcha
        $recaptcha = new Zend_Service_ReCaptcha($option->captchaOptions->recaptchaPublicKey, $option->captchaOptions->recaptchaPrivateKey);
        $recaptcha->setOptions($option->captchaOptions->toArray());
        return $recaptcha;
    }

    /**
     * Display the specific menu that was declared in configs/menu.xml file
     * @access public
     * @return void
     */
    public function setViewMenu() 
    {
        $menu_xml = new Zend_Config_Xml(CONFIGURATION_PATH . '/' . $this->requestModule . '/' . 'menu.xml', 'config');
        $menus = $menu_xml->menu;
        // if we have only one menu, Zend_Config_Xml return a simple array, not an array with key 0(zero)
        if (is_null($menus->{0})) {
            $menus = new Zend_Config(array(0 => $menu_xml->menu));
        }
        $menus = $menus->toArray();
        
        foreach ($menus as $menu) {
            // check wether the text following the ">" in the breadcrumb has been set
            $breadcrumbItem2Set = false;
            //don't display the menu if display is set to 0, or it doesn't have the ID of 1
            if (0 == $menu['display'])
                continue;
            if (1 != $menu['id'])
                continue;

            $this->setFile('tpl_menu', 'blocks/menu.tpl');

            $items = $menu['item'];
            // if we have only one menu, Zend_Config_Xml return a simple array, not an array with key 0(zero)
            if (!isset($items[0])) {
                $items = array(0 => $items);
            }
            

            $this->setBlock('tpl_menu', 'breadcrums', 'breadcrums_block');

            foreach ($items as $menuItem) {
                
                if (false !== stripos($menuItem['link'], $this->requestController . '/')) { //if current menu is the current viewed page
                    $this->setVar('BREADCRUMB_TITLE_1', $menuItem['title']);
                    $this->setVar('BREADCRUMB_LINK_1', $this->config->website->params->url . '/' . $this->requestModule . '/' . $menuItem['link']);
                    $this->setVar('BREADCRUMB_DESCRIPTION_1', $menuItem['description']);
                }
                
                $subItems = $menuItem['subItems']['subItem'];
                if (!isset($subItems[0])) {
                    $subItems = array(0 => $subItems);
                }

                foreach ($subItems as $subMenuItem) {
                    if (false !== stripos($subMenuItem['link'], $this->requestController . '/' . $this->requestAction . '/')) { //if current submenu is the current viewed page
                        $this->setVar('BREADCRUMB_TITLE_2', $subMenuItem['title']);
                        $this->setVar('BREADCRUMB_LINK_2', $this->config->website->params->url . '/' . $this->requestModule . '/' . $subMenuItem['link']);
                        $this->setVar('BREADCRUMB_DESCRIPTION_2', $subMenuItem['description']);
                        $breadcrumbItem2Set = true;
                    } 
                }
               
            }

            if (!$breadcrumbItem2Set) {
                // the second segment of the breadcrumb hasn't been set
                // this means that the action that is requested doesn't exist in menu.xml
                // in that case use the action name as the text (replace dashes with spaces and use ucwords)
                $this->setVar('BREADCRUMB_TITLE_2', ucwords(str_replace('-', ' ', $this->requestAction)));
                $this->setVar('BREADCRUMB_LINK_2', "");
            }
        }
        $this->parse('breadcrums_block', 'breadcrums', true);
        $this->parse('BREADCRUMS', 'tpl_menu');
    }

}
