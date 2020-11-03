<?php
session_start();
session_regenerate_id();

if (isset($_GET['tyhjenna'])) {
    $_SESSION['kori'] = null;
}

if (!isset($_SESSION['kori'])) {
    $_SESSION['kori'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tuotteet = $_SESSION['kori'];
    $tuote = filter_input(INPUT_POST, 'tuote', FILTER_SANITIZE_NUMBER_INT);
    array_push($tuotteet, $tuote);
    $_SESSION['kori'] = $tuotteet;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    try {
    } catch (Exception $ex) {
        print "<p>Häiriö verkkokaupassa!</p>";
    }
    ?>
    <h3>Ostoskori</h3>
    <?php 
    print "<p>Ostoskorissa on " . count($_SESSION['kori']) . " tuotetta</p>";
    $tuotteet = $_SESSION['kori'];
    $summa = 0;
    foreach ($tuotteet as $tuote_id) {
        $sql = "select * from tuote where id = $tuote_id";
        $kysely = $tietokanta->query($sql);
        $tuote = $kysely->fecth();
        $summa += $tuote['hinta'];
        print $tuote['nimi'] . ' ' . $tuote['hinta'] . '<br />';
    }
    print "<p>Yhteensä: $summa</p>";
    ?>
    <a href="<?php print($_SERVER['PHP_SELF']);?>?tyhjenna=true">Tyhjennä</a>
    <?php
    try {
        $tietokanta = new PDO('mysql:host=localhost;dbname=verkkokauppa;charset=utf8','root','');
        $tietokanta->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql = "select * from tuote";
        $kysely = $tietokanta->query($sql);
        while ($tietue = $kysely->fetch()) {
            print "<div>";
            print "<form method='post' action='" . $_SERVER['PHP_SELF'] ."'>";
            print "<input type='hidden' name='tuote' value='" . $tietue['nimi'] . "'>";
            print "<p>" . $tietue['nimi'] . "</p>";
            print "<p>" . $tietue['hinta'] . "</p>";
            print "<button>Osta</button>";
            print "</form>";
            print "</div>";
        }

    }
    catch (PDOException $pdoex) {
        print "<p>Häiriö verkkokaupassa!</p>";
    }
    ?>
    <!-- <div>
    <form action="<?php //print($_SERVER['PHP_SELF']);?>" method="post">
    <p>Lakki 5 euroa</p>
    <input type="hidden" name="tuote" value="Lakki 5 euroa">
    <button>Osta</button>
    </form>
    </div>

    <div>
    <form action="<?php //print($_SERVER['PHP_SELF']);?>" method="post">
    <p>Takki 50 euroa</p>
    <input type="hidden" name="tuote" value="Takki 50 euroa">
    <button>Osta</button>
    </form>
    </div> -->



</body>
</html>