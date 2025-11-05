<div class="modal-header">
    <h5 class="modal-title txt-heading heading_txt_color" id="exampleModalLabel">Save Search</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="savesearch-error"></div>
<div class="modal-body pb-0 mt-3 mb-5">
{*    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="module-head">
                <h4 class="auth-heading">Almost done…</h4>
                <p>You can modify your email later under My CustomWpPlugin.com.</p>
            </div>
        </div>
    </div>*}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-group">
        <p>
            {if isset($arrSearchParams.AddressName)}
                <strong>Address: </strong>{$arrSearchParams.addval}<br />
            {/if}
            {if isset($arrSearchParams.ptype)}
                <strong>Property Type: </strong>{if is_array($arrSearchParams.ptype)}{$arrSearchParams.ptype|implode:', '|lower|ucwords}{else}{$arrSearchParams.ptype}{/if}
                <br>
            {/if}
            {if isset($arrSearchParams.minprice) && isset($arrSearchParams.maxprice) && $arrSearchParams.minprice > 0 && $arrSearchParams.maxprice > 0}
                <strong>Price:</strong>{$currency}{$arrSearchParams.minprice|number_format} - {$currency}{$arrSearchParams.maxprice|number_format}<br />
            {elseif isset($arrSearchParams.minprice) && $arrSearchParams.minprice > 0}
                <strong>Price More Than: </strong>{$currency}{$arrSearchParams.minprice|number_format}<br />
            {elseif isset($arrSearchParams.maxprice) && $arrSearchParams.maxprice > 0}
                <strong>Price Less Than: </strong>{$currency}{$arrSearchParams.maxprice|number_format}<br />
            {/if}
            {if isset($arrSearchParams.beds) && $arrSearchParams.beds > 0 }
                <strong>Bedrooms: </strong>{$arrSearchParams.beds}<br />
            {/if}
            {if isset($arrSearchParams.minbed) && isset($arrSearchParams.maxbed) && $arrSearchParams.minbed > 0 && $arrSearchParams.maxbed > 0}
				<strong>Bedroom Range: </strong>{$arrSearchParams.minbed|number_format} - {$arrSearchParams.maxbed|number_format}<br />
			{elseif isset($arrSearchParams.minbed) && $arrSearchParams.minbed > 0}
				<strong>Bedroom Greater Than: </strong>{$arrSearchParams.minbed|number_format}<br />
			{elseif isset($arrSearchParams.maxbed) && $arrSearchParams.maxbed > 0}
				<strong>Bedroom Less Than: </strong>{$arrSearchParams.maxbed|number_format}<br />
			{/if}
            {if isset($arrSearchParams.minbath) && $arrSearchParams.minbath > 0}
                <strong>Bathroom: </strong>{$arrSearchParams.minbath}<br />
            {/if}
            {if isset($arrSearchParams.minsqft) && isset($arrSearchParams.maxsqft) && $arrSearchParams.minsqft > 0 && $arrSearchParams.maxsqft > 0}
                <strong>Square Feet Range: </strong>{$arrSearchParams.minsqft|number_format} - {$arrSearchParams.maxsqft|number_format}<br />
            {elseif isset($arrSearchParams.minsqft) && $arrSearchParams.minsqft > 0}
                <strong>Square Feet Greater Than: </strong>{$arrSearchParams.minsqft|number_format}<br />
            {elseif isset($arrSearchParams.maxsqft) && $arrSearchParams.maxsqft > 0}
                <strong>Square Feet Less Than: </strong>{$arrSearchParams.maxsqft|number_format}<br />
            {/if}
            {if isset($arrSearchParams.minyear) && isset($arrSearchParams.maxyear) && $arrSearchParams.minyear > 0 && $arrSearchParams.maxyear > 0}
                <strong>Year Built Range: </strong>{$arrSearchParams.minyear} - {$arrSearchParams.maxyear}<br />
            {elseif isset($arrSearchParams.minyear) && $arrSearchParams.minyear > 0}
                <strong>Year Built After: </strong>{$arrSearchParams.minyear}<br />
            {elseif isset($arrSearchParams.maxyear) && $arrSearchParams.maxyear > 0}
                <strong>Year Built Before: </strong>{$arrSearchParams.maxyear}<br />
            {/if}

            {if isset($arrSearchParams.minlotsize) && isset($arrSearchParams.maxlotsize) && $arrSearchParams.minlotsize > 0 && $arrSearchParams.maxlotsize > 0}
                <strong>Lotsize Range: </strong>{$arrSearchParams.minlotsize} - {$arrSearchParams.maxlotsize}<br />
            {elseif isset($arrSearchParams.minlotsize) && $arrSearchParams.minlotsize > 0}
                <strong>Lotsize Greater Than: </strong>{$arrSearchParams.minlotsize}<br />
            {elseif isset($arrSearchParams.maxlotsize) && $arrSearchParams.maxlotsize > 0}
                <strong>Lotsize Less Than: </strong>{$arrSearchParams.maxlotsize}<br />
            {/if}
            {if isset($arrSearchParams.sdivlist) && is_array($arrSearchParams.sdivlist)}
                <strong>Subdivision: </strong>{if is_array($arrSearchParams.sdivlist)}{$arrSearchParams.sdivlist|implode:', '|lower|ucwords}{else}{$arrSearchParams.sdivlist}{/if}<br />
                <br>
            {/if}
            {if isset($arrSearchParams.dom) && !empty($arrSearchParams.dom)}
                <strong>Days on Market: </strong>{$arrSearchParams.dom}<br />
            {/if}
            {if isset($arrSearchParams.stype)}
                <strong>Property Type: </strong>{if is_array($arrSearchParams.stype)}{str_replace('|',', ',$arrSearchParams.stype)|implode:', '}{else}{str_replace('|',', ',$arrSearchParams.stype)}{/if}<br />
            {/if}
            {if isset($arrSearchParams.pstyle)}
                <strong>Property Style: </strong>{if is_array($arrSearchParams.pstyle)}{$arrSearchParams.pstyle|implode:', '}{else}{$arrSearchParams.pstyle}{/if}<br />
            {/if}
            {if isset($arrSearchParams.kword) && !empty($arrSearchParams.kword)}
                <strong>Additional: </strong> {$arrSearchParams.kword}
            {/if}
            {if isset($arrSearchParams.horse_amenities) && !empty($arrSearchParams.horse_amenities)}
                {*<strong>Horse Amenities: </strong> {$arrSearchParams.horse_amenities|capitalize}<br />*}
                <strong>Horse Amenities: </strong>{if is_array($arrSearchParams.horse_amenities)}{str_replace('|',', ',$arrSearchParams.horse_amenities)|implode:', '}{else}{str_replace('|',', ',$arrSearchParams.horse_amenities)}{/if}<br />
            {/if}
            {if isset($arrSearchParams.horse_yn) && !empty($arrSearchParams.horse_yn)}
                <strong>Is Horse?: </strong> {$arrSearchParams.horse_yn|capitalize}<br />
            {/if}
            {if isset($arrSearchParams.waterfrontdesc) && !empty($arrSearchParams.waterfrontdesc)}
                <strong>Waterfront Description: </strong> {$arrWaterfrontDesc[$arrSearchParams.waterfrontdesc]}<br />
            {/if}
            {if isset($arrSearchParams.security_safety) && !empty($arrSearchParams.security_safety)}
                <strong>Security: </strong> {$arrSearchParams.security_safety|capitalize} <br />
            {/if}
            {if isset($arrSearchParams.add) && !empty($arrSearchParams.add)}
                <strong>Address: </strong> {$arrSearchParams.add} <br />
            {/if}
            {if is_array($arrSearchParams.city)}
                <strong>City: </strong> {$arrSearchParams.city.0} <br />
                <strong>State: </strong> {$arrSearchParams.city.1} <br />
            {elseif isset($arrSearchParams.city) && !empty($arrSearchParams.city)}
                <strong>City: </strong> {$arrSearchParams.city} <br />
            {/if}
            {if isset($arrSearchParams.zipcode) && !empty($arrSearchParams.zipcode)}
                <strong>Zipcode: </strong> {$arrSearchParams.zipcode} <br />
            {/if}
        </p>
    </div>
    <form for="form" id="frmSaveSearch">
        <span id="save_message_area_topbar"></span>
        <div class="group position-relative">
            <input class="form-input w-100 bg-transparent" id="search_title" aria-describedby="search_title" name="search_title" type="text" placeholder="" required="">
            <span class="bar"></span>
            <label class="form-label position-absolute">Save Search Name</label>
        </div>

        <input type="hidden" name="ReqType" id="ReqType" value="{$smarty.request.ReqType|default:''}"/>
        <input type="hidden" name="pid" id="pid" value="{$smarty.request.pid|default:''}"/>
        <input type="hidden" name="cid" id="cid" value="{$smarty.request.cid|default:''}"/>
        <input type="hidden" name="surl" value="{$surl}"/>
{*        <a class="btn border-secondary te-btn text-white w-100 shadow-none rounded-0 text-uppercase btn-savesearch" href="#" role="button">Submit</a>*}
        <button type="submit" class="btn border-secondary te-btn text-white- w-100 shadow-none rounded-0 text-uppercase btn-savesearch lpt-btn lpt-btn-txt">Submit</button>
    </form>

</div>
{*<div class="modal-footer justify-content-start">
    <div class="row">
        <div class="col-xl-12">
            <p>By submitting, I accept CustomWpPlugin's
                <a class="text-main" href="#">terms of use.</a>
            </p>
        </div>
    </div>
</div>*}
