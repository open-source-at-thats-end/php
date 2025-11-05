<?php
#=============================================================================================================================
#	File Name		:	IDX.php
#=============================================================================================================================
# Include data
require_once(dirname(__FILE__) . '/IDXListingData.php');

## Remove space
if(!function_exists('TrimArray'))
{
	function TrimArray($Input)
	{
		return trim($Input);
	}
}

class IDXListing extends IDXListingData
{
	#=========================================================================================================================
	#	Function Name	:   IDXgetListingByParam
	#	Return			:	None
	#-------------------------------------------------------------------------------------------------------------------------
    function IDXListing($isPopulateSchema=false)
    {
		# Make call to parent constructor
		parent::IDXListingData($isPopulateSchema);
	}
	#=========================================================================================================================
	#	Function Name	:   getQueryParameters
	#-------------------------------------------------------------------------------------------------------------------------
	function getQueryParameters($POST)
	{
		global $config, $asset;

        $Parameters	 =	'';
        if(trim($POST['Keywords']) != '')
		{
			$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['Keywords'], $keywords);

			$searchFields = array();

			$searchFields[] = 'Description';
			$searchFields[] = 'FireplaceFeatures';
            $searchFields[] = 'Cooling';
			$searchFields[] = 'Appliances';
            $searchFields[] = 'EatingArea';
            $searchFields[] = 'ExteriorFeatures';
            $searchFields[] = 'Fencing';
            $searchFields[] = 'Flooring';
            $searchFields[] = 'Heating';
            $searchFields[] = 'InteriorFeatures';
            $searchFields[] = 'LotFeatures';
            $searchFields[] = 'Patio';
            $searchFields[] = 'Roof';
            $searchFields[] = 'Rooms';
            $searchFields[] = 'EntryLocation';
            $searchFields[] = 'LaundryRoom';
            $searchFields[] = 'AccessibilityFeatures';
            $searchFields[] = 'PoolDesc';
            $searchFields[] = 'SpaDescription';
            $searchFields[] = 'PropertyStyle';
            $searchFields[] = 'ConstructionMaterials';
            $searchFields[] = 'ViewDesc';
            $searchFields[] = 'CommunityFeatures';
            $searchFields[] = 'DoorFeatures';
            $searchFields[] = 'FoundationDetails';
            $searchFields[] = 'OtherStructures';
            $searchFields[] = 'ParkingFeatures';

			$fieldsToSearch = implode(", ", $searchFields);

			$arrMlsNum = array();

			$arrAddKeyword = array();

			$arrParams = array();

			for($i=0; $i<count($keywords[0]); $i++)
			{
				$word = $keywords[0][$i];

				array_push($arrAddKeyword, $word);
			}

			if(count($arrAddKeyword) > 0)
			{
				// Street
				$strSearch = " CONCAT_WS(' ',". $fieldsToSearch. ") LIKE '%". implode(" ", $arrAddKeyword). "%' ";

				array_push($arrParams, $strSearch);

			}

			if(count($arrParams) > 0)
				$Parameters	 .=	" AND (".implode(" OR ", $arrParams).")";
		}

		## Quick Search
		if(trim($POST['quick_search']) != '')
		{
			$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['quick_search'], $keywords);

			$searchFields = array();
			$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'Address';

			$fieldsToSearch = implode(", ", $searchFields);

			$arrMlsNum = array();
			$arrAddKeyword = array();
			$arrParams = array();
			for($i=0; $i<count($keywords[0]); $i++)
			{
				$word = $keywords[0][$i];

				array_push($arrAddKeyword, $word);
			}

			if(count($arrAddKeyword) > 0)
			{
				// Street
				$strSearch = " CONCAT_WS(' ',". $fieldsToSearch. ") LIKE '%". implode(" ", $arrAddKeyword). "%' ";
				array_push($arrParams, $strSearch);

				// City Name
				$condition 	 = implode("%' OR CityName LIKE '%", $arrAddKeyword);
				$strSearch	 =	" ( CityName LIKE '%". $condition. "%' ) ";

				array_push($arrParams, $strSearch);
			}

