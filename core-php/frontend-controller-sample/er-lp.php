<?php
# File : er-lp.php
define('IN_SITE',	true);

if(isset($_GET['popup']) && $_GET['popup'] == 'true')
	define('POPUP_WIN',	true);

# Include the required file
require_once("includes/common.php");

# Get main params from URL
$params =   isset($_GET['param'])?$_GET['param']:'';

# Set all arguments based on URL params
$URL_ARGS   =   Utility::GetURLParam($params);

# Get web page for product listing and product full view
$CUR_WP     =   WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_ER_LP);

$PAGE_IS_ACTIVE = true;
if(!is_array($CUR_WP) || $CUR_WP[WebPageManager::obj()->Data[F_ACTIVE]] != YES)
	$PAGE_IS_ACTIVE = false;

# Meta info for web page
if($PAGE_IS_ACTIVE === true)
{
	$ndf = "Sorry, no product found related with your search. Have a look at other related products or reset your search criteria.";
	$LoadListing = true; $active = true;
	$Breadcrumbs[] = '<li><a href="'.$virtual_path['Host_Url'].'"><i class="fa fa-home"></i></a></li>';
	$Breadcrumbs[] = '<li>All</li>';

    # Request manipulation for full view
	if(isset($URL_ARGS[SURL_FULL_VIEW_PAGE]) && !empty($URL_ARGS[SURL_FULL_VIEW_PAGE]))
	{
	   /**need to change logic as 2 fields have been delete and created 2 new tables**/
        $arrLFVInfo = ProductMaster::obj()->getFullViewProductDetail($URL_ARGS);

        # Check for valid product as set some info based on that
		if(is_array($arrLFVInfo) && count($arrLFVInfo) > 0)
		{
            ################################################################################
			# PRODUCT SELF : Check for product active flag
			if(!isset($arrLFVInfo[ProductMaster::obj()->Data[F_ACTIVE]]) || (isset($arrLFVInfo[ProductMaster::obj()->Data[F_ACTIVE]]) && $arrLFVInfo[ProductMaster::obj()->Data[F_ACTIVE]] != YES))
				$active = false;

			################################################################################
			# CATEGORY : Check for all assigned category active flag
			$all_cat_id_field       =   ProductMaster::obj()->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_KEY];
			$all_cat_active_field   =   ProductMaster::obj()->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_ACTIVE];
			$all_cat_safe_url_field =   ProductMaster::obj()->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_S_URL];
			$all_cat_name_field     =   ProductMaster::obj()->Data[FIELD_PREFIX].CategoryMaster::obj()->Data[F_P_FIELD];

			if(isset($arrLFVInfo[$all_cat_id_field]) && isset($arrLFVInfo[$all_cat_active_field]))
			{
				$all_cat_id         =   explode(',',$arrLFVInfo[$all_cat_id_field]);
				$all_cat_safe_url   =   explode(',',$arrLFVInfo[$all_cat_safe_url_field]);
				$all_cat_name       =   explode(',',$arrLFVInfo[$all_cat_name_field]);
				$all_cat_visible    =   explode(',',$arrLFVInfo[$all_cat_active_field]);
				$list               =   array_combine($all_cat_safe_url, $all_cat_visible);

				# Check for all assigned categories whether it is active or not
				foreach($list as $safe_url => $cat_visible)
				{
					if($cat_visible == YES)
						$available_category[] = $safe_url;
					else
						$active = false;
				}
			}
			else
				$active = false;


			# Check for any active category as we need it to load product listing as requested product is not active some how
			if(isset($available_category) && is_array($available_category) && count($available_category) > 0)
				$available_category_id = end($available_category);

			if(isset($all_cat_name) && is_array($all_cat_name) && count($all_cat_name) > 0)
				$available_category_name = end($all_cat_name);

			################################################################################
			# BRAND : Check for assigned brand active flag
			$all_brand_id_field         =   ProductMaster::obj()->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_P_KEY];
			$all_brand_active_field     =   ProductMaster::obj()->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_ACTIVE];
			$all_brand_safe_url_field   =   ProductMaster::obj()->Data[FIELD_PREFIX].BrandMaster::obj()->Data[F_S_URL];

			# At this moment we do not check for active flag for brand
			/*if(!isset($arrLFVInfo[$all_brand_active_field]) || (isset($arrLFVInfo[$all_brand_active_field]) && $arrLFVInfo[$all_brand_active_field] != YES))
				$active = false;
			else
				$available_brand_id = $arrLFVInfo[$all_brand_safe_url_field];*/
			$available_brand_id = $arrLFVInfo[$all_brand_safe_url_field];

            # Get available product feature from URL.
            if(isset($URL_ARGS[QP_FEATURE]) && is_array($URL_ARGS[QP_FEATURE]) && count($URL_ARGS[QP_FEATURE]) > 0)
                $availableFeature = ProductMaster::obj()->getProductAvailableFeature($URL_ARGS);

			################################################################################
			# PRODUCT TYPE : Check for assigned product type active flag
			/*$all_protype_id_field         =   ProductMaster::obj()->Data[FIELD_PREFIX].ProductTypeMaster::obj()->Data[F_P_KEY];
			$all_protype_active_field     =   ProductMaster::obj()->Data[FIELD_PREFIX].ProductTypeMaster::obj()->Data[F_ACTIVE];
			$all_protype_safe_url_field   =   ProductMaster::obj()->Data[FIELD_PREFIX].ProductTypeMaster::obj()->Data[F_S_URL];

			if(!isset($arrLFVInfo[$all_protype_active_field]) || (isset($arrLFVInfo[$all_protype_active_field]) && $arrLFVInfo[$all_protype_active_field] != YES))
				$active = false;
			else
				$available_protype_id = $arrLFVInfo[$all_protype_safe_url_field];*/
		}
		else
			$active = false;

    	# Check for active status and manipulate based on that
		if($active === true)
		{
			$LoadListing = false;

			$CUR_WP['webpage_title']               =   $arrLFVInfo['product_name'];
			$CUR_WP['webpage_browser_title']       =   $arrLFVInfo['product_browser_title'];
			$CUR_WP['webpage_meta_keyword']        =   $arrLFVInfo['product_meta_keyword'];
			$CUR_WP['webpage_meta_desc']           =   $arrLFVInfo['product_meta_desc'];
			$CUR_WP['webpage_meta_external_tag']   =   $arrLFVInfo['product_meta_external_tag'];

			# Set current product in breadcrumbs
			if(isset($available_category) && is_array($available_category) && isset($all_cat_name) && is_array($all_cat_name))
			{
                $CatNameList = array_combine($all_cat_name,$available_category);

				if(is_array($CatNameList) && count($CatNameList) > 0)
				{
					$i=1;
					foreach($CatNameList as $cat_name => $cat_safe_url)
					{
						if($i == 3)
							$temp = '<a rel="noindex" href="'.$virtual_path['Host_Url'].'/'.SU_ER_LISTING_PAGE.'/'.QP_CATEGORY.'/'.$cat_safe_url.'/">'.$cat_name.'</a>';
						else
							$temp = $cat_name;
						$Breadcrumbs[] = '<li>'.$temp.'</li>';
						$i++;
					}
				}
			}

			$Breadcrumbs[] = '<li class="active" title="'.$arrLFVInfo['product_name'].'">'.$arrLFVInfo['product_name'].'</li>';
		}
		else
		{
			$ARGS = ''; $active = true;
			$msgError = "Sorry, requested product is not available at this moment. Please check for other related products.";

			# Product is not available so check for any available category
			if(isset($available_category_id) && is_string($available_category_id))
			{
				$URL_ARGS[QP_CATEGORY] = $available_category_id;

				# Product is not available even category is also not available so check for any available brand
				if(isset($available_brand_id) && is_string($available_brand_id))
					$URL_ARGS[QP_BRAND] = $available_brand_id;

				# Set related price

				# Set related required feature only min 1 or max 2

			}

			if(!isset($URL_ARGS[QP_CATEGORY]) && !isset($URL_ARGS[QP_BRAND]))
				$active = false;
		}
	}
	if($LoadListing === true)
	{
		# Check for any system define params in URL. If found then set SEO based on it
		if(isset($URL_ARGS[SURL_PREDEFINED_SEARCH]))
		{
			$arrPredefinedSearchInfo = PredefinedSearch::obj()->_getInfoBySefUrl_WebSite($URL_ARGS[SURL_PREDEFINED_SEARCH]);

            # Requested predefined search is not active or available some how
			if(is_array($arrPredefinedSearchInfo) && count($arrPredefinedSearchInfo) > 0)
			{
				$CUR_WP['webpage_title']               =   $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'page_heading'];
				$CUR_WP['webpage_browser_title']       =   $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'browser_title'];
				$CUR_WP['webpage_meta_keyword']        =   $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'meta_keyword'];
				$CUR_WP['webpage_meta_desc']           =   $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'meta_desc'];
				$CUR_WP['webpage_meta_external_tag']   =   $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'meta_external_tag'];
				$CUR_WP['webpage_bottom_bar_content']  =   $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'short_desc'];

                # Unserialize and decode predefined search criteria
                $arrCriteria   =   @unserialize(base64_decode($arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'criteria']));

                if(is_array($arrCriteria) && count($arrCriteria) > 0)
                {
                    $AllList = CategoryMaster::obj()->getAvailableCategoryBySafeUrl($arrCriteria[QP_CATEGORY][0]);

        			# Requested category is not active or available some how
        			if(is_array($AllList) && count($AllList) > 0)
        			{
        				$i = 0;
        				foreach($AllList as $cat_safe_url => $cat_info)
        				{
        					$i++;
        					if($i != count($AllList))
        						$Breadcrumbs[] = '<li>'.$cat_info[CategoryMaster::obj()->Data[F_P_FIELD]].'</li>';//<a rel="noindex" href="'.$virtual_path['Host_Url'].'/'.SU_ER_LISTING_PAGE.'/'.QP_CATEGORY.'/'.$cat_safe_url.'/"></a>
        				}
        				$Breadcrumbs[] = '<li><a href="'.$virtual_path['Host_Url'].'/'.SU_ER_LISTING_PAGE.'/'.QP_CATEGORY.'/'.$arrCriteria[QP_CATEGORY][0].'/">'.$AllList[$arrCriteria[QP_CATEGORY][0]][CategoryMaster::obj()->Data[F_P_FIELD]].'</a></li>';
                    }

                    # Set current predefined search in breadcrumbs
				    $Breadcrumbs[] = '<li class="active">'.$arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'page_heading'].'</li>';
                }
                else
    			{
    				$active = false;
    				$msgError = "Sorry, requested data is not available at this moment. Please check with other search criteria.";
    			}
			}
			else
			{
				$active = false;
				$msgError = "Sorry, requested search is not available at this moment. Please search with some other value.";
			}
		}
		elseif(isset($URL_ARGS[QP_CATEGORY]) && is_string($URL_ARGS[QP_CATEGORY]))
		{
			//$arrProCategoryInfo  =   CategoryMaster::obj()->_getInfoBySefUrl_WebSite($URL_ARGS[QP_CATEGORY]);
			$AllList = CategoryMaster::obj()->getAvailableCategoryBySafeUrl($URL_ARGS[QP_CATEGORY]);

			# Requested category is not active or available some how
			if(is_array($AllList) && count($AllList) > 0)
			{
				/*
				$CUR_WP['webpage_title']               =   $arrProCategoryInfo['cm_name'];
				$CUR_WP['webpage_browser_title']       =   !empty($arrProCategoryInfo['cm_browser_title'])?$arrProCategoryInfo['cm_browser_title']:$arrProCategoryInfo['cm_name'];
				$CUR_WP['webpage_meta_keyword']        =   $arrProCategoryInfo['cm_meta_keyword'];
				$CUR_WP['webpage_meta_desc']           =   $arrProCategoryInfo['cm_meta_desc'];
				$CUR_WP['webpage_bottom_bar_content']  =   $arrProCategoryInfo['cm_full_desc'];
				*/

				$i = 0;
				foreach($AllList as $cat_safe_url => $cat_info)
				{
					$i++;
					if($i != count($AllList))
						$Breadcrumbs[] = '<li>'.$cat_info[CategoryMaster::obj()->Data[F_P_FIELD]].'</li>';//<a rel="noindex" href="'.$virtual_path['Host_Url'].'/'.SU_ER_LISTING_PAGE.'/'.QP_CATEGORY.'/'.$cat_safe_url.'/"></a>
				}
				$Breadcrumbs[] = '<li class="active">'.$AllList[$URL_ARGS[QP_CATEGORY]][CategoryMaster::obj()->Data[F_P_FIELD]].'</li>';
			}
			else
			{
                # Category is not active so unset category from filter
                unset($URL_ARGS[QP_CATEGORY]);

                $active = false;
				$msgError = "Sorry, requested data is not available at this moment. Please check with other search criteria.";
			}
		}
		elseif(isset($URL_ARGS[QP_BRAND]) && is_string($URL_ARGS[QP_BRAND]))
		{
			$arrBrandInfo = BrandMaster::obj()->_getInfoBySefUrl_WebSite($URL_ARGS[QP_BRAND]);

			# Requested brand is not active or available some how
			if(is_array($arrBrandInfo) && count($arrBrandInfo) > 0)
			{
				/*
				$CUR_WP['webpage_title']               =   $arrBrandInfo['brand_name'];
				$CUR_WP['webpage_browser_title']       =   $arrBrandInfo['brand_browser_title'];
				$CUR_WP['webpage_meta_keyword']        =   $arrBrandInfo['brand_meta_keyword'];
				$CUR_WP['webpage_meta_desc']           =   $arrBrandInfo['brand_meta_desc'];
				$CUR_WP['webpage_meta_external_tag']   =   $arrBrandInfo['brand_meta_external_tag'];
				$CUR_WP['webpage_bottom_bar_content']  =   $arrBrandInfo['brand_full_desc'];
				*/

                # Set current brand in breadcrumbs
				$Breadcrumbs[] = '<li class="active">'.$arrBrandInfo[BrandMaster::obj()->Data[F_P_FIELD]].'</li>';
			}
			else
			{
				# Brand is not active so unset brand from filter
                unset($URL_ARGS[QP_BRAND]);

                $active = false;
				$msgError = "Sorry, requested brand is not available at this moment. Please check for other brands.";
			}
		}
		/*elseif(isset($URL_ARGS[QP_FEATURE]) && is_array($URL_ARGS[QP_FEATURE]) && count($URL_ARGS[QP_FEATURE]) == 1)
		{
			$f_key = key($URL_ARGS[QP_FEATURE]);
			$f_val = $URL_ARGS[QP_FEATURE][$f_key];
			if(is_string($f_val))
			{
				$arrFeatureInfo =   FeatureMaster::obj()->getFearureInfoByFeatureSafeURLAndValue($f_key,$f_val);

				# Requested tag is not active or available some how
				if(is_array($arrFeatureInfo) && count($arrFeatureInfo) > 0)
				{
					$CUR_WP['webpage_title']               =   $arrFeatureInfo['ftrvalue_value'];
					$CUR_WP['webpage_browser_title']       =   !empty($arrFeatureInfo[FeatureMaster::obj()->Data[FIELD_PREFIX].'browser_title'])?$arrFeatureInfo[FeatureMaster::obj()->Data[FIELD_PREFIX].'browser_title']:$arrFeatureInfo['ftrvalue_value']." ".$arrFeatureInfo[FeatureMaster::obj()->Data[F_P_FIELD]];
					$CUR_WP['webpage_meta_keyword']        =   $arrFeatureInfo[FeatureMaster::obj()->Data[FIELD_PREFIX].'meta_keyword'];
					$CUR_WP['webpage_meta_desc']           =   $arrFeatureInfo[FeatureMaster::obj()->Data[FIELD_PREFIX].'meta_desc'];
					$CUR_WP['webpage_meta_external_tag']   =   $arrFeatureInfo[FeatureMaster::obj()->Data[FIELD_PREFIX].'meta_external_tag'];

					$Breadcrumbs[] = '<li>'.$arrFeatureInfo[FeatureMaster::obj()->Data[F_P_FIELD]].'</li>';
					$Breadcrumbs[] = '<li class="active">'.$arrFeatureInfo['ftrvalue_value'].'</li>';
				}
				else
				{
					$active = false;
					$msgError = "Sorry, requested feature is not available at this moment. Please check for other features.";
				}
			}
		}*/

		# Request manipulation for listing based on search keyword by user
		if(isset($URL_ARGS[SURL_QUERY]))
		{
			$active = true;
			if(is_array($URL_ARGS[SURL_QUERY]))
				$ptitle = $URL_ARGS[SURL_QUERY][0];
			else
				$ptitle = $URL_ARGS[SURL_QUERY];

			$CUR_WP['webpage_title']       =   "Search For : ".$ptitle;

			$Breadcrumbs[] = '<li class="active">'.ucwords($ptitle).'</li>';
		}

		# Requested listing is not active some how so lode some thing else
		if($active === false || !is_array($URL_ARGS) || count($URL_ARGS) == 0)
		{
			$msgInfo = $ndf;

			# Get random predefined search
			$arrPredefinedSearchInfo = PredefinedSearch::obj()->getMostRecentPredefinedSearch();

            # At last there is no choice and we have got most recent predefined search
			if(is_array($arrPredefinedSearchInfo) && count($arrPredefinedSearchInfo) > 0)
			{
				$active = true;

				$URL_ARGS[SURL_PREDEFINED_SEARCH] = $arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[F_S_URL]];

                /*
				$CUR_WP['webpage_title']               =   $arrPredefinedSearchInfo[PredefineSearch::obj()->Data[FIELD_PREFIX].'page_heading'];
				$CUR_WP['webpage_browser_title']       =   $arrPredefinedSearchInfo[PredefineSearch::obj()->Data[FIELD_PREFIX].'browser_title'];
				$CUR_WP['webpage_meta_keyword']        =   $arrPredefinedSearchInfo[PredefineSearch::obj()->Data[FIELD_PREFIX].'meta_keyword'];
				$CUR_WP['webpage_meta_desc']           =   $arrPredefinedSearchInfo[PredefineSearch::obj()->Data[FIELD_PREFIX].'meta_desc'];
				$CUR_WP['webpage_meta_external_tag']   =   $arrPredefinedSearchInfo[PredefineSearch::obj()->Data[FIELD_PREFIX].'meta_external_tag'];
				$CUR_WP['webpage_bottom_bar_content']  =   $arrPredefinedSearchInfo[PredefineSearch::obj()->Data[FIELD_PREFIX].'short_desc'];
				*/
                # Unserialize and decode predefined search criteria
                $arrCriteria   =   @unserialize(base64_decode($arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'criteria']));

                if(is_array($arrCriteria) && count($arrCriteria) > 0)
                {
                    $AllList = CategoryMaster::obj()->getAvailableCategoryBySafeUrl($arrCriteria[QP_CATEGORY][0]);

                    # Requested category is not active or available some how
        			if(is_array($AllList) && count($AllList) > 0)
        			{
        				$i = 0;
        				foreach($AllList as $cat_safe_url => $cat_info)
        				{
        					$i++;
        					if($i != count($AllList))
        						$Breadcrumbs[] = '<li>'.$cat_info[CategoryMaster::obj()->Data[F_P_FIELD]].'</li>';//<a rel="noindex" href="'.$virtual_path['Host_Url'].'/'.SU_ER_LISTING_PAGE.'/'.QP_CATEGORY.'/'.$cat_safe_url.'/"></a>
        				}
        				$Breadcrumbs[] = '<li><a href="'.$virtual_path['Host_Url'].'/'.SU_ER_LISTING_PAGE.'/'.QP_CATEGORY.'/'.$arrCriteria[QP_CATEGORY][0].'/">'.$AllList[$arrCriteria[QP_CATEGORY][0]][CategoryMaster::obj()->Data[F_P_FIELD]].'</a></li>';
                    }

                    # Set current predefined search in breadcrumbs
				    $Breadcrumbs[] = '<li class="active">'.$arrPredefinedSearchInfo[PredefinedSearch::obj()->Data[FIELD_PREFIX].'page_heading'].'</li>';
                }
                else
    			{
    				$active = false;
    				$msgError = "Sorry, requested data is not available at this moment. Please check with other search criteria.";
    			}
			}
			else
				$msgError = "Sorry, requested search is not available at this moment. Please search with some other value.";
		}
	}
}

