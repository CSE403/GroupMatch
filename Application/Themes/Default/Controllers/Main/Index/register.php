<!-- 
    Index/register.php
    
    This php webpage is for users to register with the website. After users input their information, a user account
    will be created, and they will be redirected to their hompage.
-->
<section>
    <header>
        <h1>We just need a bit of information</h1>
    </header>
		
        <?php
			
			if(count($this->Errors) > 0) {
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
	
    <form name="register" action="" method="post" class="indent">
        <div><input name="email" type="email" placeholder="Email" required="required"/></div>
        <div><input name="password" type="password" placeholder="Password" required="required" pattern=".{<?php echo $this->pw_min_len; ?>,}"/></div>
        <div><input name="re_password" type="password" placeholder="Retype Password" required="required" pattern=".{<?php echo $this->pw_min_len; ?>,}"/></div>
        <div><button class="green" type="submit">Create Account</button></div>
    </form>
	<div style="padding:5px;">(Note: Passwords must be at least 6 characters long.)</div>
</section>