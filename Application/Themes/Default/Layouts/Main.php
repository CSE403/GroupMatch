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