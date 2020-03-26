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

    $sql = "SELECT sum(ilosc) FROM transakcje where $_SESSION[user_id]=ID_To;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            foreach ($row as $field => $value) {
                if($value==0) $_SESSION["ilosc"] = $value. " zł";
                else $_SESSION["ilosc"] = "0 zł";
            }
        }
    }
    else $_SESSION["ilosc"] = "0 zł";
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
                    <a class="navbar-brand" style="color:whitesmoke" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" style="color:whitesmoke" href="#">Przelewy </a>
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

                <div class="row" style="margin-top:20px; margin-left:5px">
                    <h1> <span class="badge badge-warning" style="color:white">Twój Panel</span></h1>

                </div>
                <div style="margin-left:5px">
                    <a class="badge badge-primary" style="color:white">#pieniadze</a>
                    <a class="badge badge-success" style="color:white">#konto</a>
                    <a class="badge badge-danger" style="color:white">#bank</a>
                    <a class="badge badge-info" style="color:white">#kredyt</a>
                    <a class="badge badge-dark" style="color:white">#wsbank</a>
                </div>

                <div class="row" style="margin-top:20px">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Stan konta</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $_SESSION["srodki"]; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning    text-uppercase mb-1">Wpływy (ten miesiąc)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $_SESSION["ilosc"]; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Wydatki (ten miesiąc)</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">?</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-primary"></i> Direct
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> Social
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-info"></i> Referral
                                    </span>
                                </div>
                            </div>
                        </div>
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