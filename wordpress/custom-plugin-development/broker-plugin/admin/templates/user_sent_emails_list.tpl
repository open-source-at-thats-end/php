<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                          <i class="mdi mdi-home"></i>
                        </span> Emails Sent ({$total_record|number_format:0})
                    </h3>
                </div>
                <div id="list-sent-emails" class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div>
                                        <a data-toggle="collapse" href="#UserSearchFilter" class="card-title fs-15- font-weight-bold text-primary">
                                            <i class="mdi mdi-chevron-down text-primary" style="font-size: 20px;"></i><i class="mdi mdi-account-outline text-primary" style="font-size: 20px;"></i>Filter All Emails
                                        </a>
                                    </div>
                                    <div id="UserSearchFilter" class="collapse">
                                        <hr/>
                                        <form id="FrmEmailSearch" action="" method="get">
                                            <input type="hidden" name="page" value="{$page}"/>
                                            <input type="hidden" name="action" value={$action}>
                                            <input type="hidden" name="userId" value={$userId}>
                                            <div class="form-group row">
                                                <div class="col-sm">
                                                    <label>Sent Date</label>
                                                    <input type="date" class="form-control" id="usearch_date" name="usearch_date" value="{$arrParams.usearch_date|default:''}" placeholder="">
                                                </div>
                                                <div class="col-sm">
                                                    <label>Subject</label>
                                                    <input type="text" class="form-control" id="usearch_subject" name="usearch_subject" value="{$arrParams.usearch_subject|default:''}" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="submit" id="usearch"  name="submit" value="Search" class="btn btn-gradient-primary font-weight-light">
                                                            <a href="{$scriptname}" type="button" value="" class="for-search btn">Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" value="{$scriptname}"/>
                                        </form>
                                    </div>
                                    <hr/>
                                    <table class="table table-hover c-table mt-3">
                                        <thead>
                                            <tr>
                                                <th class="text-primary">Sent</th>
                                                <th class="text-primary">To</th>
                                                <th class="text-primary">Opens</th>
                                                <th class="text-primary">Subject</th>
                                                <th class="text-primary"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if count($rsUser) > 0}
                                                {foreach $rsUser as $record}
                                                    <tr>
                                                        <td><p class="font-weight-bold mb-1">{$record.ldemail_datetime|date_format:'%m-%d-%Y'}</p><p class="mb-0 text-lowercase">{$record.ldemail_datetime|date_format:'%I:%M %p'}</p></td>
                                                        <td>{if $record.ldemail_to_name != ''}<p class="mb-1 text-lowercase"><i class="mdi mdi-shuffle-variant text-primary" style="font-size: 15px;"></i>{$record.ldemail_to_name}</p>{/if}<p class="font-weight-bold mb-0">{$record.ldemail_to_email|truncate:25:"..."}</p></td>
                                                        <td><p class="text-center border text-white bg-primary ml-2">{$record.ldemail_open_count}</p>{$record.ldemail_open_datetime|date_format:'%I:%M %p'}</td>
                                                        <td>
                                                            <a href="javaScript:void(0)" class="fs-15 font-weight-bold text-primary pop popup-modal-lg" data-toggle="#modal-lg-popup" data-value="" data-url="{$scriptname}&action=view_email_template&emailId={$record.ldemail_id}" data-type="Email_Template">
                                                                <i class="mdi mdi-magnify text-primary" style="font-size: 15px;"></i>{$record.ldemail_subject}
                                                            </a><br><br>
                                                            <i class="mdi mdi-arrow-top-left text-primary" style="font-size: 15px;"></i>Clicked Email Link {if $record.ldemail_open_datetime > 0} ({$record.ldemail_open_datetime|date_format:'%I:%M %p'}) {/if} </td>
                                                        <td>
                                                            {if (isset($record.ldemail_user_ref_id) && $record.ldemail_user_ref_id != '') || (isset($record.ldemail_user_id) && $record.ldemail_user_id != '') }
                                                                <a href="{$MainUrl}&action=user_profile&user_id={if $record.ldemail_user_ref_id != ''}{$record.ldemail_user_ref_id}{else}{$record.ldemail_user_id}{/if}" class="fs-15 font-weight-bold text-primary" target="_blank"><i class="mdi mdi-account card-title font-weight-bold text-primary"></i>Profile</a>
                                                            {else}
                                                                <i class="mdi mdi-account card-title font-weight-bold text-primary"></i>Profile
                                                            {/if}
                                                        </td>
                                                    </tr>
                                                {/foreach}
                                            {else}
                                                <tr class="alt"><td class="text-center" colspan="12">No Data Found.</td></tr>
                                            {/if}
                                        </tbody>
                                    </table>
                                    {if count($rsUser) > 0}
                                        <hr/>
                                        <div class="btn-group float-left" role="group" aria-label="Basic example">
                                            <span class="card-title- font-weight-bold">Showing {$startRecord+1} to {if $total_record <= $page_size || $totalFetched < $page_size}{$total_record}{else}{$startRecord+$page_size}{/if} of {$total_record} entries</span>
                                        </div>
                                        <div class="btn-group float-right" role="group" aria-label="Basic example">
                                            {if $total_record >= $page_size}
                                                {html_pager_responsive_loopt num_items=$total_record per_page=$page_size start_item=$startRecord add_prevnext_text=true}
                                            {/if}
                                        </div>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-50 email-modal" id="modal-lg-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>