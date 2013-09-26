<?php
  $ime_hosta = "localhost";
                    $korisnik = "root";
                    $sifra = "radovanovic";
                    $ime_baze = "imenik";

                    try {
                        $konekcioni_string = "mysql:host=$ime_hosta;dbname=$ime_baze";
                        $dbh = new PDO($konekcioni_string, $korisnik, $sifra);
// Upit trazi kombinaciju imena i sha1() checksume lozinke
                        $upit = "DELETE FROM imenik WHERE id='".$_GET["id"]."' ";
                        $pdo_izraz = $dbh->query($upit);
                        $dbh = null;
                    } catch (PDOException $e) {
                        echo "GRESKA: ";
                        echo $e->getMessage();
                    }?>
                    <script type="text/javascript">window.location='imenik.php'</script>


