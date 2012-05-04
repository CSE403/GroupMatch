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
                    $register = $GLOBALS["registry"]->utils->makeLink("Index", "register");
                ?>
                <a class="selected">About</a>
                <a href="<?php echo $register ?>">Register</a>
            </nav>
            <div class="auth_control login">
                <div class="divider"></div>
                <form name="login">
                    <?php
                        $loginLink = $GLOBALS["registry"]->utils->makeLink("Account");
                    ?>
                    <button class="icon green" onClick="">Login</button>
                    <input name="email" type="email" placeholder="Email" required="required">
                    <input name="password" type="password" placeholder="Password" required="required">
                    <button onClick="location.href='<?= $loginLink ?>'" class="green" type="submit">Login</button>
                    <a href="">Forgot Password</a>
                </form>
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