<?php
class AdminModule {
    protected $_daStruct 	= array();

    protected $_action;
    protected $_subaction;

    protected $__moduleKey 		= '';
    protected $__isAjaxRequest 	= false;

    protected function __construct(){

    }

    final public function __clone() {

        throw new Exception(__CLASS__ . ' class can\'t be instantiated. Please use the method called getInstance.');
    }

    final public function formatStringForFieldName($str) {

        $str = preg_replace('/[^a-zA-Z0-9_]+/', '_', $str);	/* Make alph numerical string */
        $str = preg_replace('/-+/', '_', $str);  			/* convert multiple dashes to a single dash */
        $str = substr($str, 0, 64);
        $str = strtolower(trim($str, '_'));

        return $str;
    }
    public function requestHandler($isAjaxRequest=false, $moduleKey) {

        $this->__isAjaxRequest = $isAjaxRequest;
        $this->__moduleKey = $moduleKey;

        if($this->__isAjaxRequest) {
            $this->_action = strtolower($_POST['ajax_action']);
            $this->_subaction = $_POST['ajax_subaction'];
        } else {
            $this->_action = strtolower(isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : 'manage'));
        }
    }
}
?>