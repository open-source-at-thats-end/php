<div class="main">
    <table class="table table-bordered  table-condensed table-hover  table-striped">
        <tbody id="the-list">
{foreach name=listingInfo from=$arrRecordSet.rs key=key item=row}
    <tr class="{cycle values='alt,'}">
        <td width="10%">{$row.MLS_NUM}</td>
        <td width="10%">
            <a href="JavaScript: void(0);" class="vlink_view" data-link="{$basePageUrl}&action=view&mls_no={$row.ListingID_MLS}" data-title="MLS# {$row.MLS_NUM}">
                {if $row.mls_is_pic_url_supported == 'Yes'}
                    {assign var=photo_url value=$row.MainPicture.large.url}
                    {if $photo_url != ''}
                        <img src="{$photo_url}" alt="{if $imgAlt}{$imgAlt}{else}MLS# {$row.MLS_NUM}{/if}" width="75" height=""/>
                    {else}
                        <img src="{$PhotoBaseUrl}no-photo/0/75/" alt="{if $imgAlt}{$imgAlt}{else}MLS# {$row.MLS_NUM}{/if}"/>
                    {/if}
                {else}
                    {*<img src="{$row.MainPicture}/75/" alt="{if $imgAlt}{$imgAlt}{else}MLS# {$row.MLS_NUM}{/if}"/>*}
                    <img src="{$row.MainPicture}" alt="{if $imgAlt}{$imgAlt}{else}MLS# {$row.MLS_NUM}{/if}"/>
                {/if}
            </a>
        </td>
        <td width="10%">{if $row.ListPrice > 0}${$row.ListPrice|number_format:0}{/if}</td>
        <td width="20%"><a href="JavaScript: void(0);" class="vlink_view" data-link="{$basePageUrl}&action=view&mls_no={$row.ListingID_MLS}" data-title="MLS# {$row.MLS_NUM}">{$objUtility->formatListingAddress($arrListingConfig.AddressFull, $row)}</a></td>


        <td width="10%">{$row.SubType}</td>
        <td width="10%">
            Beds: {$row.Beds}<br />
            Baths: {$row.Baths|number_format:0}<br />
            {*                    Baths: {$row.BathsFull}Full {if $row.BathsHalf}{$row.BathsHalf}Half{/if}<br />*}
            Sqft: {$row.SQFT|number_format:0}<br />
        </td>
        {*{if isset($SystemName) && $SystemName == {Constants::ACTRIS}}
            <td width="10%">{Constants::MLS_ACTRIS}</td>
        {else}*}
            <td width="10%">{$arrSystemName[$row.SystemName]|default:''}</td>
       {* {/if}*}
    </tr>
    {foreachelse}
    <tr class="alt"><td colspan="7">No listings.</td></tr>
{/foreach}
        </tbody>
    </table>
</div>
