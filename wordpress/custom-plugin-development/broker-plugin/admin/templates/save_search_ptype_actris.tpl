{if isset($sysName) && $sysName != '' && $sysName == 'actris'}

    {if isset($arrMeta['SubTypeActris']) && is_array($arrMeta['SubTypeActris'])}
        {foreach name=ptype from=$arrMeta['SubTypeActris'] key=pkey item=pitem}
            <label><input type="checkbox" name="stype[]" {if $pkey|in_array:$arrSearchCriteria.stype || $pkey == $arrSearchCriteria.stype}checked="checked"{/if} id="{$pkey}" value="{$pkey}" />&nbsp;{$pitem}</label>
        {/foreach}
        <label><input type="checkbox" name="stype[]" {if 'CommercialLease'|in_array:$arrSearchCriteria.stype || 'CommercialLease' == $arrSearchCriteria.stype}checked="checked"{/if} id="CommercialLease" value="CommercialLease" />&nbsp;Commercial Lease</label>
    {/if}

{else}

    {if isset($arrMeta['SubType']) && is_array($arrMeta['SubType'])}
        {foreach name=ptype from=$arrMeta['SubType'] key=pkey item=pitem}
            <label><input type="checkbox" name="stype[]" {if $pkey|in_array:$arrSearchCriteria.stype || $pkey == $arrSearchCriteria.stype}checked="checked"{/if} id="{$pkey}" value="{$pkey}" />&nbsp;{$pitem}</label>
        {/foreach}
        <label><input type="checkbox" name="stype[]" {if 'CommercialLease'|in_array:$arrSearchCriteria.stype || 'CommercialLease' == $arrSearchCriteria.stype}checked="checked"{/if} id="CommercialLease" value="CommercialLease" />&nbsp;Commercial Lease</label>
    {/if}

{/if}