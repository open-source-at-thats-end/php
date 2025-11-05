<div class="main-panel" id="email_listing_save-search">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                          <i class="mdi mdi-home"></i>
                        </span> Email Save Search Listings
            </h3>
        </div>
        {if isset($msgSuccess) || isset($msgError)}
            {if $msgSuccess}<div class="alert alert-success">{$msgSuccess}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
            {else}
                <div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">&times;</span></button></div>
            {/if}
        {/if}
        <div class="col grid-margin stretch-card">
            <div class="card">
                <legend class="card-title">Email Template</legend>
                    <div class="card-body card-border">
                        <form class="forms-sample" action="" method="post" name="email_form" id="email_form">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email To</label>
                                <div class="col-sm-10">
                                    {*<input type="text" class="form-control" id="email" name="email" placeholder="Email">*}
                                    {$profile['lead_email']}
                                   {* test.1.thatsend@gmail.com*}
                                    <input type="hidden" name="email" id="email" value="{$profile['lead_email']}" class="form-control"  placeholder="Email">
                                  {*  <input type="hidden" name="email" id="email" value="test.1.thatsend@gmail.com" class="form-control"  placeholder="Email">*}
                                </div>
                                <div class="col-sm-9">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email_subject" class="col-sm-2 col-form-label">Subject</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email_subject" name="email_subject" placeholder="Email Subject" required>
                                    <br />
                                   {* {constant("Constants::EMAIL_SUBJECT_HELP_TEXT")}*}
                                    {($smarty.const.EMAIL_SUBJECT_HELP_TEXT)}
                                    <br />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Include Default Header/Footer ?</label>
                                <div class="col-sm-1">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="header_footer" id="header_footer" value="Yes" checked=""> Yes <i class="input-helper"></i></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="header_footer" id="header_footer" value="No"> No <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="email_content"class="col-2 col-form-label">Contents:</label>
                                <div class="col-10 email_content">
                                    {* {wp_editor( 'Hi,its content', 'email_content')}*}
                                    {wp_editor( '<table align="center" border="0" cellpadding="0" cellspacing="0" class="full">
                                                        <tbody>
                                                                <tr>
                                                                    <td height="35">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="mobile" style="background-color: #ffffff;  width: 500px;  border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;padding:10px;" width="100%">
                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="2">[[listing]]</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="full">
                                                            <tbody>
                                                                <tr>
                                                                    <td height="35">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>','email_content')}

                                </div>

                            </div>
                            <button type="submit" class="btn btn-gradient-primary mr-2" value="Send"  name="Submit" >Send</button>
                            <button class="btn btn-light" type="button" onclick="JavaScript: window.location='{$scriptname}';">Cancel</button>
                        </form>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>
</div>
