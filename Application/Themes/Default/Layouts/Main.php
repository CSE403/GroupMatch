<html>
    <head>
        <?php
    	    $content = $this->registry->config->siteUrl.$this->getThemeLocation()."Images/";
		?>
		<link rel="shortcut icon" href="<?php echo $content; ?>/favicon.png" />
		<title>Group Match</title>
        <!-- jQuery -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <?php 
        	echo $this->headStyles()->prependStyle("global")->prependStyle("reset")->prependStyle("colorbox"); 
        	echo $this->headScripts()->addScript("util"); 
        ?>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '    209157775870885', // App ID
              //channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });

            // Additional initialization code here
          };

          // Load the SDK Asynchronously
          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
        </script>
        <header id="top_bar">
            <h1>GroupMatch</h1>
            <?php echo $this->topBar()->render(); ?>
        </header>
        
        <div id="page_container">
            <div id="page_content">
                <?php
                echo $this->content() 
                ?>
            </div>
            <footer>
                
            </footer>
        </div>
    </body>
</html>