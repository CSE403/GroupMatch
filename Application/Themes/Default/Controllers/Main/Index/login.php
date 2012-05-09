<!-- 
    Index/login.php
    
    This is the page for users logging in
-->
<section>
    <header>
        <h1>We just need a bit of information</h1>
    </header>
    <?php
        
        if (count($this->Errors)) {
    ?>
        <section class="form_error">
            <ul><?php
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
    <form name="login" action="" method="post" class="indent">
        <div><input name="email" type="email" placeholder="Email" required="required"/></div>
        <div><input name="password" type="password" placeholder="Password" required="required"/></div>
        <div><button class="green" type="submit">Login</button></div>
    </form>
</section>