<?php


class Dot_Validate_Message extends Dot_Validate
{
	
	private $_options = array('who' => 'user',
														'action' => '',
														'values' => array(),
														'userId' => 0);
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
		//validate the input data 
		$validatorChain = new Zend_Validate();
		$dotFilter = new Dot_Filter();

		//validate details message from
		if(array_key_exists('message_from', $values))
		{
    		$validatorChain->addValidator(new Zend_Validate_NotEmpty());
			$this->_callFilter($validatorChain, $values['message_from']);
		}
		//validate details message to
		if(array_key_exists('message_to', $values))
		{
    		$validatorChain->addValidator(new Zend_Validate_NotEmpty());
			$this->_callFilter($validatorChain, $values['message_to']);
		}
    	//validate details message subject
		if(array_key_exists('subject', $values))
		{
    		$validatorChain->addValidator(new Zend_Validate_NotEmpty());
			$this->_callFilter($validatorChain, $values['subject']);
		}
		//validate details message text
		if(array_key_exists('message_text', $values))
		{
    		$validatorChain->addValidator(new Zend_Validate_NotEmpty());
			$this->_callFilter($validatorChain, $values['message_text']);
		}
		//validate details message from email
		if(array_key_exists('message_from_email', $values))
		{
    		$validatorChain->addValidator(new Zend_Validate_EmailAddress());
			$this->_callFilter($validatorChain, $values['message_from_email']);
		}
		//validate details message to email
		if(array_key_exists('message_to_email', $values))
		{
    		$validatorChain->addValidator(new Zend_Validate_EmailAddress());
			$this->_callFilter($validatorChain, $values['message_to_email']);
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




	/**
	 * Check if user already exists - email, username, and return error
	 * @access private
	 * @param string $field
	 * @param string $value
	 * @return array
	 */
	private function _validateUnique($field, $value)
	{

		$error = array();
		//orginal string is unique, check if exists
		$exists = $this->_getStringBy($field, $value);

		if($this->_options['idtranslations'] > 0)
		{
			$currenttranslations = $this->_getStringBy('idtranslations', $this->_options['idtranslations']);
			$uniqueCondition = (is_array($exists) && $exists[$field] != $currenttranslations[$field]);
		}
		else
		{
			$uniqueCondition = (FALSE != $exists);
		}
		if($uniqueCondition)
		{
			$error[$field] = $this->option->infoMessage->translationExists;
		}
		return $error;
	}
	/**
	 * Get admin by field
	 * @access public
	 * @param string $field
	 * @param string $value
	 * @return array
	 */
	public function _getStringBy($field = '', $value = '')
	{

		
		$db = Zend_Registry::get('database');
		$select = $db->select()
									->from('translations')
									->where($field.' = ?', $value)
									->limit(1);
		$result = $db->fetchRow($select);
		return $result;
	}
}
