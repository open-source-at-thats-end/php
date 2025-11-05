{if isset($Field.SubItem)}
    {foreach name=ShowChiledList from=$Field.SubItem key=SubItemField item=SubItemInfo}
        {assign var='SubItemField' value=$FieldPrefix|cat:$SubItemField}
        {if $R_RecordSet->f($SubItemField)}
            <div>
                {if isset($SubItemInfo.Title)}<small><b>{$SubItemInfo.Title} :</b> </small>{/if}
                {if isset($SubItemInfo.SubItem)}
                    {include file="layout/list-sub-data.tpl" Field=$SubItemInfo fieldName=$SubItemField}
                {else}
                    {if isset($SubItemInfo.ControlHasTemplate)}
                        {include file=$SubItemInfo.ControlHasTemplate Field=$SubItemInfo fieldName=$SubItemField fieldValue=$R_RecordSet->f($SubItemField) Record=$R_RecordSet->Record}
                    {else}
                        {include file="layout/list-data.tpl" Field=$SubItemInfo fieldName=$SubItemField fieldValue=$R_RecordSet->f($SubItemField)}
                    {/if}
                {/if}
            </div>
        {/if}
    {/foreach}
{/if}