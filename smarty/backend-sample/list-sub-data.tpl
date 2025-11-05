{if $R_RecordSet->f($fieldName) != '' && (isset($Field.SubItemTooltip) || isset($Field.Tooltip))}
    <div class="oe-tooltip">
{/if}

{include assign='SubItemData' file="layout/list-sub-item.tpl" Field=$Field}
{assign var=SubItemData value=$SubItemData|trim}

{*if isset($Field.ControlHasTemplate)}
    {include file=$Field.ControlHasTemplate Field=$Field fieldName=$fieldName fieldValue=$R_RecordSet->f($fieldName) Record=$R_RecordSet->Record}
{elseif $R_RecordSet->f($fieldName) != '' || isset($Field.IsPicture)}
    {include file="layout/list-data.tpl" fieldValue=$R_RecordSet->f($fieldName)}
{/if*}
{include file="layout/list-data.tpl" fieldValue=$R_RecordSet->f($fieldName)}

{if $SubItemData != '' || isset($Field.SubItemTooltip) || isset($Field.Tooltip)}
    <div class="oe-subitem {if isset($Field.SubItemTooltip) || isset($Field.Tooltip)}oe-tooltip-data{/if}">
{/if}
{if isset($Field.Tooltip)}{$Field.Tooltip}{/if} {$SubItemData}
{if $SubItemData != '' || isset($Field.SubItemTooltip) || isset($Field.Tooltip)}</div>{/if}

{if $R_RecordSet->f($fieldName) != '' && (isset($Field.SubItemTooltip) || isset($Field.Tooltip))}
    </div>
{/if}
