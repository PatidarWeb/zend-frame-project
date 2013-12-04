<form action="{SITE_URL}/admin/menu/update/id/{IDMENU}" method="post" >
    <fieldset style="width: 500px">
        <legend>Edit Menu Item</legend>
        <table class="medium_table">
            <tr>
                <select name="type">
                    <option value="0">All Pages</option>
                    <option value="1">Select Page</option>
                    <option value="2">All Pages except Selected Pages</option>
                </select>
            </tr>
            <tr>
                <table>
                    
                    <tr>
                        <td>Top menu</td>
                    </tr>
                    <!-- BEGIN menu_top -->
                    <tr>
                        <td><input type="checkbox" value="{MENU_TITLE_1}" value="{MENU_TITLE}"/>{MENU_TITLE}</td>
                    </tr>
                    <!-- END menu_top -->
                    
                    <tr>
                        <td>Siderbar menu</td>
                    </tr>
                    <!-- BEGIN menu_left -->
                    <tr>
                        <td><input type="checkbox" value="{MENU_TITLE_2}" value="{MENU_TITLE}"/>{MENU_TITLE}</td>
                    </tr>
                    <!-- END menu_left -->
                    
                    <tr>
                        <td>Bottom menu</td>
                    </tr>
                    <!-- BEGIN menu_bottom -->
                    <tr>
                        <td><input type="checkbox" value="{MENU_TITLE_3}" value="{MENU_TITLE}"/>{MENU_TITLE}</td>
                    </tr>
                    <!-- END menu_bottom -->
                </table>
            </tr>
            <tr>
                <td><input type="submit" class="button" value="Save"></td>
            </tr>
        </table>
    </fieldset>
</form>
