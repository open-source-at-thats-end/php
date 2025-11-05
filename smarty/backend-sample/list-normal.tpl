{if isset($LoadRow) && is_object($R_RecordSet)}
    {assign var="pk_id" value=Ocrypt::enc($R_RecordSet->f($F_PrimaryKey))}
    <tr data-id="{$pk_id}">{*data-id="{$pk_id}"*}
        {if $MassAction == true}
            <td align="center">{if ($FieldDelete=='') || ($R_RecordSet->f($FieldDelete)!=$FieldDeleteVal)}<input type="checkbox" name="pk_list[]" value="{{$pk_id}}">{else}&nbsp;{/if}</td>
        {/if}
        {if isset($CustomListFile)}
            {include file=$CustomListFile RS=$R_RecordSet}
        {else}
            {foreach name=hdInfo from=$F_HeaderItem key=fieldName item=Field}
                {assign var='fieldName' value=$FieldPrefix|cat:$fieldName}
                <td align="{$Field.Align|default:'left'}" valign="top">{include file="layout/list-sub-data.tpl" Field=$Field fieldName=$fieldName}</td>
            {/foreach}
        {/if}
        {if isset($C_CommandList) && $smarty.const.A_SORT|in_array:$C_CommandList && isset($F_Sort)}
            <td align="left" nowrap="nowrap">
                {if $R_RecordSet->Row != 1}
                    <i class="cursor-pointer fa-lg glyphicon glyphicon-arrow-up text-muted-dark courser-pointer move-up-down" title="Move Up" data-move="Up" data-pk="{$pk_id}" data-pid="{if isset($F_ParentField)}{Ocrypt::enc($R_RecordSet->f($F_ParentField))}{/if}"></i>
                {else}
                    <i class="cursor-pointer fa-lg glyphicon glyphicon-arrow-up text-faded courser-not-allowed"></i>
                {/if}

                {if $R_RecordSet->Row != $R_RecordSet->TotalRow}
                    <i class="cursor-pointer fa-lg glyphicon glyphicon-arrow-down text-muted-dark courser-pointer move-up-down" title="Move Down" data-move="Down" data-pk="{$pk_id}" data-pid="{if isset($F_ParentField)}{Ocrypt::enc($R_RecordSet->f($F_ParentField))}{/if}"></i>
                {else}
                    <i class="cursor-pointer fa-lg glyphicon glyphicon-arrow-down text-faded courser-not-allowed"></i>
                {/if}
            </td>
        {/if}
        {if !isset($HideRecordAction) && is_array($C_CommandList) && count($C_CommandList) > 0}
            <td>
                {include file="layout/record-action.tpl"
                pk_id=$pk_id
                active=$R_RecordSet->f($F_IsActive|default:'')
                v_delete=$R_RecordSet->f($F_Virtual_Delete|default:'')
                no_delete_val=$R_RecordSet->f($FieldDelete)
                Record=$R_RecordSet->Record
                }
            </td>
        {/if}
    </tr>
{else}
    {if isset($R_RecordSet->TotalRow) && $R_RecordSet->TotalRow > 0}
        {while $R_RecordSet->next_record()}
            {include file="layout/list-normal.tpl" LoadRow=true}
        {/while}
    {elseif isset($arrR_RecordSet) && is_array($arrR_RecordSet) && count($arrR_RecordSet) > 0}
        {foreach name=arrR_RecordSet from=$arrR_RecordSet[$RecordAccessKey] key=rec_num item=Record}
            {$R_RecordSet->set_record($Record)}
            {include file="layout/list-normal.tpl" LoadRow=true}
        {/foreach}
    {else}
        <tr><td colspan="{$full_colspan|default:15}" align="center"><span class="text-danger"><i class="fa fa-warning"></i>&nbsp;&nbsp; No {$ModuleTitle}{if isset($AddTitle)} - {$AddTitle}{/if} information available.</span></td></tr>
    {/if}
{/if}