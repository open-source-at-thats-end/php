<?php

class LPTUserSavedSearches extends DAO
{
    private static $instance;

    public static function getInstance() {
        if( !isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        global $wpdb;

        $this->_daStruct['BaseTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_saved_searches';
        $this->_daStruct['SendSavedSearches']		=	$wpdb->prefix. Constants::DB_TABLE_PREFIX. 'send_saved_searches';
        $this->_daStruct['wp_users']            = $wpdb->prefix.'users';
        $this->_daStruct['PrimaryKey'] = 'search_id';
        $this->_daStruct['wp_users']        =   $wpdb->prefix."users";

        $this->_daStruct['FieldInfo']       =   array(
            'search_user_id'                =>  array(
                'title'     =>  'User Id',
                'c_type'    =>  'text',
            ),
            'search_criteria'               =>  array(
                'title'     =>  'Criteria',
                'c_type'    =>  'textarea',
            ),
            'search_resultcount'            =>  array(
                'title'     =>  'Result Count',
                'c_type'    =>  'text',
            ),
            'search_title'                  =>  array(
                'title'     =>  'Title',
                'c_type'    =>  'text',
            ),
            'search_url'                    =>  array(
                'title'     =>  'URL',
                'c_type'    =>  'text',
            ),
            'search_lastrun'                =>  array(
                'title'     =>  'Last Run',
                'c_type'    =>  'text',
            ),
            'search_alert_type'             =>  array(
                'title'     =>  'Alert Type',
                'c_type'    =>  'text',
            ),
            'search_alert_last_sent'        =>  array(
                'title'     =>  'Alert Last Sent',
                'c_type'    =>  'text',
            ),
            'search_send_till_lastupdatedate'=>  array(
                'title'     =>  'Last Update Date Time',
                'c_type'    =>  'date_time_picker',
            ),
        );

    }

    public function InsertUserSaveSearch($POST){

        global $objDB;

        $user_id = $POST['user_id'];
        $Item = $POST['search_crieteria'];
        $result_count = $POST['result_count'];
        $search_title = $POST['search_title'];
        $url = $POST['url'];
        $search_alert_type = 1;
        $listing_lastupdatedate = $POST['listing_lastupdatedate'];
        $search_saved_from = $POST['search_saved_from'];
        $search_added_by_type = 'User';

        $sql	= "INSERT INTO ". $this->_daStruct['BaseTable']
            . " ("
            . "search_user_id,"
            . "search_criteria,"
            . "search_resultcount,"
            . "search_title,"
            . "search_url,"
            . "search_lastrun,"
            . "search_alert_type,"
            . "search_send_till_lastupdatedate,search_added_by_id, search_saved_from, search_added_by_type"
            . ") VALUES ("
            . "'".	$user_id.	"',"
            . "'".	serialize($Item).			"',"
            . "'".	$result_count.		"',"
            . "'".	$search_title.				"',"
            . "'".	$url.				        "',"
            . "'".	time().						"',"
            . "'".	$search_alert_type.						"',"
            . "'".	$listing_lastupdatedate.						"',"
            . "'".	$user_id.						"',"
            . "'".	$search_saved_from.						"',"
            . "'".	$search_added_by_type.						"')";

        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs = $objDB->query($sql);

        return ($objDB->sql_inserted_id());

    }
    public function getUserSaveSearch($user_id){

        global $objDB;
        $objAPI = IDXAPI::getInstance();
        if($user_id != '')
            $search_user_id = $user_id;
        else
            return false;

        $addParams = "";

        $sql = 	" SELECT * FROM ". $this->_daStruct['BaseTable']
            .	" WHERE search_user_id	= '". $search_user_id. "'".$addParams . 'ORDER BY search_id DESC';

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        # Execute query
        $rs = $objDB->query($sql);

        //$rs = $rsp->fetch_array();

        $arrRet = array();

        $i = 0;

        while($rs->next_record())
            //for($i=0; $i < count($rs); $i++)
        {
            $arrRet[$i] = $rs->Record;
            $arrRet[$i]['search_criteria'] 	= unserialize($rs->f('search_criteria'));
            $arrRet[$i]['current_count']	= $objAPI->getCountbyParam($arrRet[$i]['search_criteria']);

            $i++;
        }

        $this->total_record = count($arrRet);

        return $arrRet;
    }
    public function getSavedSearchById($id)
    {
        global $objDB;

        $sql = 	" SELECT * FROM ". $this->_daStruct['BaseTable']
            .	" WHERE search_id	= '". $id. "' ";

        # Execute query
        $rsp = $objDB->query($sql);

        return $rsp->fetch_array(MYSQLI_FETCH_SINGLE);
    }
    public function DeleteSearch($Search_ID)
    {
        global $objDB;

        $sql	= " DELETE FROM ". $this->_daStruct['BaseTable']
            . " WHERE search_id	= '". $Search_ID. "'";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        return $objDB->query($sql);
    }
    public function UpdateSavedSearchEmailAlert($email_alertid, $search_id)
    {
        global $objDB;
        $sql = "UPDATE ".$this->_daStruct['BaseTable']." SET search_alert_type = '".$email_alertid."' WHERE search_id='".$search_id."'";

        # Execute Query
        $objDB->query($sql);
    }
    public function getAllForSearchAlert()
    {
        global $objDB;

        $sql	= " SELECT S.*,ID, user_nicename,display_name,user_email FROM ". $this->_daStruct['BaseTable']
            . " AS S LEFT JOIN ". $this->_daStruct['wp_users']. " AS U ON ID = search_user_id"
            . " WHERE search_alert_type != '0' AND 
					((search_alert_type = '1')) OR 
					((search_alert_type = '2') AND (DAYOFWEEK(CURDATE())=6)) OR 
					((search_alert_type = '3') AND (DAYOFMONTH(CURDATE())=4))  ";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        # Execute Query
        $rs = $objDB->query($sql);

        return $rs;
    }
    public function SaveUpdatedSearch($searchId, $criteria){

        global $objDB;

        $Item['search_datetime']	= time();

        $sql	= "INSERT INTO ". $this->_daStruct['SendSavedSearches']
            . " (user_search_id, user_usearch_criteria) VALUES ('".	$searchId ."', '". serialize($criteria)."')";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        $objDB->query($sql);

        return ($objDB->sql_inserted_id());
    }
    public function UpdateSentSearchEmailId($search_id ,$email_id)
    {
        global $objDB;

        $sql = "UPDATE ".$this->_daStruct['SendSavedSearches']." SET sent_email_id = '".$email_id."' WHERE user_usearch_id='".$search_id."'";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        # Execute Query
        $objDB->query($sql);
    }
    public function UpdateSearchRunDate($Search_ID, $listing_lastupdatedate='')
    {
        global $objDB;

        $Item['search_datetime']	= time();

        $sql	= " UPDATE ". $this->_daStruct['BaseTable']
            . " SET search_lastrun					= '".	time().						"', "
            . "		search_send_till_lastupdatedate	= '".	$listing_lastupdatedate.	"'"
            . " WHERE search_id	= '". $Search_ID.	"'  ";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        $objDB->query($sql);

        return true;
    }
}
?>