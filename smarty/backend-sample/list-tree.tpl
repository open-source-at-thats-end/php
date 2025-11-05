{assign var="i" value=0}
{foreach name=recordInfo from=$node item=Record}
{assign var="i" value=$i+1}
    {assign var="pk_id" value=Ocrypt::enc($Record.$F_PrimaryKey)}
    <tr data-id="{$pk_id}">
        {if $MassAction == true}
            <td align="center">
                {if ($FieldDelete=='') || ($Record.$FieldDelete!=$FieldDeleteVal)}
                    <input type="checkbox" name="pk_list[]" value="{{$pk_id}}">
                {else}
                    &nbsp;
                {/if}
            </td>
        {/if}
        {foreach name=hdInfo from=$F_HeaderItem key=fieldName item=Field}
            {assign var='fieldName' value=$FieldPrefix|cat:$fieldName}
            <td align="{$Field.Align|default:'left'}" valign="top">
                {if $smarty.foreach.hdInfo.index == 0 && $level != 0}
                    {math equation="x * y" x=$level y=5 assign=spa}
                    {'&nbsp;'|str_repeat:$spa}&brvbar;--
                {/if}
                {$R_RecordSet->set_record($Record)}
                {include file="layout/list-sub-data.tpl" Field=$Field fieldName=$fieldName}
            </td>
        {/foreach}
        {if $smarty.const.A_SORT|in_array:$C_CommandList && isset($F_Sort)}
            <td align="left" nowrap="nowrap">
                {if $level != 0}
                    {math equation="x * y" x=$level y=5 assign=spa}
                    {'&nbsp;'|str_repeat:$spa}&brvbar;--{*'--'|str_repeat:$level*}
                {/if}

                {if !$smarty.foreach.recordInfo.first}
                    <i class="fa-lg glyphicon glyphicon-arrow-up text-muted-dark courser-pointer move-up-down" title="Move Up" data-move="Up" data-pk="{$pk_id}" data-pid="{if isset($F_ParentField)}{Ocrypt::enc($Record.$F_ParentField)}{/if}"></i>
                {else}
                    <i class="fa-lg glyphicon glyphicon-arrow-up text-faded courser-not-allowed"></i>
                {/if}

                {if $i != $count}
                    <i class="fa-lg glyphicon glyphicon-arrow-down text-muted-dark courser-pointer move-up-down" title="Move Down" data-move="Down" data-pk="{$pk_id}" data-pid="{if isset($F_ParentField)}{Ocrypt::enc($Record.$F_ParentField)}{/if}"></i>
                {else}
                    <i class="fa-lg glyphicon glyphicon-arrow-down text-faded courser-not-allowed"></i>
                {/if}
            </td>
        {/if}
        {if !isset($HideRecordAction)}
            <td>
                {include file="layout/record-action.tpl"
                    pk_id=$pk_id
                    active=$Record.$F_IsActive|default:''
                    no_delete_val=$Record.$FieldDelete|default:''
                    Record=$Record
                }
            </td>
        {/if}
    </tr>
    {if isset($Record.child)}
        {assign var="entry" value=$i}
        {include file='layout/list-tree.tpl' node='child'|array_value:$Record level=$level+1 entry=$i count='count'|array_value:$Record}
        {assign var="i" value=$entry}
    {/if}
{foreachelse}
    <tr><td colspan="{$full_colspan}" align="center"><span class="text-danger"><i class="fa fa-warning"></i>&nbsp;&nbsp; No {$ModuleTitle}{if isset($AddTitle)} - {$AddTitle}{/if} information available.</span></td></tr>
{/foreach}