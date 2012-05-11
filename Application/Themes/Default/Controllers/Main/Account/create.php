<!-- 
    account/create.php
    
    This webpage php script depicts the page that was linked from the user's homepage to create new polls.
    In this page, the user can specify different options for this poll, including the options users will have
    to choose from, as well as other details like specific option group limit.
-->

<?php
    $createPage = $GLOBALS["registry"]->utils->makeLink("Account", "create");
?>

<section>
	<header>
		<div><h1>Title</h1></div>
		<button form="create_poll" type="submit" class="green">Create</button>
		<input form="create_poll" name="title" type="text" placeholder="Tile or Question"/>
	</header>
	<section class="form_error">
		This is an error message
	</section>
	<form action="<?php echo $createPage; ?>" method="post" name="create_poll" class="indent">
		<section>
			<h1>Description</h1>
			<footer>
				<textarea rows="3" cols="50" maxlength="300" placeholder="Type a description here"></textarea>
			</footer>
		</section>
		<section>
			<!--
                Specify overall how many people can use the poll before it is closed,
                based on the amount of answers you give them.
            -->
			<h1>Universal Participant Limit</h1>
			<footer>
				<input name="option_all_limit" type="checkbox" /> Participant limit per answer <input name="option_all_limit_amount" type="number" placeholder="10" min="1" disabled="disabled">
			</footer>
		</section>
		<section>
			<!--Specify how users of the poll will give his or her answers to your options.-->
			<h1>Answer type</h1>
			<footer>
				<div><input name="answer_type" type="radio" value="1" checked="checked" /> Yes / No</div>
				<div><input name="answer_type" type="radio" value="2" /> Yes / Neutral / No</div>
				<div><input name="answer_type" type="radio" value="3" /> Uniquely rate each option</div>
				<div><input name="answer_type" type="radio" value="4" /> Rate on scale between 1 and <input name="scale_max" type="number" placeholder="4" min="4" max="100" value="4" disabled="disabled" /></div>
			</footer>
		</section>
		<section>
			<!-- The options that the user will create will be displayed here.-->
			<h1>Options / Unique Participant Limit</h1>
			<footer>
				<ul id="option_list">
					<li>
						<input name="option_1" type="text" placeholder="Option" />
						<input name="option_limit_1" type="checkbox" />
						<input name="option_limit_amount_1" type="number" placeholder="10" min="1" disabled="disabled" />
					</li>
					<li>
						<input name="option_2" type="text" placeholder="Option" />
						<input name="option_limit_2" type="checkbox" />
						<input name="option_limit_amount_2" type="number" placeholder="10" min="1" disabled="disabled" />
					</li>
					<li>
						<input name="option_3" type="text" placeholder="Option" />
						<input name="option_limit_3" type="checkbox" />
						<input name="option_limit_amount_3" type="number" placeholder="10" min="1" disabled="disabled" />
					</li>
					<li>
						<input name="option_4" type="text" placeholder="Option" />
						<input name="option_limit_4" type="checkbox" />
						<input name="option_limit_amount_4" type="number" placeholder="10" min="1" disabled="disabled" />
					</li>
					<li>
						<input name="option_5" type="text" placeholder="Option" />
						<input name="option_limit_5" type="checkbox" />
						<input name="option_limit_amount_5" type="number" placeholder="10" min="1" disabled="disabled" />
					</li>
				</ul>
				<button name="add_more_options" class="green">Add Answers</button><!--This button allows the user to add additional options to the poll-->
			</footer>
		</section>
        
        <button type="submit" class="green">Create</button>
	</form>
</section>