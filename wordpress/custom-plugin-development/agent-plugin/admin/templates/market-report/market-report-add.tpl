{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Market Reports Details</h2>

<form id="frmMarketReport" action="" method="post" enctype="multipart/form-data">
    <div class="tab-content">
        <div id="tab-marketrepo" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span8">
                    <div>
                        <label>Name</label>
                        <input type="text" id="mr_name" name="mr_name" value="{$rsMarketRepo.mr_name}" class="input-xxlarge required"/>
                        <label class="error" for="mr_name">Enter Market Report Name</label>
                    </div>

                    <div>
                        <label>Description</label>
                        <textarea id="mr_desc" name="mr_desc" class="input-xxlarge required">{$rsMarketRepo.mr_desc}</textarea>
                        <label class="error" for="mr_desc">Enter Market Report Description</label>
                    </div>
                    <div>
                        <label>City</label>
                        <select name="mr_city" {if $pk}disabled="disabled"{/if} class="input-xxlarge required">
                            {html_options options=$City disabled=disabled selected=$rsMarketRepo.mr_city}
                        </select>
{*                        <label class="error" for="mr_desc">Please Select City</label>*}
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
        jQuery(document).ready(function() {
            jQuery('#frmMarketReport').validate();
        });
    </script>
{/literal}