			if(count($arrParams) > 0)
				$Parameters	 .=	" AND (".implode(" OR ", $arrParams).")";
		}


		if( isset($POST['LastChangeType']) && $POST['LastChangeType'] != '' )
        {
            $Parameters	 .=	" AND AI.LastChangeType = '".$POST['LastChangeType']."' ";
        }

        if(isset($POST['IsnewOrPriceChange']) && $POST['IsnewOrPriceChange'] == true)
        {
            $Parameters .= " AND ( M.ListingDate = CURRENT_DATE() OR ( ( M.Price_Diff != '' OR M.Price_Diff != 0) AND M.ListPrice != M.Old_Price) ) ";
        }

		## Address + Mls num Search
		if(trim($POST['Address']) != '')
		{
			$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['Address'], $keywords);

			$searchFields = array();
			$searchFields[] = 'UnitNo';
			$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'Address';

			$fieldsToSearch = implode(", ", $searchFields);

			$arrMlsNum = array();
			$arrAddKeyword = array();
			$arrParams = array();
			for($i=0; $i<count($keywords[0]); $i++)
			{
				$word = $keywords[0][$i];

				array_push($arrAddKeyword, $word);

				// MLS NUM ?
				/*print(strpos($word, '-'));

				if(strpos($word, '-') !== false && is_numeric(str_replace('-','', $word)))
					array_push($arrMlsNum, $word);
				else
					array_push($arrAddKeyword, $word);		*/
			}

			// FOR MLS NUM Search
			//$ret = preg_match_all("/[0-9-]+/", $POST['Address'], $keywords);

			if(count($keywords[0]) > 0)
			{

				array_push($arrParams, "M.MLS_NUM IN ('". implode("','", $keywords[0]). "')");
			}

			if(count($arrAddKeyword) > 0)
			{
				$strSearch = " CONCAT_WS(' ',". $fieldsToSearch. ") LIKE '%". implode(" ", $arrAddKeyword). "%' ";

				array_push($arrParams, $strSearch);

				// City Name
				$condition 	 = implode("%' OR CityName LIKE '%", $arrAddKeyword);
				$strSearch	 =	" ( CityName LIKE '%". $condition. "%' ) ";

				array_push($arrParams, $strSearch);
			}

			if(count($arrParams) > 0)
				$Parameters	 .=	" AND (".implode(" OR ", $arrParams).")";

			//print $Parameters;
		}


		# City, Neighborhood, Address, Zip or MLS#
		#---------------------------------------------------------------------------------
		if($POST['AddressType']!='' && $POST['AddressValue']!='')
		{

			if(strtolower($POST['AddressType']) == 'address')
			{
				$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['AddressValue'], $keywords);

				$arrKeyword = str_replace(', ',' ', $POST['AddressValue']);

				if($ret == '2')
				{
					$searchFields = array();
					$searchFields[] = 'CityName';
					$searchFields[] = 'State';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
				}
				elseif($ret == '3')
				{
					$searchFields = array();
					$searchFields[] = 'StreetName';
					$searchFields[] = 'CityName';
					$searchFields[] = 'State';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
				}
				else
				{
					$searchFields = array();
					$searchFields[] = 'StreetNumber';
					$searchFields[] = 'StreetName';
					$searchFields[] = 'CityName';
					$searchFields[] = 'State';

					$fieldsToSearch = implode(", ", $searchFields);

					$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
				}
			}
			elseif(strtolower($POST['AddressType']) == 'citystate')
			{
				$arrKeyword = str_replace(', ',' ', $POST['AddressValue']);

				$searchFields = array();
				$searchFields[] = 'CityName';
				$searchFields[] = 'State';

				$fieldsToSearch = implode(", ", $searchFields);

				$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".$arrKeyword."'";
			}
			elseif(strtolower($POST['AddressType']) == 'city' || strtolower($POST['AddressType']) == 'cityname')
			{

				//$arrKeyword = str_replace(', ',' ', $POST['AddressValue']);
				$city=explode(', ', $POST['AddressValue']);
				$arrKeyword= ucwords(strtolower($city[0]));
				$searchFields = array();
				$searchFields[] = 'CityName';

				$fieldsToSearch = implode(", ", $searchFields);

//				$Parameters .= " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword . "%' ";
				$Parameters .= " AND CityName = '".$arrKeyword. "'";

			}
			elseif(strtolower($POST['AddressType']) == 'zipcode')
			{
				$Parameters	 .=	" AND ( A.ZipCode LIKE '".$POST['AddressValue']."' ) ";
			}
			elseif(strtolower($POST['AddressType']) == 'mls_num' || strtolower($POST['AddressType']) == 'mls')
			{
				//$fieldsToSearch = explode(" ", $POST['AddressValue']);

				$Parameters	 .=	" AND ( M.MLS_NUM LIKE '".$POST['AddressValue']."' ) ";
			}
			elseif(strtolower($POST['AddressType']) == 'area')
			{
				$Parameters .= " AND A.Subdivision = '".$POST['AddressValue']."'";
			}
			elseif(strtolower($POST['AddressType']) == 'county')
			{
				$Parameters .= " AND A.County = '".$POST['AddressValue']."'";
			}
		}
        //Utility::pre($Parameters);
        # Address type is empty when value is not selected from dropdown
        if(is_array($POST['AddressValue']) && count($POST['AddressValue']) > 0 && ($POST['AddressType'] == 'all' || !isset($POST['AddressType'])))
        {
            $searchFields = array();
			/*$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';*/
            $searchFields[] = 'UnitNo';
			$searchFields[] = 'StreetNumber';
            $searchFields[] = 'StreetDirection';
            $searchFields[] = 'StreetDirPrefix';
            $searchFields[] = 'StreetName';
			$searchFields[] = 'StreetSuffix';
            //$searchFields[] = 'StreetSuffix_Short_code';
            $searchFields[] = 'StreetDirSuffix';
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';
            //$searchFields[] = 'StateName';
            $searchFields[] = 'ZipCode';

            $fieldsToSearch = implode(", ", $searchFields);

            foreach($POST['AddressValue'] as $key => $info)
            {
                if(!empty($info))
                {
                    $info = preg_replace('/\bpv\b/i', 'paradise valley', $info);
                    //Utility::pre($POST['AddressValue']);
                    //east west north south
                    $find_d = array('/\beast\b/i', '/\bwest\b/i', '/\bnorth\b/i', '/\bsouth\b/i');
                    $replace_d = array('E','W', 'N', 'S');
                    $info = preg_replace($find_d, $replace_d, $info);
                    $arrKeyword = preg_replace("/[^a-zA-Z0-9-\/#&]/"," ",$info);
                    $Keyword = trim($arrKeyword);

                    $arr_Parameters[] = " CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".str_replace(' ','%',$Keyword)."%'";
                }
            }

            if(is_array($arr_Parameters))
            {
                $Parameters .= " AND ( ";

                $Parameters .= implode(" OR ",$arr_Parameters);

                $Parameters .= " ) AND  UnitNo_2 > 0 ";
            }

            //$Parameters = " "
        }
        elseif($POST['AddressValue'] != '' && ($POST['AddressType'] == 'all' || !isset($POST['AddressType'])))
        {
            //$arrKeyword = str_replace(', ',' ', $POST['AddressValue']);
            $POST['AddressValue'] = preg_replace('/\bpv\b/i', 'paradise valley', $POST['AddressValue']);
            //Utility::pre($POST['AddressValue']);
            //east west north south
            $find_d = array('/\beast\b/i', '/\bwest\b/i', '/\bnorth\b/i', '/\bsouth\b/i');
            $replace_d = array('E','W', 'N', 'S');
            $POST['AddressValue'] = preg_replace($find_d, $replace_d, $POST['AddressValue']);
            $arrKeyword = preg_replace("/[^a-zA-Z0-9-\/#&]/"," ",$POST['AddressValue']);

            //Utility::pre($arrKeyword);
            //$Keyword = Utility::buildSefString(trim($arrKeyword));
            $Keyword = trim($arrKeyword);
            //Utility::pre($Keyword);
            $Parameters.= " AND (";

            $searchFields = array();
			/*$searchFields[] = 'StreetNumber';
			$searchFields[] = 'StreetName';
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';*/
            $searchFields[] = 'UnitNo';
			$searchFields[] = 'StreetNumber';
            $searchFields[] = 'StreetDirection';
            $searchFields[] = 'StreetDirPrefix';
            $searchFields[] = 'StreetName';
			$searchFields[] = 'StreetSuffix';
            //$searchFields[] = 'StreetSuffix_Short_code';
            $searchFields[] = 'StreetDirSuffix';
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';
            //$searchFields[] = 'StateName';
            $searchFields[] = 'ZipCode';

            $fieldsToSearch = implode(", ", $searchFields);
            $Parameters .= " CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".str_replace(' ','%',$Keyword)."%'";
            //Utility::pre($Parameters);

            $searchFields = array();
			$searchFields[] = 'CityName';
			$searchFields[] = 'State';
            //$searchFields[] = 'StateName';
            $fieldsToSearch = implode(", ", $searchFields);
            $Parameters .= " OR CONCAT_WS(' ',". $fieldsToSearch.") LIKE '".str_replace(' ','%',$Keyword)."'";

            /*$Parameters .= " OR ( A.Area LIKE '%".$Keyword."%')";*/
            $Parameters .= " OR ( A.ZipCode LIKE '%".$Keyword."%' )";
            $Parameters .= " OR FIND_IN_SET('".addslashes($Keyword)."',Subdivision)";

            /*$searchFields = array();
			$searchFields[] = 'County';
			$searchFields[] = 'State';
            $fieldsToSearch = implode(", ", $searchFields);
            $Parameters .= " OR CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$Keyword."%'";*/

            /*$searchFields = array();
			$searchFields[] = 'Elementary_School';
			$searchFields[] = 'High_School';
            $searchFields[] = 'Middle_School';

            $fieldsToSearch = implode(", ", $searchFields);
            $Parameters .=  " AND CONCAT_WS(' ',". $fieldsToSearch.") LIKE '%".$arrKeyword."%'";*/

            $MLS_Keyword = str_replace("MLS# ",'',$arrKeyword);
            $Parameters .= " OR ( M.MLS_NUM LIKE '".$MLS_Keyword."'  ) ";

            $Parameters .= " OR ( M.Description LIKE '%".str_replace(' ','%',$Keyword)."%'  ) ";

            $Parameters .= " )";

        }
		# StreetNumber
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['StreetNumberBegin']!='')
			$Parameters	 .=	" AND A.StreetNumber >= ". intval($POST['StreetNumberBegin']). "";

		if ($POST['StreetNumberEnd']!='')
			$Parameters	 .=	" AND A.StreetNumber <= ". intval($POST['StreetNumberEnd']). "";

		# StreetName
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['StreetName']!='')
			$Parameters	 .=	" AND A.StreetName LIKE '%". $POST['StreetName']. "%' ";

		# remarks search
			#-----------------------------------------------------------------------------------------------------------------
		if ($POST['remarks']!='')
			$Parameters	 .=	" AND (PrivateRemarks LIKE '%". $POST['remarks']. "%' "."OR Description LIKE '%". $POST['remarks']. "%' " . " OR AI.Legal LIKE '%". $POST['remarks']. "%') ";

		# Multiple StreetName
		#-----------------------------------------------------------------------------------------------------------------
		if(trim($POST['street_name_list'])!='')
		{
			$POST['street_name_list'] = preg_replace("/ +/", "%", $POST['street_name_list']); // Replace multiple/single space with %

			$arrKeyword = explode(",", trim($POST['street_name_list'], ",")); // Remove comma(,) from the beginning and end of a string

			$condition 	 = implode("%' OR A.StreetName LIKE '%", $arrKeyword);

			$Parameters	 .=	" AND ( A.StreetName LIKE '%". $condition. "%' ) ";
		}

		# Zip Code
		#-----------------------------------------------------------------------------------------------------------------
		if(trim($POST['prop_zipcode_list']) != '')
		{
			$POST['prop_zipcode_list'] = preg_replace("/ +/", "", $POST['prop_zipcode_list']); // Replace multiple/single space with none, we have no space in zipcode field

			$arrKeyword = explode(",", trim($POST['prop_zipcode_list'], ",")); // Remove comma(,) from the beginning and end of a string


			$condition 	 = implode("%' OR A.ZipCode LIKE '", $arrKeyword);

			$Parameters	 .=	" AND ( A.ZipCode LIKE '". $condition. "%' ) ";
		}
		elseif ($POST['ZipCode']!='')
		{
			$ret = preg_match_all("/[0-9-]+/", $POST['ZipCode'], $keywords);

			if(count($keywords[0]) > 0)
			{
				$condition 	 = implode("%' OR ZipCode LIKE '%", $keywords[0]);

				$Parameters	 .=	" AND ( ZipCode LIKE '%". $condition. "%')";
			}
			//$Parameters	 .=	" AND A.ZipCode LIKE '". $POST['ZipCode']. "%' ";
		}

		# State Name
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['State'])
			$Parameters	 .=	" AND A.State = '". $POST['State']. "'";

		# County Name
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['County']))
		{
			$POST['County'] = array_filter($POST['County']);

			if(count($POST['County']) > 0)
			{
				$condition 	 = implode('" OR County = "', $POST['County']);

				$Parameters	 .=	' AND ( County = "'. $condition. '" ) ';
			}

		}
		elseif($POST['County'] != '')
			$Parameters .= " AND County = '". $POST['County'] ."' ";

		/*	MS
			Saturday, November 03, 2012
			Predefine search using checkbox with name City
		 */
		if(isset($POST['City']))
			$POST['CityName'] = $POST['City'];

		# City Name
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['CityName']))
		{
			$POST['CityName'] = array_filter($POST['CityName']);

			if(count($POST['CityName']) > 0)
			{
				$condition 	 = implode('" OR CityName = "', $POST['CityName']);

				$Parameters	 .=	' AND ( CityName = "'. $condition. '" ) ';
			}

		}
		elseif($POST['CityName'])
		{

			if(strpos($POST['CityName'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['CityName']);

				$Parameters .= " AND CityName LIKE '".$cityName."'";
			}
			else
			{
				$Parameters	 .=	" AND A.CityName = '". $POST['CityName']. "'";
			}
		}

		# Subdivision
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['Subdivision']))
		{
			$POST['Subdivision'] = array_filter($POST['Subdivision']);

			if(count($POST['Subdivision']) > 0)
			{
			     //Utility::pre($POST['Subdivision']);
                 /*$condition 	 = implode("' OR Subdivision LIKE '%", $POST['Subdivision']);

				$Parameters	 .=	" AND ( Subdivision LIKE '%". $condition. "%' ) ";*/
                $temp = '';

                foreach($POST['Subdivision'] as $Key=>$val)
                    $temp[] = " FIND_IN_SET('".addslashes($val)."',Subdivision) ";

                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
            }
		}
		elseif ($POST['Subdivision'] != '')
		{
		  	//$Parameters	 .=	" AND Subdivision = '". $POST['Subdivision']. "' ";

			/*$ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['Subdivision'], $keywords);

			if(count($keywords[0]) > 0)
			{
				$condition 	 = implode("%' OR Subdivision LIKE '%", $keywords[0]);

				$Parameters	 .=	" AND ( Subdivision LIKE '%". $condition. "%')";
			}*/
            $Parameters .= " AND FIND_IN_SET('".addslashes($POST['Subdivision'])."',Subdivision)";
        }
        /*if ($POST['SubdivisionFindInSet']!='')
		{
			$POST['prop_subdivision'] = str_replace(" ", "%", preg_replace("/ +/", " ",$POST['prop_subdivision'])); // Remove multiple spaces with single one, all spaces by %
			$Parameters	 .=	" AND (FIND_IN_SET(Subdivision, '". addslashes($POST['SubdivisionFindInSet']). "') OR Subdivision LIKE '". addslashes($POST['prop_subdivision']). "')";
		}*/
		# Area
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['Area']))
		{
			$POST['Area'] = array_filter($POST['Area']);

			if(count($POST['Area']) > 0)
			{
				$condition 	 = implode("', '", $POST['Area']);

				$Parameters	 .=	" AND Area IN('". $condition. "')";
			}
		}
		elseif ($POST['Area']!='')
		{
			if(strpos($POST['Area'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['Area']);

				$Parameters .= " AND Area LIKE '".$cityName."'";
			}
			else
			{
				$str = str_replace(",", "','", $POST['Area']);
				$Parameters	 .=	" AND Area IN('".$str. "')";
			}

		}
		elseif ($POST['MLS_Area']!='')
		{
			if(strpos($POST['MLS_Area'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['MLS_Area']);

				$Parameters .= " AND Area LIKE '".$cityName."'";
			}
			else
			{
				$str = str_replace(",", "','", $POST['MLS_Area']);
				$Parameters	 .=	" AND Area IN('".$str. "')";
			}

		}

		//var_dump($POST['Area']);

		# Listing ID
		#-----------------------------------------------------------------------------------------------------------------
		if(is_array($POST['NOT_ListingID_MLS']))
		{
			$arr_ret = array_map("TrimArray", $POST['NOT_ListingID_MLS']);

			if($POST['Not_Blk_List'])
            {
                $Parameters	 .=	" AND CONCAT(M.MLS_NUM,'-',M.MLSP_ID) IN ('". implode("','",$arr_ret). "') ";
            }
            else
            {
                $Parameters	 .=	" AND CONCAT(M.MLS_NUM,'-',M.MLSP_ID) NOT IN ('". implode("','",$arr_ret). "') ";
            }
        }

		# Listing ID [Not IN]
		if($POST['NOT_MLS_NUM'])
			$Parameters	 .=	" AND M.MLS_NUM NOT IN ('". $POST['NOT_MLS_NUM']. "') ";

		# MLS No
		#-----------------------------------------------------------------------------------------------------------------
		if(is_array($POST['MlsNum']))
			$Parameters	 .=	" AND M.MLS_NUM IN ('". implode("','",$POST['MlsNum']). "') ";
		elseif($POST['MlsNum'] != '')
		{
			$POST['MlsNum'] = str_replace(",", "','", trim($POST['MlsNum']));
			$Parameters	 .=	" AND M.MLS_NUM IN ('". $POST['MlsNum'] ."') ";
		}

		if(trim($POST['prop_mlsno_list'])!='')
		{
			$POST['prop_mlsno_list'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['prop_mlsno_list'])));
			$Parameters	 .=	" AND M.MLS_NUM IN ('". $POST['prop_mlsno_list']. "') ";
        }
		// MLS-MARKETID
		if(trim($POST['prop_mlsno_with_market'])!='')
		{
			$POST['prop_mlsno_with_market'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['prop_mlsno_with_market'])));
			$Parameters	 .=	" AND CONCAT(M.MLS_NUM,'-',M.MLSP_ID) IN ('". $POST['prop_mlsno_with_market']. "') ";
		}

		if(trim($POST['prop_mlsno'])!='')
		{
			$Parameters	 .= " AND M.MLS_NUM LIKE '". trim($POST['prop_mlsno']). "%'";
		}

		# MLSP_ID
		#-----------------------------------------------------------------------------------------------------------------
		if(($POST['MLSP_ID'] != '0' && $POST['MLSP_ID'] != ''))
		{
			if(strpos($POST['MLSP_ID'], "','") == false)
				$POST['MLSP_ID'] = str_replace(",", "','", $POST['MLSP_ID']);

			$Parameters	 .=	" AND M.MLSP_ID IN('".$POST['MLSP_ID']."')";
		}
        /*else
        {
            $Parameters	 .=	" AND M.MLSP_ID IN('1')";
        }*/

		if($POST['NOT_MLSP_ID'] != '')
			$Parameters	 .=	" AND M.MLSP_ID != ".$POST['NOT_MLSP_ID'];

		if($POST['ActiveListingFlag'])
		{
			if($this->picPath['InActive_MLSP_ID'] != '')
				$Parameters	 .=	" AND M.MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";
		}

		# Property Feature
		#=================================================================================================================

		# Propert Style
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['PropertyStyle']))
		{
			$POST['PropertyStyle'] = array_filter($POST['PropertyStyle']);

			if(count($POST['PropertyStyle']) > 0)
			{
				$Parameters	 .=	" AND FIND_IN_SET(PropertyStyle, '".implode(",",$POST['PropertyStyle']). "')";
			}
		}
		elseif ($POST['PropertyStyle']!='')
		{
			$Parameters	 .=	" AND PropertyStyle = '".$POST['PropertyStyle']. "'";
		}
        # Sale Type
        #-----------------------------------------------------------------------------------------------------------------
        if (is_array($POST['saletype']))
		{
			$POST['saletype'] = array_filter($POST['saletype']);
			if(count($POST['saletype']) > 0)
			{
                $temp = '';
                foreach($POST['saletype'] AS $key => $val)
                {
                    $arr_val = explode(",", $val);
                    foreach($arr_val AS $skey => $sval)
                    {
                        $temp[] = " FIND_IN_SET('".$asset['OL_SALE_TYPE'][$sval]."',SaleType) ";
                    }

                }
                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif ($POST['saletype']!='')
		{
			$Parameters	 .=	" AND SaleType = '".$asset['OL_SALE_TYPE'][$POST['saletype']]. "'";
		}
        # Property Condition
        //echo"<pre>";print_r($POST);die;
        #-------------------------------------------------------------------------------------------------------------------
        if (is_array($POST['condition']))
		{
            $POST['condition'] = array_filter($POST['condition']);
			if(count($POST['condition']) > 0)
			{
            	$temp = '';

                foreach($POST['condition'] as $Key=>$val)
                    $temp[] = " FIND_IN_SET('".$asset['OL_STRU_CONDITION'][$val]."',StructuralCondition) ";

                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
    		}
		}
        # Propert Type
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['PropertyType']))
		{
			$POST['PropertyType'] = array_filter($POST['PropertyType']);

			if(count($POST['PropertyType']) > 0)
			{
			    $temp = '';

                foreach($POST['PropertyType'] as $Key=>$val)
                    $temp[] = " FIND_IN_SET('".$val."',PropertyType) ";

                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
                //$Parameters	 .=	" AND FIND_IN_SET(PropertyType, '".implode(",",$asset['OL_PROPERTY_TYPE'][$POST['PropertyType']]). "')";
			}
		}
        elseif ($POST['PropertyType']!= '')
		{
			// is it sub type ?
			if(strpos($POST['PropertyType'], 'PST|') !== false)
			{
				$POST['PropertyType'] = str_replace('PST|', '', $POST['PropertyType']);

				$Parameters	 .=	" AND FIND_IN_SET('".$POST['PropertyType']."', SubType)";
			}
			else
				$Parameters	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

            //$Parameters	 .=	" AND PropertyType = '".$asset['OL_PROPERTY_TYPE'][$POST['PropertyType']]. "'";
        }
        # Stories Description
        #------------------------------------------------------------------------------------------------------------------
        if (is_array($POST['storiesdesc']))
		{
			$POST['storiesdesc'] = array_filter($POST['storiesdesc']);

			if(count($POST['storiesdesc']) > 0)
			{
				$temp = '';

                foreach($POST['storiesdesc'] as $Key=>$val)
                    $temp[] = " FIND_IN_SET('".$asset['OL_STORIES_DESC'][$val]."',StoriesDescription) ";

                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
			}
		}
		elseif ($POST['storiesdesc'] !='' )
		{
			$Parameters	 .=	" AND StoriesDescription = '".$POST['storiesdesc']. "'";
		}
		//print $Parameters;

		if ($POST['Not_PropertyType'] != '')
		{
			$POST['Not_PropertyType'] = str_replace(",", "','", $POST['Not_PropertyType']);

			$Parameters	 .=	" AND PropertyType NOT IN('".$POST['Not_PropertyType']."')";
		}

		# Propert Sub Type
        #-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['subtype']))
		{
			$POST['subtype'] = array_filter($POST['subtype']);

			if(count($POST['subtype']) > 0)
			{
			    $temp = '';
                foreach($POST['subtype'] as $Key=>$val)
                {
                    if($val == 'multi')
                    {
                        $temp[] = " FIND_IN_SET(PropertyType, 'Residential Income') ";
                    }
                    else
                    {
                        $subProp = explode('|',$val);
                        foreach($subProp as $Key2 => $Propval)
                        {
                            $temp[] = " FIND_IN_SET(SubType, '".$asset['OL_PropType_LOOK_UP'][trim($Propval)]. "') ";
                        }

                    }
                }
                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
                //$Parameters	 .=	" AND FIND_IN_SET(SubType, '".implode(",",(str_replace('|',',',$POST['PropertySubType']))). "')";
			}
        }
		elseif ($POST['subtype']!='' && $POST['subtype'] == 'residential lease')
			$Parameters	 .=	" AND PropertyType = '".$POST['subtype']. "'";

		elseif ($POST['subtype']!='' && $POST['subtype'] == 'land')
			$Parameters	 .=	" AND PropertyType = '".$POST['subtype']. "'";

		elseif ($POST['subtype']!='' && $POST['subtype'] == 'manufactured in park')
			$Parameters	 .=	" AND PropertyType = '".$POST['subtype']. "'";

		elseif ($POST['subtype']!='' && $POST['subtype'] == 'other')
		{
			$Parameters	 .=	" AND SubType NOT IN ('Single Family Residence', 'Condominium', 'Townhouse')";
			/*$temp[] = " FIND_IN_SET(SubType,'Apartment,Cabin,Commercial/Residential,Deeded Parking,Duplex,Loft,Manufactured On Land,Own Your Own,Quadruplex,Rooms for Rent,Stock Cooperative,Studio,Triplex') ";
			$temp_q     = implode(' OR ', $temp);
			$Parameters .= " AND (".$temp_q.")";*/
		}

		elseif ($POST['subtype']!='' && $POST['subtype'] != 'multi')
			$Parameters	 .=	" AND SubType = '".$POST['subtype']. "'";

        elseif ($POST['subtype']!='' && $POST['subtype'] == 'multi')
            $Parameters	 .=	" AND PropertyType = '".$POST['subtype']. "'";

        //echo $Parameters;die;
		# Propert Category
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['Category']!='')
			$Parameters	 .=	" AND Category = '".$POST['Category']. "'";

		# Price Range
		# -----------------------------------------------------------------------------
		if (isset($POST['min_price']) && ($POST['min_price']!='' && $POST['min_price']!='Any'))
			$Parameters .= " AND M.ListPrice >= ". $POST['min_price'];
        if (isset($POST['max_price']) && ($POST['max_price']!='' && $POST['max_price']!='Any'))
		{
			$Parameters .= " AND M.ListPrice <= ". $POST['max_price'];
		}


		//Utility::pre($Parameters);
		// Range given ex : $15000 - $2500000
		if ($POST['ListPriceRange'] != '' && $POST['ListPriceRange'] != 'Any')
		{
			$arrTemp = explode("-", preg_replace("/[^0-9-]/",	"", 	$POST['ListPriceRange']));

			if($arrTemp[0] > 0)
				$Parameters .= " AND M.ListPrice >= '". $arrTemp[0] ."'";

			if($arrTemp[1] != $POST['max_price'])
				$Parameters .= " AND M.ListPrice <= '". $arrTemp[1] ."'";
		}

		# Master Bedroom
		# -----------------------------------------------------------------------------
		if($POST['MasterBedroom']!='')
			$Parameters .= " AND M.MasterBedroom LIKE '%". $POST['MasterBedroom']."%'";

		# BedRooms Range
		# -----------------------------------------------------------------------------
		if($POST['min_beds'] > 0)
			$Parameters .= " AND M.Beds >= ". intval($POST['min_beds']);

		if($POST['max_beds'] > 0)
			$Parameters .= " AND M.Beds <= ". intval($POST['max_beds']);

		// Range given
		if ($POST['BedRange'] != '')
		{
			$arrTemp = explode("-", preg_replace("/[^0-9-]/",	"", 	$POST['BedRange']));

			if($arrTemp[0] > 0)
				$Parameters .= " AND M.Beds >= '". $arrTemp[0] ."'";

			if($arrTemp[1] != $POST['max_bed'])
				$Parameters .= " AND M.Beds <= '". $arrTemp[1] ."'";
		}

        if (isset($POST['Beds']) && ($POST['Beds']!= 'Any' && $POST['Beds'] != '' && $POST['Beds'] != 0))
		{
		    $Parameters .= " AND M.Beds = '". $POST['Beds'] ."'";
		}

		# BathRoms Range
		# -----------------------------------------------------------------------------
		if($POST['prop_min_bathroom'] > 0)
			$Parameters .= " AND M.BathsFull >= ". intval($POST['prop_min_bathroom']);

		if($POST['prop_max_bathroom'] > 0)
			$Parameters .= " AND M.BathsFull <= ". intval($POST['prop_max_bathroom']);
        if (isset($POST['Baths']) && ($POST['Baths'] != 'Any' && $POST['Baths'] != '' && $POST['Baths'] != 0))
		{
			$Parameters .= " AND M.Baths >= '". round($POST['Baths']) ."'";
		}
		# Garage Range
		# -----------------------------------------------------------------------------
		if($POST['min_garage'] > 0)
			$Parameters .= " AND M.Garage >= ". intval($POST['min_garage']);

		if($POST['max_garage'] > 0)
			$Parameters .= " AND M.Garage <= ". intval($POST['max_garage']);

		# Min Square Feet
		# -----------------------------------------------------------------------------
		if($POST['min_sqft'] > 0)
			$Parameters .= " AND M.SQFT >= ". $POST['min_sqft'];

		if($POST['max_sqft'] > 0)
			$Parameters .= " AND M.SQFT <= ". $POST['max_sqft'];

		// Range given ex : 150 - 1000
		if ($POST['SQFTRange'] != '')
		{
			$arrTemp = explode("-", preg_replace("/[^0-9-]/",	"", 	$POST['SQFTRange']));
			if($arrTemp[0] > 0)
				$Parameters .= " AND M.SQFT >= '". $arrTemp[0] ."'";

			if($arrTemp[1] != $POST['max_sqft'])
				$Parameters .= " AND M.SQFT <= '". $arrTemp[1] ."'";
		}

		# Garage Range
		# -----------------------------------------------------------------------------
		if($POST['prop_min_stories'] > 0)
			$Parameters .= " AND M.Stories >= ". intval($POST['prop_min_stories']);

		if($POST['prop_max_stories'] > 0)
			$Parameters .= " AND M.Stories <= ". intval($POST['prop_max_stories']);

		# Stories
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['Stories']))
		{
			$POST['Stories'] = array_filter($POST['Stories']);

			if(count($POST['Stories']) > 0)
			{
				$condition 	 = implode("%' OR Stories LIKE '%", $POST['Stories']);

				$Parameters	 .=	" AND ( Stories LIKE '%". $condition. "%' ) ";
			}
		}
		elseif (isset($POST['Stories']) && ($POST['Stories'] != '' && $POST['Stories'] != 'Any'))
			$Parameters	 .=	" AND Stories LIKE '%". $POST['Stories']. "%'";

		#Parking
        #-----------------------------------------------------------------------------------------------------------------
        if (isset($POST['Parking']) && ($POST['Parking']!= 'Any' && $POST['Parking'] != '' && $POST['Baths'] != 0))
		{
		    $Parameters .= " AND M.Parking >= '". $POST['Parking'] ."'";
		}
		#Total Unit
        #-----------------------------------------------------------------------------------------------------------------
        if($POST['units'] != '' && $POST['units'] != 'Any')
        {
            $Parameters	 .=	" AND TotalUnits >= '". $POST['units']. "'";
        }
		# TotalAcreage
		#-----------------------------------------------------------------------------------------------------------------
		if (isset($POST['minacreage']) && $POST['minacreage']!='' && $POST['minacreage']!='Any')
			$Parameters	 .=	" AND TotalAcreage >= '". $POST['minacreage']. "'";

		if ($POST['prop_min_acreage']!='')
			$Parameters	 .=	" AND TotalAcreage >= '". $POST['prop_min_acreage']. "'";

		if ($POST['prop_max_acreage']!='')
			$Parameters	 .=	" AND TotalAcreage >= '". $POST['prop_max_acreage']. "'";

		# Year Range
		# -----------------------------------------------------------------------------
		if ($POST['minyear']!='' && $POST['minyear']!='0')
			$Parameters .= " AND M.YearBuilt >= '". $POST['minyear'] ."'";

		if ($POST['maxyear']!='' && $POST['maxyear']!='0')
			$Parameters .= " AND M.YearBuilt <= '". $POST['maxyear'] ."'";

		if ($POST['YearBuilt']!='')
			$Parameters .= " AND M.YearBuilt = '". $POST['YearBuilt'] ."'";

		# Tax
		# -----------------------------------------------------------------------------
		if ($POST['TaxMin']!='')
			$Parameters .= " AND M.Tax >= ". $POST['TaxMin'];

		if ($POST['TaxMax']!='')
		{
			$Parameters .= " AND M.Tax <= ". $POST['TaxMax'];
		}

		# Photos only
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['photos_only'] == '1')
			$Parameters	 .=	" AND TotalPhotos > 0 AND pic_download_flag = 'Y'";

        # Short Sale By SaleType
        #-----------------------------------------------------------------------------------------------------------------
        if($POST['Saletype_Short_Sale'] != '')
        {
            $Parameters .= " AND FIND_IN_SET('".$POST['Saletype_Short_Sale']."', SaleType)";
            //$Parameters .= " AND SaleType = '".$POST['Saletype_Short_Sale']."'";
        }
        # Bank Owned By SaleType
        #-----------------------------------------------------------------------------------------------------------------
        if($POST['Saletype_Bank_Owned'] != '')
        {
            $Parameters .= " AND FIND_IN_SET('".$POST['Saletype_Bank_Owned']."', SaleType)";
            //$Parameters .= " AND SaleType = '".$POST['Saletype_Bank_Owned']."'";
        }
         # In Foreclosures By SaleType
        #-----------------------------------------------------------------------------------------------------------------
        if($POST['Saletype_In_Foreclosures'] != '')
        {
            $POST['Saletype_In_Foreclosures'] = explode(',' , $POST['Saletype_In_Foreclosures']);
            if(count($POST['Saletype_In_Foreclosures']) > 0)
			{
				$temp = '';

                foreach($POST['Saletype_In_Foreclosures'] as $Key=>$val)
                    $temp[] = " FIND_IN_SET('".$val."',SaleType) ";

                $temp_q = implode(' OR ',$temp);
                $Parameters .=  " AND (".$temp_q.")";
			}

        }
		# New Property After given Date
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['NewPropertyAfterDate'] != '')
		{

			$Parameters	 .=	" AND  UNIX_TIMESTAMP(LastUpdateDate) > UNIX_TIMESTAMP('". $POST['NewPropertyAfterDate']. "')";
		}

		# New Property within day
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['NewPropertyWithinDay'] != '')
		{
			$Parameters	 .=	" AND DATEDIFF(CURDATE(), Begin_Date) <= '". intval($POST['NewPropertyWithinDay']). "'";
		}

		# Property To Be Expire
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['ExpireDay'] != '')
		{
			$Parameters	 .=	" AND DATEDIFF(End_Date, CURDATE()) <= '". intval($POST['ExpireDay']). "'";
		}

        # School
		#-----------------------------------------------------------------------------------------------------------------
		if(is_array($POST['school_name']))
        {
            $temp = '';
            foreach($POST['school_name'] AS $key => $val)
            {
                $temp[] = " (Elementary_School LIKE '%". $val. "%' OR High_School LIKE '%". $val. "%' OR Middle_School LIKE '%". $val. "%') ";
            }
            $temp_q = implode(' OR ',$temp);
            $Parameters .=  " AND (".$temp_q.")";
        }
        elseif ($POST['school_name']!='')
			$Parameters	 .=	" AND (Elementary_School LIKE '%". $POST['school_name']. "%' OR High_School LIKE '%". $POST['school_name']. "%' OR Middle_School LIKE '%". $POST['school_name']. "%') ";

		# Elemantary School
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['Elementary_School']))
		{
			$POST['Elementary_School'] = array_filter($POST['Elementary_School']);

			if(count($POST['Elementary_School']) > 0)
			{
				$condition 	 = implode("' OR Elementary_School = '", $POST['Elementary_School']);

				$Parameters	 .=	" AND ( Elementary_School = '". $condition. "' ) ";
			}
		}
		elseif ($POST['Elementary_School']!='')
			$Parameters .= " AND Elementary_School = '". $POST['Elementary_School']."'";

		// Middle School
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['Middle_School']))
		{
			$POST['Middle_School'] = array_filter($POST['Middle_School']);

			if(count($POST['Middle_School']) > 0)
			{
				$condition 	 = implode("' OR Middle_School = '", $POST['Middle_School']);

				$Parameters	 .=	" AND ( Middle_School = '". $condition. "' ) ";
			}
		}
		elseif ($POST['Middle_School']!='')
			$Parameters .= " AND M.Middle_School = '". $POST['Middle_School']."'";

		// High School
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['High_School']))
		{
			$POST['High_School'] = array_filter($POST['High_School']);

			if(count($POST['High_School']) > 0)
			{
				$condition 	 = implode("' OR High_School = '", $POST['High_School']);

				$Parameters	 .=	" AND ( High_School = '". $condition. "' ) ";
			}
		}
		elseif ($POST['High_School']!='')
			$Parameters .= " AND M.High_School = '". $POST['High_School']."'";

		// School District
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['School_District']))
		{
			$POST['School_District'] = array_filter($POST['School_District']);

			if(count($POST['School_District']) > 0)
			{
				$condition 	 = implode("' OR School_District = '", $POST['School_District']);

				$Parameters	 .=	" AND ( School_District = '". $condition. "' ) ";
			}
		}
		elseif ($POST['School_District']!='')
		{
			$str = str_replace(",", "','", $POST['School_District']);

			$Parameters .= " AND M.School_District IN ('". $str."')";
		}

		// Garage featrues
		if (is_array($POST['GarageFeatures']))
		{
			$POST['GarageFeatures'] = array_filter($POST['GarageFeatures']);

			if(count($POST['GarageFeatures']) > 0)
			{
				$condition 	 = implode("' OR GarageFeatures = '", $POST['GarageFeatures']);

				$Parameters	 .=	" AND ( GarageFeatures = '". $condition. "' ) ";
			}
		}

		// Lot Dimention
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['LotDimensions']!='')
			$Parameters .= " AND LotDimensions LIKE '%". $POST['LotDimensions']."%'";

		// Lake Shore
		#-----------------------------------------------------------------------------------------------------------------
		if ($POST['LakeShore']!='')
			$Parameters .= " AND LakeShore LIKE '%". $POST['LakeShore']."%'";

		// Lot Description
		#-----------------------------------------------------------------------------------------------------------------
		if (is_array($POST['LotDescription']))
		{
			$POST['LotDescription'] = array_filter($POST['LotDescription']);

			if(count($POST['LotDescription']) > 0)
			{
				$condition 	 = implode("' OR LotDescription = '", $POST['LotDescription']);

				$Parameters	 .=	" AND ( LotDescription = '". $condition. "' ) ";
			}
		}
		elseif ($POST['LotDescription']!='')
			$Parameters .= " AND LotDescription LIKE '%". $POST['LotDescription']."%'";

		# Office ID
		if ($POST['OfficeID']!='')
		{
			$POST['OfficeID'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['OfficeID'])));
			$Parameters .= " AND (M.OfficeID IN('". $POST['OfficeID']."') OR M.CoOfficeID IN('". $POST['OfficeID']."'))";
		}
		# Agent ID
        if(is_array($POST['Agent_ID']) && count($POST['Agent_ID']) > 0)
        {
            $Agent_Id_List = implode(",",$POST['Agent_ID']);
            $POST['Agent_ID'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $Agent_Id_List)));
			$Parameters .= " AND M.Agent_ID IN('". $POST['Agent_ID']."')";
        }
		elseif ($POST['Agent_ID']!='')
		{
			$POST['Agent_ID'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['Agent_ID'])));
			$Parameters .= " AND M.Agent_ID IN('". $POST['Agent_ID']."')";
		}
		# Agent Listings
		if($POST['AgentListing'])
		{
			$Parameters .= " AND (M.OfficeID IN('". $config['agent_office_code']."') OR M.CoOfficeID IN('". $config['agent_office_code']."'))";
		}

		# Agent Name
		if ($POST['AgentName']!='')
		{
			$Parameters .= " AND (AG.Agent_FName LIKE '%". $POST['AgentName']."%' OR AG.Agent_LName LIKE '%". $POST['AgentName']."%'".
							" AG2.Agent_FName LIKE '%". $POST['AgentName']."%' OR AG2.Agent_LName LIKE '%". $POST['AgentName']."%')";
		}

		# Open House
		if ($POST['OpenHouse'])
		{
			//$Parameters .=" AND (SELECT COUNT(OH.MLS_NUM) FROM ".$this->Data['MLS_Open_House_Table']." AS OH WHERE OH.MLS_NUM = M.MLS_NUM AND OH_Begins >= CURDATE() LIMIT 1) > 0";
			$Parameters .=" AND Is_OpenHouse = 'Y'";
			if(!defined("IN_ADMIN"))
				$Parameters .= " AND M.OfficeID NOT IN('".str_replace(',',"','",$config['exclude_openhouse_by_officeId'])."')";
		}

		# Book Section
		if (is_array($POST['BookSection']))
		{
			$POST['BookSection'] = array_filter($POST['BookSection']);

			if(count($POST['BookSection']) > 0)
			{
				$condition 	 = implode("','", $POST['BookSection']);

				$Parameters	 .=	" AND BookSection IN ('". $condition. "')";
			}
		}
		elseif ($POST['BookSection'] != '')
		{
			$Parameters	 .=	" AND BookSection = '". $POST['BookSection']. "'";
		}

		# Find Radious
		if (($POST['Latitude']!='') && ($POST['Longitude']!=''))
			$Parameters .= " AND ( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['Latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['Latitude']." / 57.2958 ) * COS( ".$POST['Longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) < ".($POST['Miles'] ? $POST['Miles'] : "5");

        # GeoCoded Properties only ?
        if(isset($POST['Is_GeoCoded']))
        {
            $Parameters .= " AND (A.Latitude != '' AND A.Longitude != '' AND A.Latitude != 0 AND A.Longitude != 0)";
        }

		# New Construction
		if($POST['IsNew'])
		{
			$Parameters	 .=	" AND (YearBuilt > 0 AND (date_format( curdate( ) , '%Y' ) - YearBuilt) <= 2)";
		}

		# Short Sale
		if($POST['ShortSale'])
		{
			$Parameters	 .=	" AND Description LIKE '%short sale%'";
		}

		# Owner
		if($POST['Owner'])
		{
			$Parameters	 .=	" AND Owner LIKE '%".$POST['Owner']."%'";
		}

		# Quick Search Type Received ?
		if($POST['searchType'])
		{
			switch($POST['searchType'])
			{
				# New Property within day
				case "new-property":
						$Parameters	 .=	" AND DATEDIFF(CURDATE(), ListingDate) <= 7";
						break;

				# New Construction
				case "new-constructed-property":
						$Parameters	 .=	" AND (YearBuilt > 0 AND (date_format( curdate( ) , '%Y' ) - YearBuilt) <= 2)";
						break;

				# Open House
				case "open-houses":
						//$Parameters .=" AND (SELECT COUNT(OH.MLS_NUM) FROM ".$this->Data['MLS_Open_House_Table']." AS OH WHERE OH.MLS_NUM = M.MLS_NUM AND OH_Begins >= CURDATE() LIMIT 1) > 0";
						//$Parameters .=" AND OH_DATE >= CURDATE()";
						$Parameters .=" AND Is_OpenHouse = 'Y'";
						if(!defined("IN_ADMIN"))
							$Parameters .= " AND M.OfficeID NOT IN('".str_replace(',',"','",$config['exclude_openhouse_by_officeId'])."')";
						break;

				case "price-reduced-property":
						//$Parameters .= " AND lplog_mls_num != '' AND lplog_price_diff < 0";
						$Parameters .= " AND Price_Diff < 0";
						break;

				case "price-increased-property":
						//$Parameters .= " AND lplog_mls_num != '' AND lplog_price_diff > 0";
						$Parameters .= " AND Price_Diff > 0";
						break;

				/*# Lender Owned
				case "lender-owned":
						$Parameters	 .=	" AND OccupantName = 'Lender Owned'";
						break;

				# Pending Property
				case "pending-property":
						$Parameters	 .=	" AND ListingStatus = 'Pending'";
						break;
						*/

				# Short sale
				case "short-sale-property":
						$Parameters	 .=	" AND Description LIKE '%short sale%'";
						break;
			}
		}

        # Basement
		#---------------------------------------------------------------------------------------------------------
		if (is_array($POST['Basement']))
		{
			$POST['Basement'] = array_filter($POST['Basement']);

			if(count($POST['Basement']) > 0)
			{
				$condition 	 = implode("' OR AI.Basement = '", $POST['Basement']);

				$Parameters	 .=	" AND ( AI.Basement = '". $condition. "' ) ";
			}
		}
		elseif ($POST['Basement']!='')
			$Parameters .= " AND AI.Basement = '". $POST['Basement']."'";


		# View
		/*if(is_array($POST['View']))
		{
			$condition = implode("', View) OR FIND_IN_SET('", $POST['View']);
			$Parameters .= " AND (FIND_IN_SET('".$condition."', View))";
		}*/
		if(isset($POST['view']) && $POST['view'] != 'Any')
		{
            if($POST['view'] == 'Yes' || $POST['view'] == 'yes')
                $Parameters .= " AND ViewYN = '1'";
            elseif($POST['view'] == 'No' || $POST['view'] == 'no')
                $Parameters .= " AND ViewYN = '0'";
		}
		# WaterFront desc ?
		if(is_array($POST['WaterfrontDesc']))
		{
			$condition = implode("', WaterfrontDesc) OR FIND_IN_SET('", $POST['WaterfrontDesc']);
			$Parameters .= " AND (FIND_IN_SET('".$condition."', WaterfrontDesc))";
		}
		elseif(isset($POST['WaterfrontDesc']) && $POST['WaterfrontDesc'] != '')
		{
			$Parameters .= " AND WaterfrontDesc = '". $POST['WaterfrontDesc']. "'";
		}

		# Short Sale
		if($POST['Is_ShortSale'])
		{
			$Parameters	 .=	" AND Is_ShortSale = '".$POST['Is_ShortSale']."'";
		}
		# Days On Market
        # ---------------------------------------------------------------------------------
        if(isset($POST['dom']) && ($POST['dom'] != '' && $POST['dom'] != 'Any'))
        {
            if(strpos($POST['dom'],'-') == true)
                //$Parameters .= " AND (DATEDIFF(CURRENT_DATE(), ListingDate)) <= SUBSTRING_INDEX('".$POST['dom']."','-','1')";
	            $Parameters .= " AND AI.DOM <= SUBSTRING_INDEX('".$POST['dom']."','-','1')";
            elseif(strpos($POST['dom'],'+') == true)
                $Parameters .= " AND AI.DOM >= SUBSTRING_INDEX('".$POST['dom']."','+','1')";
            else
               $Parameters .= " AND Ai.DOM <= '1'";
		}
        # REO
		if($POST['Is_REO'])
		{
			$Parameters	 .=	" AND Is_REO = '".$POST['Is_REO']."'";
		}

		# Price Reduce
		if($POST['Is_PriceReduce'])
		{
			$Parameters .= " AND Price_Diff < 0";
		}

		# Pool ?
		if(isset($POST['pool']) && ($POST['pool'] != '' && $POST['pool']!= 'Any'))
		{
            if($POST['pool'] == 'Yes' || $POST['pool'] == 'yes')
                $Parameters .= " AND Is_Pool = '1'";
            elseif($POST['pool'] == 'No' || $POST['pool'] == 'no')
                $Parameters .= " AND Is_Pool = '0'";
			//$Parameters .= " AND Is_Pool = '".$POST['Is_Pool']."'";
		}
		# Pets ?
		if($POST['PetsAllowed'])
		{
			$Parameters .= " AND PetsAllowed = 'Yes'";
		}
        /*if (is_array($POST['mapBoundary']))
		{
			$south 	= str_replace(',', '.', $POST['mapBoundary'][0]);
			$west 	= str_replace(',', '.', $POST['mapBoundary'][1]);
			$north 	= str_replace(',', '.', $POST['mapBoundary'][2]);
			$east 	= str_replace(',', '.', $POST['mapBoundary'][3]);

			if($west > $east)
				$Parameters .= " AND ((Latitude BETWEEN $south AND $north) AND ((Longitude BETWEEN -180 AND $east) OR (Longitude BETWEEN $west AND 180)))";
			else
				$Parameters .= " AND ((Latitude BETWEEN $south AND $north) AND (Longitude BETWEEN $west AND $east))";
		}*/
        if(isset($POST['mapBoundary']) && !empty($POST['mapBoundary']))
        {
            if(!is_array($POST['mapBoundary']))
            {
                $POST['mapBoundary'] = explode(',', $POST['mapBoundary']);
            }
            $south 	= str_replace(',', '.', $POST['mapBoundary'][0]);
			$west 	= str_replace(',', '.', $POST['mapBoundary'][1]);
			$north 	= str_replace(',', '.', $POST['mapBoundary'][2]);
			$east 	= str_replace(',', '.', $POST['mapBoundary'][3]);

			if($west > $east)
				$Parameters .= " AND ((Latitude BETWEEN $south AND $north) AND ((Longitude BETWEEN -180 AND $east) OR (Longitude BETWEEN $west AND 180)))";
			else
				$Parameters .= " AND ((Latitude BETWEEN $south AND $north) AND (Longitude BETWEEN $west AND $east))";
        }
        //echo"<pre>";print_r($POST);die;
        /*if($POST['mapPolygon'] && $POST['isPolygonSearch'] == 1)
        {
            $poly = trim($POST['mapPolygon'], ",");
            $point = explode(',',$poly);
            array_push($point,$point[0]);
            $Polygon = implode(",", $point);

            $Parameters .= " AND st_contains(GeomFromText('POLYGON((".$Polygon."))'), point(Latitude, Longitude))";
        }*/
        if(isset($POST['mapPolygon']) && !empty($POST['mapPolygon'])/* && $POST['isPolygonSearch'] == 1*/)
        {
/*            $poly = trim($POST['mapPolygon'], "~");
            $point = explode('~',$poly);
            array_push($point,$point[0]);
            $Polygon = implode(",", $point);

            $Parameters .= " AND st_contains(GeomFromText('POLYGON((".$Polygon."))'), point(Latitude, Longitude))";*/

	        if(strpos($POST['mapPolygon'],'~') !==  false)
	        {
		        $POST['mapPolygon'] = 'POLYGON (('.str_replace('~',',',$POST['poly']).'))';
	        }
	        $Parameters .= " AND (st_contains(GeomFromText('" . $POST['mapPolygon'] . "'), point(Longitude,Latitude)))";

	        //Utility::pre($Parameters);
        }
        //MBRContains
		# Find listing in give polygon
        if($POST['area_geo_points_xy'] != '')
        {
            //select * from listing_address where MBRContains('34.249691000000000 -118.553223000000000', CONCAT('Point(`Latitude`,' ',`Longitude`)'))
            $sql = "SELECT * from listing_address where MBRContains('".$POST['area_geo_points_xy']."','Point(Latitude,Longitude)')";
            //$sql = "SELECT MBRContains(GeomFromText('Polygon(".$POST['area_geo_points_xy']."')),GeomFromText('Point(SELECT CONCAT(`Latitude`,',',`Longitude`) FROM listing_address))";

        }
        /*if($POST['mapCircle'] && $POST['isCircleSearch'] == 1)
        {
            $circle_param = explode(',',$POST['mapCircle']);

            $radius = $circle_param['0'];
            $cenLat = $circle_param['1'];
            $cenLng = $circle_param['2'];

            $Parameters .= " AND SQRT(POW(".$cenLat." - Latitude , 2) + POW(".$cenLng." - Longitude, 2)) * 100 < (".$radius."/1000)";

        }*/
        if(isset($POST['mapCircle']) && !empty($POST['mapCircle'])/* && $POST['isCircleSearch'] == 1*/)
        {
            $circle_param = explode('~',$POST['mapCircle']);

            $radius = $circle_param['0'];
            $cenLat = $circle_param['1'];
            $cenLng = $circle_param['2'];

            $Parameters .= " AND SQRT(POW(".$cenLat." - Latitude , 2) + POW(".$cenLng." - Longitude, 2)) * 100 < (".$radius."/1000)";

        }
        if(isset($POST['Is_Upcoming_OpenHouse']) && $POST['Is_Upcoming_OpenHouse'] == 'Yes')
        {
            $Parameters .= " AND (SELECT COUNT(*) AS open_house_cnt FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1)";
        }
        if(isset($POST['with_Unit2']) && $POST['with_Unit2'] == true)
        {
            $Parameters .= " AND UnitNo_2 > 0 ";
        }
        if(is_array($POST['ListingStatus']))
        {
            $Parameters .= " AND ListingStatus IN ('". implode("','",$POST['ListingStatus'])."')  ";
        }
        else
        {
            if($POST['ListingStatus'] != '' )
            {
                $POST['ListingStatus'] = str_replace(",", "','",$POST['ListingStatus']);
                $Parameters .= " AND ListingStatus IN ('".$POST['ListingStatus']."')";
            }
            else
            {
                //$Parameters .= " AND ListingStatus IN ('Active') ";
	            $Parameters .= " AND ListingStatus NOT IN ('Closed') ";
            }
        }

		# Is Mark for deletion
		$Parameters .= " AND M.is_mark_for_deletion = 'N' AND M.ListPrice > 0 ";

		//echo $Parameters;die;

		return $Parameters;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingByParam($POST)
    {
        global $db, $virtual_path, $config, $asset;
        //Utility::pre($POST);
	    //file_put_contents('post.txt',print_r($POST,true));
        $addParameters = $this->getQueryParameters($POST);
//        file_put_contents('data.txt', print_r($addParameters,true));
        //Utility::pre($addParameters);

        $POST['page_size'] = 300;//$POST['page_size'] ? $POST['page_size'] : RESULT_PAGESIZE;

        $sql =	" SELECT count(*) as cnt ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;
        //echo $sql; die;
	    //file_put_contents('data.txt',print_r($sql,true));
		//$rs = $db->query($sql, true);
		$rs = $db->query($sql);
		$rs->next_record();

        $this->total_record = $rs->f("cnt") ;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST['start_record'] >= $this->total_record || $POST['page_size'] >= $this->total_record || !isset($POST['start_record']))
				$POST['start_record'] = 0;
		}

		//echo"<pre>";print_r($POST);die;

		if ($POST['viewType']==VT_LIST)
		{
			# DOM use Listing_Created_Date field instead of ListingDate
			$sql =  " SELECT M.MLS_NUM, ListingKey,M.Agent_ID, mls_is_pic_url_supported, M.ListPrice, M.PropertyType, M.SubType, M.Beds,M.Baths,M.Main_Photo, ".
					" M.BathsFull, M.BathsHalf, M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.Tax,".
					" M.YearBuilt, Subdivision, M.Description, TotalPhotos, Parking,M.Is_OpenHouse,M.Is_ShortSale,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
					" A.StreetNumber, M.ListingStatus, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix,A.Address, A.CityName, A.State, ZipCode, DisplayAddress,".
					" O.Office_Name,M.TotalAcreage, ".
					" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, ".
                    "(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date ";
                    /*"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";*/
               /*if($POST['ShowMiles'] && $POST['Latitude'])
				$sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['Latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['Latitude']." / 57.2958 ) * COS( ".$POST['Longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";
		      */
        }
		elseif ($POST['viewType']==VT_MAP)
		{
			# DOM use Listing_Created_Date field instead of ListingDate
			$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.PropertyType, M.SubType, M.Beds,M.Baths,M.Main_Photo, ".
					" M.BathsFull, M.BathsHalf, M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.Tax,".
					" M.YearBuilt,M.ListingStatus ,Subdivision, M.Description, TotalPhotos, Parking,M.Is_OpenHouse,M.Is_ShortSale,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, ".
					" A.StreetNumber, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix,A.Address, A.CityName, A.State, ZipCode, DisplayAddress,".
					" O.Office_Name, M.TotalAcreage, ".
					" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, ".
                    "(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date ";
                    /*"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";*/
		}
		elseif ($POST['viewType']==VT_SITE_MAP)
		{
			$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.PropertyType, LastUpdateDate, Category,".
					" A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.State, A.County, ZipCode";
		}
		else
		{
			# DOM use Listing_Created_Date field instead of ListingDate
		  	$sql =  " SELECT M.*, mls_is_pic_url_supported, M.PropertyType, M.SubType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, (DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM, M.Tax,".
					" Parking, Garage, A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, ".
					" A.StreetDirection, StreetSuffix, UnitNo, A.Latitude, A.Longitude, Main_Photo, Category, IF(M.Agent_ID = '".$config['agent_code']."', 0, 1) AS agent_listing, O.Office_Name, ".
                    "(SELECT CONCAT(OH_Date,',', OH_Begins,',', OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date ";
                    /*"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";*/
		}

		//if(!defined("IN_ADMIN"))
			//$sql .= ", IF(FIND_IN_SET(M.OfficeID,'".$config['exclude_openhouse_by_officeId']."'), 'N', Is_OpenHouse) AS Is_OpenHouse ";

		$sql .= //", CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";
				//" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

        /*if($POST['GarageFeatures'] || $POST['Is_Pool'] || $POST['PetsAllowed'] || $POST['View'] || $POST['WaterfrontDesc'])
		{*/
		  $sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";
        /*}*/
        $sql .= " WHERE 1 ".$addParameters . ' AND ListingDate > 0' ;
        //$sql .= " AND Is_OpenHouse='Y' ";
        //Utility::pre($POST);
				//" WHERE M.MLS_NUM IN ('F1725953', 'F1860700', '07224925', '21436355')".

        if (is_array($POST['sort_order_list']) && count($POST['sort_order_list']) > 0)
        {
            $field_order='';
            foreach ($POST['sort_order_list'] as $field => $order)
            {
                $field_order .= $field." ".$order.",";
            }

            $field_order = rtrim($field_order,",");

            $sql .= " ORDER BY ".$field_order;
        }
        else
        {

            if(defined("IN_ADMIN"))
            {
                $sql .=	" ORDER BY ". ($POST['sort_order'] != ''? $POST['sort_order'] :'Subdivision').' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :'DESC');
            }
            else
            {
                $sql .=	" ORDER BY ". ($POST['sort_order'] != ''? ($POST['sort_order'] == 'location' ? 'Subdivision' :isset($asset['OL_SORTBY_LOOKUP_ARRAY'][$POST['sort_order']])?$asset['OL_SORTBY_LOOKUP_ARRAY'][$POST['sort_order']]: $POST['sort_order']) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :DEFAULT_SD);
                //$sql .=	" ORDER BY Baths DESC";
            }
        }

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST['start_record']. ", ". $POST['page_size'];

        if(isset($_GET['print']) && $_GET['print'] == true)
        {
            echo $sql; die;
        }

         //echo $sql;die;
