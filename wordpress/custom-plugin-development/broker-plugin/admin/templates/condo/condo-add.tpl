<script type="text/javascript">
    var url = '{$scriptname}';
</script>
{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Condo Search Details</h2>

<form id="frmCondoSearch" class="frmCondoSearch advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    <h3>Basic Details</h3>
                    <div class="fholder2">
                        <b><input type="checkbox" id="csearch_generate_mrktreport" name="csearch_generate_mrktreport" value="Yes" {if $rsCondo.csearch_generate_mrktreport == 'Yes'}checked{/if} class="input-lg"/> Generate Market Report</b>
                    </div>
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_building" {if $rsCondo['csearch_building'] == 'Yes'}checked{/if} class="input-xxlarge required">&nbsp;<b>Building</b>
                    </div>
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_luxury" {if $rsCondo['csearch_luxury'] == 'Yes'}checked{/if} class="input-xxlarge required">&nbsp;<b>Luxury</b>
                    </div>
                    <br class="fclear">
                    <br class="fclear">
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_pet_friendly" {if $rsCondo['csearch_pet_friendly'] == 'Yes'}checked{/if} class="input-xxlarge required">&nbsp;<b>Pet-friendly</b>
                    </div>
                    <br class="fclear">
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Building Name</b></label></br>
                        <input type="text" id="csearch_name" name="csearch_name" value="{$rsCondo.csearch_name}" class="input-lg required"/>
                        <label class="error" for="csearch_name">Enter Condo Building Name</label>
                    </div>
                    <div class="fholder2">
                        <label><b>Limit Results by Number</b></label></br>
                            <input type="text" id="csearch_result_limit" name="csearch_result_limit" value="{$rsCondo.csearch_result_limit}" class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Tag</b></label></br>
                        <input type="text" id="csearch_tag" name="csearch_tag" value="{$rsCondo.csearch_tag|default:""}"  class="input-lg"/>
                    </div>
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Building Address*</b></label></br>
                        <input type="text" id="csearch_address" name="csearch_address" value="{$rsCondo.csearch_address|default:""}"  class="input-lg for-search" required/>
                        <div class="note">Enter address without Unit Number, City and State</div>
                    </div>
                    {*<div class="fholder2">
                        <label><b>City - {if $AgentSystemName == {constant('Constants::ACTRIS')}} ACTRIS {else} MIAMI/BEACHES {/if}*</b></label><br>
                        {if isset($AgentSystemName)  && $AgentSystemName == {constant('Constants::ACTRIS')}}
                            <div class="multi-opt cols3 multi-options-container">
                                <select name="city" class="apm_monoselect input-lg" required>
                                    <option value="">-- Select --</option>
                                    {html_options options=$arrMeta['CityState']['ACTRIS'] selected=$arrSearchCriteria.city}
                                    <div class="note">Enter address without Unit Number, City and State</div>
                                </select>
                            </div>
                        {else}
                            <div class="multi-opt cols3 multi-options-container">
                                <select name="city" class="apm_monoselect input-lg" required>
                                    <option value="">-- Select --</option>
                                    {html_options options=$arrMeta['CityState']['MIAMI/BEACHES'] selected=$arrSearchCriteria.city}
                                    <div class="note">Enter address without Unit Number, City and State</div>
                                </select>
                            </div><br>
                        {/if}
                    </div>*}
                    <div class="fholder2">
                        <label><b>City</b></label><br>
                        <input type="text" id="csearch_city" name="csearch_city" value="{$rsCondo.csearch_city}" class="input-lg for-search"/>
                        <div class="note">Enter city with state for ex., Miami, FL</div>
                    </div>
                    <div class="fholder2">
                        <label><b>Zipcode</b></label><br>
                        <input type="text" id="csearch_zipcode" name="csearch_zipcode" value="{$rsCondo.csearch_zipcode}" class="input-lg for-search"/>
                    </div>
                    <br class="fclear">
                    <div class="fholder2">
                        <label><b>Year Built</b></label><br>
                        <input type="text" id="csearch_year_built" name="csearch_year_built" value="{$rsCondo.csearch_year_built}" class="input-lg for-search"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Units</b></label></br>
                        <input type="text" id="csearch_unit" name="csearch_unit" value="{$rsCondo.csearch_unit|default:""}"  class="input-lg"/>
                    </div>
                    <div class="fholder2">
                        <label><b>Stories</b></label></br>
                        <input type="text" id="csearch_stories" name="csearch_stories" value="{$rsCondo.csearch_stories|default:""}"  class="input-lg"/>
                    </div>
                    <br class="fclear">
                    {*<div class="fholder2">
                        <label><b>Building Short Description</b></label></br>
                        *}{*<input type="text" id="csearch_short_desc" name="csearch_short_desc" value="{$rsCondo.csearch_short_desc|default:""}"  class="input-lg"/>*}{*
                        <textarea class="input-lg mb-2" id="csearch_short_desc" rows="4" name="csearch_short_desc">{$rsCondo.csearch_short_desc|default:""}</textarea>
                    </div>*}
                    {*<div class="fholder2">
                        <label><b>Photo/Video URL</b></label></br>
                        <input type="text" id="csearch_photo_video_url" name="csearch_photo_video_url" value="{$rsCondo.csearch_photo_video_url|default:""}"  class="input-lg"/>
                    </div>*}
                    <div class="fholder2">
                        <label><b>Is Visible?</b></label></br>
                        {*<input type="radio" value="1" name="csearch_is_visible" {if $rsCondo['csearch_is_visible?'] == true}checked{else}checked{/if} class="input-xxlarge required">&nbsp;Yes
                        <input type="radio" value="0" name="csearch_is_visible" {if $rsCondo['csearch_is_visible?'] != true}checked{/if} class="input-xxlarge required m-l-40">&nbsp;No*}
                        <select name="csearch_is_visible" class="apm_monoselect input-lg">
                            {html_options options=$arrYesNo selected=$rsCondo['csearch_is_visible']}
                        </select>
                    </div>
                    <div class="fholder2">
                        <label><b>Neighborhood</b></label></br>
                        {*<select name="csearch_neighborhood" class="apm_monoselect input-lg">
                            {html_options options=$arrMeta['Subdivision'] selected=$arrMeta['Subdivision']}
                        </select>*}
                        <input type="text" id="csearch_neighborhood" name="csearch_neighborhood" value="{$rsCondo.csearch_neighborhood|default:""}"  class="input-lg"/>
                    </div>
                     <div class="fholder2">
                        <label><b>Rental Restrictions</b></label></br>
                        <input type="text" id="csearch_rental_restrictions" name="csearch_rental_restrictions" value="{$rsCondo.csearch_rental_restrictions|default:""}"  class="input-lg"/>
                    </div>

                    <div class="fholder2">
                        <label><b>Amenities</b></label></br>
                        <input type="text" id="csearch_amenities" name="csearch_amenities" value="{$rsCondo.csearch_amenities|default:""}"  class="input-lg"/>
                        {*<input type="button" id="csearch_amenities_btn" name="csearch_amenities_btn" value="Add"  class="input-lg"/>*}
                    </div>
                    {*<label><b>Amenities</b></label></br>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="e.g. Swmming Pool" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                    </div>
                    <div class="input-group" id="Amenities-grp">
                        {foreach name='Amenities' from=$arrAmenities key=$key item=Record}
                            <input type="checkbox" class="btn-check" id="btn-check-{$key}" checked autocomplete="off">
                            <label class="btn btn-outline-secondary" id="amnt-label" for="btn-check-{$key}">{$Record}<button class="close" id="amnt-chk" data-dismiss="alert" type="button">X</button></label>
                        {/foreach}
                    </div>*}
                    <br class="fclear">
                    <div class="fholder2">
                        <input type="checkbox" value="Yes" name="csearch_display_in_agent" {if $rsCondo['csearch_display_in_agent'] == 'Yes'}checked{/if} class="input-xxlarge required">&nbsp;<b>Display in Agent</b>
                    </div>
                    <br class="fclear">
                    {*<br class="fclear">*}
                    {*<div id="s_editor" class="fholder2- s_editor">
                        <label><b>Building Description</b></label></br>
                        {php}
                            *}{*wp_editor( '{str_replace(' ','',$rsCondo['csearch_short_desc'])|default:""}', 'csearch_short_desc', $settings = array('textarea_rows'=> '10') );*}{*
                            wp_editor( "{$rsCondo.csearch_short_desc}", 'csearch_short_desc', $settings = array('textarea_rows'=> '10') );
                            *}{*$editor_id = 'custom_editor_box';
                            $uploaded_csv = get_post_meta( $post->ID, 'custom_editor_box', true);
                            wp_editor( $uploaded_csv, $editor_id );
                        {/php}
                        {wp_editor( "{$rsCondo.csearch_short_desc}", 'csearch_short_desc', {$settings})}
                    </div>*}
                    {*<div class="fholder2">
                        <b><input type="checkbox" id="csearch_generate_mrktreport" name="csearch_generate_mrktreport" value="Yes" {if $rsCondo.csearch_generate_mrktreport == 'Yes'}checked{/if} class="input-lg"/> Generate Market Report</b>
                    </div>*}
                    <br class="fclear">
                    <br class="fclear">
                </div>
            </div>
        </div>
        <h3 class="title-red">Search Criteria</h3>
        <div id="tab-agent" class="active tab-pane well wellmedpadd">
            <div class="row-fluid">
                <div class="span10-">
                    {include file='condo_search_form.tpl'}
                    <div class="fright">
                        <p class="result-count aright">
                            <a href="JavaScript: void(0);" class="match button" onclick="JavaScript: Show_MatchedListing();"><i class="fa fa-filter fa-lg"></i>&nbsp;<b>{$total_record|number_format:'0'} MATCHES</b></a>
                            <input type="hidden" name="Action" value="{$Action}">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <input id="condo-save" type="submit" {*onclick="AddMinMaxValues("{$pk}",'{$arrSearchCriteria}')"*} pk="{$pk}" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
        <input type="hidden" value="{$pk|default:''}" name="pk" />
        <input type="hidden" value="{$arrSearchCriteria}" name="searchC[]" class="searchC"/>
        <input type="hidden" value="Condominium" name="stype" />
    </div>
</form>