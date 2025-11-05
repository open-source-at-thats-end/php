<?php
/*
This script is to setup automation for property data.
Need to get property building data from myresman API and insert data in to database.
*/
define('IN_CRON', 	true);

ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

ob_start();
include_once("cron_common.php");
/*file_put_contents('Test1.txt',print_r(var_dump(file_exists($_SERVER['DOCUMENT_ROOT']. INSTALL_DIR. "/includes/common.php"),true)));*/
include_once($_SERVER['DOCUMENT_ROOT']."/includes/common.php");

include_once($physical_path['DB_Access']. '/Entrata.php');

$objentrata = new Entrata(true);


global $db;
//$con = new mysqli("localhost","usr_onecamelback",'GeJIEE}M54!B',"db_onecamelback");
//ini_set("max_execution_time", 14400);
/*$curl = curl_init();
ini_set("max_execution_time", 14400);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.myresman.com/MITS/GetMarketing4_0',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'IntegrationPartnerID=StellarResAPI&ApiKey=45EiCSAXare2SwzTtxyj4POn10eUZ7I%2B&AccountID=1399&PropertyID=d4bc8796-329f-483d-9345-ad236850573a',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',

    ),
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,

));


$result = curl_exec($curl);

if( false === $result ) {
    echo 'Curl error: ' . curl_error($curl);
    curl_close($curl);
} else {
    curl_close($curl);
    //return $result;
}

echo '<pre>';print_r(json_decode($result));die();*/


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.myresman.com/MITS/GetMarketing4_0',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'IntegrationPartnerID=StellarResAPI&ApiKey=45EiCSAXare2SwzTtxyj4POn10eUZ7I%2B&AccountID=1399&PropertyID=d4bc8796-329f-483d-9345-ad236850573a',
    CURLOPT_HTTPHEADER => array(
        'Accept: application/XML',
        'Content-Type: application/x-www-form-urlencoded'
    ),
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,

));

$result = curl_exec($curl);

if( false === $result ) {
    echo 'Curl error: ' . curl_error($curl);
    curl_close($curl);
} else {
    curl_close($curl);
    //return $result;
}
//file_put_contents('data.html',$result);
//file_put_contents('data1.html',$result);
file_put_contents('data.xml',print_r($result,true));
$retArr = file_get_contents('data.xml');

$loadContent = simplexml_load_string($retArr);
$arrData = json_decode(json_encode($loadContent),true);
$arrUnitData = $arrData['Response']['PhysicalProperty']['Property']['ILS_Unit'];
//echo '<pre>'; print_r($arrUnitData);die();

$unitNumber = array();
foreach($arrUnitData as $numberData){
    foreach($numberData as $key => $data) {
        //echo '<pre>'; print_r($key);
        //echo '<pre>'; print_r($data);

        if($key == 'Units')
        {
            $unit = $data['Unit'];
            $unitNumber[$data['Unit']['MarketingName']]['unitNumber'] = $data['Unit']['MarketingName'];
            $unitNumber[$data['Unit']['MarketingName']]['floorplanName'] = $data['Unit']['FloorplanName'];
            $unitNumber[$data['Unit']['MarketingName']]['floorplanCode'] = $data['Unit']['UnitType'];
            $unitNumber[$data['Unit']['MarketingName']]['bedroom'] = $data['Unit']['UnitBedrooms'];
            $unitNumber[$data['Unit']['MarketingName']]['bathroom'] = $data['Unit']['UnitBathrooms'];
            $unitNumber[$data['Unit']['MarketingName']]['sqft'] = $data['Unit']['MinSquareFeet'];
            $unitNumber[$data['Unit']['MarketingName']]['sqftMin'] = $data['Unit']['MinSquareFeet'];
            $unitNumber[$data['Unit']['MarketingName']]['sqftMax'] = $data['Unit']['MaxSquareFeet'];
            $unitNumber[$data['Unit']['MarketingName']]['rent'] = $data['Unit']['MarketRent'];
            $unitNumber[$data['Unit']['MarketingName']]['building'] = $data['Unit']['BuildingName'];

            if ($data['Unit']['UnitLeasedStatus'] == 'available') {
                $unitNumber[$data['Unit']['MarketingName']]['Availability'] = 0;
            }
            elseif ($data['Unit']['UnitLeasedStatus'] == 'unavailable')
            {
                $unitNumber[$data['Unit']['MarketingName']]['Availability'] = 1;
            }
        }
        if($key == 'Deposit')
        {
           // echo '<pre>'; print_r($data['Amount']['ValueRange']['@attributes']['Exact']);
           $unitNumber[$unit['MarketingName']]['deposit'] = $data['Amount']['ValueRange']['@attributes']['Exact'];
        }
        if ($key == 'Availability')
        {
            //$date = implode('/',$data['VacateDate']['@attributes']);
            $date = implode('/',$data['MadeReadyDate']['@attributes']);
            $unitNumber[$unit['MarketingName']]['availableOn'] = date('Y-m-d',strtotime($date));
        }

    }
}//die;
/*echo '<pre>'; print_r($unitNumber);
die;*/
#=============== Start API PropertyUnits ===============

$curlUrl = curl_init();

