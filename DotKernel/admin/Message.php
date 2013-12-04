<?php


/**
* Message Model
* Here are all the actions related to the Translation
* @category   DotKernel
* @package    Admin
*
*/

class Message extends Dot_Model
{
	/**
	 * Constructor
	 * @access public
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Add new message
	 * @access public
	 * @param array $data
	 * @return void
	 */
	public function addMessage($data)
	{		
       $this->db->insert('messages',$data);
	}
	/**
	 * Send forgot password to user
	 * @access public
	 * @param int id
	 * @return void
	 */
	public function sendMail($result = array())
	{
		$dotEmail = new Dot_Email();
		$dotEmail->addTo($value['email']);
		$dotEmail->setSubject();
		$dotEmail->setBodyText($msg);
		$succeed = $dotEmail->send();

	}
	
}
