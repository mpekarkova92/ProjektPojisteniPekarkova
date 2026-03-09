# Evidence pojištěných 

Projekt byl vytvořen v rámci kurzu ITnetwork zaměřeného na základy PHP a MVC 
architektury. Slouží k evidenci pojištěných osob s možností přidávávní, úprav
a mazání záznamů.

## Funkce aplikace
- přidání pojištěné osoby
- úprava existujícího záznamu
- smazání pojištěné osoby
- zobrazení seznamu pojištěných 
- automatický výpočet věku z data narození (PHP + JavaScript)
- validace vstupních dat
- ochrana proti XSS a CSRF ochrana

## Použité technologie 
- PHP 8
- MySQL
- HTML
- CSS (Flexbox)
- JavaScript
- PDO
- MVC architektura

## Vzhled aplikace
Projekt je rozdělen podle principů MVC:
- **Model** - datové modely (Pojisteny)
- **Kontroler** - aplikační logika a práce s datábazí
- **Pohled** - formuláře a výpisy dat

## Struktura složek
- index.php - hlavní vstupní bod aplikace
- modely - datové modely
- kontrolery - kontrolery aplikace
- pohledy - formuláře a seznam pojištěných
- konfigurace - připojení k databázi 
- style.css - stylování aplikace
- README.md - dokumentace projektu
 
## Databáze 
Aplikace používá databázi MySQL.

Název databaze: pojisteni
Tabulka: pojisteni

Sloupce 
- id
- jmeno
- prijmeni
- predvolba
- telefon
-datum_narozeni

## Spuštění projektu 
1. Projekt je určen ke spuštění na lokálním serveru (např. XAMPP).
2. Databázi je nutné vytvořit v MySQL.
3. Přihlašovací údaje k databázi jsou v souboru: 
   `konfigurace/Databaze.php`.
4. Hlavní soubor aplikace je `index.php`. 

## Autor 
Markéta Pekárková
Projekt ke kurzu PHP
2026

## Licence


