<br>
<br>
<br>
<form action="#"
      id="kontakt">
    <input class="a" type="radio"
           id="male"
           name="gender"
           value="male"> <label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
    <input class="a" type="radio"
           id="female"
           name="gender"
           value="female"> <label
            for="female">Female</label>&nbsp;&nbsp;&nbsp;&nbsp;
    <input class="a" type="radio"
           id="other"
           name="gender"
           value="other"> <label for="other">Other</label>
    <br>
    <br>
    <br>
    <label class="a" for="fname">Dein Vorname (erforderlich)</label>
    <input class="a" type="text"
           id="fname"
           name="firstname"
           placeholder="Dein Vorname.."
           required="">
    <br>
    <br>
    <label class="a" for="lname">Dein Nachname (erforderlich)</label>
    <input class="a" type="text"
           id="lname"
           name="lastname"
           placeholder="Dein Nachname.."
           required="">
    <br>
    <br>
    <label class="a" for="email">Deine E-Mail (erforderlich)</label>
    <input class="a" type="email"
           id="email"
           name="email"
           required="">
    <br>
    <br>
    <label class="a" for="Themenbereich">Bitte w&auml;hle einen Themenbereich (erforderlich)</label>
    <select class="a" id="Themenbereich"
            name="Themenbereich">
        <option value="none">
            -
        </option>
        <option value="Adress-Change">
            &Auml;nderung der Lieferadresse
        </option>
        <option value="Versand">
            Fragen zum Versand
        </option>
        <option value="Shop-Producten">
            Fragen zum Shop-Producten
        </option>
        <option value="Bezahlarten">
            Fragen zu den Bezahlarten
        </option>
        <option value="Besch&auml;digte-Ware">
            Besch&auml;digte Ware erhaten
        </option>
        <option value="Sonstiges">
            Sonstiges
        </option>
    </select>
    <br>
    <br>
    <label class="a" for="Betreff">Betreff</label>

    <input type="text" class="a"
           id="Betreff">
    <br>
    <br>
    <label for="Nachricht">Deine Nachricht</label>

    <textarea style="resize: none" class="b"
              id="Nachricht"></textarea>
    <br>
    <br>
    <input class="a" type="reset"
           value="Reset">
    <br>
    <input class="a" type="submit"
           value="Submit">
    <br>
    <br>
</form>