<form id="formstep1" name="form_formstep1" >
<fieldset>
    <span id="prevstep" style="display:none;">formstep1</span>
    <span id="nextstep" style="display:none;">formstep2</span>
    <legend>Personal information</legend>
    <div class="fm-opt">
        <label for="fm-sex-male">Male:<input name="fm-sex" id="fm-sex-male" type="radio" value="male" <?=$checkedm?> /> </label>
        <label for="fm-sex-female">Female:<input name="fm-sex" id="fm-sex-female" type="radio" value="female" <?=$checkedf?> /> </label>
    </div>
    <div class="fm-opt">
      <label for="fm-firstname">Name:</label>
      <input name="fm-firstname" id="fm-firstname" type="text" value="<?=$firstname?>" />
    </div>
</fieldset>
</form>