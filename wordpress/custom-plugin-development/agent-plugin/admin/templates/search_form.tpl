<div>
    <div class="fholder2">
        <label><b>MLS#</b></label>
        <input type="text" id="mlslist" name="mlslist" value="{$arrSearchCriteria.mlslist}" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Address</b></label>
        <input type="text" id="add" name="add" value="{$arrSearchCriteria.add}" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Price Range</b></label>
        {*<select name="minprice" class="apm_monoselect input-large">
            <option value="">Min</option>
            {html_options options=$arrPriceRange selected=$arrSearchCriteria.minprice}
        </select>*}
        <input type="text" id="minprice" name="minprice" value="{$arrSearchCriteria.minprice}" class="input-large for-search"/>
        To
        {*<select name="maxprice" class="apm_monoselect input-large">
            <option value="">Max</option>
            {html_options options=$arrPriceRange selected=$arrSearchCriteria.maxprice}
        </select>*}
        <input type="text" id="maxprice" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="input-large for-search"/>
{*        <div id="price-range"></div>*}
    </div>
    <br class="fclear">
    {*<div class="fholder2">
        <label><b>Area</b></label>
        <div class="multi-opt cols3 multi-options-container">
            {foreach name=area from=$arrMeta['Area'] key=skey item=sitem}
                <label><input type="checkbox" name="area[]" {if $skey|in_array:$arrSearchCriteria.area || $skey == $arrSearchCriteria.area}checked="checked"{/if} id="{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
            {/foreach}
        </div>
    </div>*}
    <div class="fholder2">
        <label><b>City</b></label>
       {* {if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
            <label><b> ACTRIS </b></label>
            <div class="multi-opt cols3 multi-options-container">
                {foreach name=city from=$arrMeta['CityActris']['ACTRIS'] key=ckey item=citem}
                    <label><input type="checkbox" name="city[]" {if $ckey|in_array:$arrSearchCriteria.city || $ckey == $arrSearchCriteria.city}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
                {/foreach}
            </div>
        {else}
            <label><b> MIAMI/BEACHES </b></label>*}
            <div class="multi-opt cols3 multi-options-container">
                {foreach name=city from=$arrMeta['CityActris']['MIAMI/BEACHES'] key=ckey item=citem}
                    <label><input type="checkbox" name="city[]" {if (isset($arrSearchCriteria.city)) && ($ckey|in_array:$arrSearchCriteria.city || $ckey == $arrSearchCriteria.city)}checked="checked"{/if} id="{$ckey}" value="{$ckey}" />&nbsp;{$citem}</label>
                {/foreach}
            </div>
        {*{/if}*}
    </div>
    <div class="fholder2">
        <label><b>Subdivision</b></label>
        <input type="text" id="sdivlist" name="sdivlist" value="{$arrSearchCriteria.sdivlist}" class="input-lg for-search"/>
        {*<div class="multi-opt cols3 multi-options-container">
            {foreach name=sdiv from=$arrMeta['Subdivision'] key=subkey item=subitem}
                {if !preg_match('/[^a-z A-Z\d]/', $subitem)}
                <label><input type="checkbox" name="sdiv[]" {if $subkey|in_array:$arrSearchCriteria.sdiv || $subkey == $arrSearchCriteria.sdiv}checked="checked"{/if} id="{$subkey}" value="{$subkey}" />&nbsp;{$subitem}</label>
                {/if}
            {/foreach}
        </div>*}
    </div>
    <div class="fholder2">
        <label><b>Lot Size</b></label>
        <select name="minlotsizesqft" class="apm_monoselect input-large">
            <option value="">Min</option>
            {html_options options=$arrLotSize selected=$arrSearchCriteria.minlotsizesqft}
        </select>
        To
        <select name="maxlotsizesqft" class="apm_monoselect input-large">
            <option value="">Max</option>
            {html_options options=$arrLotSize selected=$arrSearchCriteria.maxlotsizesqft}
        </select>
    </div>
    <div class="fholder2">
        <label><b>Year Built</b></label>
        <select name="minyear" class="apm_monoselect input-large">
            <option value="">Min</option>
            {html_options options=$arrminYearBuild selected=$arrSearchCriteria.minyear}
        </select>
        To
        <select name="maxyear" class="apm_monoselect input-large">
            <option value="">Max</option>
            {html_options options=$arrmaxYearBuild selected=$arrSearchCriteria.maxyear}
        </select>
    </div>
    <br class="fclear">
    <div class="fholder2 pt-10">
        <label><b>Property Type</b></label>
      {*  {if isset($AgentSystemName) && $AgentSystemName == {constant('Constants::ACTRIS')}}
            <label><b> ACTRIS </b></label>
            <div class="multi-opt cols3 multi-options-container">
                {foreach name=ptype from=$arrMeta['SubTypeActris'] key=pkey item=pitem}
                    <label><input type="checkbox" name="stype[]" {if $pkey|in_array:$arrSearchCriteria.stype || $pkey == $arrSearchCriteria.stype}checked="checked"{/if} id="{$pkey}" value="{$pkey}" />&nbsp;{$pitem}</label>
                {/foreach}
                <label><input type="checkbox" name="stype[]" {if 'CommercialLease'|in_array:$arrSearchCriteria.stype || 'CommercialLease' == $arrSearchCriteria.stype}checked="checked"{/if} id="CommercialLease" value="CommercialLease" />&nbsp;Commercial Lease</label>
            </div>
        {else}
            <label><b> MIAMI/BEACHES </b></label>*}
            <div class="multi-opt cols3 multi-options-container">
                {foreach name=ptype from=$arrMeta['SubType'] key=pkey item=pitem}
                    <label><input type="checkbox" name="stype[]" {if (isset($arrSearchCriteria.stype)) && ($pkey|in_array:$arrSearchCriteria.stype || $pkey == $arrSearchCriteria.stype)}checked="checked"{/if} id="{$pkey}" value="{$pkey}" />&nbsp;{$pitem}</label>
                {/foreach}
                <label><input type="checkbox" name="stype[]" {if (isset($arrSearchCriteria.stype)) && ('CommercialLease'|in_array:$arrSearchCriteria.stype || 'CommercialLease' == $arrSearchCriteria.stype)}checked="checked"{/if} id="CommercialLease" value="CommercialLease" />&nbsp;Commercial Lease</label>
            </div>
      {*  {/if}*}
    </div>
  {*  {if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
        <div class="fholder2 pt-10">
            <label><b>Property Style</b></label>
            <div class="multi-opt cols3 multi-options-container">
                {foreach name=pstyle from=$arrMeta['PropertyStyle'] key=skey item=sitem}
                    <label><input type="checkbox" name="pstyle[]" {if (isset($arrSearchCriteria.pstyle)) && ($skey|in_array:$arrSearchCriteria.pstyle || $skey == $arrSearchCriteria.pstyle)}checked="checked"{/if} id="{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
                {/foreach}
            </div>
        </div>
   {* {/if}*}
    <div class="fholder2 pt-10">
        <label><b>Days on Market</b></label>
        <select name="dom" class="apm_monoselect input-lg">
            <option value="">Any</option>
            {html_options options=$arrDayMarket selected=$arrSearchCriteria.dom}
        </select>

    </div>

    <div class="fholder2">
        <div class="col6">
            <label><b>Waterfront</b></label>
            <select name="waterfront" class="apm_monoselect input-large">
                <option value="">Any</option>
                {html_options options=$arrYesNo selected=$arrSearchCriteria.waterfront}
            </select>
        </div>
        <div class="col6">
            <label><b>Pool</b></label>
            <select name="pool" class="apm_monoselect input-large">
                <option value="">Any</option>
                {html_options options=$arrYesNo selected=$arrSearchCriteria.pool}
            </select>
        </div>
    </div>
    <div class="fholder2">
        <label><b>Status</b></label>
        <div class="multi-opt cols3 multi-options-container">
            {foreach name=status from=$arrStatus key=skey item=sitem}
                <label><input type="checkbox" name="status[]" {if (isset($arrSearchCriteria.status)) && ($skey|in_array:$arrSearchCriteria.status || $skey == $arrSearchCriteria.status)}checked="checked"{/if} id="ck-{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
            {/foreach}
{*            <select name="status" class="apm_monoselect input-large">
                {html_options options=$arrStatus selected=$arrSearchCriteria.status}
            </select>*}
        </div>
    </div>

    <div class="fholder2">
        <div class="col6">
            <label><b>Pets Allowed</b></label>
            <select name="petsallowed" class="apm_monoselect input-large">
                <option value="">Any</option>
                {html_options options=$arrYesNo selected=$arrSearchCriteria.petsallowed}
            </select>
        </div>

    </div>
    <div class="fholder2">
        <label><b>Waterfront Descripton</b></label>
        <div class="multi-opt cols3 multi-options-container">
            {foreach name=waterfrontdesc from=$arrWaterfrontDesc key=skey item=sitem}
                <label><input type="checkbox" name="waterfrontdesc[]" {if (isset($arrSearchCriteria.waterfrontdesc)) && (skey|in_array:$arrSearchCriteria.waterfrontdesc || $skey == $arrSearchCriteria.waterfrontdesc)}checked="checked"{/if} id="ck-{$skey}" value="{$skey}" />&nbsp;{$sitem}</label>
            {/foreach}
        </div>
    </div>
{*    {if !isset($isPredefine)}*}
{*        <div class="fholder2">
            <label><b>Limit Results by Number</b></label>
            <input type="text" id="limit" name="limit" value="{$arrSearchCriteria.limit}" class="input-lg for-search"/>
        </div>*}
{*    {/if}*}



    <br class="fclear">
    <div class="fholder2">
        <label><b>Sqft Range</b></label>
        <select name="minsqft" class="apm_monoselect input-large">
            <option value="">Min</option>
            {html_options options=$arrSqftRange selected=$arrSearchCriteria.minsqft}
        </select>
        To
        <select name="maxsqft" class="apm_monoselect input-large">
            <option value="">Max</option>
            {html_options options=$arrSqftRange selected=$arrSearchCriteria.maxsqft}
        </select>
    </div>
    <div class="fholder2">
		<label><b># of Bedrooms</b></label>
		<select name="minbed" class="apm_monoselect input-large">
			<option value="">Min</option>
			{html_options options=$arrBedRange selected=$arrSearchCriteria.minbed}
		</select>
		To
		<select name="maxbed" class="apm_monoselect input-large">
			<option value="">Max</option>
			{html_options options=$arrBedRange selected=$arrSearchCriteria.maxbed}
		</select>
    </div>
    <div class="fholder2">
		<label><b># of Bathrooms</b></label>
		<select name="minbath" class="apm_monoselect input-lg">
			<option value="">Select</option>
			{html_options options=$arrBathRange selected=$arrSearchCriteria.minbath}
		</select>
	</div>
	<br class="fclear">
    <div class="fholder2">
        <label><b>Zipcode</b></label>
        <input type="text" id="zipcode" name="zipcode" value="{$arrSearchCriteria.zipcode}" class="input-lg for-search"/>
    </div>

    {*<br class="fclear">
    <div class="fholder2">
        <label><b>Sub Type</b></label>
        <select name="stype" class="apm_monoselect input-xlarge">
            <option value="">Select</option>
            {html_options options=$arrPropertyStyle selected=$arrSearchCriteria.stype}
        </select>
    </div>*}
    <div class="fholder2">
        <label><b>Office Id</b></label>
        <input type="text" id="office" name="office" value="{$arrSearchCriteria.office}" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Agent Id</b></label>
        <input type="text" id="agent" name="agent" value="{$arrSearchCriteria.agent}" class="input-lg for-search"/>
    </div>
     <br class="fclear">
    <div class="fholder2">
        <label><b>Keyword</b></label>
        <input type="text" id="kword" name="kword" value="{$arrSearchCriteria.kword}" class="input-lg for-search"/>
        <div class="note-box input-lg"><b>Note: Keyword will be searched in Public, Private & Legal Remarks.</b></div>
    </div>
   {* {if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
        <div class="fholder2">
            <label><b>System Name</b></label>
            <select name="sys_name" class="apm_monoselect input-lg">
                {html_options options=$arrSystemName selected=$arrSearchCriteria.sys_name}

            </select>
        </div>
    {*{/if}*}
    {*<div class="fholder2">
        <label><b>Horse Amenities </b></label>
        <input type="text" id="horse_amenities" name="horse_amenities" value="{$arrSearchCriteria.horse_amenities}" class="input-lg for-search"/>
    </div>*}
    <div class="fholder2">
        {* <div class="col6">*}
        <label><b>Is Horse?</b></label>
        <select name="horse_yn" class="apm_monoselect input-lg">
            <option value="">Any</option>
            {html_options options=$arrYesNo selected=$arrSearchCriteria.horse_yn}
        </select>
        {*</div>*}
    </div>
   {* <div class="fholder2">
        <label><b>Waterfront Description</b></label>
        <select name="waterfrontdesc" class="apm_monoselect input-lg">
            <option value="">Any</option>
            {html_options options=$arrWaterfrontDesc selected=$arrSearchCriteria.waterfrontdesc}
        </select>
    </div>*}

  {*  {if isset($AgentSystemName) && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
        <div class="fholder2">
            {*<div class="col6">*}
            <label><b>Security</b></label>
            <select name="security_safety" class="apm_monoselect input-lg">
                <option value="">No preference</option>
                {html_options options=$arrSecuritySafety selected=$arrSearchCriteria.security_safety}
            </select>
            {* </div>*}
        </div>
   {* {/if}*}
   {* {if isset($AgentSystemName)  && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
        <div class="fholder2">
            <div class="col6">
                <label><b>Membership Required</b></label>
                <select name="membership_required" class="apm_monoselect input-large">
                    <option value="">Any</option>
                    {html_options options=$arrYesNo selected=$arrSearchCriteria.membership_required}
                </select>
            </div>
        </div>
   {* {/if}*}
   {* {if isset($AgentSystemName)  && $AgentSystemName != {constant('Constants::ACTRIS')}}*}
        <div class="fholder2">
            <div class="fholder2">
                <label><b>Membership Fee</b></label>
                <input type="text" id="membership_fee" name="membership_fee" value="{$arrSearchCriteria.membership_fee}" class="input-lg for-search"/>
            </div>
        </div>
    {* {/if}*}

{*{$arrAgent[1]|print_r}*}
    <div class="fholder2">
        <label><b>Agent profile</b></label>
        <select name="Agent profile Id" class="apm_monoselect input-lg">
            {*                            {*<option value="">Select</option>*}
            <option value="{$arrAgent}">Any</option>
            {html_options options=$arrAgent selected=$arrSearchCriteria.Agent_Id}
        </select>
    </div>


</div>
<script type="text/javascript">
    var minprice	= '{if isset($arrSearchCriteria.minprice) && $arrSearchCriteria.minprice != ''}{$arrSearchCriteria.minprice}{else}0{/if}';
    var maxprice	= '{if isset($arrSearchCriteria.maxprice) && $arrSearchCriteria.maxprice != ''}{$arrSearchCriteria.maxprice}{else}0{/if}';
</script>