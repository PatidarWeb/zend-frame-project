<div id="adminList">
    {PAGINATION}
    <fieldset style="width: 100%">
        <legend>List Users</legend>
        <table class="big_table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 20px;"><span>#</span></th>
                    <th><span>Title</span></th>
                    <th><span>Alias</span></th>
                    <th><span>Path</span></th>
                    <th><span>Show on</span></th>
                    <th width="300px"><span>Action</span></th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN list -->
                <tr>
                    <td style="text-align: center;">{ID}</td>
                    <td>{TITLE}</td>
                    <td>{ALIAS}</td>
                    <td>{PATH}</td>
                    <td>{SHOW_ON}</td>
                    <td>
                        <table class="action_table">
                            <tr>
                                <td width="15%"><a href="{SITE_URL}/admin/menu/update/id/{ID}/" title="Edit/Update" class="edit_state">&nbsp;</a></td>
                                <td width="15%"><a href="{SITE_URL}/admin/menu/delete/id/{ID}/" title="Delete" class="delete_state">&nbsp;</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- END list -->
            </tbody>
        </table>
    </fieldset>
</div>