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
                        <input type="file" name="agent_photo" id="agent_photo" class="input-xlarge" value="{$rsAgent['Agent_Photo']}" /><br/><br/>
                        {if $rsAgent['Agent_Photo'] != ''}
                            <img class="agent-photo" src="{$agentprofileImgUrl}{$rsAgent['Agent_Photo']}" width="90"/>
                            <br>
                            <input type="hidden" name="prev_agent_photo" value="{$rsAgent['Agent_Photo']}" /><br/><br/>
                            {*{else}
                                <img src="{$agentImgUrl}no-agent-img.jpg" width="90"/><br/><br/>*}
                            {*{/if}
                            {if $rsAgent.agent_photo != ''}<br/><br />
                                <img src="{$agentprofileImgUrl}{$rsAgent.agent_photo}" width="90"/>
                                <br><input type="checkbox" id= "del_agent_photo" tabindex="{$ControlTabIndex}" name="del_agent_photo" value="1" class="stdCheckbox"> Delete Agent Photo
                            *}
                       {* {else}
                            <br><img src="{$agentprofileImgUrl}no-agent-img.jpg" width="90"/>*}
                        {/if}

                    </div>
                    <div>
                        <label>First Name</label>
                        <input type="text" id="agent_first_name" name="agent_first_name" value="{if (isset($rsAgent['agent_first_name']))}  {$rsAgent['agent_first_name']}{/if}" required class="input-xxlarge required"/>
                        <label class="error" for="agent_first_name">Enter Agent First Name</label>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" id="agent_last_name" name="agent_last_name" value="{if (isset($rsAgent['agent_last_name']))} {$rsAgent['agent_last_name']}{/if}" required class="input-xxlarge required"/>
                        <label class="error" for="agent_last_name">Enter Agent Last Name</label>
                    </div>
                    <div>
                        <label>Phone No.</label>
                        <input type="text" id="agent_phone" name="agent_phone" minlength="10" maxlength="15" value="{if (isset($rsAgent['Agent_phone']))} {$rsAgent['Agent_phone']}{/if}" class="input-xxlarge phone_no- required"/>
                        <label class="error" for="agent_phone">Enter Agent Phone Number</label>
                    </div>
                    <div>
                        <label>Office No.</label>
                        <input type="text" id="agent_office" name="agent_office" minlength="10" maxlength="15" value="{if (isset($rsAgent['Agent_Office']))} {$rsAgent['Agent_Office']}{/if}" class="input-xxlarge phone_no- required"/>
                        <label class="error" for="agent_Office">Enter Agent Office Number</label>
                    </div>

                    <div>
                        <label>E-mail</label>
                        <input type="text" id="agent_email" name="agent_email" value="{if (isset($rsAgent['Agent_Email']))} {$rsAgent['Agent_Email']}{/if}" class="input-xxlarge required"/>
                        <label class="error" for="agent_email">Enter Agent E-mail</label>
                    </div>

                </div>
            </div>
        </div>
        <input type="submit" class="btn" value="Save" name="Submit" onclick="JavaScript: window.location='{$scriptname}';" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
        <input type="hidden" value="{$pk|default:''}" name="pk" />
    </div>
</form>
