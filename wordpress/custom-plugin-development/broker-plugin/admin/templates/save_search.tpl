<script type="text/javascript">
    var url = '{$scriptname}';
</script>

<div class="main-panel" id="save-search-bg">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                          <i class="mdi mdi-home"></i>
                        </span> Save Search Details
            </h3>
        </div>
        {if isset($msgSuccess) || isset($msgError)}
            {if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
            {else}
                <div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
            {/if}
        {/if}

        {if isset($search_Id) && $search_Id != '' && $Action == 'save_search'}
            <div class="font-weight-bold mt-2 mb-1" id="save_search_option">What would you like to do next for this client?</div>
            <div class="save_search_link">
                <div class="pl-3"><a href="{$MainUrl}&action=email_listing_save_search{if $user_ref_Id != ''}&user_ref_id={$user_ref_Id}{else}&user_id={$user_Id }{/if}&search_id={$search_Id}" class="font-weight-bold" type="button">+ Email Listings + Save Search For Future Alerts </a></div>
                <div class="mt-1 pl-3"><a href="{$MainUrl}&action=edit_save_search{if $user_ref_Id != ''}&user_ref_id={$user_ref_Id}{else}&user_id={$user_Id }{/if}&search_id={$search_Id}" class="font-weight-bold" type="button">+ Modify Search</a></div>
            </div>

        {else}
            <form id="frmSaveSearch" class="frmPredSearch advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
                <div class="tab-content" id="form-content">
                    <div id="tab-agent" class="active tab-pane well wellmedpadd">
                        <div class="row-fluid">
                            <div class="span10-">
                                <h3>Basic Details</h3>
                                <div class="fholder2">
                                    <label><b>Title</b></label><br>
                                    <input type="text" id="psearch_title" name="psearch_title" value="{$rsSaveSearch.search_title}" class="input-lg required"required>
                                    <label class="error" for="psearch_title">Enter Predefined Search Title</label>
                                </div>

                                <br class="fclear">
                                <h3>Search Criteria</h3>
                                {include file='save_search_form.tpl'}
                                <div class="fright">
                                    <p class="result-count aright">
                                        <a href="JavaScript: void(0);" class="match btn bg-gradient-primary text-white" onclick="JavaScript: Show_MatchedListing();">{*<i class="fa fa-filter fa-lg"></i>*}&nbsp;<b>{$total_record|number_format:'0'} MATCHES</b></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn bg-gradient-primary text-white mt-3" value="Save" name="Submit" />
                    <input type="button" class="btn mt-3" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
                    <input type="hidden" value="{$pk|default:''}" name="pk" />
                </div>
            </form>
        {/if}
    </div>
</div>

{literal}
    <script type="text/javascript">
        jQuery(document).ready(function() {
            //jQuery('#frmPredSearch').validate();
        });
    </script>
{/literal}