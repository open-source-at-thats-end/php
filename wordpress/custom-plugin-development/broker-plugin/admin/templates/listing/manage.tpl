<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav apm_nav">
            <li>
				<span class="topmodultitle">
					<i class="icon2 icon2-listings"></i>MLS Listings
				</span>
            </li>
        </ul>
    </div>
</div>
<div id="col-container">
    <div id="vmanage">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                    Search Filters
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse show">
                <form id="frmlistingSearch" class="frmlistingSearch advanced-search search" action="" method="post" enctype="multipart/form-data">
                    <div class="accordion-inner">
                        {include file='search_form.tpl'}
                        <div class="fright">
                            <p class="result-count aright">
                                <a href="JavaScript: void(0);" onclick="JavaScript: return getListing();" class="match button"><i class="fa fa-filter fa-lg"></i>&nbsp;<b>{$total_record|number_format:'0'} MATCHES</b></a>
                                <input type="hidden" name="Action" value="{$Action}">
                                <button type="submit" name="ShowAll" value="Show All" class=" button" ><b>Show All</b></button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="msg_box">{if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}</div>
        {*<div class="navbar">
            <div class="navbar-inner navbar-list-head">

            </div>
        </div>*}
        <form class="navbar-form pull-right- px-10">
            <label class="sortbyName">Sort By</label>
            <select name="sort_by">
                {html_options options=$arrSortBy}
            </select>
        </form>

        <div> {include file='listing/list.tpl'} </div>
    </div>
</div>