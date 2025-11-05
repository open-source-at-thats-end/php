<?php
/*
This is a cronjob file which access API to get property data and update in database from entrata data server
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/Includes/static_data.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/db_access/Rpsandbox.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/Includes/common.php';
global $con;

function getdatabycurl($url, $name)
{
    $jsonRequest = '{
        "auth": {
            "type" : "basic"
        },
        "method": {
            "name": "'.$name.'",
            "params": {
                "propertyId": "1183152"
            
            }
        }
    }';

    $baseUrl = 'https://bayshoreproperties.entrata.com/api/'.$url;

    $resCurl = curl_init();
    /* If you want to send a JSON Request, use these options */
    curl_setopt($resCurl, CURLOPT_HTTPHEADER, ['Content-type: APPLICATION/JSON; CHARSET=UTF-8', 'Authorization: Basic aGlnaGZvcm1fNjI4QGJheXNob3JlcHJvcGVydGllczpyKEJ7c1tWZDI5']);
    curl_setopt($resCurl, CURLOPT_POSTFIELDS, $jsonRequest);
    curl_setopt($resCurl, CURLOPT_POST, true);
    curl_setopt($resCurl, CURLOPT_URL, $baseUrl);
    curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($resCurl);

    if (false === $result) {
        echo 'Curl error: '.curl_error($resCurl);
        curl_close($resCurl);
    } else {
        curl_close($resCurl);

        return $result;
    }
}

function getXMLdatabycurl($url, $name)
{
    /* An Example XML Request */
    $xmlRequest = '
    <request>
	<auth>
		<type>basic</type>
	</auth>
	<requestId>15</requestId>
	<method>
		<name>'.$name.'</name>
		<params>
			<propertyIds>1183152</propertyIds>
		</params>
	</method>
</request>';

    $baseUrl = 'https://bayshoreproperties.entrata.com/api/'.$url;
    //echo $baseUrl;die;
    /* Initiate a CURL resource */
    $resCurl = curl_init();

    /* If you want to send an XML Request, use these options */
    curl_setopt($resCurl, CURLOPT_HTTPHEADER, ['Content-type: APPLICATION/XML; CHARSET=UTF-8', 'Authorization: Basic aGlnaGZvcm1fNjI4QGJheXNob3JlcHJvcGVydGllczpyKEJ7c1tWZDI5']);
    curl_setopt($resCurl, CURLOPT_POSTFIELDS, $xmlRequest);

    curl_setopt($resCurl, CURLOPT_POST, true);
    curl_setopt($resCurl, CURLOPT_URL, $baseUrl);
    curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($resCurl);
    //echo"<pre>";print_r(var_dump(false === $result ));die;
    if (false === $result) {
        echo 'Curl error: '.curl_error($resCurl);
        curl_close($resCurl);
    } else {
        curl_close($resCurl);

        return $result;
    }
}

/*******************special insert update **************************/

$GetUnitsAvailabilityAndPricing1 = getdatabycurl('propertyunits', 'getSpecials');
$array = json_decode($GetUnitsAvailabilityAndPricing1, true);

$all_data = $array['response']['result']['PhysicalProperty'];
foreach ($all_data as $row) {
    $idval = $row['PropertyID']['Identification']['IDValue'];
    $OrganizationName = $row['PropertyID']['Identification']['OrganizationName'];
    $MarketingName = $row['PropertyID']['MarketingName'];
    $LegalName = $row['PropertyID']['LegalName'];
    $MarketingName = $row['PropertyID']['MarketingName'];
    $sel = "select * from specials where idvalue = '".$idval."'";
    $result = $con->query($sel);

    if ($result->num_rows == '0') {
        $insert = " INSERT INTO `specials` (`idvalue`, `organizationname`, `marketingname`, `legalname`) VALUES ('".$idval."', '".$OrganizationName."', '".$MarketingName."', '".$LegalName."')";
        $result = $con->query($insert);
    } else {
        $update = "update `specials` set  `organizationname` = '".$OrganizationName."', `marketingname` =  '".$MarketingName."' , `legalname` = '".$LegalName."' where  `idvalue` = '".$idval."'";
        $result = $con->query($update);
    }
}
/******************************special insert update end*********************************/

/******************************floor plane insert update*********************************/

$all_data1 = $array['response']['result']['PhysicalProperty']['Property'];

