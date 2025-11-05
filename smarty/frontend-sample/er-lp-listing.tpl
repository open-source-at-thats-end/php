<div id="pr-listing-area" class="row">
    <form name="pr-criteria-form" id="lr-criteria-form" method="post" autocomplete="off" role="search" action="">
        <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <input type="hidden" name="{SO}" value="{$arrParams.SO}" />
            <input type="hidden" name="{SD}" value="{$arrParams.SD}" />
            <input type="hidden" name="{GO_TO_PAGE}" value="{$arrParams.GO_TO_PAGE+1}" />
            <input type="hidden" name="{P_SIZE}" value="{$arrParams.P_SIZE}" />
            <input type="hidden" name="t_record" value="{$total_record}" />
            {if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM || cw::$screen == CW_S_MD}
            <div class="row hidden-lg-up toolbar-sm">
                <div class="col-xs-3 col-sm-4 col-md-3 col-lg-3 col-xl-3 lr-viewmode-2">
                    <label class="m-b-0 text-small"><i id="lvt-icon" class="fa fa-th-large"></i> View</label>
                    <select id="{LISTING_VIEW_TYPE}" name="{LISTING_VIEW_TYPE}" class="form-control text-xs-center">
                        {foreach from=$arr_LP_ViewType key=id item=info}
                            <option value="{$id}" data-icon="{$info.icon}" {if $arrParams.LISTING_VIEW_TYPE == $id}selected="selected"{/if}>{$info.title}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-xs-5 col-sm-4 col-md-6 col-lg-6 col-xl-6 lr-sort-by-2">
                    <div class="form-group m-b-0">
                        <label class="m-b-0 text-small"><i class="fa fa-sort"></i>&nbsp; Sort By</label>
                        <select id="so_sd" name="so_sd"  class="form-control text-xs-center">
                            {html_options crypt_value=false options=$arr_LP_SortBy|default:'' selected=$arrParams.so_sd|default:'1:desc'}
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3 lr-show-filter">
                    <a data-toggle="modal" data-target="#lr-filter-modal" href="javascript:void(0);" class="filter-text">&nbsp; <i class="fa fa-filter fa-2x"></i><span>Filter</span><small>Result : <span id="lr-tr-count">{$total_record}</span></small></a>
                </div>
            </div>
            {else}
            <div class="row hidden-sm-down toolbar-lg">
                <div class="col-xs-5 col-sm-6 col-md-2 col-lg-2 col-xl-2 p-a-0 text-xs-left lr-viewmode-1">
                    {foreach from=$arr_LP_ViewType key=id item=info}
                    <span>
                        <input type="radio" name="lvt" id="lvt-{$id}" value="{$id}" {if isset($arrParams.LISTING_VIEW_TYPE) && $arrParams.LISTING_VIEW_TYPE == $id}checked="checked"{/if} />
                        <label for="lvt-{$id}"><i class="{$info.icon} fa-2x"></i></label>
                    </span>
                    {/foreach}
                </div>
                <div class="col-xs-7 col-sm-6 col-md-3 col-lg-2 col-xl-2 p-a-0 text-xs-center lr-total">
                    Total Result : <strong id="lr-tr-count">{$total_record}</strong>
                </div>
                <div id="lr-pagination" class="col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 p-a-0 text-xs-right lr-pagination">
                    {include file="tpl_er_lp/er-lp-pagination.tpl"}
                </div>
            </div>
            {/if}
        </section>
        {if cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}
        <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row hidden-sm-down">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 lr-sort-by-1">
                    <ul id="so_sd">
                        <li>Sort By : </li>
                        {foreach from=$arr_LP_SortBy key=id item=title}
                            <li><input type="radio" name="so_sd" id="{$id}" value="{$id}" {if isset($arrParams.so_sd) && $arrParams.so_sd == $id}checked="checked"{/if} /><label for="{$id}">{$title}</label> </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </section>
        {/if}
    </form>
    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div id="pr-listing" class="{if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM}row{/if}" data-lvt-prc="{if $arrParams.LISTING_VIEW_TYPE == LVT_LIST}l{else}g{/if}">
            {include file="tpl_er_lp/er-lp-listing-view.tpl"}
        </div>
    </section>
    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="row">
            <div id="pr-loading-btnmsg" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 processing-bottom">
                {include file="tpl_er_lp/er-lp-loading-btnmsg.tpl"}
            </div>
        </div>
    </section>
    {if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM || cw::$screen == CW_S_MD}
    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="row hidden-lg-up">
            <div id="lr-pagination" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center lr-pagination lr-pagination-sm">
                {include file="tpl_er_lp/er-lp-pagination.tpl"}
            </div>
        </div>
    </section>
    {/if}
    <div class="modal fade modal-theme-1 {if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM || cw::$screen == CW_S_MD}modal-expanded{/if}" id="lr-etc-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog {if cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}{/if} modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-left p-a-0">
                        <button type="button" class="close back-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-angle-left fa-2x"></i> </span>
                        </button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 p-a-0"><h5 class="p-t-1 p-r-1 text-xs-right">Quick View</h5></div>
                </div>
                <div class="modal-body bg-off-white"></div>
            </div>
        </div>
    </div>
</div>