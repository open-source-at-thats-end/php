<?php
class DAOAgentRoaster extends DAO
{
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
        global $wpdb, $arrPhysicalPath;

        $this->_daStruct['BaseTable']				=	$wpdb->prefix. Constants::DB_TABLE_PREFIX. 'agent_roster_master';
        $this->_daStruct['AdminDefault']			=   'default_agent_master';
        $this->_daStruct['PrimaryKey']              =   'agent_id';
        $this->_daStruct['FieldInfo']				=
            array(

                'agent_first_name'              =>	array(	'title'			=>	'First Name',
                    'c_type'		=>	'text',

                ),
                'agent_last_name'				=>	array(	'title'			=>	'Last Name',
                    'c_type'		=>	'text',

                ),
                'agent_phone'				    =>	array(	'title'			=>	'Phone',
                    'c_type'		=>	'text',
                ),

                'agent_email'					=>	array(     'title'		=>	'Email',
                    'c_type'		=>	'text',
                ),
                'agent_website'					=>	array(     'title'		=>	'website',
                    'c_type'		=>	'text',
                ),
                'agent_photo'					=>	array(	'title'			=>	'Photo',
                    'c_type'		=>	'picfile',
                    'upload'        => $arrPhysicalPath['UploadBase']."agent_roster/"

                ),
                'agent_city_serving'			=>	array(	'title'		=>	'Select',
                    'c_type'		=>	'checkbox',
                ),
                'agent_key_code'					=>	array(     'title'		=>	'Key code',
                    'c_type'		=>	'text',
                ),
                'agent_active'				=>	array(	'title'		=>	'Is Enabled',

                ),
                'agent_mls'				=>	array(	'title'		=>	'Agent System Name',

                ),

            );
        parent::__construct();
    }
    public function viewAll($arrParams=array(), $addWhere='', $customSelect='')
    {
        $addParameters = "";

        $rs = parent::viewAll($arrParams);

        return $rs;

    }
    public function Insert($POST)
    {

        if(!$this->EmailExists($POST['agent_email']))
        {
            parent::Insert($POST);
            return true;
        }
        else{
            return false;
        }
    }
    public function Update($pk,$POST)
    {
        $agent = parent::getInfoById($pk);

        if($agent['agent_email'] != $POST['agent_email'])
        {
            if(!$this->EmailExists($POST['agent_email']))
            {
                parent::Update($pk, $POST);

                return true;
            }
            else
            {

                return false;
            }
        }
        else{

            parent::Update($pk, $POST);

            return true;
        }

    }
    public function EmailExists($agent_email)
    {
        global $objDB;

        $sql =  " SELECT * "
            .  " FROM ". $this->_daStruct['BaseTable']
            . 	" WHERE agent_email = '". $agent_email. "' ";

        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs =  $objDB->query($sql);

        if(count($rs->fetch_array())==0)
            return false;


        return true;
    }
    public function getDefaultAgent()
    {
        global $objDB;
        $sql =  " SELECT * "
            .  " FROM ". $this->_daStruct['AdminDefault'];

        # Show debug info
        if(WP_DEBUG)
            echo '<br><br>'. $sql;

        # Update
        $rs = $objDB->query($sql);

        return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
    }
}
?>