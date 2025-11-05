<?php
/*
We get csv file in email. We need to fetch .csv from email and import into database table.
This is cronjob script. Emails are sent by API provider which is controlled by another script.
We just have to look for email nothing else. So, this is completely custom script.
*/
//$con =new mysqli("localhost","greenlink_user",']STA*m_+.+fx',"greenlink_db");
define('IN_CRON', 	true);

ini_set("memory_limit","512M");  //set memory to 50Meg
ini_set("max_execution_time", 14400); // 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)

include_once("cron_common.php");
include_once($_SERVER['DOCUMENT_ROOT']. INSTALL_DIR. "/includes/common.php");

global $db;

//var_dump(file_exists($physical_path['Site_Root']. '/attachment/greenlink-floorplan-type.csv'));



file_put_contents('api1.txt','done');
if ($db === false) {
    die("ERROR: Not connected. ".$db->connect_error);
}
else {

    $deleterecords = "TRUNCATE TABLE entrata_table"; //empty the table of its current records
    //mysqli_query($db, $deleterecords);
    $db->query($deleterecords);
    echo 'Truncate table'.'<br>';
   
    $date   =   date('Ymd');


    # Insert daily updataed sheet

    $emailAddress = 'feed@greenlinkresidences.com'; // Full email address
    $emailPassword = 'V{$^C&SZ?w3H';        // Email password
    $domainURL = 'greenlinkresidences.com';              // Your websites domain
    $useHTTPS = true;                       // Depending on how your cpanel is set up, you may be using a secure connection and you may not be. Change this from true to false as needed for your situation

    /* BEGIN MESSAGE COUNT CODE */

    $inbox = imap_open('{' . $domainURL . ':143/notls}INBOX', $emailAddress, $emailPassword) or die('Cannot connect to domain:' . imap_last_error());
   
    $emails = imap_search($inbox, 'FROM "donotreply@appfolio.com"');

    /* if any emails found, iterate through each email */
    if ($emails) {

        $count = 1;

        /* put the newest emails on top */
        rsort($emails);

        $overview = imap_fetch_overview($inbox, $emails[0], 0);


        $message = imap_fetchbody($inbox, $emails[0], 2);

        /* get mail structure */
        $structure = imap_fetchstructure($inbox, $emails[0]);
        $attachments = array();

        /* if any attachments found... */
        if (isset($structure->parts) && count($structure->parts)) {
            for ($i = 0; $i < count($structure->parts); $i++) {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );

                if ($structure->parts[$i]->ifdparameters) {
                    foreach ($structure->parts[$i]->dparameters as $object) {
                        if (strtolower($object->attribute) == 'filename') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if ($structure->parts[$i]->ifparameters) {
                    foreach ($structure->parts[$i]->parameters as $object) {
                        if (strtolower($object->attribute) == 'name') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if ($attachments[$i]['is_attachment']) {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $emails[0], $i + 1);

                    /* 3 = BASE64 encoding */
                    if ($structure->parts[$i]->encoding == 3) {
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    } /* 4 = QUOTED-PRINTABLE encoding */
                    elseif ($structure->parts[$i]->encoding == 4) {
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }

        /* iterate through each attachment and save it */
        foreach ($attachments as $attachment) {
            if ($attachment['is_attachment'] == 1) {
                $filename = $attachment['name'];
                if (empty($filename)) $filename = $attachment['filename'];

                if (empty($filename)) $filename = time() . ".dat";
                $folder = "attachment";
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $fp = fopen("./" . $folder . "/" . $filename, "w+");
                fwrite($fp, $attachment['attachment']);
                fclose($fp);
            }
        }

    }

    /* close the connection */
    imap_close($inbox);

    echo "all attachment Downloaded";
    
    $date =date('Ymd', strtotime("-1 days"));
        //$date   =   date('Ymd');
        //echo $date; die;
        //$date = '20230129';
        if (($handle1 = fopen("attachment/unit_vacancy_detail-" . $date . ".csv", "r")) !== FALSE) {
     
            $n = 1;
            while (($row = fgetcsv($handle1))!== FALSE) {
                    
                if ($n >= 4) {
                    if (isset($row['0']) && $row['0'] != '' && $row['0'] != 'Total') {
                        
                        $UnitNumber = $row['0'];
                        $BedBath = $row['2'];
                        $BedBath = explode('/', $BedBath);
                        $BedRooms = $BedBath[0];
                        $Bath = explode('.', $BedBath[1]);
                        $BathRooms = $Bath[0];
                        $Sqrt = str_replace(',', '', $row['3']);
                        $UnitStatus = $row['4'];
                        $postedToWebsite = $row['16'];
                        $RentReady = $row['5'];
                        /*if ($postedToWebsite == 'Yes') {
                            $Availability = 0;
                        } else {
                            $Availability = 1;
                        }*/
                        //if(($UnitStatus == "Vacant-Unrented" && $RentReady == "Yes") || ($UnitStatus == "Notice-Unrented" && $AvailableOn >= $TodayDate)
                        if(($postedToWebsite == "Yes" && $RentReady == "Yes" && $UnitStatus == "Vacant-Unrented") || ($postedToWebsite == "Yes" && $RentReady == "Yes" && $UnitStatus == "Notice-Unrented"))
                        {
                             $Availability = 0;
                        }
                        else
                        {
                            $Availability = 1;
                        }
                        //echo '<pre>'; print_r($UnitNumber).'<br>';
                         //echo '<pre>'; print_r($Availability).'<br>';
                        $Rent = $row['15'];
                        $amenities = $row['20'];
                        $AvailableOn = date('Y-m-d', strtotime($row['7']));
    
                        $sel = "select * from entrata_table where unitNumber='" . $UnitNumber . "'";
                        $execute = $db->query($sel);
                        if ($r = $execute->fetch_object()) {
                            $sql = "UPDATE `entrata_table` 
                                    SET `sqftMin`='" . $Sqrt . "',`sqftMax`='" . $Sqrt . "',
                                    `bedroom`='" . $BedRooms . "',`bathroom`='" . $BathRooms . "',`rent`='" . $Rent . "',
                                    `availability`='" . $Availability . "',`sqft`='" . $Sqrt . "',`availableOn`='" . $AvailableOn . "', `amenities`='" . $amenities . "' WHERE `entrata_table`.`unitNumber` ='" . $UnitNumber . "'";
                            if ($db->query($sql) === TRUE) {
                                echo "record Updated successfully ";
                            } else {
                                echo "Error: " . $sql . "<br>" . $db->error;
                            }                     
                        } else {
                            $sql = "INSERT INTO `entrata_table`
                        (`unitNumber`, `floorplanCode`, `floorplanName`, `sqftMin`,
                        `sqftMax`, `bedroom`, `bathroom`, `rent`,
                        `deposit`, `term`, `availability`, `notice`, 
                        `special`, `2dfurl`, `3dfurl`, `viewurl`, 
                        `pq`, `north`, `east`, `south`,
                        `west`, `finishes`, `pets`, `convertible`,
                            `corner`, `sqft`, `patio`, `balcony`, 
                            `parking`, `walk`, `floorplan_id`, `unit_space_id`,
                            `availableOn`, `webvisible`, `floor_ceiling`, `unitid`, `amenities`) 
                            VALUES ('" . $UnitNumber . "',null,null,'" . $Sqrt . "',
                            '" . $Sqrt . "','" . $BedRooms . "','" . $BathRooms . "','" . $Rent . "',
                            null,12,'" . $Availability . "',null,
                            null,null,null,null,
                            null,null,null,null,
                            null,null,null,null,
                            null,'" . $Sqrt . "',null,null,
                            null,null,null,null,
                            '" . $AvailableOn . "',null,null,null, '" . $amenities . "')";
                            if ($db->query($sql) === TRUE) {
                                $last_id = $db->insert_id;
                                echo "New record created successfully. Last inserted ID is: " . $last_id;
                            } else {
                                echo "Error: " . $sql . "<br>" . $db->error;
                            }
                        }

                    }

                }
                $n++;
                //die;
            }
        } else {
            echo"sheet time=======";var_dump(file_exists('attachment/unit_vacancy_detail-" . $date . ".csv'));
                echo 'not open file========';
            echo 'daily updated sheet not open';
        }
    fclose($handle1);

    #insert floorplan name and floorplan code
    if (($handle = fopen($physical_path['Site_Root']. '/attachment/greenlink-floorplan-type.csv', "r")) !== FALSE) {
        $n = 1;
        while (($row = fgetcsv($handle)) !== FALSE) {
            if ($n > 0) {
                if (isset($row['0']) && $row['0'] != '' && $row['0'] != 'Total') {
                    $UnitNumber = $row['0'];
                    $floorplanCode = $row['1'];

                    if(substr($floorplanCode,0,1)  ==   'A')
                    {
                        $floorplanName  =   'Jr. One Bedroom';
                    }
                    elseif (substr($floorplanCode,0,1)  ==   'B')
                    {
                        $floorplanName  =   '1 Bedroom';
                    }
                    elseif (substr($floorplanCode,0,1)  ==   'C')
                    {
                        $floorplanName  =   '1 Bedroom + Den';
                    }
                    elseif (substr($floorplanCode,0,1)  ==   'D')
                    {
                        $floorplanName  =   '2 Bedroom';
                    }
                    elseif (substr($floorplanCode,0,1)  ==   'E')
                    {
                        $floorplanName  =   '3 Bedroom';
                    }
                    elseif (substr($floorplanCode,0,1)  ==   'L')
                    {
                        $floorplanName  =   'Townhome';
                    }

                    $sel = "select * from entrata_table where unitNumber='" . $UnitNumber . "'";
                    $execute = $db->query($sel);
                    if ($r = $execute->fetch_object()) {
                        $sql = "UPDATE `entrata_table` 
                                    SET `floorplanCode`='" . $floorplanCode . "',`floorplanName`='".$floorplanName."' WHERE `entrata_table`.`unitNumber` ='" . $UnitNumber . "'";

                        if ($db->query($sql) === TRUE) {
                            echo "record Updated successfully ";
                        } else {
                            echo "Error: " . $sql . "<br>" . $db->error;
                        }
                    }
                    /*else{
                        $sql = "INSERT INTO `entrata_table`
                        (`unitNumber`, `floorplanCode`, `floorplanName`) 
                            VALUES ('" . $UnitNumber . "','".$floorplanCode."','".$floorplanName."')";
                    
                        if ($con->query($sql) === TRUE) {
                            $last_id = $con->insert_id;
                            echo '===========================Insert floorplan name and code================================='.'<br>';
                            echo "New record created successfully. Last inserted ID is: " . $last_id.'<br>';

                        } else {
                            echo "Error: " . $sql . "<br>" . $con->error;
                        }
                    }*/

                }

            }
            $n++;
        }
    } else {
        echo"1st time=======";var_dump(file_exists('attachment/Greenlink-Floor-Plan-Types.csv'));
        echo 'not open file========';
    }
  
    fclose($handle);

    if (($handle2 = fopen($physical_path['Site_Root']. '/attachment/greenlink-floorplan-type.csv',"r")) !== FALSE) {
        $n = 1;
        while (($row = fgetcsv($handle2)) !== FALSE) {
            if ($n > 0) {
                if (isset($row['0']) && $row['0'] != '' && $row['0'] != 'Total') {
                    $UnitNumber = $row['0'];
                    $floorplanCode = $row['1'];
                    if(strstr( $floorplanCode, '*' ) == true)
                    {
                       
                        $furl = str_replace('*','m',$floorplanCode).'.jpg';
                        $floorplanCode = rtrim($floorplanCode,'*');
                        // echo $floorplanCode.'<br>';
                        $floorplanPdf = 'Greenlink-'.$floorplanCode.'.pdf';
                    }
                    else
                    {
                        $furl = str_replace(' ','',$floorplanCode).'.jpg';
                        $floorplanPdf = 'Greenlink-'.$row['1'].'.pdf';
                    }
                  
                    $sel = "select * from entrata_table where unitNumber='" . $UnitNumber . "'";

                    $execute = $db->query($sel);
                    if ($r = $execute->fetch_object()) {
        
                        $sql = "UPDATE `entrata_table` 
                                    SET `floorplanPdf`='" . $floorplanPdf . "',`2dfurl`='" . $furl . "',`3dfurl`='" . $furl . "' WHERE `entrata_table`.`unitNumber` ='" . $UnitNumber . "'";
                        if ($db->query($sql) === TRUE) {
                            echo 'update floorplan pdf';
                            echo "record Updated successfully ";
                        } else {
                            echo "Error: " . $sql . "<br>" . $db->error;
                        }
                    }


                }

            }
            $n++;
        }
    } else {
        echo 'not open floorplan sheet';
    }
    fclose($handle2);

    #insert apply url
/*    if (($handle3 = fopen("../attachment/Apply-URLs.csv", "r")) !== FALSE) {
        $n = 3;
        while (($row = fgetcsv($handle3)) !== FALSE) {
            if ($n >= 0) {
                if (isset($row['0']) && $row['0'] != '' && $row['0'] != 'Total') {

                    $UnitNumber = $row['0'];
                    $apply_url = $row['1'];
                    echo $UnitNumber.'<br>';
                    echo $apply_url.'<br>';
                    $sel = "select * from entrata_table where unitNumber='" . $UnitNumber . "'";

                    $execute = $con->query($sel);
                    if ($r = $execute->fetch_object()) {
        
                        $sql = "UPDATE `entrata_table` 
                                    SET `apply_url`='" . $apply_url . "' WHERE `entrata_table`.`unitNumber` ='" . $UnitNumber . "'";
                        echo $sql.'<br>';
                        if ($con->query($sql) === TRUE) {
                            echo 'update apply url...';
                            echo "record Updated successfully ";
                        } else {
                            echo "Error: " . $sql . "<br>" . $con->error;
                        }
                    }
                }

            }
            $n++;

        }
    } else {
        echo 'not open apply url sheet';
    }
    fclose($handle3);*/
file_put_contents('api.txt','done');
file_put_contents('check_api.txt','done');
}


?>