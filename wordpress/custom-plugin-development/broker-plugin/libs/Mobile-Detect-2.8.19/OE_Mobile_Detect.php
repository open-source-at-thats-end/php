<?php
/**
 * Created by PhpStorm.
 * User: niravrajparmar
 * Date: 14/08/15
 * Time: 9:52 AM
 */
require_once("Mobile_Detect.php");
class dd extends Mobile_Detect
{
	public static $obj;

	public function __construct(array $headers = null, $userAgent = null)
	{
		parent::__construct($headers, $userAgent);
	}
}