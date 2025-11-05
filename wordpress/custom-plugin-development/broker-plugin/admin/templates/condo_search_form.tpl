<div>
    <div class="fholder2">
        <label><b>Building Address</b></label><br>
        <input type="text" id="add" name="add" value="{$arrSearchCriteria.add}" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>City</b></label><br>
        <input type="text" id="city" name="city" value="{$arrSearchCriteria.city}" class="input-lg for-search"/>
        <div class="note">Enter city with state for ex., Miami, FL</div>
    </div>
    <div class="fholder2">
        <label><b>Zipcode</b></label><br>
        <input type="text" id="zipcode" name="zipcode" value="{$arrSearchCriteria.zipcode}" class="input-lg for-search"/>
    </div>
    <br class="fclear">
    {*<div class="fholder2">
        <label><b>Year Built</b></label><br>
        <input type="text" id="yearbuilt" name="yearbuilt" value="{$arrSearchCriteria.yearbuilt}" class="input-lg for-search"/>
    </div>*}
    <div class="fholder2">
        <label><b>Subdivision</b></label><br>
        <input type="text" id="sdivlist" name="sdivlist" value="{$arrSearchCriteria.sdivlist}" class="input-lg for-search"/>
    </div>
    <div class="fholder2">
        <label><b>Year Built</b></label><br>
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
    <div class="fholder2">
        <label><b>Date Range</b></label><br>
        <input id="datepickermin" name="mindate" value="{if (isset($arrSearchCriteria.mindate) && $arrSearchCriteria.mindate != '')}{$arrSearchCriteria.mindate}{/if}" class="input-large for-search"/>
        To
        <input id="datepickermax" name="maxdate" value="{if (isset($arrSearchCriteria.maxdate) && $arrSearchCriteria.maxdate != '')}{$arrSearchCriteria.maxdate}{/if}" class="input-large for-search"/>
    </div>
    <br class="fclear">
    <div class="fholder2">
        <label><b>Price Range</b></label><br>
        <input type="text" id="minprice" name="minprice" value="{$arrSearchCriteria.minprice}" class="input-large for-search"/>
        To
        <input type="text" id="maxprice" name="maxprice" value="{$arrSearchCriteria.maxprice}" class="input-large for-search"/>
    </div>
    <br class="fclear">
    <div class="fholder2">
        <label><b>Waterfront</b></label><br>
        <select name="waterfront" class="apm_monoselect input-lg">
            <option value="">Any</option>
            {html_options options=$arrYesNo selected=$arrSearchCriteria.waterfront}
        </select>
    </div>
    <div class="fholder2">
        <label><b>Pets Allowed</b></label><br>
        <select name="petsallowed" class="apm_monoselect input-lg">
            <option value="">Any</option>
            {html_options options=$arrYesNo selected=$arrSearchCriteria.petsallowed}
        </select>
    </div>
    {if isset($AgentSystemName)  && $AgentSystemName != {constant('Constants::ACTRIS')}}
        <div class="fholder2">
            <label><b>System Name</b></label><br>
            <select name="sys_name" class="apm_monoselect input-lg sys-name">
                {html_options options=$arrSystemName selected=$arrSearchCriteria.sys_name}
            </select>
        </div>
    {/if}
</div>
<script type="text/javascript">
    var minprice	= '{if isset($arrSearchCriteria.minprice) && $arrSearchCriteria.minprice != ''}{$arrSearchCriteria.minprice}{else}0{/if}';
    var maxprice	= '{if isset($arrSearchCriteria.maxprice) && $arrSearchCriteria.maxprice != ''}{$arrSearchCriteria.maxprice}{else}0{/if}';
</script>