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
    $telefon = trim($_POST['telefon']);
    $datum_narozeni = trim($_POST['datum_narozeni']);

    // validace
    if ($jmeno === '') $chyby[] = 'Jméno je povinné';
    if ($prijmeni === '') $chyby[] = 'Příjmení je povinné';
    if ($telefon === '') $chyby[] = 'Telefon je povinný';
    if ($datum_narozeni === '') $chyby[] = 'Datum narození je povinné';

    // Pokud nejsou chyby uloží se do db
    if (empty($chyby)) {
        if (!empty($_POST['id'])) {
            // Úprava pojištěného
            $kontroler->upravit((int)$_POST['id'], $jmeno, $prijmeni, $telefon, $datum_narozeni);
        } else {
            // Přidání pojiištěného
            $kontroler->pridat($jmeno, $prijmeni, $telefon, $datum_narozeni );
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

