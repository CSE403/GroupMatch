<?php
    $pollPage = $GLOBALS["registry"]->utils->makeLink("Poll");
?>
<section>
    <header>
        <h1>Poll Management</h1>
    </header>
    <ul class="indent">
        <li>
            <button class="red">Delete</button>
            <header><a href="<?= $pollPage ?>">When should our team meet?</a></header>
            <footer>www.groupmatch.com/poll/ogn3f0waf3lqvnlk230</footer>
        </li>
        <li>
            <button class="red">Delete</button>
            <header><a href="<?= $pollPage ?>">Group project preference</a></header>
            <footer>www.groupmatch.com/poll/sw3jkdvb3ek9uthj5</footer>
        </li>
        <li>
            <button class="red">Delete</button>
            <header><a href="<?= $pollPage ?>">Volunteer at the homeless shelter</a></header>
            <footer>www.groupmatch.com/poll/asw3v03u1u151208ndv</footer>
        </li>
    </ul>
</section>
<section>
    <header>
        <?php
            $createLink = $GLOBALS["registry"]->utils->makeLink("Account", "create");
        ?>
        <h1><a href="<?= $createLink ?>">Create Poll</a></h1>
    </header>
</section>