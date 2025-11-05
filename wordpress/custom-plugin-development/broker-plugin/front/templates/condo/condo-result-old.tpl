{*{if $arrCondoStatisticResult > 0}
    {foreach name='CondoStatisticResult' from=$arrCondoStatisticResult['rs'] item=Record key=key}
        {if $Record['Beds'] == 6}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                {capture append=listforsale6}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsale6}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                {capture append=listforrent6}
                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>
                {/capture}
                {capture append=gridforrent6}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                {capture append=listforpending6}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforpending6}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                {capture append=listforsold6}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsold6}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
        {/if}
        {if $Record['Beds'] == 5}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                {capture append=listforsale5}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsale5}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                {capture append=listforrent5}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforrent5}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                {capture append=listforpending5}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforpending5}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                {capture append=listforsold5}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsold5}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
        {/if}
        {if $Record['Beds'] == 4}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                {capture append=listforsale4}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsale4}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                {capture append=listforrent4}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforrent4}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                {capture append=listforpending4}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforpending4}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                {capture append=listforsold4}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsold4}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
        {/if}
        {if $Record['Beds'] == 3}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                {capture append=listforsale3}

                        <tr>
                            <td class="border text-center" nowrap>
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                    {else}
                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                {/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>

                {/capture}
                {capture append=gridforsale3}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                {capture append=listforrent3}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforrent3}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                {capture append=listforpending3}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforpending3}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                {capture append=listforsold3}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsold3}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
        {/if}
        {if $Record['Beds'] == 2}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                {capture append=listforsale2}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsale2}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                {capture append=listforrent2}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforrent2}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                {capture append=listforpending2}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforpending2}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                {capture append=listforsold2}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsold2}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
        {/if}
        {if $Record['Beds'] == 1}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                {capture append=listforsale1}
                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsale1}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                {capture append=listforrent1}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforrent1}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                {capture append=listforpending1}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforpending1}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
            {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                {capture append=listforsold1}

                                <tr>
                                    <td class="border text-center" nowrap>
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                                    <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                                    <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                                    <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                                    <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                                    <td class="border text-center" nowrap>
                                        {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                        {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                    </td>
                                    <td class="border text-center" nowrap>{$Record.DOM}</td>
                                </tr>

                {/capture}
                {capture append=gridforsold1}
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
                                {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                {assign var=photo_url value={$Record.MainPicture}}
                            {/if}
                            <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                            <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                            <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                    {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                    <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                    <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                </div>
                                <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                            </div>
                        </a>
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
                    </div>
                {/capture}
            {/if}
        {/if}
    {/foreach}
{/if}*}
{if isset($arrCondo['csearch_is_visible']) && $arrCondo['csearch_is_visible'] == "yes"}
    {capture name='table_header'}
        <thead class="te-bg-table">
        <tr>
            {*<th class="border text-center no-sort" nowrap scope="col"><i class="far fa-heart"></i></th>*}
            <th class="border text-center no-sort" nowrap scope="col">Unit #</th>
            <th class="border text-center" nowrap scope="col">List Price</th>
            <th class="border text-center" nowrap scope="col">Price Change</th>
            <th class="border text-center" nowrap scope="col">Beds/Baths</th>
            <th class="border text-center" nowrap scope="col">Sq Ft</th>
            <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
            <th class="border text-center" nowrap scope="col">$/Sq Ft</th>
            <th class="border text-center" nowrap scope="col">Days Listed</th>
        </tr>
        </thead>
    {/capture}
    {capture name='sold_table_header'}
        <thead class="te-bg-table">
        <tr>
            <th class="border text-center" nowrap scope="col">Unit #</th>
            <th class="border text-center" nowrap scope="col">Closed Price</th>
            <th class="border text-center" nowrap scope="col">List Price</th>
            <th class="border text-center" nowrap scope="col">Beds/Baths</th>
            <th class="border text-center" nowrap scope="col">Sq Ft</th>
            <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
            <th class="border text-center" nowrap scope="col">Days Listed</th>
            <th class="border text-center" nowrap scope="col">Closing Date</th>
        </tr>
        </thead>
    {/capture}
    {capture name='no_results'}
        <div class="col-12 no-data-msg text-center text-danger pt-3 font-weight-bold">
            0 Results
        </div>
    {/capture}
    {if $arrCondoStatisticResult > 0}
        {foreach name='CondoStatisticResult' from=$arrCondoStatisticResult['rs'] item=Record key=key}
            {assign var="rsAttributes" value=Utility::generateListingAttributes($Record)}
            {if $Record['Beds'] == 6}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale6}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                            <td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsale6}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format}{if $pricedef != 0}<p class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if}">{if $Record.Price_Diff|substr:0:1 == '-'}{$Record.Price_Diff|round:2}{else}+{$Record.Price_Diff|round:2}{/if}% ({$currency}{str_replace('-','',$pricedef)|number_format})</p>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent6}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforrent6}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending6}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforpending6}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold6}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                            <td class="border text-center" nowrap>{$Record.Sold_Date}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsold6}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 5}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale5}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsale5}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent5}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforrent5}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending5}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforpending5}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold5}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                            <td class="border text-center" nowrap>{$Record.Sold_Date}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsold5}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 4}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale4}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsale4}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent4}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforrent4}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending4}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforpending4}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold4}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                            <td class="border text-center" nowrap>{$Record.Sold_Date}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsold4}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 3}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale3}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsale3}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent3}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforrent3}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending3}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforpending3}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold3}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                            <td class="border text-center" nowrap>{$Record.Sold_Date}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsold3}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 2}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale2}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsale2}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent2}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforrent2}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending2}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforpending2}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold2}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                            <td class="border text-center" nowrap>{$Record.Sold_Date}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsold2}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 1}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale1}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsale1}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent1}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforrent1}
                        <div class="listings-box col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending1}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>
                                <div class="d-flex justify-content-start">
                                    <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                        {if $isUserLoggedIn == true}
                                            {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                            {else}
                                                <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                            {/if}
                                        {else}
                                            <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    </div>
                                    {$Record.UnitNo}
                                </div>
                            </td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforpending1}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold1}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                            <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.Sold_Price|number_format}</td>
                            <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                            <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                            <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                            <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                                {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                            <td class="border text-center" nowrap>{$Record.DOM}</td>
                            <td class="border text-center" nowrap>{$Record.Sold_Date}</td>
                        </tr>
                    {/capture}
                    {capture append=gridforsold1}
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$Record.ListingID_MLS}">
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                {if $Record.mls_is_pic_url_supported == 'Yes'}
                                    {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {if $Record.MainPicture.large.url != '' && $Record.TotalPhotos > 0}
                                        {assign var=photo_url value=$Record.MainPicture.large.url}
                                    {else}
                                        {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                    {/if}
                                {else}
                                    {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                    {assign var=photo_url value={$Record.MainPicture}}
                                {/if}
                                <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-14">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
                                        <div class="te-property-title text-truncate te-font-size-14">{$Record.StreetNumber} {$Record.StreetName}, {$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                {if $isUserLoggedIn == true}
                                    {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                    {else}
                                        <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                    {/if}
                                {else}
                                    <a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                {/if}
                            </div>
                        </div>
                    {/capture}
                {/if}
            {/if}
        {/foreach}
    {/if}
    <section id="condo-building" class="condo-building">
        <div class="container-fluid">
            <div class="row px-lg-5 py-3 align-items-center">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 align-self-center pb-0 heading text-center text-sm-left">
                    <h3 class="align-middle pb-2"><b>{$csearch_name}</b></h3>
                    {*<span class="text-uppercase te-font-size-14">{$arrSearchCriteria['add']}, {$arrSearchCriteria['city']}, {$arrSearchCriteria['zipcode']}</span>*}
                    <span class="text-uppercase te-font-size-14">{$arrCondo['csearch_address']}, {$arrCondo['csearch_city']}, {$arrCondo['csearch_zipcode']}</span>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 text-center text-sm-right">
                    <div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center col-md-auto- col-xl-auto- px-sm-3">
                        <button id="share-btn" class="btn btn-sm dropdown-toggle font-tab- dropdown-block font-size-sm-10 font-size-sm-12 te-btn- text-white- te-font-size-12- te-btn- text-white- shadow-none p-lg-2- px-xl-3- px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline- d-lg-inline">Share</span>
                        </button>
                        <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
                            <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
                            <a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
                            <a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
                            <a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($csearch_name) && $csearch_name != ''}{$csearch_name}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
                        </div>
                    </div>
                    <span class="fav-link-container" id="fav-link-container">
                        {if $isUserLoggedIn == true}
                            {if isset($userFavCondoList) && in_array($arrCondo.csearch_id, $userFavCondoList)}
                                <a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt-" onclick="JavaScript:UpdateFavoritesCondos_Click('{$arrCondo.csearch_id}', 'Remove','CondoFullView','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart fa-2x pr-1 align-middle"></i></a>
                            {else}
                                <a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt-" onclick="JavaScript:UpdateFavoritesCondos_Click('{$arrCondo.csearch_id}', 'Add','CondoFullView','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i></a>
                            {/if}
                        {else}
                            <a class="btn btn-sm te-btn- text-white- te-font-size-13 shadow-none py-2 py-lg-2 px-lg-2 px-xl-3 te-save-propery-detail popup-modal-sm rounded-0 mx-1 mx-lg-0 lpt-btn- lpt-btn-txt-" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&condo-id={$arrCondo.csearch_id}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart fa-2x pr-1 align-middle"></i></a>
                        {/if}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="properties-slider condo-slider border-0">
                        {foreach name='CondoSearchResult' from=$arrCondoResult item=Record}
                            {assign var="rsAttributes" value=Utility::generateListingAttributes($Record)}
                            <a href="{$Host_Url}/{$rsAttributes.SFUrl}" tabindex="0" class="cp-2">
                                <div id="{$Record.ListingID_MLS}" class="listing-box px-0 slick-slide w-100" data-ref-id="{$Record.ListingID_MLS}" data-slick-index="0" aria-hidden="false" tabindex="0">
                                    <div class="listings-height d-block te-property-card te-property-gradient position-relative overflow-hidden">
                                        {if $Record.mls_is_pic_url_supported == 'Yes'}
                                            {assign var=photo_url value=$Record.MainPicture.large.url}
                                            {if $Record.MainPicture.large.url != ''}
                                                {assign var=photo_url value=$Record.MainPicture.large.url}
                                            {else}
                                                {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                            {/if}
                                        {else}
                                            {assign var=photo_url value={$Record.MainPicture}}
                                        {/if}
                                        <img src="{$photo_url}" class="te-property-fig te-property-image w-100" alt="{$Record.Address}">
                                        <div class="top-left">
                                            {if $Record.ListingStatus == 'ActiveUnderContract'}
                                                <div class="wedges list-wedge">Under Contract</div>
                                            {/if}
                                            {if $Record.ListingStatus == 'Pending'}
                                                <div class="wedges list-wedge">Pending</div>
                                            {/if}
                                            {if $Record.DOM < 7}
                                                <div class="wedges-newListing list-wedge">New Listing</div>
                                            {/if}
                                            {if $Record.ListingStatus == 'Closed'}
                                                <span class="wedges list-wedge">Closed</span>
                                            {/if}
                                            {*{if $Record.VirtualTourUrl !== '' && $Record.VirtualTourUrl != null}
                                                <span class="wedges list-wedge tour-wedge">Virtual Tour</span>
                                            {/if}*}
                                        </div>
                                        <div class="condo-overlay"></div>
                                        <div class="property-info te-smooth-gradient">
                                            <h3 class="text-white font-weight-bold pb-1">{$currency}{$Record.ListPrice|number_format}</h3>
                                            <div class="pb-2- style-3-address te-font-size-14">{$Record.Beds|number_format} Beds &nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp; {$Record.Baths|number_format} Baths</div>
                                            <div class="te-property-details-features te-font-size-14 pb-2- text-uppercase- font-weight-normal">{$Record.Address}</div>
                                            <div class="te-property-details-features te-font-size-14 pb-2- text-uppercase- font-weight-normal">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="row pt-md-4 px-sm-5 condo-idx-list">
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 order-2 order-md-1">
                    <div class="d-md-flex justify-content-between align-items-center py-3 d-none d-md-block">
                        <h3 class="align-middle text-center text-sm-left pb-lg-0"><b>{$csearch_name}</b></h3>
                        <div>
                            <ul class="nav nav-tabs p-0 border-0 justify-content-center" id="viewTab" role="tablist">
                                <li class="nav-item"><a id="condo-grid" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="false" class="nav-link font-size-sm-10 font-size-sm-12 te-font-size-12 pr-3 tab-btn- border-0"><span class="condo-font-size-18 align-middle">Grid</span> <i class="fa fa-th pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a></li>
                                <li class="nav-item active"><a id="condo-list" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true" class="nav-link active font-size-sm-10 font-size-sm-12 te-font-size-12 tab-btn- border-0"><span class="condo-font-size-18 align-middle">List</span> <i class="fa fa-bars pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row pt-4 te-font-size-14">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 pb-5 pb-lg-0">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Year Built</span><span class="font-weight-bold">{if $arrCondo['csearch_year_built'] != ''}{$arrCondo['csearch_year_built']}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units</span><span class="font-weight-bold">{if $arrCondo['csearch_unit'] != ''}{$arrCondo['csearch_unit']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Stories</span><span class="font-weight-bold">{if $arrCondo['csearch_stories'] != ''}{$arrCondo['csearch_stories']|number_format}{else}-{/if}</span></li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 pb-5 pb-lg-0">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Active Units For Sale</span><span class="font-weight-bold">{if $arrCStatistics['statistic_total_active_listing'] > 0}{$arrCStatistics['statistic_total_active_listing']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units Under Contract</span><span class="font-weight-bold">{if $arrCStatistics['statistic_total_under_contract_listing'] > 0}{$arrCStatistics['statistic_total_under_contract_listing']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units Sold (6 months)</span><span class="font-weight-bold">{if $arrCStatistics['statistic_sixmon_tot_sold_listing'] > 0}{$arrCStatistics['statistic_sixmon_tot_sold_listing']|number_format}{else}-{/if}</span></li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price Listed / SqFt</span><span class="font-weight-bold">{if $arrCStatistics['statistic_avg_price_sqft'] > 0}{$currency}{$arrCStatistics['statistic_avg_price_sqft']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price Sold / SqFt</span><span class="font-weight-bold">{if $arrCStatistics['statistic_avg_sold_price_sqft'] > 0}{$currency}{$arrCStatistics['statistic_avg_sold_price_sqft']|number_format}{else}-{/if}</span></li>
                                {*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold">{if $arrCStatistics['statistic_avg_dom'] > 0}{$arrCStatistics['statistic_avg_dom']|number_format}{else}-{/if}</span></li>*}

                                {*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Discount</span><span class="font-weight-bold {if $arrCStatistics['statistic_biggest_price_change'] < 0}text-danger{else}text-success{/if}">{if $arrCStatistics['statistic_biggest_price_change'] != ''}{if $arrCStatistics['statistic_biggest_price_change'] > 0}+{/if}{$arrCStatistics['statistic_biggest_price_change']|round:2|number_format}%{else}-{/if}</span></li>*}
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Discount</span><span class="font-weight-bold {if $arrCStatistics['statistic_biggest_price_change'] < 0}text-danger{else}text-success{/if}">{if $arrCStatistics['statistic_biggest_price_change'] != ''}{$currency}{$arrCStatistics['statistic_largest_price_reduction']|number_format} {if $arrCStatistics['statistic_biggest_price_change'] > 0}+{/if}({$arrCStatistics['statistic_biggest_price_change']|round:2|number_format}%){else}-{/if}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 px-0 px-md-3 pt-md-5 pt-xl-0 order-1 order-md-2">
                    <ul class="nav nav-tabs p-0 border-0 conTabs" id="dataListTab" role="tablist">
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainListTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_active_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR SALE</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainListTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_rental_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainListTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_pending_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">PENDING</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainListTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_sold_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">SOLD</span></a></li>
                    </ul>
                    <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="dataGridTab" role="tablist">
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainGridTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_active_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR SALE</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainGridTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_rental_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainGridTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_pending_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">PENDING</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" href="#mainGridTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_sold_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">SOLD</span></a></li>
                    </ul>
                    <div class="row pt-4 order-3">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pb-sm-5 pb-lg-0 condo-pv-url text-center">
                            <p class="text-center text-md-left text-uppercase cus-fwight-bold">THINKING OF SELLING YOUR {$arrCondo.csearch_name} CONDO? SCHEDULE A FREE VALUATION.</p>
                            {if strpos($arrCondo.csearch_photo_video_url, 'youtube')}
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="{$arrCondo.csearch_photo_video_url}" class="embed-responsive-item"></iframe>
                                </div>
                            {else}
                                <img src="{$arrCondo.csearch_photo_video_url}" alt="{$arrCondo.csearch_name}" class="pt-3 img-fluid w-100">
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-5 px-sm-5 condo-idx te-font-size-14">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    {*{if cw::$screen == 'XS' || cw::$screen == 'SM'}
                        <div class="row stat-dropdown px-0">
                            <div class="col-6 border">
                                *}{*<div class="dropdown">
                                    <div class="dropdown-menu d-block" aria-labelledby="dropdownMenu2">
                                        <div class="p-0 border-0 conTabs" id="myListTab">
                                            <div id="mainListTabs" class="hidden"></div>
                                            <a id="for-sale-tab" data-target="#forsale" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="dropdown-item active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a>
                                            <a id="for-rent-tab" data-target="#forrent" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a>
                                            <a id="for-pending-tab" data-target="#forpending" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a>
                                            <a id="for-sold-tab" data-target="#forsold" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a>
                                        </div>
                                        <div class="p-0 border-0 conTabs d-none" id="myGridTab">
                                            <div id="mainGridTabs" class="hidden"></div>
                                            <a id="for-sale-tab" data-target="#forsale1" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="dropdown-item active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a>
                                            <a id="for-rent-tab" data-target="#forrent1" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a>
                                            <a id="for-pending-tab" data-target="#forpending1" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a>
                                            <a id="for-sold-tab" data-target="#forsold1" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a>
                                        </div>
                                    </div>
                                </div>*}{*
                                <div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center col-md-auto- col-xl-auto- px-sm-3">
                                    *}{*<button id="stat-btn" class="btn btn-sm dropdown-toggle font-tab- dropdown-block font-size-sm-10 font-size-sm-12 te-btn- text-white- te-font-size-12- te-btn- text-white- shadow-none p-lg-2- px-xl-3- px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline- d-lg-inline">Share</span>
                                    </button>*}{*
                                    *}{*<a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
                                    <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
                                    <a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
                                    <a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
                                    <a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($csearch_name) && $csearch_name != ''}{$csearch_name}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>*}{*
                                    <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                                        <div class="p-0 border-0 conTabs" id="myListTab">
                                            <div id="mainListTabs" class="hidden"></div>
                                            <a id="for-sale-tab" href="" data-target="#forsale" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="dropdown-item active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a>
                                            <a id="for-rent-tab" href="" data-target="#forrent" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a>
                                            <a id="for-pending-tab" href="" data-target="#forpending" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a>
                                            <a id="for-sold-tab" href="" data-target="#forsold" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a>
                                        </div>
                                        <div class="p-0 border-0 conTabs d-none" id="myGridTab">
                                            <div id="mainGridTabs" class="hidden"></div>
                                            <a id="for-sale-tab" href="" data-target="#forsale1" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="dropdown-item active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a>
                                            <a id="for-rent-tab" href="" data-target="#forrent1" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a>
                                            <a id="for-pending-tab" href="" data-target="#forpending1" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a>
                                            <a id="for-sold-tab" href="" data-target="#forsold1" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="dropdown-item btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="dropdown">
                                    <div class="dropdown-menu border rounded-0 conTabs" aria-labelledby="dropdownMenu2">
                                        <a id="condo-grid" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="false" class="dropdown-item font-size-sm-10 font-size-sm-12 te-font-size-12 pr-3 border-0"><span class="condo-font-size-18 align-middle">Grid</span> <i class="fa fa-th pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a>
                                        <a id="condo-list" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true" class="dropdown-item active font-size-sm-10 font-size-sm-12 te-font-size-12 border-0"><span class="condo-font-size-18 align-middle">List</span> <i class="fa fa-bars pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {else}*}
                        <ul class="nav nav-tabs p-0 border-0 conTabs" id="myListTab" role="tablist">
                            <div id="mainListTabs" class="hidden"></div>
                            <li class="nav-item w-25"><a id="for-sale-tab" data-target="#forsale" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-rent-tab" data-target="#forrent" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-pending-tab" data-target="#forpending" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-sold-tab" data-target="#forsold" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a></li>
                        </ul>
                        <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="myGridTab" role="tablist">
                            <div id="mainGridTabs" class="hidden"></div>
                            <li class="nav-item w-25"><a id="for-sale-tab" data-target="#forsale1" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-rent-tab" data-target="#forrent1" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-pending-tab" data-target="#forpending1" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-sold-tab" data-target="#forsold1" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a></li>
                        </ul>
                    {*{/if}*}
                    <div class="tab-content" id="myTabContent">
                        <div id="grid" role="tabpanel" aria-labelledby="condo-grid" class="tab-pane show">
                            <div id="datagrid" class="tab-content py-5">
                                <div id="forsale" role="tabpanel" aria-labelledby="for-sale-tab condo-grid" class="tab-pane show active">
                                    <div class="row">
                                        {if (is_array($gridforsale6)) || (is_array($gridforsale5)) ||
                                        (is_array($gridforsale4)) || (is_array($gridforsale3)) ||
                                        (is_array($gridforsale2)) || (is_array($gridforsale1))}
                                            {implode('',$gridforsale6)}
                                            {implode('',$gridforsale5)}
                                            {implode('',$gridforsale4)}
                                            {implode('',$gridforsale3)}
                                            {implode('',$gridforsale2)}
                                            {implode('',$gridforsale1)}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                                <div id="forrent" role="tabpanel" aria-labelledby="for-rent-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        {if (is_array($gridforrent6)) || (is_array($gridforrent5)) ||
                                        (is_array($gridforrent4)) || (is_array($gridforrent3)) ||
                                        (is_array($gridforrent2)) || (is_array($gridforrent1))}
                                            {implode('',$gridforrent6)}
                                            {implode('',$gridforrent5)}
                                            {implode('',$gridforrent4)}
                                            {implode('',$gridforrent3)}
                                            {implode('',$gridforrent2)}
                                            {implode('',$gridforrent1)}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                                <div id="forpending" role="tabpanel" aria-labelledby="for-pending-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        {if (is_array($gridforpending6)) || (is_array($gridforpending5)) ||
                                        (is_array($gridforpending4)) || (is_array($gridforpending3)) ||
                                        (is_array($gridforpending2)) || (is_array($gridforpending1))}
                                            {implode('',$gridforpending6)}
                                            {implode('',$gridforpending5)}
                                            {implode('',$gridforpending4)}
                                            {implode('',$gridforpending3)}
                                            {implode('',$gridforpending2)}
                                            {implode('',$gridforpending1)}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                                <div id="forsold" role="tabpanel" aria-labelledby="for-sold-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        {if (is_array($gridforsold6)) || (is_array($gridforsold5)) ||
                                        (is_array($gridforsold4)) || (is_array($gridforsold3)) ||
                                        (is_array($gridforsold2)) || (is_array($gridforsold1))}
                                            {implode('',$gridforsold6)}
                                            {implode('',$gridforsold5)}
                                            {implode('',$gridforsold4)}
                                            {implode('',$gridforsold3)}
                                            {implode('',$gridforsold2)}
                                            {implode('',$gridforsold1)}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="list" role="tabpanel" aria-labelledby="condo-list" class="tab-pane show active">
                            <div id="datalist" class="tab-content pt-3 py-sm-5">
                                <div id="forsale1" role="tabpanel" aria-labelledby="for-sale-tab condo-list" class="tab-pane show active">
                                    {if (is_array($listforsale6)) || (is_array($listforsale5)) ||
                                    (is_array($listforsale4)) || (is_array($listforsale3)) ||
                                    (is_array($listforsale2)) || (is_array($listforsale1))}
                                        {if is_array($listforsale6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsale6)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsale5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsale5)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsale4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsale4)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsale3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsale3)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsale2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsale2)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsale1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsale1)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                                <div id="forrent1" role="tabpanel" aria-labelledby="for-rent-tab condo-list" class="tab-pane show" >
                                    {if (is_array($listforrent6)) || (is_array($listforrent5)) ||
                                    (is_array($listforrent4)) || (is_array($listforrent3)) ||
                                    (is_array($listforrent2)) || (is_array($listforrent1))}
                                        {if is_array($listforrent6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforrent6)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforrent5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforrent5)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforrent4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforrent4)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforrent3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforrent3)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforrent2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforrent2)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforrent1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforrent1)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                                <div id="forpending1" role="tabpanel" aria-labelledby="for-pending-tab condo-list" class="tab-pane show" >
                                    {if (is_array($listforpending6)) || (is_array($listforpending5)) ||
                                    (is_array($listforpending4)) || (is_array($listforpending3)) ||
                                    (is_array($listforpending2)) || (is_array($listforpending1))}
                                        {if is_array($listforpending6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforpending6)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforpending5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforpending5)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforpending4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforpending4)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforpending3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforpending3)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforpending2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforpending2)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforpending1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforpending1)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                                <div id="forsold1" role="tabpanel" aria-labelledby="for-sold-tab condo-list" class="tab-pane show" >
                                    {if (is_array($listforsold6)) || (is_array($listforsold5)) ||
                                    (is_array($listforsold4)) || (is_array($listforsold3)) ||
                                    (is_array($listforsold2)) || (is_array($listforsold1))}
                                        {if is_array($listforsold6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsold6)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsold5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsold5)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsold4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsold4)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsold3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsold3)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsold2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsold2)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if is_array($listforsold1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {implode('',$listforsold1)}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {*<div class="row pt-5 px-5 condo-idx">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <ul class="nav nav-tabs p-0 border-0" id="myTab" role="tablist">
                        <li class="nav-item w-25 active"><a id="for-sale-tab" data-toggle="tab" href="#forsale" role="tab" aria-controls="forsale" aria-selected="true" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-2 p-xl-2 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) FOR SALE</a></li>
                        <li class="nav-item w-25"><a id="for-rent-tab" data-toggle="tab" href="#forrent" role="tab" aria-controls="forrent" aria-selected="false" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-2 p-xl-2 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a id="for-pending-tab" data-toggle="tab" href="#forpending" role="tab" aria-controls="forpending" aria-selected="false" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-2 p-xl-2 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) PENDING</span></a></li>
                        <li class="nav-item w-25"><a id="for-sold-tab" data-toggle="tab" href="#forsold" role="tab" aria-controls="forsold" aria-selected="false" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-2 p-xl-2 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) SOLD</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="list" role="tabpanel" aria-labelledby="condo-list" class="tab-pane show active">
                            <div class="tab-content py-5">
                                <div id="forsale" role="tabpanel" aria-labelledby="for-sale-tab" class="tab-pane show active">
                                    {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                        <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">{$key} Bedroom Condos For Sale at {$arrCondo.csearch_name} ({count($Record)})</h4>
                                        <div class="table-responsive pt-4 pb-4">
                                            <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                <thead class="te-bg-table">
                                                    <tr>
                                                        <th class="border text-center no-sort" nowrap scope="col"><i class="far fa-heart"></i></th>
                                                        <th class="border text-center" nowrap scope="col">Unit #</th>
                                                        <th class="border text-center" nowrap scope="col">List Price</th>
                                                        <th class="border text-center" nowrap scope="col">% Change</th>
                                                        <th class="border text-center" nowrap scope="col">Beds/Baths</th>
                                                        <th class="border text-center" nowrap scope="col">Sq Ft</th>
                                                        <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
                                                        <th class="border text-center" nowrap scope="col">$/Sq Ft</th>
                                                        <th class="border text-center" nowrap scope="col">Days Listed</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="border-bottom cus-fwight-bold">
                                                {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                    {if $subRecord['ListingStatus'] == 'Active'}
                                                        <tr>
                                                            <td class="border text-center te-property-favourite fav-link-container-{$subRecord.ListingID_MLS}" nowrap id="fav-link-container-{$subRecord.ListingID_MLS}">
                                                                {if $isUserLoggedIn == true}
                                                                    {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                                                    {else}
                                                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                    {/if}
                                                                {else}
                                                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                {/if}
                                                            </td>
                                                            <td class="border text-center" nowrap>{$subRecord.UnitNo}</td>
                                                            <td class="border text-center" nowrap>{$currency}{$subRecord.ListPrice|number_format}</td>
                                                            <td class="border text-center {if $subRecord.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$subRecord.Price_Diff}%</td>
                                                            <td class="border text-center" nowrap>{$subRecord.Beds|number_format} / {$subRecord.BathsFull|number_format}</td>
                                                            <td class="border text-center" nowrap>{if $subRecord.SQFT > 0}{$subRecord.SQFT|number_format}{else}0{/if}</td>
                                                            <td class="border text-center" nowrap>{$subRecord.DayOnMarket}</td>
                                                            <td class="border text-center" nowrap>
                                                                {$pripsqft = {math equation="x / y" x=$subRecord.ListPrice y=$subRecord.SQFT}}
                                                                {$currency}{if $subRecord.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                                            </td>
                                                            <td class="border text-center" nowrap>{$subRecord.DOM}</td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                                </tbody>
                                            </table>
                                        </div>
                                    {/foreach}
                                </div>
                                <div id="forrent" role="tabpanel" aria-labelledby="for-rent-tab" class="tab-pane show" >
                                    {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                        <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">{$key} Bedroom Condos For Rent at {$arrCondo.csearch_name} ({count($Record)})</h4>
                                        <div class="table-responsive pt-4 pb-4">
                                            <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                <thead class="te-bg-table">
                                                <tr>
                                                    <th class="border text-center no-sort" nowrap scope="col"><i class="far fa-heart"></i></th>
                                                    <th class="border text-center" nowrap scope="col">Unit #</th>
                                                    <th class="border text-center" nowrap scope="col">List Price</th>
                                                    <th class="border text-center" nowrap scope="col">% Change</th>
                                                    <th class="border text-center" nowrap scope="col">Beds/Baths</th>
                                                    <th class="border text-center" nowrap scope="col">Sq Ft</th>
                                                    <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
                                                    <th class="border text-center" nowrap scope="col">$/Sq Ft</th>
                                                    <th class="border text-center" nowrap scope="col">Days Listed</th>
                                                </tr>
                                                </thead>
                                                <tbody class="border-bottom cus-fwight-bold">
                                                {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                    {if $subRecord['ListingStatus'] == 'Active'}
                                                        <tr>
                                                            <td class="border text-center te-property-favourite fav-link-container-{$subRecord.ListingID_MLS}" nowrap id="fav-link-container-{$subRecord.ListingID_MLS}">
                                                                {if $isUserLoggedIn == true}
                                                                    {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                                                    {else}
                                                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                    {/if}
                                                                {else}
                                                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                {/if}
                                                            </td>
                                                            <td class="border text-center" nowrap>{$subRecord.UnitNo}</td>
                                                            <td class="border text-center" nowrap>{$currency}{$subRecord.ListPrice|number_format}</td>
                                                            <td class="border text-center {if $subRecord.Price_Diff > 0}text-success{else}text-danger{/if}" nowrap>{$subRecord.Price_Diff}%</td>
                                                            <td class="border text-center" nowrap>{$subRecord.Beds|number_format} / {$subRecord.BathsFull|number_format}</td>
                                                            <td class="border text-center" nowrap>{if $subRecord.SQFT > 0}{$subRecord.SQFT|number_format}{else}0{/if}</td>
                                                            <td class="border text-center" nowrap>{$subRecord.DayOnMarket}</td>
                                                            <td class="border text-center" nowrap>
                                                                {$pripsqft = {math equation="x / y" x=$subRecord.ListPrice y=$subRecord.SQFT}}
                                                                {$currency}{if $subRecord.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                                            </td>
                                                            <td class="border text-center" nowrap>{$subRecord.DOM}</td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                                </tbody>
                                            </table>
                                        </div>
                                    {/foreach}
                                </div>
                                <div id="forpending" role="tabpanel" aria-labelledby="for-pending-tab" class="tab-pane show" >
                                    {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                        <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">{$key} Bedroom Condos For Pending at {$arrCondo.csearch_name} ({count($Record)})</h4>
                                        <div class="table-responsive pt-4 pb-4">
                                            <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                <thead class="te-bg-table">
                                                <tr>
                                                    <th class="border text-center no-sort" nowrap scope="col"><i class="far fa-heart"></i></th>
                                                    <th class="border text-center" nowrap scope="col">Unit #</th>
                                                    <th class="border text-center" nowrap scope="col">List Price</th>
                                                    <th class="border text-center" nowrap scope="col">% Change</th>
                                                    <th class="border text-center" nowrap scope="col">Beds/Baths</th>
                                                    <th class="border text-center" nowrap scope="col">Sq Ft</th>
                                                    <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
                                                    <th class="border text-center" nowrap scope="col">$/Sq Ft</th>
                                                    <th class="border text-center" nowrap scope="col">Days Listed</th>
                                                </tr>
                                                </thead>
                                                <tbody class="border-bottom cus-fwight-bold">
                                                {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                    {if $subRecord['ListingStatus'] == 'ActiveUnderContract' || $subRecord['ListingStatus'] == 'Pending'}
                                                        <tr>
                                                            <td class="border text-center te-property-favourite fav-link-container-{$subRecord.ListingID_MLS}" nowrap id="fav-link-container-{$subRecord.ListingID_MLS}">
                                                                {if $isUserLoggedIn == true}
                                                                    {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                                                    {else}
                                                                        <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                    {/if}
                                                                {else}
                                                                    <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                {/if}
                                                            </td>
                                                            <td class="border text-center" nowrap>{$subRecord.UnitNo}</td>
                                                            <td class="border text-center" nowrap>{$currency}{$subRecord.ListPrice|number_format}</td>
                                                            <td class="border text-center {if $subRecord.Price_Diff > 0}text-success{else}text-danger{/if}" nowrap>{$subRecord.Price_Diff}%</td>
                                                            <td class="border text-center" nowrap>{$subRecord.Beds|number_format} / {$subRecord.BathsFull|number_format}</td>
                                                            <td class="border text-center" nowrap>{if $subRecord.SQFT > 0}{$subRecord.SQFT|number_format}{else}0{/if}</td>
                                                            <td class="border text-center" nowrap>{$subRecord.DayOnMarket}</td>
                                                            <td class="border text-center" nowrap>
                                                                {$pripsqft = {math equation="x / y" x=$subRecord.ListPrice y=$subRecord.SQFT}}
                                                                {$currency}{if $subRecord.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                                            </td>
                                                            <td class="border text-center" nowrap>{$subRecord.DOM}</td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                                </tbody>
                                            </table>
                                        </div>
                                    {/foreach}
                                </div>
                                <div id="forsold" role="tabpanel" aria-labelledby="for-sold-tab" class="tab-pane show" >
                                    {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                        <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">{$key} Bedroom Condos For Sold at {$arrCondo.csearch_name} ({count($Record)})</h4>
                                        <div class="table-responsive pt-4 pb-4">
                                            <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                <thead class="te-bg-table">
                                                <tr>
                                                    <th class="border text-center no-sort" nowrap scope="col"><i class="far fa-heart"></i></th>
                                                    <th class="border text-center" nowrap scope="col">Unit #</th>
                                                    <th class="border text-center" nowrap scope="col">List Price</th>
                                                    <th class="border text-center" nowrap scope="col">% Change</th>
                                                    <th class="border text-center" nowrap scope="col">Beds/Baths</th>
                                                    <th class="border text-center" nowrap scope="col">Sq Ft</th>
                                                    <th class="border text-center" nowrap scope="col">M<sup>2</sup></th>
                                                    <th class="border text-center" nowrap scope="col">$/Sq Ft</th>
                                                    <th class="border text-center" nowrap scope="col">Days Listed</th>
                                                </tr>
                                                </thead>
                                                <tbody class="border-bottom cus-fwight-bold">
                                                {if is_array($Record) && count($Record) > 0}
                                                    {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                        {if $subRecord['ListingStatus'] == 'Closed'}
                                                            <tr>
                                                                <td class="border text-center te-property-favourite fav-link-container-{$subRecord.ListingID_MLS}" nowrap id="fav-link-container-{$subRecord.ListingID_MLS}">
                                                                    {if $isUserLoggedIn == true}
                                                                        {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                                                        {else}
                                                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                        {/if}
                                                                    {else}
                                                                        <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                                                    {/if}
                                                                </td>
                                                                <td class="border text-center" nowrap>{$subRecord.UnitNo}</td>
                                                                <td class="border text-center" nowrap>{$currency}{$subRecord.ListPrice|number_format}</td>
                                                                <td class="border text-center {if $subRecord.Price_Diff > 0}text-success{else}text-danger{/if}" nowrap>{$subRecord.Price_Diff}%</td>
                                                                <td class="border text-center" nowrap>{$subRecord.Beds|number_format} / {$subRecord.BathsFull|number_format}</td>
                                                                <td class="border text-center" nowrap>{if $subRecord.SQFT > 0}{$subRecord.SQFT|number_format}{else}0{/if}</td>
                                                                <td class="border text-center" nowrap>{$subRecord.DayOnMarket}</td>
                                                                <td class="border text-center" nowrap>
                                                                    {$pripsqft = {math equation="x / y" x=$subRecord.ListPrice y=$subRecord.SQFT}}
                                                                    {$currency}{if $subRecord.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                                                </td>
                                                                <td class="border text-center" nowrap>{$subRecord.DOM}</td>
                                                            </tr>
                                                        {/if}
                                                    {/foreach}
                                                {else}
                                                    <div class="text-danger font-weight-bold">No Sold data found.</div>
                                                {/if}
                                                </tbody>
                                            </table>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                        <div id="grid" role="tabpanel" aria-labelledby="condo-grid" class="tab-pane show">
                            <div class="tab-content py-5">
                                <div id="forsale" role="tabpanel" aria-labelledby="for-sale-tab" class="tab-pane show active">
                                    <div class="row">
                                        {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                            {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$subRecord.ListingID_MLS}">
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $subRecord)}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                                        {if $subRecord.mls_is_pic_url_supported == 'Yes'}
                                                            {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {if $subRecord.MainPicture.large.url != '' && $subRecord.TotalPhotos > 0}
                                                                {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {else}
                                                                {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                                            {/if}
                                                        {else}
                                                            {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                                            {assign var=photo_url value={$subRecord.MainPicture}}
                                                        {/if}
                                                        <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                                        <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                                        <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                                            <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                                                <div class="te-property-details-price">{$currency}{$subRecord.ListPrice|number_format}</div>
                                                                <div class="te-property-details-features te-font-size-14">{$subRecord.Beds|number_format} Beds <span>|</span> {$subRecord.Baths|number_format} Baths <span>|</span> {$subRecord.SQFT|number_format} Sq Ft</div>
                                                                <div class="te-property-title text-truncate te-font-size-14">{$subRecord.StreetNumber} {$subRecord.StreetName}, {$subRecord.CityName}, {$subRecord.State} {$subRecord.ZipCode}</div>
                                                            </div>
                                                            <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                                        </div>
                                                    </a>
                                                    <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                                        {if $isUserLoggedIn == true}
                                                            {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                                            {else}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                            {/if}
                                                        {else}
                                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/foreach}
                                        {/foreach}
                                    </div>
                                </div>
                                <div id="forrent" role="tabpanel" aria-labelledby="for-rent-tab" class="tab-pane show">
                                    <div class="row">
                                        {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                            {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$subRecord.ListingID_MLS}">
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $subRecord)}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                                        {if $subRecord.mls_is_pic_url_supported == 'Yes'}
                                                            {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {if $subRecord.MainPicture.large.url != '' && $subRecord.TotalPhotos > 0}
                                                                {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {else}
                                                                {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                                            {/if}
                                                        {else}
                                                            {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                                            {assign var=photo_url value={$subRecord.MainPicture}}
                                                        {/if}
                                                        <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                                        <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                                        <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                                            <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                                                <div class="te-property-details-price">{$currency}{$subRecord.ListPrice|number_format}</div>
                                                                <div class="te-property-details-features te-font-size-14">{$subRecord.Beds|number_format} Beds <span>|</span> {$subRecord.Baths|number_format} Baths <span>|</span> {$subRecord.SQFT|number_format} Sq Ft</div>
                                                                <div class="te-property-title text-truncate te-font-size-14">{$subRecord.StreetNumber} {$subRecord.StreetName}, {$subRecord.CityName}, {$subRecord.State} {$subRecord.ZipCode}</div>
                                                            </div>
                                                            <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                                        </div>
                                                    </a>
                                                    <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                                        {if $isUserLoggedIn == true}
                                                            {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                                            {else}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                            {/if}
                                                        {else}
                                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/foreach}
                                        {/foreach}
                                    </div>
                                </div>
                                <div id="forpending" role="tabpanel" aria-labelledby="for-pending-tab" class="tab-pane show">
                                    <div class="row">
                                        {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                            {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$subRecord.ListingID_MLS}">
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $subRecord)}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                                        {if $subRecord.mls_is_pic_url_supported == 'Yes'}
                                                            {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {if $subRecord.MainPicture.large.url != '' && $subRecord.TotalPhotos > 0}
                                                                {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {else}
                                                                {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                                            {/if}
                                                        {else}
                                                            {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                                            {assign var=photo_url value={$subRecord.MainPicture}}
                                                        {/if}
                                                        <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                                        <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                                        <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                                            <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                                                <div class="te-property-details-price">{$currency}{$subRecord.ListPrice|number_format}</div>
                                                                <div class="te-property-details-features te-font-size-14">{$subRecord.Beds|number_format} Beds <span>|</span> {$subRecord.Baths|number_format} Baths <span>|</span> {$subRecord.SQFT|number_format} Sq Ft</div>
                                                                <div class="te-property-title text-truncate te-font-size-14">{$subRecord.StreetNumber} {$subRecord.StreetName}, {$subRecord.CityName}, {$subRecord.State} {$subRecord.ZipCode}</div>
                                                            </div>
                                                            <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                                        </div>
                                                    </a>
                                                    <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                                        {if $isUserLoggedIn == true}
                                                            {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                                            {else}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                            {/if}
                                                        {else}
                                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/foreach}
                                        {/foreach}
                                    </div>
                                </div>
                                <div id="forsold" role="tabpanel" aria-labelledby="for-sold-tab" class="tab-pane show">
                                    <div class="row">
                                        {foreach name=arrRecord from=$arrRecord item=Record key=key}
                                            {foreach name=SubRecord from=$Record item=subRecord key=subkey}
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 p-2" id="{$subRecord.ListingID_MLS}">
                                                    <a href="{Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $subRecord)}" class="te-property-card te-property-gradient d-block position-relative overflow-hidden">
                                                        {if $subRecord.mls_is_pic_url_supported == 'Yes'}
                                                            {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {if $subRecord.MainPicture.large.url != '' && $subRecord.TotalPhotos > 0}
                                                                {assign var=photo_url value=$subRecord.MainPicture.large.url}
                                                            {else}
                                                                {assign var=photo_url value={$PhotoBaseUrl|cat:'no-photo/0/'}}
                                                            {/if}
                                                        {else}
                                                            {assign var=photo_url value={$Record.MainPicture|cat:'/350/300/f/80'}}
                                                            {assign var=photo_url value={$subRecord.MainPicture}}
                                                        {/if}
                                                        <img class="te-property-fig te-property-image position-absolute" src="{$photo_url}">
                                                        <div class="-te-property-gradient position-absolute"></div>
<div class="top-left">
	{if $Record.ListingStatus == 'ActiveUnderContract'}
		<div class="wedges list-wedge">Under Contract</div>
	{/if}
	{if $Record.ListingStatus == 'Pending'}
		<div class="wedges list-wedge">Pending</div>
	{/if}
	{if $Record.DOM < 7}
		<div class="wedges-newListing list-wedge">New Listing</div>
	{/if}
	{if $Record.ListingStatus == 'Closed'}
		<span class="wedges list-wedge">Closed</span>
	{/if}
</div>
                                                        <div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 pt-6 te-p-5">
                                                            <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99">
                                                                <div class="te-property-details-price">{$currency}{$subRecord.ListPrice|number_format}</div>
                                                                <div class="te-property-details-features te-font-size-14">{$subRecord.Beds|number_format} Beds <span>|</span> {$subRecord.Baths|number_format} Baths <span>|</span> {$subRecord.SQFT|number_format} Sq Ft</div>
                                                                <div class="te-property-title text-truncate te-font-size-14">{$subRecord.StreetNumber} {$subRecord.StreetName}, {$subRecord.CityName}, {$subRecord.State} {$subRecord.ZipCode}</div>
                                                            </div>
                                                            <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                                        </div>
                                                    </a>
                                                    <div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                                        {if $isUserLoggedIn == true}
                                                            {if isset($userFavList) && in_array($subRecord.ListingID_MLS, $userFavList)}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
                                                            {else}
                                                                <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$subRecord.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                            {/if}
                                                        {else}
                                                            <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$subRecord.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/foreach}
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>*}
        </div>
    </section>
{else}
    <div class="col-12 no-data-msg text-center text-danger pt-3 font-weight-bold">
        The {$csearch_name} condo is disabled.
    </div>
{/if}