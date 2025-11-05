<?php
/**
 *
**/
class AjaxResponse
{
    public static $Instance;

    public $XHR_URL;
    public $XHR_AJAX;
    public $XHR_AREA;
    public $XHR_MODULE;
    public $XHR_ACTION;
    public $XHR_DATA;

    public $XHR_R_JSON;
    public $XHR_R_DATA;
    public $XHR_R_ASSIGN;
    public $XHR_R_APPEND;
    public $XHR_R_PREPEND;
    public $XHR_R_SCRIPT;
    public $XHR_REDIRECT;

    public $XHR_R_ERROR;
    public $XHR_R_SUCCESS;

    public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
    public function __construct()
    {
        # Set required params
        $this->XHR_AJAX     =   isset($_POST[XHR][XHR_AJAX])?$_POST[XHR][XHR_AJAX]:'';
        $this->XHR_URL      =   isset($_POST[XHR][XHR_URL])?$_POST[XHR][XHR_URL]:'';
        $this->XHR_AREA     =   isset($_POST[XHR][XHR_AREA])?$_POST[XHR][XHR_AREA]:'';
        $this->XHR_MODULE   =   isset($_POST[XHR][XHR_MODULE])?$_POST[XHR][XHR_MODULE]:'';
        $this->XHR_ACTION   =   isset($_POST[XHR][XHR_ACTION])?$_POST[XHR][XHR_ACTION]:'';

        if(defined('IN_AJAX') && $this->XHR_AJAX == 'true')
        {
            if(isset($_POST[XHR])){unset($_POST[XHR]);}
        }
    }
    public function call_request_area()
    {
        $class  =   $this->XHR_AREA;
        $method =   $this->XHR_MODULE;
        if(class_exists($class))
        {
        	$obj = new $class;
	        if(method_exists($obj, $method))
	        	$obj->$method();
        }
    }
    public function get_response($quick=false)
    {
        if(is_array($this->XHR_R_DATA) && count($this->XHR_R_DATA) > 0)
            $XHR_R_JSON[XHR_R_DATA]          =   $this->XHR_R_DATA;

        if(is_array($this->XHR_R_ERROR) && count($this->XHR_R_ERROR) > 0)
            $XHR_R_JSON[XHR_R_ERROR]         =   $this->XHR_R_ERROR;

        if(is_array($this->XHR_R_SUCCESS) && count($this->XHR_R_SUCCESS) > 0)
            $XHR_R_JSON[XHR_R_SUCCESS]       =   $this->XHR_R_SUCCESS;

        if($quick === false)
        {
            if(is_array($this->XHR_R_ASSIGN) && count($this->XHR_R_ASSIGN) > 0)
                $XHR_R_JSON[XHR_R_ASSIGN]        =   $this->XHR_R_ASSIGN;

            if(is_array($this->XHR_R_APPEND) && count($this->XHR_R_APPEND) > 0)
                $XHR_R_JSON[XHR_R_APPEND]        =   $this->XHR_R_APPEND;

            if(is_array($this->XHR_R_PREPEND) && count($this->XHR_R_PREPEND) > 0)
                $XHR_R_JSON[XHR_R_PREPEND]       =   $this->XHR_R_PREPEND;

            if(is_array($this->XHR_R_SCRIPT) && count($this->XHR_R_SCRIPT) > 0)
                $XHR_R_JSON[XHR_R_SCRIPT]        =   $this->XHR_R_SCRIPT;

            if(is_array($this->XHR_REDIRECT) && count($this->XHR_REDIRECT) > 0)
                $XHR_R_JSON[XHR_R_REDIRECT]      =   $this->XHR_REDIRECT;
        }

        # If response jsone is not set yet then some unknown error found so reply with valid error message
        if(!isset($XHR_R_JSON) || !is_array($XHR_R_JSON) || count($XHR_R_JSON) <= 0)
            $XHR_R_JSON[XHR_R_ERROR][] = "Sorry, unable to respond to your request. Please try again.";

        return $XHR_R_JSON;
    }
    public function send($quick=false)
    {
        global $t_start;
        # Unset data base connection
        //DBc::unset_instance();

        $_output = $this->get_response($quick);

        if(!is_array($_output)) return false;

        /*if($_SESSION['SHOW_QUERY'])
        {
            global $Debug_info; if(is_array($Debug_info)){$_output['_SQL'] = $Debug_info;}
        }
        if(isset($_SESSION['SHOW_RESP_TIME']) && !empty($_SESSION['SHOW_RESP_TIME']))
        {
            $mtime      = microtime();
            $mtime      = explode(" ",$mtime);
            $mtime 	    = $mtime[1] + $mtime[0];
            $t_end      = $mtime;

            $_output['_T'] = number_format($t_end-$t_start,2)." SEC";
            $_output['_M'] = (memory_get_usage()/1048576)." MB";
        }*/

        $_output = json_encode($_output);
       
        /*if(isset($_SERVER['HTTP_ORIGIN'])){header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);}*/
  
        header('Content-Type: application/json; charset="UTF-8"');
        header('Vary: Accept-Encoding');
        header('Content-Encoding: gzip');
        $_output = gzencode($_output, 9);
        header('Content-Length: ' . strlen($_output));
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	    header("Pragma: no-cache");
	    header("Cache-Control: no-cache, max-age=0, must-revalidate, no-store");
        header("Connection: close");
        header("X-Powered-By: CustomWpPluginDemoDomain.com");


        echo $_output;
        exit();
    }
    public function set_data($key, $data)
    {
        if($key === false && is_array($data))
            $this->XHR_R_DATA = $data;
        elseif($key != '' && $data != '')
            $this->XHR_R_DATA[$key] = $data;
    }
    public function assign($content, $selector=false)
    {
        $this->XHR_R_ASSIGN[] = array($selector, $content);
    }
    public function append($content, $selector=false)
    {
        $this->XHR_R_APPEND[] = array($selector, $content);
    }
    public function prepend($content, $selector=false)
    {
        $this->XHR_R_PREPEND[] = array($selector, $content);
    }
    public function script($script)
    {
        if($script != '')
            $this->XHR_R_SCRIPT[] = $script;
    }
    public function redirect($url, $delay=false)
    {
        $this->XHR_REDIRECT[] = array($url, $delay);
    }
    public function error($msg)
    {
        if($msg != '')
            $this->XHR_R_ERROR[] = $msg;
    }
    public function success($msg)
    {
        if($msg != '')
            $this->XHR_R_SUCCESS[] = $msg;

    }
}
?>