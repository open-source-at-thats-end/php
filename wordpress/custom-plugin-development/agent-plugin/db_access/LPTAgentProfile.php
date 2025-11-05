<?php

class LPTAgentProfile extends DAO
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

        $this->_daStruct['BaseTable'] = 'wp_agent_profile';
        $this->_daStruct['PrimaryKey'] = 'Agent_Id';
        $this->_daStruct['FieldInfo']				=
            array(

                'Agent_Name'                     =>	array(	'title'			=>	'Name',
                    'c_type'		=>	'text',
                ),
                'Agent_Email'               =>	array(	'title'			=>	'Email',
                    'c_type'		=>	'text',
                ),
                'Agent_phone'               =>	array(	'title'			=>	'phone',
                    'c_type'		=>	'text',
                ),
                'Agent_Photo'               =>	array(	'title'			=>	'Photo',
                    'c_type'		=>	'text',
                ),
                'Agent_Office'               =>	array(	'title'			=>	'Office',
                    'c_type'		=>	'text',
                ),


            );
        parent::__construct();
    }

    public function viewAllAgent($POST)
    {
        $POST['page_size'] = Constants::AGENT_PROFILE_PAGE_SIZE;
        return parent::viewAll($POST);
    }
    public function Insert($POST)
    {
        $agentprofile= array();
        $agentprofile['Agent_Name'] = $POST['agent_first_name']." ".$POST['agent_last_name'];
        $agentprofile['Agent_Email'] = $POST['agent_email'];
        $agentprofile['Agent_phone'] = $POST['agent_phone'];
        $agentprofile['Agent_Photo'] = $POST['agent_photo'];
        $agentprofile['Agent_Office'] = $POST['agent_office'];


        return parent::Insert($agentprofile);
    }
    public function Update($id,$POST)
    {
        $agentprofile= array();
        $agentprofile['Agent_Name'] = $POST['agent_first_name']." ".$POST['agent_last_name'];
        $agentprofile['Agent_Email'] = $POST['agent_email'];
        $agentprofile['Agent_phone'] = $POST['agent_phone'];
        $agentprofile['Agent_Photo'] = $POST['agent_photo'];
        $agentprofile['Agent_Office'] = $POST['agent_office'];

        return parent::Update($id, $agentprofile);
    }
    public function deleteAgent($POST){
        return parent::delete($POST,$POST);
    }

    public function getInfoByIdAgent($id)  {
        global $objDB;

        $rs = parent::getInfoById($id);
        return $rs;
    }

    public function imageUpload($uploadedimage,$name){

        global $physical_path;
        $path = $physical_path['images']."/agentprofile";
        $imagename = str_replace($uploadedimage->getClientOriginalExtension(),'',$name).$uploadedimage->getClientOriginalExtension();
        $uploadedimage->move($path,$imagename);
        return $imagename;

    }
    public function agentList(){
        $arrAgent = parent::getAll()->fetch_array();
        $agents= array();
        //echo"<pre>";print_r($arrAgent);exit();
        foreach ($arrAgent as $k=>$v){
            $agents[$v['Agent_Id']] = $v['Agent_Name'];

            //$agents =array($v['Agent_Id'],$v['Agent_Name']);



            //echo"<pre>";print_r($v['Agent_Id']); exit();

        }

        return $agents;
    }

}
?>