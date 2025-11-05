<section class="te-search-results-sec">
    <div class="container te-mls-property-embedding-container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 te-featured-properties px-3 py-3 mw-100 te-mls-property-embedding h-auto">
                <div class="row justify-content-between mb-2">

                </div>

                <div class="row clearfix te-main-search-property">
                    <div class="col-12 col-sm-12 p-2">
                        <h2 class="py-3 p-title mb-0 txt-heading heading_txt_color">{if isset($recDeletedListing)}{$recDeletedListing.address_full}{else}Property Information{/if}</h2>
                    </div>

                    {if $recDeletedListing}
                        <p class="off">Off Market</p>
                        <p><span>Price </span> {$currency}{$recDeletedListing.ListPrice|number_format:0}</p>
                        {if $recDeletedListing.Baths}<p><span>Bathrooms </span> {$recDeletedListing.Baths}</p>{/if}
                        {if $recDeletedListing.Beds}<p><span>Bedrooms </span> {$recDeletedListing.Beds}</p>{/if}
                        {if $recDeletedListing.SQFT}<p><span>Square Footage </span> {$recDeletedListing.SQFT|number_format:0}</p>{/if}
                    {else}
                        <div class="col-12 col-sm-12 p-2">
                            <p class="alert alert-info p-1 mb-0">Sorry, we did not find property information. Information might be removed from MLS Listings.</p>
                        </div>
                    {/if}
                    <div class="col-12 col-sm-12 p-2">
                        <p class="alert alert-info p-1">Please check it out below more similar listing(s) or start new search for your desired home.</p>
                    </div>
                    {foreach name='SearchResult' from=$rsResult item=Record}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {*{assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}*}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
								<img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
								<div class="te-gradient te-property-details te-animate text-white position-absolute te-z-index-99 te-p-5 pt-5">
									<div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
										<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format}</div>
										<div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
										<div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
									</div>
                                	<div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
								</div>
							</a>
                            {if $arrConfig['OtherConfig']['login_enable'] == 'Yes'}
                                <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                    {if $isUserLoggedIn == true}
                                        {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                        {else}
                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                        {/if}
                                    {else}
                                        <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    {/foreach}
                </div>
                <input type="hidden" name="OnPage" id="OnPage" value="RandomResult"/>
            </div>
        </div>
    </div>
</section>
{if !$isUserLoggedIn}
    <input type="hidden" name="isredirect" id="isredirect" value="true" />
{/if}
<div class="modal fade property-contact-agent-modal" id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content px-2 rounded-0">

        </div>
    </div>
</div>