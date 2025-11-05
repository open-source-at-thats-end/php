<?php
/**
 * @file /includes/constants.php
 */
# Check for hacking attempt
if (!defined('IN_SECURE')){exit("Unauthorised Access.");}

# Base 64 Encoding Token
define('BASE64_TOKEN', 'forever');

define('DEBUG',          false);		# Debugging on | off
define ('OE_TEST_USER_EMAIL',       'odeveloper@oequal.com');

define('COUNTRY_ID_IND', '103');

define ('TPL_EX',       'tplEx');
define ('FOLDER_PERMS', 'Folder_Perms');
define ('FILE_PERMS',   'File_Perms');
define ('TABLE_PREFIX', 'Table_Prefix');
define ('TABLE_PREFIX_FYA', 'Table_Prefix_FYAccount');

define ('DB_HOST',      'DB_Host');
define ('DB_NAME',      'DB_Name');
define ('DB_USER',      'DB_User');
define ('DB_PASSWD',    'DB_Passwd');
define ('DB_DRIVER',    'DB_Driver');
define ('DB_CHARSET',   'DB_Charset');
define ('DB_PORT',      'DB_Port');
define ('DB_PREFIX',    'DB_Prefix');

define ('OE',                          'OE');
define('SYSTEM_CONFIG',                'SYSTEM_CONFIG');
define('ADMIN_PREF',                   'ADMIN_PREF');
define('SYSTEM_PRIVILEGES',            'SYSTEM_PRIVILEGES');
define ('OEC_CID',                     'OEC_CompanyID');
define ('OEC_CLID',                    'OEC_CL');
define ('OEC_INDEBUG',                 'OEC_InDebug');
define ('OEC_INPSESSION',              'OEC_InPSession');
define ('OEC_PPIN',                    'OEC_PrivatePIN');
define ('OEC_PRIVILEGE',               'OEC_ModulePrivilege');
define ('OEC_CRYPT',                   'OEC_EncryptionKey');
define ('OEC_EMAIL',                   'OEC_EmailID');
define('WORD_CENSORING',               'WORD_CENSORING');

define ('OEC_MASTER',                  'OEC_MasterInfo');
define ('OEC_SECURITY',                'OEC_SecurityInfo');
define ('OEC_ADMIN_SEC',               'OEC_AdminSecurityInfo');
define ('OEC_SYS_CONFIG',              'OEC_SystemConfig');

/*define('ANONYMOUS', 			'0');
define('ADMIN', 				'1');
define('SUBADMIN', 				'2');
define('USER', 					'3');
define('CRAWLER', 				'4');
define('CLIENT', 				'5');*/

define('ANONYMOUS', 			'Anonymous');
define('ADMIN', 				'Admin');
define('SUBADMIN', 				'SubAdmin');
define('USER', 					'User');
define('AGENT', 			    'Agent');
define('CRAWLER', 				'Crawler');
define('LDSOURCE_APP',	        'Mobile App');

define('SESSION_EXP_DURATION',	60*60*24*14); # Session Expiration Duration 14 Days

# Upload type
define('PICTURE', 'Picture');

# Email Address on which cronjob's outpue send each time the same will run
define('CRON_EMAIL_ADD', '');

# Flag
define('YES',	'Yes');
define('NO',	'No');

# Constant
define('HIDDEN',	'0');
define('VISIBLE',	'1');
define('SUBOPTION',	'SubOption');
define('LINK',		'Link');
define('IFRAME',	'iFrame');
define('PERM',		'Permission');
define('NEW_WINDOW','NewWindow');

#Tour
define('TOUR_TITLE',                     'How to?');

# Config name
define('GROUP_TITLE',					'GroupTitle');
define('GROUP_CLASS',					'GroupClass');
define('TITLE',							'Title');
define('DESC',							'Desc');
define('ICON',							'Icon');
define('ICON_IMG',					    'IconImage');
define('DATA_LINK',						'DataLink');
define('DATA_ATTRIBUTE',			    'DataAttribute');
define('KEY_VAL',						'KeyValue');			#	Control key value
define('DEF_VAL',						'DefaultValue');		#	Control default value
define('SEL_TEXT',						'SelText');				#	Control selected value list
define('OPTION',						'Option');				#	Control option list
define('DEF_OPTION',					'DefaultOption');		#	Default option
define('OPTION_TPL',                    'OptionTemplateFile');
define('SEPARATOR',						'Separator');			#	Separator of items for controls of array type. eg.checkbox, radio
define('SYS_PRIVILEGES',                'SystemPrivileges');
define('CNT_DEPEN',						'ControlDependency');	#	control's dependency fields
define('CNT_TYPE',						'ControlType');			#	Type of control
define('CNT_CLASS',						'ControlClass');			#	Type of control
define('CNT_ATTR',                      'ControlAttribute');
define('CNT_WIDTH',						'ControlWidth');		#	Control width
define('CNT_HEIGHT',					'ControlHeight');		#	Control height
define('CNT_SIZE',						'ControlSize');			#	Control Size
define('CNT_MAXLEN',					'ControlMaxLen');		#	Control maximum length
define('CNT_ALIGN',						'ControlAlign');		#	Control alignment
define('CNT_TOOLBAR',					'ControlToolbar');		#	Control toolbar
define('CNT_READONLY',					'ControlReadOnly');		#	Control read only
define('CNT_DISABLED',					'ControlDisabled');		#	Control disabled
define('CNT_EXTRA',						'ControlExtra');		#	Control extra
define('CNT_REL',						'ControlRel');		    #	Control rel used for city state suggestion box
define('PIC_PATH',						'PicPath');				#	Control selected value list
define('CNT_STRIP_ABSOLUTE_URLS',		'StripAbsoluteUrls');	#	Control to use Full Url in SPAW Editor
define('CNT_STYLESHEET',				'StyleSheet');			#	Control to use Full Url in SPAW Editor
define('CNT_LIBPATH',					'LibPath');			    #	Control to use Full Url in SPAW Editor
define('CNT_NORESIZE',                  'NoResize');
define('CNT_FIRST_ADDON',               'FirstAddon');
define('CNT_LAST_ADDON',                'LastAddon');
define('CNT_GROUP_ADDON',               'GroupAddon');
define('FADDON_IS_TEXT',                'FirstAddonIsText');
define('LADDON_IS_TEXT',                'LastAddonIsText');
define('CNT_SWLABLE_TEXT',              'SwitchLabelText');
define('CNT_SWLABLE_ICON',              'SwitchLabelIcon');
define('CNT_SWON_TEXT',                 'SwitchOnText');
define('CNT_SWOFF_TEXT',                'SwitchOffText');
define('CRYPT_VALUE',                   'CryptValue');
define('CNT_GROUP_CLASS',               'ControlGroupClass');

