<?php
/*
This script is to setup automation for property floor plan data.
Need to get data and save in database.
*/
define('IN_CRON', 	true);

//$con =new mysqli("localhost","westend_root","westend@77","2010westend_db_live");

//Getfloorplanlist

$curl = curl_init();
ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

include_once("cron_common.php");
include_once($_SERVER['DOCUMENT_ROOT']. INSTALL_DIR. "/includes/common.php");

global $db;
//echo 123; die;

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://pegasusresidentialinc.onesite.realpage.com/WebServices/CrossFire/AvailabilityAndPricing/FloorPlan.asmx',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <UserAuthInfo xmlns="http://realpage.com/webservices">
      <UserName>Highform</UserName>
      <Password>Pegasus22!</Password>
      <SiteID>4909739</SiteID>
      <PmcID>1469095</PmcID>
      <InternalUser></InternalUser> 
     </UserAuthInfo>
  </soap:Header>
  <soap:Body>
    <GetFloorPlanList xmlns="http://realpage.com/webservices">
        <listCriteria>
        <ListCriterion>
          <Name>FloorPlanName</Name>
        </ListCriterion>
      </listCriteria>
    </GetFloorPlanList>
  </soap:Body>
</soap:Envelope>',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: text/xml; charset=utf-8',
        'POST: /WebServices/CrossFire/AvailabilityAndPricing/PickLis.asmx/HTTP 1.1t',
        'SOAPAction: http://realpage.com/webservices/List',
        'Host: pegasusresidentialinc.onesite.realpage.com',
        'Cookie: ASP.NET_SessionId=2zgsii45tg2o5krx5hbi5xiu'
    ),
));

$GetFloorPlanList = curl_exec($curl);
$xmldata = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $GetFloorPlanList);
$xmldata = new SimpleXMLElement($xmldata);
//echo '<pre>';print_r($xmldata);die;
$arrFloorPlanData = $xmldata->soapBody->ListResponse->ListResult->FloorPlanObject;
//echo '<pre>';print_r($arrFloorPlanData);die;

$date=date('Y-m-d',strtotime('+30 days'));
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://pegasusresidentialinc.onesite.realpage.com/WebServices/CrossFire/AvailabilityAndPricing/Unit.asmx',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Header>
                <UserAuthInfo xmlns="http://realpage.com/webservices">
                  <UserName>Highform</UserName>
                  <Password>Pegasus22!</Password>
                  <SiteID>4909739</SiteID>
                  <PmcID>1469095</PmcID>
                </UserAuthInfo>
              </soap:Header>
              <soap:Body>
                <List xmlns="http://realpage.com/webservices">
                  <listCriteria>
                    <ListCriterion>
                      <Name>IncludeRentMatrix</Name>
                      <SingleValue>True</SingleValue>
                    </ListCriterion>        <ListCriterion>
                      <Name>DateNeeded</Name>
                      <SingleValue>'.$date.'</SingleValue>
                    </ListCriterion>
                    <ListCriterion>
                      <Name>LimitResults</Name>
                      <SingleValue>False</SingleValue>
                    </ListCriterion>
                  </listCriteria>
                </List>
              </soap:Body>
            </soap:Envelope>',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: text/xml; charset=utf-8',
        'SOAPAction: http://realpage.com/webservices/List',
        'Host: pegasusresidentialinc.onesite.realpage.com',
        'Cookie: ASP.NET_SessionId=2zgsii45tg2o5krx5hbi5xiu'
    ),
));

$response = curl_exec($curl);
$xmldata1 = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $response);
$xmldata1 = new SimpleXMLElement($xmldata1);
//echo '<pre>'; print_r($xmldata1); die;
$arrunitsPriceData = $xmldata1->soapBody->ListResponse->ListResult->UnitObject;


//GetUnitData
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://pegasusresidentialinc.onesite.realpage.com/WebServices/CrossFire/AvailabilityAndPricing/Unit.asmx',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <UserAuthInfo xmlns="http://realpage.com/webservices">
      <UserName>Highform</UserName>
      <Password>Pegasus22!</Password>
      <SiteID>4909739</SiteID>
      <PmcID>1469095</PmcID>
    </UserAuthInfo>
    <CallBackAuthInfo xmlns="http://realpage.com/webservices">
      <SiteID>4909739</SiteID>
      <PmcID>1469095</PmcID>
    </CallBackAuthInfo>
  </soap:Header>
  <soap:Body>
    <GetUnitsByProperty xmlns="http://realpage.com/webservices">
        <Name>FloorPlanName</Name>
    </GetUnitsByProperty>
  </soap:Body>
