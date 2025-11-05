<?php
/**
 * @file: admin-zone/user-master.php
 */
define('IN_ADMIN', true);

define('SECTION_KEY','UserMngt');
define('MODULE_KEY', 'UserMaster');

if((isset($_GET['popup']) && $_GET['popup']=='true') || (isset($_GET['Action']) && ($_GET['Action']=='View' || $_GET['Action']=='ChangeUserPassword')))
    define('POPUP_WIN',	true);

$Action = isset($_POST['Action'])?$_POST['Action']:(isset($_GET['Action'])?$_GET['Action']:'ShowAll');

require_once('../includes/common.php');
require_once($physical_path['Libs']. '/thumbnail.php');

$UM = isset($_GET['UM'])?Ocrypt::dec($_GET['UM']):'';

UserMaster::obj(true);
UserMaster::obj()->Data[C_COMMAND_LIST] = AuthUser::obj()->getUserPermission(SECTION_KEY,MODULE_KEY);

$file_name = UserMaster::obj()->Data['ScriptName'];

//$file_name = UserMaster::obj()->UM_PadControllerUrl($file_name);

$msgSuccess=''; $msgError='';

GeoCountry::obj(true);
GeoState::obj(true);

/* Decode Post Data */
Ocrypt::DecodeGlobal();

# Set auth connet type in post to set connected from web
if(isset($_POST) && count($_POST) > 0 && $Action == A_ADD || $Action== A_EDIT || $Action== A_USER_ACT_PROFILE)
    $_POST['connect_using'] = SIGNUP_USING_WEBSITE;

if(isset($_POST['ChangePassword']) && $_POST['ChangePassword'] == 'ChangePassword')
{
    if(AuthUser::obj()->ChangePassword($AuthID,$_POST) == true)
	{
		header("location: $file_name?update=true");
		exit();
	}
	else
		$msgError = AuthUser::obj()->Error[E_DESC];
}

/**RESPONSE PROCESSING CODE**/
UserMaster::Obj()->BasicResponseProcess($Action,$_POST,$file_name,UserMaster::Obj());

