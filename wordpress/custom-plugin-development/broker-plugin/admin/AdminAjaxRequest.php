<?php
class AdminAjaxRequest
{
    private static $instance;
    private $action;

    protected function __construct()
    {


    }

    public static function getInstance(){
        if( !isset(self::$instance)){
            self::$instance = new AdminAjaxRequest();
        }
        return self::$instance;
    }
    public function requestHandler()
    {
        global $arrPhysicalPath, $objAjaxResp;

        include_once($arrPhysicalPath['Libs'] . "AjaxResponse.php");
        $objAjaxResp = new AjaxResponse();

        # Note : Need more proper checking
        $isAjaxRequest = ($_POST['action'] == 'admin_ajax');

        if ($isAjaxRequest) {
            $strModule = strtolower($_POST['ajax_mod']);

            # Note : Following items will be moved in requestHandler for partuclar module
            # Currently it is used for serach module only
            //$this->_mod 		= $_POST['ajax_mod'];
            $this->_action = $_POST['ajax_action'];
            $this->_subaction = $_POST['ajax_subaction'];
        } else {
            $strModule = get_query_var(Constants::TYPE_URL_VAR);
        }

        $ret = "";

        if ($strModule == 'pred-listing') {
            include_once $arrPhysicalPath['UserBase'] . 'AdminPredefined.php';

            $ret = AdminPredefined::getInstance()->requestHandler($isAjaxRequest, $strModule);

            if ($isAjaxRequest) {
                $objAjaxResp = $ret;

                json_encode($objAjaxResp->aCommands);
                die();
            } else {
                return $ret;
            }
        }
        elseif ($strModule == 'manage-listing'){
            include_once $arrPhysicalPath['UserBase'] . 'AdminListings.php';
            $ret = AdminListings::getInstance()->requestHandler($isAjaxRequest, $strModule);

            if ($isAjaxRequest) {
                $objAjaxResp = $ret;

                json_encode($objAjaxResp->aCommands);
                die();
            } else {
                return $ret;
            }
        }
        elseif ($strModule == 'pre-list-pagination')
        {
            include_once $arrPhysicalPath['UserBase'] . 'AdminPredefined.php';
            $ret = AdminPredefined::getInstance()->requestHandler($isAjaxRequest, $strModule);
        }
        elseif ($strModule == 'pre-search')
        {
	        include_once $arrPhysicalPath['UserBase'] . 'AdminPredefined.php';
	        $ret = AdminPredefined::getInstance()->requestHandler($isAjaxRequest, $strModule);
        }
        elseif ($strModule == 'saved-listing')
        {

            include_once $arrPhysicalPath['UserBase'] . 'UserMaster.php';
            $ret = UserMaster::getInstance()->requestHandler($isAjaxRequest, $strModule);

        }
        elseif ($strModule == 'development-list-pagination')
        {
            include_once $arrPhysicalPath['UserBase'] . 'AdminDevelopment.php';
            $ret = AdminDevelopment::getInstance()->requestHandler($isAjaxRequest, $strModule);
        }
        elseif ($strModule == 'condo-minmax-add')
        {
            echo 123;die;
            echo"<pre>"; print_r($_POST);die;
            // include_once $arrPhysicalPath['UserBase'] . 'UserMaster.php';
            // $ret = UserMaster::getInstance()->requestHandler($isAjaxRequest, $strModule);
            $ret = CondoSearch::getInstance()->getCondoMinMaxFields($_GET['pk'], $_POST['csearch_criteria']);
        }

    }
}