</soap:Envelope>',
    CURLOPT_HTTPHEADER => array(
        'SOAPAction: http://realpage.com/webservices/GetUnitsByProperty',
        'Content-Type: text/xml; charset=utf-8',
        'POST: /WebServices/CrossFire/AvailabilityAndPricing/FloorPlan.asmx/HTTP 1.1',
        'Host: pegasusresidentialinc.onesite.realpage.com',
        'Authorization: Basic ZGlnaXRhbEBoaWdoZm9ybS5jb206SDFnaGYwcm0yMDA=',
        'Cookie: ASP.NET_SessionId=2zgsii45tg2o5krx5hbi5xiu'
    ),
));



$GetUnitsByProperty = curl_exec($curl);

$xmldata = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $GetUnitsByProperty);
$xmldata = new SimpleXMLElement($xmldata);
$arrunitsData = $xmldata->soapBody->GetUnitsByPropertyResponse->GetUnitsByPropertyResult->UnitObject;
//echo '<pre>'; print_r($arrunitsData); die;

$unitNumber = array();

foreach($arrunitsData as $key=> $val){

    foreach ($arrunitsPriceData as $k2=>$v2)
    {
          //echo (string)$v2->Address->UnitNumber.'<br>';

        if((string)$val->UnitNumber === (string)$v2->Address->UnitNumber && (string)$v2->Address->UnitNumber != '')
        {
            //echo '<pre>'; print_r($v2);
            //  echo 123; die;
            foreach($v2->rentMatrix->row as $k=>$v){
                //echo '<pre>'; print_r($v);
                $arr= (array)$v;
                 //echo '<pre>';print_r($arr['@attributes']);
                $unitNumber[(string)$val->UnitNumber]['BaseRent'] = $arr['@attributes']['MinRent'];

            }
            // echo (string)$v2->Address->UnitNumber.'=';
        }
        // data base open kar

        //echo '<pre>'; print_r($val);

        if(isset($val->UnitNumber) && $val->UnitNumber != '')
        {
            $unitNumber[(string)$val->UnitNumber]['UnitNumber'] = (string)$val->UnitNumber;
            $unitNumber[(string)$val->UnitNumber]['FloorPlanId'] = (string)$val->FloorplanID;
            $unitNumber[(string)$val->UnitNumber]['Sqft'] = (string)$val->GrossSqFtCount;
            //$unitNumber[(string)$val->UnitNumber]['BaseRent'] = (string)$val->BaseRentAmount;
            $unitNumber[(string)$val->UnitNumber]['Deposit'] = (string)$val->DepositAmount;
            $unitNumber[(string)$val->UnitNumber]['AvailableDate'] = (string)$val->MadeReadyDate;
            $unitNumber[(string)$val->UnitNumber]['Availability'] = (string)$val->AvailableBit;
            $unitNumber[(string)$val->UnitNumber]['UnitId'] = (string)$val->UnitID;

            // if($val->UnitNumber == )

        }
    }
}//die;
//echo '<pre>';print_r($unitNumber);die;
$finaldata = array();


