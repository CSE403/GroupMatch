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
    $link = $GLOBALS["registry"]->utils->makeLink("Poll", "index");
?>
		<a href="<?php echo $link; ?>"><button class="green">Back to Poll</button></a>
		<h1>Poll title here</h1>
	</header>
	<section id="report" class="indent">
		<div id="happy_meter">
			<h1>Happiness</h1>         
			<div id="numeric_value"><?php echo $this->Solution->getHappiness();?>%</div>
			<div id="meter_background"><div id="meter_value"></div></div>
		</div>
		<div id="answer">Answer Here</div>
        <div>
            <ul>
            <?php
                $solutionMap = $this->Solution->getSolutionMap();
                foreach($this->Poll->options as $option) {
                 ?>   
                <li><strong><?php echo $option->name ?></strong>
                    <ul>
                        <?php
                
                        foreach($solutionMap[$option->id] as $person)
                        {
                             ?>
                             <li><?php echo $person->name ?>: Happiness <?php echo $this->Solution->answers[$option->id.",".$person->id]->priority ?></li>
                             <?php
                        }
                    
                        ?>
                    </ul>
                </li>
                <?php
                }
            ?>
            </ul>
        </div>
        <div>
        <h3>People not placed</h3>
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
	</section>
</section>