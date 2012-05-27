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
			
            <?php
				if (count($this->Errors) > 0) {
			?>
				<section class="form_error">
					<ul>
					<?php
						 foreach($this->Errors as $error) {
							 ?>
								  <li><?php echo $error; ?></li>
							 <?php
						 }
					?>
					</ul>
				</section>
			<?php   
				}
			?>
			
            <?php
                $link = $GLOBALS["registry"]->utils->makeLink("Poll", "participate", $this->Poll->guid);
            ?>
            <form action="<?php echo $link; ?>" method="post" name="participate_form" class="indent">
				<input type="hidden" name="isUnique" id="isUnique" value="<?php echo ($this->Poll->isUnique == "true" ? 1 : 0); ?>">
					<section>
						<h1>Description</h1>
						<footer>
							<?php
								if(!empty($this->Poll->description)) {
									echo $this->Poll->description . "<br>";
								}
							?>
							<b>DO NOT ENTER ANY PERSONAL INFORMATION INTO THE POLL.  ALL POLLS ARE PUBLICLY VISIBLE.</b>
						</footer>
					</section>
                <section>
                    <h1>Your Name</h1>
                    <footer>
                        <input name="participant_name" type="text" placeholder="Name" required="required" />
                    </footer>
                </section>
                <section>
					<?php 
						$instructions = "";
						if($this->Poll->isUnique == "true") {
							$instructions = "Rate each of following on a scale from 1 to " . count($this->Poll->options)
												. ", giving each option a unique score.  In other words, do not give any two options the same score.";
						} else {
							$instructions = "Please rate each of the following on a scale from 1 to 5.";
						}
					?>
                    <h1>Your Response</h1>
                    <div id="instructions"><?php echo $instructions; ?> The higher the rating, the better the score.</div>
                    <footer>
                        <ul>
                            <?php
                                foreach($this->Poll->options as $option) {
                                ?>
                                <li>
                                    <header>
                                        <div><?php echo $option->name; ?></div>
                                    </header>
                                    <?php
                                        if ($this->Poll->isUnique == "true") {
                                        ?>
                                        <!-- max would be the polls number of options -->
                                            <input name="option_<?php echo $option->id; ?>" type="number" min="1" max="<?php echo count($this->Poll->options); ?>" required="required" placeholder="1" />
                                        <?php
                                        }   
                                        else
                                        {
                                        ?>
                                        <!-- max would be the polls scale value -->
                                            <input name="option_<?php echo $option->id; ?>" type="number" min="1" max="5" required="required" placeholder="1" />
                                        <?php
                                        }
                                    ?>
                                </li>
                                <?php
                                }
                            ?>  
                        </ul>
                    </footer>
                </section>
                <button type="submit" class="green">submit</button>
            </form>
        </section>
    </div>
    <footer>

    </footer>
</div>
