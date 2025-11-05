<?php

require_once(dirname(__FILE__) . '/CustomClass.php');

class AgentRosterMaster extends CustomClass {
    private static $instance;

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    protected function __construct()
    {

        global $wpdb, $physical_path;

        $this->Data['TableName']				= 'agent_roster_master';
        $this->Data['AdminDefault']				= 'default_agent_master';
        $this->Data['F_PrimaryKey']               = 'agent_id';
        $this->Data['P_Upload']				     =	$physical_path['Upload']. '/agent';
        $this->Data['F_FieldInfo']				=
            array(

                'agent_first_name'              =>	array(	'title'			=>	'First Name',
                    CNT_TYPE		=>	C_TEXT,

                ),
                'agent_last_name'				=>	array(	'title'			=>	'Last Name',
                    CNT_TYPE		=>	C_TEXT,

                ),
                'agent_phone'				    =>	array(	'title'			=>	'Phone',
                    CNT_TYPE		=>	C_TEXT,
                ),

                'agent_email'					=>	array(     'title'		=>	'Email',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_website'					=>	array(     'title'		=>	'website',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_site_title'					=>	array(     'title'		=>	'site title',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_photo'					=>	array(	'title'			=>	'Photo',
                    CNT_TYPE		=>	C_PICFILE,

                ),
                'agent_print_photo'					=>	array(	'title'			=>	'Email Logo',
                    CNT_TYPE		=>	C_PICFILE,

                ),
                'agent_about'					=>	array(     'title'		=>	'About Agent',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_address'					=>	array(     'title'		=>	'Agent Address',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_city_serving'			=>	array(	'title'		=>	'Select',
                    CNT_TYPE		=>	C_CHECKBOX,
                ),
                'agent_key_code'					=>	array(     'title'		=>	'Key code',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_condo_photo_video_url'       =>	array(     'title'		=>	'Agent Condo Building Photo Video Url',
                    CNT_TYPE		=>	C_TEXT,
                ),
                'agent_active'		=>	array(	'title'		=>	'Is Enabled',

                ),
                'crypto_active'		=>	array(	'title'		=>	'Crypto Values',

                ),
                'agent_mls'			=>	array(	'title'		=>	'System Name',

                ),
                'agent_select_mls'			=>	array(	'title'		=>	'Select MLS',

                ),
                'market_report_active'			=>	array(	'title'		=>	'Market Report',

                ),
                'agent_signin_text'					=>	array(     'title'		=>	'LogIn Screen Text',
                    CNT_TYPE		=>	C_TEXT,
                ),


            );
        parent::__construct();
    }
    public function addAgent($POST)
    {
        $_FILES = $POST['files'];
        unset($POST['files']);

        $id = parent::Insert($POST);
        return true;

    }
    public function getAgent($POST)
    {
        $result = array();
       $param = '';
       $search_param = '';
        if(isset($POST['page_size'])){
	        $startRecord = ((intval($POST['page_current']) ? intval($POST['page_current']) : 1 ) - 1) * $POST['page_size'];
	        $param .= " ORDER BY agent_id ASC LIMIT ". $startRecord .",".$POST['page_size'];
        }

		if(isset($POST['agent_first_name']) && $POST['agent_first_name'] != '')
		{
			$search_param .= " AND agent_first_name LIKE '%".$POST['agent_first_name']."%'";
		}
	    if(isset($POST['agent_last_name']) && $POST['agent_last_name'] != '')
	    {
		    $search_param .= " AND agent_last_name LIKE '%".$POST['agent_last_name']."%'";
	    }

        $rsAgent = parent::getAll($search_param.$param);

        $result['rsAgent'] = $rsAgent->fetch_array();
        $totalFetched = parent::ViewAll($search_param, true);
        $result['totalFetched'] = $totalFetched->TotalRow;
        $result['startRecord'] = $startRecord;

        return $result;
    }
    public function getAgentById($POST)
    {
        $rs = parent::getInfoById($POST);
        return $rs;
    }
    public function updateAgent($POST)
    {
        //echo "<pre>";print_r($POST);die;
        $pk = $POST['pk'];
        $_FILES = $POST['files'];
        unset($POST['files']);

        $agent = parent::getInfoById($pk);

        parent::Update($pk, $POST);

        return true;

    }
    public function deleteAgent($POST)
    {
        $rs = parent::Delete($POST);
        return true;
    }
    public function EmailExists($agent_email)
    {
        global $db;

        $sql =  " SELECT * "
            .  " FROM ". $this->Data['TableName']
            . 	" WHERE agent_email = '". $agent_email. "' ";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Update
        $rs = $db->query($sql);

        if(count($rs->fetch_array())==0)
            return false;

        return true;
    }
    public function getInfoByWebsite($site)
    {
        global $db;
        $sql =  " SELECT * "
            .  " FROM ". $this->Data['TableName']
            . 	" WHERE agent_website = '". $site. "' ";

        # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Update
        $rs = $db->query($sql);

        return $rs->fetch_array();

    }
    public function addDefaultAgent($POST)
    {
        global $db;

        $agent_name         = $POST['agent_name'];
        $agent_email        = $POST['agent_email'];
        $agent_phone        = $POST['agent_phone'];
        $agent_about        = $POST['agent_about'];
        $agent_address      = $POST['agent_address'];
        $agent_photo        = $POST['agent_photo'];
        $print_photo        = $POST['print_photo'];
        $agent_system_name  = strtoupper($POST['agent_system_name']);

        $defaultAgent = $this->getDefaultAgent();

        if($defaultAgent != ''){
            $sql = " REPLACE INTO ".$this->Data['AdminDefault']."
            (id, agent_name, agent_email, agent_phone, agent_about, agent_address, agent_photo, agent_print_photo, agent_system_name) 
            VALUES (1, '".$agent_name."','".$agent_email."','".$agent_phone."', '".$agent_about."','".$agent_address."', '".$agent_photo."', '".$print_photo."', '".$agent_system_name."')";
        }else{
            $sql = " INSERT INTO ".$this->Data['AdminDefault']."
            (agent_name, agent_email, agent_phone, agent_about, agent_address, agent_photo, agent_print_photo, agent_system_name) 
            VALUES ('".$agent_name."','".$agent_email."','".$agent_phone."', '".$agent_about."','".$agent_address."', '".$agent_photo."', '".$print_photo."', '".$agent_system_name."')";
        }

        if(DEBUG)
            $this->__debugMessage($sql);

        $rs = $db->query($sql);
    }
    public function getDefaultAgent()
    {
        global $db;
        $sql =  " SELECT * "
            .  " FROM ". $this->Data['AdminDefault'];

         # Show debug info
        if(DEBUG)
            $this->__debugMessage($sql);

        # Update
        $rs = $db->query($sql);

        return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
    }
    public function GetAgentByWebsite($website)
    {
        $param = ' AND agent_website = "'.$website.'"';
        $rs = parent::getInfoByParam($param);
        return $rs;
    }
    public function GetAgentByParam($post)
    {
        $param = '';
        if(isset($post['website']) && $post['website'] != '')
        {
            $param .= ' AND agent_website = "'.$post['website'].'"';
        }

        if(isset($post['agent_key_code']) && $post['agent_key_code'] != '')
        {
            $param .= ' AND agent_key_code = "'.$post['agent_key_code'].'"';
        }

        if(isset($post['agent_active']) && $post['agent_active'] != '')
        {
            $param .= ' AND agent_active = "'.$post['agent_active'].'"';
        }

        $rs = parent::getInfoByParam($param);
        return $rs;
    }
    public function IsAgentActive($agentsite){

        $param = ' AND agent_website = "'.$agentsite.'" AND agent_active = 1';
        $rs = parent::getInfoByParam($param);

        if(empty($rs)){
            return false;
        }else{
            return true;
        }

    }
    public function ActivateAgentByKey($POST)
    {
        $agentInfo = $this->GetAgentByParam($POST);

        if(is_array($agentInfo) && count($agentInfo) > 0)
        {
            if($agentInfo['agent_active'] == true){

                return $agentInfo;

            }else{

                $POST['agent_active'] = true;
                parent::Update($agentInfo['agent_id'], $POST);

                return $agentInfo;
            }

        }else{

            return false;
        }


    }
}