//	    file_put_contents('post.txt',print_r($sql,true));
        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

        $arr = array();
		$arr['rs'] = array();
		$arr['map-data'] = array();

        while($rs->next_record())
		{
			$row = $rs->Record;

			if($POST['viewType'] != VT_SITE_MAP)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
				    //$row['MainPicture'] = $this->getPicArray2($row['ListingID_MLS'], $getMainPic=true);
					$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
                }
				else
				{
					$pic_no = $row['Main_Photo']-1;
					$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
				}
			}

			if($POST['getAllPhoto'])
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=false);

					$row['PhotoAll'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

					$row['PhotoAll'] = $PicArr;
				}
			}
            if(isset($row['open_house_date']) && !empty($row['open_house_date']))
            {
                $arr_open = explode(',', $row['open_house_date']);
                $row['OpenHouse_Date'] = $arr_open[0];
                $row['OpenHouse_Begin'] = (strlen($arr_open[1]) == '1') ? substr_replace('0'.$arr_open[1].'00',':',-2,0):substr_replace($arr_open[1],':',-2,0);
                $row['OpenHouse_Close'] = (strlen($arr_open[2]) == '1') ? substr_replace('0'.$arr_open[2].'00',':',-2,0):substr_replace($arr_open[2],':',-2,0);
            }

			/*if($row['Is_OpenHouse'] == 'Y')
			{
				// Get Open House Detail
				$arrOpenHouse = $this->getOpenHouseData($row['ListingID_MLS']);

				if(is_array($arrOpenHouse))
				{
					$row['arrOpenHouse'] = $arrOpenHouse;
				}
			}*/

			array_push($arr['rs'], $row);
			if($POST['getMapData']/* && $row['Latitude'] > 0*/)
			{
				$rsAttributes = Utility::generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
                $arrTemp['CityName'] 	= $row['CityName'];
                $arrTemp['State'] 		= $row['State'];
                $arrTemp['ZipCode'] 	= $row['ZipCode'];
				$arrTemp['Price'] 		= $row['ListPrice'];
                $arrTemp['Type']        = $row['PropertyType'];
                $arrTemp['SubType']     = $row['SubType'];
				$arrTemp['Bed'] 		= $row['Beds'];
				$arrTemp['Bath'] 		= rtrim(rtrim($row['Baths'],'0'),'.');
				$arrTemp['Sqft'] 		= $row['SQFT'];
                $arrTemp['Year']        = $row['YearBuilt'];
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Pic_Path'] 	= $row['Pic_Path'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];
				$arrTemp['OfficeName']	= $row['Office_Name'];
                $arrTemp['PhotoBaseUrl']= $this->Pic_Path;
                $arrTemp['TotalPhotos']	= $row['TotalPhotos'];
                $arrTemp['Photos'] 		= $row['PhotoAll'];
                $arrTemp['PictureArr']  = $row['PhotoAll']['thumb'];
                $arrTemp['sub']         = $row['Subdivision'];
                $arrTemp['HOA']         = $row['HOA_Fee'];
                $arrTemp['status']      = $row['ListingStatus'];
                $arrTemp['LDate']      = $row['Listing_Created_Date'];
                $arrTemp['DOM']         = $row['DOM'];
                $arrTemp['lotSize']     = $row['LotSize'];
                $arrTemp['Is_OpenHouse']        = $row['Is_OpenHouse'];
                $arrTemp['OpenHouse_Date']      = isset($row['OpenHouse_Date']) ? date_format(date_create($row['OpenHouse_Date']),"D M j") : '';
                $arrTemp['OpenHouse_Begin']     = isset($row['OpenHouse_Begin']) ? date_format(date_create($row['OpenHouse_Begin']), "g:ia") : '';
                $arrTemp['OpenHouse_Close']     = isset($row['OpenHouse_Close']) ? date_format(date_create($row['OpenHouse_Close']), "g:ia") : '';

                array_push($arr['map-data'], $arrTemp);
			}
		}

		if(count($arr['map-data']) > 0)
		{
			$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
		}
        else
        {
            $arr['map-data'] = '';
        }

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

