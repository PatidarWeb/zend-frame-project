<?php


/**
* System View Class
* class that prepare output related to Message controller 
* @category   DotKernel
* @package    Admin 
*/

class Message_View extends View
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
	 * Display Translation details. It is used for add and update actions
	 * @access public
	 * @param string $templateFile
	 * @param array $data [optional]
	 * @return void
	 */

	public function details($templateFile, $data=array())
	{
		$this->tpl->setFile('tpl_main', 'message/' . $templateFile . '.tpl');
		$this->tpl->addUserToken();
		foreach ($data as $k=>$v)
		{
		    $this->tpl->setVar(strtoupper($k), $v);
		}
	}


}