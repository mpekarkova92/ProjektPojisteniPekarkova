<?php
// Načtení databáze a modelu
require_once __DIR__ . '/../konfigurace/Databaze.php';
require_once __DIR__ . '/../modely/Pojisteny.php';

// Kontroler pro práci s pojištěnými (CRUD)
class PojistenyKontroler {

    // PDO připojení k databázi 
    private PDO $db;

    // Konstruktor - naváže spojení s databází
    public function __construct() {
        $this->db = Databaze::pripojit();
    }

    // Vrátí seznam všech pojištených
    public function vsechny(): array {
        $dotaz = $this->db->query("SELECT * FROM pojisteni ORDER BY prijmeni");
        $data = $dotaz->fetchAll();
        $seznam = [];
    
        // Každá řádek s db převedeme na objekt Pojisteny
        foreach ($data as $radek) {
            $seznam[] = new Pojisteny($radek['id'], 
            $radek['jmeno'], 
            $radek['prijmeni'], 
            $radek['telefon'], 
            $radek['datum_narozeni']
            );
        }

        return $seznam;
    }

    // Přidání nového pojištěného 
    public function pridat(
        string $jmeno, 
        string $prijmeni, 
        string $telefon, 
        string $datum_narozeni
        ): void {
            $dotaz = $this->db->prepare(
                "INSERT INTO pojisteni(jmeno, prijmeni, telefon, datum_narozeni) 
                VALUES (:jmeno,:prijmeni,:telefon,:datum_narozeni)"
            );

            // Bezpečné dosazení hodnot
            $dotaz->execute([
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'telefon' => $telefon,
            'datum_narozeni' => $datum_narozeni
            ]);
        }

    // Úprava pojištěného
    public function upravit(
        int $id, 
        string $jmeno, 
        string $prijmeni, 
        string $telefon, 
        string $datum_narozeni
    ): void {
        $dotaz = $this->db->prepare(
           "UPDATE pojisteni 
            SET jmeno=:jmeno, 
                prijmeni=:prijmeni, 
                telefon=:telefon, 
                datum_narozeni=:datum_narozeni 
            WHERE id=:id"
        );

        $dotaz->execute([
            'id' => $id,
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'telefon' => $telefon,
            'datum_narozeni' => $datum_narozeni
        ]);
    }

    // Smazání pojištěného podle ID
    public function smazat(int $id): void {
        $dotaz = $this->db->prepare(
            "DELETE FROM pojisteni WHERE id=:id"
        );
        
        $dotaz->execute(['id' => $id]);
    
    }

    // Najde pojištěného podle ID
    public function najdiPodleId(int $id): ?Pojisteny {
        $dotaz = $this->db->prepare(
            "SELECT * FROM pojisteni WHERE id=:id"
        );
        
        // Spustí připrvaneý SQL dotaz a dosadí hodnotu $id do parametru :id (dotaz je bezpečný proti SQL injekcím)
        $dotaz->execute(['id'=>$id]);

        // Načte první řádek jako asociativní pole, pokud neexistuje, vrátí false
        $data = $dotaz->fetch();
        
        //Pokud záznam neexistuje, tak vrátí null
        if (!$data) 
            return null;
        
        
        // Vytvoření objektu Pojištěný z db dat
        return new Pojisteny(
            $data['id'], 
            $data['jmeno'], 
            $data['prijmeni'], 
            $data['telefon'], 
            $data['datum_narozeni']
        );
    }
}



