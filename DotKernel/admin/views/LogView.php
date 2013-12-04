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

class Log_View extends View {
    
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
     * 
     * @param type $templateFile
     * @param type $list
     * @param type $page
     */
    public function listLog($templateFile, $list, $page)
	{
		$this->tpl->setFile('tpl_main', 'log/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'list_log', 'list_log_block');
		$this->tpl->paginator($list['pages']);
		$this->tpl->setVar('PAGE', $page);

        foreach ($list['data'] as $k => $v)
		{
            $this->tpl->setVar('IDACTIVITY_LOG', $v['idactivity_log']);
			$this->tpl->setVar('USER_LOG', $v['username']);
			$this->tpl->setVar('ACTIVITY', $v['activity']);
			$this->tpl->setVar('ACTIVITY_DESCRIPTION', $v['activity_description']);
			$this->tpl->setVar('ACTIVE_TIME', $v['activity_time']);
            $this->tpl->parse('list_log_block', 'list_log', true);
        }
        
    }
    
    /**
	 * Display user details. It is used for add and update actions
	 * @access public
	 * @param string $templateFile
	 * @param array $data [optional]
	 * @return void
	 */
	public function details($templateFile, $data=array())
	{
		$this->tpl->setFile('tpl_main', 'log/' . $templateFile . '.tpl');
        if(!empty($data)):
            foreach ($data as $k=>$v)
            {
                $this->tpl->setVar(strtoupper($k), $v);
            }
        endif;
	}
}