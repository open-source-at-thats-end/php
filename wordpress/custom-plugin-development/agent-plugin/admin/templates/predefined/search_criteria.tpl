{if is_array($arrSearchResult) && count($arrSearchResult) > 0}
    {if isset($arrSearchResult.mlslist) && !empty($arrSearchResult.mlslist)}
        <strong>#MLS: </strong>{if is_array($arrSearchResult.mlslist)}{', '|implode:$arrSearchResult.mlslist}{else}{$arrSearchResult.mlslist}{/if}<br />
    {/if}
    {if isset($arrSearchResult.add) && !empty($arrSearchResult.add)}
        <strong>Address: </strong>{$arrSearchResult.add}<br />
    {/if}
    {*{if isset($arrSearchResult.ptype)}
        <strong>Property Type: </strong>{if is_array($arrSearchResult.ptype)}{$arrSearchResult.ptype|implode:', '|lower|ucwords}{else}{$arrSearchResult.ptype}{/if}
        <br>
    {/if}*}
    {if isset($arrSearchResult.sdiv)}
        <strong>Subdivision: </strong>{if is_array($arrSearchResult.sdiv)}{', '|implode:$arrSearchResult.sdiv|lower|ucwords}{else}{$arrSearchResult.sdiv}{/if}
        <br>
    {/if}
    {if isset($arrSearchResult.minprice) && $arrSearchResult.minprice > 0 && isset($arrSearchResult.maxprice) && $arrSearchResult.maxprice > 0}
        <strong>Price: </strong>{$arrSearchResult.minprice} - {$arrSearchResult.maxprice}<br />
    {elseif $arrSearchResult.minprice > 0}
        <strong>Price More Than: </strong>{$arrSearchResult.minprice}<br />
    {elseif $arrSearchResult.maxprice > 0}
        <strong>Price Less Than: </strong>{$arrSearchResult.maxprice}<br />
    {/if}
    {if isset($arrSearchResult.beds) && $arrSearchResult.beds > 0 }
        <strong>Bedrooms: </strong>{$arrSearchResult.beds}<br />
    {/if}
    {if isset($arrSearchResult.minbed) && $arrSearchResult.minbed > 0}
        <strong>Bedrooms: </strong>{$arrSearchResult.minbed}<br />
    {/if}
    {if isset($arrSearchResult.baths) && $arrSearchResult.baths > 0}
        <strong>Bathroom: </strong>{$arrSearchResult.baths}<br />
    {/if}
    {if isset($arrSearchResult.minbath) && $arrSearchResult.minbath > 0}
        <strong>Bathroom: </strong>{$arrSearchResult.minbath}<br />
    {/if}
    {if isset($arrSearchResult.minsqft) && isset($arrSearchResult.maxsqft) && $arrSearchResult.minsqft > 0 && $arrSearchResult.maxsqft > 0}
        <strong>Square Feet Range: </strong>{$arrSearchResult.minsqft} - {$arrSearchResult.maxsqft}<br />
    {elseif $arrSearchResult.minsqft > 0}
        <strong>Square Feet Greater Than: </strong>{$arrSearchResult.minsqft}<br />
    {elseif $arrSearchResult.maxsqft > 0}
        <strong>Square Feet Less Than: </strong>{$arrSearchResult.maxsqft}<br />
    {/if}
    {if isset($arrSearchResult.mingarage) && isset($arrSearchResult.maxgarage) && $arrSearchResult.mingarage > 0 && $arrSearchResult.maxgarage > 0}
        <strong>Garage Range: </strong>{$arrSearchResult.mingarage} - {$arrSearchResult.maxgarage}<br />
    {elseif isset($arrSearchResult.mingarage) && $arrSearchResult.mingarage > 0}
        <strong>Garage Greater Than: </strong>{$arrSearchResult.mingarage}<br />
    {elseif isset($arrSearchResult.maxgarage) && $arrSearchResult.maxgarage > 0}
        <strong>Garage Less Than: </strong>{$arrSearchResult.maxgarage}<br />
    {/if}
     {if isset($arrSearchResult.minyear) && isset($arrSearchResult.maxyear) && $arrSearchResult.minyear > 0 && $arrSearchResult.maxyear > 0}
         <strong>Year Built Range: </strong>{$arrSearchResult.minyear} - {$arrSearchResult.maxyear}<br />
     {elseif $arrSearchResult.minyear > 0}
         <strong>Year Built After: </strong>{$arrSearchResult.minyear}<br />
     {elseif $arrSearchResult.maxyear > 0}
         <strong>Year Built Before: </strong>{$arrSearchResult.maxyear}<br />
     {/if}
    {if isset($arrSearchResult.minlotsize) && isset($arrSearchResult.maxlotsize) && $arrSearchResult.minlotsize > 0 && $arrSearchResult.maxlotsize > 0}
        <strong>Lotsize Range: </strong>{$arrSearchResult.minlotsize} - {$arrSearchResult.maxlotsize}<br />
    {elseif isset($arrSearchResult.minlotsize) && $arrSearchResult.minlotsize > 0}
        <strong>Lotsize Greater Than: </strong>{$arrSearchResult.minlotsize}<br />
    {elseif isset($arrSearchResult.maxlotsize) && $arrSearchResult.maxlotsize > 0}
        <strong>Lotsize Less Than: </strong>{$arrSearchResult.maxlotsize}<br />
    {/if}
    {if isset($arrSearchResult.dom) && !empty($arrSearchResult.dom)}
        <strong>Days on Market: </strong>{$arrSearchResult.dom}<br />
    {/if}
    {if isset($arrSearchResult.city)}
        <strong>City: </strong>{if is_array($arrSearchResult.city)}{', '|implode:$arrSearchResult.city}{else}{$arrSearchResult.city}{/if}<br />
    {/if}
    {if isset($arrSearchResult.stype)}
        <strong>Property Type: </strong>{if is_array($arrSearchResult.stype)}{str_replace('|',', ',', '|implode:$arrSearchResult.stype)}{else}{str_replace('|',', ',$arrSearchResult.stype)}{/if}<br />
    {/if}
    {if isset($arrSearchResult.pstyle)}
        <strong>Property Style: </strong>{if is_array($arrSearchResult.pstyle)}{', '|implode:$arrSearchResult.pstyle}{else}{$arrSearchResult.pstyle}{/if}<br />
    {/if}
    {if isset($arrSearchResult.zipcode) && !empty($arrSearchResult.zipcode)}
        <strong>ZipCode: </strong>{$arrSearchResult.zipcode}<br />
    {/if}
    {if isset($arrSearchResult.ziplist) && !empty($arrSearchResult.ziplist)}
        <strong>ZipCode: </strong>{$arrSearchResult.ziplist}<br />
    {/if}
    {if isset($arrSearchResult.area)}
        <strong>Area: </strong>{if is_array($arrSearchResult.area)}{', '|implode:$arrSearchResult.area}{else}{$arrSearchResult.area}{/if}<br />
    {/if}
    {if isset($arrSearchResult.elemschl)}
        <strong>Elementary school: </strong>{if is_array($arrSearchResult.elemschl)}{', '|implode:$arrSearchResult.elemschl}{else}{$arrSearchResult.elemschl}{/if}<br />
    {/if}
    {if isset($arrSearchResult.midschl)}
        <strong>Middle school: </strong>{if is_array($arrSearchResult.midschl)}{', '|implode:$arrSearchResult.midschl}{else}{$arrSearchResult.midschl}{/if}<br />
    {/if}
    {if isset($arrSearchResult.highschl)}
        <strong>High school: </strong>{if is_array($arrSearchResult.highschl)}{', '|implode:$arrSearchResult.highschl}{else}{$arrSearchResult.highschl}{/if}<br />
    {/if}
    {if isset($arrSearchResult.office) && !empty($arrSearchResult.office)}
        <strong>Office ID: </strong>{if is_array($arrSearchResult.office)}{', '|implode:$arrSearchResult.office}{else}{$arrSearchResult.office}{/if}<br />
    {/if}
    {if isset($arrSearchResult.agent) && !empty($arrSearchResult.agent)}
        <strong>Agent ID: </strong>{if is_array($arrSearchResult.agent)}{', '|implode:$arrSearchResult.agent}{else}{$arrSearchResult.agent}{/if}<br />
    {/if}
    {if isset($arrSearchResult.kword) && !empty($arrSearchResult.kword)}
        <strong>Additional: </strong> {$arrSearchResult.kword}
    {/if}
    {*{if isset($arrSearchResult.horse_amenities) && !empty($arrSearchResult.horse_amenities)}
        <strong>Horse Amenities: </strong> {$arrSearchResult.horse_amenities}<br />
    {/if}*}
    {if isset($arrSearchResult.horse_yn) && !empty($arrSearchResult.horse_yn)}
        <strong>Horse Amenities: </strong> {$arrSearchResult.horse_yn}<br />
    {/if}
    {if isset($arrSearchResult.waterfrontdesc)}
        <strong>Waterfront Description: </strong>{if is_array($arrSearchResult.waterfrontdesc)}{str_replace('|',', ',', '|implode:$arrSearchResult.waterfrontdesc)}{else}{str_replace('|',', ',$arrSearchResult.waterfrontdesc)}{/if}<br />
    {/if}
    {if isset($arrSearchResult.security_safety) && !empty($arrSearchResult.security_safety)}
        <strong>Security: </strong> {$arrSearchResult.security_safety} <br />
    {/if}
    {if isset($arrSearchResult.waterfront) && !empty($arrSearchResult.waterfront)}
        <strong>Waterfront : </strong> {$arrSearchResult.waterfront}<br />
    {/if}
    {if isset($arrSearchResult.membership_required) && !empty($arrSearchResult.membership_required)}
        <strong>Membership Required: </strong> {$arrSearchResult.membership_required} <br />
    {/if}
    {if isset($arrSearchResult.sys_name) && !empty($arrSearchResult.sys_name)}
        <strong>System Name: </strong> {$arrSearchResult.sys_name} <br />
    {/if}

    {if isset($arrSearchResult.petsallowed) && !empty($arrSearchResult.petsallowed)}
        <strong>Pets Allowed: </strong> {$arrSearchResult.petsallowed} <br />
    {/if}

    {if isset($arrSearchResult.membership_fee) && !empty($arrSearchResult.membership_fee)}
        <strong>Membership Fee: </strong>{$arrSearchResult.membership_fee}<br />
    {/if}
    {if isset($arrSearchResult.Agent_Id) && !empty($arrSearchResult.Agent_Id)}
        <strong>Agent profile Id: </strong>{$arrSearchResult.Agent_Id}<br />
    {/if}
{/if}