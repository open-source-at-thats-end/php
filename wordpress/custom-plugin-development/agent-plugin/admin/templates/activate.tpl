
<h2>Preferences</h2>
<hr>
{if $msgError}<div class="alert alert-danger">{$msgError}<button class="close" data-dismiss="alert" type="button">X</button></div>{/if}
<form id="frmSettings" action="" method="post" enctype="multipart/form-data">
    <div class="tab-content">
        <div id="tab-option" class="active tab-pane well wellmedpadd">
            <div class="hbhPlansImage">
                <h3>Activate the Plugin</h3>
                <div>
                    <div class="row">
                        <div class="span6">
                            <label><strong>Key Code</strong></label>
                            <input type="text" id="agent_key_code" name="agent_key_code" value="" class="span6 required" required/>
                            <label class="error" for="agent_key_code">Enter Your Key Code For Activate The Plugin</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-success" value="Update" name="Submit" />
    </div>
</form>
