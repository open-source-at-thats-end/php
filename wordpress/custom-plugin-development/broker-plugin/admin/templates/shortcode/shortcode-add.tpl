{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Shortcode Details</h2>

<form id="frmshortcode" action="" method="post" enctype="multipart/form-data">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span8">
                    <div>
                        <label>Shortcode Name</label>
                        <input type="text" id="shortcode_name" name="shortcode_name" value="{$rsShortCode.shortcode_name}" class="input-xxlarge required"/>
                        <label class="error" for="shortcode_name">Enter Shortcode Name</label>
                    </div>
                    <div>
                        <label>Shortcode Detail</label>
                        <textarea class="input-xxlarge required" name="shortcode_detail">{$rsShortCode.shortcode_detail}</textarea>
                        <label class="error" for="shortcode_detail">Enter Shortcode Name</label>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
        <input type="hidden" value="{$pk|default:''}" name="pk" />
    </div>
</form>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){

            jQuery('#frmshortcode').validate();

        });
    </script>
{/literal}