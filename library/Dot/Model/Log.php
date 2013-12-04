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
* Log Model
* Here are all the actions related to the log
* @author  BunlE (n.khanhhoang@gmail.com)
*/

class Dot_Model_Log extends Dot_Model {
    
    /**
     * Constructor
     * @access public
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * save log activity 
     * @access public
     */
    public function saveLog($info = array()) {
        $this->db->insert('activity_log', $info);
    }
    
    /**
     * get all of the log activity
     * @access protected
     */
    public function getAllLog($page = 1) {
        $_select = $this->db->select()
                            ->from(array('a' => 'activity_log'))
                            ->joinLeft(array('b' => 'user'), 'a.iduser_id = b.id', 'username');
        $dotPaginator = new Dot_Paginator($_select, $page, $this->settings->resultsPerPage);
		return $dotPaginator->getData();
    }
    
    /**
     * 
     * @param type $field
     * @param type $value
     * @return type
     */
    public function getLogBy($field, $value) {
        $_select = $this->db->select()
                            ->from('activity_log')
                            ->where($field.'= ?', $value);
        return $this->db->fetchRow($_select);
    }
    /**
     * @descr delete log
     * @access public
     * @param type int $id
     * 
     */
    
    public function deleteLog($id) {
        $this->db->delete('activity_log', 'idactivity_log ='.$id);
    }
            
}