/**RESPONSE CREATING CODE**/
if(!in_array($Action,UserMaster::Obj()->Data[C_COMMAND_LIST]))
{
    Utility::obj()->SetReqProcessAlertMsg(UserMaster::Obj()->Data[L_MODULE]);
    UserMaster::obj()->ReadFilter(MODULE_KEY);

    if(isset($_GET['update']) && $_GET['update'] == 'true')
	   $msgSuccess = "Your password has been changed successfully.";

    st::$obj->assign(array(
            'includeFile'           =>  'layout/list'.$config[TPL_EX],
            'A_Action'              =>  $file_name,
            'Action'                =>  $Action,
            'CustomRecordActionFile'=>  'craf-user-master'.$config[TPL_EX],
            'MassAction'            =>  true,
            
            'SidebarKis'            =>  'sidebarkis-user-menu'. $config[TPL_EX],
            'SidebarLeft'           =>  'default-search-form'. $config[TPL_EX],
            'SearchFormFile'        =>  'sf-user-master'. $config[TPL_EX],
            'QuickSearch'           =>  true,
            
            'FieldSortSelection'    =>  true,
            'Pagination'            =>  true,
            'PageSize'		        =>	$asset['OL_PageSize'],
            'arr_YesNo'             =>  array_merge(array("0" => 'All'),$asset['OL_YesNo']),
            'arr_ocoin'             =>  $asset['OL_Ocoin_Type'],
            'arrconnect_by'         =>  $asset['OL_Signup_Using'],
            
            'FieldSelectionSort'    =>  true,
            'UserCurrentStatus'     =>  $asset['User_Current_Status'],
            F_ACTIVE                =>  UserMaster::obj()->Data[F_ACTIVE],
            F_VIRTUAL_DELETE        =>  UserMaster::obj()->Data[F_VIRTUAL_DELETE],
            'P_Upload_Root'         =>	UserMaster::obj()->Data[P_UP],
            'V_Upload_Root'	        =>	UserMaster::obj()->Data[V_UP],
            'Img_RW_Url'            =>  UserMaster::obj()->Data[IMG_RW_URL],
            FIELD_PREFIX            =>  UserMaster::Obj()->Data[FIELD_PREFIX],
            C_COMMAND_LIST          =>  UserMaster::Obj()->Data[C_COMMAND_LIST],
            F_P_KEY                 =>  UserMaster::Obj()->Data[F_P_KEY],
            'ModuleTitle'           =>  UserMaster::Obj()->Data[L_MODULE],
            'HelpText'              =>  UserMaster::Obj()->Data[H_MANAGE],
            F_H_ITEM                =>  UserMaster::Obj()->Data[F_H_ITEM],
            'R_RecordSet'           =>  UserMaster::Obj()->_ViewAll(),
            'Filter'		        =>  UserMaster::obj()->filter,
            'FilterData'	        =>  UserMaster::obj()->getSearchFilter(),
            'total_record'          =>  UserMaster::Obj()->total_record,
            //'arr_country'           =>    GeoCountry::obj()->getKeyValueArray(),
            'arr_Status'            =>  $asset['OL_User_Current_Status_Search'],
            'arrmobile_code'        =>  GeoCountry::obj()->getAllMobileCode(),
            'arrTotalOnlineUser'    =>  SessionMaster::obj()->getTotalOnlineUserCount(),
            "jFancyBox2"            =>  true,
            
    ));

    $css_files  =   array_merge($css_files, array('table','jfancybox2','auto-suggestion','bst-datetimepicker','sidebar-left','sidebar-kis','pagination'));
    $js_files   =   array_merge($js_files, array('jsieve','jfancybox2','bst-datetimepicker','sidebar-left','sidebar-kis','jmaskedinput','auto-suggestion','jgeolocationselection','list','search-filter','user-info','country-state-city-auto-suggestion'));
}
elseif($Action == A_ADD || $Action== A_USER_ACT_PROFILE)
{
    if(isset($_GET['save-pass']) && $_GET['save-pass'] == true)
        $msgSuccess = "Password has been changed.";
    elseif(isset($_GET['add-auth-con']) && $_GET['add-auth-con']=='true')
        $msgSuccess = "Succsessfully added record in auth connect.";
    elseif(isset($_GET['add-auth-con']) && $_GET['add-auth-con']=='false')
        $msgError = "Sorry, this record is already inserted in auth connect with this connect type";

    $PK = isset($_GET['pk'])?$_GET['pk']:(isset($_POST['pk'])?$_POST['pk']:'');

    //UserMaster::obj()->Data[F_F_INFO]['country_id'][OPTION]=GeoCountry::obj()->getKeyValueArray();
    UserMaster::obj()->Data[F_F_INFO][LeadSource::obj()->Data[F_P_KEY]][OPTION]    =   LeadSource::obj()->getKeyValueArray();
    UserMaster::obj()->Data[F_F_INFO]['mobile_ccode'][OPTION]   =   GeoCountry::obj()->getAllMobileCode();
    
    UserMaster::obj()->C_CommandList_UserInfo();
    
    if($Action == A_USER_ACT_PROFILE)
	{
		$user_info    =   UserMaster::obj()->getInfoById($PK);

        if(!empty($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'image_file']))
            UserMaster::obj()->setUserId($PK);

        //UserMaster::obj()->Data[F_F_INFO]['state'][OPTION] =   GeoState::obj()->getKeyValueArray($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'country'],true);
        //UserMaster::obj()->Data[F_F_INFO]['city'][OPTION] =   GeoCity::obj()->getKeyValueArray($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'state'],true);
        UserMaster::obj()->getEditFieldInfo($user_info, UserMaster::obj()->Data[F_F_INFO]);

        $Breadcrumbs    =   explode('&raquo;',Utility::obj()->Breadcrumbs());
        $Breadcrumbs[2] .=  ' - '.$user_info[UserMaster::obj()->Data[F_P_FIELD]].' '.$user_info[UserMaster::obj()->Data[FIELD_PREFIX].'lastname'];
        $Breadcrumbs[3] = "Profile";
        $Breadcrumbs    =   implode(' &raquo; ',$Breadcrumbs);

        st::$obj->assign(array(
		        'Username'          =>  $user_info[UserMaster::obj()->Data[FIELD_PREFIX].'email'],
		        'SidebarLeft'       =>  'reset-user-password'. $config[TPL_EX],
                'Breadcrumbs'       =>	$Breadcrumbs,
		        'AddTitle'          =>  UserMaster::obj()->Data[H_ADD_EDIT],
                'ModuleTitle'       =>	UserMaster::obj()->Data[L_MODULE],
                'arrconnect_by'     =>  $asset['OL_Signup_Using'],
        ));
    }
    if($Action == A_ADD)
    {
              st::$obj->assign(array(   'P_Upload_Root' =>	UserMaster::obj()->Data[P_UP],
                                        'V_Upload_Root' =>	UserMaster::obj()->Data[V_UP],
                            ));
    }
    //Utility::pre(UserMaster::obj()->Data[F_F_INFO]);
    st::$obj->assign(array( 
            'includeFile'           =>  'layout/html-form'.$config[TPL_EX],
            'SidebarKis'            =>  'tpl_webuser/webuser-info-right-sidebar'. $config[TPL_EX],
            'ExtraFormFileAfter'    =>  'extffafter-user-master'. $config[TPL_EX],
            'A_Action'              =>  $file_name,
            'Action'                =>	$Action,
            'ModuleTitle'           =>	UserMaster::obj()->Data[L_MODULE],
            'HelpText'              =>	UserMaster::obj()->Data[H_MANAGE],
            F_F_INFO                =>	UserMaster::obj()->Data[F_F_INFO],
            'PK'				    =>	$PK,
            'User_Id'				=>	$PK,
            C_COMMAND_LIST          =>  UserMaster::obj()->Data[C_COMMAND_LIST],
            'C_CommandList_UserInfo'=>  UserMaster::obj()->Data['C_CommandList_UserInfo'],
            'P_Upload_Root'         =>  UserMaster::obj()->Data[P_UP],
            'V_Upload_Root'         =>  UserMaster::obj()->Data[V_UP],
            
    ));
    $css_files  =   array_merge($css_files, array('jfancybox2','bst-datetimepicker','bst-switch','sidebar-left','auto-suggestion','sidebar-kis','pagination'));
    $js_files   =   array_merge($js_files, array('jfancybox2','bst-datetimepicker','bst-switch','jformvalidator','auto-suggestion','sidebar-kis','jgeolocationselection','sidebar-left','jmaskedinput','html_form','country-state-city-auto-suggestion','user-info'));
}
elseif($Action == A_VIEW)
{
    $PK = isset($_GET['pk'])?$_GET['pk']:'';
    $user_info    =   UserMaster::obj()->getInfoById($PK);
    
    UserMaster::Obj()->getEditFieldInfo(UserMaster::Obj()->getInfoById($PK),UserMaster::Obj()->Data[F_F_INFO],$Action);
    UserMaster::obj()->Data[F_F_INFO][LeadSource::obj()->Data[F_P_KEY]][OPTION]=LeadSource::obj()->getKeyValueArray();

    UserMaster::obj()->Data[F_F_INFO]['country'][OPTION] =   GeoCountry::obj()->getKeyValueArray();
    UserMaster::obj()->Data[F_F_INFO]['state'][OPTION] =   GeoState::obj()->_getKeyValueArray($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'country'],true);
    UserMaster::obj()->Data[F_F_INFO]['city'][OPTION] =   GeoCity::obj()->_getKeyValueArray($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'state'],true);
    
    UserMaster::obj()->Data[F_F_INFO]['mobile_ccode'][OPTION]   =   GeoCountry::obj()->getAllMobileCode();
    
    st::$obj->assign(array(
            'includeFile'           =>          'layout/view'.$config[TPL_EX],
            'A_Action'              =>          $file_name,
            "Action"                =>          $Action,
            'ModuleTitle'           =>          UserMaster::Obj()->Data[L_MODULE],
            F_P_KEY                 =>          UserMaster::Obj()->Data[F_P_KEY],
            F_F_INFO                =>          UserMaster::Obj()->Data[F_F_INFO],
            'PK'                    =>          $PK,
            'P_Upload_Root'         =>	        UserMaster::obj()->Data[P_UP],
            'V_Upload_Root'	        =>	        UserMaster::obj()->Data[V_UP],
            'IsClose'               =>          true,
    ));
    
    # Set common css and js files
    $js_files   =   array_merge($js_files, array('view'));
}
elseif($Action == A_CHANGE_USER_PASSWORD)
{
    if(isset($_GET['save-pass']) && $_GET['save-pass'] == true)
        $msgSuccess = "Password has been changed.";

    $PK = isset($_GET['pk'])?$_GET['pk']:'';

    $info=UserMaster::obj()->getInfoById($PK);

    st::$obj->assign(array(
            'includeFile'           =>  'layout/html-form'.$config[TPL_EX],
            'A_Action'              =>  $file_name,
            "Action"                =>  $Action,
            'ModuleTitle'           =>  $info[UserMaster::obj()->Data[F_P_FIELD]]." ".$info[UserMaster::obj()->Data[FIELD_PREFIX].'lastname'],
            F_F_INFO                =>  UserMaster::obj()->Data['FFI_1'],
            'PK'                    =>  $PK,
    ));
    # Set common css and js files
    $css_files  =   array_merge($css_files, array('bst-switch'));
    $js_files   =   array_merge($js_files, array('bst-switch','jformvalidator','html_form'));
}
/*elseif($Action == A_USER_INFO)
{
    $PK = isset($_GET['pk'])?$_GET['pk']:'';

	# Set user info command list
	UserMaster::obj()->C_CommandList_UserInfo();

    $user_info    =   UserMaster::obj()->getInfoById($PK);

    # Change Breadcrumbs
    $Breadcrumbs        =   explode('&raquo;',Utility::obj()->Breadcrumbs());

    $Breadcrumbs[3]     =   'User Info - '.UserMaster::obj()->getUserNameById($PK);

    $Breadcrumbs        =   implode(' &raquo; ',$Breadcrumbs);

    $objXAjax->configure('requestURI',$virtual_path['User_Root'].'/geo_location_ajax.html');

    st::$obj->assign(array(
                            'T_Body'                =>          'custom_addedit'. $config[TPL_EX],
                            'SidebarKis'            =>          'tpl_webuser/webuser-info-right-sidebar'. $config[TPL_EX],
	                        //'includeFile'           =>          'tpl_webuser/webuser-info'. $config[TPL_EX],
					        'A_Action'              =>          $file_name,
					        'Action'                =>          $Action,
                            //'CustomActionFile'      =>          'act-user'.$config[TPL_EX],
                            'HideTopAction'         =>          true,
                            'Breadcrumbs'           =>	        $Breadcrumbs,
                          //  'SidebarLeft'           =>          'tpl_webuser/webuser-info-left-side-bar'. $config[TPL_EX],
                           // 'SidebarLeftBlue'       =>          true,
	                        'msgSuccess'            =>          $msgSuccess,
					        'msgError'              =>          $msgError,
                            'AddTitle'              =>          'User Info - '.UserMaster::obj()->getUserNameById($PK),
                            'GoBackButton'          =>          UserMaster::obj()->Data['ScriptName'],
                            'ExtraModuleFileBefore' =>          'modinfo-user-master'.$config[TPL_EX],
					        'PK'                    =>          $PK,
                            'User_Id'				=>	        isset($PK)?$PK:'',

                            //'QuickSearch'           =>          true,
					        //'FieldSort'             =>          true,
	                        //'FieldSortSelection'    =>          true,
					        //'Pagination'            =>          true,
					        //'PageSize'		        =>	        $asset['OL_PageSize'],
                            //'arr_YesNo'             =>          array_merge(array("" => 'All'),$asset['OL_YesNo']),
					        //'AlphaSort'           =>          true,
					        //'FieldSelectionSort'    =>          true,
                            //F_ACTIVE               =>          UserMaster::obj()->Data[F_ACTIVE],
                            'P_Upload_Root'         =>	        UserMaster::obj()->Data[P_UP],
                            'V_Upload_Root'	        =>	        UserMaster::obj()->Data[V_UP],
					        FIELD_PREFIX            =>          UserMaster::Obj()->Data[FIELD_PREFIX],
	                        F_P_KEY                 =>          UserMaster::Obj()->Data[F_P_KEY],
					        'ModuleTitle'           =>          UserMaster::Obj()->Data[L_MODULE],
					        'HelpText'              =>          UserMaster::Obj()->Data[H_MANAGE],
					        //F_H_ITEM                =>          UserMaster::Obj()->Data[F_H_ITEM],
                             F_F_INFO                =>          UserMaster::Obj()->Data[F_F_INFO],
	                        //'Filter'		        =>          UserMaster::obj()->filter,
                            //'FilterData'	        =>          UserMaster::obj()->getSearchFilter(),
					        'total_record'          =>          UserMaster::Obj()->total_record,
                            'arrUserInfo'           =>          $user_info,
                            'arrCountry'            =>          GeoCountry::obj()->getKeyValueArray(),
                            'arrState'              =>          GeoState::obj()->getKeyValueArray($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'country']),
                            'arrCity'               =>          GeoCity::obj()->getKeyValueArray($user_info[UserMaster::obj()->Data[FIELD_PREFIX].'state']),
                            'OL_Web_User_Type'      =>          $asset['OL_Web_User_Type'],
                            'OL_Gender'             =>          $asset['OL_Gender'],

                            C_COMMAND_LIST          =>          UserMaster::Obj()->Data[C_COMMAND_LIST],
	                        'C_CommandList_UserInfo'=>          UserMaster::obj()->Data['C_CommandList_UserInfo'],

							'jbBstDateTimePicker'   =>          true,
					        'jbTable'               =>          true,
	                        'jbTabs'                =>          true,
                            "jMaskedInput"		    =>          true,
					        "jFancyBox2"            =>          true,
					        "jFormValidator"	    =>  	    true,
                            'jQueryUI'              =>          true,
                            'jGeoLocationSelection'	=>	        true,
                            'jbBstSwitch'           =>          true,
                            'xajax_javascript'		=>	        $objXAjax->getJavascript('../libs/xajax/'),
                            'JavaScript'            =>          array('list','search-filter','user-info'),
    ));
}*/

# Assign some basic data to smarty
st::$obj->assign(array(
    'msgError'          =>      $msgError,
    'msgSuccess'        =>      $msgSuccess,

    'Css'               =>      $css_files,
    'JavaScript'        =>      $js_files
));
st::$obj->display('default_layout'.$config['tplEx']);
?>