<?php
// Parametri konekcije
        $ime_hosta = "localhost";
        $korisnik = "root";
        $sifra = "radovanovic";
        $ime_baze = "imenik";
// try-catch blok u kome se otvara konekcija na bazu i vrsi upit
        try {
            $konekcioni_string = "mysql:host=$ime_hosta;dbname=$ime_baze";
    }
    catch(PDOException $e) {
        echo "GRESKA: ";
        echo $e->POSTMessage();
    }
$dbh = null;

?>

