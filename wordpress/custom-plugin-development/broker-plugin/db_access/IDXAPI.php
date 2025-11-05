<?php
class IDXAPI {
    private static $instance ;

    public static function getInstance(){
        if( !isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct(){
        global $wpdb, $arrPhysicalPath;
    }

    #====================================================================================================
    #	Function Name	:   addShortcode
    #----------------------------------------------------------------------------------------------------
    function addShortcode($POST='')
    {
        return $this->getData('shortcode', 'add', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getShortcode
    #----------------------------------------------------------------------------------------------------
    function getShortcode($POST='')
    {
        return $this->getData('shortcode', 'get', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getShortcodeById
    #----------------------------------------------------------------------------------------------------
    function getShortcodeById($POST='')
    {
        return $this->getData('shortcode', 'getByid', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updateShortcode
    #----------------------------------------------------------------------------------------------------
    function updateShortcode($POST='')
    {
        return $this->getData('shortcode', 'update', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updateShortcode
    #----------------------------------------------------------------------------------------------------
    function deleteShortcode($POST='')
    {
        return $this->getData('shortcode', 'delete', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updateShortcode
    #----------------------------------------------------------------------------------------------------
    function ViewAllShortcode($POST='')
    {
        return $this->getData('shortcode', 'viewall', $POST);
    }

    //predefined
    #====================================================================================================
    #	Function Name	:   addPredefinedSearche
    #----------------------------------------------------------------------------------------------------
    function addPredefinedSearch($POST='')
    {
        return $this->getData('predefine', 'add', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getPredefined
    #----------------------------------------------------------------------------------------------------
    function getPredefined($POST='')
    {
        return $this->getData('predefine', 'get', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getPredefined
    #----------------------------------------------------------------------------------------------------
    function getPredefinedSearchById($POST='')
    {
        return $this->getData('predefine', 'getByid', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updatePredefinedSearch
    #----------------------------------------------------------------------------------------------------
    function updatePredefinedSearch($POST='')
    {
        return $this->getData('predefine', 'update', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updatePredefinedSearch
    #----------------------------------------------------------------------------------------------------
    function deletePredefinedSearch($POST='')
    {
        return $this->getData('predefine', 'delete', $POST);
    }

    function getCityKeyValueArray($POST)
    {
        return $this->getData('address', 'allcity');
    }
    function getUser($POST)
    {
        return $this->getData('user', 'get', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getMeta
    #----------------------------------------------------------------------------------------------------
    function getMeta($POST='')
    {
        $arr = $this->getData('property', 'getMeta', $POST);

        return $arr;
    }
    #====================================================================================================
    #	Function Name	:   getCountbyParam
    #----------------------------------------------------------------------------------------------------
    public function getCountbyParam($POST=array())
    {
        global $config, $physical_path;
        return $this->getData('property', 'count', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getListingByParam
    #----------------------------------------------------------------------------------------------------
    function getListingByParam($POST, $allRecord=false, $viewType='list')
    {
       // echo '<pre>';print_r($POST);exit();
        global $config, $arrConfig;

        $POST['allRecord'] = $allRecord;
        $POST['vt'] = $viewType;
        $POST['formatURL'] = $arrConfig['page-config']['page-permalink-text-detail'];
        if (!$allRecord)
        {
            # Reset page size
            $POST['page_size'] 			= ($POST['page_size']?$POST['page_size']:($_SESSION['page_size']?$_SESSION['page_size']:$config['page_size']));
            //$_SESSION['page_size']		= $POST['page_size'];
//            $POST['start_record'] 		= $POST['start_record']?$POST['start_record']:$_SESSION['start_record'];
            $POST['start_record'] 		=(isset($POST['start_record'])?$POST['start_record']:(isset($_SESSION['start_record'])?$_SESSION['start_record']:0));
        }

        $arr = $this->getData('property', 'data', $POST);

        return $arr;
    }
    #====================================================================================================
    #	Function Name	:   getIDXListingByParam
    #----------------------------------------------------------------------------------------------------
    function getIDXListingByParam($POST, $allRecord=false, $viewType='list')
    {
        global $config, $arrConfig;

        $POST['allRecord'] = $allRecord;
        $POST['vt'] = $viewType;
        $POST['formatURL'] = $arrConfig['page-config']['page-permalink-text-detail'];
        if (!$allRecord)
        {
            # Reset page size
            $POST['page_size'] 			= ($POST['page_size']?$POST['page_size']:($_SESSION['page_size']?$_SESSION['page_size']:$config['page_size']));
            $POST['start_record'] 		=(isset($POST['start_record'])?$POST['start_record']:(isset($_SESSION['start_record'])?$_SESSION['start_record']:0));
        }

        //$arr = $this->getData('property', 'speedData', $POST);
        $arr = IDXListing::obj()->getIDXListingByParam($POST);

        return $arr;
    }
    #====================================================================================================
    #	Function Name	:   getListingByMLSNum
    #----------------------------------------------------------------------------------------------------
    function getListingByMLSNum($POST)
    {
        return $this->getData('property', 'fullData', $POST);
    }
    public function getListingLastUpdateDate()
    {
        return $this->getData('property', 'ListingLastUpdateDate');
    }
    public function getListingByParamforSaveSearch($POST)
    {
        return $this->getData('property', 'SaveSearchdata', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getDeletedListingByMLSNum
    #----------------------------------------------------------------------------------------------------
    public function getDeletedListingByMLSNum($POST)
    {
        return $this->getData('property', 'deletedListing', $POST);
    }



    #====================================================================================================
    #	Function Name	:   InsertMarketReports
    #----------------------------------------------------------------------------------------------------
    function InsertMarketReports($POST)
    {
        return $this->getData('market', 'add', $POST);
    }
    function getMarketReportsByParam($POST)
    {
        return $this->getData('market', 'getbyParam', $POST);
    }
    function getMarketReports($POST)
    {
        return $this->getData('market', 'get', $POST);
    }
    function getMarketReportsById($POST)
    {
        return $this->getData('market', 'getByid', $POST);
    }
    function updateMarketReports($POST)
    {
        return $this->getData('market', 'update', $POST);
    }
    function deleteMarketReports($POST)
    {
        return $this->getData('market', 'delete', $POST);
    }

    function addAgent($POST)
    {
        return $this->getData('agent', 'add', $POST);
    }
    function getAgent($POST)
    {
        return $this->getData('agent', 'get', $POST);
    }
    function updateAgent($POST)
    {
        return $this->getData('agent', 'update', $POST);
    }
    function getInfoById($POST)
    {
        return $this->getData('agent', 'getByid', $POST);
    }
    function deleteAgent($POST)
    {
        return $this->getData('agent', 'delete', $POST);
    }
    function getInfoByWebsite($POST)
    {
        return $this->getData('agent', 'getInfoByWebsite', $POST);
    }
    function addDefaultAgent($POST)
    {
        return $this->getData('agent', 'addDefaultAgent', $POST);
    }
	public function getRandomListingByMLSNum($POST)
	{
		return $this->getData('property', 'RandomData', $POST);
	}
	public function UpdateFavoritesHomes($POST)
	{
		return $this->getData('user', 'updatefav', $POST);
	}
	public function getUserFavoritesHomes($POST)
	{
		return $this->getData('user', 'getfav', $POST);
	}
	public function InsertUserSaveSearch($POST)
	{
		return $this->getData('user', 'insertSaveSearch', $POST);
	}
	public function getUserSaveSearch($POST)
	{
		return $this->getData('user', 'getSaveSearch', $POST);
	}
	public function getSavedSearchById($POST)
	{
		return $this->getData('user', 'searchById', $POST);
	}
	public function DeleteSearch($POST)
	{
		return $this->getData('user', 'delete', $POST);
	}
	public function UpdateSavedSearchEmailAlert($POST)
    {
        return $this->getData('user', 'updatesavesearchemailalert', $POST);
    }
	public function getPreDefineSearchByTitle($POST)
	{
		return $this->getData('predefine-search', 'getbytitle', $POST);
	}
	public function getPreDefineStatistic($POST)
	{
		return $this->getData('predefine-search', 'get-statistic', $POST);
	}
	public function InsertScheduleShowing($POST)
	{
		return $this->getData('lead', 'schedule', $POST);
	}
	public function InsertPropertyInquiry($POST)
	{
		return $this->getData('lead', 'inquiry', $POST);
	}
	public function InsertRegistration($POST)
	{
		return $this->getData('lead', 'registration', $POST);
	}
	public function getRegisterAndUnregisterUser($POST)
    {
        return $this->getData('lead', 'getuserlead', $POST);
    }
	public function UpdateRegistration($POST)
	{
		return $this->getData('user', 'UpdateRegistration', $POST);
	}
    #====================================================================================================
    #	Function Name	:   addCondoSearch
    #----------------------------------------------------------------------------------------------------
    function addCondoSearch($POST='')
    {
        return $this->getData('condo', 'add', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getCondo
    #----------------------------------------------------------------------------------------------------
    function getCondo($POST='')
    {
        return $this->getData('condo', 'get', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getCondoSearchById
    #----------------------------------------------------------------------------------------------------
    function getCondoSearchById($POST='')
    {
        return $this->getData('condo', 'getByid', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updateCondoSearch
    #----------------------------------------------------------------------------------------------------
    function updateCondoSearch($POST='')
    {
        return $this->getData('condo', 'update', $POST);
    }
    #====================================================================================================
    #	Function Name	:   deleteCondoSearch
    #----------------------------------------------------------------------------------------------------
    function deleteCondoSearch($POST='')
    {
        return $this->getData('condo', 'delete', $POST);
    }
    public function getCondoStatistic($POST)
    {
        return $this->getData('condo-search', 'get-statistic', $POST);
    }
    public function getUserFavoritesCondos($POST)
    {
        return $this->getData('user', 'getfavcondo', $POST);
    }
    #====================================================================================================
    #	Function Name	:   addDevelopmentPage
    #----------------------------------------------------------------------------------------------------
    function addDevelopmentPage($POST='')
    {
        return $this->getData('development', 'add', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getDevelopment
    #----------------------------------------------------------------------------------------------------
    function getDevelopment($POST='')
    {
        return $this->getData('development', 'get', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getDevelopmentPageById
    #----------------------------------------------------------------------------------------------------
    function getDevelopmentPageById($POST='')
    {
        return $this->getData('development', 'getByid', $POST);
    }
    #====================================================================================================
    #	Function Name	:   deleteCondoSearch
    #----------------------------------------------------------------------------------------------------
    function deleteDevelopmentPage($POST='')
    {
        return $this->getData('development', 'delete', $POST);
    }
    #====================================================================================================
    #	Function Name	:   updateDevelopmentPage
    #----------------------------------------------------------------------------------------------------
    function updateDevelopmentPage($POST='')
    {
        return $this->getData('development', 'update', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getDevelopmentPageById
    #----------------------------------------------------------------------------------------------------
    function getDevelopmentPagePreId($POST='')
    {
        return $this->getData('development', 'getPreid', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getData
    #----------------------------------------------------------------------------------------------------
    function getData($cmd, $type, $post=''){

        global $arrPhysicalPath, $arrVirtualPath, $arrConfig;
	    $arrConfig['idx_api_flag'] = 'false';

	    if ($arrConfig['idx_api_flag'] == 'false')
	    {

		    $_POST['cmd'] = $cmd;
		    $_POST['type'] = $type;
		    $_POST['filter'] = base64_encode(serialize($post));
		    //$_POST['filter'] = serialize($post);
            
		    return include($arrPhysicalPath['Base']. 'apis/DataFetcher.php');
	    }
	    else{

        //echo"<pre>";print_r($arrConfig['idxapi_url']);die;
        $response = wp_remote_post($arrConfig['idxapi_url'], array("body" => array("cmd" => $cmd, "type" => $type, 'filter' => base64_encode(serialize($post)))));

          if(is_object($response)){
            file_put_contents('lpterror_log.txt', print_r($response, true), FILE_APPEND);
        }elseif(is_array($response) && isset($response['body'])){
            return json_decode($response['body'], true);
        }
	    }
    }
}