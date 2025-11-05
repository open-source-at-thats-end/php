<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>Master Predefined Searches
				</span>
            </li>
        </ul>
    </div>
</div>
<h4>Search Filters</h4>
<hr/>
<div>
    {include file='predefined/predefined-search.tpl'}
</div>
<hr/>
<br>
<form id="frmStdForm" name="frmStdForm" action="" class="frmStdForm" method="post">
    {include file='master-predefined/master-predefined-list.tpl'}
</form>

<div id="pre-pagination">
    {include file='master-predefined/master-predefined-pagination.tpl'}
</div>