# Check for not found or not available any request
if($PAGE_IS_ACTIVE == false || $active == false || (!isset($config['OnLocal']) && strpos($_SERVER['HTTP_HOST'],'www.') === false))
{
	header("HTTP/1.0 410 Gone");
	$CUR_WP = WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_410);
	st::$obj->assign(array('IncPMM' => '410-gone'.$config[TPL_EX]));
}

# Response Creating Code. Assign page data
st::$obj->assign(array(
	"CUR_WP"                =>	$CUR_WP,

	"BodyBG"                =>  $asset['OL_WEBPAGE_BG_CLASS'][$CUR_WP['webpage_body_bg']],
	"ContainerBG"           =>  $asset['OL_WEBPAGE_BG_CLASS'][$CUR_WP['webpage_container_bg']],

	"AppendToSiteTitle"	    =>	$config['browser_title'],
	'Page_Module'           =>  $CUR_WP['webpage_module'],
	"SiteTitle"		        =>	$CUR_WP['webpage_browser_title'],
	"MetaDescription"   	=>	$CUR_WP['webpage_meta_desc'],
	"MetaKeywords"          =>	$CUR_WP['webpage_meta_keyword'],
	"PageExternalCSS"       =>  $CUR_WP['webpage_external_css'],
	"PageExternalJS"        =>  $CUR_WP['webpage_external_js'],
	"PageExternalMeta"      =>  $CUR_WP['webpage_meta_external_tag'],
	'PageCanonicalUrl'      =>  $_SERVER['REDIRECT_URL'],
	"Breadcrumbs"           =>  implode('&nbsp;',$Breadcrumbs),

	"arrOL_YesNo"           =>  $asset['OL_YesNo'],
    //'CrawlerNoIndex'        =>  true,

));

