{if isset($SubItemData) && $SubItemData != '' && !isset($Field.SubItemTooltip)}<b>{/if}
{if isset($Field.DataLink) && $fieldValue != ''}
    {if $Field.DataLink == $smarty.const.FORMAT_STR}
        <a rel="" href="{sprintf_byfield format=$Field.FormatString field_list=$Field.UseFields field_data=$R_RecordSet->Record encrypt_data=$Field.EncryptData|default:false}" {if isset($Field.OpenPopup)}class="{$Field.PopupSize|default:'popup-big'}" data-popup="true" data-fancybox-type="iframe"{/if} {$Field.DataAttribute|default:''}>
    {else}
        <a rel="" href="{$Field.DataLink}" {if isset($Field.OpenPopup)}class="big-popup" data-fancybox-type="iframe" data-popup="true"{/if} {$Field.DataAttribute|default:''}>
    {/if}
{/if}
{if isset($Field.ControlHasTemplate)}
    {include file=$Field.ControlHasTemplate Field=$Field fieldName=$fieldName fieldValue=$R_RecordSet->f($fieldName) Record=$R_RecordSet->Record}
{elseif $fieldValue != '' || isset($Field.IsPicture)}
    {if isset($Field.IsPicture)}
        {assign var="fileName" value=$fieldValue}
        {assign var="fileOriginal" value=$fileName}
        {if isset($Field.Pic_Prefix)}
            {assign var="fileName" value=$Field.Pic_Prefix|cat:$fileName}
        {/if}
        {if !$fileName|file_exists:$P_Upload_Root}
            {assign var="fileName" value="small_default.gif"}
        {/if}
        {if isset($jFancyBox2)}
            <a href="{$V_Upload_Root}/{$fileOriginal}" rel="fancybox-button" class="gallery"><img src="{$V_Upload_Root}/{$fileName}" width="{$Field.Disp_Width|default:'50'}"></a>
        {else}
            <img src="{$V_Upload_Root}/{$fileName}" width="{$Field.Disp_Width|default:'50'}">
        {/if}
    {elseif isset($Field.IsPictureUrl)}
        {if isset($jFancyBox2)}
            <a href="{$MDN_Url}{$V_Upload_Root}/{$fieldValue}" class="gallery" rel="fancybox-button"><img src="{$MDN_Url}/{$fieldValue}/100/100/" border="0"></a>
        {else}
            <img src="{$MDN_Url}{$fieldValue}/{$Field.Pic_Small|default:'100/100'}/" border="0" />
        {/if}
    {elseif isset($Field.IsDate)}
        {$fieldValue|date_format:'%d %b %Y'}
    {elseif isset($Field.IsDateTime)}
        {$fieldValue|date_format:'%d %b %Y %I:%M:%S %p '}
    {elseif isset($Field.IsAmount)}
        {$fieldValue|number_format:2}
    {elseif isset($Field.IsId)}
        {if isset($Field.Option) && $fieldValue|array_key_exists:$Field.Option}
            {$fieldValue|array_value:$Field.Option}
        {elseif $fieldValue == 0}
            {assign var="fieldOther" value=$fieldName|cat:'_other'}
            {$R_RecordSet->f($fieldOther)}
        {else}
            {$fieldValue}
        {/if}
    {elseif isset($Field.Option) && isset($Field.IsIdList)}
        {$fieldValue|array_value_list:$Field.Option:($Field.SplitBy|default:',')}
    {elseif isset($Field.Option) && isset($Field.IsLabel)}
        {if $fieldValue|array_value:$Field.Option}
            <label title="{$fieldValue|array_value:$Field.SelText}">{$fieldValue|array_value:$Field.Option}</label>
         {/if}
    {else}
        {if isset($F_Link) && $fieldName|in_array:$F_Link}
            {*{if $smarty.get.cid == 0}
                <a href="?{'qName'|array_value:$F_Link}={'idField'|array_value:$R_RecordSet->f($F_Link)}">{$fieldValue}</a>
            {else}
                {$fieldValue}
            {/if}*}
        {else}
            {if isset($Field.IsConcateField)}
                {$fieldValue} {$Field.IsConcateField|array_value:$Record}
            {else}
                {$fieldValue}
            {/if}
        {/if}
    {/if}
{/if}
{if isset($Field.DataLink) && $fieldValue != ''}
    <i class="fa fa-eye" title="View more" data-toggle="tooltip" data-placement=""></i></a>
{/if}
{if isset($Field.SubItemTooltip) || isset($Field.Tooltip)}&nbsp;<i class="fa fa-info-circle text-primary"></i>&nbsp;{/if}
{if isset($SubItemData) && $SubItemData != '' && !isset($Field.SubItemTooltip)}</b>{/if}