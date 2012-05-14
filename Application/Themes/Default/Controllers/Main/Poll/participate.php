<!--
Poll/participate.php

This php webpage will pop up when the user navigates to it from a specific poll. 
This page allows a user to interact with the poll by entering their preferences.
-->
<?php
    $content = $this->registry->config->siteUrl.$this->getThemeLocation()."Images/";
?>

<div id="page_container">
    <div id="page_content">
        <section>
            <header>
                <h1><?php echo $this->Poll->question; ?></h1>
            </header>
            <!--<section class="form_error">
                This is an error message
            </section>-->
            <?php
                $link = $GLOBALS["registry"]->utils->makeLink("Poll", "participate", $this->Poll->guid);
            ?>
            <form action="<?php echo $link; ?>" method="post" name="participate_form" class="indent">
                <section>
                    <h1>Description</h1>
                    <footer>
                        <?php echo $this->Poll->description; ?>
                    </footer>
                </section>
                <section>
                    <h1>Your Name</h1>
                    <footer>
                        <input name="participant_name" type="text" placeholder="Name" required="required" />
                    </footer>
                </section>
                <section>
                    <h1>Poll Directions go here</h1>
                    <footer>
                        <ul>
                            <?php
                                foreach($this->Poll->options as $option) {
                                ?>
                                <li>
                                    <header>
                                        <div><?php echo $option->name; ?></div>
                                    </header>
                                    <?php
                                        if ($this->Poll->isUnique) {
                                        ?>
                                        <!-- max would be the polls number of options -->
                                            <input name="option_<?php echo $option->id; ?>" type="number" min="1" max="<?php echo count($this->Poll->options); ?>" required="required" placeholder="1" />
                                        <?php
                                        }   
                                        else
                                        {
                                        ?>
                                        <!-- max would be the polls scale value -->
                                            <input name="option_<?php echo $option->id; ?>" type="number" min="1" max="5" required="required" placeholder="1" />
                                        <?php
                                        }
                                    ?>
                                </li>
                                <?php
                                }
                            ?>  
                        </ul>
                    </footer>
                </section>
                <button type="submit" class="green">submit</button>
            </form>
        </section>
    </div>
    <footer>

    </footer>
</div>
