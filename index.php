<?php

if (isset($_POST['korisnik']) || isset($_POST['lozinka'])) {
// forma submitovana
// proveri zahtevane vrednosti
    if (empty($_POST['korisnik'])) {
        die("GRESKA: Unesite ime!");
    }
    if (empty($_POST['lozinka'])) {
        die("GRESKA: Unesite lozinku!");
    }
    $ime_hosta = "localhost";
    $korisnik = "root";
    $sifra = "radovanovic";
    $ime_baze = "imenik";
    try {
        $konekcioni_string = "mysql:host=$ime_hosta;dbname=$ime_baze";
        $dbh = new PDO($konekcioni_string, $korisnik, $sifra);
// Upit trazi kombinaciju imena i sha1() checksume lozinke
        $upit = "SELECT * FROM korisnici WHERE username = '" . $_POST['korisnik'] . "'
AND password = SHA1('" . $_POST['lozinka'] . "')";
        $pdo_izraz = $dbh->query($upit);
        $dbh = null;
    } catch (PDOException $e) {
        echo "GRESKA: ";
        echo $e->getMessage();
    }
// da li je bilo sta vraceno?
    if ($pdo_izraz->rowCount() == 1) {
// ako je vracena jedna vrsta
// autorizacija je uspesna
// kreiraj sesiju i setuj cookie username sa rokom trajanja 30 dana
        session_start();
        $_SESSION['autorizovan'] = 1;
        $temp = $pdo_izraz->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $temp['id'];

        if ($temp['id_korisnika'] == "1") {
            $_SESSION['admin'] = 1;
        } else {
            $_SESSION['admin'] = 2;
        }

        setcookie("username", $_POST['korisnik'], time() + (84600 * 30));
?>

        <script type="text/javascript">window.location='pocetna.php'</script>

<?php

    } else {
// nema rezultata upita, autorizacija neuspela
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title>Telefonski imenik</title>

        <link href='css/login-box.css' rel='stylesheet' type='text/css' />
    </head>

    <body>
        <div style='padding: 100px 0 0 250px;'>
            <div id='login-box'>
                <h2>Telefonski imenik</h2>
                Greska: Unesite ispravne vase login podatke!
                <br />
                <br />
               <form method='POST' action=" . $_SERVER[PHP_SELF] . ">
                    <div id='login-box-name' style='margin-top:20px;'>Username:</div><div id='login-box-field' style='margin-top:20px;'><input name='korisnik' class='form-login' title='korisnik' value='" . $_COOKIE['korisnik'] . "' size='30' maxlength='2048' /></div>
<div id='login-box-name'>Šifra:</div><div id='login-box-field'><input name='lozinka' type='password' class='form-login' title='lozinka' value='" . $_COOKIE['lozinka'] . "' size='30' maxlength='2048' /></div>
<br />

<br />
<br />
<input background:url('images/login-btn.png') no-repeat; border: none; width='103' height='42' style='margin-left:90px;'  type='submit' value='Pošalji'>


</div>
</div>
</body>
</html>";
    }
} else {

    session_start();



    echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title>Telefonski imenik</title>

        <link href='css/login-box.css' rel='stylesheet' type='text/css' />
    </head>

    <body>
        <div style='padding: 100px 0 0 250px;'>
            <div id='login-box'>
                <h2>Telefonski imenik</h2>
                <br />
                <br />
               <form method='POST' action=" . $_SERVER['PHP_SELF'] . ">
                    <div id='login-box-name' style='margin-top:20px;'>Username:</div><div id='login-box-field' style='margin-top:20px;'><input name='korisnik' class='form-login' title='korisnik' value='" . $_COOKIE['korisnik'] . "' size='30' maxlength='2048' /></div>
<div id='login-box-name'>Šifra:</div><div id='login-box-field'><input name='lozinka' type='password' class='form-login' title='lozinka' value='" . $_COOKIE['lozinka'] . "' size='30' maxlength='2048' /></div>
<br />

<br />
<br />
<input background:url('images/login-btn.png') no-repeat; border: none; width='103' height='42' style='margin-left:90px;'  type='submit' value='Pošalji'>


</div>
</div>
</body>
</html>";
}
?>