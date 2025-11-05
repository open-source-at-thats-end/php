<hr/>
<form id="FrmCntct" action="" method="get">
    <input type="hidden" name="page" value="{$page}"/>
    <div class="form-group row">
        <div class="col-sm">
            <label {*for="csearch_fname"*}>First Name</label>
            <input type="text" class="form-control" id="csearch_fname" name="csearch_fname" value="{$arrParams.csearch_fname|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_lname"*}>Last Name</label>
            <input type="text" class="form-control" id="csearch_lname" name="csearch_lname" value="{$arrParams.csearch_lname|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_area_city"*}>Area or City</label>
            <input type="text" class="form-control" id="csearch_area_city" name="csearch_area_city" value="{$arrParams.csearch_area_city|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_zipcode"*}>Zip Code</label>
            <input type="text" class="form-control" id="csearch_zipcode" name="csearch_zipcode" value="{$arrParams.csearch_zipcode|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_lead_type"*}>Lead Type</label>
            <input type="text" class="form-control" id="csearch_lead_type" name="csearch_lead_type" value="{$arrParams.csearch_lead_type|default:''}" placeholder="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm">
            <label {*for="csearch_min_price"*}>Price Minimum</label>
            <input type="text" class="form-control" id="csearch_min_price" name="csearch_min_price" value="{$arrParams.csearch_min_price|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_max_price"*}>Price Maximum</label>
            <input type="text" class="form-control" id="csearch_max_price" name="csearch_max_price" value="{$arrParams.csearch_max_price|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_ptype"*}>Property Type</label>
            <input type="text" class="form-control" id="csearch_ptype" name="csearch_ptype" value="{$arrParams.csearch_ptype|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_source"*}>Source</label>
            <input type="text" class="form-control" id="csearch_source" name="csearch_source" value="{$arrParams.csearch_timeframe|default:''}" placeholder="">
        </div>
        <div class="col-sm">
            <label {*for="csearch_timeframe"*}>Timeframe</label>
            <input type="text" class="form-control" id="csearch_timeframe" name="csearch_timeframe" value="{$arrParams.psearch_title|default:''}" placeholder="">
        </div>
    </div>
    <div class="form-group row align-items-center">
        <div class="col-10">
            <label {*for="csearch_tags"*}>Tags (separate mutile by commas)</label>
            <input type="text" class="form-control" id="csearch_tags" name="csearch_tags" value="{$arrParams.csearch_tags|default:''}" placeholder="">
        </div>
        <div class="col-2">
            <input type="submit" id="csearch"  name="submit" value="Search" class="btn btn-gradient-primary font-weight-light w-100">
        </div>
    </div>
    <input type="hidden" value="{$scriptname}"/>
</form>