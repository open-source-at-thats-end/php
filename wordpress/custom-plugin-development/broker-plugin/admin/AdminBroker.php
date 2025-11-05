<?php
class AdminBroker extends AdminModule
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
        global $objTmpl;

        $arrParams['page_size'] = Constants::PAGE_SIZE;
        $arrParams['page_current'] = isset($_GET['cpage'])?$_GET['cpage']:1;

	    $arrParams = array_merge($_GET,$arrParams);
        $rsBroker = LPTBroker::getInstance()->viewAll($arrParams);

        $objTmpl->assign(array('T_Body' => 'broker.tpl',
            'rsBroker'	    =>	$rsBroker['rsData'],
            'total_record'	=>	$rsBroker['totalRecord'],
            'totalFetched'  =>  $rsBroker['totalFetched'],
            'page_size'	    =>	Constants::PAGE_SIZE,
            'startRecord'  =>  $rsBroker['startRecord'],
            'arrParams'     =>  $arrParams,
            'page'          =>  $_GET['page'],
             'scriptname'    => $this->baseUrl,

        ));
    }
}
?>