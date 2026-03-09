<!--Tabulka pro vytvoření pojištěného-->
<table>
    <tr>
        <th>Jméno</th>
        <th>Příjmení</th>
        <th>Předvolba</th>    <th>Telefon</th>
        <th>Datum narození</th>
        <th>Věk</th>
        <th>Akce</th>
    </tr>
    
    <?php 
    
    /*
     Cyklus foreach prochází pole $pojisteni
     Každá položka v poli je uložena do proměnné $osoba
     */
    foreach ($pojisteni as $osoba): ?>
    <tr>
        <!--Výpis jména s ochrannou proti XSS-->
        <td><?= htmlspecialchars($osoba->jmeno) ?></td>

        <!--Výpis příjmení-->
        <td><?= htmlspecialchars($osoba->prijmeni) ?></td>

        <!--Předvolba-->
        <td><?= htmlspecialchars($osoba->predvolba) ?> </td>

        <!--Výpis telefonu-->
        <td><?= htmlspecialchars($osoba->telefon) ?></td>

        <!--Výpis data narození-->
        <td><?= htmlspecialchars($osoba->datum_narozeni) ?></td>

        <!--Výpis věku poocí metody objektu-->
        <td><?= $osoba->vek() ?></td>

        <!--Akční tlačítka-->
        <td>

        <!--Odkaz pro úpravu záznamu-->
            <a href="?edit=<?= $osoba->id ?>" class="btn-upravit">
                Upravit
            </a>

        <!--Odkaz pro smazání záznamu s potvrzením-->  
            <a href="?delete=<?= $osoba->id ?>" 
                class="btn-smazat" onclick="return confirm('Opravdu smazat?')">
                Smazat
            </a>
        </td>
    </tr>
    <?php 
    
        // Konec cyklu foreach
        endforeach; 
    ?>
</table>