define('CNT_ROW',						'ControlRows');			#	Control extra
define('CNT_COLS',						'ControlCols');			#	Control extra
define('CNT_TABINDEX',					'ControlTabIndex');		#	Control extra
define('CNT_HAS_TPL',                   'ControlHasTemplate');
define('AUTO_SUGGESTION_TPL',           'AutoSuggestionTemplate');
define('MULTI_AUTO_SUGGESTION_TPL',     'MultiAutoSuggestionTemplate');
define('ALLOW_MULTIPLE',                'AllowMultiple');

define('LAYT_COLS',						'LayoutCols');			#	No. of columns
define('COLS_SPAN',						'ColumnSpan');			#	Expan column

define('DT_START_YEAR',					'StartYear');			#	Control start year
define('DT_END_YEAR',					'EndYear');				#	Control end year
define('VALIDATE',						'Validate');
define('VAL_TYPE',						'ValidationType');
define('VAL_MAXLEN',					'ValidationMaxLength');
define('VAL_MINLEN',					'ValidationMinLength');
define('VAL_MAX',						'ValidationMaxValue');
define('VAL_MIN',						'ValidationMinValue');
define('VAL_EXT',						'ValidationExtention');
define('VAL_MSG',						'ValidationMesg');
define('VAL_CHAR_RANGE',				'ValidationCharRange');
define('VAL_VALUE_RANGE',				'ValidationValueRange');
define('VAL_EQUALTO',					'ValidationEqualTo');
define('VAL_MIN_REQ_FIELD',             'ValidationMinReqField');
define("VAL_IMG_WIDTH",                 'ValidationImageWidth');
define("VAL_IMG_HEIGHT",                'ValidationImageHeight');

define('WIDTH',							'Width');				#	Width
define('ALIGN',							'Align');				#	Align

define('IS_INFO',                       'IsInfo');
define('IS_PIC',						'IsPicture');			#	Is picture file
define('PIC_WIDTH',						'PicWidth');			#	Is picture file
define('IS_LISTING_PIC',				'IsListingPicture');	#	Is Listing picture file
define('IS_PIC_URL',					'IsPicUrl');	        #	Is Listing picture file
define('IS_TIME',						'IsTime');				#	Is time field
define('IS_AMT',						'IsAmount');			#	Is amount field
define('IS_DATE',						'IsDate');				#	Is date field
define('IS_DATE_TIME',					'IsDateTime');			#	Is Date Time field
define('IS_ID',							'IsId');				#	Is ID/Key
define('IS_IDLIST',						'IsIdList');			#	Is List of ID/Key
define('NULL_ON_EMPTY',                 'NULLOnEmpty');
define('IS_CNT',						'IsControl');			#	Is a control
define('IS_CON_FIELD',					'IsConcateField');		#	Is a concate field
define('IS_HTML',						'IsHtml');				#	Is a concate field
define('IS_EXTENDED',                   'IsExtended');
define('PIC_PRE',						'Pic_Prefix');			#	Is picture file
define('CREATE_THUMB',					'CreateThumb');			#	Is picture file
define('DISP_WIDTH',					'Disp_Width');
define('CLICK_LINK',					'ClickLink');
define('IS_LABEL',						'IsLabel');
define('FORMAT',						'Format');			    #	Format the value
define('IS_FORMAT',						'IsFormat');			#	Format the value
define('FORMAT_STR',					'FormatString');		#	Format string
define('OPEN_POPUP',					'OpenPopup');		    #
define('POPUP_URL',					    'PopupUrl');		    #
define('POPUP_SIZE',					'PopupSize');		    #
define('USE_FIELDS',					'UseFields');		    #
define('IS_CHK_UNCHK_TOOL',				'IsChkUnchkTool');		#	Allow Chek/Uncheck Tool
define('IS_SORTABLE',					'IsSortable');			#	Whether field is sort or not
define('TOOLTIP',                       'Tooltip');             #   Tooltip
define('SUB_ITEM',                      'SubItem');
define('SUB_ITEM_TOOLTIP',              'SubItemTooltip');      #   Set sub item as a tooltip
define('IS_EDITABLE',					'IsEditable');
define('EDIT_FIELD',					'EditField');
define('EDIT_TYPE',						'EditType');
define('EDIT_SOURCE',					'EditSource');
define('EDIT_TITLE',					'EditTitle');
define('EDIT_REF_ID',					'EditRefID');
define('IS_QUICKVIEW',					'IsQuickView');
define('VIEW_TITLE',					'ViewTitle');
define('VIEW_REF_ID',					'ViewRefID');
define('VIEW_REF_TYPE',					'ViewRefType');
define('ENCRYPT_DATA',					'EncryptData');
define('IS_LINK',                       'IsLink');

define('IS_CUSTOM_FIELD',               'IsCustomField');
define('IS_XSMALL_CNT',                 'IsExtraSmallControl');
define('IS_SMALL_CNT',                  'IsSmallControl');
define('IS_MEDIUM_CNT',                 'IsMediumControl');

define('A_ALBUM',						'Album');				#	Action View Album
define('A_PHOTOS',						'Photos');				#	Action View Photos
define('A_VIDEOS',						'Videos');				#	Action View Videos
define('A_MULTIUPLOAD',					'MultiUpload');			#	Action add
define('A_COMMENT',						'Comment');				#	Action View Poll Answer
define('A_IMPORT',						'Import');				#	Action Import
define('A_CHILD_MODULE',                'ChildModule');         #   Action If Module Has Redirection To Sub Module
define('A_TRUNCATE_TABLE',               'TruncateTable');      # Action Trancating A Table
define('A_AUTO_DETECT',                 'AutoDetect');
define('A_SEND_AS_NEWSLETTER',          'SendAsNewsletter');
define('A_SEND_AS_NEWSLETTER_SEL',      'SendAsNewsletterSelected');
define('A_SEND_NEWSLETTER_NOW',         'SendNewsletterNow');
define('A_SEND_EMAIL',                  'SendEmail');
define('A_GET_IMPORT_EXCEL',            'GetImportExcel');

define('A_ADD_MLS',						'AddByMLS');			#	Action Import
define('A_HOME_WARRANTY_PLAN',			'Home Warranty Plan');	#	Home Warranty Plan
define('A_EXPORT_PDF',					'ExportPDF');
define('A_EXPORT',						'Export');				#	Action Export
//define('A_EXPORT',                      "ExportData");new

