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
		<h1><?php echo $this->Poll->question?></h1>
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
            <ul>
            <?php
                $solutionMap = $this->Solution->getSolutionMap();
                foreach($this->Poll->options as $option) {
                	if (count($solutionMap[$option->id]) > 0) {
            ?>   
	                <li>
	                	<h1><?php echo $option->name ?></h1>
	                    <table>
	                    	<thead>
	                    		<tr>
	                    			<th>Name</th>
	                    			<th>Happiness</th>
	                    		</tr>
	                    	</thead>
	                    	<tbody>
	                    		<?php
	                    		$counter = 0;
		                        foreach($solutionMap[$option->id] as $person)
		                        {
		                        	$classStr = "";
		                        	if ($counter % 2 == 0) {
		                        		$classStr = "alt";
		                        	}
		                        	$counter++;
								?>
		                             <tr class="<?php echo $classStr; ?>">
		                             	<td><?php echo $person->name ?></td>
		                             	<td class="center"><?php echo $this->Solution->answers[$option->id.",".$person->id]->priority ?></td>
		                             <tr>
		                             <?php
		                        }
		                        ?>
	                    	</tbody>
	                    </table>
	                </li>
	                <?php
	                }
              	}
            ?>
            </ul>
        </div>
        <?php 
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