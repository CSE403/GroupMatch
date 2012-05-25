<!-- 
    index.php
    
    This php script depicts the ZFR of the users main account index (the front page). Displayed in this page
    are the polls that the user has created, as well as options to create new polls.
-->
<section>
	<header>
		<h1>Poll Management</h1>
		All created polls are listed below.  To create a new poll, click on the "Create" button above.
	</header>
	<!-- 
        All polls that the user has created will be displayed here. Each poll item on the user's page
        gives the name of that poll and a link to the actual webpage of that poll, so the user can see
        who has used his poll, and to see the current solution.
    -->
	<section class="indent">
        <?php
            if(!count($this->Polls)) {
        ?>
		<h2 id="no_polls_message">You don't have any polls</h2>
        <?php
            }
            else
            {
        ?>
		<ul id="poll_list">
            <?php
           	 	$deletePage = $GLOBALS["registry"]->utils->makeLink("Account", "delete");
                foreach($this->Polls as $poll) {
                    $pollPage = $GLOBALS["registry"]->utils->makeLink("Poll", "index", $poll->guid);
                 ?>
                 <li>
                    <form action="<?php echo $deletePage; ?>" method="post">
                    	<input type="text" name="guid" value="<?php echo $poll->guid; ?>" style="display:none;">
                    	<button type="submit" class="red" name="delete_poll">Delete</button>
                    </form>
                    <header><a href="<?php echo $pollPage ?>"><?php echo $poll->question?></a></header>
                    <footer><?php echo $pollPage?></footer>
                </li>
                 <?php   
                }
            ?>
		</ul>
        <?php
            }
        ?>
	</section>
</section>