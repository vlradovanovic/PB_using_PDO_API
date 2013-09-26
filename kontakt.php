<?php session_start(); ?>
<?php if (isset($_SESSION['autorizovan'])) { ?>
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
                <h1>Info</h1>
                <hr><br/><br/><br/>

                <div align="center">

                    Web aplikacija predstavlja seminarski rad<br/>
                    Student: Vladimir Radovanovic<br/>
                    email: <a href="mailto:vl.radovanovic@gmail.com">vl.radovanovic@gmail.com</a><br/>
                    </div>
            </div>

            <div id="kraj">
                Vladimir Radovanović
            </div>

            <div id="ppp"> </div>

        </div>

    </body>
</html>

<?php
            } else {
?>
                <script type="text/javascript">window.location='index.php'</script>
<?php
            }
?>


