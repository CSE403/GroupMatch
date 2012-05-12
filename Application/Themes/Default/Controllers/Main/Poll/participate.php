<!--
	Poll/participate.php
	
	This php webpage will pop up when the user navigates to it from a specific poll. 
	This page allows a user to interact with the poll by entering their preferences.
 -->
<?php
    $content = $this->registry->config->siteUrl.$this->getThemeLocation()."Images/";
?>

<div id="page_container">
	<div id="page_content">
		<section>
			<header>
				<h1><?php echo $this->Poll->question; ?></h1>
			</header>
			<section class="form_error">
				This is an error message
			</section>
			<form name="participate_form" class="indent">
				<section>
					<h1>Description</h1>
					<footer>
						<?php echo $this->Poll->description; ?>
					</footer>
				</section>
				<section>
					<h1>Directions go here</h1>
					<footer>
						<ul>
							<li>
								<header>
									<div>(Uniquely rate each) example</div>
								</header>
								<!-- max would be the polls number of options -->
								<input name="answer_3" type="number" min="1" max="4" required="required" placeholder="1" />
							</li>
							<li>
								<header>
									<div>(Rate on scale) example</div>
								</header>
								<!-- max would be the polls scale value -->
								<input name="answer_3" type="number" min="1" max="5" required="required" placeholder="1" />
							</li>
						</ul>
					</footer>
				</section>
				<?php
					$link = $GLOBALS["registry"]->utils->makeLink("Poll", "index");
				?>
				<a href="<?php echo $link; ?>"><button class="green">submit</button></a>
			</form>
		</section>
	</div>
	<footer>
		
	</footer>
</div>
