<?php
/**
 * Smarty {vw_consumer_tool} function plugin
 *
 * Type:     function<br>
 * Name:     vw_consumer_tool<br>
 * Purpose:  Return a html based on given tool type
 *
 * @author VarshaaWebLabs
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_consumer_tool($params, $template)
{
    $retHtml = "";
	
	/* Defaul Format defined in Parent Or Child Template, So append it to smarty varibles */
	if(isset($params['defaultTag']) && $params['defaultTag'] != '') {
		$template->tpl_vars['tag'] = $params['defaultTag'];		
	}
	
	/* Check if Type of tool given */
	if(isset($params['tool']) && $params['tool'] != '')
	{		
		// Current MLS Record 
		$Record = $template->parent->tpl_vars['Record']->value;
		
		// Default tag
		$tag = $template->tpl_vars['tag'];
		
		// custom template ? Let's use it
		if(isset($params['tag']) && $params['tag'] != "")
			$tag = $params['tag'];
		
		// Tool Type
		$params['tool'] 	= strtolower($params['tool']);
		
		// Tool Title
		$title 				= $params['title'];		
		
		switch($params['tool'])
		{
			case "schedule-showing":
					$title = $title ? $title : "Schedule Showing";
					
					$retHtml = "<$tag data-consumer-tool=\"".$params['tool']."\" data-mlsnum=\"".$Record['mls_number']."\" data-do=\"show\" class=\"consumer-tool schedule-showing\" >$title</$tag>";
				break;
				
			case "email-to-friend":
					$title = $title ? $title : "Email to Friend";
					
					$retHtml = "<$tag data-consumer-tool=\"".$params['tool']."\" data-mlsnum=\"".$Record['mls_number']."\" data-do=\"show\" class=\"consumer-tool email-to-friend\">$title</$tag>";
				break;
				
			case "mortgage-calculator":
					$title = $title ? $title : "Mortgage Calculator";					
			
					$retHtml = "<$tag data-consumer-tool=\"".$params['tool']."\" data-mlsnum=\"".$Record['mls_number']."\" data-do=\"show\" class=\"consumer-tool mortgage-calculator\">$title</$tag>";	
				break;
			
			case "print-brochure":
					$title = $title ? $title : "Print Brochure";					
			
					$retHtml = "<$tag data-consumer-tool=\"".$params['tool']."\" data-mlsnum=\"".$Record['mls_number']."\" data-do=\"show\" data-link=\"".$Record['full_details_url']."?action=print\" class=\"consumer-tool print-brochure\">$title</$tag>";	
				break;
		}
	}
	
	return $retHtml;
}
?>