<?php
/*
::REQUIREMENT::
Below are the steps we will need to follow for creating a function.

1] Create function name with,
function update_utm(html_source,utm_source=null, utm_medium=null, utm_campaign=null, utm_term=null, utm_content=null)
html_source - You will pass any HTML source code as string
Other function arguments
utm_source=null
utm_medium=null
utm_campaign=null
utm_term=null
utm_content=null


2] Will get all <a> tag and read href attribute from all <a> tag then will check for all attribute pass in function
utm_source=null, utm_medium=null, utm_campaign=null, utm_term=null, utm_content=null


If attribute is available in URL value, then replace it values with provided value from function argument.


3] If attribute is not available in URL value, then will add it in URL as query parameter.


4] Function will return same html source with all new values which you will pass in function argument.

Sample HTML Source Data availble in below file,

TC: 31-01-2024-> test.html

Below are the urls examples provided by client:

urls examples:
https://www.examples.com?t=1&utm_source=test1
https://www.examples.com?t=2&utm_source=test1&utm_medium=test1
https://www.examples.com/
https://www.examples.com/t=3


input utms 1
utm_source=A1, utm_medium=A2, utm_campaign=A3 other null

urls updated:
https://www.examples.com?t=1&utm_source=A1&utm_medium=A2&utm_campaign=A3
https://www.examples.com?t=2&utm_source=A1&utm_medium=A2&utm_campaign=A3
https://www.examples.com/?&utm_source=A1&utm_medium=A2&utm_campaign=A3
https://www.examples.com/t=3&&utm_source=A1&utm_medium=A2&utm_campaign=A3

SMPLE HTML
<a href="https://www.examples.com?t=1&utm_source=A1" style="width: 100%; line-height: 30px; font-family: Trebuchet MS, Helvetica, Arial, sans-serif; font-size: 12px; text-decoration: none; display: inline-block;"><img alt="Synergym Cosmos" border="0" class="social" src="https://graph.facebook.com/482216231881695/picture?type=normal" style="margin: 0px; padding: 0px 0px 20px; border: currentColor; border-image: none; height: auto; color: rgb(255, 255, 255); text-transform: capitalize; line-height: 100%; font-family: Helvetica, Arial, sans-serif; font-size: 13px; text-decoration: none; max-width: 460px;" /></a>

NOTE :- Function need to be compatible with php 7.4 with optimal implmentation
*/
// BEFORE
function update_utm(
    $html_source,
    $utm_source = null,
    $utm_medium = null,
    $utm_campaign = null,
    $utm_term = null,
    $utm_content = null
)
{
    //echo $html_source;
    // save original HTML
    $new_html = $html_source;

    // process html code for href attribute and modify url as per given algorithm
    //  using PHP inbuilt DOMDocument class
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);

    // extract <a> tag from html
    $dom->loadHTML($html_source); //htmlspecialchars($html_source)
    $pNodes = $dom->getElementsByTagName('a'); // we need <a> tag from html

    // determine how many <a> tag found
    if ($pNodes->length > 0) {
        // loop through all <a> tag and need to check url query string parameters
        foreach ($pNodes as $aTag) {
            $current_url = $aTag->getAttribute('href');
            $url_components = parse_url($current_url);

            //echo '<pre>'; print_r($url_components);
            /*
            output of components
            Array
            (
                [scheme] => https
                [host] => survey.socialwibox.com
                [path] => /survey.php
                [query] => r=5&s=ZXBRTWFMZ2w3K3grRTA0bStZSHVoQT09&u=*|SUR_ID_USUARIO|*&m=*|SUR_MAIL_ID|*&i=*|ID_INSTALACION|*
            )
            */

            // check if URL has query string available or not
            // it is also possible that urk has no query string but we need to add new as epr function parameters so set variable
            $params = [];
            if (isset($url_components['query'])) {
                parse_str($url_components['query'], $params);
            }

            // checking function parameters values to process URLs
            if (isset($utm_source) && $utm_source !== null) {
                $params['utm_source'] = $utm_source;
            }

            if (isset($utm_medium) && $utm_medium !== null) {
                $params['utm_medium'] = $utm_medium;
            }

            if (isset($utm_campaign) && $utm_campaign !== null) {
                $params['utm_campaign'] = $utm_campaign;
            }

            if (isset($utm_term) && $utm_term !== null) {
                $params['utm_term'] = $utm_term;
            }

            if (isset($utm_content) && $utm_content !== null) {
                $params['utm_content'] = $utm_content;
            }

            // create new URL based on updated query string
            /*
            Best way to generate URL from url components is using php's inbuilt function http_build_url
            But this required php_http extension to be enabled in php.in file
            I am not sure what configuration is available on server so not using this method

            # if we have added/updated some query parameters we need to generate URL string
            if(is_array($params) && count($params) > 0){
                $url_components['query'] = http_build_query($params);
            }

            # generate new url from components
            $new_url = http_build_url($current_url, $url_components);
            */

            // traditional way to build get new URL
            // generate new url using components concat
            $new_url = $url_components['scheme'].'://'.$url_components['host'].(isset($url_components['path']) ? $url_components['path'] : '');

            // if we have added/updated some query parameters we need to generate URL string
            if (is_array($params) && count($params) > 0) {
                $new_url = $new_url.'?'.urldecode(http_build_query($params));
            }

            // check the difference between old and new url
            //echo $current_url."<br>".str_replace("&","&amp;",$current_url)."<br>".$new_url."<br><br>";

            // This is very critical part of this script
            // replace new URL at right place in HTML
            // there are 2 possibilities with URL encoding which is not in our control as it comes as an input
            // So, we need to perform replace with 2 different approach
            // some URL might have query string contact with & character
            // some URL might have query string contact using html entity &amp;
            // there is also possibility that we do not have any query parameter in input url but we need to add as per function args
            // so, in that case we need to make sure the replacement process not to break or concat multiple times
            // so, we will try to replace entire href attribute in <a> tag
            // it is also possible that href attribute is using single ' or double " quote <a href=""> or <a href=''> so take for replacement

            // option 1 query string use &
            $new_html = str_replace("href='".$current_url."'", "href='".$new_url."'", $new_html); //<a href="">
            $new_html = str_replace('href="'.$current_url.'"', 'href="'.$new_url.'"', $new_html); //<a href=''>

            // option 2 query string use html entity &amp;
            $new_html = str_replace("href='".str_replace('&', '&amp;', $current_url)."'", "href='".$new_url."'", $new_html); //<a href="">
            $new_html = str_replace('href="'.str_replace('&', '&amp;', $current_url).'"', 'href="'.$new_url.'"', $new_html); //<a href=''>
        }
    }

    // return the processed html
    return $new_html;
}

// get html from test file to perform test
$html_source = file_get_contents('test.html');

// test call of function
echo update_utm($html_source, 'THATSEND');