/******************************floor plan insert update end*********************************/
$GetUnitsAvailabilityAndPricing = getdatabycurl('propertyunits', 'getUnitsAvailabilityAndPricing');
$arrayGetUnitsAvailabilityAndPricing = json_decode($GetUnitsAvailabilityAndPricing);
$unitNumberData = $arrayGetUnitsAvailabilityAndPricing->response->result->ILS_Units->Unit;

//echo "<pre>"; print_r($unitNumberData); exit;
$unitNumber = [];

foreach ($unitNumberData as $numberData) {
    foreach ($numberData as $key => $data) {
        if (isset($data->UnitNumber) && $data->UnitNumber != '') {
            //echo '<pre>';print_r($data);
            if ($key == '@attributes') {
                $dataunit = $data->UnitNumber;
                $unitNumber[$data->UnitNumber]['UnitNumber'] = $data->UnitNumber;
                $unitNumber[$data->UnitNumber]['FloorPlanName'] = $data->FloorPlanName;
                $unitNumber[$data->UnitNumber]['Availability'] = $data->Availability;
                $unitNumber[$data->UnitNumber]['IsAffordable'] = $data->IsAffordable;
                $unitNumber[$data->UnitNumber]['Status'] = $data->Status;
                $unitNumber[$data->UnitNumber]['FloorplanId'] = $data->FloorplanId;
                $unitNumber[$data->UnitNumber]['UnitTypeId'] = $data->UnitTypeId;
                $unitNumber[$data->UnitNumber]['PropertyUnitId'] = $data->PropertyUnitId;
                $unitNumber[$data->UnitNumber]['PropertyId'] = $data->PropertyId;
                $unitNumber[$data->UnitNumber]['FloorId'] = isset($data->FloorId) ? $data->FloorId : 0;
                $unitNumber[$data->UnitNumber]['rent'] = 0;
                $unitNumber[$data->UnitNumber]['deposit'] = 0;
                $unitNumber[$data->UnitNumber]['sqft'] = (float) $data->Area;

                if (isset($data->AvailableOn) && $data->AvailableOn != '') {
                    $unitNumber[$data->UnitNumber]['AvailableOn'] = date('Y-m-d', strtotime($data->AvailableOn));
                } else {
                    $unitNumber[$data->UnitNumber]['AvailableOn'] = '1970-01-01';
                }
            }
        }
        if ($key == 'Rent') {
            foreach ($data as $rentKey => $rentValue) {
                if ($rentKey == 'TermRent') {
                    foreach ($rentValue as $monthRent) {
                        foreach ($monthRent as $keyMonthRent => $rent) {
                            if (isset($rent->LeaseTerm) && str_replace(' ', '', $rent->LeaseTerm) == '12Months') {
                                $unitNumber[$dataunit]['rent'] = $rent->Rent;
                            }
                        }
                    }
                }
            }
        }
        if ($key == 'Deposit') {
            foreach ($data as $depositKey => $depostiValue) {
                $unitNumber[$dataunit]['deposit'] = $depostiValue->MinDeposit;
            }
        }
    }
}//die;

//********************************************************************************

$GetUnitTypes = getdatabycurl('propertyunits', 'getUnitTypes');
$arrayGetUnitTypes = json_decode($GetUnitTypes);
$getUnitTypesData = $arrayGetUnitTypes->response->result->unitTypes->unitType;
$unitTypeName = [];
foreach ($getUnitTypesData as $typesData) {
    $unitTypeName[$typesData->identificationType->idValue] = $typesData->name;
}

//********************************************************************************

/***********************get unit space id*********************/
$getUnitSpace = getXMLdatabycurl('propertyunits', 'getPropertyUnits');
//echo '<pre>';print_r($getUnitSpace);die;
$xmldata = new SimpleXMLElement($getUnitSpace);

$arrunitsData = $xmldata->result->properties->property->units->unit;

$arrunitspace = [];

foreach ($arrunitsData as $key => $val) {
    $arrunitspace[(string) $val->unitNumber] = (string) $val->unitSpaces->unitSpace->unitSpaceId;
}
//echo"<pre>";print_r($arrunitspace);die;