foreach($unitNumber as $unitdata) {
    foreach ($arrFloorPlanData as $key1 => $val1) {
        if ((string)$val1->FloorPlanID === $unitdata['FloorPlanId']) {

            $arrFloorplancode = explode('-',(string)$val1->FloorPlanCode);

            $unitdata['FloorPlanCode'] = $arrFloorplancode[0];
            $unitdata['BedRoom'] = (string)$val1->Bedrooms;
            $unitdata['BathRoom'] = (string)$val1->Bathrooms;
            $unitdata['FloorPlanDescription'] = (string)$val1->FloorPlanNameMarketing;
            if ($unitdata['Availability'] == 'true') {
                $unitdata['Availabilityunit'] = '0';
            } elseif ($unitdata['Availability'] == 'false') {
                $unitdata['Availabilityunit'] = '1';
            }
            $finaldata = $unitdata;
            $convertible = ($unitdata['FloorPlanCode'] == "Convertible") ? 1 : 0;
            //$image2d =  strtolower($finaldata['FloorPlanCode']);

            $finaldata['FloorPlanCode']    =   str_replace('67535','',$finaldata['FloorPlanCode']);
           // $finaldata['UnitNumber']    =   preg_replace( "/^0/", '', $finaldata['UnitNumber']);

            $sel = "select * from entrata_table where unitNumber='" . $finaldata['UnitNumber'] . "'";
             //echo $sel;die;
             $execute = $db->query($sel);
             if ($r = $execute->fetch_object()) {
             
                 $updateQuery = "UPDATE `entrata_table` SET `floorplanCode` = '" . $finaldata['FloorPlanCode'] . "',floorplanName='" . $finaldata['FloorPlanDescription'] . "',sqftMin='" . $finaldata['Sqft'] . "',sqftMax = '" . $finaldata['Sqft'] . "',bedroom = '" . $finaldata['BedRoom'] . "',bathroom = '" . $finaldata['BathRoom'] . "',rent = '" . $finaldata['BaseRent'] . "', deposit = '" . $finaldata['Deposit'] . "',availability = '" . $finaldata['Availabilityunit'] . "', convertible='" . $convertible . "',sqft='" . $finaldata['Sqft'] . "', availableOn='" . $finaldata['AvailableDate'] . "', floorplan_id = '" . $finaldata['FloorPlanId'] . "',`unitid`='". $finaldata['UnitId'] .  "' WHERE `entrata_table`.`unitNumber` ='" . $finaldata['UnitNumber'] . "'";
                 //echo $updateQuery = "UPDATE `entrata_table` SET `floorplanCode` = '" . $finaldata['FloorPlanCode'] . "',floorplanName='" . $finaldata['FloorPlanDescription'] . "',sqftMin='" . $finaldata['Sqft'] . "',sqftMax = '" . $finaldata['Sqft'] . "',bedroom = '" . $finaldata['BedRoom'] . "',bathroom = '" . $finaldata['BathRoom'] . "',rent = '" . $finaldata['Rent'] . "', deposit = '" . $finaldata['Deposit'] . "',availability = '" . $finaldata['Availabilityunit'] . "', convertible='" . $convertible . "',sqft='" . $finaldata['Sqft'] . "', availableOn='" . $finaldata['AvailableDate'] . "', floorplan_id = '" . $finaldata['FloorPlanId'] . "', unit_space_id = '" . $finalList['unitSpaceId'] . "', webvisible = '" . $finalList['WebVisible'] . "' WHERE `entrata_table`.`unitNumber` ='" . $finaldata['UnitNumber'] . "'";
                 //echo $updateQuery = "UPDATE `entrata_table` SET `floorplanCode`='" . $finaldata['FloorPlanCode'] . "',`floorplanName`='" . $finaldata['FloorPlanDescription'] . "',`sqftMin`='" . $finaldata['Sqft'] . "',`sqftMax`='" . $finaldata['Sqft'] . "',`bedroom`='" . $finaldata['BedRoom'] . "',`bathroom`='" . $finaldata['BathRoom'] . "',`rent`='" . $finaldata['Rent'] . "',`deposit`='" . $finaldata['Deposit'] . "',`term`=12,`availability`='" . $finaldata['Availabilityunit'] . "',`notice`=Null,`special`=Null,`convertible`='" . $convertible . "',`sqft`='" . $finaldata['Sqft'] . "',`unit_space_id`=Null,`floorplan_id`='" . $finaldata['FloorPlanId'] . "',`availableOn`='" . $finaldata['AvailableDate'] . "',`unitid`='". $finaldata['UnitId'] .  "'  WHERE `entrata_table`.`unitNumber` ='" . $finaldata['UnitNumber'] . "'";
                 echo "<br><br>";
                 $execute = $db->query($updateQuery);

                 //file_put_contents('api.txt','run cronjob');
             } else {
              
                 //echo $inserQuery = "INSERT INTO `entrata_table` (`unitNumber`, `floorplanCode`, `floorplanName`, `sqftMin`, `sqftMax`, `bedroom`, `bathroom`, `rent`, `deposit`, `term`, `availability`,`notice`,`convertible`,`sqft`,`floorplan_id`,`unit_space_id`,`availableOn`,`webvisible`) VALUES ('" . $finaldata['UnitNumber'] . "','" . $finaldata['FloorPlanCode'] . "', '" . $finaldata['FloorPlanDescription'] . "','" . $finaldata['Sqft'] . "', '" . $finaldata['Sqft'] . "','" . $finaldata['BedRoom'] . "','" . $finaldata['BathRoom'] . "','" . $finaldata['BaseRent'] . "','" . $finaldata['Deposit'] . "','12','" . $finaldata['Availabilityunit'] . "',null ,'" . $convertible . "','" . $finaldata['Sqft'] . "','" . $finaldata['AvailableDate'] . "',0)";
                 
                  $inserQuery = "INSERT INTO `entrata_table` (`unitNumber`, `floorplanCode`, `floorplanName`, `sqftMin`, `sqftMax`, `bedroom`, `bathroom`, `rent`, `deposit`, `term`, `availability`,`notice`,`convertible`,`sqft`,`floorplan_id`,`unit_space_id`,`availableOn`,`webvisible`) 
                                      VALUES ('" . $finaldata['UnitNumber'] . "','" . $finaldata['FloorPlanCode'] . "', '" . $finaldata['FloorPlanDescription'] . "','" . $finaldata['Sqft'] . "', '" . $finaldata['Sqft'] . "','" . $finaldata['BedRoom'] . "','" . $finaldata['BathRoom'] . "','" . $finaldata['BaseRent'] . "','" . $finaldata['Deposit'] . "','12','" . $finaldata['Availabilityunit'] . "',null ,'" . $convertible . "','" . $finaldata['Sqft'] . "','". $finaldata['FloorPlanId'] ."',null,'" . $finaldata['AvailableDate'] . "',0)";

                 //echo $inserQuery = "INSERT INTO `entrata_table`(`unitNumber`, `floorplanCode`, `floorplanName`, `sqftMin`, `sqftMax`, `bedroom`, `bathroom`, `rent`, `deposit`, `term`, `availability`, `notice`, `special`,`convertible`,`sqft`,`unit_space_id`,`floorplan_id`, `availableOn`,`unitid`) VALUES ('" . $finaldata['UnitNumber'] . "','" . $finaldata['FloorPlanCode'] . "','" . $finaldata['FloorPlanDescription'] . "','" . $finaldata['Sqft'] . "','" . $finaldata['Sqft'] . "','" . $finaldata['BedRoom'] . "','" . $finaldata['BathRoom'] . "','" . $finaldata['Rent'] . "','" . $finaldata['Deposit'] . "',12,'" . $finaldata['Availabilityunit'] . "',Null,Null,'" . $convertible . "','" . $finaldata['Sqft'] . "',Null,'" . $finaldata['FloorPlanId'] . "','" . $finaldata['AvailableDate'] ."','". $finaldata['UnitId'] .  "')";
                 $execute = $db->query($inserQuery);
    
             }
            //echo '<pre>';print_r($finaldata);
        }
    }

}//die;

$sel = "select * from entrata_table";
$execute = $db->query($sel);
$Entrata_Data = $execute->fetch_all(MYSQLI_ASSOC);
$notarr = array();
foreach($Entrata_Data as $key=>$val) {

    //var_dump(!array_key_exists($val['unitNumber'], $unitNumber));
    if (!array_key_exists($val['unitNumber'], $unitNumber)) {
        $notarr[] = $val['unitNumber'];
    }
}
//echo '<pre>';print_r($notarr);die;
foreach($notarr as $key=>$val){
    $sql = "UPDATE `entrata_table` SET `availability` = '1' WHERE `unitNumber` = ".$val;
    //echo  $sql;die;
    $execute = $db->query($sql);
}
echo 23344;
file_put_contents('entrata_api_log.txt', print_r(date('y-m-d'), true), FILE_APPEND);
file_put_contents('api.txt','Success');


?>