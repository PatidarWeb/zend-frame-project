<form action="{SITE_URL}/admin/menu/update/id/{IDMENU}" method="post" >
    <fieldset style="width: 500px">
        <legend>Edit Menu Item</legend>
        <table class="medium_table">
            <tr>
                <td width="140px"><b>Title</b><span class="required">*</span></td>
                <td><input type="text" name="menu_title" value="{MENU_TITLE}"></td>
            </tr>
            <tr>
                <td><b>Alias</b></td>
                <td><input type="text" name="menu_alias" value="{MENU_ALIAS}" ></td>
            </tr>
            <tr>
                <td><b>Path</b></td>
                <td><input type="text" name="path" value="{PATH}" ></td>
            </tr>
            <tr>
                <td><b>Show on</b></td>
                <td>
                    <select name="menu_type">
                        <option value="1" {MENU_TYPE_1}>Top</option>
                        <option value="2" {MENU_TYPE_2}>Left</option>
                        <option value="3" {MENU_TYPE_3} >Bottom</option>
                    </select>
                </td>
                
            </tr>
            <tr>
                <td> </td>
                <td>
                    <input type="submit" class="button" value="update">
                </td>
            </tr>
        </table>
    </fieldset>
</form>
