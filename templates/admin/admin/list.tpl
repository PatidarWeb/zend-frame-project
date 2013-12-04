<script>
	var userToken = "{USERTOKEN}",
		SITE_URL = "{SITE_URL}",
		FLAG_TOGGLE_URL = SITE_URL + "/admin/admin/activate/";

	$(document).ready(function(){
		$(".activeButton").activeFlags({
			targetUrl:FLAG_TOGGLE_URL,
		});
	})
</script>
<div id="adminList">
	{PAGINATION}
	<fieldset>
	<legend>List Admins</legend>
	<table class="big_table">
		<thead>
			<tr>
				<th style="text-align: center; width: 20px;">#</th>
				<th>Username</th>
				<th>Email</th>
				<th><span>First name</span></th>
				<th>Last name</th>
				<th width="70px">Active</th>
				<th>Creation Date</th>
				<th width="230px">Action</th>
			</tr>
		</thead>
		<tbody>
		<!-- BEGIN list -->
			<tr>
				<td style="text-align: center;">{ID}</td>
				<td><a href="{SITE_URL}/admin/admin/update/id/{ID}">{USERNAME}</a></td>
				<td>{EMAIL}</td>
				<td>{FIRSTNAME}</td>
				<td>{LASTNAME}</td>
				<td style="vertical-align: middle;">
					 <a style="cursor: pointer;" title="Activate / Inactivate" class="{ACTIVE_IMG}_state activeButton"
					 	id="row_{ID}" data-id="{ID}" data-active="{ISACTIVE}">&nbsp;</a> </td>
				<td>{DATE_CREATED}</td>
				<td>
				<table  class="action_table">
					<tr>
						<td width="25%"><a href="{SITE_URL}/admin/admin/update/id/{ID}/" title="Edit/Update" class="edit_state">&nbsp;</a></td>
						<td width="25%"><a href="{SITE_URL}/admin/admin/delete/id/{ID}/" title="Delete" class="delete_state">&nbsp;</a></td>
						<td width="25%"><a href="{SITE_URL}/admin/admin/logins/id/{ID}/" title="User Logins" class="logins_state">&nbsp;</a></td>
					</tr>
				</table>
				</td>
			</tr>
		<!-- END list -->
		</tbody>
	</table>
	</fieldset>
</div>