{*{assign var=ab value= wp_editor( $distribution, 'distribution', array( 'theme_advanced_buttons1' => 'bold, italic, ul, pH, pH_min', 'media_buttons' => true, 'textarea_rows' => 8, 'tabindex' => 4 ) )
}*}
{*<style>
    #email-popup .wp-core-ui{
        color: #b66dff;
        border-color: #b66dff;
        background: #f6f7f7;
        vertical-align: top;
    }
    .wp-core-ui .button, .wp-core-ui .button-secondary .bg-main-hover{
        color: #b66dff;
        border-color: #b66dff;
        background: #f6f7f7;
        vertical-align: top;

    }
</style>*}

<div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                          <i class="mdi mdi-home"></i>
                        </span> Lead Profile
                    </h3>
                </div>
                {if isset($msgSuccess) || isset($msgError)}
                    {if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
                    {else}
                        <div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
                    {/if}
                {/if}
                <div class="row">
                    <div class="col-7 grid-margin stretch-card">
                        <div class="card pt-5">
                            <div class="d-flex card-title font-weight-bold">
                                <div class="mr-auto card-title">{$profile['lead_first_name']} {$profile['lead_last_name']} {*<i class="mdi mdi-lead-pencil text-primary" style="font-size: 20px;"></i>*}</div>
                                <div class="card-title">Last Activity: <span class="card-title text-primary">2 days ago</span></div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold border-bottom">Details</h5>
                                <p class="card-text"><b>Phone:</b>&nbsp; {$profile['lead_mobile']}</p>
                                <p class="card-text"><b>Email:</b>&nbsp; {$profile['lead_email']}</p>
                                <p class="card-text"><b>Lead Type:</b>&nbsp; {$profile['lead_type']}</p>
                                <p class="card-text"><b>Timeframe:</b>&nbsp; {$profile['lead_time_frame']}</p>
                                <p class="card-text"><b>Source:</b>&nbsp; {$profile['lead_source']}</p>
                                <p class="card-text"><b>Location:</b>&nbsp; {$profile['lead_ip_address']}</p>
                                <p class="card-text"><b>Landing Page:</b>&nbsp; </p>
                                <p class="card-text"><b>Date Registered:</b>&nbsp; {$profile['lead_created_date']|date_format}</p>
                                <p class="fs-15"><b>Tags:</b>&nbsp; {$profile['lead_subs']}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 grid-margin stretch-card">
                        <div class="card pt-5">
                            <div class="d-flex">
                                {*{if (isset($profile.lead_ref_id) && $profile.lead_ref_id != '') || (isset($profile.lead_ref_id) && $profile.lead_ref_id != '') }*}
                                <div>
                                    <a href="{$MainUrl}&action=save_search{if $profile.lead_ref_id != ''}&user_ref_id={$profile.lead_ref_id}{else}&user_id={$profile.lead_user_id }{/if}">
                                   {* <a href="{$MainUrl}&action=save_search{if $profile.lead_ref_id != ''}&user_ref_id={$profile.lead_ref_id}{else}&user_id={$profile.lead_user_id }{/if}">*}
                                        <button type="button" class="btn btn-gradient-primary font-weight-bold-">+ MLS Search</button>
                                    </a></div>
                                {*{/if}*}
                                <div class="px-2"><a href="{$MainUrl}&action=send_lead_info&user_id={$profile['lead_user_id']}"></a>
                                    {if isset($profile['lead_email'])  != ''}
                                    <i class="mdi mdi-email-outline text-primary"  data-toggle="modal" data-target="#email_modal" style="font-size: 30px;"></i></div>
                                    {/if}

                                <div class="px-2">
                                    <a href="{$MainUrl}&action=save_search_listing&user_id={$profile['lead_user_id']}">
                                        <i class="mdi mdi-cash-usd text-primary" style="font-size: 30px;"></i>
                                    </a>

                                </div>
                                {*<div class="px-2"><i class="mdi mdi-eye text-primary" style="font-size: 30px;"></i></div>*}
                            </div>

                            <div class="card-body">
                                <h5 class="card-title font-weight-bold border-bottom">Insights</h5>
                                {if isset($stats['price']) && $stats['price'] !== ''} <div class="fs-15 font-weight-bold mb-1">Price:&nbsp; <strong class="fs-15">{$stats['price']|number_format}</strong></div>{/if}
                                {if isset($stats['ptype_max']) && $stats['ptype_max'] !== '' || isset($stats['ptype_per']) && $stats['ptype_per'] !== ''}<div class="fs-15 font-weight-bold mb-1">Property Type:&nbsp;<span class="fs-15 font-weight-light">{$stats['ptype_max']}</span><strong><sup>{$stats['ptype_per']}%</sup></strong></div>{/if}
                                {if isset($stats['city_max']) && $stats['city_max'] !== '' || isset($stats['city_per']) && $stats['city_per'] !== ''}<div class="fs-15 font-weight-bold mb-1">Area:&nbsp; <span class="fs-15 font-weight-light">{$stats['city_max']}</span><strong><sup>{$stats['city_per']}%</sup></strong></div>{/if}
                                {if isset($stats['zip_max']) && $stats['zip_max'] !== '' || isset($stats['zip_per']) && $stats['zip_per'] !== ''}<div class="fs-15 font-weight-bold mb-1">Zip Code:&nbsp; <span class="fs-15 font-weight-light">{$stats['zip_max']}</span><strong><sup>{$stats['zip_per']}%</sup></strong></div>{/if}
                                {if isset($stats['lead_mobile']) && $stats['lead_mobile'] !== ''} <div class="fs-15 font-weight-bold mb-1">Properties Viewed:&nbsp; <span class="fs-15 font-weight-light">{$profile['lead_mobile']}</span></div>{/if}
                                {if isset($stats['lead_mobile']) && $stats['lead_mobile'] !== ''} <div class="fs-15 font-weight-bold mb-1">Properties Saved:&nbsp; <span class="fs-15 font-weight-light">{$profile['lead_mobile']}</span></div>{/if}
                                {if isset($stats['lead_mobile']) && $stats['lead_mobile'] !== ''} <div class="fs-15 font-weight-bold mb-1">Saved Searches:&nbsp; <span class="fs-15 font-weight-light">{$profile['lead_mobile']}</span></div>{/if}
                                {if isset($stats['lead_mobile']) && $stats['lead_mobile'] !== ''} <div class="fs-15 font-weight-bold mb-1">Emails Sent:&nbsp; <span class="fs-15 font-weight-light">{$profile['lead_mobile']}</span></div>{/if}
                                {if isset($stats['lead_mobile']) && $stats['lead_mobile'] !== ''}<div class="fs-15 font-weight-bold mb-1">Emails Opened:&nbsp; <span class="fs-15 font-weight-light">{$profile['lead_mobile']}</span></div>{/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal hide fade" id="email_modal" tabindex="-1" role="dialog" aria-labelledby="send_email" aria-hidden="true" style="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="send_email" style="font-size: 20px">Send Email</h5>
                {*    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>*}
            </div>
            <div class="modal-body" id="modal-body">
                {if isset($msgSuccess) || isset($msgError)}
                    {if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
                    {else}
                        <div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
                    {/if}
                {/if}
                <legend  class="card-title font-weight-bold">Email Information</legend>
                <div class="card-body col-12 card-border">
                    <form class="forms-sample" method="post" action="{$MainUrl}&action=send_email{if $profile.lead_ref_id != ''}&user_ref_id={$profile.lead_ref_id}{else}&user_id={$profile.lead_user_id }{/if}">
                        <div class="form-group row">
                            <label for="lead_email"  class="col-sm-3 col-form-label"> To Email:</label>
                            <div class="col-sm-9">
                                {$profile['lead_email']}
                                <input type="hidden" name="lead_email" value="{$profile['lead_email']}" class="form-control" id="lead_email" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_subject" class="col-sm-3 col-form-label">Mail Subject:</label>
                            <div class="col-sm-9">
                                <input type="text"  name="email_subject" class="form-control" id="email_subject" placeholder="Email Subject" required>
                                <br />
                                {$smarty.const.EMAIL_SUBJECT_HELP_TEXT}
                                <br />
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="email_content" name="email_content" class="col-sm-3 col-form-label">Contents:</label>
                            <div class="col-sm-9 email_content">
                                {wp_editor( '', 'email_content')}
                            </div>
                        </div>
                        {*<div class="mb-2" *}{*style="color: #b66dff;border-color: #b66dff;background: #f6f7f7;vertical-align: top;"*}{*>
                                                                *}{*{wp_editor( $distribution, 'distribution',
                                                                array( 'theme_advanced_buttons1' => 'bold, italic, ul, pH, pH_min',
                                                                  "media_buttons" => true, "textarea_rows" => 8, "tabindex" => 4 ) )}*}{*
                                                                *}{*{wp_editor('','content')}*}{*
                                                                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Contents:</label>
                                                                {wp_editor( 'Hi,its content', 'desired_id_of_textarea')}
                                                            </div>*}

                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                        <button class="btn btn-light" type="button" onclick="JavaScript: window.location='{$scriptname}';">Cancel</button>
                    </form>
                </div>
            </div>
            {*<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>*}
        </div>
    </div>
</div>
