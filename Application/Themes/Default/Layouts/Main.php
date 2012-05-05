<html>
    <head>
        <!-- jQuery -->  
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
        <?php 
        	echo $this->headScripts()->addScript("util"); 
        	echo $this->headStyles()->prependStyle("global")->prependStyle("reset"); 
        ?>
    </head>
    <body>
        <header id="top_bar">
            <h1>GroupMatch</h1>
            <nav>
                <?php
               		/*
               		 * A really terrible and UGLY hack to make the top bar dynamic
               		 */
                    $register = $GLOBALS["registry"]->utils->makeLink("Index", "register");
                    $about = $GLOBALS["registry"]->utils->makeLink("Index", "index");
                    $create = $GLOBALS["registry"]->utils->makeLink("Account", "create");
                    $polls = $GLOBALS["registry"]->utils->makeLink("Account", "index");
                    
                    if ($GLOBALS["page"] == "home") {
                    	$login_req = true;
                ?>
                    	<a class="selected">About</a>
                    	<a href="<?php echo $register; ?>">Create Account</a>
                <?php    
                    }else if ($GLOBALS["page"] == "register") {
                    	$login_req = true;
                ?>
                    	<a href="<?php echo $about; ?>">About</a>
                    	<a class="selected">Create Account</a>
                <?php
                    }else if ($GLOBALS["page"] == "myPolls") {
                    	$login_req = false;
                ?>
                    	<a href="<?php echo $about; ?>">About</a>
                    	<a class="selected">Polls</a>
                    	<a href="<?php echo $create; ?>">Create</a>
                <?php
                    }else if ($GLOBALS["page"] == "createPoll") {
                    	$login_req = false;
                ?>
                    	<a href="<?php echo $about; ?>">About</a>
                    	<a href="<?php echo $polls; ?>">Polls</a>
                    	<a class="selected">Create</a>
                <?php
                	}else if ($GLOBALS["page"] == "poll") {
                		$login_req = false;
               	?>
                		<a href="<?php echo $about; ?>">About</a>
                		<a href="<?php echo $polls; ?>">Polls</a>
                		<a href="<?php echo $create; ?>">Create</a>
                <?php
                	}else if ($GLOBALS["page"] == "solution") {
                		$login_req = false;
               	?>
                		<a href="<?php echo $about; ?>">About</a>
                		<a href="<?php echo $polls; ?>">Polls</a>
                		<a href="<?php echo $create; ?>">Create</a>
                <?php 
                	}else if ($GLOBALS["page"] == "participate") {
                		$login_req = false;
               	?>
                		<a href="<?php echo $about; ?>">About</a>
                		<a href="<?php echo $polls; ?>">Polls</a>
                		<a href="<?php echo $create; ?>">Create</a>
                <?php 
                	}
                ?>
            </nav>
            <?php 
            	$authClass = "logout";
            	if ($login_req) {
            		$authClass = "login";
            	}
            ?>
            <div class="auth_control <?php echo $authClass; ?>">
                <div class="divider"></div>
                <?php 
                	$loginLink = $GLOBALS["registry"]->utils->makeLink("Account");
                	if ($login_req) 
                	{
                ?>
                		<form name="login">
	                		<form name="login">
	                    	 <button class="icon green" onClick="">Login</button>
	                    	 <input name="email" type="email" placeholder="Email" required="required">
	                    	 <input name="password" type="password" placeholder="Password" required="required">
	                    	 <button onClick="location.href='<?php echo $loginLink; ?>'" class="green" type="submit">Login</button>
	                    	 <a href="">Forgot Password</a>
	                	</form>
	            <?php
                	}
                	else 
                	{
                ?>
                		<form name="logout">
                			<button onClick="location.href='<?php echo $about; ?>'" class="red" type="submit" name="logout">Logout</button>
						</form>
				<?php
                	}
                ?>
            </div>
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