<?php
/**
* DotBoost Technologies Inc.
* DotKernel Application Framework
*
* @category   DotKernel
* @package    Frontend
* @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
* @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
* @version    $Id: User.php 708 2012-05-15 16:43:03Z andrei $
*/

/**
* User Model
* Here are all the actions related to the user
* @category   DotKernel
* @package    Frontend
* @author     DotKernel Team <team@dotkernel.com>
*/

class Menu extends Dot_Model
{
	
    /**
	 * Constructor
	 * @access public 
	 * @return User
	 */
    public function __construct() {
        parent::__construct();
    }
	/**
	 * Get user info
	 * @access public
	 * @param int $id
	 * @return array
	 */
	public function getByPos($pos)
	{
		$select = $this->db->select()
					   ->from('menu')->where('menu_type = ?', $pos);
		return $this->db->fetchAll($select);
	}
    
    /**
     * @author HOANGNGUYEN
     * @access public
     * @return array
     */
    public function fetchAllVisible()
	{
		$select = $this->db->select()
					   ->from('menu')->where('status = ?',1);
		return $this->db->fetchAll($select);
	}
    
    /**
     * @author HOANGNGUYEN
     * @param int $_id
     * @return array 
     */
    public function getVis($_id)
    {
        $_query = $this->db->select()
                           ->from('menu_visibility')
                           ->where('idmenu_id = ?', $_id);
        return $this->db->fetchAll($_query);
    }
	
}