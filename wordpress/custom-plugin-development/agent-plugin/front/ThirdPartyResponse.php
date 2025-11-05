<?php

if(!session_id()) {
    session_start();
}

if( !class_exists('ThirdPartyResponse')) {

    class ThirdPartyResponse
    {

        private static $instance;

        public function __construct()
        {

        }

        public static function getInstance()
        {
            if(!isset(self::$instance))
            {
                self::$instance = new ThirdPartyResponse();
            }

            return self::$instance;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getPageTemplate()
        {
            global $arrConfig;

            add_filter('template_include', function($default_template) {

                global $arrPhysicalPath;

                $templatefilename = 'detail_template.php';
                $template = $arrPhysicalPath['Base'] . $templatefilename;
                $default_template = $template;

                // Load new template also fallback if both condition fails load default
                return $default_template;

            }, 9999);
        }

        public function getContent($POST = '')
        {
            global $objTmpl, $arrPhysicalPath, $arrVirtualPath, $arrConfig;

            define('IN_SITE', true);
            define('IN_SOCIAL', true);

            $Action = isset($_GET['Action'])?$_GET['Action']:(isset($_POST['Action'])?$_POST['Action']:'');

            include_once($arrPhysicalPath['Libs']."AjaxResponse.php");

            if($Action == 'FACEBOOK')
            {
                # Include facebook SDK file
                # Include facebook SDK file
                require_once($arrPhysicalPath['Libs'].'/facebook/src/Facebook/autoload.php');

                $objFacebook    = new Facebook\Facebook(array(
                    'app_id'                =>  $arrConfig['SocialConfig']['fb_app_id'],// Facebook App ID
                    'app_secret'            =>  $arrConfig['SocialConfig']['fb_app_secret'],// Facebook App Secret
                    'default_graph_version' =>  'v2.6',
                ));

                $helper         =   $objFacebook->getRedirectLoginHelper();

                if(!isset($_GET['error']))
                {
                    try
                    {
                        $accessToken = $helper->getAccessToken();
                        //echo "<pre>"; print_r($accessToken);die;
                        $response = $objFacebook->get('/me?fields=id,name,first_name,last_name,link,gender,email,locale,timezone,updated_time,verified', $accessToken);
                        //echo "<pre>"; print_r($response);die;
                        //$response = $objFacebook->get('/me?fields=id,name,first_name,last_name,link,gender,email,locale,timezone,updated_time,verified',$accessToken);
                    }
                    catch(Facebook\Exceptions\FacebookResponseException $e)
                    {
                        // When Graph returns an error
                        echo 'Graph returned an error: '.$e->getMessage();
                        exit;
                    }
                    catch(Facebook\Exceptions\FacebookSDKException $e)
                    {
                        // When validation fails or other local issues
                        echo 'Facebook SDK returned an error: '.$e->getMessage();
                        exit;
                    }




                    $_SESSION['facebook'] = '';
                    $arrUser              = $response->getDecodedBody();

                    if(isset($arrUser['email']) && !empty($arrUser['email']))
                    {
                        $POST['user_email']             = $arrUser['email'];
                        $POST['user_first_name']        = ucwords(strtolower($arrUser['first_name']));
                        $POST['user_last_name']         = ucwords(strtolower($arrUser['last_name']));
                        $POST['registered_from_social'] = true;
                        $POST['user_is_verified']       = 'Yes';

                        $allowed_html   = array();
                        $user_email     = trim( sanitize_text_field(wp_kses( $POST['user_email'] ,$allowed_html) ) );
                        $user_name      = trim( sanitize_text_field(wp_kses( $POST['user_first_name'] .'_'.$POST['user_last_name'] ,$allowed_html) ) );

                        if(email_exists($user_email) == false)
                        {
                            $user_password  = wp_generate_password( $length=12, $include_standard_special_chars=false );
                            $user_data      = array('user_pass' => $user_password, 'user_login' => $user_email, 'user_nicename' => $POST['user_first_name'], 'display_name' => $user_name, 'user_email' => $user_email);
                            $user_name      = $POST['user_first_name'] .'_'.$POST['user_last_name'];
                            $user_id        = wp_create_user( $user_name, $user_password, $POST['user_email'] );

                            if (is_wp_error($user_id))
                            {
                                echo 'Please, check all your input(s). Make sure you have entered all valid information.';
                            }
                            else
                            {
                                $host_url               = get_home_url();
                                $wordpress_upload_dir   = wp_upload_dir();
                                $uploadPath             = $wordpress_upload_dir['baseurl'].'/';

                                $POST['lead_user_id'] = $user_id;
                                $lead                 = LPTLeadMaster::getInstance()->InsertRegistration($POST);
                                $hash                 = base64_encode($user_email);
                                $login_url            = $host_url.'?hash='.$hash;

                                update_user_meta($user_id, 'show_admin_bar_front', false);

                                # Email To User Start
                                $objTmpl->assign(array(
                                    "frmData"       => $POST,
                                    "password"      => $user_password,
                                    "Site_Title"    => get_option('blogname'),
                                    'user_name'     => $user_name,
                                    'user_pass'     => $user_password,
                                    'user_email'    => $user_email,
                                    'login_url'     => $login_url,
                                    'Host_Url'      => $host_url,
                                    'AgentInfo'     => $arrConfig['Agent'], //'logo'           => et_get_option( 'divi_logo' ),
                                    'logo'          => '',
                                    "title"         => '',
                                    "uploadPath"    => $uploadPath,
                                    "AgentImgUrl"   => $uploadPath
                                ));

                                $objTmpl->assign(array(
                                    "Email_Header"  => 'email_header.tpl',
                                    "Email_Body"    => 'email_register.tpl',
                                ));

                                # Prepare Email Data
                                $EmailTo      = $POST['user_name'].' <'.$POST['user_email'].'>';
                                $headers      = array('From: '.$arrConfig['Agent']['agent_email'].' <'.$arrConfig['Agent']['agent_name'].'>');
                                $EmailSubject = "Thank You For Signing Up";

                                $EmailBody = $objTmpl->fetch('email_layout.tpl');

                                add_filter('wp_mail_content_type', function( $content_type ) {
                                    return 'text/html';
                                });

                                wp_mail($EmailTo, $EmailSubject, $EmailBody);

                                # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                                remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
                                # Email to User End

                                #=======================================#
                                # Email to Admin
                                global $arrConfig;

                                $objTmpl->assign(array(
                                    "Email_Header"      => 'email_header.tpl',
                                    "Email_Body"        => 'email_register_to_admin.tpl',
                                    "LeadDate"          => date('m/d/Y - h:i A'),
                                    "LeadProfile"       => admin_url('admin.php?page='.Constants::SLUG.'-'.'user'),
                                    "RegistrationPage"  => $_SERVER['HTTP_REFERER'],
                                    'logo'              => $arrConfig['Agent']['print_photo'],
                                    "uploadPath"        => $uploadPath
                                ));

                                # Prepare Email Data
                                $EmailTo = $arrConfig['Agent']['agent_email'];

                                $EmailSubject = "New Website Lead - ".ucwords(strtolower(str_replace('_', " ", $user_name)))." @ ".date('H:i a')." - ".get_bloginfo();

                                $EmailBody = $objTmpl->fetch('email_layout.tpl');

                                $headers = array('From: '.$arrConfig['Agent']['agent_email'].' <'.$arrConfig['Agent']['agent_name'].'>');

                                # Send Email to Author
                                add_filter('wp_mail_content_type', function( $content_type ) {
                                    return 'text/html';
                                });
                                if(isset($arrConfig['Listing']['cc_emails']) && !empty($arrConfig['Listing']['cc_emails'])){
                                    $cc = explode(',', $arrConfig['Listing']['cc_emails']);
                                    foreach($cc as $email){
                                        $headers[] = 'Cc: '.$email;
                                    }
                                }

                                wp_mail($EmailTo, $EmailSubject, $EmailBody, $headers);

                                # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                                remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

                                $msgSuccess = 'Registration completed successfully';

                                if(isset($msgSuccess) && $msgSuccess != '')
                                {
                                    #After signup Login user
                                    $allowed_html = array();
                                    $login_user  =  wp_kses ( $user_name, $allowed_html );
                                    $login_pwd   =  wp_kses ( $user_password, $allowed_html);

                                    wp_clear_auth_cookie();
                                    $info                   = array();
                                    $info['user_login']     = $login_user;
                                    $info['user_password']  = $login_pwd;
                                    $info['remember']       = true;

                                    $user_signon            = wp_signon( $info, true );

                                    if ( is_wp_error($user_signon) ){
                                        echo "Wrong username or password!";
                                    } else
                                    {
                                        global $current_user;

                                        wp_set_current_user($user_signon->ID);
                                        do_action('set_current_user');
                                        $current_user = wp_get_current_user();

                                        echo '<script type="text/javascript">';

                                        # Don't Re-Load Logout Page and url with #login or #signup

                                        echo 'window.opener.location.reload();';
                                        echo 'window.close();';

                                        echo '</script>';
                                    }
                                }
                            }
                        }
                        else
                        {
                            $user = get_user_by("email", $arrUser['email']);

                            if($user != "FALSE")
                            {
                                wp_set_auth_cookie($user->ID);
                            }

                            echo '<script type="text/javascript">';
                            echo 'window.opener.location.reload();';
                            echo 'window.close();';
                            echo '</script>';
                        }

                        exit();
                    }
                    else
                    {
                        echo "Sorry, email is required for signup & login but your facebook profile has no email.";
                        exit;
                    }
                }
                else
                {
                    $error = true;
                    // if access denided => just close popup
                    if(isset($_GET['error']) && ($_GET['error'] == 'access_denied'))
                    {
                        echo '<script type="text/javascript">';
                        echo 'window.close();';
                        echo '</script>';
                        exit();
                    }
                    // else display some error message
                    else
                    {
                        echo "Some Error occured. Please try again later";
                        exit;
                    }
                }
            }
            elseif($Action == 'GOOGLE')
            {
                if(isset($_GET['code']) && !empty($_GET['code']))
                {
                    require_once($arrPhysicalPath['Libs'].'/googleplus/src/Google/Client.php');
                    require_once($arrPhysicalPath['Libs'].'/googleplus/src/Google/Service/Oauth2.php');

                    $objclient = new Google_Client();
                    $objclient->setApplicationName($arrConfig['SocialConfig']['web_name']); // Set your applicatio name
                    $objclient->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile')); // set scope during user login
                    $objclient->setClientId($arrConfig['SocialConfig']['gml_app_id']); // paste the client id which you get from google API Console
                    $objclient->setClientSecret($arrConfig['SocialConfig']['gml_app_secret']); // set the client secret
                    $url = $objclient->setRedirectUri(get_home_url().'/third-party-response/?Action=GOOGLE'); // paste the redirect URI where you given in APi Console. You will get the Access Token here during login success

                    $objoauth2 = new Google_Service_Oauth2($objclient);

                    $objclient->authenticate($_GET['code']);
                    $token = $objclient->getAccessToken();
                    $objclient->setAccessToken($token);

                    $google_user_profile = $objoauth2->userinfo->get();

                    if(isset($google_user_profile['email']) && !empty($google_user_profile['email']))
                    {
                        $POST['user_email']             = $google_user_profile['email'];
                        $POST['user_first_name']        = ucwords(strtolower($google_user_profile['givenName']));
                        $POST['user_last_name']         = ucwords(strtolower($google_user_profile['familyName']));
                        $POST['registered_from_social'] = true;
                        $POST['user_is_verified']       = 'Yes';

                        $allowed_html   = array();
                        $user_email     = trim( sanitize_text_field(wp_kses( $POST['user_email'] ,$allowed_html) ) );
                        $user_name      = trim( sanitize_text_field(wp_kses( $POST['user_first_name'] .'_'.$POST['user_last_name'] ,$allowed_html) ) );

                        if(email_exists($user_email) == false)
                        {
                            $user_password  = wp_generate_password( $length=12, $include_standard_special_chars=false );
                            $user_data      = array('user_pass' => $user_password, 'user_login' => $user_email, 'user_nicename' => $POST['user_first_name'], 'display_name' => $user_name, 'user_email' => $user_email);
                            $user_name      = $POST['user_first_name'] .'_'.$POST['user_last_name'];
                            $user_id        = wp_create_user( $user_name, $user_password, $user_email );

                            if (is_wp_error($user_id))
                            {
                                echo 'Sorry, that username already exists!';
                            }
                            else
                            {
                                $host_url               = get_home_url();
                                $wordpress_upload_dir   = wp_upload_dir();
                                $uploadPath             = $wordpress_upload_dir['baseurl'].'/';

                                $POST['lead_user_id'] = $user_id;
                                $lead                 = LPTLeadMaster::getInstance()->InsertRegistration($POST);
                                $hash                 = base64_encode($user_email);
                                $login_url            = $host_url.'?hash='.$hash;

                                update_user_meta($user_id, 'show_admin_bar_front', false);

                                # Email To User Start
                                $objTmpl->assign(array(
                                    "frmData"       => $POST,
                                    "password"      => $user_password,
                                    "Site_Title"    => get_option('blogname'),
                                    'user_name'     => $user_name,
                                    'user_pass'     => $user_password,
                                    'user_email'    => $user_email,
                                    'login_url'     => $login_url,
                                    'Host_Url'      => $host_url,
                                    'AgentInfo'     => $arrConfig['Agent'],
                                    'logo'          => '',
                                    "title"         => '',
                                    "uploadPath"    => $uploadPath,
                                    "AgentImgUrl"   => $uploadPath
                                ));

                                $objTmpl->assign(array(
                                    "Email_Header"  => 'email_header.tpl',
                                    "Email_Body"    => 'email_register.tpl',
                                ));

                                # Prepare Email Data
                                $EmailTo      = $user_name.' <'.$user_email.'>';
                                $headers      = array('From: '.$arrConfig['Agent']['agent_email'].' <'.$arrConfig['Agent']['agent_name'].'>');

                                $EmailSubject = "Thank You For Signing Up";

                                $EmailBody = $objTmpl->fetch('email_layout.tpl');

                                add_filter('wp_mail_content_type', function( $content_type ) {
                                    return 'text/html';
                                });

                                wp_mail($EmailTo, $EmailSubject, $EmailBody);

                                # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                                remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
                                # Email to User End

                                #=======================================#
                                # Email to Admin
                                global $arrConfig;

                                $objTmpl->assign(array(
                                    "Email_Header"      => 'email_header.tpl',
                                    "Email_Body"        => 'email_register_to_admin.tpl',
                                    "LeadDate"          => date('m/d/Y - h:i A'),
                                    "LeadProfile"       => admin_url('admin.php?page='.Constants::SLUG.'-'.'user'),
                                    "RegistrationPage"  => $_SERVER['HTTP_REFERER'],
                                    'logo'              => $arrConfig['Agent']['print_photo'],
                                    "uploadPath"        => $uploadPath
                                ));

                                # Prepare Email Data
                                $EmailTo = $arrConfig['Agent']['agent_email'];

                                $EmailSubject = "New Website Lead - ".ucwords(strtolower(str_replace('_', " ", $user_name)))." @ ".date('H:i a')." - ".get_bloginfo();

                                $EmailBody = $objTmpl->fetch('email_layout.tpl');

                                $headers = array('From: '.$arrConfig['Agent']['agent_email'].' <'.$arrConfig['Agent']['agent_name'].'>');

                                # Send Email to Author
                                add_filter('wp_mail_content_type', function( $content_type ) {
                                    return 'text/html';
                                });

                                if(isset($arrConfig['Listing']['cc_emails']) && !empty($arrConfig['Listing']['cc_emails'])){
                                    $cc = explode(',', $arrConfig['Listing']['cc_emails']);
                                    foreach($cc as $email){
                                        $headers[] = 'Cc: '.$email;
                                    }
                                }

                                wp_mail($EmailTo, $EmailSubject, $EmailBody, $headers);

                                # Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                                remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

                                $msgSuccess = 'Registration completed successfully';

                                if(isset($msgSuccess) && $msgSuccess != '')
                                {
                                    #After signup Login user
                                    $allowed_html = array();
                                    $login_user  =  wp_kses ( $user_name, $allowed_html );
                                    $login_pwd   =  wp_kses ( $user_password, $allowed_html);

                                    wp_clear_auth_cookie();
                                    $info                   = array();
                                    $info['user_login']     = $login_user;
                                    $info['user_password']  = $login_pwd;
                                    $info['remember']       = true;

                                    $user_signon            = wp_signon( $info, true );

                                    if ( is_wp_error($user_signon) ){
                                        echo "Wrong username or password!";
                                    } else
                                    {
                                        global $current_user;

                                        wp_set_current_user($user_signon->ID);
                                        do_action('set_current_user');
                                        $current_user = wp_get_current_user();

                                        echo '<script type="text/javascript">';

                                        # Don't Re-Load Logout Page and url with #login or #signup

                                        echo 'window.opener.location.reload();';
                                        echo 'window.close();';

                                        echo '</script>';
                                    }
                                }
                            }
                        }
                        else
                        {
                            $user = get_user_by("email", $google_user_profile['email']);

                            if($user != "FALSE")
                            {
                                wp_set_auth_cookie($user->ID);
                            }

                            echo '<script type="text/javascript">';
                            echo 'window.opener.location.reload();';
                            echo 'window.close();';
                            echo '</script>';
                        }
                        exit();
                    }
                    else
                    {
                        echo "Sorry, email is required for signup & login but your facebook profile has no email.";
                        exit;
                    }
                }
                else
                {
                    $error = true;
                    // if access denided => just close popupp
                    if(isset($_GET['error']) && ($_GET['error'] == 'access_denied'))
                    {
                        echo '<script type="text/javascript">';
                        echo 'window.close();';
                        echo '</script>';
                        exit();
                    }
                    // else display some error message
                    else
                    {
                        echo "Some Error occurred. Please try again later";
                        exit;
                    }
                }
            }
        }
    }
}

?>