$css_files  =   array_merge($css_files, array('pswp'));
$js_files   =   array_merge($js_files, array('pswp','jval','jld','jsieve','jlmng','er-lp','er-lp-fv'));

if(cw::$screen == CW_S_LG || cw::$screen == CW_S_XL)
{
	$css_files  =   array_merge($css_files, array('axzm'));
	$js_files   =   array_merge($js_files, array('axzm'));
}

# If requested for product full view then show full product information
if($LoadListing === false && $active == true && isset($URL_ARGS[SURL_FULL_VIEW_PAGE]) && (isset($arrLFVInfo) && is_array($arrLFVInfo)))
{
    $arrLFVInfo['product_number'] = Ocrypt::nenc($arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]]);
    $adt = date('Y-m-d H:i:s');

    # Set visible category safe url and name
    if(isset($available_category_id) && is_string($available_category_id))
    {
        $arrLFVInfo['product_cm_safe_url']  =   $available_category_id;
        $arrLFVInfo['product_cm_name']      =   $available_category_name;
    }

    # Get all product image by product id
    $rsProductImage     =   ProductImages::obj()->GetAllImageOfProductByProductID($arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]]);
    $dt_folder          =   Utility::obj()->dt_folder($arrLFVInfo[ProductMaster::obj()->Data[F_ADDED_DATETIME]]);
    $Img_RW_URL         =   ProductImages::obj()->Data[IMG_RW_URL];

	# Create JSON for listing images to show with zooming effect
    while($rsProductImage->next_record())
    {
	    //'.$arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]].'/'.$rsProductImage->f(ProductImages::obj()->Data[F_P_KEY]).'
        $zoom = $virtual_path['MDN_Url'].ltrim(ProductMaster::obj()->Data['ENC_V_UP'],'.').'/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file');
		$thumb = $virtual_path['MDN_Url'].$Img_RW_URL.'/0/0/62x62/fx90/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file');
	    $title = $rsProductImage->f('proimg_title');
        $img = $virtual_path['MDN_Url'].ltrim(ProductMaster::obj()->Data[P_UP],'.').'/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file');

        $arrImg[] = array(
            'zoom'      => $zoom,
            //'preview'      => $virtual_path['MDN_Url'].ltrim(ProductMaster::obj()->Data[P_UP],'.').'/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file'),
            'preview'   => $virtual_path['MDN_Url'].$Img_RW_URL.'/0/0/600x600/fx90/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file'),
            'thumb'     => $thumb,
            'img'       => $img,
            'title'     => $title
        );

        # Get actual image size
        list($w,$h) = getimagesize($img);

	    $arrImg_PS[] = array(
		    'src'   =>  $zoom,
			//'msrc'	=>	$thumb,
			//'title'	=>	$title,
            /*'w'     =>  ProductMaster::obj()->Data['IMG_SIZE']['w'],
            'h'     =>  ProductMaster::obj()->Data['IMG_SIZE']['h'],*/
            'w'     =>  $w,
            'h'     =>  $h,
	    );
    }

    # Get product additional images
    $rsProductAddImage  =   ProductAdditionalImages::obj()->getAllAdditionalImageOfProductByPSGID($arrLFVInfo[ProductMaster::obj()->Data[F_F_KEY]]);

    # Get all product features by product id
	$arrPFList     =   ProductFeature::obj()->getProductFeatureList($arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]]);

    # Get all product tag by product id
    $arrPTagList    =   ProductTag::obj()->getProductTagInfoByProductId($arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]]);

    if(isset($availableFeature) && is_array($availableFeature) && count($availableFeature) > 0)
    {
        st::$obj->assign(array( 'availableFeature'  =>  $availableFeature));

    }

    # Get related products
	$rsRP = ProductMaster::obj()->getRelatedProducts($arrLFVInfo,$limit=20);

    if(isset($_COOKIE[COOKIE_TE_RV]) && !empty($_COOKIE[COOKIE_TE_RV]))
	{
		$rv_product = unserialize(base64_decode($_COOKIE[COOKIE_TE_RV]));

		# Keep only last 15 catalogs only
        if(count($rv_product[AREATE_ID_ECOM_RETAIL]) >= 15 && !array_key_exists($arrLFVInfo['product_number'], $rv_product[AREATE_ID_ECOM_RETAIL]))
		{
			reset($rv_product[AREATE_ID_ECOM_RETAIL]);

			$key = key($rv_product[AREATE_ID_ECOM_RETAIL]);
			unset($rv_product[$key]);
		}
        # 2016-03-30[ankit] exist key remove in cookie
        elseif(array_key_exists($arrLFVInfo['product_number'], $rv_product[AREATE_ID_ECOM_RETAIL]))
        {
            unset($rv_product[AREATE_ID_ECOM_RETAIL][$arrLFVInfo['product_number']]);
        }
	}

	# Set current visited product in cookie
	$rv_product[AREATE_ID_ECOM_RETAIL][$arrLFVInfo['product_number']] = $adt;

    # Add current item in cokkie array
    $rv_product = $_COOKIE[COOKIE_TE_RV] = base64_encode(serialize($rv_product));

    $d = explode(':',$_SERVER['NON_WWW_HTTP_HOST']);
	setcookie(COOKIE_TE_RV,$rv_product,time()+60*60*24*30,'/','.'.$d[0]);

    # Now update view count in product master
    //if(!isset($config['OnLocal']))
    ProductViewCount::obj()->AddViewCount($arrLFVInfo['product_id']);

    if(AuthUser::obj()->User_Perm == USER && isset(AuthUser::obj()->User_Logged) && AuthUser::obj()->User_Logged === STATUS_ONLINE && isset(UserMaster::obj()->ID) && is_numeric(UserMaster::obj()->ID))
	{
        # Insert product user visited product.If already inserted product then update this product
        UserRecentlyVisitedProduct::obj()->InsertUpdateVisitedProductByProductId(UserMaster::obj()->ID,$arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]], $adt);

		# User Log Insert
		UserLog::obj()->AddUserActionLog(ULOG_ACTION_VISITPRODUCT,$arrLFVInfo,UserMaster::obj()->ID,false,false,false);
	}

    # Get recently visited product information
    $rsURV = UserRecentlyVisitedProduct::obj()->getRecentliVisitedProductInfo($limit=15);

    # Get user wishlist product information
    $rsUW = UserWishlist::obj()->getUserWishlistProductInfo($limit=15);

    st::$obj->assign(array(
        'IncPMM'                =>  'tpl_er_lp/er-lp-full-view'.$config[TPL_EX],
        'BodyBG'                =>  'bg-off-white',

        'BarHWPS'               =>  true,
        'BarHWPH'               =>  true,
        'ContentHPB'            =>  true,
        'PR_HideAction'         =>  true,

        'arrLFVInfo'            =>  $arrLFVInfo,
        'arrPTagList'           =>  $arrPTagList,
        'LFV_ShowSP'            =>  true,
        'LFV_ShowRV'            =>  true,
        'LFV_ShowWL'            =>  true,
        'LVT_ShowSpecifications'=>  true,
        'LVT_ShowQuickLinks'    =>  true,
        'LVT_ShowQRCodeArea'    =>  true,
        'LVT_ShowSellerCodeArea'=>  true,
        'LFV_ShowSDesc'         =>  true,
        'LFV_ShowFDesc'         =>  true,
		'LVT_ShowNotice'		=>	true,
        'PR_HideQty'            =>  true,
        'arrUrlArgs'            =>  $URL_ARGS,

        'arrPFList'             =>  $arrPFList,
        'arrImg'                =>  $arrImg,
        'arrImg_PS'             =>  $arrImg_PS,

        'rsRP'                  =>  $rsRP,
        'ProductImg_IMG_RW_URL' =>  ProductImages::obj()->Data[IMG_RW_URL],
        'ProductAddImg_IMG_RW_URL'  =>  ProductAdditionalImages::obj()->Data[IMG_RW_URL],
        'Business_IMG_RW_URL'   =>  BusinessMaster::obj()->Data[IMG_RW_URL],
        'rsURV'                 =>  isset($rsURV)?$rsURV:'',
        'rsUW'                  =>  isset($rsUW)?$rsUW:'',
        'rsuw_total_record'     =>  (isset($rsUW) && $rsUW->TotalRow > 0)?$rsUW->TotalRow:'',
        'rsurv_total_record'    =>  isset($rsURV)?$rsURV->TotalRow:'',

        'rsAddImages'           =>  $rsProductAddImage,
        'arr_mobilecode'        =>  GeoCountry::obj()->getAllMobileCode(),

    ));
}
# Requested to show product listing as per URL params
elseif($LoadListing === true && $active == true)
{
    $CUR_WP['webpage_layout'] = '1';
	# Check for any search parameters from URL. As listing page is depend on direct input from URL
	/*if(isset($URL_ARGS) && is_array($URL_ARGS) && count($URL_ARGS) > 0)
	{

	}*/

    # if(isset($URL_ARGS[QP_CATEGORY]) && $URL_ARGS[QP_CATEGORY] != '')
    # Befor this code is in if condition now here move
    # Get param for search. This is a gateway to check and allow search params which are available for end user.

    $URL_FILTER = ProductMaster::obj()->setQueryParameters($URL_ARGS, isset($arrPredefinedSearchInfo)?$arrPredefinedSearchInfo:false);

    if($URL_FILTER != false && is_array($URL_FILTER))
		$_POST = array_merge($_POST, $URL_FILTER);

    # required to create cacheId
	Utility::enableCache($_POST);

    # Get product information based on set arrParams
	$rsLP = ProductMaster::obj()->_ViewAll_WebSite($_POST);

    //Utility::pre($rsLP->fetch_record());

    # Check for correct page number, If wrong then change page no and record limit
	if(isset($_POST['last_record_num']) && $_POST['last_record_num'] > ProductMaster::obj()->total_record)
	{
		$total_pages = ceil(ProductMaster::obj()->total_record/RESULT_PAGESIZE);

		if($total_pages <= $_POST[GO_TO_PAGE])
		{
			$_POST[GO_TO_PAGE]          =   0;
			$_POST[S_RECORD]            =   0;
			$_POST['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
		}
		else
		{
			$_POST['last_record_num']   =   ProductMaster::obj()->total_record;
		}
	}

	# If no result found for requested page then do required manipulation and get other related data and alert user about it
	if($rsLP->TotalRow < 1)
	{
		$msgInfo = $ndf;
	}

//Utility::pre($rsLP->fetch_record());
	# Unset map view as we don't have
	unset($asset['OL_VIEW_BY'][LVT_MAP]);
	st::$obj->assign(array(
        "CUR_WP"                =>	$CUR_WP,

        'BodyBG'                =>  'bg-none',
        'ContainerBG'           =>  '',

        'IncPMM'                =>  'tpl_er_lp/er-lp-listing'.$config[TPL_EX],
        'IncPSBM'               =>  'tpl_er_lp/er-lp-sidebar'.$config[TPL_EX],
        'IncPTBM'               =>  'tpl_er_lp/er-lp-search-filter-selected'.$config[TPL_EX],

        'BarHWPH'               =>  true,

        'InListing'             =>  true,
        'rsLP'                  =>  $rsLP,
        'arrUrlArgs'            =>  $URL_ARGS,
        'arrParams'             =>  $_POST,
        'Filter'                =>  ProductMaster::obj()->filter,
        'total_record'          =>  ProductMaster::obj()->total_record,
        'IsLastRecord'          =>  ($_POST['last_record_num'] >= ProductMaster::obj()->total_record)?true:false,

        'arr_LP_SortBy'         =>  $asset['OL_PRODUCT_SORT_BY'],
        'arr_LP_ViewType'       =>  $asset['OL_VIEW_BY'],
        'ProductImg_ENC_V_UP'   =>  ProductImages::obj()->Data['ENC_V_UP'],
        'ProductImg_IMG_RW_URL' =>  ProductImages::obj()->Data[IMG_RW_URL],

        'arr_PriceRange'        =>  $asset['OL_PRODUCT_SEARCH_PRICE_RANGE'],
        'arr_DiscountRange'     =>  $asset['OL_PRODUCT_SEARCH_DISCOUNT_RANGE'],
        'arr_FControlType'      =>  $asset['OL_Feature_Control_All'],
     ));

	# If requested for full view but some how product is not availabe to show then listing will load so in that case auto scroll will not possible
	if(isset($URL_ARGS[SURL_FULL_VIEW_PAGE]))
	{
		st::$obj->assign(array(
			'HidePagination'    =>  true,
		));
	}
}
# Assign common and required details
st::$obj->assign(array(
	'Css'               =>      $css_files,
	'JavaScript'        =>      $js_files,

	"msgSuccess"        =>      $msgSuccess,
	"msgError"          =>      $msgError,
	"msgInfo"           =>      $msgInfo,
));
st::$obj->display('default-layout'. $config[TPL_EX], isset($cacheId)?$cacheId:null);
?>