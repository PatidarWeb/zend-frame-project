<?php
/**
* DotBoost Technologies Inc.
* DotKernel Application Framework
*
* @category   DotKernel
* @package    Admin
* @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @version    $Id: User.php 715 2012-05-16 15:56:52Z adi $
*/

/**
* User Model
* Here are all the actions related to the user
* @category   DotKernel
* @package    Admin
* @author     DotKernel Team <team@dotkernel.com>
*/
class Menu extends Dot_Model
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
	 * Get user list
	 * @access public
	 * @param int $page [optional]
	 * @return array
	 */
	public function getMenuList($page = 1)
	{
		$select = $this->db->select()
						   ->from('menu');
 		$dotPaginator = new Dot_Paginator($select, $page, $this->settings->resultsPerPage);
		return $dotPaginator->getData();
	}
    
    public function getMenuBy($field, $value)
    {
        $select = $this->db->select()
                           ->from('menu')
                           ->where($field .'= ?', $value);
        $result = $this->db->fetchRow($select);
        return $result;
    }
	/**
	 * Delete user
	 * @param int $id
	 * @return void
	 */
	public function deleteMenu($id)
	{
		$this->db->delete('menu', 'idmenu ='. $id);
	}
    
    /**
     *@ HoangNguyen
     * Update menu
     * @param type $id
     */
    public function updateMenu($data)
    {
        $id = $data['idmenu'];
		unset ($data['idmenu']);
		$this->db->update('menu', $data, 'idmenu = '.$id);
    }
    
    /**
     * @HoangNguyen
     * add new item menu
     * @param type $data
     */
    public function addMenu($data)
	{		
		$this->db->insert('menu', $data);
	}
    
    /**
     * @author HOANGNGUYEN
     * @access public
     * @param avoid
     * @return array
     * 
     */
    public function listOption()
    {
        $_select = $this->db->select()
                 ->from('menu');
        return $this->db->fetchAll($_select);
    }
    
    /**
     * @author HOANGNGUYEN
     * @access public
     * @param type $_data
     */
    public function saveVisible($_data, $_id)
    {
        $this->db->insert('menu_visibility', $_data);
    }
    
    /**
     * @author HOANGNGUYEN
     * @access public
     * @param int $_id
     */
    public function deleteVis($_id = null)
    {
        $this->db->delete('menu_visibility', 'idmenu_id = '. $_id);
    }

    /**
     * @author HOANGNGUYEN
     * @access public
     * @return int id lastest menu
     */
    public function getLastRecord()
    {
        $_select = $this->db->select('idmenu')
                 ->from('menu')
                 ->order('idmenu desc')
                 ->limit(1);
        
        $_data = $this->db->fetchRow($_select);
        return $_data['idmenu'];
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