curl_setopt_array($curlUrl, array(
    CURLOPT_URL => 'https://api.myresman.com/Property/GetUnits',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'IntegrationPartnerID=StellarResAPI&ApiKey=45EiCSAXare2SwzTtxyj4POn10eUZ7I%2B&AccountID=1399&PropertyID=d4bc8796-329f-483d-9345-ad236850573a',
    CURLOPT_HTTPHEADER => array(
        'Accept: application/XML',
        'Content-Type: application/x-www-form-urlencoded'
    ),
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,

));

$response = curl_exec($curlUrl);

if( false === $response ) {
    echo 'Curl error: ' . curl_error($curlUrl);
    curl_close($curlUrl);
} else {
    curl_close($curlUrl);
}

file_put_contents('dataPropertyUnits.xml',print_r($response,true));
$retArr = file_get_contents('dataPropertyUnits.xml');

$arrPropertyUnitsData = simplexml_load_string($response);

foreach($arrPropertyUnitsData as $unitsNumberData){
    foreach($unitsNumberData as $k => $v) {
        if($k == 'Unit')
        {
            $unitNumber[(string)$v->UnitNumber]['unitId'] = (string)$v->UnitId;
        }
    }
}

#=============== End API PropertyUnits ===============
//echo "<pre>";print_r($unitNumber);die;
$truncate = "TRUNCATE TABLE `entrata_table`";
$execute = $db->query($truncate);

$final = array();
foreach($unitNumber as $unitdat){
    $finalList = $unitdat;

    $convertible=($finalList['floorplanName']=="Convertible")?1:0;
    
    $arr = explode('Affordable',$unitdat['floorplanCode']);
    
    $furl = str_replace(' ','',$arr[0]).'.jpg';

    $sel = "select * from entrata_table where unitNumber ='".$finalList['unitNumber']."'";
    $execute = $db->query($sel);
    if($r = $execute->fetch_object()){

        echo $updateQuery = "UPDATE `entrata_table` SET `floorplanCode` = '".$finalList['floorplanCode']."',`building` = '".$finalList['building']."',floorplanName='".$finalList['floorplanName']."',sqftMin='".$finalList['sqftMin']."',sqftMax = '".$finalList['sqftMax']."',bedroom = '".$finalList['bedroom']."',bathroom = '".$finalList['bathroom']."',rent = '".$finalList['rent']."', deposit = '".$finalList['deposit']."',availability = '".$finalList['Availability']."', convertible='".$convertible."',sqft='".$finalList['sqft']."', availableOn='".$finalList['availableOn']."', `unitId` = '".$finalList['unitId']."', `3dfurl` = '".$furl."', `2dfurl` = '".$furl."' WHERE `entrata_table`.`unitNumber` ='".$finalList['unitNumber']."'";
        echo "<br><br>";
        $execute = $db->query($updateQuery);
    }
    else
    {
        echo $inserQuery = "INSERT INTO `entrata_table` (`unitNumber`, `floorplanCode`, `building`, `floorplanName`, `sqftMin`, `sqftMax`, `bedroom`, `bathroom`, `rent`, `deposit`, `term`, `availability`,`convertible`,`sqft`,`availableOn`,`unitId`,`2dfurl`,`3dfurl`) VALUES
        ('".$finalList['unitNumber']."','".$finalList['floorplanCode']."', '".$finalList['building']."','".$finalList['floorplanName']."','".$finalList['sqftMin']."', '".$finalList['sqftMax']."','".$finalList['bedroom']."','".$finalList['bathroom']."','".$finalList['rent']."','".$finalList['deposit']."','12','".$finalList['Availability']."','".$convertible."','".$finalList['sqft']."','".$finalList['availableOn']."','".$finalList['unitId']."','".strtolower($furl)."','".strtolower($furl)."')";
        echo "<br><br>";

        $execute = $db->query($inserQuery);
    }

}

echo $deleteQuery = "DELETE FROM `entrata_table` WHERE `entrata_table`.`availability` = ''";
echo "<br><br>";
$execute = $db->query($deleteQuery);
file_put_contents('api.txt','success');


$POST['facilities_name'] = 'north';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET north = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}
$POST['facilities_name'] = 'east';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET east = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}
$POST['facilities_name'] = 'west';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET west = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}
$POST['facilities_name'] = 'south';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET south = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}

//file_put_contents('insertfacilities1.txt','done');
//echo 'Facilities inserted successfully';

# Uptown Collection
$POST['facilities_name'] = 'uptown';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET uptown = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}

# City View
$POST['facilities_name'] = 'cityview';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam,'');

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET cityview = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}

# Valley View
$POST['facilities_name'] = 'valleyview';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET valleyview = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}

# Mountain View
$POST['facilities_name'] = 'mountainview';
$addparam   = $objentrata->getQueryParameters($POST);
$data       = $objentrata->getAll($addparam);

while($data->next_record()){

    $sql =	" UPDATE ". $objentrata->Data['TableName']." SET mountainview = 1 " ;
    $sql .= " WHERE id = ".$data->f('id');
    $rs = $db->query($sql);
}

//file_put_contents('facilities.txt','done');
//echo 'Facilities inserted successfully';

# Check end time
$mtime 	= microtime();
$mtime 	= explode(" ",$mtime);
$mtime 	= $mtime[1] + $mtime[0];
$t_end 	= $mtime;

echo "\nRespons=e Time ". number_format($t_end-$t_start,2)." sec \n";
echo "\n=============================================\n";

$msg = ob_get_contents();

file_put_contents('cron.txt','success');
ob_end_clean();
?>
