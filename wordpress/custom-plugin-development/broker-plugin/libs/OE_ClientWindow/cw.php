<?php
define('CW_S_XS',  'XS');
define('CW_S_SM',  'SM');
define('CW_S_MD',  'MD');
define('CW_S_LG',  'LG');
define('CW_S_XL',  'XL');
define('CW_S_XXL', 'XXL');
define('CW_W_XS',   575);//542
define('CW_W_SM',   767);//766
define('CW_W_MD',   991);//990
define('CW_W_LG',   1199);//1198
define('CW_W_XL',   1200);//1200
define('CW_W_XXL',  1920);

class cw
{
	public static $obj;
	public static $screen;

	public $SETTINGS;
	public $COOKIE  =   false;
	public $SCREEN  =   false;
	public $WH      =   false;
	public $WIDTH   =   false;
	public $HEIGHT  =   false;

	/**
	 * This class is to support bootstrap functionality on server side
	 * @param array $settings = all settings will be passed in array formate. Settings will be associative array as below. If you need to change any value then chnage it
	**/
	public function __construct($settings=array())
	{
		# Set basic settings to run class
		$_settings = array(
			'cookie_name'           =>  'cyh_cw',
			'cookie_delimiter_main' =>  '|',
			'cookie_delimiter_sub'  =>  '*',
		);

		# Merge all config with modified value
		$this->SETTINGS = array_merge($_settings, $settings);

        if(isset($_COOKIE[$this->SETTINGS['cookie_name']]) && $_COOKIE[$this->SETTINGS['cookie_name']] != '')
		{
			# Set cookie in class variable
			if(isset($_COOKIE[$this->SETTINGS['cookie_name']]))
				$this->COOKIE = &$_COOKIE[$this->SETTINGS['cookie_name']];

			if($this->COOKIE == '')
			{
				if(isset($_SESSION[$this->SETTINGS['cookie_name']]) && $_SESSION[$this->SETTINGS['cookie_name']] != '')
					$this->COOKIE = &$_SESSION[$this->SETTINGS['cookie_name']];
			}

			# Also save  in session so we can a have track at 2 place
			if($this->COOKIE != '')
				$_SESSION[$this->SETTINGS['cookie_name']] = $this->COOKIE;

			$this->setScreen($this->COOKIE, $this->SETTINGS['cookie_delimiter_sub']);

			if($this->getScreen() == false)
			{
				$this->unsetConfigCookie();
			}
			else
			{
				self::$screen = $this->getScreen();
			}
		}
		/*else
		{
			$this->unsetConfigCookie();
		}*/

		# If screen size not detected then do some manipulation
		//if(self::$screen == false){}
	}
	public function unsetConfigCookie()
	{
		@setcookie($this->SETTINGS['cookie_name'],'',time()-3600);
	}
	public function setScreenWidth($width)
	{
		$this->WIDTH  = $width;
	}
	public function setScreenHeight($height)
	{
		$this->HEIGHT  = $height;
	}
	public function getScreen()
	{
		return $this->SCREEN;
	}
	/**
	 * @param string $wh = width x height (1280x800)
	 * @param string $delimiter = character to explode
	 **/
	public function setScreen($wh, $delimiter)
	{
		$this->WH = explode($delimiter, $wh);
		if(is_numeric($this->WH[0]) && is_numeric($this->WH[1]))
		{
			$this->setScreenWidth($this->WH[0]);
			$this->setScreenHeight($this->WH[1]);
			$this->DetectScreen();
		}
		else
			return false;
	}
    public function DetectScreen()
	{
		if(isset($this->WIDTH) && is_numeric($this->WIDTH))
		{
			# Extra large devices (large desktops, minimum 1200px and up)
			# @media (min-width: 75em)
			if($this->WIDTH >= CW_W_XL)
			{
				$this->SCREEN = CW_S_XL;
			}
			# Extra small devices (mobile phones, portrait phones, maximum 542px and down)
			# @media (max-width: 33.9em)
			elseif($this->WIDTH <= CW_W_XS)
			{
				$this->SCREEN = CW_S_XS;
			}
			# Small devices (landscape phones, maximum 766px and down)
			# @media (max-width: 47.9em)
			elseif($this->WIDTH <= CW_W_SM)
			{
				$this->SCREEN = CW_S_SM;
			}
			# Medium devices (tablets, maximum 990px and down)
			# @media (max-width: 61.9em)
			elseif($this->WIDTH <= CW_W_MD)
			{
				$this->SCREEN = CW_S_MD;
			}
			# Large devices (desktops maximum 1198px and down)
			# @media (max-width: 74.9em)
			elseif($this->WIDTH <= CW_W_LG)
			{
				$this->SCREEN = CW_S_LG;
			}
		}
		else
			return false;
	}
    public function SetApproxScreenDimention($screen=false)
    {
        if($screen == false)
            $screen = $this->SCREEN;

        switch($screen)
        {
            case CW_S_XS:
                    $this->WIDTH    =   CW_W_XS;
                    $this->HEIGHT   =   CW_W_SM-1;
                break;
            case CW_S_SM:
                    $this->WIDTH    =   CW_W_SM;
                    $this->HEIGHT   =   CW_W_MD-1;
                break;
            case CW_S_MD:
                    $this->WIDTH    =   CW_W_MD;
                    $this->HEIGHT   =   CW_W_LG;
                break;
            case CW_S_LG:
                    $this->WIDTH    =   CW_W_LG;
                    $this->HEIGHT   =   CW_W_MD;
                break;
            case CW_S_XL:
                    $this->WIDTH    =   CW_W_XL;
                    $this->HEIGHT   =   CW_W_MD;
                break;
            default:
                $this->WIDTH = false;
                break;
        }

        if(is_numeric($this->WIDTH) && is_numeric($this->HEIGHT))
        {
            $this->SCREEN = $screen;

            $this->WH[] = $this->WIDTH;
	        $this->WH[] = $this->HEIGHT;
        }
    }
}
?>