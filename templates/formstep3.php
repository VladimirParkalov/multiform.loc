<form id="form_<?=$step?>" name="form_<?=$step?>">
    <fieldset>
        <legend>Email </legend>
        <div class="fm-opt">
            <label for="fm-email">Email field:</label>
            <input id="fm-email" name="fm-email" type="text" value="<?=$email?>"/>
        </div>
        <div class="fm-opt">
            <label for="fm-checkbox">Short agreement text and check box if the user accept: </label>
            <input id="fm-checkbox" name="fm-checkbox" type="checkbox" <?=$checkbox?>/>
        </div>
    </fieldset>
</form>
