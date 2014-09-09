<form id="formstep2" name="form_formstep2">
    <fieldset>
        <span id="prevstep" style="display:none;">formstep1</span>
        <span id="nextstep" style="display:none;">formstep3</span>
        <legend>Voievodeship</legend>
        <div class="fm-opt">
            <label for="fm-voievodeship">Voievodeship:</label>
            <select name='fm-voievodeship' id = 'fm-voievodeship'>
                <option  value=""></option>
                <?php foreach($options as $k=>$v){ ?>
                    <option <?php if($selected==$v) echo "selected"; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                <?php }?>
            </select>

        </div>
        <div class="fm-opt">
            <span id="selectbox" class="<?=$optionselect?>" style="display: none;"></span>
            <label>Birth Date:</label>
            <input style="width: auto;float: none;" name="fm-date" value="<?=$date?>" id="datetimepicker_mask"/>
        </div>
    </fieldset>
</form>
<script>
    $('#datetimepicker_mask').datetimepicker({
            timepicker:false,
            mask:true,
            format:'Y-m-d',
            showOn: 'both',
            buttonText: 'Choose a date',
            showButtonPanel: true,
            closeOnDateSelect: true
    });
</script>