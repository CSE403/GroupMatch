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
        <a href="<?php echo $siteURLvariable; ?>/poll/solution/3"><button class="green">View Solution</button></a>
        <h1>When should our team meet?</h1>
    </header>
    <table>
        <thead>
            <tr><th></th><th>Tuesday 4pm</th><th>Thursday 5pm</th><th>Saturday 1pm</th></tr>
        </thead>
        <tbody>
        <!-- 
            Each participants answers will be stored here. On the page, it will be depicted as a row of (in this case)
            stars depicting how much the user want that option.
        -->
            <tr class="alt">
                <td class="participant">Justin Ryll</td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/></td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/></td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/></td>
            </tr>
            <tr>
                <td class="participant">Hayden Jensen</td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/></td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/></td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/></td>
            </tr>
            <tr class="alt">
                <td class="participant">Eli White</td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/></td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/><img src="<?= $content?>star_empty_small.png" width="20" height="20"/></td>
                <td><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/><img src="<?= $content?>star_small.png" width="20" height="20"/></td>
            </tr>
        </tbody>
        <tfoot>
            <tr><td><a href="<?php echo $siteURLvariable; ?>/poll/participate/3"><button class="orange">Participate</button></a><td></tr>
        </tfoot>
    </table>
    
</section>