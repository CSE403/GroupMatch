<!-- 
    Index/register.php
    
    This php webpage is for users to register with the website. After users input their information, a user account
    will be created, and they will be redirected to their hompage.
-->
<section>
    <header>
        <h1>We just need a bit of information</h1>
    </header>
    <section class="form_error">
        This is an error message
    </section>
    <form name="register" class="indent">
        <div><input name="email" type="email" placeholder="Email" required="required"/></div>
        <div><input name="password" type="password" placeholder="Password" required="required"/></div>
        <div><input name="re_password" type="password" placeholder="Retype Password" required="required"/></div>
        <div><button class="green" type="submit">Create Account</button></div>
    </form>
</section>