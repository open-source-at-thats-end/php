<?php

class LPTAgentPredefined extends DAO
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

        $this->_daStruct['BaseTable'] = $wpdb->prefix . Constants::DB_TABLE_PREFIX . 'predefined_searches';
        $this->_daStruct['PrimaryKey'] = 'psearch_id';
        $this->_daStruct['FieldInfo']				=
            array(

                'psearch_title'                     =>	array(	'title'			=>	'Title',
                    'c_type'		=>	'text',
                ),
                'psearch_criteria'               =>	array(	'title'			=>	'Criteria',
                    'c_type'		=>	'text',
                ),
                'psearch_result_limit'               =>	array(	'title'			=>	'psearch result limit',
                    'c_type'		=>	'text',
                ),
                'psearch_added_date'               =>	array(	'title'			=>	'Added Date',
                    'c_type'		=>	'hidden',
                ),
                'psearch_added_by_id'               =>	array(	'title'			=>	'Added Id',
                    'c_type'		=>	'text',
                ),
                'psearch_added_by_type'               =>	array(	'title'			=>	'Added Type',
                    'c_type'		=>	'text',
                ),
                'psearch_generate_mrktreport'               =>	array(	'title'			=>	'Generate Market Report',
                    'c_type'		=>	'text',
                ),
                'psearch_tag'               =>	array(	'title'			=>	'Tag',
                    'c_type'		=>	'text',
                ),
                'psearch_sys_name'               =>	array(	'title'			=>	'Agent System Name',
                    'c_type'		=>	'text',
                ),

            );
        parent::__construct();
    }

    public function viewAll($POST,$a='', $b='')
    {

        //echo '<pre>';print_r($POST);exit();
        $addWhere = '';

        if(isset($POST['psearch_title']) && $POST['psearch_title'] != '')
        {
            if(is_array($POST['psearch_title']) && count($POST['psearch_title']) > 0){
                $POST['psearch_title'] = implode(',',$POST['psearch_title']);
            }
            $title = explode(',', $POST['psearch_title']);

            $temp = array();
            foreach($title as $Key=>$val){
                $temp[] = " psearch_title LIKE '%".$val."%' ";
            }


            $temp_q = implode(' OR ',$temp);
            $addWhere .=  " AND (".$temp_q.")";
        }

        if(isset($POST['psearch_tag']) && $POST['psearch_tag'] !='')
        {
            if(is_array($POST['psearch_tag']) && count($POST['psearch_tag']) > 0){
                $POST['psearch_tag'] = implode(',',$POST['psearch_tag']);
            }

            $tag = explode(',', $POST['psearch_tag']);

            $temp = array();
            foreach($tag as $Key=>$val){
                $temp[] = " FIND_IN_SET('".$val."', psearch_tag) ";
            }

            $temp_q = implode(' OR ',$temp);
            $addWhere .=  " AND (".$temp_q.")";

        }
        if(isset($POST['agent_sys_name']) && $POST['agent_sys_name'] != '')
        {
            $param = " AND psearch_sys_name = '".$POST['agent_sys_name']. "'";
        }

        $param .= " ORDER BY psearch_title ASC ";

        $POST['page_size'] = Constants::PRE_DEFINE_PAGE_SIZE;

        return parent::ViewAll($POST, $addWhere, $param);

    }
    public function Insert($POST)
    {
        if(isset($POST['psearch_tag']) && $POST['psearch_tag'] != '')
        {
            $POST['psearch_tag'] = str_replace(', ',',',$POST['psearch_tag']);
        }
        return parent::Insert($POST);
    }
    public function Update($post,$POST)
    {
        if(isset($POST['psearch_tag']) && $POST['psearch_tag'] != '')
        {
            $POST['psearch_tag'] = str_replace(', ',',',$POST['psearch_tag']);
        }
        return parent::Update($POST['pk'], $POST);
    }

}
?>