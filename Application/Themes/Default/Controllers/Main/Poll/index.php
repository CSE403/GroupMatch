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
			$link = $GLOBALS["registry"]->utils->makeLink("Poll","solution","3");
		?>
        <a href="<?php echo $link; ?>"><button class="green">View Solution</button></a>
        <h1><?php echo $this->Poll->question; ?></h1>
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
                ?>            
            </tr>
        </thead>
        <!-- 
			Meter rules:
				width: between 0% and 99% (do not give a 100% width, it will overflow it's background)
				
				Setting width: 0%, will still leave a nub in the bar, this is due to the border.
				If you need positivly no color bar in the meter, set border: none.
				
				color: add color class to meter div:
					green:	60 - 100
					yellow:	35 - 60
					red:	< 35
		 -->
		 <!-- 
            Each participants answers will be stored here. On the page, it will be depicted as a row of (in this case)
            stars depicting how much the user want that option.
        -->
		<tbody>
			<tr class="alt">
				<td class="participant">Justin Ryll</td>
				<td>
					<div class="meter red">
						<div class="numeric_value">9</div>
						<div class="meter_background"><div class="meter_value" style="width: 8%;"></div></div>
					</div>
				</td>
				<td>
					<div class="meter yellow">
						<div class="numeric_value">44</div>
						<div class="meter_background"><div class="meter_value" style="width: 43%;"></div></div>
					</div>
				</td>
				<td>
					<div class="meter green">
						<div class="numeric_value">93</div>
						<div class="meter_background"><div class="meter_value" style="width: 92%;"></div></div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="participant">Hayden Jensen</td>
				<td>
					<div class="meter red">
						<div class="numeric_value">34</div>
						<div class="meter_background"><div class="meter_value" style="width: 33%;"></div></div>
					</div>
				</td>
				<td>
					<div class="meter green">
						<div class="numeric_value">61</div>
						<div class="meter_background"><div class="meter_value" style="width: 60%;"></div></div>
					</div>
				</td>
				<td>
					<div class="meter green">
						<div class="numeric_value">100</div>
						<div class="meter_background"><div class="meter_value" style="width: 99%;"></div></div>
					</div>
				</td>
			</tr>
			<tr class="alt">
				<td class="participant">Eli White</td>
				<td>
					<div class="meter yellow">
						<div class="numeric_value">52</div>
						<div class="meter_background"><div class="meter_value" style="width: 53%;"></div></div>
					</div>
				</td>
				<td>
					<div class="meter yellow">
						<div class="numeric_value">41</div>
						<div class="meter_background"><div class="meter_value" style="width: 40%;"></div></div>
					</div>
				</td>
				<td>
					<div class="meter green">
						<div class="numeric_value">88</div>
						<div class="meter_background"><div class="meter_value" style="width: 87%;"></div></div>
					</div>
				</td>
			</tr>
		</tbody>
        <tfoot>
			<?php
				$link = $GLOBALS["registry"]->utils->makeLink("Poll","participate",$this->Poll->id);
			?>
            <tr><td><a href="<?php echo $link; ?>"><button class="orange">Participate</button></a><td></tr>
        </tfoot>
    </table>
    
</section>