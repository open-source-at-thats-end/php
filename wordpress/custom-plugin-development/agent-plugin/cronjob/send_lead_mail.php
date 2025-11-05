<?php
#=============================================================================================================================
#	File Name		:	send_lead_mail.php
#=============================================================================================================================
define('IN_CRON', 	true);

ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

ob_start();

# Store start time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_start = $mtime;

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

$arrPhysicalPath['UserBase'] 	= $arrPhysicalPath['Base']. 'front' . DS;
$arrPhysicalPath['TemplateBase']		= $arrPhysicalPath['UserBase']. 'templates' . DS;
$arrPhysicalPath['EmailTemplate']		=	$arrPhysicalPath['Base']. 'email_templates'. DS;

# Get the smarty and create global object
include_once $arrPhysicalPath['Libs']. 'Smarty/Smarty.class.php';

$objTmpl = new Smarty();

$objTmpl->template_dir 	= array($arrPhysicalPath['TemplateBase'], $arrPhysicalPath['EmailTemplate']);
$objTmpl->compile_dir 	= $arrPhysicalPath['UserBase']. 'templates_c';

$objAPI = IDXAPI::getInstance();

$sendlimit	=	10;
$rsMailData	= LPTLeadEmail::getInstance()->GetPendingMail($sendlimit);

print("Email Sending Start =============================== \n");

include($arrPhysicalPath['Libs']. '/PHPMailer/PHPMailerAutoload.php');
$cnt = 0;

while($rsMailData->next_record())
{

    global $mail;
    $mail = '';
    $mail = new PHPMailer();
    $mail->Subject = $rsMailData->f('ldemail_subject');
    $content = $rsMailData->f('ldemail_content');
    $mail->setFrom($rsMailData->f('ldemail_from_email'),$rsMailData->f('ldemail_from_name'));
    if($rsMailData->f('ldemail_use_header_footer') == 'Yes')
    {
        $objTmpl->assign(array( "Email_Header"		=>	'email_header.tpl' ,
        ));
    }

    $objTmpl->assign(array(
        "isContent"			=>	true,
        "Email_Body"		=>	$content.($rsMailData->f('ldemail_sign') ? '<br /><br />'.$rsMailData->f('ldemail_sign') : ''),
        "EmailSendFrom"		=>	$rsMailData->f('FromEmail'),
        "Use_HeaderFooter"	=>	$rsMailData->f('ldemail_use_header_footer'),
        "EmailType"	        =>	$rsMailData->f('ldemail_type'),
    ));

    $Main_Content   =   $objTmpl->fetch("search_email_layout.tpl");

file_put_contents("lead_email.html", print_r($Main_Content, true));
    $cc_email = '';
    if($rsMailData->f('ldemail_cc'))
    {
        $arrCcEmail = explode(",", $rsMailData->f('ldemail_cc'));

        $ccMails = array();

        for($i=0; $i<count($arrCcEmail); $i++)
        {
            if(strpos($arrCcEmail[$i], "|") !== false)
                array_push($ccMails, (substr($arrCcEmail[$i], strripos($arrCcEmail[$i], "|")+1)));
            else
                array_push($ccMails, $arrCcEmail[$i]);
        }

        $to_cc_email = implode(",", $ccMails);

        if($rsMailData->f('ldemail_ccother'))
        {
            $to_cc_other = stripslashes($rsMailData->f('ldemail_ccother'));
            $cc_email    = $to_cc_email.','.$to_cc_other;
        }
        else
            $cc_email    = $to_cc_email;
    }
    else
    {
        if($rsMailData->f('ldemail_ccother'))
            $cc_email = stripslashes($rsMailData->f('ldemail_ccother'));
    }

    if($cc_email != '')
    {
        $cc_email = explode(',',$cc_email);
        foreach($cc_email as $key => $value)
        {
            $mail->addCC($value);
        }
    }

    $mail->isHTML(true);
    $mail->Body = $Main_Content;

    if(is_array($Bcc) && count($Bcc) > 0)
    {
        foreach($Bcc as $Emailkey => $Emailvalue)
        {
            $Emailvalue= explode('|',$Emailvalue);

            if(isset($Emailvalue[1]) && !empty($Emailvalue[1]))
                $mail->addBCC($Emailvalue[0],$Emailvalue[1]);
            else
                $mail->addBCC($Emailvalue[0]);
        }
    }

    # Tem setting for old emails which have no entry for name in lead_email table.
    if($rsMailData->f('ldemail_to_email'))
    {
        $mail->addAddress($rsMailData->f('ldemail_to_email'),$rsMailData->f('ldemail_to_name'));
        //$result = $mail->send();
        $result = $mail->send(array($rsMailData->f('ldemail_to_name').' <'.$rsMailData->f('ldemail_to_email').'>'));
    }
    else
    {
        $mail->addAddress($rsMailData->f('ToEmail'), str_replace('_', ' ', $rsMailData->f('ToName')));
        //$result = $mail->send();
        $result = $mail->send(array(str_replace('_', ' ', $rsMailData->f('ToName')).' <'.$rsMailData->f('ToEmail').'>'));
    }

    #  update status
    LPTLeadEmail::getInstance()->UpdateMailStatus($rsMailData->f('ldemail_id'), 'Yes');

    $cnt++;
}
print "Count : ".$cnt."\n\n";

print("\nEmail Sending Finish =============================== \n");

# Check end time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_end 	= $mtime;

echo "\nResponse Time ". number_format($t_end-$t_start,2)." sec \n";
echo "\n==============================================\n";

$msg = ob_get_contents();
ob_end_clean();
echo $msg;

# Mail Time : Between 4:00:00 To 4:40:00
$periodFrom = date('G:i:s', mktime(4,0,0, date('n'), date('j'), date('Y')));
$curtime 	= date("G:i:s");
$periodTo 	= date('G:i:s', mktime(4,5,0, date('n'), date('j'), date('Y')));

if(strtotime($curtime) >= strtotime($periodFrom)  && strtotime($curtime) <= strtotime($periodTo))
    @mail(CRON_EMAIL_ADD, 'Send Lead Mail', $msg);
?>