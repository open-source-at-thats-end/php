<script type="text/javascript">
    var url = '{$scriptname}';
</script>
{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Predefined Search Details</h2>

<form id="frmPredSearch" class="frmPredSearch advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <h3>Basic Details</h3>
                    <div class="fholder2">
                        <label><b>Title</b></label>
                        <input type="text" id="psearch_title" name="psearch_title" value="{$rsPredefined.psearch_title}" class="input-lg required"/>
                        <label class="error" for="psearch_title">Enter Predefined Search Title</label>
                    </div>
                    <div class="fholder2">
                        <label><b>Limit Results by Number</b></label>
                        <input type="text" id="psearch_result_limit" name="psearch_result_limit" value="{$rsPredefined.psearch_result_limit}" class="input-lg"/>
                    </div>

					<div class="fholder2">
						<label><b>Tag</b></label>
						<input type="text" id="psearch_tag" name="psearch_tag" value="{$rsPredefined.psearch_tag|default:""}"  class="input-lg"/>
					</div>
					<div class="fholder2">
						<b><input type="checkbox" id="psearch_generate_mrktreport" name="psearch_generate_mrktreport" value="Yes" {if $rsPredefined.psearch_generate_mrktreport == 'Yes'}checked{/if} class="input-lg"/> Generate Market Report</b>
						{if (isset($arrSearchCriteria.status) && $arrSearchCriteria.status !='renatl') || (is_array($arrSearchCriteria.status) &&  !in_array('rental',$arrSearchCriteria.status))}
							<b class="pl-10"><input type="checkbox" id="psearch_generate_rental" name="psearch_generate_rental" value="Yes" {if $rsPredefined.psearch_generate_rental == 'Yes'}checked{/if} class="input-lg"/> Generate Rentals Page</b>
						{/if}
						<b class="pl-10"><input type="checkbox" id="psearch_display_tab" name="psearch_display_tab" value="Yes" {if $rsPredefined.psearch_display_tab == 'Yes'}checked{/if} class="input-lg"/> Display Tab Layout?</b>
					</div>
                    <br class="fclear">
                    <h3>Search Criteria</h3>

                    {include file='search_form.tpl'}
                    <div class="fholder2">
                        <label><b>Sort By</b></label>
                        <select name="sort_by" class="apm_monoselect input-lg">
{*                            {*<option value="">Select</option>*}

                            {html_options options=$arrSortingOption selected=$arrSearchCriteria.sort_by|default:''}
                        </select>
                    </div>
                    {*<div class="fholder2">
                        <label><b>Sytem Name</b></label>
                        <select name="sys_name" class="apm_monoselect input-lg">
                            <option value="">All</option>
                            {html_options options=$arrSystemName selected=$arrSearchCriteria.sys_name|default:''}
                        </select>
                    </div>*}

                    <div class="fright">
                        <p class="result-count aright">
                            <a href="JavaScript: void(0);" class="match button" onclick="JavaScript: Show_MatchedListing();"><i class="fa fa-filter fa-lg"></i>&nbsp;<b>{$total_record|number_format:'0'} MATCHES</b></a>
                            <input type="hidden" name="Action" value="{$Action}">
                        </p>
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
            //jQuery('#frmPredSearch').validate();
        });
    </script>
{/literal}