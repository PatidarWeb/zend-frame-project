<h3>Menu</h3>
<ul class="menu_sidebar">
        <!-- BEGIN sidebar_menu_1 -->
	<li class="">
		<a href="{SITE_URL}{PATH}" target="_self">{MENU_TITLE}</a> 
	</li>
        <!-- END sidebar_menu_1 -->
	<!-- BEGIN sidebar_menu_not_logged -->
	<li class="{SEL_USER_LOGIN}">
		<a href="{SITE_URL}/user/login">Log In</a>
	</li>
	<li class="{SEL_USER_REGISTER}">
		<a href="{SITE_URL}/user/register">Register</a>
	</li>
	<!-- END sidebar_menu_not_logged -->
	<!-- BEGIN sidebar_menu_logged -->
	<li class="{SEL_USER_ACCOUNT}">
		<a href="{SITE_URL}/user/account">My Account</a>
	</li>
	<li>
		<a href="{SITE_URL}/user/logout">Log Out</a>
	</li>
	<!-- END sidebar_menu_logged -->
</ul>