//echo "<pre>";
//print_r($arr);
//echo "</pre>";
//	    file_put_contents('sql3.txt',print_r($arr,true));
        //Utility::pre($arr);
        return $arr;
	}
    #=========================================================================================================================
	#	Function Name	:   getListingByParamforSaveSearch
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingByParamforSaveSearch($POST)
    {

	 //  echo "<pre>";print_r($POST);die;
        global $db, $virtual_path, $config, $asset;
        //Utility::pre($POST);
		$addParameters = $this->getQueryParameters($POST);

        if(isset($POST['short_code']) && $POST['short_code'] != '')
        {
            $POST['short_code'] = str_replace(" ", "', '", preg_replace("/ +/", " ", str_replace(",", " ", $POST['short_code'])));
			$addParameters .= " OR ( ( M.Agent_ShortID IN ('". $POST['short_code']."')  OR M.CoAgent_ShortID IN ('". $POST['short_code']."' ) OR M.SellAgent_ShortID IN ('". $POST['short_code']."') )";
        }
        /*if(isset($POST['IsnewOrPriceChange']) && $POST['IsnewOrPriceChange'] == true)
        {
            $addParameters .= " AND ( M.ListingDate = CURRENT_DATE() OR ( ( M.Price_Diff != '' OR M.Price_Diff != 0) AND M.ListPrice != M.Old_Price) )";
        }*/
        //Utility::pre($addParameters);
        $POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : RESULT_PAGESIZE;

        $sql =	" SELECT count(*) as cnt ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

		$sql .= " WHERE ( 1 ".$addParameters.")";
        //echo $sql; die;
		//$rs = $db->query($sql, true);

		$rs = $db->query($sql);
		$rs->next_record();

        $this->total_record = $rs->f("cnt") ;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST['start_record'] >= $this->total_record || $POST['page_size'] >= $this->total_record || !isset($POST['start_record']))
				$POST['start_record'] = 0;
		}

		$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.PropertyType, M.SubType, M.Beds,M.Baths,M.Main_Photo,M.Old_Price,M.Price_Diff,  ".
				" M.BathsFull, M.BathsHalf, M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,M.ListingDate, ".
				" M.YearBuilt, Subdivision, M.Description, TotalPhotos, Parking,M.Is_OpenHouse,M.Is_ShortSale,AI.DOM, ".
				" A.StreetNumber, M.ListingStatus, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress,".
				" O.Office_Name,M.TotalAcreage, ".
				"(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
				" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName, CONCAT(AG2.Agent_FName, ' ', AG2.Agent_LName) AS CoAgent_FullName, MM.mls_disclaimer_big";
        if($POST['ShowMiles'] && $POST['Latitude'])
            $sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['Latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['Latitude']." / 57.2958 ) * COS( ".$POST['Longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";

		$sql .= //", CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";
		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ".
                " LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ".
				" LEFT JOIN ". $this->Data['Agent_Table']." AS AG2 ON M.CoAgent_ID  = AG2.Agent_ID  AND M.MLSP_ID = AG2.Agent_MLSP_ID ";

		$sql .= " WHERE  1 ".$addParameters." ";

        if (count($POST['sort_order_list']) > 0)
        {
            $field_order='';
            foreach ($POST['sort_order_list'] as $field => $order)
            {
                $field_order .= $field." ".$order.",";
            }

            $field_order = rtrim($field_order,",");

            $sql .= " ORDER BY ".$field_order;
        }
        else
        {
            if(defined("IN_ADMIN"))
            {
                $sql .=	" ORDER BY ". ($POST['sort_order'] != ''? $POST['sort_order'] :'Subdivision').' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :'DESC');
            }
            else
            {
                $sql .=	" ORDER BY ".($POST['sort_order'] != ''? ($POST['sort_order'] == 'location' ? 'Subdivision' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST['sort_order']]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :DEFAULT_SD);
            }
        }

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST['start_record']. ", ". $POST['page_size'];
		//file_put_contents('sql_search.txt',print_r($sql,true));
        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
        $arr = array();
		$arr['rs'] = array();
		//$arr['map-data'] = array();
        /*$asset['mlsPhotoType'] = array();
		$asset['mlsPhotoType']		= 	array	( 'thumb'		=>	'Thumbnail Size Photo',
										);*/
		while($rs->next_record())
		{
			$row = $rs->Record;
			//file_put_contents('pic.txt',print_r($POST,true));
			//file_put_contents('pic_row.txt',print_r($row,true));
			if($POST['viewType'] != VT_SITE_MAP)
			{
				//file_put_contents('pic_row1.txt',print_r($row,true));
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
				    //$row['MainPicture'] = $this->getPicArray2($row['ListingID_MLS'], $getMainPic=true);
					$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
					//file_put_contents('pic_row2.txt',print_r($row,true));
                }
				else
				{
					$pic_no = $row['Main_Photo']-1;
					$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
				}
			}
			if(isset($row['open_house_date']) && !empty($row['open_house_date']))
			{
				$arr_open = explode(',', $row['open_house_date']);
				$row['OpenHouse_Date'] = $arr_open[0];
				$row['OpenHouse_Begin'] = $arr_open[1];
				$row['OpenHouse_Close'] = $arr_open[2];
			}

			/*if($POST['getAllPhoto'])
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=false);

					$row['PhotoAll'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

					$row['PhotoAll'] = $PicArr;
				}
			}*/
            array_push($arr['rs'], $row);
		}

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

