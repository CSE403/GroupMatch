<!-- 
    index.php
    
    This php script depicts the ZFR of the users main account index (the front page). Displayed in this page
    are the polls that the user has created, as well as options to create new polls.
-->
<?php
    $pollPage = $GLOBALS["registry"]->utils->makeLink("Poll");
?>
<section>
	<header>
		<h1>Poll Management</h1>
	</header>
	<!-- 
        All polls that the user has created will be displayed here. Each poll item on the user's page
        gives the name of that poll and a link to the actual webpage of that poll, so the user can see
        who has used his poll, and to see the current solution.
    -->
	<section class="indent">
		<h2 id="no_polls_message" style="display:none;">You don't have any polls</h2>
		<ul id="poll_list">
			<li>
				<button class="red" name="delete_poll">Delete</button>
				<header><a href="<?= $pollPage ?>">When should our team meet?</a></header>
				<footer>www.groupmatch.com/poll/ogn3f0waf3lqvnlk230</footer>
			</li>
			<li>
				<button class="red" name="delete_poll">Delete</button>
				<header><a href="<?= $pollPage ?>">Group project preference</a></header>
				<footer>www.groupmatch.com/poll/sw3jkdvb3ek9uthj5</footer>
			</li>
			<li>
				<button class="red" name="delete_poll">Delete</button>
				<header><a href="<?= $pollPage ?>">Volunteer at the homeless shelter</a></header>
				<footer>www.groupmatch.com/poll/asw3v03u1u151208ndv</footer>
			</li>
		</ul>
	</section>
</section>

<section>
    <header>
        <!-- Link to creating new polls-->
        <?php
            $createLink = $GLOBALS["registry"]->utils->makeLink("Account", "create");
        ?>
        <h1><a href="<?= $createLink ?>">Create Poll</a></h1>
    </header>
</section>