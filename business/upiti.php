<?php

function admin(){
    $sql = "SELECT username,ime, email, korisnici.id, tip_korisnika.vrsta FROM korisnici, tip_korisnika
       WHERE korisnici.id_korisnika = tip_korisnika.id";

    return $sql;
}

function imenik(){
    $sql = "SELECT id, ime_prezime, ulica, mesto, telefon FROM imenik";

    return $sql;
}

function studenti(){
    $sql = "SELECT ime_prezime, fakultet, broj_indeksa,	adresa_stanovanja
            ,bon_dorucak,bon_rucak,bon_vecera FROM studenti_menza";
    return $sql;

    function login(){
         

         return $upit;
    }

    function log(){
        $sql = "Select * from korisnici";
        return;
    }
}
    
?>
