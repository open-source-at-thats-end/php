<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))). DIRECTORY_SEPARATOR. 'wp-load.php');

if(isset($_GET['agent_mls']) && $_GET['agent_mls'] != '')
{
    $arrConfig['Site_Agent']['agent_mls'] = $_GET['agent_mls'];

    update_option(Constants::OPTIONS, $arrConfig);
}
?>