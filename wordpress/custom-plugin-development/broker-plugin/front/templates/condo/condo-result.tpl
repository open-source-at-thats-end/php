{if isset($arrCondo['csearch_is_visible']) && $arrCondo['csearch_is_visible'] == "Yes"}
    {capture name='table_header'}
        <thead class="te-bg-table">
        <tr>
            <th class="border text-center" nowrap scope="col">Unit #</th>
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
        <div class="col-12 no-data-msg text-center- text-danger pt-3- px-0 mt-3 n-result  font-weight-bold">
            {*0 Results*}
            <div class="no-result py-2 px-2"> No listings were found matching your search criteria. Contact us for off-market listings that may be available or coming soon.</div>
        </div>
    {/capture}
    {if $arrCondoStatisticResult > 0}
        {foreach name='CondoStatisticResult' from=$arrCondoStatisticResult['rs'] item=Record key=key}
{*            {assign var="rsAttributes" value=Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL], $Record)}*}
            {assign var="rsAttributes" value=Utility::generateListingAttributes($Record)}
            {if $Record['Beds'] == 6}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale6}
                        <tr class="clickable-row" data-href="{$rsAttributes}"">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent6}
                        <tr class="clickable-row" data-href="{$rsAttributes}"">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$Record.UnitNo}</td>
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending6}
                        <tr class="clickable-row" data-href="{$rsAttributes}"">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$Record.UnitNo}</td>
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold6}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 5}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale5}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}">*}
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
{*{$Record.UnitNo}*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent5}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            <div class="d-flex justify-content-start">
                                <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                    {if $isUserLoggedIn == true}
                                        {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                        {else}
                                            <a aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','SearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    {else}
                                        <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    {/if}
                                </div>
                                {$Record.UnitNo}
                            </div>
                        </td>
                        <td class="border text-center" nowrap>{$Record.UnitNo}</td>
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
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
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        <td class="border text-center" nowrap>
                            {* {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                             {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}

                            {if $Record.SQFT|number_format !=0}
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            {else}0{/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
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
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 4}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale4}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
{*{$Record.UnitNo}*}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT|number_format !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent4}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
                                <div class="te-property-favourite fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
                                    {if $isUserLoggedIn == true}
                                        {if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
                                            <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart"></i></a>
                                        {else}
                                            <a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                        {/if}
                                    {else}
                                        <a class="popup-modal-sm " aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart"></i></a>
                                    {/if}
                                </div>
                                {$Record.UnitNo}
                            </div>*}
                            {$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT|number_format !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending4}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
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
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 3}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale3}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
{*{$Record.UnitNo}*}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent3}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending3}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        {* remove kari*}
                  {*   <td class="border text-center" nowrap>{$Record.UnitNo}</td>*}
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
                          {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                  <td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold3}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 2}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale2}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
{*{$Record.UnitNo}*}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent2}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending2}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*

                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold2}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
            {/if}
            {if $Record['Beds'] == 1}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Active' || $Record['ListingStatus'] == 'ActiveUnderContract' || $Record['ListingStatus'] == 'ComingSoon' || $Record['ListingStatus'] == 'Pending')}
                    {capture append=listforsale1}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
{*{$Record.UnitNo}*}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*

                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Active' && $Record['PropertyType'] == 'ResidentialLease'}
                    {capture append=listforrent1}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['PropertyType'] != 'ResidentialLease' && ($Record['ListingStatus'] == 'Pending' || $Record['ListingStatus'] == 'ActiveUnderContract')}
                    {capture append=listforpending1}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
                        <tr class="clickable-row" data-href="{$Host_Url}/{$rsAttributes.SFUrl}">
                        <td class="border text-center" nowrap>
                            {*<div class="d-flex justify-content-start">
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
</div>*}
{$Record.UnitNo}
                        </td>
                        <td class="border text-center" nowrap>{$Record.UnitNo}</td>
                        <td class="border text-center" nowrap>{$currency}{$Record.ListPrice|number_format}</td>
{$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
<td class="border text-center {if $Record.Price_Diff >= 0}text-success{else}text-danger{/if}" nowrap>{$currency}{str_replace('-','',$pricedef)|number_format} ({$Record.Price_Diff|round:2}%)</td>
                        <td class="border text-center" nowrap>{$Record.Beds|number_format} / {$Record.Baths|number_format} / {$Record.BathsHalf|number_format}</td>
                        <td class="border text-center" nowrap>{if $Record.SQFT > 0}{$Record.SQFT|number_format}{else}0{/if}</td>
                        <td class="border text-center" nowrap>{$meterssquare = {math equation="x * y" x=$Record.SQFT y='0.0929'}}
                            {if $meterssquare > 0}{$meterssquare|number_format}{else}-{/if}</td>
                        {*<td class="border text-center" nowrap>
                                *}{*{$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}*}{*
                                {if $Record.SQFT|number_format !=0}
                                    {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                    {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                                {else}0{/if}
                            </td>*}
                        {if $Record.SQFT !=0}
                            <td class="border text-center" nowrap>
                                {$pripsqft = {math equation="x / y" x=$Record.ListPrice y=$Record.SQFT}}
                                {$currency}{if $Record.SQFT > 0}{$pripsqft|number_format}{else}0{/if}
                            </td>
                        {else}
                            <td class="border text-center" nowrap>0</td>
                        {/if}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
                {if $Record['ListingStatus'] == 'Closed' && $Record['PropertyType'] != 'ResidentialLease'}
                    {capture append=listforsold1}
{*                        <tr class="clickable-row" data-href="{$rsAttributes}"">*}
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
                                    <div class="-te-gradient te-trans te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 te-text-shadow">
                                        {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                        <div class="te-property-details-price">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} font-weight-normal">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</div>
                                        <div class="te-property-details-features te-font-size-12">{$Record.Beds|number_format} Beds <span>|</span> {$Record.Baths|number_format} Baths <span>|</span> {$Record.SQFT|number_format} Sq Ft</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.StreetNumber} {$Record.StreetName}</div>
<div class="te-property-title text-truncate te-font-size-12">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                    </div>
                                    <div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div>
                                </div>
                            </a>
                            {*<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-{$Record.ListingID_MLS}" id="fav-link-container-{$Record.ListingID_MLS}">
	{if $isUserLoggedIn == true}
		{if isset($userFavList) && in_array($Record.ListingID_MLS, $userFavList)}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Remove','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Remove to favorites"><i class="fas fa-heart text-white"></i></a>
		{else}
			<a class="mr-3" aria-label="button" onclick="JavaScript:UpdateFavorites_Click('{$Record.ListingID_MLS}', 'Add','CondoSearchResult','{$user_id}');" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
		{/if}
	{else}
		<a class="popup-modal-sm mr-3" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login&ReqType=AddFav&mlsNum={$Record.ListingID_MLS}" href="JavaScript:void(0);" role="button" title="Add to favorites"><i class="far fa-heart text-white"></i></a>
	{/if}
</div>*}
                        </div>
                    {/capture}
                {/if}
            {/if}
        {/foreach}
    {/if}
    <section id="condo-building" class="condo-building te-font-family">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="properties-slider condo-slider border-0">
                        {foreach name='CondoSearchResult' from=$arrCondoResult item=Record}
                            {assign var="rsAttributes" value=Utility::generateListingAttributes($Record)}
{*                            {assign var="rsAttributes" value=Utility::formatListingUrl($arrConfig[Constants::OPTION_PAGE_CONFIG][Constants::OPTION_PAGE_PERMALINK_DETAIL],$Record)}*}
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
                                        <div class="property-info te-smooth-gradient te-text-shadow">
                                            {*<h3 class="text-white font-weight-bold pb-1">{$currency}{$Record.ListPrice|number_format}</h3>*}
                                            {$pricedef = {math equation="x - y" x=$Record.OriginalListPrice y=$Record.ListPrice}}
                                            <h3 class="text-white pb-1">{$currency}{$Record.ListPrice|number_format} {if $pricedef != 0}<span class="{if $Record.Price_Diff|substr:0:1 == '-'}text-danger{else}text-success{/if} te-font-size-18">{if $Record.Price_Diff|substr:0:1 == '-'}<i class="fas fa-arrow-down"></i>{else}<i class="fas fa-arrow-up"></i>{/if}{$currency}{str_replace('-','',$pricedef)|number_format}</span>{/if}</h3>
                                            <div class="pb-2- style-3-address te-font-size-12">{$Record.Beds|number_format} Beds &nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp; {$Record.Baths|number_format} Baths</div>
                                            <div class="te-property-details-features te-font-size-12 pb-2- text-uppercase- font-weight-normal">{$Record.Address}</div>
                                            <div class="te-property-details-features te-font-size-12 pb-2- text-uppercase- font-weight-normal">{$Record.CityName}, {$Record.State} {$Record.ZipCode}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="row d-lg-none condo-idx-list">
                <div class="col-12 px-0">
                    <ul class="nav nav-tabs p-0 border-0 conTabs" id="dataListTab" role="tablist">
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale1" href="#mainListTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_active_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">FOR SALE</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent1" href="#mainListTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_rental_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending1" href="#mainListTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_pending_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">PENDING</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold1" href="#mainListTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_sold_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">SOLD</span></a></li>
                    </ul>
                    <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="dataGridTab" role="tablist">
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale" href="#mainGridTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_active_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">FOR SALE</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent" href="#mainGridTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_rental_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">FOR RENT</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending" href="#mainGridTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_pending_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">PENDING</span></a></li>
                        <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold" href="#mainGridTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm p-3 font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_sold_listing']|number_format}<span class="d-block font-weight-normal- tabsFSize">SOLD</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="row px-xl-5 py-3- pt-4 pt-lg-5 align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8 align-self-center- pb-0 heading text-left- px-2">
                    <h3 class="align-middle pb-2"><b>{$csearch_name}</b></h3>
                    {*<span class="text-uppercase te-font-size-14">{$arrSearchCriteria['add']}, {$arrSearchCriteria['city']}, {$arrSearchCriteria['zipcode']}</span>*}
                    <span class="text-uppercase te-font-size-12">{$arrCondo['csearch_address']}, {$arrCondo['csearch_city']}, {$arrCondo['csearch_zipcode']}</span>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-4 align-self-center- px-2">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center col-md-auto- col-xl-auto- p-0 px-sm-5 px-xl-4 btn-gray py-lg-2-">
                            <button id="share-btn" class="btn btn-sm dropdown-toggle font-tab- dropdown-block font-size-sm-10- font-size-sm-12- te-btn- text-white- te-font-size-12- te-btn- text-white- shadow-none p-2 p-lg-2- px-xl-3- px-4 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline d-lg-inline">SHARE</span>
                            </button>
                            <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
                                <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
                                <a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
                                <a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
                                <a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($csearch_name) && $csearch_name != ''}{$csearch_name}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
                            </div>
                        </div>
{*                        {if isset($arrConfig['Site_Agent']['market_report_active']) && $arrConfig['Site_Agent']['market_report_active'] == true}*}
                            {if isset($arrCondo['csearch_generate_mrktreport']) && $arrCondo['csearch_generate_mrktreport'] == 'Yes'}
                                <a href="{$marketReportURL}" class="btn btn-sm font-size-sm-12 te-font-size-14 font-size-sm-10 shadow-none p-0 p-1- p-lg-2 p-xl-2 px-2- font-tab- text-sm-right rounded-0 font-weight-bold- lpt-btn text-white d-none- d-lg-block-">
                                    <i class="fas fa-2x fa-poll text-white- pr-2 align-middle"></i>
                                    <span class="d-none- d-sm-inline d-lg-inline align-middle">{if cw::$screen == 'XS'}INSIGHTS {else} MARKET INSIGHTS{/if}</span>
                                </a>
                            {/if}
{*                        {/if}*}
                        {*<a href="javascript::void(0);" class="btn btn-sm align-self-center btn-gray- font-size-sm-12 font-size-sm-10 te-btn- text-white- te-font-size-14 te-btn- shadow-none p-0 p-lg-2 p-xl-2 px-2- text-md-right te-pre-saveser px-xl-3 font-tab- col-md-4- col-xl-auto- px-sm-3 rounded-0 lpt-btn- lpt-btn-txt- popup-modal-sm" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch&cid={$condoId}{else}/?action=member-login&ReqType=SaveSearch&cid={$condoId}{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
                            <i class="far fa-2x fa-bell align-middle pr-2"></i>
                            <span class="d-none- d-sm-inline">Alerts</span>
                        </a>*}
                        {*<div id="user-condo-savesearch">
                            <button id="save_search" class="btn btn-sm align-self-center btn-gray- font-size-sm-12 font-size-sm-10 te-btn- text-white- te-font-size-14 te-btn- shadow-none p-0 p-lg-2 p-xl-2 px-2- text-md-right te-pre-saveser px-xl-3 font-tab- col-md-4- col-xl-auto- px-sm-3 rounded-0 lpt-btn- lpt-btn-txt- popup-modal-sm" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch&cid={$condoId}{else}/?action=member-login&ReqType=SaveSearch&cid={$condoId}{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
                                <i class="far fa-2x fa-bell align-middle pr-2"></i>
                                <span class="d-none- d-sm-inline">Alerts</span>
                            </button>
                        </div>*}
                    </div>
                </div>
                {*<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 text-center text-sm-right">
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
                </div>*}
            </div>
            <div class="row px-lg-1 px-xl-5 pt-2 pt-lg-4"><div class="col-12 px-1 px-lg-1"><div class="border-top"></div></div></div>
            {if isset($arrCondo['csearch_short_desc']) && $arrCondo['csearch_short_desc'] != ''}
                <div class="row px-xl-5 py-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p>{$arrCondo['csearch_short_desc']}</p>
                    </div>
                </div>
            {/if}
            <div class="row pt-lg-2 px-lg-2 px-xl-5 condo-idx-list">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-2">
                    <div class="{*d-md-flex justify-content-between align-items-center*} py-lg-3 d-none- d-md-block-">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-12 d-flex justify-content-between align-items-center pt-4 pt-lg-0">
                                <h4 class="align-middle- text-center text-sm-left pb-0 condo-sub-title pl-2- pl-md-0"><b>{$csearch_name} Condos</b></h4>
                                {*<div>
                                    {if isset($arrCondo['csearch_generate_mrktreport']) && $arrCondo['csearch_generate_mrktreport'] == 'Yes'}
                                        <a href="{$marketReportURL}" class="btn btn-sm btn-primary- btn-market-insight- text-primary font-size-sm-12 te-font-size-14 font-size-sm-10 shadow-none p-0 p-1- p-lg-1 p-xl-2 px-2- font-tab- text-sm-right rounded-0 font-weight-bold">
                                            <i class="fas fa-2x fa-poll text-dark pr-2 align-middle"></i>
                                            <span class="d-none- d-sm-inline d-lg-inline">{if cw::$screen == 'XS'}Insights {else} Market Insights{/if}</span>
                                        </a>
                                    {/if}
                                    <div class="dropdown d-inline-block mx-1- mx-lg-0 align-self-center col-md-auto- col-xl-auto- p-0 px-sm-3">
                                        <button id="share-btn" class="btn btn-sm dropdown-toggle font-tab- dropdown-block font-size-sm-10 font-size-sm-12 te-btn- text-white- te-font-size-12- te-btn- text-white- shadow-none p-lg-2- px-xl-3- px-2 te-share-propery-detail rounded-0 w-100 lpt-btn- lpt-btn-txt-" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-share-alt fa-2x align-middle pr-2"></i><span class="d-none- d-sm-inline d-lg-inline">Share</span>
                                        </button>
                                        <div class="dropdown-menu border rounded-0" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item font-size-14 py-1" href="https://www.facebook.com/share.php?u={$shareUrl}" target="_blank"><i class="fab fa-facebook-f pr-2"></i> Facebook</a>
                                            <a class="dropdown-item font-size-14 py-1" href="https://twitter.com/share?url={$shareUrl}" target="_blank"><i class="fab fa-twitter pr-1"></i> Twitter</a>
                                            <a class="dropdown-item font-size-14 py-1" href="https://pinterest.com/pin/create/button/?url={$shareUrl}" target="_blank"><i class="fab fa-pinterest-p pr-2" ></i> Pinterest</a>
                                            <a class="dropdown-item font-size-14 py-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={$shareUrl}" target="_blank"><i class="fab fa-linkedin-in pr-2"></i> LinkedIn</a>
                                            <a class="dropdown-item font-size-14 py-1" href="mailto:?subject=Share {if isset($csearch_name) && $csearch_name != ''}{$csearch_name}{/if}&body={$shareUrl}" target="_blank"><i class="fas fa-envelope pr-2 pr-2"></i> Email</a>
                                        </div>
                                    </div>
                                    <a href="javascript::void(0);" class="btn btn-sm align-self-center btn-gray- font-size-sm-12 font-size-sm-10 te-btn- text-white- te-font-size-14 te-btn- shadow-none p-0 p-lg-2 p-xl-2 px-2- text-md-right te-pre-saveser px-xl-3 font-tab- col-md-4- col-xl-auto- px-sm-3 rounded-0 lpt-btn- lpt-btn-txt- popup-modal-sm" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}{if $isUserLoggedIn == true}/?action=SaveSearch&cid={$condoId}{else}/?action=member-login&ReqType=SaveSearch&cid={$condoId}{/if}" data-toggle="modal" data-target="{if $isUserLoggedIn == true}savesearch{else}MemberLogin{/if}">
                                        <i class="far fa-2x fa-bell align-middle pr-2"></i>
                                        <span class="d-none- d-sm-inline">Alerts</span>
                                    </a>
                                </div>*}
                            </div>
                            <div class="col-xl-4 col-lg-6 col-12 order-1 order-lg-2 d-none d-lg-block">
                                <ul class="nav nav-tabs p-0 border-0 conTabs" id="dataListTab" role="tablist">
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale1" href="#mainListTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_active_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR SALE</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent1" href="#mainListTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_rental_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR RENT</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending1" href="#mainListTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_pending_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">PENDING</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold1" href="#mainListTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_sold_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">SOLD</span></a></li>
                                </ul>
                                <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="dataGridTab" role="tablist">
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsale" href="#mainGridTabs" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_active_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR SALE</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forrent" href="#mainGridTabs" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_rental_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">FOR RENT</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forpending" href="#mainGridTabs" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_pending_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">PENDING</span></a></li>
                                    <li class="nav-item w-25"><a data-toggle="tab" data-target="#forsold" href="#mainGridTabs" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-lg-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">{$arrCStatistics['statistic_total_sold_listing']|number_format}<span class="d-block font-weight-normal tabsFSize">SOLD</span></a></li>
                                </ul>
                            </div>
                        </div>
                        {*<div>
                            <ul class="nav nav-tabs p-0 border-0 justify-content-center" id="viewTab" role="tablist">
                                <li class="nav-item"><a id="condo-grid" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="false" class="nav-link font-size-sm-10 font-size-sm-12 te-font-size-12 pr-3 tab-btn- border-0"><span class="condo-font-size-18 align-middle">Grid</span> <i class="fa fa-th pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a></li>
                                <li class="nav-item active"><a id="condo-list" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true" class="nav-link active font-size-sm-10 font-size-sm-12 te-font-size-12 tab-btn- border-0"><span class="condo-font-size-18 align-middle">List</span> <i class="fa fa-bars pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a></li>
                            </ul>
                        </div>*}
                    </div>
                    <div class="row pt-3 te-font-size-14 px-2 px-lg-0 text-dark">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pb-md-5- pb-lg-0 px-2">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Year Built</span><span class="font-weight-bold">{if $arrCondo['csearch_year_built'] != ''}{$arrCondo['csearch_year_built']}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units</span><span class="font-weight-bold">{if $arrCondo['csearch_unit'] != ''}{$arrCondo['csearch_unit']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Stories</span><span class="font-weight-bold">{if $arrCondo['csearch_stories'] != ''}{$arrCondo['csearch_stories']|number_format}{else}-{/if}</span></li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pb-md-5- pb-lg-0 px-2">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Active Units For Sale</span><span class="font-weight-bold">{if $arrCStatistics['statistic_total_active_listing'] > 0}{$arrCStatistics['statistic_total_active_listing']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units Under Contract</span><span class="font-weight-bold">{if $arrCStatistics['statistic_total_under_contract_listing'] > 0}{$arrCStatistics['statistic_total_under_contract_listing']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Units Sold (6 months)</span><span class="font-weight-bold">{if $arrCStatistics['statistic_sixmon_tot_sold_listing'] > 0}{$arrCStatistics['statistic_sixmon_tot_sold_listing']|number_format}{else}-{/if}</span></li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 px-2">
                            <ul class="p-0">
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price Listed / SqFt</span><span class="font-weight-bold">{if $arrCStatistics['statistic_avg_price_sqft'] > 0}{$currency}{$arrCStatistics['statistic_avg_price_sqft']|number_format}{else}-{/if}</span></li>
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Price Sold / SqFt</span><span class="font-weight-bold">{if $arrCStatistics['statistic_avg_sold_price_sqft'] > 0}{$currency}{$arrCStatistics['statistic_avg_sold_price_sqft']|number_format}{else}-{/if}</span></li>
                                {*<li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Average Days on Market</span><span class="font-weight-bold">{if $arrCStatistics['statistic_avg_dom'] > 0}{$arrCStatistics['statistic_avg_dom']|number_format}{else}-{/if}</span></li>format}{else}-{/if}</span></li>*}
                                <li class="d-flex justify-content-between border-bottom pb-3 pt-3"><span>Largest Discount</span><span class="font-weight-bold {if $arrCStatistics['statistic_biggest_price_change'] < 0}text-danger{else}text-success{/if}">{if $arrCStatistics['statistic_biggest_price_change'] != ''}{$currency}{$arrCStatistics['statistic_largest_price_reduction']|number_format} {if $arrCStatistics['statistic_biggest_price_change'] > 0}+{/if}({$arrCStatistics['statistic_biggest_price_change']|round:2|number_format}%){else}-{/if}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                {*<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 pt-5 pt-xl-0">*}
                {*<ul class="nav nav-tabs p-0 border-0 conTabs" id="dataListTab" role="tablist">
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
                </ul>*}
                {*<div class="row pt-4">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pb-sm-5 pb-lg-0 condo-pv-url text-center">
                        <p class="text-left text-uppercase cus-fwight-bold">THINKING OF SELLING YOUR {$arrCondo.csearch_name} CONDO? SCHEDULE A FREE VALUATION.</p>
                        {if isset($arrConfig['Agent']['agent_condo_photo_video_url']) && $arrConfig['Agent']['agent_condo_photo_video_url'] != ''}
                            {if strpos($arrConfig['Agent']['agent_condo_photo_video_url'], 'youtube')}
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="{$arrConfig['Agent']['agent_condo_photo_video_url']}" class="embed-responsive-item"></iframe>
                                </div>
                            {else}
                                <img src="{$arrConfig['Agent']['agent_condo_photo_video_url']}" alt="{$arrCondo.csearch_name}" class="pt-3 img-fluid w-100">
                            {/if}
                        {else}
                            {if strpos($arrCondo.csearch_photo_video_url, 'youtube')}
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="{$arrCondo.csearch_photo_video_url}" class="embed-responsive-item"></iframe>
                                </div>
                            {else}
                                <img src="{$arrCondo.csearch_photo_video_url}" alt="{$arrCondo.csearch_name}" class="pt-3 img-fluid w-100">
                            {/if}
                        {/if}
                    </div>
                </div>*}
                {*</div>*}
            </div>
            <div class="row pt-2 pt-md-4 pt-lg-5 px-lg-2 px-xl-5 condo-idx te-font-size-14 px-2 px-md-0">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-lg-0">
                    {if cw::$screen == 'XS'}
                        <div class="row text-center py-4">
                            <div class="col-12 px-2">
                                {if isset($arrCondo['csearch_generate_mrktreport']) && $arrCondo['csearch_generate_mrktreport'] == 'Yes'}
                                    <a href="{$marketReportURL}" class="btn btn-lg shadow-none rounded-0 lpt-btn text-white d-lg-none w-100">
                                        <span class="d-none- d-sm-inline d-lg-inline align-middle">MARKET TRENDS</span>
                                    </a>
                                {/if}
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6 pr-0 conTabs pl-2">
                                <div class="p-0 border w-100 mblList" id="myListTab">
                                    <div id="mainListTabs" class="hidden"></div>
                                    <select class="custom-select cusOptions border-0 w-75- w-auto py-0 px-3 text-center">
                                        <option id="for-sale-tab" value="forsale" aria-controls="forsale" data-title="!for-sale" data-target="#forsale1">FOR SALE</option>
                                        <option id="for-rent-tab" value="forrent" aria-controls="forrent" data-title="!for-rent" data-target="#forrent1">FOR RENT</option>
                                        <option id="for-pending-tab" value="forpending" aria-controls="forpending" data-title="!pending" data-target="#forpending1">PENDING</option>
                                        <option id="for-sold-tab" value="forsold" aria-controls="forsold" data-title="!sold" data-target="#forsold1">SOLD</option>
                                    </select>
                                </div>
                               {* <div class="p-0 border w-100 d-none mblGrid" id="mymdidTab">*}
                                <div class="p-0 border w-100 d-none mblGrid" id="myGridTab">
                                    <div id="mainGridTabs" class="hidden"></div>
                                    <select class="custom-select cusOptions border-0 w-75- w-auto py-0 px-3 text-center">
                                        <option id="for-sale-tab" value="forsale" aria-controls="forsale" data-title="!for-sale" data-target="#forsale">FOR SALE</option>
                                        <option id="for-rent-tab" value="forrent" aria-controls="forrent" data-title="!for-rent" data-target="#forrent">FOR RENT</option>
                                        <option id="for-pending-tab" value="forpending" aria-controls="forpending" data-title="!pending" data-target="#forpending">PENDING</option>
                                        <option id="for-sold-tab" value="forsold" aria-controls="forsold" data-title="!sold" data-target="#forsold">SOLD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 pl-0 pr-2">
                                <div class="border- w-100 conTabs mblView">
                                    {*<select class="custom-select listgridOptions border-0 w-75- w-auto py-0 px-3 text-center" id="listgridOptions">
                                        <option id="condo-list" value="condo-list" data-target="#datalist" aria-controls="list">List &nbsp; &#xf0c9;</option>
                                        <option id="condo-grid" value="condo-grid" data-target="#datagrid" aria-controls="grid">Grid &nbsp; &#xf0ce;</option>
                                    </select>*}
                                    <div class="dropdown list-grid-dropdown">
                                        <button class="btn btn-secondary- text-primary custom-select border- dropdown-toggle listgridOptions" type="button"    id="listgridOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            LIST <i class="fas fa-bars pl-2-"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <div id="condo-list" value="condo-list"  class="dropdown-item text-primary " href="#">LIST <i class="fas fa-bars"></i></div>
                                            <div id="condo-grid" value="condo-grid"  class="dropdown-item text-primary" href="#">GRID <i class="fas fa-th"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {else}
                        <ul class="nav nav-tabs p-0 border-0 conTabs" id="myListTab" role="tablist">
                            <div id="mainListTabs" class="hidden"></div>
                            <li class="nav-item w-25"><a id="for-sale-tab" data-target="#forsale1" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-rent-tab" data-target="#forrent1" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-pending-tab" data-target="#forpending1" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-sold-tab" data-target="#forsold1" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a></li>
                        </ul>
                        <ul class="nav nav-tabs p-0 border-0 conTabs d-none" id="myGridTab" role="tablist">
                            <div id="mainGridTabs" class="hidden"></div>
                            <li class="nav-item w-25"><a id="for-sale-tab" data-target="#forsale" data-toggle="tab" role="tab" aria-controls="forsale" aria-selected="true" data-title="!for-sale" class="nav-link active btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 te-btn- shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 lpt-btn lpt-btn-txt tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_active_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR SALE</span>{else}FOR SALE{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-rent-tab" data-target="#forrent" data-toggle="tab" role="tab" aria-controls="forrent" aria-selected="false" data-title="!for-rent" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_rental_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">FOR RENT</span>{else}FOR RENT{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-pending-tab" data-target="#forpending" data-toggle="tab" role="tab" aria-controls="forpending" aria-selected="false" data-title="!pending" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn condo-border-right font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_pending_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">PENDING</span>{else}PENDING{/if}</a></li>
                            <li class="nav-item w-25"><a id="for-sold-tab" data-target="#forsold" data-toggle="tab" role="tab" aria-controls="forsold" aria-selected="false" data-title="!sold" class="nav-link btn btn-sm font-size-sm-10 font-size-sm-12 te-font-size-12 shadow-none p-md-3 p-xl-3 px-1 font-tab rounded-0 tab-btn font-weight-bold w-100 h-100">({$arrCStatistics['statistic_total_sold_listing']|number_format}) {if cw::$screen == 'XS'}<span class="d-block tabsFSize">SOLD</span>{else}SOLD{/if}</a></li>
                        </ul>
                        <ul class="nav nav-tabs p-0 border-0 justify-content-end pt-3 py-0" id="viewTab" role="tablist">
                            <li class="nav-item active"><a id="condo-list" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true" class="nav-link active font-size-sm-10 font-size-sm-12 te-font-size-12 tab-btn- border-0"><span class="condo-font-size-18 align-middle">List</span> <i class="fa fa-bars pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a></li>
                            <li class="nav-item"><a id="condo-grid" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="false" class="nav-link font-size-sm-10 font-size-sm-12 te-font-size-12 pr-3 tab-btn- border-0"><span class="condo-font-size-18 align-middle">Grid</span> <i class="fa fa-th pr-md-1 pr-0 {if cw::$screen == 'XS'} fa-1x {else} fa-2x {/if} align-middle"></i></a></li>
                        </ul>
                    {/if}
                    <div class="tab-content" id="myTabContent">
                        <div id="grid" role="tabpanel" aria-labelledby="condo-grid" class="tab-pane show">
                            <div id="datagrid" class="tab-content py-5">
                                <div id="forsale" role="tabpanel" aria-labelledby="for-sale-tab condo-grid" class="tab-pane show active">
                                    <div class="row">
                                        {if (isset($gridforsale6) && is_array($gridforsale6)) || (isset($gridforsale5) && is_array($gridforsale5)) ||
                                        (isset($gridforsale4) && is_array($gridforsale4)) || (isset($gridforsale3) && is_array($gridforsale3)) ||
                                        (isset($gridforsale3) && is_array($gridforsale2)) || (isset($gridforsale1) && is_array($gridforsale1))}

                                            {if $gridforsale6 !=''} {implode('',$gridforsale6)} {/if}
                                            {if $gridforsale5 !=''} {implode('',$gridforsale5)} {/if}
                                            {if $gridforsale4 !=''} {implode('',$gridforsale4)} {/if}
                                            {if $gridforsale3 !=''} {implode('',$gridforsale3)} {/if}
                                            {if $gridforsale2 !=''} {implode('',$gridforsale2)} {/if}
                                            {if $gridforsale1 !=''} {implode('',$gridforsale1)} {/if}
                                            {*{implode('',$gridforsale5)}
                                            {implode('',$gridforsale4)}
                                            {implode('',$gridforsale3)}
                                            {implode('',$gridforsale2)}
                                            {implode('',$gridforsale1)}*}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                                <div id="forrent" role="tabpanel" aria-labelledby="for-rent-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        {if (isset($gridforrent6) && is_array($gridforrent6)) || (isset($gridforrent5) && is_array($gridforrent5)) ||
                                        (isset($gridforrent4) && is_array($gridforrent4)) || (isset($gridforrent3) && is_array($gridforrent3)) ||
                                        (isset($gridforrent2) && is_array($gridforrent2)) || (isset($gridforrent1) && is_array($gridforrent1))}

                                            {if $gridforrent6 !=''} {implode('',$gridforrent6)} {/if}
                                            {if $gridforrent5 !=''} {implode('',$gridforrent5)} {/if}
                                            {if $gridforrent4 !=''} {implode('',$gridforrent4)} {/if}
                                            {if $gridforrent3 !=''} {implode('',$gridforrent3)} {/if}
                                            {if $gridforrent2 !=''} {implode('',$gridforrent2)} {/if}
                                            {if $gridforrent1 !=''} {implode('',$gridforrent1)} {/if}
                                            {*{implode('',$gridforrent6)}
                                            {implode('',$gridforrent5)}
                                            {implode('',$gridforrent4)}
                                            {implode('',$gridforrent3)}
                                            {implode('',$gridforrent2)}
                                            {implode('',$gridforrent1)}*}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                                <div id="forpending" role="tabpanel" aria-labelledby="for-pending-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        {if (isset($gridforpending6) && is_array($gridforpending6)) || (isset($gridforpending5) && is_array($gridforpending5)) ||
                                        (isset($gridforpending4) && is_array($gridforpending4)) || (isset($gridforpending3) && is_array($gridforpending3)) ||
                                        (isset($gridforpending2) && is_array($gridforpending2)) || (isset($gridforpending1) && is_array($gridforpending1))}
                                            {if $gridforpending6 !=''} {implode('',$gridforpending6)} {/if}
                                            {if $gridforpending5 !=''} {implode('',$gridforpending5)} {/if}
                                            {if $gridforpending4 !=''} {implode('',$gridforpending4)} {/if}
                                            {if $gridforpending3 !=''} {implode('',$gridforpending3)} {/if}
                                            {if $gridforpending2 !=''} {implode('',$gridforpending2)} {/if}
                                            {if $gridforpending1 !=''} {implode('',$gridforpending1)} {/if}
                                            {*{implode('',$gridforpending6)}
                                            {implode('',$gridforpending5)}
                                            {implode('',$gridforpending4)}
                                            {implode('',$gridforpending3)}
                                            {implode('',$gridforpending2)}
                                            {implode('',$gridforpending1)}*}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                                <div id="forsold" role="tabpanel" aria-labelledby="for-sold-tab condo-grid" class="tab-pane show">
                                    <div class="row">
                                        {if (isset($gridforsold6) && is_array($gridforsold6)) || (isset($gridforsold5) && is_array($gridforsold5)) ||
                                        (isset($gridforsold4) && is_array($gridforsold4)) || (isset($gridforsold3) && is_array($gridforsold3)) ||
                                        (isset($gridforsold2) && is_array($gridforsold2)) || (isset($gridforsold1) && is_array($gridforsold1))}
                                            {if $gridforsold6 !=''} {implode('',$gridforsold6)} {/if}
                                            {if $gridforsold5 !=''} {implode('',$gridforsold5)} {/if}
                                            {if $gridforsold4 !=''} {implode('',$gridforsold4)} {/if}
                                            {if $gridforsold3 !=''} {implode('',$gridforsold3)} {/if}
                                            {if $gridforsold2 !=''} {implode('',$gridforsold2)} {/if}
                                            {if $gridforsold1 !=''} {implode('',$gridforsold1)} {/if}
                                            {*{implode('',$gridforsold6)}
                                            {implode('',$gridforsold5)}
                                            {implode('',$gridforsold4)}
                                            {implode('',$gridforsold3)}
                                            {implode('',$gridforsold2)}
                                            {implode('',$gridforsold1)}*}
                                        {else}
                                            {$smarty.capture.no_results}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="list" role="tabpanel" aria-labelledby="condo-list" class="tab-pane show active">
                            <div id="datalist" class="tab-content pt-3 py-sm-0">
                                <div id="forsale1" role="tabpanel" aria-labelledby="for-sale-tab condo-list" class="tab-pane show active">
                                    {if (isset($listforsale6) && is_array($listforsale6)) || (isset($listforsale5) && is_array($listforsale5)) ||
                                    (isset($listforsale4) && is_array($listforsale4)) || (isset($listforsale3) && is_array($listforsale3)) ||
                                    (isset($listforsale2) && is_array($listforsale2)) || (isset($listforsale1) && is_array($listforsale1))}
                                        {if is_array($listforsale6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {if $listforsale6 !=''} {implode('',$listforsale6)} {/if}

                                                    {*{implode('',$listforsale6)}*}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsale5) && is_array($listforsale5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsale5)}*}

                                                    {if $listforsale5 !=''} {implode('',$listforsale5)} {/if}

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
                                                    {*{implode('',$listforsale4)}*}
                                                    {if $listforsale4 !=''} {implode('',$listforsale4)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsale3) && is_array($listforsale3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsale3)}*}
                                                    {if $listforsale3 !=''} {implode('',$listforsale3)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsale2) && is_array($listforsale2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsale2)}*}
                                                    {if $listforsale2 !=''} {implode('',$listforsale2)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsale1) && is_array($listforsale1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos For Sale at {$arrCondo.csearch_name} ({$listforsale1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsale1)}*}
                                                    {if $listforsale1 !=''} {implode('',$listforsale1)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                                <div id="forrent1" role="tabpanel" aria-labelledby="for-rent-tab condo-list" class="tab-pane show" >
                                    {if (isset($listforrent6) && is_array($listforrent6)) || (isset($listforrent5) && is_array($listforrent5)) ||
                                    (isset($listforrent4) && is_array($listforrent4)) || (isset($listforrent3) && is_array($listforrent3)) ||
                                    (isset($listforrent2) && is_array($listforrent2)) || (isset($listforrent1) && is_array($listforrent1))}
                                        {if isset($listforrent6) && is_array($listforrent6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforrent6)}*}
                                                    {if $listforrent6 !=''} {implode('',$listforrent6)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforrent5) && is_array($listforrent5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                   {* {implode('',$listforrent5)}*}
                                                    {if $listforrent5 !=''} {implode('',$listforrent5)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforrent4) && is_array($listforrent4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforrent4)}*}
                                                    {if $listforrent4 !=''} {implode('',$listforrent4)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforrent3) && is_array($listforrent3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforrent3)}*}
                                                    {if $listforrent3 !=''} {implode('',$listforrent3)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforrent2) && is_array($listforrent2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforrent2)}*}
                                                    {if $listforrent2 !=''} {implode('',$listforrent2)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforrent1) && is_array($listforrent1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos For Rent at {$arrCondo.csearch_name} ({$listforrent1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforrent1)}*}
                                                    {if $listforrent1 !=''} {implode('',$listforrent1)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                                <div id="forpending1" role="tabpanel" aria-labelledby="for-pending-tab condo-list" class="tab-pane show" >
                                    {if (isset($listforpending6) && is_array($listforpending6)) || (isset($listforpending5) && is_array($listforpending5)) ||
                                    (isset($listforpending4) && is_array($listforpending4)) || (isset($listforpending3) && is_array($listforpending3)) ||
                                    (isset($listforpending2) && is_array($listforpending2)) || (isset($listforpending1) && is_array($listforpending1))}
                                        {if isset($listforpending6) && is_array($listforpending6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                   {* {implode('',$listforpending6)}*}
                                                    {if $listforpending6 !=''} {implode('',$listforpending6)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforpending5) && is_array($listforpending5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforpending5)}*}
                                                    {if $listforpending5 !=''} {implode('',$listforpending5)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforpending4) && is_array($listforpending4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                   {* {implode('',$listforpending4)}*}
                                                    {if $listforpending4 !=''} {implode('',$listforpending4)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforpending3) && is_array($listforpending3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforpending3)}*}
                                                    {if $listforpending3 !=''} {implode('',$listforpending3)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforpending2) && is_array($listforpending2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforpending2)}*}
                                                    {if $listforpending2 !=''} {implode('',$listforpending2)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforpending1) && is_array($listforpending1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos Pending at {$arrCondo.csearch_name} ({$listforpending1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 listTable table-border">
                                                    {$smarty.capture.table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforpending1)}*}
                                                    {if $listforpending1 !=''} {implode('',$listforpending1)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                    {else}
                                        {$smarty.capture.no_results}
                                    {/if}
                                </div>
                                <div id="forsold1" role="tabpanel" aria-labelledby="for-sold-tab condo-list" class="tab-pane show" >
                                    {if (isset($listforsold6) && is_array($listforsold6)) || (isset($v) && is_array($listforsold5)) ||
                                    (isset($listforsold4) && is_array($listforsold4)) || (isset($listforsold3) && is_array($listforsold3)) ||
                                    (isset($listforsold2) && is_array($listforsold2)) || (isset($listforsold2) && is_array($listforsold2))}
                                        {if isset($listforsold6) && is_array($listforsold6)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">6 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold6|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsold6)}*}
                                                    {if $listforsold6 !=''} {implode('',$listforsold6)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsold5) && is_array($listforsold5)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">5 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold5|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsold5)}*}
                                                    {if $listforsold5 !=''} {implode('',$listforsold5)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsold4) &&  is_array($listforsold4)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">4 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold4|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsold4)}*}
                                                    {if $listforsold4 !=''} {implode('',$listforsold4)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsold3) && is_array($listforsold3)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">3 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold3|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsold3)}*}
                                                    {if $listforsold3 !=''} {implode('',$listforsold3)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsold2) && is_array($listforsold2)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">2 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold2|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsold2)}*}
                                                    {if $listforsold2 !=''} {implode('',$listforsold2)} {/if}
                                                    </tbody>
                                                </table>
                                            </div>
                                        {/if}
                                        {if isset($listforsold1) && is_array($listforsold1)}
                                            <h4 class="title-font text-left te-market-title txt-heading- text-muted- text-border-bottom py-4">1 Bedroom Condos Sold at {$arrCondo.csearch_name} ({$listforsold1|count})</h4>
                                            <div class="table-responsive pt-4 pb-4">
                                                <table class="table te-table-striped table-hover table-borderless mb-0 soldlistTable table-border">
                                                    {$smarty.capture.sold_table_header}
                                                    <tbody class="border-bottom cus-fwight-bold">
                                                    {*{implode('',$listforsold1)}*}
                                                    {if $listforsold1 !=''} {implode('',$listforsold1)} {/if}
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
        </div>
    </section>
{else}
    <div class="col-12 no-data-msg text-center text-danger pt-3 font-weight-bold">
        The {$csearch_name} condo page is disabled.
    </div>
{/if}