<?php

class LPTLeadMaster extends DAO
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
        global $wpdb;

        $this->_daStruct['BaseTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'lead_master';
        $this->_daStruct['LeadEmailTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'lead_email';
        $this->_daStruct['UserFavTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_favorite_property';
        $this->_daStruct['UserSaveSearchTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'user_saved_searches';
        $this->_daStruct['PrimaryKey'] = 'lead_id';
        $this->_daStruct['FieldInfo']				=
            array(
                'lead_type'               =>  array(
                    'title'     =>  'Type',
                    'c_type'    =>  'text',
                ),

                'lead_user_id'               =>  array(
                    'title'     =>  'User ID',
                    'c_type'    =>  'text',
                ),
                'lead_first_name'               =>  array(
                    'title'     =>  'First Name',
                    'c_type'    =>  'text',
                ),
                'lead_last_name'                =>  array(
                    'title'     =>  'Last Name',
                    'c_type'    =>  'text',
                ),
                'lead_home_phone'                    =>  array(
                    'title'     =>  'Home Phone',
                    'c_type'    =>  'text',
                ),
                'lead_work_phone'                    =>  array(
                    'title'     =>  'Work Phone',
                    'c_type'    =>  'text',
                ),
                'lead_mobile'                    =>  array(
                    'title'     =>  'Mobile',
                    'c_type'    =>  'text',
                ),
                'lead_email'                    =>  array(
                    'title'     =>  'Email',
                    'c_type'    =>  'text',
                ),
                'lead_comment'                    =>  array(
                    'title'     =>  'Comment',
                    'c_type'    =>  'textarea',
                ),
                'lead_ListingID_MLS_ID'                    =>  array(
                    'title'     =>  'Listing MLSP ID',
                    'c_type'    =>  'text',
                ),
                'lead_listing_Id'                    =>  array(
                    'title'     =>  'Listing ID',
                    'c_type'    =>  'text',
                ),
                'lead_mlsp_id'                    =>  array(
                    'title'     =>  'MLSP ID',
                    'c_type'    =>  'text',
                ),
                'lead_listing_type'                    =>  array(
                    'title'     =>  'Listing Type',
                    'c_type'    =>  'text',
                ),
                'lead_created_by'                    =>  array(
                    'title'     =>  'Created By',
                    'c_type'    =>  'text',
                ),
                'lead_created_date'                    =>  array(
                    'title'     =>  'Created Date',
                    'c_type'    =>  'text',
                ),
            );
        parent::__construct();
    }

    public function InsertRegistration($POST){

        $POST['lead_type'] = 'Registration';

        if (!isset($POST['lead_created_by']))
            $POST['lead_created_by'] = 'Site';

        $POST['lead_created_date'] = date('Y-m-d H:i:s');
        $POST['lead_home_phone']  = isset($POST['user_phone']) ? $POST['user_phone']:'';
        $POST['lead_work_phone']  = isset($POST['user_work_phone']) ? $POST['user_work_phone']:'';
        $POST['lead_mobile']	  = isset($POST['user_mobile']) ? $POST['user_mobile'] : '';
        $POST['lead_first_name']  = $POST['user_first_name'];
        $POST['lead_last_name']   = $POST['user_last_name'];
        $POST['lead_email']       = $POST['user_email'];
        $POST['lead_agent_id']    = isset($POST['user_agent_id']) ? $POST['user_agent_id'] : 0;

        $POST['lead_from_site']    = 2;

        # Make parent call for data insert
        return parent::Insert($POST);

    }

    public function InsertScheduleShowing($POST)
    {
        $POST['lead_type'] = 'ScheduleShowing';

        if (!isset($POST['lead_created_by']))
            $POST['lead_created_by'] = 'Site';

        $POST['lead_created_date'] = date('Y-m-d H:i:s');

        $POST['lead_from_site']    = 2;

        # Make parent call for data insert
        return parent::Insert($POST);
    }

    public function getRegisterAndUnregisterUser($POST)
    {

        $addWhere = " AND lead_email != '' GROUP BY lead_email ";

        return parent::ViewAll($POST, $addWhere);
    }
    public function DeleteLeadUser($email,$user_id)
    {
    	global $objDB;

    	if($user_id != 0)
	    {

		    $sql = 	" DELETE FROM ". $this->_daStruct['BaseTable'].
			    " WHERE lead_user_id IN ('".$user_id."')";

		    if(WP_DEBUG)
			    $this->__debugMessage($sql);

		    $objDB->query($sql);

		    $sql = 	" DELETE FROM ". $this->_daStruct['LeadEmailTable'].
			    " WHERE ldemail_user_id IN ('".$user_id."')";

		    if(WP_DEBUG)
			    $this->__debugMessage($sql);

		    $objDB->query($sql);

		    $sql = 	" DELETE FROM ". $this->_daStruct['UserSaveSearchTable'].
			    " WHERE search_user_id IN ('".$user_id."')";

		    if(WP_DEBUG)
			    $this->__debugMessage($sql);

		    $objDB->query($sql);

		    $sql = 	" DELETE FROM ". $this->_daStruct['UserFavTable'].
			    " WHERE fav_user_id IN ('".$user_id."')";

		    if(WP_DEBUG)
			    $this->__debugMessage($sql);

		    $objDB->query($sql);
		    $user = get_user_by('id',$user_id);
		    if(!in_array('administrator',$user->roles))
		    {
    		      $u_sql = wp_delete_user($user_id);
    		  }
		    

	    }
	    else{


		    $sql = 	" DELETE FROM ". $this->_daStruct['BaseTable'].
			    " WHERE lead_user_id IN ('".$user_id."') AND lead_email IN ('".$email."')";

		    if(WP_DEBUG)
			    $this->__debugMessage($sql);

		    $objDB->query($sql);

	    }



	    return true;
    }

    public function InsertContactFromLeads($POST)
    {
        $POST['lead_type'] = 'ContactForm';

        $POST['lead_created_date'] = date('Y-m-d H:i:s');

        $POST['lead_additional_info'] = serialize($POST);

        if(isset($POST['your-first-name']) && $POST['your-first-name'] != '')
            $POST['lead_first_name'] = $POST['your-first-name'];

        if(isset($POST['your-last-name']) && $POST['your-last-name'] != '')
            $POST['lead_last_name'] = $POST['your-last-name'];

        if(isset($POST['your-phone']) && $POST['your-phone'] != '')
            $POST['lead_mobile'] = $POST['your-phone'];

        if(isset($POST['your-email']) && $POST['your-email'] != '')
            $POST['lead_email'] = $POST['your-email'];

        # Make parent call for data insert
        return parent::Insert($POST);
    }
}

?>