define('A_EXCEL',						'excel');			    #	Action add
define('A_CVS',							'CSV');				    #	Action add
define('A_ADD',							'Add');					#	Action add
define('A_EDIT',						'Edit');				#	Action edit
define('A_EDIT_PROFILE',				'EditProfile');			#	Action edit
define('A_DOCUMENTS',                   'Documents');           #   Action Documents view
define('A_DELETE',						'Delete');				#	Action delete
define('A_DELETE_SEL',					'DeleteSelected');		#	Action delete
define('A_VIEW',						'View');				#	Action view
define('A_QUICK_VIEW',				    'QuickView');			#	Action quick view
define('A_QUICK_UPDATE',				'QuickUpdate');		    #	Action quick update
define('A_USERVIEW',					'View');				#	Action view
define('A_LISTING_VIEW',				'Listing-View');		#	Action Listing-view
define('A_LOGIN',						'Login');				#	Action Login
define('A_SEND',						'Send');				#	Action Send
define('A_LIST',						'List');				#	Action Send
define('A_SELECT',						'Select');				#	Action select
define('A_CONTINUE',					'Continue');			#	Action Continue
define('A_SHOW',						'Show');				#	Action show
define('A_PREVIEW_POST',				'PreviewPost');			# 	Preview Post
define('A_UPDATE',						'Update');				#	Action show
define('A_PRINT',						'Print');				#	Action show
define('A_VISIBILITY',					'Visibility'); // new define('A_VISIBILITY',					'VisibleHide');			#	Action add
define('A_VISIBILITY_SEL',			    'VisibleHideSelected');			#	Action add
define('A_ACTIVEINACTIVE',              'ActiveInactive');
define('A_ACTIVEINACTIVE_SEL',          'ActiveInactiveSelected');
define('A_HIGHLIGHT',					'Highlight');			#	Action Highlight
define('A_APPROVEDISAPPROVE',			'ApproveDisapprove');
define('A_APPROVEDISAPPROVE_SEL',		'ApproveDisapproveSelected');
define('A_SORT_ALL',					'SortAll');				#	Action sort all
define('A_SORT',						'Sort');				#	Action sort
define('A_EMAIL',						'Email');				#	Action email
define('A_MASSMAIL',					'MassMail');			#	Action Mass email
define('DISPLAY_MEDIUM_SIZE',			'DisplayMediumSize');	#	Action Mass email
define('A_REGION',						'Region');				#	Action Mass email
define('A_CITY',						'City');				#	Action Mass email
define('A_CUSTOM_WITH_SELECTED',		'CustomWithSelected');
define('A_EMAIL_SINGLE_USER',			'EmailSingleUser');		#	Action email to single user
define('A_EMAIL_MUL_USER',				'EmailMulUser');		#	Action email to multiple user
define('A_LISTING_LINK_VIEW',           'ListingLinkView');
define('A_DUPLICATE',                   'Duplicate');

define('A_CUSTOM_DELETE',				'CustomDelete');		# 	Action CustomDelete
define('A_MASS_DELETE',					'MassDelete');
define('A_FAVHOME',						'FavListing');
define('A_ADD_TO_FAVORITE',				'AddToFavorite');			# 	Action CustomDelete
define('A_SAVE_SEARCH',					'SaveSearch');
//define('A_METADATA',					'MetaData');
define('A_PIC_UPLOAD',					'PictureUpload');
define('A_VIRTUAL_DELETE',              'VirtualDelete');      	# Action To delete record virtually
define('A_VIRTUAL_DELETE_SEL',          'VirtualDeleteSelected');
define('A_EMAIL_BLOCK',              	'EmailBlocking');      	# Action To block email address
define('A_UNBLOCK_EMAIL',              	'UnBlockEmail');       	# Action To un block email address
define('A_CHANGE_USER_PASSWORD',        'ChangeUserPassword'); 	# Action Change User Password
define('A_MASS_GEOCODE_UPDATE',			'MassGeoCodeUpdate');	#	Action Mass geocode update
define('A_LISTING_REPORT',				'ListingReport');		#	Listing Report Selection
define('A_LISTING_EMAIL',				'Email');				#	Listing Email
define('A_CREATE_COPY',					'CreateCopy');
define('A_SCHEDULE',					'Schedule');
//define('A_VIEW_SCHEDULE_HISTORY',		'ScheduleHistory');
define('A_VIEW_SCHEDULE_HISTORY',		'ViewScheduleHistory');
define('A_VIEW_SCHEDULE',				'ViewSchedule');
define('A_ADD_TO_USER_FAVORITE',        'AddToUserFavorite');  	# Action To un block email address
define('A_SET_LOCATION',                "SetLocation");

# Custom MLS Action
define('A_METADATA',					'MetaData');
define('A_MLSSETTING',					'MLSSetting');
define('A_MLSUTILITY',					'MLSUtility');
define('A_MASS_UPDATE',					'MassUpdate');			# 	Mass Updataion
define('A_MANAGE_PAGE',					'ManagePage');
define('A_MANAGE_POST',					'ManagePost');

# Custom Lead Action
define('A_LEAD_EDIT',					'LeadEdit');			# Action lead edit used for lead edit only
define('A_LEAD_PRINT',					'LeadPrint');			# Action lead edit used for lead edit only
define('A_LEAD_EMAIL',					'LeadEmail');			# Action lead edit used for lead edit only
define('A_MULT_VIEW',					'MultipleView');

define('A_MASSREGISTRATION',			'MassRegistration');			#	Action Mass email
define('A_MASS_CATEGORISATION',         'MassCategorisation');
define('A_MASS_FOLLOWUP',               'MassFollowup');
define('A_MASS_NOTE',                   'MassNote');
define('A_AGENT_PHOTO_GALLERY',         'AgentPhotoGallery');
define('A_AGENT_TESTIMONIALS',               'AgentTestimonials');
define('A_DOWNLOAD',					'Download');
define('A_LOG',                         'Log');                 #	Action Log
define('A_DEVELOPMENT_PHOTO_GALLERY',   'DevelopmentPhotoGallery');
define('A_DEVELOPMENT_FLOOR_PLAN',      'DevelopmentFloorPlan');
define('A_DEVELOPMENT_LOCATION',        'DevelopmentLocation');
define('A_CSLISTING_PHOTO',             'PropertyPhoto');

define('A_EMPLOYEE_PHOTO_GALLERY',      'EmployeePhotoGallery');

define('A_USER_ACT_PROFILE',            'UserProfile');
define('A_USER_ACT_VIEW',				'UserView');
define('A_USER_ACT_EDIT',				'UserEdit');
define('A_USER_ACT_DELETE',				'UserDelete');
define('A_USER_ACT_PRINT',				'UserPrint');
define('A_USER_LIST',                   'UserList');
define('A_ADD_AUTH_CONNECT',            'AddAuthConnect');

