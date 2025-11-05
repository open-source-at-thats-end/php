
<form id="FrmPre" method="post">

	<div class="row">
		<div class="span6">
			<label><b>Title</b></label>
			<input type="text" id="psearch_title" name="psearch_title" value="" class="input-lg for-search"/>
		</div>
		<div class="span8">
			<label><b>Tag</b></label>
			<input type="text" id="psearch_tag" name="psearch_tag" value="" class="input-lg for-search"/>
		</div>
		<div class="span8">
			<label></label>
			<input type="button" id="presearch" name="presearch" value="Search" class="input-lg for-search"/>
		</div>
		<input type="hidden" name="scriptname" value="{$scriptname}"/>
	</div>

</form>