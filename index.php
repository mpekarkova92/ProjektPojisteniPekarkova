<?php
session_start();
// Spuštění session (pro udržení dat mezi stránkami a CSRF token)

// CSRF ochrana
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Načtení kontroleru pro pojistěné
require_once 'kontrolery/PojistenyKontroler.php';
$kontroler = new PojistenyKontroler();

// Proměnné pro pohled (formulář, seznam)
$chyby = [];                // Ukládání chyb
$upravovanaOsoba = null;    

// Zpracování POST (odeslaný formulář)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ověření CSRF 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Neplatný CSRF token');
    }

    // Získání a ořezání dat z formuláře
    $jmeno = trim($_POST['jmeno']);
    $prijmeni = trim($_POST['prijmeni']);
    $predvolba = trim($_POST['predvolba']);
    $telefon = trim($_POST['telefon']);
    $datum_narozeni = trim($_POST['datum_narozeni']);

    // validace 
    if ($jmeno === '') {
        $chyby[] = 'Jméno je povinné';
    } elseif (mb_strlen($jmeno) > 50) {
        $chyby[] = 'Jméno je příliš dlouhé (maximálně 50 znaků).';
    }
        
    if ($prijmeni === '') {
        $chyby[] = 'Příjmení je povinné';
    } elseif (mb_strlen($jmeno) > 50) {
        $chyby[] = 'Příjmení je příliš dlouhé (maximálně 50 znaků).';
    }

    // Validace telefonu
    $cisteCislo = str_replace(' ', '', $telefon); // Odstraní mezery 

    if ($telefon === '') {
        $chyby[] = 'Telefon je povinný';
    } elseif (!preg_match('/^\+?[0-9]+( [0-9]+)*$/', $telefon)) {
        $chyby[] = 'Telefonní číslo má špatný formát (plus patří na začátek, nepoužívejte vícenásobné mezery)';
    } elseif (mb_strlen($cisteCislo) < 9 || mb_strlen($cisteCislo) > 15) {
        $chyby[] = 'Telefonní číslo musí mít alespoň 9 až 15 čísel (bez mezer).';
    }

    // Validace data narození
    if ($datum_narozeni === '') {
        $chyby[] = 'Datum narození je povinné';
    } else {
        // Vytvoříme si dnešní datum ve formátu ROK, MĚSÍC, DEN (stejně jako to posílá formulář)
        $dnesniDatum = date('Y-m-d');
        $maxDatum = '1900-01-01'; // Limit rok 1880

        // Datum nesmí být následující
        if ($datum_narozeni > $dnesniDatum) {
            $chyby[] = 'Datum narození nesmí být v budoucnosti.';
        } elseif ($datum_narozeni < $maxDatum) {
            $chyby[] = 'Zadané datum narození je příliš staré.'; 
        }
    }
        
    
    
    // Pokud nejsou chyby uloží se do db
    if (empty($chyby)) {
        if (!empty($_POST['id'])) {
            // Úprava pojištěného
            $kontroler->upravit((int)$_POST['id'], $jmeno, $prijmeni, $predvolba, $telefon, $datum_narozeni);
        } else {
            // Přidání pojiištěného
            $kontroler->pridat($jmeno, $prijmeni, $predvolba, $telefon, $datum_narozeni );
        }
        // Přesměrování zpět na hlavní stránku
        header("Location: index.php");
        exit;
    }
}

// Zpracování GET (editace)
if (isset($_GET['edit'])) {
    $upravovanaOsoba = $kontroler->najdiPodleId((int)$_GET['edit']);
}
// Zpracování GET (mazání)
if (isset($_GET['delete'])) {
    $kontroler->smazat((int)$_GET['delete']);
    header("Location: index.php");
    exit;
}

// Načtení seznamu pojištěných pro zobrazení 
$pojisteni = $kontroler->vsechny();

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Evidence pojištěných</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Evidence pojištěných</h1>
    <!--Zahrnutí formuláře-->
<?php require 'pohledy/Formular.php'; ?>
    <!--Zahrnutí seznamu pojištěných-->
<?php require 'pohledy/Seznam.php'; ?>

</body>
</html>