define('A_USR_ACT_VIEW',				'User-View');
define('A_USR_ACT_EDIT',				'User-Edit');
define('A_USR_ACT_DELETE',				'User-Delete');
define('A_USR_ACT_PRINT',				'User-Print');
define('A_USR_ACT_EMAIL',				'User-Email');

define('A_CONVERT_TO_REG_USER',			'ConvertToRegUser');

define('A_CRAIGSLIST_ADS',				'CreateCraigslistAds');
define('A_PDF_BROCHURE',				'PDF-Brochure');
define('A_FB_PUBLISH',					'PostToFB');
define('A_LEAD_TRANSFER',				'LeadTransfer');
define('IsFeatured',                    'IsFeatured');

define('A_LISTING_VIDEO',               'ListingVideo');
define('A_AGENT_VIDEO_URL',             'AgentVideoUrl');
define('A_CHARITY_SUPPORT',             'CharitySupport');
define('A_CHARITY_SUPPORT_GALLERY',     'CharitySupportGallery');

define('A_CREATE_PDB',                  "CreateProjectDatabase");
define('A_ADD_STRUCTURE',               "AddProjectStructure");
define("A_VIEW_STRUCTURE",              "ViewProjectStructure");
define('A_ASSIGN_SUBADMIN',             "AssignSubAdmin");
define("A_VIEW_FULL_SUMMARY",           "ViewFullSummary");
define("A_VIEW_STRUCTURE_SUMMARY",      "ViewStructureSummary");
define("A_ALLOW_PROPERTY_MANAGEMENT",   "AllowPropertyManagement");
define('A_EDIT_TNC',                    "EditTermsAndCondition");
define('A_VIEW_TNC',                    "ViewTermsAndCondition");
define("A_ALLOW_SELLING",               "AllowToSellProperty");

# Use for Keyword suggestion tool
define('KEYWORD_SUGGESTION',			'KeywordSuggestion');
define('KEYWORD_BASE',					'KeywordBase');

# Control type
define('C_TEXT',						'Text');
define('C_AUTO_SUGGESTION',			    'AutoSuggestion');
define('C_MULTI_AUTO_SUGGESTION',	    'MultiAutoSuggestion');
define('C_PASSWORD',					'Password');
define('C_RICHTEXT',					'RichText');
define('C_TEXTAREA',					'TextArea');
define('C_COMBOBOX',					'ComboBox');
define('C_CITY_STATE_SUGGESTION',		'CityStateSuggestion');
define('C_DBCOMBOBOX',					'DbComboBox');
define('C_STATE_COMBOBOX',				'StateComboBox');
define('C_COUNTRY_COMBOBOX',			'CountryComboBox');
define('C_PAGE_PARENT_COMBOBOX',		'PageParentComboBox');//New define('C_PARENT_COMBOBOX',		        'ParentComboBox');
define('C_STATE_COUNTY_COMBOBOX',		'StateCountyComboBox');

define('C_PRIVILEGE',					'Privilege');
define('C_DATE_PICKER',					'DatePicker');
define('C_DATE_RANGE',					'DateRange');
define('C_TIME_PICKER',                 'TimePicker');
define('C_DATE_TIME_PICKER',            'DateTimePicker');
define('C_DATE',						'Date');
define('C_CHECKBOX',					'CheckBox');
define('C_RADIO',						'Radio');
define('C_CHOICE',						'Choice');
define('C_PICFILE',						'PictureFile');
define('C_AUDIOFILE',					'AudioFile');
define('C_FILE',						'File');
define('C_SIZE',						'Size');
define('C_HIDDEN',						'Hidden');
define('C_SECURE',						'Secure');
define('C_SELECT',						'Select');
define('C_TIME',						'Time');
define('C_PHONE',						'Phone');
define('C_LABEL',						'Label');
define('C_VIDEOFILE',					'VideoFile');
define('C_BSPACE',                      'BlankSpace');
define('C_SWITCH',                      'MakeSwitch');
define('C_CURRENCY',                    'Currency');
define('C_MULTI_SELECTION',             'MultiSelection');
define('C_TPL',							'Template');
define('CNT_TPL', 						'TemplateFile');

# Validation type
define('V_EMPTY',						1);
define('V_LEN',							2);
define('V_MAX',							4);
define('V_MIN',							8);
define('V_INT',							16);
define('V_FLOAT',						32);
define('V_EXTENTION',					64);
define('V_SIZE',						128);
define('V_EMPTYFILE',					256);
define('V_EMAIL',						512);
define('V_URL',							1024);
define('V_DATE',						2048);
define('V_CHECKED',						4096);
define('V_ISTIME',						8192);
define('V_CURRENCY',					16384);
define('V_PHONE',						32768);
define('V_ZIP',							65536);
define('V_URL_FRIENDLY',				131072);	/* Validate for URL Friendly name*/
define('V_MAXLEN',						262144);
define('V_MINLEN',						524288);
define('V_STR',							1048576);
define('V_CHAR_RANGE',					2097152);
define('V_VALUE_RANGE',					4194304);
define('V_EQUALTO',						8388608);
define('V_IP4',                         16777216);
define('V_IP6',                         33554432);
define('V_NO_SPACE',                    67108864);
define('V_ALPHANUMERIC',                134217728);
define('V_REQUIRE_GROUP',               268435456);
//define('V_DATERANGE',                   536870912);
define('V_IMG_WH',                      1073741824);

# Server Side Validation type
define('SV_TEXT',						'Text');
define('SV_NAME',						'Name');
define('SV_EMAIL',						'Email');
define('SV_PHONE',						'Phone');
define('SV_EMPTY',						'Empty');
define('SV_NUMBER',						'Number');

# Help Module
define('Help_Page',						'help-content.php');// new help-content.html

/* Some constants for SF url for modules */
define('LISTING',						'listing');
define('HOME_SEARCH',					'search-all-homes');
define('SEFU_LISTINGS',					'listings');
define('HOMES_FOR_SALE',				'homes-for-sale');
define('HOME_LISTING',					'home-listing');
define('ALL_MLS_LISTING',				'all-mls-listing');
define('QUICK_SEARCH',					'/quick-search/');
define('FEATURED_LISTINGS',				'/featured-listings');
/* For browse listing */
define('KEYWORD_LIST',					'%1$s homes for sale, %1$s houses, %1$s real estate listing, %1$s real estate search, %1$s waterfront homes for sale, %1$s houses for sale');

