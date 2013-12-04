<script>
	var userToken = "{USERTOKEN}",
		SITE_URL = "{SITE_URL}",
		FLAG_TOGGLE_URL = SITE_URL + "/admin/user/activate/";

	$(document).ready(function(){
		$(".activeButton").activeFlags({
			targetUrl:FLAG_TOGGLE_URL,
		});
	})
</script>
<div id="adminList">
	{PAGINATION}
	<fieldset style="width: 100%">
	<legend>List Translation</legend>
	<table class="big_table">
		<thead>
			<tr>
				<th style="text-align: center; width: 20px;"><span>#</span></th>
				<th><span>Original String</span></th>
				<th><span>Transalated String</span></th>
				<th><span>Language</span></th>
				<th width="300px"><span>Action</span></th>
			</tr>
		</thead>
		<tbody>
		<!-- BEGIN list -->
			<tr>
				<td style="text-align: center;">{ID}</td>
				<td><a href="{SITE_URL}/admin/translation/update/id/{ID}">{OSTRING}</a> </td>
				<td>{TSTRING}</td>
				<td>
					 {LANGUAGE} 
				</td>
				<td>
					<table class="action_table">
						<tr>
							<td width="25%"><a href="{SITE_URL}/admin/translation/update/id/{ID}/" title="Edit/Update" class="edit_state">&nbsp;</a></td>
						<td width="25%"><a href="{SITE_URL}/admin/translation/delete/id/{ID}/" title="Delete" class="delete_state">&nbsp;</a></td>
						</tr>
					</table>
				</td>
			</tr>
		<!-- END list -->
		</tbody>
	</table>
	</fieldset>
</div>