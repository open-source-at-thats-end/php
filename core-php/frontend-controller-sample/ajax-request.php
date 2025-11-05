<?php
# File Name : /ajax-request.php
define('IN_SITE',	true);

require_once("includes/common.php");

AjaxResponse::obj();

# Common ajax requests will be here
function GRequest()
{
	global $config, $asset, $physical_path, $virtual_path;

	# Switch through module
	switch(AjaxResponse::obj()->XHR_MODULE)
	{
		case 'AuthReq':
			# Switch through module's action
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
                case 'SignUp':
                    if(is_array($_POST) && (count($_POST) === 9 || count($_POST) === 10) && Utility::obj()->ValidateEmail($_POST['email']) === true)
                    {
                        # Initilize user master object
                        UserMaster::obj(true);
                        UserMaster::obj()->populateSchema();

                        $_POST['type']                  =   WEB_UTYPE_REGISTER;
                        $_POST['send_welcome_email']    =   ((isset($_POST['FromCart']) && $_POST['FromCart'] === YES)?NO:YES);
                        $_POST['connect_using']         =   SIGNUP_USING_WEBSITE;
                        
                        $user_id = UserMaster::obj()->WebUserSignUp($_POST);
                        
                        if(is_numeric($user_id))
                        {
                            $msg = 'Please check your email and you will find verification link. If you do not find your email in inbox then, please check spam box or other email box. Click on verification link to verify your account. If you find any problem with your registration please contact site administrative.';
                            st::$obj->assign(array(
                                'Email'         =>  $_POST['email'],
                                'msg'           =>  $msg,
            		        ));

                            AjaxResponse::obj()->assign(st::$obj->fetch('tpl_user/u-succ-sup-msg'.$config[TPL_EX]), '#user-signup-form');

                            # Get logged in as user complete sign up
                            if(UserMaster::obj()->WebUserLogin($_POST['email'],$_POST['password'],SIGNUP_USING_WEBSITE,true) === true)
                            {
                                # show success message
                                AjaxResponse::obj()->success('Successfully logged in. You will be redirected soon.');
                                
                                # Redirect to dashboard page in user account
                                if(isset($_POST['rurl']) && !empty($_POST['rurl']))
                                {
                                    $url = $_POST['rurl'];
                                }
                                else
                                {
                                    # Set dashboard url
                                    $url = $virtual_path['USER_ACCOUNT_RW_URL'].'/'.$_SESSION[ALL_WEBPAGE]['list'][PAGE_MANAGER_ID_DASHBOAD][WebPageManager::obj()->Data[F_S_URL]];
                                }
                                AjaxResponse::obj()->redirect($url,2000);
                            }
                        }
                        else
                            AjaxResponse::obj()->error(UserMaster::obj()->Error[E_DESC]);
                    }
                    else
                        AjaxResponse::obj()->error('Please, check all your input(s). Make sure you have entered all valid information.');
				break;

                case 'Login':
                    if(is_array($_POST) && (count($_POST) === 5|count($_POST) === 6))
                    {
                        if(UserMaster::obj()->WebUserLogin($_POST['username'],$_POST['password'],SIGNUP_USING_WEBSITE,isset($_POST['keep_logged'])) === true)
                        {
                            # Show success message
                	        AjaxResponse::obj()->success('Successfully logged in. You will be redirected soon.');

                            # Redirect to dashboard page in user account
                            if(isset($_POST['rurl']) && !empty($_POST['rurl']))
                            {
                                $url = $_POST['rurl'];
                            }
                            else
                            {
                                # Set dashboard url
                                $url = $virtual_path['USER_ACCOUNT_RW_URL'].'/'.$_SESSION[ALL_WEBPAGE]['list'][PAGE_MANAGER_ID_DASHBOAD][WebPageManager::obj()->Data[F_S_URL]];
                            }
                            AjaxResponse::obj()->redirect($url);
                        }
                        else
                            AjaxResponse::obj()->error(UserMaster::obj()->Error[E_DESC]);
                    }
                    else
                        AjaxResponse::obj()->error('Please, check all your input(s). Make sure you have entered all valid information.');
                    break;
                case 'ForgotPSWD':
                    if(is_array($_POST) && (count($_POST) == 2 || count($_POST) == 3) )
                    {
                        $arrUser = UserMaster::obj()->GetInfoByUserName($_POST['reset_email']);

                        if(is_array($arrUser) && count($arrUser) > 0)
                        {
                            if($arrUser[UserMaster::obj()->Data[F_VIRTUAL_DELETE]] === NO)
                            {
                                if($arrUser[UserMaster::obj()->Data[F_ACTIVE]] == NO && $arrUser[UserMaster::obj()->Data[FIELD_PREFIX].'is_verified'] == NO)
                                {
                                    $send_welcomemail = UserMaster::obj()->SendWelComeEmail($arrUser[UserMaster::obj()->Data[F_P_KEY]], false);
                                    AjaxResponse::obj()->error('Sorry, email address is not confirmed with us. Please check your email for confirmation.');
                                }
                                else
                                {
                                    # Generate new password
                                    $password = Utility::obj()->generatePassword(array($arrUser[UserMaster::obj()->Data[F_P_FIELD]],$arrUser[UserMaster::obj()->Data[FIELD_PREFIX].'lastname']));

                                    # Update user password
                                    $affected_row = AuthUser::obj()->UpdateAuthPassword($arrUser[UserMaster::obj()->Data[F_F_KEY]],$password);

                                    if(isset($affected_row) && $affected_row == 1)
                                    {
                                        # Check forgot password mail send to user or not
                                        $send_password = UserMaster::obj()->SendPasswordResetEmail($arrUser[UserMaster::obj()->Data[F_P_KEY]], $password);

                	                    $_POST[UserMaster::obj()->Data[F_F_KEY]] = $arrUser[UserMaster::obj()->Data[F_F_KEY]];

                                        # User Log Insert
                                        UserLog::obj()->AddUserActionLog(ULOG_ACTION_FORGOTPASSWORD,$_POST,$arrUser[UserMaster::obj()->Data[F_P_KEY]],$affected_row, $arrUser ,array('NewPassword' => $password));

                                        if(isset($send_password) && $send_password == 1)
                                        {
                                            AjaxResponse::obj()->success('Successfully reset your password. Please check your email for confirmation.');
                                        }
                						else
                							AjaxResponse::obj()->error('Sorry, there is a problem to send confirmation email. Please try again.');
                	   	            }
                                    else
                                        AjaxResponse::obj()->error('Sorry, your password can not be reset. Please try again.');
                                }
                            }
                            else
                                AjaxResponse::obj()->error('Sorry, your account is deleted as per request. Contact support department for further assist.');
                        }
                        else
                            AjaxResponse::obj()->error('Sorry, email address is not registered with us.');
                    }
                    else
                        AjaxResponse::obj()->error('Please, check all your input(s). Make sure you have entered all valid information.');
                break;
                case 'AcntVerify':
                    $account    =   isset($_POST['account'])?$_POST['account']:'';
                    if(!empty($account))
                    {
                        $arrAccount    =   unserialize(Ocrypt::ED('D', $account));

                        if(is_array($arrAccount) && count($arrAccount) == 2 && filter_var($arrAccount[0], FILTER_VALIDATE_EMAIL) == true && is_numeric($arrAccount[1]))
				        {
				            require_once($physical_path['Libs']. '/Captcha/ImgVerification.php');
        					$vImg = new ImageVerification();
        					$verifyCodeFlag = $vImg->isValid();

        					# Verify captcha
        					if($verifyCodeFlag)
        					{
                                # Now activate user account as password has been changed
    							if(UserMaster::obj()->ActivateUserAccount($arrAccount[1], $arrAccount[0], $_POST) === true)
    							{
                                    AjaxResponse::obj()->success("Successfully verified your account.");

                                    # Redirect to dashboard page in user account
                                    if(AuthUser::obj()->User_Logged == YES)
                                    {
                                        $url = $virtual_path['USER_ACCOUNT_RW_URL'].'/'.$_SESSION[ALL_WEBPAGE]['list'][PAGE_MANAGER_ID_DASHBOAD][WebPageManager::obj()->Data[F_S_URL]];
                                    }
                                    else
                                    {
                                        # Redirect to login signup pages
                                        $url = $virtual_path['Main_Host_Url'].'/'.$_SESSION[ALL_WEBPAGE]['list'][PAGE_MANAGER_ID_LOGIN_SIGNUP][WebPageManager::obj()->Data[F_S_URL]];
                                    }
                                    AjaxResponse::obj()->redirect($url,7);
                                }
    							else
                                    AjaxResponse::obj()->error("Sorry, unable to activate your account.");
        				    }
                            else
    						  AjaxResponse::obj()->error("Please enter valid spam verification.");
    				    }
                        else
                            AjaxResponse::obj()->error("Undefined Request Found.");
                    }
                    else
                        AjaxResponse::obj()->error("Undefined Request Found.");
                break;
			}
			break;
        case 'Form':
			# Switch through module's action
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
                # Contact us request
				case 'CUSReq':
                    
                    if(AuthUser::obj()->User_Logged == STATUS_ONLINE && AuthUser::obj()->User_Perm == USER && count($_POST) === 3)
                    {
                        $user_info = UserMaster::obj()->Profile;

                        $_POST['firstname']                         =   $user_info[UserMaster::obj()->Data[F_P_FIELD]];
                        $_POST['lastname']                          =   $user_info[UserMaster::obj()->Data[FIELD_PREFIX].'lastname'];
                        $_POST['email']                             =   $user_info[UserMaster::obj()->Data[FIELD_PREFIX].'email'];
                        $_POST['mobile_ccode']                      =   $user_info[UserMaster::obj()->Data[FIELD_PREFIX].'mobile_ccode'];
                        $_POST['mobile']                            =   $user_info[UserMaster::obj()->Data[FIELD_PREFIX].'mobile'];
                        $_POST[GeoCountry::obj()->Data[F_P_KEY]]    =   $user_info[UserMaster::obj()->Data[FIELD_PREFIX].GeoCountry::obj()->Data[F_P_KEY]];
                        $_POST['concern_issue']                     =   CONCERN_ISSUE_ITEM;
                        $_POST['subject']                           =   "Need some information of product";
                    }

					Subscribers::obj(true);
                    Subscribers::obj()->populateSchema();

                    if(!isset($_POST['subscribe_for_updates']))
                        $_POST['is_active'] =   NO;

                    $id = Subscribers::obj()->_Insert($_POST);

                    # Word Sensoring Data
                    $isCensored = true;

                    if($config['enable_word_censoring'] == 'Yes')
                    {
                        WordCensoring::obj(true);
                        $arrPOST = array();

                        array_push($arrPOST,    $_POST['firstname']);
                        array_push($arrPOST,    $_POST['lastname']);
                        $isCensored = WordCensoring::obj()->isAllowed($arrPOST);
                    }

                    if($isCensored && (!Utility::obj()->IsBlockedEmail($_POST['email'])))
                    {
                        LeadMaster::obj(true);
                        LeadMaster::obj()->populateschema();

                        $_POST['type']      =   CONTACTUS;
                        $_POST[UserMaster::obj()->Data[F_P_KEY]]   =   is_numeric(UserMaster::obj()->ID)?UserMaster::obj()->ID:false;

                        # Check if category id exist in $_POST
                        if(!empty($_POST['ref_id']) && !empty($_POST['ref_type']))
                        {
                            if(!is_numeric($_POST['ref_id']))
	                            $ref_id = Ocrypt::dec($_POST['ref_id']);
	                        else
		                        $ref_id = $_POST['ref_id'];

	                        if(!is_numeric($_POST['ref_type']))
		                        $ref_type = Ocrypt::dec($_POST['ref_type']);
	                        else
		                        $ref_type = $_POST['ref_type'];

                            # Set reference id and reference type in $_POST
                            $_POST['ref_id'] = (isset($ref_id) && is_numeric($ref_id))?$ref_id:'';

                            $_POST['ref_type'] = (isset($ref_type) && is_numeric($ref_type))?$ref_type:'';
                        }
                        $lead_id = LeadMaster::obj()->_Insert($_POST);

                        if(is_numeric($lead_id))
                        {
                            LeadMaster::obj()->SendContactUsReqEmail($_POST);
                            AjaxResponse::obj()->success('Thank you, we have received your request and will respond to you soon.');
                        }
                        else
                            AjaxResponse::obj()->error('Please, check all your input(s). Make sure you have entered all valid information.');
                    }
                    else
                        AjaxResponse::obj()->error('Please, check all your input(s). Make sure you have entered all valid information.');
                    break;
			}
			break;
        case 'Remove':
			# Switch through module's action
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
                # Remove wishlist product
				case 'WList':
                    $adt        =   date('Y-m-d H:i:s');
                	$Ref_ID     =   isset($_POST['ref_id'])?Ocrypt::ndec($_POST['ref_id']):'';
                	$Ref_Type   =   isset($_POST['ref_type'])?$_POST['ref_type']:'';

                    if(!is_numeric($Ref_ID) || !is_numeric($Ref_Type))
                	{
                		# Manipulation if no proper ref found
                		AjaxResponse::obj()->error('Sorry, ambiguous request found. Please try again.');
                		return false;
                	}

                    $arrWList       =   unserialize(base64_decode($_COOKIE[COOKIE_TE_WL]));

                    # If key is set then first unset key
                    if(isset($arrWList[$Ref_Type][$_POST['ref_id']]))
                        unset($arrWList[$Ref_Type][$_POST['ref_id']]);

                    $total_record   =   count($arrWList[$Ref_Type]);

                    # Get new wishlist
                    $arrNWlist  =   base64_encode(serialize($arrWList));

                    $d = explode(':',$_SERVER['NON_WWW_HTTP_HOST']);
                    setcookie(COOKIE_TE_WL,$arrNWlist,time()+60*60*24*30,'/','.'.$d[0]);

        			if(isset(AuthUser::obj()->User_Logged) && AuthUser::obj()->User_Logged === STATUS_ONLINE)
        			{
                        # Delete user wishlist product
                        UserWishlist::obj()->DeleteWishListByUserIDAndRefID(UserMaster::obj()->ID, $Ref_ID, $Ref_Type);

        				$param[UserMaster::obj()->Data[F_P_KEY]] = UserMaster::obj()->ID;

                        # Get count of user wishlist product
                        $total_record = UserWishlist::obj()->getUserWishListCountByParam($param);

                        # Product info set into $_POST
        				$info = array('ref_id'=>$Ref_ID,'ref_type'=>$Ref_Type,'adt'=>$adt);

        				# User Log Insert
        				UserLog::obj()->AddUserActionLog(ULOG_ACTION_REMOVEFROM_WISHLIST,$info,UserMaster::obj()->ID,false,false,false);
                    }

                    # Set info of remove data
                    $arrInfo = array('ref_id' => $_POST['ref_id'], 'total_record' => $total_record);

                    AjaxResponse::obj()->set_data(false,$arrInfo);
                    AjaxResponse::obj()->success('Successfully, remove product from your wishlist.');
    			break;

                case 'Compare':

                    $iclist  = unserialize(base64_decode($_COOKIE[COOKIE_TE_IC]));

                    #if key is set then first unset key
                    if(isset($iclist[$_POST['ref_type']][$_POST['ref_id']]))
                        unset($iclist[$_POST['ref_type']][$_POST['ref_id']]);

                    $new_iclist  =   base64_encode(serialize($iclist));

                    $d = explode(':',$_SERVER['NON_WWW_HTTP_HOST']);
                    setcookie(COOKIE_TE_IC,$new_iclist,time()+60*60*24*30,'/','.'.$d[0]);

                    AjaxResponse::obj()->set_data('ref_id',$_POST['ref_id']);
                    AjaxResponse::obj()->success('Successfully, remove product from your Compare list.');

                    if(isset($iclist[$_POST['ref_type']]) && count($iclist[$_POST['ref_type']]) < 1)
                    {
                        AjaxResponse::obj()->redirect($_SERVER['HTTP_REFERER'],2);
                    }
                break;
			}
			break;

        case '':
			# Switch through module's action
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
				case '':
					break;

			}
			break;

		default:
	}
}
function ER_LP()
{
    global $config, $asset, $physical_path, $virtual_path;
    
    $intention = $_POST['intention'];
    
    # User has changed only view type so just change URL only and return
	if($intention == 'lvt')
	{
		$p = explode('/'.LISTING_VIEW_TYPE.'/',AjaxResponse::obj()->XHR_URL);
		$url = rtrim($p[0],'/');
		$weburl = $url."/".LISTING_VIEW_TYPE."/".$_POST['lvt'];
        AjaxResponse::obj()->set_data('weburl',$weburl);
		return true;
	}
    # If user has requested to remove all filter then load only related category
	if($intention == 'fr-all' && isset($_POST['clear_filter']) && $_POST['clear_filter'] == 'all')
	{
		$category = isset($_POST[QP_CATEGORY])?$_POST[QP_CATEGORY]:'';

		if(!is_array($category) || count($category) <= 0)
		{
			$clist = isset($_POST['clist'])?$_POST['clist']:'';
			if(is_array($clist) && count($clist) > 0)
			{
				$cl = array();
				foreach($clist as $k=>$c)
				{
					$temp = explode('|',$c);
					$cl[$temp[0]] = $temp[1];
				}
				arsort($cl); $cl_max = key($cl);
				$cl_max = explode(',',$cl_max);
				$category[0] = $cl_max[count($cl_max)-1];
			}
			else
			{
				# Need some logic if nothing found related with category
			}
		}
        
        $weburl = $virtual_path['Main_Host_Url']."/".SU_ER_LISTING_PAGE."/";
        
        if(isset($category[0]) && $category[0] != '')
            $weburl .= QP_CATEGORY."/".$category[0];
		
        AjaxResponse::obj()->set_data('weburl',$weburl);
		return true;
	}

	# If user has requested to remove all fiter from particular group
	if(isset($_POST['clear_filter']) && $_POST['clear_filter'] != '')
	{
		if($intention == 'fr-group')
		{
			# Remove first 2 char (f-) from group name so we can get actual group
			$group = substr(trim($_POST['clear_filter']),2);

			if(isset($_POST[$group])){unset($_POST[$group]);}
			elseif(isset($_POST[QP_FEATURE][$group])){unset($_POST[QP_FEATURE][$group]);}
		}
		elseif($intention == 'fr-only')
		{
			$fr = $_POST['clear_filter'];
			if(isset($_POST[$fr])){unset($_POST[$fr]);}
		}
	}
    # Get param for search
	$FILTER = ProductMaster::obj()->setQueryParameters($_POST);
    
    //define('DEBUG',true);
    # Get product information based on set arrParams
	$rsLP    =   ProductMaster::obj()->_ViewAll_WebSite($FILTER);
    
    # Check for correct page number, If wrong then change page no and record limit
	if(isset($FILTER['last_record_num']) && $FILTER['last_record_num'] > ProductMaster::obj()->total_record)
	{
		$total_pages = ceil(ProductMaster::obj()->total_record/RESULT_PAGESIZE);
		if($total_pages <= $FILTER[GO_TO_PAGE])
		{
			$FILTER[GO_TO_PAGE]          =   0;
			$FILTER[S_RECORD]            =   0;
			$FILTER['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
		}
		else
		{
			$FILTER['last_record_num']   =   ProductMaster::obj()->total_record;
		}
	}

	st::$obj->assign(array(
        'InListing'             =>  true,
        "arrParams"             =>  $FILTER,
        'URL_FILTER'            =>  $_POST,
        'rsLP'                  =>  $rsLP,
        'last_record_num'       =>  $FILTER['last_record_num'],
        'total_record'          =>  ProductMaster::obj()->total_record,
        "IsLastRecord"          =>  (($FILTER['last_record_num'] >= ProductMaster::obj()->total_record)?true:false),
        'ImgRwUrl'              =>  $virtual_path['MDN_Url'].ProductImages::obj()->Data[IMG_RW_URL],
        'ProductImg_ENC_V_UP'   =>  ProductImages::obj()->Data['ENC_V_UP'],
        'ProductImg_IMG_RW_URL' =>  ProductImages::obj()->Data[IMG_RW_URL],
     ));
    //Utility::pre($_POST);
	# Load listing data as per request
	if(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN)
	{
		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_er_lp/er-lp-listing-view'.$config[TPL_EX]),$_POST['s_result_div']);
	}
	elseif(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_APPEND)
	{
		AjaxResponse::obj()->append(st::$obj->fetch('tpl_er_lp/er-lp-listing-view'.$config[TPL_EX]),$_POST['s_result_div']);
	}

	AjaxResponse::obj()->assign(st::$obj->fetch('tpl_er_lp/er-lp-pagination'. $config[TPL_EX]),$_POST['s_pagination_div']);

	# Check for last record if found
	if($FILTER['last_record_num'] >= ProductMaster::obj()->total_record || (isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN))
	{
		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_er_lp/er-lp-loading-btnmsg'. $config[TPL_EX]),$_POST['s_lbm_div']);
	}

    # Need to regenerate listing URL. As we have decereased 1 page from POST page so increase it
    $FILTER[GO_TO_PAGE]=$FILTER[GO_TO_PAGE]+1;

    # Some manipulation based on intention of data load
	if($intention == 'scroll' || $intention == 'paging')
	{
		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
		$p[0] = rtrim($p[0],'/');

		if(isset($p[1]))
			$p[1] = ltrim(strstr(ltrim($p[1],'/'),'/'),'/');

		$weburl = $p[0]."/".GO_TO_PAGE."/".$FILTER[GO_TO_PAGE]."/".(isset($p[1])?$p[1]:'');

	}
	elseif($intention == 'sosd')
	{
		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
		$p[0] = rtrim($p[0],'/');

        $url = Utility::SetURLParam($FILTER, ProductMaster::obj()->Data['LP_S_CRITERIA']);

		$weburl = $p[0]."/".$url;
	}
	else
	{
		$url = Utility::SetURLParam($FILTER, ProductMaster::obj()->Data['LP_S_PARAMS']);
		$weburl = $virtual_path['Main_Host_Url'].URLSEPARATOR_BACKSLASH.SU_ER_LISTING_PAGE.URLSEPARATOR_BACKSLASH.$url;
	}
    
    AjaxResponse::obj()->set_data('weburl',$weburl);
	AjaxResponse::obj()->set_data('t_record',(string) ProductMaster::obj()->total_record);
}
function LR_Action()
{
	global $config, $asset, $physical_path, $virtual_path;

    $adt            =   date('Y-m-d H:i:s');
	$Ref_ID         =   isset($_POST['ref_id'])?Ocrypt::dec($_POST['ref_id']):'';
	$Ref_Type       =   isset($_POST['ref_type'])?$_POST['ref_type']:'';
    $Ref_Additional =   isset($_POST['ref_additional'])?$_POST['ref_additional']:'';

    if(!is_numeric($Ref_Type) || (!is_numeric($Ref_ID) && empty($Ref_Additional)))
	{
		# Manipulation if no proper ref found
		AjaxResponse::obj()->error('Sorry, ambiguous request found. Please try again.');
		return false;
	}
	else
	{
		if(isset($Ref_Additional) && !empty($Ref_Additional))
		{
			$URL_ARGS = Utility::GetURLParam($Ref_Additional);
			$Ref_ID = false;
		}
        elseif(is_numeric($Ref_ID))
        {
            $N_Ref_Id = Ocrypt::nenc($Ref_ID);
            $URL_ARGS = false;
        }
    }

	# Switch through module
	switch(AjaxResponse::obj()->XHR_MODULE)
	{
		case 'Enquiry':

			break;
		case 'WishList':

			$msg='';

			if(isset($_COOKIE[COOKIE_TE_WL])   &&  !empty($_COOKIE[COOKIE_TE_WL]))
			{
				$wlist  = unserialize(base64_decode($_COOKIE[COOKIE_TE_WL]));

				if(isset($wlist[$Ref_Type]))
				{
					# If count is 50 or more then that then remove first one and insert new
					if(count($wlist[$Ref_Type]) >= 15 && !array_key_exists($N_Ref_Id, $wlist[$Ref_Type]))
					{
						reset($wlist[$Ref_Type]);

						$key = key($wlist[$Ref_Type]);
						unset($wlist[$Ref_Type][$key]);

						$msg.='Wish list is full. An item has been removed. ';
					}
                    elseif(array_key_exists($N_Ref_Id, $wlist[$Ref_Type]))
                    {
                        unset($wlist[$Ref_Type][$N_Ref_Id]);
                    }
				}
			}

			# Now set cookie for requested item
			$wlist[$Ref_Type][$N_Ref_Id] = $adt;
			$total_wl = count($wlist[$Ref_Type]);

            # Add current item in cokkie array
            $wlist = $_COOKIE[COOKIE_TE_WL] = base64_encode(serialize($wlist));

			$d = explode(':',$_SERVER['NON_WWW_HTTP_HOST']);
			setcookie(COOKIE_TE_WL,$wlist,time()+60*60*24*30,'/','.'.$d[0]);

			if(isset(AuthUser::obj()->User_Logged) && AuthUser::obj()->User_Logged === STATUS_ONLINE)
			{
                $msg = '';
				UserWishlist::obj()->InsertUpdateMyWishList(UserMaster::obj()->ID,$Ref_ID, $Ref_Type, $adt);

                $param[UserMaster::obj()->Data[F_P_KEY]] = UserMaster::obj()->ID;

                # Get count of user wishlist product
                $total_wl = UserWishlist::obj()->getUserWishListCountByParam($param);

                # Product info set into $_POST
				$info = array('ref_id'=>$Ref_ID,'ref_type'=>$Ref_Type,'adt'=>$adt);

				# User Log Insert
				UserLog::obj()->AddUserActionLog(ULOG_ACTION_ADDTOWISHLIST,$info,UserMaster::obj()->ID,false,false,false);
			}

            # Wishlist product info
            $rsSideBarUW = UserWishlist::obj()->getUserWishlistProductInfo($limit=5);

            st::$obj->assign(array(
                'rsSideBarUW'       =>  $rsSideBarUW,
                'rs'                =>  new DB_Recordset_DirectRecordBase(),
            ));

            AjaxResponse::obj()->assign(st::$obj->fetch('lp-wl'. $config[TPL_EX]),'#rsb-2-1');

			$msg .= 'New item has been added to your wish list. Now you have total <b>'.$total_wl.'</b> item(s) in wish list.';

            AjaxResponse::obj()->success($msg);

            break;
		case 'Compare':
			if(isset($_COOKIE[COOKIE_TE_IC])   &&  !empty($_COOKIE[COOKIE_TE_IC]))
			{
				$iclist  = unserialize(base64_decode($_COOKIE[COOKIE_TE_IC]));

			    # If count is 50 or more then that then remove first one and insert new
				if(isset($iclist[$Ref_Type]) && count($iclist[$Ref_Type]) >= 10 && !array_key_exists($N_Ref_Id, $iclist[$Ref_Type]))
				{
                    AjaxResponse::obj()->error('Sorry,your compare list is full. Remove some item from your compare list.');
				}
                else
                {
                    if(array_key_exists($N_Ref_Id, $iclist[$Ref_Type]))
                    {
                        unset($iclist[$Ref_Type][$N_Ref_Id]);
                    }

                    $iclist[$Ref_Type][$N_Ref_Id] = $adt;
        			$total_ic = count($iclist[$Ref_Type]);

                    # Add current item in cokkie array
                    $iclist = $_COOKIE[COOKIE_TE_IC] = base64_encode(serialize($iclist));

        			$d = explode(':',$_SERVER['NON_WWW_HTTP_HOST']);
        			setcookie(COOKIE_TE_IC,$iclist,time()+60*60*24*30,'/','.'.$d[0]);

        			AjaxResponse::obj()->success('Successfully added item to compare list. Now you have total <b>'.$total_ic.'</b> item(s) in your compare list.');
                }
			}
            else
            {
                # Now set cookie for requested item
    			$iclist[$Ref_Type][$N_Ref_Id] = $adt;
    			$total_ic = count($iclist[$Ref_Type]);

                # Add current item in cokkie array
                $iclist = $_COOKIE[COOKIE_TE_IC] = base64_encode(serialize($iclist));

    			$d = explode(':',$_SERVER['NON_WWW_HTTP_HOST']);
    			setcookie(COOKIE_TE_IC,$iclist,time()+60*60*24*30,'/','.'.$d[0]);

    			AjaxResponse::obj()->success('Successfully added item to compare list. Now you have total <b>'.$total_ic.'</b> item(s) in your compare list.');
			}

            # compare product info
            $rsSideBarPC = ProductMaster::obj()->getProductCompareList($limit=5);

            st::$obj->assign(array(
                'rsSideBarPC'       =>  $rsSideBarPC,
                'rs'                =>  new DB_Recordset_DirectRecordBase(),
            ));

            AjaxResponse::obj()->assign(st::$obj->fetch('lp-compare'. $config[TPL_EX]),'#rsb-4-1');

            break;
		case 'View':
			switch($Ref_Type)
			{
				case AREATE_ID_ECOM_RETAIL:
					$active = true; $e = 'Sorry, no product found related with your request. Please try again.';

                    if(!is_numeric($Ref_ID) && (!is_array($URL_ARGS) || is_array($URL_ARGS) && count($URL_ARGS) <= 0))
                        return false;

                    if(isset($Ref_ID) && is_numeric($Ref_ID))
                    {
                        $arrParam[SURL_FVP_ITEM] = $Ref_ID ;
                    }
                    else
                    {
                        if(is_array($URL_ARGS) && count($URL_ARGS) > 0)
                        {
                            $arrParam = $URL_ARGS;
                        }
                    }
                    $arrLFVInfo = ProductMaster::obj()->getFullViewProductDetail($arrParam);
                    //Utility::pre($arrLFVInfo);
                    if(!isset($arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]]))
					{
						AjaxResponse::obj()->error($e);
						return false;
					}

					$arrLFVInfo['product_number'] = Ocrypt::nenc($arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]]);

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
                    if(isset($arrParam[QP_FEATURE]) && is_array($arrParam[QP_FEATURE]) && count($arrParam[QP_FEATURE]) > 0)
                        $availableFeature = ProductMaster::obj()->getProductAvailableFeature($arrParam);

					################################################################################
					# PRODUCT TYPE : Check for assigned product type active flag
					/*$all_protype_id_field         =   ProductMaster::obj()->Data[FIELD_PREFIX].ProductTypeMaster::obj()->Data[F_P_KEY];
					$all_protype_active_field     =   ProductMaster::obj()->Data[FIELD_PREFIX].ProductTypeMaster::obj()->Data[F_ACTIVE];
					$all_protype_safe_url_field   =   ProductMaster::obj()->Data[FIELD_PREFIX].ProductTypeMaster::obj()->Data[F_S_URL];

					if(!isset($arrLFVInfo[$all_protype_active_field]) || (isset($arrLFVInfo[$all_protype_active_field]) && $arrLFVInfo[$all_protype_active_field] != YES))
						$active = false;
					else
						$available_protype_id = $arrLFVInfo[$all_protype_safe_url_field];*/

					# If requested product is not available some how then return
					if($active == false)
					{
						AjaxResponse::obj()->error($e);
						return false;
					}

					# If all ko then go ahead and process all details
					if(isset($available_category_id) && is_string($available_category_id))
					{
						$arrLFVInfo['product_cm_safe_url']   = $available_category_id;
						$arrLFVInfo['product_cm_name']      = $available_category_name;
					}

					# Get all product image by product id
					$rsProductImage     =   ProductImages::obj()->GetAllImageOfProductByProductID($arrLFVInfo['product_id']);
					$dt_folder          =   Utility::obj()->dt_folder($arrLFVInfo[ProductMaster::obj()->Data[F_ADDED_DATETIME]]);
					$Img_RW_URL         =   ProductImages::obj()->Data[IMG_RW_URL];

					# Create JSON for listing images to show with zooming effect
					while($rsProductImage->next_record())
					{
						$zoom = $virtual_path['MDN_Url'].ltrim(ProductMaster::obj()->Data['ENC_V_UP'],'.').'/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file');
                        $img = $virtual_path['MDN_Url'].ltrim(ProductMaster::obj()->Data[P_UP],'.').'/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file');
						$arrImg[] = array(
							'zoom'      => $zoom,
							//'preview'      => $virtual_path['MDN_Url'].ltrim(ProductMaster::obj()->Data[P_UP],'.').'/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file'),
							'preview'   => $virtual_path['MDN_Url'].$Img_RW_URL.'/'.$arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]].'/'.$rsProductImage->f(ProductImages::obj()->Data[F_P_KEY]).'/600x600/fx90/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file'),
							'thumb'     => $virtual_path['MDN_Url'].$Img_RW_URL.'/'.$arrLFVInfo[ProductMaster::obj()->Data[F_P_KEY]].'/'.$rsProductImage->f(ProductImages::obj()->Data[F_P_KEY]).'/62x62/fx90/'.$dt_folder.'/'.$rsProductImage->f('proimg_image_file'),
							'img'       => $img,
							'title'     => $rsProductImage->f('proimg_title')
						);
                        
                        # Get actual image size
                        list($w,$h) = getimagesize($img);
						
                        $arrImg_PS[] = array(
							'src'   =>  $zoom,
							/*'w'     =>  ProductMaster::obj()->Data['IMG_SIZE']['w'],
							'h'     =>  ProductMaster::obj()->Data['IMG_SIZE']['h'],*/
                            'w'     =>  $w,
							'h'     =>  $h,
                            
						);
					}

					# Get all product features by product id
					$arrPFList     =   ProductFeature::obj()->getProductFeatureList($arrLFVInfo['product_id']);

                    if(isset($availableFeature) && is_array($availableFeature) && count($availableFeature) > 0)
                    {
                        st::$obj->assign(array( 'availableFeature'  =>  $availableFeature));

                    }
                    if(is_array($arrParam) && count($arrParam) > 0)
                    {
                        st::$obj->assign(array( 'arrUrlArgs'  =>  $arrParam));
                    }
					if(AuthUser::obj()->User_Perm == USER && isset(AuthUser::obj()->User_Logged) && AuthUser::obj()->User_Logged === STATUS_ONLINE && isset(UserMaster::obj()->ID) && is_numeric(UserMaster::obj()->ID))
					{
						# User Log Insert
						UserLog::obj()->AddUserActionLog(ULOG_ACTION_QUICK_VIEW_PRODUCT,$arrLFVInfo,UserMaster::obj()->ID,false,false,false);
					}

					st::$obj->assign(array(
                        'arrLFVInfo'            =>  $arrLFVInfo,
                        'ProductImg_ENC_V_UP'   =>  ProductImages::obj()->Data['ENC_V_UP'],
                        'ProductImg_IMG_RW_URL' =>  ProductImages::obj()->Data[IMG_RW_URL],
                        'Business_IMG_RW_URL'   =>  BusinessMaster::obj()->Data[IMG_RW_URL],
                        'IsQuickView'           =>  true,

                        'arrPFList'             =>  $arrPFList,
                        'arrImg'                =>  $arrImg,
                        'arrImg_PS'             =>  $arrImg_PS,
	                 ));

					AjaxResponse::obj()->assign(st::$obj->fetch('tpl_er_lp/er-lp-full-view'. $config[TPL_EX]),'#lr-etc-modal .modal-body');

					break;
			}

			break;
	}
}
function LR_OP()
{
	global $config, $asset, $physical_path, $virtual_path;

	$PCElement = array(
		0   =>  '#rsb-1',//'#cart-holder',
		1   =>  '#cart-item-count',
		2   =>  '#checkout-holder'
	);

	# Initialize order master object
	OrderMaster::obj(true);

	# Set online shopping cart if not set
	if(!isset(Cart::obj()->Basket[CART_CURCART]) || (isset(Cart::obj()->Basket[CART_CURCART]) && Cart::obj()->Basket[CART_CURCART] != CART_KEY_ONLINESHOPPING))
        Cart::obj()->SetCurrentCart(CART_KEY_ONLINESHOPPING);
    
		

	# Get current shopping cart
	$_CSC = Cart::obj()->GetCurrentCart();

    $InCheckout = (isset($_POST['in_checkout']) && $_POST['in_checkout'] == 'true')?true:false;

    # Switch through module
	switch(AjaxResponse::obj()->XHR_MODULE)
	{
	   case 'Cart':
            
            
            $Ref_ID     	        =   isset($_POST['ref_id'])?Ocrypt::dec($_POST['ref_id']):'';
			$Ref_Type   	        =   isset($_POST['ref_type'])?$_POST['ref_type']:'';
			$Ref_Required           =	isset($_POST['ref_required'])?$_POST['ref_required']:'';
            $tot_required_feature   =   isset($_POST['ref_required_total'])?Ocrypt::dec($_POST['ref_required_total']):'';

            if(!is_numeric($Ref_ID) || !is_numeric($Ref_Type))
			{
				# Manipulation if no proper ref found
				AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(21));
				return false;
			}

			# Switch through module's action
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
				case 'AddToCart':
				case 'BuyNow':
                    # Check for selected required feature and total required feature are same or not.
                    if(empty($Ref_Required) || empty($tot_required_feature) || count($Ref_Required) < $tot_required_feature)
                    {
                        AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(10));
        				return false;
                    }
                    
    				if(isset($_CSC) && (empty($_CSC[CART_LAST_ORDER_BATCH_ID]) || !isset($_CSC[CART_LAST_ORDER_BATCH_ID]) || (isset($_CSC[CART_LAST_ORDER_BATCH_ID]) && isset($_CSC[CART_SHOPPING_STEP]) && $_CSC[CART_SHOPPING_STEP] == 6)) && ((isset($_CSC[CART_SHOPPING_STEP]) && $_CSC[CART_SHOPPING_STEP] != 5) || !isset($_CSC[CART_SHOPPING_STEP])))
					{
						
                        # Check and get requested product by type
						$NewShoppingItemInfo = OrderMaster::obj()->CheckShoppingCartItemByRefTypeAndRefId($Ref_Type, $Ref_ID, $Ref_Required);
                        
                        if(is_array($NewShoppingItemInfo))
						{
							# As user has only clicked on add to cart button so need some mini required qty to purchase
							$NewShoppingItemInfo['ref_req_quantity'] = $NewShoppingItemInfo['ref_min_order_qty'];

                            # Get current cart item
							$CurShoppingCart    =   $_CSC;
 
							# Check if previous shopping cart is set or not. If set then clear curent cart
							if(isset($CurShoppingCart[CART_SHOPPING_STEP]) && $CurShoppingCart[CART_SHOPPING_STEP] == 6)
								$CurShoppingCart = array();

							# Create new cart with the help of new item and current cart
							$NewShoppingCart = OrderMaster::obj()->AddNewShoppingItemInCart($CurShoppingCart, $NewShoppingItemInfo);
                            
                            if(is_array($NewShoppingCart))
							{
                                
								Cart::obj()->UpdateCartItems($NewShoppingCart,true);
								Cart::obj()->SaveCart();

								# Manipulate GUI based on current screen
								if($InCheckout === true){/*If user is in check out page then at this moment add to cart request will not come*/}
								else
								{
									Cart::obj()->AssignShoppingCartToTPL($NewShoppingCart);

									AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-shopping-cart'. $config[TPL_EX]),$PCElement[0]);
									AjaxResponse::obj()->assign($NewShoppingCart[CART_SHOPPING_GRAND_TOTAL]['shopping_cart_total_item_quantity'], $PCElement[1]);

									# If action is buy now then redirect user to checkout
									if(AjaxResponse::obj()->XHR_ACTION == 'BuyNow')
										AjaxResponse::obj()->redirect($virtual_path['CHECKOUT_RW_URL'],2);
								}
							}
							else
								AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(37));
						}
						else
							AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(5));
					}
					else
					{
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(32, $_CSC[CART_LAST_ORDER_BATCH_ID]));
						AjaxResponse::obj()->redirect($virtual_path['CHECKOUT_RW_URL'],2);
					}
					break;
				case 'RemoveItem':
					if(isset(Cart::obj()->Basket[CART_CURCART]) && Cart::obj()->Basket[CART_CURCART] == CART_KEY_ONLINESHOPPING)
					{
						# Create new cart with the help of new item and current cart
						$NewShoppingCart = OrderMaster::obj()->RemoveCartItemByRefIdAndRefTYpe($_CSC, $Ref_Type, $Ref_ID);
						if(is_array($NewShoppingCart))
						{
							Cart::obj()->UpdateCartItems($NewShoppingCart,true);
							Cart::obj()->SaveCart();
							Cart::obj()->AssignShoppingCartToTPL($NewShoppingCart, $InCheckout);

							# Manipulate GUI based on current screen
							if($InCheckout === true)
							{
								AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-checkout'. $config['tplEx']),$PCElement[2]);
							}
							else
							{
								$iq = isset($NewShoppingCart[CART_SHOPPING_GRAND_TOTAL]['shopping_cart_total_item_quantity'])?$NewShoppingCart[CART_SHOPPING_GRAND_TOTAL]['shopping_cart_total_item_quantity']:'0';
								AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-shopping-cart'. $config[TPL_EX]),$PCElement[0]);
								AjaxResponse::obj()->assign((($iq > 0)?$iq:'0'), $PCElement[1]);
							}
						}
						else
							AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(9));
					}
					else
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(37));
					break;
				case 'ChangeItemQty':
					if($InCheckout === true && isset(Cart::obj()->Basket[CART_CURCART]) && Cart::obj()->Basket[CART_CURCART] == CART_KEY_ONLINESHOPPING)
					{
						$ref_req_quantity   =   $_POST['ref_req_quantity'];
                        
						if(is_numeric($ref_req_quantity))
						{
                            # Create new cart with the help of item new quantity and current cart
							$NewShoppingCart = OrderMaster::obj()->ChangeCartItemQuantityByRefIdAndRefTYpe($_CSC, $Ref_Type, $Ref_ID, $ref_req_quantity);
                            
							if(is_array($NewShoppingCart))
							{
								Cart::obj()->UpdateCartItems($NewShoppingCart,true);
								Cart::obj()->SaveCart();
								Cart::obj()->AssignShoppingCartToTPL($NewShoppingCart, $InCheckout);
								AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-checkout'. $config['tplEx']),$PCElement[2]);
							}
							else
								AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(37));
						}
						else
							AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(8));
					}
					else
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(37));
					break;
			}
			break;
		case 'Checkout':
            
           	# All action which do not required authentication to perform
			# Switch through module's action which are only accessible for any user
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
				case 'EmptyCart':
				case 'CancelOrder':

					# Save order in temp so manipulate after clear cart
					$Last_Order_Batch_ID   =   (isset($_CSC[CART_LAST_ORDER_BATCH_ID]) && $_CSC[CART_LAST_ORDER_BATCH_ID] != '')?$_CSC[CART_LAST_ORDER_BATCH_ID]:false;
					$CartStep              =   (isset($_CSC[CART_SHOPPING_STEP]) && $_CSC[CART_SHOPPING_STEP] != '')?$_CSC[CART_SHOPPING_STEP]:'1';

					if(Cart::obj()->Clear(CART_KEY_ONLINESHOPPING) == true)
					{
						# Get current cart item
						$CurShoppingCart = Cart::obj()->GetCurrentCart();
						Cart::obj()->AssignShoppingCartToTPL($CurShoppingCart);

						st::$obj->assign(array(
			                 'OL_PurchaseStep'  =>  $asset['OL_PurchaseStep'],
		                 ));

						# Order has been inserted in database and after user has canceled so update status for that order
						if(AjaxResponse::obj()->XHR_ACTION == 'CancelOrder' && $Last_Order_Batch_ID != false && $Last_Order_Batch_ID != '' && AuthUser::obj()->User_Logged === STATUS_ONLINE  && AuthUser::obj()->User_Perm === USER)
                        {
                            # First get order id from $last_order_batch_id
                            $arrOrderID = OrderBatchMaster::obj()->getOrderIdByBatchId($Last_Order_Batch_ID);
                            
                            if(is_array($arrOrderID) && count($arrOrderID) > 0)
                            {
                                # Now change order status for all batch order
                                foreach($arrOrderID as $key => $id)
                                {
                                    OrderStatusHistory::obj()->ChangeOrderStatus($id, ORDER_STATUS_CANCELLED, 'Order has been cancelled by customer during checkout process on step '.$CartStep.'.');   
                                }
                            }
                        }
							
						if($InCheckout === true)
							AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-checkout'.$config[TPL_EX]),$PCElement[2]);
						else
						{
							AjaxResponse::obj()->assign('0',$PCElement[1]);
							AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-shopping-cart'.$config[TPL_EX]),$PCElement[0]);
						}

						AjaxResponse::obj()->success(OrderMaster::obj()->getShoppingCartSuccessMessage(7));
					}
					else
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(11));
					break;
			}

			# Do not allow below acess if user is not on check out
			if($InCheckout !== true)return false;

			# if user abouve 1st step then check for valid login to gain access
			if($_CSC[CART_SHOPPING_STEP] > 2 && (AuthUser::obj()->User_Logged != STATUS_ONLINE  && AuthUser::obj()->User_Perm != USER))
			{
				AjaxResponse::obj()->error('Unauthorized access. Please login or signup to gain access.');
				return false;
			}

			# Switch through module's action which are only accessible for logged in user
			switch(AjaxResponse::obj()->XHR_ACTION)
			{
				case 'NextPrevious':
					# Save old cart step. If some error occured then need is to reset.
					//$Old_Cart_Step  =   $_CSC[CART_SHOPPING_STEP];

                    # Manipulate new data in cart as per given step
					$NewShoppingCart = OrderMaster::obj()->ManipulateAdditionalData($_CSC, $_POST);
                    
                    if(is_array($NewShoppingCart))
					{
						Cart::obj()->UpdateCartItems($NewShoppingCart,true);
						Cart::obj()->SaveCart();
						Cart::obj()->AssignShoppingCartToTPL($NewShoppingCart,$InCheckout);

						st::$obj->assign(array(
							'OL_YesNo'                  =>      $asset['OL_YesNo'],
							'APIGateway_ENC_V_UP'       =>      APIGateway::obj()->Data['ENC_V_UP'],
                            'arr_mobilecode'            =>      GeoCountry::obj()->getAllMobileCode(),
                            'Business_IMG_RW_URL'       =>      BusinessMaster::obj()->Data[IMG_RW_URL],
						));

						# If oreder id found then add order full view page url
						if(isset($NewShoppingCart[CART_LAST_ORDER_BATCH_ID]) && !empty($NewShoppingCart[CART_LAST_ORDER_BATCH_ID]))
						{
							global $ALL_WEBPAGE;
							st::$obj->assign(array(
				                 'OrderPageUrl'         =>      $ALL_WEBPAGE['list'][PAGE_MANAGER_ID_USERORDER][WebPageManager::obj()->Data[F_S_URL]],
			                 ));
						}

						# STEP 2 : Then assign address book
						if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 2)
						{
						    if(AuthUser::obj()->User_Logged === STATUS_ONLINE  && AuthUser::obj()->User_Perm == USER)
							{
                                st::$obj->assign(array(
									'arrAddressBook'    =>  UserAddressBook::obj()->getKeyValueArrayByUserID(UserMaster::obj()->User_ID),
                                    'arr_mobilecode'    =>  GeoCountry::obj()->getAllMobileCode(),
								));
							}
							else
							{
								# Now user is on second step and not logged in so show login or sign up form
								st::$obj->assign(array(
					                 'rurl'    =>  $virtual_path['CHECKOUT_RW_URL'],
								));
							}
						}

						# STEP 3 : Then get all available payment gateway
						if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 3)
						{
						    st::$obj->assign(array(
						        'rsPaymentGateway'      =>      APIGateway::obj()->GetAllActiveAPIGateway(APIGATEWAY_TYPE_PAYMENT),
						        'rsShippingMethod'      =>      ShippingMethod::obj()->GetAllActiveShippingMethod(),
		                    ));
						}

						# STEP 4 :
						//if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 4){}

						# STEP 5 :
						//if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 5){}

						# STEP 6 :
						//if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 6){}

						###############################################################
						# Request manipulating code
						# Send all required data for shopping cart
						AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-checkout'.$config[TPL_EX]),$PCElement[2]);

						# STEP 2 : Then do some javascript manipulation
						//if($NewShoppingCart[CART_SHOPPING_STEP] == 2){}

						# STEP 3 :
						//if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 3){}

						# STEP 4 :
						//if(isset($NewShoppingCart[CART_SHOPPING_STEP]) && $NewShoppingCart[CART_SHOPPING_STEP] == 4){}

						# STEP 5 : If payment gateway is in action then load payment gateway configuration and redirect user to payment gateway
						if($NewShoppingCart[CART_SHOPPING_STEP] == 5)//$NewShoppingCart[CART_ORDER_PAYMENT_GATEWAY_INFO]['api_gateway_config']['paylive'] == YES
						{
                            if($NewShoppingCart[CART_ORDER_PAYMENT_GATEWAY_INFO][APIGateway::obj()->Data[F_P_KEY]] == APIGATEWAY_ID_INSTAMOJO)
							{

							}
                            elseif($NewShoppingCart[CART_ORDER_PAYMENT_GATEWAY_INFO][APIGateway::obj()->Data[F_P_KEY]] == APIGATEWAY_ID_PAYPAL)
							{

							}
                            # If payment gateway is not live then skip step 5 for payment process
							elseif($NewShoppingCart[CART_ORDER_PAYMENT_GATEWAY_INFO]['api_gateway_config']['paylive'] == NO)
							{
								AjaxResponse::obj()->set_data('goto','N');
							}
						}

						# STEP 6 : If requested for last step then unset cart
						if($NewShoppingCart[CART_SHOPPING_STEP] == 6)
						{
							Cart::obj()->Clear(CART_KEY_ONLINESHOPPING);
						}
					}
					else
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(37));

					break;
				case 'ApplyOffer':
					$my_cc      =   isset($_POST['my_cc'])?trim($_POST['my_cc']):false;
					$offer_id   =   isset($_POST['my_offer'])?$_POST['my_offer']:false;

					# Apply offer on order selected by user
					$NewShoppingCart = OrderMaster::obj()->ApplyUserSelectedOffer($_CSC, $offer_id, $my_cc);
                    
					if(is_array($NewShoppingCart))
					{
						Cart::obj()->UpdateCartItems($NewShoppingCart,true);
						Cart::obj()->SaveCart();
						Cart::obj()->AssignShoppingCartToTPL($NewShoppingCart,$InCheckout);
						AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-checkout'.$config[TPL_EX]),$PCElement[2]);
					}
					else
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(37));

					break;
				case 'RemoveOffer':
					# Remove offer from order
					$NewShoppingCart = OrderMaster::obj()->RemoveUserSelectedOffer($_CSC);
					if(is_array($NewShoppingCart))
					{
						Cart::obj()->UpdateCartItems($NewShoppingCart,true);
						Cart::obj()->SaveCart();
						Cart::obj()->AssignShoppingCartToTPL($NewShoppingCart,$InCheckout);
						AjaxResponse::obj()->assign(st::$obj->fetch('tpl_pc/pc-checkout'.$config[TPL_EX]),$PCElement[2]);
					}
					else
						AjaxResponse::obj()->error(OrderMaster::obj()->getShoppingCartErrorMessage(6));

					break;
			}
			break;
	}
	# On the fly success to notify end user
	if(is_array(OrderMaster::obj()->CartSuccess) && count(OrderMaster::obj()->CartSuccess) > 0)
	    foreach(OrderMaster::obj()->CartSuccess as $csk => $csv){AjaxResponse::obj()->success($csv);}

	# On the fly error to notify end user
	if(is_array(OrderMaster::obj()->CartError) && count(OrderMaster::obj()->CartError) > 0)
	    foreach(OrderMaster::obj()->CartError as $cek => $cev){AjaxResponse::obj()->error($cev);}
}
# All request which are restricted for logged inuser only
if(AuthUser::obj()->User_Logged === STATUS_ONLINE  && AuthUser::obj()->User_Perm == USER)
{
    function UAReq()
    {
        global $config, $asset, $physical_path, $virtual_path;

        # Switch through module
        switch(AjaxResponse::obj()->XHR_MODULE)
        {
            case 'Profile':
                # Switch through module's action
                switch(AjaxResponse::obj()->XHR_ACTION)
                {
                    case 'Edit':
                        # Modify field info
                        UserMaster::obj()->ResetFieldInfo(1);

                        # If user profile has no phone number then required mobile number for profile update
						if(empty(UserMaster::obj()->User_Phone))
						{
							UserMaster::obj()->Data[F_F_INFO]['mobile'] = array(
								CNT_TYPE        =>          C_PHONE,
								VALIDATE        =>          true,
								VAL_TYPE        =>          V_EMPTY|V_PHONE,
							);
						}
						# Update user details
						$user_update = UserMaster::obj()->_Update(UserMaster::obj()->ID,$_POST);
                        if(is_numeric($user_update))
                        {
                            # If user has added his phone number
                            if(empty(UserMaster::obj()->User_Phone) && isset($_POST['mobile']))
                                UserMaster::obj()->User_Phone = $_POST['mobile'];

                            #User Log Insert
                            UserLog::obj()->AddUserActionLog(ULOG_ACTION_EDITPROFILE,$_POST,UserMaster::obj()->ID,$user_update,UserMaster::obj()->Profile);

                            AjaxResponse::obj()->success('Successfully updated your profile details.');
                        }
                        else
                            AjaxResponse::obj()->error('Please enter valid profile information.'.UserMaster::obj()->Error[E_DESC]);
                        break;
                    case 'ChangePSWD':
                        require_once($physical_path['Libs']. '/Captcha/ImgVerification.php');
                        $vImg = new ImageVerification();
                        $verifyCodeFlag = $vImg->isValid();

                        # Verify captcha
                        if($verifyCodeFlag)
                        {
                            #Change user password
                            $responce = AuthUser::obj()->ChangePassword(AuthUser::obj()->User_Id,$_POST);

                            if(isset($responce) && $responce === true)
                            {
                                # User Log Insert
                                UserLog::obj()->AddUserActionLog(ULOG_ACTION_FORGOTPASSWORD,$_POST,UserMaster::obj()->ID,false,false,false);
                                AjaxResponse::obj()->success('Your password has been updated successfully.');
                            }
                            else
                                AjaxResponse::obj()->error($responce);
                        }
                        else
                            AjaxResponse::obj()->error('Please enter valid spam verification.');
                        break;
                    case 'ChangeNWLEmail':
                        if(is_array($_POST) && count($_POST) > 0)
                        {
                            if(!is_numeric($_POST['ss_id'])){$_POST['ss_id'] = Ocrypt::dec($_POST['ss_id']);}
                            
                            $affected_rows = Subscribers::obj(true)->Update($_POST['ss_id'], $_POST);
                            
                            if($affected_rows == true){AjaxResponse::obj()->success('Successfully updated subscriber info.');}
                            else{AjaxResponse::obj()->error('Sorry, error found. Please try again.');}
                        }
                        else
                            AjaxResponse::obj()->error('Please, check all your input(s). Make sure you have entered all valid information.');
                        break;
                    case '':
                        break;
                }
            case 'ABook':
                # Switch through module's action
                switch(AjaxResponse::obj()->XHR_ACTION)
                {
                    case 'Get':
                        $id = isset($_POST['a'])?trim($_POST['a']):'';
                        if(!is_numeric($id)){$id = Ocrypt::dec($id);}
                        $address = UserAddressBook::obj()->getAddressInfoByUserIdAddressId(UserMaster::obj()->ID, $id);

                        if(is_array($address) && count($address) > 0)
                        {
                            unset($address[UserAddressBook::obj()->Data[F_F_KEY]]);
                            $address[UserAddressBook::obj()->Data[F_P_KEY]] =   Ocrypt::enc($address[UserAddressBook::obj()->Data[F_P_KEY]]);
                            $address[UserAddressBook::obj()->Data[FIELD_PREFIX].'country_id'] =   Ocrypt::enc($address[UserAddressBook::obj()->Data[FIELD_PREFIX].'country_id']);
                            $address[UserAddressBook::obj()->Data[FIELD_PREFIX].'state_id']   =   Ocrypt::enc($address[UserAddressBook::obj()->Data[FIELD_PREFIX].'state_id']);
                            $address[UserAddressBook::obj()->Data[FIELD_PREFIX].'city_id']    =   Ocrypt::enc($address[UserAddressBook::obj()->Data[FIELD_PREFIX].'city_id']);

                            foreach($address as $key => $value)
                            {
                                $new_key = str_replace(UserAddressBook::obj()->Data[FIELD_PREFIX],'',$key);
                                $json[$new_key] = $value;
                            }
                            AjaxResponse::obj()->set_data(false,$json);
                        }
                        else
                            AjaxResponse::obj()->error('Unable to find your address. Please try again.');
                    break;

                    case 'AddEdit':

                        if(!is_numeric($_POST[UserMaster::obj()->Data[F_P_KEY]]))
                            $_POST[UserMaster::obj()->Data[F_P_KEY]] = Ocrypt::dec($_POST[UserMaster::obj()->Data[F_P_KEY]]);

                        if(isset($_POST[UserMaster::obj()->Data[F_P_KEY]]) && !empty($_POST[UserMaster::obj()->Data[F_P_KEY]]) && isset($_POST['pk']) && !empty($_POST['pk']))
                        {
                            UserAddressBook::obj()->populateSchema();

                            $affected_row = UserAddressBook::obj()->_Update($_POST['pk'],$_POST);

                            UserLog::obj()->AddUserActionLog(ULOG_ACTION_EDITADDRESSBOOK,$_POST,UserMaster::obj()->ID,$affected_row,false,false);

                            if($affected_row == true)
                            {
                                //AjaxResponse::obj()->script("jQuery('#user-address-book').trigger('reset');");
                                AjaxResponse::obj()->success('Your address has been updated successfully.');

                                $arrAddressBookPageInfo     =     WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_ADDRESS_BOOK);
                                $AddressbookURL             =     WebPageManager::obj()->buildUrl($arrAddressBookPageInfo,$virtual_path['USER_ACCOUNT_RW_URL']);

                                AjaxResponse::obj()->redirect($AddressbookURL, 1);
                            }
                            else
                                AjaxResponse::obj()->error('Sorry there are some error occured. Please try again.');
                        }
                        elseif(isset($_POST[UserMaster::obj()->Data[F_P_KEY]]) && is_numeric($_POST[UserMaster::obj()->Data[F_P_KEY]]))
                        {
                            UserAddressBook::obj()->populateSchema();

                            $id = UserAddressBook::obj()->_Insert($_POST);

                            UserLog::obj()->AddUserActionLog(ULOG_ACTION_ADDTOADDRESSBOOK,$_POST,UserMaster::obj()->ID,false,false,false);

                            if(is_numeric($id))
                            {
                                //AjaxResponse::obj()->script("jQuery('#user-address-book').trigger('reset');");
                                AjaxResponse::obj()->success('Your address has been added successfully.');

                                $arrAddressBookPageInfo     =     WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_ADDRESS_BOOK);
                                $AddressbookURL             =     WebPageManager::obj()->buildUrl($arrAddressBookPageInfo,$virtual_path['USER_ACCOUNT_RW_URL']);

                                AjaxResponse::obj()->redirect($AddressbookURL, 1);
                            }
                            else
                                AjaxResponse::obj()->error('Sorry there are some error occured. Please try again later.');
                		}
                    break;

                    case 'Remove':
                        $address_id     = Ocrypt::dec($_POST['address_id']);
                        $user_id        = Ocrypt::dec($_POST['user_id']);

                        $AddressInfo    = UserAddressBook::obj()->getInfoById($address_id);

                        $affected       = UserAddressBook::obj()->DeleteAddress($address_id,$user_id);
                        
                        UserLog::obj()->AddUserActionLog(ULOG_ACTION_DELETEADDRESSBOOK, $AddressInfo, UserMaster::obj()->ID, $affected, false,false);

                        if(is_numeric($affected))
                        {
                            //AjaxResponse::obj()->script('RemoveAddress("'.$_POST['address_id'].'");');
                            AjaxResponse::obj()->set_data('ref_id','address_id');
                            AjaxResponse::obj()->success('Your address has been removed successfully.');

                            $arrAddressBookPageInfo     =     WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_ADDRESS_BOOK);
                            $AddressbookURL             =     WebPageManager::obj()->buildUrl($arrAddressBookPageInfo,$virtual_path['USER_ACCOUNT_RW_URL']);

                            AjaxResponse::obj()->redirect($AddressbookURL, 1);
                        }
                        else
            			     AjaxResponse::obj()->error('Sorry there are some error occured. Please try again later.');
                    break;
                }
            break;

            case 'Dispute':
                # Switch through module's action
                switch(AjaxResponse::obj()->XHR_ACTION)
                {
                    case 'AddComment':

                        if(!is_numeric($_POST[DisputeMaster::obj()->Data[F_P_KEY]]))
                            $_POST[DisputeMaster::obj()->Data[F_P_KEY]] = DisputeMaster::obj()->EncodeDecodeDisputeId('D',$_POST[DisputeMaster::obj()->Data[F_P_KEY]]);

                        if(isset($_POST[DisputeMaster::obj()->Data[F_P_KEY]]) && is_numeric($_POST[DisputeMaster::obj()->Data[F_P_KEY]]))
                        {
                            # Set post for dispute status history
                            $_POST['status_id']    = DISPUTE_STATUS_PROCESSING;

                            DisputeStatusHistory::obj()->populateSchema();

                            $id = DisputeStatusHistory::obj()->_Insert($_POST);
                            UserLog::obj()->AddUserActionLog(ULOG_ACTION_ADDSTATUSCOMMENT,$_POST,UserMaster::obj()->ID,false,false,false);

                            if(is_numeric($id))
                            {
                                AjaxResponse::obj()->success('Your comment has been posted successfully.');
                                AjaxResponse::obj()->redirect(AjaxResponse::obj()->XHR_URL,1);
                            }
                            else
                			     AjaxResponse::obj()->error('Sorry there are some error occured. Please try again later.');
                		}
                    break;

                    /*case 'Create':

                        if(isset($_POST[UserMaster::obj()->Data[F_P_KEY]]) && !is_numeric($_POST[UserMaster::obj()->Data[F_P_KEY]]))
                            $_POST[UserMaster::obj()->Data[F_P_KEY]] = Ocrypt::dec($_POST[UserMaster::obj()->Data[F_P_KEY]]);

                        if(isset($_POST[UserMaster::obj()->Data[F_P_KEY]]) && is_numeric($_POST[UserMaster::obj()->Data[F_P_KEY]]))
                        {
                            DisputeMaster::obj()->populateSchema();

                            $id = DisputeMaster::obj()->_Insert($_POST);

                            UserLog::obj()->AddUserActionLog(ULOG_ACTION_CREATEDISPUTE,$_POST,UserMaster::obj()->ID,false,false,false);

                            if(is_numeric($id))
                            {
                                $arrDisputePageInfo     =   WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_MY_DISPUTE);
                                $DisputeURL             =   WebPageManager::obj()->buildUrl($arrDisputePageInfo,$virtual_path['USER_ACCOUNT_RW_URL']);

                                AjaxResponse::obj()->script("jQuery('#my-dispute-form').trigger('reset');");
                                AjaxResponse::obj()->success('Sorry, there are some error occured. Please try again later.');
                                AjaxResponse::obj()->redirect($DisputeURL,1);
                            }
                            else
                                AjaxResponse::obj()->error('Sorry there are some error occured. Please try again later.');
                        }
                    break;*/
                }
            break;
            case 'UOrder':
                switch(AjaxResponse::obj()->XHR_ACTION)
                {
                    case 'Cancel':
                        $order_id     = Ocrypt::dec($_POST['ref_id']);

                        OrderStatusHistory::obj(true);

                        # OrderStatusHistory : Set POST for order history
                    	$POST = array(
                    		'order_id'              =>      $order_id,
                    		'ordstatus_id'          =>      ORDER_STATUS_CANCELLED,
                    		'comment'               =>      'Order has been cancelled by customer.',
                    		'customer_notified'     =>      YES,
                    		'added_datetime'        =>      date('Y-m-d H:i:s'),
                    	);

                        # Insert order status details
                    	$oshistory_id = OrderStatusHistory::obj()->Insert($POST);

                        if(is_numeric($oshistory_id))
                        {
                            AjaxResponse::obj()->success("Successfully Cancelled Your Order.");
                            //$objResponse->redirect('',1);
                        }
                        else
            			     AjaxResponse::obj()->error("Sorry there are some error occured. Please try again later.");
                    break;
                    #####################################################################
                    # This code is now not used any where so not changed in Last_Order_ID => Last_Order_Batch_ID
                    #####################################################################
                    case 'PayNow':
                        $order_id       = OrderMaster::obj()->EncodeDecodeOrderId('D',$_POST['ref_id']);
                        $pgateway_id    = Ocrypt::dec($_POST['pgateway_id']);
                        if(is_numeric($order_id) && is_numeric($pgateway_id))
                        {
                            $PaymentGatewayFullInfo = APIGateway::obj()->GetAPIGatewayFullInfoByGatewayID($pgateway_id);

                            $PayInfo = APIGateway::obj()->ShoppingCartPaymentGatewaySetup($order_id, $PaymentGatewayFullInfo);
                            switch($pgateway_id)
                            {
                                case APIGATEWAY_ID_INSTAMOJO :
                                    if(isset($PayInfo['instamojo_payment_url']))
                                    {
                                        # Update payment gateway id
                                        OrderMaster::obj()->UpdateOrderPaymentGateway($order_id, APIGATEWAY_ID_INSTAMOJO);

                                        # Set cart so response will be shown proper
                                        $Cart = array(CART_SHOPPING_STEP => 6, 'Last_Order_ID' =>  OrderMaster::obj()->EncodeDecodeOrderId('E',$order_id));
                                        Cart::obj()->SetCurrentCart(CART_KEY_ONLINESHOPPING);
                                        Cart::obj()->UpdateCartItems($Cart,true);
                                        Cart::obj()->SaveCart();

                                        AjaxResponse::obj()->redirect($PayInfo['instamojo_payment_url']);
                                    }
                                break;

                                case APIGATEWAY_ID_PAYPAL :
                                    if(isset($PayInfo['paypal_payment_url']))
                                    {
                                        # Update payment gateway id
                                        OrderMaster::obj()->UpdateOrderPaymentGateway($order_id, APIGATEWAY_ID_PAYPAL);

                                        # Set cart so response will be shown proper
                                        $Cart = array(CART_SHOPPING_STEP => 6, 'Last_Order_ID' =>  OrderMaster::obj()->EncodeDecodeOrderId('E',$order_id));
                                        Cart::obj()->SetCurrentCart(CART_KEY_ONLINESHOPPING);
                                        Cart::obj()->UpdateCartItems($Cart,true);
                                        Cart::obj()->SaveCart();

                                        AjaxResponse::obj()->redirect($PayInfo['paypal_payment_url']);
                                    }
                                break;

                                default :
                                    AjaxResponse::obj()->error("Unable to generate payment URL for order ".$order_id);

                            }
                            /*if(isset($PayInfo['instamojo_payment_url']))
                            {
                                # Update payment gateway id
                                OrderMaster::obj()->UpdateOrderPaymentGateway($order_id, APIGATEWAY_ID_INSTAMOJO);

                                # Set cart so response will be shown proper
                                $Cart = array(CART_SHOPPING_STEP => 6, 'Last_Order_ID' =>  OrderMaster::obj()->EncodeDecodeOrderId('E',$order_id));
                                Cart::obj()->SetCurrentCart(CART_KEY_ONLINESHOPPING);
                                Cart::obj()->UpdateCartItems($Cart,true);
                                Cart::obj()->SaveCart();

                                AjaxResponse::obj()->redirect($PayInfo['instamojo_payment_url']);
                            }
                            elseif(isset($PayInfo['paypal_payment_url']))
                            {
                                # Update payment gateway id
                                OrderMaster::obj()->UpdateOrderPaymentGateway($order_id, APIGATEWAY_ID_PAYPAL);

                                # Set cart so response will be shown proper
                                $Cart = array(CART_SHOPPING_STEP => 6, 'Last_Order_ID' =>  OrderMaster::obj()->EncodeDecodeOrderId('E',$order_id));
                                Cart::obj()->SetCurrentCart(CART_KEY_ONLINESHOPPING);
                                Cart::obj()->UpdateCartItems($Cart,true);
                                Cart::obj()->SaveCart();

                                AjaxResponse::obj()->redirect($PayInfo['paypal_payment_url']);
                            }
                            else
                            {
                                AjaxResponse::obj()->error("Unable to generate payment URL for order ".$order_id);
                            }*/
                        }
                        else
                        {
                            AjaxResponse::obj()->error("Not valid order id ".$order_id);
                        }
                    break;
                }
            break;

        }
    }
    function ULP()
    {
        global $config, $asset, $physical_path, $virtual_path;

        # Switch through module
        switch(AjaxResponse::obj()->XHR_MODULE)
        {
            case 'Load':
                $intention = $_POST['intention'];

                # Switch through module's action
                switch(AjaxResponse::obj()->XHR_ACTION)
                {
                    case 'WList':
                        # Get param for load
                    	$FILTER = UserWishlist::obj(true)->setQueryParameters($_POST);

                    	# Get product information based on set filter
                    	$rsWL    =   UserWishlist::obj()->_ViewAll_WebSite($FILTER);


                    	# Check for correct page number, If wrong then change page no and record limit
                   	    if(isset($FILTER['last_record_num']) && $FILTER['last_record_num'] > UserWishlist::obj()->total_record)
                    	{
                    		$total_pages = ceil(UserWishlist::obj()->total_record/RESULT_PAGESIZE);

                    		if($total_pages <= $FILTER[GO_TO_PAGE])
                    		{
                    			$FILTER[GO_TO_PAGE]          =   0;
                    			$FILTER[S_RECORD]            =   0;
                    			$FILTER['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
                    		}
                    		else
                    		{
                    			$FILTER['last_record_num']   =   UserWishlist::obj()->total_record;
                    		}
                    	}

                        st::$obj->assign(array(
                            "arrParams"             =>  $FILTER,
                            'URL_FILTER'            =>  $_POST,
                            'rsURVWL'               =>  $rsWL,
                            'last_record_num'       =>  $FILTER['last_record_num'],
                            'total_record'          =>  UserWishlist::obj()->total_record,
                            "IsLastRecord"          =>  (($FILTER['last_record_num'] >= UserWishlist::obj()->total_record)?true:false),
                            'ProductImg_ENC_V_UP'   =>  ProductImages::obj()->Data['ENC_V_UP'],
                            'ProductImg_IMG_RW_URL' =>  ProductImages::obj()->Data[IMG_RW_URL],
                            'IsWishlist'            =>  true,
                         ));

                    	if(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_APPEND)
                    	{
                    		AjaxResponse::obj()->append(st::$obj->fetch('tpl_urvwl/u-lp-rv-wl'.$config[TPL_EX]),$_POST['s_result_div']);
                    	}

                        # Check for last record if found
                    	if($FILTER['last_record_num'] >= UserWishlist::obj()->total_record || (isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN))
                    	{
                    		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_urvwl/u-loading-btnmsg'. $config[TPL_EX]),$_POST['s_lbm_div']);
                    	}

                    	# Some manipulation based on intention of data load
                    	if($intention == 'scroll')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                            $p[0] = rtrim($p[0],'/');

                    		if(isset($p[1]))
                    			$p[1] = ltrim(strstr(ltrim($p[1],'/'),'/'),'/');

                    		$weburl = $p[0]."/".GO_TO_PAGE."/".$_POST[GO_TO_PAGE]."/".(isset($p[1])?$p[1]:'');
                    	}
                    	elseif($intention == 'sosd')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                    		$p[0] = rtrim($p[0],'/');

                    		$url = Utility::SetURLParam($_POST, UserWishlist::obj()->Data['LP_S_CRITERIA']);

                    		$weburl = $p[0]."/".$url;
                    	}
                    	else
                    	{
                    		$url = Utility::SetURLParam($_POST, UserWishlist::obj()->Data['LP_S_PARAMS']);
                    		$weburl = $virtual_path['Main_Host_Url'].URLSEPARATOR_BACKSLASH.SU_ER_LISTING_PAGE.URLSEPARATOR_BACKSLASH.$url;
                    	}
                    	AjaxResponse::obj()->set_data('weburl',$weburl);
                    	AjaxResponse::obj()->set_data('t_record',(string) UserWishlist::obj()->total_record);
                        break;

                    case 'RVisited':
                        # Get param for load
                    	$FILTER = UserRecentlyVisitedProduct::obj(true)->setQueryParameters($_POST);

                    	# Get product information based on set filter
                    	$rsURV    =   UserRecentlyVisitedProduct::obj()->_ViewAll_WebSite($FILTER);

                    	# Check for correct page number, If wrong then change page no and record limit
                   	    if(isset($FILTER['last_record_num']) && $FILTER['last_record_num'] > UserRecentlyVisitedProduct::obj()->total_record)
                    	{
                            $total_pages = ceil(UserRecentlyVisitedProduct::obj()->total_record/RESULT_PAGESIZE);

                    		if($total_pages <= $FILTER[GO_TO_PAGE])
                    		{
                    			$FILTER[GO_TO_PAGE]          =   0;
                    			$FILTER[S_RECORD]            =   0;
                    			$FILTER['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
                    		}
                    		else
                    		{
                    			$FILTER['last_record_num']   =   UserRecentlyVisitedProduct::obj()->total_record;
                    		}
                    	}

                        st::$obj->assign(array(
                            "arrParams"             =>  $FILTER,
                            'URL_FILTER'            =>  $_POST,
                            'rsURVWL'               =>  $rsURV,
                            'last_record_num'       =>  $FILTER['last_record_num'],
                            'total_record'          =>  UserRecentlyVisitedProduct::obj()->total_record,
                            "IsLastRecord"          =>  (($FILTER['last_record_num'] >= UserRecentlyVisitedProduct::obj()->total_record)?true:false),
                            'ProductImg_ENC_V_UP'   =>  ProductImages::obj()->Data['ENC_V_UP'],
                            'ProductImg_IMG_RW_URL' =>  ProductImages::obj()->Data[IMG_RW_URL],
                         ));

                    	if(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_APPEND)
                    	{
                    		AjaxResponse::obj()->append(st::$obj->fetch('tpl_urvwl/u-lp-rv-wl'.$config[TPL_EX]),$_POST['s_result_div']);
                    	}

                        # Check for last record if found
                    	if($FILTER['last_record_num'] >= UserRecentlyVisitedProduct::obj()->total_record || (isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN))
                    	{
                    		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_urvwl/u-loading-btnmsg'. $config[TPL_EX]),$_POST['s_lbm_div']);
                    	}

                    	# Some manipulation based on intention of data load
                    	if($intention == 'scroll')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                            $p[0] = rtrim($p[0],'/');

                    		if(isset($p[1]))
                    			$p[1] = ltrim(strstr(ltrim($p[1],'/'),'/'),'/');

                    		$weburl = $p[0]."/".GO_TO_PAGE."/".$_POST[GO_TO_PAGE]."/".(isset($p[1])?$p[1]:'');
                    	}
                    	elseif($intention == 'sosd')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                    		$p[0] = rtrim($p[0],'/');

                    		$url = Utility::SetURLParam($_POST, UserRecentlyVisitedProduct::obj()->Data['LP_S_CRITERIA']);

                    		$weburl = $p[0]."/".$url;
                    	}
                    	else
                    	{
                    		$url = Utility::SetURLParam($_POST, UserRecentlyVisitedProduct::obj()->Data['LP_S_PARAMS']);
                    		$weburl = $virtual_path['Main_Host_Url'].URLSEPARATOR_BACKSLASH.SU_ER_LISTING_PAGE.URLSEPARATOR_BACKSLASH.$url;
                    	}
                    	AjaxResponse::obj()->set_data('weburl',$weburl);
                    	AjaxResponse::obj()->set_data('t_record',(string) UserRecentlyVisitedProduct::obj()->total_record);
                    break;

                    case 'UABList':
                        # Get param for load
                    	$FILTER    =   UserAddressBook::obj(true)->setQueryParameters($_POST);

                        $CUR_WP    =   WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_ADDRESS_BOOK);

                    	# Get product information based on set filter
                    	$rsUAB     =   UserAddressBook::obj()->_ViewAll_WebSite($FILTER);

                    	# Check for correct page number, If wrong then change page no and record limit
                   	    if(isset($FILTER['last_record_num']) && $FILTER['last_record_num'] > UserAddressBook::obj()->total_record)
                    	{
                    		$total_pages = ceil(UserAddressBook::obj()->total_record/RESULT_PAGESIZE);

                    		if($total_pages <= $FILTER[GO_TO_PAGE])
                    		{
                    			$FILTER[GO_TO_PAGE]          =   0;
                    			$FILTER[S_RECORD]            =   0;
                    			$FILTER['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
                    		}
                    		else
                    			$FILTER['last_record_num']   =   UserAddressBook::obj()->total_record;
                    	}

                        st::$obj->assign(array(
                            "CUR_WP"                =>	$CUR_WP,
                            "arrParams"             =>  $FILTER,
                            'URL_FILTER'            =>  $_POST,
                            'rsUAB'                 =>  $rsUAB,
                            'total_record'          =>  UserAddressBook::obj()->total_record,
                            'UserAccountRW_URL'     =>  $virtual_path['USER_ACCOUNT_RW_URL'],
                            "IsLastRecord"          =>  (($FILTER['last_record_num'] >= UserAddressBook::obj()->total_record)?true:false),
                         ));

                    	if(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_APPEND)
                    	{
                    		AjaxResponse::obj()->append(st::$obj->fetch('tpl_uab/uab-listing-view'.$config[TPL_EX]),$_POST['s_result_div']);
                    	}

                        # Check for last record if found
                    	if($FILTER['last_record_num'] >= UserAddressBook::obj()->total_record || (isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN))
                    	{
                    		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_uab/uab-loading-btnmsg'. $config[TPL_EX]),$_POST['s_lbm_div']);
                    	}

                    	# Some manipulation based on intention of data load
                    	if($intention == 'scroll')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                            $p[0] = rtrim($p[0],'/');

                    		if(isset($p[1]))
                    			$p[1] = ltrim(strstr(ltrim($p[1],'/'),'/'),'/');

                    		$weburl = $p[0]."/".GO_TO_PAGE."/".$_POST[GO_TO_PAGE]."/".(isset($p[1])?$p[1]:'');
                    	}
                    	elseif($intention == 'sosd')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                    		$p[0] = rtrim($p[0],'/');

                    		$url = Utility::SetURLParam($_POST, UserAddressBook::obj()->Data['LP_S_CRITERIA']);

                    		$weburl = $p[0]."/".$url;
                    	}
                    	else
                    	{
                    		$url = Utility::SetURLParam($_POST, UserAddressBook::obj()->Data['LP_S_PARAMS']);
                    		$weburl = $virtual_path['Main_Host_Url'].URLSEPARATOR_BACKSLASH.SU_ER_LISTING_PAGE.URLSEPARATOR_BACKSLASH.$url;
                    	}
                    	AjaxResponse::obj()->set_data('weburl',$weburl);
                    	AjaxResponse::obj()->set_data('t_record',(string) UserAddressBook::obj()->total_record);

                        /*if($rsUAB->TotalRow > 0)
                            AjaxResponse::obj()->script("BindAddressBookRemoveButton();");*/
                    break;

                        case 'UDList':
                        # Get param for load
                    	$FILTER    =   DisputeMaster::obj(true)->setQueryParameters($_POST);

                        $CUR_WP    =   WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_MY_DISPUTE);

                    	# Get product information based on set filter
                    	$rsUD     =   DisputeMaster::obj()->_ViewAll_WebSite($FILTER);

                    	# Check for correct page number, If wrong then change page no and record limit
                   	    if(isset($FILTER['last_record_num']) && $FILTER['last_record_num'] > DisputeMaster::obj()->total_record)
                    	{
                    		$total_pages = ceil(DisputeMaster::obj()->total_record/RESULT_PAGESIZE);

                    		if($total_pages <= $FILTER[GO_TO_PAGE])
                    		{
                    			$FILTER[GO_TO_PAGE]          =   0;
                    			$FILTER[S_RECORD]            =   0;
                    			$FILTER['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
                    		}
                    		else
                    			$FILTER['last_record_num']   =   DisputeMaster::obj()->total_record;
                    	}

                        st::$obj->assign(array(
                            "CUR_WP"                =>	$CUR_WP,
                            "arrParams"             =>  $FILTER,
                            'URL_FILTER'            =>  $_POST,
                            'rsUD'                   =>  $rsUD,
                            'total_record'          =>  DisputeMaster::obj()->total_record,
                            'UserAccountRW_URL'     =>  $virtual_path['USER_ACCOUNT_RW_URL'],
                            "IsLastRecord"          =>  (($FILTER['last_record_num'] >= DisputeMaster::obj()->total_record)?true:false),
                            'arr_DisputeStatus'     =>  $asset['OL_Dispute_Status_Type'],
                         ));

                    	if(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_APPEND)
                    	{
                    		AjaxResponse::obj()->append(st::$obj->fetch('tpl_ud/ud-listing-view'.$config[TPL_EX]),$_POST['s_result_div']);
                    	}

                        # Check for last record if found
                    	if($FILTER['last_record_num'] >= DisputeMaster::obj()->total_record || (isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN))
                    	{
                    		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_ud/ud-loading-btnmsg'. $config[TPL_EX]),$_POST['s_lbm_div']);
                    	}

                    	# Some manipulation based on intention of data load
                    	if($intention == 'scroll')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                            $p[0] = rtrim($p[0],'/');

                    		if(isset($p[1]))
                    			$p[1] = ltrim(strstr(ltrim($p[1],'/'),'/'),'/');

                    		$weburl = $p[0]."/".GO_TO_PAGE."/".$_POST[GO_TO_PAGE]."/".(isset($p[1])?$p[1]:'');
                    	}
                    	elseif($intention == 'sosd')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                    		$p[0] = rtrim($p[0],'/');

                    		$url = Utility::SetURLParam($_POST, DisputeMaster::obj()->Data['LP_S_CRITERIA']);

                    		$weburl = $p[0]."/".$url;
                    	}
                    	else
                    	{
                    		$url = Utility::SetURLParam($_POST, DisputeMaster::obj()->Data['LP_S_PARAMS']);
                    		$weburl = $virtual_path['Main_Host_Url'].URLSEPARATOR_BACKSLASH.SU_ER_LISTING_PAGE.URLSEPARATOR_BACKSLASH.$url;
                    	}
                    	AjaxResponse::obj()->set_data('weburl',$weburl);
                    	AjaxResponse::obj()->set_data('t_record',(string) DisputeMaster::obj()->total_record);

                    break;

                    case 'UOList':
                        # Get param for load
                    	$FILTER    =   OrderMaster::obj(true)->setQueryParameters($_POST,false);

                        $CUR_WP    =   WebPageManager::obj()->getInfoById(PAGE_MANAGER_ID_MY_ORDER);

                    	# Get product information based on set filter
                    	$rsUO     =   OrderMaster::obj()->getUserOrder($FILTER);

                    	# Check for correct page number, If wrong then change page no and record limit
                   	    if(isset($FILTER['last_record_num']) && $FILTER['last_record_num'] > OrderMaster::obj()->total_record)
                    	{
                    		$total_pages = ceil(OrderMaster::obj()->total_record/RESULT_PAGESIZE);

                    		if($total_pages <= $FILTER[GO_TO_PAGE])
                    		{
                    			$FILTER[GO_TO_PAGE]          =   0;
                    			$FILTER[S_RECORD]            =   0;
                    			$FILTER['last_record_num']   =   (($_POST[GO_TO_PAGE]+1) * $_POST[P_SIZE]);
                    		}
                    		else
                    			$FILTER['last_record_num']   =   OrderMaster::obj()->total_record;
                    	}

                        st::$obj->assign(array(
                            "CUR_WP"                =>	$CUR_WP,
                            "arrParams"             =>  $FILTER,
                            'URL_FILTER'            =>  $_POST,
                            'rsUO'                   =>  $rsUO,
                            'total_record'          =>  OrderMaster::obj()->total_record,
                            'UserAccountRW_URL'     =>  $virtual_path['USER_ACCOUNT_RW_URL'],
                            "IsLastRecord"          =>  (($FILTER['last_record_num'] >= OrderMaster::obj()->total_record)?true:false),
                            'OL_Payment_Status_Type'=>  $asset['OL_Payment_Status_Type'],
                            'OL_Order_Status_Type'  =>  $asset['OL_Order_Status_Type'],
                            'arrPaygateway'         =>  APIGateway::obj()->_getKeyValueArray(APIGATEWAY_TYPE_PAYMENT,false),

                         ));

                    	if(isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_APPEND)
                    	{
                    		AjaxResponse::obj()->append(st::$obj->fetch('tpl_uo/uo-listing-view'.$config[TPL_EX]),$_POST['s_result_div']);
                    	}

                        # Check for last record if found
                    	if($FILTER['last_record_num'] >= OrderMaster::obj()->total_record || (isset($_POST['load_type']) && $_POST['load_type'] == RESULT_LOAD_TYPE_ASSIGN))
                    	{
                    		AjaxResponse::obj()->assign(st::$obj->fetch('tpl_uo/uo-loading-btnmsg'. $config[TPL_EX]),$_POST['s_lbm_div']);
                    	}

                    	# Some manipulation based on intention of data load
                    	if($intention == 'scroll')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                            $p[0] = rtrim($p[0],'/');

                    		if(isset($p[1]))
                    			$p[1] = ltrim(strstr(ltrim($p[1],'/'),'/'),'/');

                    		$weburl = $p[0]."/".GO_TO_PAGE."/".$_POST[GO_TO_PAGE]."/".(isset($p[1])?$p[1]:'');
                    	}
                    	elseif($intention == 'sosd')
                    	{
                    		$p = explode('/'.GO_TO_PAGE.'/',AjaxResponse::obj()->XHR_URL);
                    		$p[0] = rtrim($p[0],'/');

                    		$url = Utility::SetURLParam($_POST, OrderMaster::obj()->Data['LP_S_CRITERIA']);

                    		$weburl = $p[0]."/".$url;
                    	}
                    	else
                    	{
                    		$url = Utility::SetURLParam($_POST, OrderMaster::obj()->Data['LP_S_PARAMS']);
                    		$weburl = $virtual_path['Main_Host_Url'].URLSEPARATOR_BACKSLASH.SU_ER_LISTING_PAGE.URLSEPARATOR_BACKSLASH.$url;
                    	}
                    	AjaxResponse::obj()->set_data('weburl',$weburl);
                    	AjaxResponse::obj()->set_data('t_record',(string) OrderMaster::obj()->total_record);

                    break;
                }
            break;
        }
    }
}
AjaxResponse::obj()->call_request_area();
AjaxResponse::obj()->send();
?>