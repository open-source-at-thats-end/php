<?php
class LPTLeadEmail extends DAO
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

        //$this->_daStruct['BaseTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'lead_email';
        $this->_daStruct['BaseTable']       = 'lead_email';
        $this->_daStruct['wp_users']        = 'wp_users';

        $this->_daStruct['PrimaryKey']		=	"ldemail_id";
        $this->_daStruct['PrimaryField']	=	"ldemail_to_name";

        $this->_daStruct['FieldInfo']       =   array(
            'ldemail_user_id'               =>  array(
                'title'     =>  'User Id',
                'c_type'    =>  'text',
            ),
            'ldemail_to_name'               =>  array(
                'title'     =>  'Name',
                'c_type'    =>  'text',
            ),
            'ldemail_to_email'              =>  array(
                'title'     =>  'Email',
                'c_type'    =>  'text',
            ),
            'ldemail_lead_id'               =>  array(
                'title'     =>  'Lead Id',
                'c_type'    =>  'text',
            ),
            'ldemail_type'                  =>  array(
                'title'     =>  'Type',
                'c_type'    =>  'text',
            ),
            'ldemail_subject'               =>  array(
                'title'     =>  'Subject',
                'c_type'    =>  'text',
            ),
            'ldemail_cc'                    =>  array(
                'title'     =>  'CC',
                'c_type'    =>  'text',
            ),
            'ldemail_ccother'               =>  array(
                'title'     =>  'CC Other',
                'c_type'    =>  'text',
            ),
            'ldemail_bcc'                   =>  array(
                'title'     =>  'BCC',
                'c_type'    =>  'text',
            ),
            'ldemail_content'               =>  array(
                'title'     =>  'Content',
                'c_type'    =>  'textarea',
            ),
            'ldemail_sign'                  =>  array(
                'title'     =>  'Sign',
                'c_type'    =>  'textarea',
            ),
            'ldemail_from_name'                  =>  array(
                'title'     =>  'From Name',
                'c_type'    =>  'text',
            ),
            'ldemail_from_email'                  =>  array(
                'title'     =>  'From Email',
                'c_type'    =>  'text',
            ),
            'ldemail_use_header_footer'     =>  array(
                'title'     =>  'Use Header Footer?',
                'c_type'    =>  'combobox',
            ),
            'ldemail_datetime'              =>  array(
                'title'     =>  'DateTime',
                'c_type'    =>  'date_time_picker',
            ),
            'ldemail_sent'                  =>  array(
                'title'     =>  'Is Sent?',
                'c_type'    =>  'combobox',
            ),
        );
    }
    public function GetPendingMail($limit='')
    {
        global $objDB;

        /*$sql = "SELECT LE.*,CONCAT(U.user_first_name,' ', U.user_last_name) AS ToName, U.user_email AS ToEmail"
            . " FROM ".$this->Data['TableName']." AS LE"
            . " LEFT JOIN ".$this->Data['User_Table']." AS U ON U.user_wp_id = LE.ldemail_user_id"
            . " WHERE ldemail_sent = 'No'";*/

        $sql = "SELECT LE.*,U.display_name AS ToName, U.user_email AS ToEmail"
            . " FROM ".$this->_daStruct['BaseTable']." AS LE"
            . " LEFT JOIN ".$this->_daStruct['wp_users']." AS U ON U.ID = LE.ldemail_user_id"
            . " WHERE ldemail_sent = 'No'";

        //$sql .= " ORDER BY ldemail_datetime";
        $sql .= " ORDER BY ldemail_id DESC";
        $limit =1;
        if($limit != '')
            $sql .= " LIMIT 0,".$limit;

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        # Execute query
        $rs = $objDB->query($sql);

        return $rs;
    }
    public function UpdateMailStatus($pk_id, $status)
    {
        global $objDB;

        $sql 	= " UPDATE ". $this->_daStruct['BaseTable'] ." SET "
            . " ldemail_sent = '".$status."' WHERE ldemail_id = '". $pk_id ."'";

        # Show debug info
        if(WP_DEBUG)
            $this->__debugMessage($sql);

        # Execute query
        $objDB->query($sql);
    }
}
?>