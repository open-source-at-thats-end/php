<form id="FrmCondo" method="get" action="">
    <input type="hidden" name="page" value="{$page}"/>
    <div class="row">
        <div class="span6">
            <label><b>Building Name</b></label>
            <input type="text" id="csearch_name" name="csearch_name" value="{$arrParams.csearch_name|default:''}" class="input-lg for-search"/>
        </div>
        <div class="span8">
            <label><b>Building Address</b></label>
            <input type="text" id="csearch_address" name="csearch_address" value="{$arrParams.csearch_address|default:''}" class="input-lg for-search"/>
        </div>
        <div class="span4">
            <label></label>
            <input type="submit" id="csearch" value="Search" class="input-lg for-search"/>
        </div>
        <input type="hidden"  value="{$scriptname}"/>
    </div>
</form>