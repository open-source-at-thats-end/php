
<form id="FrmPre" method="get" action="">
    <input type="hidden" name="page" value="{$page}"/>
	<div class="row">
		<div class="span6">
			<label><b>Title</b></label>
			<input type="text" id="psearch_title" name="psearch_title" value="{$arrParams.psearch_title|default:''}" class="input-lg for-search"/>
		</div>
		<div class="span8">
			<label><b>Tag</b></label>
			<input type="text" id="psearch_tag" name="psearch_tag" value="{$arrParams.psearch_tag|default:''}" class="input-lg for-search"/>
		</div>
		<div class="span8">
			<label></label>
			<input type="submit" id="presearch" value="Search" class="input-lg for-search"/>
		</div>
		<input type="hidden"  value="{$scriptname}"/>
	</div>

</form>