{if isset($isPredefined) && $isPredefined == true && isset($isGrid) && $isGrid != 'true'}
    {if isset($isPredefined) && $isPredefined == true && (isset($isFilter) && $isFilter !== 'false') || (isset($psearch_display_tab) && $psearch_display_tab == 'Yes' && isset($tabs) && $tabs !== 'false')}
        <div class="row te-search-filter-row- {if $isstyle == ''}justify-content-start btn-gray {else}justify-content-between{/if} pre-filter-line pb-2- pr-1- border-bottom- bg-white {if isset($isGrid) && $isGrid == 'true' && isset($isstyle) && ($isstyle !== false)} px-3 {/if} customize-ldesign {if isset($isPredefined) && ($isPredefined == 'true' || $isPredefined == true)}no-follow-link{/if}">
        {*{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}*}
        {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes' && isset($tabs) && $tabs !== 'false'}
            <div class="col-12 col-xl-8 col-lg-8 {*{if isset($isGrid) && $isGrid == 'true'}col-xl-8 col-lg-8{else}col-xl-12 col-lg-12{/if}*} col-md-8  pl-md-2  pr-md-0  px-1 text-md-left text-center align-self-center btn-gray py-2 border-btm pl-xl-3">
                <a href="{$shareUrl}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 lpt-btn- lpt-btn-txt-"><i class="fa fa-th pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> {if isset($is_rental) && $is_rental == true} GRID VIEW {else}GRID VIEW{/if}</a>
                <a href="{$Site_Url}{Constants::TYPE_SALES}/{str_replace(' ', '-', $presearch_title)}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> LIST VIEW</a>
                <a href="{$Site_Url}{Constants::TYPE_RENTALS}/{str_replace(' ', '-', $presearch_title)}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> RENTALS</a>
                <a href="{$Site_Url}{Constants::TYPE_SOLD}/{str_replace(' ', '-', $presearch_title)}" class="btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12  shadow-none p-lg-2 p-xl-2 px-1 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab{/if} rounded-0 tab-btn-"><i class="fa fa-list pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i> PAST SALES</a>
            </div>
        {elseif isset($isFilter) && $isFilter !== 'false' && $isFilter !== false}
            {if $isstyle == ''}
                <form class="form w-25 d-none d-lg-block d-xl-block pre-search py-1- {if isset($isPredefined) && $isPredefined == true }pre-search-arrow {/if}" id="frmlistingsearch" role="form" method="post" action="{$formAction}">
                    <div class="col-12 {if isset($isGrid) && $isGrid == 'true'}col-xl-8 col-lg-8{else}col-xl-12 col-lg-12{/if} col-md-12 pl-md-2  pr-md-0  px-1 py-3- pt-11- align-self-center- btn-gray d-none d-lg-flex align-items-center {if isset($isGrid) && $isGrid !== 'true'}d-xl-inline-flex justify-content-between- text-center h-100{/if}">
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap search-btn-hover d-inline-flex justify-content-around h-100 {if isset($isGrid) && $isGrid == 'true'}pr-xl-3 pr-lg-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-xl-1 pr-lg-1 px-xl-5 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-4{/if}{/if} pr-1">
                            <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price
                            </a>
                            <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div class="te-width-max-content">
                                            <input type="text" name="minprice" value="{$arrSearchCriteria.minprice}" class="form-control rounded-0 fprice" id="minprice" placeholder="Min Price" aria-describedby="min price">
                                        </div>
                                        <div class="mx-3 align-self-center"> To </div>
                                        <div class="te-width-max-content">
                                            <input type="text" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="form-control rounded-0 fprice" id="maxprice" placeholder="Max Price" aria-describedby="max price">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div id="price-range"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap search-btn-hover d-inline-flex justify-content-around h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-xl-3 pr-lg-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-xl-1 pr-lg-1 px-xl-5 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-4 {/if}{/if} pr-1 pl-0 ">
                            <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Beds</a>
                            <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div class="te-width-max-content- w-100">
                                            <select class="custom-select rounded-0 fbed pr-5 py-0" name="minbed">
                                                <option value="" selected>Min</option>
                                                {html_options options=$arrBedRange selected=$arrSearchCriteria.minbed}
                                            </select>
                                        </div>
                                        <div class="mx-3 align-self-center"> To </div>
                                        <div class="te-width-max-content- w-100">
                                            <select class="custom-select rounded-0 fbed pr-5 py-0" name="maxbed">
                                                <option value="" selected>Max</option>
                                                {html_options options=$arrBedRange selected=$arrSearchCriteria.maxbed}
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap search-btn-hover d-inline-flex justify-content-around h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-3{if isset($isPredefined) && $isPredefined == 'true'} px-xl-3 {/if}{else}pr-1 px-xl-5 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-4{/if} {/if} pl-0">
                            <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Square Ft
                            </a>
                            <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div class="te-width-max-content">
                                            <select name="minsqft" class="custom-select rounded-0 fsqft shadow-none">
                                                <option value="" selected="">Min</option>
                                                {html_options options=$arrSqftRange selected=$arrSearchCriteria.minsqft}
                                            </select>
                                        </div>

                                        <div class="mx-3 align-self-center"> To </div>
                                        <div class="te-width-max-content">
                                            <select name="maxsqft" class="custom-select rounded-0 fsqft shadow-none">
                                                <option value="" selected="">Max</option>
                                                {html_options options=$arrSqftRange selected=$arrSearchCriteria.maxsqft}
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            {else}
                <div class="col-12 {if isset($isGrid) && $isGrid == 'true'}col-xl-8 col-lg-8{else}col-xl-3 col-lg-3{/if} col-md-12 pl-md-2  pr-md-0  px-1 py-2 pt-11- align-self-center- btn-gray d-none d-lg-flex align-items-center">
                    <form class="form w-100 d-none d-lg-block d-xl-block pre-search py-1 {if isset($isPredefined) && $isPredefined == true }pre-search-arrow {/if}" id="frmlistingsearch" role="form" method="post" action="{$formAction}">
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 {if isset($isGrid) && $isGrid == 'true'}pr-xl-3 pr-lg-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-xl-1 pr-lg-1 px-xl-3 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-3{/if}{/if} pr-1 px-0">
                            <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price
                            </a>
                            <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div class="te-width-max-content">
                                            <input type="text" name="minprice" value="{$arrSearchCriteria.minprice}" class="form-control rounded-0 fprice" id="minprice" placeholder="Min Price" aria-describedby="min price">
                                        </div>
                                        <div class="mx-3 align-self-center"> To </div>
                                        <div class="te-width-max-content">
                                            <input type="text" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="form-control rounded-0 fprice" id="maxprice" placeholder="Max Price" aria-describedby="max price">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div id="price-range"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-xl-3 pr-lg-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-xl-1 pr-lg-1 px-xl-3 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-3 {/if}{/if} pr-1 pl-0 ">
                            <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center font-size-sm-12 te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Beds</a>
                            <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content pre-dropdowen">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div class="te-width-max-content- w-100">
                                            <select class="custom-select rounded-0 fbed pr-5 py-0" name="minbed">
                                                <option value="" selected>Min</option>
                                                {html_options options=$arrBedRange selected=$arrSearchCriteria.minbed}
                                            </select>
                                        </div>
                                        <div class="mx-3 align-self-center"> To </div>
                                        <div class="te-width-max-content- w-100">
                                            <select class="custom-select rounded-0 fbed pr-5 py-0" name="maxbed">
                                                <option value="" selected>Max</option>
                                                {html_options options=$arrBedRange selected=$arrSearchCriteria.maxbed}
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {if isset($isGrid) && $isGrid == 'true' }
                            <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-3 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}pr-1 px-xl-2 px-0 {/if} pl-0">
                                <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Baths
                                </a>
                                <div class="dropdown-menu mt-12 bg-white px-4 border rounded-0">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 px-3 py-0">
                                            <div class="custom-control custom-radio py-2">
                                                <input type="radio" class="custom-control-input fbath" {if $arrSearchCriteria.minbath == ''}checked{/if} value="" name="minbath" id="bath-any">
                                                <label class="custom-control-label" for="bath-any">Any</label>
                                            </div>
                                            {foreach name=bath from=$arrBathRange key=bathkey item=bathitem}
                                                <div class="custom-control custom-radio py-2">
                                                    <input type="radio" class="custom-control-input fbath" {if $arrSearchCriteria.minbath == $bathkey}checked{/if} value="{$bathkey}" name="minbath" id="bath-{$bathkey}">
                                                    <label class="custom-control-label" for="bath-{$bathkey}">{$bathitem}</label>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds {if isset($isGrid) && $isGrid == 'true'}pr-3{if isset($isPredefined) && $isPredefined == 'true'} px-xl-3 {/if}{else}pr-1 px-xl-3 px-0 {if isset($isPredefined) && $isPredefined == 'true'}col-3{/if} {/if} pl-0">
                            <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Square Ft
                            </a>
                            <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 d-flex py-1">
                                        <div class="te-width-max-content">
                                            <select name="minsqft" class="custom-select rounded-0 fsqft shadow-none">
                                                <option value="" selected="">Min</option>
                                                {html_options options=$arrSqftRange selected=$arrSearchCriteria.minsqft}
                                            </select>
                                        </div>

                                        <div class="mx-3 align-self-center"> To </div>
                                        <div class="te-width-max-content">
                                            <select name="maxsqft" class="custom-select rounded-0 fsqft shadow-none">
                                                <option value="" selected="">Max</option>
                                                {html_options options=$arrSqftRange selected=$arrSearchCriteria.maxsqft}
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {if isset($isGrid) && $isGrid == 'true'}
                            <div class="dropdown d-none d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 pr-3 pl-0 {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}">
                                <a class="btn dropdown-toggle rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Waterfront
                                </a>
                                <div class="dropdown-menu mt-12 bg-white px-3 py-2 border rounded-0">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 py-0">
                                            <div class="custom-control custom-radio py-2">
                                                <input type="radio" class="custom-control-input fwf" {if $arrSearchCriteria.waterfront == ''}checked{/if} value="" name="waterfront" id="wf-any">
                                                <label class="custom-control-label" for="wf-any">Any</label>
                                            </div>
                                            {foreach name=beds from=$arrYesNo key=wfkey item=wfitem}
                                                <div class="custom-control custom-radio py-2">
                                                    <input type="radio" class="custom-control-input fwf" {if $arrSearchCriteria.waterfront == $wfkey}checked{/if} value="{$wfkey}" name="waterfront" id="wf-{$wfkey}">
                                                    <label class="custom-control-label" for="wf-{$wfkey}">{$wfitem}</label>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown d-none d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 pr-3 pl-0 {if isset($isPredefined) && $isPredefined == 'true' && isset($isGrid) && $isGrid == 'true'}px-xl-3 {/if}">
                                <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab  {else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pets
                                </a>
                                <div class="dropdown-menu mt-12 bg-white px-3 py-2 border rounded-0">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 py-0">
                                            <div class="custom-control custom-radio py-2">
                                                <input type="radio" class="custom-control-input fpetsa" {if $arrSearchCriteria.petsallowed == ''}checked{/if} value="" name="petsallowed" id="pets-any">
                                                <label class="custom-control-label" for="pets-any">Any</label>
                                            </div>
                                            {foreach name=beds from=$arrYesNo key=petskey item=petsitem}
                                                <div class="custom-control custom-radio py-2">
                                                    <input type="radio" class="custom-control-input fpetsa" {if $arrSearchCriteria.petsallowed == $petskey}checked{/if} value="{$petskey}" name="petsallowed" id="pets-{$petskey}">
                                                    <label class="custom-control-label" for="pets-{$petskey}">{$petsitem}</label>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown d-inline-block py-0 filter-dropdown te-white-space-no-wrap h-100 xl-beds pr-3 pl-0">
                                <a class="btn dropdown-toggle {if isset($isGrid) && $isGrid == 'true'}f-tab {if isset($isPredefined) && $isPredefined == 'true'}px-xl-3 {/if}{else}font-tab{/if} rounded-0 shadow-none align-self-center te-font-weight-500 px-0 d-none d-lg-block d-xl-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Year built
                                </a>
                                <div class="dropdown-menu mt-12 bg-white p-3 border rounded-0 te-min-width-max-content">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 d-flex py-1">
                                            <div class="te-width-max-content">
                                                <select name="minyear" class="custom-select rounded-0 shadow-none fyear">
                                                    <option value="" selected="">Min</option>
                                                    {html_options options=$arrminYearBuild selected=$arrSearchCriteria.minyear}
                                                </select>
                                            </div>

                                            <div class="mx-3 align-self-center"> To </div>
                                            <div class="te-width-max-content">
                                                <select name="maxyear" class="custom-select rounded-0 shadow-none fyear">
                                                    <option value="" selected="">Max</option>
                                                    {html_options options=$arrmaxYearBuild selected=$arrSearchCriteria.maxyear}
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                    </form>
                </div>
            {/if}
        {/if}
        <div class="col-12 {if isset($isGrid) && $isGrid == 'true'}col-xl-4 col-lg-4 {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}text-sm-right{/if} {if isset($isPredefined) && $isPredefined == true} justify-content-between- justify-content-sm-center font-size-sm-10 {if cw::$screen !== 'XS'}p-unset{/if} justify-content-md-end px-xl-3 {/if} {else} justify-content-between- justify-content-sm-end- {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'} {if isset($isGrid) && $isGrid !== 'true'}col-xl-4 col-lg-4 {else} col-xl-12 col-lg-12 mt-lg-2 {/if} {else} {if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'No'} col-xl-3 col-lg-3 text-right {else} col-xl-9 col-lg-9 {/if}{/if}{/if}   px-1- px-md-0-  text-left {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'} btn-gray col-md-4 justify-content-between py-1 {else} btn-gray col-md-12 py-2 {/if}  pt-lg-0- pt-2- {if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'Yes'}d-flex{/if} d-md-inline-block  px-3 px-lg-2 {if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'No'}px-xl-5{else}px-xl-3{/if} py-xl-1 py-md-0- pb-2- {*{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes' && cw::$screen !== 'XS'}p-unset{/if}*} {if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'No'}{if cw::$screen == 'XS' || cw::$screen == 'SM'}d-none{/if}{/if}">
            {if isset($psearch_generate_mrktreport) && $psearch_generate_mrktreport == 'Yes'}
                <a href="{$marketReportURL}" class="btn btn-sm btn-primary- btn-market-insight text-primary align-self-center  {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}font-size-sm-12{/if} te-font-size-13 font-size-sm-10 shadow-none p-1 p-lg-1 p-xl-2 px-2 {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser{else}font-tab text-sm-right text-lg-left- {if isset($isPredefined) && $isPredefined == true && (cw::$screen == 'MD' || cw::$screen == 'SM')}col col-md-4- {if isset($isGrid) && $isGrid !== 'true'} col-xl-auto {else} col-xl-auto- {/if} px-sm-3 {/if} {/if} rounded-0"><i class="fas fa-2x fa-poll text-dark pr-2 align-middle"></i><span class="d-none- d-sm-inline {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}d-md-none{/if} d-lg-inline">Market Insights</span></a>
            {/if}
            <div class="dropdown d-inline-block mx-1- mx-lg-0- align-self-center {*{if isset($isGrid) && $isGrid !== 'true'}mx-md-3 mx-lg-3 mx-xl-5{/if}*} {if isset($isPredefined) && $isPredefined == true && isset($isGrid) && $isGrid !== 'true' && (cw::$screen == 'MD' || cw::$screen == 'SM')} col-md-auto- col-xl-auto- px-sm-3{/if}">
                <button id="share-btn" class="btn btn-sm dropdown-toggle  {if isset($isGrid) && $isGrid == 'true'}f-tab btn-gray- {else}font-tab dropdown-block {/if} {if isset($psearch_display_tab) && $psearch_display_tab == 'No'} font-size-sm-10 font-size-sm-12  {else}te-btn- text-white- {/if} te-font-size-12- te-btn- text-white- shadow-none p-lg-2 px-xl-3 px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {*<i class="fas fa-external-link-alt pr-2-"></i> Share*}
                    <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline- {if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}d-md-none{/if} d-lg-inline">Share</span>
                </button>
                <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2-"></i> Facebook</a>
                    <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1-"></i> Twitter</a>
                    <a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2-" ></i> Pinterest</a>
                    <a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2-"></i> LinkedIn</a>
                    <a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($presearch_title) && $presearch_title != ''}{$presearch_title}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2-"></i> Email</a>
                </div>
            </div>
            {if isset($isGrid) && $isGrid !== 'true'}
                <div class="pre-map-toggle {if isset($isPredefined) && $isPredefined == true && ($device != 'XS' && $device != 'SM' && $device != 'MD')}order-1 mt-1 py-1 {else}col-xl-1 mt-2- float-right py-0 {/if}align-self-center custom-control custom-switch te-width-max-content- d-xl-block- d-none te-map-switch-grid d-lg-inline-flex mx-5-" data-toggle="modal" data-target="#te-map-modal">
                    <input type="checkbox" class="custom-control-input" id="toggle-trigger-grid" name="toggle-trigger-grid" {if isset($is_map) && $is_map == 'true'}checked{/if}>
                    <label class="custom-control-label font-tab te-font-weight-500" for="toggle-trigger-grid">Map</label>
                </div>
            {/if}
            {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}
                {if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD'}
                    <a class="btn btn-sm rounded-0 d-lg-none {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}font-size-sm-12 font-size-sm-10{/if} te-font-size-13 responsive-filters-tab align-self-center shadow-none te-font-size-14 px-3 lpt-btn- lpt-btn-txt- btn-gray- {if isset($isGrid) && $isGrid == 'true'}te-pre-mblf{else}font-tab {if isset($isPredefined) && $isPredefined == true }d-none {/if}{/if}" role="button" data-toggle="modal" data-target="#exampleModalScrollable"><i class="fas fa-sliders-h fa-2x pr-2 align-middle"></i>More Filters <i class="fas fa-angle-down align-middle"></i>
                    </a>
                {/if}
            {/if}
            {*<a href="javascript::void(0);" class="btn btn-sm align-self-center btn-gray- {if isset($psearch_display_tab) && $psearch_display_tab == 'No'}font-size-sm-12  font-size-sm-10 {else} te-btn- text-white- {/if} te-font-size-13 te-btn- shadow-none p-lg-2 p-xl-2 px-2 text-md-right {if isset($isGrid) && $isGrid == 'true'}te-pre-saveser px-xl-3{else}font-tab {if isset($isPredefined) && $isPredefined == true && (cw::$screen == 'MD' || cw::$screen == 'SM')}col-md-4- col-xl-auto- px-sm-3 {/if}{/if} rounded-0 lpt-btn- lpt-btn-txt- popup-modal-sm" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch&pid={$predefinedId}{else}/?action=member-login&ReqType=SaveSearch&pid={$predefinedId}{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}"><i class="far fa-2x fa-bell align-middle pr-2"></i>*}{*{if cw::$screen != 'XS'}Alerts{/if}{print_r(cw::$screen)}*}{*{if isset($isGrid) && $isGrid == 'true'}{if isset($psearch_display_tab) && $psearch_display_tab == 'Yes'}<span class="d-inline d-md-none d-lg-inline">Alerts</span>{else}<span class="d-none d-sm-inline">Alerts</span>{/if}{else}<span class="d-sm-inline">Alerts</span>{/if}</a>*}
        </div>
        </div>
        {if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD' }
            {include file="listing/mobile-device-search-form.tpl"}
        {/if}
    {/if}
{/if}
<div class="wrapper te-search-result-wrapper pms-map-listing customize-ldesign {if isset($isstyle) && ($isstyle !== false) && $isstyle == 7} slider-7{/if} {if isset($isPredefined) && ($isPredefined == 'true' || $isPredefined == true)}no-follow-link{/if}">
    <section class="te-search-results-sec  p-0 {if isset($isstyle) && ($isstyle !== false) && $isstyle == 1} slider-1{/if}">
        <div class="{if isset($isGrid) && $isGrid !== 'true' && $isstyle != 9 && $isstyle != 11 && $isstyle != 12}container-fluid{elseif isset($isstyle) && ($isstyle !== false) && $isstyle != 9 && $isstyle != 10 && $isstyle != 11 && $isstyle != 12} con-style {else} {if isset($isPredefined) && $isPredefined == true && $isstyle != 9 && $isstyle != 10 && $isstyle != 11}container-fluid pt-0{else}container con-div p-xl-0 p-md-0 pt-0{/if}{/if}">
            <div class="row {if isset($isstyle) && ($isstyle !== false) && ($isstyle == 1 || $isstyle == 7 || $isstyle == 9)} h-100{/if}">
                {if isset($isGrid) && $isGrid !== 'true'}
                    {if cw::$screen == 'XS' || cw::$screen == 'SM' || cw::$screen == 'MD'}
                        <div class="modal fade d-xl-none" id="te-map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog mw-100 m-0 h-100" role="document">
                                <div class="modal-content h-100 rounded-0 border-0">
                                    <div class="modal-header position-fixed te-z-index-99 w-100">

                                        <button type="button" class="close bg-white" data-dismiss="modal" aria-label="Close" id="closeMap">
                                            <span class="text-secondary" aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div id="pms-area-map" class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 px-0 d-xl-block te-half-map-div order-2">
                                            <div id="pms-map" data-map='true'>

                                            </div>
                                            <div id="map-infobox-small" class="oeibSmall hide-me">
                                                <div class="ibContent"></div>
                                            </div>
                                            <div id="m-loader" class="hide-me-">
                                                <div><img src="{$TPL_images}/ajax-loader-small.gif"/>&nbsp;Loading...</div>
                                            </div>

                                            <div class="te-draw-radius-button position-absolute">
                                                <a id="btn_draw" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                                    <i class="fas fa-draw-polygon text-secondary te-icon-draw"></i><br>draw
                                                </a>
                                                <a id="btn_cir" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                                    <i class="far fa-dot-circle text-secondary te-icon-radius"></i><br>radius
                                                </a>
                                                <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 d-none lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_remove">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {else}
                        <div id="pms-area-map" class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 px-0 visible-xl d-xl-block te-half-map-div order-2 d-none ">
                            <div id="pms-map" data-map='true'>

                            </div>
                            <div id="map-infobox-small" class="oeibSmall hide-me">
                                <div class="ibContent"></div>
                            </div>
                            <div id="m-loader" class="hide-me-">
                                <div><img src="{$TPL_images}/ajax-loader-small.gif"/>&nbsp;Loading...</div>
                            </div>

                            <div class=" te-draw-radius-button  position-absolute">
                                <a id="btn_draw" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                    <i class="fas fa-draw-polygon text-secondary te-icon-draw"></i><br>draw
                                </a>
                                <a id="btn_cir" class="btn bg-white text-dark text-uppercase rounded-0 border-0 shadow-none te-font-size-14 d-block py-2" href="JavaScript:void(0)" role="button">
                                    <i class="far fa-dot-circle text-secondary te-icon-radius"></i><br>radius
                                </a>
                                <a class="btn bg-white- te-btn text-white- text-uppercase rounded-0 border-0 shadow-none te-font-size-14 py-2 d-none lpt-btn lpt-btn-txt" href="javascript:void(0);" id="btn_remove">Reset</a>
                            </div>
                        </div>
                    {/if}
                {/if}

                <div id="pms-area-listing" class="{if isset($isGrid) && $isGrid !== 'true'}col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 te-featured-properties  {if isset($isPredefined) && $isPredefined == true && !isset($isstyle)}px-3{else}px-2{/if} pb-0 pb-xl-2 te-search-results-properties {if isset($isPredefined) && $isPredefined == true }order-1 {else} pt-0 pt-xl-1 order-1 px-md-4 {/if}{else}col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-featured-properties px-3 {if isset($isstyle) && ($isstyle !== false) && ($isstyle == 1 || $isstyle == 3 || $isstyle == 2)}py-0{else}{if isset($isPredefined) && $isPredefined == true }pb-3 {else}py-3{/if}{/if} mw-100 te-mls-property-embedding h-auto{/if} {if $isstyle == 10} py-5 {/if}">
                    {include file='listing/map-view.tpl' device=cw::$screen}
                </div>
            </div>
        </div>
    </section>
</div>
<form id="pms-form-filter" method="post">
    <input type="hidden" id="so" name="so" value="{$arrSearchCriteria.so|default:'price'}">
    <input type="hidden" id="sd" name="sd" value="{$arrSearchCriteria.sd|default:'asc'}">
    <input type="hidden" name="page_size" id="page_size" value="{$arrSearchCriteria.page_size}" data-type="hidden"/>
    <input type="hidden" id="MapZoomLevel" name="mz" value="{$arrSearchCriteria.mz|default:13}">
    <input type="hidden" id="MapCenterLat" name="clat" value="{$arrSearchCriteria.clat|default:25.761681}">
    <input type="hidden" id="MapCenterLng" name="clng" value="{$arrSearchCriteria.clng|default:-80.191788}">
    {*        <input type="hidden" id="map" name="map" value="{$arrSearchCriteria.map|default:''}">*}
    <input type="hidden" id="poly" name="poly" value="{$arrSearchCriteria.poly|default:''}">
    <input type="hidden" id="cir" name="cir" value="{$arrSearchCriteria.cir|default:''}">
    <input type="hidden" id="is_map" name="is_map" value="{$is_map|default:''}">

</form>
{*<div class="modal fade header-sign-in" id="modal-sm-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignIn" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content px-2 border-0 rounded-0">

        </div>
    </div>
</div>*}
<script type="text/javascript">
    var mapZoomLevel 	= {$mapZoomLevel};
    var mapCenterLat 	= {$mapCenterLat};
    var mapCenterLng 	= {$mapCenterLng};
    var jsonMapData		= '{$jsonMapData}';
    var Site_Url	    = '{$Site_Url}';
    var currency	    = '{$currency}';
    var total_record	= '{$total_record}';
    var page_size	    = '{$page_size}';
    var page	        = '{$page}';
    var URL	            = '{$URL}';
    var isUserLoggedIn	= '{$isUserLoggedIn}';
    var memberDetail	= '{$memberDetail}';
    var user_id	        = '{$user_id}';
    var issorting	    = '{$issorting}';
    var isFilter	    = '{$isFilter}';
    var sys_name	    = '{$sys_name}';
    var isRental	    = '{$is_rental}';
    var isHeading	    = '{$isHeading}';
    var issavesearch	= '{$issavesearch}';
    var isGrid	        = '{$isGrid}';
    var predefinedId	= '{$predefinedId}';
    var arrSearchCriteria            = '{$arrSearchCriteria|@json_encode}';
    var userFavList	    = '{if isset($userFavList) && is_array($userFavList)}{$userFavList|implode:','|lower|ucwords}{else}{$userFavList|default:''}{/if}';
    var isPredefined    = '{if isset($isPredefined)}{$isPredefined}{/if}';
    var isstyle         = '{if isset($isstyle)}{$isstyle}{/if}';
    if(isstyle == 8 || isstyle == 9)
        {
            var view_page_url = '{$view_page_url}'
        }
    //var isMap	        = '{$isMap}';
    //var disclaimer      = '{$disclaimer}';
    var tabs            = '{$tabs}';
    var ViewURL            = '{$ViewURL}';
    if(isstyle == 12)
    {
        var CustomCSS   = '{$CustomCSS}';
        var CustomTitle   = '{$CustomTitle}';
        var Background   = '{$Background}';
    }
    var login_enable    = '{$login_enable}';
    var bitcoin         = '{$bitcoin}';
    var etherium        = '{$etherium}';
    var cardano         = '{$cardano}';
    var rel         = '{$rel}';
                if(rel !='' && rel !=undefined){
                 setTimeout(function () {
                    jQuery('.no-follow-link a').attr('rel',rel);
                 }, 500);
                }
    var maxViewedExceed 	= '{$maxViewedExceed}';
    var maxViewedExceedCount 	= '{$arrConfig['Listing']['site_max_viewed_without_login']}';
    var isloginReq 	= '{$isloginReq}';

</script>