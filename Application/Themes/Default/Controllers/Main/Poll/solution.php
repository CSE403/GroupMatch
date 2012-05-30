<!-- 
    Poll/solution.php
    
    This php webpage will pop up when the user navigates to it from a specific poll. Given that poll, 
    and its user responses, this page will display the "most optimal" group assignments, as well as 
    the "happiness meter", which sums up how well this assignment met all users wants for their group
    assignments.
-->
<section>
	<header>
<?php
    $link = $GLOBALS["registry"]->utils->makeLink("Poll", "index", $this->Poll->guid);
?>
		<a class="nav_link" href="<?php echo $link; ?>"><button class="green">Back to Poll</button></a>
		<h1><?php echo $this->Poll->question; ?></h1>
	</header>
    
    <?php
    if ($this->NoParticipants)
    {
        ?>
             <section>
                There are no participants for this poll.
             </section>
        <?php
    }
    else
    {
    ?>
    
	<section id="report" class="indent">
		<?php $happinessPercent =  $this->Solution->getHappiness();?>
		<div id="happy_meter">
			<h1>Group Happiness</h1>    
			<p>This figure represents the happiness of everyone in the poll, including people not placed in a category.</p>
			<div id="numeric_value"><?php echo round($happinessPercent);?>%</div>
			<div id="meter_background"><div id="meter_value" style="width: <?php echo ($happinessPercent * 99.8/100); ?>%"></div></div>
		</div>
        <div id="answer">
            <table>
                <thead>
                    <tr>
            <?php
                $solutionMap = $this->Solution->getSolutionMap();
                $divide = $this->Poll->isUnique == "true" ? count($this->Poll->options) : 5;
                
                foreach($this->Poll->options as $option) {
                    ?>
                        <th><?php echo $option->name; ?></th>
                    <?php
                }
                ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $biggestPoll = 1;
                    // Go through all the people in each poll
                    // keep going until the biggest poll has no people left
                    // This is our row (person number)
                    for($i = 0; $i < $biggestPoll; $i++)
                    {
                        ?>
                        <tr>
                        <?php
                        // Lets go through all of our columns
                        foreach($this->Poll->options as $option)
                        {
                            // Lets see if there should be someone in this cell
                            
                            $people = array_keys($solutionMap[$option->id]);
                            if ($i == 0) {
                                // if we are on the first iteration, we need to figure
                                // out what the biggest option is.
                                $biggestPoll = max($biggestPoll, count($people));
                            }
                            
                            if (isset($solutionMap[$option->id][$i])) {
                                $person = $solutionMap[$option->id][$i];
                                $percent = (int)(($this->Solution->answers[$option->id.",".$person->id]->priority/$divide)*100);
                                
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
                                            <div class="numeric_value"><?php echo $person->name ?> </div>
                                            <div class="meter_background"><div class="meter_value" style="width: <?php echo max(0, $percent);?>"></div></div>
                                        </div>
                                    </td>
                                <?php
                            }
                            else
                            {
                                ?>
                                     <td></td>
                                <?php
                            }
                        }
                        ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        //die(var_dump($biggestPoll)); 
        if (count($this->Solution->getPeopleNotPlaced()) > 0) {
        ?>
	        <div id="not_placed">
	        <h1>People not placed</h1>
	            <ul>
	            <?php 
	              foreach($this->Solution->getPeopleNotPlaced() as $person) {
	                  ?>
	                  <li><?php echo $person->name?></li>
	                  <?php
	              }
	            ?>
	            </ul>
	        </div>
	    <?php 
        }
	    ?>
	</section>
    <?php
    }
    ?>
</section>