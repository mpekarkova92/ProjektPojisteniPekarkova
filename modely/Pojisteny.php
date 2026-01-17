<?php

// Model pojištěného
class Pojisteny {

// Vlastnosti objektu
    public int $id;                 // Unikátní ID
    public string $jmeno;           // Jméno
    public string $prijmeni;        // Příjmení
    public string $telefon;         // Telefon
    public string $datum_narozeni;  // Datum narození (YYY-MM-DD)

    // Konstruktor, nastaví vlastnosti objektu při jeho vytvoření
    public function __construct(int $id, string $jmeno, string $prijmeni, string $telefon, string $datum_narozeni) {
        $this->id = $id;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->telefon = $telefon;
        $this->datum_narozeni = $datum_narozeni;
    }
    
    // Metoda pro výpočet věku
    public function vek(): int {
        $narozeni = new DateTime($this->datum_narozeni);
        $dnes = new DateTime();
        return $dnes->diff($narozeni)->y;
    }

    // Magická metoda (určuje jak se objekt zobrazí)
    public function __toString(): string {
        return "$this->jmeno, $this->prijmeni, tel: $this->telefon, věk: $this->datum_narozeni";
    }
}




