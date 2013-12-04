<form action="{SITE_URL}/admin/translation/update/id/{IDTRANSLATIONS}" method="post" >
<input type="hidden" name="userToken" value="{USERTOKEN}">
<fieldset style="width: 500px">
<legend>Update Translation</legend>
<table class="medium_table">
		<tr>
			<td width="148px"><b>Original String</b><span class="required">*</span></td>
			<td><input type="text" name="original_string" value="{ORIGINAL_STRING}"></td>
		</tr>
		<tr>
			<td><b>Translated String</b><span class="required">*</span></td>
			<td><input type="text" name="translated_string" value="{TRANSLATED_STRING}">
             </td>
		</tr>
		<tr>
			<td><b>Language</b><span class="required">*</span></td>
			<td>
				<select name="language" class="language" id="some_id">
					<option value="en-GB"  {EN-GB}  >English</option>
					<option value="de-DE" {DE-DE}  >German</option>
				</select>
            </td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" value="update">
			</td>
		</tr>
	</table>
</fieldset>
</form>
