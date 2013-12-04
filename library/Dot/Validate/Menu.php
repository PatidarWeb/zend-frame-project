<?php
/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @package    DotLibrary
 * @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: User.php 713 2012-05-16 15:10:41Z andrei $
 */

 /**
 * Validate User
 * @category   DotKernel
 * @package    DotLibrary
 * @subpackage DotValidate
 * @see		   Dot_Validate
 * @author     DotKernel Team <team@dotkernel.com>
 */

class Dot_Validate_Menu extends Dot_Validate
{
	/**
	 * Validate user options
	 * Is an array with the following keys
	 * 			- who: string - for which type of user the validation is made (user, admin, ...)
	 * 			- action: string - from which action is called the validation(login, add, update, activate, ...)
	 * 			- values: array - what should validate
	 * 			- userId: integer - used for checking the uniqueness of the user(by username or email)
	 * @var array
	 * @access private
	 */
	private $_options = array('who' => 'menu',
														'action' => '',
														'values' => array(),
														'menuId' => 0);
	/**
	 * Valid data after validation
	 * @var array
	 * @access private
	 */
	private $_data = array();
	/**
	 * Errors found on validation
	 * @var array
	 * @access private
	 */
	private $_error = array();
	/**
	 * Constructor
	 * @access public
	 * @param array $options [optional]
	 * @return Dot_Validate
	 */
	public function __construct($options = array())
	{
		$this->option = Zend_Registry::get('option');
		foreach ($options as $key =>$value)
		{
			$this->_options[$key] = $value;
		}
	}
	/**
	 * Check if data is valid
	 * @access public
	 * @return bool
	 */
	public function isValid()
	{
		$this->_data = array();
		$this->_error = array();
		$values = $this->_options['values'];
		//validate the input data - username, password and email will be also filtered
		$validatorChain = new Zend_Validate();
		$dotFilter = new Dot_Filter();
        
		//validate details parameters
		if(array_key_exists('menu_title', $values))
		{
			$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => $this->option->validate->title->lengthMin)));
			$this->_callFilter($validatorChain, $values['menu_title']);
		}
		
        if(array_key_exists('menu_alias', $values))
		{
			$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => $this->option->validate->alias->lengthMin)));
			$this->_callFilter($validatorChain, $values['menu_alias']);
		}
        
		//validate details parameters
		if(array_key_exists('path', $values))
		{
			$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => $this->option->validate->path->lengthMin)));
			$this->_callFilter($validatorChain, $values['path']);
		}
		
		if(empty($this->_error))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	/**
	 * Get valid data
	 * @access public
	 * @return array
	 */
	public function getData()
	{
		return $this->_data;
	}
	/**
	 * Get errors encounter on validation
	 * @access public
	 * @return array
	 */
	public function getError()
	{
		return $this->_error;
	}
	/**
	 * Call filter method from DotFilter
	 * @access private
	 * @param Zend_Validate $validator
	 * @param array $values
	 * @return void
	 */
	private function _callFilter($validator, $values)
	{
		$dotFilter = new Dot_Filter(array('validator' => $validator, 'values' => $values));
		$dotFilter->filter();
		$this->_data = array_merge($this->_data, $dotFilter->getData());
		$this->_error = array_merge($this->_error, $dotFilter->getError());
	}
}
