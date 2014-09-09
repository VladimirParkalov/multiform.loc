<form id="formstep3" name="form_formstep3">
    <fieldset>
        <span id="prevstep" style="display:none;">formstep2</span>
        <span id="nextstep" style="display:none;">getAllData</span>
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