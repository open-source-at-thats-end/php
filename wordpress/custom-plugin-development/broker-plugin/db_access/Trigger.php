<?php
Class Trigger{
	public static $Instance;

	public $TableCounty      = 'trigger_search_by_county';
	public $TableCity        = 'trigger_search_by_city';
	public $TableArea        = 'trigger_search_by_area';
	public $TableSubdivision = 'trigger_search_by_subdivision';
	public $TableAddress     = 'trigger_search_by_address';
	public $TableZipcode     = 'trigger_search_by_zipcode';
	public $TableMls         = 'trigger_search_by_mls';

	public static function obj()
	{
		if(!is_object(self::$Instance))
			self::$Instance = new self();

		return self::$Instance;
	}
	public function __construct()
	{

	}
	public function  before_insert_on_listing_master()
	{
		$this->truncate_search_by_mls();
	}
	public function  after_insert_on_listing_master()
	{
		$this->insert_search_by_mls();
	}
	public function  before_insert_on_listing_address()
	{
		$this->truncate_search_by_county();
		$this->truncate_search_by_city();
		//$this->truncate_search_by_area();
		$this->truncate_search_by_subdivision();
		$this->truncate_search_by_address();
		$this->truncate_search_by_zipcode();
	}
	public function  after_insert_on_listing_address()
	{
		$this->insert_search_by_county();
		$this->insert_search_by_city();
		//$this->insert_search_by_area();
		$this->insert_search_by_subdivision();
		$this->insert_search_by_address();
		$this->insert_search_by_zipcode();
	}
	private function insert_search_by_county()
	{
		global $db;

		$sql = "INSERT INTO ".$this->TableCounty."(`county`)
                SELECT DISTINCT(County) AS County
                FROM listing_master AS M
                LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID
                WHERE County != ''
                AND is_mark_for_deletion = 'N'
                AND M.ListingStatus IN ('Active','Pending','ActiveUnderContract','ComingSoon')
                ORDER BY County";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_county()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableCounty."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function insert_search_by_city()
	{
		global $db;

		$sql = "INSERT INTO ".$this->TableCity."(`city_state`, `city`, `state`, `property_type`, `MLSP_ID`)
                SELECT DISTINCT(CONCAT_WS(', ', CityName, State)) AS CityState, CityName, State, PropertyType, MLSP_ID
                FROM listing_master AS M
                LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID
                WHERE is_mark_for_deletion = 'N'
                AND M.ListingStatus IN ('Active','Pending','ActiveUnderContract','ComingSoon')
                ORDER BY CityName";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_city()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableCity."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function insert_search_by_zipcode()
	{
		global $db;

		$sql = "INSERT INTO ".$this->TableZipcode."(`zip_code`, `property_type`, `MLSP_ID`)
                SELECT DISTINCT(ZipCode) AS ZipCode, PropertyType, MLSP_ID
                FROM listing_master AS M
                LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID
                WHERE ZipCode != ''
                AND is_mark_for_deletion = 'N'
                AND M.ListingStatus IN ('Active','Pending','ActiveUnderContract','ComingSoon')
                ORDER BY ZipCode";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_zipcode()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableZipcode."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function insert_search_by_subdivision()
	{
		global $db;

		$sql = "INSERT INTO ".$this->TableSubdivision."(`subdivision`, `property_type`, `MLSP_ID`)
                SELECT DISTINCT(Subdivision) AS Subdivision, PropertyType, MLSP_ID
                FROM listing_master AS M
                LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID
                WHERE is_mark_for_deletion = 'N'
                AND M.ListingStatus IN ('Active','Pending','ActiveUnderContract','ComingSoon')
                ORDER BY Subdivision";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_subdivision()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableSubdivision."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function insert_search_by_address()
	{
		global $db;

		$sql = "INSERT INTO ".$this->TableAddress."(`address`, `listing_id_mls`, `listing_status`, `property_type`, `MLSP_ID`)
                SELECT DISTINCT(CONCAT_WS(', ', Address, CityName, State)) AS address, CONCAT(M.MLS_NUM, '-', M.MLSP_ID) AS ListingID_MLS, M.ListingStatus, PropertyType, MLSP_ID
                FROM listing_master AS M
                LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID
                WHERE StreetNumber != ''
                AND is_mark_for_deletion = 'N'
                AND M.ListingStatus IN ('Active','Pending','ActiveUnderContract','ComingSoon')
                ORDER BY address";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_address()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableAddress."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function insert_search_by_mls()
	{
		global $db;

		$sql = "INSERT INTO ".$this->TableMls."(`mls_num`,`listing_status`,`property_type`, `MLSP_ID`)
                SELECT DISTINCT(MLS_NUM) AS MLS_NUM, M.ListingStatus, PropertyType, MLSP_ID
                FROM listing_master AS M
                WHERE is_mark_for_deletion = 'N'
                AND M.ListingStatus IN ('Active','Pending','ActiveUnderContract','ComingSoon')
                ORDER BY MLS_NUM";

		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_mls()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableMls."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	/*
	 * Below methods are not in use in this project
	 *
	 * */
	/*
	private function insert_search_by_area()
	{
		global $db;

		$sql = "INSERT INTO `".$this->TableArea."`(`area`)
				SELECT DISTINCT(Area) AS Area
				FROM listing_master AS M
				LEFT JOIN listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID
				WHERE is_mark_for_deletion = 'N'
				AND M.ListingStatus = 'Active'";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	private function truncate_search_by_area()
	{
		global $db;

		$sql = "TRUNCATE TABLE `".$this->TableArea."`";
		$rs = $db->quick_query($sql);
		return $rs;
	}
	*/
}
?>