$getFloorPlans = getdatabycurl('properties', 'getFloorPlans');
$arrayGetFloorPlans = json_decode($getFloorPlans);
$getFloorPlansData = $arrayGetFloorPlans->response->result->FloorPlans->FloorPlan;
$floorPlan = [];
foreach ($getFloorPlansData as $floorPlansData) {
    $FloorPlansDataSquareFeet = $floorPlansData->SquareFeet;
    foreach ($FloorPlansDataSquareFeet as $key => $values) {
        $floorPlan[$floorPlansData->Identification->IDValue]['sqftMin'] = $values->Min;
        $floorPlan[$floorPlansData->Identification->IDValue]['sqftMax'] = $values->Max;
    }
    $FloorPlansDataRoom = $floorPlansData->Room;
    foreach ($FloorPlansDataRoom as $plansDataRoom) {
        $count = $plansDataRoom->Count;
        foreach ($plansDataRoom as $key => $valuesRoom) {
            if ($key != 'Count') {
                foreach ($valuesRoom as $key => $values) {
                    if ($values == 'Bedroom') {
                        $floorPlan[$floorPlansData->Identification->IDValue]['Bedroom'] = $count;
                    }
                    if ($values == 'Bathroom') {
                        $floorPlan[$floorPlansData->Identification->IDValue]['Bathroom'] = $count;
                    }
                }
            }
        }
    }
}
$final = [];
foreach ($unitNumber as $unitdat) {
    $unitdat['UnitName'] = $unitTypeName[$unitdat['UnitTypeId']];
    $unitdat['sqftMin'] = $floorPlan[$unitdat['FloorplanId']]['sqftMin'];
    $unitdat['sqftMax'] = $floorPlan[$unitdat['FloorplanId']]['sqftMax'];
    $unitdat['Bedroom'] = $floorPlan[$unitdat['FloorplanId']]['Bedroom'];
    $unitdat['Bathroom'] = $floorPlan[$unitdat['FloorplanId']]['Bathroom'];
    $unitdat['unitSpaceId'] = $arrunitspace[$unitdat['UnitNumber']];
    $unitdat['notice'] = '';
    if ($unitdat['Availability'] == 'Available') {
        $unitdat['Availabilityunit'] = '0';
    } elseif ($unitdat['Availability'] == 'Not Available') {
        $unitdat['Availabilityunit'] = '1';
    } elseif ($unitdat['Availability'] == 'on notice') {
        $unitdat['Availabilityunit'] = '2';
        $unitdat['notice'] = '07/07/2019';
    }

    $finalList = $unitdat;

    //echo "<pre>"; print_r($finalList); exit;

    if (isset($unitdat['rent']) && $unitdat['rent'] != '') {
        $finalList['rent'] = str_replace([',', '.00'], ['', ''], $unitdat['rent']);
    }
    $convertible = ($finalList['FloorPlanName'] == 'Convertible') ? 1 : 0;

    $sel = "select * from entrata_table where unitNumber='".$finalList['UnitNumber']."'";
    $execute = $con->query($sel);
    if ($r = $execute->fetch_object()) {
        echo $updateQuery = "UPDATE `entrata_table` SET `floorplanCode` = '".$finalList['UnitName']."',floorplanName='".$finalList['FloorPlanName']."',sqftMin='".$finalList['sqftMin']."',sqftMax = '".$finalList['sqftMax']."',bedroom = '".$finalList['Bedroom']."',bathroom = '".$finalList['Bathroom']."',rent = '".$finalList['rent']."', deposit = '".$finalList['deposit']."',availability = '".$finalList['Availabilityunit']."',isaffordable = '".$finalList['IsAffordable']."', notice = '".$finalList['notice']."', convertible='".$convertible."',sqft='".$finalList['sqft']."', availableOn='".$finalList['AvailableOn']."', floorplan_id = '".$finalList['FloorplanId']."',unit_space_id = '".$finalList['unitSpaceId']."'   WHERE `entrata_table`.`unitNumber` ='".$finalList['UnitNumber']."'";
        echo '<br><br>';
        $execute = $con->query($updateQuery);
    } else {
        echo $inserQuery = "INSERT INTO `entrata_table` (`unitNumber`, `floorplanCode`, `floorplanName`, `sqftMin`, `sqftMax`, `bedroom`, `bathroom`, `rent`, `deposit`, `term`, `availability`,`isaffordable`,`notice`,`convertible`,`sqft`,`availableOn`) VALUES ('".$finalList['UnitNumber']."','".$finalList['UnitName']."', '".$finalList['FloorPlanName']."','".$finalList['sqftMin']."', '".$finalList['sqftMax']."','".$finalList['Bedroom']."','".$finalList['Bathroom']."','".$finalList['rent']."','".$finalList['deposit']."','12','".$finalList['Availabilityunit']."','".$finalList['IsAffordable']."','".$finalList['notice']."' ,'".$convertible."','".$finalList['sqft']."','".$finalList['AvailableOn']."')";
        $execute = $con->query($inserQuery);
    }
}

file_put_contents('cron.txt', 'success');
