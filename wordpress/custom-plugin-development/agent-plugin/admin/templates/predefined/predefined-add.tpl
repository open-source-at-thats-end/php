<script type="text/javascript">
    var url = '{$scriptname}';
</script>
{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<h2>Predefined Search Details</h2>
<ul class="nav nav-tabs" id="myTab">
    <!--li class="active"><a data-toggle="tab" href="#tab1">RETS Setting</a></li-->
    <li class="active"><a data-toggle="tab" href="#tab-search">Search from</a></li>
    <li><a data-toggle="tab" class="bindMap" href="#tab-map">Map</a></li>
</ul>
<form id="frmPredSearch" class="frmPredSearch advanced-search search" action="" method="post" enctype="multipart/form-data" onsubmit="JavaScript: resetFormAttributes(this);">
    <div class="tab-content">
        <div id="tab-search" class="active tab-pane well wellmedpadd">
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
                        {* <b><input type="checkbox" id="psearch_generate_mrktreport" name="psearch_generate_mrktreport" value="Yes" {if $rsPredefined.psearch_generate_mrktreport == 'Yes'}checked{/if} class="input-lg"/> Generate Market Report</b>*}
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
        <div id="tab-map" class="tab-pane well wellmedpadd">
            <div class="row-fluid">
                {literal}
                    <style>
                        .field-list {max-height:500px; overflow:auto}
                        .sub-list {margin-left:20px; width:98%; padding:1%; background:#fff; float:left}
                        .sub-list label {float:left; width:48%;}
                        .sub-list label input {margin-right:3px;}
                    </style>
                {/literal}
                <div id="pms-area-map" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0 visible-xl d-xl-block te-half-map-div order-2 d-none ">
                    <div id="pms-map" data-map='true'>

                    </div>
                    <div id="map-infobox-small" class="oeibSmall hide-me">
                        <div class="ibContent"></div>
                    </div>
                    {*<div id="m-loader" class="hide-me-">
                        <div><img src="{$TPL_images}/ajax-loader-small.gif"/>&nbsp;Loading...</div>
                    </div>*}

                    <div class=" te-draw-radius-button  position-absolute">
                        <a id="btn_draw" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 show py-2" href="JavaScript:void(0)" role="button">
                            <i class="fas fa-draw-polygon text-secondary te-icon-draw"></i><br>draw
                        </a>
                        {*<a id="btn_cir" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                            <i class="far fa-dot-circle text-secondary te-icon-radius"></i><br>radius
                        </a>*}
                        <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 hide lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_cancel">Cancel</a>
                        <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 hide lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_remove">Reset</a>
                    </div>
                </div>

            </div>
            <span class="clearfix"></span>
        </div>
        <input type="submit" class="btn" value="Save" name="Submit" />
        <input type="button" class="btn" value="Cancel" name="Submit" onclick="JavaScript: window.location='{$scriptname}';"/>
        <input type="hidden" value="{$pk|default:''}" name="pk" />
        <input type="hidden" id="poly" name="poly" value="{$arrSearchCriteria.poly|default:''}">
        <input type="hidden" id="MapZoomLevel" name="mz" value="{$arrSearchCriteria.mz|default:13}">
        <input type="hidden" id="MapCenterLat" name="clat" value="{$arrSearchCriteria.clat|default:25.761681}">
        <input type="hidden" id="MapCenterLng" name="clng" value="{$arrSearchCriteria.clng|default:-80.191788}">
    </div>
</form>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function() {
            //jQuery('#frmPredSearch').validate();
        });
    </script>
{/literal}

<script type="text/javascript">
    var mapZoomLevel 	= {$mapZoomLevel};
    var mapCenterLat 	= {$mapCenterLat};
    var mapCenterLng 	= {$mapCenterLng};

</script>