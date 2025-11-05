<?php

require_once(dirname(dirname(dirname(dirname(__FILE__)))). DIRECTORY_SEPARATOR. 'wp-load.php');

//require './libs/aws/aws-autoloader.php';
/*include_once(dirname(__FILE__). "/libs/aws/aws-autoloader.php");

use Aws\S3\S3Client;

use \Aws\Exception\AwsException;

define('AWS_S3_BUCKET_NAME','loopt-media');
$s3Client = new S3Client([

    'region' => 'us-east-2',
    'version' => 'latest',
    'credentials' => [
        //'key'    => 'AKIA3SHXNH7RKLQMMBVX',
        //'secret' => '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',
        'key'    => 'AKIAXKJXK2I5FTQHYSVN',
        'secret' => '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',
    ],

]);

//$aws_obj_path = 'trestle/04/A10821204/A10821204_0.jpg';
$aws_obj_path = 'trestle/00/A10011000/A10011000_0.jpg';

$obj_response = $s3Client->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_obj_path);

var_dump($obj_response);exit();*/

/*global $db;

$data_source = '';

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$cacheQuery = $redis->get('redis1');

if($cacheQuery) {
    // display the result from the cache
    echo "From Redis Cache";
    //echo "<pre>";print_r(unserialize($cacheQuery));
    echo "<pre>";print_r($cacheQuery);
    exit();
}
else
{
    $sql = " SELECT M.*, mls_is_pic_url_supported, M.PropertyType, M.Description,M.SystemName, M.SubType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, Parking, Garage, A.StreetNumber, A.StreetName, Address, A.Area, A.CityName, A.County, A.State, ZipCode,AI.Sold_Price, AI.Sold_Date, A.Subdivision, AI.VirtualTourUrl, A.StreetDirection,  StreetSuffix, UnitNo, StreetDirPrefix,A.Latitude, A.Longitude, Main_Photo, Category, (ListPrice/SQFT) AS PPSF, MM.mls_prop_last_run_date, IF(M.`ListingStatus` = 'ActiveUnderContract', 0, IF(M.`ListingStatus` = 'Pending', 1,2)) AS LSUC  FROM listing_master AS M  LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID  INNER JOIN mls_master AS MM ON M.MLSP_ID = MM.MLSP_ID  LEFT JOIN listing_additional_info AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID  WHERE 1 AND MM.mls_active = 'Yes'  AND M.SystemName ='SEFMIAMI' AND ListingStatus IN ('Active','ActiveUnderContract','ComingSoon', 'Pending') AND ListPrice > 0  AND M.is_mark_for_deletion = 'N'ORDER BY ListPrice desc LIMIT 0, 50";
    # Show debug in fo
    if(DEBUG)
        $this->__debugMessage($sql);

    $rs = $db->query($sql);
    echo "From Database";

    /*$data = [];
    while($rs->next_record())
    {
        $row = $rs->Record;

        $data[] = $row;
    }

    $redis->set('redis4',serialize($data));*/
    //$redis->set('redis1',$sql);
    //exit();
//}*/


<<<<<<< HEAD
=======
/*$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

if (!isset($POST['sparam']['isAjax']) && $POST['sparam']['isAjax'] != 'true')
{
    if (isset($POST['pk']) && $POST['pk'] != '')
    {
        $cacheQuery = $redis->get('ps_'.$POST['pk']);
    }
}

if($cacheQuery)
{
    echo "From Redis Cache";
    return unserialize($cacheQuery);
}
else
{*/

/*if (!isset($POST['sparam']['isAjax']) && $POST['sparam']['isAjax'] != 'true')
{
    if (isset($POST['pk']) && $POST['pk'] != '')
    {
        $redis->set('ps_' . $POST['pk'], serialize($arr));
        $redis->expire('ps_' . $POST['pk'], 60);
    }

}*/

>>>>>>> redis
?>