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
                if (isset($_GET['user']) || ($_GET['ime']) || ($_GET['email']) || ($_GET['vrsta'])) {
// forma submitovana
// proveri zahtevane vrednosti
                    if (empty($_GET['user'])) {
                        die("GRESKA: Unesite username!");
                    }
                    if (empty($_GET['ime'])) {
                        die("GRESKA: Unesite ime!");
                    }
                    if (empty($_GET['email'])) {
                        die("GRESKA: Unesite email!");
                    }

                    $ime_hosta = "localhost";
                    $korisnik = "root";
                    $sifra = "radovanovic";
                    $ime_baze = "imenik";

                    try {
                        $konekcioni_string = "mysql:host=$ime_hosta;dbname=$ime_baze";
                        $dbh = new PDO($konekcioni_string, $korisnik, $sifra);
// Upit trazi kombinaciju imena i sha1() checksume lozinke
                        $upit = "UPDATE korisnici  SET username = '" . $_GET['user'] . "'
                           ,ime = '" . $_GET['ime'] . "', id_korisnika = '" . $_GET['id_name'] . "',
                            email = '" . $_GET['email'] . "',id_korisnika = '" . $_GET['nesto'] . "'
                WHERE id='" . $_GET['id'] . "' ";
                        $pdo_izraz = $dbh->query($upit);
                        $dbh = null;
                    } catch (PDOException $e) {
                        echo "GRESKA: ";
                        echo $e->getMessage();
                    }
                ?>
                    <script type="text/javascript">window.location='administracija.php'</script>
                <?php
                } else {

                    session_start();
                    $dbh = new PDO($konekcioni_string, $korisnik, $sifra);

                    // $dbh->query() vraca PDOStatement objekat
                    $upit = "SELECT * FROM korisnici, tip_korisnika
                        WHERE korisnici.id='" . $_GET['id'] . "' AND korisnici.id_korisnika = tip_korisnika.id";
                    $pdo_izraz = $dbh->query($upit);
                    // Svi podaci se vracaju u obliku niza asocijativnih nizova
                    $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                    foreach ($niz as $dom) {

                        echo "
            <div  style='text-align: center;'>
                <form method='get' action=" . $_SERVER[PHP_SELF] . ">
                <input type='hidden' name='id' value='" . $_GET['id'] . "' />";
                ?>
                        Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='user' value="<?php echo $dom['username'] ?>"> <br><br>
                        Ime i prezime:&nbsp;&nbsp;
                        <input type='text' name='ime' value="<?php echo $dom['ime'] ?>"> <br><br>
                        Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='text' name='email' value="<?php echo $dom['email'] ?>"> <br><br>

<?php
                    }

                    $dbh = new PDO($konekcioni_string, $korisnik, $sifra);

                    // $dbh->query() vraca PDOStatement objekat
                    $upit = "SELECT * FROM tip_korisnika";
                    $pdo_izraz = $dbh->query($upit);
                    // Svi podaci se vracaju u obliku niza asocijativnih nizova
                    $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                    $niz1 = count($niz);

                    echo" Vrsta korisnika:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name='nesto' >";
                    foreach ($niz as $dom) {
                        echo"<option value='" . $dom[id] . "'>$dom[vrsta]</option>";
                    }
                    echo"  </select><br/><br/>";
                    echo"

                  <input type='submit'  value='Izmeni' >
                </form>

                <a href='administracija.php'>Nazad</a>

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