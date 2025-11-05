<form id="FrmAgent" method="get" action="">
    <input type="hidden" name="page" value="{$page}"/>
	<div class="row">
		<div class="span6">
			<label><b>First Name</b></label>
			<input type="text" id="agent_first_name" name="agent_first_name" value="{$arrParams.agent_first_name|default:''}" class="input-lg for-search "/>
		</div>
		<div class="span8">
			<label><b>Last Name</b></label>
			<input type="text" id="agent_last_name" name="agent_last_name" value="{$arrParams.agent_last_name|default:''}" class="input-lg for-search"/>
		</div>
		
	</div>
    <div class="row">
    <div class="span1">
			<label></label>
			<input type="submit" id="search"  value="Search" class="input-lg btn btn-sm for-search"/>
		</div>
		<div class="span1">
			<label></label>
			<a href="{$scriptname}" type="button" value="" class="for-search btn btn-sm">Reset</a>
		</div>
	</div>
</form>