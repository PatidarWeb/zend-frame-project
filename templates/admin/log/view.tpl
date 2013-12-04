<div id="adminList">
    {PAGINATION}
    <fieldset style="width: 100%">
        <legend>List Users</legend>
        <table class="big_table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 20px;"><span>#</span></th>
                    <th><span>User</span></th>
                    <th><span>Activity</span></th>
                    <th><span>Description</span></th>
                    <th><span>Activity Time</span></th>
                    <th width="300px"><span>Action</span></th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN list_log -->
                <tr>
                    <td style="text-align: center;">{IDACTIVITY_LOG}</td>
                    <td>{USER_LOG}</td>
                    <td>{ACTIVITY}</td>
                    <td>{ACTIVITY_DESCRIPTION}</td>
                    <td>{ACTIVE_TIME}</td>
                    <td>
                        <table class="action_table">
                            <tr>
                                <td width="15%"><a href="{SITE_URL}/admin/log/delete/id/{IDACTIVITY_LOG}/" title="Delete" class="delete_state">&nbsp;</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- END list_log -->
            </tbody>
        </table>
    </fieldset>
</div>