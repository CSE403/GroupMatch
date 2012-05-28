<!-- 
    Poll/index.php
    
    This php webpage is for the actual poll. On this page, users can see who has already participated in the poll, 
    and those participant's responses as well as their own. If the poll is not closed, users can also add their response
    to the poll.
-->
<?php
    $content = $this->registry->config->siteUrl.$this->getThemeLocation()."Images/";
?>
<section>
    <header>
		<?php
			
			$link = $GLOBALS["registry"]->utils->makeLink("Poll","solution",$this->Poll->guid);
		?>
        <a class="nav_link inline_colorbox" href="#calculating_solution_message" data-href="<?php echo $link; ?>"><button class="green">View Solution</button></a>
        <h1><?php echo $this->Poll->question; ?></h1>
        <div style="display: none;">
	        <div id="calculating_solution_message" >
	        	<div>Determining solution</div>
	        	<img alt="loading gif" src="../../../Images/ajax-loader.gif">
	        </div>
        </div>
    </header>
    <table>
        <thead>
            <tr>
                <th></th>
                <?php
                    foreach($this->Poll->options as $option) {
                        ?>
                           <th><?php echo $option->name; ?></th>
                        <?php
                    }
					if($this->isOwner) {
					?>
						<th></th>
					<?php
					}
                ?>   				
            </tr>
        </thead>
        <!-- 
			Meter rules:
				width: between 0% and 99% (do not give a 100% width, it will overflow it's background)
				
				Setting width: 0%, will still leave a nub in the bar, this is due to the border.
				If you need positivly no color bar in the meter, set border: none.
				
				color: add color class to meter div:
					green:	67 - 100
					yellow:	33 - 67
					red:	< 33
		 -->
		 <!-- 
            Each participants answers will be stored here. On the page, it will be depicted as a row of (in this case)
            stars depicting how much the user want that option.
        -->
		<tbody>
        
            <?php
                // Used for zebra striping
                $counter = 0;
                
                foreach($this->Poll->participants as $participant) {
                    
                    $classStr = "";
                    if ($counter % 2 == 0) {
                        $classStr = ' class="alt"';
                    }
                    $counter++;
                    ?>
                    <tr <?php echo $classStr; ?>>
                        <td class="participant"><?php echo $participant->name; ?></td>
                        <?php
                            $divide = $this->Poll->isUnique == "true" ? count($this->Poll->options) : 5;
                            foreach($participant->answers as $answer) {
                                $percent = (int)(($answer->priority/$divide)*100);
                                
                                $color = "red";
                                if ($percent >= 67) {
                                    $color = "green";
                                }
                                elseif($percent >= 33) {
                                    $color = "yellow";
                                }
                                
                                ?>
                                <td>
                                    <div class="meter <?php echo $color; ?>">
                                        <div class="numeric_value"><?php echo $percent; ?></div>
                                        <div class="meter_background"><div class="meter_value" style="width: <?php echo max(0, $percent);?>"></div></div>
                                    </div>
                                </td>
                                <?php
                            }
                        ?>
						<?php 
							if($this->isOwner) {
								$link = $GLOBALS["registry"]->utils->makeLink("Poll","deleteParticipant");
						?>
							<td class="participant">
								<form action="<?php echo $link; ?>" method="post">
									<input name="guid" type="text" value="<?php echo $this->Poll->guid; ?>" style="display: none;" />
									<input name="personId" type="text" value="<?php echo $participant->id; ?>" style="display: none;" />
									<button type="submit" class="red">Delete</button>
								</form>
							</td>
						<?php 
							}
						?>
                    </tr>
                    <?php
                }
            ?>
		</tbody>
        <tfoot>
			<?php
				$link = $GLOBALS["registry"]->utils->makeLink("Poll","participate",$this->Poll->guid);
			?>
            <tr><td><a href="<?php echo $link; ?>"><button class="orange">Participate</button></a><td></tr>
        </tfoot>
    </table>
    <footer>
        <div class="fb-comment-frame"><div class="fb-comments" data-num-posts="5" data-width="550"></div></div>
    </footer>
</section>