//echo "<pre>";
//print_r($arr);
//echo "</pre>";
        //Utility::pre($arr);
		return $arr;
	}

	#=========================================================================================================================
	#	Function Name	:   getListingForReport
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingForReport($POST)
    {
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =	" SELECT count(DISTINCT M.MLS_NUM) as cnt ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		$rs = $db->query($sql);

		$rs->next_record();

		$this->total_record = $rs->f("cnt") ;

		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST['start_record'] >= $this->total_record || $POST['page_size'] >= $this->total_record || !isset($POST['start_record']))
				$POST['start_record'] = 0;
		}

		$sql = " SELECT M.*, PropertyType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Category,"
			 . " Parking, Garage, A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, ZipCode, A.CityName, A.County, A.State,"
			 . " A.Latitude, A.Longitude, O.Office_Name, AG.Agent_FName, AG.Agent_LName";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID ".
				" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Order By
		$sql .= " ORDER BY ". ($POST['sort_order'] != ''? $POST['sort_order'] :DEFAULT_SO).' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :DEFAULT_SD);
        //$sql .= " ORDER BY ". ($POST['sort_order'] != ''? $POST['sort_order'] :'ListPrice').' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :'DESC');

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST['start_record']. ", ". $POST['page_size'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql, true);

		$arr = array();

		$arr['rs'] = $rs->fetch_array();

		foreach($arr['rs'] as $key => $row)
		{
			$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

			$arr['rs'][$key]['PictureArr'] 		= $PicArr;
			$arr['rs'][$key]['PrintPictureArr'] = $PicArr;

			# Set String in Proper Case
			if(isset($row['StreetName']) && $row['StreetName'] != '')
				$arr['rs'][$key]['StreetName'] = ucwords(strtolower($row['StreetName']));
		}

		$arr['total_record'] = $this->total_record;

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingByParam2($POST)
    {
		global $db, $virtual_path,$config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.MLS_NUM, mls_is_pic_url_supported, M.ListPrice, M.ListPrice, Subdivision,  M.PropertyType, M.PropertyStyle, M.Beds, M.BathsFull,".
				" M.BathsHalf, M.SQFT, M.TotalAcreage, Main_Photo, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Category, Parking, Garage,".
				" round(M.ListPrice*100/M.ListPrice) AS LP_Over_OP,".
				" round(M.ListPrice/M.SQFT) AS Price_Per_Sqft,".
				" A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, DisplayAddress,".
				" A.StreetDirection, StreetSuffix, UnitNo, M.YearBuilt, M.Description, DATEDIFF(CURDATE(), LastUpdateDate) AS DayOnMarket,".
				" Price_Diff, Is_OpenHouse,DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff".
//			 	" Description LIKE '%short sale%' AS Is_ShortSale ".
//				" , CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path";


		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Set Order
		if($POST['order_by'])
			$sql .= " ORDER BY ".$POST['order_by'];

		# Set Limit
		if($POST['limit'])
			$sql .= " LIMIT 0, ".$POST['limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		$arr['rs'] = array();

		while($rs->next_record())
		{
			$row = $rs->Record;

			if($row['mls_is_pic_url_supported'] == 'Yes')
			{
				$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=true);
			}
			else
			{
				$pic_no = $row['Main_Photo']-1;
				$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
			}

            if(isset($POST['Is_KeyValueArray']))
                $arr['rs'][$row['ListingID_MLS']] = $row;
            else
		      array_push($arr['rs'], $row);
		}

		$arr['PhotoBaseUrl'] = $this->Pic_Path;

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingForWatchAlert
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingForWatchAlert($POST)
    {
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.MLS_NUM, M.ListPrice, lpwatch_price, M.PropertyType, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,".
				" Subdivision, Main_Photo, Category, Parking, Garage,".
				" A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.County, A.State, ZipCode, DisplayAddress".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['PriceWatch_Table']." AS PW ON M.MLS_NUM = PW.lpwatch_mls_num AND M.MLSP_ID = PW.lpwatch_mlsp_id AND lpwatch_user_id = '".$POST['user_id']."'".
				" WHERE lpwatch_price != ListPrice ".$addParameters;

		# Order By
		$sql .= " ORDER BY ListPrice DESC";


		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql, true);

		$arr = array();

		$arr['rs'] = $rs->fetch_array();

		foreach($arr['rs'] as $key => $row)
		{
			$pic_no = $row['Main_Photo']-1;
			$arr['rs'][$key]['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;

			# Set String in Proper Case
			if(isset($row['StreetName']) && $row['StreetName'] != '')
				$arr['rs'][$key]['StreetName'] = ucwords(strtolower($row['StreetName']));
		}

		$arr['total_record'] = count($arr['rs']);

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingForWatchList
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingForWatchList($POST)
    {
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.*, lpwatch_price, lpwatch_date_time, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,".
				" Subdivision, A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.County, A.State, ZipCode,".
				" Price_Diff, Is_OpenHouse, DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['PriceWatch_Table']." AS PW ON M.MLS_NUM = PW.lpwatch_mls_num AND M.MLSP_ID = PW.lpwatch_mlsp_id AND lpwatch_user_id = '".$POST['user_id']."'".
				" WHERE 1".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql, true);

		$arr = array();

		$arr['rs'] = $rs->fetch_array();

		foreach($arr['rs'] as $key => $row)
		{
			$pic_no = $row['Main_Photo']-1;
			$arr['rs'][$key]['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;

			# Set String in Proper Case
			if(isset($row['StreetName']) && $row['StreetName'] != '')
				$arr['rs'][$key]['StreetName'] = ucwords(strtolower($row['StreetName']));
		}

		$arr['total_record'] = count($arr['rs']);

		return $arr;
	}
	#=========================================================================================================================
	#	Function Name	:   getMlsNoByParam
	#-------------------------------------------------------------------------------------------------------------------------
    function getMlsNoByParam($POST)
    {

		global $db;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, ListPrice";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getDistinctMarketIdByParam
	#-------------------------------------------------------------------------------------------------------------------------
    function getDistinctMarketIdByParam($POST)
    {
		global $db;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT DISTINCT(M.MLSP_ID)".
				" FROM ". $this->Data['TableName']." AS M ".
                " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrIds = array();

		while($rs->next_record())
		{
			array_push($arrIds, $rs->f('MLSP_ID'));
		}

		$strIds = implode(',', $arrIds);

		return $strIds;
	}
	#=========================================================================================================================
	#	Function Name	:   getListingStatisticByParam
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingStatisticByParam($POST)
    {
		global $db;

		$addParameters = $this->getQueryParameters($POST);

		$sql =  " SELECT MIN(M.Beds) As MinBeds, MAX(M.Beds) As MaxBeds, round(AVG(M.Beds)) As AvgBeds,".
				" MIN(M.BathsFull) As MinBathsFull, MAX(M.BathsFull) As MaxBathsFull, round(AVG(M.BathsFull)) As AvgBathsFull,".
				" MIN(M.BathsHalf) As MinBathsHalf, MAX(M.BathsHalf) As MaxBathsHalf, round(AVG(M.BathsHalf)) As AvgBathsHalf,".
				" MIN(M.Parking) As MinParking, MAX(M.Parking) As MaxParking, round(AVG(M.Parking)) As AvgParking,".
				" MIN(M.SQFT) As MinSQFT, MAX(M.SQFT) As MaxSQFT, round(AVG(M.SQFT)) As AvgSQFT,".
				" MIN(M.TotalAcreage) As MinTotalAcreage, MAX(M.TotalAcreage) As MaxTotalAcreage, round(AVG(M.TotalAcreage)) As AvgTotalAcreage,".
				" MIN(M.YearBuilt) As MinYearBuilt, MAX(M.YearBuilt) As MaxYearBuilt, round(AVG(M.YearBuilt)) As AvgYearBuilt,".
				" MIN(M.ListPrice) As MinListPrice, MAX(M.ListPrice) As MaxListPrice, round(AVG(M.ListPrice)) As AvgListPrice,".
				" MIN(round(M.ListPrice/M.SQFT)) As MinPrice_Per_Sqft, MAX(round(M.ListPrice/M.SQFT)) As MaxPrice_Per_Sqft, round(AVG(M.ListPrice/M.SQFT)) As AvgPrice_Per_Sqft,".
				" MIN(M.ListPrice) As MinListPrice, MAX(M.ListPrice) As MaxListPrice, round(AVG(M.ListPrice)) As AvgListPrice";
				//" MIN(round(M.ListPrice*100/M.ListPrice)) As MinLP_Over_OP, MAX(round(M.ListPrice*100/M.ListPrice)) As MaxLP_Over_OP, round(AVG(round(M.ListPrice*100/M.ListPrice))) As AvgLP_Over_OP";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}
	#=========================================================================================================================
	#	Function Name	:   getListingByID
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingByID($POST)
    {
        global $db, $virtual_path,$config;

		if ($POST['ListingID_MLS']=='')
			return true;

		$sql = " SELECT M.*, AI.*, M.MLS_NUM, M.MLSP_ID, mls_is_pic_url_supported, mls_disclaimer_big, M.PropertyType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,"
			 . " A.Area, A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, ZipCode, A.CityName, A.County, A.State, A.Subdivision, Description,"
			 . " A.Latitude, A.Longitude, O.Office_Name, O2.Office_Name AS CoOffice_Name, O.Office_Phone, O2.Office_Phone AS CoOffice_Phone, ListingStatus,"
			 . " CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName, CONCAT(AG2.Agent_FName, ' ', AG2.Agent_LName) AS CoAgent_FullName,AG.Agent_LicenseNumber, AG2.Agent_LicenseNumber AS CoAgent_LicenseNumber,AG2.Agent_Mobile,AG2.Agent_HomePhone,AG2.Agent_Email,"
			 . " Price_Diff, DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff,(DATEDIFF(CURRENT_DATE(), ListingDate)) AS DOM";
//			 . " CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path";

		if(!defined("IN_ADMIN"))
			$sql .= ", IF(FIND_IN_SET(M.OfficeID,'".$config['exclude_openhouse_by_officeId']."'), 'N', Is_OpenHouse) AS Is_OpenHouse ";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O2 ON M.CoOfficeID = O2.Office_ID AND M.MLSP_ID = O2.Office_MLSP_ID AND M.CoOfficeID != ''".
				" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ".
				" LEFT JOIN ". $this->Data['Agent_Table']." AS AG2 ON M.CoAgent_ID  = AG2.Agent_ID  AND M.MLSP_ID = AG2.Agent_MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Open_House_Table']." AS OP ON M.MLS_NUM  = OP.MLS_NUM  AND M.MLSP_ID = OP.MLSP_ID ";
                //" LEFT JOIN ". $this->Data['Listing_Unit_Info']." AS LUI ON M.MLS_NUM = LUI.MLS_NUM AND M.MLSP_ID = LUI.MLSP_ID ";;

		$sql .= " WHERE M.is_mark_for_deletion = 'N' AND UPPER(CONCAT(M.MLS_NUM,'-',M.MLSP_ID)) = '". strtoupper($POST['ListingID_MLS']). "' ";

		if($POST['ActiveListingFlag'])
		{
			if($this->picPath['InActive_MLSP_ID'] != '')
				$sql	 .=	" AND M.MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";
		}
        //echo $sql;die;
        $rec = $db->query($sql);

		$rs = $rec->fetch_array(MYSQLI_FETCH_SINGLE);
        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);



		if($POST['PicArr'] !== false)
		{
			if($rs['mls_is_pic_url_supported'] == 'Yes')
			{
                //$PicArr = $this->getPicArray2($rs['MLS_NUM'], $rs['MLSP_ID']);
                $PicArr = $this->getPicArray2($rs['ListingKey'], $rs['MLSP_ID']);

				$rs['PictureArr'] = $PicArr;
			}
			else
			{
				$PicArr = $this->getPicArray($rs['ListingID_MLS'], $rs['TotalPhotos']);

				$rs['PictureArr'] = $PicArr;
			}
		}
		else
		{

			if($rs['mls_is_pic_url_supported'] == 'Yes')
			{
				$rs['MainPicture'] = $this->getPicArray2($rs['ListingKey'], $rs['MLSP_ID'], $getMainPic=true);
			}
			else
				$rs['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$rs['ListingID_MLS']."/0";
		}

		$rs['PhotoBaseUrl'] = $this->Pic_Path;

		if($rs['Is_OpenHouse'] == 'Y')
		{
			// Get Open House Detail
			$arrOpenHouse = $this->getOpenHouseData($rs['ListingID_MLS']);

			if(is_array($arrOpenHouse))
			{
				$rs['arrOpenHouse'] = $arrOpenHouse;
			}
		}
		// Get virtual Tour Detail
		$recVirtualTour = $this->getVirtualTourData($rs['ListingID_MLS']);

        // Get room Details
		$rs['arrRooms'] = $this->getRoomData($rs['ListingKey'], $rs['MLSP_ID']);
        $rs['unitInfo'] = $this->getListingUnitInfo($rs['ListingKey']);
        //$rs['Feature_History']  =   $this->getPropertyHistory($rs['MLS_NUM']);
		if(is_array($recVirtualTour))
		{
			$rs = array_merge($rs, $recVirtualTour);
		}
//echo "<pre>";
//print_r($rs);
//echo "</pre>";
        return $rs;
	}
    function getListingUnitInfo($mls_no, $mlsp_no=1)
    {
        global $db, $config;

        $addParameters = " AND MLS_NUM = '".$mls_no."' AND MLSP_ID = ".$mlsp_no;
        $sql = "SELECT * FROM ".$this->Data['Listing_Unit_Info']." UI WHERE 1 ".$addParameters;

        $sql .= " ORDER BY UnitType ASC";

        if(DEBUG)
			$this->__debugMessage($sql);

		$rec = $db->query($sql);

        $rs = $rec->fetch_array(MYSQL_ASSOC);

        return $rs;
    }
    function getPropertyHistory($mls_no, $mlsp_no=1)
    {
        global $db, $config;

        $addParameters = " AND lplog_mls_num = '".$mls_no."' AND lplog_mlsp_id = ".$mlsp_no;
        $sql = "SELECT * FROM ".$this->Data['Listing_Price_Log']." PL WHERE 1 ".$addParameters;

        $sql .= " ORDER BY lplog_date desc";

        if(DEBUG)
			$this->__debugMessage($sql);

		$rec = $db->query($sql);

        $rs = $rec->fetch_array(MYSQLI_ASSOC);

        return $rs;
    }
	#=========================================================================================================================
	#	Function Name	:   getListingByMlsNum
	#-------------------------------------------------------------------------------------------------------------------------
    function getRandomListingByMLSNum($POST)
    {

        global $db, $physical_path, $virtual_path;
		//Utility::pre($POST);
		$addParameters = $this->getQueryParameters($POST);
		//Utility::pre($addParameters);
        $param = '';
		$param .= $addParameters;
		//Utility::pre($param);
		if($POST['MLS_NUM'] != '')
			$param .= " AND M.MLS_NUM IN('". $POST['MLS_NUM']. "') ";

		## Need Random Data, do it using PHP function, not by mysql // Added On 12 Aug 2010
		$start = 0;
		if($POST['Limit'] > 0)
		{
			# Get Count
			$sql = " SELECT M.MLS_NUM".
				   " FROM ". $this->Data['TableName']." AS M ".
				   " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				   " LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
                   //" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ".
                 //  " LEFT JOIN ".$this->Data['Listing_Price_Log']." AS PL ON PL.lplog_mls_num = M.MLS_NUM AND PL.lplog_mlsp_id = M.MLSP_ID".
				   " WHERE 1 ".$param;

            # Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

            //$rs->next_record();

			# Total Record
			//$recCount = $rs->f('cnt');
			$recCount = $rs->TotalRow;

			$rs->free();

			# If Count Of Matching Records more than given limit, set new start
			if($recCount > $POST['Limit'])
			{
				# Get Random no.
				$randNo = rand(1, $recCount);

				# Set Start For Limit
				$start = $recCount - $randNo;

				if(($start + $POST['Limit']) > $recCount)
				{
					$overCount = ($start + $POST['Limit']) - $recCount;

					$start = $start - $overCount;
				}
			}

		}

		$sql = " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.MLSP_ID, ListPrice, Beds, BathsFull, BathsHalf, M.PropertyType,M.Baths,M.Listing_Created_Date, M.ListingDate, M.SubType, ".
			   " Subdivision, SQFT, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Parking, Garage, DisplayAddress, ".
			   " A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, ZipCode, A.CityName, A.County, A.State, AI.DOM, ".
			   // ", CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path".
			   "Category, ListingStatus, YearBuilt, Stories, A.Latitude, A.Longitude,O.Office_Name";
        if($POST['ShowMiles'] && $POST['Latitude'])
            $sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['Latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['Latitude']." / 57.2958 ) * COS( ".$POST['Longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";

			   //" Price_Diff, Is_OpenHouse, LastUpdateDate, DATEDIFF(CURDATE(), ListingDate) AS ListedBefore, (DATE_FORMAT(CURDATE(), '%Y')-YearBuilt) AS YearDiff,".
			   //" O.Office_Name
        $sql .= " FROM ". $this->Data['TableName']." AS M ".
			   " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
			   " LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
               " LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
               " LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";
        	   //" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
			  // " LEFT JOIN ".$this->Data['Listing_Price_Log']." AS PL ON PL.lplog_mls_num = M.MLS_NUM AND PL.lplog_mlsp_id = M.MLSP_ID".
		$sql .=	   " WHERE 1 ".$param;


		if($POST['OrderBy'] != '')
			$sql .= " ORDER BY ".$POST['OrderBy']." LIMIT 0,".$POST['Limit'];
		elseif($POST['Limit'] != '')
			$sql .= " LIMIT $start,".$POST['Limit'];
	    //file_put_contents('arrSimilarProp.txt',print_r($sql,true));
        //echo $sql;die;
        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

        $arr = array();

		$arr['rs'] = array();

		while($rs->next_record())
		{
			$row = $rs->Record;

			if($POST['pic_flag'] !== false)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
				}
				else
					$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/0";
			}

			if($row['Is_OpenHouse'] == 'Y')
			{
				// Get Open House Detail
				$arrOpenHouse = $this->getOpenHouseData($row['ListingID_MLS']);

				if(is_array($arrOpenHouse))
				{
					$row['arrOpenHouse'] = $arrOpenHouse;
				}
			}

			array_push($arr['rs'], $row);
		}
        //Utility::pre($row['MainPicture']);
		$arr['PhotoBaseUrl'] = $this->Pic_Path;
        //Utility::pre($arr);
//		return $arr['rs']; // MS [Wednesday, August 28, 2013]
		return $arr;
	}
	 /**
     * IDXListing::GetDeletedListing()
     *
     * @param array $POST = required arguments in array format
     * @return array of record
     *
     * It will get record for given arguments from deleted listing
     * return that record in array format
     */
    public function GetDeletedListing($POST)
    {
        global $db;

        if ($POST['ListingID_MLS']=='')
			return true;

        $sql = "SELECT * FROM ".$this->Data['Listing_Deleted']." LD
                WHERE UPPER(CONCAT(LD.MLS_NUM,'-',LD.MLSP_ID)) = '". strtoupper($POST['ListingID_MLS']). "'";

        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

        $rec = $db->query($sql);

		$rs = $rec->fetch_array(MYSQLI_FETCH_SINGLE);

        return $rs;
    }
#====================================================================================================
#	Picture Function
#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   getPicArray
	#-------------------------------------------------------------------------------------------------------------------------
    function getPicArray($ListingID_MLS, $TotalPhotos, $printFlag=false)
    {
		global $physical_path, $virtual_path, $config;

		$retArr = array();

		$arrID = explode("-",$ListingID_MLS);

		$MLS_NUM	= $arrID[0];
		$MLSP_ID		= $arrID[1];

		//print $ListingID_MLS;die;
		if (strlen($MLS_NUM)>2)
			$folderName = substr($MLS_NUM,-2);
		else
			$folderName = $MLS_NUM;

		$pic_Path = $physical_path['Upload']. "/pictures/".$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/".$folderName."/". $MLS_NUM."/";

		for($i=0; $i<$TotalPhotos; $i++)
		{
			$picFilePath = $pic_Path. $MLS_NUM. '_'. $i.'.jpg';
			array_push($retArr, $virtual_path['Assets_Url']."/pictures/property/".$ListingID_MLS."/".$i);
		}
		/*
		print "<pre>";
		print_r($retArr);
		print "</pre>";
		die;*/
		return $retArr;
	}
	#=========================================================================================================================
	#	Function Name	:   getPicArray2
	#-------------------------------------------------------------------------------------------------------------------------
    function getPicArray2($MLS_NUM, $MLSP_ID, $getMainPic=false)
    {
		global $db, $asset;

		$arrReturn = array();

		foreach($asset['mlsPhotoType'] as $photoType=>$desc){

			$sql =	" SELECT photo_url as 'url' ".		// photo_caption as 'caption', photo_desc as 'desc',
					" FROM ". $this->Data['MLS_Photo_Table']." AS PH ".
					" WHERE MLS_NUM = '".$MLS_NUM."' ".
					"	AND MLSP_ID = '".$MLSP_ID."' ".
					"	AND photo_type = '".$photoType."' ".
					" ORDER BY photo_display_order ASC";

			//file_put_contents('pic_sql.txt',print_r($sql,true));
			if($getMainPic)
				$sql .= " LIMIT 0,1";
            //echo $sql;die;
			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);
			//file_put_contents('rs.txt',print_r($sql,true));
			if($rs->num_rows() > 0)
			{
				$arrReturn[$photoType] = array();

				if($getMainPic)
				{
					$rs->next_record();
					$rs->Record['url'] = str_replace('&', '&amp;', $rs->Record['url']);
					$arrReturn[$photoType] = $rs->Record;
				}
				else
				{
					while($rs->next_record())
					{
						$rs->Record['url'] = str_replace('&', '&amp;', $rs->Record['url']);
						array_push($arrReturn[$photoType], $rs->Record);
					}
				}
			}
		}

        if(!isset($arrReturn['thumb']) && isset($arrReturn['large']))
			$arrReturn['thumb'] = $arrReturn['large'];

		return $arrReturn;
	}
	#=========================================================================================================================
	#	Function Name	:   getActivePicNo
	#	Purpose			:	Check MLS_NUM already exists or not
	#-------------------------------------------------------------------------------------------------------------------------
    function getActivePicNo($ListingID_MLS, $TotalPhotos, &$pic_no, &$cpic)
    {
		global $physical_path, $config;

		$arrID = explode("-",$ListingID_MLS);

		$MLS_NUM	= $arrID[0];
		$MLSP_ID	= $arrID[1];

		if (strlen($MLS_NUM)>2)
			$folderName = substr($MLS_NUM,-2);
		else
			$folderName = $MLS_NUM;

		$pic_Path = $physical_path['Upload']. "/pictures/".$this->picPath['MLS_Pic_Folder'][$MLSP_ID]."/".$folderName."/". $MLS_NUM."/";

		if ((is_dir($pic_Path."custom/")) && ($MLSP_ID==0))
		{
			chdir($pic_Path."custom/");
			if (count(glob("*.*"))>0)
			{
				$pic_Path .= "custom/";
				$cpic = 1;
				$pic_no = 0;
			}
		}
		elseif (is_dir($pic_Path))
		{
			chdir($pic_Path);
			if (count(glob("*.*"))>0)
			{
				$picFilePath = $pic_Path. $MLS_NUM. '_'. $pic_no.'.jpg';
				if(!file_exists($picFilePath))
				{
					for($i=$pic_no; $i<=$TotalPhotos; $i++)
					{
						$picFilePath = $pic_Path. $MLS_NUM. '_'. $i.'.jpg';
						if(file_exists($picFilePath))
						{
							$pic_no = $i;
							break;
						}
					}
				}
			}
		}
	}

	#=========================================================================================================================
	#	Function Name	:   getListingCountByParam
	#	Purpose			:	Used by saved searches
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingCountByParam($POST)
    {
		global $db;

        $addParameters .= $this->getQueryParameters($POST);

        $sql =	" SELECT count(M.MLS_NUM) as cnt ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM".
				" LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID AND M.MLSP_ID = AG.Agent_MLSP_ID".
				" LEFT JOIN ". $this->Data['Agent_Table']." AS AG2 ON M.CoAgent_ID  = AG2.Agent_ID AND M.MLSP_ID = AG2.Agent_MLSP_ID";

		$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";
		$sql .= " WHERE 1".$addParameters;
//file_put_contents('sql_cout.txt',$sql);
		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$rs->next_record();

		return $rs->f("cnt") ;
	}
	#====================================================================================================
	#	Function Name	:   getPropTypeKeyValueArray // Added on D : 8, Apr 2010
	#----------------------------------------------------------------------------------------------------
	function getPropTypeKeyValueArray($POST='')
	{
		global $db;

		$addParams = '';

		if($POST['MLSP_ID'] != '')
			$addParams .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if($POST['ForSale'])
			$addParams .= " AND PropertyType != 'Residential Lease'";

		$sql =	" SELECT Distinct PropertyType".
				" FROM ". $this->Data['TableName']." AS M ".
				" WHERE 1".$addParams.
				" ORDER BY PropertyType desc";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrArea = array();

		while($rs->next_record())
		{
			$arrArea[strtolower($rs->f('PropertyType'))] = $rs->f('PropertyType');
		}

		return $arrArea;
	}
	#====================================================================================================
	#	Function Name	:   getEleSchoolKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getEleSchoolKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(Elementary_School)"
				. " FROM ". $this->Data['TableName']
				. " WHERE Elementary_School != ''".$addParameters
				. " ORDER BY Elementary_School";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('Elementary_School')]  = ucwords(strtolower($rs->f('Elementary_School')));
		}

		// To exclude some inappropriate values
		//$arr = array_slice($arr, 55);

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getMidSchoolKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getMidSchoolKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(Middle_School)"
				. " FROM ". $this->Data['TableName']
				. " WHERE Middle_School != ''".$addParameters
				. " ORDER BY Middle_School";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('Middle_School')]  = ucwords(strtolower($rs->f('Middle_School')));
		}

		// To exclude some inappropriate values
		$arr = array_slice($arr, 5);

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getHighSchoolKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getHighSchoolKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(High_School)"
				. " FROM ". $this->Data['TableName']
				. " WHERE High_School != ''".$addParameters
				. " ORDER BY High_School";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('High_School')]  = ucwords(strtolower($rs->f('High_School')));
		}

		// To exclude some inappropriate values
		$arr = array_slice($arr, 24);

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getSchoolDistrictKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getSchoolDistrictKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		$sql	= " SELECT DISTINCT(School_District)"
				. " FROM ". $this->Data['TableName']
				. " WHERE School_District != ''".$addParameters
				. " ORDER BY School_District";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('School_District')]  = $rs->f('School_District');
		}

		// To exclude some inappropriate values
		$arr = array_slice($arr, 24);

		return ($arr);
	}
#====================================================================================================
#	Agent Function
#----------------------------------------------------------------------------------------------------
	#====================================================================================================
	#	Function Name	:   getAgentKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getAgentKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		// Office Id
		if(isset($POST['OfficeID']) && $POST['OfficeID'] != '')
		{
			$addParameters .= " AND Agent_Office_ID IN ('".str_replace(",", "','", $POST['OfficeID'])."')";
		}

		$sql	= " SELECT Agent_ID, Agent_FName, Agent_LName"
				. " FROM ". $this->Data['Agent_Table']
				. " WHERE 1 ".$addParameters
				. " ORDER BY Agent_FName";

		if($this->picPath['InActive_MLSP_ID'] != '')
			$sql .=	" AND Agent_MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";

		# Show debug info
		if(DEBUG)

			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs = $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
			$arr[$row['Agent_ID']]  = $row['Agent_FName'].' '.$row['Agent_LName'].' ['.$row['Agent_ID'].']';

		return ($arr);
	}
    #====================================================================================================
	#	Function Name	:   getAgentShortIDKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getAgentShortIDKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		// Office Id
		if(isset($POST['OfficeID']) && $POST['OfficeID'] != '')
		{
			$addParameters .= " AND Agent_Office_ID IN ('".str_replace(",", "','", $POST['OfficeID'])."')";
		}

		$sql	= " SELECT Agent_ID, Agent_FName, Agent_LName, Agent_ShortID"
				. " FROM ". $this->Data['Agent_Table']
				. " WHERE Agent_ShortID != '' ".$addParameters
				. " ORDER BY Agent_FName";

		if($this->picPath['InActive_MLSP_ID'] != '')
			$sql .=	" AND Agent_MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";

		# Show debug info
		if(DEBUG)

			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs = $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
			$arr[$row['Agent_ShortID']]  = $row['Agent_FName'].' '.$row['Agent_LName'].' ['.$row['Agent_ID'].']'.' ['.$row['Agent_ShortID'].']';

		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   getAgentInfoByID
	#-------------------------------------------------------------------------------------------------------------------------
    function getAgentInfoByID($POST)
    {
		global $db;

		$sql = " SELECT * FROM ".$this->Data['Agent_Table']." "
			 . " WHERE CONCAT(Agent_ID,'_',Agent_MLSP_ID) = '".$POST['Agent_MLSP_ID']."' ";

		$db->query($sql);

		return $db->fetch_array(MYSQLI_FETCH_SINGLE);
	}

#====================================================================================================
#	Office Function
#----------------------------------------------------------------------------------------------------
	#====================================================================================================
	#	Function Name	:   getOfficeKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getOfficeKeyValueArray($POST)
    {
		global $db;

		$arrOfficeID = '';
		if ($POST['OfficeList'])
			$arrOfficeID = $POST['OfficeList'];

		$sql	= " SELECT Office_ID, Office_Name "
				. " FROM ". $this->Data['Office_Table']
				. " WHERE 1 ";

		if (is_array($arrOfficeID))
			$sql .= " AND CONCAT(Office_ID,'_',Office_MLSP_ID) IN ('". implode("','", $arrOfficeID) ."')";

		if($POST['ActiveOfficeFlag'])
		{
			if($this->picPath['InActive_MLSP_ID'] != '')
				$sql .=	" AND Office_MLSP_ID NOT IN ( ".$this->picPath['InActive_MLSP_ID']." ) ";
		}

		$sql	.= " ORDER BY Office_Name";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$rs = $rs->fetch_array();

		$arr 	= array();
		foreach($rs as $key => $row)
			$arr[$row['Office_ID']]  = $row['Office_Name'];

		return ($arr);
	}
