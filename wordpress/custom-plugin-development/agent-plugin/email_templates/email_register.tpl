<table width="100%" align="center" style="background: #fff;padding: 15px;width: 510px;">
	<tr>
		<td colspan="2">
			<div>
				<span>Hi {$frmData.user_first_name|capitalize}, </span>
			</div>
			<div style="padding-top: 10px;padding-bottom: 10px;">
				<p>
					We're here to help you have the best home buying experience possible. With years of experience and extensive local neighborhood knowledge, you're in good hands!
				</p>
				<p>Here are some of the benefits of having an account: </p>
				<ul>
					<li>Get new property email alerts</li>
					<li>Choose frequency of the emails (immediately, daily, weekly, monthly)</li>
					<li>Save multiple searches</li>
					<li>View all detailed property information and market reports</li>
					<li>Save favorite properties to track price changes</li>
					<li>Priority support to your questions</li>
				</ul>
				<div style="padding-bottom: 4px;">To manage your account settings, visit</div>
				<div>{$Host_Url} and sign-in using the following information:</div>

				<div style="padding-top: 20px;">
					<span><strong>Username: </strong>{if $user_email}{$user_email}{else}{$frmData.user_email}{/if}</span>
				</div>
				<div style="padding-top: 4px;">
					<span><strong>Password: </strong>{if $password }{$password}{/if}</span>
				</div>

				<p>
				If you have any questions at all, please do not hesitate to contact us.
				</p>
				<p>We look forward to earning your business!</p>
			</div>

			<div>
				<table width="100%">
					<tr>
						{*<td width="30%" class="td-responsive bg-color">
							{if isset($AgentInfo) && $AgentInfo['agent_photo'] != ''}
								<img src="{$AgentImgUrl}{$AgentInfo['agent_photo']}" alt="{$AgentInfo['agent_name']}" width="100%" style="box-shadow: 0 0 5px #d8d8d8;height: 170px;"/>
							{else}
								<img src="{$AgentImgUrl}agent-placeholder.jpg" alt="{$AgentInfo['agent_name']}" width="100%" style="box-shadow: 0 0 5px #d8d8d8;height: 170px;"/>
							{/if}
						</td>*}
						<td width="100%" valign="top" class="pd-sm-5 td-responsive" style="background-color: #ECECEC;">
							<table style="height:170px;padding-left:16px ;" width="100%">
								<tr>
									<td>
										<div>
											<strong>{$AgentInfo['agent_name']}</strong>
										</div>
										<div>{if isset($AgentInfo['agent_about']) && $AgentInfo['agent_about'] != ''}<span>{$AgentInfo['agent_about']}</span>{/if}</div>
										<div style="padding-top: 25px;">
											{if isset($AgentInfo['agent_email']) && $AgentInfo['agent_email'] != ''}<div>{$AgentInfo['agent_email']}</div>{/if}
											{if isset($AgentInfo['agent_phone']) && $AgentInfo['agent_phone'] != ''}<div>{$AgentInfo['agent_phone']}</div>{/if}
											{if isset($AgentInfo['agent_address']) && $AgentInfo['agent_address'] != ''}<div>{$AgentInfo['agent_address']}</div>{/if}
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div style="text-align: center;padding-top: 10px;">
				<span>We respect your privacy. </span><a href="{$login_url}">Manage your email preferences.</a>
			</div>
		</td>
	</tr>
</table>


