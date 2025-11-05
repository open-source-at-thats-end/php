{if !isset($MegaForm) && !isset($WithoutForm)}<form name="standard-listing-form" id="standard-listing-form" class="form-horizontal standard-listing-form " method="post" role="form" autocomplete="off" enctype="multipart/form-data" novalidate="novalidate">{/if}
    <div class="row">
        <div class="form-group col-xs-6 col-sm-4 col-md-3 col-lg-3">
            {if !isset($HideTopToolBar) && isset($QuickSearch)}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa  fa-search fa-flip-horizontal"></i></span>
                <input type="text" placeholder="Quick Search [Ctrl + Q]" class="form-control" id="quick-search">
            </div>
            {/if}
        </div>
        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
            {if !isset($HideTopToolBar) && isset($Pagination) && isset($PageSize) && isset($total_record) && $total_record > ''|current:$PageSize}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-list"></i></span>
                <select name="page_size" id="page_size" class="form-control bst-select" data-width="">
                    {html_options options=$PageSize selected=$smarty.session.page_size}
                </select>
            </div>
            {/if}
        </div>
        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
            {if !isset($HideTopToolBar) && isset($AlphaSortSelection)}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sort-alpha-asc"></i></span>
                    {html_alpha_sort_selection_box}
                </div>
            {elseif !isset($HideTopToolBar) && isset($AlphaSort)}
                {html_alpha_pager name=test linkClassName=""}
            {/if}

        </div>
        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
            {if !isset($HideTopToolBar) && isset($FieldSortSelection)}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                    {html_field_sort_selection_box dataItem=$F_HeaderItem}
                </div>
            {/if}
        </div>
        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
            {if !isset($HideTopToolBar) && isset($FieldSortSelection)}
                <div class="input-group">
                    {html_field_sort_order class='padding-none'}
                </div>
            {/if}
        </div>
        <div class="col-xs-6 col-sm-4 col-md-1 col-lg-1">
            {if !isset($HideTopAction)}{include file='layout/top-action.tpl' C_CommandList=$C_CommandList}{/if}
        </div>
    </div>
    <div class="separator bottom"></div>
    <div class="row table-responsive">
        <table id="standard-table" class="table {*table-responsive*} table-primary table-hover table-condensed {*swipe-horizontal*} border-bottom standard-table">
            <thead id="standard-table-thead">
                <tr>
                    {if $MassAction == true}
                        <th><input type="checkbox" class="check-uncheck-all" title="Check / Uncheck All" data-toggle="tooltip" data-placement="top"></th>
                    {/if}
                    {if isset($FieldSort) && !isset($FieldSortSelection)}
                        {html_sorting_link dataItem=$F_HeaderItem className="" templateImage=$TPL_images}
                    {else}
                        {foreach name=HeaderInfo from=$F_HeaderItem item=Header}
                            <th nowrap="nowrap">
                            {if isset($Header.Icon)}
                                <i class="{$Header.Icon}" title="{$Header.Title}" data-toggle="tooltip" data-placement="top"></i>
                            {elseif isset($Header.IconImage)}
                                <img src="{$TPL_images}/icon/{$Header.Icon}" title="{$Header.Title}" data-toggle="tooltip" data-placement="top">
                            {else}
                                {$Header.Title}
                            {/if}
                            </th>
                        {/foreach}
                    {/if}
                    {if isset($C_CommandList) && isset($F_Sort) && $smarty.const.A_SORT|in_array:$C_CommandList}
                        <th><i class="fa fa-exchange fa-rotate-90" title="Display Order" data-toggle="tooltip" data-placement="top"></i></th>
                    {/if}
                    {*Table gead for record action*}
                    {if !isset($HideRecordAction)}
                        <th>&nbsp;</th>
                    {/if}
                </tr>
            </thead>
            <tbody id="standard-table-body">
                {assign var=FieldDelete value='fname'|array_value:$F_NoDelete|default:''}
                {assign var=FieldDeleteVal value='fvalue'|array_value:$F_NoDelete|default:''}

                {assign var='full_colspan' value=count($F_HeaderItem)+1}
                {if $MassAction == true}{assign var='full_colspan' value=$full_colspan+1}{/if}
                {if isset($C_CommandList) && $smarty.const.A_SORT|in_array:$C_CommandList && isset($F_Sort)}{assign var='full_colspan' value=$full_colspan+1}{/if}

                {if isset($TreeList) && $TreeList === true}
                    {include file="layout/list-tree.tpl" node=$arrR_RecordSet level=0 entry=0 count=$count}
                {else}
                    {include file="layout/list-normal.tpl"}
                {/if}
            </tbody>
        </table>
    </div>
    <div class="separator bottom"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            {if $MassAction == true}
                {if isset($total_record) && $total_record > 0}
                    {*{include file="layout/with-selected-action.tpl" author_type_id=(isset($F_AddedByType)==true)|ifelse:($Record.$F_AddedByType|default:''|cat:$Record.$F_AddedById|default:''):''}*}
                    {include file="layout/with-selected-action.tpl" author_type_id=(isset($F_AddedByType))?($Record.$F_AddedByType|default:''|cat:$Record.$F_AddedById|default:''):''}
                {else}
                    {if $R_RecordSet->TotalRow > 1}
                        {include file="layout/with-selected-action.tpl" author_type_id=$R_RecordSet->f($F_AddedByType|default:'')|cat:$R_RecordSet->f($F_AddedById|default:'')}
                    {/if}
                {/if}
            {/if}
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
            {if !isset($HidePagerText) && $total_record > 0}
                {if isset($Pagination)}
                    {html_pager_text num_items=$total_record per_page=$smarty.session.page_size start_item=$smarty.session.start_record break='<br>'}
                {else}
                    {html_pager_text num_items=$total_record per_page=$total_record start_item=0 break='<br>'}
                {/if}
            {/if}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 text-right">
            {if isset($Pagination) && $total_record > $smarty.session.page_size && $smarty.session.page_size != -1}
                {html_pagination num_items=$total_record per_page=$smarty.session.page_size start_item=$smarty.session.start_record add_prevnext_text=true class='pagination-sm margin-none padding-none'}
            {/if}
        </div>
    </div>
    <input type="hidden" name="pk" value="{if isset($PK) && !empty($PK)}{Ocrypt::enc($PK)}{/if}" />
    <input type="hidden" name="active" />
    <input type="hidden" name="v_delete" />
    <input type="hidden" name="stock"/>
    <input type="hidden" name="Action" />
    <input type="hidden" name="move" />
    <input type="hidden" name="id" id="id" value="{$mid|default:''}" />
    <input type="hidden" name="parent_id" />
    <a href="#" id="hidden-link" class="hidden {if isset($UsingFancyBox)}popup-big{/if}" {if isset($UsingFancyBox)}data-fancybox-type="iframe" data-popup="true"{/if}></a>
{if !isset($MegaForm) && !isset($WithoutForm)}</form>{/if}
{if isset($HelpFile)}
    <div class="separator bottom"></div>
    <div class="row">{include file=$HelpFile}</div>
{/if}