<?php
/**
* DotBoost Technologies Inc.
* DotKernel Application Framework
*
* @category   DotKernel
* @package    Admin
* @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @version    $Id: UserView.php 715 2012-05-16 15:56:52Z adi $
*/

/**
* User View Class
* class that prepare output related to User controller
* @category   DotKernel
* @package    Admin
* @author     DotKernel Team <team@dotkernel.com>
*/

class Menu_View extends View
{
	/**
	 * Constructor
	 * @access public
	 * @param Dot_Template $tpl
	 */
	public function __construct($tpl)
	{
		$this->tpl = $tpl;
		$this->settings = Zend_Registry::get('settings');
		$this->session = Zend_Registry::get('session');
	}
	/**
	 * List users
	 * @access public
	 * @param string $templateFile
	 * @param array $list
	 * @param int $page
	 * @param bool $ajax - Using ajax, parse only the list content
	 * @return void
	 */
	public function listMenu($templateFile, $list, $page)
	{
		$this->tpl->setFile('tpl_main', 'menu/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'list', 'list_block');
		$this->tpl->paginator($list['pages']);
		$this->tpl->setVar('PAGE', $page);

        foreach ($list['data'] as $k => $v)
		{
			$this->tpl->setVar('ID', $v['idmenu']);
			$this->tpl->setVar('TITLE', $v['menu_title']);
			$this->tpl->setVar('PATH', $v['path']);
			$this->tpl->setVar('ALIAS', $v['menu_alias']);
            switch ($v['menu_type']) {
                case 1:
                    $this->tpl->setVar('SHOW_ON','Top');
                    break;
                case 2:
                    $this->tpl->setVar('SHOW_ON','Left');
                    break;
                default:
                    $this->tpl->setVar('SHOW_ON', 'Bottom');
                    break;
            }
			$this->tpl->parse('list_block', 'list', true);
		}
	}
	/**
	 * Display user details. It is used for add and update actions
	 * @access public
	 * @param string $templateFile
	 * @param array $data [optional]
	 * @return void
	 */
	public function details($templateFile, $data=array(), $visible = array(), $model = null, $_id = null)
	{
		$this->tpl->setFile('tpl_main', 'menu/' . $templateFile . '.tpl');
        
        if(!empty($data)):
            foreach ($data as $k=>$v)
            {
                $this->tpl->setVar(strtoupper($k), $v);
            }
            switch($data['menu_type'])
            {
                case 1:
                    $this->tpl->setVar('MENU_TYPE_'.$data['menu_type'], 'selected');
                    break;
                case 2:
                    $this->tpl->setVar('MENU_TYPE_'.$data['menu_type'], 'selected');
                    break;
                case 3:
                    $this->tpl->setVar('MENU_TYPE_'.$data['menu_type'], 'selected');
                    break;
            }
        endif;
        // visible/invisble of each pages
        if(!empty($visible))
        {
            $this->tpl->setBlock('tpl_main', 'menu_top', 'menu_top_block');
            $this->tpl->setBlock('tpl_main', 'menu_left', 'menu_left_block');
            $this->tpl->setBlock('tpl_main', 'menu_bottom', 'menu_bottom_block');
            $i = 1;
            $_dataVis = $model->getVis($_id);
            
            foreach ($visible as $k => $v)
            {
                $route = substr($v['path'], 5);
                $check = $this->selectedVis($route, $_dataVis);
                if($check)
                {
                    $this->tpl->setVar('CHECKED','checked');
                }
                else
                {
                    $this->tpl->setVar('CHECKED','');
                }
                if($v['menu_type'] == 1)
                {
                    $this->tpl->setVar('NAME_1','Router['.$i.']');
                    $this->tpl->setVar('VALUE_1', substr($v['path'],5));
                    $this->tpl->setVar('MENU_TITLE_1', $v['menu_title']);
                    $this->tpl->parse('menu_top_block', 'menu_top', true);
                }
                if($v['menu_type'] == 2)
                {
                    $this->tpl->setVar('NAME_2', 'Router['.$i.']');
                    $this->tpl->setVar('VALUE_2', substr($v['path'],5));
                    $this->tpl->setVar('MENU_TITLE_2', $v['menu_title']);
                    $this->tpl->parse('menu_left_block', 'menu_left', true);
                }
                if($v['menu_type'] == 3)
                {
                    $this->tpl->setVar('VALUE_3', substr($v['path'],5));
                    $this->tpl->setVar('NAME_3', 'Router['.$i.']');
                    $this->tpl->setVar('MENU_TITLE_3', $v['menu_title']);
                    $this->tpl->parse('menu_bottom_block', 'menu_bottom', true);
                }
                $i++;
            }
        }
	}
    
    /**
     * 
     * @param type $templateFile
     * @param type $data
     */
    public function showOption($templateFile, $data=array())
	{
		$this->tpl->setFile('tpl_main', 'menu/' . $templateFile . '.tpl');
        $this->tpl->setBlock('tpl_main', 'menu_top', 'menu_top_block');
        $this->tpl->setBlock('tpl_main', 'menu_left', 'menu_left_block');
        $this->tpl->setBlock('tpl_main', 'menu_bottom', 'menu_bottom_block');
        if(!empty($data))
        {
            foreach($data as $k => $v)
            {
                
                if($v['menu_type'] == 1)
                {
                    $this->tpl->setVar('MENU_TITLE', $v['menu_title']);
                    $this->tpl->setVar('MENU_TITLE_1', $v['menu_title']);
                    $this->tpl->parse('menu_top_block', 'menu_top', true);
                }
                if($v['menu_type'] == 2)
                {
                    $this->tpl->setVar('MENU_TITLE', $v['menu_title']);
                    $this->tpl->setVar('MENU_TITLE_2', $v['menu_title']);
                    $this->tpl->parse('menu_left_block', 'menu_left', true);
                }
                if($v['menu_type'] == 3)
                {
                    $this->tpl->setVar('MENU_TITLE', $v['menu_title']);
                    $this->tpl->setVar('MENU_TITLE_3', $v['menu_title']);
                    $this->tpl->parse('menu_bottom_block', 'menu_bottom', true);
                }
            }
            
        }
	}
	/**
	 * Display user logins list
	 * @access public
	 * @param string $templateFile
	 * @param array $list
	 * @param int $page
	 * @param int $browser
	 * @param int $loginDate
	 * @param int $sortField
	 * @param int $orderBy
	 * @return void
	 */
	public function loginsUser($templateFile, $list, $page, $browser, $loginDate, $sortField, $orderBy)
	{
		$dotGeoip = new Dot_Geoip();
		$geoIpWorking = TRUE;
		$this->tpl->setFile('tpl_main', 'user/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'browser', 'browser_row');
		$xml = new Zend_Config_Xml(CONFIGURATION_PATH.'/useragent/browser.xml');
		$browserArray = $xml->name->type->toArray();
		foreach ($browserArray as $key => $val)
		{
			$this->tpl->setVar('BROWSERNAME', ucfirst($val['uaBrowser']));
			if ( strtolower($val['uaBrowser']) == strtolower($browser) )
			{
				$this->tpl->setVar('BROWSERSEL', 'selected');
			}
			else
			{
				$this->tpl->setVar('BROWSERSEL', '');
			}
			$this->tpl->parse('browser_row', 'browser', true);

		}
		$this->tpl->setVar('FILTERDATE', $loginDate);
		$this->tpl->setBlock('tpl_main', 'list', 'list_block');
		$this->tpl->paginator($list['pages']);
		$this->tpl->setVar('PAGE', $page);
		$this->tpl->setVar('FILTER_URL', '/admin/user/logins');

		$sortableFields = array('username', 'dateLogin');
		foreach ($sortableFields as $field)
		{
			$linkSort = '/admin/user/logins/sort/'.$field.'/order/';
			$linkSort .= ($orderBy == 'asc') ? 'desc' : 'asc';
			$this->tpl->setVar('LINK_SORT_'.strtoupper($field), $linkSort);
			if($field != $sortField)
			{
				$sortClass = 'sortable';
			}
			elseif($orderBy == 'asc')
			{
				$sortClass = 'sort_up';
			}
			else
			{
				$sortClass = 'sort_down';
			}
			$this->tpl->setVar('CLASS_SORT_'.strtoupper($field), $sortClass);
		}

		foreach ($list['data'] as $k => $v)
		{
			$country = $dotGeoip->getCountryByIp($v['ip']);
			if($country['response'] != 'OK' && $geoIpWorking === TRUE)
			{
				$geoIpWorking = FALSE;
				$this->session->message['txt'] = $country['response'];
				$this->session->message['type'] = 'warning';
			}
			$this->tpl->setVar('ID', $v['id']);
			$this->tpl->setVar('USERID', $v['userId']);
			$this->tpl->setVar('USERNAME', $v['username']);
			$this->tpl->setVar('IP', $v['ip']);
			$this->tpl->setVar('COUNTRYIMAGE', strtolower($country[0]));
			$this->tpl->setVar('COUNTRYNAME', $country[1]);
			$this->tpl->setVar('REFERER', $v['referer']);
			$this->tpl->setVar('WHOISURL', $this->settings->whoisUrl);
			$this->tpl->setVar('USERAGENT', $v['userAgent']);
			$this->tpl->setVar('BROWSERIMAGE', Dot_UserAgent::getBrowserIcon($v['userAgent']));
			$os = Dot_UserAgent::getOsIcon($v['userAgent']);
			$this->tpl->setVar('OSIMAGE', $os['icon']);
			$this->tpl->setVar('OSMAJOR', $os['major']);
			$this->tpl->setVar('OSMINOR', $os['minor']);
			$this->tpl->setVar('DATELOGIN', Dot_Kernel::timeFormat($v['dateLogin'], 'long'));
			$this->tpl->parse('list_block', 'list', true);
		}
	}
    
    /**
     * 
     * @param type $_id
     */
    public function selectedVis($route, $data) {
       
        foreach ($data as $k => $v)
        {
            if($v['route'] == $route)
            {
                return true;
            }
        }
        return false;
    }
            
}