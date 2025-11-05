{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Agent Details</h2>

<form id="frmAgent" action="" method="post" enctype="multipart/form-data">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span8">
                    <div>
                        <label>Photo</label>
                        <input type="file" name="agent_photo" id="agent_photo" class="input-xlarge" value="{$rsAgent.agent_photo}"/>
                        {if $rsAgent.agent_photo != ''}<br/><br />
                            <img src="{$agentImgUrl}{$rsAgent.agent_photo}" width="90"/>
                            <br><input type="checkbox" id= "del_agent_photo" tabindex="{$ControlTabIndex}" name="del_agent_photo" value="1" class="stdCheckbox"> Delete Agent Photo
                        {else}
                            <br><img src="{$agentImgUrl}no-agent-img.jpg" width="90"/>
                        {/if}

                        <input type="hidden" name="prev_agent_photo" value="{$rsAgent.agent_photo}" />
                    </div><br>
                    <div>
                        <label>First Name</label>
                        <input type="text" id="agent_first_name" name="agent_first_name" value="{$rsAgent.agent_first_name}" required class="input-xxlarge required"/>
                        <label class="error" for="agent_first_name">Enter Agent First Name</label>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" id="agent_last_name" name="agent_last_name" value="{$rsAgent.agent_last_name}" required class="input-xxlarge required"/>
                        <label class="error" for="agent_last_name">Enter Agent Last Name</label>
                    </div>
                    <div>
                        <label>Phone No.</label>
                        <input type="text" id="agent_phone" name="agent_phone" minlength="10" maxlength="15" value="{$rsAgent.agent_phone}" class="input-xxlarge phone_no- required"/>
                        <label class="error" for="agent_phone">Enter Agent Phone Number</label>
                    </div>
                    <div>
                        <label>About Agent</label>
                        <textarea id="agent_about" name="agent_about" class="input-xxlarge mb-2">{$rsAgent.agent_about}</textarea>
                        <label class="error" for="agent_about">Enter something about agent</label>
                    </div>
                    <div>
                        <label>Address</label>
                        <textarea id="agent_address" name="agent_address" class="input-xxlarge mb-2">{$rsAgent.agent_address}</textarea>
                        <label class="error" for="agent_address">Enter Agent Address</label>
                    </div>
                    <div>
                        <label>E-mail</label>
                        <input type="text" id="agent_email" name="agent_email" value="{$rsAgent.agent_email}" class="input-xxlarge required"/>
                        <label class="error" for="agent_email">Enter Agent E-mail</label>
                    </div>
                    <div>
                        <label>Site Title</label>
                        <input type="text" id="agent_site_title" name="agent_site_title" value="{$rsAgent.agent_site_title}" required class="input-xxlarge required"/>
                        <label class="error" for="agent_site_title">Enter Agent Site Title</label>
                    </div>
                    <div>
                        <label>Website</label>
                        <input type="text" id="agent_website" name="agent_website" value="{$rsAgent.agent_website}" required class="input-xxlarge required"/>
                        <p><b>Note:</b> Don't enter http with domain name.</p>
                        <label class="error" for="agent_website">Enter Agent Website</label>
                    </div>
                    <div>
                        <label>LogIn Screen Text</label>
                        <textarea id="agent_signin_text" name="agent_signin_text" class="input-xxlarge">{$rsAgent.agent_signin_text}</textarea>
                        <p><b>Note:</b> Enter Header Text for Log In screen.</p>
                        <label class="error" for="agent_signin_text">Enter Log In text</label>
                    </div>
                    {*<div>
                        <label>Photo/Video URL</label>
                        <input type="text" id="agent_condo_photo_video_url" name="agent_condo_photo_video_url" value="{$rsAgent.agent_condo_photo_video_url}"  class="input-xxlarge"/>
                    </div>*}
                    <div>
                        <label>Email Logo</label>
                        <input type="file" name="agent_print_photo" id="agent_print_photo" class="input-xlarge" value="{$rsAgent.agent_print_photo}"/>
                        {if $rsAgent.agent_print_photo != ''}<br/><br />
                            <img src="{$agentImgUrl}{$rsAgent.agent_print_photo}" width="90"/>
                            <br><input type="checkbox" id= "del_agent_print_photo" tabindex="{$ControlTabIndex}" name="del_agent_print_photo" value="1" class="stdCheckbox"> Delete Agent Photo <br><br>
                        {else}
                            <br><img src="{$agentImgUrl}default-print-logo.png" width="90"/> <br><br>
                        {/if}

                        <input type="hidden" name="prev_agent_photo" value="{$rsAgent.agent_photo}" />
                    </div>
                    {*<div>
                        <label>System Name</label>
                        <select id="agent_sys_name" name="agent_mls">
                            {foreach from=$arrAgentSystemName key=key item=item}
                                <option value="{$key}" {if $key == $rsAgent['agent_mls']}selected {elseif $rsAgent['agent_mls'] == '' && $key == {constant('Constants::MARBEACHES')}}selected{/if}>{$item}</option>
                            {/foreach}
                        </select>
                    </div>*}
                    {*<div class="pt-10">
                        <label>Is Enabled?</label>
                        {foreach from=$arrAgentSystemName key=key item=item}
                            <input type="radio" value="{$key}" name="agent_mls" {if $rsAgent['agent_mls'] == true && strtolower($rsAgent['agent_mls']) == $item}checked{else}checked{/if} class="input-xxlarge required">{$item}
                        {/foreach}
                    </div>*}
                    <div class="multi-options {$Field.addClass|default:''}">
                        <label class="multi-city">City</label>
                        <div class="aright">
                        </div>
                        {*<div id="actris" class="d-none">
                        {*{if isset($AgentSystemName)  && $AgentSystemName == 'actris'}*}
                           {* <label class="multi-city"><b>ACTRIS</b></label>
                            <div class="multi-options-container">
                                {html_checkboxes name="agent_city_serving" options=$arrACTRISCity separator='' cols='4'  selected=","|explode:$rsAgent.agent_city_serving|default:'' labels=true class='city-option'}
                            </div>
                        </div>*}
                        <div id="miami" class="">
                        {*{else}*}
                           {* <label class="multi-city"><b>MIAMI/BEACHES</b></label>*}
                            {*<div class="multi-options-container">
                                {html_checkboxes name="agent_city_serving" options=$City separator='' cols='4'  selected=","|explode:$rsAgent.agent_city_serving|default:'' labels=true class='city-option'}
                            </div>*}
                            <div class="multi-options-container">
                                {html_checkboxes name="agent_city_serving" options=$arrMIAMICity separator='' cols='4'  selected=","|explode:$rsAgent.agent_city_serving|default:'' labels=true class='city-option'}
                            </div>
                        </div>
                        {*{/if}*}
                    </div>
                    <div class="pt-10">
                        <label>Is Enabled?</label>
                        <input type="radio" value="1" name="agent_active" {if $rsAgent['agent_active'] == true}checked{else}checked{/if} class="input-xxlarge required">Yes
                        <input type="radio" value="0" name="agent_active" {if $rsAgent['agent_active'] != true}checked{/if} class="input-xxlarge required m-l-40">No
                    </div>
                    <div class="pt-10">
                        <label>Crypto Values?</label>
                        <input type="radio" value="1" name="crypto_active" {if $rsAgent['crypto_active'] == true}checked{else}checked{/if} class="input-xxlarge required">Yes
                        <input type="radio" value="0" name="crypto_active" {if $rsAgent['crypto_active'] != true}checked{/if} class="input-xxlarge required m-l-40">No
                    </div>
                    <div class="pt-10">
                        <label>Market Reports?</label>
                        <input type="radio" value="1" name="market_report_active" {if $rsAgent['market_report_active'] == true}checked{else}checked{/if} class="input-xxlarge required"> Yes
                        <input type="radio" value="0" name="market_report_active" {if $rsAgent['market_report_active'] != true}checked{/if} class="input-xxlarge required m-l-40"> No
                    </div>
                    <div class="pt-10">
                        <label><b>Select MLS </b></label><br>
                        <div class="multi-opt cols3 multi-options-container ">
                            {assign var=mls value=","|explode:$rsAgent['agent_select_mls']}
                            {foreach name=agent_select_mls from=$selectMLS key=mls_key item=value}
                                <label><input type="checkbox" name="agent_select_mls[]" {if (isset($rsAgent['agent_select_mls'])) && ($mls_key|in_array:$mls || $mls_key == $rsAgent['agent_select_mls'])}checked="checked"{/if} id="{$mls_key}" value="{$mls_key}" />&nbsp;{$value}</label>
                            {/foreach}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
        <input type="hidden" value="{$pk|default:''}" name="pk" />
        <input type="hidden" class="sys_name_change" value="No" name="sys_name_change" />
    </div>
</form>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            // Input Masking for Phone Number
            if(jQuery("input.phone_no").length)
            {
                jQuery("input.phone_no").mask("(999)-999-9999");
            }
            jQuery('#frmAgent').validate();

            jQuery('.generateKeyCode').on('click', function(){
                var randomnumber=Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                jQuery('#agent_key_code').val(randomnumber);
            });
            console.log(jQuery('#agent_system_name').val());

            jQuery("#agent_system_name").on('change', function () {

                console.log(jQuery('#agent_system_name').val());

            });
        });
    </script>
{/literal}