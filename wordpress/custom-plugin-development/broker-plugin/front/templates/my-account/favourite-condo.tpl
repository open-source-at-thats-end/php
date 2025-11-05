<div class="card mb-3 bg-white text-left te-card border-0" id="basic-hash">
    <div class="card-header te-card-header te-bg-light pl-0 border-0 rounded-0 py-2">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-0">
            <h4 class="title-font text-left mb-0 pb-0 txt-heading heading_txt_color">Manage Favorite Condos</h4>
        </div>
    </div>
    <div class="card-body py-0 collapse show">
        {if is_array($rsResult) && count($rsResult) > 0}
            {foreach name="FavCondos" from=$rsResult item=Record}
                <div class="row pt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <strong>{$Record.csearch_name}</strong>
                    </div>
                    {if $arrConfig['OtherConfig']['login_enable'] == 'Yes'}
                        <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12 text-right">
                            <span class="fav-link-container" id="fav-link-container">
                                {if isset($userFavCondoList) && in_array($Record.csearch_id, $userFavCondoList)}
                                    <a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt-" onclick="JavaScript:UpdateFavoritesCondos_Click('{$Record.csearch_id}', 'Remove','Other','{$userInfo->ID}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fa-2x pr-1 align-middle"></i></a>
                                {else}
                                    <a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt-" onclick="JavaScript:UpdateFavoritesCondos_Click('{$Record.csearch_id}', 'Add','Other','{$userInfo->ID}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i></a>
                                {/if}
                            </span>
                        </div>
                    {/if}
                </div>
                <div class="row pt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <ul>
                            <li><label>Address: </label> {$Record.csearch_address}, {$Record.csearch_city|strtoupper}, {$Record.csearch_zipcode}</li>
                        </ul>
                    </div>
                </div>
                <hr class="mx-0 w-100">
            {/foreach}
        {else}
            <div class="text-center text-danger pt-2">No Favorite Condo Found.</div>
        {/if}
    </div>
</div>