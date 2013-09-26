<?php session_start(); ?>
<?php if (isset($_SESSION['autorizovan'])) { ?>
    <html>
        <head>
            <title>Telefonski imenik</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

            <script type="text/javascript" src="pack.js"></script>
            <script type="text/javascript" src="pop.js">

            </script>

            <script>
                function izmeni(id_korisnik) {
                    window.location = "izmena_admin.php?id="+id_korisnik;
                }
                function brisi(id_korisnik) {
                    var odgovor=confirm("Brisanje korisnika sistema: Da li ste sigurni?");
                    if (odgovor)
                        window.location = "brisi_admin.php?id="+id_korisnik;
                }
            </script>


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
                <h1>Administracija</h1>
                <hr><br/><br/><br/>
                <?php
                $dbh = new PDO($konekcioni_string, $korisnik, $sifra);

                // $dbh->query() vraca PDOStatement objekat
                $pdo_izraz = $dbh->query(admin());
                // Svi podaci se vracaju u obliku niza asocijativnih nizova
                $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                if ($_SESSION['admin'] == 1) {
                    echo"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <a href='dodaj_admin.php'><img src='images/add.jpeg' style='width:4%' align='middle'>&nbspDodaj novog korisnika</a>";
                }
                echo" <table id='rounded-corner' >
     <thead>
    	<tr>
        	<th scope='col' class='rounded-company'>Username</th>
            <th scope='col' class='rounded-q1'>Ime i prezime</th>
            <th scope='col' class='rounded-q2'>Email</th>
            <th scope='col' class='rounded-q3'>Vrsta korisnika</th>";
                if ($_SESSION['admin'] == 1) {
                    echo"<th scope='col' class='rounded-q4'>Opcije</th>";
                }
                echo"

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan='5' class='rounded-foot-left'><em>Spisak svih korisnika</em></td>
        	
        </tr>
    </tfoot>";
                foreach ($niz as $dom) {
                    echo"<tbody>
    	<tr>
        	<td>" . $dom['username'] . "</td>
            <td>" . $dom['ime'] . "</td>
            <td>" . $dom['email'] . "</td>
            <td>" . $dom['vrsta'] . "</td>";
                    if ($_SESSION['admin'] == 1) {
                        echo"     <td><a href='izmena_admin.php?id=" . $dom['id'] . " ' >Izmeni</a>
                        &nbsp&nbsp&nbsp
                         <a href='#' onclick='brisi(" . $dom['id'] . ")'>Brisanje</a>
</td>";
                    }
                    echo"
                    
           </tr>       
    </tbody>";
                }
                echo"</table>";
                ?>

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