#====================================================================================================
#	Address Function
#----------------------------------------------------------------------------------------------------
	#=========================================================================================================================
	#	Function Name	:   FetchStateKeyValueArray
	#	Purpose			:	Fetch Distinct State
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	function FetchStateKeyValueArray($POST='')
	{
		global $db;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		# Define query
		/*if($POST['StateName'])
		{
			$sql = " SELECT DISTINCT State, state_name FROM ". $this->Data['Listing_Address']." AS A"
				 . " LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State"
				 . " WHERE 1".$params
				 . " ORDER BY state_name";
		}
		else
		{*/
			$sql = " SELECT DISTINCT State FROM ". $this->Data['Listing_Address']
				 . " WHERE 1".$params
				 . " ORDER BY State";
		//}

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arrRet = array();
		while($rs->next_record())
		{
			/*if($POST['StateName'])
				$arrRet[$rs->f('State')] = $rs->f('state_name');
			else*/
				$arrRet[$rs->f('State')] = $rs->f('State');
		}

		return $arrRet;
	}
	#====================================================================================================
	#	Function Name	:   getOfficeKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getCityKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		/* State */
		if($POST['StateCode'])
			$addParameters .= " AND State = '".$POST['StateCode']."'";
		elseif($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		/* County */
		if($POST['County'] != '')
			$addParameters .= " AND County = '". $POST['County'] ."' ";
		/* NoCounty */
		if($POST['NoCounty'])
			$addParameters .= " AND County = '' ";

		if($POST['CityStartWith'] != '')
			$addParameters .= " AND CityName LIKE '".$POST['CityStartWith']."%'";

		$sql	= " SELECT DISTINCT(CityName)"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE CityName != ''". $addParameters
				. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[ucwords(strtolower($rs->f('CityName')))]  = ucwords(strtolower($rs->f('CityName')));
		}

		return ($arr);
	}

	#====================================================================================================
	#	Function Name	:   getCityAutoComplete
	#----------------------------------------------------------------------------------------------------
	function getCityAutoComplete($POST='')
	{
		global $db;

		$addParameters = '';
		$searchFields    = array();
		$searchFields[]  = 'CityName';

		$fieldsToSearch  = implode(", ", $searchFields);

		$addParameters   .= " AND  ( CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '%".$POST['keywords'] . "%') ";

		$sql	= " SELECT DISTINCT(CityName)"
			. " FROM ". $this->Data['Listing_Address']
			. " WHERE CityName != ''". $addParameters
			. " ORDER BY CityName";

		if($POST['Limit'] > 0)
			$sql .= " LIMIT 0,".$POST['Limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[]  = array('type' => ASTYPE_CITY, 'label' => $rs->f('CityName'));
			//$arr[ucwords(strtolower($rs->f('CityName')))]  = ucwords(strtolower($rs->f('CityName')));
		}

		return ($arr);

	}
	#====================================================================================================
	#	Function Name	:   getCityWiseZipKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getCityWiseZipKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		$sql	= " SELECT DISTINCT(CityName)"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE CityName != ''". $addParameters
				. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$cityName = ucwords(strtolower($rs->f('CityName')));

			$arr[$cityName]  = $this->getZipKeyValueArray($cityName);
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   FetchCityWiseZipKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function FetchCityWiseZipKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['State'] != '')
			$addParameters .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if ($POST['PropertyType']!='')
			$addParameters	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$addParameters	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$addParameters .=" AND Is_OpenHouse = 'Y'";

		$sql	= " SELECT DISTINCT(CityName), State, state_name, ZipCode"
				. " FROM ". $this->Data['TableName']." AS M "
				. " LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
				. " LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State"
				. " WHERE CityName != ''". $addParameters
				. " GROUP BY CityName, ZipCode"
				. " ORDER BY CityName";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getCityWiseListingCount
	#	Purpose			:	Fetch Distinct City with listing count
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	function getCityWiseListingCount($POST='')
	{
		global $db,$config;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if($POST['CityStartWith'] != '')
			$params .= " AND CityName LIKE '".$POST['CityStartWith']."%'";

		if ($POST['PropertyType']!='')
			$params	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$params	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$params .=" AND Is_OpenHouse = 'Y'";

		# Define query
		$sql =	" SELECT CityName, State, COUNT(M.MLS_NUM) as listing_cnt, state_name ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
				" LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State";

		$sql .=	" WHERE M.is_mark_for_deletion = 'N'".$params;

		$sql .=	" GROUP BY CityName HAVING COUNT( M.MLS_NUM ) > 0 ORDER BY CityName";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getCityWiseListingCount
	#	Purpose			:	Fetch Distinct City with listing count
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	function getDistinctCity($POST='')
	{
		global $db;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if ($POST['PropertyType']!='')
			$params	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$params	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$params .=" AND Is_OpenHouse = 'Y'";

		if($POST['MLSP_ID'] != '')
			$params .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		# Define query
		$sql =	" SELECT CityName, State, state_name ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
				" LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State".
				" WHERE CityName != ''".$params.
				" GROUP BY CityName ORDER BY CityName";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   getDistinctCity // Added on D : 8, Apr 2010
	#----------------------------------------------------------------------------------------------------
	function getRandomCityList($POST)
	{
		global $db;

		$addParameters = '';
		$skipRandomLogic = false;

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

        if($POST['CityName'] != '')
        {
            $str = str_replace(",", "','", $POST['CityName']);
            $addParameters	 .=	" AND CityName IN('".$str. "')";
            //$addParameters .= " AND CityName = '".$POST['CityName']."'";

			$skipRandomLogic = true;
        }

		## Need Random Data, do it using PHP function, not by mysql // Added On 12 Aug 2010
		$start = 0;
		if($POST['Limit'] > 0 && $skipRandomLogic === false)
		{
			# Get Count
			$sql = " SELECT COUNT(Distinct CityName) as cnt".
				   " FROM ". $this->Data['Listing_Address'].
				   " WHERE CityName != ''".$addParameters;

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			$rs->next_record();

			# Total Record
			$recCount = $rs->f('cnt');

			$rs->free();

			# If Count Of Matching Records more than given limit, set new start
			if($recCount > $POST['Limit'])
			{
				# Get Random no.
				$randNo = rand(1, $recCount);

				# Set Start For Limit
				$start = $recCount - $randNo;

				if(($start + $POST['Limit']) > $recCount)
				{
					$overCount = ($start + $POST['Limit']) - $recCount;

					$start = $start - $overCount;
				}
			}

		}

		$sql =	" SELECT Distinct CityName, State".
				" FROM ". $this->Data['Listing_Address'].
				" WHERE CityName != ''".$addParameters.
				" ORDER BY CityName";

		if($skipRandomLogic === true)
			$sql .= " LIMIT 0,".$POST['Limit'];
		elseif($POST['Limit'] != '')
			$sql .= " LIMIT $start,".$POST['Limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   FetchCityName
	#----------------------------------------------------------------------------------------------------
	function FetchCityName($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if($POST['CityName'] != '')
		{
			if(strpos($POST['CityName'], '~'))
			{
				$cityName = str_replace("~", "_", $POST['CityName']);

				$addParameters .= " AND CityName LIKE '".$cityName."'";
			}
		}

		$sql	= " SELECT CityName"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE CityName != ''". $addParameters;

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$rs->next_record();

		$arr['CityName'] = $rs->f('CityName');

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getCountyKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getCountyKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		$sql	= " SELECT DISTINCT(County)"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE County != ''".$addParameters
				. " ORDER BY County";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('County')]  = ucwords(strtolower($rs->f('County')));
		}

		return ($arr);
	}

	#====================================================================================================
	#	Function Name	:   getCountyKeyValue2
	#----------------------------------------------------------------------------------------------------
	function getCountyKeyValue2($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		$sql	= " SELECT DISTINCT(County)"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE County != ''".$addParameters
				. " ORDER BY County";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('County')]  = ucwords(strtolower($rs->f('County')));
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getSubdivisionKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getSubdivisionKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		/* State */
		if($POST['StateCode'])
			$addParameters .= " AND State = '".$POST['StateCode']."'";
		elseif($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		/* County */
		if($POST['County'] != '')
			$addParameters .= " AND County = '". $POST['County'] ."' ";
		/* NoCounty */
		if($POST['NoCounty'])
			$addParameters .= " AND County = '' ";

		if($POST['StartWith'] != '')
			$addParameters .= " AND Subdivision LIKE '".$POST['StartWith']."%'";

		if($POST['Subdivision'] != '')
			$addParameters .= " AND Subdivision LIKE '%".$POST['Subdivision']."%'";

		$sql	= " SELECT DISTINCT(Subdivision)"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE Subdivision != '' AND Subdivision != '0'". $addParameters
				. " ORDER BY Subdivision";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[ucwords(strtolower($rs->f('Subdivision')))]  = ucwords(strtolower($rs->f('Subdivision')));
		}

		return ($arr);
	}	#====================================================================================================
	#	Function Name	:   getAreaKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getAreaKeyValueArray($POST='')
    {
		global $db;

		$addParameters = '';

		if($POST['MLSP_ID'] != '')
			$addParameters .= " AND MLSP_ID IN('".$POST['MLSP_ID']."')";

		if($POST['State'] != '')
			$addParameters .= " AND State = '".$POST['State']."'";

		$sql	= " SELECT DISTINCT(Area) AreaName, Area"
		//$sql	= " SELECT DISTINCT(SUBSTRING_INDEX(Area, '-', -1)) AreaName, Area"
				. " FROM ". $this->Data['Listing_Address']
				. " WHERE Area != ''".$addParameters
				. " GROUP BY Area"
				. " ORDER BY Area";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$rs->f('Area')]  = ucwords(strtolower($rs->f('AreaName')));
		}

		return ($arr);
	}
	#====================================================================================================
	#	Function Name	:   getZipKeyValueArray
	#----------------------------------------------------------------------------------------------------
	function getZipKeyValueArray($cityName='')
	{
		global $db;

		$addParameters = '';

		if($cityName != '')
			$addParameters .= " AND CityName = '". $cityName ."'";

		$sql =	" SELECT Distinct(ZipCode) AS ZipCode".
				" FROM ". $this->Data['Listing_Address']." AS A ".
				" WHERE ZipCode != '' AND ZipCode > 0".$addParameters." ORDER BY ZipCode ASC";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();

		while($rs->next_record())
		{
			$arr[$cityName.'|'.$rs->f('ZipCode')]  = $rs->f('ZipCode');
		}

		return ($arr);
	}
	#=========================================================================================================================
	#	Function Name	:   getCityWiseListingCount
	#	Purpose			:	Fetch Distinct City with listing count
	#	Return			:	array
	#-------------------------------------------------------------------------------------------------------------------------
	function getZipWiseListingCount($POST='')
	{
		global $db;

		$params = '';

		if($POST['State'] != '')
			$params .= " AND State IN('".str_replace(",", "','", $POST['State'])."')";

		if($POST['City'] != '')
			$params .= " AND CityName = '".$POST['City']."'";

		if ($POST['PropertyType']!='')
			$params	 .=	" AND PropertyType = '".$POST['PropertyType']. "'";

		if ($POST['Not_PropertyType'] != '')
			$params	 .=	" AND PropertyType NOT IN('".str_replace(",", "','", $POST['Not_PropertyType'])."')";

		# Open House
		if ($POST['OpenHouse'])
			$params .=" AND Is_OpenHouse = 'Y'";

		# Define query
		$sql =	" SELECT ZipCode, CityName, State, COUNT(M.MLS_NUM) as listing_cnt, state_name ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
				" LEFT JOIN ". $this->Data['GeoState']." AS GS ON GS.state_code = A.State".
				" WHERE is_mark_for_deletion = 'N'".$params.
				" GROUP BY ZipCode HAVING COUNT( M.MLS_NUM ) > 0 ORDER BY ZipCode";

		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#====================================================================================================
	#	Function Name	:   getOpenHouseData
	#----------------------------------------------------------------------------------------------------
	function getOpenHouseData($ListingID_MLS, $days='')
	{
		global $db,$config;

		$addParams = '';

		if($days > 0)
		{
			$addParams .= ' AND OH_Date <= DATE_ADD(CURDATE(), INTERVAL '.$days.' DAY)';
		}

		$sql =	" SELECT OH_Begins, OH_Close, OH_DisplayTime, OH_Date".
				" FROM ". $this->Data['MLS_Open_House_Table']." AS OP ".
				" WHERE CONCAT(MLS_NUM,'-',MLSP_ID) = '".$ListingID_MLS."' AND OH_Date >= CURDATE()".$addParams.
				" ORDER BY OH_Date ASC";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}
	#=========================================================================================================================
	#	Function Name	:   getCurrentWeakOpenHouses
	#-------------------------------------------------------------------------------------------------------------------------
    function getCurrentWeakOpenHouses($POST)
    {
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		if(isset($POST['CountOnly']))
		{
			$sql =  "SELECT M.MLS_NUM";
		}
		else
		{
			$sql =  " SELECT M.MLS_NUM, mls_is_pic_url_supported, M.ListPrice, Subdivision,  M.PropertyType, M.PropertyStyle, M.Beds, M.BathsFull,".
					" M.BathsHalf, M.SQFT, M.TotalAcreage, Main_Photo, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, Category, Parking, Garage,O.Office_Name,".
					" A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, DisplayAddress,".
					" A.StreetDirection, StreetSuffix, UnitNo, M.YearBuilt, M.Description, Price_Diff, ".
					" CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path, OP.*";
		}

		# Shreyansh 05/20/2013
		# To exclude open house details by office ID
		if(!defined("IN_ADMIN"))
			$sql .= ", IF(FIND_IN_SET(M.OfficeID,'".$config['exclude_openhouse_by_officeId']."'), 'N', Is_OpenHouse) AS Is_OpenHouse ";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Open_House_Table']." AS OP ON M.MLSP_ID = OP.MLSP_ID AND M.MLS_NUM = OP.MLS_NUM";


		$sql .= " WHERE Is_OpenHouse = 'Y' ";
//		$sql .= " WHERE Is_OpenHouse = 'Y' AND OH_Date >= CURDATE() AND OH_Date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)".$addParameters;

		# Set Order
		$sql .= " GROUP BY M.MLS_NUM ORDER BY OH_Date ASC ";

		# Set Limit
		if($POST['limit'])
			$sql .= " LIMIT 0, ".$POST['limit'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		if(isset($POST['CountOnly']))
		{
			$arr['total'] = $rs->TotalRow;
		}
		else
		{
			$arr['rs'] = array();

			while($rs->next_record())
			{
				$row = $rs->Record;

				# Shreyansh 05/20/2013
				# To exclude open house details by office ID
				if($row['Is_OpenHouse'] == 'Y')
				{
					if($row['mls_is_pic_url_supported'] == 'Yes')
					{
						$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=true);
					}
					else
					{
						$pic_no = $row['Main_Photo']-1;
						$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
					}

					// Get Open House Detail
					$arrOpenHouse = $this->getOpenHouseData($row['ListingID_MLS'], $days=7);

					if(is_array($arrOpenHouse))
					{
						$row['arrOpenHouse'] = $arrOpenHouse;
					}

					array_push($arr['rs'], $row);
				}
			}
		}

		return $arr;
	}/*
	#====================================================================================================
	#	Function Name	:   getCurrentWeakOpenHouses
	#----------------------------------------------------------------------------------------------------
	function getCurrentWeakOpenHouses()
	{
		global $db;

		$sql =	" SELECT OH_Begins, OH_Close, OH_DisplayTime, OH_Date".
				" FROM ". $this->Data['MLS_Open_House_Table']." AS OP ".
				" WHERE OH_Date >= CURDATE() AND OH_Date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) ORDER BY OH_Date ASC";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}*/
	#====================================================================================================
	#	Function Name	:   getOpenHouseData
	#----------------------------------------------------------------------------------------------------
	function getVirtualTourData($ListingID_MLS)
	{
		global $db;

		$sql =	" SELECT tour_url".
				" FROM ". $this->Data['MLS_Virtual_Tour_Table']." AS VT ".
				" WHERE CONCAT(MLS_NUM,'-',MLSP_ID) = '".$ListingID_MLS."' ORDER BY tour_last_modified DESC LIMIT 0,1";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array(MYSQLI_FETCH_SINGLE);
	}

	#====================================================================================================
	#	Function Name	:   getRoomData
	#----------------------------------------------------------------------------------------------------
	function getRoomData($ListingKey, $MLSP_ID)
	{
		global $db;

		$sql =	" SELECT *".
				" FROM ". $this->Data['Listing_Room_Info']." AS R ".
				" WHERE ListingKey = '".$ListingKey."' AND MLSP_ID = '".$MLSP_ID."'";

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		return $rs->fetch_array();
	}

	function getListingLastUpdateDate()
	{
		global $db;

		$sql =	" SELECT MAX(LastUpdateDate) AS LastUpdateDate ".
				" FROM ". $this->Data['TableName'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
		$arr = $rs->fetch_array(MYSQLI_FETCH_SINGLE);

		return $arr['LastUpdateDate'];
	}

	#=========================================================================================================================
	#	Function Name	:   getListingForMap
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingForMap($POST)
    {
		global $db, $virtual_path, $config;

		$addParameters = $this->getQueryParameters($POST);

		$POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : RESULT_PAGESIZE;

		$sql =  " SELECT M.MLS_NUM, mls_is_pic_url_supported, M.ListPrice, M.Beds, M.Baths,".
				" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,".
				" A.StreetName, Address, A.StreetNumber, A.StreetDirection, StreetSuffix, UnitNo, A.Area, A.CityName, A.County, A.State, ZipCode,".
				" A.Latitude, A.Longitude, CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path";

		$sql .= " FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
				" WHERE 1 ".$addParameters;

		if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST['start_record']. ", ". $POST['page_size'];

		# Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);

		$arr = array();
		$arr['map-data'] = array();

		while($rs->next_record())
		{
			$row = $rs->Record;

			if($row['mls_is_pic_url_supported'] == 'Yes')
			{
				$row['MainPicture'] = $this->getPicArray2($row['MLS_NUM'], $getMainPic=true);
			}
			else
			{
				$pic_no = $row['Main_Photo']-1;
				$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
			}

			//array_push($arr['rs'], $row);

			if($row['Latitude'] > 0)
			{
				$rsAttributes = Utility::generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
				$arrTemp['Price'] 		= ($row['ListPrice'] > 0 ? $row['ListPrice'] : 'Email Us for Pricing');
				$arrTemp['Bed'] 		= ($row['Beds'] > 0 ? $row['Beds'] : 'N/A');
				$arrTemp['Bath'] 		= ($row['Baths'] > 0 ? $row['Baths'] : 'N/A');
				$arrTemp['Sqft'] 		= ($row['SQFT'] > 0 ? $row['SQFT'] : 'N/A');
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Pic_Path'] 	= $row['Pic_Path'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];

				array_push($arr['map-data'], $arrTemp);
			}
		}

		if(count($arr['map-data']) > 0)
		{
			$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
		}

		//$arr['total_record'] = $this->total_record;

		return $arr;
	}
    #=========================================================================================================================
	#	Function Name	:   getSchoolSuggestion
	#-------------------------------------------------------------------------------------------------------------------------
    function getSchoolSuggestion($POST)
    {
        global $config, $db;

		$Parameters	 =	'';

		$arr = array();

		## Quick Search
		if(trim($POST['keywords']) != '')
		{
			$POST['keywords'] = trim($POST['keywords']);

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $POST['keywords'], $keywords);

            #---------------------------------------------------------------------------------------
            # SCHOOL SEARCH
            $searchFields   = array();
            $searchFields[] = 'Elementary_School';
            $searchFields[] = 'High_School';
            $searchFields[] = 'Middle_School';

            $fieldsToSearch = implode(", ", $searchFields);

            $strSearch      = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
            $sql            = " SELECT DISTINCT Elementary_School AS Schools FROM ". $this->Data['TableName']." WHERE Elementary_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND Elementary_School LIKE '%".$strSearch."%' UNION 
                              SELECT DISTINCT High_School AS Schools FROM ". $this->Data['TableName']." WHERE High_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND High_School LIKE '%".$strSearch."%' UNION
                              SELECT DISTINCT Middle_School AS Schools FROM ". $this->Data['TableName']." WHERE Middle_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND Middle_School LIKE '%".$strSearch."%' ORDER BY Schools";

            if($POST['Limit'] > 0)
				$sql    .= " LIMIT 0,".$POST['Limit'];

             # Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

            while($rs->next_record())
			{
			    $arraddress = $rs->f('Schools');
                $strReplace = str_replace(', ,', ',', $arraddress);

				$arr[]  =  array('type' => ASTYPE_SCHOOL, 'title' => $strReplace);

			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
        }

        return $arr;
    }
    #=========================================================================================================================
	#	Function Name	:   getAddressSuggestion
	#-------------------------------------------------------------------------------------------------------------------------
	function getAddressSuggestion($POST)
	{
		global $config, $db;

		$Parameters	 =	'';

		$arr = array();

		## Quick Search
		if(trim($POST['keywords']) != '')
		{
			$POST['keywords'] = trim($POST['keywords']);

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $POST['keywords'], $keywords);
            #---------------------------------------------------------------------------------------
            # COUNTY SEARCH
            //Utility::pre($POST);
            /*$searchFields    = array();
			$searchFields[]  = 'County';

			$fieldsToSearch  = implode(", ", $searchFields);

			$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
			$addParameters   = " AND ". $fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";

			$sql             = " SELECT DISTINCT(CONCAT_WS(', ', County, State)) AS County"
                            . " FROM ". $this->Data['TableName']." AS M"
                            . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                            . " WHERE County != '' AND is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
                            . " ORDER BY County";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_COUNTY, 'title' => $rs->f('County'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}*/
            # ----------------------------------------------------------------------------------
			# CITY SEARCH
			$searchFields    = array();
			$searchFields[]  = 'CityName';

			$fieldsToSearch  = implode(", ", $searchFields);

			$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
			$addParameters   = " AND ". $fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";

			$sql             = "SELECT DISTINCT(CONCAT_WS(', ', CityName, State)) AS CityName "
                            . " FROM ". $this->Data['TableName']." AS M"
                            . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                            . " WHERE is_mark_for_deletion = 'N'". $addParameters
                            . " ORDER BY CityName";
			/*
				SELECT DISTINCT(CONCAT_WS(', ', CityName, State)) AS CityName
				FROM oe_listing_master AS M
				LEFT JOIN oe_listing_address AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                WHERE is_mark_for_deletion = 'N'
				AND CityName REGEXP '[[:<:]]
				ORDER BY CityName
			*/

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_CITYSTATE, 'title' => $rs->f('CityName'));
			}
			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
            # ---------------------------------------------------------------------------------
            # Area
            /*$searchFields    = array();
			$searchFields[]  = 'Area';

            $fieldsToSearch  = implode(", ", $searchFields);

            $strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP ' ", $keywords[0]);

			$addParameters   = " AND " .$fieldsToSearch. " REGEXP '". $strSearch. "' ";

            $sql             = "SELECT DISTINCT(Area) AS Area "
                            . " FROM ". $this->Data['TableName']." AS M"
                            . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                            . " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
                            . " ORDER BY Area";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

            # Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_AREA, 'title' => $rs->f('Area'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}*/
            #---------------------------------------------------------------------------------------
            # SCHOOL SEARCH
            /*$searchFields   = array();
            $searchFields[] = 'Elementary_School';
            $searchFields[] = 'High_School';
            $searchFields[] = 'Middle_School';

            $fieldsToSearch = implode(", ", $searchFields);

            $strSearch      = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
            //$addParameters  = " AND ( CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]". $strSearch. "') ";
            //$addParameters = " AND ( M.Elementary_School LIKE '%".$strSearch."%' OR M.High_School LIKE '%".$strSearch."%' OR M.Middle_School LIKE '%".$strSearch."%')";
            $sql            = "SELECT DISTINCT Elementary_School AS Schools FROM ". $this->Data['TableName']." WHERE Elementary_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND Elementary_School LIKE '%".$strSearch."%' UNION
                                              SELECT DISTINCT High_School AS Schools FROM ". $this->Data['TableName']." WHERE High_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND High_School LIKE '%".$strSearch."%' UNION
                                              SELECT DISTINCT Middle_School AS Schools FROM ". $this->Data['TableName']." WHERE Middle_School != '' AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' AND Middle_School LIKE '%".$strSearch."%' ORDER BY Schools";

            if($POST['Limit'] > 0)
				$sql    .= " LIMIT 0,".$POST['Limit'];
             //Utility::pre($sql);
             # Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);
            //Utility::pre($rs);
            while($rs->next_record())
			{
			    $arraddress = $rs->f('Schools');
                $strReplace = str_replace(', ,', ',', $arraddress);

				$arr[]  =  array('type' => ASTYPE_SCHOOL, 'title' => $strReplace);

			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			} */
            /*# ---------------------------------------------------------------------------------
            # SubDivision
            $searchFields    = array();
			$searchFields[]  = 'Subdivision';

            $fieldsToSearch  = implode(", ", $searchFields);

            $strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP ' ", $keywords[0]);

			$addParameters   = " AND " .$fieldsToSearch. " REGEXP '". $strSearch. "' ";

            $sql             = "SELECT DISTINCT(Subdivision) AS Subdivision "
                            . " FROM ". $this->Data['TableName']." AS M"
                            . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                            . " WHERE is_mark_for_deletion = 'N'". $addParameters
                            . " ORDER BY Subdivision";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

            # Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_SUB, 'title' => $rs->f('Subdivision'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}*/
            #---------------------------------------------------------------------------------------
            # ADDRESS SEARCH
            $searchFields   = array();
            $searchFields[] = 'UnitNo';
            $searchFields[] = 'StreetNumber';
            $searchFields[] = 'StreetName';

            $fieldsToSearch = implode(", ", $searchFields);

            $strSearch      = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
            $addParameters  = " AND ( CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]". $strSearch. "') ";

            $sql            = "SELECT DISTINCT(CONCAT_WS(', ', CONCAT_WS(' ',UnitNo, StreetNumber, StreetDirection, StreetDirPrefix, StreetName, StreetSuffix, StreetDirSuffix), CityName, State)) AS address"
                            . " FROM ". $this->Data['TableName']." AS M"
                            . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                            . " WHERE is_mark_for_deletion = 'N'" . $addParameters
                            . " ORDER BY address";

            if($POST['Limit'] > 0)
				$sql    .= " LIMIT 0,".$POST['Limit'];

            # Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

            while($rs->next_record())
			{
			    $arraddress = $rs->f('address');
                $strReplace = str_replace(', ,', ',', $arraddress);
                //$MLS = $rs->f('ListingID_MLS');

				$arr[]  =  array('type' => ASTYPE_ADD, 'title' => $strReplace);

			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
            #-------------------------------------------------------------------------------
			# ZipCode SEARCH
			$searchFields    = array();
			$searchFields[]  = 'ZipCode';

			$fieldsToSearch  = implode(", ", $searchFields);

			$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
			$addParameters   = " AND ".$fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";

			$sql             = " SELECT DISTINCT(ZipCode) AS ZipCode"
                            . " FROM ". $this->Data['TableName']." AS M"
                            . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
                            . " WHERE ZipCode != '' AND is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','Pending') ". $addParameters
                            . " ORDER BY ZipCode";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_ZIP, 'title' => $rs->f('ZipCode'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
            # ----------------------------------------------------------------------------------
			# MLS SEARCH
			$strSearch       = implode("%' OR M.MLS_NUM LIKE '", $keywords[0]);
			$addParameters   = " AND ( M.MLS_NUM LIKE '". $strSearch. "%' ) ";

			$sql             = " SELECT DISTINCT(MLS_NUM) AS MLS_NUM"
                            . " FROM ". $this->Data['TableName']." AS M"
                            . " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus IN ('Active','Pending')". $addParameters
                            . " ORDER BY MLS_NUM";

			if($POST['Limit'] > 0)
				$sql .= " LIMIT 0,".$POST['Limit'];

			# Show debug info
			if(DEBUG)
				$this->__debugMessage($sql);

			$rs = $db->query($sql);

			while($rs->next_record())
			{
				$arr[]  = array('type' => ASTYPE_MLS, 'title' => $rs->f('MLS_NUM'));
			}

			if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
			{
				return $arr;
			}
			elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
			{
				$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
			}
        }
		return $arr;
	}
    #=========================================================================================================================
	#	Function Name	:   getListingByParam
	#-------------------------------------------------------------------------------------------------------------------------
    function getListingByParamForHome($POST)
    {
		global $db, $virtual_path, $config, $asset;

		$addParameters = $this->getQueryParameters($POST);
        $POST['page_size'] = $POST['page_size'] ? $POST['page_size'] : RESULT_PAGESIZE;

        $sql =	" SELECT count(*) as cnt ".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ";

		//$sql .=	" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";

		$sql .= " WHERE 1 ".$addParameters;
       // echo $sql; die;
		//$rs = $db->query($sql, true);
		$rs = $db->query($sql);
		$rs->next_record();

        $this->total_record = $rs->f("cnt") ;
		$rs->free();

		if (!$POST['allRecord'])
		{
			if($POST['start_record'] >= $this->total_record || $POST['page_size'] >= $this->total_record || !isset($POST['start_record']))
				$POST['start_record'] = 0;
		}
		//echo"<pre>";print_r($POST);die;
		if ($POST['viewType']==VT_LIST)
		{
			$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.Beds,M.Baths,M.Main_Photo, ".
					" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,AI.DOM, ".
					" TotalPhotos, Is_OpenHouse, ListingDate, ".
					" A.StreetNumber, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress,".
					" O.Office_Name,CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName, ".
					" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, ".
                    "(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
                    "(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";
            if($POST['ShowMiles'] && $POST['Latitude'])
				$sql .= ",( 6378.7 * ACOS( SIN( A.Latitude / 57.2958 ) * SIN( ".$POST['Latitude']." / 57.2958 ) + COS( A.Latitude / 57.2958 ) * COS( ".$POST['Latitude']." / 57.2958 ) * COS( ".$POST['Longitude']." / 57.2958 - ( A.Longitude ) / 57.2958 ) ) ) AS Miles";
		}
		elseif ($POST['viewType']==VT_MAP)
		{
			$sql =  " SELECT M.MLS_NUM, ListingKey, mls_is_pic_url_supported, M.ListPrice, M.Beds,M.Baths,M.Main_Photo, ".
					" M.SQFT, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,Listing_Created_Date, ListingDate, ".
					" TotalPhotos, Is_OpenHouse, ".
					" A.StreetNumber, A.StreetName, A.StreetDirPrefix, A.StreetDirSuffix, A.CityName, A.State, ZipCode, DisplayAddress, A.Subdivision, ".
					" O.Office_Name, CONCAT(AG.Agent_FName, ' ', AG.Agent_LName) AS Agent_FullName, AI.DOM, ".
					" A.StreetDirection, StreetSuffix, UnitNo, M.Parking, M.YearBuilt, A.Latitude, A.Longitude, ".
                    "(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
                    "(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";
        }
		elseif ($POST['viewType']==VT_SITE_MAP)
		{
			$sql =  " SELECT M.MLS_NUM, M.MLSP_ID, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS, M.PropertyType, LastUpdateDate, Listing_Created_Date, ListingDate, AI.DOM,".
					" A.StreetNumber, A.StreetName, Address, A.StreetDirection, A.CityName, A.State, A.County, ZipCode, A.Subdivision ";
		}
		else
		{
		  	$sql =  " SELECT M.*, mls_is_pic_url_supported, M.PropertyType, M.SubType, CONCAT(M.MLS_NUM,'-',M.MLSP_ID) As ListingID_MLS,ListingDate, AI.DOM,".
					" Parking, Garage, A.StreetNumber, A.StreetName, Address, A.CityName, A.County, A.State, ZipCode, ".
					" A.StreetDirection, StreetSuffix, UnitNo, A.Latitude, A.Longitude, Main_Photo, Category, IF(M.Agent_ID = '".$config['agent_code']."', 0, 1) AS agent_listing, O.Office_Name, ".
                    "(SELECT OH_Date FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_date, ".
                    "(SELECT CONCAT(OH_Date,',',OH_Begins,',',OH_Close) FROM ".$this->Data['MLS_Open_House_Table']." LMOH WHERE M.MLS_NUM = LMOH.MLS_NUM AND M.MLSP_ID = LMOH.MLSP_ID AND LMOH.OH_Date >= CURRENT_DATE() ORDER BY LMOH.OH_Date ASC LIMIT 1) AS open_house_data";
		}

		//if(!defined("IN_ADMIN"))
			//$sql .= ", IF(FIND_IN_SET(M.OfficeID,'".$config['exclude_openhouse_by_officeId']."'), 'N', Is_OpenHouse) AS Is_OpenHouse ";

		$sql .= //", CONCAT('".$this->Pic_Path."', CONCAT(M.MLS_NUM,'-',M.MLSP_ID), '/0') AS Pic_Path".
				" FROM ". $this->Data['TableName']." AS M ".
				" LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Office_Table']." AS O ON M.OfficeID = O.Office_ID AND M.MLSP_ID = O.Office_MLSP_ID".
				" LEFT JOIN ". $this->Data['MLS_Master']." AS MM ON M.MLSP_ID = MM.MLSP_ID ".
				" LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ".
                " LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID ";

        $sql .= " WHERE 1 ".$addParameters;
        //Utility::pre($POST);
				//" WHERE M.MLS_NUM IN ('F1725953', 'F1860700', '07224925', '21436355')".
		if (count($POST['sort_order_list']) > 0)
        {
            $field_order='';
            foreach ($POST['sort_order_list'] as $field => $order)
            {
                $field_order .= $field." ".$order.",";
            }

            $field_order = rtrim($field_order,",");

            $sql .= " ORDER BY ".$field_order;
        }
        else
        {
             $sql .=	" ORDER BY ". ($POST['sort_order'] != ''? ($POST['sort_order'] == 'location' ? 'Subdivision' : $asset['OL_SORTBY_LOOKUP_ARRAY'][$POST['sort_order']]) :$asset['OL_SORTBY_LOOKUP_ARRAY'][DEFAULT_SO]).' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :DEFAULT_SD);
            //$sql .=	" ORDER BY ". ($POST['sort_order'] != ''? ($POST['sort_order'] == 'Address' ? 'StreetNumber,StreetName': $POST['sort_order']) :'ListPrice').' '.($POST['sort_dir'] != ''? $POST['sort_dir'] :'DESC');
        }
        if (!$POST['allRecord'])
			$sql .=  " LIMIT ". $POST['start_record']. ", ". $POST['page_size'];
//echo $sql; die;
        # Show debug info
		if(DEBUG)
			$this->__debugMessage($sql);

		$rs = $db->query($sql);
        //Utility::pre($rs);
		$arr = array();
		$arr['rs'] = array();
		$arr['map-data'] = array();
        while($rs->next_record())
		{
			$row = $rs->Record;

			if($POST['viewType'] != VT_SITE_MAP)
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
				    //$row['MainPicture'] = $this->getPicArray2($row['ListingID_MLS'], $getMainPic=true);
					$row['MainPicture'] = $this->getPicArray2($row['ListingKey'], $row['MLSP_ID'], $getMainPic=true);
                }
				else
				{
					$pic_no = $row['Main_Photo']-1;
					$row['MainPicture'] = $virtual_path['Assets_Url']."/pictures/property/".$row['ListingID_MLS']."/".$pic_no;
				}
			}

			if($POST['getAllPhoto'])
			{
				if($row['mls_is_pic_url_supported'] == 'Yes')
				{
					$PicArr = $this->getPicArray2($row['MLS_NUM'], $row['MLSP_ID'], $getMainPic=false);

					$row['PhotoAll'] = $PicArr;
				}
				else
				{
					$PicArr = $this->getPicArray($row['ListingID_MLS'], $row['TotalPhotos']);

					$row['PhotoAll'] = $PicArr;
				}
			}
            if(isset($row['open_house_data']) && !empty($row['open_house_data']))
            {
                $arr_open = explode(',', $row['open_house_data']);
                $row['OpenHouse_Date'] = $arr_open[0];
                $row['OpenHouse_Begin'] = $arr_open[1];
                $row['OpenHouse_Close'] = $arr_open[2];
            }

			/*if($row['Is_OpenHouse'] == 'Y')
			{
				// Get Open House Detail
				$arrOpenHouse = $this->getOpenHouseData($row['ListingID_MLS']);

				if(is_array($arrOpenHouse))
				{
					$row['arrOpenHouse'] = $arrOpenHouse;
				}
			}*/

			array_push($arr['rs'], $row);
			if($POST['getMapData']/* && $row['Latitude'] > 0*/)
			{
				$rsAttributes = Utility::generateListingAttributes($row);

				$arrTemp = array();
				$arrTemp['Key'] 		= $row['ListingID_MLS'];
				$arrTemp['MLS'] 		= $row['MLS_NUM'];
				$arrTemp['Address'] 	= $rsAttributes['AddressFull'];
				$arrTemp['Address2'] 	= $rsAttributes['AddressSmall'];
				$arrTemp['SFUrl'] 		= $rsAttributes['SFUrl'];
				$arrTemp['Lat'] 		= $row['Latitude'];
				$arrTemp['Long'] 		= $row['Longitude'];
                $arrTemp['CityName'] 	= $row['CityName'];
                $arrTemp['State'] 		= $row['State'];
                $arrTemp['ZipCode'] 	= $row['ZipCode'];
				$arrTemp['Price'] 		= $row['ListPrice'];
                $arrTemp['Type']        = $row['PropertyType'];
                $arrTemp['SubType']     = $row['SubType'];
				$arrTemp['Bed'] 		= $row['Beds'];
				$arrTemp['Bath'] 		= $row['Baths'];
				$arrTemp['Sqft'] 		= $row['SQFT'];
                $arrTemp['Year']        = $row['YearBuilt'];
				$arrTemp['Pic'] 		= $row['MainPicture'];
				$arrTemp['Pic_Path'] 	= $row['Pic_Path'];
				$arrTemp['Url_Support'] = $row['mls_is_pic_url_supported'];
				$arrTemp['OfficeName']	= $row['Office_Name'];
                $arrTemp['PhotoBaseUrl']= $this->Pic_Path;
                $arrTemp['TotalPhotos']	= $row['TotalPhotos'];
                $arrTemp['Photos'] 		= $row['PhotoAll'];
                $arrTemp['PictureArr']  = $row['PhotoAll']['thumb'];
                $arrTemp['sub']         = $row['Subdivision'];
                $arrTemp['HOA']         = $row['HOA_Fee'];
                $arrTemp['status']      = $row['ListingStatus'];
                $arrTemp['DOM']         = $row['DOM'];
                $arrTemp['lotSize']     = $row['LotSize'];

                array_push($arr['map-data'], $arrTemp);
			}
		}

		if(count($arr['map-data']) > 0)
		{
			$arr['map-data'] = base64_encode(gzencode(json_encode($arr['map-data'])));
		}
        else
        {
            $arr['map-data'] = '';
        }

		$arr['total_record'] = $this->total_record;
		$arr['PhotoBaseUrl'] = $this->Pic_Path;

