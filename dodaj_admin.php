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
                if (isset($_GET['user']) || ($_GET['passwd']) || ($_GET['ime']) || ($_GET['email'])) {
// forma submitovana
// proveri zahtevane vrednosti
                    if (empty($_GET['user'])) {
                        die("GRESKA: Unesite username!");
                    }
                    if (empty($_GET['ime'])) {
                        die("GRESKA: Unesite ime!");
                    }
                    if (empty($_GET['passwd'])) {
                        die("GRESKA: Sifru!");
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
                        $upit = "INSERT INTO korisnici(username,password, ime,email,id_korisnika)
                            VALUES ('" . $_GET['user'] . "',SHA1('" . $_GET['passwd'] . "'), '" . $_GET['ime'] . "',
                                '" . $_GET['email'] . "','" . $_GET['nesto'] . "')";
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


                    echo "
            <div style='text-align: center;'>
                <form method='get' action=" . $_SERVER[PHP_SELF] . ">";
                ?>
                    Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='text' name='user' > <br><br>
                    Ime i prezime:&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='ime' > <br><br>
                    Lozinka:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='password' name='passwd' > <br><br>
                    Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='text' name='email' > <br><br>


                <?php
                    $dbh = new PDO($konekcioni_string, $korisnik, $sifra);

                    // $dbh->query() vraca PDOStatement objekat
                    $upit = "SELECT * FROM tip_korisnika";
                    $pdo_izraz = $dbh->query($upit);
                    // Svi podaci se vracaju u obliku niza asocijativnih nizova
                    $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                    $niz1 = count($niz);

                    echo" Vrsta korisnika:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name='nesto'>";
                    foreach ($niz as $dom) {
                        echo"<option value='" . $dom[id] . "'>$dom[vrsta]</option>";
                    }
                    echo"  </select><br/><br/>";
                    echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='submit' onclick='dodaj()'  value='Dodaj' >
                </form>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

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