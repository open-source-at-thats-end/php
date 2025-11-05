<script type="text/javascript" xmlns="http://www.w3.org/1999/html">
    var url = '{$scriptname}';
</script>
{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Development Page Details</h2>


<form id="frmDevelopmentUpload" class="frmDevelopment advanced-search search" action="https://looptcloud.com/upload/ImgUpload.php" method="post" enctype="multipart/form-data" >
    <div class="tab-content" style="overflow: hidden">
        <div {*id="tab-agent"*} class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <h3>Image Upload</h3><hr><br class="fclear">
                <div class="span10-">
                    <div class="fholder2">
                        <label><b>Main Photo</b></label><br>
                        <input type="file" name="main_photo" id="main_photo" class="input-lg" style="height: 40px" /><br/><br/>
                        {*{if $arrAgentConfig.main_photo != ''}
                            <img class="main_photo" src="{$uploadPath}{$arrAgentConfig.main_photo}" width="90"/>
                        {/if}*}
                    </div>
                    <div class="fholder2">
                        <label><b>Upload Photo</b></label><br>
                        <input type="file" name="photo[]" class="input-lg" style="height: 40px" multiple ><br/><br/>
                        {*{if $arrAgentConfig.main_photo != ''}
                            <img class="main_photo" src="{$uploadPath}{$arrAgentConfig.main_photo}" width="90"/>
                        {/if}*}
                    </div>
                </div>
                <input type="submit" class="btn" value="Upload" name="Upload" />
                <input type="hidden" value="{$pk|default:''}" name="pk" />
                <input type="hidden" value="{$action}" name="action" />
                <input type="hidden" value="{$addPK}" name="addPK" />
                <input type="hidden" value="{$RedirectURL}" name="RedirectURL" />
            </div>
        </div>
    </div>
</form>
<form id="frmDevelopment" class="frmDevelopment advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <h3>Basic Details</h3>

                    <div class="fholder2">
                        <label><b>Title</b></label></br>
                        <input type="text" id="dev_title" name="dev_title" value="{$rsDevelopment.dev_title}" class="input-lg required"/>
                        <label class="error" for="dev_title">Enter Development Title</label>
                    </div>

                    {*<div class="fholder2">
                        <label><b>Require Registration</b></label></br>
                        <select name="dev_require_reg" class="apm_monoselect input-lg">
                            {html_options options=$arrYesNo selected=$rsDevelopment['dev_require_reg']|default:"No"}
                        </select>
                    </div>*}

                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Link 1</b></label></br>
                        <input type="text" id="dev_link1" name="dev_link1" value="{$rsDevelopment.dev_link1}" class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Link 2</b></label></br>
                        <input type="text" id="dev_link2" name="dev_link2" value="{$rsDevelopment.dev_link2|default:""}"  class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Link 3</b></label></br>
                        <input type="text" id="dev_link3" name="dev_link3" value="{$rsDevelopment.dev_link3|default:""}"  class="input-lg for-search"/>
                        {*<div class="note">Enter address without Unit Number, City and State</div>*}
                    </div>
                    <div class="fholder2">
                        <label><b>Google Embeded Map Code  </b></label><br>
                        <textarea rows="10" id="dev_google_map_code" name="dev_google_map_code" class="input-lg mb-2">{$rsDevelopment.dev_google_map_code}</textarea>
                        <div class="note">Enter Google Embeded Map Code</div>
                    </div>
                    <br class="fclear">
                    <br class="fclear">
                    <div id="s_editor_head" class="fholder2- s_editor">
                        <label for="dev_content_head"><b>Head Content Section</b></label></br>
                        <textarea cols="80" rows="25" id="dev_content_head" name="dev_content_head">
                            {$rsDevelopment.dev_content_head}
                        </textarea>
                    </div>
                    <br class="fclear">
                    <hr>
                    <br class="fclear">
                    <div id="s_editor" class="fholder2- s_editor">
                        <label for="dev_content_build_info"><b>Building Information</b></label></br>
                        <textarea cols="80" rows="25" id="dev_content_build_info" name="dev_content_build_info">
                            {$rsDevelopment.dev_content_build_info}
                        </textarea>
                    </div>
                    <br class="fclear">
                    <hr>
                    <br class="fclear">
                    <div id="s_editor_footer" class="fholder2- s_editor">
                        <label for="dev_content_footer"><b>Footer Content Section</b></label></br>
                        <textarea cols="80" rows="25" id="dev_content_footer" name="dev_content_footer">
                                {$rsDevelopment.dev_content_footer}
                        </textarea>

                    </div>

                </div>
            </div>
        </div>

        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
        <input type="hidden" value="{$pk|default:''}" name="pk" />
        {*        <input type="hidden" value="Condominium" name="stype" />*}
    </div>
</form>
<br class="fclear">
<script type="text/javascript">
    CKEDITOR.replace( 'dev_content_head' );
    CKEDITOR.replace( 'dev_content_build_info' );
    CKEDITOR.replace( 'dev_content_footer' );
</script>