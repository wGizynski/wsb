<?php
session_start();
if (isset($_SESSION['user_id'])) {
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "WSBank";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT sum(ilosc) FROM transakcje where $_SESSION[user_id]=ID_To and MONTH(data) = MONTH(CURRENT_DATE())
    AND YEAR(data) = YEAR(CURRENT_DATE());";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            foreach ($row as $field => $value) {
                if ($value != "") $_SESSION["wplywy"] = $value;
                else $_SESSION["wplywy"] = 0;
            }
        }
    } else $_SESSION["wplywy"] = "0 zł";

    $logged_user = $_SESSION['user_id'];
    $sql2 = "SELECT sum(ilosc) FROM transakcje where $_SESSION[user_id]=ID_From and MONTH(data) = MONTH(CURRENT_DATE())
    AND YEAR(data) = YEAR(CURRENT_DATE());";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_row($result2)) {
            foreach ($row as $field => $value) {
                if ($value != "") $_SESSION["wyplywy"] = $value;
                else $_SESSION["wyplywy"] = 0;
            }
        }
    } else $_SESSION["wyplywy"] = "0 zł";
    $user_id_err = "";
    $adress_err = "";
    $data_err = "";
    $amount_err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if username is empty
        if (empty(trim($_POST["user_id"]))) {
            $user_id_err = "Proszę wprowadzić nazwę użytkownika.";
        } else if ($_POST["user_id"] == $_SESSION['user_id']) {
            $user_id_err = "Nie można utworzyć przelewu na własny rachunek";
        } else {
            $user_id = $_POST["user_id"];
        }

        // Check if password is empty
        if (empty(trim($_POST["adress"]))) {
            $adress_err = "Proszę wprowadzić adres.";
        } else {
            $adress = $_POST["adress"];
        }

        if (empty(trim($_POST["data"]))) {
            $data_err = "Proszę wprowadzić date.";
        } else {
            $rawdate = htmlentities($_POST['data']);
            $data = date("Y-m-d", strtotime($rawdate));
        }

        if (empty(trim($_POST["amount"]))) {
            $amount_err = "Proszę wprowadzić kwote.";
        } else if ($_POST["amount"] > $_SESSION['srodki']) {
            $amount_err = "Nie masz takich środków.";
        } else {
            $amount = $_POST["amount"];
        }

 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($user_id_err) && empty($adress_err) && empty($data_err) && empty($amount_err)) {
                $sql3 = "Insert into transakcje (ID_from, ID_TO, DATA, ilosc) values ($logged_user, $user_id, '$data', $amount)  ";
                $wybik = mysqli_query($conn, $sql3);
                $sql4 = "update users set srodki=(srodki-$amount) where user_id = $logged_user";
                $wybik2 = mysqli_query($conn, $sql4);
                $sql5 = "update users set srodki=(srodki+$amount) where user_id = $user_id";
                $wybik3 = mysqli_query($conn, $sql5);
                $_SESSION["srodki"] = ($_SESSION["srodki"] - $amount);
                header("location: dashboard.php");
            }
        } 
    }
    ?>

    <header></header>
    <section id="content">
        <section id="top">
            <section id="top_left"> </section>
            <section id="top_middle"> <a href="index.php"> <img src="imgs/banner2.jpg"></a> </section>
            <section id="top_right"> </section>
        </section>

        <section id="mid">
            <section id="mid_left"> </section>
            <section id="middle">

                <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c00000; border-radius: 3px;">
                    <a class="navbar-brand" style="color:whitesmoke" href="dashboard.php">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" style="color:whitesmoke" href="przelewy.php">Przelewy </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color:whitesmoke" href="#">Doładowania</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color:whitesmoke" href="#">Pomoc i kontakt</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color:whitesmoke" href="history.php">Historia</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="logout.php" class="nav-link" style="color:whitesmoke"> wyloguj sie</a></li>
                        </ul>
                    </div>
                </nav>

                <div class="container login-container" style="float: left; width: 100%; max-width: 1270px;">
                    <div class="col-md-6 login-form-1" style="max-width: 100%;">
                        <h3>Przelew</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div style="width:50%; margin-left:auto; margin-right:auto">

                                <div class="form-group <?php echo (!empty($user_id_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="user_id" class="form-control" placeholder="Id odbiorcy *">
                                    <span class="help-block"><?php echo $user_id_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($adress_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="adress" class="form-control" placeholder="Adres *">
                                    <span class="help-block"><?php echo $adress_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="amount" class="form-control" placeholder="Kwota *">
                                    <?php echo $amount_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($data_err)) ? 'has-error' : ''; ?>">
                                    <input type="date" name="data" class="form-control">
                                    <?php echo $data_err; ?></span>
                                </div>

                                <input type="submit" class="btnSubmit" value="Wykonaj">
                            </div>
                        </form>
                    </div>
                </div>

            </section>
            <section id="mid_right"> </section>
            <section id="footer">
                <section id="footer_left"> </section>
                <section id="footer_middle">
                    <p> 2020 © Wielski Super Bank S.A.
                        Wielski Super Bank S.A. z siedzibą w Warszawie, przy al. Jana Pawła II 17, 00-854 Warszawa,
                        zarejestrowana w Sądzie Rejonowym dla m. st. Warszawy w Warszawie, XII Wydział Gospodarczy Krajowego
                        Rejestru Sądowego pod nr KRS 0000008723. NIP 896-000-56-73. REGON 930041341. Wysokość kapitału zakładowego 1
                        020 883 050 zł. Wysokość kapitału wpłaconego 1 020 883 050 zł.
                        Opłata za połączenie z infolinią banku zgodna z taryfą danego operatora. Słowniczek pojęć i definicji
                        dotyczących usług reprezentatywnych, wynikających z rozporządzenia Ministra Rozwoju i Finansów z dnia 14
                        lipca 2017 r. w sprawie wykazu usług reprezentatywnych powiązanych z rachunkiem płatniczym, dostępny jest na
                        stronie santander.pl/PAD oraz w placówkach banku.
                        Santander Bank Polska (dawniej BZ WBK) oferuje m.in.: rachunki płatnicze: konta osobiste (w tym konto dla
                        młodych), konta walutowe, konta oszczędnościowe oraz lokaty terminowe, kredyty gotówkowe, kredyty
                        hipoteczne, karty debetowe, karty kredytowe, a także fundusze inwestycyjne i ubezpieczenia. W ofercie dla
                        firm znajdą Państwo m.in.: konta firmowe, kredyty na bieżącą działalność, kredyty inwestycyjne oraz usługi
                        faktoringu i leasingu.
                    </p>
                    <p>

                        Regulamin serwisu
                        Polityka prywatności
                        Polityka przetwarzania danych osobowych
                        Pliki cookie
                        Kod SWIFT: WSBPPLPP</p>

                </section>
                <section id="footer_right"> </section>
            </section>
        </section>
    </section>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>