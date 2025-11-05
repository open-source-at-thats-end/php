<?php

#=============================================================================================================================
#	File Name		:	cronjob/update_crypto_data.php
#=============================================================================================================================
define('IN_CRON', 	true);

ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

ob_start();

ini_set("memory_limit","512M");  	  # set memory to 50Meg
ini_set("max_execution_time", 14400); # 10 minutes should be sufficent? ( 10 minutes * 60 seconds = 600 seconds)

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

try
{
    global $arrConfig;

    # Store start time
    $mtime   = microtime();
    $mtime   = explode(" ", $mtime);
    $mtime   = $mtime[1] + $mtime[0];
    $t_start = $mtime;

    print("Crypto Data Processing Started =============================== <br><br>\n\n");

    // set API Endpoint and API key
    $endpoint = 'live';
    $access_key = Constants::COINLAYER_ACCESS_KEY;

    // Initialize CURL:
    $ch = curl_init('http://api.coinlayer.com/api/'.$endpoint.'?access_key='.$access_key.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Store the data:
    $json = curl_exec($ch);
    curl_close($ch);

    // Decode JSON response:
    $exchangeRates = json_decode($json, true);

    $arrConfig['bitcoin']   = $exchangeRates['rates']['BTC'];
    $arrConfig['etherium']  = $exchangeRates['rates']['ETH'];
    $arrConfig['cardano']   = $exchangeRates['rates']['ADA'];

    update_option(Constants::OPTIONS, $arrConfig);
    //add_option('bitcoin', $exchangeRates['rates']['BTC']);
    //add_option('etherium', $exchangeRates['rates']['ETH']);
    //add_option('cardano', $exchangeRates['rates']['ADA']);
    update_option('bitcoin', $exchangeRates['rates']['BTC']);
    update_option('etherium', $exchangeRates['rates']['ETH']);
    update_option('cardano', $exchangeRates['rates']['ADA']);
}
catch(Exception $e)
{
    $last_run_status = "Fail";
    $message = $e->getMessage();
}

# Check end time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_end 	= $mtime;

print("\n Crypto Data Processing Finished =============================== \n");

echo "\nResponse Time ". number_format($t_end-$t_start,2)." sec \n";
echo "\n==============================================\n";

$msg = ob_get_contents();

$db->db_close();

ob_end_clean();
echo $msg;

# Mail Time : Between 4:00:00 To 4:40:00
$periodFrom = date('G:i:s', mktime(4,0,0, date('n'), date('j'), date('Y')));
$curtime 	= date("G:i:s");
$periodTo 	= date('G:i:s', mktime(4,5,0, date('n'), date('j'), date('Y')));

/*if(strtotime($curtime) >= strtotime($periodFrom)  && strtotime($curtime) <= strtotime($periodTo))
    @mail(CRON_EMAIL_ADD, $config['site_title'].': Trigger Auto Suggestion Data Process', $msg);*/
?>