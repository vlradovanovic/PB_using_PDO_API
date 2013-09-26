<?php session_start(); ?>

<html>
    <head>
        <title>Telefonski imenik</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />


        }
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
                        $upit = "UPDATE imenik  SET ime_prezime = '" . $_GET['ime_prezime'] . "'
                           ,ulica = '" . $_GET['ulica'] . "', mesto = '" . $_GET['mesto'] . "',telefon = '" . $_GET['telefon'] . "'
                WHERE id='" . $_GET['id'] . "' ";
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
                    $dbh = new PDO($konekcioni_string, $korisnik, $sifra);

                    // $dbh->query() vraca PDOStatement objekat
                    $upit = "SELECT * FROM imenik
                        WHERE imenik.id='" . $_GET['id'] . "'";
                    $pdo_izraz = $dbh->query($upit);
                    // Svi podaci se vracaju u obliku niza asocijativnih nizova
                    $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                    foreach ($niz as $dom) {

                        echo "
            <div  style='text-align: center;'>
                <form method='get' action=" . $_SERVER[PHP_SELF] . ">
                <input type='hidden' name='id' value='" . $_GET['id'] . "' />";
                ?>
                        Ime i prezime:&nbsp;&nbsp;<input type='text' name='ime_prezime' value="<?php echo $dom['ime_prezime'] ?>"> <br><br>
                        Ulica i broj:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='text' name='ulica' value="<?php echo $dom['ulica'] ?>"> <br><br>
                        Mesto:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='text' name='mesto' value="<?php echo $dom['mesto'] ?>"> <br><br>
                        Telefon:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='text' name='telefon' value="<?php echo $dom['telefon'] ?>"> <br><br>

<?php
                    }

                    
                    echo"

                  <input type='submit'  value='Izmeni' >
                </form>

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