/* Email Templates Constants */
define('EMAIL_WELCOME',					            1);
define('EMAIL_FORGOT_PASSWORD',			            2);
define('EMAIL_SEARCH_NOTIFY',			            7);//3);
define('EMAIL_SEARCH_SETUP',			            8);//3);
define('EMAIL_LISTING',					            3);
define('EMAIL_LISTING_REPORT',			            4);
define('EMAIL_LISTING_TO_FRIEND',		            5);
define('EMAIL_LISTING_PRICE_NOTIFY',	            6);
define('EMAIL_WELCOME_AGENT',                       10);
define('EMAIL_ACC_ACTIVATION',                      37);
define('EMAIL_WELCOME_AFTER_EMAIL_VERIFY',          38);
define('EMAIL_PASSWORD_RESET',                      39);
define('EMAIL_REGISTRATION',                        55);

define('SC_VARIABLE_SITE_TITLE',                    '[$SITE_TITLE]');
define('SC_VARIABLE_SITE_URL',                      '[$SITE_URL]');
define('SC_VARIABLE_SITE_DOMAIN',                   '[$SITE_DOMAIN]');
define('SC_VARIABLE_USER_NAME',                     '[$USER_NAME]');
define('SC_VARIABLE_SITE_LINK',                     '[$SITE_LINK]');
define('SC_VARIABLE_USER_LOGIN_ID',                 '[$USER_LOGIN_ID]');
define('SC_VARIABLE_ACTIVATION_LINK',               '[$ACTIVATION_LINK]');
define('SC_VARIABLE_USER_PASSWORD',                 '[$USER_PASSWORD]');
define('SC_VARIABLE_ORDER_NUMBER',                  '[$ORDER_NUMBER]');
define('SC_VARIABLE_FULL_ORDER_INFO',               '[$FULL_ORDER_INFO]');
define('SC_VARIABLE_TOKEN_NUMBER',                  '[$TOKEN_NUMBER]');
define('SC_VARIABLE_SUBJECT',                       '[$SUBJECT]');
define('SC_VARIABLE_DESCRIPTION',                   '[$DESCRIPTION]');
define('SC_VARIABLE_REFERENCE_ID',                  '[$REFERENCE_ID]');
define('SC_VARIABLE_REFERENCE_TYPE',                '[$REFERENCE_TYPE]');
define('SC_VARIABLE_DISPUTE_STATUS_HISTORY_INFO',   '[$DISPUTE_STATUS_HISTORY_INFO]');
define('SC_VARIABLE_GOODS_PURCHASE_LIST_INFO',      '[$GOODS_PURCHASE_LIST_INFO]');
define('SC_VARIABLE_BATCH_NO',                      '[$BATCH_NO]');
define('SC_VARIABLE_SUPPLIER_NAME',                 '[$SUPPLIER_NAME]');
define('SC_VARIABLE_HOST_URL',                      '[$HOST_URL]');
define('SC_VARIABLE_LINE_BREAK',                    '[$BR]');
define('SC_VARIABLE_CHILD_LINE_BREAK',              '[$CBR]');

