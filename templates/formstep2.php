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
                <option value="aries">Aries: March 21 – April 20</option>
                <option value="taurus">Taurus: April 21 – May 20</option>
                <option value="gemini">Gemini: May 21 – June 20</option>
                <option value="cancer">Cancer: June 21 – July 20</option>
                <option value="leo">Leo: July 21  – August 20</option>
                <option value="virgo">Virgo: August 21 – September 20</option>
                <option value="libra">Libra: September 21 – October 20</option>
                <option value="scorpio">Scorpio: October 21 – November 20</option>
                <option value="sagittarius">Sagittarius: November 21 – December 20</option>
                <option value="capricorn">Capricorn: December 21 – January 20</option>
                <option value="aquarius">Aquarius: January 21 – February 20</option>
                <option value="pisces">Pisces: February 21 – March 20</option>
            </select>
        </div>
    </fieldset>
</form>