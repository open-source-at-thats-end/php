<table align="center" width="50%" border="0" cellspacing="5" cellpadding="0" style="margin-top: 10px;" align="center">
    <tr height="10">
        <td></td>
    </tr>
    <tr>
        <td colspan="2" style="color:#000; text-align:left; font-size:1em; font-weight:700">Dear <font color="#094B6B">Sir/Madam</font></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Request has been received for Home Plan Number# {$Record.hp_number}.</strong></td>
    </tr>
    <tr>
        <td width="44%">&nbsp;</td>
        <td width="56%">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><font color="#094B6B">User Details :</font></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Name :</strong></td>
        <td>{$frmData.lead_first_name|lower|ucwords} {$frmData.lead_last_name|lower|ucwords}</td>
    </tr>
    {if $frmData.lead_home_phone != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Phone :</strong></td>
            <td>{$frmData.lead_home_phone}</td>
        </tr>
    {/if}
    {if $frmData.lead_work_phone != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Work Phone :</strong></td>
            <td>{$frmData.lead_work_phone}</td>
        </tr>
    {/if}
    {if $frmData.lead_mobile != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Mobile :</strong></td>
            <td>{$frmData.lead_mobile}</td>
        </tr>
    {/if}
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Email :</strong></td>
        <td>{$frmData.lead_email}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Comments :</strong></td>
        <td>{$frmData.lead_comment|nl2br}</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td colspan="2"><font color="#094B6B">Apply Online Details :</font></td>
    </tr>
    {if $frmData.lead_income != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Income :</strong></td>
            <td>{$frmData.lead_income}</td>
        </tr>
    {/if}
    {if $frmData.lead_current_debit != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Current Debit :</strong></td>
            <td>{$frmData.lead_current_debit}</td>
        </tr>
    {/if}
    {if $frmData.lead_downpayment != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Down Payment :</strong></td>
            <td>{$frmData.lead_downpayment}</td>
        </tr>
    {/if}
    {if $frmData.lead_loandamount != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Loan Amount :</strong></td>
            <td>{$frmData.lead_loandamount}</td>
        </tr>
    {/if}
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td colspan="2"><font color="#094B6B">Property Details :</font></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Plan Name :</strong></td>
        <td>{$Record.hp_name} {$Record.hp_name|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Beds :</strong></td>
        <td>{$Record.hp_beds|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Baths :</strong></td>
        <td>{$Record.hp_baths|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Price :</strong></td>
        <td>{$currency}{$Record.ListPrice|number_format:0}</td>
    </tr>
    {*<tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Listing Agent :</strong></td>
        <td>{$Record.Agent_FullName|lower|ucwords}</td>
    </tr>*}
    <tr>
        <td width="44%">&nbsp;</td>
        <td width="56%">&nbsp;</td>
    </tr>

</table>