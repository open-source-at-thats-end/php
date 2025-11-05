<?php
namespace AppBundle\Domain;


use AppBundle\Entity\User;

class API
{
	private $API_IS_LIVE;
	private $API_KEY;
	private $API_URL;

	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		if(strpos($_SERVER['HTTP_HOST'],'preprod.') != false && strpos($_SERVER['HTTP_HOST'],'.project:') != false)
			$this->API_IS_LIVE = true;
		else
			$this->API_IS_LIVE = false;

		$this->API_KEY  =   'dfhdjfhtutu';
		$this->API_URL  =   'https://demo.server/api';
	}
	public function call($action_url, $query_string=false,$_post=false,$header=false)
	{
		$api_call_url   =   $this->getCallURL($action_url, $query_string);
		$api_header     =   $this->getHeader($header);
//dump($api_call_url);die;

		# Initialize connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $api_call_url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);

		# Thursday, December 06, 2007
		if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off'))
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($ch, CURLOPT_TIMEOUT, 25); //times out after 4s
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $api_header);
		if(is_array($_post) && count($_post) > 0)
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_post));
		}

		$result=curl_exec ($ch);
		//dump(curl_error($ch));die;
		curl_close ($ch);

		$response = json_decode($result);

		return $response;
	}
	public function getCallURL($action_url,$query_string=false)
	{
		$url = $this->API_URL.$action_url;

		if(is_array($query_string) &&  count($query_string) > 0)
		{
			$q = http_build_query($query_string);
			$url = $url.'?'.$q;
		}
		return $url;
	}
	public function getHeader($addi_header=false)
	{
		$header=array();

		$header[]   =   "accept: application/json";
		$header[]   =   "API_kEY: ". $this->API_KEY;
		$header[]   =   "cache-control: no-cache";

		if($this->API_IS_LIVE == false)
			$header[]   =   'API_DEV: yes';

		if(is_array($addi_header))
		{
			foreach($addi_header as $h_name => $h_value)
				$header[]   =   $h_name.": ".$h_value;
		}

		if(count($header) > 0)
			return $header;

		return false;
	}
	/*public function getCustomerById($id)
	{
		$action_url     =   '/customer';
		$query_string   =   array();
		$_post           =   fasle;

		$header['content-type']         =   'application/json';

		return $this->cal($action_url, $query_string, $_post, $header);
	}*/
	public function getCountries()
	{
		$action_url     =   '/Countries';
		$query_string   =   false;
		$_post           =   false;
		$header         =   false;

		return $this->call($action_url, $query_string, $_post, $header);
	}
	public function getCustomer($POST)
	{
		$action_url     =   '/Customer';
		$query_string   =   array();
		$_post           =   false;
		$header         =   false;

		$query_string['CustomerNumber'] = $POST['CustomerNumber'];
		$query_string['emailRequester'] = $POST['CustomerEmail'];

		return $this->call($action_url, $query_string, $_post, $header);
	}
	public function addCustomer($POST)
	{
		$action_url     =   '/Customer';
		$query_string   =   array();
		$_post           =   array();
		$header         =   array();

		# Set querystring
		$query_string['ProfileId']  = $POST['profile_id'];
		$query_string['ProductCode']= $POST['product_code'];

		# Set post data
		if($POST['profile_id'] == 2 || $POST['profile_id'] == 3)
		{
			$_post['CCExpMonth']      = $POST['exp_month'];
			$_post['CCExpYear']       = $POST['exp_year'];
			$_post['CCCard']         = $POST['number'];
			$_post['CCCVC']            = $POST['cvc'];
			$_post['Coupon']         = $POST['coupon'];
		}

		#Set json data
		$_post['Gender']         = $POST['Gender']->getname();
		$_post['FirstName']      = $POST['FirstName'];
		$_post['Lastname']       = $POST['Lastname'];
		$_post['ContactEmail']   = $POST['ContactEmail'];
		$_post['CustomerEmail']  = $POST['ContactEmail'];
		$_post['BirthDate']      = $POST['BirthDate'];
		$_post['VATNumber']      = "";
		$_post['Address1']       = "";
		$_post['Address2']       = "";
		$_post['Zip']            = "";
		$_post['City']           = "";
		$_post['CountryId']      = "";
		$_post['PhoneNumber']    = "";
		$_post['CustomerName']   = "";
		$_post['CountryName']    = "";
		$_post['CountryId']      = "430a2151-2a64-4269-87b7-6f57b7b5dec0";
		$_post['CustomerName']   = $POST['FirstName']." ".$POST['Lastname'];
		$_post['CountryName']    = 'France';

		# Set additional header
		$header['content-type']  =   'application/json';

		return $this->call($action_url, $query_string, $_post, $header);

	}
	public function updateCustomer($POST)
	{
		$action_url     =   '/Customer';
		$query_string   =   array();
		$_post          =   array();
		$header         =   array();

		# set querystring
		$query_string['CustomerNumber'] = $POST['CustomerNumber'];
		$query_string['emailRequester'] = $POST['ContactEmail'];

		# set post data
		$_post['Gender']         = $POST['Gender'];
		$_post['FirstName']      = $POST['FirstName'];
		$_post['Lastname']       = $POST['Lastname'];
		$_post['ContactEmail']   = $POST['ContactEmail'];
		$_post['VATNumber']      = $POST['VATNumber'];
		$_post['Address1']       = $POST['Address1'];
		$_post['Address2']       = $POST['Address2'];
		$_post['Zip']            = $POST['Zip'];
		$_post['City']           = $POST['City'];
		$_post['CountryId']      = $POST['CountryId'];
		$_post['PhoneNumber']    = $POST['PhoneNumber'];
		$_post['BirthDate']      = $POST['BirthDate'];
		$_post['CustomerName']   = $POST['CustomerName'];
		$_post['CountryName']    = $POST['CountryName'];
		$_post['CustomerEmail']  = $POST['CustomerEmail'];
		$_post['CustomerNumber'] = $POST['CustomerNumber'];

		# Set additonal header
		$header['content-type']  =   'application/json';

		return $this->call($action_url, $query_string, $_post, $header);
	}
	public function getInvociesByCustomerNumber($customer_number)
	{
		$action_url     =   '/Invoices';
		$query_string   =   array();
		$_post          =   false;
		$header         =   false;

		$query_string['CustomerNumber'] = $customer_number;

		return $this->call($action_url, $query_string, $_post, $header);

	}
	public function getPaymentMethodByCustomerNumber($customer_number)
	{
		$action_url     =   '/PaymentMethod';
		$query_string   =   array();
		$_post          =   false;
		$header         =   false;

		$query_string['CustomerNumber'] = $customer_number;

		return $this->call($action_url, $query_string, $_post, $header);

	}
	public function addOrUpdatePaymentMethod($POST)
	{
		$action_url     =   '/PaymentMethod';
		$query_string   =   array();
		$_post          =   array();
		$header         =   array();

		# Set query string
		$query_string['CustomerNumber'] = $POST['CustomerNumber'];
		$query_string['CardNumber']     = $POST['CardNumber'];
		$query_string['ExpMonth']       = $POST['ExpMonth'];
		$query_string['ExpYear']        = $POST['ExpYear'];
		$query_string['cvc']            = $POST['cvc'];

		# set Post Data
		$_post = $query_string;
		//dump($_post);die;
		# Set additonal header
		$header['content-type']  =   'application/json';

		return $this->call($action_url, $query_string, $_post, $header);
	}
	public function PurchaseCalculateTotal($POST)
	{
		$action_url     =   '/PurchaseCalculateTotal';
		$query_string   =   false;
		$_post          =   array();
		$header['content-type']  =   'application/json';

		# set Post Data
		$_post['UserId'] = $POST['UserId'];
		$_post['CustomerNumber'] = $POST['CustomerNumber'];
		$_post['Coupon'] = $POST['Coupon'];

		$_post['Items'] = array();
		$i=0;
		foreach($POST['Items'] as $k=>$v)
		{
			$_post['Items'][$i]['ProductCode'] = $v['ProductCode'];
			$_post['Items'][$i]['VideoId'] = $v['VideoId'];
			$i++;
		}

		return $this->call($action_url, $query_string, $_post, $header);
	}
	public function PurchasePlaceOrder($POST)
	{
		$action_url     =   '/PurchasePlaceOrder';
		$query_string   =   false;
		$_post          =   array();
		$header['content-type']  =   'application/json';

		# set Post Data
		$_post['UserId']            =   $POST['UserId'];
		$_post['CustomerNumber']    =   $POST['CustomerNumber'];
		$_post['Coupon']            =   $POST['Coupon'];
		$_post['useOnFileCard']     =   $POST['useOnFileCard'];
		$_post['creditCardNumber']  =   $POST['creditCardNumber'];
		$_post['creditCardMonth']   =   $POST['creditCardMonth'];
		$_post['creditCardYear']    =   $POST['creditCardYear'];
		$_post['CVC']               =   $POST['CVC'];
		$_post['saveCreditCardOnFile']  =   $POST['saveCreditCardOnFile'];
		$_post['profileId']         =   $POST['profileId'];

		$_post['Items'] = array();
		$i=0;
		foreach($POST['Items'] as $k=>$v)
		{
			$_post['Items'][$i]['ProductCode'] = $v['ProductCode'];
			$_post['Items'][$i]['VideoId'] = $v['VideoId'];
			$i++;
		}

		return $this->call($action_url, $query_string, $_post, $header);
	}
	public function getDataFromAPI(
		string $url,
		bool $in_dev=false
	){
		//$apiKey = $this->apiKey;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off'))
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($ch, CURLOPT_TIMEOUT, 25); //times out after 4s
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$header = array(
			'API_KEY: '. $this->apiKey,
			'Accept:application/json',
		);
		if($this->API_IS_LIVE == false)
			$header[] = 'API_DEV:yes';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$result=curl_exec($ch);
		//dump($result);die;
		return $result;
	}
	public function sendDataToAPI(
		string $url,
		bool $in_dev=false,
		string $param,
		?bool $pass_json=true

	){

		//$apiKey ='fvjerfuiherfureygujhwiwejkhrjkew';
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off'))
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($ch, CURLOPT_TIMEOUT, 25); //times out after 4s
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		if($param != '')
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		}
		if($in_dev == true)
			$api_dev ='yes';
		else
			$api_dev = 'no';

		$header = array(
			"accept: application/json",
			"api_key: ". $this->apiKey,
			"cache-control: no-cache",
			/*'API_KEY: '. $apiKey,
			'Accept:application/json',
			'API_DEV:'.$api_dev,
			'Content-Type:application/json'*/
		);
		if($pass_json == true)
		{
			$header[] = "content-type: application/json";
		}
		if($this->API_IS_LIVE == false)
			$header[] = 'API_DEV:yes';

		//dump($header);die;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$result=curl_exec($ch);
		//dump($result);die;
		return $result;
	}
}
?>