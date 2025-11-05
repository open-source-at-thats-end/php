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
    #	Function Name	:   ViewAllShortcode
    #----------------------------------------------------------------------------------------------------
    function ViewAllShortcode($POST='')
    {
        return $this->getData('shortcode', 'viewall', $POST);
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
    #	Function Name	:   getPredefinedSearchCountById
    #----------------------------------------------------------------------------------------------------
    function getPredefinedSearchCountById($POST='')
    {
        return $this->getData('predefine', 'getcount', $POST);
    }
    function getListingByPreSearch($POST='')
    {
        global $arrConfig;

        $POST['formatURL'] = $arrConfig['page-config']['page-permalink-text-detail'];
        return $this->getData('predefine', 'getlisting', $POST);
    }

    function getCityKeyValueArray($POST)
    {
        return $this->getData('address', 'allcity');
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

        $arr = $this->getData('property', 'speedData', $POST);

        return $arr;
    }
    #====================================================================================================
    #	Function Name	:   getListingByParam
    #----------------------------------------------------------------------------------------------------
    function getListingByParam($POST, $allRecord=false, $viewType='list')
    {
        global $config, $arrConfig;

        $POST['allRecord'] = $allRecord;
        $POST['viewType'] = $viewType;
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
    function getInfoByWebsite($POST)
    {
        return $this->getData('agent', 'getInfoByWebsite', $POST);
    }
    function getWebsiteAgentInfo($POST)
    {
        return $this->getData('agent', 'getWebsiteAgent', $POST);
    }
    function ActivateAgentByKey($POST)
    {
        //echo '<pre>';print_r($POST);exit();
        return $this->getData('agent', 'activateAgent', $POST);
    }
	public function getRandomListingByMLSNum($POST)
	{
		return $this->getData('property', 'RandomData', $POST);
	}
	public function getPreDefineSearchByTitle($POST)
	{
		return $this->getData('predefine-search', 'getbytitle', $POST);
	}
	public function getPreDefineStatistic($POST)
	{
		return $this->getData('predefine-search', 'get-statistic', $POST);
	}
    #====================================================================================================
    #	Function Name	:   getCondoSearchById
    #----------------------------------------------------------------------------------------------------
    function getCondoSearchById($POST='')
    {
        return $this->getData('condo', 'getByid', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getCondoStatistic
    #----------------------------------------------------------------------------------------------------
    public function getCondoStatistic($POST)
    {
        return $this->getData('condo-search', 'get-statistic', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getCondoSearchByName
    #----------------------------------------------------------------------------------------------------
    public function getCondoSearchByName($POST)
    {
        return $this->getData('condo-search', 'getbyname', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getCryptoData
    #----------------------------------------------------------------------------------------------------
    public function getCryptoData()
    {
        return $this->getData('property', 'getcryptodata');
    }
    #====================================================================================================
    #	Function Name	:   getCondoSearchById
    #----------------------------------------------------------------------------------------------------
    function getFullDataDevelopmentPageById($POST='')
    {
        return $this->getData('development', 'fullData', $POST);
    }
    #====================================================================================================
    #	Function Name	:   getData
    #----------------------------------------------------------------------------------------------------
    function getData($cmd, $type, $post=''){

        global $arrConfig, $agentInfo;
        $agent = array(
            'website' => str_replace('www.','',$_SERVER['HTTP_HOST']),
            'agent_active' => true,
        );

        if(is_array($agentInfo) && count($agentInfo) > 0){
            $agent['agent_key_code'] = $agentInfo['agent_key_code'];
        }

        $response = wp_remote_post($arrConfig['idxapi_url'], array("body" => array("cmd" => $cmd, "type" => $type, "agent" => $agent, 'filter' => base64_encode(serialize($post)))));
        /*echo"<pre>";print_r($cmd);
        echo"<pre>";print_r($type);
        echo"<pre>";print_r($post);exit();*/
        //echo"<pre>";print_r($response);die;
        /*if($type == 'speedData'){
            echo"<pre>";print_r($response);die;
        }*/

        if(is_object($response)){
            file_put_contents('lpterror_log.txt', print_r($response, true));
        }elseif(is_array($response) && isset($response['body'])){
            return json_decode($response['body'], true);
        }
        
    }
}