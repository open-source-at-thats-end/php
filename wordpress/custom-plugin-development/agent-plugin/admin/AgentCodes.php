<?php
class AgentCodes extends AdminModule
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function requestHandler($isAjaxRequest = false, $moduleKey)
    {

        parent::requestHandler($isAjaxRequest, $moduleKey);

        $this->baseUrl = admin_url('admin.php?page=' . Constants::SLUG . '-' . $this->__moduleKey);

        switch ($this->_action) {

            default:
                $this->manage();
                break;
        }
    }

    public function manage()
    {
        global $objTmpl,$arrVirtualPath;

        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

        $arrParams = array_merge($_GET,$arrParams);

        $rsAgCode = LPTAgentCodes::getInstance()->viewAll($arrParams);

        $objTmpl->assign(array('T_Body' => 'agent_code.tpl',
            'scriptname'    => $this->baseUrl,
            'rsAgCode'	    =>	$rsAgCode['rsData'],
            'total_record'	=>	$rsAgCode['totalRecord'],
            'totalFetched'  =>  $rsAgCode['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'startRecord'   =>  $rsAgCode['startRecord'],
            'arrParams'     =>  $arrParams,
            'page'          =>  $_GET['page'],

        ));
    }
}
?>