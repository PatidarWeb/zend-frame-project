<?php


/**
* Translation Model
* Here are all the actions related to the Translation
* @category   DotKernel
* @package    Admin
*
*/

class Translation extends Dot_Model
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
	 * Get translation list
	 * @access public
	 * @param int $page [optional]
	 * @return array
	 */
	public function getTranslationList($page = 1)
	{

		$select = $this->db->select()->from('translations')->order('original_string');
 		$dotPaginator = new Dot_Paginator($select, $page, $this->settings->resultsPerPage);
		return $dotPaginator->getData();
	}

	/**
	 * Delete translation 
	 * @param int $id
	 * @return void
	 */
	
	public function deleteTranslation($id)
	{
		$this->db->delete('translations', 'idtranslations = '. $id );
	}


	/**
	 * Get Translation by field
	 * @access public
	 * @param string $field
	 * @param string $value
	 * @return array
	 */
	public function getTranslationBy($field = '', $value = '')
	{
		$select = $this->db->select()
					   ->from('translations')
					   ->where($field.' = ?', $value)
					   ->limit(1);
		$result = $this->db->fetchRow($select);
		return $result;
	}


	/**
	 * Get Translation by field orginal string value
	 * @access public
	 * @param string $field
	 * @param string $value
	 * @return array
	 */
	public function getTranslationByString($value = '')
	{
		$select = $this->db->select()
					   ->from('translations')
					   ->where('original_string = ?', $value);
		$result = $this->db->fetchAll($select);
		return $result;
	}

	/**
	 * Update Translation
	 * @access public
	 * @param array $data
	 * @return void
	 */
	public function updateTranslation($data)
	{
        $id = $data['idtranslations'];
		unset ($data['idtranslations']);
		$this->db->update('translations', $data, 'idtranslations = '.$id);
	}
	/**
	 * Add new Translation
	 * @access public
	 * @param array $data
	 * @return void
	 */
	public function addTranslation($data)
	{		
       $this->db->insert('translations',$data);
	}
	
}
