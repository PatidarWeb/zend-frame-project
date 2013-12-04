<script>
    $(document).ready(function(){
        $('.visible input[type=checkbox]').attr('disabled','disabled');
        $('.visible select').change(function(){
            var typeVis = $('.visible select option:selected').val();
            if (typeVis == 1)
            {
                $('.visible input[type=checkbox]').attr('disabled','disabled');
                $('.visible input[type=checkbox]').attr('checked','checked');
            }
            if(typeVis == 2)
            {
                $('.visible input[type=checkbox]').removeAttr('disabled');
            }
            if(typeVis == 3)
            {
                $('.visible input[type=checkbox]').removeAttr('disabled');
                $('.visible input[type=checkbox]:checked').attr('data-type','1');
                $('.visible input[type=checkbox]:not(:checked)').attr('checked', 'checked');
                
                $('.visible input[type=checkbox]').each(function(){
                    var dataType = $(this).attr('data-type');
                    if (dataType == 1)
                    {
                        $(this).removeAttr('checked');
                    }
                })
                
            }
        });
    });
</script>
<form action="{SITE_URL}/admin/menu/add" method="post" >
    <fieldset style="width: 500px">
        <legend>Add Menu Item</legend>
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
                <td><b>Path</b><span class="required">*</span></td>
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
        </table>
    </fieldset>

    <fieldset style="width: 500px">
        <table class="medium_table visible">
            <tr>
                <td width="140px"><b>TYPE</b></td>
                <td>
                    <select name="type">
                        <option value="1">All Pages</option>
                        <option value="2">Select Page</option>
                        <option value="3">All Pages except Selected Pages</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>TOP MENU</b></td>
                <td>
                    <!-- BEGIN menu_top -->
                    <input type="checkbox" name="{NAME_1}" value="{VALUE_1}"/>{MENU_TITLE_1}<br>
                    <!-- END menu_top -->
                </td>
            </tr>
            <tr>
                <td><b>Sidebar</b></td>
                <td>
                    <!-- BEGIN menu_left -->
                    <input type="checkbox" name="{NAME_2}" value="{VALUE_2}"/>{MENU_TITLE_2}<br/>
                    <!-- END menu_left -->
                </td>
            </tr>
            <tr>
                <td><b>Sidebar</b></td>
                <td>
                    <!-- BEGIN menu_bottom -->
                    <input type="checkbox" name="{NAME_3}" value="{VALUE_3}"/>{MENU_TITLE_3}<br/>
                    <!-- END menu_bottom -->
                </td>   
            </tr>
            <tr>
                <td> </td>
                <td>
                    <input type="submit" class="button" value="Add">
                </td>
            </tr>
        </table>
    </fieldset>
</form>
