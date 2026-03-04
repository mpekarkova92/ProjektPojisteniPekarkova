<?php
/*
    Třída Databaze slouží k vytvoření a připojení k databázi
    Používá se staticky, nemusí se vytvářet instance třídy
*/
class Databaze {

    // Statická proměnná, ve které si budeme pamatovat PDO spojení
    private static ?PDO $spojeni = null;

    // Statická metoda pro připojení k databázi, vrací objekt PDO
    public static function pripojit(): PDO {

        // Pokud neexistuje připojení, vytvoříme ho
        if (self::$spojeni === null) {

            // Vytvoření nového PDO připojení
            self::$spojeni = new PDO(
                "mysql:host=localhost;dbname=pojisteni;charset=utf8mb4",

                // Uživatelské jméno k databázi
                "root",

                // Heslo k databázi (zde prázdné)
                "",

                // Nastavení PDO
                [
                    // Chyby se budou zobrazovat jako vyjímky
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                    // Data se budou vracet jako asociativní pole
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        // Vrátí existující nebo nově vytvořené připojení
        return self::$spojeni;
    }
}



