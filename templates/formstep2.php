<form id="form_<?=$step?>" name="form_<?=$step?>">
    <fieldset>
        <legend>Voievodeship</legend>
        <div class="fm-opt">
            <label for="fm-voievodeship">Voievodeship:</label>
            <input id="fm-voievodeship" name="fm-voievodeship" type="text" value="<?=$voievodeship?>"/>
        </div>
        <div class="fm-opt">
            <span id="selectbox" class="<?=$optionselect?>" style="display: none;"></span>
            <label>Birth Date:</label>
            <select name='fm-date' id = 'fm-date'>
                <option  value=""></option>
                <?php foreach($options as $k=>$v){ ?>
                    <option <?php if($selected==$k) echo "selected"; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php }?>
            </select>
        </div>
    </fieldset>
</form>