//echo "<pre>";
//print_r($arr);
//echo "</pre>";
        //Utility::pre($arr);
		return $arr;
	}
    public function getPropertyStatisticForDashboard()
    {
        global $db, $config, $user, $usrInfo;

        $Join = '';
        $Join .= " LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID ";
        $param = " AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";

        $sql = " SELECT COUNT(M.MLS_NUM) AS total_listing FROM ".$this->Data['TableName']." M WHERE 1";

        //$sql .= $param;
        $rs = $db->query($sql);
        $rs->next_record();
        $arr['total_listing'] = $rs->f('total_listing');

        $rs->free();

        $sql = " SELECT COUNT(M.MLS_NUM) AS today_total_listing FROM ".$this->Data['TableName']." M ".
                $Join.
                " WHERE 1 AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE()) AND WEEK(ListingDate) = WEEK(CURRENT_DATE()))";

        $rs = $db->query($sql);
        $rs->next_record();
        $arr['today_listing']     =   $rs->f('today_total_listing');
        $rs->free();

        /*$sql = " SELECT COUNT(M.MLS_NUM) AS cur_month_listing FROM ".$this->Data['TableName']." M ".
                " WHERE 1 AND ( MONTH(ListingDate) = MONTH(CURRENT_DATE()) ) AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE)) AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active'
                AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) ";

        $rs = $db->query($sql);
        $rs->next_record();
        $arr['cur_month_listing'] = $rs->f('cur_month_listing');
        $rs->free();*/

        /*$sql = " SELECT COUNT(M.MLS_NUM) AS cur_month_sold FROM ".$this->Data['TableName']." M ".
                $Join.
                " WHERE 1 AND ( MONTH(Sold_Date) = MONTH(CURRENT_DATE())) AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE)) AND is_mark_for_deletion = 'N' AND ListingStatus = 'Closed'
                AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";

        $sql .= $param;
        $rs = $db->query($sql);
        $rs->next_record();
        $arr['cur_month_sold'] = $rs->f('cur_month_sold');
        $rs->free();

        $sql = " SELECT COUNT(M.MLS_NUM) AS cur_month_pending FROM ".$this->Data['TableName']." M ".
                $Join.
                " WHERE 1 AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE)) AND is_mark_for_deletion = 'N' AND ListingStatus = 'Pending'
                AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) ";
        /* AND ( MONTH(ListingDate) = MONTH(CURRENT_DATE())) */
       /* $sql .= $param;
        $rs = $db->query($sql);
        $rs->next_record();
        $arr['cur_month_pending'] = $rs->f('cur_month_pending');

        if($user->User_Perm == AGENT && !empty($agent_code))
        {
            $sql = " SELECT COUNT(M.MLS_NUM) AS cur_Active FROM ".$this->Data['TableName']." M ".
                    " WHERE 1 AND is_mark_for_deletion = 'N' AND ListingStatus = 'Active' ";
            /* AND ( MONTH(ListingDate) = MONTH(CURRENT_DATE())) */
           /* $sql .= $param;
            $rs = $db->query($sql);
            $rs->next_record();
            $arr['cur_Active'] = $rs->f('cur_Active');

            $sql = " SELECT COUNT(M.MLS_NUM) AS yearly_sales FROM ".$this->Data['TableName']." M ".
                    $Join.
                    " WHERE 1 AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE()) OR YEAR(Sold_Date) = YEAR(CURRENT_DATE())) AND is_mark_for_deletion = 'N' AND ListingStatus = 'Closed'";

            $sql .= $param;

            $rs = $db->query($sql);
            $rs->next_record();
            $arr['yearly_sales'] = $rs->f('yearly_sales');
            $rs->free();
        }*/

        return $arr;
    }
    public function getStatisticForChart()
    {
        global $db, $config, $user, $usrInfo, $asset;

        $param = "AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."'))";

        $sql = "SELECT COUNT(MLS_NUM) AS listing_count, PropertyType FROM ".$this->Data['TableName']." M WHERE 1
                AND is_mark_for_deletion = 'N' ";

        $param = " AND PropertyType IN('".str_replace(",", "','",implode(",",$asset['OL_Dashboard_Property_Type']))."')";

        //AND ( MONTH(Listing_Created_Date) = MONTH(CURRENT_DATE))
        $Group_By = " GROUP BY PropertyType";

        //$sql .= $param;
        $sql .= $param;
        $sql .= $Group_By;
        //echo $sql;die;
        $rs = $db->query($sql);
        //Utility::pre($rs);
        while($rs->next_record())
        {
            $arr['listing'][$rs->f('PropertyType')] = $rs->f('listing_count');
            $arr['data'][] = array("ptype" => $rs->f('PropertyType'), "l" => ($rs->f('listing_count') > 0 ? $rs->f('listing_count') : 0));
        }
        $rs->free();

        /*$sql = "SELECT COUNT(M.MLS_NUM) AS sold_count FROM ".$this->Data['TableName']." M
                LEFT JOIN ". $this->Data['Listing_Additional_Info']." AS AI ON M.MLS_NUM = AI.MLS_NUM AND M.MLSP_ID = AI.MLSP_ID
                WHERE 1 AND (ListingStatus = 'Closed'
                AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N'";

       // $Group_By = " GROUP BY MONTH(`Sold_Date`) ";

        $sql .= $param;
        $sql .= $Group_By;


        $rs = $db->query($sql);
        while($rs->next_record())
        {
            $arr['sold'][$rs->f('month')] = $rs->f('sold_count');
        }
        $rs->free();*/

        /*$sql = "SELECT COUNT(MLS_NUM) AS pending_count, MONTH(`ListingDate`) AS month FROM ".$this->Data['TableName']." M WHERE 1 AND ( YEAR(ListingDate) = YEAR(CURRENT_DATE)) AND ListingStatus = 'Pending'
                AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N' ";

        $Group_By = " GROUP BY MONTH(`ListingDate`) ";

        $sql .= $param;
        $sql .= $Group_By;

        $rs = $db->query($sql);
        while($rs->next_record())
        {
            $arr['pending'][$rs->f('month')] = $rs->f('pending_count');
        }*/
        //Utility::pre($arr);
        //$data[] = array($rs->f('PropertyType') => ($rs->f('listing_count') > 0 ? $rs->f('listing_count') : 0));
        /*for($i = 1; $i <= 12; $i++)
        {
            $data[] = array("m" => date('M',mktime(0, 0, 0, $i, 1)), "l" => ($arr['listing'][$i] > 0 ? $arr['listing'][$i] : 0), "s" => ($arr['sold'][$i] > 0 ? $arr['sold'][$i] : 0)/*, "p" => ($arr['pending'][$i] > 0 ? $arr['pending'][$i] : 0)*//*);*/
        /*}*/
        return $arr;
    }
    public function getCityWisePropertyCount($agent_code = '', $short_code = '')
    {
        global $db, $config, $user, $usrInfo;

        $param = '';
        if($user->User_Perm == AGENT && !empty($agent_code))
        {
            if(!empty($short_code))
            {
                $param .= " AND ( ( M.Agent_ID IN ('".$agent_code."') OR M.CoAgent_ID IN ('".$agent_code."')) OR ( M.Agent_ShortID IN ('".$short_code."') OR M.CoAgent_ID IN ('".$short_code."')))";
            }
            else
            {
                $param .= " AND (M.Agent_ID IN ('".$agent_code."') OR M.CoAgent_ID IN ('".$agent_code."'))";
            }
            //$param .= " AND (M.Agent_ID IN ('".$agent_code."') OR M.CoAgent_ID IN ('".$agent_code."'))";
        }

        $sql = " SELECT COUNT(M.MLS_NUM) AS total, (SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND CityName = 'Paradise Valley' AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N' ) ".$param." AS pvalley_count,
                (SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND CityName = 'Scottsdale' AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N') ".$param." AS scottsdale_count,
                (SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND CityName = 'Phoenix' AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N') ".$param." AS phoenix_count,
                (SELECT COUNT(A.MLS_NUM) FROM ".$this->Data['Listing_Address']." A LEFT JOIN ".$this->Data['TableName']." M ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID WHERE 1 AND CityName NOT IN ('Paradise Valley','Scottsdale','Phoenix') AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N') ".$param." AS other_count
                FROM ".$this->Data['TableName']." M WHERE 1 AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND is_mark_for_deletion = 'N'";

        $sql .= $param;

        $rs = $db->query($sql);
        $rs->next_record();
        $arr = $rs->Record;
        return $arr;
    }
    public function getAgentLatestUpdates($limit=5)
    {
        global $db, $config, $user, $usrInfo;

        $param = "";

        $sql = " SELECT M.MLS_NUM, M.MLSP_ID, M.LastUpdateDate,AM.agent_id,  ".
				" ( CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND ListingStatus = 'Active') THEN 'New Listing' 
                WHEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN (CASE WHEN ListingStatus = 'Closed' THEN 'Sold' WHEN ( Price_Diff < 0 AND ListingStatus = 'Active' ) THEN 'Price Drop' WHEN ( Price_Diff > 0 AND ListingStatus = 'Active') THEN 'Price Increase' END) END) AS prop_update, CONCAT_WS(' ', AG.Agent_FName, AG.Agent_LName) AS Agent_FullName
                FROM ".$this->Data['TableName']." M
                LEFT JOIN ". $this->Data['Agent_Table']." AS AG ON M.Agent_ID  = AG.Agent_ID  AND M.MLSP_ID = AG.Agent_MLSP_ID
                LEFT JOIN 	agent_roster_master AS AM ON M.Agent_ID  = AM.agent_code
                WHERE 1 AND (M.OfficeID IN('". $config['mls_office_ids']."') OR M.CoOfficeID IN('". $config['mls_office_ids']."')) AND M.is_mark_for_deletion = 'N' AND ( DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) OR DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ) 
                AND ( CASE WHEN (DATE_FORMAT(Listing_Created_Date, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND ListingStatus = 'Active') THEN 'New Listing' 
                WHEN DATE_FORMAT(LastUpdateDate, '%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN (CASE WHEN ListingStatus = 'Closed' THEN 'Sold' WHEN ( Price_Diff < 0 AND ListingStatus = 'Active' ) THEN 'Price Drop' WHEN ( Price_Diff > 0 AND ListingStatus = 'Active') THEN 'Price Increse' END) END) != ''
                ";
        if($user->User_Perm == AGENT)
        {
            $param .= " AND (M.Agent_ID = '".$usrInfo->Profile['agent_code']."' OR M.CoAgent_ID = '".$usrInfo->Profile['agent_code']."')";
        }

        $order_by = " ORDER BY LastUpdateDate DESC LIMIT 0, ".$limit;

        $sql .= $param.$order_by;
        //echo $sql;die;
        $rs = $db->query($sql);
        return $rs;
    }
	#=========================================================================================================================
	#	Function Name	:   getAddressAutoComplete
	#-------------------------------------------------------------------------------------------------------------------------
	public function getAddressAutoComplete($POST)
	{
		global $config, $db;

		$Parameters	 =	'';

		$arr = array();

		## Quick Search
		if(trim($POST['keywords']) != '')
		{
			$POST['keywords'] = trim($POST['keywords']);

			$ret = preg_match_all("/[a-zA-Z0-9_.-\/]{2,}+/", $POST['keywords'], $keywords);

			#---------------------------------------------------------------------------------------
			# COUNTY SEARCH
			if($POST['type'] == 'County' || $POST['type'] == '')
			{
				$searchFields    = array();
				$searchFields[]  = 'County';

				$fieldsToSearch  = implode(", ", $searchFields);

				//$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);

				//$addParameters   = " AND ". $fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";
				$strSearch       = implode("%' OR $fieldsToSearch LIKE '", $keywords[0]);
				$addParameters   = " AND ( ". $fieldsToSearch. " LIKE '". $strSearch. "%' ) ";
				//$addParameters   = " AND ( M.MLS_NUM LIKE '". $strSearch. "%' ) ";

				$sql             = " SELECT DISTINCT(County) AS County"
					. " FROM ". $this->Data['TableName']." AS M"
					. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
					. " WHERE County != '' AND is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
					. " ORDER BY County";

				if($POST['Limit'] > 0)
					$sql .= " LIMIT 0,".$POST['Limit'];

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);



				$rs = $db->query($sql);

				while($rs->next_record())
				{
					$arr[]  = array('type' => ASTYPE_COUNTY, 'label' => $rs->f('County'));
				}

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				{
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				{
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}

			# ----------------------------------------------------------------------------------
			# CITY SEARCH
			if($POST['type'] == 'Cities' || $POST['type'] == '')
			{
                if($ret == 2){
                    $searchFields    = array();
                    $searchFields[]  = 'CityName';
                    $searchFields[]  = 'State';
                }
				else{
                    $searchFields    = array();
                    $searchFields[]  = 'CityName';
                }

				$fieldsToSearch  = implode(", ", $searchFields);

				/*$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
				$addParameters   = " AND ". $fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";*/


                $ret = preg_match_all("/[a-zA-Z0-9_.-\/#&()]+/", $POST['keywords'], $keywords);

                if($ret == 2){

                    $addParameters   = " AND  ( CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '%".$POST['keywords'] . "%') ";
                }
                else{
                    $addParameters   = " AND $fieldsToSearch LIKE '%".$POST['keywords'] . "%' ";
                }

				if($POST['PropertyType'] != '')
					$addParameters .= " AND PropertyType = '".$POST['PropertyType']."'";
				elseif($POST['Not_PropertyType'] != '')
					$addParameters .= " AND PropertyType != '".$POST['Not_PropertyType']."'";

				$sql    =  "SELECT DISTINCT(CityName) AS CityName ,State"
							. " FROM ". $this->Data['TableName']." AS M"
							. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
							. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
							. " ORDER BY CityName";

				if($POST['Limit'] > 0)
					$sql .= " LIMIT 0,".$POST['Limit'];


				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$rs = $db->query($sql);

				while($rs->next_record())
				{
					$arr[]  = array('type' => ASTYPE_CITY, 'label' =>  $rs->f('CityName').', '.strtoupper($rs->f('State')));
				}

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				{
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				{
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}
			#-------------------------------------------------------------------------------
			# ZipCode SEARCH
			if($POST['type'] == 'Zip' || $POST['type'] == '')
			{
				$searchFields    = array();
				$searchFields[]  = 'ZipCode';

				$fieldsToSearch  = implode(", ", $searchFields);

				//$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
				//$addParameters   = " AND ".$fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";

				$strSearch       = implode("%' OR $fieldsToSearch LIKE '", $keywords[0]);
				$addParameters   = " AND ( ". $fieldsToSearch. " LIKE '". $strSearch. "%' ) ";


				if($POST['PropertyType'] != '')
					$addParameters .= " AND PropertyType = '".$POST['PropertyType']."'";
				elseif($POST['Not_PropertyType'] != '')
					$addParameters .= " AND PropertyType != '".$POST['Not_PropertyType']."'";

				$sql             = " SELECT DISTINCT(ZipCode) AS ZipCode"
					. " FROM ". $this->Data['TableName']." AS M"
					. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
					. " WHERE ZipCode != '' AND is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active' ". $addParameters
					. " ORDER BY ZipCode";

				if($POST['Limit'] > 0)
					$sql .= " LIMIT 0,".$POST['Limit'];

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$rs = $db->query($sql);

				while($rs->next_record())
				{
					$arr[]  = array('type' => ASTYPE_ZIP, 'label' => $rs->f('ZipCode'));
				}

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				{
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				{
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}

			# ---------------------------------------------------------------------------------
			# Area
			if($POST['type'] == 'Area' || $POST['type'] == '')
			{
				$searchFields    = array();
				$searchFields[]  = 'Subdivision';

				$fieldsToSearch  = implode(", ", $searchFields);

				//$strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP ' ", $keywords[0]);

				//$addParameters   = " AND " .$fieldsToSearch. " REGEXP '". $strSearch. "' ";

				$strSearch       = implode("%' OR $fieldsToSearch LIKE '", $keywords[0]);
				$addParameters   = " AND ( ". $fieldsToSearch. " LIKE '". $strSearch. "%' ) ";

				if($POST['PropertyType'] != '')
					$addParameters .= " AND PropertyType = '".$POST['PropertyType']."'";
				elseif($POST['Not_PropertyType'] != '')
					$addParameters .= " AND PropertyType != '".$POST['Not_PropertyType']."'";

				$sql             = "SELECT DISTINCT(Subdivision) AS Subdivision "
					. " FROM ". $this->Data['TableName']." AS M"
					. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
					. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
					. " ORDER BY Subdivision";

				if($POST['Limit'] > 0)
					$sql .= " LIMIT 0,".$POST['Limit'];

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$rs = $db->query($sql);

				while($rs->next_record())
				{
					$arr[]  = array('type' => ASTYPE_AREA, 'label' => $rs->f('Subdivision'));
				}

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				{
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				{
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}

			#---------------------------------------------------------------------------------------
			# School District SEARCH
			/* if($POST['type'] == 'Schools' || $POST['type'] == '')
			 {
				 $searchFields    = array();
				 $searchFields[]  = 'School_District';

				 $fieldsToSearch  = implode(", ", $searchFields);

				 $strSearch       = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
				 $addParameters   = " AND ". $fieldsToSearch. " REGEXP '[[:<:]]". $strSearch. "' ";

				 $sql             = "SELECT DISTINCT(School_District) AS School_District "
								 . " FROM ". $this->Data['TableName']." AS M"
								 . "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
								 . " WHERE is_mark_for_deletion = 'N'". $addParameters
								 . " ORDER BY School_District";

				 if($POST['Limit'] > 0)
					 $sql .= " LIMIT 0,".$POST['Limit'];

				 # Show debug info
				 if(DEBUG)
					 $this->__debugMessage($sql);

				 $rs = $db->query($sql);

				 while($rs->next_record())
				 {
					 $arr[]  = array('type' => ASTYPE_SCHOOL, 'label' => $rs->f('School_District'));
				 }
				 if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				 {
					 return $arr;
				 }
				 elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				 {
					 $POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				 }
			 }*/

			#---------------------------------------------------------------------------------------
			# ADDRESS SEARCH
			if($POST['type'] == 'Address' || $POST['type'] == '')
			{
				$searchFields   = array();
				$searchFields[] = 'StreetNumber';
				$searchFields[] = 'StreetName';

				$fieldsToSearch = implode(", ", $searchFields);

				/*$strSearch      = implode("' OR CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]", $keywords[0]);
				$addParameters  = " AND ( CONCAT_WS(', ',". $fieldsToSearch. ") REGEXP '[[:<:]]". $strSearch. "') ";*/

				$strSearch      = implode("%' OR CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '", $keywords[0]);
				$addParameters  = " AND ( CONCAT_WS(', ',". $fieldsToSearch. ") LIKE '". $strSearch. "%') ";

				if($POST['PropertyType'] != '')
					$addParameters .= " AND PropertyType = '".$POST['PropertyType']."'";
				elseif($POST['Not_PropertyType'] != '')
					$addParameters .= " AND PropertyType != '".$POST['Not_PropertyType']."'";

				$sql            = "SELECT DISTINCT(CONCAT_WS(', ', CONCAT_WS(' ', StreetNumber, StreetName), CityName, State)) AS address "
					. " FROM ". $this->Data['TableName']." AS M"
					. "	LEFT JOIN ". $this->Data['Listing_Address']." AS A ON M.MLS_NUM = A.MLS_NUM AND M.MLSP_ID = A.MLSP_ID"
					. " WHERE StreetNumber != '' AND is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
					. " ORDER BY address";

				if($POST['Limit'] > 0)
					$sql    .= " LIMIT 0,".$POST['Limit'];

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$rs = $db->query($sql);

				while($rs->next_record())
				{
					$arraddress = $rs->f('address');
					$strReplace = str_replace(', ,', ',', $arraddress);
					$MLS = $rs->f('ListingID_MLS');

					$arr[]  =  array('type' => ASTYPE_ADD, 'label' => $strReplace, 'ListingID_MLS' => $MLS);
				}

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				{
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				{
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}

			# ----------------------------------------------------------------------------------
			# MLS SEARCH
			if($POST['type'] == 'MLS' || $POST['type'] == '')
			{
				$strSearch       = implode("%' OR M.MLS_NUM LIKE '", $keywords[0]);
				$addParameters   = " AND ( M.MLS_NUM LIKE '". $strSearch. "%' ) ";

				if($POST['PropertyType'] != '')
					$addParameters .= " AND PropertyType = '".$POST['PropertyType']."'";
				elseif($POST['Not_PropertyType'] != '')
					$addParameters .= " AND PropertyType != '".$POST['Not_PropertyType']."'";

				$sql             = " SELECT DISTINCT(MLS_NUM) AS MLS_NUM"
					. " FROM ". $this->Data['TableName']." AS M"
					. " WHERE is_mark_for_deletion = 'N' AND M.ListingStatus = 'Active'". $addParameters
					. " ORDER BY MLS_NUM";

				if($POST['Limit'] > 0)
					$sql .= " LIMIT 0,".$POST['Limit'];

				# Show debug info
				if(DEBUG)
					$this->__debugMessage($sql);

				$rs = $db->query($sql);

				while($rs->next_record())
				{
					$arr[]  = array('type' => ASTYPE_MLS, 'label' => $rs->f('MLS_NUM'));
				}

				if(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) == 0)
				{
					return $arr;
				}
				elseif(($POST['Limit'] > 0) && ($POST['Limit'] - $rs->TotalRow) > 0)
				{
					$POST['Limit'] = $POST['Limit'] - $rs->TotalRow;
				}
			}
		}
		return $arr;
	}
	function InsertUpdateCountyCityBoundary($data){
		global $db;
		if(isset($data['arrResult'])){
			$arrArea = $data['arrResult'];
		}else{
			unset($data['arrResult']);
		}

		if(is_array($data['arrData']) && count($data['arrData']) > 0)
		{

			foreach($data['arrData'] as $key => $value)
			{
				if(isset($value['boundary']))
				{
					$boundary = $value['boundary'];
				}
				else
				{
					$boundary = '';
				}

				$arrTemp    = array();

				/*$arrTemp['obacp_id'] =   isset($value->id)?$value->id:(isset($arrArea[$value->id]['obacp_id'])?$arrArea[$value->id]['obacp_id']:'');
				$arrTemp['obacp_geo_key']   = isset($value->geo_key)?$value->geo_key:(isset($arrArea[$value->id]['obacp_geo_key'])?$arrArea[$value->id]['obacp_geo_key']:'');
				$arrTemp['obacp_name']   = isset($value->name)?addslashes(stripslashes($value->name)):(isset($arrArea[$value->id]['obacp_name'])?addslashes(stripslashes($arrArea[$value->id]['obacp_name'])):'');
				$arrTemp['obacp_type']   = isset($value->type)?$value->type:(isset($arrArea[$value->id]['obacp_type'])?$arrArea[$value->id]['obacp_type']:'');
				$arrTemp['obacp_area']   = isset($value->area)?$value->area:(isset($arrArea[$value->id]['obacp_area'])?$arrArea[$value->id]['obacp_area']:'');
				$arrTemp['obacp_state_id']   = isset($value->obacp_state_id)?$value->obacp_state_id:(isset($arrArea[$value->id]['obacp_state_id'])?$arrArea[$value->id]['obacp_state_id']:'');
				$arrTemp['obacp_boundary']   = $boundary;//$boundary;
				$arrTemp['obacp_geo_center'] = (isset($value->geo_center_latitude) && isset($value->geo_center_longitude))?$value->geo_center_latitude.','.$value->geo_center_longitude:'';*/
				$arrTemp['obacp_id'] = isset($value['id'])?$value['id']:isset($arrArea[$value['id']]['obacp_id'])?$arrArea[$value['id']]['obacp_id']:'';
				$arrTemp['obacp_geo_key']   = isset($value['geo_key'])?$value['geo_key']:isset($arrArea[$value['id']]['obacp_geo_key'])?$arrArea[$value['id']]['obacp_geo_key']:'';
				$arrTemp['obacp_name']   = isset($value['name'])?addslashes(stripslashes($value['name'])):isset($arrArea[$value['id']]['obacp_name'])?addslashes(stripslashes($arrArea[$value['id']]['obacp_name'])):'';
				$arrTemp['obacp_type']   = isset($value['type'])?$value['type']:isset($arrArea[$value['id']]['obacp_type'])?$arrArea[$value['id']]['obacp_type']:'';
				$arrTemp['obacp_area']   = isset($value['obacp_area'])?$value['obacp_area']:isset($arrArea[$value['id']]['obacp_area'])?$arrArea[$value['id']]['obacp_area']:'';
				$arrTemp['obacp_state_id']   = isset($value['obacp_state_id'])?$value['obacp_state_id']:isset($arrArea[$value['id']]['obacp_state_id'])?$arrArea[$value['id']]['obacp_state_id']:'';
				$arrTemp['obacp_boundary']   = $boundary;//$boundary;
				$arrTemp['obacp_geo_center'] = (isset($value['geo_center_latitude']) && isset($value['geo_center_longitude']))?$value['geo_center_latitude'].','.$value['geo_center_longitude']:'';

				$County_data[] = "'".implode("','", $arrTemp)."'";

			}

			$values = implode("), (", $County_data);

			$sql = "INSERT INTO ".$this->Data['Onboard_County_Place']."
            (obacp_id,  obacp_geo_key,obacp_name ,obacp_type, obacp_area , obacp_state_id,obacp_boundary,obacp_geo_center)
                VALUES (".$values.") ON DUPLICATE KEY UPDATE obacp_boundary=VALUES(obacp_boundary) ,obacp_geo_center=VALUES(obacp_geo_center)";
//			file_put_contents('query.txt',print_r($sql,true));

			$db->query($sql);

		}
	}
	function InsertUpdateCountyCityData($data){
		global $db;

		if(is_array($data) && count($data) > 0)
		{

			$values = implode("), (", $data);
//			file_put_contents('post.txt',print_r($values,true));exit;
			$sql = " INSERT INTO ".$this->Data['Onboard_County_Place']." 
            (obacp_id,  obacp_geo_key,obacp_name ,obacp_type, obacp_area , obacp_state_id)
                VALUES (".$values.") ON DUPLICATE KEY UPDATE obacp_id=VALUES(obacp_id) ,obacp_geo_center=VALUES(obacp_geo_center) ,obacp_name=VALUES(obacp_name) ,obacp_type=VALUES(obacp_type) ,obacp_area=VALUES(obacp_area), obacp_state_id=VALUES(obacp_state_id)";

			$db->query($sql);
		}
	}
	function getCountyCityData($POST){
		global $db;
		$arr = array();
		$Parameters = '';

		if(isset($POST['obacp_type']))
		{
			$Parameters .= " AND obacp_type = '".$POST['obacp_type']."'";
		}
		if(isset($POST['empty_obacp_boundary']) && $POST['empty_obacp_boundary'] == true)
		{
			$Parameters .= " AND obacp_boundary IS NULL";
		}
		if(isset($POST['obacp_name']) && $POST['obacp_name'] != '')
		{
			$Parameters .= " AND obacp_name LIKE '".$POST['obacp_name']."'";
		}
		if(isset($POST['obacp_state_id']) && $POST['obacp_state_id'] != '')
		{
			$Parameters .= " AND obacp_state_id = '".$POST['obacp_state_id']."'";
		}
		if(isset($POST['obacp_geo_state_id']) && $POST['obacp_geo_state_id'] != '')
		{
			$Parameters .= " AND obacp_geo_state_id = '".$POST['obacp_geo_state_id']."'";
		}

		$sql = "SELECT *  FROM ".$this->Data['Onboard_County_Place']."  WHERE 1 ".$Parameters;

		$sql .= " ORDER BY obacp_state_id ";

		if(isset($POST['limit']) && $POST['limit'] > 0)
			$sql .= " LIMIT 0, ".$POST['limit'];

//		file_put_contents('post_lglt.txt',print_r($sql,true));
		$rs = $db->query($sql);

		//file_put_contents('post_lglt_rs.txt',print_r($rs,true));
		while($rs->next_record())
		{
			$arr[$rs->f('obacp_geo_key')]  = $rs->Record;
			$arr['boundary'] =  $rs->f('obacp_boundary');
		}

		return $arr;
	}
}
?>