<?php
/**
* @file /db_access/ProductMaster.php
*/
class ProductMaster extends DB_Custom
{
    public static $Instance;
    public $ProductID;
    public $ProductInfo;

    public static function obj($isPopulateSchema=false)
    {
        if(!is_object(self::$Instance))
                self::$Instance = new self($isPopulateSchema);

        return self::$Instance;
    }
    public function __construct($isPopulateSchema=false)
    {
        global  $config, $physical_path, $virtual_path;

        # set Database Connection
        $this->DBC  =   &DBc::$obj;

        # Table name
        $this->Data[TABLE_NAME]             =   $config[TABLE_PREFIX].'product_master';

        # Field Prefix
        $this->Data[FIELD_PREFIX]           =   'product_';

        # 2016/02/01/image-name.jpg
        # Primery Field Info
        $this->Data[F_P_KEY]                =   $this->Data[FIELD_PREFIX].'id';
        $this->Data[F_F_KEY]                =   $this->Data[FIELD_PREFIX].'psg_id';
	    $this->Data[F_P_FIELD]              =   $this->Data[FIELD_PREFIX].'name';
        $this->Data[F_ACTIVE]               =   $this->Data[FIELD_PREFIX].'is_active';
        $this->Data[F_S_URL]                =   $this->Data[FIELD_PREFIX].'safe_url';
        $this->Data[F_ADDED_DATETIME]       =   $this->Data[FIELD_PREFIX].'added_datetime';

        $this->Data[P_UP]                   =   $physical_path['Upload'].'/product';
        $this->Data[V_UP]                   =   $virtual_path['Upload'].'/product';
	    $this->Data['ENC_V_UP']             =   $virtual_path['ENC_Upload'].'/product';
        # Image size must be > 700 and less then 800
        $this->Data['IMG_SIZE']             =   array('MIN'=>'700','MAX'=>'1200');
        # Image size must be in ascending order
        //$this->Data['IMG_SIZE']             =   array('800x800','1200x1200');

        $this->Data['IMG_NAME_SIZE']        =   '5';
        $this->Data['IMPORT_ROOT']          =   $physical_path['Upload'].'/temp';

        $this->Data[F_D_FIELD]              =   array(
		                                            );
        $this->Data['ScriptName']           =   'product-master.html';

        $this->SetFieldMapping();

        # Initialize parent class
        parent::__construct();
    }
    public function populateSchema()
    {
        global $asset, $config, $physical_path, $virtual_path;

        # Module title
        $this->Data[L_MODULE]               =   'Product Master';

        # Help Text
        $this->Data[H_MANAGE]               =   'Manage Product Master information.';
        $this->Data[H_ADD_EDIT]             =   'Update Product Master information ';/*and click <b>Save</b> to save the changes.
                                                Click <b>Cancel</b> to discard the changes. ';*/
        # Field information
        $this->Data[F_H_ITEM]               =
            array(
                    );

        # Field information
        $this->Data[F_F_INFO]                   =
            array();

        # Do not allow some users to access some data
        if(defined('IN_ADMIN') && !defined("IN_CRON") && !defined("IN_ASSETS") && AdminMaster::obj()->Role[AdminRole::obj()->Data[F_P_KEY]] == ADMINROLE_SEO)
        {
            unset($this->Data[F_H_ITEM]['product_info']);
            unset($this->Data[F_H_ITEM]['price']);
            unset($this->Data[F_H_ITEM]['catalog_info']);
            unset($this->Data[F_H_ITEM]['Mfg/supp']);
            unset($this->Data[F_H_ITEM]['other']);

            unset($this->Data[F_F_INFO]['is_hot_favourite']);
            unset($this->Data[F_F_INFO]['is_active']);
            unset($this->Data[F_F_INFO]['is_ready_to_dispatch']);
            unset($this->Data[F_F_INFO]['is_featured']);
            unset($this->Data[F_F_INFO]['weight']);
            unset($this->Data[F_F_INFO]['CatalogInformation']);
            unset($this->Data[F_F_INFO]['sku']);
            unset($this->Data[F_F_INFO]['space']);
            unset($this->Data[F_F_INFO]['quantity']);
            unset($this->Data[F_F_INFO]['image_type']);
            unset($this->Data[F_F_INFO]['price']);
            unset($this->Data[F_F_INFO]['max_retail_price']);
            unset($this->Data[F_F_INFO]['selling_price']);
            unset($this->Data[F_F_INFO]['manufacturer_id']);
            unset($this->Data[F_F_INFO]['supplier_id']);
        }

        $this->Data[F_F_INFO] = array_merge($this->Data[F_F_INFO], Utility::setSEOFieldInfo());
    }
	public function SystemSKU($type, $id)
	{
		$prefix =   'TE';

		if($type == 'E')
			return Ocrypt::encodeNumber($id,$prefix,759,2);
		elseif($type == 'D')
            return Ocrypt::decodeNumber(strtoupper($id),$prefix,759,2);

		return false;
	}
    public function SetFieldMapping()
    {
        global $asset;

        # Set sort order
        $this->Data[SO] = array(
            1 => $this->Data[FIELD_PREFIX].'added_datetime',
            2 => $this->Data[FIELD_PREFIX].'selling_price',
            3 => $this->Data[FIELD_PREFIX].'view_count'
        );

        # Sort direction
        $this->Data[SD] = &$asset['OL_SortDirection'];

        # Set search filter list
        $this->Data['LP_S_FBASIC'] = array(
            SURL_QUERY, QP_CATEGORY, QP_BRAND, QP_PRICE, QP_DISCOUNT, QP_TAG, QP_EXCLUDE_OUT_OF_STOCK
        );
        $this->Data['LP_S_FADVANCED'] = array(
            QP_FEATURE
        );

        # Set search criteria list
        $this->Data['LP_S_CRITERIA'] = array(
            GO_TO_PAGE, SO, SD, LISTING_VIEW_TYPE
        );

        # Set all search params
        $this->Data['LP_S_PARAMS'] = array_merge($this->Data['LP_S_FBASIC'], $this->Data['LP_S_FADVANCED'], $this->Data['LP_S_CRITERIA']);
    }
    public function getSearchFilter()
    {
        # Date Period fields
        $this->Data['PeriodChoice']	=	array(
            ''			=>	'All &nbsp;',
            'Month'		=>	'This Month',
            'Week'		=>	'This Week',
            'Today'		=>	'For Today',
            'Specify'	=>	'Specify Period',
        );

        # filter data
        $this->Data['FilterData']	=
            array(  'PeriodChoice'      =>  $this->Data['PeriodChoice'],
                    'IsDateTime'		=>  true);

        return $this->Data['FilterData'];
    }
    /**
     * This is a gateway to check and allow search params which are available for end user on web site
    **/
    public function setQueryParameters($POST, $DATA=false)
    {
        global $config, $asset;

        $FILTER = $POST;

        # Dot not include out of stock product in listing unless user want to see it
        if(!isset($POST[QP_EXCLUDE_OUT_OF_STOCK]) || (isset($POST[QP_EXCLUDE_OUT_OF_STOCK]) && !in_array($POST[QP_EXCLUDE_OUT_OF_STOCK], array_keys($asset['OL_YesNo']))))
            $FILTER[QP_EXCLUDE_OUT_OF_STOCK] = YES;

        ################################################################################################
        # Check for any predefined search params. If it is then set its criteria as search filter
        # Keep predefined search condition at the end of all params
        if(isset($POST[SURL_PREDEFINED_SEARCH]) && !empty($POST[SURL_PREDEFINED_SEARCH]) && is_array($DATA))
        {
            if(isset($DATA[PredefinedSearch::obj()->Data[FIELD_PREFIX].'criteria']) && !empty($DATA[PredefinedSearch::obj()->Data[FIELD_PREFIX].'criteria']))
            {
                # Unserialize and decode predefined search criteria
                $criteria   =   @unserialize(base64_decode($DATA[PredefinedSearch::obj()->Data[FIELD_PREFIX].'criteria']));

                # Merge(combine) arrParams and arr of predefined search criteria
                if(is_array($criteria) && count($criteria) > 0)
                {
                    # If any filter is set then replace those criteria params with filter params
                    if(is_array($FILTER) && count($FILTER) > 0)
                        $FILTER  =   array_merge($criteria,$FILTER);
                    # No filter found so pass entire cretria
                    elseif($FILTER == false)
                        $FILTER  =   $criteria;
                }
            }
        }

        ################################################################################################
        # Check for any params related with listing view type or page number to load listing or start records etc
        $FILTER[GO_TO_PAGE]         =   (isset($POST[GO_TO_PAGE]) && intval($POST[GO_TO_PAGE]) > 0)?(intval($POST[GO_TO_PAGE])-1):0;
        $FILTER[P_SIZE]             =   $_SESSION[P_SIZE]   =   RESULT_PAGESIZE;
        $FILTER[S_RECORD]           =   $_SESSION[S_RECORD] =   ($FILTER[GO_TO_PAGE] * $FILTER[P_SIZE]);
        $FILTER['last_record_num']  =   (($FILTER[GO_TO_PAGE]+1) * $FILTER[P_SIZE]);
        $FILTER[LISTING_VIEW_TYPE]  =   (isset($POST[LISTING_VIEW_TYPE]) && in_array($POST[LISTING_VIEW_TYPE],array_keys($asset['OL_VIEW_BY'])) )?$POST[LISTING_VIEW_TYPE]:LVT_GRID;

        $FILTER[SO]                 =   (isset($POST[SO]) && $POST[SO] != '' && array_key_exists($POST[SO],$this->Data[SO]))?$POST[SO]:1;
        $FILTER[SD] 		        =   (isset($POST[SD]) && in_array($POST[SD],array_keys($asset['OL_SortDirection'])) )?$POST[SD]:'d';

        # Set search by filter based on so and sd
        $FILTER[SO.'_'.SD]        =   $FILTER[SO].":".$FILTER[SD];

        return $FILTER;
    }
    public function setQueryParametersForUrlOnly($POST, $DATA=false)
    {
        $FILTER = $this->setQueryParameters($POST, $DATA);
        foreach($this->Data['LP_S_FBASIC'] as $k=>$surl)
        {
            if(isset($FILTER[$surl]) && (!isset($POST[$surl]) || (isset($POST[$surl]) && $POST[$surl] == '')))
                unset($FILTER[$surl]);
        }
        foreach($this->Data['LP_S_CRITERIA'] as $k=>$surl)
        {
            if(isset($FILTER[$surl]) && (!isset($POST[$surl]) || (isset($POST[$surl]) && $POST[$surl] == '')))
                unset($FILTER[$surl]);
        }
        return $FILTER;
    }
    public function getQueryParameters($POST=false)
    {
        $Parameters = '';
        $value      = array();

        if(is_array($POST))
            $this->filter = $POST;

        if(isset($this->filter[QP_EXCLUDE_OUT_OF_STOCK]) && $this->filter[QP_EXCLUDE_OUT_OF_STOCK] == YES)
        {
            if(defined('IN_ADMIN'))
            {
                $Parameters .= " AND MTBL.product_quantity > ? ";
            }
            else
            {
                $Parameters .= " AND (SELECT SUM(SPM.product_quantity) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY].") > ? ";
            }

            $value[] = '0';
        }
        if(isset($this->filter[QP_CATEGORY]) && !empty($this->filter[QP_CATEGORY]))
        {
            if(is_array($this->filter[QP_CATEGORY]))
                $temp = $this->filter[QP_CATEGORY];
            else
                $temp = explode(',', $this->filter[QP_CATEGORY]);

            if(is_array($temp) && count($temp) > 0)
            {
                $Parameters .= " AND PCM.".CategoryMaster::obj()->Data[F_S_URL]." IN (".rtrim(str_repeat('?,',(count($temp))),',').")";
                $value = array_merge($value,array_values($temp));
            }
        }
        /*if(isset($this->filter[QP_PTYPE]) && !empty($this->filter[QP_PTYPE]))
        {
            $Parameters .= " AND PTM.".ProductTypeMaster::obj()->Data[F_S_URL]." = ? ";
            $value[] = $this->filter[QP_PTYPE];
        }*/

        if(isset($this->filter[QP_PRICE]) && $this->filter[QP_PRICE] != '')
        {
            if(is_array($this->filter[QP_PRICE]))
                $range = $this->filter[QP_PRICE];
            else
            {
                if(strpos($this->filter[QP_PRICE],'-') == false)
                    $this->filter[QP_PRICE].'-';

                $range = explode('-', $this->filter[QP_PRICE]);
            }

            $from_real_price = is_numeric($range[0])?$range[0]:0;
            $to_real_price   = isset($range[1])?$range[1]:0;

            if(is_numeric($from_real_price) &&  $to_real_price == 0)
            {
                $Parameters .= " AND MTBL.product_selling_price >= ? ";
                $value[] = $from_real_price;
            }
            elseif(is_numeric($from_real_price) && is_numeric($to_real_price))
            {
                $Parameters .= " AND product_selling_price BETWEEN ? AND ? ";
                $value[] = $from_real_price;
                $value[] = $to_real_price;
            }
        }

