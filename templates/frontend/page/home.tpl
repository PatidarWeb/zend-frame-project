<style>
    .info{
        width:100%;
        margin:20px auto;
        background-color:#EEF2F5;
        padding:15px;
        line-height:25px;

        -moz-border-radius: 12px;
        -webkit-border-radius: 12px;
        border-radius: 12px;
        -moz-background-clip: padding; -webkit-background-clip: padding-box; background-clip: padding-box; 
    }
    #documentation{
        float:left;
        width:47%;
    }
    #download{
        float:right;
        width:47%;
    }
</style>
<div class="info">
    <div id="documentation">
        <h2>Documentation</h2>
        <a href="http://www.dotkernel.com/docs/">www.dotkernel.com/docs</a>
        <br/>
        <a href="http://www.dotkernel.com/phpdoc/">www.dotkernel.com/phpdoc</a>
        <br/>
        <a href="http://v1.dotkernel.net/readme.txt">README.TXT</a>
    </div>
    <div id="download">
        <h2>Download latest version</h2>
        <a href="http://www.dotkernel.com/download/">www.dotkernel.com/download</a>
    </div>
    <div id="download">
        <h2>Coding Standard</h2>
        <a href="{SITE_URL}/page/coding-standard/">Sample Class</a>
    </div>
    <div class="clear"></div>
</div>

<h2>1. Special Controllers</h2>
<strong>Mobile: </strong><a href="{SITE_URL}/mobile/ ">Mobile</a><br/> 
<strong>Backend: </strong><a href="{SITE_URL}/admin/ ">Admin </a><br/> 
<strong>RSS: </strong><a href="{SITE_URL}/rss/ ">RSS </a><br/>
<strong>Console: </strong>Call this only from command line<br/> 
<p>
    Also the above controllers are <strong>reserved words</strong> so you cannot have an action called
    <strong>admin</strong> or <strong>rss</strong> in frontend
</p> 

<h2>2. URL Pattern</h2>
<p>
    <strong>The default module is frontend, so the URL's will be in the form:</strong><br/> 
    <em>/controller/action/var1/value-of-var1/var2/value-of-var2/</em>
    <br/><br/>
    <strong>and in the admin the URL's will be:</strong><br/>
    <em>/admin/controller/action/var1/value-of-var1/var2/value-of-var2/</em>
</p> 

<h2>3. Adding a new Controller</h2>
<p>
    To add a controller called Articles in the frontend, you need to add 3 files:
</p>
<ul>
    <li><strong>CONTROLLER</strong>: <em>controllers/frontend/articlesController.php</em> , which contains the switch</li>
    <li><strong>MODEL</strong>: <em>DotKernel/frontend/Articles.php</em>, which contains the class Articles</li>
    <li><strong>VIEW</strong>: <em>DotKernel/frontend/views/articlesView.php</em>, which contains the class Articles_View</li>
</ul>
<p>
    As well as the folder <em>templates/frontend/articles/</em> with the necessary template files.<br/>
    In config/router.xml, inside the &lt;controller&gt; tag, add: <strong>&lt;frontend&gt;Articles&lt;frontend&gt;</strong>
</p>

<h2>Admin Panel Log In</h2>
<strong>www.your-site.com/admin</strong><br/> 
username: admin<br/> 
password: dot<br/> 