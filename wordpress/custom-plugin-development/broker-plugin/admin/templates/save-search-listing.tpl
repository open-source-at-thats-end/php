<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> All Save Search
                    </h3>
                    {*<nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle" title="Manage All User Information"></i>
                            </li>
                        </ul>
                    </nav>*}
                </div>
                {if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
                {if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            {*<form id="frmStdForm" name="frmStdForm" action="" method="post">*}
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-content-center">
                                    <span class="card-title font-weight-bold">{$total_record|number_format:0} Save Search Count</span>
                                    {*<div>
                                        {if $page == 'lpt-user'}
                                            <a href="javaScript:void(0)" id="add-contacts" class="card-title font-weight-bold text-primary pop popup-modal-sm" data-toggle="#modal-sm-popup" data-value="" data-url="{$scriptname}&action=add" data-type="Contacts" *}{*data-target="#add_modal"*}{*><i class="mdi mdi-account card-title font-weight-bold text-primary"></i> Add New</a> &nbsp;&nbsp;
                                        {/if}
                                    </div>*}
                                </div>
                                <br/>

                                <form id="frmStdForm" name="frmStdForm" action="{$scriptname}" method="get">

                                    <table width="100%" class="table" id="show-user-saved-search">
                                        <thead>
                                        <tr class="">
                                            {*<th width="1%">#</th>*}
                                            <th class="text-primary font-weight-bold">Search Title</th>
                                            <th class="text-primary font-weight-bold">Search Criteria</th>
                                            <th class="text-primary font-weight-bold">Action<br/>
                                        </tr>
                                        </thead>
                                        <tbody class="search_list">
                                        {include file='saved_searches_row.tpl'}
                                        </tbody>
                                    </table>
                                    {if empty($arrListing)}
                                        {else}

                                        <hr/>
                                        <div class="btn-group float-left" role="group" aria-label="Basic example">
                                            <span class="card-title- font-weight-bold">Showing {$startRecord+1} to {if $total_record <= $page_size || $totalFetched < $page_size}{$total_record}{else}{$startRecord+$page_size}{/if} of {$total_record} entries</span>
                                            {*<span class="card-title- font-weight-bold">Showing {$startRecord+1} to {if $total_record <= $page_size || $totalFetched < $page_size}{$total_record}{else}{$startRecord+$page_size}{/if} of {$total_record} entries</span>*}
                                            {*{html_pager_text num_items=$total_record per_page=$smarty.session.page_size start_item=$smarty.session.start_record}*}
                                        </div>
                                        {*<div class="btn-group float-right" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-secondary direction-btn">Previous</a>
                                            <a class="btn btn-gradient-primary page-num">1</a>
                                            <a class="btn btn-outline-secondary direction-btn">Next</a>
                                        </div>*}
                                        <div  class="btn-group float-right" role="group" aria-label="Basic example">
                                            {*{if $arrCount >= $page_size}
                                                {html_pager_responsive_loopt num_items=$arrCount per_page=$page_size start_item=$startRecord add_prevnext_text=true}
                                            {/if}*}
                                            {if $total_record >= $page_size}
                                                {html_pager_responsive_loopt num_items=$total_record per_page=$page_size start_item=$startRecord add_prevnext_text=true}
                                            {/if}
                                        </div>
                                    {/if}
                                </form>
                            </div>
                            {*</form>*}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{*{if $totalFetched >= $page_size}
	<div class="vlist-footer" id="list-pagination">
		<div class="navbar">
			<div class="navbar-inner">
				<div class=" pull-left" >
					<div class="pagination-text">
						<label>Items: <span class="footertalabitems">{$total_record} row(s) / {$totalFetched} total result(s) (on {$totalFetched} items)</span></label>
					</div>

				</div>
				<div class="pull-right" >
					<div class="pagination pagination-mini">
						<ul class=''>
							{html_pager2 num_items=$totalFetched per_page=$page_size add_prevnext_text=true start_item=$startRecord}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
{/if}*}
<div class="modal fade" id="modal-sm-popup" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){

            jQuery('#page_size').on('change',function () {
                jQuery('#frmStdForm').submit();
            })
        });
        function CDelete_Click(frm,search_id, msg)
        {
            if(confirm(msg ? msg : 'Are you sure you want to delete this record?'))
            {
                window.location = frm+'&action=delete_save_search&search_id='+search_id
            }
        }
    </script>
{/literal}