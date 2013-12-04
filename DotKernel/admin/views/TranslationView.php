<?php


/**
* System View Class
* class that prepare output related to Translation controller 
* @category   DotKernel
* @package    Admin 
*/

class Translation_View extends View
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
	 * List Translation
	 * @access public
	 * @param string $templateFile
	 * @param array $list
	 * @param int $page
	 * @return void
	 */
	public function listTranslation($templateFile, $list, $page)
	{

        $this->tpl->setFile('tpl_main', 'translation/' . $templateFile . '.tpl');       
        $this->tpl->setBlock('tpl_main', 'list', 'list_block');
		$this->tpl->paginator($list['pages']);
		$this->tpl->addUserToken();
		$this->tpl->setVar('PAGE', $page);
		foreach ($list['data'] as $k => $v)
		{
			$this->tpl->setVar('ID', $v['idtranslations']);
			$this->tpl->setVar('OSTRING', $v['original_string']);
			$this->tpl->setVar('TSTRING', $v['translated_string']);
			if($v['language'] == 'en-GB' ){
				$this->tpl->setVar('LANGUAGE', 'English');
			}else{
				$this->tpl->setVar('LANGUAGE', 'German');			
			}
			$this->tpl->parse('list_block', 'list', true);						
		}
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
		$this->tpl->setFile('tpl_main', 'translation/' . $templateFile . '.tpl');
		$this->tpl->addUserToken();

		foreach ($data as $k=>$v)
		{

       		$this->tpl->setVar(strtoupper($k), $v);
		    if( $k =='language'){
		    	$this->tpl->setVar( strtoupper($v), 'selected' );
		    }
		}
		
	}


}