        if(isset($this->filter[QP_DISCOUNT]) && $this->filter[QP_DISCOUNT] != '')
        {
            if(is_array($this->filter[QP_DISCOUNT]))
                $range = $this->filter[QP_DISCOUNT];
            else
            {
                if(strpos($this->filter[QP_DISCOUNT],'-') == false)
                    $this->filter[QP_DISCOUNT].'-';

                $range = explode('-', $this->filter[QP_DISCOUNT]);
            }

            $from_discount = is_numeric($range[0])?$range[0]:0;
            $to_discount   = isset($range[1])?$range[1]:0;

            if(is_numeric($from_discount) && $to_discount == 0)
            {
                $Parameters .= " AND MTBL.product_discount >= ? ";
                $value[] = $from_discount;
            }
            elseif(is_numeric($from_discount) && is_numeric($to_discount))
            {
                $Parameters .= " AND product_discount BETWEEN ? AND ? ";
                $value[] = $from_discount;
                $value[] = $to_discount;
            }
        }
        if(isset($this->filter[QP_BRAND]) && $this->filter[QP_BRAND] != '')
        {
            if(is_array($this->filter[QP_BRAND]))
                $temp = $this->filter[QP_BRAND];
            else
                $temp = explode(',', $this->filter[QP_BRAND]);

            if(is_array($temp) && count($temp) > 0)
            {
                $Parameters .= " AND BM.".BrandMaster::obj()->Data[F_S_URL]." IN (".rtrim(str_repeat('?,',(count($temp))),',').")";
                $value = array_merge($value,array_values($temp));
            }
        }
        if(isset($this->filter[QP_TAG]) && $this->filter[QP_TAG] != '')
        {
            if(is_array($this->filter[QP_TAG]))
                $temp = $this->filter[QP_TAG];
            else
                $temp = explode(',', $this->filter[QP_TAG]);

            if(is_array($temp) && count($temp) > 0)
            {
                $Parameters .= " AND PT.".ProductTag::obj()->Data[F_P_FIELD]." IN (".rtrim(str_repeat('?,',(count($temp))),',').")";
                $value = array_merge($value,array_values($temp));
            }
        }
        if(isset($this->filter['sku']) && !empty($this->filter['sku']))
        {
            if(is_array($this->filter['sku']))
                $temp = $this->filter['sku'];
            else
                $temp = explode(',', $this->filter['sku']);

            if(is_array($temp) && count($temp) > 0)
            {
                /*$Parameters .= " AND MTBL.product_sku IN (".rtrim(str_repeat('?,',(count($temp))),',').")";
                $value = array_merge($value,array_values($temp));*/
                foreach($temp as $Key=>$val)
                    $new[] = " product_sku LIKE '%".$val."%'";

                $temp_q = implode(' OR ',$new);
                $Parameters .=  " AND (".$temp_q.")";
            }
        }
        if(isset($this->filter['te_sku']) && !empty($this->filter['te_sku']))
        {
            if(is_array($this->filter['te_sku']))
                $temp = $this->filter['te_sku'];
            else
                $temp = explode(',', $this->filter['te_sku']);

            if(is_array($temp) && count($temp) > 0)
            {
                foreach($temp AS $key => $val)
                {
                    $product_id[] = $this->SystemSKU('D',$val);
                }
                $Parameters .= " AND MTBL.".$this->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($product_id))),',').")";
                $value = array_merge($value,array_values($product_id));
            }
        }

        if(isset($this->filter['is_active']) && !empty($this->filter['is_active']))
        {
            $Parameters .= " AND MTBL.product_is_active = ? ";
            $value[] = $this->filter['is_active'];
        }
        if(((isset($this->filter[QP_CATEGORY]) && !empty($this->filter[QP_CATEGORY])) || (isset($this->filter[SURL_QUERY]) && !empty($this->filter[SURL_QUERY]))) && isset($this->filter[QP_FEATURE]) && is_array($this->filter[QP_FEATURE]) && count($this->filter[QP_FEATURE]) > 0)
        {
            foreach($this->filter[QP_FEATURE] as $feature => $feature_info)
            {
                if(!is_array($feature_info))
                    $feature_info = array($feature_info);
                //if(is_array($feature_info) && count($feature_info) > 0){$f[] = $feature; $fv  = array_merge($fv, $feature_info);}
                if($feature != '' && is_array($feature_info) && count($feature_info) > 0)
                {
	                $Parameters .= " AND
                    (
                        SELECT COUNT(*) FROM ".ProductFeature::obj()->Data[TABLE_NAME]." WPF
                        WHERE WPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                        AND WPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                        AND WPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($feature_info))),',').")
                    ) = 1 ";

                    $value[] = $feature;
                    $value = array_merge($value,array_values($feature_info));
                }
            }

            # Below conditions fro features might need to be change as it is related with product feature table.
            # These might change and search will be possible with feature master and feature value master
            /*if(count($f) > 0 && count($fv) > 0)
            {
                if(is_array($f) && count($f) > 0)
                {
                    $Parameters .= " AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." IN (".rtrim(str_repeat('?,',(count($f))),',').")";
                    $value = array_merge($value,array_values($f));

                    //$Parameters .= " AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." IN ('".implode("','",$f)."')";
                }

                if(is_array($fv) && count($fv) > 0)
                {
                    //$Parameters .= " AND PF."ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($fv))),',').")";
                    //$value = array_merge($value,array_values($fv));
                    $Parameters .= " AND PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN ('".implode("','",$fv)."')";
                }
            }*/
        }

        # Allow only admin to search with some filter
        if(defined('IN_ADMIN'))
        {
            if(isset($this->filter['name']) && !empty($this->filter['name']))
            {
                $Parameters .= " AND MTBL.product_name LIKE ? ";
                $value[] = "%".trim($this->filter['name'])."%";
            }
            if(isset($this->filter['weight']) && !empty($this->filter['weight']))
            {
                $Parameters .= " AND product_weight = ? ";
                $value[] = $this->filter['weight'];
            }
            if(isset($this->filter['psg_id']) && !empty($this->filter['psg_id']))
            {
                if(!is_numeric($this->filter['psg_id']))
                    $this->filter['psg_id'] = ProductStyleGroup::obj()->StyleGroupId('D', $this->filter['psg_id']);

                $Parameters .= " AND product_psg_id = ? ";
                $value[] = $this->filter['psg_id'];
            }
            if(isset($this->filter['group_id']) && !empty($this->filter['group_id']))
            {
                $Parameters .= " AND product_group_id = ? ";
                $value[] = $this->filter['group_id'];
            }
            if(isset($this->filter['stockout_by']) && !empty($this->filter['stockout_by']))
            {
                $Parameters .= " AND MTBL.product_stockout_by = ? ";
                $value[] = $this->filter['stockout_by'];
            }
            /*if(isset($this->filter['ptag_safe_url']) && !empty($this->filter['ptag_safe_url']))
            {
                if(is_array($this->filter['ptag_safe_url']))
                    $temp = $this->filter['ptag_safe_url'];
                else
                    $temp = explode(',', $this->filter['ptag_safe_url']);

                if(is_array($temp) && count($temp) > 0)
                {
                    $Parameters .= " AND TM.".TagMaster::obj()->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($temp))),',').")";
                    $value = array_merge($value,array_values($temp));
                }
            }*/
            # If from and to real price is given then manipulate based on (to > from || to <= from || to is empty)
            if(isset($this->filter['from_max_retail_price']) && isset($this->filter['to_max_retail_price']) && intval($this->filter['from_max_retail_price']) && intval($this->filter['to_max_retail_price']) > $this->filter['from_max_retail_price'])
            {
                # to > from
                $Parameters .= " AND MTBL.product_max_retail_price BETWEEN ? AND ? ";
                $value[] = $this->filter['from_max_retail_price'];
                $value[] = $this->filter['to_max_retail_price'];
            }
            elseif(isset($this->filter['from_max_retail_price']) && isset($this->filter['to_max_retail_price']) && intval($this->filter['from_max_retail_price']) && intval($this->filter['to_max_retail_price']) <= $this->filter['from_max_retail_price'])
            {
                # to <= from
                $Parameters .= " AND MTBL.product_max_retail_price >= ? ";
                $value[] = $this->filter['from_max_retail_price'];
            }
            elseif(isset($this->filter['from_max_retail_price']) && intval($this->filter['from_max_retail_price']) && empty($this->filter['to_max_retail_price']))
            {
                # to is empty
                $Parameters .= " AND MTBL.product_max_retail_price = ? ";
                $value[] = $this->filter['from_max_retail_price'];
            }

            if(isset($this->filter['import_batch_number']) && !empty($this->filter['import_batch_number']))
            {
                $Parameters .= " AND product_import_batch_number = ? ";
                $value[] = $this->filter['import_batch_number'];
            }

            if(isset($this->filter['enable_inquiry']) && !empty($this->filter['enable_inquiry']))
            {
                $Parameters .= " AND MTBL.product_enable_inquiry = ? ";
                $value[] = $this->filter['enable_inquiry'];
            }

            if(isset($this->filter['enable_purchase']) && !empty($this->filter['enable_purchase']))
            {
                $Parameters .= " AND MTBL.product_enable_purchase = ? ";
                $value[] = $this->filter['enable_purchase'];
            }
            if(isset($this->filter[BusinessMaster::obj()->Data[F_P_KEY]]) && !empty($this->filter[BusinessMaster::obj()->Data[F_P_KEY]]))
            {
                if(!is_numeric($this->filter[BusinessMaster::obj()->Data[F_P_KEY]]))
                    $this->filter[BusinessMaster::obj()->Data[F_P_KEY]] = Ocrypt::dec($this->filter[BusinessMaster::obj()->Data[F_P_KEY]]);

                if(is_numeric($this->filter[BusinessMaster::obj()->Data[F_P_KEY]]))
                {
                    $Parameters .= " AND MTBL.".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_KEY]." = ? ";
                    $value[] = $this->filter[BusinessMaster::obj()->Data[F_P_KEY]];
                }

                /*if(is_array($this->filter[BusinessMaster::obj()->Data[F_P_KEY]]))
                    $temp = $this->filter[BusinessMaster::obj()->Data[F_P_KEY]];
                else
                    $temp = explode(',', $this->filter[BusinessMaster::obj()->Data[F_P_KEY]]);

                if(is_array($temp) && count($temp) > 0)
                {
                    $Parameters .= " AND BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($temp))),',').")";
                    $value = array_merge($value,array_values($temp));
                }*/

            }
            if(isset($this->filter['group_name']) && !empty($this->filter['group_name']))
            {
                $Parameters .= " AND MTBL.product_group_name LIKE ? ";
                $value[] = "%".trim($this->filter['group_name'])."%";
            }
            if(isset($this->filter['group_design_number']) && !empty($this->filter['group_design_number']))
            {
                $Parameters .= " AND MTBL.product_group_design_number LIKE ? ";
                $value[] = "%".trim($this->filter['group_design_number'])."%";
            }
            if(isset($this->filter['quantity']) && $this->filter['quantity'] != '')
            {
                $Parameters .= " AND MTBL.product_quantity = ? ";
                $value[] = $this->filter['quantity'];
            }
            if(isset($this->filter['min_order_qty']) && $this->filter['min_order_qty'] > 0)
            {
                $Parameters .= " AND MTBL.product_min_order_qty = ? ";
                $value[] = $this->filter['min_order_qty'];
            }

            $Parameters .= $this->getPeriodRangeQuery('product_added_datetime', $this->getSearchFilter(), 'adt', 'adt_from', 'adt_to');
            $Parameters .= $this->getPeriodRangeQuery('product_updated_datetime', $this->getSearchFilter(), 'udt', 'udt_from', 'udt_to');
            $Parameters .= $this->getPeriodRangeQuery('product_stockout_datetime', $this->getSearchFilter(), 'sodt', 'sodt_from', 'sodt_to');
        }
        elseif(defined('IN_SITE'))
        {
            # Some fixed filter for front end searching
            $Parameters .= " AND PCM.".CategoryMaster::obj()->Data[F_ACTIVE]." = ?";            $value[] = YES;
            //$Parameters .= " AND BM.".BrandMaster::obj()->Data[F_ACTIVE]." = ? ";               $value[] = YES;
            //$Parameters .= " AND PTM.".ProductTypeMaster::obj()->Data[F_ACTIVE]." = ? ";        $value[] = YES;
            //$Parameters .= " AND SUP.".Supplier::obj()->Data[F_ACTIVE]." = ? ";                 $value[] = YES;
            $Parameters .= " AND BUSM.".BusinessMaster::obj()->Data[F_ACTIVE]." = ? ";          $value[] = YES;
            $Parameters .= " AND BUSM.busm_is_verified = ? ";                                   $value[] = YES;
            $Parameters .= " AND BUSM.".BusinessMaster::obj()->Data[F_VIRTUAL_DELETE]." = ? ";  $value[] = NO;
            $Parameters .= " AND BUSM.busm_is_blocked = ? ";                                    $value[] = NO;
            $Parameters .= " AND MTBL.product_selling_price > 0 ";

            # Check for each assigned category whether it is active or not
            $Parameters .= " AND
                            (
                            SELECT GROUP_CONCAT(SPCM.".CategoryMaster::obj()->Data[F_ACTIVE]." ORDER BY SPCM.cm_level ASC)
                            FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
                            INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
                            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                            ) = ? "; $value[] = YES.','.YES.','.YES;
        }

        if(isset($this->filter['is_featured']) && !empty($this->filter['is_featured']))
        {
            $Parameters .= " AND MTBL.product_is_featured = ?";
            $value[] = $this->filter['is_featured'];
        }
        if(isset($this->filter['is_ready_to_dispatch']) && !empty($this->filter['is_ready_to_dispatch']))
        {
            $Parameters .= " AND MTBL.product_is_ready_to_dispatch = ? ";
            $value[] = $this->filter['is_ready_to_dispatch'];
        }
        if(isset($this->filter['is_hot_favourite']) && !empty($this->filter['is_hot_favourite']))
        {
            $Parameters .= " AND MTBL.product_is_hot_favourite = ? ";
            $value[] = $this->filter['is_hot_favourite'];
        }
        if(isset($this->filter['is_upcoming']) && !empty($this->filter['is_upcoming']))
        {
            $Parameters .= " AND MTBL.product_is_upcoming = ? ";
            $value[] = $this->filter['is_upcoming'];
        }

        ############################################################################################
        # Product search based on user searched keyword
        if(defined('IN_SITE') && isset($this->filter[SURL_QUERY]) && !empty($this->filter[SURL_QUERY]))
        {
            if(is_array($this->filter[SURL_QUERY]))
            {
                $q  = $this->filter[SURL_QUERY][0];
                $qt = $this->filter[SURL_QUERY][1];
            }
            elseif(is_string($this->filter[SURL_QUERY]))
            {
                $q = $this->filter[SURL_QUERY];
            }

            if(isset($q) && $q != '')
            {
	            # Check if requested for any SKU
	            $sku = $this->SystemSKU('D',$q);

	            if(is_numeric($sku))
		            $Parameters .= " AND MTBL.".$this->Data[F_P_KEY]." = '".$sku."' ";
	            else
	            {
		            preg_match_all("/[a-zA-Z0-9-\/]{2,}+/", $q, $out_keywords);

		            if(isset($out_keywords[0]) && is_array($out_keywords[0]))
		            {
			            $pm_f = array("MTBL.".$this->Data[F_P_FIELD],"MTBL.product_second_line",
			                          "PCM.".CategoryMaster::obj()->Data[F_P_FIELD],
			                          "BM.".BrandMaster::obj()->Data[F_P_FIELD]);

			            foreach($out_keywords[0] as $k => $word)
			            {
				            $a[$k] = implode(" LIKE '%".$word."%' OR ",$pm_f)." LIKE '%".$word."%' ";
				            $a[$k] .= " OR (
					                    SELECT COUNT(*) FROM ".ProductFeature::obj()->Data[TABLE_NAME]." WPF, ".FeatureMaster::obj()->Data[TABLE_NAME]." WFM
					                    WHERE WPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
					                    AND WPF.".ProductFeature::obj()->Data[F_P_FIELD]." = WFM.".FeatureMaster::obj()->Data[F_P_KEY]."
					                    AND WFM.".FeatureMaster::obj()->Data[F_ACTIVE]." = '".YES."'
					                    AND WFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."type = '".FEATURETYPE_REGULAR."'
					                    AND (WPF.".ProductFeature::obj()->Data[F_P_FIELD]." LIKE '".$word."%' OR WPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." LIKE '".$word."%')
										) > 0 ";
			            }

			            if(is_array($a))
				            $Parameters .= "AND (".implode(" ) AND ( ",$a).")";
		            }
	            }
            }
        }

        return array('sql'=>$Parameters,'value'=>$value);
    }
    public function _ViewAll_WebSite($POST = false)
    {
        global $config,$asset;

        $POST['is_active']     =   YES;

        $Custom_Param[F_B_SELECT] =   "
        MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].",MTBL.".$this->Data[F_S_URL].",MTBL.".$this->Data[F_ADDED_DATETIME].",
        MTBL.product_group_id,
        MTBL.product_is_ready_to_dispatch,MTBL.product_quantity, MTBL.product_min_order_qty, MTBL.product_is_hot_favourite, MTBL.product_is_featured,
        MTBL.product_image_type, MTBL.product_selling_price, MTBL.product_max_retail_price,
        MTBL.product_enable_inquiry, MTBL.product_enable_purchase, MTBL.product_is_upcoming, MTBL.product_discount,
        BM.".BrandMaster::obj()->Data[F_S_URL]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_S_URL].",
        BM.".BrandMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_FIELD].",
        COUNT(PVC.".View_ProductViewCurrentCount::obj()->Data[F_P_FIELD].") AS ".$this->Data[FIELD_PREFIX]."view_count,
        (
            SELECT GROUP_CONCAT(SPCM.".CategoryMaster::obj()->Data[F_S_URL].")
            FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
            INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            ORDER BY SPCM.cm_level ASC
        ) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_S_URL].",
        (
            SELECT SUM(SPM.product_quantity)FROM ".$this->Data[TABLE_NAME]." SPM
            WHERE SPM.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
        ) AS product_group_quantity,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('*',SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is,SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title,SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD].",SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."type,SSFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title) SEPARATOR '|' )
            FROM
            ".ProductFeature::obj()->Data[TABLE_NAME]." SPF,
            ".FeatureValueMaster::obj()->Data[TABLE_NAME]." SFVM,
            ".FeatureMaster::obj()->Data[TABLE_NAME]." SFM
            LEFT JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." SSFM ON SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."sub = SSFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            WHERE  SPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = SFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
            AND SFM.".FeatureMaster::obj()->Data[F_ACTIVE]." = '".YES."'
            AND SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is != '".FEATUREIS_REQUIRED."'
            ORDER BY SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is ASC
        ) AS ".$this->Data[FIELD_PREFIX]."feature_list,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('*',TM.".TagMaster::obj()->Data[F_P_KEY].",TM.".TagMaster::obj()->Data[F_P_FIELD].") SEPARATOR '|')
            FROM ".ProductTag::obj()->Data[TABLE_NAME]." PT,
            ".TagMaster::obj()->Data[TABLE_NAME]." TM
            WHERE  PT.".ProductTag::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            AND TM.".TagMaster::obj()->Data[F_P_KEY]." = PT.".ProductTag::obj()->Data[F_P_FIELD]."
        ) AS ".$this->Data[FIELD_PREFIX]."tag_list,
        PSG.*
        ";
        /*(
            SELECT GROUP_CONCAT(CONCAT_WS('[]',CONCAT_WS('*',SFM.".FeatureMaster::obj()->Data[F_P_KEY].",SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title),CONCAT_WS('*',SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY].",SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD].")) ORDER BY MTBL.product_quantity DESC, SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD]." ASC SEPARATOR '/' )
            FROM
            ".ProductFeature::obj()->Data[TABLE_NAME]." SPF,
            ".FeatureValueMaster::obj()->Data[TABLE_NAME]." SFVM,
            ".FeatureMaster::obj()->Data[TABLE_NAME]." SFM
            WHERE SPF.pfeature_psg_id = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = SFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
            AND SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '".FEATUREIS_REQUIRED."'
        ) AS product_required_feature,*/


        $Join = '';
        $Join .= " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
        //$Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
        //$Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];
        $Join .= " LEFT JOIN ".ProductTag::obj()->Data[TABLE_NAME]." PT ON MTBL.".$this->Data[F_P_KEY]." = PT.".ProductTag::obj()->Data[F_F_KEY];
        //$Join .= " INNER JOIN ".TagMaster::obj()->Data[TABLE_NAME]." TM ON PT.".ProductTag::obj()->Data[FIELD_PREFIX]." = TM.".TagMaster::obj()->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".View_ProductViewCurrentCount::obj()->Data[TABLE_NAME]." PVC ON MTBL.".$this->Data[F_P_KEY]." = PVC.".View_ProductViewCurrentCount::obj()->Data[F_P_KEY];

	    # Get all search filters based on params
        $param =   $this->getQueryParameters($POST);

	    $addParams = $param['sql'];

        # Set group by as we have one to many relation with table join in sql
        $Custom_Param[GROUP_BY]   =   "PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];

        # Check for all assigned category is active
        //$Custom_Param[HAVING] = $this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_ACTIVE]." = ? ";
        //$param['value'][] = YES.','.YES.','.YES;

        # Check if sort order and direction set into $_POST or not. If not set then product come with updated_datetime DESC
        if(isset($POST[SO]) && !empty($POST[SO]))
            $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY ".$this->Data[SO][$POST[SO]]." ".$asset['OL_SortDirection'][$POST[SD]]."";
        else
            $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY MTBL.product_added_datetime DESC, MTBL.product_updated_datetime DESC, MTBL.".$this->Data[F_P_KEY]." DESC ";

        if(isset($_GET['print']) || defined('DEBUG'))
        {
            //Utility::pre(parent::ViewAll($addParams, $param['value'], $Join, $Custom_Param)->fetch_record());
            $a = "SELECT ".$Custom_Param[F_B_SELECT]." FROM ".$this->Data[TABLE_NAME]." MTBL ".$Join." WHERE 1 ".$addParams." GROUP BY ".$Custom_Param[GROUP_BY].(isset($Custom_Param[HAVING])?" HAVING ".$Custom_Param[HAVING]:'')." ".$Custom_Param[CUST_SORT_ORDER_STR]." LIMIT ".$POST[S_RECORD].",".$POST[P_SIZE];
            $b = explode('?',$a);
            echo "<pre>".count($b)."=>".count($param['value'])."<br />========<br />";
            if((count($b)-1) == count($param['value']))
            {
                foreach($param['value'] as $k => $v)
                {

                    if(isset($b[$k]))
                        $b[$k] .= "'".$v."'";
                }

                echo implode(" ", $b);
            }
            echo "<br />==========<br />".$a;
            print_r($param['value']); die;
        }

        # Change group concat length. Its default string length is 1024. This is effect only excute this query.
        $this->DBC->set_group_concat_max_len(PRODUCT_STYLE_GROUP_MAX_ITEM);

        return parent::ViewAll($addParams, $param['value'], $Join, $Custom_Param);
    }
    public function _ViewAll_WebSite_OLD($POST = false)
    {
        global $config,$asset;

        $POST['is_active']     =   YES;

        $Custom_Param[F_B_SELECT] =   "
        MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].",MTBL.".$this->Data[F_S_URL].",MTBL.".$this->Data[F_ADDED_DATETIME].",
        MTBL.product_is_ready_to_dispatch,MTBL.product_quantity, MTBL.product_min_order_qty, MTBL.product_is_hot_favourite, MTBL.product_is_featured,
        MTBL.product_image_type, MTBL.product_selling_price, MTBL.product_max_retail_price,
        MTBL.product_enable_inquiry, MTBL.product_enable_purchase, MTBL.product_is_upcoming, MTBL.product_discount,
        BM.".BrandMaster::obj()->Data[F_S_URL]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_S_URL].",
        BM.".BrandMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_FIELD].",
        PVC.".View_ProductViewCurrentCount::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX]."view_count,
        (
            SELECT GROUP_CONCAT(SPCM.".CategoryMaster::obj()->Data[F_S_URL].")
            FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
            INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            ORDER BY SPCM.cm_level ASC
        ) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_S_URL].",
        (
            SELECT GROUP_CONCAT(CONCAT_WS('*',PI.".ProductImages::obj()->Data[F_P_KEY].",PI.proimg_image_file,PI.".ProductImages::obj()->Data[F_P_FIELD].") SEPARATOR '|')
            FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI
            WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND proimg_is_cover = ".YES."
            ORDER BY proimg_is_cover ASC, proimg_display_order ASC
        ) AS ".$this->Data[FIELD_PREFIX]."images_info,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('*',SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is,SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title,SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD].",SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."type,SSFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title) SEPARATOR '|' )
            FROM
            ".ProductFeature::obj()->Data[TABLE_NAME]." SPF,
            ".FeatureValueMaster::obj()->Data[TABLE_NAME]." SFVM,
            ".FeatureMaster::obj()->Data[TABLE_NAME]." SFM
            LEFT JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." SSFM ON SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."sub = SSFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            WHERE  SPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureMaster::obj()->Data[F_P_KEY]." = SFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
            AND SFM.".FeatureMaster::obj()->Data[F_ACTIVE]." = '".YES."'
            ORDER BY SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is ASC
        ) AS ".$this->Data[FIELD_PREFIX]."feature_list";
        /*(
            SELECT COUNT(PVC.ip) FROM
            (
                SELECT COUNT(SPVC.pvcount_ip) AS ip,SPVC.".ProductViewCount::obj()->Data[F_F_KEY]." FROM ".ProductViewCount::obj()->Data[TABLE_NAME]." SPVC
                WHERE (YEAR(SPVC.pvcount_adt) = ".date('Y').") AND (WEEK(SPVC.pvcount_adt, 3) = ". date('W').")
                GROUP BY SPVC.".ProductViewCount::obj()->Data[F_F_KEY].",SPVC.".ProductViewCount::obj()->Data[F_P_FIELD]."
            ) AS PVC
            WHERE PVC.".ProductViewCount::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
        ) AS ".$this->Data[FIELD_PREFIX]."view_count";*/
        //IF(MTBL.product_quantity = 0,'".YES."','".NO."') AS  product_outof_stock
        /*
        (
            SELECT GROUP_CONCAT(SPCM.".CategoryMaster::obj()->Data[F_ACTIVE]." ORDER BY SPCM.cm_level ASC)
            FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
            INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
        ) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_ACTIVE].",
        */

        $Join = '';
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];
        $Join .= " LEFT JOIN ".View_ProductViewCurrentCount::obj()->Data[TABLE_NAME]." PVC ON MTBL.".$this->Data[F_P_KEY]." = PVC.".View_ProductViewCurrentCount::obj()->Data[F_P_KEY];

	    # Get all search filters based on params
        $param =   $this->getQueryParameters($POST);

	    $addParams = $param['sql'];

        # Set group by as we have one to many relation with table join in sql
        $Custom_Param[GROUP_BY]   =   "MTBL.".$this->Data[F_P_KEY];

        # Check for all assigned category is active
        //$Custom_Param[HAVING] = $this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_ACTIVE]." = ? ";
        //$param['value'][] = YES.','.YES.','.YES;

        # Check if sort order and direction set into $_POST or not. If not set then product come with updated_datetime DESC
        if(isset($POST[SO]) && !empty($POST[SO]))
            $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY ".$this->Data[SO][$POST[SO]]." ".$asset['OL_SortDirection'][$POST[SD]].", MTBL.".$this->Data[F_P_KEY]." DESC ";
        else
            $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY MTBL.product_added_datetime DESC, MTBL.product_updated_datetime DESC, MTBL.".$this->Data[F_P_KEY]." DESC ";

        if(isset($_GET['print']) || defined('DEBUG'))
        {
            //Utility::pre(parent::ViewAll($addParams, $param['value'], $Join, $Custom_Param)->fetch_record());
            $a = "SELECT ".$Custom_Param[F_B_SELECT]." FROM ".$this->Data[TABLE_NAME]." MTBL ".$Join." WHERE 1 ".$addParams." GROUP BY ".$Custom_Param[GROUP_BY].(isset($Custom_Param[HAVING])?" HAVING ".$Custom_Param[HAVING]:'')." ".$Custom_Param[CUST_SORT_ORDER_STR]." LIMIT ".$POST[S_RECORD].",".$POST[P_SIZE];
            $b = explode('?',$a);
            echo "<pre>".count($b)."=>".count($param['value'])."<br />========<br />";
            if((count($b)-1) == count($param['value']))
            {
                foreach($param['value'] as $k => $v)
                {

                    if(isset($b[$k]))
                        $b[$k] .= "'".$v."'";
                }

                echo implode(" ", $b);
            }
            echo "<br />==========<br />".$a;
            print_r($param['value']); die;
        }

        return parent::ViewAll($addParams, $param['value'], $Join, $Custom_Param);
    }
    public function getHomePageProductData()
    {
        # Set some basic filter
        $POST['is_active']              =   YES;
        $POST[QP_EXCLUDE_OUT_OF_STOCK]  =   YES;

        # Get all search filters based on params
        $pamars = $this->getQueryParameters($POST);
        $b_where=''; $p = explode('?',$pamars['sql']);
        foreach($pamars['value'] as $k=>$v)
            $b_where .= $p[$k]." '".$v."' ";

        $b_where_featured = "   AND product_is_featured = '".YES."'";

        $b_select = " MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].",MTBL.".$this->Data[F_S_URL].",MTBL.".$this->Data[F_ADDED_DATETIME].",
        MTBL.product_quantity,
        (
            SELECT SUM(SPM.product_quantity) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
        ) AS product_group_quantity
        , MTBL.product_image_type, MTBL.product_selling_price, MTBL.product_max_retail_price, MTBL.product_discount,
        PSG.".ProductStyleGroup::obj()->Data[F_P_KEY].",PSG.".ProductStyleGroup::obj()->Data[F_P_FIELD].",PSG.psg_image_info";
        /*(
            SELECT GROUP_CONCAT(CONCAT_WS('*',PI.".ProductImages::obj()->Data[F_P_KEY].",PI.proimg_image_file,PI.".ProductImages::obj()->Data[F_P_FIELD].") SEPARATOR '|')
            FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI
            WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            AND proimg_is_cover = '".YES."'
        ) AS product_images_info ";*/

        $Join = '';
        $Join .= " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
        //$Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
        //$Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];

        $b_group_by   =   " GROUP BY PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]." ";

        $sql = "SELECT * FROM
        (
            (
                SELECT ".$b_select.", 'Most Popular' AS product_dg, '1' AS product_slider_order FROM ".View_ProductViewCurrentCount::obj()->Data[TABLE_NAME]." VPVCC
                INNER JOIN ".$this->Data[TABLE_NAME]." MTBL ON VPVCC.".View_ProductViewCurrentCount::obj()->Data[F_P_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING."'
                ".$b_where."
                AND MTBL.product_quantity > 0
                ".$b_group_by."
                ORDER BY VPVCC.".View_ProductViewCurrentCount::obj()->Data[F_P_FIELD]." DESC
                LIMIT 0,12
            )
            UNION
            (
                SELECT ".$b_select.", 'Latest Fashion Hand Bags' AS product_dg, '2' AS product_slider_order FROM ".$this->Data[TABLE_NAME]." MTBL
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_FASHION_AND_TRAND_FASHION_ACCESSORIES_BAG."'
                ".$b_where."
                ".$b_where_featured."
                AND MTBL.product_quantity > 0
                ".$b_group_by."
                ORDER BY MTBL.product_added_datetime DESC
                LIMIT 0,12
            )
            UNION
            (
                SELECT ".$b_select.", 'Latest Salwar Kameez' AS product_dg, '3' AS product_slider_order FROM ".$this->Data[TABLE_NAME]." MTBL
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING_ETHNICWEAR_SALWARKAMEEZ."'
                ".$b_where."
                ".$b_where_featured."
                AND MTBL.product_quantity > 0
                ".$b_group_by."
                ORDER BY MTBL.product_added_datetime DESC
                LIMIT 0,12
            )
            UNION
            (
                SELECT ".$b_select.", 'Latest Kurti With Lowest Price' AS product_dg, '4' AS product_slider_order FROM ".$this->Data[TABLE_NAME]." MTBL
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING_TOPS_KURTI."'
                ".$b_where."
                ".$b_where_featured."
                AND MTBL.product_quantity > 0
                ".$b_group_by."
                ORDER BY MTBL.product_selling_price ASC, MTBL.product_added_datetime DESC
                LIMIT 0,12
            )
            UNION
            (
                SELECT ".$b_select.", 'Designer Saree' AS product_dg, '5' AS product_slider_order FROM ".$this->Data[TABLE_NAME]." MTBL
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING_ETHNICWEAR_SAREE."'
                ".$b_where."
                ".$b_where_featured."
                AND
                (
                    SELECT COUNT(*) FROM ".ProductFeature::obj()->Data[TABLE_NAME]." WPF
                    WHERE WPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                    AND WPF.".ProductFeature::obj()->Data[F_P_FIELD]." = '".FEATURE_SAREESTYLE."'
                    AND WPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN ('".FEATURE_VAL_DESIGNER."')
                ) = 1
                AND MTBL.product_quantity > 0
                ".$b_group_by."
                ORDER BY MTBL.product_added_datetime DESC
                LIMIT 0,12
            )
            UNION
            (
                SELECT ".$b_select.", 'Lehanga Choli' AS product_dg, '6' AS product_slider_order FROM ".$this->Data[TABLE_NAME]." MTBL
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING_ETHNICWEAR_LEHANGACHOLI."'
                ".$b_where."
                ".$b_where_featured."
                AND MTBL.product_quantity > 0
                ".$b_group_by."
                ORDER BY MTBL.product_selling_price ASC, MTBL.product_added_datetime DESC
                LIMIT 0,12
            )

        ) HomePageData ";
        /*UNION
        (
            SELECT ".$b_select.", 'Designer Gown' AS product_dg, '5' AS product_slider_order FROM ".$this->Data[TABLE_NAME]." MTBL
            ".$Join."
            WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING_ETHNICWEAR_GOWN."'
            ".$b_where."
            ".$b_where_featured."
            AND
            (
                SELECT COUNT(*) FROM ".ProductFeature::obj()->Data[TABLE_NAME]." WPF
                WHERE WPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                AND WPF.".ProductFeature::obj()->Data[F_P_FIELD]." = '".FEATURE_GOWNSTYLE."'
                AND WPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN ('".FEATURE_VAL_DESIGNER."')
            ) = 1
            AND MTBL.product_quantity > 0
            ".$b_group_by."
            ORDER BY MTBL.product_added_datetime DESC
            LIMIT 0,12
        )*/
        $rs = $this->DBC->run_query($sql,false);
        return $rs;
        /*UNION
            (
                SELECT ".$b_select.", 'Jewellery Collection' AS product_dg, '2' AS product_slider_order FROM ".View_ProductViewCurrentCount::obj()->Data[TABLE_NAME]." VPVCC
                INNER JOIN ".$this->Data[TABLE_NAME]." MTBL ON VPVCC.".View_ProductViewCurrentCount::obj()->Data[F_P_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                ".$Join."
                WHERE PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_JEWELLERY_ORNAMENTS."'
                ".$b_where."
                ORDER BY VPVCC.".View_ProductViewCurrentCount::obj()->Data[F_P_FIELD]." DESC
                LIMIT 0,10
            )
            */
    }
    public function getHomePageSBProduct()
    {
        # Set some basic filter
        $POST['is_active']              =   YES;
        $POST[QP_EXCLUDE_OUT_OF_STOCK]  =   YES;

        # Get all search filters based on params
        $params = $this->getQueryParameters($POST);
        $addParams = $params['sql'];
        /*$b_where=''; $p = explode('?',$pamars['sql']);
        foreach($pamars['value'] as $k=>$v)
            $b_where .= $p[$k]." '".$v."' ";
        */
        $Custom_Param[F_B_SELECT] = "
        MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].",MTBL.".$this->Data[F_S_URL].",MTBL.".$this->Data[F_ADDED_DATETIME].",
        MTBL.product_quantity, MTBL.product_image_type, MTBL.product_selling_price, MTBL.product_max_retail_price, MTBL.product_discount,
        PSG.".ProductStyleGroup::obj()->Data[F_P_KEY].",PSG.".ProductStyleGroup::obj()->Data[F_P_FIELD].",PSG.psg_image_info";
        /*(
            SELECT GROUP_CONCAT(CONCAT_WS('*',PI.".ProductImages::obj()->Data[F_P_KEY].",PI.proimg_image_file,PI.".ProductImages::obj()->Data[F_P_FIELD].") SEPARATOR '|')
            FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI
            WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            AND proimg_is_cover = '".YES."'
        ) AS product_images_info ";*/

        $addParams .= " AND PC.".ProductCategory::obj()->Data[F_P_FIELD]." =  '".CAT_CLOTHING_TOPS_KURTI."'";

        $Join = '';
        $Join .= " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
        //$Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
        //$Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];

        $Custom_Param[SQL_LIMIT] = "0,6";
        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY MTBL.product_added_datetime DESC, MTBL.product_updated_datetime DESC, MTBL.".$this->Data[F_P_KEY]." DESC ";

        return parent::getAll($addParams,$params['value'],$Join,$Custom_Param);
    }
	public function _ViewAll_HotFavProduct($POST = false)
    {
        $this->page_size            =   $POST[CART_PAGE_SIZE];
		$_SESSION[S_RECORD]         =   $POST[S_RECORD];

        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY product_added_datetime DESC, product_updated_datetime DESC ";

		$Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,MTBL.product_is_featured,MTBL.product_is_hot_favourite,MTBL.product_is_ready_to_dispatch,MTBL.product_quantity,MTBL.product_image_type,MTBL.product_sku, MTBL.product_selling_price,MTBL.product_max_retail_price, (SELECT GROUP_CONCAT(PI.proimg_id SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_id, (SELECT GROUP_CONCAT(PI.proimg_filename SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_name,(SELECT GROUP_CONCAT(PI.proimg_alt SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_alt,(SELECT GROUP_CONCAT(PI.proimg_title SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_title ";

		$addParams = " AND product_is_hot_favourite = ? AND product_quantity > ? AND ".$this->Data[F_ACTIVE]." = ? AND product_selling_price > 0";

        $value  = array(YES,0,YES);

        return parent::ViewAll($addParams,$value,$Join=false, $Custom_Param);
    }
	public function getProductInfoByProductID($product_id)
    {
        if(!is_numeric($product_id))
            return false;

        $F_CustomSelect = "MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,product_short_desc,product_selling_price,product_max_retail_price,product_quantity,product_min_order_qty,product_is_featured,product_is_ready_to_dispatch,product_is_hot_favourite,product_image_type,product_sku,PI.proimg_id,PI.proimg_image_file,PI.proimg_title,PI.proimg_alt ";

        $param = $this->Data[F_P_KEY]." = ? ";
        $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = ? AND PI.proimg_is_cover = ?";

        return parent::getInfoByParam($param, array(YES,YES,$product_id),$F_CustomSelect, $Join);
    }
	public function getCatalogInfoByProductId($product_id)
	{
		if(!is_numeric($product_id))
			return false;

		$F_CustomSelect = " product_sku";

		return parent::getInfoById($product_id, $F_CustomSelect);
	}
    public function _ViewAll($addParameters=false, $value=false, $Join=false, $Custom_Param=false, $allRecord=false)
    {
        //GROUP_CONCAT(DISTINCT PC.".ProductCategory::obj()->Data[F_P_FIELD].") AS ".$this->Data[FIELD_PREFIX].ProductCategory::obj()->Data[F_P_FIELD].",
        //GROUP_CONCAT(DISTINCT PCM.".CategoryMaster::obj()->Data[F_P_FIELD]." ORDER BY PCM.cm_level ASC) AS product_cat_name,
        $Custom_Param[F_B_SELECT] = "MTBL.*,
        (
            SELECT GROUP_CONCAT(SPCM.cm_name)
            FROM oe_product_category SPC
            INNER JOIN oe_category_master SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
            WHERE SPC.pcat_product_id = MTBL.product_id
            ORDER BY SPCM.cm_level ASC
        ) AS product_cm_name,
        CONCAT(PI.".ProductImages::obj()->Data[F_F_KEY].",
                '/',PI.".ProductImages::obj()->Data[F_P_KEY]."
                )AS product_photo,
        PI.proimg_image_file AS product_filename,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('*',SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title,SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD].") SEPARATOR '|' )
            FROM
            ".ProductFeature::obj()->Data[TABLE_NAME]." SPF,
            ".FeatureValueMaster::obj()->Data[TABLE_NAME]." SFVM,
            ".FeatureMaster::obj()->Data[TABLE_NAME]." SFM
            WHERE  SPF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureMaster::obj()->Data[F_P_KEY]." = SFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
            AND SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is= '".FEATUREIS_REQUIRED."'
        ) AS ".$this->Data[FIELD_PREFIX]."feature_list,
        GROUP_CONCAT(DISTINCT BUSM.".BusinessMaster::obj()->Data[F_P_FIELD]." ORDER BY BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." ASC) AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_FIELD].",
        GROUP_CONCAT(DISTINCT TM.".TagMaster::obj()->Data[F_P_FIELD].") AS ".$this->Data[FIELD_PREFIX]."ptag_safe_url
        ";
        //GROUP_CONCAT(DISTINCT SUP.".Supplier::obj()->Data[F_P_FIELD]." ORDER BY SUP.".Supplier::obj()->Data[F_P_KEY]." ASC) AS product_sup_name,

        //var_dump($Custom_Param);exit;
        $Join = '';
        $Join .= " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND proimg_is_cover = '".YES."'";
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
        //$Join .= " LEFT JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PS ON PS.".ProductSupplier::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON PS.".ProductSupplier::obj()->Data[F_P_FIELD]." = SUP.".Supplier::obj()->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".ProductTag::obj()->Data[TABLE_NAME]." PT ON PT.".ProductTag::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".TagMaster::obj()->Data[TABLE_NAME]." TM ON TM.".TagMaster::obj()->Data[F_P_KEY]." = PT.".ProductTag::obj()->Data[F_P_FIELD];
        $Join .= " LEFT JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON MTBL.product_protype_id = PTM.".ProductTypeMaster::obj()->Data[F_P_KEY];

        /*if((isset($this->filter[SURL_QUERY])) || (isset($this->filter[QP_CATEGORY]) && !empty($this->filter[QP_CATEGORY]) && isset($this->filter[QP_FEATURE]) && is_array($this->filter[QP_FEATURE]) && count($this->filter[QP_FEATURE]) > 0))
        {
            $Join .= " INNER JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON MTBL.".$this->Data[F_P_KEY]." = PF.".ProductFeature::obj()->Data[F_F_KEY];
        }*/
        //$Join .= " LEFT JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON MTBL.".$this->Data[F_P_KEY]." = PF.".ProductFeature::obj()->Data[F_F_KEY];
        //$Join .= " LEFT JOIN ".FeatureValueMaster::obj()->Data[TABLE_NAME]." FVM ON PF.".ProductFeature::obj()->Data[F_P_FIELD]." = FVM.".FeatureValueMaster::obj()->Data[F_F_KEY];
        //$Join .= " LEFT JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." FM ON FVM.".FeatureValueMaster::obj()->Data[F_F_KEY]." = FM.".FeatureMaster::obj()->Data[F_P_KEY];
/*

SELECT
        MTBL.*,
        (
            SELECT GROUP_CONCAT(SPCM.cm_safe_url)
            FROM oe_product_category SPC
            INNER JOIN oe_cm_master SPCM ON SPC.pcat_cm_id = SPCM.cm_id
            WHERE SPC.pcat_product_id = MTBL.product_id
            ORDER BY SPCM.cm_level ASC
        ) AS product_cm_safe_url

FROM oe_product_master MTBL INNER JOIN oe_product_category PC ON MTBL.product_id = PC.pcat_product_id INNER JOIN oe_category_master PCM ON PCM.cm_id = PC.pcat_cm_id INNER JOIN oe_product_supplier PSUP ON MTBL.product_id = PSUP.psup_product_id INNER JOIN oe_supplier SUP ON SUP.supplier_id = PSUP.psup_supplier_id WHERE 1  AND MTBL.product_quantity > 0  AND PCM.cm_safe_url IN ('salwar-kameez') AND MTBL.product_is_active = 1  AND PCM.cm_is_active = 1 AND SUP.supplier_is_active =1  AND MTBL.product_selling_price > 0  GROUP BY MTBL.product_id ORDER BY product_added_datetime DESC, MTBL.product_id DESC  LIMIT 0, 12

*/
        $params	        =	$this->getQueryParameters();
        $addParameters  .=  $params['sql'];

        if(is_array($value) && is_array($params['value']))
            $value = array_merge($value,$params['value']);
        elseif(is_array($params['value']))
            $value =   $params['value'];

	    if(!isset($_GET[SO]))
		{
			$_GET[SO] = 'updated_datetime';
			$_GET[SD] = 'desc';
		}
        # Set group by as we have one to many relation with table join in sql
        $Custom_Param[GROUP_BY]   =   "MTBL.".$this->Data[F_P_KEY];
        return parent::ViewAll($addParameters, $value, $Join, $Custom_Param, $allRecord);
    }
    public function getFullViewProductDetail_OLD($product_id)
    {
        $F_CustomSelect = " MTBL.*,
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_P_KEY]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_KEY].",
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_S_URL]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_S_URL].",
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_ACTIVE]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_ACTIVE].",
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_P_FIELD]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_FIELD].",

        BM.".BrandMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX]."".BrandMaster::obj()->Data[F_P_FIELD].",
        BM.".BrandMaster::obj()->Data[F_S_URL]." AS ".$this->Data[FIELD_PREFIX]."".BrandMaster::obj()->Data[F_S_URL].",
        BM.".BrandMaster::obj()->Data[F_ACTIVE]." AS ".$this->Data[FIELD_PREFIX]."".BrandMaster::obj()->Data[F_ACTIVE];

        $param = $this->Data[F_P_KEY]." = :id ";
        $value = array(':id' => $product_id);

        $Join = " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        //$Join .= " INNER JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON MTBL.product_protype_id = PTM.".ProductTypeMaster::obj()->Data[F_P_KEY];

        return parent::getInfoByParam($param, $value, $F_CustomSelect, $Join);
    }
    public function getFullViewProductDetail($arrParam)
    {
        if((!isset($arrParam[SURL_FULL_VIEW_PAGE]) || (isset($arrParam[SURL_FULL_VIEW_PAGE]) && empty($arrParam[SURL_FULL_VIEW_PAGE]))) && (!isset($arrParam[SURL_FVP_ITEM]) || (isset($arrParam[SURL_FVP_ITEM]) && empty($arrParam[SURL_FVP_ITEM]))))
            return false;

        $F_CustomSelect = " MTBL.*,PSG.".ProductStyleGroup::obj()->Data[F_P_KEY].",PSG.".ProductStyleGroup::obj()->Data[F_P_FIELD].",PSG.psg_image_info,
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_P_KEY]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_KEY].",
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_S_URL]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_S_URL].",
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_ACTIVE]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_ACTIVE].",
        GROUP_CONCAT(PCM.".CategoryMaster::obj()->Data[F_P_FIELD]." ORDER BY PCM.cm_level) AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_FIELD].",
        
        BUSM.".BusinessMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_FIELD].",
        BUSM.busm_logo AS ".$this->Data[FIELD_PREFIX]."busm_logo,
        BUSM.".BusinessMaster::obj()->Data[F_ADDED_DATETIME]." AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_ADDED_DATETIME].",
            
        BM.".BrandMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_FIELD].",
        BM.".BrandMaster::obj()->Data[F_S_URL]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_S_URL].",
        BM.".BrandMaster::obj()->Data[F_ACTIVE]." AS ".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_ACTIVE].",
        (
            SELECT GROUP_CONCAT(CONCAT_WS('|', CONCAT_WS('*',SFM.".FeatureMaster::obj()->Data[F_P_KEY].",SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title),CONCAT_WS('*',SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY].",SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD]."),CONCAT_WS('*',PIMG.".ProductImages::obj()->Data[F_P_KEY].",PIMG.proimg_image_file,(SELECT SSPM.".$this->Data[F_ADDED_DATETIME]."  FROM ".$this->Data[TABLE_NAME]." SSPM WHERE SPF.".ProductFeature::obj()->Data[F_F_KEY]." = SSPM.".$this->Data[F_P_KEY]."))) ORDER BY MTBL.product_quantity DESC,SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title ASC,SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD]." ASC SEPARATOR '/' )
            FROM 
            ".FeatureValueMaster::obj()->Data[TABLE_NAME]." SFVM,
            ".FeatureMaster::obj()->Data[TABLE_NAME]." SFM,
            ".ProductFeature::obj()->Data[TABLE_NAME]." SPF,
            ".ProductImages::obj()->Data[TABLE_NAME]." PIMG
            WHERE SPF.pfeature_psg_id = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = SFM.".FeatureMaster::obj()->Data[F_P_KEY]."
            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
            AND SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '".FEATUREIS_REQUIRED."'
            AND PIMG.".ProductImages::obj()->Data[F_F_KEY]." = SPF.".ProductFeature::obj()->Data[F_F_KEY]."
            AND PIMG.proimg_is_cover = '".YES."'
        ) AS product_required_feature";

        $Parameters = " 1 ";

        if(isset($arrParam[SURL_FVP_ITEM]) && !empty($arrParam[SURL_FVP_ITEM]))
        {
            $Parameters .= " AND ".$this->Data[F_P_KEY]." = ? ";
            $value[] = !is_numeric($arrParam[SURL_FVP_ITEM]) ? $this->SystemSKU('D',$arrParam[SURL_FVP_ITEM]) : $arrParam[SURL_FVP_ITEM];
        }
        if(isset($arrParam[SURL_FULL_VIEW_PAGE]) && !empty($arrParam[SURL_FULL_VIEW_PAGE]))
        {
            $Parameters .= " AND ".$this->Data[F_F_KEY]." = ? ";
            $value[] = !is_numeric($arrParam[SURL_FULL_VIEW_PAGE]) ? ProductStyleGroup::obj()->StyleGroupId('D',$arrParam[SURL_FULL_VIEW_PAGE]) : $arrParam[SURL_FULL_VIEW_PAGE];
        }
        if(isset($arrParam[QP_FEATURE]) && is_array($arrParam[QP_FEATURE]) && count($arrParam[QP_FEATURE]) > 0)
        {
            /*$value = array_keys($arrParam[QP_FEATURE]);
            $value[] = $arrParam[QP_FEATURE][$value[0]][0];
            $value[] = $arrParam[QP_FEATURE][$value[1]][0];*/

            $ftr = array_keys($arrParam[QP_FEATURE]);
            if(isset($ftr[0]) && isset($arrParam[QP_FEATURE][$ftr[0]]) && is_array($arrParam[QP_FEATURE][$ftr[0]]))
            {
                /*$Parameters .= "AND WPF.pfeature_psg_id = ?
                                AND WPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                                AND WPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = ?";
                                ;*/
                $Parameters .= "AND MTBL.".$this->Data[F_P_KEY]." = 
                                (
                                    SELECT WPF.pfeature_product_id FROM ".ProductFeature::obj()->Data[TABLE_NAME]." WPF
                                    WHERE WPF.pfeature_psg_id = ?
                                    AND WPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                                    AND WPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = ?";
                                    if(isset($ftr[1]) && isset($arrParam[QP_FEATURE][$ftr[1]]) && is_array($arrParam[QP_FEATURE][$ftr[1]]))
                                    {
                                        $Parameters .= " AND WPF.pfeature_product_id IN 
                                                        (
                                                            SELECT SPF.pfeature_product_id FROM ".ProductFeature::obj()->Data[TABLE_NAME]." SPF
                                                            WHERE SPF.pfeature_psg_id = ?
                                                            AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                                                            AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = ?
                                                        )"
                                                        ;
                                        $value[] = ProductStyleGroup::obj()->StyleGroupId('D',$arrParam[SURL_FULL_VIEW_PAGE]);
                                        $value[] = $ftr[1];
                                        $value = array_merge($value,$arrParam[QP_FEATURE][$ftr[1]]);

                                    }
                                    $Parameters .= "ORDER BY MTBL.product_quantity DESC LIMIT 1
                                ) 
                                ";
                $value[] = ProductStyleGroup::obj()->StyleGroupId('D',$arrParam[SURL_FULL_VIEW_PAGE]);
                $value[] = $ftr[0];
                $value = array_merge($value,$arrParam[QP_FEATURE][$ftr[0]]);
            }
        }

        $Join = " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON MTBL.product_busm_id = BUSM.".BusinessMaster::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        /*define('DEBUG',true);
        echo "<pre>"; print_r($value);*/
        $this->DBC->set_group_concat_max_len(PRODUCT_STYLE_GROUP_MAX_ITEM);
        $info = parent::getInfoByParam($Parameters, $value, $F_CustomSelect, $Join);

        if(is_array($info) && count($info) > 0)
        {
            # If want to display product insted of color in full view then enable it & need to manipulate it further based on requirement
            /*if(isset($info['psg_image_info']) && !empty($info['psg_image_info']))
            {
                $image_info = explode('/',$info['psg_image_info']);
                foreach($image_info as $ipkey => $ipinfo)
                {
                    $imgInfo   =   explode('|',$ipinfo);

                    $img_list[$imgInfo[0]][]    = $imgInfo[1];
                    $img_list[$imgInfo[0]][]    = $imgInfo[2];

                }
                $info['psg_image_info']= $img_list;
            }*/
            if(isset($info['product_required_feature']) && !empty($info['product_required_feature']))
            {
                $feature_info = explode('/',$info['product_required_feature']);
                foreach($feature_info as $fkey => $finfo)
                {
                    $ftrInfo   =   explode('|',$finfo);
                    $f         =   explode('*',$ftrInfo[0]);
                    $fv        =   explode('*',$ftrInfo[1]);
                    $pi        =   explode('*',$ftrInfo[2]);
                    $f_list[$f[0]]['title']    = $f[1];
                    $f_list[$f[0]]['list'][$fv[0]]['title'] = $fv[1];
                    $f_list[$f[0]]['list'][$fv[0]]['img_id'] = $pi[0];
                    $f_list[$f[0]]['list'][$fv[0]]['img_file'] = $pi[1];
                    $f_list[$f[0]]['list'][$fv[0]]['p_adt'] = $pi[2];
                }
                $info['product_required_feature']= $f_list;
            }
        }

        return $info;
    }
    public function getProductAvailableFeature($POST)
    {
        if(!is_array($POST))
            return false;

        $F_CustomSelect = " PF.pfeature_product_id,PF.".ProductFeature::obj()->Data[F_P_FIELD].",PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY];

        $Parameters = " 1 ";
        /*if(isset($POST[QP_FEATURE]) && is_array($POST[QP_FEATURE]) && count($POST[QP_FEATURE]))
        {
            $Parameters .= " AND PF.pfeature_product_id IN
                            (
                                SELECT SPF.pfeature_product_id FROM ".ProductFeature::obj()->Data[TABLE_NAME]." SPF
                                WHERE
                                SPF.pfeature_psg_id = ?
                                AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                                AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = ?
                            )
                            AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." != ?
                            AND FM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '".FEATUREIS_REQUIRED."'
                            AND MTBL.product_quantity > 0
                            GROUP BY PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]."
                            ";
            $ftr = array_keys($POST[QP_FEATURE]);

            $value[] = ProductStyleGroup::obj()->StyleGroupId('D',$POST[SURL_FULL_VIEW_PAGE]);
            $value = array_merge($value,$ftr);
            if(isset($ftr[0]) && isset($POST[QP_FEATURE][$ftr[0]]) && is_array($POST[QP_FEATURE][$ftr[0]]))
                $value = array_merge($value,$POST[QP_FEATURE][$ftr[0]]);
            if(isset($ftr[1]) && isset($POST[QP_FEATURE][$ftr[1]]) && is_array($POST[QP_FEATURE][$ftr[1]]))
                $value = array_merge($value,$POST[QP_FEATURE][$ftr[1]]);

            $value = array_merge($value,$ftr);

        }*/
        if(isset($POST[QP_FEATURE]) && is_array($POST[QP_FEATURE]) && count($POST[QP_FEATURE]))
        {
            $Parameters .= " AND PF.pfeature_product_id IN 
                            (
                                SELECT SPF.pfeature_product_id FROM ".ProductFeature::obj()->Data[TABLE_NAME]." SPF
                                WHERE 
                                SPF.pfeature_psg_id = ?
                                AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." IN (".rtrim(str_repeat('?,',(count($POST[QP_FEATURE]))),',').") 
                                AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($POST[QP_FEATURE]))),',').")
                            )
                            AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." != ?
                            AND FM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '".FEATUREIS_REQUIRED."'
                            AND MTBL.product_quantity > 0 
                            GROUP BY PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY];

            $ftr = array_keys($POST[QP_FEATURE]);

            $value[] = ProductStyleGroup::obj()->StyleGroupId('D',$POST[SURL_FULL_VIEW_PAGE]);
            $value = array_merge($value,$ftr);
            if(isset($ftr[0]) && isset($POST[QP_FEATURE][$ftr[0]]) && is_array($POST[QP_FEATURE][$ftr[0]]))
                $value = array_merge($value,$POST[QP_FEATURE][$ftr[0]]);
            if(isset($ftr[1]) && isset($POST[QP_FEATURE][$ftr[1]]) && is_array($POST[QP_FEATURE][$ftr[1]]))
                $value = array_merge($value,$POST[QP_FEATURE][$ftr[1]]);

            if(isset($ftr[0]) && isset($POST[QP_FEATURE][$ftr[0]]) && is_array($POST[QP_FEATURE][$ftr[0]]))
            {
                $value[] = $ftr[0];
            }
            /*if(isset($ftr[1]) && isset($POST[QP_FEATURE][$ftr[1]]) && is_array($POST[QP_FEATURE][$ftr[1]]))
            {
                $value[] = $ftr[1];
            }
            elseif(isset($ftr[0]) && isset($POST[QP_FEATURE][$ftr[0]]) && is_array($POST[QP_FEATURE][$ftr[0]]))
            {
                $value[] = $ftr[0];
            }*/
        }
        /*if(isset($POST[SURL_FVP_ITEM]) && !empty($POST[SURL_FVP_ITEM]))
        {
            $Parameters .= "AND PF.pfeature_product_id = ?
                            AND FM.feature_is = '".FEATUREIS_REQUIRED."'
                            AND MTBL.product_quantity > 0
                            GROUP BY PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY];

            $value[] = !is_numeric($POST[SURL_FVP_ITEM]) ? $this->SystemSKU('D',$POST[SURL_FVP_ITEM]) : $POST[SURL_FVP_ITEM];
        }*/

        $Join = " INNER JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON PF.pfeature_psg_id = MTBL.".$this->Data[F_F_KEY];
        $Join .= " INNER JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." FM ON FM.".FeatureMaster::obj()->Data[F_P_KEY]." = PF.".ProductFeature::obj()->Data[F_P_FIELD];
        /*define('DEBUG',true);
        echo"<pre>"; print_r($value);*/
        $pfInfo = parent::getInfoByParam($Parameters, $value, $F_CustomSelect, $Join,PDO_FETCH_ALL);
        //Utility::pre($pfInfo);
        if(is_array($pfInfo) && count($pfInfo) > 0 )
        {
            foreach($pfInfo AS $k => $fInfo)
            {
                $arrFeature[$fInfo[ProductFeature::obj()->Data[FIELD_PREFIX].FeatureMaster::obj()->Data[F_P_KEY]]][$fInfo[ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]]] = $fInfo[ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]];
            }
            return $arrFeature;
        }
        else
            return false;
    }
	public function getRandomImagesByCategoryAndFeature($cat,$feature)
	{
		if(!is_numeric($cat) || $feature == '')
			return false;

		if(!is_array($feature))
			$feature = array($feature);

		$Custom_Param[F_B_SELECT] = "MTBL.".$this->Data[F_ADDED_DATETIME]." AS adt, PI.proimg_image_file AS image,
		(
			SELECT CONCAT(PF.".ProductFeature::obj()->Data[F_P_FIELD].",'|',PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY].")  FROM ".ProductFeature::obj()->Data[TABLE_NAME]." PF
		    WHERE  PF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
		    AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." IN ('".implode("','",$feature)."')
		    AND PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IS NOT NULL
		    ORDER BY RAND()
		    LIMIT 1
		) AS feature ";

		$addParameters = " AND MTBL.".$this->Data[F_ACTIVE]." = ? "; $value[] = YES;
        $addParameters .= " AND MTBL.product_quantity > 0 ";
		$addParameters .= " AND PC.".ProductCategory::obj()->Data[F_P_FIELD]." = ? "; $value[] = $cat;
		$addParameters .= " AND PI.proimg_is_cover = ? "; $value[] = YES;
		$addParameters .= " AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = ? "; $value[] = YES;

		$Join  = " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
		$Join .= " INNER JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON MTBL.".$this->Data[F_P_KEY]." = PI.".ProductImages::obj()->Data[F_F_KEY];

		$Custom_Param[GROUP_BY] = " feature ";
		$Custom_Param[HAVING] = " feature IS NOT NULL ";
		$Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY MTBL.".$this->Data[F_ADDED_DATETIME]." DESC ";
		$Custom_Param[SQL_LIMIT] = "25";

		$rs = parent::getAll($addParameters, $value, $Join, $Custom_Param);

		if($rs->TotalRow > 0)
		{
			$out=array();
			while($rs->next_record())
			{
				$f = explode('|',$rs->f('feature'));
				$out[$f[0]][$f[1]][] = $rs->f('image');
				$out[$f[0]][$f[1]][] = $rs->f('adt');
			}
			return $out;
		}
		return false;
	}
    public function getSafeUrl(&$POST)
    {
        $f_safe_url = str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_S_URL]);

        if (!isset($POST[$f_safe_url]) || empty($POST[$f_safe_url]))
			$safe_url = $this->buildURLFriendlyName($POST[str_replace($this->Data[FIELD_PREFIX], '', $this->Data[F_P_FIELD])]);
		else
			$safe_url = $this->buildURLFriendlyName($POST[$f_safe_url]);

        $POST[$f_safe_url] = $safe_url;

        return $safe_url;
    }
    public function getStyleGroupNoById($product_id)
    {
        if(!is_numeric($product_id))
            return false;

        $F_CustomSelect = 'product_psg_id,product_group_id';
        $param = $this->Data[F_P_KEY]." = ? ";
        $value[] = $product_id;

        return parent::getInfoByParam($param,$value,$F_CustomSelect);
    }
    public function _Insert($POST, $product_id = false)
    {
        $this->Data[F_F_INFO]['added_datetime'][CNT_TYPE]   = C_HIDDEN;
        $this->Data[F_F_INFO]['updated_datetime'][CNT_TYPE] = C_HIDDEN;
        $this->Data[F_F_INFO]['discount'][CNT_TYPE] = C_HIDDEN;
        $this->Data[F_F_INFO]['group_id'][CNT_TYPE] = C_HIDDEN;
        $this->Data[F_F_INFO]['short_desc'][CNT_TYPE] = C_HIDDEN;
        $this->Data[F_F_INFO]['ean'][CNT_TYPE] = C_HIDDEN;
        $this->Data[F_F_INFO]['upc'][CNT_TYPE] = C_HIDDEN;

        ProductStyleGroup::obj()->populateSchema(true);

        if($POST[ProductStyleGroup::obj()->Data[F_P_KEY]] != '')
        {
            $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] = trim($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

            $ProductInfo = array();

            # Get product info by style group id
            $ProductInfo = $this->getProductInfoByStyleGroupId($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

            # Check style group no is exist or not
            if(is_array($ProductInfo) && count($ProductInfo) > 0)
            {
                # Set style group id in group id
                $POST['group_id'] = $ProductInfo['product_group_id'];

                # Check group of total product is less then 15 or 15.
                if($ProductInfo['product_variant'] < PRODUCT_STYLE_GROUP_MAX_ITEM)
                {
                    $Category = explode(',',$ProductInfo['product_cm_safe_url']);
                    $arrTCat = explode('|',$Category[2]);

                    # Check system group category and post category is not same then error given
                    if($arrTCat[0] != $POST[CategoryMaster::obj()->Data[F_P_KEY]])
                    {
                        $this->Error[E_DESC] = "Sorry, invalid category selected for ".$POST[ProductStyleGroup::obj()->Data[F_P_KEY]]." style group no. Please Try again.";
                        return false;
                    }
                }
                else
                {
                    $this->Error[E_DESC] = 'Sorry, you can add only '.PRODUCT_STYLE_GROUP_MAX_ITEM.' item in '.$POST[ProductStyleGroup::obj()->Data[F_P_KEY]].' style group no. Please create another style group no.';
                    return false;
                }
            }
            else
            {
                $POST['group_id'] = $POST[ProductStyleGroup::obj()->Data[F_P_KEY]];
                unset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);
            }
        }
        else
        {
            $POST['group_id'] = 'G0';
            unset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);
        }

        $POST['added_datetime']     = date('Y-m-d H:i:s');
        $POST['updated_datetime']   = date('Y-m-d H:i:s');
        $POST['name']               = ucwords(strtolower($POST['name']));
        $procat_id                  = $POST[CategoryMaster::obj()->Data[F_P_KEY]];
        $POST['discount']           = round((($POST['max_retail_price']-$POST['selling_price'])*100)/$POST['max_retail_price']);
        $POST['ean']                = '';
        $POST['upc']                = '';
        $POST['short_desc']         = isset($POST['short_desc'])?$POST['short_desc']:'';

        if(isset($POST['ptag_safe_url']) && !empty($POST['ptag_safe_url']))
            $arrTag =   $POST['ptag_safe_url'];

        if(isset($POST['quantity']) && $POST['quantity'] == 0)
        {
            $this->Data[F_F_INFO]['stockout_datetime'][CNT_TYPE]    = C_HIDDEN;
            $this->Data[F_F_INFO]['stockout_by'][CNT_TYPE]          = C_HIDDEN;

            $POST['stockout_datetime']  =   date('Y-m-d H:i:s');
            $POST['stockout_by']        =   STOCKOUT_MANUALLY;
        }
        if(isset($POST['quantity']) && $POST['quantity'] > 0)
        {
           $this->Data[F_F_INFO]['stockout_by'][CNT_TYPE]   = C_HIDDEN;
           $POST['stockout_by']        =   STOCKOUT_NONE;
        }

        #unset Category id and Supplier id before insert called.
        unset($this->Data[F_F_INFO][CategoryMaster::obj()->Data[F_P_KEY]]);
        //unset($this->Data[F_F_INFO]['supplier_id']);
        unset($this->Data[F_F_INFO]['ptag_safe_url']);
        //unset($POST['cm_id'],$POST['supplier_id']);
        //$this->Data[F_F_INFO]['supplier_id'] = array();
        //$this->Data[F_F_INFO]['cm_id'] = array();

        if(isset($POST[BusinessMaster::obj()->Data[F_P_KEY]]) && is_numeric(Ocrypt::dec($POST[BusinessMaster::obj()->Data[F_P_KEY]])))
            $POST[BusinessMaster::obj()->Data[F_P_KEY]] = Ocrypt::dec($POST[BusinessMaster::obj()->Data[F_P_KEY]]);

        # Set safe URL and unset it as its not possible to be a unique
        $this->getSafeUrl($POST);
        unset($this->Data[F_S_URL]);

        # If product style id not set in post then insert record into oe_product_style_group
        if(!isset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]))
        {
            $SPOST['product_info'] = '';
            $SPOST['image_info'] = '';
            $SPOST['req_feature_info'] = '';

            # Insert data into product style group table
            $psg_id  = ProductStyleGroup::obj()->Insert($SPOST);

            if(is_numeric($psg_id))
            {
                $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] = $psg_id;
            }
            else
                return false;
        }

        if(isset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]) && $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] != '' && !is_numeric($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]))
            $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] = ProductStyleGroup::obj()->StyleGroupId('D',$POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

        $product_id =  parent::Insert($POST);

        if(isset($procat_id) && is_numeric($product_id))
        {
            if(isset($POST['safe_url']) && $POST['safe_url'] != '')
            {
                ProductStyleGroup::obj()->UpdateStyleGroupProductInfoById($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);
            }

            $cat_info = CategoryMaster::obj()->getAllParentCataegoryByChildCategory($procat_id);

            if(isset($cat_info['product_cm_list']) && $cat_info['product_cm_list'] != '')
            {
                ProductCategory::obj(true)->_Insert($product_id, $cat_info);
            }
            elseif(!is_numeric($procat_id))
            {
                $this->Error[E_DESC] = "Sorry, you can not change your product category.";
                return false;
            }

            if(is_array($arrTag))
                ProductTag::obj(true)->_Insert($product_id, $arrTag);
        }
        return $product_id;
    }
    public function _Delete($id, $retField='')
    {
        if(!is_numeric($id) && !is_array($id))
            return false;

        $info = $this->getInfoById($id);
        $cnt = 0;

        # Multiple product delete
        if(is_array($id) && count($id) > 1)
        {
            foreach($info AS $key => $pInfo)
            {
                # Delete product images and additional images
                $return = $this->DeleteProductImages($pInfo);
                $cnt++;

                # Get product style group total variant
                $pTotalVariant = $this->getTotalVariantByStyleGroupId($pInfo[$this->Data[F_F_KEY]]);

                if($pTotalVariant['product_variant'] < 1)
                {
                    # Delete product style group
                    ProductStyleGroup::obj(true)->Delete($pInfo[$this->Data[F_F_KEY]]);
                }
                else
                {
                    # Update deleted product style group info
                    ProductStyleGroup::obj(true)->UpdateStyleGroupInfoByPSGId($pInfo[$this->Data[F_F_KEY]]);
                }
            }
        }
        else
        {
            # Delete product images and additional images
            $return = $this->DeleteProductImages($info);

            # Get product style group total variant
            $pTotalVariant = $this->getTotalVariantByStyleGroupId($info[$this->Data[F_F_KEY]]);

            if($pTotalVariant['product_variant'] < 1)
            {
                # Delete product style group
                ProductStyleGroup::obj(true)->Delete($info[$this->Data[F_F_KEY]]);
            }
            else
            {
                # Update deleted product style group info
                ProductStyleGroup::obj(true)->UpdateStyleGroupInfoByPSGId($info[$this->Data[F_F_KEY]]);
            }
        }

        return $return;
    }
    public function DeleteProductImages($info)
    {
        if(is_array($info) && count($info) > 0)
        {
            # Get product images path
            $p_up = Utility::obj()->DateTimeBasedUploadLocation($this->Data[P_UP],$info[$this->Data[F_ADDED_DATETIME]],false,false);

            # Get product images information from ProdutImages by product ID
            $Product_Images = ProductImages::obj()->getProductImagesInfoByProductID($info[$this->Data[F_P_KEY]]);

            ### Processing for product additinal images
            # Get product additional images path
            $paddimg_up = Utility::obj()->DateTimeBasedUploadLocation(ProductAdditionalImages::obj()->Data[P_UP],$info[$this->Data[F_ADDED_DATETIME]],false,false);

            # Get product additional images information from ProductAdditionalImages by product ID
            $Product_AddImages = ProductAdditionalImages::obj()->getProductAdditionalImagesInfoByProductID($info[$this->Data[F_P_KEY]]);

            # Delete product and its images into database
            $return = parent::Delete($info[$this->Data[F_P_KEY]]);

            if(!empty($Product_Images))
            {
                if(is_array($Product_Images) && count($Product_Images) > 0)
                {
                    foreach($Product_Images as $key => $info)
                    {
                        $file = $p_up."/".$info['proimg_image_file'];

                        # If file exist then remove this file
                        if(file_exists($file))
                            unlink($file);
                    }
                }
                else
                {
                    $file = $p_up."/".$Product_Images['proimg_image_file'];

                    # If file exist then remove this file
                    if(file_exists($file))
                        unlink($file);
                }

                # Read directory
                $dir_content = Utility::obj()->readDirectory($p_up);

                # Check directry is empty then remove it.
                if((!is_array($dir_content) && count($dir_content) <= 0) || empty($dir_content))
                    Utility::obj()->deleteDirectory($p_up);
            }

            if(!empty($Product_AddImages))
            {
                if(is_array($Product_AddImages) && count($Product_AddImages) > 0)
                {
                    foreach($Product_AddImages as $key => $info)
                    {
                        $file = $paddimg_up."/".$info['paddimg_image_file'];

                        # If file exist then remove this file
                        if(file_exists($file))
                            unlink($file);
                    }
                }
                else
                {
                    $file = $paddimg_up."/".$Product_AddImages['paddimg_image_file'];

                    # If file exist then remove this file
                    if(file_exists($file))
                        unlink($file);
                }

                # Read directory
                $dir_content = Utility::obj()->readDirectory($paddimg_up);

                # Check directry is empty then remove it.
                if((!is_array($dir_content) && count($dir_content) <= 0) || empty($dir_content))
                    Utility::obj()->deleteDirectory($paddimg_up);
            }

            return $return;
        }
        else
            return false;
    }
    public function _BasicResponseProcess($Action, $POST, $file_name, $objController = false)
    {
        global $msgError, $msgSuccess;
        if($Action == A_STOCK_IN_OUT)
		{

			if(isset($POST['stock']) && !empty($POST['stock']))
                $affected_row = $this->UpdateQuntityFieldById($POST['stock'],$POST['pk']);

            if(defined('IN_XAJAX'))
			{
				if($affected_row == 1)
					$_GET['stock'] = $POST['stock'];
			}
			else
			{
			    if($affected_row == 1)
					header("location: ".$file_name."stock=".$POST['stock']);
				else
					header("location: ".$file_name."stock=".$POST['stock']);

				exit();
			}
		}
		elseif($Action == A_STOCK_IN_OUT_SEL)
		{

            if(isset($POST['stock']) && !empty($POST['stock']))
                $affected_row = $this->UpdateQuntityFieldById($POST['stock'],$POST['pk_list']);

            if(defined('IN_XAJAX'))
			{
				if($affected_row == 1)
					$_GET['stock'] = $POST['stock'];
			}
			else
			{
			    if($affected_row == 1)
					header("location: ".$file_name."stock=".$POST['stock']);
				else
					header("location: ".$file_name."stock=".$POST['stock']);

				exit();
			}
		}
        elseif($Action == A_ADD_REMOVE_READY_TO_DISPATCH)
		{
			$this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_ready_to_dispatch';

            $affected_row = $objController->ActiveInactive($POST['pk'], $POST['active']);


		    if($affected_row == 1)
				header("location: ".$file_name."readytodispatch=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_READY_TO_DISPATCH_SEL)
        {
            $this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_ready_to_dispatch';

			$affected_row = $objController->ActiveInactive($POST['pk_list'], $POST['active']);


			if($affected_row > 0)
				header("location: ".$file_name."readytodispatch=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_HOT_FAVOURITE)
		{
			$this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_hot_favourite';

            $affected_row = $objController->ActiveInactive($POST['pk'], $POST['active']);

		    if($affected_row == 1)
				header("location: ".$file_name."ishotfavourite=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_HOT_FAVOURITE_SEL)
        {
            $this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_hot_favourite';

			$affected_row = $objController->ActiveInactive($POST['pk_list'], $POST['active']);

			if($affected_row > 0)
				header("location: ".$file_name."ishotfavourite=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_IS_FEATURED)
		{
			$this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_featured';

            $affected_row = $objController->ActiveInactive($POST['pk'], $POST['active']);


		    if($affected_row == 1)
				header("location: ".$file_name."isfeatured=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_IS_FEATURED_SEL)
        {
            $this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_featured';

			$affected_row = $objController->ActiveInactive($POST['pk_list'], $POST['active']);


			if($affected_row > 0)
				header("location: ".$file_name."isfeatured=".$POST['is_active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_IS_UPCOMING)
		{
            $this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_upcoming';

            $affected_row = $objController->ActiveInactive($POST['pk'], $POST['active']);


		    if($affected_row == 1)
				header("location: ".$file_name."isupcoming=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_IS_UPCOMING_SEL)
        {
            $this->Data[F_ACTIVE] = $this->Data[FIELD_PREFIX].'is_upcoming';

			$affected_row = $objController->ActiveInactive($POST['pk_list'], $POST['active']);


			if($affected_row > 0)
				header("location: ".$file_name."isupcoming=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_PURCHASE)
		{
			$POST['purchase']   =   true;

            $affected_row = $objController->UpdateEnablePurchaseAndInquiryField($POST['pk'], $POST);


		    if($affected_row == 1)
				header("location: ".$file_name."purchase=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_PURCHASE_SEL)
        {
            $POST['purchase']   =   true;

            $affected_row = $objController->UpdateEnablePurchaseAndInquiryField($POST['pk_list'], $POST);


			if($affected_row > 0)
				header("location: ".$file_name."purchase=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_INQUIRY)
        {
            $affected_row = $objController->UpdateEnablePurchaseAndInquiryField($POST['pk'], $POST);


			if($affected_row > 0)
				header("location: ".$file_name."inquiry=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
        elseif($Action == A_ADD_REMOVE_INQUIRY_SEL)
        {
            $affected_row = $objController->UpdateEnablePurchaseAndInquiryField($POST['pk_list'], $POST);


			if($affected_row > 0)
				header("location: ".$file_name."inquiry=".$POST['active']);
			else
				header("location: ".$file_name."error=true");

			exit();
		}
    }

    public function _Update($pkValue, $POST)
	{

        # Get product info by product id
        $proInfo    =   $this->IsProductExist($pkValue);
        $TESID      =   ProductStyleGroup::obj()->StyleGroupId('E',$proInfo[$this->Data[F_F_KEY]]);

        # Check product post product category and product category is same
        if(isset($POST[CategoryMaster::obj()->Data[F_P_KEY]]))
        {
            $arrCat = explode(',',$proInfo['product_cm_id']);

            end($arrCat);

            if($POST[CategoryMaster::obj()->Data[F_P_KEY]]!= $arrCat[key($arrCat)])
            {
                $this->Error[E_DESC] = "Sorry, you can not change your product category.";
                return false;
            }
        }

        if($POST[ProductStyleGroup::obj()->Data[F_P_KEY]] != '')
        {
            $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] = trim($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

            if($POST[ProductStyleGroup::obj()->Data[F_P_KEY]] != $TESID)
            {
                $ProductInfo = array();

                # Get product info by style group id
                $ProductInfo = $this->getProductInfoByStyleGroupId($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

                # Get product info by style group id
                $OldStyleGroupInfo = $this->getProductInfoByStyleGroupId($proInfo[$this->Data[F_F_KEY]]);

                # Check style group no is exist or not
                if(is_array($ProductInfo) && count($ProductInfo) > 0)
                {
                    # Check group of total product
                    if($ProductInfo['product_variant'] > PRODUCT_STYLE_GROUP_MAX_ITEM)
                    {
                        $this->Error[E_DESC] = 'Sorry, you can add only '.PRODUCT_STYLE_GROUP_MAX_ITEM.' item in '.$POST[ProductStyleGroup::obj()->Data[F_P_KEY]].' style group id. Please create another style group no.';
                        return false;
                    }
                }
                else
                {
                    # Set group id
                    $POST['group_id'] = $POST[ProductStyleGroup::obj()->Data[F_P_KEY]];

                    # Unset psg_id for new insert psg_id
                    unset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);
                }
            }
        }
        else
        {
            # Set group id
            $POST['group_id'] = 'G0';

            # Unset psg_id for new insert psg_id
            unset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

            # Get product info by style group id
            $OldStyleGroupInfo = $this->getProductInfoByStyleGroupId($proInfo[$this->Data[F_F_KEY]]);
        }

        # Set updated date time
        $POST['name']   =   ucwords(strtolower($POST['name']));
        $procat_id      =   $POST[CategoryMaster::obj()->Data[F_P_KEY]];
        //$arr_sup        =   $POST['supplier_id'];
        $sup            =   $POST[BusinessMaster::obj()->Data[F_P_KEY]];
        $arrTag         =   isset($POST['ptag_safe_url'])?$POST['ptag_safe_url']:'';

        $this->Data[F_F_INFO]['discount'][CNT_TYPE] = C_HIDDEN;
        $POST['discount']   = round((($POST['max_retail_price']-$POST['selling_price'])*100)/$POST['max_retail_price']);
        $this->Data[F_F_INFO]['updated_datetime'][CNT_TYPE] = C_HIDDEN;
        $POST['updated_datetime']   = date('Y-m-d H:i:s');

        if(isset($POST['quantity']) && $POST['quantity'] == 0)
        {
            $this->Data[F_F_INFO]['stockout_datetime'][CNT_TYPE]    = C_HIDDEN;
            $this->Data[F_F_INFO]['stockout_by'][CNT_TYPE]          = C_HIDDEN;

            $POST['stockout_datetime']  =   date('Y-m-d H:i:s');
            $POST['stockout_by']        =   STOCKOUT_MANUALLY;
        }

        if(isset($POST['quantity']) && $POST['quantity'] > 0)
        {
           $this->Data[F_F_INFO]['stockout_by'][CNT_TYPE]   = C_HIDDEN;
           $POST['stockout_by']        =   STOCKOUT_NONE;
        }

        if(isset($POST[BusinessMaster::obj()->Data[F_P_KEY]]) && is_numeric(Ocrypt::dec($POST[BusinessMaster::obj()->Data[F_P_KEY]])))
            $POST[BusinessMaster::obj()->Data[F_P_KEY]] = Ocrypt::dec($POST[BusinessMaster::obj()->Data[F_P_KEY]]);


        #unset Category id and Supplier id before update called.
        unset($this->Data[F_F_INFO][CategoryMaster::obj()->Data[F_P_KEY]]);
        //unset($this->Data[F_F_INFO]['supplier_id']);
        unset($this->Data[F_F_INFO]['ptag_safe_url']);

        # Set safe URL and unset it as its not possible to be a unique
        $this->getSafeUrl($POST);
        unset($this->Data[F_S_URL]);

        # Set populate schema true
        ProductStyleGroup::obj()->populateSchema(true);

        # If product style id not set in post then insert record into oe_product_style_group
        if(!isset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]))
        {
            $SPOST['product_info'] = '';
            $SPOST['image_info'] = '';
            $SPOST['req_feature_info'] = '';

            # Insert data into product style group table
            $psd_id  = ProductStyleGroup::obj()->Insert($SPOST);

            if(is_numeric($psd_id))
            {
                $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] = $psd_id;
            }
            else
                return false;
        }

        if(isset($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]) && $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] != '' && !is_numeric($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]))
            $POST[ProductStyleGroup::obj()->Data[F_P_KEY]] =  ProductStyleGroup::obj()->StyleGroupId('D',$POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);


        $affected_rows =  parent::Update($pkValue, $POST);

        # Check post psg_id or product psg_id is not same
        if($POST[ProductStyleGroup::obj()->Data[F_P_KEY]] != $proInfo[$this->Data[F_F_KEY]])
        {
            # Update product feature style group id
            $sets   =   " pfeature_psg_id = ? ";
            $where  =   ProductFeature::obj()->Data[F_F_KEY]." = ? ";

            ProductFeature::obj()->UpdateFieldByParam($sets, $where, array($POST[ProductStyleGroup::obj()->Data[F_P_KEY]],$pkValue));

            if(isset($OldStyleGroupInfo) && is_array($OldStyleGroupInfo) && count($OldStyleGroupInfo) > 0)
            {
                # Check for style group in only 1 product then reremoved it and insert into entered or new style group.
                if($OldStyleGroupInfo['product_variant'] <= 1)
                {
                    # Delete product style group
                    ProductStyleGroup::obj()->Delete($proInfo[$this->Data[F_F_KEY]]);
                }
                else
                {
                    # Update old product style group info
                    ProductStyleGroup::obj()->UpdateStyleGroupInfoByPSGId($proInfo[$this->Data[F_F_KEY]]);
                }
            }
            # Update new product style group info
            ProductStyleGroup::obj()->UpdateStyleGroupInfoByPSGId($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);

        }
        elseif(isset($POST['safe_url']) && $POST['safe_url'] != '')
        {
            # Update product style group info [product_id*product_safe_url]
            ProductStyleGroup::obj(true)->UpdateStyleGroupProductInfoById($POST[ProductStyleGroup::obj()->Data[F_P_KEY]]);
        }

        if(isset($POST[CategoryMaster::obj()->Data[F_P_KEY]]))
        {
            $cat_info = CategoryMaster::obj()->getAllParentCataegoryByChildCategory($procat_id);

            if(isset($cat_info['product_cm_list']) && $cat_info['product_cm_list'] != '')
            {
                ProductCategory::obj()->_Insert($pkValue, $cat_info);
            }
            elseif(!is_numeric($POST[CategoryMaster::obj()->Data[F_P_KEY]]))
            {
                $this->Error[E_DESC] = "Sorry, you can not change your product category.";
                return false;
            }

            if(isset($sup) && !empty($sup))
                ProductSupplier::obj()->_Insert($pkValue, $sup);

            # Inssert into product tag table
            ProductTag::obj()->_Insert($pkValue, $arrTag);
        }
        return $affected_rows;
	}
    function getProductInfoByStyleGroupId($psg_id)
    {
        /*if($psg_id == '' || is_numeric($psg_id))
            return false;*/
        if(!is_numeric($psg_id))
            $psg_id = ProductStyleGroup::obj()->StyleGroupId('D',$psg_id);

        $F_CustomSelect = " 
        MTBL.".$this->Data[F_F_KEY].",MTBL.product_group_id,
        MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].",MTBL.".$this->Data[F_S_URL].",MTBL.".$this->Data[F_ADDED_DATETIME].",
        MTBL.product_is_ready_to_dispatch,MTBL.product_quantity, MTBL.product_min_order_qty, MTBL.product_is_hot_favourite, MTBL.product_is_featured,
        MTBL.product_image_type, MTBL.product_selling_price, MTBL.product_max_retail_price,
        MTBL.product_enable_inquiry, MTBL.product_enable_purchase, MTBL.product_is_upcoming, MTBL.product_discount,
        (
            SELECT SUM(SPM.product_quantity) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = MTBL.".$this->Data[F_F_KEY]."
        ) AS produt_total_quntity,
        (
            SELECT COUNT(*) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = MTBL.".$this->Data[F_F_KEY]."
        ) AS product_variant,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('|',SPCM.".CategoryMaster::obj()->Data[F_P_KEY].",SPCM.".CategoryMaster::obj()->Data[F_S_URL]."))
            FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
            INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            ORDER BY SPCM.cm_level ASC
        ) AS product_cm_safe_url";

        $param = " MTBL.".$this->Data[F_F_KEY]." = ? ";
        $value[] = $psg_id;

        return parent::getInfoByParam($param,$value,$F_CustomSelect,$Join=false, $type=PDO_FETCH_SINGLE, $index_key=false);
    }
    public function getTotalVariantByStyleGroupId($psg_id)
    {
        if(!is_numeric($psg_id))
            $psg_id = ProductStyleGroup::obj()->StyleGroupId('D',$psg_id);

        $F_CustomSelect = "
        (
            SELECT COUNT(*) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = MTBL.".$this->Data[F_F_KEY]."
        ) AS product_variant";

        $param = " MTBL.".$this->Data[F_F_KEY]." = ? ";
        $value[] = $psg_id;

        return parent::getInfoByParam($param,$value,$F_CustomSelect,$Join=false, $type=PDO_FETCH_SINGLE, $index_key=false);


    }
    /*function getProductFullInfoById($product_id)
    {
        if(!is_numeric($product_id))
            return false;

        $F_CustomSelect = "MTBL.*,
        (
            SELECT COUNT(*) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.product_psg_id = MTBL.product_psg_id
        ) AS product_variant,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('|',SPCM.".CategoryMaster::obj()->Data[F_P_KEY].",SPCM.".CategoryMaster::obj()->Data[F_S_URL]."))
            FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
            INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
            ORDER BY SPCM.cm_level ASC
        ) AS product_cm_safe_url";

        $param = $this->Data[F_P_KEY]." = ? ";
        $value[] = $product_id;

        return parent::getInfoByParam($param,$value,$F_CustomSelect,$Join=false, $type=PDO_FETCH_SINGLE, $index_key=false,$a='test');
    }*/
    public function IsProductExist($product_id)
    {
        if(!is_numeric($product_id))
            return false;

        $F_CustomSelect = "MTBL.*,GROUP_CONCAT(DISTINCT BUSM.".BusinessMaster::obj()->Data[F_P_KEY].") AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_KEY].",
        GROUP_CONCAT(DISTINCT PC." .ProductCategory::obj()->Data[F_P_FIELD].") AS ".$this->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_KEY].",
        (
            SELECT COUNT(*) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.product_psg_id = MTBL.product_psg_id
        ) AS product_variant
        ";

        $param = $this->Data[F_P_KEY]." = ".$product_id;

        $Join = " LEFT JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " LEFT JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." CM ON PC.".ProductCategory::obj()->Data[F_P_FIELD]." = CM.".CategoryMaster::obj()->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PS ON MTBL.".$this->Data[F_P_KEY]." = PS.".ProductSupplier::obj()->Data[F_F_KEY];

        $product_info = parent::getInfoByParam($param, $value=false, $F_CustomSelect, $Join, $type=PDO_FETCH_SINGLE, $index_key=false);

        if(is_array($product_info) && count($product_info) > 0 && isset($product_info[$this->Data[F_P_KEY]]) && $product_info[$this->Data[F_P_KEY]] == $product_id)
            return $product_info;
        else
            return false;
    }
    public function getHotFavouriteProductInfo($limit=false)
    {
        $Custom_Param[CUST_SORT_ORDER_STR]  =   " ORDER BY RAND() ";

        $Custom_Param[SQL_LIMIT] = " 0,".(($limit!=false)?$limit:5);

        $addParameters = " AND product_is_hot_favourite = ?  ";

        return parent::getAll($addParameters, array(YES), $Join=false, $Custom_Param);
    }
    public function getFeaturedProductInfo($limit=false)
    {
        $Custom_Param[CUST_SORT_ORDER_STR]    =   " ORDER BY RAND() ";

        $Custom_Param[SQL_LIMIT] = " 0,".(($limit!=false)?$limit:5);

        $addParameters = " AND product_is_featured = ? ";

        return parent::getAll($addParameters,array(YES),$Join=false, $Custom_Param);
    }
    public function GetFullProductUrlForAdmin($product_id)
    {
        global $virtual_path;

	    if(!is_numeric($product_id))
	       return false;

        $product_id = Ocrypt::enc($product_id);

        $url = $virtual_path['User_Root']."/". $this->Data['ScriptName']."?Action=".A_VIEW."&pk=".$product_id."&popup=true";
        return $url;
    }
    public function UpdateStockOutDateAndByFieldById($product_id)
    {
        $sets   =   " product_stockout_datetime = ? , product_stockout_by = ?";
        $where  =   " product_quantity = ? AND product_id = ? ";
        parent::UpdateFieldByParam($sets,$where,array(date('Y-m-d H:i:s'),STOCKOUT_AUTO,0,$product_id));
    }
    public function UpdateUpdatedDateTimeById($product_id)
    {
        $sets   =   " product_updated_datetime = ? ";
        $where  =   " product_id = ? ";
        parent::UpdateFieldByParam($sets,$where,array(date('Y-m-d H:i:s'),$product_id));
    }
    public function UpdateQuntityFieldById($stock,$product_id)
    {
        if(is_array($product_id))
            $product_id = implode(',',$product_id);

        if ($stock == 'stock-out')
        {
            $sets   =   " product_quantity = ? ,product_stockout_by = ?,product_stockout_datetime = ?";
            $where  =   " product_id IN (". $product_id. ") ";
            return parent::UpdateFieldByParam($sets,$where,array(0,STOCKOUT_MANUALLY,date('Y-m-d H:i:s')));
        }
        else
        {
            $sets   =   " product_quantity = ? ,product_stockout_by = ?";
            $where  =   " product_id IN (". $product_id. ") ";
            return parent::UpdateFieldByParam($sets,$where,array(2,STOCKOUT_NONE));
        }
    }
    public function getProductNameById($product_id)
    {
        if(!is_numeric($product_id))
            return false;

        $info = parent::getInfoById($product_id);
        if(is_array($info))
            return $info['product_name'];
        else
            return false;
    }
    public function AutoDetectProductDirectory($product_id, $cleanup_doc=false)
    {
        $info = $this->getInfoById($product_id);
        ProductImages::obj(true);
        $path = ProductImages::obj()->Data[P_UP]."/".$info['product_group_number'];

        if(!is_dir($path))
            return false;

        if($cleanup_doc == true)
        {
             # Delete all previously added record form product images by product id
            ProductImages::obj()->DeleteAllProductImagesByProductID($product_id);
        }

        # Read directory for files
        $file_list = Utility::obj()->readDirectory($path);

        # Change field info
        ProductImages::obj()->Data[F_F_INFO]['image_file'][CNT_TYPE] = C_HIDDEN;
        ProductImages::obj()->Data[F_F_INFO]['title'][CNT_TYPE] = C_HIDDEN;

        # Insert all record from directory to catalog images
        foreach($file_list as $key => $filename)
        {
            //$fileTitle      =   substr($filename, 25);
            $title          =   explode(".",$filename);
            if(strpos($title[0],'-') == 24)
            {
                $name = substr($title[0], 25);
                $_post['title'] = $info['product_name']."-".$name;

            }
            else
                $_post['title'] =   $info['product_name']."-".$title[0];

            $_post['image_file']= $filename;
            $_post['is_active']=  YES;

            ProductImages::obj()->_Insert($_post,$product_id);
        }

        ProductImages::obj()-> setAlbumCoverIfNotFound($product_id);

        return true;
    }
    public function getRelatedProductByCatagoryID($category_id, $product_id, $limit = 9)
    {
        $addParameters = '';
        $value = '';

        $POST[CategoryMaster::obj()->Data[F_P_KEY]] = $category_id;

        $addParameters  =   " AND ".$this->Data[F_P_KEY]." != ?  AND ".$this->Data[F_ACTIVE]." = ? AND product_quantity > ? ";
        $value[]        =   $product_id;
        $value[]        =   YES;
        $value[]        =   0;

        //$Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,MTBL.product_is_ready_to_dispatch,MTBL.product_quantity,MTBL.product_is_hot_favourite,MTBL.product_image_type,MTBL.product_group_number, MTBL.product_selling_price,MTBL.product_real_price,MTBL.product_enable_inquiry,MTBL.product_enable_purchase, (SELECT GROUP_CONCAT(PI.proimg_id SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_id, (SELECT GROUP_CONCAT(PI.proimg_filename SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_name,(SELECT GROUP_CONCAT(PI.proimg_alt SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_alt,(SELECT GROUP_CONCAT(PI.proimg_title SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_title";
        $Custom_Param[F_B_SELECT] =   "
        MTBL.product_id, MTBL.product_name, MTBL.product_safe_url, MTBL.product_is_ready_to_dispatch,
        MTBL.product_quantity, MTBL.product_min_order_qty, MTBL.product_is_hot_favourite, MTBL.product_is_featured,
        MTBL.product_image_type, MTBL.product_sku, MTBL.product_selling_price, MTBL.product_max_retail_price,
        MTBL.product_enable_inquiry, MTBL.product_enable_purchase, MTBL.product_is_upcoming,
        (
            SELECT GROUP_CONCAT(CONCAT_WS('*',PI.".ProductImages::obj()->Data[F_P_KEY].",PI.proimg_image_file,PI.".ProductImages::obj()->Data[F_P_FIELD].") ORDER BY proimg_is_cover DESC SEPARATOR '|')
            FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
        ) AS product_images_info";

        $Join  = " LEFT JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PC ON FIND_IN_SET(PC.".CategoryMaster::obj()->Data[F_P_KEY]." ,MTBL.".$this->Data[F_F_KEY].")";
        //$Join .= " LEFT JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON FIND_IN_SET(SUP.".Supplier::obj()->Data[F_P_KEY]." ,MTBL.product_supplier_id)";
        $Join .= " LEFT JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON MTBL.product_protype_id = PTM.".ProductTypeMaster::obj()->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON MTBL.".$this->Data[F_P_KEY]." = PF.".ProductFeature::obj()->Data[F_F_KEY];
        //$Join .= " LEFT JOIN ".FeatureValueMaster::obj()->Data[TABLE_NAME]." FVM ON PF.".ProductFeature::obj()->Data[F_P_FIELD]." = FVM.".FeatureValueMaster::obj()->Data[F_F_KEY];
        //$Join .= " LEFT JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." FM ON FVM.".FeatureValueMaster::obj()->Data[F_F_KEY]." = FM.".FeatureMaster::obj()->Data[F_P_KEY];

        $pamars	        =	$this->getQueryParameters($POST);
        $addParameters  .=  $pamars['sql'];

        if(is_array($value) && is_array($pamars['value']))
            $value = array_merge($value,$pamars['value']);
        elseif(is_array($pamars['value']))
            $value =   $pamars['value'];

        $Custom_Param[CUST_SORT_ORDER_STR]   =   " ORDER BY RAND() ";

        if(is_numeric($limit))
            $Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

        //$Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.proimg_is_cover = '".YES."' ";
        return parent::getAll($addParameters,$value, $Join, $Custom_Param);
    }
    public function getRelatedProducts($arrLFVInfo, $limit=false)
    {
        $addParameters = '';
        $value = '';

        if(!is_array($arrLFVInfo) && count($arrLFVInfo)<=0)return false;

        $POST[QP_CATEGORY]  =   $arrLFVInfo['product_cm_safe_url'];
        $POST[QP_PRICE]     =   ($arrLFVInfo['product_selling_price']-'100').'-'.($arrLFVInfo['product_selling_price']+'100');
        //$POST[QP_PTYPE]     =   $arrLFVInfo['product_protype_safe_url'];
        //$POST['discount']   =   $arrLFVInfo['product_discount'];
        //$POST[QP_FEATURE]   =   $arrPFList;

        $Custom_Param[F_B_SELECT] =   "
        MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].", MTBL.".$this->Data[F_S_URL].", MTBL.".$this->Data[F_ADDED_DATETIME].", MTBL.product_is_ready_to_dispatch,
        MTBL.product_min_order_qty, MTBL.product_is_hot_favourite, MTBL.product_is_featured,
        MTBL.product_image_type, MTBL.product_selling_price, MTBL.product_max_retail_price,
        MTBL.product_enable_inquiry, MTBL.product_enable_purchase, MTBL.product_is_upcoming,MTBL.product_quantity,
        (
            SELECT SUM(SPM.product_quantity) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
        ) AS product_group_quantity,
        PSG.".ProductStyleGroup::obj()->Data[F_P_KEY].",PSG.".ProductStyleGroup::obj()->Data[F_P_FIELD].",PSG.psg_image_info";

        $Join = '';
        $Join .= " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        //$Join .= " INNER JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON MTBL.product_protype_id = PTM.".ProductTypeMaster::obj()->Data[F_P_KEY];
        $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
        $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
        $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
        //$Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
        //$Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];


        $addParameters  =   " AND MTBL.".$this->Data[F_P_KEY]." != ? AND MTBL.".$this->Data[F_F_KEY]." != ?  AND MTBL.".$this->Data[F_ACTIVE]." = ? AND MTBL.product_quantity > ? ";
        $value          =   array($arrLFVInfo[$this->Data[F_P_KEY]],$arrLFVInfo[$this->Data[F_F_KEY]],YES,'0');

        # Get all search filters based on params
        $pamars =   $this->getQueryParameters($POST);
        $addParameters  .=  $pamars['sql'];

        if(is_array($value) && is_array($pamars['value']))
            $value = array_merge($value,$pamars['value']);
        elseif(is_array($pamars['value']))
            $value =   $pamars['value'];

        if($limit == false)
            $limit = '20';

        $Custom_Param[GROUP_BY] = " PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]." ";
        $Custom_Param[CUST_SORT_ORDER_STR]   =   " ORDER BY product_selling_price ASC ";

        $Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

        return parent::getAll($addParameters,$value, $Join, $Custom_Param);
    }
    public function  getProductSearchSuggestion($str, $limit=50)
    {
        $Custom_Param[F_B_SELECT] ="
            MTBL.".$this->Data[F_P_KEY].",
            MTBL.".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_KEY].",
            MTBL.".$this->Data[F_P_FIELD].",
            MTBL.product_second_line,
            MTBL.product_selling_price,
            MTBL.product_weight,
            MTBL.product_quantity,
            MTBL.product_min_order_qty,
            MTBL.product_protype_id,
            MTBL.product_sku,
            MTBL.product_selling_price,
            MTBL.product_psg_id,
            MTBL.product_group_id,
            MTBL.product_added_datetime,
            
            PI.".ProductImages::obj()->Data[F_P_KEY].",
            PI.proimg_image_file,
            
            BUSM.".BusinessMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_FIELD].",
            
            (
	            SELECT CONCAT(SPCM.cm_tax_percentage,'|',SPCM.cm_addi_tax_percentage)
	            FROM ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM
	            INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." SPC ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
	            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
	            ORDER BY SPCM.cm_level DESC LIMIT 1
            ) AS ".$this->Data[FIELD_PREFIX]."tax,
            (
                SELECT GROUP_CONCAT(CONCAT(CONCAT_WS('[]',FM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title,FVM.".FeatureValueMaster::obj()->Data[F_P_FIELD]."),'*',(CONCAT_WS('[]',FM.".FeatureMaster::obj()->Data[F_P_KEY].",FVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."))) SEPARATOR '|')
                FROM ".ProductFeature::obj()->Data[TABLE_NAME]." PF,
                ".FeatureMaster::obj()->Data[TABLE_NAME]." FM,
                ".FeatureValueMaster::obj()->Data[TABLE_NAME]." FVM
                WHERE PF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." = FM.".FeatureMaster::obj()->Data[F_P_KEY]."
                AND PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = FVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
                AND FM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '1'
                GROUP BY MTBL.product_id
            ) AS ".$this->Data[FIELD_PREFIX]."required_feature
            ";

        $searchFields   =   array('product_name', 'product_second_line','product_short_desc','product_sku');
	    $addParameters  =   " AND ".$this->Data[F_ACTIVE]." = ? AND product_quantity > ? ";

        $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = '".YES."' AND PI.proimg_is_cover = '".YES."' ";
        $Join .= " LEFT JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id AND BUSM.".BusinessMaster::obj()->Data[F_ACTIVE]." = '".YES."' AND BUSM.busm_is_verified = '".YES."' AND BUSM.".BusinessMaster::obj()->Data[F_VIRTUAL_DELETE]." = '".NO."' AND BUSM.busm_is_blocked = '".NO."' ";
        //$Join .= " LEFT JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON PTM.".ProductTypeMaster::obj()->Data[F_P_KEY]." = MTBL.product_protype_id ";

	    return parent::getAutoSuggestionRecord($str, $searchFields, $addParameters, array(YES,0), $Custom_Param, $Join, $limit);
    }

    public function GetRandomProductForLoginSignup($limit=2)
    {
        $Custom_Param[F_B_SELECT] = " MTBL.*,PI.* ";

        $addParameters = " AND MTBL.".$this->Data[F_ACTIVE]." = ? AND MTBL.product_quantity > ? ORDER BY RAND() LIMIT 0,".$limit;

        $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = ? AND PI.proimg_is_cover = ?";

        $rs = parent::getAll($addParameters, array(YES,YES, YES, 0), $Join, $Custom_Param);

        return $rs->fetch_record();
    }
	/**
	 * @GetNewArrivalProducts
	 *
	 * method will get latest product based on added datetime in database
	 * Basically it will chewck for latest added datetime DESC .
	 **/
	public function GetNewArrivalProducts($limit=false)
	{
		$Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY product_added_datetime DESC ";

		if(is_numeric($limit))
			$Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

		$Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,MTBL.product_is_featured,MTBL.product_is_hot_favourite,MTBL.product_is_ready_to_dispatch,MTBL.product_quantity,MTBL.product_added_datetime,MTBL.product_image_type,MTBL.product_sku, MTBL.product_selling_price,MTBL.product_max_retail_price, (SELECT GROUP_CONCAT(PI.proimg_id SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_id, (SELECT GROUP_CONCAT(PI.proimg_image_file SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_name,(SELECT GROUP_CONCAT(PI.proimg_alt SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_alt,(SELECT GROUP_CONCAT(PI.proimg_title SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_title ";

		$addParameters = " AND product_quantity > ? AND ".$this->Data[F_ACTIVE]." = ? ";

		//$Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = ? AND PI.proimg_is_cover = ? ";

		return parent::getAll($addParameters,array(0,YES), $Join = false, $Custom_Param);
	}
    /**
     * @GetLatestProduct
     *
     * method will get latest product based on added and updated datetime in database
     * Basically it will chewck for latest added datetime DESC and after check for updated datetime.
    **/
    public function GetLatestProduct($limit=false)
    {
        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY RAND(), product_added_datetime DESC, product_updated_datetime DESC ";
        $Custom_Param[SQL_LIMIT] = " 0,".(($limit!=false)?$limit:5);
        $Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url ";

        $addParameters = " AND ".$this->Data[F_ACTIVE]." = ? ";

        return parent::getAll($addParameters, array(YES), $Join=false, $Custom_Param);
    }
    public function getAllProductInfoByProductID($product_id, $limit=false)
    {
        if(empty($product_id))
            return false;

        if(isset($limit) && is_numeric($limit))
            $Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

        if(is_array($product_id) && count($product_id) > 0)
            $id = implode(",",$product_id);
        else
            $id = $product_id;

        $Custom_Param[F_B_SELECT] =   "
            MTBL.".$this->Data[F_P_KEY].",MTBL.".$this->Data[F_P_FIELD].",MTBL.".$this->Data[F_S_URL].",
            MTBL.product_is_ready_to_dispatch,
            MTBL.product_is_hot_favourite,MTBL.product_image_type,MTBL.product_selling_price,
            MTBL.product_max_retail_price,MTBL.product_added_datetime,MTBL.product_sku,MTBL.product_discount,MTBL.product_quantity,MTBL.".$this->Data[F_F_KEY].",
            (
                SELECT SUM(SPM.product_quantity) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
            ) AS product_group_quantity,
            PSG.*";
            /*(
                SELECT GROUP_CONCAT(CONCAT_WS('*',PI.".ProductImages::obj()->Data[F_P_KEY].",PI.proimg_image_file,PI.".ProductImages::obj()->Data[F_P_FIELD].") SEPARATOR '|')
                FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI
                WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                ORDER BY proimg_is_cover DESC
            ) AS product_images_info";*/

        $addParameters = " AND MTBL.".$this->Data[F_P_KEY]." IN(".$id.") AND MTBL.".$this->Data[F_ACTIVE]." = '".YES."'";

        $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = '".YES."' AND PI.proimg_is_cover = '".YES."' ";
        $Join .= " INNER JOIN ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG ON MTBL.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];

        /*if(isset($type) && !empty($type) && $type != COOKIE_TE_WL)
            $Custom_Param[GROUP_BY]   =   " PSG.".ProductStyleGroup::obj()->Data[F_P_KEY];*/

        return parent::getAll($addParameters, false, $Join, $Custom_Param);
    }
    public function getProductInfoByProductIdForNewsletter($product_id)
    {
        if(is_array($product_id))
        {
            foreach($product_id as $key => $id)
            {
                $this->Data[F_B_SELECT] = "MTBL.*, (SELECT GROUP_CONCAT(PI.proimg_id) FROM oe_product_images PI WHERE MTBL.product_id = PI.proimg_product_id) product_image ";
                $param = $this->Data[F_P_KEY]." = ? AND product_is_active = ?";
                $value = array($id,YES);
                //$Join = " LEFT JOIN ".CatalogImages::obj()->Data[TABLE_NAME]." CI ON CI.".CatalogImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND CI.".CatalogImages::obj()->Data[F_ACTIVE]." = '".YES."' AND CI.catalogimg_is_cover = '".YES."' ";
                $product = parent::getInfoByParam($param, $value,false, false);

                if(is_array($product))
                    $product_info[] = $product;
            }
         }
         if(isset($product_info))
            return $product_info;
         else
            return false;
    }
	/**
	 * All methodes related with shopping cart
	 **/
	/*public function getProductInfoForShoppingCartById($product_id,$ref_required)
    {
        if(!is_numeric($product_id) && !is_array($ref_required))
			return false;

        $this->Data[F_B_SELECT] = "
            MTBL.".$this->Data[F_P_KEY].", MTBL.".$this->Data[F_ADDED_DATETIME].",
            MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY].", MTBL.".$this->Data[F_P_FIELD].", MTBL.".$this->Data[F_S_URL].",
            MTBL.product_price, MTBL.product_selling_price, MTBL.product_max_retail_price,
            MTBL.product_quantity,MTBL.product_min_order_qty, MTBL.product_weight,MTBL.".$this->Data[F_ACTIVE].",
            MTBL.product_image_type,MTBL.product_sku,MTBL.product_enable_purchase,
            PI.".ProductImages::obj()->Data[F_P_KEY].", PI.".ProductImages::obj()->Data[F_F_KEY].",
            PI.proimg_image_file, PI.".ProductImages::obj()->Data[F_P_FIELD].",
            (
	            SELECT CONCAT(SPCM.cm_tax_percentage,'|',SPCM.cm_addi_tax_percentage)
	            FROM ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM
	            INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." SPC ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
	            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
	            ORDER BY SPCM.cm_level DESC LIMIT 1
            ) AS ".$this->Data[FIELD_PREFIX]."tax";

            $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];

            $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
            $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
            $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
            $Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
            $Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];

            $pamars =
                        $this->Data[F_P_KEY]." = :id
                        AND PI.proimg_is_cover = :yes
                        AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = :yes
                        AND BM.".BrandMaster::obj()->Data[F_ACTIVE]." = :yes
                        AND PCM.".CategoryMaster::obj()->Data[F_ACTIVE]." = :yes
                        AND SUP.".Supplier::obj()->Data[F_ACTIVE]." = :yes ";

			$pamars .= " AND
                        (
	                        SELECT GROUP_CONCAT(SPCM.".CategoryMaster::obj()->Data[F_ACTIVE]." ORDER BY SPCM.cm_level ASC)
	                        FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
	                        INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
	                        WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                        ) = '".YES.",".YES.",".YES."' ";

            $value = array(':id' => $product_id, ':yes' => YES);

    		$info = $this->getInfoByParam($pamars, $value, $F_CustomSelect=false, $Join);

            if(is_array($info))
    		{
    			if($info[$this->Data[F_ACTIVE]] === YES && $info['product_quantity'] > 0)
    				return $info;
    			else
    				return false;
    		}
    		else
    			return false;
	}*/
    public function getProductInfoForShoppingCartById($product_id,$ref_required=false)
    {
        if(!is_numeric($product_id))
			return false;

        $value = '';
        $this->Data[F_B_SELECT] = "
            MTBL.".$this->Data[F_P_KEY].", MTBL.".$this->Data[F_ADDED_DATETIME].",
            MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY].", MTBL.".$this->Data[F_P_FIELD].", MTBL.".$this->Data[F_S_URL].",
            MTBL.product_price, MTBL.product_selling_price, MTBL.product_max_retail_price,
            MTBL.product_quantity,MTBL.product_min_order_qty, MTBL.product_weight,MTBL.".$this->Data[F_ACTIVE].",
            MTBL.product_image_type,MTBL.product_sku,MTBL.product_enable_purchase,
            MTBL.product_psg_id,MTBL.product_busm_id,
            
            BUSM.".BusinessMaster::obj()->Data[F_P_FIELD]." AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_P_FIELD].",
            BUSM.busm_logo AS ".$this->Data[FIELD_PREFIX]."busm_logo,
            BUSM.".BusinessMaster::obj()->Data[F_ADDED_DATETIME]." AS ".$this->Data[FIELD_PREFIX].BusinessMaster::obj()->Data[F_ADDED_DATETIME].",
            
            PI.".ProductImages::obj()->Data[F_P_KEY].", PI.".ProductImages::obj()->Data[F_F_KEY].",
            PI.proimg_image_file, PI.".ProductImages::obj()->Data[F_P_FIELD].",
            (
	            SELECT CONCAT(SPCM.cm_tax_percentage,'|',SPCM.cm_addi_tax_percentage)
	            FROM ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM
	            INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." SPC ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
	            WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
	            ORDER BY SPCM.cm_level DESC LIMIT 1
            ) AS ".$this->Data[FIELD_PREFIX]."tax,
            (
                SELECT GROUP_CONCAT(CONCAT(CONCAT_WS('[]',FM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."display_title,FVM.".FeatureValueMaster::obj()->Data[F_P_FIELD]."),'*',(CONCAT_WS('[]',FM.".FeatureMaster::obj()->Data[F_P_KEY].",FVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."))) SEPARATOR '|')
                FROM ".ProductFeature::obj()->Data[TABLE_NAME]." PF,
                ".FeatureMaster::obj()->Data[TABLE_NAME]." FM,
                ".FeatureValueMaster::obj()->Data[TABLE_NAME]." FVM
                WHERE PF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." = FM.".FeatureMaster::obj()->Data[F_P_KEY]."
                AND PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = FVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
                AND FM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '1'
                GROUP BY MTBL.product_id
            ) AS ".$this->Data[FIELD_PREFIX]."required_feature
            ";

            $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];

            $Join .= " INNER JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
            $Join .= " INNER JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON MTBL.".$this->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_F_KEY];
            $Join .= " INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PCM.".CategoryMaster::obj()->Data[F_P_KEY]." = PC.".ProductCategory::obj()->Data[F_P_FIELD];
            $Join .= " INNER JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
            //$Join .= " INNER JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PSUP ON MTBL.".$this->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_F_KEY];
            //$Join .= " INNER JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PSUP.".ProductSupplier::obj()->Data[F_P_FIELD];
            $Join .= " INNER JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON PF.".ProductFeature::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];

            $pamars =  " PI.proimg_is_cover = '".YES."'
                        AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = '".YES."'
                        AND BM.".BrandMaster::obj()->Data[F_ACTIVE]." = '".YES."'
                        AND PCM.".CategoryMaster::obj()->Data[F_ACTIVE]." = '".YES."'
                        AND BUSM.".BusinessMaster::obj()->Data[F_ACTIVE]." = '".YES."'
                        AND BUSM.busm_is_verified = '".YES."'
                        AND BUSM.".BusinessMaster::obj()->Data[F_VIRTUAL_DELETE]." = '".NO."' 
                        AND BUSM.busm_is_blocked = '".NO."' ";

			$pamars .= " AND
                        (
	                        SELECT GROUP_CONCAT(SPCM.".CategoryMaster::obj()->Data[F_ACTIVE]." ORDER BY SPCM.cm_level ASC)
	                        FROM ".ProductCategory::obj()->Data[TABLE_NAME]." SPC
	                        INNER JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." SPCM ON SPC.".ProductCategory::obj()->Data[F_P_FIELD]." = SPCM.".CategoryMaster::obj()->Data[F_P_KEY]."
	                        WHERE SPC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]."
                        ) = '".YES.",".YES.",".YES."' ";

            # if ref required is set then also check with product feature.
            if(is_array($ref_required))
            {
                $arrfkey_info = array_keys($ref_required);
                $arrfval_info = array_values($ref_required);

                /*$pamars = " PF.".ProductFeature::obj()->Data[F_F_KEY] ." = '".$product_id."'
                            AND PF.".ProductFeature::obj()->Data[F_P_FIELD]." IN (".rtrim(str_repeat('?,',(count($arrfkey_info))),',').")
                            AND PF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IN (".rtrim(str_repeat('?,',(count($arrfval_info))),',').")";


                $value = array_merge($arrfkey_info,$arrfval_info);*/
                $pamars .= "AND  MTBL.product_id = 
                         (
                             SELECT SPF.".ProductFeature::obj()->Data[F_F_KEY]." FROM ".ProductFeature::obj()->Data[TABLE_NAME]." SPF
                             WHERE SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                             AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = ?";
                             if(isset($arrfkey_info[1]) && !empty($arrfkey_info[1]))
                             {
                                $pamars .= "
                                            AND SPF.".ProductFeature::obj()->Data[F_F_KEY]." =
                                             (
                                                 SELECT SSPF.".ProductFeature::obj()->Data[F_F_KEY]." FROM ".ProductFeature::obj()->Data[TABLE_NAME]." SSPF
                                                 WHERE SSPF.".ProductFeature::obj()->Data[F_P_FIELD]." = ?
                                                 AND SSPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = ?
                                                 AND SSPF.pfeature_product_id = '".$product_id."'
                                             )";
                                $Key_info[] = $arrfkey_info[1];
                                $value_info[] = $arrfval_info[1];
                                $value = array_merge($Key_info,$value_info);
                             }
                             else
                             {
                                $pamars .= " AND SPF.".ProductFeature::obj()->Data[F_F_KEY]." = '".$product_id."'";
                             }

                      $pamars .=")";

            }
            else
            {
              $pamars .= "AND ".$this->Data[F_P_KEY]." = '".$product_id."'";
            }

            $Key_info1[] = $arrfkey_info[0];
            $value_info1[] = $arrfval_info[0];

            if(is_array($value))
                $value = array_merge($value,$Key_info1,$value_info1);
            else
                 $value = array_merge($Key_info1,$value_info1);

            $pamars .= "GROUP BY ".$this->Data[F_P_KEY];

            $info = $this->getInfoByParam($pamars, $value, $F_CustomSelect=false, $Join);

            if(is_array($info))
    		{
    			if($info[$this->Data[F_ACTIVE]] === YES && $info['product_quantity'] > 0)
    				return $info;
    			else
    				return false;
    		}
    		else
    			return false;
	}
	public function ChangeProductQuantity($product_id, $quantity, $operation)
	{
		if($operation != '+' && $operation != '-')
			return false;

	    $field_sets     = " product_stockout_datetime = IF(product_quantity ".$operation." ".$quantity." <= 0, '".date('Y-m-d H:i:s')."', product_stockout_datetime),
                            product_stockout_by = IF(product_quantity ".$operation." ".$quantity." <= 0, '".STOCKOUT_MANUALLY."', ".STOCKOUT_NONE."),
                            product_quantity = IF(product_quantity ".$operation." ".$quantity." < 0, 0,product_quantity ".$operation." ".$quantity.")";
		$where_condition = $this->Data[F_P_KEY]." = ? ";
		$value = array($product_id);

        $update = parent::UpdateFieldByParam($field_sets , $where_condition, $value);

		if($update == 1)
			return $update;
		else
			$this->Error[E_DESC] = "Sorry, unable to update quantity for given product.";
	}
	public function getProductQuantity($product_id)
	{
		$info = parent::getInfoById($product_id, 'product_quantity');
		if(isset($info['product_quantity']))
			return $info['product_quantity'];
		else
			return false;
	}
    public function getProductInfoByProductIDAndImageID($product_id,$image_id = false)
    {
        if(!is_numeric($product_id))
            return false;

        $param = $this->Data[F_P_KEY]." = ?";
        $value[] = $product_id;

        if(isset($image_id) && is_numeric($image_id) && $image_id > 0)
        {
            $param .= " AND PI.".ProductImages::obj()->Data[F_P_KEY]." = ? ";
            $value[] = $image_id;
        }
	    else
	    {
		    $param .= " AND PI.proimg_is_cover = ? ";
		    $value[] = YES;
	    }

        $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];

        return parent::getInfoByParam($param, $value,false, $Join);
    }
    public function GetProductSearchLinksForSitmap()
    {
        $Custom_Param[SQL_LIMIT]  =   '';
        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY product_added_datetime DESC, product_updated_datetime DESC ";

        $Custom_Param[F_B_SELECT] = $this->Data[F_P_FIELD].", ".$this->Data[F_S_URL];
        $addParameters = "AND ".$this->Data[F_ACTIVE]." = ? ";

        return parent::getAll($addParameters, array(YES), $Join = false, $Custom_Param);
    }
    public function getFeaturedProductInfoForHomePage($limit=false)
    {
        $Custom_Param[CUST_SORT_ORDER_STR]    =   " ORDER BY RAND() ";

        if(is_numeric($limit))
            $Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

        $Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,MTBL.product_is_ready_to_dispatch,MTBL.product_quantity,MTBL.product_min_order_qty,MTBL.product_is_hot_favourite,MTBL.product_image_type,MTBL.product_sku, MTBL.product_selling_price,MTBL.product_max_retail_price,(SELECT GROUP_CONCAT(PI.proimg_id SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_id, (SELECT GROUP_CONCAT(PI.proimg_image_file SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_name,(SELECT GROUP_CONCAT(PI.proimg_alt SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_alt,(SELECT GROUP_CONCAT(PI.proimg_title SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_title ";

        $addParameters = " AND product_quantity > ? AND product_is_featured = ? AND product_image_type = ? AND product_is_active = ?";

        //$Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = ? AND PI.proimg_is_cover = ? ";

        return parent::getAll($addParameters,array(0,YES,PRODUCT_IMAGE_VERTICAL,YES), $Join = false, $Custom_Param);
    }
    public function GetBestProduct($limit=false)
    {
        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY product_added_datetime DESC, product_updated_datetime DESC ";

        if(is_numeric($limit))
            $Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

        $Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,MTBL.product_is_featured,MTBL.product_is_hot_favourite,MTBL.product_is_ready_to_dispatch,MTBL.product_quantity,MTBL.product_image_type,MTBL.product_sku, MTBL.product_selling_price,MTBL.product_max_retail_price, (SELECT GROUP_CONCAT(PI.proimg_id SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_id, (SELECT GROUP_CONCAT(PI.proimg_image_file SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_name,(SELECT GROUP_CONCAT(PI.proimg_alt SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_alt,(SELECT GROUP_CONCAT(PI.proimg_title SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_title ";

        $addParameters = " AND product_is_featured = ? AND product_is_hot_favourite = ? AND product_quantity > ? AND ".$this->Data[F_ACTIVE]." = ? ";

        //$Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.".ProductImages::obj()->Data[F_ACTIVE]." = ? AND PI.proimg_is_cover = ? ";

        return parent::getAll($addParameters,array(YES,YES,0,YES), $Join = false, $Custom_Param);
    }
	public function getDistinctBatchNumberList()
    {
        $Custom_Param[F_B_SELECT] = " DISTINCT(MTBL.product_import_batch_number) ";
        $Custom_Param[CUST_SORT_ORDER_STR]    =   " ORDER BY product_import_batch_number DESC ";

        $rs = parent::getAll($addParameters=false,$value=false, $Join = false, $Custom_Param);

        $newArr = array();
        if($rs->TotalRow > 0)
        {
            while($rs -> next_record())
            {
                if($rs->f('product_import_batch_number') != '')
                    $newArr[$rs->f('product_import_batch_number')] = $rs->f('product_import_batch_number');
            }
        }

        return $newArr;
    }
    public function _ViewAll_ProductByCategory($POST)
    {
        $this->page_size            =   $POST[CART_PAGE_SIZE];
		$_SESSION[S_RECORD]         =   $POST[S_RECORD];

        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY product_added_datetime DESC, product_updated_datetime DESC ";

		$Custom_Param[F_B_SELECT] =   " MTBL.product_id,MTBL.product_name,MTBL.product_safe_url,MTBL.product_is_featured,MTBL.product_is_hot_favourite,MTBL.product_is_ready_to_dispatch,MTBL.product_quantity,MTBL.product_image_type,MTBL.product_sku, MTBL.product_selling_price,MTBL.product_max_retail_price, (SELECT GROUP_CONCAT(PI.proimg_id SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_id, (SELECT GROUP_CONCAT(PI.proimg_image_file SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_name,(SELECT GROUP_CONCAT(PI.proimg_alt SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_alt,(SELECT GROUP_CONCAT(PI.proimg_title SEPARATOR '|') FROM ".ProductImages::obj()->Data[TABLE_NAME]." PI WHERE PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." LIMIT 0,2) AS product_images_title ";

		$addParams = " AND product_quantity > ? AND ".$this->Data[F_ACTIVE]." = ? AND product_selling_price > 0 AND FIND_IN_SET(3,product_cm_id)";

        $value  = array(0,YES);

        $pamars =   $this->getQueryParameters($POST);

        $addParams .= $pamars['sql'];

        if(is_array($value) && is_array($pamars['value']))
            $value = array_merge($value,$pamars['value']);
        elseif(is_array($pamars['value']))
            $value =   $pamars['value'];

        $Join  = " LEFT JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PC ON FIND_IN_SET(PC.".CategoryMaster::obj()->Data[F_P_KEY]." ,MTBL.".$this->Data[F_F_KEY].")";
        //$Join .= " LEFT JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON FIND_IN_SET(SUP.".Supplier::obj()->Data[F_P_KEY]." ,MTBL.product_supplier_id)";
        $Join .= " LEFT JOIN ".BrandMaster::obj()->Data[TABLE_NAME]." BM ON MTBL.".$this->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY]." = BM.".BrandMaster::obj()->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON MTBL.product_protype_id = PTM.".ProductTypeMaster::obj()->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON MTBL.".$this->Data[F_P_KEY]." = PF.".ProductFeature::obj()->Data[F_F_KEY];
        $Join .= " LEFT JOIN ".FeatureValueMaster::obj()->Data[TABLE_NAME]." FVM ON PF.".ProductFeature::obj()->Data[F_P_FIELD]." = FVM.".FeatureValueMaster::obj()->Data[F_F_KEY];
        $Join .= " LEFT JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." FM ON FVM.".FeatureValueMaster::obj()->Data[F_F_KEY]." = FM.".FeatureMaster::obj()->Data[F_P_KEY];

        return parent::ViewAll($addParams,$value,(isset($Join)?$Join:false), $Custom_Param);
    }
    public function  getAllSuggestionImportBatchNumber($str, $limit)
    {
        $searchFields   =   array('product_import_batch_number');
	    $limit          =   !empty($limit) ? intval($limit) : 100;

        $Custom_Param[F_B_SELECT] = 'MTBL.product_import_batch_number';

        $Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY MTBL.product_import_batch_number DESC";

        return parent::getAutoSuggestionRecord($str, $searchFields, $addParameters=false, false, $Custom_Param, $Join=false, $limit);

    }
    public function getProductCountByParam($param)
    {
        if(empty($param))
            return false;

        $param	= $this->getQueryParameters($param);

		$addParameters  =  $param['sql'];

        $Custom_Param[F_B_SELECT]  = $this->Data[F_P_KEY];

        //$Join = " LEFT JOIN ".ProductSupplier::obj()->Data[TABLE_NAME]." PS ON PS.".ProductSupplier::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];
        //$Join .= " LEFT JOIN ".Supplier::obj()->Data[TABLE_NAME]." SUP ON SUP.".Supplier::obj()->Data[F_P_KEY]." = PS.".ProductSupplier::obj()->Data[F_P_FIELD];
        $Join = " LEFT JOIN ".BusinessMaster::obj()->Data[TABLE_NAME]." BUSM ON BUSM.".BusinessMaster::obj()->Data[F_P_KEY]." = MTBL.product_busm_id";
        $Join .= " LEFT JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON PC.".ProductCategory::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".CategoryMaster::obj()->Data[TABLE_NAME]." PCM ON PC.".ProductCategory::obj()->Data[F_P_FIELD]." = PCM.".CategoryMaster::obj()->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".ProductFeature::obj()->Data[TABLE_NAME]." PF ON MTBL.".$this->Data[F_P_KEY]." = PF.".ProductFeature::obj()->Data[F_F_KEY];
        $Join .= " LEFT JOIN ".FeatureValueMaster::obj()->Data[TABLE_NAME]." FVM ON PF.".ProductFeature::obj()->Data[F_P_FIELD]." = FVM.".FeatureValueMaster::obj()->Data[F_F_KEY];
        $Join .= " LEFT JOIN ".FeatureMaster::obj()->Data[TABLE_NAME]." FM ON FVM.".FeatureValueMaster::obj()->Data[F_F_KEY]." = FM.".FeatureMaster::obj()->Data[F_P_KEY];

        $Custom_Param[GROUP_BY]   =   "MTBL.".$this->Data[F_P_KEY];

        $rs = parent::getAll($addParameters,$param['value'],$Join,$Custom_Param);
        if(count($rs->TotalRow) > 0)
            return $rs->TotalRow;
        else
            return false;
    }
    public function getCountByStockoutByAndDayWise($stockout_by, $day)
    {
        $Custom_Param[F_B_SELECT]  = $this->Data[F_P_KEY];

        //$Custom_Param[F_B_SELECT]="MTBL.*,PI.*,PC.".CategoryMaster::obj()->Data[F_P_FIELD]." AS product_cm_name,CONCAT(PI.".ProductImages::obj()->Data[F_F_KEY].",'/',PI.".ProductImages::obj()->Data[F_P_KEY].",'/',MTBL.product_group_number) AS product_photo,PI.proimg_filename AS product_filename";

        //$Join  = " LEFT JOIN ".ProductCategory::obj()->Data[TABLE_NAME]." PC ON PC.".ProductCategory::obj()->Data[F_P_KEY]." = MTBL.".$this->Data[F_F_KEY];
        //$Join  .= " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.proimg_is_cover = '".YES."' AND PI.proimg_visible = '".YES."'";

        # Unset status filter s requested
        if($stockout_by == STOCKOUT_AUTO || $stockout_by == STOCKOUT_MANUALLY)
        {
            $old_stats = isset($this->filter['stockout_by'])?$this->filter['stockout_by']:'';
            $this->filter['stockout_by'] = $stockout_by;
        }

        $field_name = "product_stockout_datetime";
        $addParameters = '';

        switch($day)
			{
				case FILTERBY_THISMONTH;
					$addParameters	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (MONTH(".$field_name.") = ".date("m"). ") ";
					break;
				case FILTERBY_THISWEEK;
					$addParameters	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (WEEK(".$field_name.", 3) = ". date('W').")  ";
					break;
				case FILTERBY_TODAY;
					$addParameters	 .=	" AND (DATE(".$field_name.") = '". date("Y-m-d")."') ";
					break;
                case FILTERBY_YESTERDAY;
					$addParameters	 .=	" AND (DATE(".$field_name.") = '". date("Y-m-d",strtotime("-1 days"))."') ";
					break;
                case FILTERBY_LASTMONTH;
					$addParameters	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (MONTH(".$field_name.") = ".date("m",strtotime(" -1 month")). ") ";
					break;
            }

        # Get search filter if any set
    	$pamars	= $this->getQueryParameters();

		$addParameters  .=  $pamars['sql'];
        if(is_array($pamars['value']))
			$value =   $pamars['value'];
        else
            $value = '';

        $rs = parent::getAll($addParameters, $value, $Join=false, $Custom_Param);

        # Reset filter
        if($stockout_by == STOCKOUT_AUTO || $stockout_by == STOCKOUT_MANUALLY)
            $this->filter['stockout_by'] = $old_stats;


        return $rs->TotalRow;
    }
    /*2016-01-26*/
    public function getTotalCountByStockoutByAndDayWise($stockout_by)
    {
        $field_name = "product_stockout_datetime";

        # Unset status filter s requested
        if($stockout_by == STOCKOUT_AUTO || $stockout_by == STOCKOUT_MANUALLY)
        {
            $old_stats = isset($this->filter['stockout_by'])?$this->filter['stockout_by']:'';
            $this->filter['stockout_by'] = $stockout_by;
        }

        $pamars	= $this->getQueryParameters();

        $addParameters  =  $pamars['sql'];

        $param = "  1";

        if(is_array($pamars['value']))
            $value =   $pamars['value'];

        $addParameters = str_replace('?',implode(',',$value),$addParameters);

        $F_CustomSelect = "
            DISTINCT(
                SELECT COUNT(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (DATE(".$field_name.") = '".date('Y-m-d')."' ".$addParameters.")
            ) AS today,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (DATE(".$field_name.") = '".date('Y-m-d',strtotime('-1 days'))."' ".$addParameters.")
            ) AS yesterday,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (YEAR(".$field_name.") = '".date('Y')."') AND (WEEK(".$field_name.") = '".date('W')."' ".$addParameters.")
            ) AS this_week,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (YEAR(".$field_name.") = '".date('Y')."') AND (MONTH(".$field_name.") = '".date('m')."' ".$addParameters.")
            ) AS this_month,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (YEAR(".$field_name.") = '".date('Y')."') AND (MONTH(".$field_name.") = '".date('m',strtotime(' -1 month'))."' ".$addParameters.")
            ) AS last_month
            ";

        //echo "<pre>"; print_r($F_CustomSelect); die;
        $rs = parent::getInfoByParam($param, $value=false, $F_CustomSelect, $Join=false, $type=PDO_FETCH_SINGLE, $index_key=false);

        # Reset filter
        if($stockout_by == STOCKOUT_AUTO || $stockout_by == STOCKOUT_MANUALLY)
            $this->filter['stockout_by'] = $old_stats;

        return $rs;
    }
    /*2016-01-26*/
    public function getTotalCountForImportAndNewProductByDayWise($product)
    {
        if($product == 'New')
            $field_name = "product_added_datetime";
        elseif($product == 'Import')
            $field_name = "product_import_batch_number";

        $pamars	= $this->getQueryParameters();

        $addParameters  =  $pamars['sql'];

        $F_CustomSelect = "
            DISTINCT(
                SELECT COUNT(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (DATE(".$field_name.") = '".date('Y-m-d')."' ".$addParameters.")
            ) AS today,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (DATE(".$field_name.") = '".date('Y-m-d',strtotime('-1 days'))."' ".$addParameters.")
            ) AS yesterday,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (YEAR(".$field_name.") = '".date('Y')."') AND (WEEK(".$field_name.") = '".date('W')."' ".$addParameters.")
            ) AS this_week,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (YEAR(".$field_name.") = '".date('Y')."') AND (MONTH(".$field_name.") = '".date('m')."' ".$addParameters.")
            ) AS this_month,
            (
                SELECT count(*) FROM ".$this->Data[TABLE_NAME]." AS MTBL WHERE (YEAR(".$field_name.") = '".date('Y')."') AND (MONTH(".$field_name.") = '".date('m',strtotime(' -1 month'))."' ".$addParameters.")
            ) AS last_month
            ";
        //echo "<pre>"; print_r($F_CustomSelect); die;
        $param = "  1";

        if(is_array($pamars['value']))
			$value =   $pamars['value'];
        else
            $value = '';

        $rs = parent::getInfoByParam($param, $value, $F_CustomSelect, $Join=false, $type=PDO_FETCH_SINGLE, $index_key=false);

        return $rs;
    }
    public function getCountForImportAndNewProductByDayWise($product,$day)
    {
        $Custom_Param[F_B_SELECT]  = $this->Data[F_P_KEY];

        if($product == 'New')
            $field_name = "product_added_datetime";
        elseif($product == 'Import')
            $field_name = "product_import_batch_number";

        $addParameters = '';

        switch($day)
			{
				case FILTERBY_THISMONTH;
					$addParameters	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (MONTH(".$field_name.") = ".date("m"). ") ";
					break;
				case FILTERBY_THISWEEK;
					$addParameters	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (WEEK(".$field_name.", 3) = ". date('W').")  ";
					break;
				case FILTERBY_TODAY;
					$addParameters	 .=	" AND (DATE(".$field_name.") = '". date("Y-m-d")."') ";
					break;
                case FILTERBY_YESTERDAY;
					$addParameters	 .=	" AND (DATE(".$field_name.") = '". date("Y-m-d",strtotime("-1 days"))."') ";
					break;
                case FILTERBY_LASTMONTH;
					$addParameters	 .=	" AND (YEAR(".$field_name.") = ".date('Y').") AND (MONTH(".$field_name.") = ".date("m",strtotime(" -1 month")). ") ";
					break;
            }

        # Get search filter if any set
    	$param	= $this->getQueryParameters();

        $addParameters  .=  $param['sql'];
        if(is_array($param['value']))
			$value =   $param['value'];
        else
            $value = '';

        $rs = parent::getAll($addParameters,$value,$join=false,$Custom_Param);

        return $rs->TotalRow;
    }
    public function getTodayTotalStockOut($stockout_by)
    {
       $F_CustomSelect = " COUNT(*) AS Total_stockout";

       $param   = " DATE(MTBL.product_stockout_datetime) = ? AND product_stockout_by = ?";
       $value   = array(date('Y-m-d'),$stockout_by);
       $info    =  parent::getInfoByParam($param, $value, $F_CustomSelect);

       if(is_array($info))
            return $info['Total_stockout'];
    }
    public function GetNewArrivalProductsForWholesale($limit=false)
	{
		$Custom_Param[CUST_SORT_ORDER_STR] = " ORDER BY product_added_datetime DESC ";

		if(is_numeric($limit))
			$Custom_Param[SQL_LIMIT]  =  " 0,".$limit;

		$Custom_Param[F_B_SELECT]   =
			" MTBL.".$this->Data[F_P_KEY].", MTBL.`product_group_number`, MTBL.`product_group_name`, MTBL.`product_image_type`,MTBL.product_protype_id ,MTBL.product_safe_url,MTBL.product_selling_price,
			PI.".ProductImages::obj()->Data[F_P_KEY].",
			PI.`proimg_image_file`";

		$Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." `PI` ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY]." AND PI.`proimg_is_cover` = 'Yes' ";
        //$Join .= " LEFT JOIN ".ProductTypeMaster::obj()->Data[TABLE_NAME]." PTM ON PTM.".ProductTypeMaster::obj()->Data[F_P_KEY]." = MTBL.product_protype_id ";

        $Custom_Param[GROUP_BY]   =   "MTBL.".$this->Data[F_P_KEY];

        $addParameters = " AND product_quantity > ? AND ".$this->Data[F_ACTIVE]." = ? ";

		return parent::getAll($addParameters,array(0,YES), $Join, $Custom_Param);
	}
    public function UpdateEnablePurchaseAndInquiryField($pk,$POST)
    {
        if(is_array($pk))
            $pk = implode(',',$pk);

        if(isset($POST['purchase']) && $POST['purchase'] == true)
        {
            if($POST['active'] == YES)
                $inquiry    =   NO;
            else
                $inquiry    =   YES;

            $param  = " product_enable_purchase = ?, product_enable_inquiry = ?";
            $value= array($POST['active'],$inquiry);
        }
        else
        {
            if($POST['active'] == YES)
                $purchase    =   NO;
            else
                $purchase    =   YES;

            $param  = " product_enable_inquiry = ?, product_enable_purchase = ?";
            $value= array($POST['active'],$purchase);
        }
        $where  =   " product_id IN (".$pk.") ";
        return parent::UpdateFieldByParam($param,$where,$value);
    }
    public function GetProductByImportBatchNumber($importBatchNo)
    {
        if(empty($importBatchNo))
            return false;

        $Custom_Param[F_B_SELECT]   ="PI.*,PAI.*,MTBL.".$this->Data[F_P_KEY].", MTBL.product_added_datetime,MTBL.".$this->Data[F_P_FIELD].',MTBL.product_sku,MTBL.'.$this->Data[F_F_KEY];

        $addParameters = " AND MTBL.product_import_batch_number = ? ";
        $value = array($importBatchNo);

        $Join = " LEFT JOIN ".ProductImages::obj()->Data[TABLE_NAME]." PI ON PI.".ProductImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];
        $Join .= " LEFT JOIN ".ProductAdditionalImages::obj()->Data[TABLE_NAME]." PAI ON PAI.".ProductAdditionalImages::obj()->Data[F_F_KEY]." = MTBL.".$this->Data[F_P_KEY];

        return parent::getAll($addParameters,$value, $Join, $Custom_Param);
    }
	public function getProductCompareList($limit=false)
	{
		if(isset($_COOKIE[COOKIE_TE_IC]) && !empty($_COOKIE[COOKIE_TE_IC]))
		{
			$comapre_product = (unserialize(base64_decode($_COOKIE[COOKIE_TE_IC])));

			if(is_array($comapre_product[AREATE_ID_ECOM_RETAIL]) && count($comapre_product[AREATE_ID_ECOM_RETAIL]) > 0)
			{
				$temp = array_reverse($comapre_product[AREATE_ID_ECOM_RETAIL], true);
				$i=1;
				foreach($temp as $key  =>  $info)
				{
					if(!is_numeric($key))
						$product_id[] = Ocrypt::ndec($key);
					else
						$product_id[] = $key;

					if($limit == $i)
						break;

					$i++;
				}

				# Product Info
				return $this->getAllProductInfoByProductID($product_id, $limit);
			}
		}
	}
    public function GetStockOutFeaturedProduct()
    {
        $Custom_Param[F_B_SELECT] = $this->Data[F_P_KEY];
        $addParameters = " AND product_quantity <= ? AND product_is_featured = ? ";
        $value = array(0,YES);
        return parent::getAll($addParameters, $value, $Join=false, $Custom_Param);
    }
	public function ImportProductDataIntoTempTable($fileName)
    {
        global  $config, $physical_path, $virtual_path, $Debug_info;

        # Start debug
        $this->DBC->start_debug();

        # Set temp table name
        $this->Data['TEMP_TABLE'] = 'temp_table';

        $this->DBC->ThrowError(true);


        $TableName = $this->Data['TEMP_TABLE'];

        $CSVFilePath = $physical_path['Upload'].'/import/'.$fileName;

        $file = fopen($CSVFilePath,"r");

        while (($data = fgetcsv($file, 1100, ",")) !== false)
        {
            $FileContents[] =   $data;
        }
        $FieldList = array_shift($FileContents);
        //Utility::pre($FieldList);
        $FieldCount = count($FieldList);
        $sqlFields = '';
        $sqlValues = '';
        $strInsertData = '';

        foreach($FieldList as $FieldKey=>$FieldName)
        {
            $sqlFields .= $FieldName .", ";
        }
        //Utility::pre($FileContents);
        for($i=0;$i<count($FileContents);$i++)
        {

            if($FileContents[$i] != '')
            {
                if (is_array($FileContents[$i]) && count($FileContents[$i]) > 0)
                {
                    $arrData = $FileContents[$i];

                    if(count($arrData) == $FieldCount)
                    {
                        $strDataValue = '';
                        foreach($arrData as $Key => $DataValue)
                        {
                            $strDataValue .= "'".$DataValue."',";
                        }
                    }

                }
                $strInsertData .= '('.trim($strDataValue,",").'),';
            }

        }
        $sqlValues = rtrim($strInsertData,",");
        $sqlFields = rtrim($sqlFields,", ");

        if(!empty($sqlValues))
        {
            $sql = " INSERT INTO $TableName ($sqlFields) VALUES $sqlValues ";
            $this->DBC->run_query($sql,false,false);
        }

        $sql = "DELETE FROM $TableName WHERE (`group_number` = '' OR `group_number` IS NULL) AND (group_design_no = '' OR group_design_no IS NULL)";
        $this->DBC->run_query($sql,false,false);
    }
    public function ImportProductData($import_batch, $price_by=0.35, $fileName)
    {
        if(empty($import_batch))
            return false;

        # Set memory to 50Meg
        ini_set("memory_limit","512M");
        # 4hrs should be sufficent? ( 240 minutes * 60 seconds = 14400 seconds)
        ini_set("max_execution_time", 14400);

        global $Debug_info; $out = '';$msg = '';

        $cur_datetime = date('Y-m-d H:i:s');
        # Start debug
        $this->DBC->start_debug();

        # Set temp table name
        $this->Data['TEMP_TABLE'] = 'temp_table';

        # Lock table before do any processing
        $this->DBC->lock_tables($this->Data['TEMP_TABLE']);

        # Sart transaction
        $this->DBC->start_transaction();

        $this->DBC->ThrowError(true);

        //$p_up   =   $this->Data[P_UP];
        //$this->Data[P_UP] = str_replace('product','import',$p_up);

        try
        {
            /*
            # Truncate temp table
		    $sql = "TRUNCATE `temp_table`";
		    $this->DBC->q_query($sql);

		    # DROP primary key `temp_table`
		    $sql =  "ALTER TABLE `temp_table` DROP PRIMARY KEY;";
		    $this->DBC->q_query($sql);

		    # First DROP additionally created fields from `temp_table`
		    $sql =  "
					ALTER TABLE `temp_table` DROP `pk`;
					ALTER TABLE `temp_table` DROP `fk_cm_id`;
					ALTER TABLE `temp_table` DROP `fk_manufacturer_id`;
					ALTER TABLE `temp_table` DROP `fk_supplier_id`;
					ALTER TABLE `temp_table` DROP `fk_feature_Fabric_2`;
					ALTER TABLE `temp_table` DROP `fk_feature_WorkType_15`;
					ALTER TABLE `temp_table` DROP `fk_feature_Occasion_8`;
					ALTER TABLE `temp_table` DROP `fk_feature_StichingType_36`;
					";
		    $this->DBC->q_query($sql);
			*/
            /*
			######################################################################################
			# NOW UPLOAD ENTIRE .CSV FILE IN TEMP TABLE

			$import_file_name = $this->uploadFile($_FILES['product_import'], '', false, false, false);
			$import_file_located = $this->Data[P_UP]."/".$import_file_name;

			# NOW DUMP ALL DATA FROM >CSV TO TEMP TABLE
			$sql =  "LOAD DATA LOCAL INFILE '".$import_file_located."' INTO TABLE `temp_table` FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n'(`group_number`, `group_design_no`, `image_name`, `cm_id`, `name`, `Product`, `manufacturer_id`, `supplier_id`, `Price`, `selling_price`, `real_price`, `weight`, `quantity`, `feature_Size_17`, `feature_SizeBottom_47`, `feature_SizeDupatta_48`, `feature_Fabric_2`, `feature_FabricTop_49`, `feature_FabricBottom_50`, `feature_FabricDuptto_51`, `feature_WorkType_15`, `feature_WorkTop_52`, `feature_WorkBottom_53`, `feature_WorkDupatta_54`, `feature_Colour_29`, `feature_ColourTop_55`, `feature_ColourBottom_56`, `feature_Occasion_8`, `feature_StichingType_36`, `feature_Style_57`, `feature_WashCare_58`, `is_featured`, `is_active`, `is_out_of_stock`, `image_type`, `catalog_name`)";
			//$this->DBC->q_query($sql);
			exec($sql);
			######################################################################################
			*/

            # Now get all records from database
            $sql = "SELECT * FROM `temp_table`";

            $this->DBC->q_prepare($sql);
            $this->DBC->q_execute();
            $rs = new DB_Recordset($this->DBC->get_link_id(), $this->DBC->get_sth_result(), $sql);

            if($rs->TotalRow > 0)
            {
                # Get all product categories
                $arr_category_list      =
                    CategoryMaster::obj()->getKeyValueArray();
                $rev_arr_category_list  =   array_flip($arr_category_list);

                # Get feature value list
                $all_feature_list       =   array(
                    'fabric'                =>  'feature_Fabric_2',
                    'work-type'            =>  'feature_WorkType_15',
                    'occasion'              =>  'feature_Occasion_8',
                    'stiching-type'         =>  'feature_StichingType_36',
                    'salwar-kameez-type'   =>  'feature_Salwar_Kameez_Type_65',
                    'saree-type'            =>  'feature_Saree_Type_67',
                    'lehanga-choli-type'=>  'feature_Lehanga_Choli_Type_68',
                    'kurti-type'       =>  'feature_Kurti_Type_69',
                    'gown-type'         =>  'feature_Gown_Type_70',

                );

                $other_feature_list = array(
                    'size'              =>  'feature_Size_17',
                    'size-bottom '      =>  'feature_SizeBottom_47',
                    'size-dupatta'      =>  'feature_SizeDupatta_48',
                    'fabric-top'        =>  'feature_FabricTop_49',
                    'fabric-bottom'     =>  'feature_FabricBottom_50',
                    'dupatta-fabric'    =>  'feature_DupattaFabric_51',
                    'colour'            =>  'feature_Colour_29',
                    'colour-top'        =>  'feature_ColourTop_55',
                    'colour-bottom'     =>  'feature_ColourBottom_56',
                    'style'             =>  'feature_Style_57',
                    'blouse-length'     =>  'feature_BlouseLength_60',
                    'length'            =>  'feature_Length_32',
                    'choli-fabric '     =>  'feature_CholiFabric_23',
                    'lehenga-fabric'    =>  'feature_LehngaFabric_24',
                    'inner-color'       =>  'feature_InnerColor_61',
                    'inner-fabric'      =>  'feature_InnerFabric_62',
                    'inner-size'        =>  'feature_InnerSize_73',
                    'top-length '       =>  'feature_TopLength_63',
                );

                $all_feature_value_list =   FeatureValueMaster::obj()->getFeatureValueInfoBySafeUrl(array_keys($all_feature_list));

                # Create primay key
                $sql = "ALTER TABLE `temp_table` ADD PRIMARY KEY( `group_number`, `group_design_no`);";
                $this->DBC->q_query($sql);

                # Now add additional fields in table to set foreign key
                $sql =  "
					ALTER TABLE `temp_table` ADD `pk` BIGINT UNSIGNED NULL DEFAULT NULL FIRST;
					ALTER TABLE `temp_table` ADD `fk_cm_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `pk`;
					ALTER TABLE `temp_table` ADD `fk_supplier_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_cm_id`;
					ALTER TABLE `temp_table` ADD `fk_protype_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_supplier_id`;
					ALTER TABLE `temp_table` ADD `fk_feature_Fabric_2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_protype_id`;
					ALTER TABLE `temp_table` ADD `fk_feature_WorkType_15` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_Fabric_2`;
					ALTER TABLE `temp_table` ADD `fk_feature_Occasion_8` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_WorkType_15`;
					ALTER TABLE `temp_table` ADD `fk_feature_StichingType_36` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_Occasion_8`;
					ALTER TABLE `temp_table` ADD `fk_feature_Salwar_Kameez_Type_65` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_StichingType_36`;
					ALTER TABLE `temp_table` ADD `fk_feature_Saree_Type_67` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_Salwar_Kameez_Type_65`;
					ALTER TABLE `temp_table` ADD `fk_feature_Lehanga_Choli_Type_68` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_Saree_Type_67`;
					ALTER TABLE `temp_table` ADD `fk_feature_Kurti_Type_69` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_Lehanga_Choli_Type_68`;
					ALTER TABLE `temp_table` ADD `fk_feature_Gown_Type_70` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `fk_feature_Kurti_Type_69`;
					";
                $this->DBC->q_query($sql);

                # Set `real_price` in temp
                $sql = "UPDATE `temp_table` SET `max_retail_price` = IF(max_retail_price IS NULL OR max_retail_price = '' OR max_retail_price <= 0,ROUND(`max_retail_price`*2),max_retail_price);";
                $this->DBC->q_query($sql);

                # Set `selling_price` in temp
                $sql = "UPDATE `temp_table` SET `selling_price` = IF(selling_price IS NULL OR selling_price = '' OR selling_price <= 0, ROUND(((`Price`*".$price_by.")+`Price`)+70), selling_price);";
                $this->DBC->q_query($sql);

                # Now loop through all required manipulation
                while($rs->next_record())
                {
                    $CATALOG_NUM    =   $rs->f('group_number');
                    $DESIGN_NUM     =   $rs->f('group_design_no');

                    echo "<br> === START Manipulation Record : CATALOG_NUM => ".$CATALOG_NUM." | DESIGN_NUM => ".$DESIGN_NUM;
                    $msg .= "<br> === START Manipulation Record : CATALOG_NUM => ".$CATALOG_NUM." | DESIGN_NUM => ".$DESIGN_NUM;
                    # Manipulate with category. Now set id of foreign key value for
                    /*$arr_category = explode(',',$rs->f('cm_id'));
					if(count($arr_category) > 0)
					{
						echo "<br />Manipulation for category : ".$rs->f('cm_id')."<br />";
						$list = null;
						foreach($arr_category as $key => $category)
							$list[] = $rev_arr_category_list[trim($category)];

						$full_category_list = implode(',',$list);
					}*/

                    # Manipulate with basic features
                    $full_feature_list = null;
                    foreach($all_feature_list as $feature_id => $feature_field_name)
                    {
                        echo "<br />Manipulation for field : ".$feature_field_name."<br />";
                        $msg .= "<br />Manipulation for field : ".$feature_field_name."<br />";

                        $arr_feature = explode(',',$rs->f($feature_field_name));
                        if(count($arr_feature) > 0)
                        {
                            $rev_arr_feature = array_flip($all_feature_value_list[$feature_id]);

                            $list = null;
                            foreach($arr_feature as $key => $feature_value)
                            {
                                if(isset($rev_arr_feature[trim($feature_value)]))
                                    $list[] = $rev_arr_feature[trim($feature_value)];
                                else
                                {
                                    echo "<br />Feature value not found : ".$feature_value;
                                    $msg .= "<br />Feature value not found : ".$feature_value;
                                }
                            }

                            if(isset($list) && is_array($list) && count($list) > 0)
                                $full_feature_list[] = "  TT.`fk_".$feature_field_name."` = '".implode(',',$list)."' ";
                            else
                            {
                                echo "<br />No list found : TT.`fk_".$feature_field_name."`";
                                $msg .= "<br />No list found : TT.`fk_".$feature_field_name."`";
                            }
                        }
                    }

                    # Now update all data in respected field
                    /*$sql = "UPDATE `temp_table` TT SET TT.`fk_cm_id` = (SELECT GROUP_CONCAT(DISTINCT CONCAT(`cm_parent_id`,',',`cm_id`) SEPARATOR ',') FROM `oe_product_category` WHERE `cm_id` IN (".$full_category_list.")),
							".implode(",",$full_feature_list)."
							WHERE group_number = '".$CATALOG_NUM."' AND group_design_no = '".$DESIGN_NUM."'";
					*/
                    $sql = "UPDATE `temp_table` TT SET TT.`fk_cm_id` = (SELECT CONCAT(SPC.cm_parent_id,',', PC.cm_parent_id,',',PC.cm_id) FROM `oe_product_category_master` PC LEFT JOIN `oe_product_category_master` SPC ON PC.cm_parent_id = SPC.cm_id WHERE PC.cm_name = TT.cm_id),
                            ".implode(",",$full_feature_list)."
						    WHERE group_number = '".$CATALOG_NUM."' AND group_design_no = '".$DESIGN_NUM."'";

                    $this->DBC->q_query($sql);

                    echo "<br /> === END Manipulation Record : CATALOG_NUM => ".$CATALOG_NUM." | DESIGN_NUM => ".$DESIGN_NUM."<br />";
                    $msg .= "<br /> === END Manipulation Record : CATALOG_NUM => ".$CATALOG_NUM." | DESIGN_NUM => ".$DESIGN_NUM."<br />";
                }

                # Now update all supplier id
                $sql = "UPDATE `temp_table` TT LEFT JOIN `oe_supplier` S ON TT.`supplier_id` = S.`supplier_name` SET TT.`fk_supplier_id` = S.`supplier_id`;";
                $this->DBC->q_query($sql);

                # Now update all manufacturer id
                //$sql = "UPDATE `temp_table` TT LEFT JOIN `oe_manufacturer` M ON TT.`manufacturer_id` = M.`manufacturer_name` SET TT.`fk_manufacturer_id` = M.`manufacturer_id`;";
                //$this->DBC->q_query($sql);

                # Now update all product type id
                //$sql = "UPDATE `temp_table` TT LEFT JOIN `oe_product_type_master` PTM ON TT.`protype_id` = PTM.`protype_title` SET TT.`fk_protype_id` = PTM.`protype_id`;";
                //$this->DBC->q_query($sql);

                /** *************************************************************************** **/
                /** Now start transferring all data to main table ***************************** **/
                /** *************************************************************************** **/

                # Transfer all data to main `oe_product_master` table
                $sql =
                    "
				    INSERT INTO `oe_product_master`
					(
					`product_name`, `product_second_line`,
					`product_safe_url`, `product_short_desc`, `product_full_desc`,
					`product_price`,`product_selling_price`, `product_max_retail_price`,`product_discount`, `product_quantity`, `product_weight`, `product_min_order_qty`,`product_shipping_charge`,
					`product_protype_id`,
					`product_is_active`, `product_is_featured`, `product_is_ready_to_dispatch`, `product_is_hot_favourite`,`product_is_upcoming`,`product_enable_inquiry`,`product_enable_purchase`,
					`product_page_heading`,`product_browser_title`, `product_meta_keyword`, `product_meta_desc`, `product_meta_external_tag`,
					`product_added_by_id`, `product_added_by_type`,
					`product_added_datetime`, `product_updated_datetime`, `product_import_batch_number`,
					`product_image_type`,
					`product_group_name`, `product_group_design_number`, `product_group_number`
					)
					SELECT
					REPLACE(`name`,'?',' ') AS `product_name`,
					IF(`second_line` IS NULL OR `second_line` = '',CONCAT(`group_name`,' ',`name`),`second_line`) AS `product_second_line`,

					TRIM(LEADING '-' FROM REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LCASE(CONCAT(`group_name`,'-',`name`,'-',`cm_id`,'-',`group_number`,'-',`group_design_no`)),' ','-'),'---','-'),'--','-'),',','-'),'?','-'),'&','and'),'#','')) AS `product_safe_url`,
					CONCAT(`group_name`,' ',`name`,', ',`cm_id`,'. With fabric ',`feature_Fabric_2`,' with ',`feature_WorkType_15`,' work type. You can use it as ',`feature_Occasion_8`,'.') AS `product_short_desc`,
					TRIM(LEADING ' ' FROM TRIM(LEADING ' - ' FROM CONCAT(`group_name`,' - ',`name`,'. ',`cm_id`,'. Fabric type is ',`feature_Fabric_2`,'. Work type is ',`feature_WorkType_15`,'. Stiching Type is ',`feature_StichingType_36`,'. You can use it on occasion like ',`feature_Occasion_8`,'. Wash Care : ',`feature_WashCare_58`,'. *Any information in written or in image/photo can be little different or can have some changes in real. Images are only representative. Due to various types of lightings and flash used while photo shoot, the color shade of the product may vary. The brightest shade seen is the closest colour of the product. Designs and patterns on the actual product may slightly vary from designs shown in the image. Some accessory shown in image might not found in product box as it is just for demonstration purpose.'))) AS `product_full_desc`,
					`Price` AS `product_price`,`selling_price` AS `product_selling_price`, `max_retail_price` AS `product_max_retail_price`, (((max_retail_price - selling_price)*100)/selling_price) AS `product_discount`,`quantity` AS `product_quantity`, `weight` AS `product_weight`, `min_order_qty` AS `product_min_order_qty`, IF((`shipping_charge` IS NULL OR `shipping_charge` = ''),0.00,shipping_charge) AS product_shipping_charge,
					`fk_protype_id` AS `product_protype_id`,
					IF(`is_active` = 'Yes',1,2) AS `product_is_active`, IF(`is_featured` = 'Yes',1,2)AS `product_is_featured`, IF(`is_ready_to_dispatch` = 'Yes',1,2) AS `product_is_ready_to_dispatch`, IF(`is_hot_favourite` = 'Yes',1,2) AS `product_is_hot_favourite`, IF(`is_upcoming` = 'Yes',1,2) AS `product_is_upcoming`,IF(`enable_inquiry` = 'Yes',1,2) AS product_enable_inquiry,IF(`enable_purchase` = 'Yes',1,2) AS `product_enable_purchase`,
					TRIM(LEADING ' ' FROM CONCAT(`group_name`,' ',`name`)) AS `product_page_heading`,TRIM(LEADING ' ' FROM CONCAT(`group_name`,' ',`name`)) AS `product_browser_title`,
					TRIM(LEADING ',' FROM  REPLACE(REPLACE(CONCAT(`group_name`,',',`name`),' ',','),',,',',')) AS `product_meta_keyword`,
					TRIM(LEADING ' ' FROM CONCAT(`group_name`,' ',`name`,', ',`cm_id`,'. With fabric ',`feature_Fabric_2`,' with ',`feature_WorkType_15`,' and ',`feature_StichingType_36`,' work type. You can use it as ',`feature_Occasion_8`)) AS `product_meta_desc`,
					'' AS `product_meta_external_tag`,
					1 AS `product_added_by_id`, 1 AS `product_added_by_type`,
					'".$cur_datetime."' AS `product_added_datetime`, '".$cur_datetime."' AS `product_updated_datetime`,
					'".$import_batch."' AS `product_import_batch_number`,
					IF(`image_type` = 'Vertical', 2, 1) AS `product_image_type`,
					`group_name` AS `product_group_name`, `group_design_no` AS `product_group_design_number`, `group_number` AS `product_group_number`
					FROM `temp_table`
					WHERE 1
				    ";

                $this->DBC->q_query($sql);

                # Update some tag fro current import batch
                /*$sql = "UPDATE `oe_product_master` SET `product_tag_id` = '4,5,8,14,12,16,17,22,26,27,28,6' WHERE `product_import_batch_number` = '".$import_batch."' AND `product_id`%3 = 0 AND (`product_tag_id` = '' OR `product_tag_id` IS NULL);";
                $this->DBC->q_query($sql);
                $sql = "UPDATE `oe_product_master` SET `product_tag_id` = '7,8,4,6,19,23,28' WHERE `product_import_batch_number` = '".$import_batch."' AND `product_id`%2 = 0 AND (`product_tag_id` = '' OR `product_tag_id` IS NULL);";
                $this->DBC->q_query($sql);
                $sql = "UPDATE `oe_product_master` SET `product_tag_id` = '10,14,8,12,18,22,11,6' WHERE `product_import_batch_number` = '".$import_batch."' AND (`product_tag_id` = '' OR `product_tag_id` IS NULL);";
                $this->DBC->q_query($sql);*/

                # Remove leading - from safe URL
                //$sql = "UPDATE oe_product_master SET `product_safe_url` = TRIM(LEADING '-' FROM `product_safe_url`) WHERE `product_import_batch_number` = '".$import_batch."';";
                //$this->DBC->q_query($sql);

                # Remove leading - from full description
                //$sql = "UPDATE oe_product_master SET `product_full_desc` = TRIM(LEADING ' - ' FROM `product_full_desc`) WHERE `product_import_batch_number` = '".$import_batch."';";
                //$this->DBC->q_query($sql);

                # Remove leading - from meta key word
                //$sql = "UPDATE oe_product_master SET `product_meta_keyword` = TRIM(LEADING ',' FROM `product_meta_keyword`) WHERE `product_import_batch_number` = '".$import_batch."';";
                //$this->DBC->q_query($sql);


                # Now update `pk` in `temp_table`
                $sql =
                    "
				    UPDATE `temp_table` TT LEFT JOIN `oe_product_master` PM
					ON TT.`group_number` = PM.`product_group_number`
					AND TT.`group_design_no` = PM.`product_group_design_number`
					AND PM.`product_import_batch_number` = '".$import_batch."'
					SET TT.`pk` = PM.`product_id`
					WHERE 1;
				    ";
                $this->DBC->q_query($sql);

                # Now get all records from database
                $sql = "SELECT *  FROM `temp_table`";
                $this->DBC->q_prepare($sql);
                $this->DBC->q_execute();
                $rs = new DB_Recordset($this->DBC->get_link_id(), $this->DBC->get_sth_result(), $sql);

                # Now loop through for image manipulation
                $image_query_list = null;
                while($rs->next_record())
                {
                    $procat_list= explode(',',$rs->f('fk_cm_id'));
                    $supp_list  = explode(',',$rs->f('fk_supplier_id'));
                    $image_list = explode(',',$rs->f('image_name'));

                    # Now insert product category
                    if(count($procat_list) > 0)
                    {
                        foreach($procat_list as $key=> $procat_id)
                        {
                            $pcat_product_id =   $rs->f('pk');
                            $pcat_procat_id  =   $procat_id;

                            $procat_query_list[]  =   "('".$pcat_product_id."','".$pcat_procat_id."')";
                        }
                    }
                    # Now insert product supplier
                    if(count($supp_list) > 0)
                    {
                        foreach($supp_list as $key => $sup_id)
                        {
                            $psup_product_id    = $rs->f('pk');
                            $psup_procat_id     = $sup_id;

                            $prosupp_query_list[]   = "('".$psup_product_id."','".$psup_procat_id."')";
                        }
                    }
                    if(count($image_list) > 0)
                    {
                        foreach($image_list as $key => $image_name)
                        {
                            $proimg_product_id  =   $rs->f('pk');
                            $proimg_filename    =   trim($image_name);
                            $proimg_title       =   $rs->f('name')." ".$rs->f('group_design_no')."-".$key;
                            $proimg_display_order =   $key;
                            $proimg_is_active   =   YES;
                            $proimg_is_cover    =   ($key=='0')?YES:NO;
                            $proimg_alt         =   $rs->f('group_name')." ".$rs->f('name')." ".$rs->f('cm_id')." ".$rs->f('group_number')." ".$rs->f('group_design_no')." ".$key;

                            $image_query_list[] = "('".$proimg_product_id."','".$proimg_filename."','".$proimg_title."','".$proimg_display_order."','".$proimg_is_active."','".$proimg_is_cover."', '".$proimg_alt."')";
                        }
                    }
                }
                # Transfer all product category
                if(count($procat_query_list) > 0)
                {
                    $sql =
                        "
    				INSERT INTO `oe_product_category`
    				(
    				`pcat_product_id`, `pcat_cm_id`
    				) VALUES ".implode(',',$procat_query_list);

                    $this->DBC->q_query($sql);

                }

                # Transfer all product supplier
                if(count($prosupp_query_list) > 0)
                {
                    $sql =
                        "
    				INSERT INTO `oe_product_supplier`
    				(
    				`psup_product_id`, `psup_supplier_id`
    				) VALUES ".implode(',',$prosupp_query_list);
                    $this->DBC->q_query($sql);
                }

                # Transfer all image to databse
                $sql =
                    "
				INSERT INTO `oe_product_images`
				(
				`proimg_product_id`, `proimg_image_file`,
				`proimg_title`,
				`proimg_display_order`, `proimg_is_active`, `proimg_is_cover`,
				`proimg_alt`
				) VALUES ".implode(',',$image_query_list);
                $this->DBC->q_query($sql);

                # Now transfer all features in table `oe_product_feature`

                foreach($all_feature_list as $feature_id => $feature_field_name)
                {
                    $field_name = "`fk_".$feature_field_name."`";

                    $sql =
                        "
						INSERT INTO `oe_product_feature`
						(`pfeature_product_id`, `pfeature_ftm_safe_url`, `pfeature_ftvm_safe_url`,`pfeature_answer`)
						SELECT
						`pk` AS `pfeature_product_id`,
						'".$feature_id."' AS `pfeature_ftm_safe_url`,
						IF(`".$field_name."` IS NULL,'',TRIM(`".$field_name."`)) AS `pfeature_ftvm_safe_url`,'' AS `pfeature_answer`
						FROM `temp_table`
						WHERE 1
						";
                    $this->DBC->q_query($sql);

                }

                # Now transfer other features in table `oe_product_feature`
                foreach($other_feature_list as $feature_id => $feature_field_name)
                {
                    $sql =
                        "
						INSERT INTO `oe_product_feature`
						(`pfeature_product_id`, `pfeature_ftm_safe_url`, `pfeature_ftvm_safe_url`, `pfeature_answer`)
						SELECT
						`pk` AS `pfeature_product_id`,
						'".$feature_id."' AS `pfeature_ftm_safe_url`,'' AS `pfeature_ftvm_safe_url`,
						IF(`".$feature_field_name."` IS NULL,'',TRIM(`".$feature_field_name."`)) AS `pfeature_answer`
						FROM `temp_table`
						WHERE 1
						";
                    $this->DBC->q_query($sql);
                }

                # Now delete those feature where pfeature_ftvm_safe_url and pfeature_answer is null
                //$sql = " DELETE FROM oe_product_feature WHERE (".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." IS NULL OR ".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = '') && (pfeature_answer)";

                $out .= "<br>== Huha... succesfully imported my data base == <br /><br />";

                $sql = "SELECT COUNT(*) AS total_record, MIN(`product_id`) AS start_from, MAX(`product_id`) AS end_at FROM `oe_product_master` WHERE `product_import_batch_number` = '".$import_batch."'";
                $this->DBC->q_prepare($sql);
                $this->DBC->q_execute();
                $rs = new DB_Recordset($this->DBC->get_link_id(), $this->DBC->get_sth_result(), $sql);
                $ilog = $rs->fetch_record(PDO_FETCH_SINGLE);

                $out .= "IMPORT NO : '".$import_batch."'<br />";
                $out .= "RECORD RANGE : ".$ilog['start_from']." TO ".$ilog['end_at']."<br />";
                $out .= "TOTAL IMPORTED RECORDS : ".$ilog['total_record']."<br /><br />";

                $out .= "<br>==Temp table TRUNCATE start.";

                $sql = "ALTER TABLE temp_table DROP PRIMARY KEY;";
                $sql .= "ALTER TABLE `temp_table` DROP `pk`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_cm_id`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_supplier_id`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_protype_id`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Fabric_2`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_WorkType_15`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Occasion_8`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_StichingType_36`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Salwar_Kameez_Type_65`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Saree_Type_67`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Lehanga_Choli_Type_68`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Kurti_Type_69`;";
                $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Gown_Type_70`;";
                $this->DBC->q_query($sql);

                $sql = "TRUNCATE `temp_table`";
                $this->DBC->q_query($sql);

                $out .= "<br>== End TRUNCATE temp table.";

                # End transaction
                $this->DBC->end_transaction();
            }
            else
            {
                throw new PDOException("No data found in temp table.");
            }
        }
        catch (PDOException $e)
        {
            # Error occured so stop transaction all roll back all chnages
            $this->DBC->stop_transaction();

            $db_e = $e->getMessage();//unserialize($e->getMessage());

            $out .= "<br>== Error info == <br><p style='color:red'>".print_r($db_e,true)."</p>";

            echo "<pre><p style='color:red'>"; print_r($e->getMessage())."</p>";

            echo "<br> === Start Truncate Temp Table ======";

            $sql = "ALTER TABLE temp_table DROP PRIMARY KEY;";
            $sql .= "ALTER TABLE `temp_table` DROP `pk`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_cm_id`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_supplier_id`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_protype_id`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Fabric_2`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_WorkType_15`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Occasion_8`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_StichingType_36`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Salwar_Kameez_Type_65`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Saree_Type_67`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Lehanga_Choli_Type_68`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Kurti_Type_69`;";
            $sql .= "ALTER TABLE `temp_table` DROP `fk_feature_Gown_Type_70`;";
            $this->DBC->q_query($sql);

            $sql = "TRUNCATE `temp_table`";
            $this->DBC->q_query($sql);

            echo"<br/> === End Truncate Temp Table ===";

            echo "<br> === Error Found. ===";
        }

        # Now delete uploaded file
        //if(isset($import_file_located))
        //    unlink($import_file_located);

        //$this->Data[P_UP] = $p_up;

        $this->DBC->ThrowError(false);

        # All process complete unlock table
        $this->DBC->unlock_tables();

        # Stop debug
        $this->DBC->stop_debug('','');

        $out .= "<br>== Debug info == <br>".print_r($Debug_info,true);

        echo "<pre>".$out."</pre>";

        $msg .= $out;
        # Serialize All message
        $import_data = base64_encode(serialize($msg));

        echo "<br>=== Start insert into Import Log table ===";

        $record_range = isset($ilog) && !empty($ilog)? $ilog['start_from'].' TO '.$ilog['end_at']:'0';
        $total_record = isset($ilog['total_record']) && !empty($ilog['total_record'])?$ilog['total_record']:'0';
        $sql =
            "
			INSERT INTO `oe_import_log`
			(
			`il_file`,
			`l_batch_no`,
			`il_record_range`,
            `il_total_records`,
            `il_data`
			) VALUES ('".$fileName."','".$import_batch."','".$record_range."','".$total_record."','".$import_data."')";

        $this->DBC->run_query($sql,false,false);

        echo "<br>=== End insert data ===";

        die;
    }
    /**
     * NEW EXCEL SHEET IMPORT LOGIC
    **/
    public function MoveImportFileToImportFolder($fileName)
    {
        global $physical_path;

        if(empty($fileName))
            return false;

        $source = $this->Data[P_UP]."/".$fileName;
        $destination = $physical_path['Upload'].'/import/'.$fileName;

        # Copy image from user folder to user_id folder and remove from user folder
        if(copy($source,$destination))
            unlink($source);

    }
    public function ExcelImportFieldList($cf_id,$cs_id,$ct_id)
    {
        global $asset;

        $brand          = CategoryBrand::obj()->getCategoryBrandByCategoryId($ct_id);
        $arrBusiness    = BusinessMaster::obj()->getKeyValueArray();

        $list = array(
            'SKU'                           =>  array(
                'feature_field'             =>  'sku',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Enter unique SKU code to mantain product stock and for other manuplation.',
            ),
            'Group ID'                      =>  array(
                'feature_field'             =>  'group_id',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Group ID is a code given to the different color and size variants of the same design. All products with this common code will be clubbed together on the product and browse page. For example, if a product comes in three sizes and each size comes in two colors, then there will be a total of six products which would require a common Group ID.',
            ),
            'Price'                         =>  array(
                'feature_field'             =>  'price',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_FLOAT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Write product price.',
            ),
            'Max Retail Price'              =>  array(
                'feature_field'             =>  'max_retail_price',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_FLOAT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Write product market price (MRP). This price will be shown with overline. Max retail price must be greater than Selling Price.',
            ),
            'Selling Price'                 =>  array(
                'feature_field'             =>  'selling_price',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_FLOAT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  YES,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'User will purchase product with this price. This price will include everything like product price, shipping cost, any tax and other. Selling Price must be less than max retail price.',
            ),
            'Min Selling Price'             =>  array(
                'feature_field'             =>  'min_selling_price',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_FLOAT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Write product minimum selling price. This will be helpful to create offers and discount.',
            ),
            'Shipping Charge'               =>  array(
                'feature_field'             =>  'shipping_charge',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_FLOAT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Enter shipping charge for product. This price is already included in your Selling Price but here only for future information.',
            ),
            'Quantity'                      =>  array(
                'feature_field'             =>  'quantity',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_INT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'How many products you want to sell. Total number of items.',
            ),
            'Minimum Order Quantity'        =>  array(
                'feature_field'             =>  'min_order_qty',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_INT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Minimum order quantity for purchase.',
            ),
            'Weight'                        =>  array(
                'feature_field'             =>  'weight',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  V_FLOAT,
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Total weight of product. Weight must be in Kilogram (KG).',
            ),
            'Brand Name'                    =>  array(
                'feature_field'             =>  BrandMaster::obj()->Data[F_P_KEY],
                'feature_control_type'      =>  FCNTTYPE_RADIO,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  YES,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Select brand name of product.',
                'feature_value'             =>  is_array($brand)?array_flip($brand):false,
            ),
            'Business'                      =>  array(
                'feature_field'             =>  BusinessMaster::obj()->Data[F_P_KEY],
                'feature_control_type'      =>  FCNTTYPE_RADIO,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  YES,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Select business name of product.',
                'feature_value'             =>  is_array($arrBusiness)?array_flip($arrBusiness):false,
            ),
            'Freebies'                      =>  array(
                'feature_field'             =>  'freebies',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_OPTIONAL,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Enter any product that is given free of charge.',
            ),
            'Full Description'              =>  array(
                'feature_field'             =>  'full_desc',
                'feature_control_type'      =>  FCNTTYPE_TEXTBOX,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_OPTIONAL,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Write product details so users can get more information.',
            ),
            'Enable Inquiry'                =>  array(
                'feature_field'             =>  'enable_inquiry',
                'feature_control_type'      =>  FCNTTYPE_RADIO,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Whether user can send inquiry or not.',
                'feature_value'             =>  array_flip($asset['OL_YesNo']),
            ),
            'Enable Purchase'               =>  array(
                'feature_field'             =>  'enable_purchase',
                'feature_control_type'      =>  FCNTTYPE_RADIO,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Whether user can purchase product or not.',
                'feature_value'             =>  array_flip($asset['OL_YesNo']),
            ),
            'Ready To Dispatch?'            =>  array(
                'feature_field'             =>  'is_ready_to_dispatch',
                'feature_control_type'      =>  FCNTTYPE_RADIO,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Whether product is ready for dispatch when user will place an order.',
                'feature_value'             =>  array_flip($asset['OL_YesNo']),
            ),
            'Is Upcoming?'                  =>  array(
                'feature_field'             =>  'is_upcoming',
                'feature_control_type'      =>  FCNTTYPE_RADIO,
                'feature_type'              =>  FEATURETYPE_REGULAR,
                'feature_validation'        =>  '',
                'feature_column_color'      =>  '',
                'feature_is'                =>  FEATUREIS_REQUIRED,
                'feature_enable_search'     =>  NO,
                'feature_used_for'          =>  '',
                'feature_guideline'         =>  'Product is upcoming soon but want to take its order in advance.',
                'feature_value'             =>  array_flip($asset['OL_YesNo']),
            )
        );
        return $list;
    }
    public function getTempFieldName($name)
    {
        return 'temp_'.str_replace('-','_',$this->buildURLFriendlyName($name));
    }
    public function CreateTempTableForProductImport($cf_id,$cs_id,$ct_id,$TABLE_FIELDS)
    {
        $TABLE_NAME     =   strtolower("temp_import_".$cf_id."_".$cs_id."_".$ct_id."_".$_SESSION['session_id']);

        # Generate table with colums fileds
        $sql  = "DROP TABLE IF EXISTS ".$TABLE_NAME.";";
        $sql .= "CREATE TABLE ".$TABLE_NAME. " (`temp_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, ".implode(" TEXT NOT NULL,", $TABLE_FIELDS)." TEXT NOT NULL) COMMENT='Created at ".date('Y-m-d H:i:s')."'";

        $this->DBC->run_query($sql, false, false);

        return $TABLE_NAME;
    }
    public function ImportDataInTempTable($source_file_name, $TEMP_TABLE, $TEMP_SCHEMA)
    {
        global $config, $physical_path, $virtual_path, $Debug_info;

        $CSVFilePath = $physical_path['Upload'].'/import/'.$source_file_name;

        $file = fopen($CSVFilePath, "r");

        $temp=1;$es_row=1;$ee_row=103;$FileContents = array();

        while(($data = fgetcsv($file)) !== false)
        {
            if($temp >= $es_row && $temp <= $ee_row)
            {
	            # If First column has no data then skip that row
	            if($data[0] != '')
		            $FileContents[] = $data;
            }
	        else
	        {
		        if($temp > $ee_row){break;}
	        }
	        $temp++;
        }
        # Get field name list, save in variable and remove it from main content, Row 1
        $ColumnsList = array_shift($FileContents);

        $FieldList = array_map(function($v){return  $this->getTempFieldName($v);}, $ColumnsList);

        if($FieldList === $TEMP_SCHEMA)
        {
            # Remove all data with data type instruction. Row 2
            array_shift($FileContents);

            # Remove all data with example and field explanation. Row 3
            array_shift($FileContents);

            # Now check for data exist in array or not
            if(count($FileContents) > 0)
            {
                # start debug
                $this->DBC->ThrowError(true);
                $this->DBC->start_transaction();

                $FieldCount    = count($TEMP_SCHEMA);
                $sqlValuesError= '';

                try
                {
                    $sql_val_field = array_map(function($v){return ":".$v;},$TEMP_SCHEMA);

                    $sql = "INSERT INTO ".$TEMP_TABLE." (".implode(',',$TEMP_SCHEMA).") VALUES (".implode(',',$sql_val_field).")";
                    $this->DBC->q_prepare($sql);

                    $imported=0;
                    for($i = 0; $i < count($FileContents); $i++)
                    {
                        $excel_row = $i+4;
                        $arrData = isset($FileContents[$i])?$FileContents[$i]:array();
                        $d_count = count($arrData);

                        if(is_array($arrData) && $d_count == $FieldCount)
                        {
                            if($arrData[0] != '')
                            {
                                $arrData = array_map(function($v){return  trim($v);}, $arrData);
                                $val = array_combine($sql_val_field, $arrData);

                                $this->DBC->q_execute($val);
                                $id = $this->DBC->last_inserted_id();

                                if(is_numeric($id))
                                    $imported++;
                                else
                                    $sqlValuesError[] = "Excel Row [".$excel_row."] : ".$arrData[0]." - Unable to insert data.";
                            }
                            else
                                $sqlValuesError[] = "Excel Row [".$excel_row."] : First column is empty.";
                        }
                        else
                            $sqlValuesError[] = "Excel Row [".$excel_row."] : Column count mismatch. Required columns ".$FieldCount." found columns ".$d_count.".";
                    }

                    if($imported != count($FileContents))
                        $sqlValuesError[] = "Inappropriate data found so skipped some row during import. Total records found ".count($FileContents)." and total imported ".$imported.".";
                }
                catch(Exception $e)
                {
                    # Error Log Action
                    if($this->DBErrorLog === true)
                        ErrorLog::obj()->AddErrorLog(A_ADD, $e->getMessage());

                    if(!isset($config['OnLocal']))
                        $this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to insert your record. Check your details and try again.';
                    else
                        $this->Error[E_DESC] = $e->getMessage();
                }

                # If some error found during import process then
                if(is_array($sqlValuesError) && count($sqlValuesError) > 0)
                    $this->Error[E_DESC] .= implode(' ',$sqlValuesError);

                if($this->Error[E_DESC] == '')
                {
                    # No error found so commit for all execution
                    $this->DBC->end_transaction();
                    return true;
                }
                else
                    $this->DBC->stop_transaction();
            }
            else
                $this->Error[E_DESC] = "No data found in excel sheet. Please import sheet appropriate data.";
        }
        else
            $this->Error[E_DESC] = "Columns count mismatch. Your excel sheet is inappropriate or older version.";

        return false;
    }
    public function TransferImportedData($POST, $CatInfo, $TEMP_TABLE, $TEMP_SCHEMA, $arrMain, $arrFeature, $arrImage, $arrAddImage)
    {
        global $config;

        $map_keys = function ($f_info){$o = array(); foreach($f_info as $k => $v){
            $o[$this->getTempFieldName($k)] = $v;
            $o[$this->getTempFieldName($k)]['feature_title'] = $k;
        } return $o;};

        $arrMain        = $map_keys($arrMain);
        $arrFeature     = $map_keys($arrFeature);
        $arrImage       = $map_keys($arrImage);
        $arrAddImage    = $map_keys($arrAddImage);
        if(is_array($arrMain) && count($arrMain) > 0 && is_array($arrFeature) && count($arrFeature) > 0 && is_array($arrImage) && count($arrImage) > 0 && is_array($arrAddImage) && count($arrAddImage) > 0)
        {
            $sql = "SELECT * FROM `".$TEMP_TABLE."`";
            $rs = $this->DBC->run_query($sql);
            $temp_data = $rs->fetch_record();
            if($rs->TotalRow > 0)
            {
                $adt = date('Y-m-d H:i:s');
                $GROUP_LIST = array();

                # start debug
                $this->DBC->ThrowError(true);
                $this->DBC->start_transaction();

                try
                {
                    $ExcelStartRow=504;

                    ################################################################################
                    # Server side validation. Check for valid data for each column in record.
                    $error='';
                    foreach ($temp_data as $ri => $R)
                    {
                        # Set row number in variable for which we are processing
                        $excel_row = $ri+$ExcelStartRow;

                        $is_v=true; $e=''; $e .= 'EXCEL ROW - '.$excel_row.' | ';

                        foreach(array_merge($arrMain,$arrFeature,$arrImage,$arrAddImage) as $field => $info)
                        {
                            $ce = '';

                            # If field is empty then check for how it's controll tyte
                            if($R[$field] == '')
                            {
                                # Check for valid data for column
                                if($info['feature_is'] == FEATUREIS_REQUIRED || $info['feature_is'] == FEATUREIS_BASIC)
                                {
                                    $is_v=false;
                                    $ce .= 'No data found. Empty data not valid. ';
                                }
                            }
                            else
                            {
                                # Check for any applied validation
                                if(isset($info['feature_validation']) && $info['feature_validation'] != '')
                                {
                                    $v = explode(',',$info['feature_validation']);
                                    if(in_array(V_INT,$v))
                                    {
                                        if(strpos($R[$field],'.') !== false)
                                        {
                                            $is_v=false;
                                            $ce .= 'Please enter number only. No decimal point allowed. ';
                                        }
                                    }
                                    if(in_array(V_FLOAT,$v))
                                    {
                                        if(!is_numeric($R[$field]))
                                        {
                                            $is_v=false;
                                            $ce .= 'Please enter number only with or without decimal. ';
                                        }
                                    }
                                }
                            }
                            if($is_v==false && $ce != ''){$e .= 'COLUMN : '.$info['feature_title'].' => '.$ce;}
                        }
                        $GROUP_COUNT[$R['temp_group_id']][] = $excel_row;

                        # Check for valid price
                        if($R['temp_max_retail_price'] < $R['temp_selling_price'])
                        {
                            $is_v=false;
                            $e .= 'Please enter valid price. Max Retail Price '.$R['temp_max_retail_price'].' must be greater than or equal to Selling Price '.$R['temp_selling_price'].'. ';
                        }

                        if($is_v !== true){$error .= $e;}
                    }

                    # Check for max number of products in one group.
                    $g_error = '';
                    foreach($GROUP_COUNT AS $gk=>$gval)
                    {
                        $product_count = count($gval);

                        if($product_count > PRODUCT_STYLE_GROUP_MAX_ITEM)
                        {
                            $g_error .= "Group : ".$gk." - Rows (".implode(',',$gval).") - Product Count : ".$product_count.". ";
                        }
                    }

                    if($g_error != '')
                        $error = 'You can enter only '.PRODUCT_STYLE_GROUP_MAX_ITEM.' products in one group. '.$g_error;

                    # Check for any error with data as per validation if so then trigger error and terminate process
                    if($error != '')
                        throw new Exception($error);

                    ################################################################################
                    # Manipulate to transfer data in main tables

	                $InCat = $CatInfo[$POST['cat_t']];
	                $CatUsedFor = explode(',',$InCat['cm_used_for']);

                    foreach ($temp_data as $ri => $R)
                    {
                        # Set row number in variable for which we are processing
                        $excel_row = $ri+$ExcelStartRow;

                        # SQL value storage variables
                        $V_Product=array();$V_Feature=array();$V_Category=array();$V_Images=array();$V_Supplier=array();$V_AddImages=array();

                        # Temp variables to collect data for dependent required field  from imported fata
                        $name=array();$s_line=array();$s_desc=array();$b_title=array();$m_key=array();$m_desc=array();

                        # Check for style group in list array. If not exist then insert new.
                        if(!isset($GROUP_LIST[$R['temp_group_id']]))
                        {
                            $sql = " INSERT INTO ".ProductStyleGroup::obj()->Data[TABLE_NAME]." (`".ProductStyleGroup::obj()->Data[F_P_FIELD]."`, `psg_image_info`,`psg_req_feature_info`) VALUES (?,?,?);";
                            $this->DBC->q_prepare($sql);
                            $this->DBC->q_execute(array('','',''));
                            $psg_id = $this->DBC->last_inserted_id();

                            $GROUP_LIST[$R['temp_group_id']] =  $psg_id;
                        }

                        # Now set psg_id in temp variable
                        $psg_id = $GROUP_LIST[$R['temp_group_id']];

                        # Manipulate for product feature table
                        foreach($arrFeature as $field => $info)
                        {
                            # If field is empty then skip it
                            if($R[$field] != '')
                            {
                                # Get used for list for feature
                                $used_for = explode(',', $info['feature_used_for']);

                                # Predefied value list for feature
                                $f_value = array();$new_f_value=array();
                                if(isset($info['feature_value']))
                                {
                                    $f_value = $info['feature_value'];

                                    # Convert all kays to upper case
                                    if(count($f_value) > 0)
                                    {
                                        foreach($f_value as $k => $v)
                                        {
                                            $new_f_value[strtoupper($k)] = $v;
                                        }
                                    }
                                }

                                # Set data based on control type of feature
                                $V_Feature[$field][':f']        = $info['feature_field'];
                                $V_Feature[$field][':fv']       = null;
                                $V_Feature[$field][':ans']      = '';
                                $V_Feature[$field][':psg_id']   = $psg_id;

                                if($info['feature_control_type'] == FCNTTYPE_TEXTBOX)
                                    $V_Feature[$field][':ans'] = trim($R[$field]);
                                elseif($info['feature_control_type'] == FCNTTYPE_LIST_TEXTBOX)
                                    $V_Feature[$field][':ans'] = trim(str_replace('::', ', ', $R[$field]));
                                elseif($info['feature_control_type'] == FCNTTYPE_RADIO)
                                {
                                    if(is_string($R[$field]) || is_numeric($R[$field]))
                                    {
                                        $_v = strtoupper(trim($R[$field]));
                                        if(isset($new_f_value[$_v]))
                                        {
                                            $V_Feature[$field][':fv'] = $new_f_value[$_v];
                                        }
                                    }
                                }
                                elseif($info['feature_control_type'] == FCNTTYPE_CHECKBOX)
                                {
                                    $list = explode(',', $R[$field]);
                                    if(is_array($list) && count($list) > 0)
                                    {
                                        foreach($list as $_k => $_v)
                                        {
                                            $_v = strtoupper(trim($_v));
                                            if(isset($new_f_value[$_v]))
                                            {
                                                $V_Feature[$field][':fv'][] = $new_f_value[$_v];
                                            }
                                        }
                                    }
                                }

                                $n = $info['feature_title'].' '.$R[$field];
                                $n = explode(',', $n);
                                $n = implode(', ', $n);
                                $n = str_replace('::', ', ', $n);

                                # Set dependent field value based on features. Check for any possibility for current feature
                                if(in_array(FEATUREUSEDFOR_NAME, $used_for))
                                {
                                    # Check whether need to concat display title with feature value
                                    if($info['feature_title_used_with_used_for'] == YES)
                                    {
                                        # Concat display title at which position
                                        if($info['feature_title_position'] == FEATURE_POSITION_PREFIX)
                                        {
                                            $R[$field] = $info['feature_title'].' '.$R[$field];
                                        }
                                        elseif($info['feature_title_position'] == FEATURE_POSITION_SUFFIX)
                                        {
                                            $R[$field] = $R[$field].' '.$info['feature_title'];
                                        }
                                        else
                                        {
                                            $R[$field] = $R[$field].' '.$info['feature_title'];
                                        }
                                    }
                                    $nn      = explode(',', $R[$field]);
                                    $nn      = implode(', ', $nn);
                                    $name[] = str_replace('::', ', ', $nn);
                                }
                                if(in_array(FEATUREUSEDFOR_SECOND_LINE, $used_for))
                                {
                                    $s_line[] = $n;
                                }
                                if(in_array(FEATUREUSEDFOR_SHORT_DESC, $used_for))
                                {
                                    $s_desc[] = $n;
                                }
                                if(in_array(FEATUREUSEDFOR_BROWSER_TITLE, $used_for))
                                {
                                    $b_title[] = $n;
                                }
                                if(in_array(FEATUREUSEDFOR_META_KEYWORD, $used_for))
                                {
                                    $m_key[] = $n;
                                }
                                if(in_array(FEATUREUSEDFOR_META_DESC, $used_for))
                                {
                                    $m_desc[] = $n;
                                }
                            }
                        }

	                    $max_str_length = 255;

                        # Set some field detail based on imported data
                        $V_Product['name'] = implode(' ',$name);
						if(in_array(FEATUREUSEDFOR_NAME,$CatUsedFor)){$V_Product['name'] .= ' '.$InCat[CategoryMaster::obj()->Data[F_P_FIELD]];}
	                    $V_Product['name'] = ucwords($V_Product['name']);

                        $V_Product['safe_url'] = $this->buildURLFriendlyName($V_Product['name']);

                        $V_Product['second_line'] = implode('. ',$s_line).'.';
                        $V_Product['second_line'] = substr($V_Product['second_line'],0,round($max_str_length/2));
                        $V_Product['second_line'] = substr($V_Product['second_line'],0,strrpos($V_Product['second_line'],'. ')).'.';


                        $V_Product['short_desc'] = implode('. ',$s_desc).'.';
                        //$V_Product['short_desc'] = substr($V_Product['short_desc'],0,$max_str_length);
                        //$V_Product['short_desc'] = substr($V_Product['short_desc'],0,strrpos($V_Product['short_desc'],'. ')).'.';

                        $V_Product['page_heading'] = $V_Product['name'];

                        $V_Product['browser_title'] = implode(' ',$b_title);

                        $V_Product['meta_keyword'] = strtolower(implode(',  ',$m_key));
                        $V_Product['meta_keyword'] = substr($V_Product['meta_keyword'],0,$max_str_length);
                        $V_Product['meta_keyword'] = substr($V_Product['meta_keyword'],0,strrpos($V_Product['meta_keyword'],', '));

                        $V_Product['meta_desc'] = implode('. ',$m_desc).'.';
                        $V_Product['meta_desc'] = substr($V_Product['meta_desc'],0,$max_str_length);
                        $V_Product['meta_desc'] = substr($V_Product['meta_desc'],0,strrpos($V_Product['meta_desc'],'. ')).'.';

                        $V_Product['meta_external_tag'] = '';

                        $V_Product['discount'] = number_format((($R['temp_max_retail_price'] - $R['temp_selling_price']) * 100)/$R['temp_max_retail_price']);

                        # Set some field basic details which we will not get it from import sheet
                        $V_Product['added_by_id']   =   AuthUser::obj()->UserID;
                        $V_Product['added_by_type'] =   AuthUser::obj()->User_Perm;

                        $V_Product['import_batch_number']   =   $adt;
                        $V_Product['added_datetime']        =   $adt;
                        $V_Product['updated_datetime']      =   $adt;

                        $V_Product['is_featured']       =   NO;
                        $V_Product['is_hot_favourite']  =   NO;
                        $V_Product['is_active']         =   NO;

                        $V_Product['psg_id'] = $psg_id;
                        $V_Product['ean']   = '';
                        $V_Product['upc'] = '';
                        # Manipulate for product main table
                        foreach($arrMain as $field => $info)
                        {
                            $key = $info['feature_field'];

                            # If field is empty then skip it
                            //if($R[$field] != ''){}
                                # Predefined value list for feature
                                $f_value = array();
                                if(isset($info['feature_value']))
                                {
                                    $f_value = $info['feature_value'];
                                }

                                if($info['feature_control_type'] == FCNTTYPE_TEXTBOX)
                                    $V_Product[$key] = trim($R[$field]);
                                elseif($info['feature_control_type'] == FCNTTYPE_LIST_TEXTBOX)
                                    $V_Product[$key] = trim(str_replace('::', ', ', $R[$field]));
                                elseif($info['feature_control_type'] == FCNTTYPE_RADIO)
                                {
                                    $R[$field] = trim($R[$field]);
                                    if(isset($f_value[$R[$field]]))
                                    {
                                        $V_Product[$key] = $f_value[$R[$field]];
                                    }
                                }
                                elseif($info['feature_control_type'] == FCNTTYPE_CHECKBOX)
                                {
                                    $list = explode(',', $R[$field]);
                                    if(is_array($list) && count($list) > 0)
                                    {
                                        foreach($list as $_k => $_v)
                                        {
                                            $_v = trim($_v);
                                            if(isset($f_value[$_v]))
                                            {
                                                $V_Product[$key][] = $f_value[$_v];
                                            }
                                        }
                                    }

                                    if(is_array($V_Product[$key]))
                                        $V_Product[$key] = implode(',', $V_Product[$key]);
                                }

	                        # Manipulate for product supplier table
                            /*if($key == Supplier::obj()->Data[F_P_KEY])
	                        {
		                        # Supplier will come with product detail but it has another table to store data so seperate it
		                        $V_Supplier = $V_Product[$key];
		                        unset($V_Product[$key]);
	                        }*/

                        }
                        # Check for valid supplier for product. If no supplier found then trigger error
	                    /*if($V_Supplier == '')
		                    throw new Exception('EXCEL ROW - '.$excel_row.'. No supplier found. ');*/

                        # Manipulate for product image table
                        $imgo=1;
                        foreach($arrImage as $field => $info)
                        {
                            # If field is empty then skip it
                            if($R[$field] != '')
                            {
                                $V_Images[$field][':img_name'] = trim($R[$field]);
                                $V_Images[$field][':title']    = $V_Product['name'];
                                $V_Images[$field][':order']    = $imgo;
                                $V_Images[$field][':is_cover'] = ($imgo == 1)?YES:NO;
                                $V_Images[$field][':alt']      = '';
                                $imgo++;
                            }
                        }
                        # Manipulate for product additional image table
                        $aimgo=1;
                        foreach($arrAddImage as $field => $info)
                        {
                            # If field is empty then skip it
                            if($R[$field] != '')
                            {
                                $V_AddImages[$field][':img_name'] = trim($R[$field]);
                                $V_AddImages[$field][':order']    = $aimgo;
                                $imgo++;
                            }
                        }
                        # Execute SQL statement to transfer all data in database
                        $sql = "INSERT INTO ".$this->Data[TABLE_NAME]." (".implode(',',array_map(function($v){return $this->Data[FIELD_PREFIX].$v;},array_keys($V_Product))).") VALUES (".rtrim(str_repeat('?,',count($V_Product)),',').")";
                        $this->DBC->q_prepare($sql);
                        $this->DBC->q_execute(array_values($V_Product));
                        $pk = $this->DBC->last_inserted_id();

                        if(is_numeric($pk))
                        {
                            # Start inserting in category
                            $cf = array(ProductCategory::obj()->Data[F_F_KEY],ProductCategory::obj()->Data[F_P_FIELD]);
                            $sql = "INSERT INTO ".ProductCategory::obj()->Data[TABLE_NAME]." (".implode(',',$cf).") VALUES (".implode(',',array_map(function($v){return ':'.$v;},$cf)).")";
                            $this->DBC->q_prepare($sql);
                            $V_Category[':'.ProductCategory::obj()->Data[F_F_KEY]] = $pk;
                            foreach($CatInfo as $id=>$name)
                            {
                                $V_Category[':'.ProductCategory::obj()->Data[F_P_FIELD]] = $id;
                                $this->DBC->q_execute($V_Category);
                            }

                            # Start inserting in supplier table
                            /*$sf = array(ProductSupplier::obj()->Data[F_F_KEY],ProductSupplier::obj()->Data[F_P_FIELD]);
                            $sql = "INSERT INTO ".ProductSupplier::obj()->Data[TABLE_NAME]." (".implode(',',$sf).") VALUES (".implode(',',array_map(function($v){return ':'.$v;},$sf)).")";
                            $this->DBC->q_prepare($sql);
                            $SupInfo = explode(',',$V_Supplier);
                            $sup = array();
	                        $sup[':'.ProductSupplier::obj()->Data[F_F_KEY]] = $pk;
                            foreach($SupInfo as $si=>$sv)
                            {
                                $sup[':'.ProductSupplier::obj()->Data[F_P_FIELD]] = $sv;
                                $this->DBC->q_execute($sup);
                            }*/

                            # Insert product images
                            $if = array($this->Data[F_P_KEY],'image_file','title','display_order','is_cover','alt');
                            $sql = "INSERT INTO ".ProductImages::obj()->Data[TABLE_NAME]."  (".implode(',',array_map(function($v){return ProductImages::obj()->Data[FIELD_PREFIX].$v;},$if)).") VALUES (:pid,:img_name,:title,:order,:is_cover,:alt)";
                            $this->DBC->q_prepare($sql);
                            foreach($V_Images as $ik=>$iv)
                            {
                                $iv[':pid'] = $pk;
                                $this->DBC->q_execute($iv);
                            }

                            # Insert product additional images
                            $if = array($this->Data[F_P_KEY],'image_file','display_order');
                            $sql = "INSERT INTO ".ProductAdditionalImages::obj()->Data[TABLE_NAME]."  (".implode(',',array_map(function($v){return ProductAdditionalImages::obj()->Data[FIELD_PREFIX].$v;},$if)).") VALUES (:pid,:img_name,:order)";
                            $this->DBC->q_prepare($sql);
                            foreach($V_AddImages as $ik=>$iv)
                            {
                                $iv[':pid'] = $pk;
                                $this->DBC->q_execute($iv);
                            }

                            # Start inserting in feature
                            $ff = array($this->Data[F_P_KEY],FeatureMaster::obj()->Data[F_P_KEY],FeatureValueMaster::obj()->Data[F_P_KEY],'answer','psg_id');
                            $sql = "INSERT INTO ".ProductFeature::obj()->Data[TABLE_NAME]." (".implode(',',array_map(function($v){return ProductFeature::obj()->Data[FIELD_PREFIX].$v;},$ff)).") VALUES (:pid,:f,:fv,:ans,:psg_id)";
                            $this->DBC->q_prepare($sql);
                            $v_f[':pid'] = $pk;
                            foreach($V_Feature as $tf => $info)
                            {
                                $v_f = array_merge($v_f,$info);
                                if(is_array($info[':fv']))
                                {
                                    foreach($info[':fv'] as $kk => $vv)
                                    {
                                        $v_f[':fv'] = $vv;
                                        $this->DBC->q_execute($v_f);
                                    }
                                }
                                else
                                {
                                    $this->DBC->q_execute($v_f);
                                }
                            }

                            # Now Update in product_style_group table
                            $group_sql = "SET group_concat_max_len = (1024*".PRODUCT_STYLE_GROUP_MAX_ITEM.");";
                            $group_sql .= "UPDATE ".ProductStyleGroup::obj()->Data[TABLE_NAME]." PSG 
                                    SET `".ProductStyleGroup::obj()->Data[F_P_FIELD]."` = 
                                    (
                                        SELECT GROUP_CONCAT(CONCAT_WS('|',SPM.".$this->Data[F_P_KEY].",SPM.".$this->Data[F_S_URL].") ORDER BY SPM.product_quantity DESC SEPARATOR '/' ) FROM ".$this->Data[TABLE_NAME]." SPM WHERE SPM.".$this->Data[F_F_KEY]." = '".$psg_id."'
                                    ), 
                                    `psg_image_info` = 
                                    (
                                        SELECT GROUP_CONCAT(CONCAT_WS('|',SPM.".$this->Data[F_P_KEY].",SPM.".$this->Data[F_ADDED_DATETIME].",PIM.".ProductImages::obj()->Data[F_P_KEY].",PIM.proimg_image_file) ORDER BY SPM.product_quantity DESC SEPARATOR '/' )
                                        FROM ".$this->Data[TABLE_NAME]." SPM,
                                        ".ProductImages::obj()->Data[TABLE_NAME]." PIM
                                        WHERE SPM.".$this->Data[F_F_KEY]." = ".$psg_id."
                                        AND SPM.".$this->Data[F_P_KEY]."  =  PIM.".ProductImages::obj()->Data[F_F_KEY]."
                                        AND proimg_is_cover = 1
                                    ),
                                    `psg_req_feature_info` = 
                                    (
                                        SELECT GROUP_CONCAT(CONCAT_WS('|',SPM.".ProductMaster::obj()->Data[F_P_KEY].",(CONCAT_WS('[]',CONCAT_WS('*',SFM.".FeatureMaster::obj()->Data[F_P_KEY].",SFM.feature_display_title),CONCAT_WS('*',SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY].",SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD].")))) ORDER BY SPM.product_quantity DESC, SFVM.".FeatureValueMaster::obj()->Data[F_P_FIELD]." ASC SEPARATOR '/' )
                                        FROM 
                                        ".$this->Data[TABLE_NAME]." SPM,
                                        ".ProductFeature::obj()->Data[TABLE_NAME]." SPF,
                                        ".FeatureValueMaster::obj()->Data[TABLE_NAME]." SFVM,
                                        ".FeatureMaster::obj()->Data[TABLE_NAME]." SFM
                                        WHERE SPM.".$this->Data[F_F_KEY]." = PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]."
                                        AND SPF.".ProductFeature::obj()->Data[F_F_KEY]." = SPM.".$this->Data[F_P_KEY]."
                                        AND SPF.".ProductFeature::obj()->Data[F_P_FIELD]." = SFM.".FeatureMaster::obj()->Data[F_P_KEY]."
                                        AND SPF.".ProductFeature::obj()->Data[FIELD_PREFIX].FeatureValueMaster::obj()->Data[F_P_KEY]." = SFVM.".FeatureValueMaster::obj()->Data[F_P_KEY]."
                                        AND SFM.".FeatureMaster::obj()->Data[FIELD_PREFIX]."is = '".FEATUREIS_REQUIRED."'
                                    ) WHERE PSG.".ProductStyleGroup::obj()->Data[F_P_KEY]." = ".$psg_id;

                            $this->DBC->q_query($group_sql);

                            # Successfully inserted one record so log log PK
                            $record_range[] = $pk;
                        }
                        else
                        {
                            $e = 'EXCEL ROW : '.$excel_row.'. Unable to save required details and import has been terminated. Check your record and try again.';
                            throw new Exception($e);
                            break;
                        }
                    }
                }
                catch(Exception $e)
                {
                    # Error Log Action
                    if($this->DBErrorLog === true)
                        ErrorLog::obj()->AddErrorLog(A_ADD, $e->getMessage());

                    if(!isset($config['OnLocal']))
                        $this->Error[E_DESC] = 'Sorry, critical error occurred. Unable to insert your record. Check your details and try again.';
                    else
                        $this->Error[E_DESC] = $e->getMessage();
                }

                $this->DBC->ThrowError(false);

                # No error found so commit for all execution
                if(isset($record_range) && is_array($record_range) && count($temp_data) == count($record_range))
                {
                    $this->DBC->end_transaction();
                    return array(
                        'import_batch'  =>  $V_Product['import_batch_number'],
                        'record_range'  =>  $record_range
                    );
                }
                else
                {
                    $this->Error[E_DESC] .= " Error while transfering data. Please try again.";
                    $this->DBC->stop_transaction();
                }
            }
            else
                $this->Error[E_DESC] = "No data found in temp table.";
        }
        else
            $this->Error[E_DESC] = "Temp table schema not found while transferring your imported data.";

        return false;
    }
    public function ImportData($POST)
    {
        global  $config, $physical_path, $virtual_path, $Debug_info;

        $POST['cat_f'] = isset($POST['cat_f'])?Ocrypt::dec($POST['cat_f']):'';
        $POST['cat_s'] = isset($POST['cat_s'])?Ocrypt::dec($POST['cat_s']):'';
        $POST['cat_t'] = isset($POST['cat_t'])?Ocrypt::dec($POST['cat_t']):'';

        if(is_numeric($POST['cat_f']) && is_numeric($POST['cat_s']) && is_numeric($POST['cat_t']))
        {
            $CatInfo = CategoryMaster::obj()->CheckCategoryForDataImport($POST['cat_f'],$POST['cat_s'],$POST['cat_t']);
            if(is_array($CatInfo) && count($CatInfo) == 3)
            {
                if(isset($_FILES) && !empty($_FILES['csv_file']))
                {
                    $file_name = $this->uploadFile($_FILES['csv_file'], '', false, false);//'_IMPORT_Clothing_EthnicWear_Saree.csv'
                    if(!empty($file_name))
                    {
                        # Copy upload file from product folder to import folder and remove file from product folder
                        ProductMaster::obj()->MoveImportFileToImportFolder($file_name);

                        # Get all field info for import process
                        $arrMain    = $this->ExcelImportFieldList($POST['cat_f'], $POST['cat_s'], $POST['cat_t']);
                        $arrFeature = CategoryFeature::obj()->getCategoryFeatureWithValue($POST['cat_t']);
                        $arrImage   = ProductImages::obj()->ExcelImportImagesFieldList();
                        $arrAddImage = ProductAdditionalImages::obj()->ExcelImportAdditionalImagesFieldList();

                        # We were changed xml for excel sheet that is all required feature is after group id so seprate required and other feature
                        foreach($arrFeature as $fk =>$fval)
                        {
                            if ($fval['feature_is'] == FEATUREIS_REQUIRED)
                                $arrRequiredFeature[$fk] = $fval;
                            else
                                $arrOtherFeature[$fk]   =   $fval;

                        }

                        # Now break main array and merge with required feature.
                        $s_array = array_slice($arrMain,0,2);
                        $e_array = array_slice($arrMain,2);

                        $arrProduct = array_merge($s_array,$arrRequiredFeature,$e_array);
                        # ---------
                        $TEMP_SCHEMA = array_map(function ($v){return $this->getTempFieldName($v);}, array_keys(array_merge($arrProduct, $arrOtherFeature, $arrImage, $arrAddImage)));

                        if(is_array($TEMP_SCHEMA) && count($TEMP_SCHEMA) > 0)
                        {
                            # Now create temp table to dump file data in database
                            $TEMP_TABLE = ProductMaster::obj()->CreateTempTableForProductImport($POST['cat_f'], $POST['cat_s'], $POST['cat_t'], $TEMP_SCHEMA);
                            if($TEMP_TABLE != '')
                            {
                                # Insert data into temp table.
                                if($this->ImportDataInTempTable($file_name, $TEMP_TABLE, $TEMP_SCHEMA) === true)
                                {
                                    $s = $this->TransferImportedData($POST, $CatInfo, $TEMP_TABLE, $TEMP_SCHEMA, $arrMain, $arrFeature, $arrImage, $arrAddImage);

                                    # Drop temp table
                                    $this->DBC->drop_table($TEMP_TABLE);

                                    if(is_array($s))
                                    {
                                        # Insert log
                                        $rng = $s['record_range'][0].' TO '.$s['record_range'][count($s['record_range'])-1];
                                        $sql = "INSERT INTO ".ImportLog::obj()->Data[TABLE_NAME]."(il_file,il_batch_no,il_record_range,il_total_records,il_data)
                                        VALUES ('".$file_name."','".$s['import_batch']."','".$rng."','".count($s['record_range'])."','".base64_encode(serialize($s))."')";
                                        $this->DBC->run_query($sql,false,false);

                                        return $s['import_batch'];
                                    }
                                    else
                                    {
                                        return false;
                                    }
                                }
                            }
                            else
                                $this->Error[E_DESC] = "Error, unable to load data sheet in database.";
                        }
                        else
                            $this->Error[E_DESC] = "Error, temp table schema not found.";
                    }
                    else
                        $this->Error[E_DESC] = "Error, unable to upload your CSV file please try again";
                }
                else
                    $this->Error[E_DESC] = "CSV file not found. Please upload attach CSV with all data.";
            }
            else
                $this->Error[E_DESC] = "Selected category is not active.";
        }
        else
            $this->Error[E_DESC] = "No category found to import data. Please select category.";

        return false;
    }
    public function ImportImages($POST)
    {
        global $physical_path,$config;

        if(isset($_FILES['import_zip']) && !empty($_FILES['import_zip']) && $POST['import_batch_number'] != '')
        {
            try
            {
                /*$newFolder = str_replace(':','-',$POST['import_batch_number']);
                $newFolder = str_replace(' ','-',$newFolder);

                # Checking for folder is created or not
                if(!is_dir($this->Data[P_UP].'/'.$newFolder))
                    mkdir($this->Data[P_UP].'/'.$newFolder);

                # Set folder path
                $importPath = $this->Data[P_UP].'/'.$newFolder;
                */
                # Upload zip file in product folder
                $fileName = $this->uploadFile($_FILES['import_zip'], '', false, false);

                # Set zip file path
                $file = $this->Data[P_UP]."/".$fileName;

                $zip = new ZipArchive;
                $res = $zip->open($file);

                if($res === true)
                {
                    # Extract it to the path we determined above
                    $zip->extractTo($this->Data[P_UP]);

                    # Get extract directory
                    $dir = trim($zip->getNameIndex(0), '/');
                    $zip->close();

                    # Now delete existing zip file [Note:Remove zip file for empty temp source folder]
                    if(file_exists($file))
                        unlink($file);

                    # Get extract folder directory
                    $extFolder = $this->Data[P_UP].'/'.$dir;

                    if(is_dir($extFolder))
                    {
                        $folderName = str_replace(':','-',$POST['import_batch_number']);
                        $folderName = str_replace(' ','_',$folderName);

                        # Set new folder name
                        $importPath = $this->Data[P_UP].'/'.$folderName;
                        $importPathResize = $this->Data[P_UP].'/Resize_'.$folderName;

                        # If already exist new folder so delete it folder.
                        if(is_dir($importPath))
                            Utility::obj()->deleteDirectory($importPath);

                        # Rename folder name
                        if(rename($extFolder,$importPath) === true)
                        {
                            # Get uploaded image file array
                            $image_list = Utility::obj()->readDirectory($importPath);

                            if(is_array($image_list) && count($image_list) > 0)
                            {
                                # Get product by import batch number
                                $rsProduct = $this->GetProductByImportBatchNumber($POST['import_batch_number']);

                                if($rsProduct->TotalRow > 0)
                                {
                                    $e='';$PAddImageList=array();$arrProductAddIMG=array();
    	                            while($rsProduct->next_record())
                                    {
                                        # Checking product additional images is found
                                        if($rsProduct->f($this->Data[F_P_KEY]) != '' && $rsProduct->f(ProductAdditionalImages::obj()->Data[F_F_KEY]) != '' && $rsProduct->f('paddimg_image_file') != '')
                                        {
                                            # Set only additional image list
                                            $PAddImageList[$rsProduct->f(ProductAdditionalImages::obj()->Data[F_P_KEY])] =   $rsProduct->f('paddimg_image_file');

                                            # Set array of product
                                            $arrProductAddIMG[$rsProduct->f(ProductAdditionalImages::obj()->Data[F_P_KEY])] =   $rsProduct->Record;
                                        }

                                        # Check product id not empty and image product id not empty
                                        if($rsProduct->f($this->Data[F_P_KEY]) != '' && $rsProduct->f(ProductImages::obj()->Data[F_F_KEY]) != '' && $rsProduct->f('proimg_image_file') != '')
                                        {
                                            # Set only image list
                                            $PImageList[$rsProduct->f(ProductImages::obj()->Data[F_P_KEY])] =   $rsProduct->f('proimg_image_file');

                                            # Set array of product
                                            $arrProduct[$rsProduct->f(ProductImages::obj()->Data[F_P_KEY])] =   $rsProduct->Record;
                                        }
                                        else
        		                          $e .= $rsProduct->f('product_sku').'  '.$rsProduct->f($this->Data[F_P_FIELD]).' : Image not found in database. ';
                                    }

                                    if($e!='')
        	                           throw new Exception('Successfully completed remove unwanted file but error with some images. '.$e);
                                }
                                else
                                    throw new Exception('No data found in database.');


                                if(is_array($arrProduct) && count($arrProduct ) > 0)
                                {
                                    ################################################################################
                                    # Now we will check all uploaded image and inserted image is same
                                    # Other file found then remove it
                                    if(is_array($PImageList) && count($PImageList) > 0)
                                    {
                                        $error = '';$deletedFile='';
                                        foreach($image_list as $k => $image_name)
                                        {
                                            if(!in_array($image_name, $PImageList) && !in_array($image_name, $PAddImageList))
                                            {
                                                $unwanted_file_path = $importPath.'/'.$image_name;

                                                # Remove unwanted file
                                                if(unlink($unwanted_file_path) === true)
                                                    $deletedFile .= $image_name.' | ';
                                                else
                                                    $error .= $image_name.' | ';
                                            }
                                        }

                                        if($error != '')
                                        {
                                            Utility::obj()->deleteDirectory($importPath);
                                            $e = 'Unwanted file found.Please remove this file and try again. Unwanted file list => ';
                                            throw new Exception($e.$error);
                                        }
                                    }
                                    else
                                        throw new Exception('Image not found in database.');

                                    # Get cleanup image file array
                                    $new_image_list = Utility::obj()->readDirectory($importPath);

                                    # Total product count
                                    $TotalProductCount = $arrProductAddIMG+$arrProduct;

                                    if(count($TotalProductCount) == count($new_image_list))
                                    {
                                        ################################################################################
                                        # Now we will check all uploaded images and confirm validation
                                        $error='';
                                        foreach($new_image_list as $k => $image_name)
                                        {
                                            # Check only product images not check for product additional images
                                            if(in_array($image_name,$PImageList))
                                            {
                                                $temp_image_path = $importPath.'/'.$image_name;

                                                list($w,$h) = getimagesize($temp_image_path);

                                                if($w != $h || $w < $this->Data['IMG_SIZE']['MIN'] || $w > $this->Data['IMG_SIZE']['MAX'])
                                                    $error .= $image_name.' - Width '.$w.'px Height '.$h.'px | ';

                                                //if(($w != $this->Data['IMG_SIZE']['w1200'] || $w != $this->Data['IMG_SIZE']['w800']) && $w != $h)

                                                /*$wh = $w.'x'.$h;
                                                if(!in_array($wh,ProductMaster::obj()->Data['IMG_SIZE']))
                                                    $error .= $image_name.' - Width '.$w.'px Height '.$h.'px | ';*/
                                            }
                                        }

                                        if($error != '')
                                        {
                                            Utility::obj()->deleteDirectory($importPath);
                                            $e = 'Invalid width height dimension found. Valid width X height greater than '.$this->Data['IMG_SIZE']['MIN'].' px and less than '.$this->Data['IMG_SIZE']['MAX'].' px. Invalid image list => ';
                                            throw new Exception($e.$error);
                                        }

                                        ################################################################################
                                        # Now we will check all upload image start resizing it.
                                        /*if($config['resize_import_image'] == YES)
                                        {
                                            require_once($physical_path['Libs'].'/thumbnail.php');
                                            $thumb = new Thumbnail();

                                            # Start resizing so need folder so create new directory
                                            if(mkdir($importPathResize) != true)
                                            {
                                                Utility::obj()->deleteDirectory($importPath);
                                                throw new Exception('Unable to start resizing process. Directory creation denied.');
                                            }

                                            ################################################################################
                                            # Now we will check all upload image dimension is appropriate or not.
                                            $error = '';
                                            foreach($new_image_list as $k => $image_name)
                                            {
                                                $temp_image_path        = $importPath.'/'.$image_name;
                                                //$temp_image_path_resize = $importPathResize.'/'.$image_name;

                                                # Get actual image dimension
                                                list($w,$h) = getimagesize($temp_image_path);

                                                #######################################################
                                                # Get image dimension which is more appropriate
                                                foreach($this->Data['IMG_SIZE'] as $k => $v)
                                                {
                                                    $imgSize[$k] = explode('x',$v);
                                                }

                                                foreach($imgSize as $key => $sInfo)
                                                {
                                                    if(($sInfo[0]-$w) >= 0 && ($sInfo[1]-$h) >= 0)
                                                    {
                                                        $arrW[$key] = $sInfo[0]-$w;
                                                        $arrH[$key] = $sInfo[1]-$h;
                                                    }
                                                    else
                                                        $error .= $image_name.' - Width '.$w.'px Height '.$h.'px | ';
                                                }
                                            }

                                            if($error != '')
                                            {
                                                Utility::obj()->deleteDirectory($importPath);
                                                $e = 'Invalid width height dimension found. Valid width X height '.implode(' or ',$this->Data['IMG_SIZE']).' px. Invalid image list => ';
                                                throw new Exception($e.$error);
                                            }

                                            $error = '';
                                            foreach($new_image_list as $k => $image_name)
                                            {
                                                $temp_image_path        = $importPath.'/'.$image_name;
                                                $temp_image_path_resize = $importPathResize.'/'.$image_name;

                                                # Get actual image size
                                                list($w,$h) = getimagesize($temp_image_path);

                                                # Make thumb
                                                $thumb->image($temp_image_path);

                                                # Change image quality
                                                $thumb->jpeg_quality(70);

                                                # Get appropriate image size
                                                if(isset($arrW) && is_array($arrW) && count($arrW) > 0 && isset($arrH) && is_array($arrH) && count($arrH) > 0)
                                                {
                                                    # Width checking
                                                    $minW = min($arrW);
                                                    $arrMinW = array_keys($arrW,$minW);
                                                    $flp = array_flip($arrMinW);

                                                    # Height checking
                                                    $arrHeight = array_intersect_key($arrH,$flp);
                                                    $minH = min($arrHeight);
                                                    $accsKey = array_keys($arrHeight,$minH);

                                                    $resizeWidth = $imgSize[$accsKey[0]][0];
                                                    $resizeHeight = $imgSize[$accsKey[0]][0];
                                                }

                                                $thumb->size_smart_v2($resizeWidth, $resizeHeight);


                                                $thumb->create(false, $temp_image_path_resize);

                                                if(!file_exists($temp_image_path_resize))
                                                    $error .= $image_name.' - Unable to resize image. | ';
                                            }

                                            unset($thumb);
                                            if($error != '')
                                            {
                                                Utility::obj()->deleteDirectory($importPath);
                                                Utility::obj()->deleteDirectory($importPathResize);
                                                $e = 'Corrupted image found. Invalid image list => ';
                                                throw new Exception($e.$error);
                                            }

                                            # Now we don't need main folder as we will use all images from resize folder
                                            Utility::obj()->deleteDirectory($importPath);
                                        }
                                        else
                                        {
                                            $importPathResize = $importPath;
                                        }*/
                                        # If above code uncomment then remove this path
                                        $importPathResize = $importPath;

                                        ################################################################################
                                        # Now images are validated so start transfering images
                                        $e='';

                                        foreach($arrProduct as $imgId => $pInfo)
                                        {
                                            $group_sql = '';
                                            if($pInfo[$this->Data[F_P_KEY]] != '' && $pInfo[ProductImages::obj()->Data[F_F_KEY]] != '' && $pInfo['proimg_image_file'] != '')
                                            {
                                                # Added datettime expload with space
                                                if($pInfo[$this->Data[F_ADDED_DATETIME]])
                                                    $expSpace = explode(' ', $pInfo[$this->Data[F_ADDED_DATETIME]]);

                                                # Now expload with -
                                                if($expSpace[0] != '')
                                                    $expDesc = explode('-', $expSpace[0]);

                                                # Checking for year
                                                if(!is_dir($this->Data[P_UP].'/'.$expDesc[0]))
                                                    mkdir($this->Data[P_UP]."/".$expDesc[0]);

                                                # Checking for month
                                                if(!is_dir($this->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1]))
                                                    mkdir($this->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1]);

                                                # Checking for day
                                                if(!is_dir($this->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1].'/'.$expDesc[2]))
                                                    mkdir($this->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1].'/'.$expDesc[2]);

                                                # Set product image path
                                                $original_file = $importPathResize.'/'.$pInfo['proimg_image_file'];

                                                if(file_exists($original_file))
                                                {
                                                    # Get unique prefix
                                                    $Unique = ProductMaster::obj()->getUniqueFilePrefix();

                                                    # Combine unique prefix with original file
                                                    $new_file  = $Unique.$pInfo['proimg_image_file'];

                                                    # Set destination path
                                                    $FileDest = $this->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1].'/'.$expDesc[2].'/'.$new_file;

                                                    # Copy file into destination path
                                                    if(rename($original_file,$FileDest) === true)
                                                    {
                                                        # Set update query for product image file
                                                        $sql = " UPDATE ".ProductImages::obj()->Data[TABLE_NAME]." SET proimg_image_file = '".$new_file."', proimg_is_uploaded = '".YES."'
                                                                 WHERE ".ProductImages::obj()->Data[F_P_KEY]." = ".$pInfo[ProductImages::obj()->Data[F_P_KEY]]." AND ".ProductImages::obj()->Data[F_F_KEY]." = ".$pInfo[ProductImages::obj()->Data[F_F_KEY]];

                                                        # Update product image file name
                                                        $affected_rows = $this->DBC->run_query($sql,false,PDO_U);

                                                        if($affected_rows == 1)
                                                        {
                                                            $ok[] = $new_file;

                                                            # Update style group image info
                                                            ProductStyleGroup::obj()->UpdateStyleGroupImageInfoById($pInfo[$this->Data[F_F_KEY]]);
                                                        }
                                                        else
                                                        {
                                                            $e .= $pInfo['proimg_image_file'].' unable update database status. ';
                                                            unlink($FileDest);
                                                        }
                                                    }
                                                    else
                                                        $e .= $pInfo['proimg_image_file'].' unable to move file. ';
                                                }
                                                else
                                                    $e .= $pInfo['proimg_image_file'].' not found. ';
                                            }
                                            else
                                                $e .= $pInfo['product_sku'].'  '.$pInfo[$this->Data[F_P_FIELD]].' : Image not found in database. ';
                                        }

                                        # Check for product additional images
                                        if(is_array($arrProductAddIMG) && count($arrProductAddIMG) > 0)
                                        {
                                            foreach($arrProductAddIMG as $imgId => $pAddInfo)
                                            {
                                                $group_sql = '';
                                                if($pAddInfo[$this->Data[F_P_KEY]] != '' && $pAddInfo[ProductAdditionalImages::obj()->Data[F_F_KEY]] != '' && $pAddInfo['paddimg_image_file'] != '')
                                                {
                                                    # Added datettime expload with space
                                                    if($pAddInfo[$this->Data[F_ADDED_DATETIME]])
                                                        $expSpace = explode(' ', $pAddInfo[$this->Data[F_ADDED_DATETIME]]);

                                                    # Now expload with -
                                                    if($expSpace[0] != '')
                                                        $expDesc = explode('-', $expSpace[0]);

                                                    # Checking for year
                                                    if(!is_dir(ProductAdditionalImages::obj()->Data[P_UP].'/'.$expDesc[0]))
                                                        mkdir(ProductAdditionalImages::obj()->Data[P_UP]."/".$expDesc[0]);

                                                    # Checking for month
                                                    if(!is_dir(ProductAdditionalImages::obj()->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1]))
                                                        mkdir(ProductAdditionalImages::obj()->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1]);

                                                    # Checking for day
                                                    if(!is_dir(ProductAdditionalImages::obj()->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1].'/'.$expDesc[2]))
                                                        mkdir(ProductAdditionalImages::obj()->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1].'/'.$expDesc[2]);

                                                    # Set product additional image path
                                                    $original_file = $importPathResize.'/'.$pAddInfo['paddimg_image_file'];

                                                    if(file_exists($original_file))
                                                    {
                                                        # Get unique prefix
                                                        $Unique = ProductAdditionalImages::obj()->getUniqueFilePrefix();

                                                        # Combine unique prefix with original file
                                                        $new_file  = $Unique.$pAddInfo['paddimg_image_file'];

                                                        # Set destination path
                                                        $FileDest = ProductAdditionalImages::obj()->Data[P_UP].'/'.$expDesc[0].'/'.$expDesc[1].'/'.$expDesc[2].'/'.$new_file;

                                                        # Copy file into destination path
                                                        if(rename($original_file,$FileDest) === true)
                                                        {
                                                            # Set update query for product additional image file
                                                            $sql = " UPDATE ".ProductAdditionalImages::obj()->Data[TABLE_NAME]." SET paddimg_image_file = '".$new_file."'
                                                                     WHERE ".ProductAdditionalImages::obj()->Data[F_P_KEY]." = ".$pAddInfo[ProductAdditionalImages::obj()->Data[F_P_KEY]]." AND ".ProductAdditionalImages::obj()->Data[F_F_KEY]." = ".$pAddInfo[ProductAdditionalImages::obj()->Data[F_F_KEY]];

                                                            # Update product additional image file name
                                                            $affected_rows = $this->DBC->run_query($sql,false,PDO_U);

                                                            if($affected_rows == 1)
                                                            {
                                                                $ok[] = $new_file;
                                                            }
                                                            else
                                                            {
                                                                $e .= $pAddInfo['paddimg_image_file'].' unable update database status. ';
                                                                unlink($FileDest);
                                                            }
                                                        }
                                                        else
                                                            $e .= $pAddInfo['paddimg_image_file'].' unable to move file. ';
                                                    }
                                                }
                                            }
                                        }

                                        # Delete temp folder with imported images
                                        Utility::obj()->deleteDirectory($importPathResize);

        	                            if($e!='')
        	                                throw new Exception('Successfully completed upload process but error with some images. '.$e);
                                    }
                                    else
                                    {
                                        # Delete temp folder with imported images
                                        Utility::obj()->deleteDirectory($importPath);

                                        $eMsg = 'Total images count mismatch. Data sheet images count is '.count($TotalProductCount).' and upload images count is '.count($new_image_list).'.';

                                        if($deletedFile != '')
                                            $eMsg .= 'Data sheet images and uploaded images is different then deleted this file. Delete file list => '.$deletedFile.'.';

                                        throw new Exception($eMsg);
                                    }
                                }
                                else
                                {
                                    # Delete export folder
                                    Utility::obj()->deleteDirectory($importPath);
                                    throw new Exception('Image not found in database.');
                                }

                            }
                            else
                            {
                                # Delete rename folder
                                Utility::obj()->deleteDirectory($importPath);
                                throw new Exception('Unable to read directory.');
                            }
                        }
                        else
                            throw new Exception('Unable to rename folder.');
                    }
                    else
                        throw new Exception('Unable to extract images from zip file.');
                }
                else
                    throw new Exception('Unable to open zip file. Possible reason corrupted file.');
            }
            catch(Exception $e)
            {
                # Error Log Action
                if($this->DBErrorLog === true)
                    ErrorLog::obj()->AddErrorLog(A_ADD, $e->getMessage());


                $this->Error[E_DESC] = $e->getMessage();
            }

	        # If any images processed successfully
	        if(isset($ok) && is_array($ok))
	            return array('total'=>count($TotalProductCount), 'processed'=>$ok);
        }
	    return false;
    }
}
?>