<?php
/*
 * Smarty plugin
 * ------------------------------------------------------------- 
 * File:     resource.email_template.php
 * Type:     resource
 * Name:     email_template
 * Purpose:  Fetches templates from a database
 * -------------------------------------------------------------
 */
function smarty_resource_email_template_source($email_name, &$email_source, $smarty)
{
    global $recContent;
  
    if($recContent != '') {
        
		$email_source = $recContent;
        return true;
    }
	else
	{
        return false;
    }
}

function smarty_resource_email_template_timestamp($email_name, &$email_timestamp, $smarty)
{
    global $recContent;
    
    if ($recContent != '') {
        $email_timestamp = time();
        return true;
    } else {
        return false;
    }
}

function smarty_resource_email_template_secure($email_name, $smarty)
{
    // assume all templates are secure
    return true;
}

function smarty_resource_email_template_trusted($email_name, $smarty)
{
    // not used for templates
}
?>
