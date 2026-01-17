<?php if (!empty($chyby)): ?>

    <!--Pokud existují chyby zobrazí se v tomto bloku-->

<div class="chyby">
    <?php 
        // Projedeme pole chyb a každou chybu vypíšeme
        foreach ($chyby as $chyba): 
    ?>
        <p><?= htmlspecialchars($chyba) ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!--Formulář pro přidání nebo úpravu pojistného-->
<form method="post" class="formular">

<!--CSRF ochrana-->
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <?php if ($upravovanaOsoba): ?>

<!--Pokud upravujeme existující osobu, pošleme její ID-->
        <input type="hidden" name="id" value="<?= $upravovanaOsoba->id ?>">
    <?php endif; ?>

<!--Řádek formuláře: Jméno a příjmení-->
    <div class="radek">
        <div class="sloupec">
            <input name="jmeno" placeholder="Jméno" value="<?= htmlspecialchars($upravovanaOsoba->jmeno ?? '') ?>" required>
        </div>
        <div class="sloupec">
            <input name="prijmeni" placeholder="Příjmení" value="<?= htmlspecialchars($upravovanaOsoba->prijmeni ?? '') ?>" required>
        </div>
    </div>

<!--Řádek formuláře: datum narození a telefon-->
    <div class="radek">
        <div class="sloupec">
            <input type="date" name="datum_narozeni" placeholder="Datum narození" id="datum_narozeni"
                   value="<?= htmlspecialchars($upravovanaOsoba->datum_narozeni ?? '') ?>" required>
        </div>
        <div class="sloupec">
            <input name="telefon" placeholder="Telefon" value="<?= htmlspecialchars($upravovanaOsoba->telefon ?? '') ?>" required>
        </div>
    </div>

<!--Místo pro dynamický věk-->
    <div class="radek">
        <div class="sloupec">
            <label>Věk: <span id="vek_display"><?= $upravovanaOsoba ? $upravovanaOsoba->vek() : '' ?></span></label>
        </div>
    </div>

    <button class="btn-maly"><?= $upravovanaOsoba ? 'Uložit změny' : 'Přidat pojištěného' ?></button>
</form>

<!-- JS pro zobrazení věku live -->
<script>
    // Input s datem narození 
    const datumInput = document.getElementById('datum_narozeni');

    // Místo kam se vypisuje věk
    const vekDisplay = document.getElementById('vek_display');

    // Reakce na změnu data narození 
    datumInput.addEventListener('change', () => {

        const dnes = new Date();            // Dnešní datum
        const narozeni = new Date(datumInput.value);        // Datum narození 
        
        // Pokud je datum platné 
        if (!isNaN(narozeni)) {

            // Výpočet věku
            let vek = dnes.getFullYear() - narozeni.getFullYear();

            // Kontrola zda letos proběhly narozeniny
            const m = dnes.getMonth() - narozeni.getMonth();
            if (m < 0 || (m === 0 && dnes.getDate() < narozeni.getDate())) {
                vek--;
            }

            // Zobrazení věku 
            vekDisplay.textContent = vek;
        } else {

        // Pokud datum není platné
            vekDisplay.textContent = '';
        }
    });
</script>




