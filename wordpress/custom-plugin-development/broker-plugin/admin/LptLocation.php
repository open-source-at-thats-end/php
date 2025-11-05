<?php
class LptLocation extends AdminModule
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

	public function requestHandler($isAjaxRequest = false, $moduleKey)
	{

		parent::requestHandler($isAjaxRequest, $moduleKey);

		$this->baseUrl = admin_url('admin.php?page='.Constants::SLUG.'-'.$this->__moduleKey);

		switch($this->_action)
		{

			default:
				$this->manage();
				break;
		}
	}

	public function manage()
	{
		echo '434';die;
	}

}
?>