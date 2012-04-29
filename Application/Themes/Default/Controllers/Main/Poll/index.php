<?php
    $content = $this->registry->config->siteUrl.$this->getThemeLocation()."Images/";
?>

<section>
    <header>
        <button class="green">View Solution</button>
        <h1>When should our team meet?</h1>
    </header>
    <table>
        <thead>
            <tr><th></th><th>Tuesday 4pm</th><th>Thursday 5pm</th><th>Saturday 1pm</th></tr>
        </thead>
        <tbody>
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
            <tr><td><button class="orange">Participate</button><td></tr>
        </tfoot>
    </table>
    
</section>