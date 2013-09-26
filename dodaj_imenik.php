<?php session_start(); ?>

<html>
    <head>
        <title>Telefonski imenik</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

    </head>
    <body>

        <div id="okvir">

            <div id="vrh"> </div>

            <div id="pocetak">
                <?php
                include 'business/upiti.php';
                include 'konekcija.php';
                $dbh = new PDO($konekcioni_string, $korisnik, $sifra);
                $upit = ("Select * from korisnici where id=" . $_SESSION['id']);

                $izraz = $dbh->query($upit);
                $obj = $izraz->fetch(PDO::FETCH_ASSOC);
                $ime = $obj['username'];
                echo "<p id='bbb'><b >$ime</b>:dobrodosli</p>";
                ?>
                <a id="log" href="logout.php">LOGOUT</a>
            </div>


            <div id="meni" id="nav">
                <ul>
                   <li><a href="pocetna.php">Početna</a></li>
                    <li><a href="imenik.php">Imenik</a
                    <li><a href="administracija.php">Administracija</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                </ul>
            </div>

            <div id="sadrzaj" >

                <?php
                if (isset($_GET['ime_prezime']) || ($_GET['ulica']) || ($_GET['mesto']) || ($_GET['telefon'])) {
// forma submitovana
// proveri zahtevane vrednosti
                    if (empty($_GET['ime_prezime'])) {
                        die("GRESKA: Unesite ime i prezime!");
                    }
                    if (empty($_GET['ulica'])) {
                        die("GRESKA: Unesite ulicu i broj!");
                    }
                    if (empty($_GET['mesto'])) {
                        die("GRESKA: Unesite mesto!");
                    }
                    if (empty($_GET['telefon'])) {
                        die("GRESKA: Unesite telefon!");
                    }


                    $ime_hosta = "localhost";
                    $korisnik = "root";
                    $sifra = "radovanovic";
                    $ime_baze = "imenik";

                    try {
                        $konekcioni_string = "mysql:host=$ime_hosta;dbname=$ime_baze";
                        $dbh = new PDO($konekcioni_string, $korisnik, $sifra);
// Upit trazi kombinaciju imena i sha1() checksume lozinke
                        $upit = "INSERT INTO imenik(ime_prezime,ulica, mesto,telefon)
                            VALUES ('" . $_GET['ime_prezime'] . "','" . $_GET['ulica'] . "', '" . $_GET['mesto'] . "',
                                '" . $_GET['telefon'] . "')";
                        $pdo_izraz = $dbh->query($upit);
                        $dbh = null;
                    } catch (PDOException $e) {
                        echo "GRESKA: ";
                        echo $e->getMessage();
                    }
                ?>
                    <script type="text/javascript">window.location='imenik.php'</script>
                <?php
                } else {

                    session_start();


                    echo "
            <div style='text-align: center;'>
                <form method='get' action=" . $_SERVER[PHP_SELF] . ">";
                ?>
                    Ime i prezime:&nbsp;&nbsp;
                    <input type='text' name='ime_prezime' > <br><br>
                    Ulica i broj:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='ulica' > <br><br>
                    Mesto: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='text' name='mesto' > <br><br>
                    Telefon:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='text' name='telefon' > <br><br>


                <?php
                   
                    echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='submit' onclick='dodaj()'  value='Dodaj' >
                </form>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <a href='imenik.php'>Nazad</a>

        </div>";
                }
                ?>

            </div>

            <div id="kraj">
                Vladimir Radovanović
            </div>

            <div id="ppp"> </div>

        </div>

    </body>
</html>