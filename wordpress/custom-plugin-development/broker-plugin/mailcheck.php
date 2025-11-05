<?php

require_once(dirname(dirname(dirname(dirname(__FILE__)))). DIRECTORY_SEPARATOR. 'wp-load.php');

$user_id    = $_GET['user_id'];
$idemail_id = $_GET['ldemail_id'];

if(isset($user_id) && $user_id != '' && isset($idemail_id) && $idemail_id != '')
{
    global $objDB;

    $sql = " UPDATE lead_email SET".
           " ldemail_open_datetime = '".date('Y-m-d H:i:s')."', ldemail_open_count = ldemail_open_count + 1".
           " WHERE ldemail_id=".$idemail_id." AND ldemail_user_id=".$user_id;

    $rs = $objDB->query($sql);

    return $rs;
}

?>