define('EMAIL_SUBJECT_HELP_TEXT',		'You can make use of following variables with subject:<br />
										{$Site_Title}, {$Site_Url}, {$Site_Domain}, {$user_name}, {$user_first_name}, {$user_last_name}');

define('EMAIL_CONTENT_HELP_TEXT',		'You can make use of following variables with email body:<br />
										{$Site_Title}, {$Site_Url}, {$Site_Domain}, {$user_name}, {$Site_Link}');

/*
New email text constant. When change code as per new structure enable it & delete old structured related constant.
define('EMAIL_SUBJECT_HELP_TEXT',		'You can make use of following variables with subject:<br />

										'.SC_VARIABLE_SITE_TITLE.', '.SC_VARIABLE_SITE_URL.', '.SC_VARIABLE_SITE_DOMAIN.'');



define('EMAIL_CONTENT_HELP_TEXT',		'You can make use of following variables with email body:<br />

										'.SC_VARIABLE_SITE_TITLE.', '.SC_VARIABLE_SITE_URL.', '.SC_VARIABLE_SITE_DOMAIN.', '.SC_VARIABLE_USER_NAME.', '.SC_VARIABLE_SITE_LINK.'');


*/

# Used in Lead Edit Layout in admin section
define('SHOW_EMAIL_TOTAL_RECORDS',      5);
define('SHOW_LOGIN_TOTAL_RECORDS',      10);
define('SHOW_FOLLOWUP_TOTAL_RECORDS',	10);
define('SHOW_NOTES_TOTAL_RECORDS',      10);
define('TOTAL_VIEW_EMAIL_DISPLAY',      25);

# User Transaction Related Constants
define('SHOW_DOCS_TOTAL_RECORDS',	10);

# System Log Action Constants
define('LOG_EMAIL_SEND',  	 			'Email Sent');
define('LOG_LISTING',					'List');
define('LOG_UPDATE_PERSONAL',  			'Update Personal Info');
define('LOG_UPDATE_LEAD_PERSONAL',  	'Update Lead Personal Info');
define('LOG_UPDATE_SCHEDULESHOWING',	'Update Schedule Showing');
define('LOG_NOTES_ADD',					'Add Notes');
define('LOG_NOTES_SHOWALL',				'Show All Notes');
define('LOG_NOTES_SHOWLIMITED',			'Show Limited Notes');
define('LOG_FOLLOWUP_ADD',				'Add Followup');
define('LOG_FOLLOWUP_DELETE',			'Delete Followup');
define('LOG_FOLLOWUP_SHOWALL',			'Show All Followup');
define('LOG_FOLLOWUP_SHOWLIMITED',		'Show Limited Followup');
define('LOG_EMAIL_SHOWALL',				'Show All Emails');
define('LOG_EMAIL_SHOWLIMITED',			'Show Limited Emails');

define('ADDITIONAL_THUMBS',             'AdditionalThumbs');

define('COMM_MODE_NONE',                0);
define('COMM_MODE_EMAIL',               1);
define('COMM_MODE_SMS',                 2);

define('STATUS_ONLINE',                 '1');
define('STATUS_OFFLINE',                '2');
define('STATUS_SLEEP',                  '3');

define('MODULE_KEY_CONF',               'Configuration');

define('WEBPP_HEADER',  '1');
define('WEBPP_MENU',    '2');
define('WEBPP_FOOTER',  '3');
define('WEBPP_TOP',     '4');
define('WEBPP_RIGHT',   '5');
define('WEBPP_LEFT',    '6');

define('WEBPT_SIMPLEPAGE','1');
define('WEBPT_IFRAME','2');
define('WEBPT_INTERNALLINK','3');
define('WEBPT_EXTERNALLINK','4');
define('WEBPT_HIDDENPAGE','5');

/*
Defien constants 2 times. Check which are used in system & use that and delete other
define('WEB_PAGETYPE_SIMPLE_PAGE',              '1');
define('WEB_PAGETYPE_IFRAME',                   '2');
define('WEB_PAGETYPE_INTERNAL_LINK',            '3');
define('WEB_PAGETYPE_EXTERNAL_LINK',            '4');
define('WEB_PAGETYPE_HIDDEN_PAGE',              '5');
*/

define('CONTACTUS', '1');
define('REGISTERUSER', '2');
define('EMAILTOFRIEND', '3');
define('INQUIRY', '4');

define('PAGE_MANAGER_ID_HOME',              '1');
define('PAGE_MANAGER_ID_404',               '3');
define('PAGE_MANAGER_ID_ABOUT_US',          '4');
define('PAGE_MANAGER_ID_CONTACT_US',        '5');
define('PAGE_MANAGER_ID_AGENT_SUPPORT',     '27');
define('PAGE_MANAGER_ID_TESTIMONIAL',       '18');
define('PAGE_MANAGER_ID_TERMS_OF_USE',      '7');
define('PAGE_MANAGER_ID_PRIVACY',           '9');
define('PAGE_MANAGER_ID_NEWS',              '26');

define('AGENT_PAGE_MODULE_HOME',       'HomePage');
define('AGENT_PAGE_MODULE_CONTACT',    'Contact');
define('AGENT_PAGE_MODULE_AGENTLISTINGS', 'AgentListings');
define('AGENT_MANAGER_ID_TESTIMONIAL',       '25');
/*define('PAGE_MANAGER_ID_410',               '63');
define('PAGE_MANAGER_ID_FAQ',               '17');
define('PAGE_MANAGER_ID_NEWS',              '10');
define('PAGE_MANAGER_ID_MYACCOUNT',         '18');
define('PAGE_MANAGER_ID_DASHBOAD',          '20');
define('PAGE_MANAGER_ID_LOGOUT',            '21');
define('PAGE_MANAGER_ID_USERTRANSACTION',   '27');
define('PAGE_MANAGER_ID_COMPANY_POLICY',    '61');
define('PAGE_MANAGER_ID_LOGIN_SIGNUP',      '52');
define('PAGE_MANAGER_ID_CHANGE_PASSWORD',   '40');
define('PAGE_MANAGER_ID_HELP',              '60');*/

define('MYACT_INDEX',                       'myaccount.php');
define('MYACT_EDIT_PROFILE',                '/myaccount/edit-profile.html');
define('MYACT_FAV_LISTING',                '/myaccount/favourites-listings.html');
define('MYACT_SAVE_SEARCH',                '/myaccount/saved-searches.html');
define('MYACT_CHANGE_PASS',                '/myaccount/change-password.html');


define('DEVELOPMENT_URL',                '/developments/');
define('NEWS_URL',                       '/news/');
define('TESTIMONIAL_URL',                '/testimonial/');
define('AGENT_TESTIMONIAL_URL',                '/testimonials/');

/*
OLD PAGE ID CONSTANT
define('POLICY_PAGE_ID',                         '134');
define('TERMS_OF_USE_PAGE_ID',                   '140');
define('AGENT_PAGE_ID',                          '163');
define('ABOUT_PAGE_ID',                          '147');
define('CONTACT_US_PAGE_ID',                     '133');
*/

define('ABOUT_PAGE_ID',                 '14');
define('POLICY_PAGE_ID',                '9');
define('TERMS_OF_USE_PAGE_ID',          '7');

define('DEVELOPMENT_PAGE_ID',           '15');
define('AGENT_DEVELOPMENT_PAGE_ID',     '23');


define('WEB_UTYPE_REGISTER',                    '1');
define('WEB_UTYPE_UNREGISTER',                  '2');

define('ULOG_ACTION_SIGNUP',                        'UserSignup');
define('ULOG_ACTION_ACCOUNTACTIVATION',             'AccountActivation');
define('ULOG_ACTION_USERLOGIN',                     'UserLogin');
define('ULOG_ACTION_FORGOTPASSWORD',                'ForgotPassword');
define('ULOG_ACTION_EDITPROFILE',                   'EditProfile');

define('LETYPE_SIGNUP',             '1');
define('LETYPE_FORGOTPASSWORD',     '2');
define('LETYPE_OTHER',              '7');

define('SIGNUP_USING_WEBSITE',          '1');
define('SIGNUP_USING_FACEBOOK',         '2');
define('SIGNUP_USING_GOOGLE',           '3');

define('GENDER_MALE',          '1');
define('GENDER_FEMALE',         '2');

define('REFERRAL_TYPE_SIGN_UP',     '1');

define('EMAIL_TEMPLET_CATEGORY_SYSTEM', '1');
define('EMAIL_TEMPLET_CATEGORY_LEAD',   '2');
define('EMAIL_TEMPLET_CATEGORY_NEWSLETTER', '3');

define('IMAGE_SIZE_16X16',                      '16x16');
define('IMAGE_SIZE_32X32',                      '32x32');
define('IMAGE_SIZE_64X64',                      '64x64');
define('IMAGE_SIZE_128X128',                    '128x128');

define('PRODUCT_IMAGE_QUALITY',                 '90');
define('PRODUCT_STYLE_GROUP_MAX_ITEM',          '15');

define('ADMINROLE_SEO',           '6');
define('TEST_USER_ID',               '');

define('TRACK_MODULE_URL_EMAIL',           'email');
define('TRACK_MODULE_URL_OTHER',           'other');
define('TRACK_TYPE_URL_PRODUCT',           'product');

define('ALL_WEBPAGE',                       'AllWebPage');

define('WPM_HOME',                      'Home');
define('WPM_NEWS',                      'News');
define('WPM_ABOUTUS',                   'AboutUs');
define('WPM_CONTACTUS',                 'ContactUs');
//define('WPM_TERMSANDCONDITION',         'TermsandCondition');
define('WPM_COMPANYPOLICY',             'CompanyPolicy');
define('WPM_FAQ',                       'Faq');
define('WPM_ACTIVATION',                'Activation');
define('WPM_SITEMAP',                   'Sitemap');
define('WPM_LOGINORREGISTER',           'LoginOrRegister');
define('WPM_HELP',                      'Help');
define('WPM_DASHBOARD',                 'Dashboard');
define('WPM_MYPROFILE',                 'MyProfile');
define('WPM_CHANGEPASSWORD',            'ChangePassword');
define('WPM_LOGOUT',                    'LogOut');

define('LEAD_NEWSLETTER',                       'Newsletter');
define('LEAD_SELLERINQUIRY',                    'SellerInquiry');
define('LEAD_BUYERINQUIRY',                     'BuyerInquiry');
define('LEAD_CAREERINQUIRY',                    'CareerInquiry');

define('DEF_LEAD_STATUS',                   1);

define('DEVICE_TYPE_MOBILE',                 'phone');
define('DEVICE_TYPE_TABLET',                'tablet');
define('DEVICE_TYPE_COMPUTER',                'computer');

/*****************************************************************************************
 * BACKGROUNG COLOR CLASS
 **/
define('BG_NONE',                       '1');
define('BG_OFF_WHITE',                  '2');
define('BG_WHITE',                      '3');
define('BG_LIGHT_GRAY',                 '4');
define('BG_GRAY',                       '5');
define('BG_NORMAL',                     '6');
define('BG_BROWN',                      '7');
define('BG_PURPLE',                     '8');
define('BG_SKY',                        '9');
define('BG_PINK_LIGHT',                 '10');
define('BG_ETHNIC',                     '11');
define('BG_PATTERN',                    '12');
define('BG_FLORAL',                     '13');
define('BG_PATTERN_PURPLE',             '14');
define('BG_PATTERN_PINK',               '15');
define('BG_PATTERN_SKY',                '16');
define('BG_CROSS_LINES',                '17');

/*******************************************************************************************

 * DO NOT WRITE BELOW THIS LINE

 * NOTICE : Web page URL constants

 * All below constants are related with web site page url structure

 **/
/* Report Links Used In Email Sending */
define('Single_Property_Link', 			'/report/full-property.html');
define('Single_Property_Link_Title', 	'View Property');

define('Full_Property_Report_Link', 	'/report/full-property.html');
define('Market_Analysis_Report_Link', 	'/report/market-analysis.html');

define('Full_Property_Report_Link_Title', 		'Multiple Property Report');
define('Market_Analysis_Report_Link_Title', 	'Property Summary Report');
define('Market_Analysis_Report_Link_Title_Ex', 	'Property Summary Report');

define('Summary_Report_Title', 					'Property Summary Report');
define('Summary_Report_Title_Ex', 				'Property Summary Report');
define('Summary_Report_Sub_Title_Ex', 			'MV\'s for eXclusive Clients Only');

/* Page URL Constant For Admin Side */
define('Page_Listing_Utility',					'listing-utility.php');

define('Predefined_Search_Link', 				'/search/');
define('SEF_Homes_For_Sale', 				'homes-for-sale');

define('Sef_City',							'sitemap/%1$s/city/%2$s');
define('Sef_Suburb',						'sitemap/%1$s/suburb/%2$s');
define('Sef_Zip',							'sitemap/%1$s/zip/%2$s');
define('Sef_Zip_City',						'sitemap/%1$s/zip/%2$s/%3$s');
define('Sef_Suburb_City',					'sitemap/%1$s/suburb/%2$s/%3$s');

define('Sale_Search_Link',						'/search');

define('URL_SEPARATORBACKSLASE',            '/');
define('URL_SEPARATORDASH',                 '-');
define('URL_SEPARATORCOMMA',                ',');
define('URL_SEPARATORTIELD',                '~');
define('MAILTO_SEPARATORPIPE',              '|');

define('FIELD_SUBTYPE',             'type');
define('FIELD_PROP_CONDITION',      'pcond');
define('FIELD_SALETYPE',            'sale');
define('FIELD_STORIES_DESC',        'sdesc');

define('XHR',                   'XHR');
define('XHR_URL',               'URL');
define('XHR_AJAX',              'AJAX');
define('XHR_AREA',              'AREA');
define('XHR_MODULE',            'MODULE');
define('XHR_ACTION',            'ACTION');
define('XHR_R_ASSIGN',          'ASSIGN');
define('XHR_R_APPEND',          'APPEND');
define('XHR_R_PREPEND',         'PREPEND');
define('XHR_R_SCRIPT',          'SCRIPT');
define('XHR_R_REDIRECT',        'REDIRECT');
define('XHR_R_ERROR',           'ERROR');
define('XHR_R_SUCCESS',         'SUCCESS');
define('XHR_R_DATA',            'DATA');

define("VT_MAP",                'map');
define("VT_LIST",               'list');
define("VT_GALLERY",            'gallery');
define("VT_SITE_MAP",           'sitemsap');

define('DEFAULT_SO',                'dom');
define('DEFAULT_SD',                'desc');
define('DEFAULT_VT',                VT_MAP);

define('ASTYPE_ADD',            'add');
define('ASTYPE_ZIP',            'zip');
define('ASTYPE_CITYSTATE',      'cs');
define('ASTYPE_CITY',           'city');
define('ASTYPE_MLS',            'mls');
define('ASTYPE_AREA',           'area');
define('ASTYPE_COUNTY',         'county');
define('ASTYPE_SCHOOL',         'school');
define('ASTYPE_SUB',            'sub');
define('ASTYPE_AGENT',          'agent');
define('ASTYPE_GSRCH',          'gsrch');
define('ASTYPE_ALL',          'all');
define('ASTYPE_CITYCODE',          'cc');

define('SEARCH_URL',            '/for-sale/');
define('AGENT_URL',             '/agents/');

define('DATA_FROM_SITE',             '1');
define('DATA_FROM_APP',              '2');

define('COOKIE_GCR_SID', 'cgcr_sid');
define('COOKIE_GCR_CW',  'cgcr_cw');
define('COOKIE_GCR_RV',  'cgcr_rv');
define('COOKIE_GCR_WL',  'cgcr_wl');
define('COOKIE_GCR_IC',  'cgcr_ic');

define('TRACK_URL',                     'track');

define('AGENT_ROSTER',                     'Agent-Roster');



# Set number of results for each listing as per device type. As each device has different processor.

define('RESULT_PAGESIZE_MOBILE',             '6');

define('RESULT_PAGESIZE_REGULAR',            '50');
define('MAXRES_WITHOUT_LOGIN',               '1500');
define('MAXRES_WITH_LOGIN',                  '500');

/*if(cw::$screen == CW_S_XS || cw::$screen == CW_S_SM)

	define('RESULT_PAGESIZE',               RESULT_PAGESIZE_MOBILE);

else*/

define('RESULT_PAGESIZE',               RESULT_PAGESIZE_REGULAR);
define('RESULT_PAGESIZE_AGENT',              '1');
/*******************************************************************************************

 * NOTICE : DB_Custom constants

 * All below constants are related with class DB_Custom

 * Keep it at last in this file

 **/

define('L_BASE',                        'Language_Base');
define('L_TABLE_NAME',                  'LanguageTableName');
define('F_L_CODE',                      'F_Language_Code');
define('TABLE_NAME',                    'TableName');

define('O_TABLE_NAME',                  'OriginalTableName');
define('TABLE_FIELD_LIST',              'TableFieldList');
define('FIELD_PREFIX',                  'FieldPrefix');
define('F_F_INFO',                      'F_FieldInfo');
define('F_P_KEY',                       'F_PrimaryKey');
define('F_F_KEY',                       'F_Foreign_Key');
define('F_P_FIELD',                     'F_PrimaryField');
define('F_PARTITION_FIELD',             'F_PartitionField');
define('F_U_FIELD',                     'F_UniqueField');
define('F_CROSS_FIELD',                 'F_CrossField');
define('F_PARENT_FIELD',				'F_ParentField');
define('F_DELETE_RELATION',             'F_DeleteRelation');
define('F_DELETE_CUS_RELATION',         'F_DeleteCustomRelation');
define('F_D_FIELD',                     'F_Data_Field');
define('F_ACTIVE',                      'F_IsActive');
define('F_APPROVEDISAPPROVE',           'F_ApproveDisapprove');
define('F_VIRTUAL_DELETE',              'F_Virtual_Delete');
define('F_H_ITEM',                      'F_HeaderItem');
define('F_H_ALT',                       'F_HeaderItem_Alt');
define('F_SORT',                        'F_Sort');
define('F_B_SELECT',                    'F_BasicSelect');
define('F_S_URL',                       'F_Safe_Url');
define('F_NO_DEL',						'F_NoDelete');
define('F_PARENT_ID',					'F_Parent_ID');
define('F_CUSTOM_LIST',                 'F_CustomList');
define('F_ADDED_BY_ID',                 'F_AddedByIdField');
define('F_ADDED_BY_TYPE',               'F_AaddedByTypeField');
define('F_ADDED_DATETIME',              'F_AaddedDateTime');
define('F_REF_ID',                      'F_ReferenceId');
define('F_REF_TYPE',                    'F_ReferenceType');
define('F_UP_FOLDER_NAME',              'F_UploadFolderName');
define('P_UP',                          'P_Upload');
define('V_UP',                          'V_Upload');
define('IMG_RW_URL',                    'ImgReWriteUrl');

define('S_RECORD',                      'start_record');
define('P_SIZE',                        'page_size');
define('SO',                            'so');
define('SD',                            'sd');
define('ALPHA',                         'alpha');
define('GO_TO_PAGE',                    'page');
define('V_TYPE',                        'vt');

define('SD_ASC',                        'asc');
define('SD_DESC',                       'desc');

define('SEL_VAL',                       'SelValue');
define('S_FILTER',                      'Search_Filter');
define('E_DESC',                        'ErrorDescription');
define('S_IMG',                         'small');
define('M_IMG',                         'medium');
define('B_IMG',                         'big');
define('CUST_SORT_ORDER_STR',           'CustSortOrderString');
define('GROUP_BY',                      'GroupBy');
define('HAVING',                        'Having');
define('SQL_LIMIT',                     'SqlLIMIT');

define('C_COMMAND_LIST',				'C_CommandList');
define('C_POPUP_SIZE',					'C_PopupSize');

define('L_MODULE',						'L_Module');
define('H_MANAGE',						'H_Manage');
define('H_ADD_EDIT',					'H_AddEdit');

define("PRIVATELISTING_MLSP_ID",         '2');
define('A_PRIVATELISTING_PHOTO',         'PropertyPhoto');
define('A_PRIVATELISTING_FLOOR_PLAN',    'PropertyFloorPlan');
define('A_PRIVATELISTING_VIDEO_URL',    'PropertyVideoUrl');


# Cookie expire time
define('COOKIE_EXPIRE_TIME_MIN',        time()+12*3600);
define('COOKIE_EXPIRE_TIME_MAX',        time()+24*3600);

define('LOGIN_SCORE_INCRE',                   '1');
define('CONTACT_SCORE_INCRE',                   '2');
define('CONTACT_INQUIRY_SCORE_INCRE',            '10');

define('FPLAN_APPLY_TO_ENTIER_PROJECT',     1);
define('FPLAN_APPLY_MANNUALY',              2);

# Some comon fields in any database and in any table

define('F_FIXNAME_PRIMARY_KEY',                'id');

define('F_FIXNAME_PARENT_ID',                  'parent_id');

define('F_FIXNAME_IMAGE_FILE',                 'image_file');

define('F_FIXNAME_ATTACHMENT_FILE',            'attachment_file');

define('F_FIXNAME_TITLE',                      'title');

define('F_FIXNAME_NAME',                       'name');

define('F_FIXNAME_SHORT_DESC',                 'short_desc');

define('F_FIXNAME_FULL_DESC',                  'full_desc');

define('F_FIXNAME_NOTE',                       'note');

define('F_FIXNAME_SAFE_URL',                   'safe_url');

define('F_FIXNAME_LINK_TITLE',                 'link_title');

define('F_FIXNAME_PAGE_HEADING',               'page_heading');

define('F_FIXNAME_BROWSER_TITLE',              'browser_title');

define('F_FIXNAME_META_KEYWORD',               'meta_keyword');

define('F_FIXNAME_META_DESC',                  'meta_desc');

define('F_FIXNAME_META_EXTERNAL_TAG',          'meta_external_tag');

define('F_FIXNAME_DISPLAY_ORDER',              'display_order');//Remove order filed if found some wehere and make it sort order

//define('F_FIXNAME_is_visible',                 'is_visible'); //Remove this field and make it is_active in entire proh\ject

define('F_FIXNAME_IS_ACTIVE',                  'is_active');

define('F_FIXNAME_IS_DEFAULT',                 'is_default');

define('F_FIXNAME_IS_DELETED',                 'is_deleted');

define('F_FIXNAME_ADDED_BY_ID',                'added_by_id');

define('F_FIXNAME_ADDED_BY_TYPE',              'added_by_type');

define('F_FIXNAME_ADDED_DATETIME',             'added_datetime');

define('F_FIXNAME_UPDATED_DATETIME',           'updated_datetime');

define('F_FIXNAME_REF_ID',                     'ref_id');

define('F_FIXNAME_REF_TYPE',                   'ref_type');


define('LOCALLOGIC_NEARBYKEY',                'VH5Tw1lkaZ90zcB1Jt6XM4P0cpaORsNs3E7tZzO8');
/**
 * END : DB_Custom constants
 * DO NOT WRITE BELOW THIS LINE
 **************************************************************************************/

define('TIMESTAMP', '140687623');

define('DT_GENERATED',                  'DTGenerated');

define('CNT_SWITCH',                    'ControlSwitch');

define('SUB_ITEM_TOOTLTIP',             'SubItemTooltip');      #   Set sub item as a tooltip

define('LDSOURCE_SITE',		'Site');


define('ADMIN_ALT_URL',     'rpadmin');

define('DEFAULT_MLSP_ID',     '1');
define('DEFAULT_PRIVATE_MLSP_ID',     '2');


?>