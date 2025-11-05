<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     array_key_search<br>
 * Date:     Aug 16, 2013
 * Purpose:  Searches the array for a given key and returns the corresponding value if successful
 * Input:<br>
 *         - needle = mixed needle
 *         - haystack = array haystack 
 *         - strict = strict check
 * Example:  {$needle|in_array:$haystack:$strict}
 * @version  1.0
 * @author MS
 * @param string
 * @return string
 */
function smarty_modifier_array_key_search($needle, $haystack, $strict=false)
{			
	if(!is_array($haystack))
		return false;

		
	foreach($haystack as $key=>$val) {
		if($key == $needle)
			return $val;
		
		if(is_array($val)) {
			$val = smarty_modifier_array_key_search($needle, $val, $strict);
			if($val !== false)
				return $val;
		}
	}
	
	return false;
}

?>
