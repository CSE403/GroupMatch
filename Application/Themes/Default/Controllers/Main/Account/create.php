<section>
    <header>
        <button class="green">Create</button>
        <input name="title" type="text" placeholder="Tile or Question"/>
    </header>
    <form name="create_poll" class="indent">
        <section>
            <h1>Universal Participant Limit</h1>
            <footer>
                <input name="option_all_limit" type="checkbox"/> Participant limit per answer <input name="option_all_limit_amount" type="number" placeholder="10" disabled="disabled">
            </footer>
        </section>
        <section>
            <h1>Answer type</h1>
            <footer>
                <div><input name="answer_type" type="radio" checked="checked"/> Yes / No</div>
                <div><input name="answer_type" type="radio"/> Yes / Neutral / No</div>
                <div><input name="answer_type" type="radio"/> Uniquely rate each option</div>
                <div><input name="answer_type" type="radio"/> Rate on scale between 1 and <input name="scale_max" type="number" placeholder="4" min="5" max="100" value="4" disabled="disabled"></div>
            </footer>
        </section>
        <section>
            <h1>Options / Unique Participant Limit</h1>
            <footer>
                <ul>
                    <li>
                        <input name="option_1" type="text" placeholder="Option"/>
                        <input name="option_1_limit" type="checkbox"/>
                        <input name="option_1_limit_amount" type="number" placeholder="10" min="1" disabled="disabled">
                    </li>
                    <li>
                        <input name="option_1" type="text" placeholder="Option"/>
                        <input name="option_1_limit" type="checkbox"/>
                        <input name="option_1_limit_amount" type="number" placeholder="10" min="1" disabled="disabled">
                    </li>
                    <li>
                        <input name="option_1" type="text" placeholder="Option"/>
                        <input name="option_1_limit" type="checkbox"/>
                        <input name="option_1_limit_amount" type="number" placeholder="10" min="1" disabled="disabled">
                    </li>
                    <li>
                        <input name="option_1" type="text" placeholder="Option"/>
                        <input name="option_1_limit" type="checkbox"/>
                        <input name="option_1_limit_amount" type="number" placeholder="10" min="1" disabled="disabled">
                    </li>
                    <li>
                        
                    </li>
                </ul>
                <button class="green">Add Answers</button>
            </footer>
        </section>
    </form>
</section>