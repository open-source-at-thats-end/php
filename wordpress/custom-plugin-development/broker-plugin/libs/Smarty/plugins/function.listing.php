<?php
/**
 * Smarty {vw_listing} function plugin
 *
 * Type:     function<br>
 * Name:     vw_listing<br>
 * Purpose:  Return a html based on predefined template
 *
 * @author VarshaaWebLabs
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_listing($params, $template)
{
    $retHtml = "";
	
	/* Defaul Format defined in Parent Or Child Template, So append it to smarty varibles */
	if(isset($params['defaultTemplate']) && $params['defaultTemplate'] != '') {
		$template->tpl_vars['template'] = $params['defaultTemplate'];		
	}
	/* Defaul Field V
	alue defined in Parent Or Child Template, So append it to smarty varibles */
	if(isset($params['defaultValue']) && $params['defaultValue'] != '') {
		$template->tpl_vars['value'] = $params['defaultValue'];		
	}
	
	/* "Field" parameter received, replace fielad Caption and it's value in given template Or in defaultTemplate */
	if(isset($params['field']) && $params['field'] != '') {
		
		/* Note : Refer PARENT Template Varibles only for Record && FieldMapping array, It map happen that these variables overwrite in child template */
		
		// Array from which we can get Field title and it's data type
		$arrFieldMapping = $template->parent->tpl_vars['arrFiledMapping']->value;
		
		// Record from which we can get field's value
		$Record = $template->parent->tpl_vars['Record']->value;
									
		$fieldVal = "";
		
		// Check field value with database default value, if both are same means no value available for this field, so no need to display this field
		if(HBNUtility::getFieldDefaultValue($arrFieldMapping[$params['field']]['data_type']) != $Record[$params['field']])
		{
			$fieldVal = $Record[$params['field']];
		}
		// Check if default value set
		elseif(isset($template->tpl_vars['value'])/* || isset($params['value'])*/)
		{
			$fieldVal = $template->tpl_vars['value'];
			
			//if(isset($params['value']))
				//$fieldVal = $params['value'];
		}
				
		if($fieldVal != "")
		{
			// Default Format
			$template = $template->tpl_vars['template'];
			
			// custom template ? Let's use it
			if(isset($params['template']) && $params['template'] != "")
				$template = $params['template'];
			
			//$fieldVal = $Record[$params['field']];
			
			// Truncate Field Value
			if(isset($params['truncate']) && $params['truncate'] > 0)
			{
				require_once(SMARTY_PLUGINS_DIR . 'modifier.truncate.php');
				
				$fieldVal = smarty_modifier_truncate($fieldVal, $params['limit']);
			}
				
			// Format as Number
			if(isset($params['format']) && $params['format'] == "number" && $fieldVal > 0)
				$fieldVal = number_format($fieldVal, 0);
				
            //echo "<pre> Tempalte: "; print_r($template); echo "<br/>";
			// echo "<pre> Caption: "; print_r($arrFieldMapping[$params['field']]['caption']); echo "<br/>";
              //echo "<pre> FieldValue"; print_r($fieldVal); echo "<br/>";
            // Caption not required ? replace template with field value only
			if(isset($params['caption']) && $params['caption'] === false)
				$retHtml = sprintf($template, $fieldVal);
			else	
				$retHtml = sprintf($template, $arrFieldMapping[$params['field']]['caption'], $fieldVal);
		}		
	}
	
	return $retHtml;
}

?>