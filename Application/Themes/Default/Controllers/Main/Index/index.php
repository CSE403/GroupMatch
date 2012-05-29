<!-- 
    Index/index.php
    
    This php webpage is for the front page of the overall website. It gives an explanation as to why we exist, and why 
    you should use our webpage.
    
    Users that have already logged in will have this frontpage replaced with their homepage the next time they come to 
    the website.
-->
<?php 
	$content = $this->registry->config->siteUrl.$this->getThemeLocation()."Images/";
?>
<section>
    <header>
        <h1>What is GroupMatch?</h1>
    </header>
    <div id="about">
    	<div class="section_frame">
	    	<div id="section_1_side"></div>
	    	<section id="section_1">
	    		<img src="<?php echo $content; ?>section1_anim.gif"><p>This is you.  You have to manage groups of people, fitting their preferences to fulfill your requirements and schedule.</p> 
	    	</section>
	    	<div id="section_1_bottom"></div>
    	</div>
    	<div class="section_frame">
	    	<div id="section_2_side"></div>
	    	<section id="section_2">
	    		<img src="<?php echo $content; ?>section2_anim.gif"><p>It's not easy to ensure that your needs are met, while trying to please everyone.</p> 
	    	</section>
	    	<div id="section_2_bottom"></div>
    	</div>
    	<div class="section_frame">
	    	<div id="section_3_side"></div>
	    	<section id="section_3">
	    		 <img src="<?php echo $content; ?>section3_anim.gif"><p>You're a progressive problem solver and your time is valuable.  So you use <span class="title">GroupMatch</span> to poll your group members and allow our <span class="em">tricky maths</span> and <span class="em">algorithmic wizardry</span> to determine the best way to fulfill your needs while making sure participant preferences are accomodated as well as possible.</p>
	    	</section>
	    	<div id="section_3_bottom"></div>
    	</div>
    	<div class="section_frame">
    		<div id="section_4_side"></div>
    		<section id="section_4">
    			<img src="<?php echo $content; ?>section4_anim.gif"><p>By letting <span class="title">GroupMatch</span> fit your group together, you can focus on what people should be doing and not having to waste time balancing your person resource. That makes you smart, super-hero smart.  Be a hero, try <span class="title">GroupMatch</span> today!</p>
    		</section>
    	</div>
    </div>
</section> 