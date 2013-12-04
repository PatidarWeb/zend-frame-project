<?php
/**
 * @package    DotLibrary
 * @version    $Id: Language.php
 */

class Dot_Transalate_Language extends Dot_Model
{
   
   /**
   * Set content
   * @access public 
   * @param string $val
   */
   public function transalate($val = ''){
        //setting default language en
        $lang   = 'en-GB';
        $result = array();
        //checking selected language cookie $_COOKIE["language"]
        if(isset($_COOKIE["language"]) && $_COOKIE["language"] !="" ){
        	$lang  = $_COOKIE["language"];
        }
        if($val !="" ){
          $select = $this->db->select('translated_string')
					   ->from('translations')
					   ->where(' original_string = ?', $val)
					   ->where(' language = ?', $lang )
					   ->limit(1);
		      $result = $this->db->fetchRow($select);
          $out = array_key_exists('translated_string', $result) ? $result['translated_string'] :'No transalation found';
		      return $out;

        }else{
          //for empty string 	
          return '';
        }

   }

 
}