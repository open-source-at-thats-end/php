{if !isset($SidebarLeftForm)}
    {if !isset($MegaForm) && !isset($WithoutForm)}<form name="standard-form" id="standard-form" class="form-horizontal standard-form " data-form-for="{$Action}" method="post" role="form" data-toggle="standardform" autocomplete="off" enctype="multipart/form-data">{/if}
    {if !isset($WithoutForm)}
    <div class="row">
        <div class="col-lg-12 text-right">
            {if (isset($F_FieldInfo) && count($F_FieldInfo) > 0) || (isset($RequiredFieldNotice) && $RequiredFieldNotice == true)}
                <span class="text-danger"><i class="fa fa-eye"></i> Fields marked with (*) are mandatory.</span>
            {/if}
        </div>
    </div>
    {/if}
    {if isset($FormWizard)}{include file="layout/html-form-wizard.tpl"}{/if}
{/if}
{assign var="ControlTabIndex" value=$StartTabIndex|default:1 scope="global"}
{if isset($ExtraFormFileBefore) && $ExtraFormFileBefore != false}
    {include file=$ExtraFormFileBefore}
{/if}
{if isset($F_FieldInfo)}
    {foreach name=fieldInfo from=$F_FieldInfo key=fieldName item=Field}
        {if isset($Field.GroupTitle) && $Field.GroupTitle != ''}
            {if isset($group) && $group != ''}
                    </div>{*widget body close*}
                </div>{*widget close*}
                {if isset($IncludeCustomForm)}{include file=$IncludeCustomForm}{/if}
            {/if}
            {assign var=group value=$Field.GroupTitle}
            {assign var="fldCount" value=0}
            {assign var="LayoutCols" value=$Field.LayoutCols|default:2}
            {assign var="ColumnSpan" value=$Field.ColumnSpan|default:false}

            <div class="widget {$Field.GroupClass|default:''} {if isset($SidebarLeftForm)}border-none{/if}" id="{$Field.GroupId|default:''}">{*widget start*}
                <div class="widget-head bg-primary-light">{*widget title start*}
                    <h4 class="heading"><i class="fa {if $Action == $smarty.const.A_ADD}fa-plus-circle{else}fa-edit{/if}"></i> {$Field.GroupTitle}</h4>{*widget title*}
                </div>{*widget title end*}
                <div class="widget-body {if isset($SidebarLeftForm)}padding-none{/if}">{*widget body start*}
        {else}
            {if isset($fldCount) && isset($LayoutCols) && $fldCount%$LayoutCols == 0}
                <div class="row">{*row start*}
            {/if}
            {assign var="fldCount" value=$fldCount+2}
            {if isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_HIDDEN}
                <div class="{if (isset($Field.ColumnSpan)) || (isset($ColumnSpan) && $ColumnSpan === true)}col-lg-12{assign var="fldCount" value=$fldCount+2}{else}col-lg-6{/if}"><input type="hidden" id="{$fieldName}" name="{$fieldName}" value="{$Field.SelValue|default:$Field.DefaultValue|default:''}"></div>
            {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_BSPACE}
                <div class="{if (isset($Field.ColumnSpan)) || (isset($ColumnSpan) && $ColumnSpan === true)}col-lg-12{assign var="fldCount" value=$fldCount+2}{else}col-lg-6{/if}">&nbsp;</div>
            {else}
                {if isset($NoTabIndex) && $NoTabIndex == true}
                    {assign var="ControlTabIndex" value=0 scope="global"}
                {elseif isset($Field.ControlTabIndex) && $Field.ControlTabIndex != ''}
                    {assign var="ControlTabIndex" value=$Field.ControlTabIndex scope="global"}
                {else}
                    {assign var="ControlTabIndex" value=$ControlTabIndex+1 scope="global"}
                {/if}
                {assign var=classes value='form-control '}
                {assign var=attributes value=$Field.ControlAttribute|default:''}{*form="standard-form"*}
                {if isset($Field.Validate)}
                    {* Check for empty field *}
                    {if $Field.ValidationType&$smarty.const.V_EMPTY}
                        {assign var=classes value=$classes|cat:" required"}
                    {/if}
                    {* Check for empty file *}
                    {if $Field.ValidationType&$smarty.const.V_EMPTYFILE}
                        {if !isset($Field.SelValue)}
                            {assign var=classes value=$classes|cat:" required"}
                        {/if}
                    {/if}
                    {* Check  for maximum length *}
                    {if $Field.ValidationType&$smarty.const.V_MAXLEN}
                        {assign var=classes value=$classes|cat:" maxlength"}
                        {assign var=attributes value=$attributes|cat:'maxlength="'|cat:$Field.ValidationMaxLength|cat:'"'}
                    {/if}
                    {* Check  for maximum value *}
                    {if $Field.ValidationType&$smarty.const.V_MAX}
                        {assign var=classes value=$classes|cat:" max"}
                        {assign var=attributes value=$attributes|cat:'max="'|cat:$Field.ValidationMaxValue|cat:'"'}
                    {/if}
                    {* Check  for minimum length *}
                    {if $Field.ValidationType&$smarty.const.V_MINLEN}
                        {assign var=classes value=$classes|cat:" minlength"}
                        {assign var=attributes value=$attributes|cat:'minlength="'|cat:$Field.ValidationMinLength|cat:'"'}
                    {/if}
                    {* Check  for minimum value *}
                    {if $Field.ValidationType&$smarty.const.V_MIN}
                        {assign var=classes value=$classes|cat:" min"}
                        {assign var=attributes value=$attributes|cat:'min="'|cat:$Field.ValidationMinValue|cat:'"'}
                    {/if}
                    {* Check  for minimum require number of fields *}
                    {if $Field.ValidationType&$smarty.const.V_REQUIRE_GROUP}
                        {assign var=classes value=$classes|cat:" require-group"}
                        {assign var=attributes value=$attributes|cat:'data-req-min-field="'|cat:$Field.ValidationMinReqField|cat:'"'}
                    {/if}
                    {* Check  for length range given *}
                    {if $Field.ValidationType&$smarty.const.V_CHAR_RANGE}
                        {assign var=classes value=$classes|cat:" rangeChars"}
                        {assign var=attributes value=$attributes|cat:'rangeChars="'|cat:$Field.ValidationCharRange|cat:'"'}
                    {/if}
                    {* Check  for input range given *}
                    {if $Field.ValidationType&$smarty.const.V_VALUE_RANGE}
                        {assign var=classes value=$classes|cat:" rangeValue"}
                        {assign var=attributes value=$attributes|cat:'rangeValue="'|cat:$Field.ValidationValueRange|cat:'"'}
                    {/if}
                    {* Check for valid email *}
                    {if $Field.ValidationType&$smarty.const.V_EMAIL}
                        {assign var=classes value=$classes|cat:" email"}
                    {/if}
                    {* Check for valid url *}
                    {if $Field.ValidationType&$smarty.const.V_URL}
                        {assign var=classes value=$classes|cat:" url"}
                    {/if}
                    {* Check for valid seo based url *}
                    {if $Field.ValidationType&$smarty.const.V_URL_FRIENDLY}
                        {assign var=classes value=$classes|cat:" seo_friendly_url"}
                    {/if}
                    {* Check for valid alphanumeric *}
                    {if $Field.ValidationType&$smarty.const.V_ALPHANUMERIC}
                        {assign var=classes value=$classes|cat:" alphanumeric"}
                    {/if}
                    {* Check for no white space *}
                    {if $Field.ValidationType&$smarty.const.V_NO_SPACE}
                        {assign var=classes value=$classes|cat:" nowhitespace"}
                    {/if}
                    {* Check for valid integer *}
                    {if $Field.ValidationType&$smarty.const.V_INT}
                        {assign var=classes value=$classes|cat:" digits"}
                    {/if}
                    {* Check for valid Number [float] *}
                    {if $Field.ValidationType&$smarty.const.V_FLOAT}
                        {assign var=classes value=$classes|cat:" number"}
                    {/if}
                    {* Check for valid IP version 4*}
                    {if $Field.ValidationType&$smarty.const.V_IP4}
                        {assign var=classes value=$classes|cat:" ipv4"}
                    {/if}
                    {* Check for valid IP version 6*}
                    {if $Field.ValidationType&$smarty.const.V_IP6}
                        {assign var=classes value=$classes|cat:" ipv6"}
                    {/if}
                    {* Check for valid string *}
                    {if $Field.ValidationType&$smarty.const.V_STR}
                        {assign var=classes value=$classes|cat:" alphanumericwithbasicpunc"}
                    {/if}
                    {* Check for valid extension *}
                    {if $Field.ValidationType&$smarty.const.V_EXTENTION}
                        {assign var=classes value=$classes|cat:" extension"}
                        {* Extension type given? by default it validate for png, jpeg, gif files *}
                        {if isset($Field.ValidationExtention)}
                            {assign var=attributes value=$attributes|cat:'extension="'|cat:$Field.ValidationExtention|cat:'"'}
                        {/if}
                    {/if}
                    {* Check for matching values of two input elements *}
                    {if $Field.ValidationType&$smarty.const.V_EQUALTO && $Field.ValidationEqualTo != ''}
                        {assign var=classes value=$classes|cat:" equalTo"}
                        {assign var=attributes value=$attributes|cat:'equalTo="#'|cat:$Field.ValidationEqualTo|cat:'"'}
                    {/if}
                    {* Check for atleast one checkbox selection , need to remove code, because we can do same validation using 'minlength' class *}
                    {*if $Field.ValidationType&$smarty.const.V_CHECKED}
                        {assign var=classes value=$classes|cat:" atleastOne"}
                    {/if*}
                {/if}
                <label {*for="$fieldName"*} class="{$Field.ControlGroupClass|default:''} col-xs-12 {if isset($SidebarLeftForm)}col-lg-12 text-left{else}col-lg-2{/if} control-label">{if isset($Field.Validate) && isset($Field.ValidationType) && ($Field.ValidationType&$smarty.const.V_EMPTY || $Field.ValidationType&$smarty.const.V_EMPTYFILE || $Field.ValidationType&$smarty.const.V_CHECKED)}<span class="text-danger">*</span> {/if}{$Field.Title|default:''}</label>
                <div class="{$Field.ControlGroupClass|default:''} form-group col-xs-12 {if isset($SidebarLeftForm)}col-lg-12{if (isset($Field.ColumnSpan)) || (isset($ColumnSpan) && $ColumnSpan === true)}{assign var="fldCount" value=$fldCount+2}{/if}{else}{if (isset($Field.ColumnSpan)) || (isset($ColumnSpan) && $ColumnSpan === true)}col-lg-10{assign var="fldCount" value=$fldCount+2}{else}col-lg-4{/if}{/if}">
                    {if isset($Field.ControlSize)}<div class="col-lg-{$Field.ControlSize} padding-none">{/if}
                    {if isset($Field.GroupAddon) || isset($Field.FirstAddon) || isset($Field.LastAddon)}<div class="input-group">{/if}
                    {if isset($Field.FirstAddon) && $Field.FirstAddon != ''}<span class="input-group-addon">{if isset($Field.FirstAddonIsText)}{$Field.FirstAddon}{else}<i class="{$Field.FirstAddon}"></i>{/if}</span>{/if}

                        {if isset($Field.ControlHasTemplate)}
                            {include file=$Field.ControlHasTemplate}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_AUTO_SUGGESTION}
                            <select data-auto-suggestion="{$fieldName}" name="{$fieldName}" id="{$fieldName}" class="auto-suggestion {$Field.ControlClass|default:''} {$classes}" {$attributes} placeholder="{$Field.Placeholder|default:('Select '|cat:$Field.Title)}" tabindex="{$ControlTabIndex}">
                                {if isset($Field.AutoSuggestionTemplate)}{include file=$Field.AutoSuggestionTemplate}{/if}
                            </select>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_MULTI_AUTO_SUGGESTION}
                            <select multiple="multiple" data-multi-auto-suggestion="{$fieldName}" name="{$fieldName}[]" id="{$fieldName}" class="multi-auto-suggestion {$Field.ControlClass|default:''} {$classes}" {$attributes} placeholder="{$Field.Placeholder|default:('Select '|cat:$Field.Title)}" tabindex="{$ControlTabIndex}">
                                {if isset($Field.MultiAutoSuggestionTemplate)}{include file=$Field.MultiAutoSuggestionTemplate}{/if}
                            </select>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.CNT_READONLY}
                            <p class="form-control-static">
                                {if isset($Field.SelText)}
                                    {$Field.SelText}
                                {elseif isset($Field.Option) && isset($Field.SelValue)}
                                    {$opt_val = array_flip(explode(',',$Field.SelValue))}
                                    {$sel = array_intersect_key($Field.Option, $opt_val)}
                                    <span class="badge badge-stroke">{implode('</span> <span class="badge badge-stroke">',$sel)}</span>
                                {else}
                                    {$Field.SelValue|default:''}
                                {/if}
                            </p>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_LABEL}
                            <p class="form-control-static">{$Field.SelText|default:''}</p>
                            <input type="hidden" id="{$fieldName}" name="{$fieldName}"  value="{$Field.SelValue|default:$Field.DefaultValue|default:''}">
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_TEXT}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" maxlength="{$Field.ControlMaxLen|default:''}" value="{$Field.SelValue|default:$Field.DefaultValue|default:''}" class="{$Field.ControlClass|default:''} {$classes} text-{$Field.ControlAlign|default:'left'}" placeholder="{$Field.Placeholder|default:''}" {$attributes} rel="{$Field.ControlRel|default:''}" {if isset($Field.ControlDisabled)}disabled="disabled"{/if}>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_PASSWORD}
                            <input type="password" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" class="{$Field.ControlClass|default:''} {$classes}" {$attributes}>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_RICHTEXT}
                            {if isset($Field.ControlReadOnly)}
								{$Field.SelValue|default:''}
							{else}
								{*{html_richtext toolbar=$Field.ControlToolbar|default:'full' width=$Field.ControlWidth|default:'99%' height=$Field.ControlHeight|default:500 RichTextName=$fieldName RichTextValue=$Field.SelValue|default:$Field.DefaultValue|default:'' strip_absolute_urls=$Field.StripAbsoluteUrls|default:'' stylesheet=$Field.StyleSheet|default:'' tabindex="{$ControlTabIndex}"}*}
								<textarea id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" class="{$fieldName} {$Field.ControlClass|default:''} {$classes}" placeholder="{$Field.Placeholder|default:''}" {$attributes} data-cke="true" data-cke-toolbar="{$Field.ControlToolbar|default:'full'}" data-cke-width="{$Field.ControlWidth|default:'99%'}" data-cke-height="{$Field.ControlHeight|default:200}" data-cke-stylesheet="{$Field.StyleSheet|default:''}">{$Field.SelValue|default:''}</textarea>
							{/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_TEXTAREA}
                            <textarea id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" rows="{$Field.ControlRows|default:4}" cols="{$Field.ControlCols|default:48}" maxlength="{$Field.ControlMaxLen|default:''}" class="{$Field.ControlClass|default:''} {$classes} {if isset($Field.NoResize)}no-resize{/if} character-count" placeholder="{$Field.Placeholder|default:''}" {$attributes}>{$Field.SelValue|default:''}</textarea>
                            <div class="text-right"><strong data-counter-for="{$fieldName}">0</strong> Character(s)</div>
                            {if isset($Field.ClickLink) && $Field.ClickLink!=''}{$Field.ClickLink}{/if}
                            {*Is Keyword Suggestion enabled?*}
                            {if isset($Field.KeywordSuggestion) && is_array($Field.KeywordSuggestion)}
                                <br />
                                <b>Keyword Suggestion :</b>
                                {*<img src="{$TPL_images}/yahoo.png" />
                                <a href="JavaScript:void(0);" onclick="JavaScript: Keyword_Suggestion(Array('{"','"|implode:$Field.KeywordSuggestion.KeywordBase}'), '{$fieldName}_keyword_list', '{$fieldName}', 'Yahoo')">Yahoo! Web Service</a>
                                <i class="fa fa-question-circle" data-toggle="tooltip" title="Provide most relative keyword base on content and existing keywords"></i>
                                |*}
                                <a class="text-primary" href="javascript:void(0);" onclick="javascript: Keyword_Suggestion(Array('{"','"|implode:$Field.KeywordSuggestion.KeywordBase}'), '{$fieldName}_keyword_list', '{$fieldName}', 'Keyword')">Keyword Library</a>
                                <i class="fa fa-question-circle" data-toggle="tooltip" title="Provide basic words list from your key word library"></i>
                                <br clear="all" />
                                <div id="{$fieldName}_keyword_list" class="KeywordSuggestion"></div>
                            {/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_CHECKBOX}
                            {if isset($Field.Option) && $Field.Option != ''}
                                {if isset($Field.IsChkUnchkTool)}
                                    <div class="text-right">
                                        <a href="JavaScript: CheckUncheck_Click(document.getElementsByName('{$fieldName}[]'), true);" class=""><i class="fa fa-check-square-o"></i> Check All</a>&nbsp;/&nbsp;
                                        <a href="JavaScript: CheckUncheck_Click(document.getElementsByName('{$fieldName}[]'), false);" class=""><i class="fa fa-square-o"></i> Uncheck All</a>
                                    </div>
                                {/if}
                                <div class="{$Field.addMainClass|default:''}">
                                    {if isset($Field.Option) && '1'|is_multiarray:$Field.Option}
                                        {foreach name=optionInfo from=$Field.Option key=groupName item=groupItem}
                                            <div id="{$fieldName}_{$groupName}" class="multi-options {$Field.addClass|default:''}">
                                                <h5 class="title">{$groupName|lower|ucwords}</h5>
                                                {html_checkboxes name=$fieldName options=$groupItem separator='' cols=$Field.ControlCols|default:'' selected=","|explode:$Field.SelValue|default:$Field.DefaultValue|default:'' table=false labels=true}
                                                <br class="clear"/>
                                            </div>
                                        {/foreach}
                                    {else}
                                        {if isset($Field.ControlCols)}
                                            {html_checkboxes name=$fieldName options=$Field.Option|default:'' separator='' cols=$Field.ControlCols|default:'' selected=","|explode:$Field.SelValue|default:$Field.DefaultValue|default:'' labels=true tabindex=$ControlTabIndex class=$classes}
                                        {else}
                                            {html_checkboxes name=$fieldName options=$Field.Option|default:'' separator='<br>' selected=","|explode:$Field.SelValue|default:$Field.DefaultValue|default:'' labels=true class=$classes}
                                        {/if}
                                    {/if}
                                </div>
                            {else}
                                <input type="checkbox" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" value="{$Field.KeyValue|default:$Field.DefaultValue|default:''}" {if isset($Field.KeyValue) && isset($Field.SelValue) && $Field.KeyValue==$Field.SelValue && $Field.SelValue != ''}checked="checked"{/if}>
                            {/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_RADIO}
                            {if isset($Field.Option) && $Field.Option != ''}
                                {if isset($Field.ControlExtra)}
                                    {html_radios name=$fieldName options=$Field.Option separator=$Field.Separator|default:'&nbsp;' checked=$Field.SelValue|default:$Field.DefaultValue|default:'' extra='onClick=JavaScript:'|cat:$Field.ControlExtra|default:'' class=$classes}
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){ldelim}{$Field.ControlExtra}{rdelim});
                                    </script>
                                {else}
                                    {html_radios name=$fieldName options=$Field.Option separator=$Field.Separator|default:'&nbsp;' checked=$Field.SelValue|default:$Field.DefaultValue|default:'' class=$classes}
                                {/if}
                            {else}
                                <input type="radio" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" value="{$Field.KeyValue|default:''}" {if isset($Field.KeyValue) && isset($Field.SelValue) && $field.keyvalue==$Field.SelValue}checked="checked"{/if}>
                            {/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_CHOICE}
                            {html_radio_button_group name=$fieldName option=$Field.Option selected=$Field.SelValue|default:$Field.DefaultValue|default:'' class=$classes tabindex=$ControlTabIndex}
                            {assign var="ControlTabIndex" value=(($ControlTabIndex-1)+count($Field.Option)) scope="global"}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_DATE_TIME}
                            {html_select_time prefix=$fieldName display_hours=true display_minutes=true display_seconds=false use_24_hours=false minute_interval=5 time=$Field.SelValue|default:$Field.DefaultValue|date_format:"%H:%M"|default:''}
                        {elseif isset($Field.ControlType) && ($Field.ControlType == $smarty.const.C_DATE_PICKER || $Field.ControlType == $smarty.const.C_DATE_RANGE)}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" maxlength="{$Field.ControlMaxLen|default:''}" value="{$Field.SelValue|default:$Field.DefaultValue|date_format:'%d %h %Y'|default:''}" data-date-startdate="{$Field.MinDate|default:''}" data-date-enddate="{$Field.MaxDate|default:''}" class="{$Field.ControlClass|default:''} date {if $Field.ControlType == $smarty.const.C_DATE_PICKER}date-picker{/if} {$classes} text-{$Field.ControlAlign|default:'left'}" {$attributes}>
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-calendar"></i></span>{/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_DATE_TIME_PICKER}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" maxlength="{$Field.ControlMaxLen|default:''}" value="{$Field.SelValue|default:$Field.DefaultValue|date_format:'%d %h %Y %I:%M %p'|default:''}" data-date-startdate="{$Field.MinDate|default:''}" data-date-enddate="{$Field.MaxDate|default:''}" class="{$Field.ControlClass|default:''} date date-time-picker {$classes} text-{$Field.ControlAlign|default:'left'}" {$attributes}>
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>{/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_TIME}
                            {html_select_time prefix=$fieldName display_hours=true display_minutes=true display_seconds=false use_24_hours=false time=$Field.SelValue|default:$Field.DefaultValue|default:''}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_TIME_PICKER}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" class="time-picker {$classes}" value="{$Field.SelValue|default:$Field.DefaultValue|date_format:'%I:%M %p'|default:''}" {$attributes}>
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>{/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_SWITCH}
                            <input type="checkbox" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" class="{$Field.ControlClass|default:''} make-switch {$classes}" value="{$smarty.const.YES}" data-on="success" data-off="danger" {if isset($Field.SwitchLabelText)}data-text-label="{$Field.SwitchLabelText}"{/if} data-label-icon="fa {$Field.SwitchLabelIcon|default:''}" data-on-label="{$Field.SwitchOnText|default:$smarty.const.YES}" data-off-label="{$Field.SwitchOffText|default:$smarty.const.NO}" {if ($Field.SelValue|default:$Field.DefaultValue|default:$smarty.const.NO == $smarty.const.YES)}checked="checked"{/if} {$attributes}><br>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_PICFILE}
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>{/if}
                            <input type="file" tabindex="{$ControlTabIndex}" id="{$fieldName}" size="{$Field.ControlSize|default:''}" value="{$fieldName}" class="{$Field.ControlClass|default:''} {$classes}" {$attributes} {if isset($PK) && empty($PK) && isset($Field[$smarty.const.ALLOW_MULTIPLE]) && $Field[$smarty.const.ALLOW_MULTIPLE] === true}multiple="multiple" name="{$fieldName}[]" {else}name="{$fieldName}"{/if} />
                            <input type="hidden" id="prev_{$fieldName}" name="prev_{$fieldName}" value="{$Field.SelValue|default:''}" class="{$Field.ControlClass|default:''}" {$attributes}>
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-upload"></i></span>{/if}
                            {if isset($Field.GroupAddon)}</div>{*close addon div and start new div*}{/if}
                            <div>{*div to show image preview and delete switch. This new div will be closed automatically by addon close div. If addon id not on then has close div at end of this condition*}
                            {assign var="fileName" value=$Field.SelValue|default:''}
                            {assign var="fileOriginal" value=$fileName}
                            {if isset($Field.Pic_Prefix)}
                                {assign var="fileName" value=$Field.Pic_Prefix|cat:$fileName}
                            {/if}
                            {if !isset($fileName) || ($fileName=='') || (!"/"|cat:$fileName|file_exists:$P_Upload_Root)}
                                {assign var="fileName" value='small_default.gif'}
                            {/if}                            
                            {if $fileName != 'small_default.gif'}
                                {if isset($jFancyBox2)}
                                    <a href="{$V_Upload_Root}/{$fileOriginal}" class="gallery"><img width="{$Field.Disp_Width|default:'50'}" class="border-none" src="{$V_Upload_Root}/{$fileName}"></a>
                                {else}
                                    <img class="border-none" src="{$V_Upload_Root}/{$fileName}" width="{$Field.Disp_Width|default:'50'}">
                                {/if}
                            {elseif $Action != $smarty.const.A_ADD}
                                <img class="border-none" src="{$V_Upload_Root}/{$fileName}" width="{$Field.Disp_Width|default:'50'}">
                            {/if}
                            {if $fileName != 'small_default.gif' && $fileName != 'default.gif'}
                                {assign var="ControlTabIndex" value=$ControlTabIndex+1 scope="global"}
                                <input type="checkbox" id= "del_{$fieldName}" name="del_{$fieldName}" value="{$smarty.const.YES}" tabindex="{$ControlTabIndex}"  class="make-switch" data-on="danger" data-off="default" {*data-text-label=""*} data-label-icon="fa fa-trash-o" data-on-label="YES" data-off-label="NO">
                            {/if}
                            {if !isset($Field.GroupAddon)}
                                </div>{*div to show image preview and delete switch. This new div will be closed here if addon is off*}
                            {/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_AUDIOFILE}
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-music"></i></span>{/if}
                            <input type="file" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" class="{$Field.ControlClass|default:''} {$classes}" {$attributes}>
                            <input type="hidden" id="prev_{$fieldName}" name="prev_{$fieldName}" value="{$Field.SelValue|default:''}">
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-upload"></i></span>{/if}
                            {if isset($Field.SelValue) && $Field.SelValue|file_exists:$P_Upload_Root|cat:"/"}
                                {if isset($Field.GroupAddon)}</div>{*close addon div and start new div*}{/if}
                                <div class="separator bottom"></div>
                                <div class="input-group">{*div to show image preview and delete switch. This new div will be closed automatically by addon close div*}
                                <span class="input-group-addon bg-white border-none padding-none">
                                    <audio controls="controls">
                                        {*<source src="horse.wav" type="audio/wav">
                                        <source src="horse.ogg" type="audio/ogg">*}
                                        <source src="{$V_Upload_Root}/{$Field.SelValue}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </span>
                                <span class="input-group-addon bg-white border-none padding-none">
                                    {assign var="ControlTabIndex" value=$ControlTabIndex+1 scope="global"}
                                    <input type="checkbox" id= "del_{$fieldName}" name="del_{$fieldName}" value="{$smarty.const.YES}" tabindex="{$ControlTabIndex}"  class="make-switch" data-on="danger" data-off="default" {*data-text-label=""*} data-label-icon="fa fa-trash-o" data-on-label="YES" data-off-label="NO">
                                </span>
                                {if !isset($Field.GroupAddon)}</div>{*close input group for display addon*}{/if}
                            {/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_VIDEOFILE}
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-video-camera"></i></span>{/if}
                            <input type="file" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" class="{$Field.ControlClass|default:''} {$classes}" {$attributes}>
                            <input type="hidden" id="prev_{$fieldName}" name="prev_{$fieldName}" value="{$Field.SelValue|default:''}">
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-upload"></i></span>{/if}
                            {if isset($Field.SelValue)}
                                {if isset($Field.GroupAddon)}</div>{/if}{*close addon div and start new div*}
                                <div class="separator bottom"></div>
                                <div class="input-group">{*div to show image preview and delete switch. This new div will be closed automatically by addon close div*}
                                {*$Field.SelValue|substr:25*}
                                <video width="{$Field.ControlWidth|default:200}" height="{$Field.ControlHeight|default:200}" controls>
                                    {*<source src="movie.ogg" type="video/ogg">
                                    <source src="movie.webm" type="video/webm">*}
                                    <source src="{$V_Upload_Root}/{$Field.SelValue}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                {assign var="ControlTabIndex" value=$ControlTabIndex+1 scope="global"}
                                <br><input type="checkbox" id= "del_{$fieldName}" name="del_{$fieldName}" value="{$smarty.const.YES}" tabindex="{$ControlTabIndex}"  class="make-switch" data-on="danger" data-off="default" {*data-text-label=""*} data-label-icon="fa fa-trash-o" data-on-label="YES" data-off-label="NO">
                                {if !isset($Field.GroupAddon)}</div>{*close addon div if group addon flag is off*}{/if}
                            {/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_FILE}
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-file-text"></i></span>{/if}
                            <input type="file" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" class="{$Field.ControlClass|default:''} {$classes}" {$attributes}>
                            <input type="hidden" id="prev_{$fieldName}" name="prev_{$fieldName}" value="{$Field.SelValue|default:''}">
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-upload"></i></span>{/if}
                            {if isset($Field.SelValue) && !empty($Field.SelValue)}
                                {if isset($Field.GroupAddon)}</div>{/if}{*close addon div and start new div*}
                                <div class="separator bottom"></div>
                                <div class="input-group">{*div to show image preview and delete switch. This new div will be closed automatically by addon close div*}
                                    <span class="input-group-addon bg-white border-none padding-none">
                                        {$Field.SelValue|substr:25}
                                    </span>
                                    <span class="input-group-addon bg-white border-none padding-none">
                                        {assign var="ControlTabIndex" value=$ControlTabIndex+1 scope="global"}
                                        <input type="checkbox" id= "del_{$fieldName}" name="del_{$fieldName}" value="{$smarty.const.YES}" tabindex="{$ControlTabIndex}"  class="make-switch" data-on="danger" data-off="default" {*data-text-label=""*} data-label-icon="fa fa-trash-o" data-on-label="YES" data-off-label="NO">
                                    </span>
                                {if !isset($Field.GroupAddon)}</div>{/if}{*clode addon div if addon flag is off*}
                            {/if}
                        {elseif isset($Field.ControlType) && ($Field.ControlType == $smarty.const.C_COMBOBOX || $Field.ControlType == $smarty.const.C_DBCOMBOBOX)}
                            <select id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" {$Field.ControlExtra|default:''} class="{$Field.ControlClass|default:''} {if isset($Field.IsExtended)}{str_replace('form-control','',$classes)} bst-select margin-none dropdown-menu-light{else}{$classes}{/if}" {$attributes} {if isset($Field.IsExtended)}data-width="100%" data-size="10" data-live-search="true" data-style="btn-default" data-container="body"{/if}>
                                {if isset($Field.DefaultOption)}
                                    <option value="{'value'|array_value:$Field.DefaultOption}">{'text'|array_value:$Field.DefaultOption}</option>
                                {/if}
                                {if isset($Field.CryptValue) && $Field.CryptValue == true}
                                    {assign var='selected' value=Ocrypt::enc($Field.SelValue|default:$Field.DefaultValue|default:'')}
                                {else}
                                    {assign var='selected' value=$Field.SelValue|default:$Field.DefaultValue|default:''}
                                {/if}
                                {html_options options=$Field.Option|default:'' selected=$selected|default:$Field.DefaultValue|default:'' crypt_value=$Field.CryptValue|default:false}
                            </select>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_MULTI_SELECTION}
                            <select id="{$fieldName}" name="{$fieldName}[]" tabindex="{$ControlTabIndex}" {$Field.ControlExtra|default:''} class="{$Field.ControlClass|default:''} {str_replace('form-control','',$classes)} multi-select bst-select margin-none dropdown-menu-light" data-container="body" multiple="multiple" data-width="100%" data-size="10" data-live-search="true" data-style="btn-default" title="{$Field.Placeholder|default:('Select '|cat:$Field.Title)}" {$attributes}>
                                {if isset($Field.DefaultOption)}
                                    <option value="{'value'|array_value:$Field.DefaultOption}">{'text'|array_value:$Field.DefaultOption}</option>
                                {/if}
                                {html_options options=$Field.Option|default:'' selected=','|explode:$Field.SelValue|default:$Field.DefaultValue|default:'' crypt_value=$Field.CryptValue|default:false}
                            </select>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_PARENT_COMBOBOX}
                            <select id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" class="{$Field.ControlClass|default:''} form-control bst-select" data-live-search="true" data-size="10" data-width="100%">
                                {if !isset($PCombo_NoRoot)}<option value="{Ocrypt::enc(0)}">ROOT</option>{/if}
                                {include file="layout/parent-combo.tpl" node=$R_RecordSet_Parent level=0}
                            </select>
                        {*
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_STATE_COUNTY_COMBOBOX}
                            {if $Field.IsLabel}
                                {$Field.SelValue|array_value:$Field.Option}
                                <input type="hidden" name="{$fieldName}" id="{$fieldName}" value="{$Field.SelValue}">
                            {else}
                                <select id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" class="form-control" onchange="JavaScript: xajax_FillCounty(this.value, '{$Field.ControlDependency}');" style="width:120px" class="{$Field.ControlClass}{$classes}" {$attributes}>
                                    {if $Field.DefaultOption}
                                        <option value="{'value'|array_value:$Field.DefaultOption}">{'text'|array_value:$Field.DefaultOption}</option>
                                    {/if}
                                    {html_options options=$Field.Option selected=$Field.SelValue|default:$Field.DefaultValue}
                                </select>&nbsp;{assign var=ControlTabIndex value=$ControlTabIndex+1 scope="global"}
                            {/if}
                            <span id="container_{$Field.ControlDependency}">
                                <select id="{$Field.ControlDependency}" name="{$Field.ControlDependency}" tabindex="{$ControlTabIndex}" class="form-control" style="width:120px">
                                    {if $Field.RelControlDefaultOption}
                                        <option value="{'value'|array_value:$Field.RelControlDefaultOption}">{'text'|array_value:$Field.RelControlDefaultOption}</option>
                                    {/if}
                                    {html_options options=$Field.RelControlOption}
                                </select>
                            </span>
                            <br>
                            <div class="error" htmlfor="{$fieldName}">Please select state/county</div>
                            <script language="javascript" type="text/javascript">
                                $(document).ready(function(){ldelim}

                                    /* Fill Up county */
                                    xajax_FillCounty('{$Field.SelValue}', '{$Field.ControlDependency}', {ldelim}selCounty:''{rdelim});
                                    {rdelim});
                            </script>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_CITY_STATE_SUGGESTION}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize}" maxlength="{$Field.ControlMaxLen}" value="{$Field.SelValue|default:$Field.DefaultValue}" rel="{$Field.ControlRel}" class="{$Field.ControlClass} {$classes} text-{$Field.ControlAlign|default:'left'}" {$attributes}>

                         *}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_PRIVILEGE}
                            </div>{** colse default 4 or 10 column div *}
                                <div class="col-lg-12">{*start new div with full width. This div will be closed by default closing*}
                                {include file='layout/user-privilege.tpl' FieldName=$fieldName PrivilegesList=$Field.Option|default:$AssignedPrivileges selected=$Field.SelValue|default:'' mode=$Action}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_SUGGESTION}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" maxlength="{$Field.ControlMaxLen|default:''}" value="{$Field.SelValue|default:$Field.DefaultValue|default:''}" rel="{$Field.ControlRel|default:''}" class="suggestion {$classes} text-{$Field.ControlAlign|default:'left'}" {$attributes}>
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_PHONE}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" maxlength="{$Field.ControlMaxLen|default:''}" value="{$Field.SelValue|default:$Field.DefaultValue|default:''}" class="{$Field.ControlClass|default:''} {$classes} phone text-{$Field.ControlAlign|default:'left'}" {$attributes} rel="{$Field.ControlRel|default:''}">
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-phone fa-rotate-270"></i></span>{/if}
                        {elseif isset($Field.ControlType) && $Field.ControlType == $smarty.const.C_CURRENCY}
                            <input type="text" id="{$fieldName}" name="{$fieldName}" tabindex="{$ControlTabIndex}" size="{$Field.ControlSize|default:''}" maxlength="{$Field.ControlMaxLen|default:'32'}" value="{$Field.SelValue|default:$Field.DefaultValue|default:'0.00'}" class="{$Field.ControlClass|default:''} {$classes} currency text-{$Field.ControlAlign|default:'right'}" {$attributes} rel="{$Field.ControlRel|default:''}">
                            {if isset($Field.GroupAddon)}<span class="input-group-addon"><i class="fa fa-inr"></i></span>{/if}
                        {/if}
                    {if isset($Field.LastAddon) && $Field.LastAddon != ''}<span class="input-group-addon">{if isset($Field.LastAddonIsText)}{$Field.LastAddon}{else}<i class="{$Field.LastAddon}"></i>{/if}</span>{/if}
                    {if isset($Field.GroupAddon) || isset($Field.FirstAddon) || isset($Field.LastAddon)}</div>{*group addon div end*}{/if}
                    {if isset($Field.ControlSize)}</div>{/if}
                    {if isset($Field.Desc)}
                        <div class="help-inline col-lg-12 padding-none"><i class="fa fa-info-circle text-primary" data-toggle="tooltip"></i> {$Field.Desc}
                            {*<span class="btn btn-primary" data-toggle="popover" data-title="Help for {$Field.Title}" data-content="" data-placement=""></span>*}
                        </div>
                    {/if}
                </div>{*field container div end*}
            {/if}
            {if isset($fldCount) && isset($LayoutCols) && $fldCount%$LayoutCols == 0}
                </div>{*row end*}
                {if isset($Field.ControlType) && $Field.ControlType != $smarty.const.C_HIDDEN}
                    <div class="separator bottom"></div>{*row separator *}
                {/if}
            {/if}
            {*Reset Values*}
            {assign var=classes value=''}
            {assign var=attributes value=''}
        {/if}
    {/foreach}
        </div>{*widget body close*}
    </div>{*widget close*}
{/if}
{if isset($ExtraFormFileAfter) && $ExtraFormFileAfter != false}
    {include file=$ExtraFormFileAfter}
{/if}
{if !isset($SidebarLeftForm) && !isset($WithoutForm)}
    <input type="hidden" name="Action" value="{$Action}">
    <input type="hidden" name="pk" value="{if isset($PK) && $PK != ''}{Ocrypt::enc($PK)}{/if}">
    {*if isset($IsAjaxBase)}<input type="hidden" name="SubmitForm" value="{str_replace(' ','',$SubmitButtonText|default:'Save')}">{/if*}
    <div id="fixed-buttons">
        <div id="form-actions">
            {if !isset($HideSave)}<button form="standard-form" class="btn btn-success" type="submit" name="SubmitForm" id="submit-standard-form" value="{str_replace(' ','',$SubmitButtonText|default:'Save')}" tabindex="{$SubButtTabIndex|default:$ControlTabIndex}"><i class="{$SubmitButtonIcon|default:'fa fa-floppy-o'} fa-lg"></i>&nbsp;&nbsp;{$SubmitButtonText|default:'Save'}</button>{/if}

            {if !isset($HideCancelClose)}
                {if $smarty.const.POPUP_WIN == 'true' && (!isset($IsClose) || (isset($IsClose) && $IsClose == true))}
                    {if isset($includeCloseFunction)}{assign var=CallBackFunction value='callOnClose();'}{/if}
                    <button class="btn btn-danger" type="button" tabindex="{if isset($SubButtTabIndex)}{$SubButtTabIndex+1}{else}{$ControlTabIndex+2}{/if}" onclick="javascript: {$CallBackFunction|default:''} parent.$.fancybox.close();"><i class="fa fa-times-circle fa-lg"></i>&nbsp;&nbsp;Close</button>
                {elseif isset($IsAjaxBase)}
                    <button class="btn btn-danger go-back" type="button" tabindex="{if isset($SubButtTabIndex)}{$SubButtTabIndex+1}{else}{$ControlTabIndex+2}{/if}"><i class="fa fa-times-circle fa-lg"></i>&nbsp;&nbsp;Cancel</button>
                {else}
                    <button class="btn btn-danger" type="button" tabindex="{if isset($SubButtTabIndex)}{$SubButtTabIndex+1}{else}{$ControlTabIndex+2}{/if}" onclick="javascript:window.location='{$CancelActionUrl|default:$A_Action}';"><i class="fa fa-times-circle fa-lg"></i>&nbsp;&nbsp;Cancel</button>
                {/if}
            {/if}
        </div>
    </div>
    <div id="standard-form-helper"></div>
    {if !isset($MegaForm) && !isset($WithoutForm)}</form>{/if}
{/if}